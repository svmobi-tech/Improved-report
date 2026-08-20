<?php
require_once __DIR__ . '/../admin/includes/config.php';

$con1=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2
$con=mysql_connect(DB_PROD_HOST3, DB_USER, DB_PASS);
$gamebar_all_Greece='gamebardb_greecevf';
$report='gamebardb_vodafone_qatar_report';
 $sql="call ".$gamebar_all_Greece.".grmainreport('2019-05-01 00:00:00','2019-05-04 23:59:59','')";
			
				
								
								if($result=$con1->query($sql) )
								{
								//$main++;	
								
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
									$result1=mysql_query($sql4,$con) or die(mysql_error($con));
									$indonesia_query=$sql4;
								
								}
								}
								$result->close();
								//$result1->close();
							$con1->next_result();

						  