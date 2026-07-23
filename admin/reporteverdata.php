<?php

ini_set('max_execution_time', 6000);

include("includes/check_session.php");
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);
$con=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2





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
		if($operator=='poland')
		{
			$db="glambar_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='greecepd')
		{
			$db="fashionbardb_paydashgrglam";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbpaydashgrglam.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='southafricamtn' || $operator=='southafricacellc')
		{
			
			$db="fashionbardb_zaglam";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbzaglam.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='thailand_svobi')
		{
			$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);*/
		}
		else if($operator=='poland_teleaudio')
		{
			
			$db="glambar_plteleaudio";
			$commondb="advertiserdb";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$commondb.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='new_thailand')
		{
			$db="fashionbardb_glam9005thailand";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbthailand.newadvertiser";
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
		else if($operator=='vodacom_All')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='Cosmote_Greece')
		{
			
			$db="glambardb_greececosmote";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Vodafone_Greece')
		{
			
			$db="glambardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Wind_Greece')
		{
			
			$db="glambardb_greecewind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='all_greece')
		{
			
			$db="glambardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		
		
	}
	else
	{
		//echo $operator;exit;
		if($operator=='vodacom_za')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=4";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='cambodia')
		{
			
			$db="gamesdbnew_smart_cambodia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='southafricamtn' || $operator=='southafricacellc')
		{
			
			$db="fashionbardb_za";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbza.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='ksa_all_weekly' || $operator=='ksa_mobily_weekly' || $operator=='ksa_stc_weekly' ||$operator=='ksa_zain_weekly' )
		{
			
			$db="fashionbardb_saweekly";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbsaweekly.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='thailand9305')
		{
			$db="fashionbardb_game9305thailand";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbthailand.newadvertiser  ";
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
		else if($operator=='srilanka_gamestore')
		{
			
			$db="gamebar_srilanka";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='vodafoneqatar')
		{
			
			$db="fashionbardb_qatarvodafone";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbqatarvodafone.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='zain_ksa')
		{
			
			$db="fashionbardb_timwezain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbtimwezain.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='finland')
		{
			
			$db="fashionbardb_finland";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbfinland.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='stc_ksa')
		{
			
			$db="fashionbardb_timwezain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbtimwezain.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='buhrain_zain')
		{
			
			$db="fashionbardb_bh";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbh.advertiser";
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
		else if($operator=='france')
		{
			
			$db="fashionbardb_france";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbfrance.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='malaysiamaxis')
		{
			
			$db="gamebar_my";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='norway')
		{
			
			$db="gamebardb_norway";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		
		
		
		
		else if($operator=='dialog_srilanka')
		{
			
			$db="gamesdbnew_dialog_srilanka";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='blazon_etisalad')
		{
			
			$db="fashionbardb_uae";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='poland')
		{
			$db="gamebar_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='sweden')
		{
			$db="gamebar_sweden";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='egypt')
		{
			
			$db="gamebar_tpayegypt";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$commondb="advertiserdb";
			$sql_ad="select * from ".$commondb.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='egypt_mondemedia')
		{
			
			$db="gamebar_egypt";
			$commondb="advertiserdb";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$commondb.".advertiser ";
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
		else if($operator=='algeria')
		{
			
			$db="gamebardb_algeria";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kwzain')
		{
			
			$db="fashionbardb_slakwzain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbslakwzain.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kwstc')
		{
			
			$db="fashionbardb_slakwstc";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbslakwstc.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='russia')
		{
			
			$db="fashionbardb_ru";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbru.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='netherland_netsmart')
		{
			
			$db="fashionbardb_nl";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbnl.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='uae_etisalat')
		{
			
			$db="fashionbardb_etisalat";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbetisalat.advertiser  ";
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
		
		else if($operator=='spain')
		{
			
			$db="gamebardb_spain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		elseif($operator=='ooredoo_oman')
		{
			$db="gamesdb_ooredoo_oman";
			$dblog="gamesdblog_ooredoo_oman";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbomooredoo.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		elseif($operator=='oman_omantel')
		{
			$db="fashionbardb_omantel";
			$dblog="gamesdblog_omantel_oman";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbomantel.advertiser  ";
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
		
		
		elseif($operator=='ooredoo_qatar')
		{
			$db="fashionbardb_qatarooredoo";
			$dblog="gamesdblog_ooredoo_qatar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbqatarooredoo.advertiser ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		elseif($operator=='qatar_gamestation')
		{
			$db="fashionbardb_qatarooredoo";
			$dblog="gamesdblog_ooredoo_qatar_gamestation";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbqatarooredoo.advertiser  ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		else if($operator=='Cosmote_Greece')
		{
			
			$db="gamebardb_greececosmote";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamebardb_greecevf.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Vodafone_Greece')
		{
			
			$db="gamebardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamebardb_greecevf.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='Wind_Greece')
		{
			
			$db="gamebardb_greecewind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamebardb_greecevf.advertiser  ";
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
		else if($operator=='pk_telenor')
		{
			
			$db="gamebar_pk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=1  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='pk_zong')
		{
			
			$db="gamebar_pk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=2  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='bahrain')
		{
			
			$db="gamesdb_batelviva_bahrain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='uae_du')
		{
			
			$db="gamesdb_uaedu_ma";
			$dblog="gamesdblog_uaedu_ma";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$dblog.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='bahrain_stc')
		{
			
			$db="fashionbardb_bhstc";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbhstc.advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='bahrain_batelco')
		{
			
			$db="fashionbardb_bhbatelco";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbhbatelco.advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='saudi_mobily')
		{
			
			$db="fashionbardb_timwezain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbtimwezain.advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		
		else if($operator=='gr2')
		{
			
			$db="fashionbardb_greece";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbgreece.advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='greecepd')
		{
			$db="fashionbardb_paydashgr";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbpaydashgr.advertiser  ";
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
	else if($operator=='Bangladesh_Robi')
	{//vodafone
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
		
	}
	else if($operator=='cambodia')
	{//vodafone
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
		
	}
	
	
	else if($operator=='ksa_all_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
					 $sql="call fashionbardb_saweekly.allreport('".$start_date."','".$end_date."',0)";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	
	else if($operator=='ksa_mobily_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mobily')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mobily')";
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
	
	
	else if($operator=='thailand9305')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
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
	
	
	
	else if($operator=='ksa_stc_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','stc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','stc')";
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
	
	else if($operator=='ksa_zain_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','zain')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','zain')";
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
	
	else if($operator=='srilanka_gamestore')
	{//vodafone
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
		
	}
	
	
	
	
	
	
	else if($operator=='vodafoneqatar')
	{//vodafone
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
		
	}
	
	
	else if($operator=='algeria')
	{//vodafone
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
		
	}
	
	
	else if($operator=='uae_etisalat')
	{//vodafone
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
		
	}
	
	
	
	
	
	
	
	else if($operator=='kwzain')
	{//vodafone
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
		
	}
	
	else if($operator=='kwstc')
	{//vodafone
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
		
	}
	
	
	else if($operator=='russia')
	{//vodafone
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
		
	}
	
	
	
	else if($operator=='buhrain_zain')
	{//vodafone
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
		
	}
	
	else if($operator=='southafricamtn')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					echo $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mtn')";
					exit;
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mtn')";
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
				
				
					
					echo $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mtn')";
					exit;
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mtn')";
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
	
	else if($operator=='southafricacellc')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','cellc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','cellc')";
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
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','cellc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','cellc')";
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
	
	
	else if($operator=='malaysiamaxis')
	{//vodafone
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
		
	}
	
	
	
	
	
	
	
	
	
	else if($operator=='stc_ksa')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','stc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','stc')";
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
	else if($operator=='zain_ksa')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','zain')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','zain')";
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
	
	
	
	
	else if($operator=='netherland_netsmart')
	{//vodafone
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
		
	}
	else if($operator=='france')
	{//vodafone
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
		
	}
	
	else if($operator=='norway')
	{//vodafone
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
		
	}
	
	
	
	
	else if($operator=='gr2')
	{//vodafone
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
		
	}
	
	else if($operator=='bahrain')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
	 	$sql="call fashionbardb_bh.allreport('".$start_date."','".$end_date."')";
	//echo $sql;exit;
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	else if($operator=='kw_all')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
	 	$sql="call fashionbardb_slakwzain.allreport('".$start_date."','".$end_date."')";
	//echo $sql;exit;
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	
	else if($operator=='bahrain_batelco')
	{//vodafone
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
		
		
	}
	
	
	else if($operator=='bahrain_stc')
	{//vodafone
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
		
		
	}
	
	
	
	else if($operator=='saudi_mobily')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					  $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mobily')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','mobily')";
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
	
	else if($operator=='uae_du')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','0')";
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
	
	
	
	
	
	else if($operator=='oman_omantel')
	{//vodafone
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
		
	}
	
	

	
	
	else if($operator=='dialog_srilanka')
	{//vodafone
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
		
	}
	
	
	
	
	
	
	else if($operator=='myanmar')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
				 	echo  $sql="call ".$db.".report(0,'".$start_date."','".$end_date."')";
					exit;
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					 $sql="call ".$db.".report(0,'".$start_date."','".$end_date."')";
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
	else if($operator=='ecuador')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
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
	
	
	
	else if($operator=='tmobile_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
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
	
	else if($operator=='hutchison_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."',0)";
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
	
	
	
	
	if($operator=='egypt')
	{//egypt
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
		
	}
	
	if($operator=='egypt_mondemedia')
	{//egypt
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
		
	}
	
	
	else if($operator=='ooredoo_oman')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call fashionbardb_omooredoo.mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call fashionbardb_omooredoo.mainreport('".$start_date."','".$end_date."','0')";
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
	else if($operator=='malaysia_cellcom')
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
		
	}
	
	else if($operator=='south-africa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','0')";
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
	
	else if($operator=='poland')
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
	
	else if($operator=='poland_teleaudio')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
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
	
	
	
	else if($operator=='sweden')
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
	
	
	else if($operator=='Cosmote_Greece')
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
	else if($operator=='Vodafone_Greece')
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
	else if($operator=='Wind_Greece')
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
	else if($operator=='all_greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call fashionbardb_greecegamebar.mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call fashionbardb_greecegamebar.mainreport('".$start_date."','".$end_date."','0')";
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
				
				
					
					$sql="call fashionbardb_greeceglambar.mainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call fashionbardb_greeceglambar.mainreport('".$start_date."','".$end_date."','0')";
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
	else if($operator=='sweden')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".swedenmainreport('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".swedenmainreport('".$start_date."','".$end_date."','0')";
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
			
			
		}
	}	
	
	
	
	
	
	
	
	else if($operator=='indonesia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
					//exit;
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
			
			
		}
	}
	
	else if($operator=='vodacom_za')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0',4)";
					
				$cc=1;
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
	
	
	else if($operator=='vodacom_All')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			/*if($end_date1 == $date1 && $start_date1 == $date1)
			{
				*/
				
					
				 	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','0')";
					
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
	
	
	
	
	
	else if($operator=='ksa_all')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
	 $sql="call fashionbardb_timwezain.allreport('".$start_date."','".$end_date."',0)";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
		
		
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
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
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
	else if($operator=='new_thailand')
	{
			if($product=='gamebar' || $product=='gamebar')
			{
			}else{
		
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".report('".$start_date."','".$end_date."','0')";
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
	
	
	else if($operator=='blazon_etisalad')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		 $sql="call ".$db.".report('".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
		
		}
		else{
			
			 
			
			
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
	
	else if($operator=='pk_telenor')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','06')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','06')";
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
			
			
			
		}
	}
	
	
	
	else if($operator=='pk_zong')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','04')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0','04')";
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
			
			
			
		}
	}
	
	
	
	
	
	
	elseif($operator=='qatar_gamestation')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				   if($end_date1 == $date1 && $start_date1 == $date1)
					{
						
						
							
							$sql="call fashionbardb_qatarooredoo.mainreport_gamestation('".$start_date."','".$end_date."','0')";
							
						$cc=1;
						$res=mysqli_query($con1,$sql) or die(mysqli_error());
					}
					elseif($end_date1 == $date1 && $start_date1 != $date1)
					{
						 $sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
						$res1=mysqli_query($con,$sql1);
						
						$start_date=date('Y-m-d 00:00:00');
						$end_date=date('Y-m-d 23:59:59');
						
							$sql="call fashionbardb_qatarooredoo.mainreport_gamestation('".$start_date."','".$end_date."','0')";
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
			
			
		}
		
	}

	
	
	
	elseif($operator=='ooredoo_qatar')
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
			
			
		}
		
	}
	
	elseif($operator=='finland')
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
			
			
		}
		
	}
	
	elseif($operator=='greecepd')
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
				
				
					
				echo 	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
				
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
	
	else if($operator=='vodafone')
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
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		
		else{
			 //$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			//$cc=1;
			//	$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','0')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	
	
	
}



else
{
	
	//echo $operator;exit;
	if($operator=='Vodafone_Qatar')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	else if($operator=='Bangladesh_Robi')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	else if($operator=='thailand9305')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			$sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	
	else if($operator=='cambodia')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	else if($operator=='ksa_all_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
					 $sql="call fashionbardb_saweekly.allreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	else if($operator=='ksa_all')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
					 $sql="call fashionbardb_timwezain.allreport(('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
		}
		
	}
	
	
	else if($operator=='ksa_mobily_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mobily')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mobily')";
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
	
	else if($operator=='ksa_stc_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','stc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','stc')";
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
	
	else if($operator=='ksa_zain_weekly')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','zain')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','zain')";
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
	
	
	
	else if($operator=='srilanka_gamestore')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	
	
	else if($operator=='new_thailand')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			$sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}else{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			$sql="call ".$db.".report('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
			
			
		}		
	}
	
	
	
	
	
	else if($operator=='buhrain_zain')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	
	else if($operator=='vodafoneqatar')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	else if($operator=='dialog_srilanka')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		
			
			
			
		}	
	}
	
	
	
	else if($operator=='netherland_netsmart')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	else if($operator=='france')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
				 echo 	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')"; 
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	else if($operator=='malaysiamaxis')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	else if($operator=='uae_etisalat')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	
	
	
	else if($operator=='norway')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	else if($operator=='gr2')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	
	else if($operator=='bahrain_stc')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	else if($operator=='bahrain_batelco')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	
	else if($operator=='oman_omantel')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	else if($operator=='southafricamtn')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					echo $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mtn')";
					exit;
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."','mtn')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mtn')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."','mtn')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
		
		
	}
	else if($operator=='southafricacellc')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','cellc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."','cellc')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','cellc')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."','cellc')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
		
		
	}
	
	
	
	
	
	else if($operator=='saudi_mobily')
	{
		//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mobily')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0 and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','mobily')";
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
	
	
	else if($operator=='uae_du')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".mainreport1('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	
	else if($operator=='tmobile_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	else if($operator=='hutchison_austria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	else if($operator=='myanmar')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".report('".$advertiserid."','".$start_date."','".$end_date."')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".report('".$advertiserid."','".$start_date."','".$end_date."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	
	
	
	else if($operator=='ecuador')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	
	else if($operator=='Cosmote_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		
		
	}
	else if($operator=='Vodafone_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
		
		
	}
	else if($operator=='Wind_Greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
				
					$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
		
		
	}
	else if($operator=='all_greece')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				
				
					
					 $sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
				$res1=mysqli_query($con,$sql1);
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
					$sql="call ".$db.".grmainreport('".$start_date."','".$end_date."','".$advertiserid."')";
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				 $sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'" ;
				$cc=3;
				$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
		
	}
	
	
	
	
	
	else if($operator=='egypt')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	else if($operator=='egypt_mondemedia')
	{
		
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}	
	}
	
	
	
	else if($operator=='ooredoo_oman')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call fashionbardb_omooredoo.mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call fashionbardb_omooredoo.mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
	}
	
	else if($operator=='malaysia_cellcom')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
		}
	}
	
	else if($operator=='south-africa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport_gamebar('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	else if($operator=='poland')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	else if($operator=='poland_teleaudio')
	{
		if($product=='gamebar' || $product=='gamebar')
		{	
		}
		else{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	
	else if($operator=='sweden')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	
	
	
	
	
	
	
	else if($operator=='vodafone')
	{
		
		//echo $advertiserid;
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
			{
		  //	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
		//	$cc=1;
			//	$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		
		else{
			 //$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			//$cc=1;
			//	$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
		}
	}
	
	
	else if($operator=='gamezone_vodafone')
	{
		
		//echo $advertiserid;
		//$count=2;
		if($product=='gamebar' || $product=='gamebar')
			{
		  //	$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
		//	$cc=1;
			//	$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		
		
	}
	
	
	
	
	
	else if($operator=='indonesia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	else if($operator=='algeria')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	else if($operator=='kwzain')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	
	else if($operator=='kwstc')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	
	
	else if($operator=='russia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	
	
	
	else if($operator=='stc_ksa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							  $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','stc')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','stc')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	else if($operator=='zain_ksa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','zain')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','zain')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	
	else if($operator=='finland')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
		}
	}
	
	
	else if($operator=='vodacom_za')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			$sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','4')";
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
	
	
	else if($operator=='vodacom_all')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			
			
		}
		else{
			
			
			
				
				  $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','0')";
				$cc=1;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	
	else if($operator=='portugal')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
	}
	
	
	else if($operator=='spain')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
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
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
	}
	
	
	else if($operator=='pk_telenor')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','06')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','06')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			
			
		}
	}
	
	
	
	else if($operator=='pk_zong')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			
			
		}
	}
	
	
	
	
	
	else if($operator=='qatar_gamestation')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call fashionbardb_qatarooredoo.mainreport_gamestation('".$start_date."','".$end_date."','".$advertiserid."')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call  fashionbardb_qatarooredoo.mainreport_gamestation('".$start_date."','".$end_date."','".$advertiserid."')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
	}
	
	
	
	else if($operator=='ooredoo_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			
			
		}
	}
	else if($operator=='greecepd')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
		}
		else{
			
			
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
							$cc=1;
								$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
			
			
			 $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
			$cc=2;
			$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$advertiserid."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
			
			
			
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
							
							<option value="all_greece" <?php if($operator=='all_greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_All D</option>
							<option value="Cosmote_Greece" <?php if($operator=='Cosmote_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Cosmote</option>
							<option value="Vodafone_Greece" <?php if($operator=='Vodafone_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Vodafone</option>
							<option value="Wind_Greece" <?php if($operator=='Wind_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Wind</option>
							<option value="greecepd" <?php if($operator=='greecepd'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_PD</option>
							<option value="new_thailand" <?php if($operator=='new_thailand'){$selected='selected';}else{$selected='';} echo $selected; ?> >New_Thailand</option>
							<option value="poland_teleaudio" <?php if($operator=='poland_teleaudio'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_Teleaudio</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_TMobile</option>
							<option value="southafricacellc" <?php if($operator=='southafricacellc'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Cellc</option>
							<option value="southafricamtn" <?php if($operator=='southafricamtn'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Mtn</option>
							<option value="vodacom_All" <?php if($operator=='vodacom_All'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_All</option>
							<option value="vodacom_bt" <?php if($operator=='vodacom_bt'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Bt</option>
							<option value="vodacom_fg" <?php if($operator=='vodacom_fg'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Fg</option>
							<option value="vodacom_wfh" <?php if($operator=='vodacom_wfh'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Wfh</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain_Vodafone</option>
							<option value="thailand_svobi" <?php if($operator=='thailand_svobi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand
							
							
						<?php
						}
						else if($product == 'gamebar'){
						?>
							
							
							<option value="algeria" <?php if($operator=='algeria'){$selected='selected';}else{$selected='';} echo $selected; ?> >Algeria</option>
							<option value="bahrain" <?php if($operator=='bahrain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_All</option>
							
							<option value="bahrain_stc" <?php if($operator=='bahrain_stc'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_stc</option>
							
							<option value="bahrain_batelco" <?php if($operator=='bahrain_batelco'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_Batelco</option>
							
							
							<option value="buhrain_zain" <?php if($operator=='buhrain_zain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_zain</option>
							<option value="Bangladesh_Robi" <?php if($operator=='Bangladesh_Robi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bangladesh_Robi</option>
							
							<option value="cambodia" <?php if($operator=='cambodia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Cambodia</option>
							<option value="egypt" <?php if($operator=='egypt'){$selected='selected';}else{$selected='';} echo $selected; ?> >Egypt</option>
							<option value="egypt_mondemedia" <?php if($operator=='egypt_mondemedia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Egypt_Mondemedia</option>
							<option value="finland" <?php if($operator=='finland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Finland</option>
							<!--ion value="blazon_etisalad" <?php//f($operator=='blazon_etisalad'){$selected='selected';}else{$selected='';} echo $selected; ?> >Etisalad_Blazon</option>-->
							<option value="france" <?php if($operator=='france'){$selected='selected';}else{$selected='';} echo $selected; ?> >France</option>
							<option value="all_greece" <?php if($operator=='all_greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_All D</option>
						<!--	<option value="Cosmote_Greece" <?php //if($operator=='Cosmote_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Cosmote</option>-->
							<option value="gr2" <?php if($operator=='gr2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_N</option>
							<option value="greecepd" <?php if($operator=='greecepd'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_PD</option>
							<!--<option value="Vodafone_Greece" <?php //if($operator=='Vodafone_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Vodafone</option>
							<option value="Wind_Greece" <?php //if($operator=='Wind_Greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_Wind</option>-->
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Indonesia</option>
							<option value="ksa_all" <?php if($operator=='ksa_all'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_All</option>
							<option value="saudi_mobily" <?php if($operator=='saudi_mobily'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Mobily</option>

							<option value="stc_ksa" <?php if($operator=='stc_ksa'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Stc</option>
							<option value="zain_ksa" <?php if($operator=='zain_ksa'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Zain</option>
							<option value="ksa_all_weekly" <?php if($operator=='ksa_all_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_All_weekly</option>
							<option value="ksa_mobily_weekly" <?php if($operator=='ksa_mobily_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Mobily_weekly</option>
							<option value="ksa_stc_weekly" <?php if($operator=='ksa_stc_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Stc_Weekly</option>
							<option value="ksa_zain_weekly" <?php if($operator=='ksa_zain_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Zain_weekly</option>
							<option value="kw_all" <?php if($operator=='kw_all'){$selected='selected';}else{$selected='';} echo $selected; ?> >KW_All</option>
							<option value="kwstc" <?php if($operator=='kwstc'){$selected='selected';}else{$selected='';} echo $selected; ?> >KW_STC</option>
							<option value="kwzain" <?php if($operator=='kwzain'){$selected='selected';}else{$selected='';} echo $selected; ?> >KW_Zain</option>
							
							<option value="malaysia_cellcom" <?php if($operator=='malaysia_cellcom'){$selected='selected';}else{$selected='';} echo $selected; ?>>Malaysia_Cellcom</option>
							<option value="malaysiamaxis" <?php if($operator=='malaysiamaxis'){$selected='selected';}else{$selected='';} echo $selected; ?> >Malaysia_maxis</option>
							<option value="myanmar" <?php if($operator=='myanmar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Myanmar_Telenor</option>
							<option value="netherland_netsmart" <?php if($operator=='netherland_netsmart'){$selected='selected';}else{$selected='';} echo $selected; ?> >Netherland_N</option>
							<option value="norway" <?php if($operator=='norway'){$selected='selected';}else{$selected='';} echo $selected; ?> >Norway</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Oman_Ooredoo</option>
							<option value="oman_omantel" <?php if($operator=='oman_omantel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Oman_Omantel</option>
							<option value="pk_telenor" <?php if($operator=='pk_telenor'){$selected='selected';}else{$selected='';} echo $selected; ?> >Pakistan_Telenor</option>
							<option value="pk_zong" <?php if($operator=='pk_zong'){$selected='selected';}else{$selected='';} echo $selected; ?> >Pakistan_Zong</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_TMobile</option>
							<option value="qatar_gamestation" <?php if($operator=='qatar_gamestation'){$selected='selected';}else{$selected='';} echo $selected; ?>>Qatar_Gamestation</option>
							<option value="ooredoo_qatar" <?php if($operator=='ooredoo_qatar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Qatar_Ooredoo</option>
							<option value="vodafoneqatar" <?php if($operator=='vodafoneqatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Qatar_Vodafone</option>
							<option value="russia" <?php if($operator=='russia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Russia</option>
							
							<option value="southafricacellc" <?php if($operator=='southafricacellc'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Cellc</option>
							<option value="southafricamtn" <?php if($operator=='southafricamtn'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Mtn</option>
							<option value="vodacom_za" <?php if($operator=='vodacom_za'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Vodacom</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain_Vodafone</option>
							<option value="dialog_srilanka" <?php if($operator=='dialog_srilanka'){$selected='selected';}else{$selected='';} echo $selected; ?> >Srilanka_gamestore</option>
							<option value="srilanka_gamestore" <?php if($operator=='srilanka_gamestore'){$selected='selected';}else{$selected='';} echo $selected; ?> >Srilanka_Dialog</option>
							<option value="sweden" <?php if($operator=='sweden'){$selected='selected';}else{$selected='';} echo $selected; ?> >Sweden</option>
							<option value="thailand9305" <?php if($operator=='thailand9305'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand9305</option>
							<option value="uae_etisalat" <?php if($operator=='uae_etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?> >UAE_Etisalat</option>
							<option value="uae_du" <?php if($operator=='uae_du'){$selected='selected';}else{$selected='';} echo $selected; ?> >UAE_DU</option>
							
							
							
							
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
		select.options[select.options.length] = new Option('Greece_All D', 'all_greece');
		select.options[select.options.length] = new Option('Greece_Cosmote', 'Cosmote_Greece');
		select.options[select.options.length] = new Option('Greece_Vodafone', 'Vodafone_Greece');
		select.options[select.options.length] = new Option('Greece_Wind', 'Wind_Greece');
		select.options[select.options.length] = new Option('Greece_PD', 'greecepd');
		select.options[select.options.length] = new Option('New_Thailand', 'new_thailand');
		select.options[select.options.length] = new Option('Poland_Teleaudio', 'poland_teleaudio');
		select.options[select.options.length] = new Option('Poland_TMobile', 'poland');
		select.options[select.options.length] = new Option('SouthAfrica_Cellc', 'southafricacellc');
		select.options[select.options.length] = new Option('SouthAfrica_Mtn', 'southafricamtn');
		select.options[select.options.length] = new Option('SouthAfrica_All', 'vodacom_All');
		select.options[select.options.length] = new Option('SouthAfrica_Bt', 'vodacom_bt');
		select.options[select.options.length] = new Option('SouthAfrica_Fg', 'vodacom_fg');
		select.options[select.options.length] = new Option('SouthAfrica_Wfh', 'vodacom_wfh');
		select.options[select.options.length] = new Option('Spain_Vodafone', 'spain');
		select.options[select.options.length] = new Option('Thailand', 'thailand_svobi');

	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		//select.options[select.options.length] = new Option('Qatar_Vodafone', 'Vodafone_Qatar');
		select.options[select.options.length] = new Option('Algeria', 'algeria');
		select.options[select.options.length] = new Option('Bahrain_All', 'bahrain');
		select.options[select.options.length] = new Option('Bahrain_stc', 'bahrain_stc');
		select.options[select.options.length] = new Option('Bahrain_Batelco', 'bahrain_batelco');
		select.options[select.options.length] = new Option('Bahrain_Zain', 'buhrain_zain');
		select.options[select.options.length] = new Option('Bangladesh_Robi', 'Bangladesh_Robi');
		select.options[select.options.length] = new Option('Cambodia', 'cambodia');
		select.options[select.options.length] = new Option('Egypt', 'egypt');
		select.options[select.options.length] = new Option('Egypt_Mondemedia', 'egypt_mondemedia');
		//select.options[select.options.length] = new Option('Etisalad_Blazon', 'blazon_etisalad');
		select.options[select.options.length] = new Option('Finland', 'finland');
		
		select.options[select.options.length] = new Option('France', 'france');
		select.options[select.options.length] = new Option('Greece_All D', 'all_greece');
		//select.options[select.options.length] = new Option('Greece_Cosmote', 'Cosmote_Greece');
		select.options[select.options.length] = new Option('Greece_N', 'gr2');
		select.options[select.options.length] = new Option('Greece_PD', 'greecepd');
	//	select.options[select.options.length] = new Option('Greece_Vodafone', 'Vodafone_Greece');
		//select.options[select.options.length] = new Option('Greece_Wind', 'Wind_Greece');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('KSA_All', 'ksa_all');
		
		select.options[select.options.length] = new Option('KSA_Mobily', 'saudi_mobily');
		
		select.options[select.options.length] = new Option('KSA_STC', 'stc_ksa');
		
		select.options[select.options.length] = new Option('KSA_Zain', 'zain_ksa');
		select.options[select.options.length] = new Option('KSA_All_weekly', 'ksa_all_weekly');
		select.options[select.options.length] = new Option('KSA_Mobily_weekly', 'ksa_mobily_weekly');
		select.options[select.options.length] = new Option('KSA_STC_Weekly', 'ksa_stc_weekly');
		select.options[select.options.length] = new Option('KSA_Zain_weekly', 'ksa_zain_weekly');
		select.options[select.options.length] = new Option('KW_All', 'kw_all');
		select.options[select.options.length] = new Option('KW_STC', 'kwstc');
		select.options[select.options.length] = new Option('KW_Zain', 'kwzain');
		select.options[select.options.length] = new Option('Malaysia_Cellcom', 'malaysia_cellcom');
		select.options[select.options.length] = new Option('Malaysia_Maxis', 'malaysiamaxis');
		select.options[select.options.length] = new Option('Myanmar_Telenor', 'myanmar');
		select.options[select.options.length] = new Option('Netherland_N', 'netherland_netsmart');
		select.options[select.options.length] = new Option('Norway', 'norway');
		select.options[select.options.length] = new Option('Oman_Ooredoo', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Oman_Omantel', 'oman_omantel');
		select.options[select.options.length] = new Option('Pakistan_Telenor', 'pk_telenor');
		select.options[select.options.length] = new Option('Pakistan_Zong', 'pk_zong');
		select.options[select.options.length] = new Option('Poland_TMobile', 'poland');
		select.options[select.options.length] = new Option('Qatar_GameStation', 'qatar_gamestation');
		select.options[select.options.length] = new Option('Qatar_Ooredoo', 'ooredoo_qatar');
		select.options[select.options.length] = new Option('Qatar_Vodafone', 'vodafoneqatar');
		select.options[select.options.length] = new Option('Russia', 'russia');
		select.options[select.options.length] = new Option('SouthAfrica_Cellc', 'southafricacellc');
		select.options[select.options.length] = new Option('SouthAfrica_Mtn', 'southafricamtn');
		select.options[select.options.length] = new Option('SouthAfrica_Vodacom', 'vodacom_za');
		select.options[select.options.length] = new Option('Spain_Vodafone', 'spain');
		select.options[select.options.length] = new Option('Srilanka_Apigate', 'dialog_srilanka');
		select.options[select.options.length] = new Option('Srilanka_Dialog', 'srilanka_gamestore');
		select.options[select.options.length] = new Option('Sweden', 'sweden');
		select.options[select.options.length] = new Option('Thailand9305', 'thailand9305');
		select.options[select.options.length] = new Option('UAE_Etisalat', 'uae_etisalat');
		select.options[select.options.length] = new Option('UAE_DU', 'uae_du');
		
		
		

		
		
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

