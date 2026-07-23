<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); //cluster 1
$date1=date('Y-m-d');
$date2=date('Y-m-d', strtotime($date1 .' -2 day'));
$con1=$con;
error_reporting(0);
$sum=0;
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
		
		//$type=$_POST['type'];
		//$display=$_POST['display']; 
		//$advertiserid=$_POST['advertiserid'];
		$b=$c=0;
		if($start_date == $end_date)
		{
			$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
			$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
			$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
			$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
			//$hours=$_POST['hours'];
		}	
		else
		{
			$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
			$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
			$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
			$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
			//$hours=$_POST['hours'];
		}
		
		/*if($product== 'glambar' && $operator=='Airtel')
		{
				if($end_date1 > $date2 && $start_date1 > $date2)
				{
					$c=1;
					
					
				}
				else if($start_date1 <= $date2 && $end_date1 > $date2)
				{
					$b=1;
					$c=1;
					
				}
				else{
					$b=1;
					
				}
			
		}	
		else{*/
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
		}
		
	if($product== 'gamebar')
	{
		if($operator=='Vodafone-Qatar')
		{
			$db='gamebardb_vodafone_qatar';
			$report='gamebardb_vodafone_qatar_report';
			
			if($b==1)
			{
				$sql2="select * from ".$report.".actdct_report where date >= '".$start_date1."' and date <= '".$end_date1."' and operator='".$operator."' and product='".$product."'"; 
				//echo $sql2;
				//exit;		
			$res2=mysql_query($sql2,$con1);
			
				
			}
			if($c==1)
			{
				
				$start_date=$date1." 00:00:00";
				$end_date=$date1." 23:59:59";
			 $sql="
				SELECT 
					aa.dt dt1,
					COUNT(aa.reqid) act,
					COUNT(bb.reqid) dct,
					((COUNT(bb.reqid) / COUNT(aa.reqid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriptiondetail.reqid,
							subscriptiondetail.msisdn,
							advname,
							MAX(userlogid),
							userlog.advertiserid,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
					LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount > 0
							AND isrenew = 0 group by subscriptiondetail.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriptiondetail.reqid,
							subscriptiondetail.msisdn,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".subscriptiondetail
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount = 0
							AND charging_mode = 'null') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			}
		}
		
		
		if($operator=='indonesia')
		{
			$db='gamebardb_indonesia';
			$report='gamebardb_vodafone_qatar_report';
			
			if($b==1)
			{
				 $sql2="select * from ".$report.".actdct_report where date >= '".$start_date1."' and date <= '".$end_date1."' and operator='".$operator."' and product='".$product."'"; 
				//echo $sql2;
				//exit;		
			$res2=mysql_query($sql2,$con1);
			
				
			}
			if($c==1)
			{
				
				$start_date=$date1." 00:00:00";
				$end_date=$date1." 23:59:59";
			 $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.clickid) act,
					COUNT(bb.clickid) dct,
					((COUNT(bb.clickid) / COUNT(aa.clickid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						mo.clickid,
							mo.msisdn,
							advname,
							advertiser.advertiserid,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".mo
				   
					LEFT JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount > 0
							AND charging_mode='act'
					GROUP BY mo.clickid) aa
						LEFT JOIN
					(SELECT DISTINCT mo.msisdn,
							mo.clickid,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".mo
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount = 0
							AND charging_mode = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			}
		}
		
		
		
		else if($operator=='spain')
		{
			$db='gamebardb_spain';
			$report='';
			
			
			$c=1;
			
				
				
			  $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.clickid) act,
					COUNT(bb.clickid) dct,
					((COUNT(bb.clickid) / COUNT(aa.clickid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriber.clickid,
							subscriber.msisdn,
							advname,
							advertiser.advertiserid,
							DATE(subscriprion_startdate) dt
					FROM
						".$db.".subscriber
					LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
					WHERE
						subscriprion_startdate >= '".$start_date."'
							AND subscriprion_startdate <= '".$end_date."'
							AND (charging_mode = 'act' or charging_mode='low')
					GROUP BY subscriber.clickid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriber.msisdn, subscriber.clickid, DATE(subscriprion_startdate) dt
					FROM
						".$db.".subscriber
					WHERE
						subscriprion_startdate >= '".$start_date."'
							AND subscriprion_startdate <= '".$end_date."'
						  
							AND charging_mode = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		
		else if($operator=='a1_austria')
		{
			$db='gamebardb_a1';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriber.txnid,
								subscriber.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						INNER JOIN ".$db.".userlog ON subscriber.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >='".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								AND charging_mode = 'start-subscription'
								AND isrenew = 0
						GROUP BY subscriber.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriber.msisdn, DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND amount = 0
								AND charging_mode = 'close-subscription') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		else if($operator=='tmobile_austria')
		{
			$db='gamebardb_tmobile';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriber.txnid,
								subscriber.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						INNER JOIN ".$db.".userlog ON subscriber.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >='".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								AND charging_mode = 'start-subscription'
								AND isrenew = 0
						GROUP BY subscriber.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriber.msisdn, DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND amount = 0
								AND charging_mode = 'close-subscription') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		else if($operator=='hutchison_austria')
		{
			$db='gamebardb_dimoco';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriber.txnid,
								subscriber.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						INNER JOIN ".$db.".userlog ON subscriber.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >='".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								AND charging_mode = 'start-subscription'
								AND isrenew = 0
						GROUP BY subscriber.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriber.msisdn, DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND amount = 0
								AND charging_mode = 'close-subscription') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		
		else if($operator=='tim_italy')
		{
			$db='gamebardb_tim';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.txnid) act,
					COUNT(bb.msisdn) dct,
					((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							advname,
							advertiser.advertiserid,
							DATE(receivedtime) dt
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
					LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						receivedtime >= '".$start_date."'
							AND receivedtime <= '".$end_date."'
							AND amount > 0
							AND typ = 'act'
							AND retcode = '1001'
					GROUP BY subscriptiondetail.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriptiondetail.msisdn, DATE(receivedtime) dt
					FROM
						".$db.".subscriptiondetail
					WHERE
						receivedtime >= '".$start_date."'
							AND receivedtime <= '".$end_date."'
							AND amount = 0
							AND typ = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		else if($operator=='wind_italy')
		{
			$db='gamebardb_wind';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriptiondetail.txnid,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(receivedtime) dt
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							receivedtime >= '".$start_date."'
								AND receivedtime <= '".$end_date."'
								AND amount > 0
								AND typ = 'act'
								AND retcode = '1001'
						GROUP BY subscriptiondetail.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriptiondetail.msisdn, DATE(receivedtime) dt
						FROM
							".$db.".subscriptiondetail
						WHERE
							receivedtime >= '".$start_date."'
								AND receivedtime <= '".$end_date."'
								AND amount = 0
								AND typ = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		else if($operator=='h3g_italy')
		{
			$db='gamebardb_h3g';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.txnid) act,
					COUNT(bb.msisdn) dct,
					((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							advname,
							advertiser.advertiserid,
							DATE(receivedtime) dt
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
					LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						receivedtime >= '".$start_date."'
							AND receivedtime <= '".$end_date."'
							AND amount > 0
							AND typ = 'act'
							AND retcode = '1001'
					GROUP BY subscriptiondetail.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriptiondetail.msisdn, DATE(receivedtime) dt
					FROM
						".$db.".subscriptiondetail
					WHERE
						receivedtime >= '".$start_date."'
							AND receivedtime <= '".$end_date."'
							AND amount = 0
							AND typ = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		
		
		
		else if($operator=='poland')
		{
			$db='gamebardb_poland';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriber.txnid,
								subscriber.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						INNER JOIN ".$db.".userlog ON subscriber.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >='".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								AND charging_mode = 'start-subscription'
								AND isrenew = 0
						GROUP BY subscriber.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriber.msisdn, DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND amount = 0
								AND charging_mode = 'close-subscription') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		else if($operator=='myanmar')
		{
			$db='fashionbardb_myanmartelenor';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
					dt dt1, advertiser_name ad1, a1.advertiserid advertiser, act, dct, (dct/act)*100 perc
				FROM
					(SELECT 
						a.dt1 dt, a.act act, b.dct dct, a.advertiserid 
					FROM
						(SELECT 
						COUNT(DISTINCT clickid) act,
							DATE(subscriptionstartdate) dt1,
							advertiserid
					FROM
						".$db.".subscriber
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND charging_mode = 'act'
							AND sameday = 1
					GROUP BY dt1 , advertiserid) a
					INNER JOIN (SELECT 
						COUNT(DISTINCT subscriber.clickid) dct,
							DATE(subscriptionstartdate) dt2,
							subscriber.advertiserid advertiserid
					FROM
						".$db.".subscriber inner join 
						".$db.".activeuserlog on subscriber.clickid = activeuserlog.clickid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND charging_mode = 'dct'
							AND DATE(subscriptionstartdate) = DATE(accesstime)
					GROUP BY dt2 , subscriber.advertiserid) b ON a.advertiserid = b.advertiserid) a1
						INNER JOIN
					commondbmyanmar.advertiser ON a1.advertiserid = advertiser.advertiserid
					group by dt1,ad1 order by perc desc;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		
		else if($operator=='vodafone')
		{
			
			$db="gamebardb_svmobi";
			$report="";
			
			
			
			
			$c=1;
			
				
				
			  $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.txnid) act,
					COUNT(bb.txnid) dct,
					((COUNT(bb.txnid) / COUNT(aa.txnid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriber.txnid,
							subscriber.customerid,
							advname,
							advertiser.advertiserid,
							DATE(fromdate) dt
					FROM
						".$db.".subscriber
					LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
					WHERE
						fromdate >=  '".$start_date."'
							AND fromdate <=  '".$end_date."'
							AND (action = 'activation')
					GROUP BY subscriber.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriber.customerid,
							subscriber.txnid,
							DATE(fromdate) dt
					FROM
						".$db.".subscriber
					WHERE
						fromdate >=  '".$start_date."'
							AND fromdate <=  '".$end_date."'
							AND action = 'deactivation') bb ON aa.dt = bb.dt AND aa.customerid = bb.customerid
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		
		
		
		
		
		
		else if($operator=='ooredoo_oman')
		{
			$db='gamesdb_ooredoo_oman';
			$report='gamebardb_vodafone_qatar_report';
			$dblog='gamesdblog_ooredoo_oman';
			if($b==1)
			{
				$sql2="select * from ".$report.".actdct_report where date >= '".$start_date1."' and date <= '".$end_date1."' and operator='".$operator."' and product='".$product."'"; 
				//echo $sql2;
				//exit;		
			$res2=mysql_query($sql2,$con1);
			
				
			}
			if($c==1)
			{
				
				$start_date=$date1." 00:00:00";
				$end_date=$date1." 23:59:59";
			 $sql="
				SELECT 
					aa.dt dt1,
					COUNT(aa.reqid) act,
					COUNT(bb.reqid) dct,
					((COUNT(bb.reqid) / COUNT(aa.reqid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriptiondetail.reqid,
							subscriptiondetail.msisdn,
							advname,
							MAX(userlogid),
							userlog.advertiserid,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
					LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount > 0
							AND isrenew = 0 group by subscriptiondetail.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriptiondetail.reqid,
							subscriptiondetail.msisdn,
							DATE(subscriptionstartdate) dt
					FROM
						".$db.".subscriptiondetail
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND amount = 0
							AND charging_mode = 'null') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			}
		}
		
		else if($operator=='airtel_india')
		{
			$db='gamebardb_airtel';
			$c=1;
			$report='gamebardb_vodafone_qatar_report';
			
			if($b==1)
			{
				 $sql2="select * from ".$report.".actdct_report where date >= '".$start_date1."' and date <= '".$end_date1."' and operator='".$operator."' and product='".$product."'"; 
				//echo $sql2;
				//exit;		
			$res2=mysql_query($sql2,$con1);
			
				
			}
			if($c==1)
			{
				
				//$start_date=$date1." 00:00:00";
				//$end_date=$date1." 23:59:59";
				 $sql="SELECT 
					CASE
						WHEN act IS NULL THEN 0
						ELSE act
					END act,
					dt1,
					CASE
						WHEN dct IS NULL THEN 0
						ELSE dct
					END dct,
					dt2,
					CASE
						WHEN advertiserid IS NULL THEN '-1'
						ELSE advertiserid
					END advertiser,
					CASE
						WHEN advname IS NULL THEN 'other'
						ELSE advname
					END ad1,
					(dct / act) * 100 perc
				FROM
					(SELECT 
						COUNT(txnid) act, dct, dt1, dt2, y.advertiserid, y.advname
					FROM
						(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							activeuserlog.advertiserid,
							advname,
							DATE(subscriptionstartdate) dt1
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".activeuserlog ON subscriptiondetail.msisdn = activeuserlog.msisdn
					LEFT JOIN ".$db.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
					WHERE
						isrenew = 0 AND errorcode = 1000
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."') y
					LEFT JOIN (SELECT 
						COUNT(a.txnid) dct, advertiserid, advname, a.dt1 dt2
					FROM
						(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							activeuserlog.advertiserid,
							advname,
							DATE(subscriptionstartdate) dt1,
							subscriptionstartdate,
							DATE_ADD(subscriptionstartdate, INTERVAL 1 DAY) nextday
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".activeuserlog ON subscriptiondetail.msisdn = activeuserlog.msisdn
					LEFT JOIN ".$db.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
					WHERE
						isrenew = 0 
							and subscriptiondetail.subscriptionstartdate < subscriptiondetail.subscriptionenddate
							AND errorcode = 1000
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."') a
					INNER JOIN (SELECT DISTINCT
						txnid, msisdn, subscriptionstartdate dctdt, isrenew, amount
					FROM
						".$db.".subscriptiondetail
					WHERE
						 subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
							AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and  charging_mode != 600375)
							AND errorcode = 1001) b ON a.msisdn = b.msisdn
					WHERE
						b.dctdt >= subscriptionstartdate
							AND b.dctdt <= nextday
					GROUP BY dt2 , advname) ll ON ll.dt2 = y.dt1
						AND y.advname = ll.advname
					GROUP BY advertiserid , dt1) gg"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			}
		}
		else if($operator=='gamezone_vodafone')
		{
			$db='gamesnewdb_voda';
			$c=1;
			$report='gamebardb_vodafone_qatar_report';
			
			
				
				//$start_date=$date1." 00:00:00";
				//$end_date=$date1." 23:59:59";
				 $sql="SELECT 
							CASE
								WHEN act IS NULL THEN 0
								ELSE act
							END act,
							dt1,
							CASE
								WHEN dct IS NULL THEN 0
								ELSE dct
							END dct,
							dt2,
							CASE
								WHEN advertiserid IS NULL THEN '-1'
								ELSE advertiserid
							END advertiser,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END ad1,
							(dct / act) * 100 perc
						FROM
							(SELECT 
								COUNT(txnid) act, dct, dt1, dt2, y.advertiserid, y.advname
							FROM
								(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									userlog.advertiserid,
									advname,
									DATE(subscriptionstartdate) dt1
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
							LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								isrenew = 0 AND amount >0
									AND subscriptionstartdate >=  '".$start_date."'
									AND subscriptionstartdate <  '".$end_date."') y
							LEFT JOIN (SELECT 
								COUNT(a.txnid) dct, advertiserid, advname, a.dt1 dt2
							FROM
								(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									userlog.advertiserid,
									advname,
									DATE(subscriptionstartdate) dt1,
									subscriptionstartdate,
									DATE_ADD(subscriptionstartdate, INTERVAL 1 DAY) nextday
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
							LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								isrenew = 0
									AND subscriptiondetail.subscriptionstartdate < subscriptiondetail.subscriptionenddate
									AND amount>0
									AND subscriptionstartdate >=  '".$start_date."'
									AND subscriptionstartdate <  '".$end_date."') a
							INNER JOIN (SELECT DISTINCT
								txnid, msisdn, subscriptionstartdate dctdt, isrenew, amount
							FROM
								".$db.".subscriptiondetail
							WHERE
								subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
									AND isrenew=0
									and charging_mode='null') b ON a.msisdn = b.msisdn
							WHERE
								b.dctdt >= subscriptionstartdate
									AND b.dctdt <= nextday
							GROUP BY dt2 , advname) ll ON ll.dt2 = y.dt1
								AND y.advname = ll.advname
							GROUP BY advertiserid , dt1) gg"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		
	
	
}
else{
	if($operator=='airtel_india')
		{
			$db='funzonedb_airtel';
			$report='gamebardb_vodafone_qatar_report';
			$c=1;
			if($b==1)
			{
				 $sql2="select * from ".$report.".actdct_report where date >= '".$start_date1."' and date <= '".$end_date1."' and operator='".$operator."' and product='".$product."'"; 
				//echo $sql2;
				//exit;		
			$res2=mysql_query($sql2,$con1);
			
				
			}
			if($c==1)
			{
				
				//$start_date=$date1." 00:00:00";
				//$end_date=$date1." 23:59:59";
			 $sql="SELECT 
					CASE
						WHEN act IS NULL THEN 0
						ELSE act
					END act,
					dt1,
					CASE
						WHEN dct IS NULL THEN 0
						ELSE dct
					END dct,
					dt2,
					CASE
						WHEN advertiserid IS NULL THEN '-1'
						ELSE advertiserid
					END advertiser,
					CASE
						WHEN advname IS NULL THEN 'other'
						ELSE advname
					END ad1,
					(dct / act) * 100 perc
				FROM
					(SELECT 
						COUNT(txnid) act, dct, dt1, dt2, y.advertiserid, y.advname
					FROM
						(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							activeuserlog.advertiserid,
							advname,
							DATE(subscriptionstartdate) dt1
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".activeuserlog ON subscriptiondetail.msisdn = activeuserlog.msisdn
					LEFT JOIN ".$db.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
					WHERE
						isrenew = 0 AND errorcode = 1000
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."') y
					LEFT JOIN (SELECT 
						COUNT(a.txnid) dct, advertiserid, advname, a.dt1 dt2
					FROM
						(SELECT DISTINCT
						subscriptiondetail.txnid,
							subscriptiondetail.msisdn,
							activeuserlog.advertiserid,
							advname,
							DATE(subscriptionstartdate) dt1,
							subscriptionstartdate,
							DATE_ADD(subscriptionstartdate, INTERVAL 1 DAY) nextday
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".activeuserlog ON subscriptiondetail.msisdn = activeuserlog.msisdn
					LEFT JOIN ".$db.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
					WHERE
						isrenew = 0 
							and subscriptiondetail.subscriptionstartdate < subscriptiondetail.subscriptionenddate
							AND errorcode = 1000
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."') a
					INNER JOIN (SELECT DISTINCT
						txnid, msisdn, subscriptionstartdate dctdt, isrenew, amount
					FROM
						".$db.".subscriptiondetail
					WHERE
						 subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
							AND (charging_mode != 600396  and charging_mode != 600398 and charging_mode != 600408 and charging_mode != 600409 and charging_mode != 600404)
							AND errorcode = 1001) b ON a.msisdn = b.msisdn
					WHERE
						b.dctdt >= subscriptionstartdate
							AND b.dctdt <= nextday
					GROUP BY dt2 , advname) ll ON ll.dt2 = y.dt1
						AND y.advname = ll.advname
					GROUP BY advertiserid , dt1) gg"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			}
		}
		
	else if($operator=='spain')
		{
			$db='fashionbardb_spain';
			$report='';
			
			
			$c=1;
			
				
				
			 $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.clickid) act,
					COUNT(bb.clickid) dct,
					((COUNT(bb.clickid) / COUNT(aa.clickid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriber.clickid,
							subscriber.msisdn,
							advname,
							advertiser.advertiserid,
							DATE(subscriprion_startdate) dt
					FROM
						".$db.".subscriber
					LEFT JOIN ".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
					WHERE
						subscriprion_startdate >= '".$start_date."'
							AND subscriprion_startdate <= '".$end_date."'
							
							AND (charging_mode = 'act' or charging_mode='low')
					GROUP BY subscriber.clickid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriber.msisdn, subscriber.clickid, DATE(subscriprion_startdate) dt
					FROM
						".$db.".subscriber
					WHERE
						subscriprion_startdate >= '".$start_date."'
							AND subscriprion_startdate <= '".$end_date."'
						  
							AND charging_mode = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		
		else if($operator=='vodafone')
		{
			
			$db="fashionbardb_svmobi";
			$report="";
			
			
			
			
			$c=1;
			
				
				
			  $sql="SELECT 
					aa.dt dt1,
					COUNT(aa.txnid) act,
					COUNT(bb.txnid) dct,
					((COUNT(bb.txnid) / COUNT(aa.txnid)) * 100) perc,
					CASE
						WHEN aa.advertiserid IS NULL THEN - 1
						ELSE aa.advertiserid
					END advertiser,
					CASE
						WHEN
							aa.advertiserid = - 1
								OR aa.advertiserid IS NULL
						THEN
							'other'
						ELSE aa.advname
					END ad1
				FROM
					(SELECT DISTINCT
						subscriber.txnid,
							subscriber.customerid,
							advname,
							advertiser.advertiserid,
							DATE(fromdate) dt
					FROM
						".$db.".subscriber
					LEFT JOIN ".$db.".advertiser ON subscriber.advertid = advertiser.advertiserid
					WHERE
						fromdate >=  '".$start_date."'
							AND fromdate <=  '".$end_date."'
							AND (action = 'activation')
					GROUP BY subscriber.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriber.customerid,
							subscriber.txnid,
							DATE(fromdate) dt
					FROM
						".$db.".subscriber
					WHERE
						fromdate >=  '".$start_date."'
							AND fromdate <=  '".$end_date."'
							AND action = 'deactivation') bb ON aa.dt = bb.dt AND aa.customerid = bb.customerid
				GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		else if($operator=='hotshots_vodafone')
		{
			$db='hotshotsnewdb_voda_0617';
			$c=1;
			$report='gamebardb_vodafone_qatar_report';
			
			
				
				//$start_date=$date1." 00:00:00";
				//$end_date=$date1." 23:59:59";
				 $sql="SELECT 
							CASE
								WHEN act IS NULL THEN 0
								ELSE act
							END act,
							dt1,
							CASE
								WHEN dct IS NULL THEN 0
								ELSE dct
							END dct,
							dt2,
							CASE
								WHEN advertiserid IS NULL THEN '-1'
								ELSE advertiserid
							END advertiser,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END ad1,
							(dct / act) * 100 perc
						FROM
							(SELECT 
								COUNT(txnid) act, dct, dt1, dt2, y.advertiserid, y.advname
							FROM
								(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									userlog.advertiserid,
									advname,
									DATE(subscriptionstartdate) dt1
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
							LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								isrenew = 0 AND amount >0
									AND subscriptionstartdate >=  '".$start_date."'
									AND subscriptionstartdate <  '".$end_date."') y
							LEFT JOIN (SELECT 
								COUNT(a.txnid) dct, advertiserid, advname, a.dt1 dt2
							FROM
								(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									userlog.advertiserid,
									advname,
									DATE(subscriptionstartdate) dt1,
									subscriptionstartdate,
									DATE_ADD(subscriptionstartdate, INTERVAL 1 DAY) nextday
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
							LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								isrenew = 0
									AND subscriptiondetail.subscriptionstartdate < subscriptiondetail.subscriptionenddate
									AND amount>0
									AND subscriptionstartdate >=  '".$start_date."'
									AND subscriptionstartdate <  '".$end_date."') a
							INNER JOIN (SELECT DISTINCT
								txnid, msisdn, subscriptionstartdate dctdt, isrenew, amount
							FROM
								".$db.".subscriptiondetail
							WHERE
								subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate
									AND isrenew=0
									and charging_mode='null') b ON a.msisdn = b.msisdn
							WHERE
								b.dctdt >= subscriptionstartdate
									AND b.dctdt <= nextday
							GROUP BY dt2 , advname) ll ON ll.dt2 = y.dt1
								AND y.advname = ll.advname
							GROUP BY advertiserid , dt1) gg"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con1);
			
		}
		
		
		else if($operator=='poland')
		{
			$db='glambardb_poland';
			$report='';
			
			
			$c=1;
			
				//$res->close();
				//mysql_next_result($con);
			   $sql="SELECT 
						aa.dt dt1,
						COUNT(aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
						CASE
							WHEN aa.advertiserid IS NULL THEN - 1
							ELSE aa.advertiserid
						END advertiser,
						CASE
							WHEN
								aa.advertiserid = - 1
									OR aa.advertiserid IS NULL
							THEN
								'other'
							ELSE aa.advname
						END ad1
					FROM
						(SELECT DISTINCT
							subscriber.txnid,
								subscriber.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						INNER JOIN ".$db.".userlog ON subscriber.txnid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >='".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								AND charging_mode = 'start-subscription'
								AND isrenew = 0
						GROUP BY subscriber.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriber.msisdn, DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND amount = 0
								AND charging_mode = 'close-subscription') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;"; 
				//echo $sql;
						
				$res=mysql_query($sql,$con);
				//mysql_next_result($con);
			
		}
		
		
}

//$res=mysql_query($sql) or die(mysql_error());
//$fields=mysql_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";

//echo $sql;

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
                    <h2>Sameday Churn Report</h2>
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
						<select name="product" class="form-control" id="product" onchange="myfun()">
							<option>Product</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Glambar</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
						<?php
						if($product == 'glambar')
						{ ?>
							<option>Operator</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Airtel_India</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="hotshots_vodafone" <?php if($operator=='hotshots_vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots_Vodafone</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland</option>
							<!--<option value="Vodafone-Qatar" <?php // if($operator=='Vodafone-Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone-Qatar</option>
							<!--<option value="Airtel" <?php //if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							-->
					<?php
						}
						else if($product == 'gamebar'){
						?>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Airtel_India</option>
							<option value="Vodafone-Qatar" <?php if($operator=='Vodafone-Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone-Qatar</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Oman</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?>>Indonesia</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Spain</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="gamezone_vodafone" <?php if($operator=='gamezone_vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Gamezone_Vodafone</option>
							<option value="a1_austria" <?php if($operator=='a1_austria'){$selected='selected';}else{$selected='';} echo $selected; ?> >A1_Austria</option>
							<option value="tmobile_austria"<?php if($operator=='tmobile_austria'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tmobile_Austria</option>
							<option value="hutchison_austria" <?php if($operator=='hutchison_austria'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hutchison_Austria</option>
							<option value="tim_italy" <?php if($operator=='tim_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tim Italy</option>
							<option value="wind_italy" <?php if($operator=='wind_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >Wind Italy</option>
							<option value="h3g_italy" <?php if($operator=='h3g_italy'){$selected='selected';}else{$selected='';} echo $selected; ?> >H3g Italy</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland</option>
							<option value="myanmar" <?php if($operator=='myanmar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Myanmar</option>
							<!--<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							<!--<option  id="azharbeizan" name="azharbeizan" value="Azharbeizan" <?php //if($operator=='Azharbeizan'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azharbeizan</option>
							<option  id="ooredoo" name="ooredoo" value="ooredoo" <?php //if($operator=='ooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo-Qatar</option>-->
							<!--<option  id="srilanka" name="srilanka" value="srilanka" <?php //if($operator=='srilanka'){$selected='selected';}else{$selected='';} echo $selected; ?>>srilanka</option>
						<!--	<option  id="etisalat" name="etisalat" value="etisalat" <?php //if($operator=='etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>etisalat</option>-->
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
				
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
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
							<h2>Output Records <small></small></h2>
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
										<td><strong>Activation</strong></td>
										<td><strong>Deactivation</strong></td>
										<td><strong>Percentage</strong></td>
	
									</tr>
								</thead>


								<tbody>
								<?php
									$act=0;
									$dct=0;
									$perc=0;
									
									if($c==1)
									{
									while($row=mysql_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $row['dt1']; ?></td>
										<td><?php echo $row['ad1']; ?></td>
										<td><?php echo number_format($row['act']); $act=$act+$row['act']; ?></td>
										<td><?php echo number_format($row['dct']); $dct=$dct+$row['dct']; ?></td>
										<td><?php echo number_format($row['perc'],2)." %"; ?></td>
									</tr>
									
								<?php
								//echo "perc= ".$row['perc'];
									}
									}
									if($b==1)
									{
										
									while($row2=mysql_fetch_array($res2))
									{
										
								?>
									<tr>
										<td><?php echo $row2['date']; ?></td>
										<td><?php echo $row2['advname']; ?></td>
										<td><?php echo number_format($row2['act']); $act=$act+$row2['act']; ?></td>
										<td><?php echo number_format($row2['dct']); $dct=$dct+$row2['dct']; ?></td>
										<td><?php echo number_format($row2['perc'],2)." %"; ?></td>
									</tr>
									
								<?php
								//echo "perc= ".$row['perc'];
									}
										
									}
									
								?>
								
								<tr>
									<td><strong>Total</strong></td>
									<td></td>
									<td><strong><?php echo $act; ?></strong></td>
									<td><strong><?php echo $dct; ?></strong></td>
									<td><strong><?php $perc=number_format(($dct/$act)*100,2)." %"; if($perc > 15){echo "<span style='color:red;'>".$perc."</span>";}else{echo "<span style='color:green;'>".$perc."</span>";}?></strong></td>
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
function myfun() {
	var x = document.getElementById("product").value;
    //alert(x);
	if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		//select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Vodafone', 'vodafone');
		select.options[select.options.length] = new Option('Hotshots_Vodafone', 'hotshots_vodafone');
		select.options[select.options.length] = new Option('Poland', 'poland');
		
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
		select.options[select.options.length] = new Option('Vodafone-Qatar', 'Vodafone-Qatar');
		select.options[select.options.length] = new Option('Ooredoo_Oman', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Vodafone', 'vodafone');
		select.options[select.options.length] = new Option('Gamezone_Vodafone', 'gamezone_vodafone');
		select.options[select.options.length] = new Option('A1_Austria', 'a1_austria');
		select.options[select.options.length] = new Option('Tmobile_Austria', 'tmobile_austria');
		select.options[select.options.length] = new Option('Hutchison_Austria', 'hutchison_austria');
		select.options[select.options.length] = new Option('Tim Italy', 'tim_italy');
		select.options[select.options.length] = new Option('Wind Italy', 'wind_italy');
		select.options[select.options.length] = new Option('H3g Italy', 'h3g_italy');
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Myanmar', 'myanmar');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		//select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		//select.options[select.options.length] = new Option('etisalat', 'etisalat');
		//select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
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