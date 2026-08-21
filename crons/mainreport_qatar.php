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
echo  $date1=date('Y-m-d',strtotime("-1 days"));
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$ooredoo="gamesdb_ooredoo_qatar";
$oman="gamesdb_ooredoo_oman";
$report='gamebardb_vodafone_qatar_report';



 $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and operator in ('ooredoo_qatar')  ;") or die(mysqli_error($con1));


								//all



//Vodacom_worldforher


								$sql="";
			
				
								
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
									$advname='All';
									$operator='ooredoo_qatar';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."') ; ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid,advname from gamesdblog_ooredoo_qatar.advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 $advname=$row5['advname'];
										 $sql2="SELECT 
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
														gamesdb_ooredoo_qatar.subscriber
													INNER JOIN gamesdblog_ooredoo_qatar.annonymoustracking ON msisdn = userid
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
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
														gamesdb_ooredoo_qatar.subscriber
													INNER JOIN gamesdblog_ooredoo_qatar.annonymoustracking ON msisdn = userid
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
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
														gamesdblog_ooredoo_qatar.annonymoustracking
													WHERE
														accesstime >= '".$startdate."'
															AND accesstime <= '".$enddate."'
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
														gamesdblog_ooredoo_qatar.annonymoustracking
													WHERE
														accesstime >= '".$startdate."'
															AND accesstime <= '".$enddate."'
															AND advertiserid=".$advertiserid.") a) p
													GROUP BY dt) q ON x.dt = q.dt
													LEFT JOIN (SELECT 
														COUNT(msisdn) cg, dt
													FROM
														(SELECT 
														msisdn, DATE(requesttime) dt
													FROM
														gamesdb_ooredoo_qatar.callbackrequests
													INNER JOIN gamesdblog_ooredoo_qatar.annonymoustracking ON msisdn = userid
													WHERE
														requesttime >= '".$startdate."'
															AND requesttime <= '".$enddate."'
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
														gamesdb_ooredoo_qatar.subscriber
														 INNER JOIN gamesdblog_ooredoo_qatar.annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
													WHERE
													
														amount = 0 AND txnid LIKE '%-81%'
															AND subscriber.subscriptionstartdate < subscriber.subscriptionenddate
															AND subscriber.subscriptionstartdate >= '".$startdate."'
															AND subscriber.subscriptionstartdate <= '".$enddate."'
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
														gamesdb_ooredoo_qatar.requestresponse
													WHERE
														requesttime >= '".$startdate."'
															AND requesttime <= '".$enddate."'
															AND advertiserid=".$advertiserid.") a
													INNER JOIN gamesdblog_ooredoo_qatar.advertiser ON a.advertiserid = advertiser.advertiserid
													GROUP BY dt , advname) b
													GROUP BY dt) v ON z.dt = v.dt
												ORDER BY z.dt;";
												
										
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
												$operator='ooredoo_qatar';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."');  ";
												$result5=mysql_query($sql4,$con) ;
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

	