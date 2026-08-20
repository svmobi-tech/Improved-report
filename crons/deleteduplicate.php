<?php
require_once dirname(__DIR__) . '/admin/includes/config.php';

ini_set('max_execution_time', 100000000);

ini_set('mysql.connect_timeout', 100000000);
ini_set('default_socket_timeout', 100000000);
$con1 = mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_error()); //cluster 2

$con2 = $con1;
$con6 = mysqli_connect(DB_PROD_HOST2, DB_USER, DB_PASS);
date_default_timezone_set("Asia/Calcutta");
echo  $date1 = date('Y-m-d', strtotime("-1 days"));
$userdate = date('dmY', strtotime("-1 days"));
$startdate = $date1 . ' 00:00:00';
$enddate = $date1 . ' 23:59:59';
$operator_vodafone = 'gamebardb_vodafone_qatar';
$operator_oman = "gamesdb_ooredoo_oman";
$du_dubai = 'gamesdb_uaedu';
$du_dubailog = 'gamesdblog_uaedu';
$maleysia_celcom = "gamesdbnew_celcom_malaysia";
$operator_oomanlog = "gamesdblog_ooredoo_oman";
$southafrica = "fashionbardb_africa";
$southafrica_gamebar = "gamebarbardb_africa";
$indonesia = "gamebardb_indonesia";
$report = 'gamebardb_vodafone_qatar_report';
$portugal_gamebar = 'gamebardb_portugal';
$portugal_glambar = 'fashionbardb_portugal';
$glambar_airtel = 'funzonedb_airtel';
$gamebar_airtel = 'gamebardb_airtel';
$gamebar_voda = 'gamebardb_svmobi';
$fashionbar_voda = 'fashionbardb_svmobi';
$gamebar_idea = 'gamesworld_idea';
$gamebar_bsnl = 'bsnlgamebar';
$glambar_voda = 'glamourworld_voda';
$glambar_idea = 'glamourworld_idea';
$glambar_bsnl = 'bsnlfashionbar';
$gamebar_egypt = 'gamebardb_vodafone_egypt';
$glambar_southafrica_intarget = 'glambardb_southafrica';
$gamebar_southafrica_intarget = 'gamebardb_southafrica';
$gamebar_kenya_oxygen = 'gamebardb_kenya';
$glambar_kenya_oxygen = 'glambardb_kenya';
$tim_gamebar = 'gamebardb_tim';
$wind_gamebar = 'gamebardb_wind';
$h3g_gamebar = 'gamebardb_h3g';
$gamebar_guatemala = 'gamebardb_guatemala';
$gamebar_myanmar = 'fashionbardb_myanmartelenor';
$hotshots_airtel = 'hotshotsdb_airtel';
$gamebar_ecuador = 'gamebardb_ecuador';
$gamebar_spain = 'gamebardb_spain';
$hotshots_voda = 'hotshotsnewdb_voda_0617';
$gamebar_a1_austria = "gamebardb_a1";
$gamebar_tmobile_austria = "gamebardb_tmobile";
$gamebar_hutchison_austria = "gamebardb_dimoco";
$gamezone_vodafone = "gamesnewdb_voda";
$glambar_spain = 'fashionbardb_spain';
$gamebar_poland = 'gamebardb_poland';
$glambar_poland = 'glambardb_poland';
$gamebar_kazakistan = 'fashionbardb_kazakhstan';
$gamebar_bangladeshromi = 'gamesdbnew_robi_bangladesh';
$vodacom = 'vodacom_za';
$gamebar_Cosmote_Greece = 'gamebardb_greececosmote';
$gamebar_Wind_Greece = 'gamebardb_greecewind';
$gamebar_Vodafone_Greece = 'gamebardb_greecevf';
$gamebar_all_Greece = 'gamebardb_greecevf';
$gamebar_Mts_Serbia = 'gamebardb_serbiamts';
$gamebar_Vip_Serbia = 'gamebardb_serbiavip';
$gamebar_uaedu = 'gamesdb_uaedu';
$gamebar_uaeetis = 'gamebardb_uaeetis';
$gamebar_palestine = 'gamebardb_palestine';
$gamebar_sweden = 'gamebardb_swedentelenor';
$dialog_srilanka = 'gamesdbnew_dialog_srilanka';



echo "<br>" .	 $sql = "select * from $report.mainreport where date='" . $date1 . "'";



if ($result = $con1->query($sql)) {
	//$main++;	

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<br>" . $sql1 = "select * from $report.mainreport where date='" . $date1 . "' and operator='" . $row['operator'] . "' and product='" . $row['product'] . "' and reportid !='" . $row['reportid'] . "' and reportid > '" . $row['reportid'] . "' and advertiser='" . $row['advertiser'] . "' order by reportid asc";
		//exit;
		if ($result1 = $con1->query($sql1)) {
			//$main++;	

			while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
				echo "<br>" . $row1['reportid'];
				mysqli_query($con1, "DELETE FROM " . $report . ".`mainreport` WHERE `reportid`='" . $row1['reportid'] . "' ;") or die(mysqli_error($con1));
			}
		}
		//exit;
	}
}
