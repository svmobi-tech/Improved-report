<?php
require_once __DIR__ . '/../admin/includes/config.php';

ini_set('max_execution_time', 1000000);

ini_set('mysql.connect_timeout', 1000000);
ini_set('default_socket_timeout', 1000000);
$con1=mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
//$con=mysql_connect('10.34.240.3','webserveruser','K&dN&r4a8N@du0');
$con6=mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS);
date_default_timezone_set("Asia/Calcutta");
echo  $date1=date('Y-m-d',strtotime("-1 days"));

$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';


//$date1='2023-07-14';


$report='gamebardb_vodafone_qatar_report';




 $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and (operator like '%Ethiopia%' or  operator like '%Ethiopia_11Players%')  ;") or die(mysqli_error($con1));

//echo"hi";exit;
//all
$url="https://gamebar.et/et/mainreport.php?startdate=$date1&enddate=$date1";

					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => $url,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => '',
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 600,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
					 
					));

					$response = curl_exec($curl);

					curl_close($curl);

					
					$row1=json_decode($response,true);
					$row=$row1[$date1];	
					print_r($row);

//{"2023-06-28":{"clicks":"0","uniq":"0","cg":"286","conversion":true,"actcount":"13","actamount":"26","renewcount":"336","renewamount":"672","totalcount":349,"totalamount":698,"churn":"0","park":"0","cbsent":"114","cbsentpercent":876.923076923076905586640350520610809326171875,"advamount":1453.5,"advertiser":0,"operator":"Ethopia","product":"Gamebar","advname":"all","country":"Ethopia","pcsent":"0"}}No error


									
										
												$pcsent=$clicks=$uniq=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$pcsent=$cbsent=$conversion=$totalcount=$totalamount=$cbsentpercent=$advamount=0;
												$pcsent=0;
												$Date=$date1;
												$clicks=$row['clicks'];
												
												$uniq=$row['uniq'];
												$cg=$row['cg'];
												$actcount=$row['actcount'];
												$actamount=$row['actamount'];
												$renewcount=$row['renewcount'];
												$renewamount=$row['renewamount'];
												$totalcount=$row['totalcount'];
												$totalamount=$row['totalamount'];
												$churn=$row['churn'];
												$park=$row['park'];
												$cbsent=$row['cbsent'];
												$cbsentpercent=$row['cbsentpercent'];
												$advamount=$row['advamount'];
												$advertiser=$row['advertiser'];
												$operator=$row['operator'];
												$product=$row['product'];
												$advname=$row['advname'];
												$country=$row['country'];
												$pcsent=$row['pcsent'];
												
												
												
												
												$advname='all';
												$conversion=($row['actcount']*100)/$row['clicks'];
												
												
													
												//echo "hi";
											$sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`,`country`,`pcsent`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."','".$country."','".$pcsent."')  ";
												//$result1=mysql_query($sql4,$con) or die(mysql_error($con));
												//$indonesia_query=$sql4;
												$result4=$con6->query($sql4);
											
											
										
										//	$result->close();
											//$result1->close();
										$con1->next_result();
										
										
										
										
										//advertiser wise
										
										
										


$url="https://11players.et/mainreport.php?startdate=$date1&enddate=$date1";

					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => $url,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => '',
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 600,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
					 
					));

					$response = curl_exec($curl);

					curl_close($curl);

					
					$row1=json_decode($response,true);
					$row=$row1[$date1];	
					print_r($row);

//{"2023-06-28":{"clicks":"0","uniq":"0","cg":"286","conversion":true,"actcount":"13","actamount":"26","renewcount":"336","renewamount":"672","totalcount":349,"totalamount":698,"churn":"0","park":"0","cbsent":"114","cbsentpercent":876.923076923076905586640350520610809326171875,"advamount":1453.5,"advertiser":0,"operator":"Ethopia","product":"Gamebar","advname":"all","country":"Ethopia","pcsent":"0"}}No error


									
										
												$pcsent=$clicks=$uniq=$cg=$actcount=$actamount=$renewcount=$renewamount=$churn=$park=$pcsent=$cbsent=$conversion=$totalcount=$totalamount=$cbsentpercent=$advamount=0;
												$pcsent=0;
												$Date=$date1;
												$clicks=$row['clicks'];
												
												$uniq=$row['uniq'];
												$cg=$row['cg'];
												$actcount=$row['actcount'];
												$actamount=$row['actamount'];
												$renewcount=$row['renewcount'];
												$renewamount=$row['renewamount'];
												$totalcount=$row['totalcount'];
												$totalamount=$row['totalamount'];
												$churn=$row['churn'];
												$park=$row['park'];
												$cbsent=$row['cbsent'];
												$cbsentpercent=$row['cbsentpercent'];
												$advamount=$row['advamount'];
												$advertiser=$row['advertiser'];
												$operator=$row['operator'];
												$product=$row['product'];
												$advname=$row['advname'];
												$country=$row['country'];
												$pcsent=$row['pcsent'];
												
												
												
												
												$advname='all';
												$conversion=($row['actcount']*100)/$row['clicks'];
												  $operator='Ethiopia';
												 $product='11Players';
												
													
												//echo "hi";
											$sql4="INSERT INTO ".$report.".`mainreport`(`Date`, `clicks`, `uniq`, `cg`, `conversion`, `actcount`, `actamount`, `renewcount`, `renewamount`, `totalcount`, `totalamount`, `churn`, `park`,  `cbsent`, `cbsentpercent`, `advamount`,   `advertiser`, `operator`, `product`,`advname`,`country`,`pcsent`) values('".$Date."','".$clicks."','".$uniq."','".$cg."','".$conversion."','".$actcount."','".$actamount."','".$renewcount."','".$renewamount."','".$totalcount."','".$totalamount."','".$churn."','".$park."','".$cbsent."','".$cbsentpercent."','".$advamount."','".$advertiser."','".$operator."','".$product."','".$advname."','".$country."','".$pcsent."')  ";
												//$result1=mysql_query($sql4,$con) or die(mysql_error($con));
												//$indonesia_query=$sql4;
												$result4=$con6->query($sql4);
											
											
										
										//	$result->close();
											//$result1->close();
										$con1->next_result();