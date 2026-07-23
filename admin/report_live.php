<?php

ini_set('max_execution_time', 6000);

//include("includes/check_session.php");
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);
$con=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2





//$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1

$con1=$con;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$cc=0;
if(isset($_POST['submit']))
{

$count=1;
$operator=$_POST['operator'];
$product=$_POST['product'];
$date1=date('Y-m-d');
	if($start_date == $end_date)
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}	
	else
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}
   $advertiserid=$_POST['advertiserid']; 
//echo $operator;

// report logic below
	if($product=='glambar' || $product=='glambar')
	{
		if($operator=='south-africa')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='idea')
		{
			$db="glamourworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='poland')
		{
			$db="glambardb_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='southafrica_intarget')
		{
			$db="glambardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="glambardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='thailand_svobi')
		{
			$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);*/
		}
		else if($operator=='new_thailand')
		{
			$db="fashionbardb_glam9005thailand";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);*/
		}
		else if($operator=='vodafone')
		{
			$db="fashionbardb_svmobi";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='bsnl_india')
		{
			$db="bsnlfashionbar";
			$report="gamebardb_vodafone_qatar_report";
			 $sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3   group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='airtel_india')
		{
			
			$db="funzonedb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='hotshots_airtel')
		{
			
			$db="hotshotsdb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='portugal')
		{
			
			$db="fashionbardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='spain')
		{
			
			$db="fashionbardb_spain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		
		else if($operator=='rusia_biline')
		{
			
			$db="glambardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="glambardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='hotshots_vodafone')
		{
			$db="hotshotsnewdb_voda_0617";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='vodacom_wfh')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=1";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='vodacom_fg')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=2";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='vodacom_bt')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=3";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		
		
	}
	else
	{
		//echo $operator;exit;
		if($operator=='du_dubai')
		{
			
			$db="gamesdb_uaedu";
			$report="gamebardb_vodafone_qatar_report";
			$dblog="gamesdblog_uaedu";
			
			$sql_ad="select * from ".$dblog.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='Vodafone_Qatar')
		{
			
			$db="gamebardb_vodafone_qatar";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Bangladesh_Robi')
		{
			
			$db="gamesdbnew_robi_bangladesh";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='poland')
		{
			$db="gamebardb_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='egypt')
		{
			
			$db="gamebardb_vodafone_egypt";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='ecuador')
		{
			
			$db="gamebardb_ecuador";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='tim_italy')
		{
			
			$db="gamebardb_tim";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='palestine')
		{
			
			$db="gamebardb_palestine";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='du_uae')
		{
			
			$db="gamesdb_uaedu";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='etisalad_uae')
		{
			
			$db="gamebardb_uaeetis";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='wind_italy')
		{
			
			$db="gamebardb_wind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='h3g_italy')
		{
			
			$db="gamebardb_h3g";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='indonesia')
		{
			
			$db="gamebardb_indonesia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='myanmar')
		{
			
			$db="fashionbardb_myanmartelenor";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbmyanmar.advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='portugal')
		{
			
			$db="gamebardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kazakistan')
		{
			
			$db="fashionbardb_kazakhstan";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbkazakhstan.advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='spain')
		{
			
			$db="gamebardb_spain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="gamebardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		elseif($operator=='ooredoo_oman')
		{
			$db="gamesdb_ooredoo_oman";
			$dblog="gamesdblog_ooredoo_oman";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		elseif($operator=='malaysia_cellcom')
		{
			$db="gamesdbnew_celcom_malaysia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='idea')
		{
			$db="gamesworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='vodafone')
		{
			$db="gamebardb_svmobi";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		
		else if($operator=='gamezone_vodafone')
		{
			$db="gamesnewdb_voda";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		
		else if($operator=='bsnl_india')
		{
			$db="bsnlgamebar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='south-africa')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='airtel_india')
		{
			
			$db="gamebardb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		elseif($operator=='ooredoo_qatar')
		{
			$db="gamesdb_ooredoo_qatar";
			$dblog="gamesdblog_ooredoo_qatar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		elseif($operator=='qu_qatar')
		{
			$db="gamesdb_ooredoo_qatar_qyou";
			$dblog="gamesdblog_ooredoo_qatar_qyou";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		elseif($operator=='qatar_gamestation')
		{
			$db="gamesdb_ooredoo_qatar_gamestation";
			$dblog="gamesdblog_ooredoo_qatar_gamestation";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		else if($operator=='southafrica_intarget')
		{
			$db="gamebardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_biline')
		{
			
			$db="gamebardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="gamebardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}//guatemala
	
		else if($operator=='guatemala')
		{
			
			$db="gamebardb_guatemala";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='a1_austria')
		{
			
			$db="gamebardb_a1";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='tmobile_austria')
		{
			
			$db="gamebardb_tmobile";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='hutchison_austria')
		{
			
			$db="gamebardb_dimoco";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Cosmote_Greece')
		{
			
			$db="gamebardb_greececosmote";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Vodafone_Greece')
		{
			
			$db="gamebardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Wind_Greece')
		{
			
			$db="gamebardb_greecewind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='all_greece')
		{
			
			$db="gamebardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='sweden')
		{
			
			$db="gamebardb_swedentelenor";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Mts_Serbia')
		{
			
			$db="gamebardb_serbiamts";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Vip_Serbia')
		{
			
			$db="gamebardb_serbiavip";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
	}

	
	$data['startdate']=$start_date;
	$data['enddate']=$end_date;
	$data['db']=$db;
	//$data['dblog']=$dblog;
	$data['advertiser']=$advertiserid;
	//echo $operator;exit;
if($advertiserid=='' || $advertiserid=='all')
{
	if($operator=='Vodafone_Qatar')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	else if($operator=='Bangladesh_Robi')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	else if($operator=='palestine')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	else if($operator=='du_uae')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	else if($operator=='etisalad_uae')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	
	else if($operator=='guatemala')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='myanmar')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					 $sql="call ".$db.".report(0,'".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='kazakistan')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					 $sql="call ".$db.".report(0,'".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='ecuador')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='a1_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
		
		}
		
		
	}
	else if($operator=='tmobile_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='hutchison_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	else if($operator=='tim_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='wind_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='h3g_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	else if($operator=='southafrica_intarget')
	{
		if($product=='glambar' || $product=='Glambar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		else{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	if($operator=='rusia_biline')
	{
		if($product=='glambar' || $product=='Glambar')
		{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');*/
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}*/
		}
		else{
			
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');*/
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
			
		}
	}
	
	
	else if($operator=='rusia_tele2')
	{
		if($product=='glambar' || $product=='Glambar')
		{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				
				
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');*/
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}*/
		}
		else{
			
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59'); */
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
		
			
		}
	}
	
	
	if($operator=='egypt')
	{//egypt
		if($product=='gamebar' || $product=='gamebar')
		{
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	else if($operator=='du_dubai')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	else if($operator=='ooredoo_oman')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
					$sql="call ".$db.".mainreport1('".$db."','".$dblog."','".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	else if($operator=='malaysia_cellcom')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	else if($operator=='south-africa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
					$sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		
		}
		else{
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	else if($operator=='poland')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}	
	
	else if($operator=='Cosmote_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		
		}
		else{
			
			
		}
	}	
	else if($operator=='Vodafone_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
			
			
		}
	}	
	else if($operator=='Wind_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		else{
			
			
		}
	}	
	else if($operator=='all_greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		
		}
		else{
			
			
		}
	}	
	else if($operator=='sweden')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".swedenmainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
			
			
		}
	}	
	
	
	
	
	
	
	else if($operator=='Mts_Serbia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		
		}
		else{
			
			
		}
	}	
	else if($operator=='Vip_Serbia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
			
			
		}
	}	
	
	
	
	
	
	
	else if($operator=='kenya_oxygen')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		
		}
		else{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	else if($operator=='indonesia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
			
			
		}
	}
	
	
	else if($operator=='vodacom_wfh')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{*/
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',1)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',1)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
			
			
		}
	}
	else if($operator=='vodacom_fg')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{*/
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',2)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',2)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
			
			
		}
	}
	
	
	else if($operator=='vodacom_bt')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				*/
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',3)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',3)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			*/
			
		}
	}
	
	
	
	
	else if($operator=='thailand_svobi')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
			*/	
					
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}*/
		
		}
		else{
			
			  $sql="SELECT 
						dt,
						SUM(clicks) clicks,
						SUM(cbr) cg,
						SUM(low) park,
						SUM(act) act,
						SUM(ren) ren,
						SUM(dct) churn,
						SUM(cbs) cbsent,
						sum(low)Low
					FROM
						(SELECT 
							COUNT(clickid) clicks,
								0 cbr,
								DATE(accesstime) dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT DISTINCT
							clickid, accesstime
						FROM
							".$db.".userlog
						WHERE
							accesstime >= '".$start_date."'
								AND accesstime <= '".$end_date."') a
						GROUP BY dt UNION SELECT 
							0 clicks,
								COUNT(clickid) cbr,
								DATE(subscriptionstartdate) dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, subscriptionstartdate, charging_mode
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."') a
						WHERE
							charging_mode = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(subscriptionstartdate) dt,
								COUNT(clickid) dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, subscriptionstartdate, charging_mode
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."') a
						WHERE
							charging_mode = 'dct') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(advertdatetime) dt,
								0 dct,
								COUNT(clickid) cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, advertdatetime, advertresponse, action
						FROM
							".$db.".advertcallback
						WHERE
							advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."') a
						WHERE
							advertresponse != 'stop'
								AND advertresponse != ''
								AND action = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(downloaddatetime) dt,
								0 dct,
								0 cbs,
								COUNT(*) act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, downloaddatetime, status_code, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							status_code = 'ok'
								AND charging_mode = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(downloaddatetime) dt,
								0 dct,
								0 cbs,
								0 act,
								COUNT(*) ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							msisdn, downloaddatetime, status_code, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							status_code = 'ok'
								AND charging_mode = 'ren') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								COUNT(*) low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							msisdn, DATE(downloaddatetime) dt, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							charging_mode = 'low') b
						GROUP BY dt) b
					GROUP BY dt;";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	else if($operator=='new_thailand')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
			*/	
					
			/*}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}*/
		
		}
		else{
			
			  $sql="call ".$db.".report('".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	
	else if($operator=='portugal')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		
		}
		else{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser=0 and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
	}
	
	
	else if($operator=='spain')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		}
		else{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
	}
	
	
	
	
	
	
	elseif($operator=='qatar_gamestation')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
				
				
					   $sql="SELECT 
							z.*, IFNULL(v.cbsent, 0) cbsent
						FROM
							(SELECT 
								SUM(clicks) clicks,
									SUM(uniq) uniq,
									dt,
									SUM(act) act,
									SUM(churn) churn,
									SUM(actamnt) actamnt,
									SUM(ren) ren,
									SUM(renamnt) renamnt,
									SUM(Low) Low,
									SUM(cg) cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									SUM(actcnt) act,
									SUM(dctcnt) churn,
									SUM(actamnt) actamnt,
									SUM(rencnt) ren,
									SUM(renamnt) renamnt,
									SUM(LOWbal) Low,
									cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									act,
									amt,
									CASE
										WHEN typ = 'DCT' THEN act
										ELSE 0
									END dctcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN act
										ELSE 0
									END ACTcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN amt
										ELSE 0
									END ACTAMNT,
									CASE
										WHEN typ = 'REN' THEN act
										ELSE 0
									END RENcnt,
									CASE
										WHEN typ = 'REN' THEN amt
										ELSE 0
									END RENAMNT,
									CASE
										WHEN typ = 'ACT' AND bal = 0 THEN act
										ELSE 0
									END LOWbal,
									bal,
									cg
							FROM
								(SELECT 
								IFNULL(clicks, 0) clicks,
									IFNULL(uniq, 0) uniq,
									x.dt,
									act,
									amt,
									typ,
									bal,
									IFNULL(cg, 0) cg
							FROM
								(SELECT 
								COUNT(*) act,
									dt,
									SUM(amount) amt,
									CASE
										WHEN isrenew = 0 THEN 'ACT'
										ELSE 'REN'
									END typ,
									1 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)
									AND amount>0 and affiliate_txnid like '%,1') a
							GROUP BY dt , isrenew UNION SELECT 
								COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND affiliate_txnid LIKE '%,1122%') a
							GROUP BY dt) x
							left JOIN (SELECT 
								COUNT(clicks) clicks, dt
							FROM
								(SELECT 
								userid clicks, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') y
							GROUP BY dt) z ON x.dt = z.dt
							LEFT JOIN (SELECT 
								COUNT(clicks) uniq, dt
							FROM
								(SELECT DISTINCT
								userid clicks, dt
							FROM
								(SELECT 
								userid, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') a) p
							GROUP BY dt) q ON x.dt = q.dt
							LEFT JOIN (SELECT 
								COUNT(msisdn) cg, dt
							FROM
								(SELECT 
								msisdn, DATE(requesttime) dt
							FROM
								".$db.".callbackrequests
							INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."'
							GROUP BY msisdn , dt) j
							GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
								0 clicks,
									0 uniq,
									dt,
									COUNT(subscriberid) act,
									0 amt,
									'DCT' typ,
									0 bal,
									0 cg
							FROM
								(SELECT DISTINCT
								DATE(subscriber.subscriptionstartdate) dt,
									subscriber.subscriberid,
									subscriber.charging_mode,
									subscriber.msisdn
							FROM
								".$db.".subscriber
							WHERE
								amount = 0 AND affiliate_txnid LIKE '%-81%'
									AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
									AND subscriber.subscriptionstartdate >= '".$start_date."'
									AND subscriber.subscriptionstartdate <= '".$end_date."'
							GROUP BY dt) w
							GROUP BY dt
							ORDER BY dt ASC , clicks ASC) x) bb
							GROUP BY dt , clicks , uniq) y
							GROUP BY dt) z
								LEFT JOIN
							(SELECT 
								dt, SUM(cnt) cbsent
							FROM
								(SELECT 
								dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
							FROM
								(SELECT DISTINCT
								DATE(requesttime) dt, msisdn, advertiserid
							FROM
								".$db.".requestresponse
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."') a
							INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
							GROUP BY dt , advname) b
							GROUP BY dt) v ON z.dt = v.dt
						ORDER BY z.dt";	
					$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		else{
			
			
		}
		
	}

	
	
	
	elseif($operator=='ooredoo_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
				
				
					   $sql="SELECT 
							z.*, IFNULL(v.cbsent, 0) cbsent
						FROM
							(SELECT 
								SUM(clicks) clicks,
									SUM(uniq) uniq,
									dt,
									SUM(act) act,
									SUM(churn) churn,
									SUM(actamnt) actamnt,
									SUM(ren) ren,
									SUM(renamnt) renamnt,
									SUM(Low) Low,
									SUM(cg) cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									SUM(actcnt) act,
									SUM(dctcnt) churn,
									SUM(actamnt) actamnt,
									SUM(rencnt) ren,
									SUM(renamnt) renamnt,
									SUM(LOWbal) Low,
									cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									act,
									amt,
									CASE
										WHEN typ = 'DCT' THEN act
										ELSE 0
									END dctcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN act
										ELSE 0
									END ACTcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN amt
										ELSE 0
									END ACTAMNT,
									CASE
										WHEN typ = 'REN' THEN act
										ELSE 0
									END RENcnt,
									CASE
										WHEN typ = 'REN' THEN amt
										ELSE 0
									END RENAMNT,
									CASE
										WHEN typ = 'ACT' AND bal = 0 THEN act
										ELSE 0
									END LOWbal,
									bal,
									cg
							FROM
								(SELECT 
								IFNULL(clicks, 0) clicks,
									IFNULL(uniq, 0) uniq,
									x.dt,
									act,
									amt,
									typ,
									bal,
									IFNULL(cg, 0) cg
							FROM
								(SELECT 
								COUNT(*) act,
									dt,
									SUM(amount) amt,
									CASE
										WHEN isrenew = 0 THEN 'ACT'
										ELSE 'REN'
									END typ,
									1 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)
									AND amount>0 and txnid like '%,1') a
							GROUP BY dt , isrenew UNION SELECT 
								COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND txnid LIKE '%,1122%') a
							GROUP BY dt) x
							left JOIN (SELECT 
								COUNT(clicks) clicks, dt
							FROM
								(SELECT 
								userid clicks, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') y
							GROUP BY dt) z ON x.dt = z.dt
							LEFT JOIN (SELECT 
								COUNT(clicks) uniq, dt
							FROM
								(SELECT DISTINCT
								userid clicks, dt
							FROM
								(SELECT 
								userid, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') a) p
							GROUP BY dt) q ON x.dt = q.dt
							LEFT JOIN (SELECT 
								COUNT(msisdn) cg, dt
							FROM
								(SELECT 
								msisdn, DATE(requesttime) dt
							FROM
								".$db.".callbackrequests
							INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."'
							GROUP BY msisdn , dt) j
							GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
								0 clicks,
									0 uniq,
									dt,
									COUNT(subscriberid) act,
									0 amt,
									'DCT' typ,
									0 bal,
									0 cg
							FROM
								(SELECT DISTINCT
								DATE(subscriber.subscriptionstartdate) dt,
									subscriber.subscriberid,
									subscriber.charging_mode,
									subscriber.msisdn
							FROM
								".$db.".subscriber
							WHERE
								amount = 0 AND txnid LIKE '%-81%'
									AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
									AND subscriber.subscriptionstartdate >= '".$start_date."'
									AND subscriber.subscriptionstartdate <= '".$end_date."'
							GROUP BY dt) w
							GROUP BY dt
							ORDER BY dt ASC , clicks ASC) x) bb
							GROUP BY dt , clicks , uniq) y
							GROUP BY dt) z
								LEFT JOIN
							(SELECT 
								dt, SUM(cnt) cbsent1
							FROM
								(SELECT 
								dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
							FROM
								(SELECT DISTINCT
								DATE(requesttime) dt, msisdn, advertiserid
							FROM
								".$db.".requestresponse
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."') a
							INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
							GROUP BY dt , advname) b
							GROUP BY dt) v1 ON z.dt = v1.dt
							LEFT JOIN
							(SELECT 
								dt, SUM(cnt) cbsent
							FROM
								(SELECT 
								dt, COUNT(msisdn) cnt
							FROM
								(SELECT DISTINCT
							DATE(subscriptionstartdate) dt, msisdn
							FROM
								".$db.".subscriber
							WHERE
								subscriptionstartdate  >= '".$start_date."'
									AND subscriptionstartdate  <= '".$end_date."' and keyword != '') cb1 ) b
							GROUP BY dt) v ON z.dt = v.dt
						ORDER BY z.dt";	
					$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		else{
			
			
		}
		
	}
	elseif($operator=='qu_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
				
				
					   $sql="SELECT 
							z.*, IFNULL(v.cbsent, 0) cbsent
						FROM
							(SELECT 
								SUM(clicks) clicks,
									SUM(uniq) uniq,
									dt,
									SUM(act) act,
									SUM(churn) churn,
									SUM(actamnt) actamnt,
									SUM(ren) ren,
									SUM(renamnt) renamnt,
									SUM(Low) Low,
									SUM(cg) cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									SUM(actcnt) act,
									SUM(dctcnt) churn,
									SUM(actamnt) actamnt,
									SUM(rencnt) ren,
									SUM(renamnt) renamnt,
									SUM(LOWbal) Low,
									cg
							FROM
								(SELECT 
								clicks,
									uniq,
									dt,
									act,
									amt,
									CASE
										WHEN typ = 'DCT' THEN act
										ELSE 0
									END dctcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN act
										ELSE 0
									END ACTcnt,
									CASE
										WHEN typ = 'ACT' AND amt > 0 THEN amt
										ELSE 0
									END ACTAMNT,
									CASE
										WHEN typ = 'REN' THEN act
										ELSE 0
									END RENcnt,
									CASE
										WHEN typ = 'REN' THEN amt
										ELSE 0
									END RENAMNT,
									CASE
										WHEN typ = 'ACT' AND bal = 0 THEN act
										ELSE 0
									END LOWbal,
									bal,
									cg
							FROM
								(SELECT 
								IFNULL(clicks, 0) clicks,
									IFNULL(uniq, 0) uniq,
									x.dt,
									act,
									amt,
									typ,
									bal,
									IFNULL(cg, 0) cg
							FROM
								(SELECT 
								COUNT(*) act,
									dt,
									SUM(amount) amt,
									CASE
										WHEN isrenew = 0 THEN 'ACT'
										ELSE 'REN'
									END typ,
									1 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)
									AND amount>0 and txnid like '%,1') a
							GROUP BY dt , isrenew UNION SELECT 
								COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
							FROM
								(SELECT DISTINCT
								subscriber.subscriberid,
									DATE(subscriptionstartdate) dt,
									amount,
									isrenew
							FROM
								".$db.".subscriber
							
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND txnid LIKE '%,1122%') a
							GROUP BY dt) x
							left JOIN (SELECT 
								COUNT(clicks) clicks, dt
							FROM
								(SELECT 
								userid clicks, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') y
							GROUP BY dt) z ON x.dt = z.dt
							LEFT JOIN (SELECT 
								COUNT(clicks) uniq, dt
							FROM
								(SELECT DISTINCT
								userid clicks, dt
							FROM
								(SELECT 
								userid, DATE(AccessTime) dt
							FROM
								".$dblog.".annonymoustracking
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."') a) p
							GROUP BY dt) q ON x.dt = q.dt
							LEFT JOIN (SELECT 
								COUNT(msisdn) cg, dt
							FROM
								(SELECT 
								msisdn, DATE(requesttime) dt
							FROM
								".$db.".callbackrequests
							INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."'
							GROUP BY msisdn , dt) j
							GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
								0 clicks,
									0 uniq,
									dt,
									COUNT(subscriberid) act,
									0 amt,
									'DCT' typ,
									0 bal,
									0 cg
							FROM
								(SELECT DISTINCT
								DATE(subscriber.subscriptionstartdate) dt,
									subscriber.subscriberid,
									subscriber.charging_mode,
									subscriber.msisdn
							FROM
								".$db.".subscriber
							WHERE
								amount = 0 AND txnid LIKE '%-81%'
									AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
									AND subscriber.subscriptionstartdate >= '".$start_date."'
									AND subscriber.subscriptionstartdate <= '".$end_date."'
							GROUP BY dt) w
							GROUP BY dt
							ORDER BY dt ASC , clicks ASC) x) bb
							GROUP BY dt , clicks , uniq) y
							GROUP BY dt) z
								LEFT JOIN
							(SELECT 
								dt, SUM(cnt) cbsent
							FROM
								(SELECT 
								dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
							FROM
								(SELECT DISTINCT
								DATE(requesttime) dt, msisdn, advertiserid
							FROM
								".$db.".requestresponse
							WHERE
								requesttime >= '".$start_date."'
									AND requesttime <= '".$end_date."') a
							INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
							GROUP BY dt , advname) b
							GROUP BY dt) v ON z.dt = v.dt
						ORDER BY z.dt";	
					$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		else{
			
			
		}
		
	}

	
	else if($operator=='vodafone')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
		
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	
	
	
}



else
{
	
	if($operator=='Vodafone_Qatar')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}	
	}
	
	
	else if($operator=='Bangladesh_Robi')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}	
	}
	else if($operator=='du_uae')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}	
	}
	
	else if($operator=='etisalad_uae')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}	
	}
	
	else if($operator=='palestine')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}	
	}
	
	
	
	if($operator=='southafrica_intarget')
	{
		
		
		if($product=='glambar' || $product=='Glambar')
		{
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		else{
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
	}
	else if($operator=='rusia_biline')
	{
		
		
		if($product=='glambar' || $product=='Glambar')
		{
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			*/
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			/*}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			*/
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
		}
	}
	else if($operator=='rusia_tele2')
	{
		
		
		if($product=='glambar' || $product=='Glambar')
		{
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			*/
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			*/
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			/*
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			*/
		}
	}
	
	else if($operator=='guatemala')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='a1_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='tmobile_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='hutchison_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	else if($operator=='myanmar')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".report('".$advertiserid."','".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='kazakistan')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".report('".$advertiserid."','".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	
	
	
	else if($operator=='ecuador')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='Cosmote_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='Vodafone_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='Wind_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='all_greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='sweden')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".swedenmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	else if($operator=='Mts_Serbia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='Vip_Serbia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='tim_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	else if($operator=='wind_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	else if($operator=='h3g_italy')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
		
	}
	
	
	
	
	
	else if($operator=='egypt')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}	
	}
	
	else if($operator=='du_dubai')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	else if($operator=='ooredoo_oman')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			 $sql="call ".$db.".mainreport1('".$db."','".$dblog."','".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	else if($operator=='malaysia_cellcom')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	else if($operator=='south-africa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			 $sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	else if($operator=='poland')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		else{
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	
	
	
	
	
	else if($operator=='kenya_oxygen')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	else if($operator=='vodafone')
	{
		
		//echo $advertiserid;
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
			{
		  
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		
		else{
			 //$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			//$cc=1;
			//	$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	
	else if($operator=='gamezone_vodafone')
	{
		
		//echo $advertiserid;
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
			{
		  
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
		
		
	}
	
	
	
	
	
	else if($operator=='bsnl_india')
	{
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
			{
		 /*	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());*/
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		
	}
	else if($operator=='idea')
	{
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		
		
		}
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	else if($operator=='indonesia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
		else{
			
			
		}
	}
	
	else if($operator=='vodacom_wfh')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
		}
		else{
			
			
			/*
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
				 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','1')";
				$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			*/
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','1')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			/*
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}*/
			
			
		}
	}
	
	else if($operator=='vodacom_fg')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
		}
		else{
			
			
			
			
				
				 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','2')";
				$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
			
		}
	}
	else if($operator=='vodacom_bt')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
		}
		else{
			
			
			
				
				  $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','3')";
				$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	
	
	else if($operator=='spain')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
						
		}
		else{
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	else if($operator=='qatar_gamestation')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
				
				
							 $sql="SELECT 
				z.*, v.cbsent
			FROM
				(SELECT 
					SUM(clicks) clicks,
						SUM(uniq) uniq,
						dt,
						SUM(act) act,
						SUM(churn) churn,
						SUM(actamnt) actamnt,
						SUM(ren) ren,
						SUM(renamnt) renamnt,
						SUM(Low) Low,
						SUM(cg) cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						SUM(actcnt) act,
						SUM(dctcnt) churn,
						SUM(actamnt) actamnt,
						SUM(rencnt) ren,
						SUM(renamnt) renamnt,
						SUM(LOWbal) Low,
						cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						act,
						amt,
						CASE
							WHEN typ = 'DCT' THEN act
							ELSE 0
						END dctcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN act
							ELSE 0
						END ACTcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN amt
							ELSE 0
						END ACTAMNT,
						CASE
							WHEN typ = 'REN' THEN act
							ELSE 0
						END RENcnt,
						CASE
							WHEN typ = 'REN' THEN amt
							ELSE 0
						END RENAMNT,
						CASE
							WHEN typ = 'ACT' AND bal = 0 THEN act
							ELSE 0
						END LOWbal,
						bal,
						cg
				FROM
					(SELECT 
					IFNULL(clicks, 0) clicks,
						IFNULL(uniq, 0) uniq,
						CASE
							WHEN z.dt is null THEN x.dt
							ELSE z.dt
						END dt,
						act,
						amt,
						typ,
						bal,
						IFNULL(cg, 0) cg
				FROM
					(SELECT 
					COUNT(*) act,
						dt,
						SUM(amount) amt,
						CASE
							WHEN isrenew = 0 THEN 'ACT'
							ELSE 'REN'
						END typ,
						1 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND subscriptionstartdate < subscriptionenddate
						AND advertiserid=".$advertiserid."
						AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)) a
				GROUP BY dt , isrenew UNION SELECT 
					COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND affiliate_txnid LIKE '%,1122%'
						AND advertiserid=".$advertiserid."
						) a
				GROUP BY dt) x
				LEFT JOIN (SELECT 
					COUNT(clicks) clicks, dt
				FROM
					(SELECT 
					userid clicks, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
						) y
						
				GROUP BY dt) z ON x.dt = z.dt
				LEFT JOIN (SELECT 
					COUNT(clicks) uniq, dt
				FROM
					(SELECT DISTINCT
					userid clicks, dt
				FROM
					(SELECT 
					userid, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a) p
				GROUP BY dt) q ON x.dt = q.dt
				LEFT JOIN (SELECT 
					COUNT(msisdn) cg, dt
				FROM
					(SELECT 
					msisdn, DATE(requesttime) dt
				FROM
					".$db.".callbackrequests
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY msisdn , dt) j
				GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
					0 clicks,
						0 uniq,
						dt,
						COUNT(subscriberid) act,
						0 amt,
						'DCT' typ,
						0 bal,
						0 cg
				FROM
					(SELECT DISTINCT
					DATE(subscriber.subscriptionstartdate) dt,
						subscriber.subscriberid,
						subscriber.charging_mode,
						subscriber.msisdn
				FROM
					".$db.".subscriber
					 INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
				WHERE
				
					amount = 0 AND affiliate_txnid LIKE '%-81%'
						AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
						AND subscriber.subscriptionstartdate >= '".$start_date."'
						AND subscriber.subscriptionstartdate <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY dt) w
				GROUP BY dt
				ORDER BY dt ASC , clicks ASC) x) bb
				GROUP BY dt , clicks , uniq) y
				GROUP BY dt) z
					LEFT JOIN
				(SELECT 
					dt, SUM(cnt) cbsent
				FROM
					(SELECT 
					dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
				FROM
					(SELECT DISTINCT
					DATE(requesttime) dt, msisdn, advertiserid
				FROM
					".$db.".requestresponse
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a
				INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
				GROUP BY dt , advname) b
				GROUP BY dt) v ON z.dt = v.dt
			ORDER BY z.dt;
					";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	else if($operator=='qu_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
				
				
							 $sql="SELECT 
				z.*, v.cbsent
			FROM
				(SELECT 
					SUM(clicks) clicks,
						SUM(uniq) uniq,
						dt,
						SUM(act) act,
						SUM(churn) churn,
						SUM(actamnt) actamnt,
						SUM(ren) ren,
						SUM(renamnt) renamnt,
						SUM(Low) Low,
						SUM(cg) cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						SUM(actcnt) act,
						SUM(dctcnt) churn,
						SUM(actamnt) actamnt,
						SUM(rencnt) ren,
						SUM(renamnt) renamnt,
						SUM(LOWbal) Low,
						cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						act,
						amt,
						CASE
							WHEN typ = 'DCT' THEN act
							ELSE 0
						END dctcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN act
							ELSE 0
						END ACTcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN amt
							ELSE 0
						END ACTAMNT,
						CASE
							WHEN typ = 'REN' THEN act
							ELSE 0
						END RENcnt,
						CASE
							WHEN typ = 'REN' THEN amt
							ELSE 0
						END RENAMNT,
						CASE
							WHEN typ = 'ACT' AND bal = 0 THEN act
							ELSE 0
						END LOWbal,
						bal,
						cg
				FROM
					(SELECT 
					IFNULL(clicks, 0) clicks,
						IFNULL(uniq, 0) uniq,
						CASE
							WHEN z.dt is null THEN x.dt
							ELSE z.dt
						END dt,
						act,
						amt,
						typ,
						bal,
						IFNULL(cg, 0) cg
				FROM
					(SELECT 
					COUNT(*) act,
						dt,
						SUM(amount) amt,
						CASE
							WHEN isrenew = 0 THEN 'ACT'
							ELSE 'REN'
						END typ,
						1 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND subscriptionstartdate < subscriptionenddate
						AND advertiserid=".$advertiserid."
						AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)) a
				GROUP BY dt , isrenew UNION SELECT 
					COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND txnid LIKE '%,1122%'
						AND advertiserid=".$advertiserid."
						) a
				GROUP BY dt) x
				LEFT JOIN (SELECT 
					COUNT(clicks) clicks, dt
				FROM
					(SELECT 
					userid clicks, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
						) y
						
				GROUP BY dt) z ON x.dt = z.dt
				LEFT JOIN (SELECT 
					COUNT(clicks) uniq, dt
				FROM
					(SELECT DISTINCT
					userid clicks, dt
				FROM
					(SELECT 
					userid, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a) p
				GROUP BY dt) q ON x.dt = q.dt
				LEFT JOIN (SELECT 
					COUNT(msisdn) cg, dt
				FROM
					(SELECT 
					msisdn, DATE(requesttime) dt
				FROM
					".$db.".callbackrequests
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY msisdn , dt) j
				GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
					0 clicks,
						0 uniq,
						dt,
						COUNT(subscriberid) act,
						0 amt,
						'DCT' typ,
						0 bal,
						0 cg
				FROM
					(SELECT DISTINCT
					DATE(subscriber.subscriptionstartdate) dt,
						subscriber.subscriberid,
						subscriber.charging_mode,
						subscriber.msisdn
				FROM
					".$db.".subscriber
					 INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
				WHERE
				
					amount = 0 AND txnid LIKE '%-81%'
						AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
						AND subscriber.subscriptionstartdate >= '".$start_date."'
						AND subscriber.subscriptionstartdate <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY dt) w
				GROUP BY dt
				ORDER BY dt ASC , clicks ASC) x) bb
				GROUP BY dt , clicks , uniq) y
				GROUP BY dt) z
					LEFT JOIN
				(SELECT 
					dt, SUM(cnt) cbsent
				FROM
					(SELECT 
					dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
				FROM
					(SELECT DISTINCT
					DATE(requesttime) dt, msisdn, advertiserid
				FROM
					".$db.".requestresponse
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a
				INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
				GROUP BY dt , advname) b
				GROUP BY dt) v ON z.dt = v.dt
			ORDER BY z.dt;
					";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	
	
	else if($operator=='ooredoo_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
				
				
							 $sql="SELECT 
				z.*, v.cbsent
			FROM
				(SELECT 
					SUM(clicks) clicks,
						SUM(uniq) uniq,
						dt,
						SUM(act) act,
						SUM(churn) churn,
						SUM(actamnt) actamnt,
						SUM(ren) ren,
						SUM(renamnt) renamnt,
						SUM(Low) Low,
						SUM(cg) cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						SUM(actcnt) act,
						SUM(dctcnt) churn,
						SUM(actamnt) actamnt,
						SUM(rencnt) ren,
						SUM(renamnt) renamnt,
						SUM(LOWbal) Low,
						cg
				FROM
					(SELECT 
					clicks,
						uniq,
						dt,
						act,
						amt,
						CASE
							WHEN typ = 'DCT' THEN act
							ELSE 0
						END dctcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN act
							ELSE 0
						END ACTcnt,
						CASE
							WHEN typ = 'ACT' AND amt > 0 THEN amt
							ELSE 0
						END ACTAMNT,
						CASE
							WHEN typ = 'REN' THEN act
							ELSE 0
						END RENcnt,
						CASE
							WHEN typ = 'REN' THEN amt
							ELSE 0
						END RENAMNT,
						CASE
							WHEN typ = 'ACT' AND bal = 0 THEN act
							ELSE 0
						END LOWbal,
						bal,
						cg
				FROM
					(SELECT 
					IFNULL(clicks, 0) clicks,
						IFNULL(uniq, 0) uniq,
						CASE
							WHEN z.dt is null THEN x.dt
							ELSE z.dt
						END dt,
						act,
						amt,
						typ,
						bal,
						IFNULL(cg, 0) cg
				FROM
					(SELECT 
					COUNT(*) act,
						dt,
						SUM(amount) amt,
						CASE
							WHEN isrenew = 0 THEN 'ACT'
							ELSE 'REN'
						END typ,
						1 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND subscriptionstartdate < subscriptionenddate
						AND advertiserid=".$advertiserid."
						AND subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)) a
				GROUP BY dt , isrenew UNION SELECT 
					COUNT(*) act, dt, 0 amt, 'ACT' typ, 0 bal
				FROM
					(SELECT DISTINCT
					subscriber.subscriberid,
						DATE(subscriptionstartdate) dt,
						amount,
						isrenew
				FROM
					".$db.".subscriber
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate <= '".$end_date."'
						AND txnid LIKE '%,1122%'
						AND advertiserid=".$advertiserid."
						) a
				GROUP BY dt) x
				LEFT JOIN (SELECT 
					COUNT(clicks) clicks, dt
				FROM
					(SELECT 
					userid clicks, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
						) y
						
				GROUP BY dt) z ON x.dt = z.dt
				LEFT JOIN (SELECT 
					COUNT(clicks) uniq, dt
				FROM
					(SELECT DISTINCT
					userid clicks, dt
				FROM
					(SELECT 
					userid, DATE(AccessTime) dt
				FROM
					".$dblog.".annonymoustracking
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a) p
				GROUP BY dt) q ON x.dt = q.dt
				LEFT JOIN (SELECT 
					COUNT(msisdn) cg, dt
				FROM
					(SELECT 
					msisdn, DATE(requesttime) dt
				FROM
					".$db.".callbackrequests
				INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY msisdn , dt) j
				GROUP BY dt) k ON x.dt = k.dt UNION SELECT 
					0 clicks,
						0 uniq,
						dt,
						COUNT(subscriberid) act,
						0 amt,
						'DCT' typ,
						0 bal,
						0 cg
				FROM
					(SELECT DISTINCT
					DATE(subscriber.subscriptionstartdate) dt,
						subscriber.subscriberid,
						subscriber.charging_mode,
						subscriber.msisdn
				FROM
					".$db.".subscriber
					 INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
				WHERE
				
					amount = 0 AND txnid LIKE '%-81%'
						AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
						AND subscriber.subscriptionstartdate >= '".$start_date."'
						AND subscriber.subscriptionstartdate <= '".$end_date."'
						AND advertiserid=".$advertiserid."
				GROUP BY dt) w
				GROUP BY dt
				ORDER BY dt ASC , clicks ASC) x) bb
				GROUP BY dt , clicks , uniq) y
				GROUP BY dt) z
					LEFT JOIN
				(SELECT 
					dt, SUM(cnt) cbsent
				FROM
					(SELECT 
					dt, COUNT(a.advertiserid) cnt, a.advertiserid, advname
				FROM
					(SELECT DISTINCT
					DATE(requesttime) dt, msisdn, advertiserid
				FROM
					".$db.".requestresponse
				WHERE
					requesttime >= '".$start_date."'
						AND requesttime <= '".$end_date."'
						AND advertiserid=".$advertiserid.") a
				INNER JOIN ".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
				GROUP BY dt , advname) b
				GROUP BY dt) v ON z.dt = v.dt
			ORDER BY z.dt;
					";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
	}
	
	
	
}
//echo $sql;
//echo $count;exit;
$fields=mysqli_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";
$start_date2=$_POST['start_date'];
$end_date2=$_POST['end_date'];

	//					exit;

}
?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            
			
          
			

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Report <small>Clicks, Activation, Deactivation, Churn, Amount, Revenue</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product" onchange="myfun()">
							<option>Product</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glambar</option>
							
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
						<?php
						if($product == 'glambar')
						{ ?>
							<option>Operator</option>
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Oxygen</option>
							<option value="southafrica_intarget" <?php if($operator=='southafrica_intarget'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Intarget</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_India</option>
							<option value="hotshots_vodafone" <?php if($operator=='hotshots_vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots_Vodafone</option>
							<option value="idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?> >Idea_India</option>
							<!--<option value="airtel_india" <?php //if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Airtel_India
							</option>
							<option value="hotshots_airtel" <?php //if($operator=='hotshots_airtel'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots_Airtel
							</option>-->
							<!--<option value="bsnl_india" <?php //if($operator=='bsnl_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bsnl_India
							</option>-->
							<option value="kenya_oxygen" <?php if($operator=='kenya_oxygen'){$selected='selected';}else{$selected='';} echo $selected; ?> >Kenya_Oxygen
							</option>
							<option value="thailand_svobi" <?php if($operator=='thailand_svobi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand
							<option value="new_thailand" <?php if($operator=='new_thailand'){$selected='selected';}else{$selected='';} echo $selected; ?> >New_Thailand
							</option>
							<option value="portugal" <?php if($operator=='portugal'){$selected='selected';}else{$selected='';} echo $selected; ?> >Portugal</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain</option>
							<option value="rusia_biline" <?php if($operator=='rusia_biline'){$selected='selected';}else{$selected='';} echo $selected; ?> >Biline Rusia</option>
							<option value="rusia_tele2" <?php if($operator=='rusia_tele2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tele2 Rusia</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland</option>
							<option value="vodacom_wfh" <?php if($operator=='vodacom_wfh'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodacom_Wfh</option>
							<option value="vodacom_fg" <?php if($operator=='vodacom_fg'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodacom_Fg</option>
							<option value="vodacom_bt" <?php if($operator=='vodacom_bt'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodacom_Bt</option>
							<!--<option value="Airtel" <?php //if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>-->
						<?php
						}
						else if($product == 'gamebar'){
						?>
							<option value="Vodafone_Qatar" <?php if($operator=='Vodafone_Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_Qatar</option>
								<option value="ooredoo_qatar" <?php if($operator=='ooredoo_qatar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Qatar</option>
								<option value="qu_qatar" <?php if($operator=='qu_qatar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Qu_Qatar</option>
								<option value="qatar_gamestation" <?php if($operator=='qatar_gamestation'){$selected='selected';}else{$selected='';} echo $selected; ?>>Qatar_Gamestation</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Oman</option>
							<option value="malaysia_cellcom" <?php if($operator=='malaysia_cellcom'){$selected='selected';}else{$selected='';} echo $selected; ?>>cellcom_Malaysia</option>
							
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Oxygen</option>
							<option value="southafrica_intarget" <?php if($operator=='southafrica_intarget'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Intarget</option>
							
							<option value="portugal" <?php if($operator=='portugal'){$selected='selected';}else{$selected='';} echo $selected; ?> >Portugal</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Indonesia</option>
							<option value="egypt" <?php if($operator=='egypt'){$selected='selected';}else{$selected='';} echo $selected; ?> >Egypt</option>
							<option value="du_dubai" <?php if($operator=='du_dubai'){$selected='selected';}else{$selected='';} echo $selected; ?> >Du_Dubai</option>
							<option value="kenya_oxygen" <?php if($operator=='kenya_oxygen'){$selected='selected';}else{$selected='';} echo $selected; ?> >Kenya_Oxygen
							</option>
							<option value="rusia_biline" <?php if($operator=='rusia_biline'){$selected='selected';}else{$selected='';} echo $selected; ?> >Biline Rusia</option>
							<option value="rusia_tele2" <?php if($operator=='rusia_tele2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tele2 Rusia</option>
							<option value="tim_italy" <?php if($operator=='tim_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tim Italy</option>
							<option value="wind_italy" <?php if($operator=='wind_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >Wind Italy</option>
							<option value="h3g_italy" <?php if($operator=='h3g_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >H3g Italy</option>
							<option value="guatemala" <?php if($operator=='guatemala'){$selected='selected';}else{$selected='';} echo $selected; ?> >Guatemala</option>
							<option value="myanmar" <?php if($operator=='myanmar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Myanmar</option>
							<option value="kazakistan" <?php if($operator=='kazakistan'){$selected='selected';}else{$selected='';} echo $selected; ?> >Kazakistan</option>
							<option value="ecuador" <?php if($operator=='ecuador'){$selected='selected';}else{$selected='';} echo $selected; ?> >Ecuador</option>
					
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland</option>
							<option value="Bangladesh_Robi" <?php if($operator=='Bangladesh_Robi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bangladesh_Robi</option>
							<option value="Cosmote_Greece" <?php if($operator=='Cosmote_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Cosmote_Greece</option>
							
							<option value="Vodafone_Greece" <?php if($operator=='Vodafone_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_Greece</option>
							
							<option value="Wind_Greece" <?php if($operator=='Wind_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Wind_Greece</option><option value="all_greece" <?php if($operator=='all_greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >All_Greece</option>
							<option value="Mts_Serbia" <?php if($operator=='Mts_Serbia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Mts_Serbia</option>
							<option value="Vip_Serbia" <?php if($operator=='Vip_Serbia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vip_Serbia</option>
							<option value="du_uae" <?php if($operator=='du_uae'){$selected='selected';}else{$selected='';} echo $selected; ?> >Du_UAE</option>
							<option value="etisalad_uae" <?php if($operator=='etisalad_uae'){$selected='selected';}else{$selected='';} echo $selected; ?> >Etisalad_UAE</option>
							<option value="palestine" <?php if($operator=='palestine'){$selected='selected';}else{$selected='';} echo $selected; ?> >Palestine</option>
							<option value="sweden" <?php if($operator=='sweden'){$selected='selected';}else{$selected='';} echo $selected; ?> >Sweden</option>
							
							
							
							
							
						<?php
						}
						else{
						?>
						<option>Operator</option>
						<?php
						}
						
						?>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){ echo date('d-m-Y',strtotime($start_date2)); } else { echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						
						<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback first"> Advertiser
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
							//echo $operator;exit;
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel">
									<?php
									
									if( $operator == 'idea' or $operator=='bsnl_india'){
										
									
									
									
									}
									else{
										
										echo "<option value='all'>All</option>";
									}
									while($row_ad=mysqli_fetch_array($res_ad))
									{
										if($row_ad['advertiserid']==$advertiserid)
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
									?>
									<option value="<?php echo $row_ad['advertiserid']; ?>" <?php echo $selected; ?>><?php echo $row_ad['advname']; ?></option>
									<?php
									}
									?>
									
								</select>
								</span>
							</div>
						<?php
						}
						?>
						

                     
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Output Records <small></small></h2>
							<ul class="nav navbar-right panel_toolbox">
							  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							  </li>
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
								  <li><a href="#">Settings 1</a>
								  </li>
								  <li><a href="#">Settings 2</a>
								  </li>
								</ul>
							  </li>
							  <li><a class="close-link"><i class="fa fa-close"></i></a>
							  </li>
							</ul>
							<div class="clearfix"></div>
						</div>
						
			<?php 
			//echo $operator;
			
				$swq="select operator_cost from `gamebardb_vodafone_qatar_report`.`operatorcost` where operator='".$operator."'";
				$ser=mysqli_query($con3,$swq) or die(mysqli_error());
				while($wor=mysqli_fetch_array($ser))
				{
					$cost=$wor['operator_cost'];
				}
				
				$swq1="select revenueshare from `gamebardb_vodafone_qatar_report`.`svmobi_revenueshare` where operator='".$operator."'";
				$ser1=mysqli_query($con3,$swq1) or die(mysqli_error());
				while($wor1=mysqli_fetch_array($ser1))
				{
					 $revenue=$wor1['revenueshare'];
				}
			if($count==1)
			{
				$k=$l=0;
				//echo $cc;exit;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>With mdn</strong></td><!--uniq-->
									<td><strong>Sent CG</strong></td>
									<td><strong>Conv %</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Renewal</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Total Count</strong></td>
									<td><strong>Total Amount</strong></td>
									<td><strong>SVMobi Revenue</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Low Bal.</strong></td>
									<td><strong>Callback Sent</strong></td>
									<td><strong>Callback %</strong></td>
									<td><strong>Adv. Cost</strong></td>
									
									
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
							//echo $sql;
								$click_sum='';
								$uniq_sum='';
								$cg_sum='';
								$act_sum='';
								$actamnt_sum='';
								$ren_sum='';
								$renamnt_sum='';
								$count_sum='';
								$amount_sum='';
								$low_sum='';
								$cbsent_sum='';
								$churn_sum='';
								$advcost_sum=$svmobiamount_sum='';
									
								if($cc==1)
								{
									//echo "hi";
									while($row=mysqli_fetch_array($res))
									{
										$ddate=date('d-m-Y',strtotime($row['dt']));
										$dclick=$row['clicks'];
										if($dclick=="")
										{
											$dclick=0;
										}
										$duniq=$row['uniq'];
										if($duniq == "")
										{
											$duniq=0;
											
										}
										$dcg=$row['cg'];
										$dconv=($row['act']*100)/$row['clicks'];
										$dact=$row['act'];
										
										$dactamnt=$row['actamnt'];
										
										$dren=$row['ren'];
										$drenamnt=$row['renamnt'];
										$dcount=$row['act']+$row['ren'];
										$damount=$row['actamnt']+$row['renamnt'];
										$churn=$row['dct'];
										$dlow=$row['Low'];
										$dcbsent=$row['cbsent'];
										if($dcbsent>0)
										{
										$dcbs=($dcbsent*100)/$row['act'];
										}else
										{
											$dcbs=0;
										}
										
										
											
										
										
										
										$dadvcost=$row['cbsent']*$cost;
										
										
								?>
									<tr>
										<td><?php echo $ddate; //date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($dclick); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($duniq); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										<td><?php echo number_format($dcg); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php echo number_format($dconv, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dact); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($dactamnt,2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($dren); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($drenamnt,2,'.',''); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($dcount); $count_sum=$count_sum+$dcount; ?></td>
										<td><?php echo number_format($damount,2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										?>
										
										<td><?php echo number_format($churn); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($dlow); $low_sum=$low_sum+$row['Low'];?></td>

										<td><?php echo number_format($dcbsent); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></td>
										<td><?php echo number_format($dcbs, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dadvcost, 2, '.', ''); $advcost_sum=$advcost_sum+$dadvcost; ?></td>
										
										
									</tr>
								
								
								
								<?php
									}
									
								}
								elseif($cc==2)
								{
									
									
									if(mysqli_num_rows ($res1)>0)
									{
										$l=1;
									}
									while($row1=mysqli_fetch_array($res1))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row1['Date']));  ?></td>
										<td><?php echo number_format($row1['clicks']); $click_sum=$click_sum+$row1['clicks']; ?></td>
										
										<td><?php echo number_format($row1['uniq']); $uniq_sum=$uniq_sum+$row1['uniq'];?></td>
										
										<td><?php echo number_format($row1['cg']); $cg_sum=$cg_sum+$row1['cg'];?></td>
										<td><?php $conv=$row1['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($row1['actcount']); $act_sum=$act_sum+$row1['actcount'];?></td>
										<td><?php echo number_format($row1['actamount'],2,'.',''); $actamnt_sum=$actamnt_sum+$row1['actamount'];?></td>
										<td><?php echo number_format($row1['renewcount']); $ren_sum=$ren_sum+$row1['renewcount']; ?></a></td>
										<td><?php echo number_format($row1['renewamount'],2,'.',''); $renamnt_sum=$renamnt_sum+$row1['renewamount'];?></td>
										<td><?php echo number_format($count=$row1['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row1['totalamount'],2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										
										
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										?>
										<td><?php echo number_format($row1['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										
										<td><?php echo number_format($row1['park']); $low_sum=$low_sum+$row1['park']; ?></td>
										<td><?php echo number_format($row1['cbsent']); $cbsent_sum=$cbsent_sum+$row1['cbsent']; ?></td>
										<td><?php echo number_format($row1['cbsentpercent'], 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($advcost=$row1['cbsent']*$cost, 2, '.', ''); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
									while($row=mysqli_fetch_array($res))
									{
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=($row['act']*100)/$row['clicks']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($row['actamnt'],2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($row['renamnt'],2,'.',''); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($count=$row['act']+$row['ren']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['actamnt']+$row['renamnt'],2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										
										
										<?php
										}
										?>
										
										
										
										<td><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										<td><?php echo number_format($row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php $cbs=($row['cbsent']*100)/$row['act']; echo number_format($cbs, 2, '.', '')."%"; ?></td>
										<?php
										
										
										
											$dadvcost1=$row['cbsent']*$cost;
										
										?>
										<td><?php echo number_format($dadvcost1, 2, '.', ''); $advcost_sum=$advcost_sum+$dadvcost1; ?></td>
										
									</tr>
								<?php
									}
								}
								else
								{
									while($row=mysqli_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['Date']));  ?></td>
										<td><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										
										<td><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=$row['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($row['actcount']); $act_sum=$act_sum+$row['actcount'];?></td>
										<td><?php echo number_format($row['actamount'],2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamount'];?></td>
										<td><?php echo number_format($row['renewcount']); $ren_sum=$ren_sum+$row['renewcount']; ?></td>
										<td><?php echo number_format($row['renewamount'],2,'.',''); $renamnt_sum=$renamnt_sum+$row['renewamount'];?></td>
										<td><?php echo number_format($count=$row['totalcount'],2,'.',''); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['totalamount'],2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										
										<?php
										if($revenue !='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										
										<?php
										}
										?>
										
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='churn'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row['churn'];?></a></td>
										<td><?php echo number_format($row['park']); $low_sum=$low_sum+$row['park']; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php echo number_format($row['cbsentpercent'], 2, '.', '')."%";?></td>
										<td><?php echo number_format($advcost=$row['cbsent']*$cost, 2, '.', ''); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
								}
								if(mysqli_num_rows ($res)>0)
								{
									$k=1;
								}
								
								if($k==1 or $l==1)
									{
								?>
								
								
								
								<tr>
									<td>Total</td>
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format($uniq_sum); ?></td>
									<td><?php echo number_format($cg_sum); ?></td>
									<td></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo  number_format($actamnt_sum,2,'.','');?></td>
									<td><?php echo number_format($ren_sum); ?></td>
									<td><?php echo number_format($renamnt_sum,2,'.',''); ?></td>
									<td><?php echo number_format($count_sum); ?></td>
									<td><?php echo number_format($amount_sum,2,'.',''); ?></td>
									<td><?php echo number_format($svmobiamount_sum,2,'.',''); ?></td>
									<td><?php echo number_format($churn_sum); ?></td>
									<td><?php echo number_format($low_sum); ?></td>
									<td><?php echo number_format($cbsent_sum); ?></td>
									<td></td>
									<td><?php echo number_format($advcost_sum, 2, '.', ''); ?></td>
									
									
								</tr>
									<?php 
									}
									?>
							</tbody>
							
							
								
								
						</table>
					  </div>
				<!--<div id="advertiser"></div>-->
			<?php
			}
			else if($count==2)
			{
				//echo "hi";exit;
			?>	
			
			<div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>With mdn</strong></td><!--uniq-->
									
									<td><strong>Conv %</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Renewal</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Total Count</strong></td>
									<td><strong>Total Amount</strong></td>
									<td><strong>SVMobi Revenue</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Low Bal.</strong></td>
									<td><strong>%Low Conv</strong></td>

										
								</tr>
							</thead>


							<tbody>
							<?php
							
							while($row=mysqli_fetch_array($res))
							{
								?>
									<tr>
										<td><?php echo $row['dt']; //date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($dclick=$row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($duniq=$row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										<td><?php echo number_format($dconv=$row['conv'], 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dact=$row['act']); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($dactamnt=$row['actamnt'],2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($dren=$row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($drenamnt=$row['renamnt'],2,'.',''); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($dcount=$row['totalcount']); $count_sum=$count_sum+$dcount; ?></td>
										<td><?php echo number_format($damount=$row['totalamount'],2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='spain')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										?>
										<td><?php echo number_format($churn=$row['dct']); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($dlow=$row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><?php echo number_format($row['lowconv'], 2, '.', '')."%"; ?></td>

									
										
										
										
										
									</tr>
								<?php
							}
							
							?>
							</tbody>
							</table>
					  </div>
			
			<?php	
			}
			else{
				
			}
			?>
					</div>
                </div>
			</div>
			
		</div>
        <!-- /page content -->
		
       <?php
	   include("includes/footer.php");
		?>
		
<script type="text/javascript">
 $(document).ready(function(){

   $("#operator").change(function(){
		
		var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel").val('');
			$("#t").hide();
			$("#f").show();
						
		}
        var operator = $("#operator").val();
		var product = $("#product").val();
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>
<script type="text/javascript">
function myfun() {
	var x = document.getElementById("product").value;
    //alert(x);
	if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('South-Africa Oxygen', 'south-africa');
		select.options[select.options.length] = new Option('South-Africa Intarget', 'southafrica_intarget');
		select.options[select.options.length] = new Option('Thailand', 'thailand_svobi');
		select.options[select.options.length] = new Option('New_Thailand', 'new_thailand');
		select.options[select.options.length] = new Option('Portugal', 'portugal');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		select.options[select.options.length] = new Option('Biline Rusia', 'rusia_biline');
		select.options[select.options.length] = new Option('Tele2 Rusia', 'rusia_tele2');
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Vodacom_Wfh', 'vodacom_wfh');
		select.options[select.options.length] = new Option('Vodacom_Fg', 'vodacom_fg');
		select.options[select.options.length] = new Option('Vodacom_Bt', 'vodacom_bt');
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		
		select.options[select.options.length] = new Option('South-Africa Oxygen', 'south-africa');
		select.options[select.options.length] = new Option('South-Africa Intarget', 'southafrica_intarget');
		select.options[select.options.length] = new Option('Ooredoo_Oman', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Qatar_Gamestation', 'qatar_gamestation');
		select.options[select.options.length] = new Option('Ooredoo_Qatar', 'ooredoo_qatar');
		select.options[select.options.length] = new Option('Qu_Qatar', 'qu_qatar');
		select.options[select.options.length] = new Option('Cellcom_Malaysia', 'malaysia_cellcom');
		
		
		//select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
	//	select.options[select.options.length] = new Option('Bsnl_India', 'bsnl_india');
		select.options[select.options.length] = new Option('Portugal', 'portugal');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Egypt', 'egypt');
		select.options[select.options.length] = new Option('Du_Dubai', 'du_dubai');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		select.options[select.options.length] = new Option('Biline Rusia', 'rusia_biline');
		select.options[select.options.length] = new Option('Tele2 Rusia', 'rusia_tele2');
		select.options[select.options.length] = new Option('Tim Italy', 'tim_italy');
		select.options[select.options.length] = new Option('Wind Italy', 'wind_italy');
		select.options[select.options.length] = new Option('H3g Italy', 'h3g_italy');
		select.options[select.options.length] = new Option('Guatemala', 'guatemala');
		select.options[select.options.length] = new Option('Myanmar', 'myanmar');
		select.options[select.options.length] = new Option('Kazakistan', 'kazakistan');
		select.options[select.options.length] = new Option('Ecuador', 'ecuador');
		
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Bangladesh_Robi', 'Bangladesh_Robi');
		select.options[select.options.length] = new Option('Cosmote_Greece', 'Cosmote_Greece');
		select.options[select.options.length] = new Option('Vodafone_Greece', 'Vodafone_Greece');
		select.options[select.options.length] = new Option('Wind_Greece', 'Wind_Greece');
		select.options[select.options.length] = new Option('All_Greece', 'all_greece');
		select.options[select.options.length] = new Option('Mts_Serbia', 'Mts_Serbia');
		select.options[select.options.length] = new Option('Vip_Serbia', 'Vip_Serbia');
		select.options[select.options.length] = new Option('Du_UAE', 'du_uae');
		select.options[select.options.length] = new Option('Etisalad_UAE', 'etisalad_uae');
		select.options[select.options.length] = new Option('Palestine', 'palestine');
		select.options[select.options.length] = new Option('Sweden', 'sweden');
	}
	
	/*if(x=="glambar")
	{
		 //alert("hi");
	document.getElementById('azharbeizan').style.visibility = 'hidden';
	}else
	{
		document.getElementById('azharbeizan').style.visibility = 'visible';
	}*/
}
</script>		
<script>
 function getdata(startdate,enddate,db,dblog,advertiser,parameter){

  
  if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("advertiser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","mehul_ajax/mehul_ajax.php?startdate="+startdate+"&enddate="+enddate+"&db="+db+"&dblog="+dblog+"&advertiser="+advertiser+"&parameter="+parameter,true);
        xmlhttp.send();
    }
 
 </script>   

