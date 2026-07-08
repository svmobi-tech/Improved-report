<?php
ob_start();

$pageTitle = 'Activation Report';
$pageIcon  = 'fa-bolt';

if (session_status() === PHP_SESSION_NONE) session_start();
date_default_timezone_set("Asia/Kolkata");

require_once __DIR__ . '/includes/config.php';
include("includes/check_session.php");
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

$result1 = $con1->query("select * from {$report}.activationsetting");
while ($row1 = mysqli_fetch_array($result1)) {
    $ll[$row1['Product']][$row1['Country']] = $row1['Action'];
}
$result1->close();

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



 <div class="hp-card hp-filter-card">
    <div class="hp-card-header">
      <h4><i class="fa fa-filter"></i> Filter Options</h4>
      <span id="last-updated-ts" style="float:right; color:#fff; font-size:13px; margin-top:6px;">
        <i class="fa fa-clock-o"></i> Last updated: --
      </span>
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
                                        $date1 = date('Y-m-d');
                                        $b = $c = 0;

                                        if ($start_date == $end_date) {
                                            $start_date  = date('Y-m-d 00:00:00', strtotime($_POST['start_date']));
                                            $end_date    = date('Y-m-d 23:59:59', strtotime($_POST['end_date']));
                                            $start_date1 = date('Y-m-d', strtotime($_POST['start_date']));
                                            $end_date1   = date('Y-m-d', strtotime($_POST['end_date']));
                                            $hours       = $_POST['hours'];
                                        } else {
                                            $start_date  = date('Y-m-d 00:00:00', strtotime($_POST['start_date']));
                                            $end_date    = date('Y-m-d 00:00:00', strtotime($_POST['end_date']));
                                            $start_date1 = date('Y-m-d', strtotime($_POST['start_date']));
                                            $end_date1   = date('Y-m-d', strtotime($_POST['end_date']));
                                            $hours       = $_POST['hours'];
                                        }

                                        if ($end_date1 == $date1 && $start_date1 == $date1) {
                                            $c = 1;
                                        } elseif ($end_date1 == $date1 && $start_date1 != $date1) {
                                            $b = 1;
                                            $c = 1;
                                        } else {
                                            $b = 1;
                                        }

                                        if ($b == 1) {
                                            $report = 'gamebardb_vodafone_qatar_report';
                                            $sql    = "select * from {$report}.activation_report"
                                                    . " where date>='{$start_date1}' and date<='{$end_date}' and hour='{$hours}'"
                                                    . " order by `date` asc";

                                            $result = $con1->query($sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $row['glambar_poland'] = ($row['glambar_pl'] ?? 0) + ($row['glambar_pldmc'] ?? 0);
                                                echo "<tr><td>{$row['date']}</td>";
                                                foreach ($columns as $product => $countries) {
                                                    foreach ($countries as $country => $col) {
                                                        if (($ll[$product][$country] ?? '') === 'Open') {
                                                            echo "<td>" . ($row[$col] ?? '') . "</td>";
                                                        }
                                                    }
                                                }
                                                echo "</tr>";
                                            }
                                        }

                                        if ($c == 1) {
                                            $start_date = $date1 . " 00:00:00";
                                            $end_date   = $date1 . " 23:59:59";

                                            // Cache today's SP results in session for 5 min to avoid ~58 sequential SP calls on every filter
                                            $act_cache_key = 'act_today_' . $date1 . '_h' . $hours;
                                            $act_cache_ts  = $act_cache_key . '_ts';
                                            $cache_valid   = isset($_SESSION[$act_cache_key], $_SESSION[$act_cache_ts])
                                                          && (time() - $_SESSION[$act_cache_ts]) < 300;

                                            if ($cache_valid) {
                                                $today = $_SESSION[$act_cache_key];
                                            } else {
                                            $today = [];

                                            $today['gamebar_france']      = call_sp($con1, 'fashionbardb_france.get_activation',      $start_date, $end_date, $hours);
                                            $today['gamebar_gabon']        = call_sp($con1, 'fashionbardb_gabon.get_activation',        $start_date, $end_date, $hours);
                                            $today['gamebar_turkey']       = call_sp($con1, 'fashionbardb_paygurutr.get_activation',    $start_date, $end_date, $hours);
                                            $today['gamebar_switzerland']  = call_sp($con1, 'gamebar_ch_nth.get_activation',            $start_date, $end_date, $hours);
                                            $today['11Players_KSA']        = call_sp($con1, 'fashionbardb_sa11.get_activation',         $start_date, $end_date, $hours);
                                            $today['gamebar_pk']           = call_sp($con1, 'fashionbardb_pkzong.get_activation',       $start_date, $end_date, $hours);
                                            $today['gamebar_ro']           = call_sp($con1, 'gamebar_ro.get_activation',               $start_date, $end_date, $hours);
                                            $today['gamebar_finland']      = call_sp($con1, 'fashionbardb_finland.get_activation',      $start_date, $end_date, $hours);
                                            $today['gamebar_slovenia']     = call_sp($con1, 'gamebar_slovenia.get_activation',          $start_date, $end_date, $hours);
                                            $today['glambar_slovenia']     = call_sp($con1, 'glambar_slovenia.get_activation',          $start_date, $end_date, $hours);
                                            $today['glambar_czech']        = call_sp($con1, 'fashionbardb_czglam.get_activation',       $start_date, $end_date, $hours);
                                            $today['gamebar_ksa']          = call_sp($con1, 'fashionbardb_timwezain.get_activation',    $start_date, $end_date, $hours);
                                            $today['gamebar_myanmar']      = call_sp($con1, 'fashionbardb_myanmartelenor.get_activation', $start_date, $end_date, $hours);
                                            $today['gamebar_Mozambique']   = call_sp($con1, 'fashionbardb_mz.get_activation',           $start_date, $end_date, $hours);
                                            $today['gamebar_paydashgr']    = call_sp($con1, 'fashionbardb_greece.get_activation',       $start_date, $end_date, $hours);
                                            $today['Glambar_paydashgr']    = call_sp($con1, 'fashionbardb_greeceglambar.get_activation', $start_date, $end_date, $hours);
                                            $today['gamebar_uae']          = call_sp($con1, 'fashionbardb_etisalat.get_activation',     $start_date, $end_date, $hours);
                                            $today['gamebar_pl']           = call_sp($con1, 'fashionbardb_polandgame.get_activation',   $start_date, $end_date, $hours);
                                            $today['gamebar_bahrain']      = call_sp($con1, 'fashionbardb_bh.get_activation',           $start_date, $end_date, $hours);
                                            $today['glambar_thailand']     = call_sp($con1, 'fashionbardb_glam9005thailand.get_activation', $start_date, $end_date, $hours);
                                            $today['gamebar_thailand']     = call_sp($con1, 'fashionbardb_game9305thailand.get_activation', $start_date, $end_date, $hours);
                                            $today['gamebar_oman']         = call_sp($con1, 'fashionbardb_omooredoo.get_activation',    $start_date, $end_date, $hours);
                                            $today['gamebar_kenya']        = call_sp($con1, 'fashionbardb_safaricom.get_activation',    $start_date, $end_date, $hours);
                                            $today['gamebar_ghana']        = call_sp($con1, 'gamebar_ghairtel_mtech.getactivation',     $start_date, $end_date, $hours);
                                            $today['11Players_nigeria']    = call_sp($con1, 'fashionbardb_ngmtn11.get_activation',      $start_date, $end_date, $hours);
                                            $today['gamebar_Palestine']    = call_sp($con1, 'fashionbardb_psjw.get_activation',         $start_date, $end_date, $hours);
                                            $today['11Players_kenya']      = call_sp($con1, 'fashionbardb_safaricompkm.get_activation', $start_date, $end_date, $hours);
                                            $today['contest_qatar']        = call_sp($con1, 'contestdb_qaoo.get_activation',            $start_date, $end_date, $hours);
                                            $today['gamebar_lk']           = call_sp($con1, 'gamebar_lk_dig.getactivation',             $start_date, $end_date, $hours);
                                            $today['contest_bh']           = call_sp($con1, 'contestdb_bh.get_activation',              $start_date, $end_date, $hours);

                                            // Multi-source aggregations
                                            $today['gamebar_iraq']         = call_sp($con1, 'gamebar_iqzain_qg.getactivation_1',          $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'gamebar_iqmw_api.getactivation_1',            $start_date, $end_date, $hours);
                                            $today['gamebar_qatar']        = call_sp($con1, 'fashionbardb_qatarooredoo.get_activation',  $start_date, $end_date, $hours);
                                            $today['gamebar_egmon']        = call_sp($con1, 'gamebar_egypt.getactivation',               $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'gamebar_egypt_mondianew.getactivation',     $start_date, $end_date, $hours);
                                            $today['gamebar_czech']        = call_sp($con1, 'fashionbardb_cz.get_activation',            $start_date, $end_date, $hours);
                                            $today['Glambar_southafrica']  = call_sp($con1, 'fashionbardb_zaglam.get_activation',        $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'glambar_zamobixone.get_activation',         $start_date, $end_date, $hours);
                                            $today['gamebar_southafrica']  = call_sp($con1, 'fashionbardb_za.get_activation_1',            $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'gamebar_zamobixone.get_activation',         $start_date, $end_date, $hours);
                                            $today['gamebar_indoneisa']    = call_sp($con1, 'gamebardb_indonesia.get_activation',        $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_idtelkomsel.get_activation',   $start_date, $end_date, $hours);
                                            $today['gamebar_kuwait']       = call_sp($con1, 'fashionbardb_slakwzain.get_activation',     $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_slakwstc.get_activation',      $start_date, $end_date, $hours);
                                            $today['gamebar_jordan']       = call_sp($con1, 'fashionbardb_joorange.get_activation',      $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_joumniah.get_activation',      $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'gamebar_jozain.getactivation',              $start_date, $end_date, $hours);
                                            $today['gamebar_bangladesh']   = call_sp($con1, 'gamebar_bdgrameen.getactivation',           $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_bdgp.get_activation',          $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'gamebar_bdrobi.getactivation',              $start_date, $end_date, $hours);
                                            $today['gamebar_Nigeria']      = call_sp($con1, 'gamebar_nigeria_MMT.getactivation',         $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_ngmtn.get_activation',         $start_date, $end_date, $hours);
                                            $today['11Players_bd']         = call_sp($con1, '11players_bdrobi.getactivation',            $start_date, $end_date, $hours)
                                                                           + call_sp($con1, '11players_bdrobi_weekly.getactivation',     $start_date, $end_date, $hours)
                                                                           + call_sp($con1, '11players_bdrobi_monthly.getactivation',    $start_date, $end_date, $hours);
                                            $today['gamebar_ethiopia']     = call_sp($con1, 'gamebar_ethopia.getactivation',             $start_date, $end_date, $hours);
                                            $today['11players_ethiopia']   = call_sp($con1, '11players_ethopia.getactivation',           $start_date, $end_date, $hours);
                                            $today['11players_ghana']      = call_sp($con1, 'fashionbardb_ghmtn11.get_activation',       $start_date, $end_date, $hours);
                                            // Glambar Poland = sum of two separate SP sources
                                            $today['glambar_poland']       = call_sp($con1, 'glambar_plteleaudio.getactivation',         $start_date, $end_date, $hours)
                                                                           + call_sp($con1, 'fashionbardb_polandglam.get_activation',    $start_date, $end_date, $hours);

                                            // Store in session cache
                                            $_SESSION[$act_cache_key] = $today;
                                            $_SESSION[$act_cache_ts]  = time();
                                            } // end cache miss block

                                            $cc = 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $date1; ?></td>
                                                <?php foreach ($columns as $product => $countries): ?>
                                                    <?php foreach ($countries as $country => $col): ?>
                                                        <?php if (($ll[$product][$country] ?? '') === 'Open'): ?>
                                                            <td><?php echo $today[$col] ?? 0; ?></td>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php
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

    function generateReport() {
        var start_date = $('input[name="start_date"]').val();
        var end_date   = $('input[name="end_date"]').val();
        var hours      = $('select[name="hours"]').val();

        $.ajax({
            url: window.location.pathname,   // same page
            type: 'POST',
            data: {
                start_date: start_date,
                end_date:   end_date,
                hours:      hours,
                submit:     1
            },
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            beforeSend: function () {
                $('#last-updated-ts').html('<i class="fa fa-spinner fa-spin"></i> Refreshing...');
            },
            success: function (html) {
                $('#ajax-output').html(html);
                var now = new Date();
                var ts = now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                $('#last-updated-ts').html('<i class="fa fa-clock-o"></i> Last updated: ' + ts);
            },
            error: function () {
                $('#last-updated-ts').html('<i class="fa fa-exclamation-triangle"></i> Refresh failed');
            }
        });
    }
    // Run once on page load so the timestamp is populated immediately
    generateReport();
    // Then auto-refresh every 10 minutes (600000 ms)
    setInterval(generateReport, 600000);

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
