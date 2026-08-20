<?php
require_once __DIR__ . '/../admin/includes/config.php';
//$con=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());//cluster1
$con2=mysql_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysql_error());//cluster 2
$con1=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysqli_error());//cluster1
$con=$con2;
//date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$date2=date('Y-m-d',strtotime("-2 days"));
//$date1='2017-07-06 ';
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$startdate2=$date2.' 00:00:00';
$enddate2=$date2.' 23:59:59';
$operator=['gamebardb_vodafone_qatar','gamesdb_ooredoo_oman','gamebardb_indonesia'];
$report='gamebardb_vodafone_qatar_report';
mysql_query("DELETE FROM ".$report.".`actdct_report` WHERE `date`='".$date1."'",$con);
//mysql_query("DELETE FROM hotshotsnewdb_idea_0717.`actdct_report` WHERE `date`='".$date1."'",$con);
//mysql_query("DELETE FROM gamebardb_vodafone_qatar_report.`actdct_report` WHERE `date`='".$date1."'",$con);



$actdct1=0;
for ($i=0;$i<4;$i++)//OPERATOR
{
	if($i==0)
	{
				 $sql2="SELECT 
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
						".$operator[$i].".subscriptiondetail
					LEFT JOIN ".$operator[$i].".userlog ON subscriptiondetail.reqid = userlog.txnid
					LEFT JOIN ".$operator[$i].".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >='".$startdate."'
							AND subscriptionstartdate <= '".$enddate."'
							AND amount > 0
							AND isrenew = 0
					GROUP BY subscriptiondetail.txnid) aa
						LEFT JOIN
					(SELECT DISTINCT
						subscriptiondetail.reqid,																			
							subscriptiondetail.msisdn,
							DATE(subscriptionstartdate) dt
					FROM
						".$operator[$i].".subscriptiondetail
					WHERE
						subscriptionstartdate >= '".$startdate."'
							AND subscriptionstartdate <= '".$enddate."'
							AND amount = 0
							AND charging_mode = 'null') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
				GROUP BY aa.dt , advertiser;";
				
				if($result=mysqli_query($con1,$sql2))
				{
					$actdct1++;
					
				while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
				{
					$act=$row['act'];
					$dct=$row['dct'];
					$perc=$row['perc'];
					$advertiser=$row['advertiser'];
					$ad1=$row['ad1'];
					$perc=number_format($perc,2);
					//echo "hi";
					  $sql4="INSERT INTO ".$report.".actdct_report
					(`date`, `act`, `dct`,`perc`, `advertiserid`, `advname`,`operator`,`product`) values('".$date1."','".$act."','".$dct."','".$perc."','".$advertiser."','".$ad1."','Vodafone-Qatar','gamebar')  ";
					
					$result1=mysql_query($sql4,$con);
				
				}
				}
	}
	if($i==1)
	{
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
						subscriber.msisdn,
						advname,
						MAX(annonymoustrackingid),
						annonymoustracking.advertiserid,
						DATE(subscriptionstartdate) dt
				FROM
					gamesdb_ooredoo_oman.subscriber
				LEFT JOIN gamesdblog_ooredoo_oman.annonymoustracking ON subscriber.txnid = annonymoustracking.txnid
				LEFT JOIN gamesdblog_ooredoo_oman.advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND amount > 0
						AND isrenew = 0
				GROUP BY subscriber.txnid) aa
					LEFT JOIN
				(SELECT DISTINCT
					subscriber.txnid,
						subscriber.msisdn,
						DATE(subscriptionstartdate) dt
				FROM
					gamesdb_ooredoo_oman.subscriber
				WHERE
					subscriptionstartdate >= '".$startdate."'
						AND subscriptionstartdate <= '".$enddate."'
						AND amount = 0
						AND charging_mode = 'null') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
			GROUP BY aa.dt , advertiser;";
							
				if($result=mysql_query($sql,$con))
				{
					$actdct1++;
					
				while($row=mysql_fetch_array($result,MYSQL_ASSOC))
				{
					$act=$row['act'];
					$dct=$row['dct'];
					$perc=$row['perc'];
					$advertiser=$row['advertiser'];
					$ad1=$row['ad1'];
					$perc=number_format($perc,2);
					//echo "hi";
					  $sql4="INSERT INTO ".$report.".actdct_report
					(`date`, `act`, `dct`,`perc`, `advertiserid`, `advname`,`operator`,`product`) values('".$date1."','".$act."','".$dct."','".$perc."','".$advertiser."','".$ad1."','ooredoo_oman','gamebar')  ";
					
					$result1=mysql_query($sql4,$con);
				
				}
				}
				
		
		
		
	}
	elseif($i==2)
	{
		
				
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
							".$operator[$i].".mo
					   
						LEFT JOIN ".$operator[$i].".advertiser ON mo.advid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$startdate."'
								AND subscriptionstartdate <= '".$enddate."'
								AND amount > 0
								AND charging_mode='act'
						GROUP BY mo.clickid) aa
							LEFT JOIN
						(SELECT DISTINCT mo.msisdn,
								mo.clickid,
								DATE(subscriptionstartdate) dt
						FROM
							".$operator[$i].".mo
						WHERE
							subscriptionstartdate >= '".$startdate."'
								AND subscriptionstartdate <= '".$enddate."'
								AND amount = 0
								AND charging_mode = 'dct') bb ON aa.dt = bb.dt AND aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser;";
				//exit;
				if($result=mysql_query($sql,$con))
				{
					$actdct1++;
				while($row=mysql_fetch_array($result,MYSQL_ASSOC))
				{
					$act=$row['act'];
					$dct=$row['dct'];
					$perc=$row['perc'];
					$advertiser=$row['advertiser'];
					$ad1=$row['ad1'];
					$perc=number_format($perc,2);
					//echo "hi";
					  $sql4="INSERT INTO ".$report.".actdct_report
					(`date`, `act`, `dct`,`perc`, `advertiserid`, `advname`,`operator`,`product`) values('".$date1."','".$act."','".$dct."','".$perc."','".$advertiser."','".$ad1."','indonesia','gamebar')  ";
					$result1=mysql_query($sql4,$con);
				
				}
				}
		
		
	}
		
}

echo $actdct1;
//exit;
$actdctcount=0;
if($actdct1==1)
{
	$actdctcount=1;
	//$sql="update hotshotsnewdb_voda_0617.cron_report set cron_actdct=".$actdctcount." where date='".$date1."'";
	$cur_date=date('Y-m-d H-i:s');
	$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=".$actdctcount.", date='".$cur_date."' where cron_name='cron_actdct'";
	$result = mysql_query($sql,$con2) ;
}

?>