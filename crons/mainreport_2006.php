<?php
require_once __DIR__ . '/../admin/includes/config.php';
ini_set('max_execution_time', 1000000);

ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000);
$con1=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
$con=mysql_connect(DB_PROD_HOST3, DB_USER, DB_PASS);
$con6=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS);
date_default_timezone_set("Asia/Calcutta");
echo  $date1=date('Y-m-d',strtotime("-1 days"));

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

 $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' ;") or die(mysqli_error($con1));


								//all


// gamebar_indonesia


		 $sql="call ".$indonesia.".mainreport_backdate('".$startdate."','".$enddate."','')";
			
				
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
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
										  $sql2="call ".$indonesia.".mainreport_backdate('".$startdate."','".$enddate."','".$advertiserid."')";
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
							
							
			

			
//Gamebar Kenya oxygen

$sql="call ".$gamebar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
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
										  $sql2="call ".$gamebar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
							
							
							
							
							
//glambar Kenya oxygen

$sql="call ".$glambar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
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
										  $sql2="call ".$glambar_kenya_oxygen.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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




			
							
							
							
							
		//glambar_southafrica intarget
		
		
		$sql="call ".$glambar_southafrica_intarget.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$operator='southafrica_intarget';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$glambar_southafrica_intarget.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$glambar_southafrica_intarget.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='southafrica_intarget';
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
							
							
	//gamebardb_africa intarget  
	
	
	$sql="call ".$gamebar_southafrica_intarget.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$operator='southafrica_intarget';
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
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_southafrica_intarget.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$gamebar_southafrica_intarget.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='southafrica_intarget';
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




 //glambar southafrica
 
 $sql="call ".$southafrica.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
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
										  $sql2="call ".$southafrica.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							
								$result3->close();
								
							$con1->next_result();
							
 
 
 //gamebar southafrica
 
 
 
 $sql="call ".$southafrica.".mainreport_gamebar('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
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
										  $sql2="call ".$southafrica.".mainreport_gamebar('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;
								//			$indonesia_query=$indonesia_query.$sql4;
											}
										}
									}
								}
							
								$result3->close();
								
							$con1->next_result();
 
 
 
 
 






		
						
//Vodafone_Qatar
							
						
				
 $sql="call ".$operator_vodafone.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4) or die(mysql_error($con));

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
										   $sql2="call ".$operator_vodafone.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
	
	//egypt

	$sql="call ".$gamebar_egypt.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4) or die(mysql_error($con));

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
										   $sql2="call ".$gamebar_egypt.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();


		//du dubai					
		 $sql="call ".$du_dubai.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
										  $sql2="call ".$du_dubai.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result30->close();
								//$result1->close();
							$con1->next_result();
							
		
	
	//ooredoo oman

			 $sql="call ".$operator_oman.".mainreport1('ab','cd','".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
										  $sql2="call ".$operator_oman.".mainreport1('ab','cd','".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
	

//malaciya celcom

				
 $sql="call ".$maleysia_celcom.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
										   $sql2="call ".$maleysia_celcom.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
							
							
							
							
//tim_italy Gamebar			
							
				
				$sql="call ".$tim_gamebar.".mainreport('".$startdate."','".$enddate."',0)";
										
								
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
									$operator='tim_italy';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$tim_gamebar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										   $sql2="call ".$tim_gamebar.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='tim_italy';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();		
							
							
						
//wind_italy Gamebar			
							
				
				$sql="call ".$wind_gamebar.".mainreport('".$startdate."','".$enddate."',0)";
										
								
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
									$operator='wind_italy';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$wind_gamebar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										   $sql2="call ".$wind_gamebar.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='wind_italy';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();

						
	//h3g_italy Gamebar			
							
				
				$sql="call ".$h3g_gamebar.".mainreport('".$startdate."','".$enddate."',0)";
										
								
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
									$operator='h3g_italy';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$h3g_gamebar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										   $sql2="call ".$h3g_gamebar.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='h3g_italy';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();					
						
						
						

						

//portugal Gamebar			
							
				
 $sql="call ".$portugal_gamebar.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$operator='portugal';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$portugal_gamebar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										   $sql2="call ".$portugal_gamebar.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='portugal';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();	

							
							
//portugal glambar			
							
				
 $sql="call ".$portugal_glambar.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
									$operator='portugal';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$portugal_glambar.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										   $sql2="call ".$portugal_glambar.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='portugal';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();	
							
							
							
							
							

//gamebar_voda





		 $sql="call ".$gamebar_voda.".mainreport('".$startdate."','".$enddate."','')";
			
				
								
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
									$operator='vodafone';
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
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_voda.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo   $sql2="call ".$gamebar_voda.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='vodafone';
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

				


// glambar_vodafone


		 $sql="call ".$fashionbar_voda.".mainreport('".$startdate."','".$enddate."','')";
			
				
								
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
									$operator='vodafone';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$fashionbar_voda.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										echo   $sql2="call ".$gamebar_voda.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												$operator='vodafone';
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
						
							
//gamebar_idea	
						
						
						$sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$gamebar_idea.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
												
										mysqli_free_result($result30);   
									mysqli_next_result($con1); 
										if($result30=$con1->query($sql2))
										{
											
										$main++;
											while($row2=mysqli_fetch_array($result30,MYSQLI_ASSOC))
											{
												$clicks=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$cbsent=$conversion=$totalcount=$totalamount=0;
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
											//	$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
											//	$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='idea';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
							
//glambar_idea	
						$sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$glambar_idea.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
											mysqli_free_result($result30);   
									mysqli_next_result($con1); 	
										
										if($result30=$con1->query($sql2))
										{
											
										$main++;
											while($row2=mysqli_fetch_array($result30,MYSQLI_ASSOC))
											{
												$clicks=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$cbsent=$conversion=$totalcount=$totalamount=0;
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
											//	$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
											//	$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='idea';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();	
	
//gamebar_bsnl
/*
$sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
									 	  $sql2="call ".$gamebar_bsnl.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
												
										mysqli_free_result($result30);   
									mysqli_next_result($con1); 
										if($result30=$con1->query($sql2))
										{
											
										$main++;
										$clicks=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$cbsent=$conversion=$totalcount=$totalamount=0;
											while($row2=mysqli_fetch_array($result30,MYSQLI_ASSOC))
											{
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
											//	$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
											//	$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='bsnl_india';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();	

							
//glambar_bsnl

$sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$glambar_bsnl.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
												
										mysqli_free_result($result30);   
									mysqli_next_result($con1); 
										if($result30=$con1->query($sql2))
										{
											
										$main++;
											while($row2=mysqli_fetch_array($result30,MYSQLI_ASSOC))
											{
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
											//	$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
											//	$cbsent=$row2['cbsent'];
												$advertiser=$advertiserid;
												$operator='bsnl_india';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
	
	*/
	//gamebar_airtel	

			
   //$sql="call ".$gamebar_airtel.".mainreport('".$startdate."','".$enddate."','')";
	
								$sql="SELECT 
							dt,
							SUM(total_click) clicks,
						   0 witmdn,
						   0 uniq,
							SUM(total_click) cg,
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
								(SELECT sum(act) total_click,date dt,advertiserid FROM  gamebardb_vodafone_qatar_report.`trend_report` WHERE product ='gamebar' and operator='airtel_india' and type='clicks' and date >='".$date1."'  and date <='".$date1."'  group by dt) total_click  UNION SELECT 
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
								subscriptiondetail.msisdn,
									amount,
									DATE(subscriptionstartdate) dt,
									MAX(subscriptionstartdate)
							FROM
								 ".$gamebar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND isrenew = 0
									AND amount > 0
									AND subscriptionstartdate < subscriptionenddate
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
									AND errorcode = 1000
									
									
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
								".$gamebar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND isrenew = 1
									AND amount > 0
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
									AND errorcode = 1000
									) ren
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
								".$gamebar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND amount = 0
									AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
									AND subscriptiondetail.errorcode = 1001
									) dct
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
								".$gamebar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
								   and (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
						   AND errorcode = 1000
									AND amount = 0
							   ) low
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
								(SELECT 
								DISTINCT advertcallback.txnid,
									advertcallback.msisdn,
									DATE(senttime) dt
							FROM
								".$gamebar_airtel.".advertcallback
							INNER JOIN ".$gamebar_airtel.".subscriptiondetail ON advertcallback.txnid = subscriptiondetail.txnid
							WHERE
								senttime >= '".$startdate."'
									AND senttime <=  '".$enddate."'
									) cbs
							GROUP BY dt) a
						GROUP BY dt;";									


	
								
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
									$operator='airtel_india';
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$gamebar_airtel.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										 set_time_limit(0);
										     //$sql2="call ".$gamebar_airtel.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
											
											$sql2="SELECT 
													dt,
													SUM(total_click) clicks,
												   0 witmdn,
												   0 uniq,
													SUM(total_click) cg,
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
														(SELECT sum(act) total_click,date dt,advertiserid FROM  gamebardb_vodafone_qatar_report.`trend_report` WHERE product ='gamebar' and operator='airtel_india' and type='clicks' and date >='".$date1."'  and date <='".$date1."' and advertiserid='".$advertiserid."' group by dt) total_click  UNION SELECT 
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
														subscriptiondetail.msisdn,
															amount,
															DATE(subscriptionstartdate) dt,
															MAX(subscriptionstartdate)
													FROM
														 ".$gamebar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND isrenew = 0
															AND amount > 0
															AND subscriptionstartdate < subscriptionenddate
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
															AND errorcode = 1000
															and advertid='".$advertiserid."'
															
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
														".$gamebar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND isrenew = 1
															AND amount > 0
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
															AND errorcode = 1000
															and advertid='".$advertiserid."') ren
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
														".$gamebar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND amount = 0
															AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
															AND subscriptiondetail.errorcode = 1001
															and advertid='".$advertiserid."') dct
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
														".$gamebar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
														   and  (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
												   AND errorcode = 1000
															AND amount = 0
														and advertid='".$advertiserid."') low
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
														(SELECT 
														DISTINCT advertcallback.txnid,
															advertcallback.msisdn,
															DATE(senttime) dt
													FROM
														".$gamebar_airtel.".advertcallback
													INNER JOIN ".$gamebar_airtel.".subscriptiondetail ON advertcallback.txnid = subscriptiondetail.txnid
													WHERE
														senttime >= '".$startdate."'
															AND senttime <=  '".$enddate."'
															and advertiserid='".$advertiserid."') cbs
													GROUP BY dt) a
												GROUP BY dt;";
											
											mysqli_free_result($result3);   
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
												$operator='airtel_india';
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
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
						
					
//glambar_airtel

						
   // $sql="call ".$glambar_airtel.".mainreport('".$startdate."','".$enddate."','')";
							$sql="SELECT 
							dt,
							SUM(total_click) clicks,
						   0 witmdn,
						   0 uniq,
							SUM(total_click) cg,
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
								(SELECT sum(act) total_click,date dt,advertiserid FROM  gamebardb_vodafone_qatar_report.`trend_report` WHERE product ='glambar' and operator='airtel_india' and type='clicks' and date >='".$date1."'  and date <='".$date1."'  group by dt) total_click  UNION SELECT 
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
								subscriptiondetail.msisdn,
									amount,
									DATE(subscriptionstartdate) dt,
									MAX(subscriptionstartdate)
							FROM
								 ".$glambar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND isrenew = 0
									AND amount > 0
									AND subscriptionstartdate < subscriptionenddate
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
									AND errorcode = 1000
									
									
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
								".$glambar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND isrenew = 1
									AND amount > 0
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
									AND errorcode = 1000
									) ren
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
								".$glambar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
									AND amount = 0
									AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
									AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
									AND subscriptiondetail.errorcode = 1001
									) dct
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
								".$glambar_airtel.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$startdate."'
									AND subscriptionstartdate <= '".$enddate."'
								   and (charging_mode = 600404 or charging_mode = 600409 or charging_mode = 600398)
						   AND errorcode = 1000
									AND amount = 0
							   ) low
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
								(SELECT 
								DISTINCT advertcallback.txnid,
									advertcallback.msisdn,
									DATE(senttime) dt
							FROM
								".$glambar_airtel.".advertcallback
							INNER JOIN ".$glambar_airtel.".subscriptiondetail ON advertcallback.txnid = subscriptiondetail.txnid
							WHERE
								senttime >= '".$startdate."'
									AND senttime <=  '".$enddate."'
									) cbs
							GROUP BY dt) a
						GROUP BY dt;";								
								
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
									$operator='airtel_india';
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  $sql1="select advertiserid from ".$glambar_airtel.".advertiser";					
						
							if($result30=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result30,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  // $sql2="call ".$glambar_airtel.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
											$sql2="SELECT 
													dt,
													SUM(total_click) clicks,
												   0 witmdn,
												   0 uniq,
													SUM(total_click) cg,
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
														(SELECT sum(act) total_click,date dt,advertiserid FROM  gamebardb_vodafone_qatar_report.`trend_report` WHERE product ='glambar' and operator='airtel_india' and type='clicks' and date >='".$date1."'  and date <='".$date1."' and advertiserid='".$advertiserid."' group by dt) total_click  UNION SELECT 
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
														subscriptiondetail.msisdn,
															amount,
															DATE(subscriptionstartdate) dt,
															MAX(subscriptionstartdate)
													FROM
														 ".$glambar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND isrenew = 0
															AND amount > 0
															AND subscriptionstartdate < subscriptionenddate
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
															AND errorcode = 1000
															and advertid='".$advertiserid."'
															
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
														".$glambar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND isrenew = 1
															AND amount > 0
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
															AND errorcode = 1000
															and advertid='".$advertiserid."') ren
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
														".$glambar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
															AND amount = 0
															AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
															AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and  charging_mode != 600375)
															AND subscriptiondetail.errorcode = 1001
															and advertid='".$advertiserid."') dct
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
														".$glambar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
														   and (charging_mode = 600404 or charging_mode = 600409 or charging_mode = 600398)
												   AND errorcode = 1000
															AND amount = 0
														and advertid='".$advertiserid."') low
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
														(SELECT 
														DISTINCT advertcallback.txnid,
															advertcallback.msisdn,
															DATE(senttime) dt
													FROM
														".$glambar_airtel.".advertcallback
													INNER JOIN ".$glambar_airtel.".subscriptiondetail ON advertcallback.txnid = subscriptiondetail.txnid
													WHERE
														senttime >= '".$startdate."'
															AND senttime <=  '".$enddate."'
															and advertiserid='".$advertiserid."') cbs
													GROUP BY dt) a
												GROUP BY dt;";
											
											
											mysqli_free_result($result3);   
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
												$operator='airtel_india';
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
						
						echo "<br>". $main;				
								
		if($main>=244)
		{
			
			$cur_date=date('Y-m-d H-i:s');
			$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=1, date='".$cur_date."' where cron_name='mainreport'";
			$result = mysqli_query($con2,$sql) ;
		}