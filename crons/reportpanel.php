<?php
require_once dirname(__DIR__) . '/admin/includes/config.php';

$con1 = $con55;
date_default_timezone_set("Asia/Calcutta");
$date1 = date('Y-m-d', strtotime("-1 days"));
$date2 = date('Y-m-d H:i:s');

// ── Log file setup ────────────────────────────────────────────────────────────
$log_dir  = __DIR__ . '/logs';
if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
$log_file = $log_dir . '/reportpanel_' . date('Y-m-d') . '.log';

function clog(string $msg): void {
	global $log_file;
	file_put_contents($log_file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

clog("========== reportpanel START — report date: {$date1} ==========");

$sql = "UPDATE gamebardb_vodafone_qatar_report.cron_report set ran=0 where ran=1 and date(date) ='" . $date1 . "' ";

$result = mysqli_query($con55, $sql);
if ($result) {
	clog("Reset stale ran=1 rows for {$date1} — affected: " . mysqli_affected_rows($con55));
} else {
	clog("ERROR resetting cron_report: " . mysqli_error($con55));
}
$k = 0;

$sql500 = "select * from gamebardb_vodafone_qatar_report.cron_report  ";

$result500 = mysqli_query($con55, $sql500);
$message = "";
$b = [];
while ($row100 = mysqli_fetch_array($result500)) {
	$a =	$row100['cron_name'];
	$b[$a] = $row100['ran'];
	$k = 1;
}
clog("Loaded cron_report state: " . json_encode($b));

$perform_hotshots = $trendreportvoda = $partnertrack = $activation1 = $actdct5 = $pub1 = $mainreport = $mainreport_vodacom = 3;
if ($k == 1) {
	$activation1 = $b['cron_activation'];
	$mainreport = $b['mainreport'];
	clog("cron_activation ran={$activation1} | mainreport ran={$mainreport}");

	if ($pub1 == 0) {
		clog("Running cron_pubwise_report.php");
		include 'cron_pubwise_report.php';

		if ($pubcount != 1) {
			clog("cron_pubwise_report.php FAILED");
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {
			clog("cron_pubwise_report.php OK");
			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	}

	if ($trendreportvoda == 0) {
		clog("Running cron_trend_report_hotshots_voda.php");
		include 'cron_trend_report_hotshots_voda.php';

		if ($trendvoda != 1) {
			clog("cron_trend_report_hotshots_voda.php FAILED");
			$message .= "<br><h2 style='color:red'>cron_trend_report_hotshots_voda.php was not run successfully</h2>";
		} else {
			clog("cron_trend_report_hotshots_voda.php OK");
			$message .= "<br><h2 style='color:green'>cron_trend_report_hotshots_voda.php was  run successfully</h2>";
		}
	}

	if ($activation1 == 0) {
		clog("Running cron_activation.php");
		include 'cron_activation.php';

		if ($activationcount != 1) {
			clog("cron_activation.php FAILED");
			$message .= "<br><h2 style='color:red'>cron_activation.php was not run successfully</h2>";
		} else {
			clog("cron_activation.php OK");
			$message .= "<br><h2 style='color:green'>cron_activation.php was  run successfully</h2>";
		}
	} else {
		clog("Skipping cron_activation.php — already ran (ran={$activation1})");
	}

	if ($mainreport == 0) {
		clog("Checking mainreport status");
		if ($main != 1) {
			clog("mainreport FAILED");
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {
			clog("mainreport OK");
			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	} else {
		clog("Skipping mainreport check — already ran (ran={$mainreport})");
	}

	if ($message != "") {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "from :Support@loop360.co" . "\r\n";
		$mailSent = mail("team@svmobi.com", "cron ran report", $message, $headers);
		clog($mailSent ? "Summary mail sent to team@svmobi.com" : "Summary mail FAILED to send");
	}
} else {
	clog("No rows found in cron_report — nothing to process");
}

clog("========== reportpanel END ==========");
