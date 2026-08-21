<?php
require_once __DIR__ . '/../admin/includes/config.php';

$con1=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2

$con2=$con1;
//$con=mysql_connect("10.125.1.51","productionuser","Zb8#fNIsXnoP876") or die(mysql_error());//cluster2
$con=mysql_connect(DB_PROD_HOST3, DB_USER, DB_PASS);

date_default_timezone_set("Asia/Calcutta");
echo  $date1=date('Y-m-d',strtotime("-49 days"));

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
$gamebar_egypt='gamebardb_vodafone_egypt';

 $main=0;

mysqli_query($con1,"DELETE FROM ".$report.".`mainreport` WHERE `date`='".$date1."' and operator='bsnl_india' and product='glambar' ;") or die(mysqli_error($con1));



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
												if($row2['act']==0)
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
	