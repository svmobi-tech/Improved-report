<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

require_once dirname(__DIR__) . '/includes/config.php';

$report  = 'gamebardb_vodafone_qatar_report';
$revenue = 0.6;
$cost    = 0.0;
$today   = date('Y-m-d');
$rows    = [];

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
    // historical format
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

// ── Validate input ─────────────────────────────────────────────────────────────
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

// ── Operator cost ──────────────────────────────────────────────────────────────
$r = mysqli_query($con, "SELECT operator_cost FROM `{$report}`.`operatorcost` WHERE operator='{$operator}'");
if ($r && ($w = mysqli_fetch_assoc($r))) {
    $cost = (float)$w['operator_cost'];
}
// ── Revenue share ──────────────────────────────────────────────────────────────
$r = mysqli_query($con, "SELECT revenueshare FROM `{$report}`.`svmobi_revenueshare` WHERE operator='{$operator}'");
if ($r && ($w = mysqli_fetch_assoc($r))) {
    $revenue = (float)$w['revenueshare'] ?: 0.6;
}
// ── Query templates ────────────────────────────────────────────────────────────
$tpl_all = $tpl_adv = '';
$r = mysqli_query($con, "SELECT mainreport_all, mainreport_advertiser FROM `{$report}`.mainreportquery
    WHERE product='{$product}' AND operator='{$operator}'");
if ($r && ($w = mysqli_fetch_assoc($r))) {
    $tpl_all = $w['mainreport_all'];
    $tpl_adv = $w['mainreport_advertiser'];
}
$adve = ($advertiserid === 'all') ? '0' : $advertiserid;
$tpl  = ($advertiserid === 'all') ? $tpl_all : $tpl_adv;

// ── Fetch rows ─────────────────────────────────────────────────────────────────
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

// ── Render HTML ────────────────────────────────────────────────────────────────
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
