<?php
/**
 * cron_activation_today.php — slim, frequent refresh of TODAY's activation rows.
 *
 * The nightly crons/cron_activation.php recomputes a full day (24 hours × ~90 SPs)
 * and is meant for finalizing PAST dates. This job keeps *today* current cheaply so
 * admin/activationreport.php can read today straight from the pre-aggregated
 * gamebardb_vodafone_qatar_report.activation_report table instead of firing ~58
 * stored procedures live on every page load.
 *
 * Design:
 *   - Refreshes only the hour buckets that can still change (current hour → 24).
 *     Elapsed hours of today are already final from earlier runs, so we skip them.
 *   - UPSERTs each (date, hour) row (INSERT ... ON DUPLICATE KEY UPDATE) instead of
 *     the nightly job's DELETE-whole-day + INSERT, so the report never reads a
 *     half-wiped day mid-refresh. REQUIRES a UNIQUE index on activation_report(date, hour).
 *   - A lock file prevents overlapping runs when the scheduler fires every ~10 min.
 *
 * Schedule (every ~10 min, well within the accepted 5–15 min freshness budget):
 *   php crons/cron_activation_today.php
 * Optional: ?date=YYYY-MM-DD to backfill a specific date (full 24h when not today).
 */

ini_set('max_execution_time', 100000000);
ini_set('mysql.connect_timeout', 100000000);
ini_set('default_socket_timeout', 100000000);

require_once __DIR__ . '/../admin/includes/config.php';

// Same server the nightly cron writes to (and the report reads via DB_HOST in prod).
$con1 = mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_connect_error());

date_default_timezone_set("Asia/Calcutta");

// ── Target date ───────────────────────────────────────────────────────────────
$raw   = trim($_GET['date'] ?? '');
$date1 = ($raw && preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) ? $raw : date('Y-m-d');
if ($date1 > date('Y-m-d')) { exit; } // never run for the future

$start_date = $date1 . ' 00:00:00';
$end_date   = $date1 . ' 23:59:59';
$is_today   = ($date1 === date('Y-m-d'));

// Only the current hour and later can still change; past hours are final. For a
// past date (backfill) do the full day. Start one bucket early to absorb late data.
$start_hour = $is_today ? max(1, (int)date('G')) : 1;

// ── Logging ───────────────────────────────────────────────────────────────────
$log_dir  = __DIR__ . '/logs';
if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
$log_file = $log_dir . '/cron_activation_today_' . date('Y-m-d') . '.log';
function tlog(string $msg): void {
    global $log_file;
    file_put_contents($log_file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

// ── Overlap guard ─────────────────────────────────────────────────────────────
$lock_path = $log_dir . '/cron_activation_today.lock';
$lock_fp   = fopen($lock_path, 'c');
if (!$lock_fp || !flock($lock_fp, LOCK_EX | LOCK_NB)) {
    tlog("SKIP — previous run still in progress");
    exit;
}

tlog("START — date={$date1} hours={$start_hour}..24");

// ── Column → list of SPs to sum (mirrors crons/cron_activation.php:78-218) ─────
// Keys are exactly the activation_report column names.
$sp_map = [
    'gamebar_france'      => ['fashionbardb_france.get_activation'],
    'gamebar_southafrica' => ['fashionbardb_za.get_activation', 'gamebar_zamobixone.get_activation'],
    'gamebar_myanmar'     => ['fashionbardb_myanmartelenor.get_activation'],
    'gamebar_paydashgr'   => ['fashionbardb_greece.get_activation'],
    'Glambar_southafrica' => ['fashionbardb_zaglam.get_activation', 'glambar_zamobixone.get_activation'],
    'Glambar_paydashgr'   => ['fashionbardb_greeceglambar.get_activation'],
    'gamebar_kuwait'      => ['fashionbardb_slakwzain.get_activation', 'fashionbardb_slakwstc.get_activation'],
    'gamebar_bahrain'     => ['fashionbardb_bh.get_activation'],
    'gamebar_indoneisa'   => ['gamebardb_indonesia.get_activation', 'fashionbardb_idtelkomsel.get_activation'],
    'gamebar_oman'        => ['fashionbardb_omooredoo.get_activation'],
    'gamebar_pk'          => ['fashionbardb_pkzong.get_activation'],
    'gamebar_qatar'       => ['fashionbardb_qatarooredoo.get_activation'],
    'gamebar_uae'         => ['fashionbardb_etisalat.get_activation'],
    'glambar_pl'          => ['glambar_plteleaudio.getactivation'],
    'glambar_thailand'    => ['fashionbardb_glam9005thailand.get_activation'],
    'gamebar_thailand'    => ['fashionbardb_game9305thailand.get_activation'],
    'gamebar_ksa'         => ['fashionbardb_timwezain.get_activation'],
    'gamebar_norway'      => ['fashionbardb_norway.get_activation'],
    'gamebar_czech'       => ['fashionbardb_cz.get_activation'],
    'gamebar_egmon'       => ['gamebar_egypt.getactivation', 'gamebar_egypt_mondianew.getactivation'],
    'glambar_czech'       => ['fashionbardb_czglam.get_activation'],
    'gamebar_slovenia'    => ['gamebar_slovenia.get_activation'],
    'gamebar_ro'          => ['gamebar_ro.get_activation'],
    'gamebar_finland'     => ['fashionbardb_finland.get_activation'],
    'glambar_slovenia'    => ['glambar_slovenia.get_activation'],
    'gamebar_pl'          => ['fashionbardb_polandgame.get_activation'],
    'glambar_pldmc'       => ['fashionbardb_polandglam.get_activation'],
    'gamebar_turkey'      => ['fashionbardb_paygurutr.get_activation'],
    'gamebar_switzerland' => ['gamebar_ch_nth.get_activation'],
    'gamebar_iraq'        => ['gamebar_iqzain_qg.getactivation', 'gamebar_iqmw_api.getactivation'],
    'gamebar_Mozambique'  => ['fashionbardb_mz.get_activation'],
    'gamebar_kenya'       => ['fashionbardb_safaricom.get_activation'],
    'gamebar_jordan'      => ['fashionbardb_joorange.get_activation', 'fashionbardb_joumniah.get_activation', 'gamebar_jozain.getactivation'],
    'gamebar_bangladesh'  => ['gamebar_bdgrameen.getactivation', 'fashionbardb_bdgp.get_activation', 'gamebar_bdrobi.getactivation'],
    'gamebar_ghana'       => ['gamebar_ghairtel_mtech.getactivation'],
    'gamebar_Nigeria'     => ['gamebar_nigeria_MMT.getactivation', 'fashionbardb_ngmtn.get_activation'],
    'gamebar_gabon'       => ['fashionbardb_gabon.get_activation'],
    'gamebar_Palestine'   => ['fashionbardb_psjw.get_activation'],
    '11Players_nigeria'   => ['fashionbardb_ngmtn11.get_activation'],
    '11Players_bd'        => ['11players_bdrobi.getactivation', '11players_bdrobi_weekly.getactivation', '11players_bdrobi_monthly.getactivation'],
    '11Players_kenya'     => ['fashionbardb_safaricompkm.get_activation'],
    'contest_qatar'       => ['contestdb_qaoo.get_activation'],
    'gamebar_ethiopia'    => ['gamebar_ethopia.getactivation'],
    '11players_ethiopia'  => ['11players_ethopia.getactivation'],
    '11players_ghana'     => ['fashionbardb_ghmtn11.get_activation'],
    '11Players_KSA'       => ['fashionbardb_sa11.get_activation'],
    'contest_bh'          => ['contestdb_bh.get_activation'],
    'gamebar_lk'          => ['gamebar_lk_dig.getactivation'],
];

// Calls a stored procedure and returns its 'act' value (0 if SP missing or fails).
function call_proc(mysqli $con, string $sql): int {
    $result = $con->query($sql);
    $val = 0;
    if ($result) {
        while ($row = mysqli_fetch_array($result)) { $val = (int)($row['act'] ?? 0); }
        $result->close();
    }
    $con->next_result();
    return $val;
}

$columns = array_keys($sp_map);
// Column list is fixed, so build the UPSERT template once.
$col_parts = $update_parts = [];
foreach ($columns as $c) {
    $col_parts[]    = "`{$c}`";
    $update_parts[] = "`{$c}`=VALUES(`{$c}`)";
}
$col_sql    = '`date`,`hour`,' . implode(',', $col_parts);
$update_sql = implode(',', $update_parts);

$hours_done = 0;
for ($i = $start_hour; $i <= 24; $i++) {
    $vals = [];
    foreach ($sp_map as $col => $procs) {
        $sum = 0;
        foreach ($procs as $proc) {
            $sum += call_proc($con1, "call {$proc}('{$start_date}','{$end_date}',{$i})");
        }
        $vals[$col] = $sum;
    }

    $value_parts = [];
    foreach ($columns as $c) {
        $value_parts[] = "'" . (int)$vals[$c] . "'";
    }
    $value_sql = "'{$date1}','{$i}'," . implode(',', $value_parts);
    $sql = "INSERT INTO gamebardb_vodafone_qatar_report.activation_report ({$col_sql})"
         . " VALUES ({$value_sql})"
         . " ON DUPLICATE KEY UPDATE {$update_sql}";

    if (!mysqli_query($con1, $sql)) {
        tlog("UPSERT ERROR hour {$i}: " . mysqli_error($con1));
    } else {
        $hours_done++;
    }
}

tlog("DONE — date={$date1} hours_refreshed={$hours_done}");

flock($lock_fp, LOCK_UN);
fclose($lock_fp);
