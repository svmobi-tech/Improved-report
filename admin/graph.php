<?php 
include("includes/check_session.php");
include("includes/connection.php");
//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
//error_reporting(0);
$con1=$con;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$display='';
$type='';
$title='';
$tenure='';
$d1='';
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
	 
	
	$type=$_POST['type'];
	$display=$_POST['display']; 
	$advertiserid=$_POST['advertiserid'];
	$tenure=$_POST['tenure']; 
	
	
	if($type=='All')
	{
		if($product=='Hotshots')
		{
			if($operator =='Vodafone')
			{
				
				$db='hotshotsdb1';
				$dblog='hotshotsdblog1';
							
				$sql_ad="select * from ".$dblog.".advertiser where operator=1";
				$res_ad=mysql_query($sql_ad);
				
				if($advertiserid != 'all')
				{
				
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
				else
				{
					
					if($tenure=='daily')
					{
						$db="hotshotsnewdb_voda_0417";
						 $sql="SELECT 
									*
								FROM
									(SELECT 
										COUNT(reqid) act_count, dt, SUM(amount) act_amt
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid,
											subscriptiondetail.msisdn,
											DATE(subscriptionstartdate) dt,
											amount,
											isrenew
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									WHERE
										subscriptionstartdate >  '".$start_date."'
											AND subscriptionstartdate <='".$end_date."'
											AND amount > 0
											and isrenew=0) a
									) a1,
									(SELECT 
										COUNT(reqid) ren_count, dt, SUM(amount) ren_amt
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid,
											subscriptiondetail.msisdn,
											DATE(subscriptionstartdate) dt,
											amount,
											isrenew
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									WHERE
										subscriptionstartdate >  '".$start_date."'
											AND subscriptionstartdate <='".$end_date."'
											AND amount > 0
											and isrenew=1) b
									) b1,
									(SELECT 
										COUNT(userlogid) clicks, DATE(AccessTime) dt
									FROM
										".$db.".userlog
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
									GROUP BY dt) c1,
									(SELECT 
										COUNT(reqid) park_count, dt, SUM(amount) park_amt
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid,
											subscriptiondetail.msisdn,
											DATE(subscriptionstartdate) dt,
											amount,
											isrenew
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									WHERE
										subscriptionstartdate >  '".$start_date."'
											AND subscriptionstartdate <='".$end_date."'
											 AND charging_mode = 'PARKING'
											 )d
									) d1,
									(SELECT 
										ROUND(((act1 / act2) * 100), 2) cr, dt, act2
									FROM
										(SELECT 
										COUNT(reqid) act1, dt, SUM(amount) amt
									FROM
										(SELECT DISTINCT
										subscriptiondetail.reqid,
											subscriptiondetail.msisdn,
											DATE(subscriptionstartdate) dt,
											amount,
											isrenew
									FROM
										".$db.".subscriptiondetail
									LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
									WHERE
										subscriptionstartdate >  '".$start_date."'
											AND subscriptionstartdate <='".$end_date."'
											AND amount > 0
											and isrenew=0) b
									GROUP BY dt) c, (SELECT 
										COUNT(userlogid) act2, DATE(AccessTime) dt1
									FROM
										".$db.".userlog
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
									GROUP BY dt1) d
									WHERE
										d.dt1 = c.dt) e4,
									(SELECT 
										COUNT(msisdn) cb, dt
									FROM
										(SELECT DISTINCT
										advertcallback.txnid,advertcallback.msisdn, DATE(senttime) dt
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".advertcallback ON subscriptiondetail.reqid = advertcallback.txnid
									WHERE
										senttime >   '".$start_date."'
										 AND senttime <= '".$end_date."'
										   ) s
									GROUP BY dt) f5
								WHERE
									f5.dt = e4.dt AND e4.dt = d1.dt
										AND d1.dt = c1.dt
										AND c1.dt = b1.dt
										AND b1.dt = a1.dt";
						$res=mysql_query($sql,$con1);
					}
					elseif($tenure=='weekly')
					{
						
						
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
						
					}
					else
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb 
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
			}
			elseif($operator =='Airtel')
			{
				
				$db='hotshotsdb_airtel1';
				$dblog='hotshotsdblog_airtel1';
							
				$sql_ad="select * from ".$dblog.".advertiser ";
				$res_ad=mysql_query($sql_ad);
				
				if($advertiserid != 'all')
				{
				
					if($tenure == 'daily')
					{
						echo $sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'  and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						 AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						 and annonymoustracking.advertiserid > -1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'  and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
				else
				{
					
					if($tenure=='daily')
					{
						
						$sql="
							SELECT 
									*
								FROM
									(SELECT 
										COUNT(mobilenumber) act_count, dt, SUM(amount) act_amt
									FROM
										(SELECT DISTINCT
										mobilenumber, dt, amount
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) dt,
											MAX(annonymoustrackingid) atid,
											amount
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 0
											AND amount > 0
											AND (DATE(accesstime) = DATE(subscriptionstartdate)
											OR DATE(accesstime) < DATE(subscriptionstartdate))
											AND annonymoustracking.advertiserid > - 1
											AND accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
										   
									GROUP BY subscriptiondetail.subscriberid , dt , advertiser.advertiserid) a ON a.atid = annonymoustrackingid) b
									GROUP BY dt) a1,
									(SELECT 
										COUNT(mobilenumber) ren_count, dt, SUM(amount) ren_amt
									FROM
										(SELECT DISTINCT
										mobilenumber, dt, amount
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) dt,
											MAX(annonymoustrackingid) atid,
											amount
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 1
											AND annonymoustracking.advertiserid > - 1
									GROUP BY subscriptiondetail.subscriberid , dt , advertiser.advertiserid) a ON a.atid = annonymoustrackingid) b
									GROUP BY dt) b1,
									(SELECT 
										COUNT(annonymoustrackingid) clicks, DATE(AccessTime) dt
									FROM
										".$dblog.".annonymoustracking
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
									GROUP BY dt) c1,
									(SELECT 
										COUNT(mobilenumber) park_count, dt, SUM(amount) park_amt
									FROM
										(SELECT DISTINCT
										mobilenumber, dt, amount
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) dt,
											MAX(annonymoustrackingid) atid,
											amount
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND charging_mode = '541729'
											AND amount=0
											AND errorcode=1000
											AND annonymoustracking.advertiserid > - 1
											
									GROUP BY subscriptiondetail.subscriberid , dt , advertiser.advertiserid) a ON a.atid = annonymoustrackingid) b
									GROUP BY dt) d1,
									(SELECT 
										ROUND(((act1 / act2) * 100), 2) cr, dt, act2
									FROM
										(SELECT 
										COUNT(mobilenumber) act1, dt, SUM(amount) amt
									FROM
										(SELECT DISTINCT
										mobilenumber, dt, amount
									FROM
										".$dblog.".annonymoustracking
									INNER JOIN (SELECT 
										mobilenumber,
											DATE(subscriptionstartdate) dt,
											MAX(annonymoustrackingid) atid,
											amount
									FROM
										".$db.".subscriptiondetail
									INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
									INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
									INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
									WHERE
										subscriptionstartdate >= '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND isrenew = 0
											AND amount > 0
											AND DATE(accesstime) = DATE(subscriptionstartdate)
											AND annonymoustracking.advertiserid > - 1
											AND accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
										 
									GROUP BY subscriptiondetail.subscriberid , dt , advertiser.advertiserid) a ON a.atid = annonymoustrackingid) b
									GROUP BY dt) c, (SELECT 
										COUNT(annonymoustrackingid) act2, DATE(AccessTime) dt1
									FROM
										".$dblog.".annonymoustracking
									WHERE
										accesstime >= '".$start_date."'
											AND accesstime < '".$end_date."'
									GROUP BY dt1) d
									WHERE
										d.dt1 = c.dt) e4,
									(SELECT 
										COUNT(requestresponseid) cb, DATE(requesttime) dt
									FROM
										".$db.".requestresponse
									WHERE
										requesttime >= '".$start_date."'
											AND requesttime < '".$end_date."'
									GROUP BY dt) f5
								WHERE
									f5.dt = e4.dt AND e4.dt = d1.dt
										AND d1.dt = c1.dt
										AND c1.dt = b1.dt
										AND b1.dt = a1.dt";
										$res=mysql_query($sql,$con);
					}
					elseif($tenure=='weekly')
					{
						
						
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						AND charging_mode = '541729' AND amount=0  AND errorcode=1000 and annonymoustracking.advertiserid > -1  
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb 
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						AND charging_mode = '541729' AND amount=0  AND errorcode=1000 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
			}
			else
			{
				$db='hotshotsdb_idea';
				$db1='hotshotsdb';
				$dblog='hotshotsdblog_idea';
							
				$sql_ad="select * from ".$dblog.".advertiser where operator=2";
				$res_ad=mysql_query($sql_ad);
				
				
				if($advertiserid != 'all')
				{
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and advertiserid='".$advertiserid."' and accesstime < '".$end_date."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt";
					$res=mysql_query($sql,$con);
				}
					elseif($tenure == 'weekly')
					{
						$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb			
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and advertiserid='".$advertiserid."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
					$sql="select f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
					sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb			
					from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and advertiserid='".$advertiserid."' and accesstime < '".$end_date."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
					$res=mysql_query($sql,$con);
				}
					
				}
				else
				{
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db1.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
					
					
				}
			}
		}
		else
		{
			if($operator == 'Vodafone')
			{
				$db='gamesdb_voda';
				$dblog='gamesdblog_voda';
							
				$sql_ad="select * from ".$dblog.".advertiser where operator=1";
				$res_ad=mysql_query($sql_ad);
				
				if($advertiserid != 'all')
				{
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and advertiser.advertiserid='".$advertiserid."'
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt";
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb	
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and advertiser.advertiserid='".$advertiserid."'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb	
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and advertiser.advertiserid='".$advertiserid."'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
				else
				{
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
					and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt";
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by week(f5.dt)" ;
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and isrenew=0 and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=1 and annonymoustracking.advertiserid > -1 and operator=1 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and annonymoustracking.advertiserid > -1 and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)" ;
						$res=mysql_query($sql,$con);
					}
					

				}
				
				
			}
			else
			{
				$db='gamesdb';
				
				$dblog='gamesdblog_idea';
							
				$sql_ad="select * from ".$dblog.".advertiser where operator=2 ";
				$res_ad=mysql_query($sql_ad);
				
				if($advertiserid != 'all')
				{
					if($tenure == 'daily')
					{
						echo $sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."' 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
					and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt"; exit;
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and advertiser.advertiserid='".$advertiserid."'
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and advertiser.advertiserid='".$advertiserid."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
					
				else
				{
					if($tenure == 'daily')
					{
						$sql="select * from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
					and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
					or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

					(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
					advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
					
					(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

					(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
					and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

					(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
					and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
					select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
					where accesstime >= '".$start_date."' 
					and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
					(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
					where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt";
					$res=mysql_query($sql,$con);
					}
					elseif($tenure  == 'weekly')
					{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/7),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by WEEK(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					else{
						$sql="select 
						f5.dt, sum(act_count) act_count, sum(act_amt) act_amt, sum(ren_count) ren_count, sum(ren_amt) ren_amt,
						sum(park_count) park_count,sum(park_amt) park_amt,ROUND((sum(cr)/31),2) cr ,sum(clicks) clicks, sum(cb) cb
						from (select count(mobilenumber) act_count, dt, sum(amount) act_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate <'".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 and (date(accesstime) = date(subscriptionstartdate) 
						or date(accesstime) < date(subscriptionstartdate)) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)a1,

						(select count(mobilenumber) ren_count, dt, sum(amount) ren_amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%REN%' and annonymoustracking.advertiserid > -1 and operator=2 group by subscriptiondetail.subscriberid, dt, 
						advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)b1,
						
						(select count(annonymoustrackingid) clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt) c1,

						(select count(mobilenumber) park_count, dt, sum(amount) park_amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount = 0  and annonymoustracking.advertiserid > -1 and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) d1,

						(select ROUND(((act1/act2)*100),2) cr,dt,act2 from ( select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%' 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate) and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c, (
						select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking 
						where accesstime >= '".$start_date."' 
						and accesstime < '".$end_date."'group by dt1) d where d.dt1=c.dt) e4,
						(select count(requestresponseid) cb, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' group by dt) f5
						where f5.dt=e4.dt and e4.dt=d1.dt and d1.dt=c1.dt and c1.dt=b1.dt and b1.dt=a1.dt group by MONTH(f5.dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
				
			}
		}
	
		
	//	$res=mysql_query($sql);
		$num=mysql_num_rows($res);
		$act_count='';
		$ren_count='';
		$park='';
		$clicks='';
		$cr='';
		$cb='';
		
		while($row=mysql_fetch_array($res))
		{
			
				if($num==1)
				{
					$act_count.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['act_count'].",Amount:".$row['act_amt']."}";
					$ren_count.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['ren_count'].",Amount:".$row['ren_amt']."}";
					$park.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['park_count']."}";
					$clicks.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['clicks']."}";
					$cr.="{date: '".date("Y-m-d",strtotime($row['dt']))."',CR:".$row['cr']."}";
					$cb.="{date: '".date("Y-m-d",strtotime($row['dt']))."',CB:".$row['cb']."}";
					
				}
				else
				{
					$act_count.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['act_count'].",Amount:".$row['act_amt']."},";
					$ren_count.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['ren_count'].",Amount:".$row['ren_amt']."},";	
					$park.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['park_count']."},";
					$clicks.="{date: '".date("Y-m-d",strtotime($row['dt']))."',Count:".$row['clicks']."},";	
					$cr.="{date: '".date("Y-m-d",strtotime($row['dt']))."',CR:".$row['cr']."},";	
					$cb.="{date: '".date("Y-m-d",strtotime($row['dt']))."',CB:".$row['cb']."},";				
					$num--;
				}
			
			
		}	
		
		
	}
	else
	{

	}
	
	if($product == 'Hotshots') // hotshots
	{
		if($operator == 'Vodafone') // hotshots->voda
		{
			$db='hotshotsdb1';
			$dblog='hotshotsdblog1';
					
			$sql_ad="select * from ".$dblog.".advertiser where operator=1";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all') // hotshots->voda->all
			{
				if($type=='Activation') // hotshots->voda->all->Activation
				{
					$title='Activation';
					if($tenure == 'daily' )
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
					 	$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by WEEK(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by MONTH(dt)";
						$res=mysql_query($sql,$con);						
					}
									}
				elseif($type=='Renewal') // hotshots->voda->all->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure== 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (
						select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (
						select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by MONTH(dt)
						";
						$res=mysql_query($sql,$con);
					}
						
					
				}
				elseif($type == 'Clicks') // hotshots->voda->all->Clicks
				{
					$title='Clicks';
					if($tenure=='daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure=='weekly')
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}				
					else
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt ) a group by MONTH(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // hotshots->voda->all->Parking
				{
					$title='Parking';	
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt) 
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act ,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by month(dt) 
						";
						$res=mysql_query($sql,$con);
					}
					 
				}
				elseif($type=='Callbacks') // hotshots->voda->all->Callbacks
				{
					$title='Callbacks';
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt	"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						
						$sql="select sum(act) act,dt from (
						select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt
						) a group by week(dt)"; 
						$res=mysql_query($sql,$con);

					}
					else
					{
						$sql="select sum(act) act,dt from (
						select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt
						) a group by month(dt)"; 
						$res=mysql_query($sql,$con);
					}
				}
				else // hotshots->voda->all->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif( $tenure == 'weekly')
					{
					 	$sql="select sum(act) act, dt, sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) a
						group by week(dt)";  
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) a
						group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
					$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
					$res=mysql_query($sql,$con);					
				}
			}
			else // hotshots->voda->advertiser wise
			{
				if($type=='Activation') // hotshots->voda->advertiser wise->Activation
				{
					$title='Activation';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act ,dt,sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
						
					 
				}
				elseif($type=='Renewal') // hotshots->voda->advertiser wise->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type == 'Clicks') // hotshots->voda->advertiser wise->Clicks
				{
					$title='Clicks';
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						"; 
						$res=mysql_query($sql,$con);

					}
					elseif( $tenure == 'weekly' )
					{
						$sql="select sum(act) act,dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						) a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else 
					{
						$sql="select sum(act) act,dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						) a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // hotshots->voda->advertiser wise->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode = 'PARKING' and advertiser.advertiserid=".$advertiserid."
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and advertiser.advertiserid=".$advertiserid."
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode = 'PARKING' and advertiser.advertiserid=".$advertiserid."
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by month(dt)
						";
						$res=mysql_query($sql,$con);
						
					}
					
				}
				elseif($type=='Callbacks') // hotshots->voda->advertiser wise->Callbacks
				{
					$title='Callbacks';
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."'
						group by dt	"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' 
						group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);						
					}
					else
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' 
						group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				else // hotshots->voda->advertiser wise->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);
					}
					elseif( $tenure == 'weekly' )
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
					 
				}
			}
		}
		elseif($operator == 'Airtel') // hotshots->Airtel
		{
			$db='hotshotsdb_airtel1';
			$dblog='hotshotsdblog_airtel1';
					
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all') // hotshots->Airtel->all
			{
				if($type=='Activation') // hotshots->Airtel->all->Activation
				{
					$title='Activation';
					if($tenure == 'daily' )
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
					 	$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by WEEK(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by MONTH(dt)";
						$res=mysql_query($sql,$con);						
					}
									}
				elseif($type=='Renewal') // hotshots->Airtel->all->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure== 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (
						select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (
						select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by MONTH(dt)
						";
						$res=mysql_query($sql,$con);
					}
						
					
				}
				elseif($type == 'Clicks') // hotshots->Airtel->all->Clicks
				{
					$title='Clicks';
					if($tenure=='daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure=='weekly')
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}				
					else
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt ) a group by MONTH(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // hotshots->Airtel->all->Parking
				{
					$title='Parking';	
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt) 
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act ,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by month(dt) 
						";
						$res=mysql_query($sql,$con);
					}
					 
				}
				elseif($type=='Callbacks') // hotshots->Airtel->all->Callbacks
				{
					$title='Callbacks';
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt	"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						
						$sql="select sum(act) act,dt from (
						select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt
						) a group by week(dt)"; 
						$res=mysql_query($sql,$con);

					}
					else
					{
						$sql="select sum(act) act,dt from (
						select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt
						) a group by month(dt)"; 
						$res=mysql_query($sql,$con);
					}
				}
				else // hotshots->Airtel->all->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate) 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);
					}
					elseif( $tenure == 'weekly')
					{
					 	$sql="select sum(act) act, dt, sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) a
						group by week(dt)";  
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) a
						group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
					$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
					$res=mysql_query($sql,$con);					
				}
			}
			else // hotshots->Airtel->advertiser wise
			{
				if($type=='Activation') // hotshots->Airtel->advertiser wise->Activation
				{
					$title='Activation';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act ,dt,sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
						
					 
				}
				elseif($type=='Renewal') // hotshots->Airtel->advertiser wise->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1   and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1   and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type == 'Clicks') // hotshots->Airtel->advertiser wise->Clicks
				{
					$title='Clicks';
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						"; 
						$res=mysql_query($sql,$con);

					}
					elseif( $tenure == 'weekly' )
					{
						$sql="select sum(act) act,dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						) a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else 
					{
						$sql="select sum(act) act,dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt
						) a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // hotshots->Airtel->advertiser wise->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by week(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						AND charging_mode = '541729' AND amount=0 AND errorcode=1000 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						) a group by month(dt)
						";
						$res=mysql_query($sql,$con);
						
					}
					
				}
				elseif($type=='Callbacks') // hotshots->Airtel->advertiser wise->Callbacks
				{
					$title='Callbacks';
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse 
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."'
						group by dt	"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' 
						group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid='".$advertiserid."' 
						group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				else // hotshots->Airtel->advertiser wise->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);
					}
					elseif( $tenure == 'weekly' )
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."'
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' 
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  
						group by dt1) d where d.dt1=c.dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
					 
				}
			}
		}
		else // hotshots->idea
		{
			$db='hotshotsdb_idea';
			$db1='hotshotsdb';
			$dblog='hotshotsdblog_idea';
					
			$sql_ad="select * from ".$dblog.".advertiser where operator=2";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all') // hotshots->Idea->all
			{
				if($type=='Activation') // hotshots->Idea->all->Activation
				{
					$title='Activation';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);						
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type=='Renewal') // hotshots->Idea->all->Renewal
				{
					$title='Renewal';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt,sum(amt) amt from (select  count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt);
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt,sum(amt) amt from (select  count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt);
						";
						$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type == 'Clicks') // hotshots->Idea->all->Clicks
				{
					$title='Clicks';
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt from ( select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}

				}
				elseif($type== 'Parking') // hotshots->Idea->all->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily' )
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				
					
				}
				elseif($type=='Callbacks') // hotshots->Idea->all->Callbacks
				{
					$title='Callbacks';
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt	"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt from ( select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt) a group by week(dt)	";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt from ( select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt) a group by month(dt)	";
						$res=mysql_query($sql,$con);
					}
					
				}
				else // hotshots->Idea->all->CR
				{
					$title='CR';
					if( $tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt  from (  select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt  from (  select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					 
				}
			}
			
			else // hotshots->Idea->advertiser wise
			{
				if($type=='Activation') // hotshots->Idea->advertise wise->Activation
				{
					$title='Activation';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by week(dt)";
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					 
				}
				elseif($type=='Renewal') // hotshots->Idea->advertise wise->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						";
						$res=mysql_query($sql,$con);
					}
					elseif( $tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type == 'Clicks') // hotshots->Idea->advertise wise->Clicks
				{
					$title='Clicks';
					
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly' )

					{
						$sql="select sum(act) act, dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt)
						a group by week(dt)";
						$res=mysql_query($sql,$con);
						
					}
					else
					{
						$sql="select sum(act) act, dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt)
						a group by month(dt)";
						$res=mysql_query($sql,$con);
						

					}
				
					
				}
				elseif($type== 'Parking') // hotshots->Idea->advertise wise->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly' )
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt  from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type=='Callbacks') // hotshots->Idea->advertise wise->Callbacks
				{
					$title='Callbacks';
					if($tenure =='daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt	"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt) a group by week(dt)	"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db1.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."    group by dt) a group by month(dt)	"; 
						$res=mysql_query($sql,$con);
					}
				}
				else // hotshots->Idea->advertise wise->CR
				{
					$title='CR';
					
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
						advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum() act,dt,sum() amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
						advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."' 
						group by dt1) d where d.dt1=c.dt) a group by week(dt)";
						$res=mysql_query($sql,$con);						
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
						advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."' 
						group by dt1) d where d.dt1=c.dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
				}
			}
		}
	}
	else // games
	{
		if($operator == 'Vodafone') //games-> voda
		{
			$db='gamesdb_voda';
			$dblog='gamesdblog_voda';
					
			$sql_ad="select * from ".$dblog.".advertiser where operator=1";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all') // games->voda->all
			{
				if($type=='Activation') // games->voda->all->Activation
				{
					$title='Activation';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt , sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt , sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					 
				}
				elseif($type=='Renewal') // games->voda->all->Renewal
				{
					$title='Renewal';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type == 'Clicks') // games->voda->all->Clicks
				{
					$title='Clicks';
					
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt";
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);

					}
					else{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // games->voda->all->Parking
				{
					$title='Parking';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)						
						"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)						
						";  
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type=='Callbacks') // games->voda->all->Callbacks
				{
					$title='Callbacks';
						
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt	"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt)a group by week(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'   group by dt)a group by month(dt)"; 
						$res=mysql_query($sql,$con);
					}
				}
				else // games->voda->all->CR
				{
					$title='CR';
					
					if($tenure == 'daily' )
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);						
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt) a 
						group by week(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from ( ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt) a 
						group by month(dt)"; 
						$res=mysql_query($sql,$con);
					}
					
				}
			}
			else // games->voda->advertiser wise
			{
				if($type=='Activation') // games->voda->advertiser wise->Activation
				{
					$title='Activation';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt, sum(amt) amt  from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by week(dt)";
						$res=mysql_query($sql,$con);						
						
					}
					else
					{
						$sql="select sum(act) act,dt, sum(amt) amt  from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and isrenew=0 and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1
						and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt ) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					 
				}
				elseif($type=='Renewal') // games->voda->advertiser wise->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
						";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=1
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type == 'Clicks') // games->voda->advertiser wise->Clicks
				{
					$title='Clicks';
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt";
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt)
						a group by week(dt)";
						$res=mysql_query($sql,$con);

					}
					else
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' and advertiserid=".$advertiserid." group by dt)
						a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // games->voda->advertiser wise-> Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
						and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
						"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
					and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
					a group by week(dt)
					"; 
					$res=mysql_query($sql,$con);
					}
					else{
							$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode = 'PARKING'
					and annonymoustracking.advertiserid > -1  and operator=1 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
					a group by month(dt)
					"; 
					$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type=='Callbacks') // games->voda->advertiser wise->Callbacks
				{
					$title='Callbacks';
					if($tenure =='daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt	"; 
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt) a group by week(dt)	"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt) a group by month(dt)	";
						$res=mysql_query($sql,$con);
					}
				}
				else // games->voda->advertiser wise->CR
				{
					$title='CR';
					
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid."  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt";
						$res=mysql_query($sql,$con);						
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt , sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid."  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
						a group by week(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					else{
						$sql="select sum(act) act, dt , sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and isrenew=0 and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=1 
						and advertiser.advertiserid=".$advertiserid." 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and advertiserid=".$advertiserid."  and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
						a group by month(dt)
						"; 
						$res=mysql_query($sql,$con);
					}
					
				}
			}
		}
		else // games-> idea
		{
			$db='gamesdb';
			$dblog='gamesdblog_idea';
					
			$sql_ad="select * from ".$dblog.".advertiser where operator=2";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all') // games->Idea->all
			{
				if($type=='Activation') // games->Idea->all->Activation
				{
					$title='Activation';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt";
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt , sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);
					}
					else{
							
						$sql="select sum(act) act,dt , sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
						select distinct mobilenumber, dt,amount
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
						amount
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
						and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
						date(accesstime) < date(subscriptionstartdate))
						and annonymoustracking.advertiserid > -1
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
						group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
					
					 
				}
				elseif($type=='Renewal') // games->Idea->all->Renewal
				{
					$title='Renewal';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
					and annonymoustracking.advertiserid > -1  and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
					";
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type == 'Clicks') // games->Idea->all->Clicks
				{
					$title='Clicks';
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt";
						$res=mysql_query($sql,$con);

					}
					elseif($tenure == 'weekly')
					{
						$sql="select sun(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by week(dt)";
						$res=mysql_query($sql,$con);

					}
					else{
						
						$sql="select sun(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."' group by dt) a group by month(dt)";
						$res=mysql_query($sql,$con);

					}
				}
				elseif($type== 'Parking') // games->Idea->all->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
					charging_mode like '%ACT%' and amount = 0 
					and annonymoustracking.advertiserid > -1  and operator=2 
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
					"; 
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
					";
					$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
						charging_mode like '%ACT%' and amount = 0 
						and annonymoustracking.advertiserid > -1  and operator=2 
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
					";
					$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type=='Callbacks') // games->Idea->all->Callbacks
				{
					$title='Callbacks';
					
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt	"; 
						$res=mysql_query($sql,$con);

					}
					elseif( $tenure == 'weekly')
					{
						$sql="select sum(act) act,dt from(select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt	) a group by week(dt)"; 
						$res=mysql_query($sql,$con);

					}
					else{
						$sql="select sum(act) act,dt from(select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."'    group by dt	) a group by month(dt)";
						$res=mysql_query($sql,$con);						
					}
				}
				else // games->Idea->all->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
					and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt"; 
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) 
						a group by week(dt)"; 
						$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act, dt, sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
						select count(mobilenumber) act1, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
						and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
						and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
						(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
						where accesstime >= '".$start_date."' and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt ) 
						a group by month(dt)"; 
						$res=mysql_query($sql,$con);
					}
					
					
				}
			}
			else // games->Idea->advertiser wise
			{
				if($type=='Activation') // games->Idea->advertise wise->Activation
				{
					$title='Activation';
				
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from (
					select distinct mobilenumber, dt,amount
					from ".$dblog.".annonymoustracking inner join (
					select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
					amount
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
					date(accesstime) < date(subscriptionstartdate))
					and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
					group by dt";
					$res=mysql_query($sql,$con);
					}
				elseif($tenure == 'weekly')
				{
					$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
					select distinct mobilenumber, dt,amount
					from ".$dblog.".annonymoustracking inner join (
					select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
					amount
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
					date(accesstime) < date(subscriptionstartdate))
					and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
					group by dt ) a group by week(dt)";
					$res=mysql_query($sql,$con);
				}
				else{
					$sql="select sum(act) act,dt, sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from (
					select distinct mobilenumber, dt,amount
					from ".$dblog.".annonymoustracking inner join (
					select mobilenumber,  date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid,
					amount
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and  (date(accesstime) = date(subscriptionstartdate) or
					date(accesstime) < date(subscriptionstartdate))
					and annonymoustracking.advertiserid > -1 and advertiser.advertiserid=".$advertiserid."
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b 
					group by dt ) a group by month(dt)";
					$res=mysql_query($sql,$con);
				}
					 
				}
				elseif($type=='Renewal') // games->Idea->advertise wise->Renewal
				{
					$title='Renewal';
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
					and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt;
					";
					$res=mysql_query($sql,$con);
					}
					elseif($tenure =='weekly')
					{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by week(dt)
						";
						$res=mysql_query($sql,$con);
					}
					else{
						$sql="select sum(act) act,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
						select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
						select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%REN%'
						and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
						group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
						a group by month(dt)
						";
						$res=mysql_query($sql,$con);
					}
					
				}
				elseif($type == 'Clicks') // games->Idea->advertise wise->Clicks
				{
					$title='Clicks';
					
					if($tenure == 'daily')
					{
						$sql="select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking   where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt";
						$res=mysql_query($sql,$con);

					}
					elseif($tenure  == 'weekly')
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking  
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt )
						a group by week(dt)";
						$res=mysql_query($sql,$con);

					}
					else
					{
						$sql="select sum(act) act,dt from (select count(annonymoustrackingid) act, date(AccessTime) dt from ".$dblog.".annonymoustracking  
						where accesstime >= '".$start_date."'  and accesstime < '".$end_date."'  and advertiserid=".$advertiserid." group by dt )
						a group by month(dt)";
						$res=mysql_query($sql,$con);
					}
				}
				elseif($type== 'Parking') // games->Idea->advertise wise->Parking
				{
					$title='Parking';
					
					if($tenure == 'daily')
					{
						$sql="select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
					charging_mode like '%ACT%' and amount = 0 
					and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt
					"; 
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act ,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
					charging_mode like '%ACT%' and amount = 0 
					and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
					a group by week(dt)
					"; 
					$res=mysql_query($sql,$con);
					}
					else{
						$sql="select sum(act) act ,dt,sum(amt) amt from (select count(mobilenumber) act, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt, amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt, max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and 
					charging_mode like '%ACT%' and amount = 0 
					and annonymoustracking.advertiserid > -1  and operator=2 and advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt)
					a group by month(dt)
					"; 
					$res=mysql_query($sql,$con);
					}
					
					
				}
				elseif($type=='Callbacks') // games->Idea->advertise wise->Callbacks
				{
					$title='Callbacks';
					
					if($tenure == 'daily')
					{
						$sql="select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."    group by dt	"; 
						$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{					
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."    group by dt) a group by week(dt)	"; 
						$res=mysql_query($sql,$con);
						
					}
					else{
						
						$sql="select sum(act) act,dt from (select count(requestresponseid) act, date(requesttime) dt from ".$db.".requestresponse  
						where requesttime > '".$start_date."' and requesttime < '".$end_date."' and advertiserid=".$advertiserid."   group by dt) a group by month(dt)	"; 
						$res=mysql_query($sql,$con);
					}
					
					
				}
				else // games->Idea->advertise wise->CR
				{
					$title='CR';
					if($tenure == 'daily')
					{
						$sql="select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
					and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
					advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt"; 
					$res=mysql_query($sql,$con);
					}
					elseif($tenure == 'weekly')
					{
						$sql="select sum(act) act,dt, sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
					and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
					advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
					a group by week(dt)"; 
					$res=mysql_query($sql,$con);
					}
					else
					{
						$sql="select sum(act) act,dt, sum(amt) amt from (select ROUND(((act1/act2)*100),2) act,dt,amt,act2 from ( 
					select count(mobilenumber) act1, dt, sum(amount) amt from ( 
					select distinct mobilenumber, dt,amount from ".$dblog.".annonymoustracking inner join ( 
					select mobilenumber, date(subscriptionstartdate) dt,  max(annonymoustrackingid) atid, amount 
					from ".$db.".subscriptiondetail 
					inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid 
					inner join ".$dblog.".annonymoustracking on mobilenumber = userid 
					inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid 
					where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' and charging_mode like '%ACT%'
					and amount > 0 and date(accesstime) = date(subscriptionstartdate)  and annonymoustracking.advertiserid > -1 
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and operator=2 and
					advertiser.advertiserid=".$advertiserid."
					group by subscriptiondetail.subscriberid, dt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b group by dt) c,
					(select count(annonymoustrackingid) act2, date(AccessTime) dt1 from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and advertiserid=".$advertiserid." and accesstime < '".$end_date."'  group by dt1) d where d.dt1=c.dt)
					a group by month(dt)"; 
					$res=mysql_query($sql,$con);
					}
					
					
					
				}
			}
		}
	}
	//$res=mysql_query($sql,$con);
	$num=mysql_num_rows($res);
	$d1='';
	
	if($type=='Clicks' || $type=='Parking' || $type=='CR' || $type == 'Callbacks' ||$type == 'Total' )
	{
		$display='Count';
	}

	
	
	$c=0;
	while($row=mysql_fetch_array($res))
	{ 

			if($num == 1)
			{ 
				if($display=='Count')
				{
					$d1.="{date: '".date("Y-m-d",strtotime($row['dt']))."',winners: ".$row['act']."}";
				}
				else
				{
					$d1.="{date: '".date("Y-m-d",strtotime($row['dt']))."',winners:".$row['amt']."}";
				}
				
				break;
			}				 
			else
			{
				if($display=='Count')
				{
					$d1.="{date: '".date("Y-m-d",strtotime($row['dt']))."',winners: ".$row['act']."},";
					$num--;
				}
				else
				{
					$d1.="{date: '".date("Y-m-d",strtotime($row['dt']))."',winners: ".$row['amt']."},";
					$num--;
				}
			}
		 
	}
	 
}


include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<?php include("includes/top_navigation.php"); ?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="footer_down">

            
            <br />
			
			 <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Graphical Report</h2>
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
					<input type="text" hidden value="<?php echo $count; ?>"   id="check1">
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product">
							<option>Product</option>
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Operator</option>
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
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Tenure
								<select name="tenure" class="form-control">
									<option value="daily">Daily</option>
									<option value="weekly" <?php $selected=''; if($tenure=='weekly') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Weekly</option>
									
									<option value="monthly" <?php  $selected=''; if($tenure=='monthly') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Monthly</option>
								</select>
								
						</div>
						
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Type
								<select name="type" class="form-control">
									<option value="All">All</option>
									<option value="Activation" <?php $selected=''; if($type=='Activation') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Activation</option>
									<option value="Renewal" <?php  $selected=''; if($type=='Renewal') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Renewal</option>
									<option value="Churn" <?php  $selected=''; if($type=='Churn') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Churn</option>
									<option value="Clicks" <?php  $selected=''; if($type=='Clicks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Clicks</option>
									
									<option value="Parking" <?php  $selected=''; if($type=='Parking') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Parking</option>
									<option value="CR" <?php  $selected=''; if($type=='CR') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>CR</option>
									
									<option value="Callbacks" <?php  $selected=''; if($type=='Callbacks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callbacks</option>
								
								</select>
								
							</div>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
								<select name="display" class="form-control">
							
								<option value="Count" <?php  $selected=''; if($display=='Count') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Count</option>
								<option value="Amount" <?php  $selected=''; if($display=='Amount') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Amount</option>
							
								</select>
							</div>
						
						
						<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 orm-group has-feedback first"> Advertiser
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-3 form-group has-feedback two"> Advertiser
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
						
					</div>
					<div class="x_content">

                     
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>

<?php 
if($type!='All')
{
?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
            </div>
<?php 
}
else
{
?>
			<div class="row">
              
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Activation Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line1" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			  
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Renewal Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line2" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Parking Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line3" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Clicks Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line4" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>CR Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line5" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			  <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Callbacks Graph</h2>
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
                  <div class="x_content2">
                    <div id="graph_line6" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div> 
			  
			 
			  
            </div>
			
			
			
			
<?php
}
?>
        <!-- footer content -->
        
		<?php 
		include("includes/footer.php");
		?>
    
 
 <script type="text/javascript">
 
      $(document).ready(function() {		

		if ($("#graph_line").length > 0) {
		
		$(function() {
			
				Morris.Line({
				  element: 'graph_line',
				  data: [
								<?php echo $d1; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['winners'],
				  
				
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['<?php echo $title; ?>'],
				  lineColors: ['#167f39'],
				  lineWidth: 2,
				
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
	  });
</script>
<script type="text/javascript">

		 $(document).ready(function() {
		if ($("#graph_line1").length > 0) {
			
		$(function() {
			
				Morris.Line({
				  element: 'graph_line1',
				  data: [
								<?php echo $act_count; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['Count','Amount'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['Count','Amount'],
				  lineColors: ['#167f39','#167fdd'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		if ($("#graph_line2").length > 0) {
		$(function() {
			
				Morris.Line({
				  element: 'graph_line2',
				  data: [
								<?php echo $ren_count; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['Count','Amount'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['Count','Amount'],
				  lineColors: ['#167f39','#167fdd'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		if ($("#graph_line3").length > 0) {
		$(function() {
			
				Morris.Line({
				  element: 'graph_line3',
				  data: [
								<?php echo $park; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['Count'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['Count'],
				  lineColors: ['#167f39','#167fdd'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		if ($("#graph_line4").length > 0) {
		$(function() {
			
				Morris.Line({
				  element: 'graph_line4',
				  data: [
								<?php echo $clicks; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['Count'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['Count'],
				  lineColors: ['#167f39'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		if ($("#graph_line5").length > 0) {
		$(function() {
			
				Morris.Line({
				  element: 'graph_line5',
				  data: [
								<?php echo $cr; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['CR'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['CR'],
				  lineColors: ['#167f39'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		if ($("#graph_line6").length > 0) {
		$(function() {
			
				Morris.Line({
				  element: 'graph_line6',
				  data: [
								<?php echo $cb; ?>
							  ],
				  xkey: 'date',
				  ykeys: ['CB'],
				  xLabelFormat: function(date) {
					  return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear(); 
					  },
				  xLabels:'day',
				  labels: ['CB'],
				  lineColors: ['#167f39'],
				  lineWidth: 2,
				  dateFormat: function(date) {
					  d = new Date(date);
					  return d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear(); 
					  }
				
				});	
		});
		
		}
		
		
});


    </script>
 
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
		var product=$("#product").val();
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	 


 </body>
</html>