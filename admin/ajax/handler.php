<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

require_once dirname(__DIR__) . '/includes/config.php';

$action = trim($_REQUEST['action'] ?? '');

switch ($action) {
    case 'report_data':              action_report_data($con);              break;
    case 'subdash_data':             action_subdash_data($con);             break;
    case 'find_operators':           action_find_operators($con);           break;
    case 'find_advertisers':         action_find_advertisers($con);         break;
    case 'find_operators_perform':   action_find_operators_perform($con);   break;
    case 'perform_data':             action_perform_data($con);             break;
    case 'find_operators_trend':     action_find_operators_trend($con);     break;
    case 'trend_data':               action_trend_data($con);               break;
    case 'last_activity_data':       action_last_activity_data($con);       break;
    case 'performance_data':         action_performance_data($con);         break;
    case 'performance2_data':        action_performance2_data($con);        break;
    case 'dashboard_data':           action_dashboard_data($con);           break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action: ' . htmlspecialchars($action)]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// Helper used by action_report_data()
// ═══════════════════════════════════════════════════════════════════════════════
function normalizeRow(array $row, string $fmt, float $cost): array
{
    if ($fmt === 'live') {
        $act     = (int)$row['act'];
        $clicks  = max(1, (int)$row['clicks']);
        $actamnt = (float)$row['actamnt'];
        $renamnt = (float)$row['renamnt'];
        $cbsent  = (int)$row['cbsent'];
        $total   = $actamnt + $renamnt;
        return [
            'date'         => date('d-m-Y', strtotime($row['dt'])),
            'clicks'       => (int)$row['clicks'],
            'uniq'         => (int)$row['uniq'],
            'cg'           => (int)$row['cg'],
            'conv'         => ($act * 100) / $clicks,
            'act'          => $act,
            'actamnt'      => $actamnt,
            'ren'          => (int)$row['ren'],
            'renamnt'      => $renamnt,
            'total_count'  => $act + (int)$row['ren'],
            'total_amount' => $total,
            'churn'        => (int)$row['dct'],
            'low_bal'      => (int)$row['Low'],
            'cbsent'       => $cbsent,
            'cbsent_pct'   => $act > 0 ? ($cbsent * 100) / $act : 0,
            'advcost'      => $cbsent * $cost,
        ];
    }
    $cbsent = (int)$row['cbsent'];
    $total  = (float)$row['totalamount'];
    return [
        'date'         => date('d-m-Y', strtotime($row['Date'])),
        'clicks'       => (int)$row['clicks'],
        'uniq'         => (int)$row['uniq'],
        'cg'           => (int)$row['cg'],
        'conv'         => (float)$row['conversion'],
        'act'          => (int)$row['actcount'],
        'actamnt'      => (float)$row['actamount'],
        'ren'          => (int)$row['renewcount'],
        'renamnt'      => (float)$row['renewamount'],
        'total_count'  => (int)$row['totalcount'],
        'total_amount' => $total,
        'churn'        => (int)$row['churn'],
        'low_bal'      => (int)$row['park'],
        'cbsent'       => $cbsent,
        'cbsent_pct'   => (float)$row['cbsentpercent'],
        'advcost'      => $cbsent * $cost,
    ];
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Main Report data table
// Called by: report.php  →  POST ajax/handler.php?action=report_data
// POST params: operator, product, advertiserid, start_date, end_date
// ═══════════════════════════════════════════════════════════════════════════════
function action_report_data(mysqli $con): void
{
    $report  = 'gamebardb_vodafone_qatar_report';
    $revenue = 0.6;
    $cost    = 0.0;
    $today   = date('Y-m-d');
    $rows    = [];

    $operator     = mysqli_real_escape_string($con, $_POST['operator']     ?? '');
    $product      = mysqli_real_escape_string($con, $_POST['product']      ?? '');
    $advertiserid = mysqli_real_escape_string($con, $_POST['advertiserid'] ?? 'all');
    $start_date2  = $_POST['start_date'] ?? date('d-m-Y');
    $end_date2    = $_POST['end_date']   ?? date('d-m-Y');

    if (!$operator || !$product) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e"><i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>Please select Product and Operator.</div>';
        exit;
    }

    $start_dt  = date('Y-m-d 00:00:00', strtotime($start_date2));
    $end_dt    = date('Y-m-d 23:59:59', strtotime($end_date2));
    $start_dt1 = date('Y-m-d', strtotime($start_date2));
    $end_dt1   = date('Y-m-d', strtotime($end_date2));

    $r = mysqli_query($con, "SELECT operator_cost FROM `{$report}`.`operatorcost` WHERE operator='{$operator}'");
    if ($r && ($w = mysqli_fetch_assoc($r))) {
        $cost = (float)$w['operator_cost'];
    }

    $r = mysqli_query($con, "SELECT revenueshare FROM `{$report}`.`svmobi_revenueshare` WHERE operator='{$operator}'");
    if ($r && ($w = mysqli_fetch_assoc($r))) {
        $revenue = (float)$w['revenueshare'] ?: 0.6;
    }

    $tpl_all = $tpl_adv = '';
    $r = mysqli_query($con, "SELECT mainreport_all, mainreport_advertiser FROM `{$report}`.mainreportquery
        WHERE product='{$product}' AND operator='{$operator}'");
    if ($r && ($w = mysqli_fetch_assoc($r))) {
        $tpl_all = $w['mainreport_all'];
        $tpl_adv = $w['mainreport_advertiser'];
    }
    $adve = ($advertiserid === 'all') ? '0' : $advertiserid;
    $tpl  = ($advertiserid === 'all') ? $tpl_all : $tpl_adv;

    if ($start_dt1 === $today && $end_dt1 === $today) {
        $q   = str_replace(['[startdate]', '[enddate]', '[advid]'], [$start_dt, $end_dt, $adve], $tpl);
        $res = mysqli_query($con, $q);
        if ($res) {
            while ($row = mysqli_fetch_array($res)) {
                $rows[] = normalizeRow($row, 'live', $cost);
            }
        }
    } elseif ($end_dt1 === $today) {
        $q_hist = "SELECT * FROM `{$report}`.mainreport
                   WHERE date >= '{$start_dt1}' AND date < '{$end_dt1}'
                   AND advertiser='{$adve}' AND operator='{$operator}' AND product='{$product}'";
        $r_hist = mysqli_query($con, $q_hist);
        if ($r_hist) {
            while ($row = mysqli_fetch_array($r_hist)) {
                $rows[] = normalizeRow($row, 'historical', $cost);
            }
        }
        $t_start = date('Y-m-d 00:00:00');
        $t_end   = date('Y-m-d 23:59:59');
        $q_live  = str_replace(['[startdate]', '[enddate]', '[advid]'], [$t_start, $t_end, $adve], $tpl);
        $r_live  = mysqli_query($con, $q_live);
        if ($r_live) {
            while ($row = mysqli_fetch_array($r_live)) {
                $rows[] = normalizeRow($row, 'live', $cost);
            }
        }
    } else {
        $q_hist = "SELECT * FROM `{$report}`.mainreport
                   WHERE date >= '{$start_dt1}' AND date <= '{$end_dt1}'
                   AND advertiser='{$adve}' AND operator='{$operator}' AND product='{$product}'";
        $r_hist = mysqli_query($con, $q_hist);
        if ($r_hist) {
            while ($row = mysqli_fetch_array($r_hist)) {
                $rows[] = normalizeRow($row, 'historical', $cost);
            }
        }
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-table"></i> Report Results</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <?php if (!empty($rows)):
            $totals = array_fill_keys(
                ['clicks','uniq','cg','act','actamnt','ren','renamnt','total_count','total_amount','svmobi','churn','low_bal','cbsent','advcost'],
                0
            );
            foreach ($rows as $r) {
                $totals['clicks']       += $r['clicks'];
                $totals['uniq']         += $r['uniq'];
                $totals['cg']           += $r['cg'];
                $totals['act']          += $r['act'];
                $totals['actamnt']      += $r['actamnt'];
                $totals['ren']          += $r['ren'];
                $totals['renamnt']      += $r['renamnt'];
                $totals['total_count']  += $r['total_count'];
                $totals['total_amount'] += $r['total_amount'];
                $totals['svmobi']       += $r['total_amount'] * $revenue;
                $totals['churn']        += $r['churn'];
                $totals['low_bal']      += $r['low_bal'];
                $totals['cbsent']       += $r['cbsent'];
                $totals['advcost']      += $r['advcost'];
            }
        ?>
        <table id="datatable-buttons" class="table table-striped table-bordered" style="min-width:1400px">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Clicks</th>
                    <th>With MDN</th>
                    <th>Sent CG</th>
                    <th>Conv %</th>
                    <th>Activation</th>
                    <th>Act. Amount</th>
                    <th>Renewal</th>
                    <th>Ren. Amount</th>
                    <th>Total Count</th>
                    <th>Total Amount</th>
                    <th>SVMobi Revenue</th>
                    <th>Churn</th>
                    <th>Low Bal.</th>
                    <th>CB Sent</th>
                    <th>CB %</th>
                    <th>Adv. Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo $r['date']; ?></td>
                    <td><?php echo number_format($r['clicks']); ?></td>
                    <td><?php echo number_format($r['uniq']); ?></td>
                    <td><?php echo number_format($r['cg']); ?></td>
                    <td><?php echo number_format($r['conv'], 2) . '%'; ?></td>
                    <td><?php echo number_format($r['act']); ?></td>
                    <td><?php echo number_format($r['actamnt']); ?></td>
                    <td><?php echo number_format($r['ren']); ?></td>
                    <td><?php echo number_format($r['renamnt']); ?></td>
                    <td><?php echo number_format($r['total_count']); ?></td>
                    <td><?php echo number_format($r['total_amount']); ?></td>
                    <td><?php echo number_format($r['total_amount'] * $revenue); ?></td>
                    <td><?php echo number_format($r['churn']); ?></td>
                    <td><?php echo number_format($r['low_bal']); ?></td>
                    <td><?php echo number_format($r['cbsent']); ?></td>
                    <td><?php echo number_format($r['cbsent_pct']) . '%'; ?></td>
                    <td><?php echo number_format($r['advcost']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold; background:#f0f4ff">
                    <td>Total</td>
                    <td><?php echo number_format($totals['clicks']); ?></td>
                    <td><?php echo number_format($totals['uniq']); ?></td>
                    <td><?php echo number_format($totals['cg']); ?></td>
                    <td>—</td>
                    <td><?php echo number_format($totals['act']); ?></td>
                    <td><?php echo number_format($totals['actamnt']); ?></td>
                    <td><?php echo number_format($totals['ren']); ?></td>
                    <td><?php echo number_format($totals['renamnt']); ?></td>
                    <td><?php echo number_format($totals['total_count']); ?></td>
                    <td><?php echo number_format($totals['total_amount']); ?></td>
                    <td><?php echo number_format($totals['svmobi']); ?></td>
                    <td><?php echo number_format($totals['churn']); ?></td>
                    <td><?php echo number_format($totals['low_bal']); ?></td>
                    <td><?php echo number_format($totals['cbsent']); ?></td>
                    <td>—</td>
                    <td><?php echo number_format($totals['advcost']); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <div style="padding:60px; text-align:center">
            <i class="fa fa-inbox" style="font-size:48px; color:#e2e8f0; display:block; margin-bottom:16px"></i>
            <p style="color:#a0aec0; margin:0">No records found for the selected filters.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Sub Dashboard data table
// Called by: subdash.php  →  POST ajax/handler.php?action=subdash_data
// POST params: year, month, currency
// ═══════════════════════════════════════════════════════════════════════════════
function action_subdash_data(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';

    $excluded = [
        'ZA_Vodacom_BT','ZA_Vodacom_FG','ZA_Vodacom','ZA_Vodacom_WFH',
        'Thailand_9305_dtac','Thailand_9305_Ais',
        'Thailand_new_9005_Ais','Thailand_new_9005_Dtac','Thailand_new_9005_Truemove',
        'KSA_Weekly_Mobily','KSA_Weekly_STC','KSA_Weekly_zain',
        'KSA_Daily_Mobily','KSA_Daily_STC','KSA_Daily_zain',
        'KSA_GamePub_Weekly_Mobily','KSA_GamePub_Weekly_STC',
        'KSA_Mobily_Weekly_Gamestation','KSA_Zain_Weekly_Gamestation','KSA_Stc_Weekly_Gamestation',
    ];
    $excl_sql = "'" . implode("','", $excluded) . "'";

    $sel_year     = (int)($_POST['year']     ?? date('Y'));
    $sel_month    = $_POST['month']           ?? date('m');
    $sel_currency = $_POST['currency']        ?? 'INR';
    $devide       = ($sel_currency === 'INR') ? 1 : 87;

    if (!$sel_year || !$sel_month) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Please select Month and Year.
              </div>';
        exit;
    }

    $start_date1   = "{$sel_year}-{$sel_month}-01";
    $end_date      = date('Y-m-t', strtotime($start_date1)) . ' 23:59:59';
    $enddate       = date('Y-m-t', strtotime($start_date1));
    $eday          = (int)date('t', strtotime($enddate));
    $laststartdate = date('Y-m-d', strtotime($start_date1 . ' -1 month'));
    $lastenddate   = date('Y-m-d', strtotime($start_date1 . ' -1 day'));

    $is_current_month = ($sel_month == date('m') && $sel_year == (int)date('Y'));
    if ($is_current_month) {
        $date1   = (int)date('d', strtotime('-1 day'));
        $orderby = 'product, country, operator';
    } else {
        $date1   = $eday;
        $orderby = 'country, product, operator';
    }
    $date1 = max(1, $date1);

    $sql = "
        SELECT
            a.country,
            a.product,
            a.operator,
            a.actcount,
            a.actamount    * f.toinr                                     AS actamount,
            a.renewcount,
            a.renewamount  * f.toinr                                     AS renewamount,
            a.totalcount,
            a.totalamount  * f.toinr                                     AS totalamount,
            a.cbsent,
            a.cbsent      * COALESCE(b.operator_cost, 0) * f.toinr      AS digiinvest,
            a.totalamount * COALESCE(c.revenueshare,  0) * f.toinr      AS revenueshare,
            g.ptotalamount                                               AS lastmonthrevenue
        FROM (
            SELECT product, country, operator,
                   SUM(actcount)    AS actcount,
                   SUM(actamount)   AS actamount,
                   SUM(renewcount)  AS renewcount,
                   SUM(renewamount) AS renewamount,
                   SUM(totalcount)  AS totalcount,
                   SUM(totalamount) AS totalamount,
                   SUM(cbsent)      AS cbsent
            FROM `{$report}`.mainreport
            WHERE advertiser = '0'
              AND Date >= '{$start_date1}'
              AND Date <= '{$end_date}'
              AND operator NOT IN ({$excl_sql})
            GROUP BY product, country, operator
        ) a
        LEFT JOIN  (SELECT operator, MAX(operator_cost) AS operator_cost FROM `{$report}`.operatorcost        GROUP BY operator) b ON b.operator = a.operator
        LEFT JOIN  (SELECT operator, MAX(revenueshare)  AS revenueshare  FROM `{$report}`.svmobi_revenueshare GROUP BY operator) c ON c.operator = a.operator
        INNER JOIN (SELECT country,  MAX(toinr)         AS toinr          FROM `{$report}`.currency            GROUP BY country)  f ON f.country  = a.country
        LEFT JOIN (
            SELECT product, operator, SUM(ptotalamount) AS ptotalamount
            FROM `{$report}`.subdashboard
            WHERE date >= '{$laststartdate}' AND date <= '{$lastenddate}'
            GROUP BY product, operator
        ) g ON g.product = a.product AND g.operator = a.operator
        WHERE (a.totalcount > 0 OR a.cbsent > 0)
        ORDER BY {$orderby}
    ";

    $rows = [];
    $res  = mysqli_query($con, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }

    $plasttotalamount = 0.0;
    $res3 = mysqli_query($con,
        "SELECT SUM(ptotalamount) AS plasttotalamount
         FROM `{$report}`.subdashboard
         WHERE date >= '{$laststartdate}' AND date <= '{$lastenddate}'"
    );
    if ($res3 && ($r3 = mysqli_fetch_assoc($res3))) {
        $plasttotalamount = (float)($r3['plasttotalamount'] ?? 0);
    }

    $totals = array_fill_keys(
        ['act','actamount','renewcount','renewamount','totalcount','totalamount',
         'cbsent','digiinvest','revenueshare','profit','ptotal','pdigitin','prevenue','pprofit'],
        0.0
    );
    foreach ($rows as $r) {
        $totalamt = $r['totalamount']  / $devide;
        $digitin  = $r['digiinvest']   / $devide;
        $revenue  = $r['revenueshare'] / $devide;
        $profit   = ($r['revenueshare'] - $r['digiinvest']) / $devide;
        $ptotal   = $totalamt * $eday / $date1;
        $totals['act']          += $r['actcount'];
        $totals['actamount']    += $r['actamount']   / $devide;
        $totals['renewcount']   += $r['renewcount'];
        $totals['renewamount']  += $r['renewamount']  / $devide;
        $totals['totalcount']   += $r['totalcount'];
        $totals['totalamount']  += $totalamt;
        $totals['cbsent']       += $r['cbsent'];
        $totals['digiinvest']   += $digitin;
        $totals['revenueshare'] += $revenue;
        $totals['profit']       += $profit;
        $totals['ptotal']       += $ptotal;
        $totals['pdigitin']     += $digitin  * $eday / $date1;
        $totals['prevenue']     += $revenue  * $eday / $date1;
        $totals['pprofit']      += $profit   * $eday / $date1;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-table"></i> Sub Dashboard Results</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <?php if (!empty($rows)): ?>
        <table id="subdash-table" class="table table-striped table-bordered" style="min-width:1600px; font-size:12.5px;">
            <thead>
                <tr style="background:#4a5568; color:#fff; text-align:center;">
                    <th rowspan="2">Country</th>
                    <th rowspan="2">Product</th>
                    <th rowspan="2">Operator</th>
                    <th colspan="2">Activation</th>
                    <th colspan="2">Renewal</th>
                    <th colspan="2">Total</th>
                    <th rowspan="2">CB Sent</th>
                    <th rowspan="2">Digital Investment</th>
                    <th rowspan="2">SVMobi Revenue</th>
                    <th rowspan="2">Profit / Loss</th>
                    <th colspan="5">Projected</th>
                </tr>
                <tr style="background:#4a5568; color:#fff; text-align:center;">
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Total Amt</th><th>Dig. Invest</th>
                    <th>Revenue</th><th>P/L</th>
                    <th>% Growth</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r):
                    $totalamt = $r['totalamount']  / $devide;
                    $digitin  = $r['digiinvest']   / $devide;
                    $revenue  = $r['revenueshare'] / $devide;
                    $profit   = ($r['revenueshare'] - $r['digiinvest']) / $devide;
                    $ptotal   = $totalamt * $eday / $date1;
                    $pdigitin = $digitin  * $eday / $date1;
                    $prevenue = $revenue  * $eday / $date1;
                    $pprofit  = $profit   * $eday / $date1;
                    $mm       = (float)($r['lastmonthrevenue'] ?? 0) / $devide;
                    $growth   = ($ptotal > 0) ? ($ptotal - $mm) / $ptotal * 100 : 0;
                ?>
                <tr>
                    <td style="background:#dedbdb; font-weight:600;"><?php echo htmlspecialchars($r['country']); ?></td>
                    <td style="background:#dedbdb; font-weight:600;"><?php echo htmlspecialchars($r['product']); ?></td>
                    <td style="background:#dedbdb; font-weight:600;"><?php echo htmlspecialchars($r['operator']); ?></td>
                    <td><?php echo number_format($r['actcount']); ?></td>
                    <td><?php echo number_format($r['actamount'] / $devide); ?></td>
                    <td><?php echo number_format($r['renewcount']); ?></td>
                    <td><?php echo number_format($r['renewamount'] / $devide); ?></td>
                    <td><?php echo number_format($r['totalcount']); ?></td>
                    <td><?php echo number_format($totalamt); ?></td>
                    <td><?php echo number_format($r['cbsent']); ?></td>
                    <td><?php echo number_format($digitin); ?></td>
                    <td><?php echo number_format($revenue); ?></td>
                    <td><?php echo number_format($profit); ?></td>
                    <td><?php echo number_format($ptotal); ?></td>
                    <td><?php echo number_format($pdigitin); ?></td>
                    <td><?php echo number_format($prevenue); ?></td>
                    <td style="font-weight:bold; color:#fff; background:<?php echo $pprofit < 0 ? '#fc8181' : '#68d391'; ?>;">
                        <?php echo number_format($pprofit); ?>
                    </td>
                    <td style="font-weight:bold; color:#fff; background:<?php echo $growth < 0 ? '#fc8181' : '#68d391'; ?>;">
                        <?php echo number_format($growth, 1) . '%'; ?>
                    </td>
                </tr>
                <?php endforeach;
                    $total_growth = ($totals['ptotal'] > 0)
                        ? ($totals['ptotal'] - $plasttotalamount) / $totals['ptotal'] * 100
                        : 0;
                ?>
            </tbody>
            <tfoot>
                <tr style="background:#4a5568; color:#fff; font-weight:bold; text-align:center;">
                    <td colspan="3">Grand Total</td>
                    <td><?php echo number_format($totals['act']); ?></td>
                    <td><?php echo number_format($totals['actamount']); ?></td>
                    <td><?php echo number_format($totals['renewcount']); ?></td>
                    <td><?php echo number_format($totals['renewamount']); ?></td>
                    <td><?php echo number_format($totals['totalcount']); ?></td>
                    <td><?php echo number_format($totals['totalamount']); ?></td>
                    <td><?php echo number_format($totals['cbsent']); ?></td>
                    <td><?php echo number_format($totals['digiinvest']); ?></td>
                    <td><?php echo number_format($totals['revenueshare']); ?></td>
                    <td><?php echo number_format($totals['profit']); ?></td>
                    <td><?php echo number_format($totals['ptotal']); ?></td>
                    <td><?php echo number_format($totals['pdigitin']); ?></td>
                    <td><?php echo number_format($totals['prevenue']); ?></td>
                    <td><?php echo number_format($totals['pprofit']); ?></td>
                    <td><?php echo number_format($total_growth, 1) . '%'; ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <div style="padding:60px; text-align:center;">
            <i class="fa fa-inbox" style="font-size:48px; color:#e2e8f0; display:block; margin-bottom:16px;"></i>
            <p style="color:#a0aec0; margin:0;">No records found for the selected filters.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Operator dropdown for Main Report
// Called by: report.php  →  GET ajax/handler.php?action=find_operators&product=...
// ═══════════════════════════════════════════════════════════════════════════════
function action_find_operators(mysqli $con): void
{
    $product = $_GET['product'] ?? '';
    $report  = 'gamebardb_vodafone_qatar_report';

    if (strcasecmp($product, 'glambar') === 0) {
        $sql = "SELECT * FROM {$report}.mainreportquery WHERE product='glambar'
                AND (mainreport_all IS NOT NULL AND mainreport_all != '') ORDER BY operator ASC";
    } elseif (in_array(strtolower($product), ['11players'])) {
        $sql = "SELECT * FROM {$report}.mainreportquery WHERE product='11Players'
                AND (mainreport_all IS NOT NULL AND mainreport_all != '') ORDER BY operator ASC";
    } elseif (strcasecmp($product, 'contest') === 0) {
        $sql = "SELECT * FROM {$report}.mainreportquery WHERE product='Contest'
                AND (mainreport_all IS NOT NULL AND mainreport_all != '') ORDER BY operator ASC";
    } else {
        $sql = "SELECT * FROM {$report}.mainreportquery WHERE product='gamebar'
                AND (mainreport_all IS NOT NULL AND mainreport_all != '') ORDER BY operator ASC";
    }

    $res = mysqli_query($con, $sql);
    ?>
<select name="operator" id="operator" class="form-control" required>
    <option value="all">All</option>
    <?php while ($row = mysqli_fetch_array($res)): ?>
    <option value="<?php echo htmlspecialchars($row['operator']); ?>">
        <?php echo htmlspecialchars($row['operator']); ?>
    </option>
    <?php endwhile; ?>
</select>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Advertiser dropdown for Main Report
// Called by: report.php  →  GET ajax/handler.php?action=find_advertisers&operator=...&product=...
// ═══════════════════════════════════════════════════════════════════════════════
function action_find_advertisers(mysqli $con): void
{
    $res = mysqli_query($con, "SELECT * FROM advertiserdb.advertiser ORDER BY advname ASC");
    ?>
<select name="advertiserid" class="form-control" required>
    <option value="all">All</option>
    <?php while ($row = mysqli_fetch_array($res)): ?>
    <option value="<?php echo htmlspecialchars($row['advertiserid']); ?>">
        <?php echo htmlspecialchars($row['advname']); ?>
    </option>
    <?php endwhile; ?>
</select>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Operator dropdown for Perform Report
// Called by: perform.php  →  GET ajax/handler.php?action=find_operators_perform&product=...
// ═══════════════════════════════════════════════════════════════════════════════
function action_find_operators_perform(mysqli $con): void
{
    $product = $_GET['product'] ?? '';
    $report  = 'gamebardb_vodafone_qatar_report';

    $perform_cols = "perform_act LIKE '%call%' OR perform_callback LIKE '%call%'
                  OR perform_click LIKE '%call%' OR perform_lowbalance LIKE '%call%'
                  OR perform_trial LIKE '%call%' OR perform_pinconfirm LIKE '%call%'
                  OR perform_centtocg LIKE '%call%'";

    if (strcasecmp($product, 'glambar') === 0) {
        $prod_filter = "product = 'glambar'";
    } elseif (strcasecmp($product, '11players') === 0) {
        $prod_filter = "product = '11Players'";
    } elseif (strcasecmp($product, 'contest') === 0) {
        $prod_filter = "product = 'Contest'";
    } else {
        $prod_filter = "product = 'gamebar'";
    }

    $res = mysqli_query($con,
        "SELECT * FROM {$report}.mainreportquery
         WHERE {$prod_filter} AND ({$perform_cols})
         ORDER BY operator ASC"
    );
    ?>
<select name="operator" id="operator" class="form-control" required>
    <option value="">-- Select Operator --</option>
    <?php while ($row = mysqli_fetch_array($res)): ?>
    <option value="<?php echo htmlspecialchars($row['operator']); ?>">
        <?php echo htmlspecialchars($row['operator']); ?>
    </option>
    <?php endwhile; ?>
</select>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Perform Report data table
// Called by: perform.php  →  POST ajax/handler.php?action=perform_data
// POST params: operator, product, display, start_date, end_date, hours
// ═══════════════════════════════════════════════════════════════════════════════
function action_perform_data(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';

    $operator   = mysqli_real_escape_string($con, $_POST['operator']   ?? '');
    $product    = mysqli_real_escape_string($con, $_POST['product']    ?? '');
    $display    = $_POST['display']    ?? 'activation';
    $hours      = mysqli_real_escape_string($con, $_POST['hours']      ?? '24');
    $start_raw  = $_POST['start_date'] ?? date('d-m-Y');
    $end_raw    = $_POST['end_date']   ?? date('d-m-Y');

    if (!$operator || !$product) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Please select Product and Operator.
              </div>';
        return;
    }

    $start_date = date('Y-m-d 00:00:00', strtotime($start_raw));
    $end_date   = date('Y-m-d 23:59:59', strtotime($end_raw));

    // ── Fetch perform URL columns for this product/operator ───────────────────
    $res = mysqli_query($con,
        "SELECT * FROM {$report}.mainreportquery
         WHERE product = '{$product}' AND operator = '{$operator}' LIMIT 1"
    );
    $row_q = $res ? mysqli_fetch_assoc($res) : [];

    // ── Map display value → column ─────────────────────────────────────────────
    $col_map = [
        'activation'   => 'perform_act',
        'callbacksent' => 'perform_callback',
        'clicks'       => 'perform_click',
        'low'          => 'perform_lowbalance',
        'trial'        => 'perform_trial',
        'pinconfirmed' => 'perform_pinconfirm',
        'cr'           => 'perform_cr',
        'pc'           => 'perform_chargingpercent',
        'renewal'      => 'perform_renewal',
        'sentcg'       => 'perform_centtocg',
    ];
    $col = $col_map[$display] ?? 'perform_centtocg';
    $url = $row_q[$col] ?? '';

    if (!$url) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-info-circle" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No perform URL configured for this operator / display combination.</p>
              </div>';
        return;
    }

    // ── Build and run the query ────────────────────────────────────────────────
    $query = str_replace(
        ['[start_date]', '[end_date]', '[hours]'],
        [$start_date,    $end_date,    $hours],
        $url
    );

    $res = mysqli_query($con, $query);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Query failed. Please check perform URL configuration.</div>';
        return;
    }

    // ── Group rows by date → advname → act ────────────────────────────────────
    $dt      = [];
    $advname = [];
    $arrdt   = [];
    $prevdate = '';
    $act      = [];

    while ($row = mysqli_fetch_array($res)) {
        if ($prevdate === '') $prevdate = $row['dt'];
        if ($prevdate !== $row['dt']) {
            $dt[$prevdate] = $act;
            $act           = [];
            $prevdate      = $row['dt'];
        }
        $act[$row['advname']] = $row['act'];
        if (!in_array($row['advname'], $advname)) $advname[] = $row['advname'];
        if (!in_array($row['dt'],     $arrdt))    $arrdt[]   = $row['dt'];
    }
    if ($prevdate !== '') $dt[$prevdate] = $act;

    if (empty($dt)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected filters.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-table"></i> Perform Report Results</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <table id="perform-table" class="table table-striped table-bordered" style="font-size:12.5px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <?php foreach ($advname as $adv): ?>
                    <th><?php echo htmlspecialchars($adv); ?></th>
                    <?php endforeach; ?>
                    <th><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dt as $date => $vals):
                    $sum = 0;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($date); ?></td>
                    <?php foreach ($advname as $adv):
                        if (array_key_exists($adv, $vals)) {
                            $a = $display === 'cr'
                                ? number_format((float)$vals[$adv], 2, '.', '')
                                : $vals[$adv];
                            $sum += (float)$vals[$adv];
                            echo "<td>{$a}</td>";
                        } else {
                            echo '<td>0</td>';
                        }
                    endforeach; ?>
                    <td><strong><?php echo $display === 'cr' ? number_format($sum, 2) : number_format($sum); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Operator dropdown for Trend Report
// Called by: trend_report.php  →  GET ajax/handler.php?action=find_operators_trend&product=...
// ═══════════════════════════════════════════════════════════════════════════════
function action_find_operators_trend(mysqli $con): void
{
    $product = $_GET['product'] ?? '';
    $report  = 'gamebardb_vodafone_qatar_report';

    if (strcasecmp($product, 'glambar') === 0) {
        $prod_filter = "product = 'glambar'";
    } elseif (strcasecmp($product, '11players') === 0) {
        $prod_filter = "product = '11Players'";
    } elseif (strcasecmp($product, 'contest') === 0) {
        $prod_filter = "product = 'Contest'";
    } else {
        $prod_filter = "product = 'gamebar'";
    }

    $res = mysqli_query($con,
        "SELECT * FROM {$report}.mainreportquery
         WHERE {$prod_filter} AND (trend IS NOT NULL AND trend != '')
         ORDER BY operator ASC"
    );
    ?>
<select name="operator" id="operator" class="form-control" required>
    <option value="">-- Select Operator --</option>
    <?php while ($row = mysqli_fetch_array($res)): ?>
    <option value="<?php echo htmlspecialchars($row['operator']); ?>">
        <?php echo htmlspecialchars($row['operator']); ?>
    </option>
    <?php endwhile; ?>
</select>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Trend Report data table
// Called by: trend_report.php  →  POST ajax/handler.php?action=trend_data
// POST params: operator, product, advertiserid, type, start_date, end_date
// ═══════════════════════════════════════════════════════════════════════════════
function action_trend_data(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';

    $operator     = mysqli_real_escape_string($con, $_POST['operator']     ?? '');
    $product      = mysqli_real_escape_string($con, $_POST['product']      ?? '');
    $advertiserid = mysqli_real_escape_string($con, $_POST['advertiserid'] ?? 'all');
    $type         = mysqli_real_escape_string($con, $_POST['type']         ?? 'act');
    $start_raw    = $_POST['start_date'] ?? date('d-m-Y');
    $end_raw      = $_POST['end_date']   ?? date('d-m-Y');

    if (!$operator || !$product) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Please select Product and Operator.
              </div>';
        return;
    }

    $start_date = date('Y-m-d 00:00:00', strtotime($start_raw));
    $end_date   = date('Y-m-d 23:59:59', strtotime($end_raw));
    // Pass advertiserid as-is — trend URL templates use the raw value (e.g. 'all')
    $advid      = $advertiserid;

    // Fetch trend URL template for this product + operator
    $res = mysqli_query($con,
        "SELECT trend FROM {$report}.mainreportquery
         WHERE product='{$product}' AND operator='{$operator}' LIMIT 1"
    );
    $url = '';
    if ($res && ($trow = mysqli_fetch_assoc($res))) {
        $url = $trow['trend'];
    }

    if (!$url) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-info-circle" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No trend URL configured for this operator.</p>
              </div>';
        return;
    }

    $query = str_replace(
        ['[start_date]', '[end_date]', '[advid]', '[type]'],
        [$start_date,    $end_date,    $advid,    $type],
        $url
    );

    $res = mysqli_query($con, $query);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Query failed. Please check trend URL configuration.</div>';
        return;
    }

    // Build pivot: $advname[$date][$hour] = value
    $advname  = [];
    $dt       = [];
    $prevdate = '';

    while ($row = mysqli_fetch_array($res)) {
        if ($prevdate === '') $prevdate = $row['dt'];
        if ($prevdate !== $row['dt']) {
            $dt[$prevdate] = '';
            $prevdate      = $row['dt'];
        }
        $advname[$prevdate][$row['hr']] = $row['act'];
    }
    if ($prevdate !== '') $dt[$prevdate] = '';

    if (empty($dt)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected filters.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-line-chart"></i> Trend Report Results</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <table id="trend-table" class="table table-striped table-bordered" style="font-size:12px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <?php for ($i = 0; $i <= 23; $i++): ?>
                    <th><?php echo $i; ?></th>
                    <?php endfor; ?>
                    <th><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dt as $date => $unused):
                    $sum = 0;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($date); ?></td>
                    <?php for ($jj = 0; $jj < 24; $jj++):
                        $val = isset($advname[$date][$jj]) && $advname[$date][$jj] !== ''
                            ? $advname[$date][$jj] : '';
                        $sum += (int)$val;
                    ?>
                    <td><?php if ($val !== ''): ?>
                        <?php echo number_format((int)$val); ?>
                    <?php else: ?>
                        <span style="color:#fff;font-weight:bold;background:red;padding:2px 5px;border-radius:3px;">0</span>
                    <?php endif; ?></td>
                    <?php endfor; ?>
                    <td><strong><?php echo number_format($sum); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Last Activity Report data table
// Called by: last_activityreport.php  →  POST ajax/handler.php?action=last_activity_data
// No POST params — loads all rows from lastactivity table
// ═══════════════════════════════════════════════════════════════════════════════
function action_last_activity_data(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';
    $today  = date('Y-m-d');

    $res = mysqli_query($con, "SELECT * FROM {$report}.lastactivity ORDER BY id ASC");
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Failed to fetch activity records.</div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No activity records found.</p>
              </div>';
        return;
    }

    $data = [];
    foreach ($rows as $row) {
        $sql1     = trim($row['query'] ?? '');
        $act_date = $ren_date = $cb_date = '';

        if ($sql1) {
            // multi_query handles both regular SELECTs and CALL stored-proc statements
            if ($con->multi_query($sql1)) {
                $result1 = $con->store_result();
                if ($result1) {
                    $row1 = $result1->fetch_assoc();
                    if ($row1) {
                        $act_date = $row1['act_date'] ?? '';
                        $ren_date = $row1['ren_date'] ?? '';
                        $cb_date  = $row1['cb_date']  ?? '';
                    }
                    $result1->free();
                }
                // Flush any remaining result sets (stored procedure cleanup)
                while ($con->more_results()) {
                    $con->next_result();
                    $extra = $con->store_result();
                    if ($extra) $extra->free();
                }
            }
        }

        $data[] = [
            'id'       => $row['id'],
            'product'  => $row['product']  ?? '',
            'operator' => $row['operator'] ?? '',
            'act_date' => $act_date,
            'ren_date' => $ren_date,
            'cb_date'  => $cb_date,
        ];
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-clock-o"></i> Last Activity</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <table id="activity-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Operator</th>
                    <th>Activation</th>
                    <th>Renewal</th>
                    <th>Callback Sent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d): ?>
                <tr>
                    <td><?php echo (int)$d['id']; ?></td>
                    <td><?php echo htmlspecialchars($d['product']); ?></td>
                    <td><?php echo htmlspecialchars($d['operator']); ?></td>
                    <td>
                        <?php $v = $d['act_date']; $c = ($v !== '' && $v > $today) ? '#68d391' : '#fc8181'; ?>
                        <span style="color:#fff;font-weight:bold;background:<?php echo $c; ?>;padding:3px 8px;border-radius:3px;"><?php echo htmlspecialchars($v ?: '—'); ?></span>
                    </td>
                    <td>
                        <?php $v = $d['ren_date']; $c = ($v !== '' && $v > $today) ? '#68d391' : '#fc8181'; ?>
                        <span style="color:#fff;font-weight:bold;background:<?php echo $c; ?>;padding:3px 8px;border-radius:3px;"><?php echo htmlspecialchars($v ?: '—'); ?></span>
                    </td>
                    <td>
                        <?php $v = $d['cb_date']; $c = ($v !== '' && $v > $today) ? '#68d391' : '#fc8181'; ?>
                        <span style="color:#fff;font-weight:bold;background:<?php echo $c; ?>;padding:3px 8px;border-radius:3px;"><?php echo htmlspecialchars($v ?: '—'); ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Current Month Performance data table
// Called by: performance.php  →  POST ajax/handler.php?action=performance_data
// No POST params — compares yesterday vs last 30-day average
// ═══════════════════════════════════════════════════════════════════════════════
function action_performance_data(mysqli $con): void
{
    $report    = 'gamebardb_vodafone_qatar_report';
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $lastday   = date('Y-m-d', strtotime('-30 day'));

    $sql = "
        SELECT
            a.product, a.country, a.operator,
            lastactavg, lastactamtavg,
            lastrenavg, lastrenamtavg,
            yestactcount, yestactamtcount,
            yetrencount, yestrenamtcount
        FROM (
            SELECT product, country, operator,
                   AVG(actcount)    AS lastactavg,
                   AVG(actamount)   AS lastactamtavg,
                   AVG(renewcount)  AS lastrenavg,
                   AVG(renewamount) AS lastrenamtavg
            FROM {$report}.mainreport
            WHERE Date >= '{$lastday}' AND Date <= '{$yesterday}' AND advertiser = 0
            GROUP BY product, country, operator
        ) a
        JOIN (
            SELECT product, country, operator,
                   actcount    AS yestactcount,
                   actamount   AS yestactamtcount,
                   renewcount  AS yetrencount,
                   renewamount AS yestrenamtcount
            FROM {$report}.mainreport
            WHERE Date >= '{$yesterday}' AND Date <= '{$yesterday}' AND advertiser = 0
        ) b ON a.product = b.product AND a.operator = b.operator
        ORDER BY product, country, operator
    ";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Query failed. Please try again.</div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No performance data found for yesterday.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-tachometer"></i> Performance Report
            <small style="font-size:12px;font-weight:400;color:#a0aec0;margin-left:10px;">
                Yesterday (<?php echo date('d-m-Y', strtotime($yesterday)); ?>) vs. Last 30-day Average
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <table id="perf-table" class="table table-striped table-bordered" style="font-size:12.5px;">
            <thead style="background:#4a5568; color:#fff; text-align:center;">
                <tr>
                    <th rowspan="3">Country</th>
                    <th rowspan="3">Product</th>
                    <th rowspan="3">Operator</th>
                    <th colspan="4">Activation</th>
                    <th colspan="4">Renewal</th>
                    <th colspan="2" rowspan="2">% Growth</th>
                </tr>
                <tr>
                    <th colspan="2">AVG. Last 30 Days</th>
                    <th colspan="2">Yesterday</th>
                    <th colspan="2">AVG. Last 30 Days</th>
                    <th colspan="2">Yesterday</th>
                </tr>
                <tr>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>% Growth Act.</th>
                    <th>% Growth Ren.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r):
                    $kk1 = (float)$r['lastactamtavg'] != 0
                        ? ((float)$r['yestactamtcount'] - (float)$r['lastactamtavg']) / (float)$r['lastactamtavg'] * 100 : 0;
                    $kk2 = (float)$r['lastrenamtavg'] != 0
                        ? ((float)$r['yestrenamtcount'] - (float)$r['lastrenamtavg']) / (float)$r['lastrenamtavg'] * 100 : 0;
                ?>
                <tr>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['country']); ?></td>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['product']); ?></td>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['operator']); ?></td>
                    <td><?php echo number_format((float)$r['lastactavg'],      0); ?></td>
                    <td><?php echo number_format((float)$r['lastactamtavg'],   1); ?></td>
                    <td><?php echo number_format((float)$r['yestactcount'],    0); ?></td>
                    <td><?php echo number_format((float)$r['yestactamtcount'], 1); ?></td>
                    <td><?php echo number_format((float)$r['lastrenavg'],      0); ?></td>
                    <td><?php echo number_format((float)$r['lastrenamtavg'],   1); ?></td>
                    <td><?php echo number_format((float)$r['yetrencount'],     0); ?></td>
                    <td><?php echo number_format((float)$r['yestrenamtcount'], 1); ?></td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $kk1 >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($kk1, 1) . '%'; ?>
                    </td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $kk2 >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($kk2, 1) . '%'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Performance2 data table (shows actual date ranges in headers)
// Called by: performance2.php  →  POST ajax/handler.php?action=performance2_data
// ═══════════════════════════════════════════════════════════════════════════════
function action_performance2_data(mysqli $con): void
{
    $report    = 'gamebardb_vodafone_qatar_report';
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $lastday   = date('Y-m') . '-01';
    $avgLabel  = date('d M', strtotime($lastday)) . ' – ' . date('d M Y', strtotime($yesterday));
    $ydLabel   = date('d M Y', strtotime($yesterday));

    $sql = "
        SELECT a.product, a.country, a.operator,
               lastactavg, lastactamtavg, lastrenavg, lastrenamtavg,
               yestactcount, yestactamtcount, yetrencount, yestrenamtcount
        FROM (
            SELECT product, country, operator,
                   AVG(actcount)    AS lastactavg,
                   AVG(actamount)   AS lastactamtavg,
                   AVG(renewcount)  AS lastrenavg,
                   AVG(renewamount) AS lastrenamtavg
            FROM {$report}.mainreport
            WHERE Date >= '{$lastday}' AND Date <= '{$yesterday}' AND advertiser = 0
            GROUP BY product, country, operator
        ) a
        JOIN (
            SELECT product, country, operator,
                   actcount    AS yestactcount,
                   actamount   AS yestactamtcount,
                   renewcount  AS yetrencount,
                   renewamount AS yestrenamtcount
            FROM {$report}.mainreport
            WHERE Date = '{$yesterday}' AND advertiser = 0
        ) b ON a.product = b.product AND a.operator = b.operator
        ORDER BY product, country, operator
    ";

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Query failed. Please try again.</div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No performance data found for yesterday.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-tachometer"></i> Performance Report
            <small style="font-size:12px;font-weight:400;color:#a0aec0;margin-left:10px;">
                <?php echo htmlspecialchars($ydLabel); ?> vs. Monthly Average (<?php echo htmlspecialchars($avgLabel); ?>)
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="perf2-table" class="table table-striped table-bordered" style="font-size:12.5px;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th rowspan="3">Country</th>
                    <th rowspan="3">Product</th>
                    <th rowspan="3">Operator</th>
                    <th colspan="4">Activation</th>
                    <th colspan="4">Renewal</th>
                    <th colspan="2" rowspan="2">% Growth</th>
                </tr>
                <tr>
                    <th colspan="2"><?php echo htmlspecialchars($avgLabel); ?></th>
                    <th colspan="2"><?php echo htmlspecialchars($ydLabel); ?></th>
                    <th colspan="2"><?php echo htmlspecialchars($avgLabel); ?></th>
                    <th colspan="2"><?php echo htmlspecialchars($ydLabel); ?></th>
                </tr>
                <tr>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>% Growth Act.</th>
                    <th>% Growth Ren.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r):
                    $kk1 = (float)$r['lastactamtavg'] != 0
                        ? ((float)$r['yestactamtcount'] - (float)$r['lastactamtavg']) / (float)$r['lastactamtavg'] * 100 : 0;
                    $kk2 = (float)$r['lastrenamtavg'] != 0
                        ? ((float)$r['yestrenamtcount'] - (float)$r['lastrenamtavg']) / (float)$r['lastrenamtavg'] * 100 : 0;
                ?>
                <tr>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['country']); ?></td>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['product']); ?></td>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($r['operator']); ?></td>
                    <td><?php echo number_format((float)$r['lastactavg'],      0); ?></td>
                    <td><?php echo number_format((float)$r['lastactamtavg'],   1); ?></td>
                    <td><?php echo number_format((float)$r['yestactcount'],    0); ?></td>
                    <td><?php echo number_format((float)$r['yestactamtcount'], 1); ?></td>
                    <td><?php echo number_format((float)$r['lastrenavg'],      0); ?></td>
                    <td><?php echo number_format((float)$r['lastrenamtavg'],   1); ?></td>
                    <td><?php echo number_format((float)$r['yetrencount'],     0); ?></td>
                    <td><?php echo number_format((float)$r['yestrenamtcount'], 1); ?></td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $kk1 >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($kk1, 1) . '%'; ?>
                    </td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $kk2 >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($kk2, 1) . '%'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Dashboard data table
// Called by: dashboard.php  →  POST ajax/handler.php?action=dashboard_data
// POST params: month, year, currency
// ═══════════════════════════════════════════════════════════════════════════════
function action_dashboard_data(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';

    $excluded = [
        'ZA_Vodacom_BT','ZA_Vodacom_FG','ZA_Vodacom','ZA_Vodacom_WFH',
        'Thailand_9305_dtac','Thailand_9305_Ais',
        'Thailand_new_9005_Ais','Thailand_new_9005_Dtac','Thailand_new_9005_Truemove',
        'KSA_Weekly_Mobily','KSA_Weekly_STC','KSA_Weekly_zain',
        'KSA_Daily_Mobily','KSA_Daily_STC','KSA_Daily_zain',
        'KSA_GamePub_Weekly_Mobily','KSA_GamePub_Weekly_STC',
        'KSA_Mobily_Weekly_Gamestation','KSA_Zain_Weekly_Gamestation','KSA_Stc_Weekly_Gamestation',
    ];
    $excl_sql = "'" . implode("','", $excluded) . "'";

    $sel_year     = (int)($_POST['year']    ?? date('Y'));
    $sel_month    = str_pad($_POST['month'] ?? date('m'), 2, '0', STR_PAD_LEFT);
    $sel_currency = $_POST['currency']      ?? 'INR';
    $devide       = ($sel_currency === 'INR') ? 1 : 90;

    $start_date1   = "{$sel_year}-{$sel_month}-01";
    $enddate       = date('Y-m-t', strtotime($start_date1));
    $end_date      = $enddate . ' 23:59:59';
    $eday          = (int)date('t', strtotime($enddate));
    $laststartdate = date('Y-m-d', strtotime($start_date1 . ' -1 month'));
    $lastenddate   = date('Y-m-d', strtotime($start_date1 . ' -1 day'));

    $is_current_month = ($sel_month == date('m') && $sel_year == (int)date('Y'));
    $date1 = $is_current_month ? (int)date('d', strtotime('-1 day')) : $eday;
    $date1 = max(1, $date1);

    $sql = "
        SELECT
            e.country,
            actcount,
            actamount    * toinr AS actamount,
            renewcount,
            renewamount  * toinr AS renewamount,
            totalcount,
            totalamount  * toinr AS totalamount,
            cbsent,
            digiinvest   * toinr AS digiinvest,
            revenueshare * toinr AS revenueshare,
            g.ptotalamount       AS lastmonthrevenue,
            fixcost
        FROM (
            SELECT country,
                   SUM(actcount)     AS actcount,   SUM(actamount)     AS actamount,
                   SUM(renewcount)   AS renewcount, SUM(renewamount)   AS renewamount,
                   SUM(totalcount)   AS totalcount, SUM(totalamount)   AS totalamount,
                   SUM(cbsent)       AS cbsent,
                   SUM(digiinvest)   AS digiinvest,
                   SUM(revenueshare) AS revenueshare
            FROM (
                SELECT country, a.product, a.operator,
                       actcount, actamount, renewcount, renewamount,
                       totalcount, totalamount, cbsent,
                       cbsent * b.operator_cost       AS digiinvest,
                       totalamount * c.revenueshare    AS revenueshare
                FROM (
                    SELECT product, country, operator,
                           SUM(actcount)    AS actcount,   SUM(actamount)    AS actamount,
                           SUM(renewcount)  AS renewcount, SUM(renewamount)  AS renewamount,
                           SUM(totalcount)  AS totalcount, SUM(totalamount)  AS totalamount,
                           SUM(cbsent)      AS cbsent
                    FROM {$report}.mainreport
                    WHERE advertiser = '0'
                      AND Date >= '{$start_date1}' AND Date <= '{$end_date}'
                      AND operator NOT IN ({$excl_sql})
                    GROUP BY operator, product, country
                ) a
                LEFT JOIN (SELECT operator, operator_cost FROM {$report}.operatorcost)       b ON b.operator = a.operator
                LEFT JOIN (SELECT operator, revenueshare   FROM {$report}.svmobi_revenueshare) c ON c.operator = a.operator
                GROUP BY product, operator, country, b.operator_cost, c.revenueshare
            ) dd
            GROUP BY country
        ) e
        INNER JOIN (SELECT * FROM {$report}.currency) f ON f.country = e.country
        LEFT JOIN (
            SELECT country, SUM(ptotalamount) AS ptotalamount
            FROM {$report}.dashboard
            WHERE date >= '{$laststartdate}' AND date <= '{$lastenddate}'
            GROUP BY country
        ) g ON g.country = e.country
        WHERE totalcount > 0
        ORDER BY country
    ";

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Query failed. Please try again.</div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }

    $plasttotalamount = 0.0;
    $res3 = mysqli_query($con,
        "SELECT SUM(ptotalamount) AS plasttotalamount
         FROM {$report}.dashboard
         WHERE date >= '{$laststartdate}' AND date <= '{$lastenddate}'"
    );
    if ($res3 && ($r3 = mysqli_fetch_assoc($res3))) {
        $plasttotalamount = (float)($r3['plasttotalamount'] ?? 0);
    }

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        return;
    }

    $computed = [];
    $totals = array_fill_keys(
        ['act','actamount','renewcount','renewamount','totalcount','totalamount',
         'cbsent','digiinvest','revenueshare','profit','ptotal','pdigitin','prevenue','fixcost','pprofit'],
        0.0
    );

    foreach ($rows as $r) {
        $totalamt  = (float)$r['totalamount']   / $devide;
        $digitin   = (float)$r['digiinvest']    / $devide;
        $revenue   = (float)$r['revenueshare']  / $devide;
        $fixcost   = (float)$r['fixcost']       / $devide;
        $profit    = ((float)$r['revenueshare'] - (float)$r['digiinvest']) / $devide;
        $ptotal    = ($eday > 0 && $date1 > 0) ? $totalamt * $eday / $date1 : 0;
        $pdigitin  = ($eday > 0 && $date1 > 0) ? $digitin  * $eday / $date1 : 0;
        $prevenue  = ($eday > 0 && $date1 > 0) ? $revenue  * $eday / $date1 : 0;
        $pprofit   = ($eday > 0 && $date1 > 0) ? $profit   * $eday / $date1 - $fixcost : 0;
        $mm        = (float)($r['lastmonthrevenue'] ?? 0) / $devide;
        $growth    = $ptotal > 0 ? ($ptotal - $mm) / $ptotal * 100 : 0;

        $computed[] = compact(
            'totalamt','digitin','revenue','fixcost','profit',
            'ptotal','pdigitin','prevenue','pprofit','growth'
        ) + [
            'country'     => $r['country'],
            'actcount'    => (float)$r['actcount'],
            'actamount'   => (float)$r['actamount']   / $devide,
            'renewcount'  => (float)$r['renewcount'],
            'renewamount' => (float)$r['renewamount']  / $devide,
            'totalcount'  => (float)$r['totalcount'],
            'cbsent'      => (float)$r['cbsent'],
        ];

        $totals['act']          += (float)$r['actcount'];
        $totals['actamount']    += (float)$r['actamount']   / $devide;
        $totals['renewcount']   += (float)$r['renewcount'];
        $totals['renewamount']  += (float)$r['renewamount']  / $devide;
        $totals['totalcount']   += (float)$r['totalcount'];
        $totals['totalamount']  += $totalamt;
        $totals['cbsent']       += (float)$r['cbsent'];
        $totals['digiinvest']   += $digitin;
        $totals['revenueshare'] += $revenue;
        $totals['profit']       += $profit;
        $totals['ptotal']       += $ptotal;
        $totals['pdigitin']     += $pdigitin;
        $totals['prevenue']     += $prevenue;
        $totals['fixcost']      += $fixcost;
        $totals['pprofit']      += $pprofit;
    }

    $total_growth = $totals['ptotal'] > 0
        ? ($totals['ptotal'] - $plasttotalamount) / $totals['ptotal'] * 100 : 0;
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-home"></i> Dashboard Results</h4>
    </div>
    <div class="hp-card-body" style="padding:0; overflow-x:auto;">
        <table id="dash-table" class="table table-striped table-bordered" style="min-width:1600px; font-size:12.5px;">
            <thead style="background:#4a5568; color:#fff; text-align:center;">
                <tr>
                    <th rowspan="2">Country</th>
                    <th colspan="2">Activation</th>
                    <th colspan="2">Renewal</th>
                    <th colspan="2">Total</th>
                    <th rowspan="2">CB Sent</th>
                    <th rowspan="2">Digital Investment</th>
                    <th rowspan="2">SVMobi Revenue</th>
                    <th rowspan="2">Profit / Loss</th>
                    <th colspan="6">Projected</th>
                </tr>
                <tr>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Count</th><th>Amount</th>
                    <th>Total Amt</th><th>Dig. Invest</th>
                    <th>Revenue</th><th>Fix Cost</th>
                    <th>P / L</th><th>% Growth</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($computed as $c): ?>
                <tr>
                    <td style="background:#dedbdb;font-weight:600;"><?php echo htmlspecialchars($c['country']); ?></td>
                    <td><?php echo number_format($c['actcount'],   0); ?></td>
                    <td><?php echo number_format($c['actamount'],  0); ?></td>
                    <td><?php echo number_format($c['renewcount'], 0); ?></td>
                    <td><?php echo number_format($c['renewamount'],0); ?></td>
                    <td><?php echo number_format($c['totalcount'], 0); ?></td>
                    <td><?php echo number_format($c['totalamt'],   0); ?></td>
                    <td><?php echo number_format($c['cbsent'],     0); ?></td>
                    <td><?php echo number_format($c['digitin'],    0); ?></td>
                    <td><?php echo number_format($c['revenue'],    0); ?></td>
                    <td><?php echo number_format($c['profit'],     0); ?></td>
                    <td><?php echo number_format($c['ptotal'],     0); ?></td>
                    <td><?php echo number_format($c['pdigitin'],   0); ?></td>
                    <td><?php echo number_format($c['prevenue'],   0); ?></td>
                    <td><?php echo number_format($c['fixcost'],    0); ?></td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $c['pprofit'] >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($c['pprofit'], 0); ?>
                    </td>
                    <td style="color:#fff;font-weight:bold;background:<?php echo $c['growth'] >= 0 ? '#68d391' : '#fc8181'; ?>;">
                        <?php echo number_format($c['growth'], 0) . '%'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#4a5568; color:#fff; font-weight:bold; text-align:center;">
                    <td>Grand Total</td>
                    <td><?php echo number_format($totals['act'],          0); ?></td>
                    <td><?php echo number_format($totals['actamount'],    0); ?></td>
                    <td><?php echo number_format($totals['renewcount'],   0); ?></td>
                    <td><?php echo number_format($totals['renewamount'],  0); ?></td>
                    <td><?php echo number_format($totals['totalcount'],   0); ?></td>
                    <td><?php echo number_format($totals['totalamount'],  0); ?></td>
                    <td><?php echo number_format($totals['cbsent'],       0); ?></td>
                    <td><?php echo number_format($totals['digiinvest'],   0); ?></td>
                    <td><?php echo number_format($totals['revenueshare'], 0); ?></td>
                    <td><?php echo number_format($totals['profit'],       0); ?></td>
                    <td><?php echo number_format($totals['ptotal'],       0); ?></td>
                    <td><?php echo number_format($totals['pdigitin'],     0); ?></td>
                    <td><?php echo number_format($totals['prevenue'],     0); ?></td>
                    <td><?php echo number_format($totals['fixcost'],      0); ?></td>
                    <td><?php echo number_format($totals['pprofit'],      0); ?></td>
                    <td><?php echo number_format($total_growth,           0) . '%'; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
}
