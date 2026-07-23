<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");

//$con=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back
//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
$con1=$con;


/*
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
*/

$sum=0;
$start_date='';
$end_date='';
$start_date1='';
$end_date1='';
$operator='';
$product='';
$count=0;
$display='';

if(isset($_POST['submit']))
{

$count=1;
$operator=$_POST['operator'];
$product=$_POST['product'];




	$count=1;
	$operator=$_POST['operator'];
	$product=$_POST['product'];
	$date1=date('Y-m-d');
	$advertiserid=$_POST['advertiserid']; 

	//$hours=$_POST['hours'];
	//$display=$_POST['display']; 

	$b=$c=0;
	if($start_date == $end_date)
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}	
	else
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}
	
	if($end_date1 == $date1 && $start_date1 == $date1)
	{
		$c=1;//currentdate
	}
	elseif($end_date1 == $date1 && $start_date1 != $date1)
	{
		
		$b=1;
		$c=1;
	}
	else{
		
		$b=1;
	}
		if($product=='gamebar')
		{
			
			if($operator=='Vodafone_Qatar')
			{
				$db='gamebardb_vodafone_qatar';
				$report='gamebardb_vodafone_qatar_report';
				//$dblog='hotshotsdblog1';
			}
			elseif($operator=='ooredoo_oman')
			{
				$db='gamesdb_ooredoo_oman';
				$dblog='gamesdblog_ooredoo_oman';
				$report='gamebardb_vodafone_qatar_report';
			}	
			else if ($operator=='airtel_india')
			{
				$db='gamebardb_airtel';
				$dblog='';
				$report='gamebardb_vodafone_qatar_report';
			}
			else if ($operator=='indonesia')
			{
				$db='gamebardb_indonesia';
				$dblog='gamebardblog_indonesia';
				$report='gamebardb_vodafone_qatar_report';
			}
			else if($operator =='south-africa')
			{
				$db="fashionbardb_africa";
				$report="gamebardb_vodafone_qatar_report";
				$dblog='gamebarbardb_africa';
			}
			elseif ($operator=='spain')
			{
				$c=1;
				$db="gamebardb_spain";
				$dblog="gamebardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				
			}
			elseif ($operator=='vodafone')
			{
				$c=1;
				$db="gamebardb_svmobi";
				//$dblog="gamebardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				
			}
			else if($operator=='gamezone_vodafone')
			{
				$db="gamesnewdb_voda";
				$report="gamebardb_vodafone_qatar_report";
				
				
			}	
			
		/*	
			else{
				$db='hotshotsnewdb_idea_0717';
			}*/
			
		}
		else{
			
			if ($operator=='airtel_india')
			{
				$db='funzonedb_airtel';
				$dblog='';
				$report='gamebardb_vodafone_qatar_report';
				
			}
			else if($operator =='south-africa')
			{
				$db='fashionbardb_africa';
				$dblog='';
				$report='gamebardb_vodafone_qatar_report';
			}
			elseif ($operator=='spain')
			{
				$c=1;
				$db="fashionbardb_spain";
				$dblog="fashionbardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				
			}
			elseif ($operator=='vodafone')
			{
				$c=1;
				$db="fashionbardb_svmobi";
				//$dblog="gamebardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				
			}
			
			else if($operator=='hotshots_vodafone')
			{
				$db="hotshotsnewdb_voda_0617";
				$report="gamebardb_vodafone_qatar_report";
				
				$sql_ad="select * from ".$db.".advertiser";
				$res_ad=mysqli_query($con,$sql_ad);
				
			}
		}


//echo $product;
// report logic below
	if($product=='gamebar' || $product=='Gamebar')
	{
		
		if($b==1)
			{
			
					if($advertiserid=='all')
					{
						$sql="SELECT * 
							FROM ".$report.".`report_partner_tracking` 
							WHERE DATE >= '".$start_date1."'
							AND DATE <=  '".$end_date1."' and operator='".$operator."' and product='".$product."'";
						//echo $sql;exit;
						$res2=mysql_query($sql,$con1);
						
					}
					else{
						$sql="SELECT * 
							FROM ".$report.".`report_partner_tracking` 
							WHERE DATE >= '".$start_date1."'
							AND DATE <=  '".$end_date1."' and advertiserid='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
						//echo $sql;exit;
						$res2=mysql_query($sql,$con1);	
						
					}
			}
		if($c==1)
			{
						
				if($operator=='Vodafone_Qatar')
				{
					
					//$db="hotshotsdb1";
				//	$dblog="hotshotsdblog1";
					//$db='hotshotsnewdb_voda_0617';
					$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					
					$sql_ad="select * from ".$db.".advertiser where operator=1 ";
					$res_ad=mysql_query($sql_ad,$con1);
					
					
					
					
					if($advertiserid != 'all')
					{
						
						
						
					 $sql_track="SELECT 
											bb.dt dt,
											adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													SUM(amount) total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(accesstime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$db.".userlog
											INNER JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
											WHERE
												accesstime >= '".$start_date."'
													AND accesstime <= '".$end_date."'
													AND userlog.advertiserid = '".$advertiserid."') a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												COUNT(b.act) act, dt, advname, SUM(amount) amount, typ
											FROM
												(SELECT DISTINCT
												subscriptiondetail.reqid act,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount,
													1 typ,
													MAX(userlogid)
											FROM
												".$db.".subscriptiondetail
											INNER JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >= '".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													AND DATE(accesstime) = DATE(subscriptionstartdate)
													AND amount > 0
													AND isrenew = 0
													AND userlog.advertiserid = '".$advertiserid."'
											GROUP BY subscriptiondetail.reqid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriptiondetail.reqid spo,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount,
													MAX(userlogid)
											FROM
												".$db.".subscriptiondetail
											INNER JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >='".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													AND DATE(accesstime) < DATE(subscriptionstartdate)
													AND amount > 0
													AND isrenew = 0
													AND userlog.advertiserid = '".$advertiserid."'
											GROUP BY subscriptiondetail.reqid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												txnid cbs, DATE(senttime) dt, advname
											FROM
												".$db.".advertcallback
											INNER JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
											WHERE
												senttime >= '".$start_date."'
													AND senttime <= '".$end_date."'
													AND advertcallback.advertiserid = '".$advertiserid."') aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;
											
										   ";
										  
										  
					}
					else
					{
					//all	
					 $sql_track="SELECT 
									bb.dt dt,
									CASE
										WHEN adv1 IS NULL THEN 'other'
										ELSE adv1
									END adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											SUM(amount) total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											CASE
												WHEN advname IS NULL THEN 'other'
												ELSE advname
											END advname,
											advertiser.advertiserid
									FROM
										".$db.".userlog
									LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."') a
									GROUP BY dt , advname) b
									LEFT JOIN (SELECT 
										COUNT(reqid) act, dt, advname, SUM(amount) amount, typ,advertiserid
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid,
										userlog.msisdn,
											CASE
												WHEN advname IS NULL THEN 'other'
												ELSE advname
											END advname,
											userlog.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount,
											1 typ,
											MAX(userlogid)
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								   where subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and date(accesstime)=date(subscriptionstartdate)
											AND amount > 0
											AND isrenew = 0
									GROUP BY subscriptiondetail.txnid
									) b
									GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m UNION SELECT 
										dt,
											CASE
												WHEN advname IS NULL THEN 'other'
												ELSE advname
											END adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid spo,
											advname,
											CASE
												WHEN advertiser.advertiserid IS NULL THEN - 1
												ELSE advertiser.advertiserid
											END advertiserid,
											DATE(subscriptionstartdate) dt,
											amount,
											MAX(userlogid)
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											AND DATE(accesstime) < DATE(subscriptionstartdate)
											AND amount > 0
											AND isrenew = 0
									GROUP BY subscriptiondetail.reqid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(
										SELECT DISTINCT
										txnid cbs, DATE(senttime) dt, advname
									FROM
										".$db.".advertcallback
									LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
									WHERE
										senttime >= '".$start_date."'
											AND senttime <= '".$end_date."') aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1";
																						   
											}
					//echo $sql_track;
					$res_track=mysql_query($sql_track,$con1);
					
				}
				else if($operator=='ooredoo_oman')
				{
					$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					
					$sql_ad="select * from ".$dblog.".advertiser where operator=1 ";
					$res_ad=mysql_query($sql_ad,$con1);
					if($advertiserid != 'all')
					{
							$sql_track="SELECT 
										dt,
										adv1,
										clicks,
										act,
										actsp spo,
										total_amount,
										total_amount1,
										cbs
									FROM
										(SELECT 
											COUNT(*) clicks,
												DATE(accesstime) dt,
												advertiser.advname adv1
										FROM
											gamesdblog_ooredoo_oman.annonymoustracking
										INNER JOIN gamesdblog_ooredoo_oman.advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											accesstime >= '2017-09-22 00:00:00'
												AND accesstime < '2017-09-22 23:59:59'
												 and annonymoustracking.advertiserid =".$advertiserid."
										GROUP BY dt , adv1) a
											LEFT JOIN
										(SELECT 
											COUNT(msisdn) act, SUM(amount) total_amount, sdt, adv2
										FROM
											(SELECT DISTINCT
											msisdn, amount, sdt, DATE(accesstime) acsdt, adv2
										FROM
											gamesdblog_ooredoo_oman.annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												amount,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv2
										FROM
											gamesdb_ooredoo_oman.subscriber
										INNER JOIN gamesdblog_ooredoo_oman.annonymoustracking ON msisdn = userid
										INNER JOIN gamesdblog_ooredoo_oman.advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '2017-09-22 00:00:00'
												AND subscriptionstartdate < '2017-09-22 23:59:59'
												AND isrenew = 0
												AND amount > 0
												AND DATE(accesstime) = DATE(subscriptionstartdate)
												AND annonymoustracking.advertiserid =".$advertiserid."
												
												AND accesstime >= '2017-09-22 00:00:00'
												AND accesstime < '2017-09-22 23:59:59'
										GROUP BY subscriber.subscriberid , sdt , adv2) aa ON aa.atid = annonymoustrackingid) bb
										GROUP BY sdt , adv2) b ON a.dt = b.sdt AND a.adv1 = b.adv2
											LEFT JOIN
										(SELECT 
											COUNT(*) actsp,
												SUM(u.amount) total_amount1,
												u.sdt dt22,
												u.adv4
										FROM
											(SELECT DISTINCT
											msisdn, sdt, DATE(accesstime) acsdt, adv3
										FROM
											gamesdblog_ooredoo_oman.annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv3
										FROM
											gamesdb_ooredoo_oman.subscriber
										INNER JOIN gamesdblog_ooredoo_oman.annonymoustracking ON msisdn = userid
										INNER JOIN gamesdblog_ooredoo_oman.advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '2017-09-22 00:00:00'
												AND subscriptionstartdate < '2017-09-22 23:59:59'
												AND isrenew = 0
												AND amount > 0
												
												AND DATE(accesstime) = DATE(subscriptionstartdate)
												AND annonymoustracking.advertiserid =".$advertiserid."
												AND accesstime >= '2017-09-22 00:00:00'
												AND accesstime < '2017-09-22 23:59:59'
										GROUP BY subscriber.subscriberid , sdt , adv3) a ON a.atid = annonymoustrackingid) x
										RIGHT JOIN (SELECT DISTINCT
											msisdn, amount, sdt, DATE(accesstime) acsdt, adv4
										FROM
											gamesdblog_ooredoo_oman.annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												amount,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv4
										FROM
											gamesdb_ooredoo_oman.subscriber
										INNER JOIN gamesdblog_ooredoo_oman.annonymoustracking ON msisdn = userid
										INNER JOIN gamesdblog_ooredoo_oman.advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '2017-09-22 00:00:00'
												AND subscriptionstartdate < '2017-09-22 23:59:59'
												AND isrenew = 0
												AND amount > 0
												
												AND annonymoustracking.advertiserid =".$advertiserid."
												AND accesstime >= SUBDATE('2017-09-22 00:00:00', INTERVAL 7 DAY)
												AND accesstime < '2017-09-22 23:59:59'
										GROUP BY subscriber.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.msisdn = u.msisdn
										GROUP BY dt22 , adv4) c ON b.sdt = c.dt22 AND b.adv2 = c.adv4
											LEFT JOIN
										(SELECT 
											COUNT(*) cbs, DATE(requesttime) dt3, advertiser.advname adv5
										FROM
											gamesdb_ooredoo_oman.requestresponse
										INNER JOIN gamesdblog_ooredoo_oman.advertiser ON advertiser.advertiserid = requestresponse.advertiserid
										WHERE
											requesttime >= '2017-09-22 00:00:00'
												AND requesttime < '2017-09-22 23:59:59'
												and advertiser.advertiserid=".$advertiserid."
										GROUP BY dt3 , adv5) d ON c.dt22 = d.dt3 AND c.adv4 = d.adv5
									GROUP BY dt , adv1
									"; 
					}
					else
					{
						   $sql_track="SELECT 
										dt,
										adv1,
										clicks,
										act,
										actsp spo,
										total_amount,
										total_amount1,
										cbs
									FROM
										(SELECT 
											COUNT(*) clicks,
												DATE(accesstime) dt,
												advertiser.advname adv1
										FROM
											".$dblog.".annonymoustracking
										INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											accesstime >= '".$start_date."'
												AND accesstime < '".$end_date."'
												AND operator = 1
										GROUP BY dt , adv1) a
											left JOIN
										(SELECT 
											COUNT(msisdn) act, SUM(amount) total_amount, sdt, adv2
										FROM
											(SELECT DISTINCT
											msisdn, amount, sdt, DATE(accesstime) acsdt, adv2
										FROM
											".$dblog.".annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												amount,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv2
										FROM
											".$db.".subscriber 
										INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
										INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$start_date."'
												AND subscriptionstartdate < '".$end_date."'
												AND isrenew = 0
												AND amount > 0
												AND DATE(accesstime) = DATE(subscriptionstartdate)
												AND annonymoustracking.advertiserid > - 1
												AND operator = 1
												AND accesstime >= '".$start_date."'
												AND accesstime < '".$end_date."'
										GROUP BY subscriber.subscriberid , sdt , adv2) aa ON aa.atid = annonymoustrackingid) bb
										GROUP BY sdt , adv2) b ON a.dt = b.sdt AND a.adv1 = b.adv2
											left JOIN
										(SELECT 
											COUNT(*) actsp,
												SUM(u.amount) total_amount1,
												u.sdt dt22,
												u.adv4
										FROM
											(SELECT DISTINCT
											msisdn, sdt, DATE(accesstime) acsdt, adv3
										FROM
											".$dblog.".annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv3
										FROM
											".$db.".subscriber 
										INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
										INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$start_date."'
												AND subscriptionstartdate < '".$end_date."'
												AND isrenew = 0
												AND amount > 0
												AND operator = 1
												AND DATE(accesstime) = DATE(subscriptionstartdate)
												AND annonymoustracking.advertiserid > - 1
												AND accesstime >= '".$start_date."'
												AND accesstime < '".$end_date."'
										GROUP BY subscriber.subscriberid , sdt , adv3) a ON a.atid = annonymoustrackingid) x
										RIGHT JOIN (SELECT DISTINCT
											msisdn, amount, sdt, DATE(accesstime) acsdt, adv4
										FROM
											".$dblog.".annonymoustracking
										INNER JOIN (SELECT 
											msisdn,
												DATE(subscriptionstartdate) sdt,
												amount,
												MAX(annonymoustrackingid) atid,
												advertiser.advname adv4
										FROM
											 ".$db.".subscriber 
										INNER JOIN ".$dblog.".annonymoustracking ON msisdn = userid
										INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$start_date."'
												AND subscriptionstartdate < '".$end_date."'
												AND isrenew = 0
												AND amount > 0
												AND operator = 1
												AND annonymoustracking.advertiserid > - 1
												AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
												AND accesstime < '".$end_date."'
										GROUP BY subscriber.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.msisdn = u.msisdn
										GROUP BY dt22 , adv4) c ON b.sdt = c.dt22 AND b.adv2 = c.adv4
											left JOIN
										(SELECT 
											COUNT(*) cbs, DATE(requesttime) dt3, advertiser.advname adv5
										FROM
											".$db.".requestresponse
										INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
										WHERE
											requesttime >= '".$start_date."'
												AND requesttime < '".$end_date."'
										GROUP BY dt3 , adv5) d ON c.dt22 = d.dt3 AND c.adv4 = d.adv5
									GROUP BY dt , adv1";
					
					}  
					
					
				}
			
				elseif ($operator=='airtel_india')
				{
					//$db="hotshotsdb_airtel1";
					//$dblog="hotshotsdblog_airtel1";
					$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							$sql_track="SELECT 
								bb.dt dt,
								adv1,
								SUM(clicks) clicks,
								SUM(act) act,
								SUM(total_amount) total_amount,
								SUM(spo) spo,
								SUM(spamount) total_amount1,
								cbs
							FROM
								(SELECT 
									dt,
										adv1,
										clicks,
										CASE
											WHEN typ = 1 THEN act
											ELSE 0
										END act,
										CASE
											WHEN typ = 1 THEN total_amount
											ELSE 0
										END total_amount,
										CASE
											WHEN typ = 2 THEN act
											ELSE 0
										END spo,
										CASE
											WHEN typ = 2 THEN total_amount
											ELSE 0
										END spamount
								FROM
									(SELECT 
									dt, adv1, clicks, act, typ, total_amount
								FROM
									(SELECT 
									b.dt dt,
										b.advname adv1,
										clicks,
										act,
										typ,
										SUM(amount) total_amount
								FROM
									(SELECT 
									COUNT(msisdn) clicks, dt, advname
								FROM
									(SELECT 
									msisdn,
										DATE(accesstime) dt,
										advname,
										advertiser.advertiserid
								FROM
									".$db.".userlog
								INNER JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND userlog.advertiserid = ".$advertiserid.") a
								GROUP BY dt , advname) b
								LEFT JOIN (SELECT 
									COUNT(b.act) act, dt, advname, SUM(amount) amount, typ
								FROM
									(SELECT count(DISTINCT subscriptiondetail.txnid) act,
										userlog.msisdn,
										accesstime,
										sum(amount) amount,
										advname,
										1 typ,
										advertcallback.advertiserid,
										date(subscriptionstartdate) dt,
										max(userlogid)
								FROM
									".$db.".subscriptiondetail
							   left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
								inner join ".$db.".advertcallback on subscriptiondetail.txnid = advertcallback.txnid 
								inner JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										and date(subscriptionstartdate) = date(accesstime)
										and accesstime >= SUBDATE('".$start_date."',INTERVAL 7 DAY)
										AND amount > 0
										AND isrenew = 0
										AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
										AND subscriptiondetail.errorcode = 1000
										AND userlog.advertiserid = ".$advertiserid."
								GROUP BY subscriptiondetail.txnid) b
								GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
								GROUP BY dt , adv1) m UNION SELECT 
									dt,
										advname adv1,
										0 clicks,
										COUNT(a.spo) act,
										2 typ,
										SUM(amount) total_amount
								FROM
									(SELECT DISTINCT
									subscriptiondetail.txnid spo,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										amount,
										MAX(userlogid)
								FROM
									".$db.".subscriptiondetail
								INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
								INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND DATE(accesstime) < DATE(subscriptionstartdate)
									   AND amount > 0
										AND isrenew = 0
										AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
										AND subscriptiondetail.errorcode = 1000
										AND userlog.advertiserid = ".$advertiserid."
								GROUP BY subscriptiondetail.txnid) a
								GROUP BY dt , advname) aa) bb
									LEFT JOIN
								(SELECT 
									COUNT(cbs) cbs, dt, advname
								FROM
									(SELECT DISTINCT
									txnid cbs, DATE(senttime) dt, advname
								FROM
									".$db.".advertcallback
								INNER JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
								WHERE
									senttime >= '".$start_date."'
										AND senttime <= '".$end_date. "'  
										AND advertcallback.advertiserid = ".$advertiserid.") aa1
								GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
							GROUP BY dt , adv1"; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
					 $sql_track="SELECT 
								bb.dt dt,
								CASE
									WHEN adv1 IS NULL THEN 'other'
									ELSE adv1
								END adv1,
								SUM(clicks) clicks,
								SUM(act) act,
								SUM(total_amount) total_amount,
								SUM(spo) spo,
								SUM(spamount) total_amount1,
								cbs
							FROM
								(SELECT 
									dt,
										adv1,
										clicks,
										CASE
											WHEN typ = 1 THEN act
											ELSE 0
										END act,
										CASE
											WHEN typ = 1 THEN total_amount
											ELSE 0
										END total_amount,
										CASE
											WHEN typ = 2 THEN act
											ELSE 0
										END spo,
										CASE
											WHEN typ = 2 THEN total_amount
											ELSE 0
										END spamount
								FROM
									(SELECT 
									dt, adv1, clicks, act, typ, total_amount
								FROM
									(SELECT 
									b.dt dt,
										b.advname adv1,
										clicks,
										act,
										typ,
										amount total_amount
								FROM
									(SELECT 
									COUNT(msisdn) clicks, dt, advname
								FROM
									(SELECT 
									msisdn,
										DATE(accesstime) dt,
										advname,
										advertiser.advertiserid
								FROM
									".$db.".userlog
								LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."') a
								GROUP BY dt , advname) b
								LEFT JOIN (
								
								
								
								SELECT 
									act, dt, advname, amount, typ
								FROM
									(
									
									
									SELECT count(DISTINCT subscriptiondetail.txnid) act,
										userlog.msisdn,
										accesstime,
										sum(amount) amount,
										advname,
										1 typ,
										advertcallback.advertiserid,
										date(subscriptionstartdate) dt,
										max(userlogid)
								FROM
									".$db.".subscriptiondetail
							   left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
								inner join ".$db.".advertcallback on subscriptiondetail.txnid = advertcallback.txnid 
								inner JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										and date(subscriptionstartdate) = date(accesstime)
										and accesstime >= SUBDATE('".$start_date."',INTERVAL 7 DAY)
										AND amount > 0
										AND isrenew = 0
										AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
										AND subscriptiondetail.errorcode = 1000
										
								GROUP BY advname order by msisdn
								
								
								) b
								GROUP BY dt , advname
								
								
								
								
								) c ON b.dt = c.dt AND b.advname = c.advname
								GROUP BY dt , adv1) m UNION SELECT 
									dt,
										advname adv1,
										0 clicks,
										COUNT(a.spo) act,
										2 typ,
										SUM(amount) total_amount
								FROM
									(SELECT DISTINCT
									subscriptiondetail.txnid spo,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										amount,
										MAX(userlogid)
								FROM
									".$db.".subscriptiondetail
								LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
								LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND DATE(accesstime) < DATE(subscriptionstartdate)
										AND amount > 0
										AND isrenew = 0
										AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
										AND subscriptiondetail.errorcode = 1000
									   
								GROUP BY subscriptiondetail.txnid) a
								GROUP BY dt , advname) aa) bb
									LEFT JOIN
								(SELECT 
									COUNT(cbs) cbs, dt, advname
								FROM
									(SELECT DISTINCT
									txnid cbs, DATE(senttime) dt, advname
								FROM
									".$db.".advertcallback
								LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
								WHERE
									senttime >= '".$start_date."'
										AND senttime <= '".$end_date."'  ) aa1
								GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
							GROUP BY dt , adv1;
						";
					}
					$res_track=mysql_query($sql_track,$con1);	
							
				}
				else if ($operator=='indonesia')
				{
					
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							   $sql_track="SELECT 
									bb.dt dt,
									CASE
										WHEN adv1 IS NULL THEN 'other'
										ELSE adv1
									END adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											amount total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											advname,
											advertiser.advertiserid
									FROM
										".$dblog.".userlog
									LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."'
											and userlog.advertiserid='".$advertiserid."') a
									GROUP BY dt , advname) b
									LEFT JOIN (SELECT 
										act, dt, advname, amount, typ
									FROM
										(SELECT 
										COUNT(DISTINCT mo.clickid) act,
											SUM(amount) amount,
											advname,
											1 typ,
											DATE(subscriptionstartdate) dt
										   
									FROM
										".$db.".mo
									
									INNER JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and advid='".$advertiserid."'
											AND amount > 0
											AND charging_mode = 'ACT'
											and pull_tid  is not null
									GROUP BY advname
									ORDER BY clickid) b
									GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m 
									UNION SELECT 
										dt,
											advname adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										mo.clickid spo,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount
										   
									FROM
										".$db.".mo
									
									LEFT JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and pull_tid is null
											AND amount > 0
											AND charging_mode = 'ACT'
											and advid='".$advertiserid."'
										   
									GROUP BY mo.clickid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(SELECT DISTINCT
										clickid cbs, DATE(requesttime ) dt, advname
									FROM
										".$db.".callbackresponse
									LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
									WHERE
										requesttime  >= '".$start_date."'
											AND requesttime  <= '".$end_date."'
											and issent=1
											and callbackresponse.advertiserid='".$advertiserid."') aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1;"; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
					  $sql_track="SELECT 
									bb.dt dt,
									CASE
										WHEN adv1 IS NULL THEN 'other'
										ELSE adv1
									END adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											amount total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											advname,
											advertiser.advertiserid
									FROM
										".$dblog.".userlog
									LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."') a
									GROUP BY dt , advname) b
									LEFT JOIN (SELECT 
										act, dt, advname, amount, typ
									FROM
										(SELECT 
										COUNT(DISTINCT mo.clickid) act,
											SUM(amount) amount,
											advname,
											1 typ,
											DATE(subscriptionstartdate) dt
										   
									FROM
										".$db.".mo
									
									INNER JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											
											AND amount > 0
											AND charging_mode = 'ACT'
											and pull_tid  is not null
									GROUP BY advname
									ORDER BY clickid) b
									GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m 
									UNION SELECT 
										dt,
											advname adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										mo.clickid spo,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount
										   
									FROM
										".$db.".mo
									
									LEFT JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and pull_tid is null
											AND amount > 0
											AND charging_mode = 'ACT'
										   
									GROUP BY mo.clickid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(SELECT DISTINCT
										clickid cbs, DATE(requesttime ) dt, advname
									FROM
										".$db.".callbackresponse
									LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
									WHERE
										requesttime  >= '".$start_date."'
											AND requesttime  <= '".$end_date."'
											and issent=1) aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1;
						";
					}
					$res_track=mysql_query($sql_track,$con1);
					
					
					
					
					
				}
				else if($operator=='south-africa')
				{
					$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							    $sql_track="SELECT 
											bb.dt dt,
											CASE
												WHEN adv1 IS NULL THEN 'other'
												ELSE adv1
											END adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													amount total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(accesstime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$dblog.".userlog
											LEFT JOIN ".$dblog.".advertiser ON advertiser.advertiserid = userlog.advertiserid
											WHERE
												accesstime >= '".$start_date."'
													AND accesstime <= '".$end_date."'
													and userlog.advertiserid='".$advertiserid."') a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												act, dt, advname, amount, typ
											FROM
												(SELECT 
												COUNT(DISTINCT subscriptiondetail.clickid) act,
													SUM(amount) amount,
													advname,
													1 typ,
													DATE(subscriptionstartdate) dt
											FROM
												".$db.".subscriptiondetail
											INNER JOIN ".$dblog.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
											inner join ".$dblog.".userlog on subscriptiondetail.clickid=userlog.clickid
											WHERE
												subscriptionstartdate >= '".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													AND amount > 0
													AND charging_mode = 'ACT'
													and campaignid='43955'
													and advid='".$advertiserid."'
												   and date(userlog.accesstime)=date(subscriptionstartdate)
											GROUP BY advname
											ORDER BY subscriptiondetail.clickid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriptiondetail.clickid spo,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount
											FROM
												".$db.".subscriptiondetail
												INNER join ".$dblog.".userlog on subscriptiondetail.clickid=userlog.clickid
											inner JOIN ".$dblog.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >= '".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													and date(userlog.accesstime)!=date(subscriptionstartdate)
													and campaignid='43955'
													AND amount > 0
													AND charging_mode = 'ACT'
													and advid='".$advertiserid."'
											GROUP BY subscriptiondetail.clickid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												clickid cbs, DATE(requesttime) dt, advname
											FROM
												".$db.".callbackresponse
											LEFT JOIN ".$dblog.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
											WHERE
												requesttime >= '".$start_date."'
													AND requesttime <= '".$end_date."'
													AND issent = 1
													and campaignid='43955'
													and callbackresponse.advertiserid='".$advertiserid."') aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;"; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
					  $sql_track="SELECT 
									bb.dt dt,
									CASE
										WHEN adv1 IS NULL THEN 'other'
										ELSE adv1
									END adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											amount total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											advname,
											advertiser.advertiserid
									FROM
										".$dblog.".userlog
									LEFT JOIN ".$dblog.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."'
											) a
									GROUP BY dt , advname) b
									LEFT JOIN (SELECT 
										act, dt, advname, amount, typ
									FROM
										(SELECT 
										COUNT(DISTINCT subscriptiondetail.clickid) act,
											SUM(amount) amount,
											advname,
											1 typ,
											DATE(subscriptionstartdate) dt
									FROM
										".$db.".subscriptiondetail
									left JOIN ".$dblog.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
									left JOIN ".$dblog.".userlog ON subscriptiondetail.clickid = userlog.clickid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											AND amount > 0
											AND charging_mode = 'ACT'
											AND campaignid = '43955'
											
											AND DATE(userlog.accesstime) = DATE(subscriptionstartdate)
									GROUP BY advname
									ORDER BY subscriptiondetail.clickid) b
									GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m UNION SELECT 
										dt,
											advname adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										subscriptiondetail.clickid spo,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount
									FROM
										".$db.".subscriptiondetail
									left JOIN ".$dblog.".userlog ON subscriptiondetail.clickid = userlog.clickid
									left JOIN ".$dblog.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											AND DATE(userlog.accesstime) != DATE(subscriptionstartdate)
											AND campaignid = '43955'
											AND amount > 0
											AND charging_mode = 'ACT'
											
									GROUP BY subscriptiondetail.clickid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(SELECT DISTINCT
										clickid cbs, DATE(requesttime) dt, advname
									FROM
										".$db.".callbackresponse
									LEFT JOIN ".$dblog.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
									WHERE
										requesttime >= '".$start_date."'
											AND requesttime <= '".$end_date."'
											AND issent = 1
											AND campaignid = '43955'
										   ) aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1;
						";
					}
					$res_track=mysql_query($sql_track,$con1);
					
					
					
					
					
				}
				
				else if($operator=='spain')
				{
					//$start_date=date('Y-m-d')." 00:00:00";
					//$end_date=date('Y-m-d')." 23:59:59";
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							    $sql_track="SELECT 
												bb.dt dt,
												CASE
													WHEN adv1 IS NULL THEN 'other'
													ELSE adv1
												END adv1,
												SUM(clicks) clicks,
												SUM(act) act,
												SUM(total_amount) total_amount,
												SUM(spo) spo,
												SUM(spamount) total_amount1,
												cbs
											FROM
												(SELECT 
													dt,
														adv1,
														clicks,
														CASE
															WHEN typ = 1 THEN act
															ELSE 0
														END act,
														CASE
															WHEN typ = 1 THEN total_amount
															ELSE 0
														END total_amount,
														CASE
															WHEN typ = 2 THEN act
															ELSE 0
														END spo,
														CASE
															WHEN typ = 2 THEN total_amount
															ELSE 0
														END spamount
												FROM
													(SELECT 
													dt, adv1, clicks, act, typ, total_amount
												FROM
													(SELECT 
													b.dt dt,
														b.advname adv1,
														clicks,
														act,
														typ,
														amount total_amount
												FROM
													(SELECT 
													COUNT(msisdn) clicks, dt, advname
												FROM
													(SELECT 
													msisdn,
														DATE(accesstime) dt,
														advname,
														advertiser.advertiserid
												FROM
													".$dblog.".userlog
												LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
												WHERE
													accesstime >=  '".$start_date."'
														AND accesstime <=  '".$end_date."'
														and userlog.advertiserid='".$advertiserid."') a
												GROUP BY dt , advname) b
												LEFT JOIN (SELECT 
													act, dt, advname, amount, typ
												FROM
													(SELECT 
													COUNT(DISTINCT subscriber.clickid) act,
														SUM(amount) amount,
														advname,
														1 typ,
														DATE(subscriprion_startdate) dt
												FROM
													".$db.".subscriber
												LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
												LEFT JOIN ".$dblog.".userlog ON subscriber.clickid = userlog.clickid
												WHERE
													subscriprion_startdate >=  '".$start_date."'
														AND subscriprion_startdate <=  '".$end_date."'
														AND amount > 0
														AND charging_mode = 'ACT'
														and advid='".$advertiserid."'
														AND DATE(userlog.accesstime) = DATE(subscriprion_startdate)
												GROUP BY advname,dt
												ORDER BY subscriber.clickid) b
												GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
												GROUP BY dt , adv1) m UNION SELECT 
													dt,
														advname adv1,
														0 clicks,
														COUNT(a.spo) act,
														2 typ,
														SUM(amount) total_amount
												FROM
													(SELECT DISTINCT
													subscriber.clickid spo,
														advname,
														advertiser.advertiserid,
														DATE(subscriprion_startdate) dt,
														amount
												FROM
													".$db.".subscriber
												LEFT JOIN ".$dblog.".userlog ON subscriber.clickid = userlog.clickid
												LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
												WHERE
													subscriprion_startdate >=  '".$start_date."'
														AND subscriprion_startdate <=  '".$end_date."'
														AND DATE(userlog.accesstime) != DATE(subscriprion_startdate)
													   
														AND amount > 0
														AND charging_mode = 'ACT'
														and advid='".$advertiserid."'
												GROUP BY subscriber.clickid) a
												GROUP BY dt , advname) aa) bb
													LEFT JOIN
												(SELECT 
													COUNT(cbs) cbs, dt, advname
												FROM
													(SELECT DISTINCT
													clickid cbs, DATE(requesttime) dt, advname
												FROM
													".$db.".callbackresponse
												LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
												WHERE
													requesttime >=  '".$start_date."'
														AND requesttime <=  '".$end_date."'
														AND issent = 1
														and callbackresponse.advertiserid='".$advertiserid."'
													   ) aa1
												GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
											GROUP BY dt , adv1; "; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
						  $sql_track="SELECT 
								bb.dt dt,
								CASE
									WHEN adv1 IS NULL THEN 'other'
									ELSE adv1
								END adv1,
								SUM(clicks) clicks,
								SUM(act) act,
								SUM(total_amount) total_amount,
								SUM(spo) spo,
								SUM(spamount) total_amount1,
								cbs
							FROM
								(SELECT 
									dt,
										adv1,
										clicks,
										CASE
											WHEN typ = 1 THEN act
											ELSE 0
										END act,
										CASE
											WHEN typ = 1 THEN total_amount
											ELSE 0
										END total_amount,
										CASE
											WHEN typ = 2 THEN act
											ELSE 0
										END spo,
										CASE
											WHEN typ = 2 THEN total_amount
											ELSE 0
										END spamount
								FROM
									(SELECT 
									dt, adv1, clicks, act, typ, total_amount
								FROM
									(SELECT 
									b.dt dt,
										b.advname adv1,
										clicks,
										act,
										typ,
										amount total_amount
								FROM
									(SELECT 
									COUNT(msisdn) clicks, dt, advname
								FROM
									(SELECT 
									msisdn,
										DATE(accesstime) dt,
										advname,
										advertiser.advertiserid
								FROM
									".$dblog.".userlog
								LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >=  '".$start_date."'
										AND accesstime <=  '".$end_date."') a
								GROUP BY dt , advname) b
								LEFT JOIN (SELECT 
									act, dt, advname, amount, typ
								FROM
									(SELECT 
									COUNT(DISTINCT subscriber.clickid) act,
										SUM(amount) amount,
										advname,
										1 typ,
										DATE(subscriprion_startdate) dt
								FROM
									".$db.".subscriber
								LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								LEFT JOIN ".$db.".activeuserlog ON subscriber.clickid = activeuserlog.clickid
								WHERE
									subscriprion_startdate >=  '".$start_date."'
										AND subscriprion_startdate <=  '".$end_date."'
										AND amount > 0
										AND charging_mode = 'ACT'
									   
										AND DATE(activeuserlog.accesstime) = DATE(subscriprion_startdate)
								GROUP BY advname,dt
								ORDER BY subscriber.clickid) b
								GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
								GROUP BY dt , adv1) m UNION SELECT 
									dt,
										advname adv1,
										0 clicks,
										COUNT(a.spo) act,
										2 typ,
										SUM(amount) total_amount
								FROM
									(SELECT DISTINCT
									subscriber.clickid spo,
										advname,
										advertiser.advertiserid,
										DATE(subscriprion_startdate) dt,
										amount
								FROM
									".$db.".subscriber
								LEFT JOIN ".$db.".activeuserlog ON subscriber.clickid = activeuserlog.clickid
								LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
									subscriprion_startdate >=  '".$start_date."'
										AND subscriprion_startdate <=  '".$end_date."'
										AND DATE(activeuserlog.accesstime) < DATE(subscriprion_startdate)
									   
										AND amount > 0
										AND charging_mode = 'ACT'
								GROUP BY subscriber.clickid) a
								GROUP BY dt , advname) aa) bb
									LEFT JOIN
								(SELECT 
									COUNT(cbs) cbs, dt, advname
								FROM
									(SELECT DISTINCT
									clickid cbs, DATE(requesttime) dt, advname
								FROM
									".$db.".callbackresponse
								LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
								WHERE
									requesttime >=  '".$start_date."'
										AND requesttime <=  '".$end_date."'
										AND issent = 1
									   ) aa1
								GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
							GROUP BY dt , adv1;  
						";
					}
					$res_track=mysql_query($sql_track,$con1);
					
					
					
					
					
				}
				
				else if($operator=='vodafone')
				{
					//$start_date=date('Y-m-d')." 00:00:00";
					//$end_date=date('Y-m-d')." 23:59:59";
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							    $sql_track="SELECT 
											bb.dt dt,
											CASE
												WHEN adv1 IS NULL THEN 'other'
												ELSE adv1
											END adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													amount total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(requesttime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$db.".requestresponse
											LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
											WHERE
												requesttime >=  '".$start_date."'
													AND requesttime <=  '".$end_date."'
													and requestresponse.advertiserid='".$advertiserid."') a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												act, dt, advname, amount, typ
											FROM
												(SELECT 
												COUNT(DISTINCT subscriber.txnid) act,
													SUM(amount) amount,
													advname,
													1 typ,
													DATE(fromdate) dt
											FROM
												".$db.".subscriber
											LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
											LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
											WHERE
												fromdate >=  '".$start_date."'
													AND fromdate <=  '".$end_date."'
													AND amount > 0
													AND action = 'activation'
													and advertid='".$advertiserid."'
													AND DATE(requestresponse.requesttime) = DATE(fromdate)
											GROUP BY advname , dt
											ORDER BY subscriber.txnid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriber.txnid spo,
													advname,
													advertiser.advertiserid,
													DATE(fromdate) dt,
													amount
											FROM
												".$db.".subscriber
											LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
											LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
											WHERE
												fromdate >=  '".$start_date."'
													AND fromdate <=  '".$end_date."'
													AND DATE(requestresponse.requesttime) != DATE(fromdate)
													AND amount > 0
													AND action = 'activation'
													and advertid='".$advertiserid."'
											GROUP BY subscriber.txnid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												msisdn cbs, DATE(senttime) dt, advname
											FROM
												".$db.".advertcallback
											LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
											WHERE
												senttime >=  '".$start_date."'
													AND senttime <=  '".$end_date."'
													AND action = 'act'
													and advertiser.advertiserid='".$advertiserid."') aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;"; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
						 $sql_track="SELECT 
										bb.dt dt,
										CASE
											WHEN adv1 IS NULL THEN 'other'
											ELSE adv1
										END adv1,
										SUM(clicks) clicks,
										SUM(act) act,
										SUM(total_amount) total_amount,
										SUM(spo) spo,
										SUM(spamount) total_amount1,
										cbs
									FROM
										(SELECT 
											dt,
												adv1,
												clicks,
												CASE
													WHEN typ = 1 THEN act
													ELSE 0
												END act,
												CASE
													WHEN typ = 1 THEN total_amount
													ELSE 0
												END total_amount,
												CASE
													WHEN typ = 2 THEN act
													ELSE 0
												END spo,
												CASE
													WHEN typ = 2 THEN total_amount
													ELSE 0
												END spamount
										FROM
											(SELECT 
											dt, adv1, clicks, act, typ, total_amount
										FROM
											(SELECT 
											b.dt dt,
												b.advname adv1,
												clicks,
												act,
												typ,
												amount total_amount
										FROM
											(SELECT 
											COUNT(msisdn) clicks, dt, advname
										FROM
											(SELECT 
											msisdn,
												DATE(requesttime) dt,
												advname,
												advertiser.advertiserid
										FROM
											".$db.".requestresponse
										LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
										WHERE
											requesttime >=  '".$start_date."'
												AND requesttime <=  '".$end_date."') a
										GROUP BY dt , advname) b
										LEFT JOIN (SELECT 
											act, dt, advname, amount, typ
										FROM
											(SELECT 
											COUNT(DISTINCT subscriber.txnid) act,
												SUM(amount) amount,
												advname,
												1 typ,
												DATE(fromdate) dt
										FROM
											".$db.".subscriber
										LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
										LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
										WHERE
											fromdate >=  '".$start_date."'
												AND fromdate <=  '".$end_date."'
												AND amount > 0
												AND action = 'activation'
												AND DATE(requestresponse.requesttime) = DATE(fromdate)
										GROUP BY advname , dt
										ORDER BY subscriber.txnid) b
										GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
										GROUP BY dt , adv1) m UNION SELECT 
											dt,
												advname adv1,
												0 clicks,
												COUNT(a.spo) act,
												2 typ,
												SUM(amount) total_amount
										FROM
											(SELECT DISTINCT
											subscriber.txnid spo,
												advname,
												advertiser.advertiserid,
												DATE(fromdate) dt,
												amount
										FROM
											".$db.".subscriber
										LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
										LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
										WHERE
											fromdate >=  '".$start_date."'
												AND fromdate <=  '".$end_date."'
												AND DATE(requestresponse.requesttime) != DATE(fromdate)
												AND amount > 0
												AND action = 'activation'
										GROUP BY subscriber.txnid) a
										GROUP BY dt , advname) aa) bb
											LEFT JOIN
										(SELECT 
											COUNT(cbs) cbs, dt, advname
										FROM
											(SELECT DISTINCT
											msisdn cbs, DATE(senttime) dt, advname
										FROM
											".$db.".advertcallback
										LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
										WHERE
											senttime >=  '".$start_date."'
												AND senttime <=  '".$end_date."'
												AND action = 'act') aa1
										GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
									GROUP BY dt , adv1;
						";
					}
					$res_track=mysql_query($sql_track,$con1);
					
					
					
					
					
				}
				
				else if($operator=='gamezone_vodafone')
				{
					//$start_date=date('Y-m-d')." 00:00:00";
					//$end_date=date('Y-m-d')." 23:59:59";
					$sql_ad="select * from ".$db.".advertiser ";
					$res_ad=mysql_query($sql_ad);
					
					//$db="hotshotsnewdb_airtel_0717";
					if($advertiserid != 'all')
					{
						//$db="hotshotsnewdb_airtel_0717";
							    $sql_track="SELECT 
											bb.dt dt,
											CASE
												WHEN adv1 IS NULL THEN 'other'
												ELSE adv1
											END adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													amount total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(accesstime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$db.".userlog
											LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
											WHERE
												accesstime >=  '".$start_date."'
													AND accesstime <=  '".$end_date."'
													and advertiser.advertiserid=".$advertiserid.") a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												act, dt, advname, amount, typ
											FROM
												(SELECT 
												COUNT(DISTINCT subscriptiondetail.reqid) act,
													SUM(amount) amount,
													advname,
													1 typ,
													DATE(subscriptionstartdate) dt
											FROM
												".$db.".subscriptiondetail
											LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											
											WHERE
												subscriptionstartdate >=  '".$start_date."'
													AND subscriptionstartdate <=  '".$end_date."'
													AND amount > 0
													and isrenew=0
													and advertiser.advertiserid=".$advertiserid."
													AND DATE(userlog.accesstime) = DATE(subscriptionstartdate)
											GROUP BY advname , dt
											ORDER BY subscriptiondetail.reqid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriptiondetail.reqid spo,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount
											FROM
												".$db.".subscriptiondetail
											LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >=  '".$start_date."'
													AND subscriptionstartdate <=  '".$end_date."'
													AND DATE(userlog.accesstime) != DATE(subscriptionstartdate)
													AND amount > 0
													and isrenew=0
													and advertiser.advertiserid=".$advertiserid."
											GROUP BY subscriptiondetail.reqid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												msisdn cbs, DATE(senttime) dt, advname
											FROM
												".$db.".advertcallback
											LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
											WHERE
												senttime >=  '".$start_date."'
													AND senttime <=  '".$end_date."'
													and advertiser.advertiserid=".$advertiserid."
												   ) aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;"; 
					}
					else
					{
						//$db="hotshotsnewdb_airtel_0717";
						 $sql_track="SELECT 
											bb.dt dt,
											CASE
												WHEN adv1 IS NULL THEN 'other'
												ELSE adv1
											END adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													amount total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(accesstime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$db.".userlog
											LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
											WHERE
												accesstime >=  '".$start_date."'
													AND accesstime <=  '".$end_date."') a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												act, dt, advname, amount, typ
											FROM
												(SELECT 
												COUNT(DISTINCT subscriptiondetail.reqid) act,
													SUM(amount) amount,
													advname,
													1 typ,
													DATE(subscriptionstartdate) dt
											FROM
												".$db.".subscriptiondetail
											LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											
											WHERE
												subscriptionstartdate >=  '".$start_date."'
													AND subscriptionstartdate <=  '".$end_date."'
													AND amount > 0
													and isrenew=0
													AND DATE(userlog.accesstime) = DATE(subscriptionstartdate)
											GROUP BY advname , dt
											ORDER BY subscriptiondetail.reqid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriptiondetail.reqid spo,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount
											FROM
												".$db.".subscriptiondetail
											LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
											LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >=  '".$start_date."'
													AND subscriptionstartdate <=  '".$end_date."'
													AND DATE(userlog.accesstime) != DATE(subscriptionstartdate)
													AND amount > 0
													and isrenew=0
											GROUP BY subscriptiondetail.reqid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												msisdn cbs, DATE(senttime) dt, advname
											FROM
												".$db.".advertcallback
											LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
											WHERE
												senttime >=  '".$start_date."'
													AND senttime <=  '".$end_date."'
												   ) aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;
						";
					}
					$res_track=mysql_query($sql_track,$con1);
					
					
					
					
					
				}
				
				
				
				$res_track=mysql_query($sql_track,$con1);
					
					
			}
				
		
		
	}
	else
	{
		
		if($b==1)
			{
			
					if($advertiserid=='all')
					{
						$sql="SELECT * 
							FROM ".$report.".`report_partner_tracking` 
							WHERE DATE >= '".$start_date1."'
							AND DATE <=  '".$end_date1."' and operator='".$operator."' and product='".$product."'";
						//echo $sql;exit;
						$res2=mysql_query($sql,$con1);
						
					}
					else{
						$sql="SELECT * 
							FROM ".$report.".`report_partner_tracking` 
							WHERE DATE >= '".$start_date1."'
							AND DATE <=  '".$end_date1."' and advertiserid='".$advertiserid."' and operator='".$operator."' and product='".$product."'";
						//echo $sql;exit;
						$res2=mysql_query($sql,$con1);	
						
					}
			}
		if($c==1)
			{
				
				
					if ($operator=='airtel_india')
					{
						//$db="hotshotsdb_airtel1";
						//$dblog="hotshotsdblog_airtel1";
						$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
						$sql_ad="select * from ".$db.".advertiser ";
						$res_ad=mysql_query($sql_ad);
						
						//$db="hotshotsnewdb_airtel_0717";
						if($advertiserid != 'all')
						{
							//$db="hotshotsnewdb_airtel_0717";
								$sql_track="SELECT 
									bb.dt dt,
									adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											SUM(amount) total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											advname,
											advertiser.advertiserid
									FROM
										".$db.".userlog
									INNER JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."'
											AND userlog.advertiserid = ".$advertiserid.") a
									GROUP BY dt , advname) b
									LEFT JOIN (SELECT 
										COUNT(b.act) act, dt, advname, SUM(amount) amount, typ
									FROM
										(SELECT count(DISTINCT subscriptiondetail.txnid) act,
											userlog.msisdn,
											accesstime,
											sum(amount) amount,
											advname,
											1 typ,
											advertcallback.advertiserid,
											date(subscriptionstartdate) dt,
											max(userlogid)
									FROM
										".$db.".subscriptiondetail
								   left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
									inner join ".$db.".advertcallback on subscriptiondetail.txnid = advertcallback.txnid 
									inner JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and date(subscriptionstartdate) = date(accesstime)
											and accesstime >= SUBDATE('".$start_date."',INTERVAL 7 DAY)
											AND amount > 0
											AND isrenew = 0
											AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
											AND subscriptiondetail.errorcode = 1000
											AND userlog.advertiserid = ".$advertiserid."
											
									GROUP BY subscriptiondetail.txnid) b
									GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m UNION SELECT 
										dt,
											advname adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										subscriptiondetail.txnid spo,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount,
											MAX(userlogid)
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
									INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											AND DATE(accesstime) < DATE(subscriptionstartdate)
										   AND amount > 0
											AND isrenew = 0
											AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
											AND subscriptiondetail.errorcode = 1000
											AND userlog.advertiserid = ".$advertiserid."
									GROUP BY subscriptiondetail.txnid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(SELECT DISTINCT
										txnid cbs, DATE(senttime) dt, advname
									FROM
										".$db.".advertcallback
									INNER JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
									WHERE
										senttime >= '".$start_date."'
											AND senttime <= '".$end_date. "'  
											AND advertcallback.advertiserid = ".$advertiserid.") aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1"; 
						}
						else
						{
							//$db="hotshotsnewdb_airtel_0717";
						   $sql_track="SELECT 
									bb.dt dt,
									CASE
										WHEN adv1 IS NULL THEN 'other'
										ELSE adv1
									END adv1,
									SUM(clicks) clicks,
									SUM(act) act,
									SUM(total_amount) total_amount,
									SUM(spo) spo,
									SUM(spamount) total_amount1,
									cbs
								FROM
									(SELECT 
										dt,
											adv1,
											clicks,
											CASE
												WHEN typ = 1 THEN act
												ELSE 0
											END act,
											CASE
												WHEN typ = 1 THEN total_amount
												ELSE 0
											END total_amount,
											CASE
												WHEN typ = 2 THEN act
												ELSE 0
											END spo,
											CASE
												WHEN typ = 2 THEN total_amount
												ELSE 0
											END spamount
									FROM
										(SELECT 
										dt, adv1, clicks, act, typ, total_amount
									FROM
										(SELECT 
										b.dt dt,
											b.advname adv1,
											clicks,
											act,
											typ,
											amount total_amount
									FROM
										(SELECT 
										COUNT(msisdn) clicks, dt, advname
									FROM
										(SELECT 
										msisdn,
											DATE(accesstime) dt,
											advname,
											advertiser.advertiserid
									FROM
										".$db.".userlog
									LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."') a
									GROUP BY dt , advname) b
									LEFT JOIN (
									
									
									
									SELECT 
										act, dt, advname, amount, typ
									FROM
										(
										
										
										SELECT count(DISTINCT subscriptiondetail.txnid) act,
											userlog.msisdn,
											accesstime,
											sum(amount) amount,
											advname,
											1 typ,
											userlog.advertiserid,
											date(subscriptionstartdate) dt,
											max(userlogid)
									FROM
										".$db.".subscriptiondetail
								   left JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
									
									inner JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											and date(subscriptionstartdate) = date(accesstime)
											and accesstime >= SUBDATE('".$start_date."',INTERVAL 7 DAY)
											AND amount > 0
											AND isrenew = 0
											AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
											AND subscriptiondetail.errorcode = 1000
											
									GROUP BY advname order by msisdn
									
									
									) b
									GROUP BY dt , advname
									
									
									
									
									) c ON b.dt = c.dt AND b.advname = c.advname
									GROUP BY dt , adv1) m UNION SELECT 
										dt,
											advname adv1,
											0 clicks,
											COUNT(a.spo) act,
											2 typ,
											SUM(amount) total_amount
									FROM
										(SELECT DISTINCT
										subscriptiondetail.txnid spo,
											advname,
											advertiser.advertiserid,
											DATE(subscriptionstartdate) dt,
											amount,
											MAX(userlogid)
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
									LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate <= '".$end_date."'
											AND DATE(accesstime) < DATE(subscriptionstartdate)
											AND amount > 0
											AND isrenew = 0
											AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600403 and charging_mode != 600404)
											AND subscriptiondetail.errorcode = 1000
										   
									GROUP BY subscriptiondetail.txnid) a
									GROUP BY dt , advname) aa) bb
										LEFT JOIN
									(SELECT 
										COUNT(cbs) cbs, dt, advname
									FROM
										(SELECT DISTINCT
										txnid cbs, DATE(senttime) dt, advname
									FROM
										".$db.".advertcallback
									LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
									WHERE
										senttime >= '".$start_date."'
											AND senttime <= '".$end_date."'  ) aa1
									GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
								GROUP BY dt , adv1;
							";
						}
						$res_track=mysql_query($sql_track,$con1);	
								
					}
					else if($operator == 'south-africa')
					{
						$sql_ad="select * from ".$db.".advertiser ";
						$res_ad=mysql_query($sql_ad);
						$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
						//$db="hotshotsnewdb_airtel_0717";
						if($advertiserid != 'all')
						{
							//$db="hotshotsnewdb_airtel_0717";
								   $sql_track="SELECT 
										bb.dt dt,
										CASE
											WHEN adv1 IS NULL THEN 'other'
											ELSE adv1
										END adv1,
										SUM(clicks) clicks,
										SUM(act) act,
										SUM(total_amount) total_amount,
										SUM(spo) spo,
										SUM(spamount) total_amount1,
										cbs
									FROM
										(SELECT 
											dt,
												adv1,
												clicks,
												CASE
													WHEN typ = 1 THEN act
													ELSE 0
												END act,
												CASE
													WHEN typ = 1 THEN total_amount
													ELSE 0
												END total_amount,
												CASE
													WHEN typ = 2 THEN act
													ELSE 0
												END spo,
												CASE
													WHEN typ = 2 THEN total_amount
													ELSE 0
												END spamount
										FROM
											(SELECT 
											dt, adv1, clicks, act, typ, total_amount
										FROM
											(SELECT 
											b.dt dt,
												b.advname adv1,
												clicks,
												act,
												typ,
												amount total_amount
										FROM
											(SELECT 
											COUNT(msisdn) clicks, dt, advname
										FROM
											(SELECT 
											msisdn,
												DATE(accesstime) dt,
												advname,
												advertiser.advertiserid
										FROM
											".$db.".userlog
										LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
										WHERE
											accesstime >= '".$start_date."'
												AND accesstime <= '".$end_date."'
												and userlog.advertiserid='".$advertiserid."') a
										GROUP BY dt , advname) b
										LEFT JOIN (SELECT 
											act, dt, advname, amount, typ
										FROM
											(SELECT 
											COUNT(DISTINCT subscriptiondetail.clickid) act,
												SUM(amount) amount,
												advname,
												1 typ,
												DATE(subscriptionstartdate) dt
										FROM
											".$db.".subscriptiondetail
										LEFT JOIN ".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
										LEFT join ".$db.".userlog on subscriptiondetail.clickid=userlog.clickid
										WHERE
											subscriptionstartdate >= '".$start_date."'
												AND subscriptionstartdate <= '".$end_date."'
												AND amount > 0
												AND charging_mode = 'ACT'
												and campaignid='43956'
												and advid='".$advertiserid."'
											   and date(userlog.accesstime)=date(subscriptionstartdate)
										GROUP BY advname
										ORDER BY subscriptiondetail.clickid) b
										GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
										GROUP BY dt , adv1) m UNION SELECT 
											dt,
												advname adv1,
												0 clicks,
												COUNT(a.spo) act,
												2 typ,
												SUM(amount) total_amount
										FROM
											(SELECT DISTINCT
											subscriptiondetail.clickid spo,
												advname,
												advertiser.advertiserid,
												DATE(subscriptionstartdate) dt,
												amount
										FROM
											".$db.".subscriptiondetail
											LEFT join ".$db.".userlog on subscriptiondetail.clickid=userlog.clickid
										LEFT JOIN ".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
										WHERE
											subscriptionstartdate >= '".$start_date."'
												AND subscriptionstartdate <= '".$end_date."'
												and date(userlog.accesstime)!=date(subscriptionstartdate)
												and campaignid='43956'
												AND amount > 0
												AND charging_mode = 'ACT'
												and advid='".$advertiserid."'
										GROUP BY subscriptiondetail.clickid) a
										GROUP BY dt , advname) aa) bb
											LEFT JOIN
										(SELECT 
											COUNT(cbs) cbs, dt, advname
										FROM
											(SELECT DISTINCT
											clickid cbs, DATE(requesttime) dt, advname
										FROM
											".$db.".callbackresponse
										LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
										WHERE
											requesttime >= '".$start_date."'
												AND requesttime <= '".$end_date."'
												AND issent = 1
												and campaignid='43956'
												and callbackresponse.advertiserid='".$advertiserid."') aa1
										GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
									GROUP BY dt , adv1;"; 
						}
						else
						{
							//$db="hotshotsnewdb_airtel_0717";
							  $sql_track="SELECT 
											bb.dt dt,
											CASE
												WHEN adv1 IS NULL THEN 'other'
												ELSE adv1
											END adv1,
											SUM(clicks) clicks,
											SUM(act) act,
											SUM(total_amount) total_amount,
											SUM(spo) spo,
											SUM(spamount) total_amount1,
											cbs
										FROM
											(SELECT 
												dt,
													adv1,
													clicks,
													CASE
														WHEN typ = 1 THEN act
														ELSE 0
													END act,
													CASE
														WHEN typ = 1 THEN total_amount
														ELSE 0
													END total_amount,
													CASE
														WHEN typ = 2 THEN act
														ELSE 0
													END spo,
													CASE
														WHEN typ = 2 THEN total_amount
														ELSE 0
													END spamount
											FROM
												(SELECT 
												dt, adv1, clicks, act, typ, total_amount
											FROM
												(SELECT 
												b.dt dt,
													b.advname adv1,
													clicks,
													act,
													typ,
													amount total_amount
											FROM
												(SELECT 
												COUNT(msisdn) clicks, dt, advname
											FROM
												(SELECT 
												msisdn,
													DATE(accesstime) dt,
													advname,
													advertiser.advertiserid
											FROM
												".$db.".userlog
											LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
											WHERE
												accesstime >= '".$start_date."'
													AND accesstime <= '".$end_date."') a
											GROUP BY dt , advname) b
											LEFT JOIN (SELECT 
												act, dt, advname, amount, typ
											FROM
												(SELECT 
												COUNT(DISTINCT subscriptiondetail.clickid) act,
													SUM(amount) amount,
													advname,
													1 typ,
													DATE(subscriptionstartdate) dt
											FROM
												".$db.".subscriptiondetail
											LEFT JOIN ".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
											LEFT join ".$db.".userlog on subscriptiondetail.clickid=userlog.clickid
											WHERE
												subscriptionstartdate >= '".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													AND amount > 0
													AND charging_mode = 'ACT'
													and campaignid='43956'
												   and date(userlog.accesstime)=date(subscriptionstartdate)
											GROUP BY advname
											ORDER BY subscriptiondetail.clickid) b
											GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
											GROUP BY dt , adv1) m UNION SELECT 
												dt,
													advname adv1,
													0 clicks,
													COUNT(a.spo) act,
													2 typ,
													SUM(amount) total_amount
											FROM
												(SELECT DISTINCT
												subscriptiondetail.clickid spo,
													advname,
													advertiser.advertiserid,
													DATE(subscriptionstartdate) dt,
													amount
											FROM
												".$db.".subscriptiondetail
												LEFT join ".$db.".userlog on subscriptiondetail.clickid=userlog.clickid
											LEFT JOIN ".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
											WHERE
												subscriptionstartdate >= '".$start_date."'
													AND subscriptionstartdate <= '".$end_date."'
													and date(userlog.accesstime)!=date(subscriptionstartdate)
													and campaignid='43956'
													AND amount > 0
													AND charging_mode = 'ACT'
											GROUP BY subscriptiondetail.clickid) a
											GROUP BY dt , advname) aa) bb
												LEFT JOIN
											(SELECT 
												COUNT(cbs) cbs, dt, advname
											FROM
												(SELECT DISTINCT
												clickid cbs, DATE(requesttime) dt, advname
											FROM
												".$db.".callbackresponse
											LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
											WHERE
												requesttime >= '".$start_date."'
													AND requesttime <= '".$end_date."'
													AND issent = 1
													and campaignid='43956') aa1
											GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
										GROUP BY dt , adv1;
								";
							}
							$res_track=mysql_query($sql_track,$con1);
							
							
							
							
							
							
					}
					else if($operator=='spain')
					{
						//$start_date=date('Y-m-d')." 00:00:00";
						//$end_date=date('Y-m-d')." 23:59:59";
						$sql_ad="select * from ".$db.".advertiser ";
						$res_ad=mysql_query($sql_ad);
						
						//$db="hotshotsnewdb_airtel_0717";
						if($advertiserid != 'all')
						{
							//$db="hotshotsnewdb_airtel_0717";
									$sql_track="SELECT 
													bb.dt dt,
													CASE
														WHEN adv1 IS NULL THEN 'other'
														ELSE adv1
													END adv1,
													SUM(clicks) clicks,
													SUM(act) act,
													SUM(total_amount) total_amount,
													SUM(spo) spo,
													SUM(spamount) total_amount1,
													cbs
												FROM
													(SELECT 
														dt,
															adv1,
															clicks,
															CASE
																WHEN typ = 1 THEN act
																ELSE 0
															END act,
															CASE
																WHEN typ = 1 THEN total_amount
																ELSE 0
															END total_amount,
															CASE
																WHEN typ = 2 THEN act
																ELSE 0
															END spo,
															CASE
																WHEN typ = 2 THEN total_amount
																ELSE 0
															END spamount
													FROM
														(SELECT 
														dt, adv1, clicks, act, typ, total_amount
													FROM
														(SELECT 
														b.dt dt,
															b.advname adv1,
															clicks,
															act,
															typ,
															amount total_amount
													FROM
														(SELECT 
														COUNT(msisdn) clicks, dt, advname
													FROM
														(SELECT 
														msisdn,
															DATE(accesstime) dt,
															advname,
															advertiser.advertiserid
													FROM
														".$dblog.".userlog
													LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
													WHERE
														accesstime >=  '".$start_date."'
															AND accesstime <=  '".$end_date."'
															and userlog.advertiserid='".$advertiserid."') a
													GROUP BY dt , advname) b
													LEFT JOIN (SELECT 
														act, dt, advname, amount, typ
													FROM
														(SELECT 
														COUNT(DISTINCT subscriber.clickid) act,
															SUM(amount) amount,
															advname,
															1 typ,
															DATE(subscriprion_startdate) dt
													FROM
														".$db.".subscriber
													LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
													LEFT JOIN ".$dblog.".userlog ON subscriber.clickid = userlog.clickid
													WHERE
														subscriprion_startdate >=  '".$start_date."'
															AND subscriprion_startdate <=  '".$end_date."'
															AND amount > 0
															AND charging_mode = 'ACT'
															and advid='".$advertiserid."'
															AND DATE(userlog.accesstime) = DATE(subscriprion_startdate)
													GROUP BY advname,dt
													ORDER BY subscriber.clickid) b
													GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
													GROUP BY dt , adv1) m UNION SELECT 
														dt,
															advname adv1,
															0 clicks,
															COUNT(a.spo) act,
															2 typ,
															SUM(amount) total_amount
													FROM
														(SELECT DISTINCT
														subscriber.clickid spo,
															advname,
															advertiser.advertiserid,
															DATE(subscriprion_startdate) dt,
															amount
													FROM
														".$db.".subscriber
													LEFT JOIN ".$dblog.".userlog ON subscriber.clickid = userlog.clickid
													LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
													WHERE
														subscriprion_startdate >=  '".$start_date."'
															AND subscriprion_startdate <=  '".$end_date."'
															AND DATE(userlog.accesstime) != DATE(subscriprion_startdate)
														   
															AND amount > 0
															AND charging_mode = 'ACT'
															and advid='".$advertiserid."'
													GROUP BY subscriber.clickid) a
													GROUP BY dt , advname) aa) bb
														LEFT JOIN
													(SELECT 
														COUNT(cbs) cbs, dt, advname
													FROM
														(SELECT DISTINCT
														clickid cbs, DATE(requesttime) dt, advname
													FROM
														".$db.".callbackresponse
													LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
													WHERE
														requesttime >=  '".$start_date."'
															AND requesttime <=  '".$end_date."'
															AND issent = 1
															and callbackresponse.advertiserid='".$advertiserid."'
														   ) aa1
													GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
												GROUP BY dt , adv1; "; 
						}
						else
						{
							//$db="hotshotsnewdb_airtel_0717";
							 $sql_track="SELECT 
								bb.dt dt,
								CASE
									WHEN adv1 IS NULL THEN 'other'
									ELSE adv1
								END adv1,
								SUM(clicks) clicks,
								SUM(act) act,
								SUM(total_amount) total_amount,
								SUM(spo) spo,
								SUM(spamount) total_amount1,
								cbs
							FROM
								(SELECT 
									dt,
										adv1,
										clicks,
										CASE
											WHEN typ = 1 THEN act
											ELSE 0
										END act,
										CASE
											WHEN typ = 1 THEN total_amount
											ELSE 0
										END total_amount,
										CASE
											WHEN typ = 2 THEN act
											ELSE 0
										END spo,
										CASE
											WHEN typ = 2 THEN total_amount
											ELSE 0
										END spamount
								FROM
									(SELECT 
									dt, adv1, clicks, act, typ, total_amount
								FROM
									(SELECT 
									b.dt dt,
										b.advname adv1,
										clicks,
										act,
										typ,
										amount total_amount
								FROM
									(SELECT 
									COUNT(msisdn) clicks, dt, advname
								FROM
									(SELECT 
									msisdn,
										DATE(accesstime) dt,
										advname,
										advertiser.advertiserid
								FROM
									".$dblog.".userlog
								LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >=  '".$start_date."'
										AND accesstime <=  '".$end_date."') a
								GROUP BY dt , advname) b
								LEFT JOIN (SELECT 
									act, dt, advname, amount, typ
								FROM
									(SELECT 
									COUNT(DISTINCT subscriber.clickid) act,
										SUM(amount) amount,
										advname,
										1 typ,
										DATE(subscriprion_startdate) dt
								FROM
									".$db.".subscriber
								LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								LEFT JOIN ".$db.".activeuserlog ON subscriber.clickid = activeuserlog.clickid
								WHERE
									subscriprion_startdate >=  '".$start_date."'
										AND subscriprion_startdate <=  '".$end_date."'
										AND amount > 0
										AND charging_mode = 'ACT'
									   
										AND DATE(activeuserlog.accesstime) = DATE(subscriprion_startdate)
								GROUP BY advname,dt
								ORDER BY subscriber.clickid) b
								GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
								GROUP BY dt , adv1) m UNION SELECT 
									dt,
										advname adv1,
										0 clicks,
										COUNT(a.spo) act,
										2 typ,
										SUM(amount) total_amount
								FROM
									(SELECT DISTINCT
									subscriber.clickid spo,
										advname,
										advertiser.advertiserid,
										DATE(subscriprion_startdate) dt,
										amount
								FROM
									".$db.".subscriber
								LEFT JOIN ".$db.".activeuserlog ON subscriber.clickid = activeuserlog.clickid
								LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
									subscriprion_startdate >=  '".$start_date."'
										AND subscriprion_startdate <=  '".$end_date."'
										AND DATE(activeuserlog.accesstime) < DATE(subscriprion_startdate)
									   
										AND amount > 0
										AND charging_mode = 'ACT'
								GROUP BY subscriber.clickid) a
								GROUP BY dt , advname) aa) bb
									LEFT JOIN
								(SELECT 
									COUNT(cbs) cbs, dt, advname
								FROM
									(SELECT DISTINCT
									clickid cbs, DATE(requesttime) dt, advname
								FROM
									".$db.".callbackresponse
								LEFT JOIN ".$db.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
								WHERE
									requesttime >=  '".$start_date."'
										AND requesttime <=  '".$end_date."'
										AND issent = 1
									   ) aa1
								GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
							GROUP BY dt , adv1; 
							";
						}
						$res_track=mysql_query($sql_track,$con1);
						
						
						
						
						
					}		
					else if($operator=='vodafone')
					{
							//$start_date=date('Y-m-d')." 00:00:00";
							//$end_date=date('Y-m-d')." 23:59:59";
							$sql_ad="select * from ".$db.".advertiser ";
							$res_ad=mysql_query($sql_ad);
							
							//$db="hotshotsnewdb_airtel_0717";
							if($advertiserid != 'all')
							{
								//$db="hotshotsnewdb_airtel_0717";
										$sql_track="SELECT 
													bb.dt dt,
													CASE
														WHEN adv1 IS NULL THEN 'other'
														ELSE adv1
													END adv1,
													SUM(clicks) clicks,
													SUM(act) act,
													SUM(total_amount) total_amount,
													SUM(spo) spo,
													SUM(spamount) total_amount1,
													cbs
												FROM
													(SELECT 
														dt,
															adv1,
															clicks,
															CASE
																WHEN typ = 1 THEN act
																ELSE 0
															END act,
															CASE
																WHEN typ = 1 THEN total_amount
																ELSE 0
															END total_amount,
															CASE
																WHEN typ = 2 THEN act
																ELSE 0
															END spo,
															CASE
																WHEN typ = 2 THEN total_amount
																ELSE 0
															END spamount
													FROM
														(SELECT 
														dt, adv1, clicks, act, typ, total_amount
													FROM
														(SELECT 
														b.dt dt,
															b.advname adv1,
															clicks,
															act,
															typ,
															amount total_amount
													FROM
														(SELECT 
														COUNT(msisdn) clicks, dt, advname
													FROM
														(SELECT 
														msisdn,
															DATE(requesttime) dt,
															advname,
															advertiser.advertiserid
													FROM
														".$db.".requestresponse
													LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
													WHERE
														requesttime >=  '".$start_date."'
															AND requesttime <=  '".$end_date."'
															and requestresponse.advertiserid='".$advertiserid."') a
													GROUP BY dt , advname) b
													LEFT JOIN (SELECT 
														act, dt, advname, amount, typ
													FROM
														(SELECT 
														COUNT(DISTINCT subscriber.txnid) act,
															SUM(amount) amount,
															advname,
															1 typ,
															DATE(fromdate) dt
													FROM
														".$db.".subscriber
													LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
													LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
													WHERE
														fromdate >=  '".$start_date."'
															AND fromdate <=  '".$end_date."'
															AND amount > 0
															AND action = 'activation'
															and advertid='".$advertiserid."'
															AND DATE(requestresponse.requesttime) = DATE(fromdate)
													GROUP BY advname , dt
													ORDER BY subscriber.txnid) b
													GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
													GROUP BY dt , adv1) m UNION SELECT 
														dt,
															advname adv1,
															0 clicks,
															COUNT(a.spo) act,
															2 typ,
															SUM(amount) total_amount
													FROM
														(SELECT DISTINCT
														subscriber.txnid spo,
															advname,
															advertiser.advertiserid,
															DATE(fromdate) dt,
															amount
													FROM
														".$db.".subscriber
													LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
													LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
													WHERE
														fromdate >=  '".$start_date."'
															AND fromdate <=  '".$end_date."'
															AND DATE(requestresponse.requesttime) != DATE(fromdate)
															AND amount > 0
															AND action = 'activation'
															and advertid='".$advertiserid."'
													GROUP BY subscriber.txnid) a
													GROUP BY dt , advname) aa) bb
														LEFT JOIN
													(SELECT 
														COUNT(cbs) cbs, dt, advname
													FROM
														(SELECT DISTINCT
														msisdn cbs, DATE(senttime) dt, advname
													FROM
														".$db.".advertcallback
													LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
													WHERE
														senttime >=  '".$start_date."'
															AND senttime <=  '".$end_date."'
															AND action = 'act'
															and advertiser.advertiserid='".$advertiserid."') aa1
													GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
												GROUP BY dt , adv1;"; 
							}
							else
							{
								//$db="hotshotsnewdb_airtel_0717";
								 $sql_track="SELECT 
												bb.dt dt,
												CASE
													WHEN adv1 IS NULL THEN 'other'
													ELSE adv1
												END adv1,
												SUM(clicks) clicks,
												SUM(act) act,
												SUM(total_amount) total_amount,
												SUM(spo) spo,
												SUM(spamount) total_amount1,
												cbs
											FROM
												(SELECT 
													dt,
														adv1,
														clicks,
														CASE
															WHEN typ = 1 THEN act
															ELSE 0
														END act,
														CASE
															WHEN typ = 1 THEN total_amount
															ELSE 0
														END total_amount,
														CASE
															WHEN typ = 2 THEN act
															ELSE 0
														END spo,
														CASE
															WHEN typ = 2 THEN total_amount
															ELSE 0
														END spamount
												FROM
													(SELECT 
													dt, adv1, clicks, act, typ, total_amount
												FROM
													(SELECT 
													b.dt dt,
														b.advname adv1,
														clicks,
														act,
														typ,
														amount total_amount
												FROM
													(SELECT 
													COUNT(msisdn) clicks, dt, advname
												FROM
													(SELECT 
													msisdn,
														DATE(requesttime) dt,
														advname,
														advertiser.advertiserid
												FROM
													".$db.".requestresponse
												LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
												WHERE
													requesttime >=  '".$start_date."'
														AND requesttime <=  '".$end_date."') a
												GROUP BY dt , advname) b
												LEFT JOIN (SELECT 
													act, dt, advname, amount, typ
												FROM
													(SELECT 
													COUNT(DISTINCT subscriber.txnid) act,
														SUM(amount) amount,
														advname,
														1 typ,
														DATE(fromdate) dt
												FROM
													".$db.".subscriber
												LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
												LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
												WHERE
													fromdate >=  '".$start_date."'
														AND fromdate <=  '".$end_date."'
														AND amount > 0
														AND action = 'activation'
														AND DATE(requestresponse.requesttime) = DATE(fromdate)
												GROUP BY advname , dt
												ORDER BY subscriber.txnid) b
												GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
												GROUP BY dt , adv1) m UNION SELECT 
													dt,
														advname adv1,
														0 clicks,
														COUNT(a.spo) act,
														2 typ,
														SUM(amount) total_amount
												FROM
													(SELECT DISTINCT
													subscriber.txnid spo,
														advname,
														advertiser.advertiserid,
														DATE(fromdate) dt,
														amount
												FROM
													".$db.".subscriber
												LEFT JOIN ".$db.".requestresponse ON subscriber.txnid = requestresponse.msisdn
												LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
												WHERE
													fromdate >=  '".$start_date."'
														AND fromdate <=  '".$end_date."'
														AND DATE(requestresponse.requesttime) != DATE(fromdate)
														AND amount > 0
														AND action = 'activation'
												GROUP BY subscriber.txnid) a
												GROUP BY dt , advname) aa) bb
													LEFT JOIN
												(SELECT 
													COUNT(cbs) cbs, dt, advname
												FROM
													(SELECT DISTINCT
													msisdn cbs, DATE(senttime) dt, advname
												FROM
													".$db.".advertcallback
												LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
												WHERE
													senttime >=  '".$start_date."'
														AND senttime <=  '".$end_date."'
														AND action = 'act') aa1
												GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
											GROUP BY dt , adv1;
								";
							}
							$res_track=mysql_query($sql_track,$con1);
							
							
							
					
					
				}
					else if($operator=='hotshots_vodafone')
						{
							//$start_date=date('Y-m-d')." 00:00:00";
							//$end_date=date('Y-m-d')." 23:59:59";
							$sql_ad="select * from ".$db.".advertiser ";
							$res_ad=mysql_query($sql_ad);
							
							//$db="hotshotsnewdb_airtel_0717";
							if($advertiserid != 'all')
							{
								//$db="hotshotsnewdb_airtel_0717";
										$sql_track="SELECT 
													bb.dt dt,
													CASE
														WHEN adv1 IS NULL THEN 'other'
														ELSE adv1
													END adv1,
													SUM(clicks) clicks,
													SUM(act) act,
													SUM(total_amount) total_amount,
													SUM(spo) spo,
													SUM(spamount) total_amount1,
													cbs
												FROM
													(SELECT 
														dt,
															adv1,
															clicks,
															CASE
																WHEN typ = 1 THEN act
																ELSE 0
															END act,
															CASE
																WHEN typ = 1 THEN total_amount
																ELSE 0
															END total_amount,
															CASE
																WHEN typ = 2 THEN act
																ELSE 0
															END spo,
															CASE
																WHEN typ = 2 THEN total_amount
																ELSE 0
															END spamount
													FROM
														(SELECT 
														dt, adv1, clicks, act, typ, total_amount
													FROM
														(SELECT 
														b.dt dt,
															b.advname adv1,
															clicks,
															act,
															typ,
															amount total_amount
													FROM
														(SELECT 
														COUNT(msisdn) clicks, dt, advname
													FROM
														(SELECT 
														msisdn,
															DATE(accesstime) dt,
															advname,
															advertiser.advertiserid
													FROM
														".$db.".userlog
													LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
													WHERE
														accesstime >=  '".$start_date."'
															AND accesstime <=  '".$end_date."'
															and advertiser.advertiserid=".$advertiserid.") a
													GROUP BY dt , advname) b
													LEFT JOIN (SELECT 
														act, dt, advname, amount, typ
													FROM
														(SELECT 
														COUNT(DISTINCT subscriptiondetail.reqid) act,
															SUM(amount) amount,
															advname,
															1 typ,
															DATE(subscriptionstartdate) dt
													FROM
														".$db.".subscriptiondetail
													LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
													LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
													
													WHERE
														subscriptionstartdate >=  '".$start_date."'
															AND subscriptionstartdate <=  '".$end_date."'
															AND amount > 0
															and isrenew=0
															and advertiser.advertiserid=".$advertiserid."
															AND DATE(userlog.accesstime) = DATE(subscriptionstartdate)
													GROUP BY advname , dt
													ORDER BY subscriptiondetail.reqid) b
													GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
													GROUP BY dt , adv1) m UNION SELECT 
														dt,
															advname adv1,
															0 clicks,
															COUNT(a.spo) act,
															2 typ,
															SUM(amount) total_amount
													FROM
														(SELECT DISTINCT
														subscriptiondetail.reqid spo,
															advname,
															advertiser.advertiserid,
															DATE(subscriptionstartdate) dt,
															amount
													FROM
														".$db.".subscriptiondetail
													LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
													LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
													WHERE
														subscriptionstartdate >=  '".$start_date."'
															AND subscriptionstartdate <=  '".$end_date."'
															AND DATE(userlog.accesstime) != DATE(subscriptionstartdate)
															AND amount > 0
															and isrenew=0
															and advertiser.advertiserid=".$advertiserid."
													GROUP BY subscriptiondetail.reqid) a
													GROUP BY dt , advname) aa) bb
														LEFT JOIN
													(SELECT 
														COUNT(cbs) cbs, dt, advname
													FROM
														(SELECT DISTINCT
														msisdn cbs, DATE(senttime) dt, advname
													FROM
														".$db.".advertcallback
													LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
													WHERE
														senttime >=  '".$start_date."'
															AND senttime <=  '".$end_date."'
															and advertiser.advertiserid=".$advertiserid."
														   ) aa1
													GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
												GROUP BY dt , adv1;"; 
							}
							else
							{
								//$db="hotshotsnewdb_airtel_0717";
								 $sql_track="SELECT 
													bb.dt dt,
													CASE
														WHEN adv1 IS NULL THEN 'other'
														ELSE adv1
													END adv1,
													SUM(clicks) clicks,
													SUM(act) act,
													SUM(total_amount) total_amount,
													SUM(spo) spo,
													SUM(spamount) total_amount1,
													cbs
												FROM
													(SELECT 
														dt,
															adv1,
															clicks,
															CASE
																WHEN typ = 1 THEN act
																ELSE 0
															END act,
															CASE
																WHEN typ = 1 THEN total_amount
																ELSE 0
															END total_amount,
															CASE
																WHEN typ = 2 THEN act
																ELSE 0
															END spo,
															CASE
																WHEN typ = 2 THEN total_amount
																ELSE 0
															END spamount
													FROM
														(SELECT 
														dt, adv1, clicks, act, typ, total_amount
													FROM
														(SELECT 
														b.dt dt,
															b.advname adv1,
															clicks,
															act,
															typ,
															amount total_amount
													FROM
														(SELECT 
														COUNT(msisdn) clicks, dt, advname
													FROM
														(SELECT 
														msisdn,
															DATE(accesstime) dt,
															advname,
															advertiser.advertiserid
													FROM
														".$db.".userlog
													LEFT JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
													WHERE
														accesstime >=  '".$start_date."'
															AND accesstime <=  '".$end_date."') a
													GROUP BY dt , advname) b
													LEFT JOIN (SELECT 
														act, dt, advname, amount, typ
													FROM
														(SELECT 
														COUNT(DISTINCT subscriptiondetail.reqid) act,
															SUM(amount) amount,
															advname,
															1 typ,
															DATE(subscriptionstartdate) dt
													FROM
														".$db.".subscriptiondetail
													LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
													LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
													
													WHERE
														subscriptionstartdate >=  '".$start_date."'
															AND subscriptionstartdate <=  '".$end_date."'
															AND amount > 0
															and isrenew=0
															AND DATE(userlog.accesstime) = DATE(subscriptionstartdate)
													GROUP BY advname , dt
													ORDER BY subscriptiondetail.reqid) b
													GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
													GROUP BY dt , adv1) m UNION SELECT 
														dt,
															advname adv1,
															0 clicks,
															COUNT(a.spo) act,
															2 typ,
															SUM(amount) total_amount
													FROM
														(SELECT DISTINCT
														subscriptiondetail.reqid spo,
															advname,
															advertiser.advertiserid,
															DATE(subscriptionstartdate) dt,
															amount
													FROM
														".$db.".subscriptiondetail
													LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
													LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
													WHERE
														subscriptionstartdate >=  '".$start_date."'
															AND subscriptionstartdate <=  '".$end_date."'
															AND DATE(userlog.accesstime) != DATE(subscriptionstartdate)
															AND amount > 0
															and isrenew=0
													GROUP BY subscriptiondetail.reqid) a
													GROUP BY dt , advname) aa) bb
														LEFT JOIN
													(SELECT 
														COUNT(cbs) cbs, dt, advname
													FROM
														(SELECT DISTINCT
														msisdn cbs, DATE(senttime) dt, advname
													FROM
														".$db.".advertcallback
													LEFT JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
													WHERE
														senttime >=  '".$start_date."'
															AND senttime <=  '".$end_date."'
														   ) aa1
													GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
												GROUP BY dt , adv1;
								";
							}
							$res_track=mysql_query($sql_track,$con1);
							
							
							
							
							
						}
						
				
				
			
			}
		
		/*if($operator=='Vodafone')
		{
			$db="gamesdb_voda";
			$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid != 'all')
			{
				 $sql_track="SELECT 
									clicks,
									dt,
									advname adv1,
									act,
									actsp spo,
									total_amount,
									total_amount1,
									cbs
								FROM
									(SELECT 
										COUNT(*) clicks, DATE(accesstime) dt,advname
									FROM
										".$dblog.".annonymoustracking
										inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime <= '".$end_date."'
											AND annonymoustracking.advertiserid = ".$advertiserid."
									GROUP BY dt) a
										INNER JOIN
									(SELECT 
										COUNT(mobilenumber) act, SUM(amount) total_amount, sdt
									FROM
										(SELECT DISTINCT
										mobilenumber, amount, sdt, DATE(accesstime) acsdt
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) sdt,
											amount,
											MAX(annonymoustrackingid) atid
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 0
											AND amount > 0
											AND DATE(accesstime) = DATE(subscriptionstartdate)
											AND annonymoustracking.advertiserid > - 1
											AND accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
											AND advertiserid = ".$advertiserid."
									GROUP BY subscriptiondetail.subscriberid , sdt) aa ON aa.atid = annonymoustrackingid) bb
									GROUP BY sdt) b ON a.dt = b.sdt
										INNER JOIN
									(SELECT 
										COUNT(*) actsp, SUM(u.amount) total_amount1, u.sdt dt22,ad
									FROM
										(SELECT DISTINCT
										mobilenumber, sdt, ad, DATE(accesstime) acsdt
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) sdt,
											MAX(annonymoustrackingid) atid,
											advertiser.advname ad
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 0
											AND amount > 0
											AND operator = 1
											AND DATE(accesstime) = DATE(subscriptionstartdate)
											AND advertiser.advertiserid = ".$advertiserid."
											AND annonymoustracking.advertiserid > - 1
											AND accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
									GROUP BY subscriptiondetail.subscriberid , sdt) a ON a.atid = annonymoustrackingid) x
									RIGHT JOIN (SELECT DISTINCT
										mobilenumber, amount, sdt, uad, DATE(accesstime) acsdt
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) sdt,
											amount,
											MAX(annonymoustrackingid) atid,
											advertiser.advname uad
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 0
											AND amount > 0
											AND operator = 1
											AND DATE(accesstime) < DATE(subscriptionstartdate)
											AND advertiser.advertiserid = ".$advertiserid."
											AND annonymoustracking.advertiserid > - 1
											AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
											AND accesstime < '".$end_date."'
									GROUP BY subscriptiondetail.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.mobilenumber = u.mobilenumber
									WHERE
										x.mobilenumber IS NULL
									GROUP BY dt22) c ON b.sdt = c.dt22
										INNER JOIN
									(SELECT 
										COUNT(*) cbs, DATE(requesttime) dt3
									FROM
										".$db.".requestresponse
									WHERE
										requesttime >= '".$start_date."'
											AND requesttime <= '".$end_date."'
											AND advertiserid = ".$advertiserid."
									GROUP BY dt3) d ON c.dt22 = d.dt3
								GROUP BY dt;
				"; 
			}
			else
			{
				 $sql_track="select  dt,adv1,clicks, act, actsp spo, total_amount,total_amount1,cbs from ( 
				select count(*) clicks, DATE(accesstime) dt , advertiser.advname adv1 from ".$dblog.".annonymoustracking 
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1  group by dt,adv1 ) a inner join 
				( 
				select count(mobilenumber) act,sum(amount) total_amount, sdt,adv2 from (
				select distinct mobilenumber,amount, sdt, date(accesstime) acsdt,adv2 from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt, amount,max(annonymoustrackingid) atid, advertiser.advname adv2
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
				and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)
				 and annonymoustracking.advertiserid > -1 and operator=1
				and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
				group by subscriptiondetail.subscriberid, sdt,adv2) aa on aa.atid = annonymoustrackingid) bb group  by sdt,adv2) b on a.dt=b.sdt and a.adv1=b.adv2 inner join 
				(
				select count(*) actsp,sum(u.amount) total_amount1,u.sdt dt22,u.adv4 from (
				select distinct mobilenumber, sdt, date(accesstime) acsdt ,adv3
				from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt, max(annonymoustrackingid) atid, advertiser.advname adv3
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
				and isrenew=0 and amount > 0 and operator =1  and date(accesstime) = date(subscriptionstartdate)
				 and annonymoustracking.advertiserid > -1
				and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
				group by subscriptiondetail.subscriberid, sdt,adv3) a on a.atid = annonymoustrackingid) x right join (
				select distinct mobilenumber,amount, sdt, date(accesstime) acsdt , adv4
				from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt,amount, max(annonymoustrackingid) atid, advertiser.advname adv4
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
				and isrenew=0 and amount > 0 and operator =1  
				and annonymoustracking.advertiserid > -1
				and accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY) and accesstime < '".$end_date."'
				group by subscriptiondetail.subscriberid, sdt) a on a.atid = annonymoustrackingid) u on x.mobilenumber = u.mobilenumber
				 group by dt22,adv4
				) c on b.sdt=c.dt22 and b.adv2=c.adv4
				inner join ( 
				select count(*) cbs , DATE(requesttime) dt3, advertiser.advname adv5 from ".$db.".requestresponse inner join ".$dblog.".advertiser
				on advertiser.advertiserid=requestresponse.advertiserid where requesttime >= '".$start_date."'
				and requesttime < '".$end_date."' group by dt3,adv5 ) d on c.dt22=d.dt3 and c.adv4=d.adv5 group by dt,adv1";
			
			}  
			$res_track=mysql_query($sql_track,$con);
			
		}
		elseif ($operator=='Airtel')
		{
			
		}
		else
		{
			$db="gamesdb";
			$dblog="gamesdblog_idea";
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=2";
			$res_ad=mysql_query($sql_ad);
			
			
			if($advertiserid != 'all')
			{
				 $sql_track="select clicks, dt, act, actsp, total_amount,total_amount1, cbs from ( 
					select count(*) clicks, DATE(accesstime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime <= '".$end_date."' and advertiserid=".$advertiserid." group by dt ) a inner join 
					( 
					select count(mobilenumber) act,sum(amount) total_amount, sdt from (
					select distinct mobilenumber,amount, sdt, date(accesstime) acsdt from ".$dblog.".annonymoustracking inner join (
					select mobilenumber, date(subscriptionstartdate) sdt, amount,max(annonymoustrackingid) atid
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and date(accesstime) = date(subscriptionstartdate)
					 and annonymoustracking.advertiserid > -1
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and  advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, sdt) aa on aa.atid = annonymoustrackingid) bb group by sdt) b on a.dt=b.sdt inner join 
					(

					select count(*) actsp,sum(u.amount) total_amount1,u.sdt dt22 from (
					select distinct mobilenumber, sdt, ad, date(accesstime) acsdt 
					from ".$dblog.".annonymoustracking inner join (
					select mobilenumber, date(subscriptionstartdate) sdt, max(annonymoustrackingid) atid,advertiser.advname ad
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and operator =2 and date(accesstime) = date(subscriptionstartdate) and advertiser.advertiserid=".$advertiserid."
					 and annonymoustracking.advertiserid > -1
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					group by subscriptiondetail.subscriberid, sdt) a on a.atid = annonymoustrackingid) x right join (
					select distinct mobilenumber,amount, sdt, uad, date(accesstime) acsdt 
					from ".$dblog.".annonymoustracking inner join (
					select mobilenumber, date(subscriptionstartdate) sdt,amount, max(annonymoustrackingid) atid,advertiser.advname uad
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and operator =2  and date(accesstime) < date(subscriptionstartdate) and advertiser.advertiserid=".$advertiserid."
					and annonymoustracking.advertiserid > -1
					and accesstime >= SUBDATE('".$start_date."',INTERVAL 7 DAY) and accesstime < '".$end_date."'
					group by subscriptiondetail.subscriberid, sdt) a on a.atid = annonymoustrackingid) u on x.mobilenumber = u.mobilenumber
					where x.mobilenumber is null group by dt22
					 
					) c on b.sdt=c.dt22 
					inner join ( 
					select count(*) cbs , DATE(requesttime) dt3 from ".$db.".requestresponse where requesttime >= '".$start_date."'
					and requesttime <= '".$end_date."' and advertiserid=".$advertiserid." group by dt3 ) d on c.dt22=d.dt3;
					"; 
			}
			else
			{
			 $sql_track="select  dt,adv1,clicks, act, actsp, total_amount,total_amount1,cbs from ( 
				select count(*) clicks, DATE(accesstime) dt , advertiser.advname adv1 from ".$dblog.".annonymoustracking 
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 group by dt,adv1 ) a inner join 
				( 
				select count(mobilenumber) act,sum(amount) total_amount, sdt,adv2 from (
				select distinct mobilenumber,amount, sdt, date(accesstime) acsdt,adv2 from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt, amount,max(annonymoustrackingid) atid, advertiser.advname adv2
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
				and  charging_mode like '%ACT%' and amount > 0 and date(accesstime) = date(subscriptionstartdate)
				 and annonymoustracking.advertiserid > -1 and operator=2
				and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
				group by subscriptiondetail.subscriberid, sdt,adv2) aa on aa.atid = annonymoustrackingid) bb group  by sdt,adv2) b on a.dt=b.sdt and a.adv1=b.adv2 inner join 
				(
				select count(*) actsp,sum(u.amount) total_amount1,u.sdt dt22,u.adv4 from (
				select distinct mobilenumber, sdt, date(accesstime) acsdt ,adv3
				from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt, max(annonymoustrackingid) atid, advertiser.advname adv3
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
				and  charging_mode like '%ACT%' and amount > 0 and operator =2  and date(accesstime) = date(subscriptionstartdate)
				 and annonymoustracking.advertiserid > -1
				and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
				group by subscriptiondetail.subscriberid, sdt,adv3) a on a.atid = annonymoustrackingid) x right join (
				select distinct mobilenumber,amount, sdt, date(accesstime) acsdt , adv4
				from ".$dblog.".annonymoustracking inner join (
				select mobilenumber, date(subscriptionstartdate) sdt,amount, max(annonymoustrackingid) atid, advertiser.advname adv4
				from ".$db.".subscriptiondetail 
				inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
				inner join ".$dblog.".annonymoustracking on mobilenumber = userid
				inner join ".$dblog.".advertiser on annonymoustracking.advertiserid=advertiser.advertiserid
				where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
				and charging_mode like '%ACT%' and amount > 0 and operator =2
				and annonymoustracking.advertiserid > -1
				and accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY) and accesstime < '".$end_date."'
				group by subscriptiondetail.subscriberid, sdt) a on a.atid = annonymoustrackingid) u on x.mobilenumber = u.mobilenumber
				 group by dt22,adv4
				) c on b.sdt=c.dt22 and b.adv2=c.adv4
				inner join ( 
				select count(*) cbs , DATE(requesttime) dt3, advertiser.advname adv5 from ".$db.".requestresponse inner join ".$dblog.".advertiser
				on advertiser.advertiserid=requestresponse.advertiserid where requesttime >= '".$start_date."'
				and requesttime < '".$end_date."' group by dt3,adv5 ) d on c.dt22=d.dt3 and c.adv4=d.adv5 group by dt,adv1";
			}
				
			$res_track=mysql_query($sql_track);
			
			
			
		}
		
	}
*/
	





//echo "<script>window.location='report.php';</script>";



	}
}
?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Partners Tracking Report </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product" onchange="myfun()">
							<option>Product</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glambar</option>
							
						</select>		
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<?php
						if($product == 'glambar')
						{ ?>
							<option>Operator</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel_India</option>
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?>>SouthAfrica_oxygen</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="hotshots_vodafone" <?php if($operator=='hotshots_vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots_Vodafone</option>
							<!--<option value="Vodafone" <?php //if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php //if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							-->
						<?php
						}
						else if($product == 'gamebar'){
						?>
							<option value="Vodafone_Qatar" <?php if($operator=='Vodafone_Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_Qatar</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Oman</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?>>Indonesia</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel_India</option>
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?>>SouthAfrica_oxygen</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="gamezone_vodafone" <?php if($operator=='gamezone_vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Gamezone_Vodafone</option>
							<!--<option  id="ooredoo_oman" name="ooredoo_oman" value="ooredoo_oman" <?php //if($operator=='ooredoo-oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Oman</option>
							<!--<option  id="ooredoo" name="ooredoo" value="ooredoo" <?php //if($operator=='ooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo-Qatar</option>-->
							<!--<option  id="srilanka" name="srilanka" value="srilanka" <?php //if($operator=='srilanka'){$selected='selected';}else{$selected='';} echo $selected; ?>>srilanka</option>
							<!--<option  id="etisalat" name="etisalat" value="etisalat" <?php //if($operator=='etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>etisalat</option>-->
						<?php
						}
						else{
						?>
						<option>Operator</option>
						<?php
						}
						
						?>					
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date1!=''){echo date('d-m-Y',strtotime($start_date1));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date1!=''){echo date('d-m-Y',strtotime($end_date1));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						
						<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback first"> Advertiser
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel">
									<option value="all">All</option>
									<?php
										
									while($row_ad=mysql_fetch_array($res_ad))
									{
										if($row_ad['advertiserid']==$advertiserid)
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
									?>
									<option value="<?php echo $row_ad['advertiserid']; ?>" <?php echo $selected; ?>><?php echo $row_ad['advname']; ?></option>
									<?php
									}
									?>
									
								</select>
								</span>
							</div>
						<?php
						}
						?>
						

                     
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Output Records</h2>
							<ul class="nav navbar-right panel_toolbox">
							  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							  </li>
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
								  <li><a href="#">Settings 1</a>
								  </li>
								  <li><a href="#">Settings 2</a>
								  </li>
								</ul>
							  </li>
							  <li><a class="close-link"><i class="fa fa-close"></i></a>
							  </li>
							</ul>
							<div class="clearfix"></div>
						</div>
						
			<?php 	
			if($count==1)
			{
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Advertiser</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>SPO</strong></td>
									<td><strong>Amount</strong></td>
									
									<td><strong>CBS</strong></td>
									<td><strong>CR%</strong></td>
									<td><strong>COA</strong></td>					
									<td><strong>ARPU</strong></td>					
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$act_sum='';
								$act_amnt='';
								$actsp_sum='';
								$total_amount='';
								$cbs_sum='';
								$coa_sum='';
								$arpu_sum='';
								$a=0;
								if($c==1)
								{
								while($row_track=mysql_fetch_array($res_track))
								{
								
								?>
								<tr>
									<td><?php echo $row_track['dt'];  ?></td>
									<td><?php echo $row_track['adv1'];  ?></td>
									<td><?php echo number_format($row_track['clicks']); $click_sum=$click_sum+$row_track['clicks']; ?></td>
									<td><?php echo number_format($row_track['act']); $act_sum=$act_sum+$row_track['act'];?></td>
									<td><?php echo number_format($row_track['total_amount']); $act_amnt=$act_amnt+$row_track['total_amount'];?></td>
									<td><?php $actsp=$row_track['spo']; echo number_format($actsp); $a=$a+$actsp;?></td>
									<td><?php echo number_format($row_track['total_amount1']); $total_amount=$total_amount+$row_track['total_amount1'];?></td>
									<td><?php echo number_format($row_track['cbs']); $cbs_sum=$cbs_sum+$row_track['cbs']; ?></td>
									<td><?php echo number_format(($row_track['act']/$row_track['clicks'])*100,2) ."%"; ?></td>
									<td><?php echo $coa=number_format(($row_track['cbs']*0.55*67)/$row_track['act'],2); $coa_sum=$coa_sum+$coa; ?></td>
									<td><?php echo $arpu=number_format($row_track['total_amount']/$row_track['act'],2); $arpu_sum=$arpu_sum+$arpu;?></td>
									
								</tr>
								<?php
								}
								}
								if($b==1)
								{
									while($row_track2=mysql_fetch_array($res2))
								{
								
								?>
								<tr>
									<td><?php echo $row_track2['date'];  ?></td>
									<td><?php echo $row_track2['advname'];  ?></td>
									<td><?php echo number_format($row_track2['clicks']); $click_sum=$click_sum+$row_track2['clicks']; ?></td>
									<td><?php echo number_format($row_track2['activation']); $act_sum=$act_sum+$row_track2['activation'];?></td>
									<td><?php echo number_format($row_track2['amount']); $act_amnt=$act_amnt+$row_track2['amount'];?></td>
									<td><?php $actsp=$row_track2['spo']; echo number_format($actsp); $a=$a+$actsp;?></td>
									<td><?php echo number_format($row_track2['spoamount']); $total_amount=$total_amount+$row_track2['spoamount'];?></td>
									<td><?php echo number_format($row_track2['cbs']); $cbs_sum=$cbs_sum+$row_track2['cbs']; ?></td>
									<td><?php echo number_format($row_track2['cr'],2) ."%"; ?></td>
									<td><?php echo $coa=number_format($row_track2['coa'],2); $coa_sum=$coa_sum+$coa; ?></td>
									<td><?php echo $arpu=number_format($row_track2['arpu'],2); $arpu_sum=$arpu_sum+$arpu;?></td>
									
								</tr>
								<?php
								}
								}
								?>
								
								
								
								<tr>
									<td>Total</td>
									<td></td>
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo number_format($act_amnt); ?></td>
									<td><?php echo number_format($a); ?></td>
								
									<td><?php echo number_format($total_amount); ?></td>
									<td><?php echo  number_format($cbs_sum);?></td>
									<td></td>
									<td><?php echo number_format($coa_sum,2); ?></td>
									<td><?php echo number_format($arpu_sum,2); ?></td>
									
									
									
								</tr>
							</tbody>
							
							
								
								
						</table>
					  </div>
				
			<?php
			}
			else
			{}
			?>
					</div>
                </div>
			</div>
		</div>
        <!-- /page content -->
	<?php
	include("includes/footer.php");
	?>

<script type="text/javascript">

$(document).ready(function(){

    $("#operator").change(function(){
		
		var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel").val('');
			$("#t").hide();
			$("#f").show();
						
		}
        var operator = $("#operator").val();	
		var product= $("#product").val();
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	 


<script type="text/javascript">
function myfun() {
	var x = document.getElementById("product").value;
    //alert(x);
	if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
		select.options[select.options.length] = new Option('SouthAfrica_oxygen', 'south-africa');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Vodafone', 'vodafone');
		select.options[select.options.length] = new Option('Hotshots_Vodafone', 'hotshots_vodafone');
		//select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		select.options[select.options.length] = new Option('Ooredoo_oman', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
		select.options[select.options.length] = new Option('SouthAfrica_oxygen', 'south-africa');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Vodafone', 'vodafone');
		select.options[select.options.length] = new Option('Gamezone_Vodafone', 'gamezone_vodafone');
		//select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
	//	select.options[select.options.length] = new Option('etisalat', 'etisalat');
	//	select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
		//select.options[select.options.length] = new Option('srilanka', 'srilanka');
	}
	
	/*if(x=="glambar")
	{
		 //alert("hi");
	document.getElementById('azharbeizan').style.visibility = 'hidden';
	}else
	{
		document.getElementById('azharbeizan').style.visibility = 'visible';
	}*/
}
</script>	  		