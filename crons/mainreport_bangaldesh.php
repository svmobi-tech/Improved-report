
<?php
require_once __DIR__ . '/../admin/includes/config.php';
ini_set('max_execution_time', 1000000);

ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000);
$con1=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
$con=mysql_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS);
$con6=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS);
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$operator_vodafone='gamebardb_vodafone_qatar';
$operator_oman="gamesdb_ooredoo_oman";
$du_dubai='gamesdb_uaedu';
$du_dubailog='gamesdblog_uaedu';
$maleysia_celcom="gamesdbnew_celcom_malaysia";
$operator_oomanlog="gamesdblog_ooredoo_oman";
$southafrica="fashionbardb_africa";
$southafrica_gamebar="gamebarbardb_africa";
$indonesia="gamebardb_indonesia";
$report='gamebardb_vodafone_qatar_report';
$portugal_gamebar='gamebardb_portugal';
$portugal_glambar='fashionbardb_portugal';
$glambar_airtel='funzonedb_airtel';
$gamebar_airtel='gamebardb_airtel';
$gamebar_voda='gamebardb_svmobi';
$fashionbar_voda='fashionbardb_svmobi';
$gamebar_idea='gamesworld_idea';
$gamebar_bsnl='bsnlgamebar';
$glambar_voda='glamourworld_voda';
$glambar_idea='glamourworld_idea';
$glambar_bsnl='bsnlfashionbar';
$gamebar_egypt='gamebardb_vodafone_egypt';
$glambar_southafrica_intarget='glambardb_southafrica';
$gamebar_southafrica_intarget='gamebardb_southafrica';
$gamebar_kenya_oxygen='gamebardb_kenya';
$glambar_kenya_oxygen='glambardb_kenya';
$tim_gamebar='gamebardb_tim';
$wind_gamebar='gamebardb_wind';
$h3g_gamebar='gamebardb_h3g';
$gamebar_guatemala='gamebardb_guatemala';
$gamebar_myanmar='fashionbardb_myanmartelenor';
$hotshots_airtel='hotshotsdb_airtel';
$gamebar_ecuador='gamebardb_ecuador';
$gamebar_spain='gamebardb_spain';
$hotshots_voda='hotshotsnewdb_voda_0617';
$gamebar_a1_austria="gamebardb_a1";
$gamebar_tmobile_austria="gamebardb_tmobile";
$gamebar_hutchison_austria="gamebardb_dimoco";
$gamezone_vodafone="gamesnewdb_voda";
$glambar_spain='fashionbardb_spain';
$gamebar_poland='gamebardb_poland';
$glambar_poland='glambardb_poland';
$gamebar_kazakistan='fashionbardb_kazakhstan';
$gamebar_bangladeshromi='gamesdbnew_robi_bangladesh';
$vodacom='vodacom_za';
$gamebar_Cosmote_Greece='gamebardb_greececosmote';
$gamebar_Wind_Greece='gamebardb_greecewind';
$gamebar_Vodafone_Greece='gamebardb_greecevf';
$gamebar_all_Greece='gamebardb_greecevf';
$gamebar_Mts_Serbia='gamebardb_serbiamts';
$gamebar_Vip_Serbia='gamebardb_serbiavip';
$gamebar_uaedu='gamesdb_uaedu';
$gamebar_uaeetis='gamebardb_uaeetis';
$gamebar_palestine='gamebardb_palestine';
$gamebar_sweden='gamebardb_swedentelenor';





 $main=0;








$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$gamebar_bangladeshromi.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}

else{
	
	 $userlogname='userlog';
}


//echo $userlogname;exit;

$cgrequestna="cgrequests_".$userdate;

$sql22="select 1 from ".$gamebar_bangladeshromi.".".$cgrequestna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $cgrequestname=$cgrequestna;
}
else{
	
	 $cgrequestname='cgrequests';
}

		/*echo	$sql="
			SELECT 
				dt,
				SUM(total_click) clicks,
				SUM(withmsisdn) witmdn,
				SUM(uniq) uniq,
				SUM(cgsent) cg,
				SUM(act) act,
				SUM(actamt) actamnt,
				SUM(ren) ren,
				SUM(renamt) renamnt,
				SUM(dct) dct,
				 SUM(dct) churn,
				SUM(low) Low,
				SUM(cbs) cbsent
			FROM
				(SELECT 
					dt,
						total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT 
					COUNT(txnid) total_click, dt
				FROM
					(SELECT DISTINCT
					txnid, msisdn, advertiserid, DATE(accesstime) dt
				FROM
					".$gamebar_bangladeshromi.".".$userlogname."
				WHERE
					accesstime >= '".$startdate."'
						AND accesstime <= '".$enddate."') aa
				GROUP BY dt) total_click UNION SELECT 
					dt,
						0 total_click,
						COUNT(msisdn) withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT 
					msisdn, DATE(accesstime) dt
				FROM
					".$gamebar_bangladeshromi.".".$userlogname."
				WHERE
					accesstime >= '".$startdate."'
						AND accesstime <= '".$enddate."'
						AND msisdn = 0) withmsisdn
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						COUNT(msisdn) uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT DISTINCT
					msisdn, DATE(accesstime) dt
				FROM
					".$gamebar_bangladeshromi.".".$userlogname."
				WHERE
					accesstime >= '".$startdate."'
						AND accesstime <= '".$enddate."'
						and msisdn > 0 ) uniq
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						COUNT(txnid) cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT DISTINCT
					txnid, DATE(requesttime) dt
				FROM
					".$gamebar_bangladeshromi.".".$cgrequestname."
				WHERE
					requesttime >= '".$startdate."'
						AND requesttime <= '".$enddate."') cgsent
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						COUNT(txnid) act,
						SUM(AMOUNT) actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT DISTINCT
					txnid,
						amount,
						DATE(subscriptionstartdate) dt,
						MAX(subscriptionstartdate)
				FROM
					".$gamebar_bangladeshromi.".subscriptiondetail
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND isrenew = 0
						and charging_mode like '%act%'
						AND amount > 0
				GROUP BY txnid) act
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						COUNT(msisdn) ren,
						SUM(amount) renamt,
						0 dct,
						0 low,
						0 cbs
				FROM
					(SELECT DISTINCT
					msisdn, amount, DATE(subscriptionstartdate) dt
				FROM
					".$gamebar_bangladeshromi.".subscriptiondetail
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND isrenew = 1
						and charging_mode like '%ren%'
						AND amount > 0) ren
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						COUNT(txnid) dct,
						0 low,
						0 cbs
				FROM
					(SELECT DISTINCT
					txnid, DATE(subscriptionstartdate) dt
				FROM
					".$gamebar_bangladeshromi.".subscriptiondetail
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND charging_mode = 'dct'
						AND amount = 0) dct
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						COUNT(txnid) low,
						0 cbs
				FROM
					(SELECT DISTINCT
					txnid, DATE(subscriptionstartdate) dt
				FROM
					".$gamebar_bangladeshromi.".subscriptiondetail
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND charging_mode = 'lowbal'
						AND amount = 0) low
				GROUP BY dt UNION SELECT 
					dt,
						0 total_click,
						0 withmsisdn,
						0 uniq,
						0 cgsent,
						0 act,
						0 actamt,
						0 ren,
						0 renamt,
						0 dct,
						0 low,
						COUNT(txnid) cbs
				FROM
					(SELECT DISTINCT
					txnid, DATE(senttime) dt
				FROM
					".$gamebar_bangladeshromi.".advertcallback
				WHERE
					senttime >= '".$startdate."'
						AND senttime <= '".$enddate."') cbs
				GROUP BY dt) a
			GROUP BY dt;
			";
			
				
								
								if($result=$con1->query($sql) )
								{
								$main++;	
								
								while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
								{
									$Date=$row['dt'];
									$clicks=$row['clicks'];
									
									$uniq=$row['uniq'];
									$cg=$row['cg'];
									$actcount=$row['act'];
									$actamount=$row['actamnt'];
									$renewcount=$row['ren'];
									$renewamount=$row['renamnt'];
									$churn=$row['churn'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='Bangladesh_Robi';
									$product='gamebar';
									$conversion=($row['act']*100)/$row['clicks'];
									$totalcount=$row['act']+$row['ren'];
									$totalamount=$row['actamnt']+$row['renamnt'];
									if($row['act']==0)
									{
										$cbsentpercent=0;
									}else{
										$cbsentpercent=($cbsent*100)/$row['act'];
									}	 
									$advamount=$row['cbsent']*12.75;
										
									//echo "hi";
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."') ; ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
									$indonesia_query=$sql4;
								
								}
								}
							//	$result->close();
								//$result1->close();
							$con1->next_result();*/

						  $sql1="select advertiserid from ".$gamebar_bangladeshromi.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo	  $sql2="SELECT 
														dt,
														SUM(total_click) clicks,
														SUM(withmsisdn) witmdn,
														SUM(uniq) uniq,
														SUM(cgsent) cg,
														SUM(act) act,
														SUM(actamt) actamnt,
														SUM(ren) ren,
														SUM(renamt) renamnt,
														SUM(dct) dct,
														SUM(low) Low,
														SUM(cbs) cbsent
													FROM
														(SELECT 
															dt,
																total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT 
															COUNT(txnid) total_click, dt
														FROM
															(SELECT DISTINCT
															txnid, msisdn, advertiserid, DATE(accesstime) dt
														FROM
															".$gamebar_bangladeshromi.".".$userlogname."
														WHERE
															accesstime >= '".$startdate."'
																AND accesstime <= '".$enddate."'
																AND advertiserid = '4') aa
														GROUP BY dt) total_click UNION SELECT 
															dt,
																0 total_click,
																COUNT(msisdn) withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT 
															msisdn, DATE(accesstime) dt
														FROM
														   ".$gamebar_bangladeshromi.".".$userlogname."
														WHERE
															accesstime >= '".$startdate."'
																AND accesstime <= '".$enddate."'
																AND advertiserid = '4' 
																and msisdn = 0) withmsisdn
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																COUNT(msisdn) uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT DISTINCT
															msisdn, DATE(accesstime) dt
														FROM
															".$gamebar_bangladeshromi.".".$userlogname."
														WHERE
															accesstime >= '".$startdate."'
																AND accesstime <= '".$enddate."'
																AND advertiserid = '4' 
																and msisdn > 0) uniq
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																COUNT(txnid) cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT DISTINCT
																cg5.txnid, DATE(requesttime) dt
															FROM
																".$gamebar_bangladeshromi.".".$cgrequestname." cg5 inner join ".$gamebar_bangladeshromi.".".$userlogname." user1 on cg5.txnid = user1.txnid
														WHERE
															requesttime >= '".$startdate."'
															AND requesttime <= '".$enddate."'
															AND advertiserid = 4) cgsent
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																COUNT(txnid) act,
																SUM(AMOUNT) actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT DISTINCT
															txnid,
																amount,
																DATE(subscriptionstartdate) dt,
																MAX(subscriptionstartdate)
														FROM
															".$gamebar_bangladeshromi.".subscriptiondetail
														WHERE
															subscriptionstartdate >= '".$startdate."'
																AND subscriptionstartdate <= '".$enddate."'
																and charging_mode like'%act%'
																AND isrenew = 0
																AND amount > 0
																AND advid = '4'
														GROUP BY txnid) act
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																COUNT(msisdn) ren,
																SUM(amount) renamt,
																0 dct,
																0 low,
																0 cbs
														FROM
															(SELECT DISTINCT
															msisdn, amount, DATE(subscriptionstartdate) dt
														FROM
															".$gamebar_bangladeshromi.".subscriptiondetail
														WHERE
															subscriptionstartdate >= '".$startdate."'
																AND subscriptionstartdate <= '".$enddate."'
																AND isrenew = 1
																and charging_mode like '%ren%'
																AND amount > 0
																AND advid = '4') ren
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																COUNT(txnid) dct,
																0 low,
																0 cbs
														FROM
															(SELECT DISTINCT
															txnid, DATE(subscriptionstartdate) dt
														FROM
															".$gamebar_bangladeshromi.".subscriptiondetail
														WHERE
															subscriptionstartdate >= '".$startdate."'
																AND subscriptionstartdate <= '".$enddate."'
																AND charging_mode = 'dct'
																AND amount = 0
																AND advid = '4') dct
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																COUNT(txnid) low,
																0 cbs
														FROM
															(SELECT DISTINCT
															txnid, DATE(subscriptionstartdate) dt
														FROM
															".$gamebar_bangladeshromi.".subscriptiondetail
														WHERE
															subscriptionstartdate >= '".$startdate."'
																AND subscriptionstartdate <= '".$enddate."'
																AND charging_mode = 'lowbal'
																AND amount = 0
																AND advid = '4') low
														GROUP BY dt UNION SELECT 
															dt,
																0 total_click,
																0 withmsisdn,
																0 uniq,
																0 cgsent,
																0 act,
																0 actamt,
																0 ren,
																0 renamt,
																0 dct,
																0 low,
																COUNT(txnid) cbs
														FROM
															(SELECT DISTINCT
															txnid, DATE(senttime) dt
														FROM
															".$gamebar_bangladeshromi.".advertcallback
														WHERE
															senttime >= '".$startdate."'
																AND senttime <= '".$enddate."'
																AND advertiserid = '4') cbs
														GROUP BY dt) a
													GROUP BY dt
										  
										  ";exit;
											//mysqli_free_result($result3);   
											mysqli_next_result($con1); 	
										
										if($result3=$con1->query($sql2))
										{
											
										$main++;
											while($row2=mysqli_fetch_array($result3,MYSQLI_ASSOC))
											{
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
												$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='Bangladesh_Robi';
												$product='gamebar';
												$conversion=($row2['act']*100)/$row2['clicks'];
												$totalcount=$row2['act']+$row2['ren'];
												$totalamount=$row2['actamnt']+$row2['renamnt'];
												if($row['act']==0)
												{
													$cbsentpercent=0;
												}else{
													$cbsentpercent=($cbsent*100)/$row['act'];
												}
													if($operator=='Idea')
													{	
														$advamount=$row2['cbsent']*34;
													}
													elseif($operator=='Vodafone_Qatar')
													{
														//echo "hi <br>";
														 $advamount=$row2['cbsent']*12.75;
													}
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."');  ";
												$result5=mysql_query($sql4,$con) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								$result3->close();
								//$result1->close();
							$con1->next_result();			

		