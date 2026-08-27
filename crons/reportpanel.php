<?php
require_once dirname(__DIR__) . '/admin/includes/config.php';

$con1 = $con55;
date_default_timezone_set("Asia/Calcutta");
$date1 = date('Y-m-d', strtotime("-1 days"));
$date2 = date('Y-m-d H:i:s');

$sql = "UPDATE gamebardb_vodafone_qatar_report.cron_report set ran=0 where ran=1 and date(date) ='" . $date1 . "' ";

$result = mysqli_query($con55, $sql);
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

$perform_hotshots = $trendreportvoda = $partnertrack = $activation1 = $actdct5 = $pub1 = $mainreport = $mainreport_vodacom = 3;
if ($k == 1) {
	$activation1 = $b['cron_activation'];
	$mainreport = $b['mainreport'];
	echo "hi";

	if ($pub1 == 0) {
		include 'cron_pubwise_report.php';

		if ($pubcount != 1) {
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {

			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	}

	if ($trendreportvoda == 0) {
		include 'cron_trend_report_hotshots_voda.php';

		if ($trendvoda != 1) {
			$message .= "<br><h2 style='color:red'>cron_trend_report_hotshots_voda.php was not run successfully</h2>";
		} else {
			$message .= "<br><h2 style='color:green'>cron_trend_report_hotshots_voda.php was  run successfully</h2>";
		}
	}

	if ($activation1 == 0) {
		include 'cron_activation.php';

		if ($activationcount != 1) {
			$message .= "<br><h2 style='color:red'>cron_activation.php was not run successfully</h2>";
		} else {
			$message .= "<br><h2 style='color:green'>cron_activation.php was  run successfully</h2>";
		}
	}

	if ($mainreport == 0) {
		if ($main != 1) {
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {

			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	}

	if ($message != "") {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "from :Support@loop360.co" . "\r\n";
		mail("team@svmobi.com", "cron ran report", $message, $headers);
	}
}
