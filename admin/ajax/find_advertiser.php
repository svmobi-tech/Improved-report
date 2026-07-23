<?php 
error_reporting(0);
include("../includes/connection.php");
//$con=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$operator=$_GET['operator'];
$product=$_GET['product'];

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 
if($product == 'glambar' || $product == 'GLAMBAR')
{
		if($operator=='south-africa')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='southafricamtn' || $operator=='southafricacellc')
		{
			
			$db="fashionbardb_za";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbzaglam.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='idea')
		{
			$db="glamourworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='poland')
		{
			$db="glambar_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='poland_teleaudio')
		{
			$db="glambar_plteleaudio";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from advertiserdb.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='southafrica_intarget')
		{
			$db="glambardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="glambardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='thailand_svobi')
		{
			$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);*/
		}
		else if($operator=='new_thailand')
		{
			$db="fashionbardb_glam9005thailand";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbthailand.newadvertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		
		else if($operator=='vodafone')
		{
			$db="fashionbardb_svmobi";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		
		else if($operator=='bsnl_india')
		{
			$db="bsnlfashionbar";
			$report="gamebardb_vodafone_qatar_report";
			 $sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3   group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='airtel_india')
		{
			
			$db="funzonedb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='hotshots_airtel')
		{
			
			$db="hotshotsdb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='portugal')
		{
			
			$db="fashionbardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='spain')
		{
			
			$db="fashionbardb_spain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		else if($operator=='rusia_biline')
		{
			
			$db="glambardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="glambardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='hotshots_vodafone')
		{
			$db="hotshotsnewdb_voda_0617";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='vodacom_wfh')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=1";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='vodacom_fg')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=2";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='vodacom_bt')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=3";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='Cosmote_Greece')
		{
			
			$db="glambardb_greececosmote";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Vodafone_Greece')
		{
			
			$db="glambardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Wind_Greece')
		{
			
			$db="glambardb_greecewind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='all_greece')
		{
			
			$db="glambardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
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
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='vodacom_za')
		{
			$db="vodacom_za";
			$dblog="vodacom_za_log";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=4";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='Vodafone_Qatar')
		{
			
			$db="gamebardb_vodafone_qatar";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='uae_du')
		{
			
			$db="gamesdb_uaedu_ma";
			$dblog="gamesdblog_uaedu_ma";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='vodafoneqatar')
		{
			
			$db="gamesdbnew_197_vodafone_qatar";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbqatarvodafone.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='unitedkingdom')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbmgage.advertiseruk.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='finland')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbfinland.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='cambodia')
		{
			
			$db="gamesdbnew_smart_cambodia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamesdbnew_smart_cambodia.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='ksa_all_weekly')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbsaweekly.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='ksa_mobily_weekly')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbsaweekly.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='ksa_stc_weekly')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbsaweekly.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='ksa_zain_weekly')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbsaweekly.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		else if($operator=='russia')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbru.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='buhrain_zain')
		{
			
			$db="";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbh.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='gr2')
		{
			
			$db="fashionbardb_uk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbgreece.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Bangladesh_Robi')
		{
			
			$db="gamesdbnew_robi_bangladesh";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='upstream_thailand')
		{
			$db="fashionbardb_game9305thailand";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);*/
		}
		
		else if($operator=='dialog_srilanka')
		{
			
			$db="gamesdbnew_dialog_srilanka";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='blazon_etisalad')
		{
			
			$db="fashionbardb_uae";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='poland')
		{
			$db="gamebar_poland";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='italy_tim')
		{
			$db="gamebar_italy";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='egypt')
		{
			
			$db="gamebardb_vodafone_egypt";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='ecuador')
		{
			
			$db="gamebardb_ecuador";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='tim_italy')
		{
			
			$db="gamebardb_tim";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='palestine')
		{
			
			$db="gamebardb_palestine";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='algeria')
		{
			
			$db="gamebardb_algeria";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='kwzain')
		{
			
			$db="fashionbardb_kwzain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbkwzain.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='kwviva')
		{
			
			$db="fashionbardb_kwviva";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='netherland')
		{
			
			$db="gamebardb_nlvf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}	
		else if($operator=='france')
		{
			
			$db="gamebardb_france";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='netherland_netsmart')
		{
			
			$db="fashionbardb_nl";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbnl.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='du_uae')
		{
			
			$db="gamesdb_uaedu";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='etisalad_uae')
		{
			
			$db="gamebardb_uaeetis";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='wind_italy')
		{
			
			$db="gamebardb_wind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='h3g_italy')
		{
			
			$db="gamebardb_h3g";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='indonesia')
		{
			
			$db="gamebardb_indonesia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='malaysiamaxis')
		{
			
			$db="gamebar_my";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='myanmar')
		{
			
			$db="fashionbardb_myanmartelenor";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbmyanmar.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='portugal')
		{
			
			$db="gamebardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='kazakistan')
		{
			
			$db="fashionbardb_kazakhstan";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbkazakhstan.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='stc_ksa' || $operator=='saudiarabia_zain')
		{
			
			$db="fashionbardb_ksastc";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbtimwezain.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='southafricamtn' || $operator=='southafricacellc')
		{
			
			$db="fashionbardb_za";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbza.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		
		else if($operator=='zain_ksa')
		{
			
			$db="fashionbardb_ksazain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbtimwezain.advertiser";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='spain')
		{
			
			$db="gamebardb_spain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="gamebardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		elseif($operator=='ooredoo_oman')
		{
			$db="gamesdb_ooredoo_oman";
			$dblog="gamesdblog_ooredoo_oman";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbomooredoo.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		elseif($operator=='malaysia_cellcom')
		{
			$db="gamesdbnew_celcom_malaysia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='idea')
		{
			$db="gamesworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='vodafone')
		{
			$db="gamebardb_svmobi";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		
		else if($operator=='gamezone_vodafone')
		{
			$db="gamesnewdb_voda";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		
		else if($operator=='bsnl_india')
		{
			$db="bsnlgamebar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3 group by aggregator";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='south-africa')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='airtel_india')
		{
			
			$db="gamebardb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		elseif($operator=='ooredoo_qatar')
		{
			$db="gamesdb_ooredoo_qatar";
			$dblog="gamesdblog_ooredoo_qatar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from ".$dblog.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		elseif($operator=='egypt_mondemedia')
		{
			$db="gamebar_egypt";
			$commondb="advertiserdb";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$commondb.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		elseif($operator=='greecepd')
		{
			$db="gamesdb_ooredoo_qatar";
			$dblog="gamesdblog_ooredoo_qatar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbpaydashgr.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		elseif($operator=='qu_qatar')
		{
			$db="gamesdb_ooredoo_qatar_qyou";
			$dblog="gamesdblog_ooredoo_qatar_qyou";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		elseif($operator=='qatar_gamestation')
		{
			$db="gamesdb_ooredoo_qatar_gamestation";
			$dblog="gamesdblog_ooredoo_qatar_gamestation";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select advertiserid,advertiser_name advname from commondbqatarooredoo.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
			
		}
		else if($operator=='southafrica_intarget')
		{
			$db="gamebardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='rusia_biline')
		{
			
			$db="gamebardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="gamebardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}//guatemala
	
		else if($operator=='guatemala')
		{
			
			$db="gamebardb_guatemala";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='a1_austria')
		{
			
			$db="gamebardb_a1";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='tmobile_austria')
		{
			
			$db="gamebardb_tmobile";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='hutchison_austria')
		{
			
			$db="gamebardb_dimoco";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Cosmote_Greece')
		{
			
			$db="gamebardb_greececosmote";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamebardb_greecevf.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Vodafone_Greece')
		{
			
			$db="gamebardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Wind_Greece')
		{
			
			$db="gamebardb_greecewind";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamebardb_greecevf.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='all_greece')
		{
			
			$db="gamebardb_greecevf";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='sweden')
		{
			
			$db="gamebar_sweden";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='srilanka_gamestore')
		{
			
			$db="gamebar_srilanka";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Mts_Serbia')
		{
			
			$db="gamebardb_serbiamts";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='Vip_Serbia')
		{
			
			$db="gamebardb_serbiavip";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='pk_telenor')
		{
			
			$db="gamebar_pk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=1 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='pk_zong')
		{
			
			$db="gamebar_pk";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where serviceid=2 ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		else if($operator=='bahrain_stc')
		{
			
			$db="commondbbhstc";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbhstc.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='bahrain_batelco')
		{
			
			$db="commondbbhstc";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbbhbatelco.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
		
		
		
		
		else if($operator=='bahrain')
		{
			
			$db="gamesdb_batelviva_bahrain";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='norway')
		{
			
			$db="gamebardb_norway";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='saudi_mobily')
		{
			
			$db="gamesdb_mobily_saudi";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from gamesdblog_mobily_saudi.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='oman_omantel')
		{
			
			$db="gamesdb_mobily_saudi";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbomantel.advertiser  ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		else if($operator=='uae_etisalat')
		{
			
			$db="fashionbardb_etisalat";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select advertiserid,advertiser_name advname from commondbetisalat.advertiser ";
			$res_ad=mysql_query($sql_ad,$con);
		}
		
	}


?>
                          
                        
	<select name="advertiserid" class="form-control select2_multiple"  required >
		<?php
		if( $operator == 'idea' )
		{
		?>
			<option value="16">SVMOBI</option>
			
		<?php
		
		}
		elseif($operator=='bsnl_india')
		{
			?>
		<option value="20">SVMOBI</option>
			
		<?php	
		}
		
		
		else{
		?>	
		<option value="all">All</option>
		<?php
		}
		while($row_ad=mysql_fetch_array($res_ad))
		{
			//echo $row_ad[0];exit;
		?>
		<option value="<?php echo $row_ad[0]; ?>"><?php echo $row_ad[1]; ?></option>
		<?php
		}
		?>
		
	</select>

	
	
<!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->