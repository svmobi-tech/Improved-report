<?php
include("includes/check_session.php");
include("includes/connection.php");

//$con=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back
$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
//error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;

if(isset($_POST['submit']))
{

$count=1;
$operator=$_POST['operator'];
$product=$_POST['product'];

	if($start_date == $end_date)
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
	}	
	else
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
	}
$advertiserid=$_POST['advertiserid']; 





// report logic below
	if($product=='hotshots' || $product=='Hotshots')
	{
		
		if($operator=='Vodafone')
		{
			
			//$db="hotshotsdb1";
		//	$dblog="hotshotsdblog1";
			$db='hotshotsnewdb_voda_0417';
			
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
		elseif ($operator=='Airtel')
		{
			$db="hotshotsdb_airtel1";
			$dblog="hotshotsdblog_airtel1";
			
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysql_query($sql_ad);
			
			$db="hotshotsnewdb_airtel_0417";
			if($advertiserid != 'all')
			{
				$db="hotshotsnewdb_airtel_0417";
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
							(SELECT DISTINCT
							subscriptiondetail.txnid act,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								amount,
								1 typ,
								MAX(userlogid)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND DATE(accesstime) = DATE(subscriptionstartdate)
								AND amount > 0
								AND isrenew = 0
								AND subscriptiondetail.charging_mode != 541729
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
								AND subscriptiondetail.charging_mode != 541729
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
								AND senttime <= '".$end_date."'
								AND advertcallback.advertiserid = ".$advertiserid.") aa1
						GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
					GROUP BY dt , adv1"; 
			}
			else
			{
				$db="hotshotsnewdb_airtel_0417";
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
								AND subscriptiondetail.charging_mode != 541729
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
								AND subscriptiondetail.charging_mode != 541729
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
								AND senttime <= '".$end_date."') aa1
						GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
					GROUP BY dt , adv1;
				";
			}
			$res_track=mysql_query($sql_track,$con1);	
					
		}
		else
		{
			
			$db="hotshotsnewdb_idea_0417";
			//$db="hotshotsdb_idea";
			//$db1="hotshotsdb";
			//$dblog="hotshotsdblog_idea";
			
			$sql_ad="select * from ".$db.".advertiser where operator=2";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid != 'all')
			{
					/*$sql_track="select clicks, dt, act, actsp, total_amount,total_amount1, cbs from ( 
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
					select count(*) cbs , DATE(requesttime) dt3 from ".$db1.".requestresponse where requesttime >= '".$start_date."'
					and requesttime <= '".$end_date."' and advertiserid=".$advertiserid." group by dt3 ) d on c.dt22=d.dt3;
					";*/
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
									(SELECT DISTINCT
									subscriptiondetail.txnid act,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										amount,
										1 typ,
										MAX(userlogid)
								FROM
									".$db.".subscriptiondetail
								INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
								INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND DATE(accesstime) = DATE(subscriptionstartdate)
										AND amount > 0
										AND (charging_mode LIKE '%ACT%'
										OR charging_mode LIKE '%UPGRD%')
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
										AND (charging_mode LIKE '%ACT%'
										OR charging_mode LIKE '%UPGRD%')
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
										AND senttime <= '".$end_date."'
										AND advertcallback.advertiserid = ".$advertiserid.") aa1
								GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
							GROUP BY dt , adv1
							   
								   ";					
			}
			else
			{
				
				
				 $sql_track="SELECT 
							bb.dt dt,
							case when adv1 is null then 'other'
							else adv1
							end adv1,
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
							left JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									) a
							GROUP BY dt , advname) b
							LEFT JOIN (SELECT 
								COUNT(b.act) act, dt, advname, SUM(amount) amount, typ
							FROM
								(SELECT DISTINCT
								subscriptiondetail.txnid act,
									advname,
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									amount,
									1 typ,
									MAX(userlogid)
							FROM
								".$db.".subscriptiondetail
							left JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
							left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND DATE(accesstime) = DATE(subscriptionstartdate)
									AND amount > 0
									AND (charging_mode LIKE '%ACT%'
									OR charging_mode LIKE '%UPGRD%')
									
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
							left JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
							left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND DATE(accesstime) < DATE(subscriptionstartdate)
									AND amount > 0
									AND (charging_mode LIKE '%ACT%'
									OR charging_mode LIKE '%UPGRD%')
								   
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
							left JOIN ".$db.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								senttime >= '".$start_date."'
									AND senttime <= '".$end_date."'
									) aa1
							GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
						GROUP BY dt , adv1;";
										
			}
			$res_track=mysql_query($sql_track,$con1);
			
			
		}
		
	}
	else
	{
		if($operator=='Vodafone')
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

	





//echo "<script>window.location='report.php';</script>";



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
						<select name="product" class="form-control" id="product">
							<option>Product</option>
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Select Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
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