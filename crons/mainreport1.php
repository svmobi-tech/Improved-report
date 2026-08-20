<?php


$con1=mysqli_connect('10.125.1.51','webserveruser','K&dN&r4a8N@du0') or die(mysqli_error());//cluster 2
/*con.query('SET GLOBAL connect_timeout=28800');
con.query('SET GLOBAL wait_timeout=28800');
con.query('SET GLOBAL interactive_timeout=28800');
*/
$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
$con=mysql_connect(DB_PROD_HOST3, DB_USER, DB_PASS);

date_default_timezone_set("Asia/Calcutta");
echo  $date1=date('Y-m-d',strtotime("-1 days"));

$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$operator_vodafone='gamebardb_vodafone_qatar';
$operator_oman="gamesdb_ooredoo_oman";
$maleysia_celcom="gamesdbnew_celcom_malaysia";
$operator_oomanlog="gamesdblog_ooredoo_oman";
$southafrica="fashionbardb_africa";
$southafricagame="fashionbardb_africa";
$indonesia="gamebardb_indonesia";
$report='gamebardb_vodafone_qatar_report';
$portugal_gamebar='gamebardb_portugal';
$glambar_airtel='funzonedb_airtel';
$gamebar_airtel='gamebardb_airtel';
$gamebar_voda='gamesworld_voda';
$gamebar_idea='gamesworld_idea';
$gamebar_bsnl='bsnlgamebar';
$glambar_voda='glamourworld_voda';
$glambar_idea='glamourworld_idea';
$glambar_bsnl='bsnlfashionbar';

echo $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."';") or die(mysqli_error($con1));


								//all


// gamebar_indonesia


		 $sql="call ".$indonesia.".mainreport('".$startdate."','".$enddate."','')";
										
								
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
										  $sql2="call ".$indonesia.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
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
								   $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
							
//gamebar southafrica


			
  $sql="call ".$southafrica.".mainreport_gamebar('".$startdate."','".$enddate."','')";
										
								
								if($result30=mysqli_query($con2,$sql) )
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
								 echo  $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));

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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();
							
	//portugal					
							
				
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


							
//gamebar_voda



							$result9='';
						  $sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=1 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$gamebar_voda.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
												
										mysqli_free_result($result9);   
									mysqli_next_result($con1); 
										if($result9=$con1->query($sql2))
										{
											
										$main++;
											while($row2=mysqli_fetch_array($result9,MYSQLI_ASSOC))
											{
												$clicks=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$cbsent=$conversion=$totalcount=$totalamount=0;
												$Date=$row2['dt'];
												$clicks=$row2['clicks'];
												
												$uniq=$row2['uniq'];
												//$cg=$row2['cg'];
												$actcount=$row2['act'];
												$actamount=$row2['actamnt'];
												$renewcount=$row2['ren'];
												$renewamount=$row2['renamnt'];
												$churn=$row2['churn'];
												$park=$row2['Low'];
											//	$cbsent=$row2['cbsent'];
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
								$result3->close();
								//$result1->close();
							$con1->next_result();

//glambar_voda
									
		   $sql1="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=1 group by aggregator";					
						
							if($result3=mysqli_query($con2,$sql1))
								{
							//	echo $result3; exit;
								//echo "hi";
									while($row5=mysqli_fetch_array($result3,MYSQLI_ASSOC))
									{
										 $advertiserid=$row5['advertiserid'];
										  $sql2="call ".$glambar_voda.".mainreport('".$startdate."','".$enddate."','".$advertiserid."')";
												
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
												
												
										 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."')  ";
												$result5=mysql_query($sql4,$con) ;

											}
										}
									}
								}
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
								".$gamebar_airtel.".subscriptiondetail
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
								".$gamebar_airtel.".subscriptiondetail
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
														".$gamebar_airtel.".subscriptiondetail
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
														".$gamebar_airtel.".subscriptiondetail
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
														".$gamebar_airtel.".subscriptiondetail
													WHERE
														subscriptionstartdate >= '".$startdate."'
															AND subscriptionstartdate <= '".$enddate."'
														   and (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
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
														   and (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
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
								
		if($main>=106)
		{
			
			$cur_date=date('Y-m-d H-i:s');
			$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=1, date='".$cur_date."' where cron_name='mainreport'";
			$result = mysqli_query($con2,$sql) ;
		}
				



						
				
		
	


		
		
		//$result3->close();
			//$result1->close();
//		$con1->next_result();
	?>

