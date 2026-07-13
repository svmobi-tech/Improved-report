<?php
ini_set('max_execution_time', 100000000);
ini_set('mysql.connect_timeout', 100000000);
ini_set('default_socket_timeout', 100000000);

require_once __DIR__ . '/../admin/includes/config.php';

$con2 = mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_connect_error());
$con1 = $con2;

date_default_timezone_set("Asia/Calcutta");

// Accept ?date=YYYY-MM-DD from URL; fallback to yesterday
$raw   = trim($_GET['date'] ?? '');
$date1 = ($raw && preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) ? $raw : date('Y-m-d', strtotime('-1 days'));

// Block future dates — cron cannot run for dates that haven't happened yet
if ($date1 > date('Y-m-d')) {
    if (php_sapi_name() !== 'cli') {
        echo "<!DOCTYPE html><html><head><title>Blocked</title>
        <style>body{font-family:monospace;background:#1a1f3c;color:#f87171;padding:40px;font-size:14px}</style></head><body>
        <p style='font-size:18px;color:#fbbf24;'>&#10007; Future date blocked</p>
        <p>Cannot run cron for <strong>{$date1}</strong> — this date is in the future.</p>
        <p style='color:#94a3b8;margin-top:20px'>Please select today or a past date.</p></body></html>";
    }
    exit;
}

$start_date = $date1 . ' 00:00:00';
$end_date   = $date1 . ' 23:59:59';
$activation = 0;

// ── Log file setup ────────────────────────────────────────────────────────────
$log_dir  = __DIR__ . '/logs';
if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
$log_file = $log_dir . '/cron_activation_' . date('Y-m-d') . '.log';

function clog(string $msg): void {
    global $log_file;
    file_put_contents($log_file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

clog("========== cron_activation START — report date: {$date1} ==========");

// Show progress in browser when triggered via URL
$is_web = (php_sapi_name() !== 'cli');
if ($is_web) {
    echo "<!DOCTYPE html><html><head><title>Cron Activation — {$date1}</title>
    <style>body{font-family:monospace;background:#1a1f3c;color:#a0f0a0;padding:20px;font-size:13px}
    .done{color:#6ee7b7}.err{color:#f87171}.head{color:#fbbf24;font-size:15px;font-weight:bold}</style></head><body>";
    echo "<p class='head'>&#9654; cron_activation &nbsp; report date: <u>{$date1}</u></p>";
    ob_flush(); flush();
}

// Run a stored procedure and return its 'act' value.
// Pass $activation by reference to count successful calls (omit to skip counting).
function call_proc(mysqli $con, string $sql, ?int &$activation = null): int {
    $result = $con->query($sql);
    $val = 0;
    if ($result) {
        if ($activation !== null) $activation++;
        while ($row = mysqli_fetch_array($result)) {
            $val = (int)$row['act'];
        }
        $result->close();
    }
    $con->next_result();
    return $val;
}

mysqli_query($con1, "DELETE FROM gamebardb_vodafone_qatar_report.`activation_report` WHERE `date`='{$date1}'");

for ($i = 1; $i <= 24; $i++) {

    $hvact=$oman=$malaysia=$saact=$sagact=$gindonesia=$ooredoo_qatar=$glambar_airtel=$gamebar_airtel=$gamebar_idea=$gamebar_voda=$glamour_idea=$glamour_voda=$gamerussia=$glamerussia=$gamebar_egypt=$gamebar_southafrica_intarget=$glambar_southafrica_intarget=$gamebar_italy=$dialog_srilanka=0;

    // ── France ────────────────────────────────────────────────────────────────
    $gamebar_france     = call_proc($con1, "call fashionbardb_france.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── Egypt ─────────────────────────────────────────────────────────────────
    $egmon1             = call_proc($con1, "call gamebar_egypt.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $egmon2             = call_proc($con1, "call gamebar_egypt_mondianew.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $egmon              = $egmon1 + $egmon2;

    // ── South Africa (Glambar) ────────────────────────────────────────────────
    $glambarsouthafrica1 = call_proc($con1, "call fashionbardb_zaglam.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glamzamobixone      = call_proc($con1, "call glambar_zamobixone.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambarsouthafrica  = $glambarsouthafrica1 + $glamzamobixone;

    // ── Europe ────────────────────────────────────────────────────────────────
    $gamebar_turkey     = call_proc($con1, "call fashionbardb_paygurutr.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_ro         = call_proc($con1, "call gamebar_ro.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_pl         = call_proc($con1, "call fashionbardb_polandgame.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambar_czech      = call_proc($con1, "call fashionbardb_czglam.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_slovenia   = call_proc($con1, "call gamebar_slovenia.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambar_slovenia   = call_proc($con1, "call glambar_slovenia.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── South Africa (Gamebar) ────────────────────────────────────────────────
    $sagact1            = call_proc($con1, "call fashionbardb_za.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebarzamobixone  = call_proc($con1, "call gamebar_zamobixone.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $sagact             = $sagact1 + $gamebarzamobixone;

    // ── Southeast Asia ────────────────────────────────────────────────────────
    $gamebar_myanmar    = call_proc($con1, "call fashionbardb_myanmartelenor.get_activation('{$start_date}','{$end_date}','{$i}')", $activation);
    $gamebar_thailand   = call_proc($con1, "call fashionbardb_game9305thailand.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambar_thailand   = call_proc($con1, "call fashionbardb_glam9005thailand.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── Middle East ───────────────────────────────────────────────────────────
    $gamebar_qatar_ooredoo  = call_proc($con1, "call fashionbardb_qatarooredoo.get_activation('{$start_date}','{$end_date}','{$i}')", $activation);
    $gamebar_qatar_vodafone = 0;
    $gamebar_qatar          = $gamebar_qatar_ooredoo + $gamebar_qatar_vodafone;

    $gamebar_paydashgr  = call_proc($con1, "call fashionbardb_greece.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambar_paydashgr  = call_proc($con1, "call fashionbardb_greeceglambar.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    $kuwaitzain         = call_proc($con1, "call fashionbardb_slakwzain.get_activation('{$start_date}','{$end_date}','{$i}')", $activation);
    $kuwaitstc          = call_proc($con1, "call fashionbardb_slakwstc.get_activation('{$start_date}','{$end_date}','{$i}')", $activation);
    $gamebar_kuwait     = $kuwaitzain + $kuwaitstc;

    $gamebar_bahrain    = call_proc($con1, "call fashionbardb_bh.get_activation('{$start_date}','{$end_date}',{$i})");
    $gamebar_oman       = call_proc($con1, "call fashionbardb_omooredoo.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_uae        = call_proc($con1, "call fashionbardb_etisalat.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_ksa        = call_proc($con1, "call fashionbardb_timwezain.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    $gamebar_iraq1      = call_proc($con1, "call gamebar_iqzain_qg.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_iraqmwapi  = call_proc($con1, "call gamebar_iqmw_api.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_iraq       = $gamebar_iraq1 + $gamebar_iraqmwapi;

    $gamebar_jordan1    = call_proc($con1, "call fashionbardb_joorange.get_activation('{$start_date}','{$end_date}',{$i})");
    $gamebar_jordanum   = call_proc($con1, "call fashionbardb_joumniah.get_activation('{$start_date}','{$end_date}',{$i})");
    $gamebar_zain       = call_proc($con1, "call gamebar_jozain.getactivation('{$start_date}','{$end_date}',{$i})");
    $gamebar_jordan     = $gamebar_jordan1 + $gamebar_jordanum + $gamebar_zain;

    $gamebar_Palestine  = call_proc($con1, "call fashionbardb_psjw.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── South / Southeast Asia ────────────────────────────────────────────────
    $gamebar_pk         = call_proc($con1, "call fashionbardb_pkzong.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    $gamebar_indonesia1 = call_proc($con1, "call gamebardb_indonesia.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_indonesia2 = call_proc($con1, "call fashionbardb_idtelkomsel.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_indonesia  = $gamebar_indonesia1 + $gamebar_indonesia2;

    $gamebar_bangladesh1 = call_proc($con1, "call gamebar_bdgrameen.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_bangladesh2 = call_proc($con1, "call fashionbardb_bdgp.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_bangladesh3 = call_proc($con1, "call gamebar_bdrobi.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_bangladesh  = $gamebar_bangladesh1 + $gamebar_bangladesh2 + $gamebar_bangladesh3;

    $gamebar_lk         = call_proc($con1, "call gamebar_lk_dig.getactivation('{$start_date}','{$end_date}',{$i})");

    // ── Africa ────────────────────────────────────────────────────────────────
    $gamebar_kenya      = call_proc($con1, "call fashionbardb_safaricom.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_ghana      = call_proc($con1, "call gamebar_ghairtel_mtech.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_Nigeriammt = call_proc($con1, "call gamebar_nigeria_MMT.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_Nigeriamtn = call_proc($con1, "call fashionbardb_ngmtn.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_Nigeria    = $gamebar_Nigeriamtn + $gamebar_Nigeriammt;
    $gamebar_gabon      = call_proc($con1, "call fashionbardb_gabon.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_et         = call_proc($con1, "call gamebar_ethopia.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_Mozambique = call_proc($con1, "call fashionbardb_mz.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── Nordics / CZ / CH ─────────────────────────────────────────────────────
    $gamebar_norway     = call_proc($con1, "call fashionbardb_norway.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_sweden     = call_proc($con1, "call fashionbardb_sweden.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_finland    = call_proc($con1, "call fashionbardb_finland.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_cz         = call_proc($con1, "call fashionbardb_cz.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $gamebar_switzerland = call_proc($con1, "call gamebar_ch_nth.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    // ── Glambar / 11Players / Contest ─────────────────────────────────────────
    $glambar_pl         = call_proc($con1, "call glambar_plteleaudio.getactivation('{$start_date}','{$end_date}',{$i})", $activation);
    $glambar_pldmc      = call_proc($con1, "call fashionbardb_polandglam.get_activation('{$start_date}','{$end_date}',{$i})", $activation);

    $Players_kenya      = call_proc($con1, "call fashionbardb_safaricompkm_new.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $players_ng         = call_proc($con1, "call fashionbardb_ngmtn11.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $players_et         = call_proc($con1, "call 11players_ethopia.getactivation('{$start_date}','{$end_date}',{$i})", $activation);

    $players_bd_daily   = call_proc($con1, "call 11players_bdrobi.getactivation('{$start_date}','{$end_date}',{$i})");
    $players_bd_weekly  = call_proc($con1, "call 11players_bdrobi_weekly.getactivation('{$start_date}','{$end_date}',{$i})");
    $players_bd_monthly = call_proc($con1, "call 11players_bdrobi_monthly.getactivation('{$start_date}','{$end_date}',{$i})");
    $players_bd         = $players_bd_daily + $players_bd_weekly + $players_bd_monthly;

    $players_ghana      = call_proc($con1, "call fashionbardb_ghmtn11.get_activation('{$start_date}','{$end_date}',{$i})");
    $players_ksa        = call_proc($con1, "call fashionbardb_sa11.get_activation('{$start_date}','{$end_date}',{$i})");

    $contest_qatar      = call_proc($con1, "call contestdb_qaoo.get_activation('{$start_date}','{$end_date}',{$i})", $activation);
    $contest_bh         = call_proc($con1, "call contestdb_bh.get_activation('{$start_date}','{$end_date}',{$i})");

    // ── Log hour summary ──────────────────────────────────────────────────────
    clog("Hour {$i}/24 | activation={$activation} | iraq={$gamebar_iraq} bangladesh={$gamebar_bangladesh} indonesia={$gamebar_indonesia} nigeria={$gamebar_Nigeria}");
    if ($is_web) { echo "<p class='done'>&#10003; Hour {$i}/24 done &mdash; activation={$activation}</p>"; ob_flush(); flush(); }

    // ── Mark cron as ran once enough operators have responded ─────────────────
    if ($activation >= 139) {
        $activationcount = 1;
        $cur_date = date('Y-m-d H-i:s');
        mysqli_query($con2, "UPDATE gamebardb_vodafone_qatar_report.cron_report SET ran={$activationcount}, date='{$cur_date}' WHERE cron_name='cron_activation'");
        clog("cron_report marked ran=1");
    }

    // ── Insert hour row ───────────────────────────────────────────────────────
    $sql55 = "INSERT INTO gamebardb_vodafone_qatar_report.activation_report
        (`date`,`hour`,`gamebar_france`,`gamebar_southafrica`,`gamebar_myanmar`,`gamebar_paydashgr`,
         `Glambar_southafrica`,`Glambar_paydashgr`,`gamebar_kuwait`,`gamebar_bahrain`,`gamebar_indoneisa`,
         `gamebar_oman`,`gamebar_pk`,`gamebar_qatar`,`gamebar_uae`,`glambar_pl`,`glambar_thailand`,
         `gamebar_thailand`,`gamebar_ksa`,`gamebar_norway`,`gamebar_czech`,`gamebar_egmon`,`glambar_czech`,
         `gamebar_slovenia`,`gamebar_ro`,`gamebar_finland`,`glambar_slovenia`,`gamebar_pl`,`glambar_pldmc`,
         `gamebar_turkey`,`gamebar_switzerland`,`gamebar_iraq`,`gamebar_Mozambique`,`gamebar_kenya`,
         `gamebar_jordan`,`gamebar_bangladesh`,`gamebar_ghana`,`gamebar_Nigeria`,`gamebar_gabon`,
         `gamebar_Palestine`,`11Players_nigeria`,`11Players_bd`,`11Players_kenya`,`contest_qatar`,
         `gamebar_ethiopia`,`11players_ethiopia`,`11players_ghana`,`11Players_KSA`,`contest_bh`,`gamebar_lk`)
        VALUES
        ('{$date1}','{$i}','{$gamebar_france}','{$sagact}','{$gamebar_myanmar}','{$gamebar_paydashgr}',
         '{$glambarsouthafrica}','{$glambar_paydashgr}','{$gamebar_kuwait}','{$gamebar_bahrain}','{$gamebar_indonesia}',
         '{$gamebar_oman}','{$gamebar_pk}','{$gamebar_qatar}','{$gamebar_uae}','{$glambar_pl}','{$glambar_thailand}',
         '{$gamebar_thailand}','{$gamebar_ksa}','{$gamebar_norway}','{$gamebar_cz}','{$egmon}','{$glambar_czech}',
         '{$gamebar_slovenia}','{$gamebar_ro}','{$gamebar_finland}','{$glambar_slovenia}','{$gamebar_pl}','{$glambar_pldmc}',
         '{$gamebar_turkey}','{$gamebar_switzerland}','{$gamebar_iraq}','{$gamebar_Mozambique}','{$gamebar_kenya}',
         '{$gamebar_jordan}','{$gamebar_bangladesh}','{$gamebar_ghana}','{$gamebar_Nigeria}','{$gamebar_gabon}',
         '{$gamebar_Palestine}','{$players_ng}','{$players_bd}','{$Players_kenya}','{$contest_qatar}',
         '{$gamebar_et}','{$players_et}','{$players_ghana}','{$players_ksa}','{$contest_bh}','{$gamebar_lk}')";

    if (!mysqli_query($con1, $sql55)) {
        clog("INSERT ERROR hour {$i}: " . $con1->error);
        if ($is_web) { echo "<p class='err'>&#10007; INSERT error hour {$i}: " . htmlspecialchars($con1->error) . "</p>"; ob_flush(); flush(); }
    }
}

clog("========== cron_activation DONE — total activation={$activation} ==========");
if ($is_web) {
    echo "<p class='head'>&#10003; DONE &mdash; total activation={$activation} &mdash; date={$date1}</p>";
    echo "<p style='color:#94a3b8;margin-top:20px'>You can close this tab. Data is saved.</p></body></html>";
}
?>
