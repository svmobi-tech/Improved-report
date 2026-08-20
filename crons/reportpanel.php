<?php
require_once dirname(__DIR__) . '/admin/includes/config.php';

$con2 = mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_error()); //cluster 2

$con1 = $con2;
date_default_timezone_set("Asia/Calcutta");
$date1 = date('Y-m-d', strtotime("-1 days"));
$date2 = date('Y-m-d H:i:s');

//$sql="INSERT IGNORE INTO hotshotsnewdb_voda_0417.cron_report (date) VALUES ('".$date1."')";
$sql = "UPDATE gamebardb_vodafone_qatar_report.cron_report set ran=0 where ran=1 and date(date) ='" . $date1 . "' ";

$result = mysqli_query($con2, $sql);
$k = 0;

$sql500 = "select * from gamebardb_vodafone_qatar_report.cron_report  ";

$result500 = mysqli_query($con2, $sql500);
$message = "";
$b = [];
while ($row100 = mysqli_fetch_array($result500)) {
	$a =	$row100['cron_name'];
	$b[$a] = $row100['ran'];


	$k = 1;
}
//print_r($b);
//echo $a;

//exit;
$perform_hotshots = $trendreportvoda = $partnertrack = $activation1 = $actdct5 = $pub1 = $mainreport = $mainreport_vodacom = 3;
if ($k == 1) {
	//$trendreportidea=$b['cron_trend_idea'];
	//$trendreportvoda=$b['cron_trend_voda_qatar'];
	//$trendreportairtel=$b['cron_trend_airtel'];
	//$perform_hotshots=$b['cron_perform'];
	//$partnertrack=$b['cron_partner_tracking'];
	$activation1 = $b['cron_activation'];
	//$actdct5=$b['cron_actdct'];
	//$pub1=$b['cron_pub_wise'];
	$mainreport = $b['mainreport'];
	//$mainreport_vodacom=$b['mainreport_vodacom'];

	echo "hi";

	if ($pub1 == 0) {

		//echo "hi";exit;
		include 'cron_pubwise_report.php';
		//echo "<br>trendidea=".$trendidea;
		//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_trend_idea=".$trendidea." where date='".$date1."'";
		//$result = mysqli_query($con1,$sql) ;
		if ($pubcount != 1) {
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {

			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	}
	//exit;
	/*if($trendreportidea==0)
{
	include 'cron_trnd_report_hotshots_idea.php';
	//echo "<br>trendidea=".$trendidea;
	//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_trend_idea=".$trendidea." where date='".$date1."'";
	//$result = mysqli_query($con1,$sql) ;
	if($trendidea!=1)
	{
		$message.="<h2 style='color:red'>cron_trend_report_hotshots_idea.php was not run successfully</h2>";
	}
	else 
	{
		
		$message.="<h2 style='color:green'>cron_trend_report_hotshots_idea.php was run successfully</h2>";
		
	}
}*/

	if ($trendreportvoda == 0) {
		include 'cron_trend_report_hotshots_voda.php';
		//echo "<br>trendvoda".$trendvoda;
		//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_trend_voda=".$trendvoda." where date='".$date1."'";
		//$result = mysqli_query($con1,$sql) ;

		if ($trendvoda != 1) {
			$message .= "<br><h2 style='color:red'>cron_trend_report_hotshots_voda.php was not run successfully</h2>";
		} else {
			$message .= "<br><h2 style='color:green'>cron_trend_report_hotshots_voda.php was  run successfully</h2>";
		}
	}
	/*if($trendreportairtel==0)
{
	include 'cron_trend_report_hotshots_airtel.php';
	//echo "<br>trendairtel=".$trendairtel;
	//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_trend_airtel=".$trendairtel." where date='".$date1."'";
	//$result = mysqli_query($con1,$sql) ;
	if($trendairtel!=1)
	{
		$message.="<br><h2 style='color:red'>cron_trend_report_hotshots_airtel.php was not run successfully</h2>";
	}
	else {
		$message.="<br><h2 style='color:green'>cron_trend_report_hotshots_airtel.php was  run successfully</h2>";
	}
	
}
if($perform_hotshots==0)
{
	include 'cron_perform_hotshotvoda.php';
	 //echo "<br>performcount".$performcount;
	// $sql="update hotshotsnewdb_voda_0417.cron_report set cron_perform=".$performcount." where date='".$date1."'";
	//$result = mysqli_query($con1,$sql) ;
	if($performcount!=1)
	{
		$message.="<br><h2 style='color:red'>cron_perform.php was not run successfully</h2>";
	}else {
		$message.="<br><h2 style='color:green'>cron_perform.php was run  successfully</h2>";
	}
}

if($partnertrack==0)
{
	include 'cron_partner_tracking_report.php';
	//echo "<br>partnercount=". $partnercount;
	//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_partner_tracking=".$partnercount." where date='".$date1."'";
	//$result = mysqli_query($con1,$sql) ;
	if($partnercount!=1)
	{
		$message.="<br><h2 style='color:red'>cron_partner_tracking_report.php was not run successfully</h2>";
	}else{
		$message.="<br><h2 style='color:green'>cron_partner_tracking_report.php was run successfully</h2>";
	}
}*/

	if ($activation1 == 0) {
		include 'cron_activation.php';
		//echo "<br>activationcount=".$activationcount;
		//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_activation=".$activationcount." where date='".$date1."'";
		//$result = mysqli_query($con1,$sql) ;

		if ($activationcount != 1) {
			$message .= "<br><h2 style='color:red'>cron_activation.php was not run successfully</h2>";
		} else {
			$message .= "<br><h2 style='color:green'>cron_activation.php was  run successfully</h2>";
		}
	}
	/*
if($actdct5==0)
{

	include 'cron_actdct.php';
	//echo "<br>actdct=".$actdctcount;
	//$sql="update hotshotsnewdb_voda_0417.cron_report set cron_actdct=".$actdctcount." where date='".$date1."'";
	//$result = mysqli_query($con1,$sql) ;
	if($actdctcount!=1)
	{
		$message.="<br><h2 style='color:red'>cron_actdct.php was not run successfully</h2>";
	}else if($actdctcount!=1 or $g1==1)
	{
		$message.="<br><h2 style='color:green'>cron_actdct.php was run successfully</h2>";
		
	}
}*/
	if ($mainreport == 0) {

		//include 'mainreport_all.php';
		if ($main != 1) {
			$message .= "<h2 style='color:red'>cron_pubwise_report.php was not run successfully</h2>";
		} else {

			$message .= "<h2 style='color:green'>cron_pubwise_report.php was run successfully</h2>";
		}
	}
	/*
if($mainreport_vodacom==0)
{
	
	include 'mainreport_Vodacom.php';
	if($main!=1)
	{
		$message.="<h2 style='color:red'>mainreport_vodacom.php was not run successfully</h2>";
	}
	else 
	{
		
		$message.="<h2 style='color:green'>mainreport_vodacom.php was run successfully</h2>";
		
	}
}
*/

	if ($message != "") {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "from :Support@loop360.co" . "\r\n";
		mail("team@svmobi.com", "cron ran report", $message, $headers);
	}
}
