<?php
require_once __DIR__ . '/../admin/includes/config.php';
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysql_error());//cluster 2
//$con=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());//cluster1
$con1=$con2;
$con=mysql_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysql_error());//cluster2
date_default_timezone_set("Asia/Calcutta");
//$result=mysql_query("truncate gamebardb_vodafone_qatar.subscriptiondetail",$con);
 $date1=date('Y-m-d',strtotime("-1 days"));
 $userdate=date('dmY',strtotime("-1 days"));
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$operator=['gamebardb_vodafone_qatar','gamesdb_ooredoo_oman','gamesdbnew_robi_bangladesh','gamebardb_airtel','gamebardb_indonesia','gamebardb_vodafone_egypt','gamebardb_spain','fashionbardb_spain'];
$operatorlog=['','gamesdblog_ooredoo_oman','','','gamebardblog_indonesia','','gamebardblog_spain','fashionbardblog_spain'];
$report='gamebardb_vodafone_qatar_report';
$type = array('count','amount','arpu','clicks','callbackrate','callbacksent');

$sizetype=sizeof($type);
$performcount=0;

$count1=0;

//echo "Hi";
mysqli_query($con1,"DELETE FROM gamebardb_vodafone_qatar_report.`perform_report` WHERE `date`='".$date1."';");
//mysqli_query($con1,"DELETE FROM hotshotsnewdb_idea_0717.`perform_report` WHERE `date`='".$date1."';");
//mysqli_query($con1,"DELETE FROM hotshotsnewdb_airtel_0717.`perform_report` WHERE `date`='".$date1."';");




	for ($i=0;$i<8;$i++)//OPERATOR
	{
		for($j=0;$j <$sizetype ; $j++)//TYPE
		{
			
			
			
				
				if($j==0)//count
				{
					
							
							//echo $sql="call ".$operator[$i].".get_perform_count('".$startdate."','".$enddate."',".$k.")";
							//echo $k."<br>";
							if($i==0)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.txnid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.txnid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
								
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>1=".$count1;
								//$row="";
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							
							else if($i==1)
							{
							
							$sql="SELECT 
									aa.dt dt,
									COUNT(txnid) act,
									CASE
										WHEN aa.advname IS NULL THEN 'other'
										ELSE aa.advname
									END advname,
									aa.advertiserid,
									SUM(amount) amt,
									 aces
								FROM
									(SELECT DISTINCT
										subscriber.txnid,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											hour(subscriptionstartdate) aces,
											amount
									FROM
										".$operator[$i].".subscriber
									LEFT JOIN ".$operatorlog[$i].".annonymoustracking ON subscriber.txnid = annonymoustracking.txnid
									LEFT JOIN ".$operatorlog[$i].".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										 
											AND amount > 0
											AND isrenew=0) aa
								GROUP BY aces,aa.dt , aa.advname;

								";
										
							
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>2=".$count1;
								//$row="";
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','gamebar','ooredoo_oman')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							/*elseif($i==2)
							{
								  $sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
							//	echo $sql;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','glambar','airtel_india')  ";
								
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							
							elseif($i==3)
							{
								$sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							*/
							elseif($i==4)
							{
								
								 $sql="							
									SELECT 
										COUNT(DISTINCT mo.clickid) act,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										mo.advid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate)aces,
										SUM(amount) amt,
										advertiser.advertiserid
									FROM
										".$operator[$i].".mo
											LEFT JOIN
										".$operator[$i].".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate < '".$enddate."'
											
											AND charging_mode = 'ACT'
											AND amount > 0
									GROUP BY dt , advname,aces
										"; 
								
								
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							else if($i==5)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.txnid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.txnid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
								
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>1=".$count1;
								//$row="";
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','count','".$act."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							
				
				
				}
			
				else if($j==1)//amount
				{
						
						if($i==0)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
										
								
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>3=".$count1;
								//$row="";
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$amt=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$amt."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==1)
							{
							 $sql="SELECT 
									aa.dt dt,
									COUNT(txnid) act,
									CASE
										WHEN aa.advname IS NULL THEN 'other'
										ELSE aa.advname
									END advname,
									aa.advertiserid,
									SUM(amount) amt,
									 aces
								FROM
									(SELECT DISTINCT
										subscriber.txnid,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											hour(subscriptionstartdate) aces,
											amount
									FROM
										".$operator[$i].".subscriber
									LEFT JOIN ".$operatorlog[$i].".annonymoustracking ON subscriber.txnid = annonymoustracking.txnid
									LEFT JOIN ".$operatorlog[$i].".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										 
											AND amount > 0
											AND isrenew=0) aa
								GROUP BY aces,aa.dt , aa.advname;

								";
								
								
										
							//	exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>4=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$amt=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$amt."','gamebar','ooredoo_oman')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							/*elseif($i==2)
							{
								  $sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$act."','glambar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							} 
							
							elseif($i==3)
							{
								 $sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 541729
												AND charging_mode != 548184
												AND charging_mode != 548185
												AND charging_mode != 548186
												AND charging_mode != 548178)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
									 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							*/
							elseif($i==4)
							{
								$sql="							
									SELECT 
										COUNT(DISTINCT mo.clickid) act,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										mo.advid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate)aces,
										SUM(amount) amt,
										advertiser.advertiserid
									FROM
										".$operator[$i].".mo
											LEFT JOIN
										".$operator[$i].".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate < '".$enddate."'
											
											AND charging_mode = 'ACT'
											AND amount > 0
									GROUP BY dt , advname,aces
										"; 
								
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
									 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							else if($i==5)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
										
								
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>3=".$count1;
								//$row="";
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$amt=$row['amt'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','amount','".$amt."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							
							
							
				}
				else if($j==2)//arpu
				{
						if($i==0)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>5=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==1)
							{
							$sql="SELECT 
									aa.dt dt,
									COUNT(txnid) act,
									CASE
										WHEN aa.advname IS NULL THEN 'other'
										ELSE aa.advname
									END advname,
									aa.advertiserid,
									SUM(amount) amt,
									 aces
								FROM
									(SELECT DISTINCT
										subscriber.txnid,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											hour(subscriptionstartdate) aces,
											amount
									FROM
										".$operator[$i].".subscriber
									LEFT JOIN ".$operatorlog[$i].".annonymoustracking ON subscriber.txnid = annonymoustracking.txnid
									LEFT JOIN ".$operatorlog[$i].".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										 
											AND amount > 0
											AND isrenew=0) aa
								GROUP BY aces,aa.dt , aa.advname;


								";
										
							//echo $sql;	exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>6=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','gamebar','ooredoo_oman')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							/*
							elseif($i==2)
							{
								$sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 541729
												AND charging_mode != 548184
												AND charging_mode != 548185
												AND charging_mode != 548186
												AND charging_mode != 548178)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$act=number_format($act,2);
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','glambar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							elseif($i==3)
							{
								 $sql="SELECT 
										aa.dt dt,
										COUNT(DISTINCT aa.txnid) act,
										SUM(aa.amount) amt,
										CASE
											WHEN aa.advertiserid IS NULL THEN - 1
											ELSE aa.advertiserid
										END advertiserid,
										CASE
											WHEN
												aa.advertiserid = - 1
													OR aa.advertiserid IS NULL
											THEN
												'other'
											ELSE aa.advname
										END advname,
										aces
									FROM
										(SELECT DISTINCT
											subscriptiondetail.txnid,
											   
												amount,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
											   
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										INNER JOIN ".$operator[$i].".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
												AND amount > 0
												AND isrenew = 0
												AND (charging_mode != 541729
												AND charging_mode != 548184
												AND charging_mode != 548185
												AND charging_mode != 548186
												AND charging_mode != 548178)
												AND subscriptiondetail.errorcode = 1000
										GROUP BY subscriptiondetail.txnid) aa
									GROUP BY aces , aa.dt , advertiserid;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$act=number_format($act,2);
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							*/
							elseif($i==4)
							{
								$sql="							
									SELECT 
										COUNT(DISTINCT mo.clickid) act,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										mo.advid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate)aces,
										SUM(amount) amt,
										advertiser.advertiserid
									FROM
										".$operator[$i].".mo
											LEFT JOIN
										".$operator[$i].".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$startdate."'
											AND subscriptionstartdate < '".$enddate."'
											
											AND charging_mode = 'ACT'
											AND amount > 0
									GROUP BY dt , advname,aces
										"; 
								
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$act=number_format($act,2);
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==5)
							{
								$sql="select * from (SELECT 
										COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate) aces,
										SUM(amount) amt
									FROM
										".$operator[$i].".subscriptiondetail
											LEFT JOIN
										".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN
										".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
										  
											AND amount > 0
											AND isrenew = 0
									GROUP BY aces,dt , advname)aa;";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>5=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['amt']/$row['act'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$act=number_format($act,2);
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','arpu','".$act."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							
							
				}
				else if($j==3)//clicks
				{
				
						
						if($i==0)
							{
								$sql="SELECT 
								COUNT(txnid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
							FROM
								(SELECT 
									txnid, DATE(accesstime) dt, userlog.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operator[$i].".userlog
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
							GROUP BY dt , advname,accesstime;";
										
							
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
							//		echo "<br>7=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==1)
							{
							  $sql="SELECT 
								COUNT(txnid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
								FROM
								(SELECT 
									txnid, DATE(accesstime) dt, annonymoustracking.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operatorlog[$i].".annonymoustracking
								LEFT JOIN ".$operatorlog[$i].".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
								GROUP BY dt , advname,accesstime;";
										
							//	exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>8=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','ooredoo_oman')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							elseif($i==2)
							{
								 
								
								 $userlogna="userlog_".$userdate;
								 
								  $sql22="select 1 from ".$operator[$i].".".$userlogna." limit 1 ";
								if($result22 = $con1->query($sql22))
								{
									 $userlogname=$userlogna;
								}
								else{
									
									 $userlogname='userlog';
								}
								
								 $sql="SELECT 
								COUNT(txnid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
								FROM
								(SELECT 
									txnid, DATE(accesstime) dt, userlog1.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operator[$i].".".$userlogname." userlog1
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = userlog1.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
								GROUP BY dt , advname,accesstime;";
										
								
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','Bangladesh_Robi')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							/*elseif($i==3)
							{
								 $userlogna="userlog_".$userdate;
								 
								  $sql22="select 1 from ".$operator[$i].".".$userlogna." limit 1 ";
								if($result22 = $con1->query($sql22))
								{
									 $userlogname=$userlogna;
								}
								else{
									
									 $userlogname='userlog';
								}
								
								 $sql="SELECT 
								COUNT(txnid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
								FROM
								(SELECT 
									txnid, DATE(accesstime) dt, userlog1.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operator[$i].".".$userlogname." userlog1
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = userlog1.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
								GROUP BY dt , advname,accesstime;";
										
								
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							*/
							elseif($i==4)
							{
								 $userlogna="userlog_".$userdate;
								 
								  $sql22="select 1 from ".$operatorlog[$i].".".$userlogna." limit 1 ";
								if($result22 = $con1->query($sql22))
								{
									 $userlogname=$userlogna;
								}
								else{
									
									 $userlogname='userlog';
								}
								$sql="SELECT 
								COUNT(clickid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
								FROM
								(SELECT 
									clickid, DATE(accesstime) dt, userlog1.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operatorlog[$i].".".$userlogname." userlog1
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = userlog1.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
								GROUP BY dt , advname,accesstime;";
										
								
								//$result=mysql_query($sql,$con);
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							else if($i==5)
							{
								$sql="SELECT 
								COUNT(txnid) clicks,
								dt,
								advertiserid,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								accesstime
							FROM
								(SELECT 
									txnid, DATE(accesstime) dt, userlog.advertiserid, advname,hour(accesstime) accesstime
								FROM
									".$operator[$i].".userlog
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >=  '".$startdate."'
										AND accesstime <= '".$enddate."'
										) a
							GROUP BY dt , advname,accesstime;";
										
							
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
							//		echo "<br>7=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['clicks'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$accesstime=$row['accesstime'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$accesstime."','".$advertiser."','".$advertiserid."','clicks','".$act."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							
				
				}
				else if($j==4)
				{
						
						
						
						if($i==0)
							{
								$sql="SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								advertiserid,
								aces
								
							FROM
								(SELECT DISTINCT
									advertcallback.txnid,
										advertcallback.msisdn,
										DATE(senttime) dt,
										advname,
										advertiser.advertiserid,
										hour(senttime) aces
								FROM
									".$operator[$i].".subscriptiondetail
								INNER JOIN ".$operator[$i].".advertcallback ON subscriptiondetail.reqid = advertcallback.txnid
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
									senttime >= '".$startdate."'
										AND senttime <= '".$enddate."'
										AND advertcallback.isact != 0
										) s
							GROUP BY aces,dt , advname";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>9=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
							 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==1)
							{
							  $sql="SELECT COUNT( cbsent ) CBS, dt, 
									CASE 
									WHEN advname IS NULL 
									THEN  'other'
									ELSE advname
									END advname, advertiserid, aces
									FROM (
									SELECT COUNT(requestresponseid) cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid, HOUR( requesttime )aces  from ".$operator[$i].".requestresponse 
									inner join ".$operatorlog[$i].".advertiser on advertiser.advertiserid = requestresponse.advertiserid  where requesttime >= '".$startdate."' and requesttime < '".$enddate."' 
									)a
									GROUP BY aces, dt, advname
									ORDER BY aces ASC	";
										
							
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>10=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','gamebar','ooredoo_oman')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							/*elseif($i==2)
							{
								 $sql="SELECT 
										COUNT(cbsent) CBS,
										dt,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										aces,advertiserid
									FROM
										(SELECT DISTINCT
											advertcallback.txnid cbsent, DATE(senttime) dt, advname,hour(senttime) aces,advertiser.advertiserid
										FROM
											".$operator[$i].".advertcallback
										LEFT JOIN ".$operator[$i].".subscriptiondetail ON subscriptiondetail.txnid = advertcallback.txnid
										LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
										WHERE
											senttime >='".$startdate."'
												AND senttime <= '".$enddate."'
												
												) a
									GROUP BY aces,dt , advname";
																			
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','glambar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							elseif($i==3)
							{
								$sql="SELECT 
										COUNT(cbsent) CBS,
										dt,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										aces,advertiserid
									FROM
										(SELECT DISTINCT
											advertcallback.txnid cbsent, DATE(senttime) dt, advname,hour(senttime) aces,advertiser.advertiserid
										FROM
											".$operator[$i].".advertcallback
										LEFT JOIN ".$operator[$i].".subscriptiondetail ON subscriptiondetail.txnid = advertcallback.txnid
										LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
										WHERE
											senttime >='".$startdate."'
												AND senttime <= '".$enddate."'
												
												) a
									GROUP BY aces,dt , advname";
																			
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							*/
							elseif($i==4)
							{
								$sql="SELECT 
										COUNT(cbsent) CBS,
										dt,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										aces,advertiserid
									FROM
										(SELECT DISTINCT
											callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,hour(requesttime) aces,advertiser.advertiserid
										FROM
											".$operator[$i].".callbackresponse
										
										LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
										WHERE
											requesttime >='".$startdate."'
												AND requesttime <= '".$enddate."'
												and issent=1
												
												) a
									GROUP BY aces,dt , advname";
																			
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								}
								
							}
							else if($i==5)
							{
								$sql="SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								advertiserid,
								aces
								
							FROM
								(SELECT DISTINCT
									advertcallback.txnid,
										advertcallback.msisdn,
										DATE(senttime) dt,
										advname,
										advertiser.advertiserid,
										hour(senttime) aces
								FROM
									".$operator[$i].".subscriptiondetail
								INNER JOIN ".$operator[$i].".advertcallback ON subscriptiondetail.reqid = advertcallback.txnid
								LEFT JOIN ".$operator[$i].".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
									senttime >= '".$startdate."'
										AND senttime <= '".$enddate."'
										AND advertcallback.isact != 0
										) s
							GROUP BY aces,dt , advname";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								//	echo "<br>9=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['CBS'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['advertiserid'];
									$aces=$row['aces'];
								
									//echo "hi";
							 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','cbs','".$act."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							
						
				}
				else
				{
						
							if($i==0)
							{
								$sql="SELECT 
								c.dt dt,
								b.act1 act,
								c.act act1,
								c.advname advname,
								c.aid,
								c.aces,
								(c.act / b.act1) * 100 cr
							FROM
								(SELECT 
									COUNT(userlogid) act1, advertiserid aid,date(accesstime) dt,hour(accesstime) aces
								FROM
									".$operator[$i].".userlog
								WHERE
									accesstime >= '".$startdate."'
										AND accesstime <= '".$enddate."'
										
								GROUP BY aces,aid,dt) b
									inner JOIN
								(SELECT 
									COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid aid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate)aces,
										SUM(amount) amt
								FROM
									".$operator[$i].".subscriptiondetail
								LEFT JOIN ".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
								LEFT JOIN ".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$startdate."'
										AND subscriptionstartdate <= '".$enddate."'
										AND amount > 0
										AND isrenew = 0
								GROUP BY aces,userlog.advertiserid,dt) c ON b.aid = c.aid and b.dt=c.dt and c.aces=b.aces
							GROUP BY aces,dt , advname order by aces asc";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>11=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['cr'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['aid'];
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','gamebar','Vodafone_Qatar')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							else if($i==1)//idea
							{
									 $sql="
									 SELECT 
									b.dt dt, clicks act, act act1, b.advname advname, (act/clicks)*100 cr,b.aces,b.aid
								FROM
									(SELECT 
										COUNT(txnid) clicks, dt, advname, aid,aces
									FROM
										(SELECT DISTINCT
										txnid,
											userid,
											DATE(accesstime) dt,
											advertiser.advertiserid aid,
											advname,
											hour(accesstime) aces
									FROM
										".$operatorlog[$i].".annonymoustracking
									INNER JOIN ".$operatorlog[$i].".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										accesstime >='".$startdate."'
											AND accesstime <= '".$enddate."'
											) a
									GROUP BY dt , aid,aces) b
										inner JOIN
									(SELECT 
										COUNT(a.act) act, dt, a.aid, a.advname,a.aces
									FROM
										(SELECT DISTINCT
										subscriber.txnid act,
											DATE(subscriptionstartdate) dt,
											advertiser.advertiserid aid,
											advname,
											MAX(accesstime),
											hour(accesstime) aces
											
									FROM
										".$operator[$i].".subscriber
									INNER JOIN ".$operatorlog[$i].".annonymoustracking ON subscriber.msisdn = annonymoustracking.userid
									INNER JOIN ".$operatorlog[$i].".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										subscriptionstartdate >='".$startdate."'
											AND subscriptionstartdate <= '".$enddate."'
											
											AND amount > 0
											AND isrenew=0
									GROUP BY subscriber.txnid,aces) a
									GROUP BY dt , aid,aces) c ON b.dt = c.dt AND b.aid = c.aid and b.aces=c.aces
								GROUP BY c.aces,dt , c.aid
									 
										";
										
										//$result=mysql_query($sql,$con);
										//$row="";
										if($result=mysql_query($sql,$con))
										{
											$count1++;
											//echo "<br>12=".$count1;
										while($row=mysql_fetch_array($result,MYSQL_ASSOC))
										{
											$act=$row['cr'];
											$advertiser=$row['advname'];
											$date2=$row['dt'];
											$advertiserid=$row['aid'];
											$aces=$row['aces'];
											//echo "hi";
											$sql4="INSERT INTO ".$report.".perform_report
											(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','gamebar','ooredoo_oman')  ";
											$result1=mysql_query($sql4);
										
										}
										}
										
							}
							
							/*
							elseif($i==2)
							{
								$sql="SELECT 
										c.dt dt,
										b.act1 act,
										c.act act1,
										CASE
											WHEN c.advname IS NULL THEN 'other'
											ELSE c.advname
										END advname,
										case when (c.act / b.act1) * 100  is NULL THEN 0   
										else (c.act / b.act1) * 100 
										end cr,
										b.aces,
										b.aid
									FROM
										(SELECT 
											COUNT(userlogid) act1, advertiserid aid,hour(accesstime)aces
										FROM
											".$operator[$i].".userlog
										WHERE
											accesstime > '".$startdate."'
												AND accesstime < '".$enddate."'
												
										GROUP BY aid,aces) b
											LEFT JOIN
										(SELECT 
											COUNT(DISTINCT subscriptiondetail.txnid) act,
												userlog.msisdn,
												CASE
													WHEN advname IS NULL THEN 'other'
													ELSE advname
												END advname,
												userlog.advertiserid aid,
												DATE(subscriptionstartdate) dt,
												SUM(amount) amt,
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										LEFT JOIN ".$operator[$i].".userlog ON subscriptiondetail.txnid = userlog.txnid
										LEFT JOIN ".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
										   
												AND amount > 0
												AND isrenew = 0
										GROUP BY advname,aces) c ON b.aid = c.aid and b.aces=c.aces
									GROUP BY aces,dt , advname";
										
								//echo $sql;exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['cr'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['aid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','glambar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								
								}
								
							}
							
							elseif($i==3)
							{
								$sql="SELECT 
										c.dt dt,
										b.act1 act,
										c.act act1,
										CASE
											WHEN c.advname IS NULL THEN 'other'
											ELSE c.advname
										END advname,
										case when (c.act / b.act1) * 100  is NULL THEN 0   
										else (c.act / b.act1) * 100 
										end cr,
										b.aces,
										b.aid
									FROM
										(SELECT 
											COUNT(userlogid) act1, advertiserid aid,hour(accesstime)aces
										FROM
											".$operator[$i].".userlog
										WHERE
											accesstime > '".$startdate."'
												AND accesstime < '".$enddate."'
												
										GROUP BY aid,aces) b
											LEFT JOIN
										(SELECT 
											COUNT(DISTINCT subscriptiondetail.txnid) act,
												userlog.msisdn,
												CASE
													WHEN advname IS NULL THEN 'other'
													ELSE advname
												END advname,
												userlog.advertiserid aid,
												DATE(subscriptionstartdate) dt,
												SUM(amount) amt,
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".subscriptiondetail
										LEFT JOIN ".$operator[$i].".userlog ON subscriptiondetail.txnid = userlog.txnid
										LEFT JOIN ".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
										   
												AND amount > 0
												AND isrenew = 0
										GROUP BY advname,aces) c ON b.aid = c.aid and b.aces=c.aces
									GROUP BY aces,dt , advname";
										
								//echo $sql;exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['cr'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['aid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','gamebar','airtel_india')  ";
									$result1=mysql_query($sql4);
								
								}
								
								}
								
							}
							*/
							elseif($i==4)
							{
								$sql="SELECT 
										c.dt dt,
										b.act1 act,
										c.act act1,
										CASE
											WHEN c.advname IS NULL THEN 'other'
											ELSE c.advname
										END advname,
										case when (c.act / b.act1) * 100  is NULL THEN 0   
										else (c.act / b.act1) * 100 
										end cr,
										b.aces,
										b.aid
									FROM
										(SELECT 
											COUNT(userlogid) act1, advertiserid aid,hour(accesstime)aces
										FROM
											".$operatorlog[$i].".userlog
										WHERE
											accesstime > '".$startdate."'
												AND accesstime < '".$enddate."'
												
										GROUP BY aid,aces) b
											LEFT JOIN
										(SELECT 
											COUNT(DISTINCT mo.txnid) act,
												
												CASE
													WHEN advname IS NULL THEN 'other'
													ELSE advname
												END advname,
												mo.advid aid,
												DATE(subscriptionstartdate) dt,
												SUM(amount) amt,
												HOUR(subscriptionstartdate) aces
										FROM
											".$operator[$i].".mo
										
										LEFT JOIN ".$operator[$i].".advertiser ON mo.advid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$startdate."'
												AND subscriptionstartdate <= '".$enddate."'
										   
												AND amount > 0
												AND isrenew = 0
										GROUP BY advname,aces) c ON b.aid = c.aid and b.aces=c.aces
									GROUP BY aces,dt , advname";
										
								//echo $sql;exit;
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['cr'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['aid'];
									$aces=$row['aces'];
									//echo "hi";
									$sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','gamebar','indonesia')  ";
									$result1=mysql_query($sql4);
								
								}
								
								}
								
								
							}
							else if($i==5)
							{
								$sql="SELECT 
								c.dt dt,
								b.act1 act,
								c.act act1,
								c.advname advname,
								c.aid,
								c.aces,
								(c.act / b.act1) * 100 cr
							FROM
								(SELECT 
									COUNT(userlogid) act1, advertiserid aid,date(accesstime) dt,hour(accesstime) aces
								FROM
									".$operator[$i].".userlog
								WHERE
									accesstime >= '".$startdate."'
										AND accesstime <= '".$enddate."'
										
								GROUP BY aces,aid,dt) b
									inner JOIN
								(SELECT 
									COUNT(DISTINCT subscriptiondetail.reqid) act,
										userlog.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										userlog.advertiserid aid,
										DATE(subscriptionstartdate) dt,
										hour(subscriptionstartdate)aces,
										SUM(amount) amt
								FROM
									".$operator[$i].".subscriptiondetail
								LEFT JOIN ".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
								LEFT JOIN ".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$startdate."'
										AND subscriptionstartdate <= '".$enddate."'
										AND amount > 0
										AND isrenew = 0
								GROUP BY aces,userlog.advertiserid,dt) c ON b.aid = c.aid and b.dt=c.dt and c.aces=b.aces
							GROUP BY aces,dt , advname order by aces asc";
										
								
								//$result=mysql_query($sql,$con);
								//$row="";
								if($result=mysql_query($sql,$con))
								{
									$count1++;
									//echo "<br>11=".$count1;
								while($row=mysql_fetch_array($result,MYSQL_ASSOC))
								{
									$act=$row['cr'];
									$advertiser=$row['advname'];
									$date2=$row['dt'];
									$advertiserid=$row['aid'];
									$aces=$row['aces'];
									//echo "hi";
								 $sql4="INSERT INTO ".$report.".perform_report
									(`date`, `hour`, `advertiser`,`advertiserid`, `type`, `count`,`product`,`operator`) values('".$date1."','".$aces."','".$advertiser."','".$advertiserid."','callbackrate','".$act."','gamebar','vodafone_egypt')  ";
									$result1=mysql_query($sql4);
								
								}
								}
							}
							
							
				}
			
		
		}
		

	}
	echo $count1;
	if($count1>=13)
	{
		$performcount=1;
		// $sql="update gamebardb_vodafone_qatar.cron_report set cron_perform=".$performcount." where date='".$date1."'";
		$cur_date=date('Y-m-d H-i:s');
			$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=".$performcount.", date='".$cur_date."' where cron_name='cron_perform'";
			$result = mysql_query($sql) ;
	}

?>