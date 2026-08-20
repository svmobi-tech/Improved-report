<?php
require_once __DIR__ . '/../admin/includes/config.php';
ini_set('max_execution_time', 100000000);

ini_set('mysql.connect_timeout', 100000000);
ini_set('default_socket_timeout', 100000000);
$con1=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
$con=mysql_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS);
$con6=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS)or die(mysqli_error());
date_default_timezone_set("Asia/Calcutta");
echo  $date1=date('Y-m-d',strtotime("-1 days"));
$userdate=date('dmY',strtotime("-1 days"));
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

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' ;") or die(mysqli_error($con1));

//echo"hi";exit;
//all


// gamebar_indonesia


	echo "<br>".	 $sql="call ".$indonesia.".mainreport_backdate('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='indonesia';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();
							
							
						  $sql1="select advertiserid from ".$indonesia.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo "<br>".$sql2="call ".$indonesia.".mainreport_backdate('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='indonesia';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
								
											}
										}
									}
								}
							//	echo $indonesia_query;
								//exit;
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								$result3->close();
								//$result1->close();
							$con1->next_result();
		
		

//gamebar_bangladeshromi

//$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
 echo "<br>". $sql22="select 1 from ".$gamebar_bangladeshromi.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}

$cgrequestna="cgrequests_".$userdate;

echo "<br>". $sql22="select 1 from ".$gamebar_bangladeshromi.".".$cgrequestna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $cgrequestname=$cgrequestna;
}
else{
	
	 $cgrequestname='cgrequests';
}

		echo "<br>".	$sql="
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
			
				//exit;
								
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();
							
						  $sql1="select advertiserid from ".$gamebar_bangladeshromi.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
									echo "<br>".	 $advertiserid=$row5['advertiserid'];
										  $sql2="
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
													AND advertiserid = '".$advertiserid."') aa
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
											   ".$gamebar_bangladeshromi.". ".$userlogname."
											WHERE
												accesstime >= '".$startdate."'
													AND accesstime <= '".$enddate."'
													AND advertiserid = '".$advertiserid."' 
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
													AND advertiserid = '".$advertiserid."' 
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
													and charging_mode like'%act%'
													AND isrenew = 0
													AND amount > 0
													AND advid = '".$advertiserid."'
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
													AND advid = '".$advertiserid."') ren
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
													AND advid = '".$advertiserid."') dct
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
													AND advid = '".$advertiserid."') low
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
													AND advertiserid = '".$advertiserid."') cbs
											GROUP BY dt) a
										GROUP BY dt;
										  
										  ";
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
												$result5 = mysqli_query($con6,$sql4) ;
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
							
				
							
							
					
			//exit;		



	
//gamebar_palestine

			echo "<br>".$sql="call ".$gamebar_palestine.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='palestine';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_palestine.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo "<br>".	  $sql2="call ".$gamebar_palestine.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='palestine';
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
												$result5 = mysqli_query($con6,$sql4) ;
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


							
							
//gamebar sweden							
	
	echo "<br>".$sql="call ".$gamebar_sweden.".swedenmainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='sweden';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_sweden.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  echo "<br>".$sql2="call ".$gamebar_sweden.".swedenmainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='sweden';
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
												$result5 = mysqli_query($con6,$sql4) ;
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



//gamebar_uaedu

		echo "<br>".	$sql="call ".$gamebar_uaedu.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='du_uae';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_uaedu.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_uaedu.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='du_uae';
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
												$result5 = mysqli_query($con6,$sql4) ;
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



//gamebar_uaeetis

		echo "<br>".	$sql="call ".$gamebar_uaeetis.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='etisalad_uae';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_uaeetis.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_uaeetis.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='etisalad_uae';
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
												$result5 = mysqli_query($con6,$sql4) ;
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




	
			


//gamebar_poland


			echo "<br>".$sql="call ".$gamebar_poland.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='poland';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_poland.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_poland.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='poland';
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
												$result5 = mysqli_query($con6,$sql4) ;
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


//glambar_poland


			echo "<br>".$sql="call ".$glambar_poland.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='poland';
									$product='glambar';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$glambar_poland.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>". $sql2="call ".$glambar_poland.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='poland';
												$product='glambar';
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
												$result5 = mysqli_query($con6,$sql4) ;
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
							
			
			
			
			
			
//Gamebar Kenya oxygen

echo "<br>".$sql="call ".$gamebar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$operator='kenya_oxygen';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_kenya_oxygen.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>". $sql2="call ".$gamebar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='kenya_oxygen';
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
												$result5 = mysqli_query($con6,$sql4) ;
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
							
							
							
							
							
//glambar Kenya oxygen

echo "<br>".$sql="call ".$glambar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$operator='kenya_oxygen';
									$product='glambar';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$glambar_kenya_oxygen.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>". $sql2="call ".$glambar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='kenya_oxygen';
												$product='glambar';
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
												$result5 = mysqli_query($con6,$sql4) ;
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

//glambar_spain



echo "<br>".$sql="call ".$glambar_spain.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$operator='spain';
									$product='glambar';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$glambar_spain.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  echo "<br>".$sql2="call ".$glambar_spain.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='spain';
												$product='glambar';
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
												$result5 = mysqli_query($con6,$sql4) ;
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








 //glambar southafrica
 
 echo "<br>".$sql="call ".$southafrica.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='south-africa';
									$product='glambar';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$southafrica.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$southafrica.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='south-africa';
												$product='glambar';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							
								$result3->close();
								
							$con1->next_result();
							
 
 
 //gamebar southafrica
 
 
 
 echo "<br>".$sql="call ".$southafrica.".mainreport_gamebar('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='south-africa';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$southafrica_gamebar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$southafrica.".mainreport_gamebar('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='south-africa';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							
								$result3->close();
								
							$con1->next_result();
 
 
 
 
 






		
						
//Vodafone_Qatar
							
						
				
 echo "<br>".$sql="call ".$operator_vodafone.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='Vodafone_Qatar';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									//$con->next_result();
									$result1=mysqli_query($con6,$sql4);

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$operator_vodafone.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  echo "<br>". $sql2="call ".$operator_vodafone.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='Vodafone_Qatar';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
	
	//egypt

	echo "<br>".$sql="call ".$gamebar_egypt.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='egypt';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									//$con->next_result();
									$result1=mysqli_query($con6,$sql4);

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_egypt.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".   $sql2="call ".$gamebar_egypt.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='egypt';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();


		//du dubai					
		echo "<br>". $sql="call ".$du_dubai.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='du_dubai';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$du_dubailog.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$du_dubai.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
										//	mysqli_free_result($result3);   
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='du_dubai';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result30->close();
								//$result1->close();
							$con1->next_result();
							
		
	
	//ooredoo oman

			echo "<br>". $sql="call ".$operator_oman.".mainreport1('ab','cd','".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='ooredoo_oman';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$operator_oomanlog.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>". $sql2="call ".$operator_oman.".mainreport1('ab','cd','".$startdate."','".$enddate."','".$advertiserid."')";
										//	mysqli_free_result($result3);   
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='ooredoo_oman';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
	

//malaciya celcom

				
 echo "<br>".$sql="call ".$maleysia_celcom.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='malaysia_cellcom';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$maleysia_celcom.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>".  $sql2="call ".$maleysia_celcom.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='malaysia_cellcom';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								//$result3->close();
								//$result1->close();
							$con1->next_result();
							
							
							
		
						
//spain Gamebar			
							
				
echo "<br>". $sql="call ".$gamebar_spain.".mainreport('".$startdate."','".$enddate."','0')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='spain';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_spain.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>".  $sql2="call ".$gamebar_spain.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='spain';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
						
				
	//gamebar_guatemala	
							
	/*			
 echo "<br>".$sql="call ".$gamebar_guatemala.".mainreport('".$startdate."','".$enddate."',0)";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='guatemala';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								//$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_guatemala.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 echo "<br>".  $sql2="call ".$gamebar_guatemala.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='guatemala';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
			*/				
							
			//gamebar_myanmar
							
				
 echo "<br>". $sql="call ".$gamebar_myanmar.".report(0,'".$startdate."','".$enddate."')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='myanmar';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid,advertiser_name advname from commondbmyanmar.advertiser ";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".   $sql2="call ".$gamebar_myanmar.".report('".$advertiserid."','".$startdate."','".$enddate."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='myanmar';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();				
	

//gamebar kazakistan
echo "<br>".$sql="call ".$gamebar_kazakistan.".report(0,'".$startdate."','".$enddate."')";
										
								
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
									$churn=$row['dct'];
									$park=$row['Low'];
									$cbsent=$row['cbsent'];
									$advertiser=0;
									$operator='kazakistan';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1 = mysqli_query($con6,$sql4) ;

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid,advertiser_name advname from commondbkazakhstan.advertiser ";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".   $sql2="call ".$gamebar_kazakistan.".report('".$advertiserid."','".$startdate."','".$enddate."')";
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
												$churn=$row2['dct'];
												$park=$row2['Low'];
												$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='kazakistan';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5 = mysqli_query($con6,$sql4) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();



	
							
		
// Cosmote_Greece


	echo "<br>".	 $sql="call ".$gamebar_Cosmote_Greece.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='Cosmote_Greece';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_Cosmote_Greece.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_Cosmote_Greece.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='Cosmote_Greece';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();

// Vodafone_Greece


		echo "<br>". $sql="call ".$gamebar_Vodafone_Greece.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='Vodafone_Greece';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_Vodafone_Greece.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_Vodafone_Greece.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='Vodafone_Greece';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();// Vodafone_Greece

//all greece
	echo "<br>".	 $sql="call ".$gamebar_all_Greece.".grmainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='all_greece';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_all_Greece.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo "<br>".	  $sql2="call ".$gamebar_all_Greece.".grmainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='all_greece';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();

// Wind_Greece


	echo "<br>".	 $sql="call ".$gamebar_Wind_Greece.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='Wind_Greece';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_Wind_Greece.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo "<br>".	  $sql2="call ".$gamebar_Wind_Greece.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='Wind_Greece';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								$result3->close();
								//$result->close();
							$con1->next_result();
							
							
/*						
// Mts_Serbia


	echo "<br>".	 $sql="call ".$gamebar_Mts_Serbia.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='Mts_Serbia';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
								//$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_Mts_Serbia.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									echo "<br>".	  $sql2="call ".$gamebar_Mts_Serbia.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='Mts_Serbia';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();
											
							
// Vip_Serbia


	echo "<br>".	 $sql="call ".$gamebar_Vip_Serbia.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='Vip_Serbia';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
							//	$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_Vip_Serbia.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_Vip_Serbia.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='Vip_Serbia';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();
											
							
							
							
			
	
// gamebar_ecudor


	echo "<br>".	 $sql="call ".$gamebar_ecuador.".mainreport('".$startdate."','".$enddate."','0')";
			
				
								
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
									$operator='ecuador';
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
									$result1 = mysqli_query($con6,$sql4) ;
									$indonesia_query=$sql4;
								
								}
								}
//								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_ecuador.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo "<br>".  $sql2="call ".$gamebar_ecuador.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='ecuador';
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
												$result5 = mysqli_query($con6,$sql4) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							//	echo $indonesia_query;
								
								 //$result1=mysql_query($indonesia_query,$con) or die(mysql_error($con));
								//$result3->close();
								//$result1->close();
							$con1->next_result();
							
				
						
							*/
							
						
						
echo "<br>main=". $main;				
								
		if($main>=244)
		{
			
			$cur_date=date('Y-m-d H-i:s');
			$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=1, date='".$cur_date."' where cron_name='mainreport'";
			$result = mysqli_query($con1,$sql) ;
		}