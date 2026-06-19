<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

require_once dirname(__DIR__) . '/includes/config.php';

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

// ── Input ──────────────────────────────────────────────────────────────────────
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

// ── Date calculations ──────────────────────────────────────────────────────────
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

// ── Query (optimized: 3 subquery layers collapsed to 1) ───────────────────────
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

// ── Pre-compute totals ─────────────────────────────────────────────────────────
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
    $totals['act']         += $r['actcount'];
    $totals['actamount']   += $r['actamount']   / $devide;
    $totals['renewcount']  += $r['renewcount'];
    $totals['renewamount'] += $r['renewamount']  / $devide;
    $totals['totalcount']  += $r['totalcount'];
    $totals['totalamount'] += $totalamt;
    $totals['cbsent']      += $r['cbsent'];
    $totals['digiinvest']  += $digitin;
    $totals['revenueshare']+= $revenue;
    $totals['profit']      += $profit;
    $totals['ptotal']      += $ptotal;
    $totals['pdigitin']    += $digitin  * $eday / $date1;
    $totals['prevenue']    += $revenue  * $eday / $date1;
    $totals['pprofit']     += $profit   * $eday / $date1;
}

// ── Render ─────────────────────────────────────────────────────────────────────
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
