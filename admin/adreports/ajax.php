<?php
// Centralized AJAX handler for admin/adreports/* pages
// All adreports AJAX calls POST here with an 'action' field.

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['username'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'session_expired']);
    exit;
}

// PDO connection (adnetwork_admin) — ob_start guards against stray output from connection.php
$conn = null;
ob_start();
try {
    include(dirname(dirname(dirname(__DIR__))) . '/adnetwork_admin/includes/connection.php');
} catch (Exception $e) { /* connection failed, $conn stays null */ }
ob_end_clean();

header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection unavailable']);
    exit;
}

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

function validateDate(string $d): bool
{
    return (bool)preg_match('/^\d{2}-\d{2}-\d{4}$/', $d);
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: all_in_one_report
// ─────────────────────────────────────────────────────────────────────────────

function action_all_in_one_report(PDO $conn): void
{
    $type       = strtolower(trim($_POST['type']       ?? 'advertiser'));
    $start_date = trim($_POST['start_date']             ?? '');
    $end_date   = trim($_POST['end_date']               ?? '');
    $hour       = (int)($_POST['hour']                  ?? 24);
    $commondb   = 'commondb';
    $product    = 'glamour';

    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (expected DD-MM-YYYY)']);
        return;
    }
    if ($hour < 1 || $hour > 24) $hour = 24;

    $startDT = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT   = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';

    try {
        if ($type === 'api') {
            $result = aio_api($conn, $startDT, $endDT, $start_date, $end_date);
        } else {
            $operators = [];
            $res = $conn->query("
                SELECT operator_id, country_name, operator_tbl.country_id, operator
                FROM {$commondb}.country_tbl
                INNER JOIN {$commondb}.operator_tbl
                        ON country_tbl.country_id = operator_tbl.country_id
                WHERE operator_tbl.isactive = 1
            ");
            if ($res) while ($row = $res->fetch(PDO::FETCH_ASSOC)) $operators[] = $row;

            if ($type === 'publisher') {
                $result = aio_publisher($conn, $operators, $startDT, $endDT, $hour, $product, $commondb, $start_date, $end_date);
            } else {
                $result = aio_advertiser($conn, $operators, $startDT, $endDT, $hour, $product, $commondb, $start_date, $end_date);
            }
        }
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function aio_advertiser(PDO $conn, array $operators, string $startDT, string $endDT, int $hour, string $product, string $commondb, string $start_date, string $end_date): array
{
    $num     = count($operators);
    $opNames = array_column($operators, 'operator');
    $base    = ['success' => true, 'type' => 'advertiser', 'ops' => $opNames, 'rows' => [], 'totals' => ['ops' => [], 'total_count' => 0, 'total_amount' => 0.0], 'start_date' => $start_date, 'end_date' => $end_date];

    if ($num === 0) return $base;

    // Build pivot SELECT
    $select = 'SELECT advertiser_name, ';
    foreach ($operators as $i => $op) {
        $oid   = (int)$op['operator_id'];
        $name  = $op['operator'];
        $comma = ($i < $num - 1) ? ',' : '';
        $select .= "CASE WHEN operator = {$oid} THEN SUM(s) END `{$name}_amt`,
                    CASE WHEN operator = {$oid} THEN SUM(c) END `{$name}`{$comma} ";
    }
    $select .= ' FROM (';

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
                  AND HOUR(ad_resp_datetime) <= {$hour}
                  AND action = 'act'
            ) a{$idx}
            GROUP BY campaign_id, operator";
    }

    if (empty($parts)) return $base;

    $sql  = $select . implode(' UNION ', $parts) . ') a GROUP BY advertiser_name, operator ORDER BY advertiser_name';
    $stmt = $conn->query($sql);
    if (!$stmt) return $base;

    // Aggregate: one row per advertiser across all operators
    $byName = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['advertiser_name'];
        if (!isset($byName[$name])) {
            $byName[$name] = [];
            foreach ($opNames as $op) $byName[$name][$op] = ['count' => 0, 'amount' => 0.0];
        }
        foreach ($opNames as $op) {
            if (isset($row[$op]) && $row[$op] !== null) {
                $byName[$name][$op]['count']  += (int)$row[$op];
                $byName[$name][$op]['amount'] += (float)($row[$op . '_amt'] ?? 0);
            }
        }
    }

    $opTotals    = [];
    foreach ($opNames as $op) $opTotals[$op] = ['count' => 0, 'amount' => 0.0];
    $grandCount  = 0;
    $grandAmount = 0.0;
    $rows        = [];

    foreach ($byName as $name => $ops) {
        $rowCount = 0; $rowAmount = 0.0;
        $opArr    = [];
        foreach ($opNames as $op) {
            $c = $ops[$op]['count'];
            $a = $ops[$op]['amount'];
            $opArr[] = ['count' => $c, 'amount' => round($a, 2)];
            $opTotals[$op]['count']  += $c;
            $opTotals[$op]['amount'] += $a;
            $rowCount  += $c;
            $rowAmount += $a;
        }
        $rows[]      = ['name' => $name, 'ops' => $opArr, 'total_count' => $rowCount, 'total_amount' => round($rowAmount, 2)];
        $grandCount  += $rowCount;
        $grandAmount += $rowAmount;
    }

    $totOps = [];
    foreach ($opNames as $op) {
        $totOps[] = ['count' => $opTotals[$op]['count'], 'amount' => round($opTotals[$op]['amount'], 2)];
    }

    return array_merge($base, [
        'rows'   => $rows,
        'totals' => ['ops' => $totOps, 'total_count' => $grandCount, 'total_amount' => round($grandAmount, 2)],
    ]);
}

function aio_publisher(PDO $conn, array $operators, string $startDT, string $endDT, int $hour, string $product, string $commondb, string $start_date, string $end_date): array
{
    $num     = count($operators);
    $opNames = array_column($operators, 'operator');
    $base    = ['success' => true, 'type' => 'publisher', 'ops' => $opNames, 'rows' => [], 'totals' => ['ops' => array_fill(0, $num, 0), 'total' => 0], 'start_date' => $start_date, 'end_date' => $end_date];

    if ($num === 0) return $base;

    $select = 'SELECT publisher_name, ';
    foreach ($operators as $i => $op) {
        $oid   = (int)$op['operator_id'];
        $name  = $op['operator'];
        $comma = ($i < $num - 1) ? ',' : '';
        $select .= "CASE WHEN operator = {$oid} THEN SUM(c) END `{$name}`{$comma} ";
    }
    $select .= ' FROM (';

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
              AND HOUR(ad_resp_datetime) <= {$hour}
              AND action = 'act'
            GROUP BY advertiser_id, operator";
    }

    if (empty($parts)) return $base;

    $sql  = $select . implode(' UNION ', $parts) . ') a GROUP BY publisher_name, operator ORDER BY publisher_name';
    $stmt = $conn->query($sql);
    if (!$stmt) return $base;

    $byName = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['publisher_name'];
        if (!isset($byName[$name])) $byName[$name] = array_fill(0, $num, 0);
        foreach ($opNames as $i => $op) {
            if (isset($row[$op]) && $row[$op] !== null) $byName[$name][$i] += (int)$row[$op];
        }
    }

    $opTotals   = array_fill(0, $num, 0);
    $grandTotal = 0;
    $rows       = [];

    foreach ($byName as $name => $ops) {
        $rowTotal = array_sum($ops);
        for ($i = 0; $i < $num; $i++) $opTotals[$i] += $ops[$i];
        $grandTotal += $rowTotal;
        $rows[]      = ['name' => $name, 'ops' => $ops, 'total' => $rowTotal];
    }

    return array_merge($base, [
        'rows'   => $rows,
        'totals' => ['ops' => $opTotals, 'total' => $grandTotal],
    ]);
}

function aio_api(PDO $conn, string $startDT, string $endDT, string $start_date, string $end_date): array
{
    $sql = "SELECT partner,
        sa,   CASE WHEN partner='svmobisa'  THEN sa*0   ELSE sa*2   END saamount,
        om,   CASE WHEN partner='svmobiom'  THEN om*0   ELSE om*2.3 END omamount,
        ae,   CASE WHEN partner='svmobiae'  THEN ae*0   ELSE ae*3.4 END aeamount,
        ps,   CASE WHEN partner='linkitps'  THEN ps*0.7
                   WHEN partner='airgps'    THEN ps*2
                   ELSE ps*3 END psamount,
        pl,   CASE WHEN partner='linkitps'  THEN pl*0.7
                   WHEN partner='airgps'    THEN pl*2
                   ELSE pl*3 END plamount,
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

    $stmt = $conn->query($sql);
    $base = ['success' => true, 'type' => 'api', 'rows' => [], 'totals' => ['countries' => [], 'total_count' => 0, 'total_amount' => 0.0], 'start_date' => $start_date, 'end_date' => $end_date];
    if (!$stmt) return $base;

    $keys    = ['sa',  'om',  'ae',  'ps',  'pl',  'et'];
    $amtKeys = ['saamount','omamount','aeamount','psamount','plamount','etamount'];
    $labels  = ['SA',  'OM',  'AE',  'PS',  'PL',  'ET'];
    $totC    = array_fill(0, 6, 0);
    $totA    = array_fill(0, 6, 0.0);
    $rows    = [];

    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $countries = [];
        $rowCount  = 0;
        $rowAmt    = 0.0;
        foreach ($keys as $i => $k) {
            $c = (int)$r[$k];
            $a = (float)$r[$amtKeys[$i]];
            $countries[] = ['label' => $labels[$i], 'count' => $c, 'amount' => round($a, 2)];
            $totC[$i] += $c;
            $totA[$i] += $a;
            $rowCount  += $c;
            $rowAmt    += $a;
        }
        $rows[] = ['partner' => strtoupper($r['partner']), 'countries' => $countries, 'total_count' => $rowCount, 'total_amount' => round($rowAmt, 2)];
    }

    $totCountries = [];
    foreach ($labels as $i => $l) {
        $totCountries[] = ['label' => $l, 'count' => $totC[$i], 'amount' => round($totA[$i], 2)];
    }

    return array_merge($base, [
        'rows'   => $rows,
        'totals' => ['countries' => $totCountries, 'total_count' => array_sum($totC), 'total_amount' => round(array_sum($totA), 2)],
    ]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: report — get operators for a country
// ─────────────────────────────────────────────────────────────────────────────

function action_report_get_operators(PDO $conn): void
{
    $country_id = (int)($_POST['country_id'] ?? 0);
    if (!$country_id) { echo json_encode(['success' => false, 'error' => 'Missing country']); return; }

    $stmt = $conn->prepare("SELECT operator_id, operator FROM commondb.operator_tbl WHERE country_id = ? ORDER BY operator");
    $stmt->execute([$country_id]);
    echo json_encode(['success' => true, 'operators' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: report — get publisher/advertiser names for an operator+type
// ─────────────────────────────────────────────────────────────────────────────

function action_report_get_names(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $type        = strtolower(trim($_POST['type'] ?? ''));

    if (!$operator_id || !$type) { echo json_encode(['success' => false, 'error' => 'Missing params']); return; }

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ?");
    $stmt->execute([$operator_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($row['operator'], 'glamour');

    if ($type === 'advertiser') {
        if (!dbExists($conn, $logdb)) { echo json_encode(['success' => true, 'items' => []]); return; }
        $res   = $conn->query("SELECT campaign_id id, campaign_title name FROM {$logdb}.campaign_tbl ORDER BY campaign_title");
    } else {
        $res   = $conn->query("SELECT advertiser_id id, advertiser_name name FROM commondb.advertiser_tbl ORDER BY advertiser_name");
    }

    echo json_encode(['success' => true, 'items' => $res ? $res->fetchAll(PDO::FETCH_ASSOC) : []]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: report — run main date-wise report
// ─────────────────────────────────────────────────────────────────────────────

function action_report_data(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $type        = strtolower(trim($_POST['type']       ?? ''));
    $id          = trim($_POST['id']                    ?? 'all');
    $start_date  = trim($_POST['start_date']            ?? '');
    $end_date    = trim($_POST['end_date']              ?? '');

    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']);
        return;
    }
    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']);
        return;
    }

    $startDT = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT   = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';
    $id      = ($id === 'all') ? 'all' : (string)(int)$id;

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ?");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb    = logDbName($opRow['operator'], 'glamour');
    $commondb = 'commondb';

    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database found for operator: ' . $opRow['operator']]);
        return;
    }

    $condition = '';
    if ($id !== 'all' && $id !== '') {
        $condition = ($type === 'advertiser')
            ? "AND campaign_tbl.campaign_id = '{$id}'"
            : "AND advertiser_tbl.advertiser_id = '{$id}'";
    }

    try {
        $sql = ($type === 'advertiser')
            ? report_sql_advertiser($logdb, $startDT, $endDT, $condition)
            : report_sql_publisher($logdb, $commondb, $startDT, $endDT, $condition);

        $res = $conn->query($sql);
        if (!$res) { echo json_encode(['success' => false, 'error' => 'Query failed']); return; }

        $rows = [];
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = [
                'dt'         => date('d-m-Y', strtotime($row['dt'])),
                'title'      => $row['title'],
                'clicks'     => (int)$row['clicks'],
                'sameday'    => (int)$row['sameday'],
                'act'        => (int)$row['act'],
                'samedaydct' => (int)$row['samedaydct'],
                'dct'        => (int)$row['dct'],
                'cbr'        => (int)$row['cbr'],
            ];
        }

        echo json_encode([
            'success'    => true,
            'rows'       => $rows,
            'operator'   => $opRow['operator'],
            'type'       => $type,
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function report_sql_advertiser(string $logdb, string $startDT, string $endDT, string $condition): string
{
    return "SELECT dt1 dt,
        CASE WHEN campaign_title IS NULL THEN 'OTHER' ELSE campaign_title END title,
        SUM(clicks) clicks, SUM(sameday) sameday, SUM(act) act,
        SUM(samedaydct) samedaydct, SUM(dct) dct, SUM(cbr) cbr
    FROM (
        SELECT COUNT(DISTINCT userlog_tbl.clickid) clicks, 0 sameday, 0 act, 0 samedaydct, 0 dct, 0 cbr,
               DATE(userlog_datetime) dt1, campaign_title
        FROM {$logdb}.userlog_tbl
        LEFT JOIN {$logdb}.campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
        LEFT JOIN {$logdb}.campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
        WHERE userlog_datetime >= '{$startDT}' AND userlog_datetime < '{$endDT}' {$condition}
        GROUP BY dt1, campaign_title
        UNION
        SELECT 0, COUNT(s.clickid), 0, 0, 0, 0, s.dt, s.campaign_title
        FROM (SELECT DISTINCT r.clickid, DATE(r.camp_resp_datetime) dt, t.campaign_title
              FROM {$logdb}.campaign_response_tbl r
              LEFT JOIN {$logdb}.userlog_tbl u ON u.clickid = r.clickid
              LEFT JOIN {$logdb}.campaign_tbl t ON t.campaign_id = r.campaign_id
              WHERE r.camp_resp_datetime >= '{$startDT}' AND r.camp_resp_datetime <= '{$endDT}'
                AND DATE(r.camp_resp_datetime) = DATE(u.userlog_datetime)
                AND r.camp_action = 'act' {$condition}) s
        GROUP BY s.dt, s.campaign_title
        UNION
        SELECT 0, 0, COUNT(a.clickid), 0, 0, 0, a.dt, a.campaign_title
        FROM (SELECT DISTINCT r.clickid, DATE(r.camp_resp_datetime) dt, t.campaign_title
              FROM {$logdb}.campaign_response_tbl r
              LEFT JOIN {$logdb}.campaign_tbl t ON t.campaign_id = r.campaign_id
              WHERE r.camp_resp_datetime >= '{$startDT}' AND r.camp_resp_datetime <= '{$endDT}'
                AND r.camp_action = 'act' {$condition}) a
        GROUP BY a.dt, a.campaign_title
        UNION
        SELECT 0, 0, 0, COUNT(sd.clickid), 0, 0, sd.dt, sd.campaign_title
        FROM (SELECT DISTINCT r.clickid, DATE(r.camp_resp_datetime) dt, t.campaign_title
              FROM {$logdb}.campaign_response_tbl r
              LEFT JOIN {$logdb}.userlog_tbl u ON u.clickid = r.clickid
              LEFT JOIN {$logdb}.campaign_tbl t ON t.campaign_id = r.campaign_id
              WHERE r.camp_resp_datetime >= '{$startDT}' AND r.camp_resp_datetime <= '{$endDT}'
                AND DATE(r.camp_resp_datetime) = DATE(u.userlog_datetime)
                AND r.camp_action = 'dct' {$condition}) sd
        GROUP BY sd.dt, sd.campaign_title
        UNION
        SELECT 0, 0, 0, 0, COUNT(d.clickid), 0, d.dt, d.campaign_title
        FROM (SELECT DISTINCT r.clickid, DATE(r.camp_resp_datetime) dt, t.campaign_title
              FROM {$logdb}.campaign_response_tbl r
              LEFT JOIN {$logdb}.campaign_tbl t ON t.campaign_id = r.campaign_id
              WHERE r.camp_resp_datetime >= '{$startDT}' AND r.camp_resp_datetime <= '{$endDT}'
                AND r.camp_action = 'dct' {$condition}) d
        GROUP BY d.dt, d.campaign_title
        UNION
        SELECT 0, 0, 0, 0, 0, COUNT(b.clickid), b.dt, b.campaign_title
        FROM (SELECT DISTINCT r.clickid, DATE(r.camp_resp_datetime) dt, t.campaign_title
              FROM {$logdb}.campaign_response_tbl r
              LEFT JOIN {$logdb}.campaign_tbl t ON t.campaign_id = r.campaign_id
              WHERE r.camp_resp_datetime >= '{$startDT}' AND r.camp_resp_datetime <= '{$endDT}'
                AND r.camp_action = 'act' {$condition}) b
        GROUP BY b.dt, b.campaign_title
    ) a
    GROUP BY dt1, campaign_title";
}

function report_sql_publisher(string $logdb, string $commondb, string $startDT, string $endDT, string $condition): string
{
    return "SELECT dt1 dt,
        CASE WHEN advertiser_name IS NULL THEN 'OTHER' ELSE advertiser_name END title,
        SUM(clicks) clicks, SUM(sameday) sameday, SUM(act) act,
        SUM(samedaydct) samedaydct, SUM(dct) dct, SUM(cbr) cbr
    FROM (
        SELECT COUNT(u.clickid) clicks, 0 sameday, 0 act, 0 samedaydct, 0 dct, 0 cbr,
               DATE(u.userlog_datetime) dt1, at.advertiser_name
        FROM {$logdb}.userlog_tbl u
        LEFT JOIN {$logdb}.campaign_request_tbl cr ON u.clickid = cr.clickid
        LEFT JOIN {$commondb}.advertiser_tbl at ON cr.advertiser_id = at.advertiser_id
        WHERE u.userlog_datetime >= '{$startDT}' AND u.userlog_datetime <= '{$endDT}' {$condition}
        GROUP BY dt1, at.advertiser_name
        UNION
        SELECT 0, COUNT(s.clickid), 0, 0, 0, 0, s.dt, s.advertiser_name
        FROM (SELECT DISTINCT r.clickid, DATE(r.ad_resp_datetime) dt, at.advertiser_name
              FROM {$logdb}.advertiser_response_tbl r
              LEFT JOIN {$logdb}.userlog_tbl u ON u.clickid = r.clickid
              LEFT JOIN {$commondb}.advertiser_tbl at ON at.advertiser_id = r.advertiser_id
              WHERE r.ad_resp_datetime >= '{$startDT}' AND r.ad_resp_datetime <= '{$endDT}'
                AND DATE(r.ad_resp_datetime) = DATE(u.userlog_datetime)
                AND r.action = 'act' {$condition}) s
        GROUP BY s.dt, s.advertiser_name
        UNION
        SELECT 0, 0, COUNT(DISTINCT a.clickid), 0, 0, 0, a.dt, a.advertiser_name
        FROM (SELECT DISTINCT r.clickid, DATE(r.ad_resp_datetime) dt, at.advertiser_name
              FROM {$logdb}.advertiser_response_tbl r
              LEFT JOIN {$commondb}.advertiser_tbl at ON at.advertiser_id = r.advertiser_id
              WHERE r.ad_resp_datetime >= '{$startDT}' AND r.ad_resp_datetime <= '{$endDT}'
                AND r.action = 'act' {$condition}) a
        GROUP BY a.dt, a.advertiser_name
        UNION
        SELECT 0, 0, 0, COUNT(sd.clickid), 0, 0, sd.dt, sd.advertiser_name
        FROM (SELECT DISTINCT r.clickid, DATE(r.ad_resp_datetime) dt, at.advertiser_name
              FROM {$logdb}.advertiser_response_tbl r
              LEFT JOIN {$logdb}.userlog_tbl u ON u.clickid = r.clickid
              LEFT JOIN {$commondb}.advertiser_tbl at ON at.advertiser_id = r.advertiser_id
              WHERE r.ad_resp_datetime >= '{$startDT}' AND r.ad_resp_datetime <= '{$endDT}'
                AND DATE(r.ad_resp_datetime) = DATE(u.userlog_datetime)
                AND r.action = 'dct' {$condition}) sd
        GROUP BY sd.dt, sd.advertiser_name
        UNION
        SELECT 0, 0, 0, 0, COUNT(DISTINCT d.clickid), 0, d.dt, d.advertiser_name
        FROM (SELECT DISTINCT r.clickid, DATE(r.ad_resp_datetime) dt, at.advertiser_name
              FROM {$logdb}.advertiser_response_tbl r
              LEFT JOIN {$commondb}.advertiser_tbl at ON at.advertiser_id = r.advertiser_id
              WHERE r.ad_resp_datetime >= '{$startDT}' AND r.ad_resp_datetime <= '{$endDT}'
                AND r.action = 'dct' {$condition}) d
        GROUP BY d.dt, d.advertiser_name
        UNION
        SELECT 0, 0, 0, 0, 0, COUNT(b.clickid), b.dt, b.advertiser_name
        FROM (SELECT DISTINCT r.clickid, DATE(r.ad_resp_datetime) dt, at.advertiser_name
              FROM {$logdb}.advertiser_response_tbl r
              LEFT JOIN {$commondb}.advertiser_tbl at ON at.advertiser_id = r.advertiser_id
              WHERE r.ad_resp_datetime >= '{$startDT}' AND r.ad_resp_datetime <= '{$endDT}'
                AND r.advertiser_response != 'stop' AND r.action = 'act' {$condition}) b
        GROUP BY b.dt, b.advertiser_name
    ) a
    GROUP BY dt1, title";
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: adreport_perform — pivot date-wise perform report
// ─────────────────────────────────────────────────────────────────────────────

function action_adreport_perform(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $type        = strtolower(trim($_POST['type']    ?? ''));
    $id          = trim($_POST['id']                 ?? 'all');
    $start_date  = trim($_POST['start_date']         ?? '');
    $end_date    = trim($_POST['end_date']           ?? '');
    $display     = strtolower(trim($_POST['display'] ?? 'activation'));
    $hour        = (int)($_POST['hour']              ?? 24);

    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']); return;
    }
    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }
    if ($hour < 1 || $hour > 24) $hour = 24;
    if (!in_array($display, ['activation','churn','clicks','cr','cb'])) $display = 'activation';

    $startDT = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT   = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';
    $id      = ($id === 'all') ? 'all' : (string)(int)$id;

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ?");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb    = logDbName($opRow['operator'], 'glamour');
    $commondb = 'commondb';

    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    $condition = '';
    if ($id !== 'all' && $id !== '') {
        $condition = ($type === 'advertiser')
            ? "AND campaign_tbl.campaign_id = '{$id}'"
            : "AND advertiser_tbl.advertiser_id = '{$id}'";
    }

    try {
        $sql = ($type === 'advertiser')
            ? perform_sql_advertiser($display, $logdb, $startDT, $endDT, $hour, $condition)
            : perform_sql_publisher($display, $logdb, $commondb, $startDT, $endDT, $hour, $condition);

        $res = $conn->query($sql);
        if (!$res) { echo json_encode(['success' => false, 'error' => 'Query failed']); return; }

        $pivot = []; $names = []; $dates = [];
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $dt   = date('d-m-Y', strtotime($row['dt']));
            $name = $row['advname'];
            $val  = (float)$row['val'];
            if (!in_array($dt, $dates))   $dates[] = $dt;
            if (!in_array($name, $names)) $names[] = $name;
            $pivot[$dt][$name] = $val;
        }

        $totals = array_fill_keys($names, 0.0);
        $rows   = [];
        foreach ($dates as $dt) {
            $vals  = []; $rowTotal = 0.0;
            foreach ($names as $n) {
                $v = $pivot[$dt][$n] ?? 0.0;
                $vals[] = $v; $totals[$n] += $v; $rowTotal += $v;
            }
            $rows[] = ['dt' => $dt, 'vals' => $vals, 'total' => $rowTotal];
        }

        echo json_encode([
            'success'    => true,
            'type'       => $type,
            'display'    => $display,
            'operator'   => $opRow['operator'],
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'names'      => $names,
            'rows'       => $rows,
            'totals'     => array_values($totals),
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function perform_sql_publisher(string $display, string $logdb, string $commondb, string $startDT, string $endDT, int $hour, string $condition): string
{
    switch ($display) {
        case 'churn':
            return "SELECT DATE(ad_resp_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                COUNT(DISTINCT advertiser_response_tbl.clickid) val
            FROM {$logdb}.advertiser_response_tbl
            LEFT JOIN {$commondb}.advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
            WHERE ad_resp_datetime >= '{$startDT}' AND ad_resp_datetime <= '{$endDT}'
                AND action='dct' AND HOUR(ad_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        case 'clicks':
            return "SELECT DATE(userlog_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                COUNT(DISTINCT userlog_tbl.clickid) val
            FROM {$logdb}.userlog_tbl
            LEFT JOIN {$logdb}.campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
            LEFT JOIN {$commondb}.advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
            WHERE userlog_datetime >= '{$startDT}' AND userlog_datetime <= '{$endDT}'
                AND HOUR(userlog_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        case 'cr':
            return "SELECT c.dt, COALESCE(c.advname,'OTHER') advname,
                CASE WHEN c.clicks > 0 THEN ROUND((COALESCE(a.act,0)/c.clicks)*100,2) ELSE 0 END val
            FROM (
                SELECT DATE(adlog_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                    COUNT(advertiserlog_tbl.clickid) clicks
                FROM {$logdb}.advertiserlog_tbl
                LEFT JOIN {$logdb}.campaign_request_tbl ON advertiserlog_tbl.clickid = campaign_request_tbl.clickid
                LEFT JOIN {$commondb}.advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
                WHERE adlog_datetime >= '{$startDT}' AND adlog_datetime <= '{$endDT}'
                    AND HOUR(adlog_datetime) <= {$hour} {$condition}
                GROUP BY dt, advname
            ) c
            LEFT JOIN (
                SELECT DATE(ad_resp_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                    COUNT(DISTINCT advertiser_response_tbl.clickid) act
                FROM {$logdb}.advertiser_response_tbl
                LEFT JOIN {$commondb}.advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
                WHERE ad_resp_datetime >= '{$startDT}' AND ad_resp_datetime <= '{$endDT}'
                    AND action='act' AND HOUR(ad_resp_datetime) <= {$hour} {$condition}
                GROUP BY dt, advname
            ) a ON c.dt=a.dt AND c.advname=a.advname
            ORDER BY c.dt, c.advname";

        case 'cb':
            return "SELECT DATE(ad_resp_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                COUNT(DISTINCT advertiser_response_tbl.clickid) val
            FROM {$logdb}.advertiser_response_tbl
            LEFT JOIN {$commondb}.advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
            WHERE ad_resp_datetime >= '{$startDT}' AND ad_resp_datetime <= '{$endDT}'
                AND advertiser_response != 'stop' AND action='act'
                AND HOUR(ad_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        default: // activation
            return "SELECT DATE(ad_resp_datetime) dt, COALESCE(advertiser_name,'OTHER') advname,
                COUNT(DISTINCT advertiser_response_tbl.clickid) val
            FROM {$logdb}.advertiser_response_tbl
            LEFT JOIN {$commondb}.advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
            WHERE ad_resp_datetime >= '{$startDT}' AND ad_resp_datetime <= '{$endDT}'
                AND action='act' AND HOUR(ad_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";
    }
}

function perform_sql_advertiser(string $display, string $logdb, string $startDT, string $endDT, int $hour, string $condition): string
{
    switch ($display) {
        case 'churn':
            return "SELECT DATE(camp_resp_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                COUNT(DISTINCT campaign_response_tbl.clickid) val
            FROM {$logdb}.campaign_response_tbl
            LEFT JOIN {$logdb}.campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
            WHERE camp_resp_datetime >= '{$startDT}' AND camp_resp_datetime <= '{$endDT}'
                AND camp_action='dct' AND HOUR(camp_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        case 'clicks':
            return "SELECT DATE(userlog_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                COUNT(DISTINCT userlog_tbl.clickid) val
            FROM {$logdb}.userlog_tbl
            LEFT JOIN {$logdb}.campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
            LEFT JOIN {$logdb}.campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
            WHERE userlog_datetime >= '{$startDT}' AND userlog_datetime <= '{$endDT}'
                AND HOUR(userlog_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        case 'cr':
            return "SELECT c.dt, COALESCE(c.advname,'OTHER') advname,
                CASE WHEN c.clicks > 0 THEN ROUND((COALESCE(a.act,0)/c.clicks)*100,2) ELSE 0 END val
            FROM (
                SELECT DATE(userlog_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                    COUNT(userlog_tbl.clickid) clicks
                FROM {$logdb}.userlog_tbl
                LEFT JOIN {$logdb}.campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
                LEFT JOIN {$logdb}.campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
                WHERE userlog_datetime >= '{$startDT}' AND userlog_datetime <= '{$endDT}'
                    AND HOUR(userlog_datetime) <= {$hour} {$condition}
                GROUP BY dt, advname
            ) c
            LEFT JOIN (
                SELECT DATE(camp_resp_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                    COUNT(DISTINCT campaign_response_tbl.clickid) act
                FROM {$logdb}.campaign_response_tbl
                LEFT JOIN {$logdb}.campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
                WHERE camp_resp_datetime >= '{$startDT}' AND camp_resp_datetime <= '{$endDT}'
                    AND camp_action='act' AND HOUR(camp_resp_datetime) <= {$hour} {$condition}
                GROUP BY dt, advname
            ) a ON c.dt=a.dt AND c.advname=a.advname
            ORDER BY c.dt, c.advname";

        case 'cb':
            return "SELECT DATE(camp_resp_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                COUNT(DISTINCT campaign_response_tbl.clickid) val
            FROM {$logdb}.campaign_response_tbl
            LEFT JOIN {$logdb}.campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
            WHERE camp_resp_datetime >= '{$startDT}' AND camp_resp_datetime <= '{$endDT}'
                AND HOUR(camp_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";

        default: // activation
            return "SELECT DATE(camp_resp_datetime) dt, COALESCE(campaign_title,'OTHER') advname,
                COUNT(DISTINCT campaign_response_tbl.clickid) val
            FROM {$logdb}.campaign_response_tbl
            LEFT JOIN {$logdb}.campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
            WHERE camp_resp_datetime >= '{$startDT}' AND camp_resp_datetime <= '{$endDT}'
                AND camp_action='act' AND HOUR(camp_resp_datetime) <= {$hour} {$condition}
            GROUP BY dt, advname ORDER BY dt, advname";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Router — add new cases here as adreports pages grow
// ─────────────────────────────────────────────────────────────────────────────

$action = trim($_POST['action'] ?? '');
// ─────────────────────────────────────────────────────────────────────────────
// Action: adreport_adv_pub — Advertiser & Publisher report (campaign × publisher daily counts)
// ─────────────────────────────────────────────────────────────────────────────

function action_adreport_adv_pub(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $start_date  = trim($_POST['start_date']   ?? '');
    $end_date    = trim($_POST['end_date']      ?? '');
    $display     = strtolower(trim($_POST['display'] ?? 'activation'));

    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }
    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']); return;
    }
    if (!in_array($display, ['activation', 'cbs'])) $display = 'activation';

    $startDT = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT   = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb    = logDbName($opRow['operator'], 'glamour');
    $commondb = 'commondb';

    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    $extra = ($display === 'cbs') ? " AND r.advertiser_response != 'stop'" : '';

    try {
        $sql  = "SELECT DATE(r.ad_resp_datetime) AS dt,
                        c.campaign_title AS campaign,
                        a.advertiser_name AS publisher,
                        COUNT(*) AS cnt
                 FROM {$logdb}.advertiser_response_tbl r
                 INNER JOIN {$logdb}.campaign_tbl c ON r.campaign_id = c.campaign_id
                 INNER JOIN {$commondb}.advertiser_tbl a ON r.advertiser_id = a.advertiser_id
                 WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ?{$extra}
                 GROUP BY dt, r.campaign_id, r.advertiser_id
                 ORDER BY dt ASC, c.campaign_title ASC, a.advertiser_name ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$startDT, $endDT]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;
        foreach ($rows as $r) $total += (int)$r['cnt'];

        echo json_encode([
            'success'    => true,
            'operator'   => $opRow['operator'],
            'display'    => $display,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'rows'       => $rows,
            'total'      => $total,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: adreport_trend — Hourly pivot table (Date × Hour) for pub/adv
// ─────────────────────────────────────────────────────────────────────────────

function action_adreport_trend(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $start_date  = trim($_POST['start_date']   ?? '');
    $end_date    = trim($_POST['end_date']      ?? '');
    $type        = strtolower(trim($_POST['type']    ?? 'publisher'));
    $id          = trim($_POST['id']            ?? 'all');
    $display     = strtolower(trim($_POST['display'] ?? 'activation'));

    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }
    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']); return;
    }
    if (!in_array($type, ['publisher', 'advertiser'])) $type = 'publisher';
    if (!in_array($display, ['activation', 'churn', 'cb', 'cr', 'clicks'])) $display = 'activation';

    $startDT  = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT    = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';
    $filterId = ($id !== 'all' && $id !== '') ? (int)$id : 0;

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($opRow['operator'], 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    $sql    = '';
    $params = [];

    if ($type === 'publisher') {
        $idCond      = $filterId ? " AND r.advertiser_id = {$filterId}"   : '';
        $clickIdCond = $filterId ? " AND crt.advertiser_id = {$filterId}" : '';

        switch ($display) {
            case 'activation':
                $sql    = "SELECT COUNT(DISTINCT r.clickid) val, DATE(r.ad_resp_datetime) dt, HOUR(r.ad_resp_datetime) hr
                           FROM {$logdb}.advertiser_response_tbl r
                           WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ? AND r.action = 'act'{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'churn':
                $sql    = "SELECT COUNT(r.clickid) val, DATE(r.ad_resp_datetime) dt, HOUR(r.ad_resp_datetime) hr
                           FROM {$logdb}.advertiser_response_tbl r
                           WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ? AND r.action = 'dct'{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'cb':
                $sql    = "SELECT COUNT(r.clickid) val, DATE(r.ad_resp_datetime) dt, HOUR(r.ad_resp_datetime) hr
                           FROM {$logdb}.advertiser_response_tbl r
                           WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ?
                             AND r.advertiser_response != 'stop' AND r.action = 'act'{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'cr':
                $sql    = "SELECT c.dt, c.hr,
                                  CASE WHEN c.clicks = 0 OR a.acts IS NULL THEN 0
                                       ELSE ROUND((a.acts / c.clicks) * 100, 2) END val
                           FROM (
                               SELECT DATE(u.userlog_datetime) dt, HOUR(u.userlog_datetime) hr, COUNT(u.clickid) clicks
                               FROM {$logdb}.userlog_tbl u
                               LEFT JOIN {$logdb}.campaign_request_tbl crt ON u.clickid = crt.clickid
                               WHERE u.userlog_datetime >= ? AND u.userlog_datetime <= ?{$clickIdCond}
                               GROUP BY dt, hr
                           ) c
                           LEFT JOIN (
                               SELECT DATE(r.ad_resp_datetime) dt, HOUR(r.ad_resp_datetime) hr, COUNT(r.clickid) acts
                               FROM {$logdb}.advertiser_response_tbl r
                               WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ? AND r.action = 'act'{$idCond}
                               GROUP BY dt, hr
                           ) a ON c.dt = a.dt AND c.hr = a.hr
                           ORDER BY c.dt ASC, c.hr ASC";
                $params = [$startDT, $endDT, $startDT, $endDT]; break;
            default: // clicks
                $clickIdCond2 = $filterId ? " AND u.advertiser_id = {$filterId}" : '';
                $sql    = "SELECT COUNT(u.clickid) val, DATE(u.userlog_datetime) dt, HOUR(u.userlog_datetime) hr
                           FROM {$logdb}.userlog_tbl u
                           WHERE u.userlog_datetime >= ? AND u.userlog_datetime <= ?{$clickIdCond2}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT];
        }
    } else {
        $idCond      = $filterId ? " AND r.campaign_id = {$filterId}"     : '';
        $clickIdCond = $filterId ? " AND crt.campaign_id = {$filterId}"   : '';

        switch ($display) {
            case 'activation':
                $sql    = "SELECT COUNT(r.clickid) val, DATE(r.camp_resp_datetime) dt, HOUR(r.camp_resp_datetime) hr
                           FROM {$logdb}.campaign_response_tbl r
                           WHERE r.camp_resp_datetime >= ? AND r.camp_resp_datetime <= ? AND r.camp_action = 'act'{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'churn':
                $sql    = "SELECT COUNT(r.clickid) val, DATE(r.camp_resp_datetime) dt, HOUR(r.camp_resp_datetime) hr
                           FROM {$logdb}.campaign_response_tbl r
                           WHERE r.camp_resp_datetime >= ? AND r.camp_resp_datetime <= ? AND r.camp_action = 'dct'{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'cb':
                $sql    = "SELECT COUNT(r.clickid) val, DATE(r.camp_resp_datetime) dt, HOUR(r.camp_resp_datetime) hr
                           FROM {$logdb}.campaign_response_tbl r
                           WHERE r.camp_resp_datetime >= ? AND r.camp_resp_datetime <= ?{$idCond}
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT]; break;
            case 'cr':
                $sql    = "SELECT c.dt, c.hr,
                                  CASE WHEN c.clicks = 0 OR a.acts IS NULL THEN 0
                                       ELSE ROUND((a.acts / c.clicks) * 100, 2) END val
                           FROM (
                               SELECT DATE(u.userlog_datetime) dt, HOUR(u.userlog_datetime) hr, COUNT(u.clickid) clicks
                               FROM {$logdb}.userlog_tbl u
                               LEFT JOIN {$logdb}.campaign_request_tbl crt ON u.clickid = crt.clickid
                               WHERE u.userlog_datetime >= ? AND u.userlog_datetime <= ?{$clickIdCond}
                               GROUP BY dt, hr
                           ) c
                           LEFT JOIN (
                               SELECT DATE(r.camp_resp_datetime) dt, HOUR(r.camp_resp_datetime) hr, COUNT(r.clickid) acts
                               FROM {$logdb}.campaign_response_tbl r
                               WHERE r.camp_resp_datetime >= ? AND r.camp_resp_datetime <= ? AND r.camp_action = 'act'{$idCond}
                               GROUP BY dt, hr
                           ) a ON c.dt = a.dt AND c.hr = a.hr
                           ORDER BY c.dt ASC, c.hr ASC";
                $params = [$startDT, $endDT, $startDT, $endDT]; break;
            default: // clicks
                $sql    = "SELECT COUNT(u.clickid) val, DATE(u.userlog_datetime) dt, HOUR(u.userlog_datetime) hr
                           FROM {$logdb}.userlog_tbl u
                           WHERE u.userlog_datetime >= ? AND u.userlog_datetime <= ?
                           GROUP BY dt, hr ORDER BY dt ASC, hr ASC";
                $params = [$startDT, $endDT];
        }
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success'    => true,
            'operator'   => $opRow['operator'],
            'type'       => $type,
            'display'    => $display,
            'is_cr'      => ($display === 'cr'),
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'rows'       => $rows,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: adreport_pub_act_dct — PubID-wise Activation & Deactivation
// ─────────────────────────────────────────────────────────────────────────────

function action_adreport_pub_act_dct(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $start_date  = trim($_POST['start_date']   ?? '');
    $end_date    = trim($_POST['end_date']      ?? '');
    $type        = strtolower(trim($_POST['type'] ?? 'publisher'));
    $id          = trim($_POST['id']            ?? 'all');

    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }
    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']); return;
    }
    if (!in_array($type, ['publisher', 'advertiser'])) $type = 'publisher';

    $startDT  = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT    = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';
    $filterId = ($id !== 'all' && $id !== '') ? (int)$id : 0;

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($opRow['operator'], 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    if ($type === 'publisher') {
        $actIdCond   = $filterId ? " AND r.advertiser_id = {$filterId}" : '';
        $clkIdCond   = $filterId ? " AND u.advertiser_id = {$filterId}" : '';

        $sql = "SELECT a.dt, a.pubid,
                       COALESCE(a.advertiser_name, 'OTHER') title,
                       COALESCE(c.clicks, 0) clicks,
                       a.act act
                FROM (
                    SELECT COUNT(DISTINCT r.clickid) act,
                           DATE(r.ad_resp_datetime) dt,
                           adv.advertiser_name,
                           r.pubid
                    FROM {$logdb}.advertiser_response_tbl r
                    LEFT JOIN commondb.advertiser_tbl adv ON adv.advertiser_id = r.advertiser_id
                    WHERE r.ad_resp_datetime >= ? AND r.ad_resp_datetime <= ?
                      AND r.action = 'act'{$actIdCond}
                    GROUP BY r.pubid, adv.advertiser_name, dt
                ) a
                LEFT JOIN (
                    SELECT COUNT(u.clickid) clicks,
                           DATE(u.userlog_datetime) dt,
                           adv.advertiser_name,
                           u.pubid
                    FROM {$logdb}.userlog_tbl u
                    LEFT JOIN commondb.advertiser_tbl adv ON adv.advertiser_id = u.advertiser_id
                    WHERE u.userlog_datetime >= ? AND u.userlog_datetime <= ?{$clkIdCond}
                    GROUP BY u.pubid, adv.advertiser_name, dt
                ) c ON a.dt = c.dt AND a.advertiser_name = c.advertiser_name AND a.pubid = c.pubid
                ORDER BY a.dt ASC, a.pubid ASC";
    } else {
        $actIdCond   = $filterId ? " AND r.campaign_id = {$filterId}"   : '';
        $clkIdCond   = $filterId ? " AND crt.campaign_id = {$filterId}" : '';

        $sql = "SELECT a.dt, a.pubid,
                       COALESCE(a.campaign_title, 'OTHER') title,
                       COALESCE(c.clicks, 0) clicks,
                       a.act act
                FROM (
                    SELECT COUNT(DISTINCT r.clickid) act,
                           DATE(r.camp_resp_datetime) dt,
                           ct.campaign_title,
                           r.pubid
                    FROM {$logdb}.campaign_response_tbl r
                    LEFT JOIN {$logdb}.campaign_tbl ct ON ct.campaign_id = r.campaign_id
                    WHERE r.camp_resp_datetime >= ? AND r.camp_resp_datetime <= ?
                      AND r.camp_action = 'act'{$actIdCond}
                    GROUP BY dt, ct.campaign_title, r.pubid
                ) a
                LEFT JOIN (
                    SELECT COUNT(DISTINCT u.clickid) clicks,
                           DATE(crt.camp_req_datetime) dt,
                           ct.campaign_title,
                           crt.pubid
                    FROM {$logdb}.userlog_tbl u
                    LEFT JOIN {$logdb}.campaign_request_tbl crt ON u.clickid = crt.clickid
                    LEFT JOIN {$logdb}.campaign_tbl ct ON crt.campaign_id = ct.campaign_id
                    WHERE crt.camp_req_datetime >= ? AND crt.camp_req_datetime <= ?{$clkIdCond}
                    GROUP BY dt, ct.campaign_title, crt.pubid
                ) c ON a.dt = c.dt AND a.campaign_title = c.campaign_title AND a.pubid = c.pubid
                ORDER BY a.dt ASC, a.pubid ASC";
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$startDT, $endDT, $startDT, $endDT]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalClicks = 0;
        $totalAct    = 0;
        foreach ($rows as $r) {
            $totalClicks += (int)$r['clicks'];
            $totalAct    += (int)$r['act'];
        }

        echo json_encode([
            'success'      => true,
            'operator'     => $opRow['operator'],
            'type'         => $type,
            'start_date'   => $start_date,
            'end_date'     => $end_date,
            'rows'         => $rows,
            'total_clicks' => $totalClicks,
            'total_act'    => $totalAct,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

switch ($action) {
    case 'all_in_one_report':        action_all_in_one_report($conn);        break;
    case 'report_get_operators':     action_report_get_operators($conn);     break;
    case 'report_get_names':         action_report_get_names($conn);         break;
    case 'report_data':              action_report_data($conn);              break;
    case 'adreport_perform':         action_adreport_perform($conn);         break;
    case 'adreport_adv_pub':         action_adreport_adv_pub($conn);         break;
    case 'adreport_trend':           action_adreport_trend($conn);           break;
    case 'adreport_pub_act_dct':     action_adreport_pub_act_dct($conn);     break;
    case 'counter_reset':            action_counter_reset($conn);            break;
    case 'pending_cbs_search':       action_pending_cbs_search($conn);       break;
    case 'pending_cbs_push':         action_pending_cbs_push($conn);         break;
    case 'campaign_add':                action_campaign_add($conn);                break;
    case 'publisher_add':               action_publisher_add($conn);               break;
    case 'campaign_blocking_operators': action_campaign_blocking_operators($conn); break;
    case 'campaign_blocking_load':      action_campaign_blocking_load($conn);      break;
    case 'campaign_blocking_toggle':    action_campaign_blocking_toggle($conn);    break;
    case 'campaign_blocking_update':    action_campaign_blocking_update($conn);    break;
    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
        break;
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: counter_reset — sets counter_no = 0 for selected operator
// ─────────────────────────────────────────────────────────────────────────────

function action_counter_reset(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($opRow['operator'], 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    try {
        $affected = $conn->exec("UPDATE {$logdb}.counter_tbl SET counter_no = 0");
        echo json_encode([
            'success'  => true,
            'operator' => $opRow['operator'],
            'affected' => (int)$affected,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: pending_cbs_search — find clickids stuck in 'stop' with no recovery
// ─────────────────────────────────────────────────────────────────────────────

function action_pending_cbs_search(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $start_date  = trim($_POST['start_date']   ?? '');
    $end_date    = trim($_POST['end_date']      ?? '');
    $type        = strtolower(trim($_POST['type'] ?? 'publisher'));
    $id          = trim($_POST['id']            ?? 'all');

    if (!$operator_id) {
        echo json_encode(['success' => false, 'error' => 'Please select an operator']); return;
    }
    if (!validateDate($start_date) || !validateDate($end_date)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date format (DD-MM-YYYY)']); return;
    }
    if (!in_array($type, ['publisher', 'advertiser'])) $type = 'publisher';

    $startDT  = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
    $endDT    = date('Y-m-d', strtotime($end_date))   . ' 23:59:59';
    $filterId = ($id !== 'all' && $id !== '') ? (int)$id : 0;

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($opRow['operator'], 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator: ' . $opRow['operator']]); return;
    }

    // ID filter applied directly on advertiser_response_tbl columns (no extra join needed)
    $idCond = '';
    if ($filterId) {
        $idCond = ($type === 'advertiser')
            ? " AND r2.campaign_id = {$filterId}"
            : " AND r2.advertiser_id = {$filterId}";
    }

    $sql = "SELECT
                r.ad_resp_id,
                r.advertiser_callbackurl,
                r.ad_resp_datetime dt,
                adv.advertiser_name publisher,
                ct.campaign_title advertiser
            FROM {$logdb}.advertiser_response_tbl r
            INNER JOIN {$logdb}.campaign_tbl ct  ON r.campaign_id  = ct.campaign_id
            INNER JOIN commondb.advertiser_tbl adv ON r.advertiser_id = adv.advertiser_id
            WHERE r.ad_resp_id IN (
                SELECT MAX(r2.ad_resp_id)
                FROM {$logdb}.advertiser_response_tbl r2
                WHERE r2.ad_resp_datetime >= ? AND r2.ad_resp_datetime <= ?
                  AND r2.advertiser_response = 'stop'{$idCond}
                  AND r2.clickid NOT IN (
                      SELECT DISTINCT r3.clickid
                      FROM {$logdb}.advertiser_response_tbl r3
                      WHERE r3.ad_resp_datetime >= ? AND r3.ad_resp_datetime <= ?
                        AND r3.advertiser_response != 'stop'{$idCond}
                  )
                GROUP BY r2.clickid
            )
            ORDER BY r.ad_resp_datetime DESC";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$startDT, $endDT, $startDT, $endDT]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success'    => true,
            'operator'   => $opRow['operator'],
            'operator_id'=> $operator_id,
            'logdb'      => $logdb,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'rows'       => $rows,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: pending_cbs_push — call each callback URL and update response in DB
// ─────────────────────────────────────────────────────────────────────────────

function action_pending_cbs_push(PDO $conn): void
{
    $operator_id = (int)($_POST['operator_id'] ?? 0);
    $ids         = isset($_POST['ids']) && is_array($_POST['ids']) ? $_POST['ids'] : [];
    $ids         = array_values(array_filter(array_map('intval', $ids)));

    if (!$operator_id || empty($ids)) {
        echo json_encode(['success' => false, 'error' => 'No items selected']); return;
    }

    $stmt = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
    $stmt->execute([$operator_id]);
    $opRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$opRow) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

    $logdb = logDbName($opRow['operator'], 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database for operator']); return;
    }

    $ctx     = stream_context_create(['http' => ['timeout' => 10, 'ignore_errors' => true]]);
    $pushed  = 0;
    $failed  = 0;
    $results = [];

    foreach ($ids as $respId) {
        $stmt = $conn->prepare(
            "SELECT ad_resp_id, advertiser_callbackurl
             FROM {$logdb}.advertiser_response_tbl
             WHERE ad_resp_id = ? LIMIT 1"
        );
        $stmt->execute([$respId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || empty($row['advertiser_callbackurl'])) {
            $failed++;
            $results[] = ['id' => $respId, 'status' => 'error', 'response' => 'No URL found'];
            continue;
        }

        $response = @file_get_contents($row['advertiser_callbackurl'], false, $ctx);
        $response = ($response === false) ? 'error' : trim($response);

        $upd = $conn->prepare(
            "UPDATE {$logdb}.advertiser_response_tbl
             SET advertiser_response = ?
             WHERE ad_resp_id = ?"
        );
        $upd->execute([$response, $respId]);

        $pushed++;
        $results[] = ['id' => $respId, 'status' => 'ok', 'response' => $response];
    }

    echo json_encode([
        'success' => true,
        'pushed'  => $pushed,
        'failed'  => $failed,
        'results' => $results,
    ]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: campaign_add — insert campaign into one or more operator DBs
// ─────────────────────────────────────────────────────────────────────────────

function action_campaign_add(PDO $conn): void
{
    header('Content-Type: application/json');
    $product   = 'glamour';
    $operIds   = isset($_POST['operator_ids']) && is_array($_POST['operator_ids'])
                 ? array_map('intval', $_POST['operator_ids']) : [];
    $countryId = (int)($_POST['country_id'] ?? 0);
    $partner   = trim($_POST['partner']    ?? '');
    $title     = trim($_POST['title']      ?? '');
    $price     = (float)($_POST['price']   ?? 10);
    $url       = trim($_POST['url']        ?? '');
    $live      = (int)($_POST['live']      ?? 0);
    $weightage = (float)($_POST['weightage'] ?? 1);
    $browsers  = isset($_POST['browser']) && is_array($_POST['browser'])
                 ? implode(',', array_map('trim', $_POST['browser'])) : '';
    $os        = isset($_POST['os']) && is_array($_POST['os'])
                 ? implode(',', array_map('trim', $_POST['os'])) : '';

    if (!$operIds) { echo json_encode(['success' => false, 'error' => 'Please select at least one operator.']); return; }
    if (!$partner) { echo json_encode(['success' => false, 'error' => 'Campaign Partner is required.']); return; }
    if (!$title)   { echo json_encode(['success' => false, 'error' => 'Campaign Title is required.']); return; }
    if (!$url)     { echo json_encode(['success' => false, 'error' => 'Campaign URL is required.']); return; }
    if ($price  <= 0) $price  = 10;
    if ($weightage <= 0) $weightage = 1;

    $startDT = date('Y-m-d') . ' 00:00:00';
    $endDT   = date('Y-m-d') . ' 23:59:59';

    $results = [];
    foreach ($operIds as $opId) {
        $stOp = $conn->prepare("SELECT operator FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1");
        $stOp->execute([$opId]);
        $opRow = $stOp->fetch(PDO::FETCH_ASSOC);
        if (!$opRow) {
            $results[] = ['operator_id' => $opId, 'operator' => '?', 'status' => 'error', 'msg' => 'Operator not found'];
            continue;
        }
        $opName = $opRow['operator'];
        $logdb  = logDbName($opName, $product);
        if (!dbExists($conn, $logdb)) {
            $results[] = ['operator_id' => $opId, 'operator' => $opName, 'status' => 'error', 'msg' => 'Log DB not found: ' . $logdb];
            continue;
        }
        try {
            $stIns = $conn->prepare(
                "INSERT INTO {$logdb}.campaign_tbl
                 (campaign_partner, campaign_title, campaign_url, campaign_price,
                  campaign_operator, campaign_live, campaign_startdatetime, campaign_enddatetime,
                  campaign_weight, campaign_weight_track, campaign_country, campaign_category,
                  campaign_browser, campaign_os)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
            );
            $stIns->execute([
                $partner, $title, $url, $price,
                $opName, $live, $startDT, $endDT,
                $weightage, $weightage, $countryId, $product,
                $browsers, $os
            ]);
            $campId = (int)$conn->lastInsertId();

            $stPay = $conn->prepare(
                "INSERT INTO commondb.{$product}_advertiser_payout_tbl
                 (operatorid, campaign_id, payout, payout_datetime)
                 VALUES (?,?,?,?)"
            );
            $stPay->execute([$opId, $campId, $price, $startDT]);

            $results[] = ['operator_id' => $opId, 'operator' => $opName, 'status' => 'ok', 'campaign_id' => $campId];
        } catch (PDOException $e) {
            $results[] = ['operator_id' => $opId, 'operator' => $opName, 'status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    $ok  = count(array_filter($results, function ($r) { return $r['status'] === 'ok'; }));
    $err = count($results) - $ok;
    echo json_encode(['success' => true, 'inserted' => $ok, 'failed' => $err, 'results' => $results]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Campaign Blocking — operators list
// Returns: {success, operators: [{operator_id, operator}]}
// ─────────────────────────────────────────────────────────────────────────────
function action_campaign_blocking_operators(PDO $conn): void
{
    $res = $conn->query("SELECT operator_id, operator FROM commondb.operator_tbl ORDER BY operator ASC");
    $ops = $res ? $res->fetchAll(PDO::FETCH_ASSOC) : [];
    echo json_encode(['success' => true, 'operators' => $ops]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Campaign Blocking — load campaign table for an operator
// POST: operator_id, operator, browser, os
// Returns: {success, html}  or  {success:false, error}
// ─────────────────────────────────────────────────────────────────────────────
function action_campaign_blocking_load(PDO $conn): void
{
    $operatorId = (int)($_POST['operator_id'] ?? 0);
    $operator   = strtolower(trim($_POST['operator'] ?? ''));
    $browser    = trim($_POST['browser'] ?? 'all');
    $os         = trim($_POST['os']      ?? 'all');

    if (!$operator) { echo json_encode(['success' => false, 'error' => 'Operator is required']); return; }

    $logdb = logDbName($operator, 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'No database found for operator: ' . $operator]); return;
    }

    $where = "WHERE campaign_operator = " . $conn->quote($operator);
    if ($browser !== '' && $browser !== 'all') $where .= " AND campaign_browser LIKE " . $conn->quote('%' . $browser . '%');
    if ($os      !== '' && $os      !== 'all') $where .= " AND campaign_os LIKE "      . $conn->quote('%' . $os      . '%');

    $res_c = $conn->query(
        "SELECT campaign_id, campaign_title, campaign_live, campaign_url,
                campaign_startdatetime, campaign_enddatetime
         FROM {$logdb}.campaign_tbl {$where} ORDER BY campaign_id ASC"
    );
    if (!$res_c) { echo json_encode(['success' => false, 'error' => 'Query failed']); return; }

    $campaigns = $res_c->fetchAll(PDO::FETCH_ASSOC);
    if (empty($campaigns)) {
        echo json_encode(['success' => true, 'html' =>
            '<div style="padding:40px;text-align:center;color:#a0aec0;">'
          . '<i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:12px;color:#e2e8f0;"></i>'
          . 'No campaigns found for the selected filters.</div>'
        ]);
        return;
    }

    $opId = $operatorId;
    if (!$opId) {
        $stOp = $conn->prepare("SELECT operator_id FROM commondb.operator_tbl WHERE operator = ? LIMIT 1");
        $stOp->execute([$operator]);
        $opRow = $stOp->fetch(PDO::FETCH_ASSOC);
        $opId  = $opRow ? (int)$opRow['operator_id'] : 0;
    }

    ob_start();
    ?>
    <div class="hp-card" style="margin-top:0;">
        <div class="hp-card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <h4 style="margin:0;">
                <i class="fa fa-list"></i>
                Campaigns — <?php echo htmlspecialchars(ucfirst($operator)); ?>
                <span style="font-weight:400;font-size:13px;color:#a0aec0;margin-left:8px;">
                    <?php echo count($campaigns); ?> record(s)
                </span>
            </h4>
            <button id="cb-url-toggle" class="btn btn-sm btn-default" style="font-size:12px;">
                <i class="fa fa-lock"></i><span> Enable URL Edit</span>
            </button>
        </div>
        <div class="hp-card-body" style="padding:0;overflow-x:auto;">
            <table class="table table-striped table-bordered" style="margin:0;font-size:13px;min-width:900px;">
                <thead>
                    <tr style="background:#4a5568;color:#fff;text-align:center;">
                        <th style="width:70px;">Camp ID</th>
                        <th>Title</th>
                        <th style="width:70px;">Block</th>
                        <th>URL</th>
                        <th style="width:100px;">Payout</th>
                        <th style="width:220px;">Time (start/end)</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($campaigns as $c):
                    $cid     = (int)$c['campaign_id'];
                    $blocked = ((string)$c['campaign_live'] !== '1');
                    $time_v  = trim($c['campaign_startdatetime'] ?? '') . '/' . trim($c['campaign_enddatetime'] ?? '');
                    $payout  = '';
                    if ($opId) {
                        $stPay = $conn->prepare(
                            "SELECT payout FROM commondb.glamour_advertiser_payout_tbl
                             WHERE campaign_id = ? AND operatorid = ?
                             ORDER BY adpayoutid DESC LIMIT 1"
                        );
                        $stPay->execute([$cid, $opId]);
                        $payRow = $stPay->fetch(PDO::FETCH_ASSOC);
                        if ($payRow) $payout = $payRow['payout'];
                    }
                ?>
                    <tr>
                        <td style="text-align:center;font-weight:600;"><?php echo $cid; ?></td>
                        <td><?php echo htmlspecialchars($c['campaign_title'] ?? ''); ?></td>
                        <td style="text-align:center;">
                            <input type="checkbox" class="cb-block-chk"
                                   value="<?php echo $cid; ?>"
                                   <?php echo $blocked ? 'checked' : ''; ?>
                                   title="<?php echo $blocked ? 'Blocked — uncheck to make live' : 'Live — check to block'; ?>">
                        </td>
                        <td>
                            <input type="text" class="cb-inline-input url-field"
                                   data-field="url" data-id="<?php echo $cid; ?>"
                                   value="<?php echo htmlspecialchars($c['campaign_url'] ?? ''); ?>"
                                   disabled>
                        </td>
                        <td>
                            <input type="text" class="cb-inline-input"
                                   data-field="payout" data-id="<?php echo $cid; ?>"
                                   value="<?php echo htmlspecialchars($payout); ?>"
                                   placeholder="0.00">
                        </td>
                        <td>
                            <input type="text" class="cb-inline-input"
                                   data-field="time" data-id="<?php echo $cid; ?>"
                                   value="<?php echo htmlspecialchars($time_v); ?>"
                                   placeholder="HH:MM:SS/HH:MM:SS">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    echo json_encode(['success' => true, 'html' => ob_get_clean()]);
}

// ─────────────────────────────────────────────────────────────────────────────
// Campaign Blocking — toggle block / unblock
// POST: operator_id, operator, campaign_id, toggle (block|unblock)
// ─────────────────────────────────────────────────────────────────────────────
function action_campaign_blocking_toggle(PDO $conn): void
{
    $operator   = strtolower(trim($_POST['operator']    ?? ''));
    $campaignId = (int)($_POST['campaign_id'] ?? 0);
    $toggle     = trim($_POST['toggle'] ?? '');

    if (!$operator || !$campaignId || !in_array($toggle, ['block', 'unblock'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid params']); return;
    }

    $logdb = logDbName($operator, 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'Operator DB not found']); return;
    }

    try {
        if ($toggle === 'block') {
            $conn->exec("UPDATE {$logdb}.campaign_tbl SET campaign_live = 0 WHERE campaign_id = {$campaignId}");
            $conn->exec("DELETE FROM {$logdb}.running_campaign_tbl WHERE campaign_id = {$campaignId}");
        } else {
            $conn->exec("UPDATE {$logdb}.campaign_tbl SET campaign_live = 1 WHERE campaign_id = {$campaignId}");
            $res = $conn->query("SELECT COALESCE(MAX(run_camp_id),0)+1 FROM {$logdb}.running_campaign_tbl");
            $nid = $res ? (int)$res->fetchColumn() : 1;
            $conn->exec(
                "INSERT INTO {$logdb}.running_campaign_tbl
                 (run_camp_id, campaign_id, run_camp_operator, run_camp_track)
                 VALUES ({$nid}, {$campaignId}, " . $conn->quote($operator) . ", '0')"
            );
        }
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Campaign Blocking — inline update URL / payout / time
// POST: operator_id, operator, campaign_id, field (url|payout|time), value
// ─────────────────────────────────────────────────────────────────────────────
function action_campaign_blocking_update(PDO $conn): void
{
    $operatorId = (int)($_POST['operator_id'] ?? 0);
    $operator   = strtolower(trim($_POST['operator']    ?? ''));
    $campaignId = (int)($_POST['campaign_id'] ?? 0);
    $field      = trim($_POST['field']  ?? '');
    $value      = trim($_POST['value']  ?? '');

    if (!$operator || !$campaignId || !in_array($field, ['url', 'payout', 'time'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid params']); return;
    }

    $logdb = logDbName($operator, 'glamour');
    if (!dbExists($conn, $logdb)) {
        echo json_encode(['success' => false, 'error' => 'Operator DB not found']); return;
    }

    try {
        if ($field === 'url') {
            $st = $conn->prepare("UPDATE {$logdb}.campaign_tbl SET campaign_url = ? WHERE campaign_id = ?");
            $st->execute([$value, $campaignId]);

        } elseif ($field === 'payout') {
            $opId = $operatorId;
            if (!$opId) {
                $stOp = $conn->prepare("SELECT operator_id FROM commondb.operator_tbl WHERE operator = ? LIMIT 1");
                $stOp->execute([$operator]);
                $opRow = $stOp->fetch(PDO::FETCH_ASSOC);
                $opId  = $opRow ? (int)$opRow['operator_id'] : 0;
            }
            if (!$opId) { echo json_encode(['success' => false, 'error' => 'Operator not found']); return; }

            $stPay = $conn->prepare(
                "INSERT INTO commondb.glamour_advertiser_payout_tbl
                 (operatorid, campaign_id, payout, payout_datetime) VALUES (?,?,?,?)"
            );
            $stPay->execute([$opId, $campaignId, $value, date('Y-m-d H:i:s')]);

            $stUpd = $conn->prepare("UPDATE {$logdb}.campaign_tbl SET campaign_price = ? WHERE campaign_id = ?");
            $stUpd->execute([$value, $campaignId]);

        } elseif ($field === 'time') {
            $parts = explode('/', $value, 2);
            if (count($parts) !== 2) { echo json_encode(['success' => false, 'error' => 'Format: start/end']); return; }
            $st = $conn->prepare(
                "UPDATE {$logdb}.campaign_tbl
                 SET campaign_startdatetime = ?, campaign_enddatetime = ? WHERE campaign_id = ?"
            );
            $st->execute([trim($parts[0]), trim($parts[1]), $campaignId]);
        }

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Action: publisher_add — insert publisher into commondb.advertiser_tbl
//         and advertiser_callback_counter_tbl for each selected operator
// ─────────────────────────────────────────────────────────────────────────────

function action_publisher_add(PDO $conn): void
{
    header('Content-Type: application/json');
    $product   = 'glamour';
    $operIds   = isset($_POST['operator_ids']) && is_array($_POST['operator_ids'])
                 ? array_map('intval', $_POST['operator_ids']) : [];
    $pubName   = trim($_POST['pub_name']     ?? '');
    $pubUrl    = trim($_POST['pub_url']      ?? '');
    $pubDctUrl = trim($_POST['pub_dct_url']  ?? '');
    $redirectUrl = trim($_POST['redirect_url'] ?? 'http://bit.ly/28TEoDR');
    $isActive  = (int)($_POST['is_active']   ?? 1);

    if (!$operIds)  { echo json_encode(['success' => false, 'error' => 'Please select at least one operator.']); return; }
    if (!$pubName)  { echo json_encode(['success' => false, 'error' => 'Publisher Name is required.']); return; }
    if (!$pubUrl)   { echo json_encode(['success' => false, 'error' => 'Activation PostBack URL is required.']); return; }
    if (!$redirectUrl) $redirectUrl = 'http://bit.ly/28TEoDR';

    $results = [];
    foreach ($operIds as $opId) {
        $stOp = $conn->prepare(
            "SELECT operator, operator_code FROM commondb.operator_tbl WHERE operator_id = ? LIMIT 1"
        );
        $stOp->execute([$opId]);
        $opRow = $stOp->fetch(PDO::FETCH_ASSOC);
        if (!$opRow) {
            $results[] = ['operator_id' => $opId, 'operator' => '?', 'status' => 'error', 'msg' => 'Operator not found'];
            continue;
        }
        $opName      = $opRow['operator'];
        $opCode      = $opRow['operator_code'] ?? '';
        $advName     = $pubName . $opCode;

        try {
            $stIns = $conn->prepare(
                "INSERT INTO commondb.advertiser_tbl
                 (advertiser_name, operator, advertiser_url, advertiser_isactive,
                  advertiser_dct_url, spo_stopcallback, act_stopcallback,
                  games_spo_stopcallback, games_act_stopcallback,
                  music_spo_stopcallback, music_act_stopcallback, redirect_url)
                 VALUES (?,?,?,?,?,100,10,100,10,100,10,?)"
            );
            $stIns->execute([$advName, $opId, $pubUrl, $isActive, $pubDctUrl, $redirectUrl]);
            $advId = (int)$conn->lastInsertId();

            // Insert callback counter in glamour logdb if it exists
            $logdb = logDbName($opName, $product);
            $cbInserted = false;
            if (dbExists($conn, $logdb)) {
                $stCb = $conn->prepare(
                    "INSERT INTO {$logdb}.advertiser_callback_counter_tbl
                     (advertiser_id, spo_callback_counter, act_callback_counter)
                     VALUES (?,20,20)"
                );
                $stCb->execute([$advId]);
                $cbInserted = true;
            }

            $results[] = [
                'operator_id'  => $opId,
                'operator'     => $opName,
                'advertiser_id'=> $advId,
                'adv_name'     => $advName,
                'cb_inserted'  => $cbInserted,
                'status'       => 'ok',
            ];
        } catch (PDOException $e) {
            $results[] = ['operator_id' => $opId, 'operator' => $opName, 'status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    $ok  = count(array_filter($results, function ($r) { return $r['status'] === 'ok'; }));
    $err = count($results) - $ok;
    echo json_encode(['success' => true, 'inserted' => $ok, 'failed' => $err, 'results' => $results]);
}
