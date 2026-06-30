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
    case 'contest_data':             action_contest_data($con);             break;
    case 'contest_charging_data':    action_contest_charging_data($con);    break;
    case 'promotion_data':           action_promotion_data($con);           break;
    case 'engagement_data':          action_engagement_data($con);          break;
    case 'api_report_data':          action_api_report_data();              break;
    case 'apicharge_data':               action_apicharge_data();                   break;
    case 'activation_setting_load':      action_activation_setting_load($con);      break;
    case 'activation_setting_update':    action_activation_setting_update($con);    break;
    case 'callback_setting_load':        action_callback_setting_load($con);        break;
    case 'callback_setting_update':      action_callback_setting_update($con);      break;
    case 'currency_load':                action_currency_load($con);                break;
    case 'currency_update':             action_currency_update($con);              break;
    case 'callback_report_load':        action_callback_report_load($con);         break;
    case 'callback_report_operators':   action_callback_report_operators($con);    break;
    case 'callback_report_advertisers': action_callback_report_advertisers($con);  break;
    case 'uat_add':                     action_uat_add($con);                      break;
    case 'uat_countries':               action_uat_countries($con);                break;
    case 'uat_load':                    action_uat_load($con);                     break;
    case 'checkactivation_load':        action_checkactivation_load($con);         break;
    case 'urlmake_operators':            action_urlmake_operators($con);            break;
    case 'urlmake_advertisers':      action_urlmake_advertisers($con);      break;
    case 'urlmake_generate':         action_urlmake_generate($con);         break;
    case 'dashboard_data':           action_dashboard_data($con);           break;
    case 'gamezop_partners':         action_gamezop_partners($con);         break;
    case 'gamezop_report_load':      action_gamezop_report_load($con);      break;
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
        'pinconfirmed' => 'perform_centtocg',
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
                <tr style="text-align:center;">
                    <th style="text-align:center;">Date</th>
                    <?php foreach ($advname as $adv): ?>
                    <th style="text-align:center;"><?php echo htmlspecialchars($adv); ?></th>
                    <?php endforeach; ?>
                    <th style="text-align:center;"><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dt as $date => $vals):
                    $sum = 0;
                ?>
                <tr style="text-align:center;">
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
        echo '<div class="hp-card" style="margin-top:16px">
                <div class="hp-card-body" style="padding:60px;text-align:center">
                    <i class="fa fa-bar-chart" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                    <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No Data Available</p>
                    <p style="color:#cbd5e0;font-size:13px;margin:0">No trend data found for the selected filters.<br>Try changing the date range, product, or operator.</p>
                </div>
              </div>';
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
        echo '<div class="hp-card" style="margin-top:16px">
                <div class="hp-card-body" style="padding:60px;text-align:center">
                    <i class="fa fa-bar-chart" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                    <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No Data Available</p>
                    <p style="color:#cbd5e0;font-size:13px;margin:0">No trend data found for the selected filters.<br>Try changing the date range, product, or operator.</p>
                </div>
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
                <?php foreach (array_keys($dt) as $date):
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
                    <th class="text-center">ID</th>
                    <th class="text-center">Product</th>
                    <th class="text-center">Operator</th>
                    <th class="text-center">Activation</th>
                    <th class="text-center">Renewal</th>
                    <th class="text-center">Callback Sent</th>
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
// ACTION: Contest Leaderboard data table
// Called by: contest.php  →  POST ajax/handler.php?action=contest_data
// POST params: country (qa|bh), group (day|all), msisdn (optional)
// ═══════════════════════════════════════════════════════════════════════════════
function action_contest_data(mysqli $con): void
{
    $country = trim($_POST['country'] ?? 'qa');
    $group   = trim($_POST['group']   ?? 'day');
    $msisdn  = trim($_POST['msisdn']  ?? '');

    // Whitelist country and group
    $db    = ($country === 'bh') ? 'contestdb_bh' : 'contestdb_qaoo';
    $group = ($group === 'all')  ? 'all'           : 'day';

    // When an MSISDN filter is given, force day-level grouping
    $condition = '';
    if ($msisdn !== '') {
        $condition = "msisdn = '" . mysqli_real_escape_string($con, $msisdn) . "' AND ";
        $group     = 'day';
    }

    if ($group === 'day') {
        $sql = "
            SELECT msisdn,
                   SUM(CASE WHEN result = 'wrong'                    THEN c ELSE 0 END) AS wrong,
                   SUM(CASE WHEN result = 'correct'                  THEN c ELSE 0 END) AS correct,
                   SUM(CASE WHEN result = 'missed' OR result = ''    THEN c ELSE 0 END) AS missed,
                   dt
            FROM (
                SELECT msisdn, COUNT(*) AS c, result, DATE(answerdatetime) dt
                FROM {$db}.contestlog
                WHERE {$condition}
                      msisdn IN (
                          SELECT msisdn FROM {$db}.subscriber
                          WHERE subscriberid IN (
                              SELECT MAX(subscriberid) FROM {$db}.subscriber GROUP BY msisdn
                          ) AND charging_mode != 'dct'
                      )
                GROUP BY msisdn, result, dt
            ) sub
            GROUP BY msisdn, dt
            ORDER BY msisdn DESC";
    } else {
        $sql = "
            SELECT msisdn,
                   SUM(CASE WHEN result = 'wrong'                    THEN c ELSE 0 END) AS wrong,
                   SUM(CASE WHEN result = 'correct'                  THEN c ELSE 0 END) AS correct,
                   SUM(CASE WHEN result = 'missed' OR result = ''    THEN c ELSE 0 END) AS missed
            FROM (
                SELECT msisdn, COUNT(*) AS c, result
                FROM {$db}.contestlog
                WHERE {$condition}
                      msisdn IN (
                          SELECT msisdn FROM {$db}.subscriber
                          WHERE subscriberid IN (
                              SELECT MAX(subscriberid) FROM {$db}.subscriber GROUP BY msisdn
                          ) AND charging_mode != 'dct'
                      )
                GROUP BY msisdn, result
            ) sub
            GROUP BY msisdn";
    }

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Query failed. Please try again.
              </div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected filters.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-trophy"></i> Contest Leaderboard
            <small style="font-size:12px;font-weight:400;color:#a0aec0;margin-left:10px;">
                <?php echo strtoupper(htmlspecialchars($country)); ?> &middot;
                <?php echo $group === 'day' ? 'By Day' : 'All Time'; ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="contest-table" class="table table-striped table-bordered" style="font-size:13px;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th>MSISDN</th>
                    <?php if ($group === 'day'): ?><th>Date</th><?php endif; ?>
                    <th>Correct</th>
                    <th>Wrong</th>
                    <th>Missed</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $correct_sum = $wrong_sum = $missed_sum = $total_sum = 0;
                foreach ($rows as $r):
                    $c           = (int)$r['correct'];
                    $correct_sum += $c;
                    $wrong_sum   += (int)$r['wrong'];
                    $missed_sum  += (int)$r['missed'];
                    $scoreVal    = $group === 'day' ? $c * 10 : $c * 10 + 100;
                    $total_sum   += $scoreVal;
                    $scoreText   = $group === 'day'
                        ? (string)($c * 10)
                        : ($c * 10) . ' + 100(Bonus) = ' . ($c * 10 + 100);
                    $correctStyle = $c === 5 ? ' style="background:blueviolet;color:#fff;font-weight:bold;"' : '';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['msisdn']); ?></td>
                    <?php if ($group === 'day'): ?>
                    <td><?php echo date('d-m-Y', strtotime($r['dt'])); ?></td>
                    <?php endif; ?>
                    <td<?php echo $correctStyle; ?>><?php echo $c; ?></td>
                    <td><?php echo (int)$r['wrong']; ?></td>
                    <td><?php echo (int)$r['missed']; ?></td>
                    <td><?php echo $scoreText; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if ($msisdn !== ''): ?>
            <tfoot>
                <tr style="font-weight:bold;background:#f0f4ff;">
                    <td>Total</td>
                    <?php if ($group === 'day'): ?><td></td><?php endif; ?>
                    <td><?php echo number_format($correct_sum); ?></td>
                    <td><?php echo number_format($wrong_sum); ?></td>
                    <td><?php echo number_format($missed_sum); ?></td>
                    <td><?php echo number_format($correct_sum * 10) . ' + 100(Bonus) = ' . number_format($correct_sum * 10 + 100); ?></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Contest Charging Report data table
// Called by: contest_charging.php  →  POST ajax/handler.php?action=contest_charging_data
// POST params: country (qa|bh), start_date (d-m-Y), end_date (d-m-Y)
// ═══════════════════════════════════════════════════════════════════════════════
function action_contest_charging_data(mysqli $con): void
{
    $country   = trim($_POST['country']    ?? 'qa');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    // Whitelist country
    $db = ($country === 'bh') ? 'contestdb_bh' : 'contestdb_qaoo';

    // Parse dates (picker sends d-m-Y)
    $dtStart = DateTime::createFromFormat('d-m-Y', $start_raw);
    $dtEnd   = DateTime::createFromFormat('d-m-Y', $end_raw);
    if (!$dtStart || !$dtEnd) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid date format. Please use the date picker.</div>';
        return;
    }

    $startdate = $dtStart->format('Y-m-d') . ' 00:00:00';
    $enddate   = $dtEnd->format('Y-m-d')   . ' 23:59:59';

    $sql = "
        SELECT dt,
               SUM(act)        AS act,
               SUM(actamnt)    AS actamnt,
               SUM(ren)        AS ren,
               SUM(renamnt)    AS renamnt,
               SUM(oneshot)    AS oneshot,
               SUM(oneshotamt) AS oneshotamt
        FROM (
            SELECT COUNT(DISTINCT msisdn) AS act, SUM(amount) AS actamnt,
                   0 AS ren, 0 AS renamnt, 0 AS oneshot, 0 AS oneshotamt,
                   DATE(subscriptionstartdate) AS dt
            FROM {$db}.subscriber
            WHERE subscriptionstartdate >= '{$startdate}'
              AND subscriptionstartdate <= '{$enddate}'
              AND charging_mode = 'act'
            GROUP BY dt
            UNION ALL
            SELECT 0 AS act, 0 AS actamnt,
                   COUNT(msisdn) AS ren, SUM(amount) AS renamnt,
                   0 AS oneshot, 0 AS oneshotamt,
                   DATE(subscriptionstartdate) AS dt
            FROM {$db}.subscriber
            WHERE subscriptionstartdate >= '{$startdate}'
              AND subscriptionstartdate <= '{$enddate}'
              AND charging_mode = 'ren'
            GROUP BY dt
            UNION ALL
            SELECT 0 AS act, 0 AS actamnt,
                   0 AS ren, 0 AS renamnt,
                   COUNT(msisdn) AS oneshot, SUM(amount) AS oneshotamt,
                   DATE(subscriptionstartdate) AS dt
            FROM {$db}.subscriber
            WHERE subscriptionstartdate >= '{$startdate}'
              AND subscriptionstartdate <= '{$enddate}'
              AND charging_mode = 'oneshot'
            GROUP BY dt
        ) a
        GROUP BY dt
        ORDER BY dt ASC
    ";

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Query failed. Please try again.
              </div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        return;
    }

    $act_sum = $ren_sum = $oneshot_sum = 0;
    $actamt_sum = $renamt_sum = $oneshotamt_sum = $total_amt = 0.0;
    foreach ($rows as $r) {
        $act_sum        += (int)$r['act'];
        $ren_sum        += (int)$r['ren'];
        $oneshot_sum    += (int)$r['oneshot'];
        $actamt_sum     += (float)$r['actamnt'];
        $renamt_sum     += (float)$r['renamnt'];
        $oneshotamt_sum += (float)$r['oneshotamt'];
        $total_amt      += (float)$r['actamnt'] + (float)$r['renamnt'] + (float)$r['oneshotamt'];
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-credit-card"></i> Charging Report
            <small style="font-size:12px;font-weight:400;color:#a0aec0;margin-left:10px;">
                <?php echo strtoupper(htmlspecialchars($country)); ?> &middot;
                <?php echo $dtStart->format('d M Y'); ?> – <?php echo $dtEnd->format('d M Y'); ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="charging-table" class="table table-striped table-bordered" style="font-size:13px;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th>Date</th>
                    <th>Activation</th>
                    <th>Act. Amount</th>
                    <th>Renewal</th>
                    <th>Ren. Amount</th>
                    <th>OneShot</th>
                    <th>OneShot Amt</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['dt']); ?></td>
                    <td><?php echo number_format((int)$r['act']); ?></td>
                    <td><?php echo number_format((float)$r['actamnt'], 2); ?></td>
                    <td><?php echo number_format((int)$r['ren']); ?></td>
                    <td><?php echo number_format((float)$r['renamnt'], 2); ?></td>
                    <td><?php echo number_format((int)$r['oneshot']); ?></td>
                    <td><?php echo number_format((float)$r['oneshotamt'], 2); ?></td>
                    <td><?php echo number_format((float)$r['actamnt'] + (float)$r['renamnt'] + (float)$r['oneshotamt'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#4a5568;color:#fff;text-align:center;">
                    <td>Total</td>
                    <td><?php echo number_format($act_sum); ?></td>
                    <td><?php echo number_format($actamt_sum, 2); ?></td>
                    <td><?php echo number_format($ren_sum); ?></td>
                    <td><?php echo number_format($renamt_sum, 2); ?></td>
                    <td><?php echo number_format($oneshot_sum); ?></td>
                    <td><?php echo number_format($oneshotamt_sum, 2); ?></td>
                    <td><?php echo number_format($total_amt, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: API Report data
// Called by: api.php  →  POST ajax/handler.php?action=api_report_data
// POST params: country, advpb (advertiser|publisher), start_date (d-m-Y), end_date (d-m-Y)
// Returns: HTML table
// ═══════════════════════════════════════════════════════════════════════════════
function action_api_report_data(): void
{
    // Own connection — same host/credentials as connection_jay.php
    $con = new mysqli(DB_PROD_HOST, DB_USER, DB_PASS, '', (int)DB_PROD_PORT);
    if ($con->connect_errno) {
        echo '<div style="padding:50px;text-align:center;color:#e53e3e">
                <i class="fa fa-server" style="font-size:38px;display:block;margin-bottom:14px"></i>
                <strong>Production database not reachable.</strong>
                <div style="margin-top:8px;font-size:12px;color:#718096;">'
                . htmlspecialchars($con->connect_error) .
                '</div>
              </div>';
        return;
    }

    $allowed_countries = ['sa','ae','om','kw','ps','iq','qa','pl','bh'];
    $allowed_advpb     = ['advertiser','publisher'];

    $country   = trim($_POST['country']    ?? 'sa');
    $advpb     = trim($_POST['advpb']      ?? 'advertiser');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    if (!in_array($country, $allowed_countries, true)) $country = 'sa';
    if (!in_array($advpb,   $allowed_advpb,     true)) $advpb   = 'advertiser';

    $db = 'fashionbardb_airg_' . $country;

    $dtStart = DateTime::createFromFormat('d-m-Y', $start_raw);
    $dtEnd   = DateTime::createFromFormat('d-m-Y', $end_raw);
    if (!$dtStart || !$dtEnd) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid date format. Please use the date picker.</div>';
        return;
    }

    $startdate = $dtStart->format('Y-m-d') . ' 00:00:00';
    $enddate   = $dtEnd->format('Y-m-d')   . ' 23:59:59';

    $union_cols_adv = "dt, operator, advertiserid, partner";
    $union_cols_pub = "dt, operator, advertiserid";

    if ($advpb === 'advertiser') {
        $sql = "
            SELECT dt, SUM(clicks) AS clicks, SUM(uniq) AS uniq, SUM(pg) AS pg,
                   SUM(pv) AS pv, SUM(act) AS act, SUM(cbs) AS cbs,
                   operator, advname, partner
            FROM (
                SELECT dt, SUM(clicks) AS clicks, SUM(uniq) AS uniq, SUM(pg) AS pg,
                       SUM(pv) AS pv, SUM(act) AS act, SUM(cbs) AS cbs,
                       operator, advertiserid, partner
                FROM (
                    SELECT COUNT(DISTINCT clickid) AS clicks, 0 AS uniq, 0 AS pg, 0 AS pv, 0 AS act, 0 AS cbs,
                           DATE(accesstime) AS dt, operator, advertiserid, partner
                    FROM {$db}.userlog
                    WHERE accesstime >= '{$startdate}' AND accesstime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid, partner
                    UNION ALL
                    SELECT 0, COUNT(DISTINCT msisdn) AS uniq, 0, 0, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid, partner
                    FROM {$db}.requestpin
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid, partner
                    UNION ALL
                    SELECT 0, 0, COUNT(DISTINCT msisdn) AS pg, 0, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid, partner
                    FROM {$db}.requestpin
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                      AND (status = 'success' OR status = 'SUCCESS')
                    GROUP BY dt, operator, advertiserid, partner
                    UNION ALL
                    SELECT 0, 0, 0, COUNT(DISTINCT msisdn) AS pv, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid, partner
                    FROM {$db}.pinverify
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid, partner
                    UNION ALL
                    SELECT 0, 0, 0, 0, COUNT(DISTINCT msisdn) AS act, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid, partner
                    FROM {$db}.pinverify
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                      AND (status = 'success' OR status = 'pending')
                    GROUP BY dt, operator, advertiserid, partner
                    UNION ALL
                    SELECT 0, 0, 0, 0, 0, COUNT(DISTINCT msisdn) AS cbs,
                           DATE(advertdatetime) AS dt, operator, advertiserid, partner
                    FROM {$db}.advertcallback
                    WHERE advertdatetime >= '{$startdate}' AND advertdatetime <= '{$enddate}'
                      AND advertresponse != 'stop' AND action = 'cg'
                    GROUP BY dt, operator, advertiserid, partner
                ) a
                GROUP BY dt, operator, advertiserid, partner
            ) a
            INNER JOIN advertiserdb.advertiser ON a.advertiserid = advertiser.advertiserid
            GROUP BY dt, operator, advname, partner
            ORDER BY dt ASC
        ";
    } else {
        $sql = "
            SELECT dt, SUM(clicks) AS clicks, SUM(uniq) AS uniq, SUM(pg) AS pg,
                   SUM(pv) AS pv, SUM(act) AS act, SUM(cbs) AS cbs,
                   operator, advname
            FROM (
                SELECT dt, SUM(clicks) AS clicks, SUM(uniq) AS uniq, SUM(pg) AS pg,
                       SUM(pv) AS pv, SUM(act) AS act, SUM(cbs) AS cbs,
                       operator, advertiserid
                FROM (
                    SELECT COUNT(DISTINCT clickid) AS clicks, 0 AS uniq, 0 AS pg, 0 AS pv, 0 AS act, 0 AS cbs,
                           DATE(accesstime) AS dt, operator, advertiserid
                    FROM {$db}.userlog
                    WHERE accesstime >= '{$startdate}' AND accesstime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid
                    UNION ALL
                    SELECT 0, COUNT(DISTINCT msisdn) AS uniq, 0, 0, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid
                    FROM {$db}.requestpin
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid
                    UNION ALL
                    SELECT 0, 0, COUNT(DISTINCT msisdn) AS pg, 0, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid
                    FROM {$db}.requestpin
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                      AND (status = 'success' OR status = 'SUCCESS')
                    GROUP BY dt, operator, advertiserid
                    UNION ALL
                    SELECT 0, 0, 0, COUNT(DISTINCT msisdn) AS pv, 0, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid
                    FROM {$db}.pinverify
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                    GROUP BY dt, operator, advertiserid
                    UNION ALL
                    SELECT 0, 0, 0, 0, COUNT(DISTINCT msisdn) AS act, 0,
                           DATE(pindatetime) AS dt, operator, advertiserid
                    FROM {$db}.pinverify
                    WHERE pindatetime >= '{$startdate}' AND pindatetime <= '{$enddate}'
                      AND (status = 'success' OR status = 'pending')
                    GROUP BY dt, operator, advertiserid
                    UNION ALL
                    SELECT 0, 0, 0, 0, 0, COUNT(DISTINCT msisdn) AS cbs,
                           DATE(advertdatetime) AS dt, operator, advertiserid
                    FROM {$db}.advertcallback
                    WHERE advertdatetime >= '{$startdate}' AND advertdatetime <= '{$enddate}'
                      AND advertresponse != 'stop' AND action = 'cg'
                    GROUP BY dt, operator, advertiserid
                ) a
                GROUP BY dt, operator, advertiserid
            ) a
            INNER JOIN advertiserdb.advertiser ON a.advertiserid = advertiser.advertiserid
            GROUP BY dt, operator, advname
            ORDER BY dt ASC
        ";
    }

    $res = mysqli_query($con, $sql);
    if (!$res) {
        $err = mysqli_error($con);
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                <strong>Query failed.</strong>
                <div style="margin-top:10px;font-size:12px;color:#718096;word-break:break-all;">'
                . htmlspecialchars($err) .
                '</div>
              </div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        return;
    }

    $clicks_sum = $uniq_sum = $pg_sum = $pv_sum = $act_sum = $cbs_sum = 0;
    foreach ($rows as $r) {
        $clicks_sum += (int)$r['clicks'];
        $uniq_sum   += (int)$r['uniq'];
        $pg_sum     += (int)$r['pg'];
        $pv_sum     += (int)$r['pv'];
        $act_sum    += (int)$r['act'];
        $cbs_sum    += (int)$r['cbs'];
    }
    $is_adv = ($advpb === 'advertiser');
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-plug"></i> API Report
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo strtoupper(htmlspecialchars($country)); ?> &middot;
                <?php echo ucfirst(htmlspecialchars($advpb)); ?> &middot;
                <?php echo $dtStart->format('d M Y'); ?> – <?php echo $dtEnd->format('d M Y'); ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="api-table" class="table table-striped table-bordered" style="font-size:12px;margin:0;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Publisher</th>
                    <?php if ($is_adv): ?><th style="text-align:center;">Advertiser</th><?php endif; ?>
                    <th style="text-align:center;">Clicks</th>
                    <th style="text-align:center;">UClicks</th>
                    <th style="text-align:center;">PG</th>
                    <th style="text-align:center;">PV</th>
                    <th style="text-align:center;">Operator</th>
                    <th style="text-align:center;">Activation</th>
                    <th style="text-align:center;">ACR%</th>
                    <th style="text-align:center;">CBS</th>
                    <th style="text-align:center;">CR%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r):
                    $pv  = (int)$r['pv'];
                    $act = (int)$r['act'];
                    $cbs = (int)$r['cbs'];
                    $acr = $pv > 0 ? number_format(($act / $pv) * 100, 2) . '%' : '0.00%';
                    $cr  = $pv > 0 ? number_format(($cbs / $pv) * 100, 2) . '%' : '0.00%';
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($r['dt'])); ?></td>
                    <td style="text-align:center;"><?php echo htmlspecialchars(ucfirst($r['advname'])); ?></td>
                    <?php if ($is_adv): ?>
                    <td style="text-align:center;"><?php echo htmlspecialchars(ucfirst($r['partner'] ?? '')); ?></td>
                    <?php endif; ?>
                    <td style="text-align:center;"><?php echo number_format((int)$r['clicks']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['uniq']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['pg']); ?></td>
                    <td style="text-align:center;"><?php echo number_format($pv); ?></td>
                    <td style="text-align:center;"><?php echo htmlspecialchars($r['operator']); ?></td>
                    <td style="text-align:center;"><?php echo number_format($act); ?></td>
                    <td style="text-align:center;"><?php echo $acr; ?></td>
                    <td style="text-align:center;"><?php echo number_format($cbs); ?></td>
                    <td style="text-align:center;"><?php echo $cr; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#4a5568;color:#fff;text-align:center;">
                    <td>Total</td>
                    <td></td>
                    <?php if ($is_adv): ?><td></td><?php endif; ?>
                    <td><?php echo number_format($clicks_sum); ?></td>
                    <td><?php echo number_format($uniq_sum); ?></td>
                    <td><?php echo number_format($pg_sum); ?></td>
                    <td><?php echo number_format($pv_sum); ?></td>
                    <td></td>
                    <td><?php echo number_format($act_sum); ?></td>
                    <td><?php echo $pv_sum > 0 ? number_format(($act_sum / $pv_sum) * 100, 2) . '%' : '0.00%'; ?></td>
                    <td><?php echo number_format($cbs_sum); ?></td>
                    <td><?php echo $pv_sum > 0 ? number_format(($cbs_sum / $pv_sum) * 100, 2) . '%' : '0.00%'; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
    $con->close();
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: API Charging % data
// Called by: apicharge.php  →  POST ajax/handler.php?action=apicharge_data
// POST params: country (full db name), start_date (d-m-Y), end_date (d-m-Y)
// Returns: HTML table
// ═══════════════════════════════════════════════════════════════════════════════
function action_apicharge_data(): void
{
    // Own connection — same as connection_jay.php / action_api_report_data
    $con = new mysqli(DB_PROD_HOST, DB_USER, DB_PASS, '', (int)DB_PROD_PORT);
    if ($con->connect_errno) {
        echo '<div style="padding:50px;text-align:center;color:#e53e3e">
                <i class="fa fa-server" style="font-size:38px;display:block;margin-bottom:14px"></i>
                <strong>Production database not reachable.</strong>
                <div style="margin-top:8px;font-size:12px;color:#718096;">'
                . htmlspecialchars($con->connect_error) .
                '</div>
              </div>';
        return;
    }

    $allowed_dbs = [
        'fashionbardb_etisalat',  'fashionbardb_omooredoo',
        'fashionbardb_omantel',   'fashionbardb_kwoo',
        'fashionbardb_psjw',      'fashionbardb_psoo',
        'gamebar_iqmw_api',       'fashionbardb_qatarooredoo',
        'fashionbardb_qatarvodafone', 'fashionbardb_safaricom_new',
        'fashionbardb_safaricompkm',
    ];

    $db        = trim($_POST['country']    ?? '');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    if (!in_array($db, $allowed_dbs, true)) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid country selection.</div>';
        $con->close(); return;
    }

    $dtStart = DateTime::createFromFormat('d-m-Y', $start_raw);
    $dtEnd   = DateTime::createFromFormat('d-m-Y', $end_raw);
    if (!$dtStart || !$dtEnd) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid date format. Please use the date picker.</div>';
        $con->close(); return;
    }

    $startdate = $dtStart->format('Y-m-d') . ' 00:00:00';
    $enddate   = $dtEnd->format('Y-m-d')   . ' 23:59:59';

    if ($db === 'fashionbardb_psjw' || $db === 'fashionbardb_psoo') {
        $sql = "
            SELECT advname, SUM(c) AS cg, SUM(b) AS act
            FROM (
                SELECT COUNT(a.msisdn) c, COUNT(b.msisdn) b, a.advertiserid
                FROM (
                    SELECT DISTINCT msisdn, advertiserid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND subscriptionstartdate <= '{$enddate}'
                      AND (charging_mode = 'act' OR charging_mode = 'low')
                ) a
                LEFT JOIN (
                    SELECT DISTINCT msisdn, advertiserid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND (charging_mode = 'act' OR charging_mode = 'ren')
                ) b ON a.msisdn = b.msisdn
                GROUP BY advertiserid
            ) aa
            INNER JOIN advertiserdb.advertiser ON advertiser.advertiserid = aa.advertiserid
            GROUP BY advname
        ";
    } elseif ($db === 'gamebar_iqmw_api') {
        $sql = "
            SELECT advname, SUM(c) AS cg, SUM(b) AS act
            FROM (
                SELECT COUNT(a.msisdn) c, COUNT(b.msisdn) b, a.advid AS advertiserid
                FROM (
                    SELECT DISTINCT msisdn, advid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND subscriptionstartdate <= '{$enddate}'
                      AND charging_mode = 'trial'
                ) a
                LEFT JOIN (
                    SELECT DISTINCT msisdn, advid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND (charging_mode = 'act' OR (charging_mode = 'ren' AND amount > 0))
                ) b ON a.msisdn = b.msisdn
                GROUP BY a.advid
            ) aa
            INNER JOIN advertiserdb.advertiser ON advertiser.advertiserid = aa.advertiserid
            GROUP BY advname
        ";
    } else {
        $sql = "
            SELECT advname, SUM(c) AS cg, SUM(b) AS act
            FROM (
                SELECT COUNT(a.msisdn) c, COUNT(b.msisdn) b, a.advertiserid
                FROM (
                    SELECT DISTINCT msisdn, advertiserid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND subscriptionstartdate <= '{$enddate}'
                      AND charging_mode = 'cg'
                ) a
                LEFT JOIN (
                    SELECT DISTINCT msisdn, advertiserid
                    FROM {$db}.subscriber
                    WHERE subscriptionstartdate >= '{$startdate}'
                      AND (charging_mode = 'act' OR charging_mode = 'ren')
                ) b ON a.msisdn = b.msisdn
                GROUP BY advertiserid
            ) aa
            INNER JOIN advertiserdb.advertiser ON advertiser.advertiserid = aa.advertiserid
            GROUP BY advname
        ";
    }

    $res = mysqli_query($con, $sql);
    if (!$res) {
        $err = mysqli_error($con);
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                <strong>Query failed.</strong>
                <div style="margin-top:10px;font-size:12px;color:#718096;word-break:break-all;">'
                . htmlspecialchars($err) .
                '</div>
              </div>';
        $con->close(); return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        $con->close(); return;
    }

    $cg_sum = $act_sum = 0;
    foreach ($rows as $r) {
        $cg_sum  += (int)$r['cg'];
        $act_sum += (int)$r['act'];
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-percent"></i> API Charging %
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo htmlspecialchars($db); ?> &middot;
                <?php echo $dtStart->format('d M Y'); ?> – <?php echo $dtEnd->format('d M Y'); ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="apicharge-table" class="table table-striped table-bordered" style="font-size:13px;margin:0;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th style="text-align:center;">Publisher</th>
                    <th style="text-align:center;">CG</th>
                    <th style="text-align:center;">Charged</th>
                    <th style="text-align:center;">%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r):
                    $cg  = (int)$r['cg'];
                    $act = (int)$r['act'];
                    $pct = $cg > 0 ? number_format(($act / $cg) * 100, 2) . '%' : '0.00%';
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo htmlspecialchars(ucfirst($r['advname'])); ?></td>
                    <td style="text-align:center;"><?php echo number_format($cg); ?></td>
                    <td style="text-align:center;"><?php echo number_format($act); ?></td>
                    <td style="text-align:center;"><?php echo $pct; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#4a5568;color:#fff;text-align:center;">
                    <td>Total</td>
                    <td><?php echo number_format($cg_sum); ?></td>
                    <td><?php echo number_format($act_sum); ?></td>
                    <td><?php echo $cg_sum > 0 ? number_format(($act_sum / $cg_sum) * 100, 2) . '%' : '0.00%'; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
    $con->close();
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Engagement Activity data
// Called by: engagement.php  →  POST ajax/handler.php?action=engagement_data
// POST params: country, start_date (d-m-Y), end_date (d-m-Y)
// Returns: HTML table
// ═══════════════════════════════════════════════════════════════════════════════
function action_engagement_data(mysqli $con): void
{
    $country   = trim($_POST['country']    ?? 'qa');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    $db = ($country === 'bh') ? 'contestdb_bh' : 'contestdb_qaoo';

    $dtStart = DateTime::createFromFormat('d-m-Y', $start_raw);
    $dtEnd   = DateTime::createFromFormat('d-m-Y', $end_raw);
    if (!$dtStart || !$dtEnd) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid date format. Please use the date picker.</div>';
        return;
    }

    $startdate = $dtStart->format('Y-m-d') . ' 00:00:00';
    $enddate   = $dtEnd->format('Y-m-d')   . ' 23:59:59';

    $sql = "
        SELECT SUM(promo) AS promo, SUM(act) AS act, dt
        FROM (
            SELECT COUNT(msisdn) AS promo, 0 AS act,
                   DATE(mtdatetime) AS dt
            FROM {$db}.mt
            WHERE status = 'success'
              AND response LIKE '%ENGAGEMENT%'
              AND mtdatetime >= '{$startdate}'
              AND mtdatetime <= '{$enddate}'
            GROUP BY dt
            UNION ALL
            SELECT 0 AS promo, COUNT(msisdn) AS act,
                   DATE(answerdatetime) AS dt
            FROM {$db}.contestlog
            WHERE engagement = 'engagement'
              AND result != ''
              AND answerdatetime >= '{$startdate}'
              AND answerdatetime <= '{$enddate}'
            GROUP BY dt
        ) a
        GROUP BY dt
        ORDER BY dt ASC
    ";

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Query failed. Please try again.
              </div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        return;
    }

    $promo_sum  = $act_sum = 0;
    $amount_sum = 0.0;
    foreach ($rows as $r) {
        $promo_sum  += (int)$r['promo'];
        $act_sum    += (int)$r['act'];
        $amount_sum += (int)$r['act'] * 0.20;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-comments"></i> Engagement Activity
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo strtoupper(htmlspecialchars($country)); ?> &middot;
                <?php echo $dtStart->format('d M Y'); ?> – <?php echo $dtEnd->format('d M Y'); ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="engage-table" class="table table-striped table-bordered" style="font-size:13px;margin:0;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Engagement</th>
                    <th style="text-align:center;">SMS Played</th>
                    <th style="text-align:center;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td style="text-align:center;"><?php echo htmlspecialchars($r['dt']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['promo']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['act']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['act'] * 0.20, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#4a5568;color:#fff;text-align:center;">
                    <td>Total</td>
                    <td><?php echo number_format($promo_sum); ?></td>
                    <td><?php echo number_format($act_sum); ?></td>
                    <td><?php echo number_format($amount_sum, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Promotional Activity data
// Called by: promotion.php  →  POST ajax/handler.php?action=promotion_data
// POST params: country, start_date (d-m-Y), end_date (d-m-Y)
// Returns: HTML table
// ═══════════════════════════════════════════════════════════════════════════════
function action_promotion_data(mysqli $con): void
{
    $country   = trim($_POST['country']    ?? 'qa');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    $db = ($country === 'bh') ? 'contestdb_bh' : 'contestdb_qaoo';

    $dtStart = DateTime::createFromFormat('d-m-Y', $start_raw);
    $dtEnd   = DateTime::createFromFormat('d-m-Y', $end_raw);
    if (!$dtStart || !$dtEnd) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">Invalid date format. Please use the date picker.</div>';
        return;
    }

    $startdate = $dtStart->format('Y-m-d') . ' 00:00:00';
    $enddate   = $dtEnd->format('Y-m-d')   . ' 23:59:59';

    $sql = "
        SELECT SUM(promocount) AS promo, SUM(subcount) AS act, dt
        FROM (
            SELECT COUNT(DISTINCT msisdn) AS promocount, 0 AS subcount,
                   DATE(mtdatetime) AS dt
            FROM {$db}.promotions
            WHERE status = 'success'
              AND mtdatetime >= '{$startdate}'
              AND mtdatetime <= '{$enddate}'
            GROUP BY dt
            UNION ALL
            SELECT 0 AS promocount, COUNT(promotions.msisdn) AS subcount,
                   DATE(mtdatetime) AS dt
            FROM {$db}.promotions
            INNER JOIN {$db}.subscriber ON promotions.msisdn = subscriber.msisdn
            WHERE charging_mode = 'optin'
              AND mtdatetime >= '{$startdate}'
              AND mtdatetime <= '{$enddate}'
              AND subscriptionstartdate >= '{$startdate}'
              AND subscriptionstartdate <= '{$enddate}'
            GROUP BY dt
        ) a
        GROUP BY dt
        ORDER BY dt ASC
    ";

    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <i class="fa fa-exclamation-circle" style="font-size:32px;display:block;margin-bottom:10px"></i>
                Query failed. Please try again.
              </div>';
        return;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No records found for the selected period.</p>
              </div>';
        return;
    }

    $promo_sum = $act_sum = 0;
    foreach ($rows as $r) {
        $promo_sum += (int)$r['promo'];
        $act_sum   += (int)$r['act'];
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-bullhorn"></i> Promotional Activity
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo strtoupper(htmlspecialchars($country)); ?> &middot;
                <?php echo $dtStart->format('d M Y'); ?> – <?php echo $dtEnd->format('d M Y'); ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">
        <table id="promo-table" class="table table-striped table-bordered" style="font-size:13px;margin:0;">
            <thead style="background:#4a5568;color:#fff;text-align:center;">
                <tr>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Promotions</th>
                    <th style="text-align:center;">Activation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td style="text-align:center;"><?php echo htmlspecialchars($r['dt']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['promo']); ?></td>
                    <td style="text-align:center;"><?php echo number_format((int)$r['act']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#4a5568;color:#fff;text-align:center;">
                    <td>Total</td>
                    <td><?php echo number_format($promo_sum); ?></td>
                    <td><?php echo number_format($act_sum); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: URL Maker — operator list for a product
// Called by: urlmake.php  →  POST ajax/handler.php?action=urlmake_operators
// POST params: product
// Returns: JSON string[]
// ═══════════════════════════════════════════════════════════════════════════════
function action_urlmake_operators(mysqli $con): void
{
    header('Content-Type: application/json');
    $product = trim($_POST['product'] ?? '');
    if (!$product) { echo json_encode([]); return; }

    $stmt = $con->prepare(
        'SELECT DISTINCT operatorname
         FROM gamebardb_vodafone_qatar_report.operatorurls
         WHERE product=? ORDER BY operatorname ASC'
    );
    if (!$stmt) { echo json_encode([]); return; }
    $stmt->bind_param('s', $product);
    $stmt->execute();
    $opname = null;
    $stmt->bind_result($opname);
    $ops = [];
    while ($stmt->fetch()) { $ops[] = $opname; }
    $stmt->close();
    echo json_encode($ops);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: URL Maker — advertiser list for a product+operator
// Called by: urlmake.php  →  POST ajax/handler.php?action=urlmake_advertisers
// POST params: product, operator
// Returns: JSON {id, name}[]
// ═══════════════════════════════════════════════════════════════════════════════
function action_urlmake_advertisers(mysqli $con): void
{
    header('Content-Type: application/json');
    $product  = trim($_POST['product']  ?? '');
    $operator = trim($_POST['operator'] ?? '');
    if (!$product || !$operator) { echo json_encode([]); return; }

    $stmt = $con->prepare(
        'SELECT advertiserquery
         FROM gamebardb_vodafone_qatar_report.operatorurls
         WHERE product=? AND operatorname=? LIMIT 1'
    );
    if (!$stmt) { echo json_encode([]); return; }
    $stmt->bind_param('ss', $product, $operator);
    $stmt->execute();
    $aq = null;
    $stmt->bind_result($aq);
    $stmt->fetch();
    $stmt->close();

    if (empty($aq)) { echo json_encode([]); return; }

    $res = mysqli_query($con, $aq);
    $advertisers = [];
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $advertisers[] = ['id' => $row['advertiserid'], 'name' => $row['advname']];
        }
        $res->close();
    }
    echo json_encode($advertisers);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: URL Maker — generate URL for product+operator+advertiser
// Called by: urlmake.php  →  POST ajax/handler.php?action=urlmake_generate
// POST params: product, operator, advertiserid
// Returns: JSON {url, advid, advname} or {error}
// ═══════════════════════════════════════════════════════════════════════════════
function action_urlmake_generate(mysqli $con): void
{
    header('Content-Type: application/json');
    $product      = trim($_POST['product']      ?? '');
    $operator     = trim($_POST['operator']     ?? '');
    $advertiserid = trim($_POST['advertiserid'] ?? '');

    if (!$product || !$operator || !$advertiserid) {
        echo json_encode(['error' => 'All fields are required.']); return;
    }

    $stmt = $con->prepare(
        'SELECT advertiserurl, advertiserwise_query
         FROM gamebardb_vodafone_qatar_report.operatorurls
         WHERE product=? AND operatorname=? LIMIT 1'
    );
    if (!$stmt) { echo json_encode(['error' => 'Database error.']); return; }
    $stmt->bind_param('ss', $product, $operator);
    $stmt->execute();
    $advertiserurl = $advertiserwise_query = null;
    $stmt->bind_result($advertiserurl, $advertiserwise_query);
    $stmt->fetch();
    $stmt->close();

    if (empty($advertiserurl)) {
        echo json_encode(['error' => 'Operator configuration not found.']); return;
    }

    $awQuery = str_replace('[advid]', (int)$advertiserid, (string)$advertiserwise_query);
    $res = mysqli_query($con, $awQuery);
    if (!$res) {
        echo json_encode(['error' => 'Advertiser query failed.']); return;
    }

    $row = mysqli_fetch_assoc($res);
    $res->close();

    if (!$row) {
        echo json_encode(['error' => 'No advertiser data found.']); return;
    }

    $url = str_replace(['[adid]', '[uid]'], [$row['advertiserid'], $row['uid']], $advertiserurl);

    echo json_encode([
        'url'     => $url,
        'advid'   => $row['advertiserid'],
        'advname' => $row['advname']
    ]);
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

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Activation Report Setting — load table
// Called by: activationsetting.php  →  POST ajax/handler.php?action=activation_setting_load
// Returns: HTML table with inline Open/Close dropdowns
// ═══════════════════════════════════════════════════════════════════════════════
function action_activation_setting_load(mysqli $con): void
{
    $sql = "SELECT Product, Country, Action
            FROM gamebardb_vodafone_qatar_report.activationsetting
            ORDER BY Country ASC";
    $res = $con->query($sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <strong>Query failed.</strong>
                <div style="margin-top:8px;font-size:12px;color:#718096">'
             . htmlspecialchars($con->error) .
             '</div></div>';
        return;
    }

    $rows = [];
    while ($row = $res->fetch_assoc()) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No activation settings found.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-toggle-on"></i> Activation Settings
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo count($rows); ?> records
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="overflow-x:auto;">
        <table id="as-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align:center">Product</th>
                    <th style="text-align:center">Country</th>
                    <th style="text-align:center">Action</th>
                    <th style="text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row):
                    $p = htmlspecialchars($row['Product']);
                    $c = htmlspecialchars($row['Country']);
                    $a = htmlspecialchars($row['Action']);
                ?>
                <tr>
                    <td style="text-align:center"><?php echo $p; ?></td>
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center">
                        <select class="action-select form-control"
                                style="width:120px;display:inline-block"
                                data-product="<?php echo $p; ?>"
                                data-country="<?php echo $c; ?>">
                            <option value="Open"  <?php echo $a === 'Open'  ? 'selected' : ''; ?>>Open</option>
                            <option value="Close" <?php echo $a === 'Close' ? 'selected' : ''; ?>>Close</option>
                        </select>
                    </td>
                    <td style="text-align:center">
                        <span class="as-status-<?php echo $p; ?>-<?php echo $c; ?>">
                            <?php if ($a === 'Open'): ?>
                            <span class="label label-success">Open</span>
                            <?php else: ?>
                            <span class="label label-danger">Closed</span>
                            <?php endif; ?>
                        </span>
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
// ACTION: Activation Report Setting — update single row
// Called by: activationsetting.php  →  POST ajax/handler.php?action=activation_setting_update
// POST params: act (Open|Close), product, country
// Returns: JSON {ok: true} or {ok: false, msg: "..."}
// ═══════════════════════════════════════════════════════════════════════════════
function action_activation_setting_update(mysqli $con): void
{
    header('Content-Type: application/json');

    $act     = trim($_POST['act']     ?? '');
    $product = trim($_POST['product'] ?? '');
    $country = trim($_POST['country'] ?? '');

    if (!in_array($act, ['Open', 'Close'], true) || $product === '' || $country === '') {
        echo json_encode(['ok' => false, 'msg' => 'Invalid parameters']);
        return;
    }

    $stmt = $con->prepare(
        "UPDATE gamebardb_vodafone_qatar_report.activationsetting
         SET Action = ? WHERE Product = ? AND Country = ?"
    );
    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => $con->error]);
        return;
    }
    $stmt->bind_param('sss', $act, $product, $country);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Callback Settings — load rows
// Called by: callbackssetting.php → POST ajax/handler.php?action=callback_setting_load
// POST params: product, operator
// Returns: JSON { success, rows[], meta: {advdb, advtable, condition, operator, product} }
// ═══════════════════════════════════════════════════════════════════════════════
function action_callback_setting_load(mysqli $con): void
{
    header('Content-Type: application/json');

    $product  = trim($_POST['product']  ?? '');
    $operator = trim($_POST['operator'] ?? '');

    if ($product === '' || $operator === '') {
        echo json_encode(['success' => false, 'message' => 'Product and operator are required.']);
        return;
    }

    $stmt = $con->prepare(
        "SELECT advdb, advtable, callbackcondition
         FROM gamebardb_vodafone_qatar_report.mainreportquery
         WHERE product = ? AND operator = ?
         LIMIT 1"
    );
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => $con->error]);
        return;
    }
    $stmt->bind_param('ss', $product, $operator);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'No configuration found for selected product/operator.']);
        return;
    }

    $advdb     = $row['advdb'];
    $advtable  = $row['advtable'];
    $condition = $row['callbackcondition'];

    $query = "SELECT a.advertiserid, a.callbackurl, a.advname, isactive, spo_stop, act_stop, cg_stop
              FROM {$advdb}.{$advtable}
              INNER JOIN advertiserdb.advertiser a ON a.advertiserid = {$advtable}.advertiserid
              {$condition}";

    $res = $con->query($query);
    if (!$res) {
        echo json_encode(['success' => false, 'message' => 'Query error: ' . $con->error]);
        return;
    }

    $rows = [];
    while ($r = $res->fetch_assoc()) {
        $rows[] = [
            'advertiserid' => (int)$r['advertiserid'],
            'advname'      => htmlspecialchars($r['advname'],     ENT_QUOTES),
            'callbackurl'  => htmlspecialchars($r['callbackurl'], ENT_QUOTES),
            'act_stop'     => $r['act_stop'],
            'spo_stop'     => $r['spo_stop'],
            'cg_stop'      => $r['cg_stop'],
        ];
    }

    echo json_encode([
        'success' => true,
        'rows'    => $rows,
        'meta'    => [
            'advdb'     => $advdb,
            'advtable'  => $advtable,
            'condition' => $condition,
            'operator'  => $operator,
            'product'   => $product,
        ],
    ]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Callback Settings — update stop percentage
// Called by: callbackssetting.php → POST ajax/handler.php?action=callback_setting_update
// POST params: callbacktype (act_stop|spo_stop|cg_stop), advertiserid, callbackstop_perc,
//              advdb, advtable, condition
// Returns: JSON { ok: true } or { ok: false, msg: "..." }
// ═══════════════════════════════════════════════════════════════════════════════
function action_callback_setting_update(mysqli $con): void
{
    header('Content-Type: application/json');

    $allowed_types = ['act_stop', 'spo_stop', 'cg_stop'];

    $callbacktype = trim($_POST['callbacktype']       ?? '');
    $advertiserid = trim($_POST['advertiserid']       ?? '');
    $perc         = trim($_POST['callbackstop_perc']  ?? '');
    $advdb        = trim($_POST['advdb']              ?? '');
    $advtable     = trim($_POST['advtable']           ?? '');
    $condition    = trim($_POST['condition']          ?? '');

    if (!in_array($callbacktype, $allowed_types, true) || $advertiserid === '' || $advdb === '' || $advtable === '') {
        echo json_encode(['ok' => false, 'msg' => 'Invalid parameters.']);
        return;
    }

    if ($advertiserid === 'mehul') {
        $sql = $condition === ''
            ? "UPDATE {$advdb}.{$advtable} SET {$callbacktype} = '" . mysqli_real_escape_string($con, $perc) . "'"
            : "UPDATE {$advdb}.{$advtable} SET {$callbacktype} = '" . mysqli_real_escape_string($con, $perc) . "' {$condition}";
    } else {
        $advid = mysqli_real_escape_string($con, $advertiserid);
        $sql = $condition === ''
            ? "UPDATE {$advdb}.{$advtable} SET {$callbacktype} = '" . mysqli_real_escape_string($con, $perc) . "' WHERE advertiserid = '{$advid}'"
            : "UPDATE {$advdb}.{$advtable} SET {$callbacktype} = '" . mysqli_real_escape_string($con, $perc) . "' {$condition} AND advertiserid = '{$advid}'";
    }

    $ok = $con->query($sql);
    echo json_encode(['ok' => (bool)$ok, 'msg' => $ok ? '' : $con->error]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Currency — load table
// Called by: currency.php  →  POST ajax/handler.php?action=currency_load
// Returns: HTML table
// ═══════════════════════════════════════════════════════════════════════════════
function action_currency_load(mysqli $con): void
{
    $sql = "SELECT id, country, toinr
            FROM gamebardb_vodafone_qatar_report.currency
            ORDER BY country ASC";
    $res = $con->query($sql);
    if (!$res) {
        echo '<div style="padding:40px;text-align:center;color:#e53e3e">
                <strong>Query failed.</strong>
                <div style="margin-top:8px;font-size:12px;color:#718096">'
             . htmlspecialchars($con->error) .
             '</div></div>';
        return;
    }

    $rows = [];
    while ($row = $res->fetch_assoc()) { $rows[] = $row; }
    $res->close();

    if (empty($rows)) {
        echo '<div style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;margin:0">No currency records found.</p>
              </div>';
        return;
    }
    ?>
<div class="hp-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-money"></i> Currency Rates
            <small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">
                <?php echo count($rows); ?> records
            </small>
        </h4>
    </div>
    <div class="hp-card-body">
        <p style="margin-bottom:10px;font-size:12px;color:#718096;">
            <i class="fa fa-info-circle"></i>
            Edit the <strong>Rate (to INR)</strong> value and click outside the field to save instantly.
        </p>
        <div style="overflow-x:auto;">
        <table id="cur-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">Country</th>
                    <th style="text-align:center">Rate (to INR)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td style="text-align:center"><?php echo (int)$row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['country']); ?></td>
                    <td style="text-align:center">
                        <input type="number" step="any" class="cur-input"
                               style="width:100px;padding:4px 6px;border:1px solid #e2e8f0;border-radius:4px;text-align:center;font-size:13px;"
                               value="<?php echo htmlspecialchars($row['toinr']); ?>"
                               data-id="<?php echo (int)$row['id']; ?>"
                               placeholder="0.00">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Currency — update single row
// Called by: currency.php  →  POST ajax/handler.php?action=currency_update
// POST params: id (int), toinr (numeric)
// Returns: JSON {ok: true} or {ok: false, msg: "..."}
// ═══════════════════════════════════════════════════════════════════════════════
function action_currency_update(mysqli $con): void
{
    header('Content-Type: application/json');

    $id    = (int)($_POST['id']    ?? 0);
    $toinr = trim($_POST['toinr']  ?? '');

    if ($id <= 0 || $toinr === '' || !is_numeric($toinr)) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid parameters.']);
        return;
    }

    $stmt = $con->prepare(
        "UPDATE gamebardb_vodafone_qatar_report.currency SET toinr = ? WHERE id = ?"
    );
    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => $con->error]);
        return;
    }
    $stmt->bind_param('di', $toinr, $id);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok, 'msg' => $ok ? '' : $con->error]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Callback Report — summary by product/operator/advertiser
// Called by: callbackreport.php  →  POST ajax/handler.php?action=callback_report_load
// POST params: product, operator ('all' or specific), advertiser ('all' or id),
//              start_date (d-m-Y), end_date (d-m-Y)
// ═══════════════════════════════════════════════════════════════════════════════
function action_callback_report_load(mysqli $con): void
{
    $report = 'gamebardb_vodafone_qatar_report';

    $product    = trim($_POST['product']    ?? '');
    $operator   = trim($_POST['operator']   ?? '');
    $advertiser = trim($_POST['advertiser'] ?? 'all');
    $start_raw  = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw    = trim($_POST['end_date']   ?? date('d-m-Y'));

    if (!$product || !$operator) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-exclamation-circle" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;font-size:14px;margin:0">Please select Product and Operator.</p>
              </div></div>';
        return;
    }

    $start_date = date('Y-m-d', strtotime($start_raw));
    $end_date   = date('Y-m-d', strtotime($end_raw));
    if ($start_date < '2020-04-13') $start_date = '2020-04-13';

    $base_select = "SELECT mainreport.product, mainreport.operator, advname,
                    SUM(cbsent) AS cbsum, SUM(pcsent) AS pcsent, operatorcost_usd
             FROM {$report}.mainreport
             LEFT JOIN {$report}.operatorcost ON mainreport.operator = operatorcost.operator
             WHERE mainreport.date >= ? AND mainreport.date <= ?
               AND mainreport.product = ?";

    $base_tail = " AND cbsent > 0
               AND operatorcost.product = ?
             GROUP BY mainreport.product, mainreport.operator, advname, operatorcost_usd
             ORDER BY mainreport.product ASC, mainreport.operator ASC";

    // 4 branches: operator (all/specific) × advertiser (all/specific)
    if ($operator === 'all' && $advertiser === 'all') {
        $stmt = $con->prepare($base_select . " AND advertiser > 0" . $base_tail);
        $stmt->bind_param('ssss', $start_date, $end_date, $product, $product);

    } elseif ($operator === 'all' && $advertiser !== 'all') {
        $stmt = $con->prepare($base_select . " AND advertiser = ?" . $base_tail);
        $stmt->bind_param('sssss', $start_date, $end_date, $product, $advertiser, $product);

    } elseif ($operator !== 'all' && $advertiser === 'all') {
        $stmt = $con->prepare($base_select . " AND mainreport.operator = ? AND advertiser > 0" . $base_tail);
        $stmt->bind_param('sssss', $start_date, $end_date, $product, $operator, $product);

    } else {
        $stmt = $con->prepare($base_select . " AND mainreport.operator = ? AND advertiser = ?" . $base_tail);
        $stmt->bind_param('ssssss', $start_date, $end_date, $product, $operator, $advertiser, $product);
    }

    if (!$stmt || !$stmt->execute()) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-bar-chart" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No Data Available</p>
                <p style="color:#cbd5e0;font-size:13px;margin:0">No callback data found for the selected filters.<br>Try changing the date range, product, or operator.</p>
              </div></div>';
        return;
    }

    $res  = $stmt->get_result();
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $stmt->close();

    if (empty($rows)) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No Data Available</p>
                <p style="color:#cbd5e0;font-size:13px;margin:0">No records found for the selected filters.<br>Try changing the date range, product, or operator.</p>
              </div></div>';
        return;
    }

    $total_cb   = 0;
    $total_pc   = 0;
    $total_cost = 0.0;

    $op_label = $operator === 'all' ? 'All Operators' : htmlspecialchars($operator);
    $html  = '<div class="hp-card" style="margin-top:16px">';
    $html .= '<div class="hp-card-header"><h4><i class="fa fa-phone"></i> Callback Report Results';
    $html .= '<small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">';
    $html .= htmlspecialchars($product) . ' &middot; ' . $op_label . ' &middot; ' . count($rows) . ' records</small>';
    $html .= '</h4></div>';
    $html .= '<div class="hp-card-body" style="overflow-x:auto;">';
    $html .= '<table id="cbr-table" class="table table-striped table-bordered" style="width:100%">';
    $html .= '<thead><tr>';
    $html .= '<th>Product</th><th>Operator</th><th>Advertiser</th>';
    $html .= '<th>Total Callback Sent</th><th>Pin-Confirmed</th>';
    $html .= '<th>Cost/CB (USD)</th><th>Total Cost (USD)</th>';
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $r) {
        $cost_row    = round((float)$r['cbsum'] * (float)$r['operatorcost_usd'], 4);
        $total_cb   += (int)$r['cbsum'];
        $total_pc   += (int)$r['pcsent'];
        $total_cost += $cost_row;

        $html .= '<tr>';
        $html .= '<td>'                           . htmlspecialchars($r['product'])           . '</td>';
        $html .= '<td>'                           . htmlspecialchars($r['operator'])          . '</td>';
        $html .= '<td>'                           . htmlspecialchars($r['advname'])           . '</td>';
        $html .= '<td style="text-align:right">'  . number_format((int)$r['cbsum'])          . '</td>';
        $html .= '<td style="text-align:right">'  . number_format((int)$r['pcsent'])         . '</td>';
        $html .= '<td style="text-align:right">'  . number_format((float)$r['operatorcost_usd'], 6) . '</td>';
        $html .= '<td style="text-align:right">'  . number_format($cost_row, 4)              . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody><tfoot><tr>';
    $html .= '<th colspan="3" style="text-align:right;font-weight:700">Total</th>';
    $html .= '<th style="text-align:right">' . number_format($total_cb)          . '</th>';
    $html .= '<th style="text-align:right">' . number_format($total_pc)          . '</th>';
    $html .= '<th></th>';
    $html .= '<th style="text-align:right">' . number_format($total_cost, 4)     . '</th>';
    $html .= '</tr></tfoot>';
    $html .= '</table></div></div>';

    echo $html;
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Operators that have callback data for a given product + date range
// Called by: callbackreport.php  →  POST ajax/handler.php?action=callback_report_operators
// POST params: product, start_date (d-m-Y), end_date (d-m-Y)
// Returns: JSON array of operator strings
// ═══════════════════════════════════════════════════════════════════════════════
function action_callback_report_operators(mysqli $con): void
{
    header('Content-Type: application/json');
    $report    = 'gamebardb_vodafone_qatar_report';
    $product   = trim($_POST['product']    ?? '');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    if (!$product) {
        echo json_encode([]);
        return;
    }

    $start_date = date('Y-m-d', strtotime($start_raw));
    $end_date   = date('Y-m-d', strtotime($end_raw));
    if ($start_date < '2020-04-13') $start_date = '2020-04-13';

    $stmt = $con->prepare(
        "SELECT DISTINCT mainreport.operator
         FROM {$report}.mainreport
         LEFT JOIN {$report}.operatorcost ON mainreport.operator = operatorcost.operator
         WHERE mainreport.date >= ? AND mainreport.date <= ?
           AND mainreport.product = ?
           AND advertiser > 0 AND cbsent > 0
           AND operatorcost.product = ?
         ORDER BY mainreport.operator ASC"
    );
    $stmt->bind_param('ssss', $start_date, $end_date, $product, $product);
    $stmt->execute();
    $res = $stmt->get_result();
    $ops = [];
    while ($r = $res->fetch_assoc()) $ops[] = $r['operator'];
    $stmt->close();

    echo json_encode($ops);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Advertisers that have callback data for a given product + date range
// Called by: callbackreport.php  →  POST ajax/handler.php?action=callback_report_advertisers
// POST params: product, start_date (d-m-Y), end_date (d-m-Y)
// Returns: JSON array of {id, name} objects
// ═══════════════════════════════════════════════════════════════════════════════
function action_callback_report_advertisers(mysqli $con): void
{
    header('Content-Type: application/json');
    $report    = 'gamebardb_vodafone_qatar_report';
    $product   = trim($_POST['product']    ?? '');
    $start_raw = trim($_POST['start_date'] ?? date('d-m-Y'));
    $end_raw   = trim($_POST['end_date']   ?? date('d-m-Y'));

    if (!$product) {
        echo json_encode([]);
        return;
    }

    $start_date = date('Y-m-d', strtotime($start_raw));
    $end_date   = date('Y-m-d', strtotime($end_raw));
    if ($start_date < '2020-04-13') $start_date = '2020-04-13';

    $stmt = $con->prepare(
        "SELECT DISTINCT m.advertiser AS id, a.advname AS name
         FROM {$report}.mainreport m
         LEFT JOIN advertiserdb.advertiser a ON m.advertiser = a.advertiserid
         LEFT JOIN {$report}.operatorcost oc ON m.operator = oc.operator AND oc.product = ?
         WHERE m.date >= ? AND m.date <= ?
           AND m.product = ?
           AND m.advertiser > 0 AND m.cbsent > 0
         ORDER BY a.advname ASC"
    );
    $stmt->bind_param('ssss', $product, $start_date, $end_date, $product);
    $stmt->execute();
    $res  = $stmt->get_result();
    $advs = [];
    while ($r = $res->fetch_assoc()) $advs[] = ['id' => $r['id'], 'name' => $r['name'] ?: 'Advertiser #' . $r['id']];
    $stmt->close();

    echo json_encode($advs);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Add UAT record
// Called by: adduat.php  →  POST ajax/handler.php?action=uat_add
// POST params: all 31 UAT form fields
// ═══════════════════════════════════════════════════════════════════════════════
function action_uat_add(mysqli $con): void
{
    header('Content-Type: application/json');
    $db = 'gamebardb_vodafone_qatar_report';

    $product                      = trim($_POST['product']                      ?? '');
    $country                      = trim($_POST['country']                      ?? '');
    $operator                     = trim($_POST['operator']                     ?? '');
    $url                          = trim($_POST['url']                          ?? '');
    $pricepoint                   = trim($_POST['pricepoint']                   ?? '');
    $pricepointdays               = trim($_POST['pricepointdays']               ?? '');
    $freetrial                    = trim($_POST['freetrial']                    ?? '');
    $freetrialdays                = trim($_POST['freetrialdays']                ?? '');
    $fallback                     = trim($_POST['fallback']                     ?? '');
    $actfallbackamount            = trim($_POST['actfallbackamount']            ?? '');
    $subscribebutton              = trim($_POST['subscribebutton']              ?? '');
    $servicename                  = trim($_POST['servicename']                  ?? '');
    $pricepointonlanding          = trim($_POST['pricepointonlanding']          ?? '');
    $servicetnc                   = trim($_POST['servicetnc']                   ?? '');
    $openinglp                    = trim($_POST['openinglp']                    ?? '');
    $consenthandle                = trim($_POST['consenthandle']                ?? '');
    $activatedsuccessfully        = trim($_POST['activatedsuccessfully']        ?? '');
    $activationcallbackwithamount = trim($_POST['activationcallbackwithamount'] ?? '');
    $fallbackinactivationcallback = trim($_POST['fallbackinactivationcallback'] ?? '');
    $retriesoftheactivation       = trim($_POST['retriesoftheactivation']       ?? '');
    $unsubbyuser                  = trim($_POST['unsubbyuser']                  ?? '');
    $unsubinreport                = trim($_POST['unsubinreport']                ?? '');
    $renewalgetting               = trim($_POST['renewalgetting']               ?? '');
    $fallbackinrenewal            = trim($_POST['fallbackinrenewal']            ?? '');
    $renfallbackamount            = trim($_POST['renfallbackamount']            ?? '');
    $daysforrenewal               = trim($_POST['daysforrenewal']               ?? '');
    $directcontentpage            = trim($_POST['directcontentpage']            ?? '');
    $downloadcontentbyuser        = trim($_POST['downloadcontentbyuser']        ?? '');
    $newportal                    = trim($_POST['newportal']                    ?? '');
    $callbacksent                 = trim($_POST['callbacksent']                 ?? '');
    $completereport               = trim($_POST['completereport']               ?? '');

    $stmt = $con->prepare(
        "INSERT INTO {$db}.uat
         (`product`,`country`,`operator`,`testurl`,`pricepoint`,`pricepointperdays`,
          `freetrial`,`freetrialdays`,`fallback`,`actfallbackamount`,
          `landingpagesubscribebutton`,`landingpageservicename`,`landingpagepricepoint`,
          `landingpaget&c`,`landingmsisdn`,`consentpagehandle`,
          `activatedsuccessfully`,`activationcallbackwithamount`,`fallbackinactivationcallback`,
          `retriesoftheactivation`,`unsubbyuser`,`unsubinreport`,
          `renewalgetting`,`fallbackinrenewal`,`renfallbackamount`,`daysforrenewal`,
          `directcontentpage`,`downloadcontentbyuser`,`newportal`,
          `callbacksent`,`completereport`)
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
    );

    if (!$stmt) {
        echo json_encode(['ok' => false, 'msg' => $con->error]);
        return;
    }

    $stmt->bind_param('sssssssssssssssssssssssssssssss',
        $product, $country, $operator, $url, $pricepoint,
        $pricepointdays, $freetrial, $freetrialdays, $fallback, $actfallbackamount,
        $subscribebutton, $servicename, $pricepointonlanding, $servicetnc, $openinglp,
        $consenthandle, $activatedsuccessfully, $activationcallbackwithamount,
        $fallbackinactivationcallback, $retriesoftheactivation,
        $unsubbyuser, $unsubinreport, $renewalgetting, $fallbackinrenewal,
        $renfallbackamount, $daysforrenewal, $directcontentpage,
        $downloadcontentbyuser, $newportal, $callbacksent, $completereport
    );

    $ok  = $stmt->execute();
    $err = $stmt->error;
    $stmt->close();

    echo json_encode(['ok' => $ok, 'msg' => $ok ? 'UAT record added successfully.' : $err]);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Distinct country list for All UAT dropdown
// Called by: alluat.php  →  GET ajax/handler.php?action=uat_countries
// ═══════════════════════════════════════════════════════════════════════════════
function action_uat_countries(mysqli $con): void
{
    header('Content-Type: application/json');
    $db  = 'gamebardb_vodafone_qatar_report';
    $res = $con->query(
        "SELECT DISTINCT country FROM {$db}.uat WHERE country IS NOT NULL AND country != '' ORDER BY country ASC"
    );
    $list = [];
    while ($row = $res->fetch_assoc()) $list[] = $row['country'];
    echo json_encode($list);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: UAT pivot table for a given country
// Called by: alluat.php  →  POST ajax/handler.php?action=uat_load
// POST params: country
// Returns: HTML pivot table (rows = questions, columns = operators)
// ═══════════════════════════════════════════════════════════════════════════════
function action_uat_load(mysqli $con): void
{
    $db      = 'gamebardb_vodafone_qatar_report';
    $country = trim($_POST['country'] ?? '');

    if (!$country) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-exclamation-circle" style="font-size:48px;color:#e2e8f0;display:block;margin-bottom:16px"></i>
                <p style="color:#a0aec0;font-size:14px;margin:0">Please select a Country.</p>
              </div></div>';
        return;
    }

    $stmt = $con->prepare(
        "SELECT * FROM {$db}.uat WHERE country = ? ORDER BY operator ASC"
    );
    $stmt->bind_param('s', $country);
    $stmt->execute();
    $res  = $stmt->get_result();
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $stmt->close();

    if (empty($rows)) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No UAT Records</p>
                <p style="color:#cbd5e0;font-size:13px;margin:0">No UAT entries found for <strong>' . htmlspecialchars($country) . '</strong>.</p>
              </div></div>';
        return;
    }

    // Build lookup: operator → row
    $operators = array_column($rows, 'operator');
    $ll = [];
    foreach ($rows as $r) $ll[$r['operator']] = $r;
    $n = count($operators);

    // Question definitions: field => [label, section_header_before_this_row | null]
    $questions = [
        'product'                      => ['Product',                                        null],
        'country'                      => ['Country',                                        null],
        'testurl'                      => ['Test URL',                                       null],
        'pricepoint'                   => ['Price Point',                                    null],
        'pricepointperdays'            => ['Days of Price Point',                            null],
        'freetrial'                    => ['Free Trial',                                     null],
        'freetrialdays'                => ['Free Trial Days',                                null],
        'fallback'                     => ['Fallback',                                       null],
        'actfallbackamount'            => ['Fallback Amount',                                null],
        'landingpagesubscribebutton'   => ['Subscribe Button',                               'Landing Page Must Include'],
        'landingpageservicename'       => ['Service Name',                                   null],
        'landingpagepricepoint'        => ['Price Point on Landing',                         null],
        'landingpaget&c'               => ['Service T&amp;C',                                null],
        'landingmsisdn'                => ['Opening MDN / HE / LP',                         null],
        'consentpagehandle'            => ['Consent Page Handled By',                        'Consent Page'],
        'activatedsuccessfully'        => ['Sub Activated Properly &amp; in Report',         null],
        'activationcallbackwithamount' => ['Activation Callback with Amount',                null],
        'fallbackinactivationcallback' => ['Fallbacks in Activation Callback',               null],
        'retriesoftheactivation'       => ['Retries in Activation',                          null],
        'unsubbyuser'                  => ['User Can Unsub',                                 'Unsub Flow'],
        'unsubinreport'                => ['Churn Captured in Report',                       null],
        'renewalgetting'               => ['Getting Renewal',                                'Renewal Flow'],
        'fallbackinrenewal'            => ['Fallbacks in Renewal',                           null],
        'renfallbackamount'            => ['Renewal Fallback Amount',                        null],
        'daysforrenewal'               => ['Retries in Renewal',                             null],
        'directcontentpage'            => ['Directed to Content Page',                       'Content Flow'],
        'downloadcontentbyuser'        => ['User Can Download Games',                        null],
        'newportal'                    => ['New Portal Displayed',                           null],
        'callbacksent'                 => ['Callback Sent to Publisher',                     'Call-backs'],
        'completereport'               => ['Geo in Reporting Tool (Act/Perform/Trend/Last)', null],
    ];

    $html  = '<div class="hp-card" style="margin-top:16px">';
    $html .= '<div class="hp-card-header"><h4><i class="fa fa-list-alt"></i> UAT Comparison — ' . htmlspecialchars($country);
    $html .= '<small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">';
    $html .= $n . ' operator' . ($n !== 1 ? 's' : '') . '</small></h4></div>';
    $html .= '<div class="hp-card-body" style="overflow-x:auto;padding:0;">';
    $html .= '<table class="table table-striped table-bordered" style="width:100%;font-size:12px;margin:0;">';
    $html .= '<thead>';
    $html .= '<tr style="background:#667eea;color:#fff;">';
    $html .= '<th rowspan="2" style="vertical-align:middle;min-width:260px;">Question</th>';
    $html .= '<th colspan="' . $n . '" style="text-align:center">Operator</th></tr>';
    $html .= '<tr style="background:#764ba2;color:#fff;">';
    foreach ($operators as $op) {
        $html .= '<th style="text-align:center;white-space:nowrap">' . htmlspecialchars($op) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($questions as $field => $meta) {
        list($label, $section) = $meta;
        if ($section !== null) {
            $html .= '<tr><td colspan="' . ($n + 1) . '" style="background:#f8f9fa;padding:8px 12px;">';
            $html .= '<strong style="color:#e53935;font-size:12px;"><i class="fa fa-angle-right"></i> ' . $section . '</strong>';
            $html .= '</td></tr>';
        }
        $html .= '<tr><td style="padding:6px 10px;">' . $label . '</td>';
        foreach ($operators as $op) {
            $val = htmlspecialchars($ll[$op][$field] ?? '—');
            $html .= '<td style="text-align:center;padding:6px 10px;">' . $val . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table></div></div>';
    echo $html;
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Check Crons — activation & renewal for a date where advertiser = 0
// Called by: checkactivation.php  →  POST ajax/handler.php?action=checkactivation_load
// POST params: date (d-m-Y)
// ═══════════════════════════════════════════════════════════════════════════════
function action_checkactivation_load(mysqli $con): void
{
    $report   = 'gamebardb_vodafone_qatar_report';
    $date_raw = trim($_POST['date'] ?? date('d-m-Y'));

    $date_dt = date('Y-m-d', strtotime($date_raw));
    $date_lbl = date('d-m-Y', strtotime($date_raw));

    $stmt = $con->prepare(
        "SELECT Date, country, product, operator, actcount, renewcount
         FROM {$report}.mainreport
         WHERE date = ? AND advertiser = '0'
         ORDER BY actcount ASC, renewcount ASC"
    );
    $stmt->bind_param('s', $date_dt);
    $stmt->execute();
    $res  = $stmt->get_result();
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $stmt->close();

    if (empty($rows)) {
        echo '<div class="hp-card" style="margin-top:16px"><div class="hp-card-body" style="padding:60px;text-align:center">
                <i class="fa fa-inbox" style="font-size:52px;color:#e2e8f0;display:block;margin-bottom:18px"></i>
                <p style="color:#a0aec0;font-size:15px;margin:0 0 6px;font-weight:600">No Data Available</p>
                <p style="color:#cbd5e0;font-size:13px;margin:0">No cron records found for <strong>' . htmlspecialchars($date_lbl) . '</strong>.</p>
              </div></div>';
        return;
    }

    $zero_act = 0;
    $zero_ren = 0;
    foreach ($rows as $r) {
        if ((int)$r['actcount']   === 0) $zero_act++;
        if ((int)$r['renewcount'] === 0) $zero_ren++;
    }

    $html  = '<div class="hp-card" style="margin-top:16px">';
    $html .= '<div class="hp-card-header"><h4><i class="fa fa-check-circle-o"></i> Check Crons — ' . htmlspecialchars($date_lbl);
    $html .= '<small style="font-size:12px;font-weight:400;color:rgba(255,255,255,.7);margin-left:10px;">';
    $html .= count($rows) . ' records';
    if ($zero_act > 0) $html .= ' &middot; <span style="color:#ffcdd2">' . $zero_act . ' zero-activation</span>';
    if ($zero_ren > 0) $html .= ' &middot; <span style="color:#ffcdd2">' . $zero_ren . ' zero-renewal</span>';
    $html .= '</small></h4></div>';
    $html .= '<div class="hp-card-body" style="overflow-x:auto;">';
    $html .= '<table id="chkact-table" class="table table-striped table-bordered" style="width:100%">';
    $html .= '<thead><tr>';
    $html .= '<th class="text-center">Date</th><th class="text-center">Country</th><th class="text-center">Product</th><th class="text-center">Operator</th>';
    $html .= '<th class="text-center">Activation</th><th class="text-center">Renewal</th>';
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $r) {
        $act_style = ((int)$r['actcount']   === 0) ? ' style="color:#fff;font-weight:700;background:#ff9999;"' : '';
        $ren_style = ((int)$r['renewcount'] === 0) ? ' style="color:#fff;font-weight:700;background:#ff9999;"' : '';
        $html .= '<tr>';
        $html .= '<td class="text-center">' . htmlspecialchars(date('d-m-Y', strtotime($r['Date'])))  . '</td>';
        $html .= '<td class="text-center">' . htmlspecialchars($r['country'])  . '</td>';
        $html .= '<td class="text-center">' . htmlspecialchars($r['product'])  . '</td>';
        $html .= '<td class="text-center">' . htmlspecialchars($r['operator']) . '</td>';
        $html .= '<td class="text-center"' . $act_style . '>' . (int)$r['actcount']   . '</td>';
        $html .= '<td class="text-center"' . $ren_style . '>' . (int)$r['renewcount'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table></div></div>';
    echo $html;
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Gamezop — Partner dropdown list
// Called by: gamezop_report.php  →  POST ajax/handler.php?action=gamezop_partners
// Returns JSON array of active partners: [{userid, name}, ...]
// ═══════════════════════════════════════════════════════════════════════════════
function action_gamezop_partners(mysqli $con): void
{
    header('Content-Type: application/json');

    $stmt = $con->prepare(
        "SELECT userid, name, access FROM svmobigamesreport.login_username ORDER BY name ASC"
    );
    if (!$stmt) {
        echo json_encode([]);
        return;
    }
    $stmt->execute();
    $res      = $stmt->get_result();
    $partners = [];
    while ($row = $res->fetch_assoc()) {
        $access = json_decode($row['access'] ?? '{}', true);
        if (($access['active'] ?? '') !== '1') continue;
        if (empty($access['for']))              continue;
        $partners[] = [
            'userid' => (int)$row['userid'],
            'name'   => $row['name'],
        ];
    }
    $stmt->close();
    echo json_encode($partners);
}

// ═══════════════════════════════════════════════════════════════════════════════
// ACTION: Gamezop — Load report data
// Called by: gamezop_report.php  →  POST ajax/handler.php?action=gamezop_report_load
// POST params: userid (int), start_date (YYYY-MM-DD), end_date (YYYY-MM-DD)
// Returns JSON: {success, partner_name, stats:{...}, chart:{labels,data}, rows:[...]}
// ═══════════════════════════════════════════════════════════════════════════════
function action_gamezop_report_load(mysqli $con): void
{
    header('Content-Type: application/json');

    $gamezop_token = '8f222d9c-4207-4654-bf85-55e65ae6ed0c';

    $userid     = (int)($_POST['userid']     ?? 0);
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date   = trim($_POST['end_date']   ?? '');

    if (!$userid
        || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)
        || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
        return;
    }
    if ($start_date > date('Y-m-d') || $end_date > date('Y-m-d')) {
        echo json_encode(['success' => false, 'error' => 'Future dates are not allowed.']);
        return;
    }

    // Fetch user's property_id and name
    $stmt = $con->prepare(
        "SELECT name, access FROM svmobigamesreport.login_username WHERE userid = ? LIMIT 1"
    );
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(['success' => false, 'error' => 'Partner not found.']);
        return;
    }

    $access       = json_decode($row['access'] ?? '{}', true);
    $property_id  = $access['for'] ?? '';
    $partner_name = $row['name'];

    if (!$property_id) {
        echo json_encode(['success' => false, 'error' => 'Partner has no property ID configured.']);
        return;
    }

    // Fetch revenueshare from offers table
    $revenueshare = 1.0;
    $stmt2 = $con->prepare(
        "SELECT revenueshare FROM svmobigamesreport.offers WHERE offerid = ? LIMIT 1"
    );
    $stmt2->bind_param('s', $property_id);
    $stmt2->execute();
    $row2 = $stmt2->get_result()->fetch_assoc();
    $stmt2->close();
    if ($row2) {
        $revenueshare = (float)$row2['revenueshare'];
    }

    // Call Gamezop API
    $api_payload = json_encode([
        'start_date'  => $start_date,
        'end_date'    => $end_date,
        'property_id' => $property_id,
        'metrics'     => ['impressions', 'clicks', 'revenue', 'total-revenue', 'ctr', 'ecpm'],
        'breakdowns'  => ['property-id'],
    ]);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => 'https://api.platform.gamezop.com/v1/ad-revenue-data',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $api_payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $gamezop_token,
        ],
        CURLOPT_TIMEOUT        => 30,
    ]);
    $curl_error    = curl_error($ch);
    $api_response  = curl_exec($ch);
    curl_close($ch);

    $api_data = json_decode($api_response, true);
    $api_note = '';
    $stats = [
        'impressions'   => 0,
        'clicks'        => 0,
        'revenue'       => 0,
        'total_revenue' => 0,
        'ecpm'          => 0,
        'your_revenue'  => 0,
    ];

    if ($curl_error) {
        $api_note = 'API connection error: ' . $curl_error;
    } elseif (!$api_response) {
        $api_note = 'API returned empty response.';
    } elseif (!is_array($api_data)) {
        $api_note = 'API response could not be decoded.';
    } elseif (empty($api_data['success']) || !$api_data['success']) {
        $api_note = 'API error: ' . ($api_data['message'] ?? $api_data['error'] ?? 'unknown');
    } else {
        $item = $api_data['data']['ad_revenue'][0] ?? [];
        if (empty($item)) {
            $api_note = 'No ad revenue data for this date range.';
        } else {
            $stats['impressions']   = (int)($item['impressions']     ?? 0);
            $stats['clicks']        = (int)($item['clicks']          ?? 0);
            $stats['revenue']       = (float)($item['revenue']       ?? 0);
            $stats['total_revenue'] = (float)($item['total-revenue'] ?? 0);
            $stats['ecpm']          = (float)($item['ecpm']          ?? 0);
            $stats['your_revenue']  = $stats['total_revenue'] * $revenueshare;
        }
    }

    // Last 5 days chart data from stored report table
    $chart_labels = [];
    $chart_data   = [];
    $stmt3 = $con->prepare(
        "SELECT reportdate, totalrevenue FROM svmobigamesreport.report
         WHERE offerid = ? AND reportdate >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
         ORDER BY reportdate ASC"
    );
    $stmt3->bind_param('s', $property_id);
    $stmt3->execute();
    $res3 = $stmt3->get_result();
    while ($r3 = $res3->fetch_assoc()) {
        $chart_labels[] = date('d M', strtotime($r3['reportdate']));
        $chart_data[]   = round((float)$r3['totalrevenue'], 4);
    }
    $stmt3->close();

    // Per-day rows from stored report table for the selected range
    $rows  = [];
    $stmt4 = $con->prepare(
        "SELECT reportdate, totalrevenue, impressions, ecpm, clicks
         FROM svmobigamesreport.report
         WHERE offerid = ? AND reportdate >= ? AND reportdate <= ?
         ORDER BY reportdate ASC"
    );
    $stmt4->bind_param('sss', $property_id, $start_date, $end_date);
    $stmt4->execute();
    $res4 = $stmt4->get_result();
    while ($r4 = $res4->fetch_assoc()) {
        $rows[] = [
            'date'        => date('d-m-Y', strtotime($r4['reportdate'])),
            'your_rev'    => round((float)$r4['totalrevenue'] * $revenueshare, 2),
            'total_rev'   => round((float)$r4['totalrevenue'], 2),
            'impressions' => (int)$r4['impressions'],
            'ecpm'        => round((float)$r4['ecpm'], 2),
            'clicks'      => (int)$r4['clicks'],
        ];
    }
    $stmt4->close();

    echo json_encode([
        'success'      => true,
        'partner_name' => $partner_name,
        'stats'        => $stats,
        'api_note'     => $api_note,
        'chart'        => ['labels' => $chart_labels, 'data' => $chart_data],
        'rows'         => $rows,
    ]);
}
