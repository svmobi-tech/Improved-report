<?php
require_once __DIR__ . '/../admin/includes/config.php';

//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysql_error());//cluster 2
$con1=$con2;
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';

//$hvdb="hotshotsnewdb_voda_0617";
$hvdb="gamebardb_vodafone_qatar";
$report="gamebardb_vodafone_qatar_report";
$gamebardb_airtel='gamebardb_airtel';
$funzonedb_airtel='funzonedb_airtel';
//$hidb="hotshotsnewdb_idea_0717";
$pub=0;

mysqli_query($con1,"DELETE FROM ".$report.".`pubwise_report` WHERE `date`='".$date1."';");
//mysqli_query($con1,"DELETE FROM ".$hidb.".`pubwise_report` WHERE `date`='".$date1."';");
//mysqli_query($con1,"DELETE FROM ".$hadb.".`pubwise_report` WHERE `date`='".$date1."';");

		$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
		$text1='pubid';
	
		
	
			 $sql="SELECT 
						aa.dt dt1,
						aa.reff reff1,
						COUNT(reqid) act,
						CASE
							WHEN bb.dct IS NULL THEN 0
							ELSE bb.dct
						END dct,
						CASE
							WHEN aa.advname IS NULL THEN 'other'
							ELSE aa.advname
						END advname,
						aa.advertiserid,
						CASE
							WHEN ((bb.dct / COUNT(reqid)) * 100) IS NULL THEN 0
							ELSE((bb.dct / COUNT(reqid)) * 100) 
						END perc
					FROM
						(SELECT DISTINCT
							".$text." reff,
								subscriptiondetail.reqid,
								subscriptiondetail.msisdn,
								advname,
								CASE
									WHEN advertiser.advertiserid IS NULL THEN - 1
									ELSE advertiser.advertiserid
								END advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$hvdb.".subscriptiondetail
						LEFT JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								AND isrenew = 0
						GROUP BY subscriptiondetail.msisdn) aa
							LEFT JOIN
						(SELECT 
							COUNT(*) dct, a.dt, a.advname, a.advertiserid, a.reff1 reff
						FROM
							(SELECT DISTINCT
							".$text." reff1,
								subscriptiondetail.reqid,
								subscriptiondetail.msisdn,
								advname,
								CASE
									WHEN advertiser.advertiserid IS NULL THEN - 1
									ELSE advertiser.advertiserid
								END advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$hvdb.".subscriptiondetail
						LEFT JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								AND isrenew = 0
						GROUP BY subscriptiondetail.msisdn) a
						INNER JOIN (SELECT DISTINCT
							".$text." reff2,
								subscriptiondetail.reqid,
								subscriptiondetail.msisdn,
								advname,
								CASE
									WHEN advertiser.advertiserid IS NULL THEN - 1
									ELSE advertiser.advertiserid
								END advertiserid,
								DATE(subscriptionstartdate) dt
						FROM
							".$hvdb.".subscriptiondetail
						LEFT JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount = 0
								AND charging_mode = 'null'
						GROUP BY subscriptiondetail.reqid) b ON a.msisdn = b.msisdn AND a.dt = b.dt
							AND a.advertiserid = b.advertiserid
							AND a.reff1 = b.reff2
						GROUP BY a.dt , a.advertiserid , a.reff1) bb ON aa.dt = bb.dt
							AND aa.advertiserid = bb.advertiserid
							AND aa.reff = bb.reff
					GROUP BY aa.dt , aa.advertiserid , aa.reff";
	
	
if($result = $con1->query($sql))
{
	$pub++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt1'];
	$reff1=$row['reff1'];
	$advertiserid=$row['advertiserid'];
	$advname=$row['advname'];
	$act=$row['act'];
	$dct=$row['dct'];
	$perc=$row['perc'];

	
	
	
	 $sql1="INSERT INTO ".$report.". pubwise_report
				(`date`, `reff1`, `advertiserid`, `advname`, `act`, `dct`, `perc`,`product`,`operator`) values('".$date."','".$reff1."','".$advertiserid."','".$advname."','".$act."','".$dct."','".$perc."','gamebar','Vodafone_Qatar')";
					
			
	$result1=mysqli_query($con1,$sql1);
	
	
	
}

}
	/*				$sql="SELECT 
						aa.dt dt1,
						aa.reff reff1,
						case when bb.dct is null then 0
						else  bb.dct
						end dct,
						case when COUNT(msisdn) is null then 0
						else  COUNT(msisdn)
						end act,
						
						case 
						when aa.advname is null then 'other'
						else aa.advname 
						end advname,

						case 
						when aa.advertiserid is null then -1
						else aa.advertiserid 
						end advertiserid,
						
						case when ((bb.dct / COUNT(msisdn)) * 100) is null then 0
						else ((bb.dct / COUNT(msisdn)) * 100)
						end perc
						
					FROM
						(SELECT DISTINCT
							CASE
									WHEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED) != '0'
									THEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED)
									ELSE CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
										AS UNSIGNED)
								END reff,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$hidb.".subscriptiondetail
						left JOIN ".$hidb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								AND charging_mode LIKE '%ACT%'
						GROUP BY subscriptiondetail.msisdn) aa
							LEFT JOIN
						(SELECT 
							COUNT(*) dct, a.dt, a.advname, a.advertiserid, a.reff1 reff
						FROM
							(SELECT DISTINCT
							CASE
									WHEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED) != '0'
									THEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED)
									ELSE CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
										AS UNSIGNED)
								END reff1,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$hidb.".subscriptiondetail
						left JOIN ".$hidb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								AND charging_mode LIKE '%ACT%'
						GROUP BY subscriptiondetail.msisdn) a
						INNER JOIN (SELECT DISTINCT
							CASE
									WHEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED) != '0'
									THEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED)
									ELSE CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
										AS UNSIGNED)
								END reff2,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$hidb.".subscriptiondetail
						left JOIN ".$hidb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount = 0
								AND charging_mode LIKE '%DCT%'
						GROUP BY subscriptiondetail.msisdn) b ON a.msisdn = b.msisdn AND a.dt = b.dt
							AND a.advertiserid = b.advertiserid
							AND a.reff1 = b.reff2
						GROUP BY a.dt , a.advertiserid , a.reff1) bb ON aa.dt = bb.dt
							AND aa.advertiserid = bb.advertiserid
							AND aa.reff = bb.reff
					GROUP BY aa.dt , aa.advertiserid , aa.reff";
					
					
					//echo $sql;exit;
					
					
if($result = $con1->query($sql))
{
	$pub++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt1'];
	$reff1=$row['reff1'];
	$advertiserid=$row['advertiserid'];
	$advname=$row['advname'];
	$act=$row['act'];
	$dct=$row['dct'];
	$perc=$row['perc'];

	
	
	
	$sql1="INSERT INTO ".$hidb.". pubwise_report
				(`date`, `reff1`, `advertiserid`, `advname`, `act`, `dct`, `perc`) values('".$date."','".$reff1."','".$advertiserid."','".$advname."','".$act."','".$dct."','".$perc."')";
					
			
	$result1=mysqli_query($con1,$sql1);
	
	
	
}

}
*/


/*

$sql="SELECT 
						aa.dt dt1,
						 aa.reff reff1,
						COUNT(DISTINCT aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
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
						END advname
					FROM
						(SELECT DISTINCT
							subscriptiondetail.txnid,
							CASE
									WHEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED) != '0'
									THEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED)
									ELSE CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
										AS UNSIGNED)
								END reff,
								userlog.msisdn,
								advname,
								userlog.advertiserid,
								DATE(subscriptionstartdate) dt,
								max(userlogid)
						FROM
							".$gamebardb_airtel.".subscriptiondetail
						LEFT JOIN ".$gamebardb_airtel.".activeuserlog userlog ON subscriptiondetail.txnid = userlog.txnid
						
						left JOIN ".$gamebardb_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
								AND subscriptiondetail.errorcode = 1000
						GROUP BY subscriptiondetail.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriptiondetail.txnid,
								subscriptiondetail.msisdn,
								DATE(subscriptionstartdate) dt
						FROM
							".$gamebardb_airtel.".subscriptiondetail
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount = 0
								AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
								AND subscriptiondetail.errorcode = 1001
								AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
					GROUP BY aa.dt , advertiserid,aa.reff";
					
					
				
					
					
if($result = $con1->query($sql))
{
	$pub++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt1'];
	$reff1=$row['reff1'];
	$advertiserid=$row['advertiserid'];
	$advname=$row['advname'];
	$act=$row['act'];
	$dct=$row['dct'];
	$perc=$row['perc'];

	
	
	
	$sql1="INSERT INTO ".$report.". pubwise_report
				(`date`, `reff1`, `advertiserid`, `advname`, `act`, `dct`, `perc`,`product`,`operator`) values('".$date."','".$reff1."','".$advertiserid."','".$advname."','".$act."','".$dct."','".$perc."','gamebar','airtel_india')";
					
			
	$result1=mysqli_query($con1,$sql1);
	
	
	
}

}


$sql="SELECT 
						aa.dt dt1,
						 aa.reff reff1,
						COUNT(DISTINCT aa.txnid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.txnid)) * 100) perc,
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
						END advname
					FROM
						(SELECT DISTINCT
							subscriptiondetail.txnid,
							CASE
									WHEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED) != '0'
									THEN
										CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
											AS UNSIGNED)
									ELSE CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
										AS UNSIGNED)
								END reff,
								userlog.msisdn,
								advname,
								userlog.advertiserid,
								DATE(subscriptionstartdate) dt,
								max(userlogid)
						FROM
							".$funzonedb_airtel.".subscriptiondetail
						LEFT JOIN ".$funzonedb_airtel.".activeuserlog userlog ON subscriptiondetail.txnid = userlog.txnid
						
						left JOIN ".$funzonedb_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND (charging_mode != 600396
            AND charging_mode != 600398
            AND charging_mode != 600408
            AND charging_mode != 600409
            AND charging_mode != 600403
            AND charging_mode != 600404)
								AND subscriptiondetail.errorcode = 1000
						GROUP BY subscriptiondetail.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriptiondetail.txnid,
								subscriptiondetail.msisdn,
								DATE(subscriptionstartdate) dt
						FROM
							".$funzonedb_airtel.".subscriptiondetail
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount = 0
								AND (charging_mode != 600396
            AND charging_mode != 600398
            AND charging_mode != 600408
            AND charging_mode != 600409
            AND charging_mode != 600403
            AND charging_mode != 600404)
								AND subscriptiondetail.errorcode = 1001
								AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
					GROUP BY aa.dt , advertiserid,aa.reff";
					
					
				
					
					
if($result = $con1->query($sql))
{
	$pub++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt1'];
	$reff1=$row['reff1'];
	$advertiserid=$row['advertiserid'];
	$advname=$row['advname'];
	$act=$row['act'];
	$dct=$row['dct'];
	$perc=$row['perc'];

	
	
	
	$sql1="INSERT INTO ".$report.". pubwise_report
				(`date`, `reff1`, `advertiserid`, `advname`, `act`, `dct`, `perc`,`product`,`operator`) values('".$date."','".$reff1."','".$advertiserid."','".$advname."','".$act."','".$dct."','".$perc."','glambar','airtel_india')";
					
			
	$result1=mysqli_query($con1,$sql1);
	
	
	
}

}*/
echo $pub;
$pubcount=0;
if($pub==0)
{
	$pubcount=1;
	$cur_date=date('Y-m-d H-i:s');
	$sql="update ".$report.".cron_report set ran=".$pubcount.", date='".$cur_date."' where cron_name='cron_pub_wise'";

	$result = mysqli_query($con2,$sql) ;
}


