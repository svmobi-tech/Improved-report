<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
//$conn1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); 
//$con=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back
$conn1=$con;





date_default_timezone_set("Asia/Kolkata");
$curdate=date('Y-m-d');
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
$advertiserid=$_POST['advertiserid']; 
 $date1=date('Y-m-d');


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
	
if($product=='gamebar' || $product=='gamebar')
{
	
	if($operator=='Vodafone_Qatar')
	{
		$db="gamebardb_vodafone_qatar";
		$report="gamebardb_vodafone_qatar_report";
		//$dblog="hotshotsdblog1";
		$sql_ad="select * from ".$db.".advertiser where operator=1 ";
		$res_ad=mysql_query($sql_ad,$con);
		
		
	}
	elseif ($operator=='ooredoo_oman')
	{
		$db="gamesdb_ooredoo_oman";
		$dblog="gamesdblog_ooredoo_oman";
		
		$sql_ad="select * from ".$dblog.".advertiser  ";
		$res_ad=mysql_query($sql_ad,$con);
	}
	else if ($operator=='airtel_india')
	{
		$db='gamebardb_airtel';
		$dblog='';
		$report='gamebardb_vodafone_qatar_report';
	}
	else if($operator=='indonesia')
	{
		$db='gamebardb_indonesia';
		$dblog='gamebardblog_indonesia';
		$report='gamebardb_vodafone_qatar_report';
		
	}
	elseif ($operator=='spain')
	{
		$c=1;
		$db="gamebardb_spain";
		$dblog="gamebardblog_spain";
		$report="gamebardb_vodafone_qatar_report";
		
	}
	
}
else{
	if ($operator=='airtel_india')
			{
				$db='funzonedb_airtel';
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
	
}

if($product=='gamebar' || $product=='gamebar')
{
	if($operator == 'Vodafone_Qatar' || $operator == 'Idea')
	{
	if($advertiserid == '8' || $advertiserid == '10' || $advertiserid == '1')
	{
		$text="CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
									AS UNSIGNED) ";
		$text1='subid';
	}
	elseif($advertiserid == '14' || $advertiserid=='13')
	{
		$text="SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 19) ";
		$text1='pubid';
	}	
	else
	{
		$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
		$text1='pubid';
	}
	}
	else
	{
		$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
		$text1='pubid';
	}
	
}
else
{
	if($operator=='Azharbeizan')
	{
		if($advertiserid == '9' )
		{
			$text="CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
									AS UNSIGNED) ";
			$text1='subid';
		}
		else
		{	
			$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
			$text1='pubid';
		}
		
	}
	else{
	
	
	if($advertiserid == '1' || $advertiserid == '14' || $advertiserid == '10')
	{
		$text="CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)
									AS UNSIGNED) ";
		$text1='subid';
	}
	elseif($advertiserid == '4' || $advertiserid=='17')
	{
		$text="SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 19) ";
		$text1='pubid';
	}	
	else
	{
		$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
		$text1='pubid';
	}
	}
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

// report logic below
	if($product=='gamebar' || $product=='gamebar')
	{
		if($b==1)//code of previous data
		{
			
				
				if($advertiserid=='all')
				{
					$sql="SELECT * FROM ".$report.".`pubwise_report` WHERE date >='".$start_date1."' and date <='".$end_date1."' and operator='".$operator."' and product='".$product."'";
					//echo $sql;exit;
					$res2=mysql_query($sql,$conn1);
					
				}
				else{
					$sql="SELECT * FROM ".$report.".`pubwise_report` WHERE date >='".$start_date1."' and date <='".$end_date1."' and operator='".$operator."' and product='".$product."' and advertiserid = ".$advertiserid ;
					//echo $sql;exit;
					$res2=mysql_query($sql,$conn1);	
					
				}
			
		}
					
		if($c==1)
		{
			
						
						
			if($operator=='indonesia')
			{
				 $sql="SELECT 
						aa.dt dt1,
						aa.reff reff1,
						COUNT(DISTINCT aa.clickid) act,
						COUNT(bb.msisdn) dct,
						((COUNT(bb.msisdn) / COUNT(aa.clickid)) * 100) perc,
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
								pubid reff,
								mo.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$db.".mo
						LEFT JOIN ".$db.".activeuserlog userlog ON mo.clickid = userlog.clickid
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >=  '".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount > 0
								and charging_mode='act'
						GROUP BY mo.clickid) aa
							LEFT JOIN
						(SELECT DISTINCT
							mo.clickid,
								mo.msisdn,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".mo
						WHERE
							subscriptionstartdate >=  '".$start_date."'
								AND subscriptionstartdate <=  '".$end_date."'
								AND amount = 0
								and charging_mode='dct'
								AND mo.subscriptionstartdate = mo.subscriptionenddate) bb ON aa.msisdn = bb.msisdn
					GROUP BY aa.dt , advertiser , aa.reff";
					
				
					//echo $sql;
					$res=mysql_query($sql,$conn1);
				
			}
			

			if($operator=='spain')
			{
				 $sql="SELECT 
							aa.dt dt1,
							aa.reff reff1,
							COUNT(DISTINCT aa.clickid) act,
							COUNT(bb.msisdn) dct,
							((COUNT(bb.msisdn) / COUNT(aa.clickid)) * 100) perc,
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
									pubid reff,
									subscriber.msisdn,
									advname,
									advertiser.advertiserid,
									DATE(subscriprion_startdate) dt,
									MAX(userlogid)
							FROM
								".$db.".subscriber
							LEFT JOIN ".$db.".activeuserlog userlog ON subscriber.clickid = userlog.clickid
							INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriprion_startdate >=  '".$start_date."'
									AND subscriprion_startdate <=  '".$end_date."'
									AND amount > 0
									and charging_mode='act'
							GROUP BY subscriber.clickid) aa
								LEFT JOIN
							(SELECT DISTINCT
								subscriber.clickid,
									subscriber.msisdn,
									DATE(subscriprion_startdate) dt
							FROM
								".$db.".subscriber
							WHERE
								subscriprion_startdate >=  '".$start_date."'
									AND subscriprion_startdate <=  '".$end_date."'
									AND amount = 0
									and charging_mode='dct'
									AND subscriber.subscriprion_startdate = subscriber.subscription_enddate) bb ON aa.msisdn = bb.msisdn
						GROUP BY aa.dt , advertiser , aa.reff";									
																				
				
					//echo $sql;
					$res=mysql_query($sql,$conn1);
				
			}
				
		/*if($operator=='Idea')
		{
			
			//$db="hotshotsnewdb_idea_0717";
			//$db1="hotshotsdb";
			//$dblog="hotshotsdblog_idea";
			
			//$sql_ad="select * from ".$db.".advertiser where operator=2";
			//$res_ad=mysql_query($sql_ad,$conn);
			
			if($advertiserid=='all')
			{
				
				
				
				$sql="SELECT 
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
						end ad1,
						
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
							".$db.".subscriptiondetail
						left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
							".$db.".subscriptiondetail
						left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
							".$db.".subscriptiondetail
						left JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
					
				
					//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			else
			{
			
			 $sql="SELECT 
						aa.dt dt1,
						aa.reff reff1,
						COUNT(msisdn) act,
						bb.dct dct,
						aa.advname ad1,
						((bb.dct / COUNT(msisdn)) * 100) perc
					FROM
						(SELECT DISTINCT
							".$text." reff,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
						
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								and charging_mode LIKE '%ACT%' AND advertiser.advertiserid='".$advertiserid."'
						GROUP BY subscriptiondetail.msisdn) aa
							LEFT JOIN
						(SELECT 
							COUNT(*) dct, a.dt, a.advname, a.advertiserid, a.reff1 reff
						FROM
							(SELECT DISTINCT
							".$text." reff1,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount > 0
								and charging_mode LIKE '%ACT%' AND advertiser.advertiserid='".$advertiserid."'
						GROUP BY subscriptiondetail.msisdn) a
						INNER JOIN (SELECT DISTINCT
							".$text." reff2,
								subscriptiondetail.msisdn,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(subscriptionstartdate)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND amount = 0
								and charging_mode LIKE '%DCT%'	AND advertiser.advertiserid='".$advertiserid."'
						GROUP BY subscriptiondetail.msisdn) b ON a.msisdn = b.msisdn AND a.dt = b.dt
							AND a.advertiserid = b.advertiserid
							AND a.reff1 = b.reff2
						GROUP BY a.dt , a.advertiserid , a.reff1) bb ON aa.dt = bb.dt
							AND aa.advertiserid = bb.advertiserid
							AND aa.reff = bb.reff
					GROUP BY aa.dt , aa.advertiserid , aa.reff";
				//echo $sql;
				$res=mysql_query($sql,$conn1);
			}
			
			//$res=mysql_query($sql);
			
			
		}*/
		else if($operator=='airtel_india')
		{
			//$db="hotshotsnewdb_airtel_0717";
			//$dblog="hotshotsdblog_airtel1";
			$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all')
			{
				
				  $sql="SELECT 
						aa.dt dt1,
						 aa.reff reff1,
						COUNT(DISTINCT aa.txnid) act,
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
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								max(userlogid)
						FROM
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
						
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
								AND subscriptiondetail.errorcode = 1000
						GROUP BY subscriptiondetail.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriptiondetail.txnid,
								subscriptiondetail.msisdn,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriptiondetail
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount = 0
								AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
								AND subscriptiondetail.errorcode = 1001
								AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
					GROUP BY aa.dt , advertiser,aa.reff";
										
						//			echo $sql;
										
										$res=mysql_query($sql,$conn1);
									
			}
			else
			{
		
											
								 $sql="SELECT 
						aa.dt dt1,
						 aa.reff reff1,
						COUNT(DISTINCT aa.txnid) act,
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
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								max(userlogid)
						FROM
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
						
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
								AND advertiser.advertiserid=".$advertiserid."
								AND subscriptiondetail.errorcode = 1000
						GROUP BY subscriptiondetail.txnid) aa
							LEFT JOIN
						(SELECT DISTINCT
							subscriptiondetail.txnid,
								subscriptiondetail.msisdn,
								DATE(subscriptionstartdate) dt
						FROM
							".$db.".subscriptiondetail
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <='".$end_date."'
								AND amount = 0
								AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
								AND subscriptiondetail.errorcode = 1001
								AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
					GROUP BY aa.dt , advertiser,aa.reff";
					
				
					//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			//$res=mysql_query($sql);
		}
		
		if($operator=='Vodafone_Qatar')
		{
			//$db="gamebardb_vodafone_qatar";
			//$dblog="hotshotsdblog1";
			$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
			$sql_ad="select * from ".$db.".advertiser where operator=1";
			$res_ad=mysql_query($sql_ad,$conn1);
			
			if($advertiserid=='all')
			{
				
				  $sql="SELECT 
						aa.dt dt1,
						aa.reff reff1,
						COUNT(reqid) act,
						bb.dct dct,
						CASE
							WHEN aa.advname IS NULL THEN 'other'
							ELSE aa.advname
						END ad1,
						((bb.dct / COUNT(reqid)) * 100) perc
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
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
					//echo $sql;
					$res=mysql_query($sql,$conn1);
				
			}
			else
			{
				
				
				
				 $sql="
					SELECT 
						aa.dt dt1,
						aa.reff reff1,
						COUNT(reqid) act,
						bb.dct dct,
						aa.advname ad1,
						((bb.dct / COUNT(reqid)) * 100) perc
					FROM
						(SELECT DISTINCT
								".$text." reff,
								subscriptiondetail.reqid,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND accesstime > SUBDATE('".$start_date."', INTERVAL 30 DAY) 
								AND accesstime < '".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND advertiser.advertiserid= '".$advertiserid."'
						GROUP BY subscriptiondetail.reqid) aa
							LEFT JOIN
						(SELECT 
							COUNT(*) dct, a.dt, a.advname, a.advertiserid, a.reff1 reff
						FROM
							(SELECT DISTINCT
								".$text." reff1,
								subscriptiondetail.reqid,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND accesstime > SUBDATE('".$start_date."', INTERVAL 30 DAY) 
								AND accesstime < '".$end_date."'
								AND amount > 0
								AND isrenew = 0
								AND advertiser.advertiserid= '".$advertiserid."'
						GROUP BY subscriptiondetail.reqid) a
						INNER JOIN (SELECT DISTINCT
								".$text." reff2,
								subscriptiondetail.reqid,
								advname,
								advertiser.advertiserid,
								DATE(subscriptionstartdate) dt,
								MAX(userlogid)
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND accesstime > SUBDATE('".$start_date."', INTERVAL 30 DAY) 
								AND accesstime < '".$end_date."'
								AND amount = 0
								AND charging_mode = 'null'
								AND advertiser.advertiserid= '".$advertiserid."'
						GROUP BY subscriptiondetail.reqid) b ON a.reqid = b.reqid AND a.dt = b.dt
							AND a.advertiserid = b.advertiserid
							AND a.reff1 = b.reff2
						GROUP BY a.dt , a.advertiserid , a.reff1) bb ON aa.dt = bb.dt
							AND aa.advertiserid = bb.advertiserid
							AND aa.reff = bb.reff
					GROUP BY aa.dt , aa.advertiserid , aa.reff
				";
				//echo $sql;
				
				$res=mysql_query($sql,$conn1);
			}
			
			
		}
		
		}
	}	
	else
	{
		


		if($b==1)//code of previous data
		{
			
				
				if($advertiserid=='all')
				{
					$sql="SELECT * FROM ".$report.".`pubwise_report` WHERE date >='".$start_date1."' and date <='".$end_date1."' and operator='".$operator."' and product='".$product."'";
					//echo $sql;exit;
					$res2=mysql_query($sql,$conn1);
					
				}
				else{
					$sql="SELECT * FROM ".$report.".`pubwise_report` WHERE date >='".$start_date1."' and date <='".$end_date1."' and operator='".$operator."' and product='".$product."' and advertiserid = ".$advertiserid ;
					//echo $sql;exit;
					$res2=mysql_query($sql,$conn1);	
					
				}
			
		}
					
		if($c==1)
		{
			
			
		
			if($operator=='airtel_india')
			{
				//$db="hotshotsnewdb_airtel_0717";
				//$dblog="hotshotsdblog_airtel1";
			$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
				$sql_ad="select * from ".$db.".advertiser";
				$res_ad=mysql_query($sql_ad);
				
				if($advertiserid=='all')
				{
					
					  $sql="SELECT 
							aa.dt dt1,
							 aa.reff reff1,
							COUNT(DISTINCT aa.txnid) act,
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
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									max(userlogid)
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
							
							INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <='".$end_date."'
									AND amount > 0
									AND isrenew = 0
									AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
									AND subscriptiondetail.errorcode = 1000
							GROUP BY subscriptiondetail.txnid) aa
								LEFT JOIN
							(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									DATE(subscriptionstartdate) dt
							FROM
								".$db.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <='".$end_date."'
									AND amount = 0
									AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
									AND subscriptiondetail.errorcode = 1001
									AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
						GROUP BY aa.dt , advertiser,aa.reff";
											
							//			echo $sql;
											
											$res=mysql_query($sql,$conn1);
										
				}
				else
				{
			
												
									$sql="SELECT 
							aa.dt dt1,
							 aa.reff reff1,
							COUNT(DISTINCT aa.txnid) act,
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
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									max(userlogid)
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
							
							INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <='".$end_date."'
									AND amount > 0
									AND isrenew = 0
									AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
									AND advertiser.advertiserid=".$advertiserid."
									AND subscriptiondetail.errorcode = 1000
							GROUP BY subscriptiondetail.txnid) aa
								LEFT JOIN
							(SELECT DISTINCT
								subscriptiondetail.txnid,
									subscriptiondetail.msisdn,
									DATE(subscriptionstartdate) dt
							FROM
								".$db.".subscriptiondetail
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <='".$end_date."'
									AND amount = 0
									AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
									AND subscriptiondetail.errorcode = 1001
									AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn 
						GROUP BY aa.dt , advertiser,aa.reff";
						
					
						//echo $sql;
						$res=mysql_query($sql,$conn1);
				}
				//$res=mysql_query($sql);
			}
			else if($operator=='spain')
			{
				 $sql="SELECT 
							aa.dt dt1,
							aa.reff reff1,
							COUNT(DISTINCT aa.clickid) act,
							COUNT(bb.msisdn) dct,
							((COUNT(bb.msisdn) / COUNT(aa.clickid)) * 100) perc,
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
									pubid reff,
									subscriber.msisdn,
									advname,
									advertiser.advertiserid,
									DATE(subscriprion_startdate) dt,
									MAX(userlogid)
							FROM
								".$db.".subscriber
							LEFT JOIN ".$db.".activeuserlog userlog ON subscriber.clickid = userlog.clickid
							INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriprion_startdate >=  '".$start_date."'
									AND subscriprion_startdate <=  '".$end_date."'
									AND amount > 0
									and charging_mode='act'
							GROUP BY subscriber.clickid) aa
								LEFT JOIN
							(SELECT DISTINCT
								subscriber.clickid,
									subscriber.msisdn,
									DATE(subscriprion_startdate) dt
							FROM
								".$db.".subscriber
							WHERE
								subscriprion_startdate >=  '".$start_date."'
									AND subscriprion_startdate <=  '".$end_date."'
									AND amount = 0
									and charging_mode='dct'
									AND subscriber.subscriprion_startdate = subscriber.subscription_enddate) bb ON aa.msisdn = bb.msisdn
						GROUP BY aa.dt , advertiser , aa.reff";									
																				
				
					//echo $sql;
					$res=mysql_query($sql,$conn1);
				
			}
			

	
	/*	
		$c=1;
		if($operator=='Idea')
		{
			
			$db="gamesdb";
			$dblog="gamesdblog_idea";
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=2";
			$res_ad=mysql_query($sql_ad);
			
			if($advertiserid=='all')
			{
				 $sql="
				SELECT 
					a.*, SUM(dct) dct
				FROM
					(SELECT 
						COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad1,
							".$text." reff1,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					inner join ".$db.".requestresponse on annonymoustracking.advertiserid=requestresponse.advertiserid 
					WHERE
						charging_mode LIKE '%ACT%'
							AND amount > 0
						   
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY mobilenumber) a
					GROUP BY dt1 , ad1 , reff1) a
						left JOIN
					(SELECT 
						COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2, reff3
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad2,
							".$text." reff,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					inner join ".$db.".requestresponse on annonymoustracking.advertiserid=requestresponse.advertiserid 
					WHERE
						charging_mode LIKE '%ACT%'
							AND amount > 0
							
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY mobilenumber) a
					INNER JOIN (SELECT DISTINCT
						subscriptiondetail.subscriberid,
							userid,
							subscriptionstartdate dctdt,
							".$text." reff3,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					inner join ".$db.".requestresponse on annonymoustracking.advertiserid=requestresponse.advertiserid 
					WHERE
						charging_mode LIKE '%DCT%'
							AND amount = 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY userid) b ON a.subscriberid = b.subscriberid group by ad2) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
						AND a.reff1 = b.reff3
					where a.reff1 != ''
				GROUP BY a.reff1 , dt1,a.ad1
				ORDER BY dt1 DESC;
				";
				
			}
			else
			{
				$sql="
				SELECT 
					a.*, SUM(dct) dct
				FROM
					(SELECT 
						COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad1,
							".$text." reff1,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					LEFT JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					
					WHERE
						charging_mode LIKE '%ACT%'
							AND amount > 0
							AND advertiser.advertiserid='".$advertiserid."'
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY mobilenumber) a
					GROUP BY dt1 , ad1 , reff1) a
						LEFT JOIN
					(SELECT 
						COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2, reff3
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad2,
							".$text." reff,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					LEFT JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					
					WHERE
						charging_mode LIKE '%ACT%'
							AND amount > 0
							AND advertiser.advertiserid='".$advertiserid."'
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY mobilenumber) a
					INNER JOIN (SELECT DISTINCT
						subscriptiondetail.subscriberid,
							userid,
							subscriptionstartdate dctdt,
							".$text." reff3,
								min(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					
					WHERE
						charging_mode LIKE '%DCT%'
							AND amount = 0
							AND annonymoustracking.advertiserid='".$advertiserid."'
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND accesstime < subscriptionstartdate
					GROUP BY userid) b ON a.subscriberid = b.subscriberid group by reff3) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
						AND a.reff1 = b.reff3
					
				GROUP BY a.reff1 , dt1
				ORDER BY dt1 DESC;
				";
				
			}
			
			$res=mysql_query($sql);
			
			
		}
		else if($operator=='srilanka')
		{
			$db="gamesdb_sridialog";
			$dblog="gamesdblog_sridialog";
			
			$sql_ad="select * from ".$dblog.".advertiser";
			$res_ad=mysql_query($sql_ad,$conn1);
			
			if($advertiserid=='all')
			{
				
				 $sql="SELECT 
							a.*,IFNULL(b.dct, 0) dct, (b.dct / a.act) * 100 perc
						FROM
							(SELECT 
								COUNT(msisdn) act, DATE(a.actdt) dt1, ad1, reff1
							FROM
								(SELECT DISTINCT
									subscriberid,
									msisdn,
									DATE(subscriptionstartdate) actdt,
									advertiser.advname ad1,
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
									MIN(accesstime)
							FROM
								 ".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'act' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY msisdn) a
							GROUP BY dt1 , ad1 , reff1) a
								LEFT JOIN
							(SELECT 
								COUNT(msisdn) dct, DATE(a.actdt) dt2, ad2, reff1
							FROM
								(SELECT DISTINCT
								subscriberid,
									msisdn,
									subscriptionstartdate actdt,
									advertiser.advname ad2,
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
									MIN(accesstime)
							FROM
								".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'act' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY msisdn , reff1) a
							INNER JOIN (SELECT DISTINCT
							   subscriberid,
									userid,
									subscriptionstartdate dctdt,
									MIN(accesstime)
							FROM
							   ".$db.".subscriber 
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							WHERE
								charging_mode = 'dct'
									
									AND amount = 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY userid) b ON a.msisdn = b.userid
							GROUP BY dt2 , ad2 , reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
								AND a.reff1 = b.reff1
						GROUP BY a.reff1";
											//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			else{
				if($advertiserid==16)
				{
					$text="CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 10)AS UNSIGNED) ";
						$text1='subid';
				}
				else{
					$text="CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)AS UNSIGNED) ";
					$text1='pubid';
				}
				
				
				 $sql="SELECT 
							a.*,IFNULL(b.dct, 0) dct, (b.dct / a.act) * 100 perc
						FROM
							(SELECT 
								COUNT(msisdn) act, DATE(a.actdt) dt1, ad1, reff1
							FROM
								(SELECT DISTINCT
									subscriberid,
									msisdn,
									DATE(subscriptionstartdate) actdt,
									advertiser.advname ad1,
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
									MIN(accesstime)
							FROM
								 ".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'act' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									and annonymoustracking.advertiserid=".$advertiserid."
							GROUP BY msisdn) a
							GROUP BY dt1 , ad1 , reff1) a
								LEFT JOIN
							(SELECT 
								COUNT(msisdn) dct, DATE(a.actdt) dt2, ad2, reff1
							FROM
								(SELECT DISTINCT
								subscriberid,
									msisdn,
									subscriptionstartdate actdt,
									advertiser.advname ad2,
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
									MIN(accesstime)
							FROM
								".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'act' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									and annonymoustracking.advertiserid=".$advertiserid."
							GROUP BY msisdn , reff1) a
							INNER JOIN (SELECT DISTINCT
							   subscriberid,
									userid,
									subscriptionstartdate dctdt,
									MIN(accesstime)
							FROM
							   ".$db.".subscriber 
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							WHERE
								charging_mode = 'dct'
									
									AND amount = 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY userid) b ON a.msisdn = b.userid
							GROUP BY dt2 , ad2 , reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
								AND a.reff1 = b.reff1
						GROUP BY a.reff1";
											//echo $sql;
					$res=mysql_query($sql,$conn1);
				
			
			}
			
		}
		else if($operator=='Azharbeizan')
		{
			$db="gamesdb_azerbaijan";
			$dblog="gamesdblog_azerbaijan";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$conn1);
			
			if($advertiserid=='all')
			{
				
				 $sql="SELECT 
							a.*,IFNULL(b.dct, 0) dct, (b.dct / a.act) * 100 perc
						FROM
							(SELECT 
								COUNT(msisdn) act, DATE(a.actdt) dt1, ad1, reff1
							FROM
								(SELECT DISTINCT
									subscriberid,
									msisdn,
									DATE(subscriptionstartdate) actdt,
									advertiser.advname ad1,
									CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
										AS UNSIGNED) reff1,
									MIN(accesstime)
							FROM
								 ".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'subscribed' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY msisdn) a
							GROUP BY dt1 , ad1 , reff1) a
								LEFT JOIN
							(SELECT 
								COUNT(msisdn) dct, DATE(a.actdt) dt2, ad2, reff1
							FROM
								(SELECT DISTINCT
								subscriberid,
									msisdn,
									subscriptionstartdate actdt,
									advertiser.advname ad2,
									CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
										AS UNSIGNED) reff1,
									MIN(accesstime)
							FROM
								".$db.".subscriber
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
							WHERE
								charging_mode = 'subscribed' and amount > 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY msisdn , reff1) a
							INNER JOIN (SELECT DISTINCT
							   subscriberid,
									userid,
									subscriptionstartdate dctdt,
									MIN(accesstime)
							FROM
							   ".$db.".subscriber 
							INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.msisdn
							WHERE
								(charging_mode = 'null'
									OR charging_mode LIKE '%suspend%')
									AND amount = 0
									AND subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
							GROUP BY userid) b ON a.subscriberid = b.subscriberid
							GROUP BY dt2 , ad2 , reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
								AND a.reff1 = b.reff1
						GROUP BY a.reff1";
											//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			else{
			
			}
		}
		else if($operator=='ooredoo')
		{
			$db='gamesdb_ooredoo_qatar';
			$dblog='gamesdblog_ooredoo_qatar';
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$conn1);
			
			if($advertiserid=='all')
			{
				
				 $sql="SELECT 
					a.*, b.dct, (b.dct / a.act) * 100 perc
				FROM
					(SELECT 
						COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							DATE(subscriptionstartdate) actdt,
							advertiser.advname ad1,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							
					GROUP BY mobilenumber) a
					GROUP BY dt1 , ad1,reff1) a
						LEFT JOIN
					(SELECT 
						COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2,reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad2,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
						   
					GROUP BY mobilenumber,reff1) a
					INNER JOIN (SELECT DISTINCT
						subscriptiondetail.subscriberid,
							userid,
							subscriptionstartdate dctdt,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					WHERE
						(charging_mode = 'null'
							OR charging_mode LIKE '%suspend%')
							AND amount = 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
					GROUP BY userid) b ON a.subscriberid = b.subscriberid
					GROUP BY dt2 , ad2 ,reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
						AND a.reff1 = b.reff1 group by a.reff1";
					//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			else{
				
			}
		}
		else if($operator=='etisalat')
		{
			$db='gamesdb_etisalat';
			$dblog='gamesdblog_etisalat';
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysql_query($sql_ad,$conn1);
			
			if($advertiserid=='all')
			{
				
				 $sql="SELECT 
					a.*, b.dct, (b.dct / a.act) * 100 perc
				FROM
					(SELECT 
						COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							DATE(subscriptionstartdate) actdt,
							advertiser.advname ad1,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							
					GROUP BY mobilenumber) a
					GROUP BY dt1 , ad1,reff1) a
						LEFT JOIN
					(SELECT 
						COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2,reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad2,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
						   
					GROUP BY mobilenumber,reff1) a
					INNER JOIN (SELECT DISTINCT
						subscriptiondetail.subscriberid,
							userid,
							subscriptionstartdate dctdt,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					WHERE
						(charging_mode = 'null'
							OR charging_mode LIKE '%suspend%')
							AND amount = 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
					GROUP BY userid) b ON a.subscriberid = b.subscriberid
					GROUP BY dt2 , ad2 ,reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
						AND a.reff1 = b.reff1 group by a.reff1";
					//echo $sql;
					$res=mysql_query($sql,$conn1);
			}
			else{
				
			}
		}
		else
		{
			$db="gamesdb_voda";
			$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1";
			$res_ad=mysql_query($sql_ad,$con);
			
			if($advertiserid=='all')
			{
				 $sql="SELECT 
					a.*, b.dct, (b.dct / a.act) * 100 perc
				FROM
					(SELECT 
						COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							DATE(subscriptionstartdate) actdt,
							advertiser.advname ad1,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							
					GROUP BY mobilenumber) a
					GROUP BY dt1 , ad1,reff1) a
						LEFT JOIN
					(SELECT 
						COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2,reff1
					FROM
						(SELECT DISTINCT
						subscriptiondetail.subscriberid,
							mobilenumber,
							subscriptionstartdate actdt,
							advertiser.advname ad2,
							CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
								AS UNSIGNED) reff1,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
					WHERE
						isrenew = 0 AND amount > 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
						   
					GROUP BY mobilenumber,reff1) a
					INNER JOIN (SELECT DISTINCT
						subscriptiondetail.subscriberid,
							userid,
							subscriptionstartdate dctdt,
							MIN(accesstime)
					FROM
						".$db.".subscriptiondetail
					INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
					INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
					WHERE
						(charging_mode = 'null'
							OR charging_mode LIKE '%suspend%')
							AND amount = 0
							AND subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
					GROUP BY userid) b ON a.subscriberid = b.subscriberid
					GROUP BY dt2 , ad2 ,reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
						AND a.reff1 = b.reff1 group by a.reff1";
									//echo $sql;
				
			}
			else
			{
			 $sql="
							SELECT 
				a.*, b.dct, (b.dct / a.act) * 100 perc
			FROM
				(SELECT 
					COUNT(mobilenumber) act, DATE(a.actdt) dt1, ad1, reff1
				FROM
					(SELECT DISTINCT
					subscriptiondetail.subscriberid,
						mobilenumber,
						DATE(subscriptionstartdate) actdt,
						advertiser.advname ad1,
						CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
							AS UNSIGNED) reff1,
						MIN(accesstime)
				FROM
					".$db.".subscriptiondetail
				INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
				INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
				INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
				WHERE
					isrenew = 0 AND amount > 0
						AND subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate < '".$end_date."'
						AND advertiser.advertiserid = ".$advertiserid."
				GROUP BY mobilenumber) a
				GROUP BY dt1 , ad1,reff1) a
					LEFT JOIN
				(SELECT 
					COUNT(mobilenumber) dct, DATE(a.actdt) dt2, ad2,reff1
				FROM
					(SELECT DISTINCT
					subscriptiondetail.subscriberid,
						mobilenumber,
						subscriptionstartdate actdt,
						advertiser.advname ad2,
						CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 10)
							AS UNSIGNED) reff1,
						MIN(accesstime)
				FROM
					".$db.".subscriptiondetail
				INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
				INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
				INNER JOIN ".$dblog.".advertiser ON advertiser.advertiserid = annonymoustracking.advertiserid
				WHERE
					isrenew = 0 AND amount > 0
						AND subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate < '".$end_date."'
						AND advertiser.advertiserid = ".$advertiserid."
				GROUP BY mobilenumber,reff1) a
				INNER JOIN (SELECT DISTINCT
					subscriptiondetail.subscriberid,
						userid,
						subscriptionstartdate dctdt,
						MIN(accesstime)
				FROM
					".$db.".subscriptiondetail
				INNER JOIN ".$db.".subscriber ON subscriber.subscriberid = subscriptiondetail.subscriberid
				INNER JOIN ".$dblog.".annonymoustracking ON annonymoustracking.userid = subscriber.mobilenumber
				WHERE
					(charging_mode = 'null'
						OR charging_mode LIKE '%suspend%')
						AND amount = 0
						AND subscriptionstartdate >= '".$start_date."'
						AND subscriptionstartdate < '".$end_date."'
				GROUP BY userid) b ON a.subscriberid = b.subscriberid
				GROUP BY dt2 , ad2 ,reff1) b ON a.dt1 = b.dt2 AND a.ad1 = b.ad2
					AND a.reff1 = b.reff1 group by a.reff1";
								//echo $sql;
			}
			
			$res=mysql_query($sql,$con);
		}
	*/
		}

	
//echo $sql;




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
                    <h2>PubID wise Report </h2>
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
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Glambar</option>
						</select>
						</div>
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
						<?php
						if($product == 'gamebar')
						{ ?>
							<option>Operator</option>
							<option value="Vodafone_Qatar" <?php if($operator=='Vodafone_Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_Qatar</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel_India</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?>>Indonesia</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain</option>
						<!--	<option value="Airtel" <?php //if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>-->
						<?php
						}
						else if($product == 'glambar'){
							
						?>
						
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel_India</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain</option>
							<!--<option value="Vodafone_Qatar" <?php //if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
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

						
						
						<?php
						//echo $count;exit;
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
									<td><strong>Pub ID</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Deactivation</strong></td>
									<td><strong>Percentage</strong></td>
									
									
													
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$act_sum='';
								$dct_sum='';
								
								
								$a=0;
								if($c==1)
								{
								while($row=mysql_fetch_array($res))
								{
								
								?>
								<tr>
									<td><?php echo $row['dt1'];  ?></td>
									<td><?php echo $row['ad1'];  ?></td>									
									<td><?php echo $row['reff1'];  ?></td>									
									<td><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></td>
									<td><?php echo number_format($row['dct']); $dct_sum=$dct_sum+$row['dct'];?></td>
									<td><?php echo number_format(($row['dct']*100)/$row['act'],2)." %"; ?></td>
									
								</tr>
								<?php
								}
								}
								if($b==1)
								{
								while($row2=mysql_fetch_array($res2))
								{
								
								?>
								<tr>
									<td><?php echo $row2['date'];  ?></td>
									<td><?php echo $row2['advname'];  ?></td>									
									<td><?php echo $row2['reff1'];  ?></td>									
									<td><?php echo number_format($row2['act']); $act_sum=$act_sum+$row2['act'];?></td>
									<td><?php echo number_format($row2['dct']); $dct_sum=$dct_sum+$row2['dct'];?></td>
									<td><?php echo number_format(($row2['dct']*100)/$row2['act'],2)." %"; ?></td>
									
								</tr>
								<?php
								}
								}
								?>

								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td><?php  echo number_format($act_sum); ?></td>
									<td><?php  echo number_format($dct_sum); ?></td>
									<td><strong><?php $perc=number_format(($dct_sum/$act_sum)*100,2)." %"; if($perc > 15){echo "<span style='color:red;'>".$perc."</span>";}else{echo "<span style='color:green;'>".$perc."</span>";}?></strong></td>
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
	if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		select.options[select.options.length] = new Option('Airtel_india', 'airtel_india');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Spain', 'spain');
		
	}
	else if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Airtel_india', 'airtel_india');
		select.options[select.options.length] = new Option('Spain', 'spain');
		//select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		//select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		//select.options[select.options.length] = new Option('etisalat', 'etisalat');
		//select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
	//	select.options[select.options.length] = new Option('srilanka', 'srilanka');
	}
	
	/*if(x=="gamebar")
	{
		 //alert("hi");
	document.getElementById('azharbeizan').style.visibility = 'hidden';
	}else
	{
		document.getElementById('azharbeizan').style.visibility = 'visible';
	}*/
}
</script>		
   		