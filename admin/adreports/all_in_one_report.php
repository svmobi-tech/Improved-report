<?php
ini_set('max_execution_time', 6000);
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);

$pageTitle = 'All in One Report';
$pageIcon  = 'fa-th';

// Absolute base URL so assets in header/footer resolve correctly from this subdirectory
$pageBase = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
          . $_SERVER['HTTP_HOST']
          . rtrim(dirname(dirname(str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__)))), '/') . '/';

// Admin includes (one level up)
include('../includes/check_session.php');

// PDO connection from adnetwork_admin (required for columnCount / getColumnMeta)
include(dirname(dirname(dirname(__DIR__))) . '/adnetwork_admin/includes/connection.php');

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────

function logDbName(string $op, string $product): string
{
    $lc = strtolower($op);
    if ($lc === 'vodafone') return "voda_{$product}db";
    if ($lc === 'ais')      return "{$op}_{$product}db_0118";
    return "{$op}_{$product}db";
}

function dbExists(PDO $conn, string $dbName): bool
{
    $r = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . $conn->quote($dbName));
    return $r && $r->rowCount() > 0;
}

// ─────────────────────────────────────────────────────────────────────────────
// SQL builders
// ─────────────────────────────────────────────────────────────────────────────

function buildPublisherSql(array $operators, int $num, string $startDT, string $endDT, string $hour, string $product, string $commondb, PDO $conn): string
{
    $select = 'SELECT publisher_name, ';
    foreach ($operators as $i => $op) {
        $oid   = (int)$op['operator_id'];
        $name  = $op['operator'];
        $comma = ($i < $num - 1) ? ',' : '';
        $select .= "CASE WHEN operator = {$oid} THEN SUM(c) END {$name}{$comma} ";
    }
    $select .= 'FROM (';

    $parts = [];
    foreach ($operators as $op) {
        $db = logDbName($op['operator'], $product);
        if (!dbExists($conn, $db)) continue;
        $parts[] = "
            SELECT advertiser_name publisher_name,
                   COUNT(DISTINCT clickid) c,
                   advertiser_tbl.advertiser_id,
                   operator
            FROM {$db}.advertiser_response_tbl
            INNER JOIN {$commondb}.advertiser_tbl
                    ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
            WHERE ad_resp_datetime >= '{$startDT}'
              AND ad_resp_datetime <= '{$endDT}'
              AND HOUR(ad_resp_datetime) <= '{$hour}'
              AND action = 'act'
            GROUP BY advertiser_id, operator";
    }

    if (empty($parts)) return '';
    return $select . implode(' UNION ', $parts) . ') a GROUP BY publisher_name, operator ORDER BY publisher_name';
}

function buildAdvertiserSql(array $operators, int $num, string $startDT, string $endDT, string $hour, string $product, string $commondb, PDO $conn): string
{
    $select = 'SELECT advertiser_name, ';
    foreach ($operators as $i => $op) {
        $oid   = (int)$op['operator_id'];
        $name  = $op['operator'];
        $comma = ($i < $num - 1) ? ',' : '';
        $select .= "CASE WHEN operator = {$oid} THEN SUM(s) END {$name}_amt,
                    CASE WHEN operator = {$oid} THEN SUM(c) END {$name}{$comma} ";
    }
    $select .= 'FROM (';

    $parts = [];
    $idx   = 0;
    foreach ($operators as $op) {
        $db = logDbName($op['operator'], $product);
        if (!dbExists($conn, $db)) continue;
        $idx++;
        $parts[] = "
            SELECT COUNT(clickid) c, advertiser_name, campaign_id, operator, SUM(campaign_price) s
            FROM (
                SELECT DISTINCT clickid, campaign_title advertiser_name,
                       campaign_tbl.campaign_id, operator, campaign_price
                FROM {$db}.advertiser_response_tbl
                INNER JOIN {$commondb}.advertiser_tbl
                        ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
                INNER JOIN {$db}.campaign_tbl
                        ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
                WHERE ad_resp_datetime >= '{$startDT}'
                  AND ad_resp_datetime <= '{$endDT}'
                  AND HOUR(ad_resp_datetime) <= '{$hour}'
                  AND action = 'act'
            ) a{$idx}
            GROUP BY campaign_id, operator";
    }

    if (empty($parts)) return '';
    return $select . implode(' UNION ', $parts) . ') a GROUP BY advertiser_name, operator ORDER BY advertiser_name';
}

function buildApiSql(string $startDT, string $endDT): string
{
    return "SELECT partner,
        sa,   CASE WHEN partner='svmobisa'  THEN sa*0  ELSE sa*2   END saamount,
        om,   CASE WHEN partner='svmobiom'  THEN om*0  ELSE om*2.3 END omamount,
        ae,   CASE WHEN partner='svmobiae'  THEN ae*0  ELSE ae*3.4 END aeamount,
        ps,   CASE WHEN partner='linkitps'  THEN ps*0.7 WHEN partner='airgps' THEN ps*2 ELSE ps*3 END psamount,
        pl,   CASE WHEN partner='linkitps'  THEN pl*0.7 WHEN partner='airgps' THEN pl*2 ELSE pl*3 END plamount,
        et,   et*0.2 etamount
    FROM (
        SELECT CONCAT(partner,'sa') partner, COUNT(DISTINCT msisdn) sa, 0 om, 0 ae, 0 ps, 0 pl, 0 et
        FROM fashionbardb_airg_sa.pinverify
        WHERE (status='success' OR status='pending')
          AND pindatetime >= '{$startDT}' AND pindatetime <= '{$endDT}'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
        UNION ALL
        SELECT CONCAT(partner,'om'), 0, COUNT(*), 0, 0, 0, 0
        FROM fashionbardb_airg_om.pinverify
        WHERE (status='success' OR status='pending')
          AND pindatetime >= '{$startDT}' AND pindatetime <= '{$endDT}'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
        UNION ALL
        SELECT CONCAT(partner,'ae'), 0, 0, COUNT(*), 0, 0, 0
        FROM fashionbardb_airg_ae.pinverify
        WHERE (status='success' OR status='pending')
          AND pindatetime >= '{$startDT}' AND pindatetime <= '{$endDT}'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
        UNION ALL
        SELECT CONCAT(partner,'ps'), 0, 0, 0, COUNT(*), 0, 0
        FROM fashionbardb_airg_ps.pinverify
        WHERE (status='success' OR status='pending')
          AND pindatetime >= '{$startDT}' AND pindatetime <= '{$endDT}'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
        UNION ALL
        SELECT CONCAT(partner,'pl'), 0, 0, 0, 0, COUNT(*), 0
        FROM fashionbardb_airg_pl.pinverify
        WHERE (status='success' OR status='pending')
          AND pindatetime >= '{$startDT}' AND pindatetime <= '{$endDT}'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
        UNION ALL
        SELECT CONCAT(partner,'et'), 0, 0, 0, 0, 0, COUNT(*)
        FROM fashionbardb_airg_et.advertcallback
        WHERE advertdatetime >= '{$startDT}' AND advertdatetime <= '{$endDT}'
          AND action = 'act'
          AND partner NOT IN ('svmobi','svmobigpub') GROUP BY partner
    ) a";
}

// ─────────────────────────────────────────────────────────────────────────────
// Process form
// ─────────────────────────────────────────────────────────────────────────────

$type       = 'advertiser';
$start_date = date('d-m-Y');
$end_date   = date('d-m-Y');
$hour       = '24';
$submitted  = false;
$result     = null;
$commondb   = 'commondb';
$product    = 'glamour';

if (isset($_POST['submit'])) {
    $submitted  = true;
    $type       = strtolower($_POST['type']    ?? 'advertiser');
    $start_date = trim($_POST['start_date']    ?? date('d-m-Y'));
    $end_date   = trim($_POST['end_date']       ?? date('d-m-Y'));
    $hour       = trim($_POST['hour']           ?? '24');

    $startDT = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT   = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';

    // Optional cron include
    $cronPath = dirname(dirname(dirname(__DIR__))) . '/adnetwork_admin/actcron.php';
    if (file_exists($cronPath)) include $cronPath;

    // Fetch active operators once
    $operators = [];
    $res_ops = $conn->query("
        SELECT operator_id, country_name, operator_tbl.country_id, operator
        FROM {$commondb}.country_tbl
        INNER JOIN {$commondb}.operator_tbl ON country_tbl.country_id = operator_tbl.country_id
        WHERE operator_tbl.isactive = 1
    ");
    if ($res_ops) {
        while ($row = $res_ops->fetch()) $operators[] = $row;
    }
    $num = count($operators);

    if ($type === 'publisher') {
        $sql = buildPublisherSql($operators, $num, $startDT, $endDT, $hour, $product, $commondb, $conn);
    } elseif ($type === 'advertiser') {
        $sql = buildAdvertiserSql($operators, $num, $startDT, $endDT, $hour, $product, $commondb, $conn);
    } else {
        $sql = buildApiSql($startDT, $endDT);
    }

    if (!empty($sql)) {
        $result = $conn->query($sql);
    }
}
?>
<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<div class="hp-main">
<?php include('../includes/top_navigation.php'); ?>
<div class="hp-content">

<!-- ─── Filter Card ──────────────────────────────────────────────────────────── -->
<div class="hp-card hp-filter-card">
    <div class="hp-card-header">
        <h4><i class="fa fa-th"></i> All in One Report</h4>
    </div>
    <div class="hp-card-body">
        <form method="post" id="aioForm">
            <div class="row">

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Publisher / Advertiser</label>
                        <select name="type" class="form-control">
                            <option value="advertiser" <?= $type === 'advertiser' ? 'selected' : '' ?>>Advertiser</option>
                            <option value="publisher"  <?= $type === 'publisher'  ? 'selected' : '' ?>>Publisher</option>
                            <option value="api"        <?= $type === 'api'        ? 'selected' : '' ?>>API</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Start Date</label>
                        <input type="text" name="start_date" class="form-control birthday"
                               value="<?= htmlspecialchars($start_date) ?>">
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">End Date</label>
                        <input type="text" name="end_date" class="form-control birthday"
                               value="<?= htmlspecialchars($end_date) ?>">
                    </div>
                </div>

                <div class="col-md-1 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">Hour</label>
                        <select name="hour" class="form-control">
                            <?php for ($i = 24; $i > 0; $i--): ?>
                                <option value="<?= $i ?>" <?= (string)$i === $hour ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-1 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label class="hp-filter-label">&nbsp;</label>
                        <button type="submit" name="submit" class="btn-submit-report">
                            <i class="fa fa-search"></i> Submit
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<?php if ($submitted && $result): ?>

<!-- ─── Results Card ─────────────────────────────────────────────────────────── -->
<div class="hp-card" style="margin-top:16px;">
    <div class="hp-card-header">
        <h4><i class="fa fa-table"></i> Output Records
            <small style="font-size:12px;color:#a0aec0;margin-left:8px;">
                <?= htmlspecialchars(ucfirst($type)) ?> &mdash;
                <?= htmlspecialchars($start_date) ?> to <?= htmlspecialchars($end_date) ?>
            </small>
        </h4>
    </div>
    <div class="hp-card-body" style="padding:0;overflow-x:auto;">

    <?php if ($type === 'advertiser'): ?>
    <?php
        $totalCols = $result->columnCount();
        $colNames  = [];
        for ($i = 0; $i < $totalCols; $i++) {
            $meta = $result->getColumnMeta($i);
            $colNames[$i] = $meta['name'];
        }
        $allRows     = $result->fetchAll(PDO::FETCH_ASSOC);
        $check1      = []; // count totals
        $check2      = []; // amount totals
        $grandTotal1 = 0;
        $grandTotal2 = 0;
    ?>
    <table class="table table-striped table-bordered" style="font-size:12.5px;min-width:800px;">
        <thead>
            <tr style="background:#4a5568;color:#fff;text-align:center;">
                <?php foreach ($colNames as $i => $name): ?>
                    <?php if (substr($name, -4) !== '_amt'): ?>
                        <th style="white-space:nowrap;"><?= htmlspecialchars($name) ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allRows as $row):
            $rowSum1 = 0; $rowSum2 = 0;
        ?>
            <tr>
            <?php foreach ($colNames as $i => $name):
                if (substr($name, -4) === '_amt') {
                    $check2[$i] = ($check2[$i] ?? 0) + (float)$row[$name];
                    continue;
                }
                $val     = $row[$name];
                $amtName = $colNames[$i - 1] ?? '';
                $amtVal  = ($amtName && substr($amtName, -4) === '_amt') ? (float)$row[$amtName] : null;
                if ($i > 0) $check1[$i] = ($check1[$i] ?? 0) + (int)$val;
            ?>
                <td style="text-align:center;white-space:nowrap;">
                <?php if ($i === 0): ?>
                    <strong><?= htmlspecialchars($val) ?></strong>
                <?php elseif ($val === '' || $val === null): ?>
                    0
                <?php elseif ($amtVal !== null): ?>
                    <?= '$' . number_format($amtVal, 2) . ' || ' . $val ?>
                    <?php $rowSum1 += $amtVal; $rowSum2 += (int)$val; ?>
                <?php else: ?>
                    <?= htmlspecialchars($val) ?>
                <?php endif; ?>
                </td>
            <?php endforeach; ?>
                <td style="text-align:center;white-space:nowrap;font-weight:600;">
                    $<?= number_format($rowSum1, 2) ?> || <?= $rowSum2 ?>
                </td>
            <?php $grandTotal1 += $rowSum1; $grandTotal2 += $rowSum2; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:#edf2f7;font-weight:700;text-align:center;">
                <td style="text-align:left;"><strong>Total</strong></td>
                <?php foreach ($colNames as $i => $name): ?>
                    <?php if ($i === 0) continue; ?>
                    <?php if (substr($name, -4) === '_amt'): ?>
                        <td style="white-space:nowrap;">$<?= number_format($check2[$i] ?? 0, 2) ?> ||</td>
                    <?php else: ?>
                        <td><?= number_format($check1[$i] ?? 0) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td style="white-space:nowrap;">$<?= number_format($grandTotal1, 2) ?> || <?= $grandTotal2 ?></td>
            </tr>
        </tfoot>
    </table>

    <?php elseif ($type === 'publisher'): ?>
    <?php
        $totalCols = $result->columnCount();
        $colNames  = [];
        $colTotals = [];
        for ($i = 0; $i < $totalCols; $i++) {
            $meta = $result->getColumnMeta($i);
            $colNames[$i]  = $meta['name'];
            $colTotals[$i] = 0;
        }
        $allRows  = $result->fetchAll(PDO::FETCH_ASSOC);
        $grandPub = 0;
    ?>
    <table class="table table-striped table-bordered" style="font-size:12.5px;min-width:800px;">
        <thead>
            <tr style="background:#4a5568;color:#fff;text-align:center;">
                <?php foreach ($colNames as $name): ?>
                    <th style="white-space:nowrap;"><?= htmlspecialchars($name) ?></th>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allRows as $row):
            $rowSum = 0;
        ?>
            <tr>
            <?php foreach ($colNames as $i => $name):
                $val = $row[$name];
                if ($i > 0) $colTotals[$i] += (int)$val;
            ?>
                <td style="text-align:center;white-space:nowrap;">
                <?php if ($i === 0): ?>
                    <strong><?= htmlspecialchars($val) ?></strong>
                <?php elseif ($val === '' || $val === null): ?>
                    0
                <?php else: ?>
                    <?= htmlspecialchars($val) ?>
                    <?php $rowSum += (int)$val; ?>
                <?php endif; ?>
                </td>
            <?php endforeach; ?>
                <td style="text-align:center;font-weight:600;"><?= $rowSum ?></td>
            <?php $grandPub += $rowSum; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:#edf2f7;font-weight:700;text-align:center;">
                <?php foreach ($colNames as $i => $name): ?>
                    <td><?= $i === 0 ? 'Total' : number_format($colTotals[$i]) ?></td>
                <?php endforeach; ?>
                <td><?= number_format($grandPub) ?></td>
            </tr>
        </tfoot>
    </table>

    <?php else: // API / Partner ?>
    <?php
        $allRows = $result->fetchAll(PDO::FETCH_ASSOC);
        $keys    = ['sa','om','ae','ps','pl','et'];
        $amtKeys = ['saamt'=>'saamount','omamt'=>'omamount','aeamt'=>'aeamount','psamt'=>'psamount','plamt'=>'plamount','etamt'=>'etamount'];
        $totals  = array_fill_keys(array_merge($keys, array_keys($amtKeys)), 0);
    ?>
    <table class="table table-striped table-bordered" style="font-size:12.5px;">
        <thead>
            <tr style="background:#4a5568;color:#fff;text-align:center;">
                <th>Partner</th>
                <?php foreach (array_map('strtoupper', $keys) as $h): ?><th><?= $h ?></th><?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allRows as $r):
            $vals    = array_map(fn($k) => (int)$r[$k],       $keys);
            $amts    = array_map(fn($v) => (float)$r[$v],     array_values($amtKeys));
            $rowTot  = array_sum($vals);
            $rowAmt  = array_sum($amts);
            foreach ($keys as $j => $k) { $totals[$k] += $vals[$j]; }
            foreach (array_keys($amtKeys) as $j => $ak) { $totals[$ak] += $amts[$j]; }
        ?>
            <tr>
                <td style="font-weight:600;"><?= strtoupper(htmlspecialchars($r['partner'])) ?></td>
                <?php foreach ($keys as $j => $k): ?>
                    <td style="text-align:center;white-space:nowrap;">
                        <?= $vals[$j] === 0 ? '0' : $vals[$j] . ' || $' . number_format($amts[$j], 2) ?>
                    </td>
                <?php endforeach; ?>
                <td style="text-align:center;font-weight:600;white-space:nowrap;">
                    <?= $rowTot ?> || $<?= number_format($rowAmt, 2) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:#edf2f7;font-weight:700;text-align:center;">
                <td>TOTAL</td>
                <?php foreach ($keys as $j => $k): ?>
                    <?php $ak = array_keys($amtKeys)[$j]; ?>
                    <td style="white-space:nowrap;">
                        <?= $totals[$k] === 0 ? '0' : $totals[$k] . ' || $' . number_format($totals[$ak], 2) ?>
                    </td>
                <?php endforeach; ?>
                <?php
                    $gt  = array_sum(array_map(fn($k) => $totals[$k], $keys));
                    $gta = array_sum(array_map(fn($k) => $totals[$k], array_keys($amtKeys)));
                ?>
                <td style="white-space:nowrap;"><?= $gt ?> || $<?= number_format($gta, 2) ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>

    </div><!-- /.hp-card-body -->
</div><!-- /.hp-card -->

<?php elseif ($submitted): ?>
<div class="hp-card" style="margin-top:16px;">
    <div class="hp-card-body" style="text-align:center;padding:48px;color:#a0aec0;">
        <i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:12px;"></i>
        No data found for the selected filters.
    </div>
</div>
<?php endif; ?>

</div><!-- /.hp-content -->
</div><!-- /.hp-main -->

<?php include('../includes/footer.php'); ?>
