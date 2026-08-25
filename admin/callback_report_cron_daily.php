<?php
require_once __DIR__ . '/../admin/includes/config.php';

ini_set('max_execution_time', 6000);
ini_set('mysql.connect_timeout', 6000);
ini_set('default_socket_timeout', 6000);

$con1 = mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS,null,DB_PROD_PORT) or die(mysqli_error());

date_default_timezone_set("Asia/Calcutta");

$logFile = __DIR__ . '/../logs/callbackreport_daily_' . date('Y-m-d') . '.log';
if (!is_dir(dirname($logFile))) {
    @mkdir(dirname($logFile), 0775, true);
}
function log_line($level, $msg)
{
    global $logFile;
    @file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] [' . $level . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

$report      = 'gamebardb_vodafone_qatar_report';
$report_date = date('Y-m-d', strtotime('-1 days'));
$start_date  = $report_date . ' 00:00:00';
$end_date    = $report_date . ' 23:59:59';

log_line('INFO', 'run start report_date=' . $report_date);

// Same operator exclusions used today in admin/ajax/handler.php's live dropdown queries
$excludedOperators = [
    'Egypt_Mondia_Orange', 'Egypt_Mondia_all', 'Slovenia', 'Romania',
    'Egypt_Mondia_api', 'Ghana_VF', 'Iraq_Korek_SVS', 'Nigeria_Airtel', 'Kuwait_Stc'
];
$excludedList = "'" . implode("','", array_map(fn($o) => mysqli_real_escape_string($con1, $o), $excludedOperators)) . "'";

// mainreportquery is READ-ONLY here — nothing is ever written back to it.
// Progress is tracked purely by checking whether callback_report_daily already
// has a row for this product+operator+date, so no separate state table is needed either.
$sql1 = "SELECT mq.* FROM {$report}.mainreportquery mq
         WHERE (mq.perform_callback IS NOT NULL AND mq.perform_callback != '')
           AND mq.operator NOT IN ({$excludedList})
           AND NOT EXISTS (
               SELECT 1 FROM {$report}.callback_report_daily d
               WHERE d.product = mq.product
                 AND d.operator = mq.operator
                 AND d.report_date = '{$report_date}'
           )
         ORDER BY mq.id ASC";

$operatorsProcessed = 0;


if ($result1 = mysqli_query($con1, $sql1)) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $operatorsProcessed++;

        $product          = $row1['product'];
        $operator         = $row1['operator'];
        $perform_callback = $row1['perform_callback'];
        $perform_centtocg = $row1['perform_centtocg'] ?? '';

        log_line('INFO', "processing product={$product} operator={$operator}");

        $operatorCost = 0.0;
        $costRes = mysqli_query($con1,
            "SELECT operatorcost_usd FROM {$report}.operatorcost
            WHERE product = '" . mysqli_real_escape_string($con1, $product) . "'
            AND operator = '" . mysqli_real_escape_string($con1, $operator) . "'
            LIMIT 1"
        );
        if ($costRes && $costRow = mysqli_fetch_assoc($costRes)) {
            $operatorCost = (float)$costRow['operatorcost_usd'];
        }


        // --- callback_act ("Total callback sent"), from perform_callback SP ---
        if ($perform_callback) {
            $q = str_replace(['[start_date]', '[end_date]', '[hours]'],
                              [$start_date,    $end_date,    '24'], $perform_callback);
            $rows = [];
            if ($r = mysqli_query($con1, $q)) {
                while ($row = mysqli_fetch_assoc($r)) {
                    $rows[] = $row;
                }
                mysqli_free_result($r);
            } else {
                log_line('ERROR', "perform_callback failed operator={$operator}: " . mysqli_error($con1));
            }
            while (mysqli_more_results($con1) && mysqli_next_result($con1)) {
                if ($extra = mysqli_store_result($con1)) mysqli_free_result($extra);
            }

            foreach ($rows as $row) {
                $advname = $row['advname'] ?? '';
                $act     = (int)($row['act'] ?? 0);
                $totalCost = round($act * $operatorCost, 6);
                upsert_callback_row($con1, $report, $product, $report_date, $operator, $advname, $act, 0, 'callback_act', $operatorCost, $totalCost);
            }
        }

        // --- pinconfirm_act ("Pin-confirmed"), from perform_centtocg SP ---
        if ($perform_centtocg) {
            $q = str_replace(['[start_date]', '[end_date]', '[hours]'],
                              [$start_date,    $end_date,    '24'], $perform_centtocg);
            try {
                $r = mysqli_query($con1, $q);
            } catch (mysqli_sql_exception $e) {
                log_line('ERROR', "perform_callback query failed operator={$operator}: " . $e->getMessage());
                $r = false;
            }
            $rows = [];

            if ($r) {
                while ($row = mysqli_fetch_assoc($r)) {
                    $rows[] = $row;
                }
                mysqli_free_result($r);
            } else {
                log_line('ERROR', "perform_centtocg failed operator={$operator}: " . mysqli_error($con1));
            }
            while (mysqli_more_results($con1) && mysqli_next_result($con1)) {
                if ($extra = mysqli_store_result($con1)) mysqli_free_result($extra);
            }

            foreach ($rows as $row) {
                $advname = $row['advname'] ?? '';
                $act     = (int)($row['act'] ?? 0);
                upsert_callback_row($con1, $report, $product, $report_date, $operator, $advname, 0, $act, 'pinconfirm_act', $operatorCost);
            }
        }
    }
} else {
    log_line('ERROR', 'main select failed: ' . mysqli_error($con1));
}

log_line('INFO', "run complete operatorsProcessed={$operatorsProcessed}");

// Upserts a single (product, report_date, operator, advertiser) row, only touching the
// one metric column being set this call — the other metric is left untouched if the row
// already exists (e.g. callback_act set by the first pass, pinconfirm_act by the second).
function upsert_callback_row($con, $report, $product, $report_date, $operator, $advname, $callback_act, $pinconfirm_act, $metricCol, $costPerCallback = 0, $totalCost = 0)
{
    $product   = mysqli_real_escape_string($con, $product);
    $operator  = mysqli_real_escape_string($con, $operator);
    $advname   = mysqli_real_escape_string($con, $advname);
    $updateCol = $metricCol === 'callback_act' ? 'callback_act' : 'pinconfirm_act';
    $costCols  = ', cost_per_callback = VALUES(cost_per_callback)';
    $costCols .= $metricCol === 'callback_act' ? ', total_cost = VALUES(total_cost)' : '';

    $sql = "INSERT INTO {$report}.callback_report_daily
                (product, report_date, operator, advertiser, callback_act, pinconfirm_act, cost_per_callback, total_cost)
            VALUES
                ('{$product}', '{$report_date}', '{$operator}', '{$advname}', {$callback_act}, {$pinconfirm_act}, {$costPerCallback}, {$totalCost})
            ON DUPLICATE KEY UPDATE
                {$updateCol} = VALUES({$updateCol}){$costCols},
                updated_at = CURRENT_TIMESTAMP";

    mysqli_query($con, $sql) or log_line('ERROR', 'upsert failed: ' . mysqli_error($con) . ' sql=' . $sql);
}