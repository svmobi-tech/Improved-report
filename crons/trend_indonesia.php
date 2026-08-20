<?php
require_once __DIR__ . '/../admin/includes/config.php';

$con2=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2
$con1=$con2;
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';

$glambar_airtel='funzonedb_airtel';
$gamebar_airtel='gamebardb_airtel';
$gamebar_indonesia='gamebardb_indonesia';
//$hadb='gamebardb_vodafone_qatar_report';
$hvdb="gamebardb_vodafone_qatar";
$report="gamebardb_vodafone_qatar_report";

$hadb=$report;
mysqli_query($con1,"delete from ".$report.".trend_report where date='".$date1."' and operator='indonesia'");

$gamebarlog_indonesia='gamebardblog_indonesia_25062018';
//activation
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(clickid) act,
	aa.advertiserid advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        mo.clickid,
            mo.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$gamebar_indonesia.".mo
    left JOIN ".$gamebar_indonesia.".advertiser ON mo.advid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
           and charging_mode='act'
            AND amount > 0
            
    GROUP BY mo.clickid) aa
GROUP BY aa.dt , hr,advertiserid;";
//echo $sql1;exit;
$count=0;
if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=$row1['amt'];
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="activation";
	
	 $ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(clickid) act,
    aa.advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        mo.clickid,
            mo.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$gamebar_indonesia.".mo
    LEFT JOIN ".$gamebar_indonesia.".advertiser ON mo.advid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND charging_mode='ren'
    GROUP BY mo.clickid) aa
GROUP BY aa.dt , hr ,advertiserid";

if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=$row1['amt'];
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="renew";
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}


$userlogname='userlog';
$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog1.advertiserid, advname
FROM ".$gamebarlog_indonesia.".".$userlogname." userlog1
left JOIN ".$gamebar_indonesia.".advertiser ON userlog1.advertiserid = advertiser.advertiserid
WHERE accesstime >=  '".$start_date."'
AND accesstime <= '".$end_date."'
GROUP BY dt, hr, advname
ORDER BY hr";

if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=0;
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="clicks";
	
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
				
		
	$res1=$con1->query($ins1);
				
	
	
	
}




//clicks
/*$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$gamebar_indonesia.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}


$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog1.advertiserid, advname
FROM ".$gamebarlog_indonesia.".".$userlogname." userlog1
left JOIN ".$gamebar_indonesia.".advertiser ON userlog1.advertiserid = advertiser.advertiserid
WHERE accesstime >=  '".$start_date."'
AND accesstime <= '".$end_date."'
GROUP BY dt, hr, advname
ORDER BY hr";

if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=0;
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="clicks";
	
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
				
		
	$res1=$con1->query($ins1);
				
	
	
	
}*/
//PARKING
 $sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(clickid) act,
   aa. advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        mo.clickid,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$gamebar_indonesia.".mo
    left JOIN ".$gamebar_indonesia.".advertiser ON mo.advid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
            AND subscriptionstartdate <='".$end_date."'
            AND amount = 0
            AND charging_mode='act'
            
    GROUP BY mo.clickid) aa
GROUP BY aa.dt , hr,advertiserid;";

//echo $sql1;exit;
if($result1 = $con1->query($sql1))
{	
$count++;
}

while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=$row1['amt'];
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="parking";
	
	
	
	 
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
					
		
	$res1=$con1->query($ins1);
	
}

//cr

$sql1="SELECT 
    act, dt, hr, amt, act1,c.advertiserid,c.advname
FROM
    (SELECT 
        COUNT(clickid) act, dt, hr, SUM(amount) amt,advertiserid,advname
    FROM
        (SELECT 
        mo.clickid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            
            advertiser.advertiserid,
            advertiser.advname,
            amount
    FROM
        ".$gamebar_indonesia.".mo
		left join ".$gamebarlog_indonesia.".userlog on mo.clickid=userlog.clickid
    left JOIN ".$gamebar_indonesia.".advertiser ON advertiser.advertiserid = mo.advid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <'".$end_date."'
            AND charging_mode='act'
            AND amount > 0
            AND DATE(accesstime) = DATE(subscriptionstartdate)
    GROUP BY mo.clickid , dt , advertiser.advertiserid) b
    GROUP BY dt , hr,advertiserid) c,
    (SELECT 
        COUNT(userlogid) act1,
            DATE(AccessTime) dt1,
            HOUR(AccessTime) hr1,
     		advertiserid
    FROM
        ".$gamebarlog_indonesia.".userlog
    
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
            
    GROUP BY dt1 , hr1,advertiserid) d
WHERE
    d.dt1 = c.dt AND d.hr1 = c.hr and d.advertiserid=c.advertiserid;";
	
	//echo $sql1; exit;
if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=number_format(($row1['act']/$row1['act1'])*100,2);
	$amt=0;
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="cr";
	$hr=$row1['hr'];
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
					
		
	$res1=$con1->query($ins1);
}
//callback



  $sql1="SELECT COUNT( clickid ) act, DATE( requesttime ) dt, HOUR( requesttime ) hr, advertiser.advertiserid, advertiser.advname
FROM  ".$gamebar_indonesia.".callbackresponse
LEFT JOIN  ".$gamebar_indonesia.".advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
WHERE requesttime >= '".$start_date."'
AND requesttime <= '".$end_date."'
and issent=1

GROUP BY dt, hr,advertiserid";

//echo $sql1; exit;
if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=0;
	$advname=$row1['advname'];
	$advertiserid=$row1['advertiserid'];
	$type="callback";
	
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','indonesia','gamebar') ";
					
		
	$res1=$con1->query($ins1);
}
