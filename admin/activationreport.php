<?php
ob_start();

$pageTitle = 'Activation Report';
$pageIcon  = 'fa-bolt';

include("includes/check_session.php");
date_default_timezone_set("Asia/Kolkata");

require_once __DIR__ . '/includes/config.php';
$con1 = $con; // credentials loaded from .env via config.php

$start_date = '';
$end_date   = '';
$date1      = date('Y-m-d');
$cc         = 0;

$start_date2 = mysqli_real_escape_string($con1, $_POST['start_date'] ?? '');
$end_date2   = mysqli_real_escape_string($con1, $_POST['end_date']   ?? '');
$hours       = mysqli_real_escape_string($con1, $_POST['hours']      ?? '');

$report = 'gamebardb_vodafone_qatar_report';

$kk = [];
$ll = [];

$result1 = $con1->query("select Product,count(Country)cc from {$report}.activationsetting where Action='Open' group by Product");
while ($row1 = mysqli_fetch_array($result1)) {
    $kk[$row1['Product']] = $row1['cc'];
}
$result1->close();
$con1->next_result();

$result1 = $con1->query("select * from {$report}.activationsetting");
while ($row1 = mysqli_fetch_array($result1)) {
    $ll[$row1['Product']][$row1['Country']] = $row1['Action'];
}
$result1->close();
$con1->next_result();

// Maps each product/country to its column key in activation_report table.
// 'glambar_poland' is a virtual key = glambar_pl + glambar_pldmc (precomputed per row).
$columns = [
    'Gamebar' => [
        'Bahrain'     => 'gamebar_bahrain',
        'Bangladesh'  => 'gamebar_bangladesh',
        'Czech'       => 'gamebar_czech',
        'Egypt'       => 'gamebar_egmon',
        'Ethiopia'    => 'gamebar_ethiopia',
        'Finland'     => 'gamebar_finland',
        'France'      => 'gamebar_france',
        'Gabon'       => 'gamebar_gabon',
        'Ghana'       => 'gamebar_ghana',
        'Greece'      => 'gamebar_paydashgr',
        'Indonesia'   => 'gamebar_indoneisa',
        'Iraq'        => 'gamebar_iraq',
        'Jordan'      => 'gamebar_jordan',
        'Kenya'       => 'gamebar_kenya',
        'KSA'         => 'gamebar_ksa',
        'Kuwait'      => 'gamebar_kuwait',
        'Myanmar'     => 'gamebar_myanmar',
        'Mozambique'  => 'gamebar_Mozambique',
        'Nigeria'     => 'gamebar_Nigeria',
        'Oman'        => 'gamebar_oman',
        'Pakistan'    => 'gamebar_pk',
        'Palestine'   => 'gamebar_Palestine',
        'Poland'      => 'gamebar_pl',
        'Qatar'       => 'gamebar_qatar',
        'Romania'     => 'gamebar_ro',
        'Slovenia'    => 'gamebar_slovenia',
        'SouthAfrica' => 'gamebar_southafrica',
        'Srilanka'    => 'gamebar_lk',
        'Switzerland' => 'gamebar_switzerland',
        'Thailand'    => 'gamebar_thailand',
        'UAE'         => 'gamebar_uae',
        'Turkey'      => 'gamebar_turkey',
    ],
    'Glambar' => [
        'Czech'       => 'glambar_czech',
        'Greece'      => 'Glambar_paydashgr',
        'Poland'      => 'glambar_poland',
        'Slovenia'    => 'glambar_slovenia',
        'SouthAfrica' => 'Glambar_southafrica',
        'Thailand'    => 'glambar_thailand',
    ],
    '11Players' => [
        'Bangladesh'  => '11Players_bd',
        'Ethiopia'    => '11players_ethiopia',
        'Ghana'       => '11players_ghana',
        'Kenya'       => '11Players_kenya',
        'KSA'         => '11Players_KSA',
        'Nigeria'     => '11Players_nigeria',
    ],
    'Contest' => [
        'Bahrain'     => 'contest_bh',
        'Qatar'       => 'contest_qatar',
    ],
];

// Calls a stored procedure and returns its 'act' value (0 if SP missing or fails).
function call_sp(mysqli $con, string $db_proc, string $start, string $end, string $hours): int {
    $result = $con->query("call {$db_proc}('{$start}', '{$end}', {$hours})");
    if (!$result) { $con->next_result(); return 0; }
    $act = 0;
    while ($row = mysqli_fetch_array($result)) { $act = (int)($row['act'] ?? 0); }
    $result->close();
    $con->next_result();
    return $act;
}

// Renders one <tr> for the report table.
// $vals maps activation_report column key => value. Works for both a table row
// (fetched from activation_report) and a live-computed today row.
function render_row(string $dateLabel, array $vals, array $columns, array $ll): void {
    // 'glambar_poland' is virtual (glambar_pl + glambar_pldmc). Only derive it when
    // it isn't already provided — the live path sets it directly from two SP sources.
    if (!isset($vals['glambar_poland'])) {
        $vals['glambar_poland'] = ($vals['glambar_pl'] ?? 0) + ($vals['glambar_pldmc'] ?? 0);
    }
    echo "<tr><td>{$dateLabel}</td>";
    foreach ($columns as $product => $countries) {
        foreach ($countries as $country => $col) {
            if (($ll[$product][$country] ?? '') === 'Open') {
                echo "<td>" . ($vals[$col] ?? '') . "</td>";
            }
        }
    }
    echo "</tr>";
}

// Live-computes today's activations by fan-out over ~58 stored procedures.
// Used ONLY as a fallback when the refresh cron has not yet populated today's
// row in activation_report. Normal loads read the pre-aggregated table instead.
function compute_today_live(mysqli $con, string $start, string $end, int $hours): array {
    $today = [];

    $today['gamebar_france']      = call_sp($con, 'fashionbardb_france.get_activation',      $start, $end, $hours);
    $today['gamebar_gabon']       = call_sp($con, 'fashionbardb_gabon.get_activation',       $start, $end, $hours);
    $today['gamebar_turkey']      = call_sp($con, 'fashionbardb_paygurutr.get_activation',   $start, $end, $hours);
    $today['gamebar_switzerland'] = call_sp($con, 'gamebar_ch_nth.get_activation',           $start, $end, $hours);
    $today['11Players_KSA']       = call_sp($con, 'fashionbardb_sa11.get_activation',        $start, $end, $hours);
    $today['gamebar_pk']          = call_sp($con, 'fashionbardb_pkzong.get_activation',      $start, $end, $hours);
    $today['gamebar_ro']          = call_sp($con, 'gamebar_ro.get_activation',               $start, $end, $hours);
    $today['gamebar_finland']     = call_sp($con, 'fashionbardb_finland.get_activation',     $start, $end, $hours);
    $today['gamebar_slovenia']    = call_sp($con, 'gamebar_slovenia.get_activation',         $start, $end, $hours);
    $today['glambar_slovenia']    = call_sp($con, 'glambar_slovenia.get_activation',         $start, $end, $hours);
    $today['glambar_czech']       = call_sp($con, 'fashionbardb_czglam.get_activation',      $start, $end, $hours);
    $today['gamebar_ksa']         = call_sp($con, 'fashionbardb_timwezain.get_activation',   $start, $end, $hours);
    $today['gamebar_myanmar']     = call_sp($con, 'fashionbardb_myanmartelenor.get_activation', $start, $end, $hours);
    $today['gamebar_Mozambique']  = call_sp($con, 'fashionbardb_mz.get_activation',          $start, $end, $hours);
    $today['gamebar_paydashgr']   = call_sp($con, 'fashionbardb_greece.get_activation',      $start, $end, $hours);
    $today['Glambar_paydashgr']   = call_sp($con, 'fashionbardb_greeceglambar.get_activation', $start, $end, $hours);
    $today['gamebar_uae']         = call_sp($con, 'fashionbardb_etisalat.get_activation',    $start, $end, $hours);
    $today['gamebar_pl']          = call_sp($con, 'fashionbardb_polandgame.get_activation',  $start, $end, $hours);
    $today['gamebar_bahrain']     = call_sp($con, 'fashionbardb_bh.get_activation',          $start, $end, $hours);
    $today['glambar_thailand']    = call_sp($con, 'fashionbardb_glam9005thailand.get_activation', $start, $end, $hours);
    $today['gamebar_thailand']    = call_sp($con, 'fashionbardb_game9305thailand.get_activation', $start, $end, $hours);
    $today['gamebar_oman']        = call_sp($con, 'fashionbardb_omooredoo.get_activation',   $start, $end, $hours);
    $today['gamebar_kenya']       = call_sp($con, 'fashionbardb_safaricom.get_activation',   $start, $end, $hours);
    $today['gamebar_ghana']       = call_sp($con, 'gamebar_ghairtel_mtech.getactivation',    $start, $end, $hours);
    $today['11Players_nigeria']   = call_sp($con, 'fashionbardb_ngmtn11.get_activation',     $start, $end, $hours);
    $today['gamebar_Palestine']   = call_sp($con, 'fashionbardb_psjw.get_activation',        $start, $end, $hours);
    $today['11Players_kenya']     = call_sp($con, 'fashionbardb_safaricompkm.get_activation', $start, $end, $hours);
    $today['contest_qatar']       = call_sp($con, 'contestdb_qaoo.get_activation',           $start, $end, $hours);
    $today['gamebar_lk']          = call_sp($con, 'gamebar_lk_dig.getactivation',            $start, $end, $hours);
    $today['contest_bh']          = call_sp($con, 'contestdb_bh.get_activation',             $start, $end, $hours);

    // Multi-source aggregations
    $today['gamebar_iraq']        = call_sp($con, 'gamebar_iqzain_qg.getactivation',         $start, $end, $hours)
                                  + call_sp($con, 'gamebar_iqmw_api.getactivation',          $start, $end, $hours);
    $today['gamebar_qatar']       = call_sp($con, 'fashionbardb_qatarooredoo.get_activation', $start, $end, $hours);
    $today['gamebar_egmon']       = call_sp($con, 'gamebar_egypt.getactivation',             $start, $end, $hours)
                                  + call_sp($con, 'gamebar_egypt_mondianew.getactivation',   $start, $end, $hours);
    $today['gamebar_czech']       = call_sp($con, 'fashionbardb_cz.get_activation',          $start, $end, $hours);
    $today['Glambar_southafrica'] = call_sp($con, 'fashionbardb_zaglam.get_activation',      $start, $end, $hours)
                                  + call_sp($con, 'glambar_zamobixone.get_activation',       $start, $end, $hours);
    $today['gamebar_southafrica'] = call_sp($con, 'fashionbardb_za.get_activation',          $start, $end, $hours)
                                  + call_sp($con, 'gamebar_zamobixone.get_activation',       $start, $end, $hours);
    $today['gamebar_indoneisa']   = call_sp($con, 'gamebardb_indonesia.get_activation',      $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_idtelkomsel.get_activation', $start, $end, $hours);
    $today['gamebar_kuwait']      = call_sp($con, 'fashionbardb_slakwzain.get_activation',   $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_slakwstc.get_activation',    $start, $end, $hours);
    $today['gamebar_jordan']      = call_sp($con, 'fashionbardb_joorange.get_activation',    $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_joumniah.get_activation',    $start, $end, $hours)
                                  + call_sp($con, 'gamebar_jozain.getactivation',            $start, $end, $hours);
    $today['gamebar_bangladesh']  = call_sp($con, 'gamebar_bdgrameen.getactivation',         $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_bdgp.get_activation',        $start, $end, $hours)
                                  + call_sp($con, 'gamebar_bdrobi.getactivation',            $start, $end, $hours);
    $today['gamebar_Nigeria']     = call_sp($con, 'gamebar_nigeria_MMT.getactivation',       $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_ngmtn.get_activation',       $start, $end, $hours);
    $today['11Players_bd']        = call_sp($con, '11players_bdrobi.getactivation',          $start, $end, $hours)
                                  + call_sp($con, '11players_bdrobi_weekly.getactivation',   $start, $end, $hours)
                                  + call_sp($con, '11players_bdrobi_monthly.getactivation',  $start, $end, $hours);
    $today['gamebar_ethiopia']    = call_sp($con, 'gamebar_ethopia.getactivation',           $start, $end, $hours);
    $today['11players_ethiopia']  = call_sp($con, '11players_ethopia.getactivation',         $start, $end, $hours);
    $today['11players_ghana']     = call_sp($con, 'fashionbardb_ghmtn11.get_activation',     $start, $end, $hours);
    // Glambar Poland = sum of two separate SP sources
    $today['glambar_poland']      = call_sp($con, 'glambar_plteleaudio.getactivation',       $start, $end, $hours)
                                  + call_sp($con, 'fashionbardb_polandglam.get_activation',  $start, $end, $hours);

    return $today;
}

// Detect AJAX request (sent by jQuery with X-Requested-With header).
$is_ajax = (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest');

// ─── AJAX path: render only the table HTML, then exit ────────────────────────
if ($is_ajax) {
    ob_clean(); // discard anything buffered before this point
    if (!isset($_POST['submit'])) { exit; }
    // Fall through to table rendering below; ob_get_clean() + exit at the end.
}

// ─── Full-page path: render the complete page shell ──────────────────────────
if (!$is_ajax) {
    include("includes/header.php");
    include("includes/sidebar.php");
}
?>
<?php if (!$is_ajax): ?>
<div class="hp-main">
<?php include("includes/top_navigation.php"); ?>
<div class="hp-content">

  <!-- Filter card -->
  <div class="hp-card hp-filter-card">
    <div class="hp-card-header">
      <h4><i class="fa fa-filter"></i> Filter Options</h4>
    </div>
    <div class="hp-card-body">
      <form class="form-horizontal" name="formname" id="formname" method="post">
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <div class="form-group">
              <label class="hp-filter-label">Start Date</label>
              <input class="date-picker form-control" name="start_date" type="text"
                value="<?php echo $start_date2 ? date('d-m-Y', strtotime($start_date2)) : date('d-m-Y'); ?>">
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="form-group">
              <label class="hp-filter-label">End Date</label>
              <input class="date-picker form-control" name="end_date" type="text"
                value="<?php echo $end_date2 ? date('d-m-Y', strtotime($end_date2)) : date('d-m-Y'); ?>">
            </div>
          </div>
          <div class="col-md-2 col-sm-4">
            <div class="form-group">
              <label class="hp-filter-label">Hours</label>
              <select name="hours" class="form-control">
                <?php for ($i = 24; $i > 0; $i--): ?>
                  <option <?php echo ($i == $hours) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="col-md-2 col-sm-4">
            <div class="form-group">
              <label class="hp-filter-label">&nbsp;</label>
              <button type="submit" name="submit" class="btn-submit-report">
                <i class="fa fa-search"></i> Generate Report
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Result card -->
  <div class="hp-card">
    <div class="hp-card-header">
      <h4><i class="fa fa-table"></i> Activation Report</h4>
      <button class="btn-transpose" onclick="transposeTable()">
        <i class="fa fa-arrows-alt"></i> Transpose
      </button>
    </div>
    <div class="hp-card-body" style="padding:0;">
      <div id="ajax-output">
<?php endif; // end full-page shell ?>

<?php
// ─── TABLE RENDERING (used by both full-page and AJAX paths) ─────────────────
if (isset($_POST['submit'])):
?>
                            <div style="padding:16px; overflow-x:auto;">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"><center>Date</center></th>
                                            <?php if (($kk['Gamebar']  ?? 0) > 0): ?><th colspan="<?php echo $kk['Gamebar'];  ?>"><center>Gamebar</center></th><?php endif; ?>
                                            <?php if (($kk['Glambar']  ?? 0) > 0): ?><th colspan="<?php echo $kk['Glambar'];  ?>"><center>Glambar</center></th><?php endif; ?>
                                            <?php if (($kk['11Players'] ?? 0) > 0): ?><th colspan="<?php echo $kk['11Players']; ?>"><center>11Players</center></th><?php endif; ?>
                                            <?php if (($kk['Contest']  ?? 0) > 0): ?><th colspan="<?php echo $kk['Contest'];  ?>"><center>Contest</center></th><?php endif; ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($columns as $product => $countries): ?>
                                                <?php foreach ($countries as $country => $col): ?>
                                                    <?php if (($ll[$product][$country] ?? '') === 'Open'): ?>
                                                        <th><center><?php echo $country; ?></center></th>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $date1       = date('Y-m-d');
                                        $start_date1 = date('Y-m-d', strtotime($_POST['start_date']));
                                        $end_date1   = date('Y-m-d', strtotime($_POST['end_date']));
                                        $hours       = (int)$_POST['hours'];
                                        $report      = 'gamebardb_vodafone_qatar_report';

                                        // Single indexed read for the whole range — including today, which the
                                        // refresh cron keeps current in activation_report. No live SP fan-out here.
                                        $sql = "select * from {$report}.activation_report"
                                             . " where date>='{$start_date1}' and date<='{$end_date1}' and hour='{$hours}'"
                                             . " order by `date` asc";

                                        $todaySeen = false;
                                        $result = $con1->query($sql);
                                        if ($result) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                $rowDate = date('Y-m-d', strtotime($row['date']));
                                                if ($rowDate === $date1) { $todaySeen = true; }
                                                render_row($row['date'], $row, $columns, $ll);
                                            }
                                            $result->close();
                                        }

                                        // Fallback: today is in range but the cron hasn't populated its row yet.
                                        // Compute it live (slow, ~58 SPs) so there is no regression when the cron
                                        // is momentarily behind. Short session cache avoids repeated slow loads.
                                        $todayInRange = ($start_date1 <= $date1 && $date1 <= $end_date1);
                                        if ($todayInRange && !$todaySeen) {
                                            $start_dt = $date1 . ' 00:00:00';
                                            $end_dt   = $date1 . ' 23:59:59';

                                            $act_cache_key = 'act_today_' . $date1 . '_h' . $hours;
                                            $act_cache_ts  = $act_cache_key . '_ts';
                                            $cache_valid   = isset($_SESSION[$act_cache_key], $_SESSION[$act_cache_ts])
                                                          && (time() - $_SESSION[$act_cache_ts]) < 300;

                                            if ($cache_valid) {
                                                $today = $_SESSION[$act_cache_key];
                                            } else {
                                                $today = compute_today_live($con1, $start_dt, $end_dt, $hours);
                                                $_SESSION[$act_cache_key] = $today;
                                                $_SESSION[$act_cache_ts]  = time();
                                            }

                                            render_row($date1, $today, $columns, $ll);
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <div id="tableCopyContainer"></div>
                                <div id="output"></div>
                            </div>
<?php endif; // isset $_POST['submit'] ?>

<?php
// ─── AJAX: flush the buffered table HTML and exit ────────────────────────────
if ($is_ajax) {
    $html = ob_get_clean();
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
    exit;
}
?>

      </div><!-- /#ajax-output -->
    </div><!-- /.hp-card-body -->
  </div><!-- /.hp-card -->

  <!-- Manual Activation Insert (collapsed by default) -->
  <div class="hp-card" style="margin-top:16px;">
    <div class="hp-card-header" id="manual-cron-header" style="cursor:pointer;user-select:none;">
      <h4><i class="fa fa-play-circle"></i> Manual Activation Insert</h4>
      <button class="btn btn-xs btn-default" id="manual-cron-toggle" style="float:right;margin-top:-2px;" onclick="return false;">
        <i class="fa fa-chevron-down"></i>
      </button>
    </div>
    <div class="hp-card-body" id="manual-cron-body" style="display:none;">
      <div class="row" style="align-items:flex-end;">
        <div class="col-md-3 col-sm-5">
          <div class="form-group" style="margin-bottom:0">
            <label class="hp-filter-label">Select Date</label>
            <input type="text" id="manual-cron-date" class="form-control birthday"
                   value="<?php echo date('d-m-Y', strtotime('-1 days')); ?>">
          </div>
        </div>
        <div class="col-md-2 col-sm-4" style="padding-top:4px;">
          <button id="manual-cron-btn" class="btn btn-warning btn-block" style="font-weight:600;">
            <i class="fa fa-bolt"></i> Run Cron for Date
          </button>
        </div>
        <div class="col-md-5 col-sm-12" style="padding-top:4px;">
          <p id="manual-cron-note" style="margin:0;font-size:12.5px;color:#718096;line-height:1.5;">
            <i class="fa fa-info-circle" style="color:#667eea;"></i>
            Opens the cron in a new tab — existing data for that date will be cleared and re-inserted.
          </p>
        </div>
      </div>
    </div>
  </div>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php $noAutoLoad = true; include("includes/footer.php"); ?>

<script>
$(document).ready(function () {
    // Toggle Manual Activation Insert card
    $('#manual-cron-header').on('click', function () {
        var $body = $('#manual-cron-body');
        var $icon = $('#manual-cron-toggle i');
        $body.slideToggle(250, function () {
            if ($body.is(':visible')) {
                $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });
    });

    // Manual cron date picker — future dates disabled
    $('#manual-cron-date').daterangepicker({
        singleDatePicker : true,
        autoApply        : true,
        maxDate          : moment(),
        locale           : { format: 'DD-MM-YYYY' }
    });

    // On click: convert date to YYYY-MM-DD and open cron URL in new tab
    $('#manual-cron-btn').on('click', function () {
        var raw = $('#manual-cron-date').val();  // DD-MM-YYYY
        if (!raw) { alert('Please select a date.'); return; }

        // Parse DD-MM-YYYY → YYYY-MM-DD
        var parts = raw.split('-');
        if (parts.length !== 3) { alert('Invalid date.'); return; }
        var ymd = parts[2] + '-' + parts[1] + '-' + parts[0];

        // Block future dates
        var today = new Date(); today.setHours(0,0,0,0);
        var picked = new Date(ymd);
        if (picked > today) {
            alert('Future date not allowed.\nPlease select today or a past date.');
            return;
        }

        var url = '../crons/cron_activation.php?date=' + ymd;
        window.open(url, '_blank');
    });
});
</script>

<?php ob_end_flush(); ?>
