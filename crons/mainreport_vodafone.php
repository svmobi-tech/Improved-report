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
//echo  $date1=date('Y-m-d',strtotime("-1 days"));
$date1=$_GET['date'];
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$gamebar_voda='gamebardb_svmobi';
$fashionbar_voda='fashionbardb_svmobi';

 $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and operator='vodafone' ;") or die(mysqli_error($con1));



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
						
	