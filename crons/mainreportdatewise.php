<?php
require_once __DIR__ . '/../admin/includes/config.php';
//exit;
ini_set('max_execution_time', 400000000);

ini_set('mysql.connect_timeout', 400000000);
ini_set('default_socket_timeout', 400000000);
$con1=mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
//$con=mysql_connect('10.34.240.3','webserveruser','K&dN&r4a8N@du0');
$con6=mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS);
date_default_timezone_set("Asia/Calcutta");
  $date1=date('Y-m-d',strtotime("-4 days"));
  $date2=date('Y-m-d',strtotime("-2 days"));
$userdate=date('dmY',strtotime("-2 days"));




$start_date=$date1.' 00:00:00';
$end_date=$date2.' 23:59:59';




$report='gamebardb_vodafone_qatar_report';

$currdate=date('Y-m-d');
$currdate2=date('Y-m-d H:i:s');

 $main=0;

//mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and operator not like '%vodacom%' ;") or die(mysqli_error($con1));

//echo"hi";exit;
//all


$sql1="select * from gamebardb_vodafone_qatar_report.mainreportquery where (lastrun<'".$currdate."' or lastrun is null or lastrun='') and (mainreport_all is not null and mainreport_all !='') order by id asc limit 10";
			//echo $sql1;exit;
				
								
								if($result1=$con1->query($sql1) )
								{
									$main++;	
									
									while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC))
									{
										
										

										$product=$row1['product'];
										$country=$row1['Country'];
										$operator=$row1['operator'];
										$mainreport_all=$row1['mainreport_all'];
										$mainreport_advertiser=$row1['mainreport_advertiser'];
										
										//echo "DELETE FROM ".$report.".`mainreport` WHERE `date`>='".$date1."' and `date`<='".$date2."' and  and product='".$product."' and operator='".$operator."' ;";exit;
										
										
										
										
										//mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`>='".$date1."' and `date`<='".$date2."' and  and product='".$product."' and operator='".$operator."' ;") or die(mysqli_error($con1));
										
										//all
										
											$url=str_replace("[startdate]",$start_date,$mainreport_all);
												$url=str_replace("[enddate]",$end_date,$url);
												
												$query=str_replace("[advid]",$adve,$url);
										
										
											echo "<br>====".date('Y-m-d H:i:s')."==".	 $query;
				
					
									
											if($result=$con1->query($query) )
											{
												$con1->next_result();
											mysqli_query($con1,"update ".$report.".`mainreportquery` set lastrun='".$currdate2."' WHERE product='".$product."' and operator='".$operator."'");
											$main++;	
											echo "====".date('Y-m-d H:i:s')."==<br>";
											while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
											{
												$pcsent=$clicks=$uniq=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$pcsent=$cbsent=$conversion=$totalcount=$totalamount=$cbsentpercent=$advamount=0;
												$pcsent=0;
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
												$pcsent=$row['pcsent'];
												$cbsent=$row['cbsent'];
												$advertiser=0;
												
												
												
												$advname='all';
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
											$sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`,`country`,`pcsent`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."','".$country."','".$pcsent."')  ";
												//$result1=mysql_query($sql4,$con) or die(mysql_error($con));
												//$indonesia_query=$sql4;
												$result4=$con6->query($sql4);
												
											}
											}
										//	$result->close();
											//$result1->close();
										$con1->next_result();
										
										
										
										
										//advertiser wise
										
										
										$sql22='select * from  advertiserdb.advertiser order by advertiserid asc';
										$result22=$con1->query($sql22);
										
										while($row22=mysqli_fetch_array($result22,MYSQLI_ASSOC))
										{
											
											$advid=$row22['advertiserid'];
											$advname=$row22['advname'];
										
												$url1=str_replace("[startdate]",$start_date,$mainreport_advertiser);
														$url1=str_replace("[enddate]",$end_date,$url1);
														
														$query1=str_replace("[advid]",$advid,$url1);
												
												
												
												
												
													//echo "<br>".$query1;
						
													echo "<br>====".date('Y-m-d H:i:s')."==".	 $query1;
											
													if($result=$con1->query($query1) )
													{
													$main++;	
													echo "====".date('Y-m-d H:i:s')."==<br>";
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
													{
														$pcsent=$clicks=$uniq=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$pcsent=$cbsent=$conversion=$totalcount=$totalamount=$cbsentpercent=$advamount=0;
														$pcsent=0;
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
														$pcsent=$row['pcsent'];
														$cbsent=$row['cbsent'];
														$advertiser=$advid;
														
														
														
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
													 $sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`,`country`,`pcsent`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."','".$country."','".$pcsent."')  ";
														//$result1=mysql_query($sql4,$con) or die(mysql_error($con));
														//$indonesia_query=$sql4;
														$result4=$con6->query($sql4);
													
													}
													}
												//	$result->close();
													//$result1->close();
												$con1->next_result();
										
										
										
										
										}
										
										
										
										
										

									}

								}





						
						
echo "<br>main=". $main;				
								
		if($main>=244)
		{
			
			$cur_date=date('Y-m-d H-i:s');
			$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=1, date='".$cur_date."' where cron_name='mainreport'";
			$result = mysqli_query($con1,$sql) ;
			
			mysqli_close($con1);
			mysqli_close($con6);
			Header("location:deleteduplicate.php");
		}