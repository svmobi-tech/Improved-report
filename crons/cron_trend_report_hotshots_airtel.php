<?php
require_once __DIR__ . '/../admin/includes/config.php';

try{
	
	
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0"); //cluster1
$con2=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2
 $con1=$con2;
 date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';
 //$userdate=date('dmY',strtotime("-1 days"));
//exit;

$glambar_airtel='funzonedb_airtel';
$gamebar_airtel='gamebardb_airtel';
$hadb='gamebardb_vodafone_qatar_report';
//$hadb="hotshotsnewdb_airtel_0717";
mysqli_query($con1,"delete from ".$hadb.".trend_report where date='".$date1."'");
//activation
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
	aa.advertiserid advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    
    left JOIN ".$gamebar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
           
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
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
	
	 $ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    aa.advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    
    LEFT JOIN ".$gamebar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND isrenew = 1
            
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
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
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//clicks
$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$gamebar_airtel.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}


$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog1.advertiserid, advname
FROM ".$gamebar_airtel.".".$userlogname." userlog1
left JOIN ".$gamebar_airtel.".advertiser ON userlog1.advertiserid = advertiser.advertiserid
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
	
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
				
		
	$res1=$con1->query($ins1);
				
	
	
	
}
//PARKING
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
   aa. advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid

    left JOIN ".$gamebar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
            AND subscriptionstartdate <='".$end_date."'
            AND amount = 0
            AND isrenew = 0
           and (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
            AND subscriptiondetail.errorcode = 1000
           
    GROUP BY subscriptiondetail.txnid) aa
GROUP BY aa.dt , hr,advertiserid;";


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
	
	
	
	 
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
					
		
	$res1=$con1->query($ins1);
	
}

//cr

$sql1="SELECT 
    act, dt, hr, amt, act1,c.advertiserid,c.advname
FROM
    (SELECT 
        COUNT(txnid) act, dt, hr, SUM(amount) amt,advertiserid,advname
    FROM
        (SELECT 
        subscriptiondetail.txnid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            MAX(userlogid) atid,
            advertiser.advertiserid,
            advertiser.advname,
            amount
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    left JOIN ".$gamebar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    left JOIN ".$gamebar_airtel.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <'".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND errorcode = 1000
           
            AND DATE(accesstime) = DATE(subscriptionstartdate)
    GROUP BY subscriptiondetail.txnid , dt , advertiser.advertiserid) b
    GROUP BY dt , hr,advertiserid) c,
    (SELECT 
        COUNT(userlogid) act1,
            DATE(AccessTime) dt1,
            HOUR(AccessTime) hr1,
     		advertiserid
    FROM
        ".$gamebar_airtel.".userlog
    
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
            
    GROUP BY dt1 , hr1,advertiserid) d
WHERE
    d.dt1 = c.dt AND d.hr1 = c.hr and d.advertiserid=c.advertiserid;";
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
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
					
		
	$res1=$con1->query($ins1);
}
//callback


$sql1="SELECT COUNT( advertcallbackid ) act, DATE( senttime ) dt, HOUR( senttime ) hr, advertiser.advertiserid, advertiser.advname
FROM  ".$gamebar_airtel.".advertcallback
LEFT JOIN  ".$gamebar_airtel.".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
WHERE senttime >= '".$start_date."'
AND senttime <= '".$end_date."'
and isact!=0
GROUP BY dt, hr,advertiserid";


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
	
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','gamebar') ";
					
		
	$res1=$con1->query($ins1);
}

//glambar_airtel

//activation
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
	aa.advertiserid advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    
    left JOIN ".$glambar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
           
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
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
	
	 $ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    aa.advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    
    LEFT JOIN ".$glambar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND isrenew = 1
            
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
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
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//clicks
$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$glambar_airtel.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}


$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog1.advertiserid, advname
FROM ".$glambar_airtel.".".$userlogname." userlog1
left JOIN ".$glambar_airtel.".advertiser ON userlog1.advertiserid = advertiser.advertiserid
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
	
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
				
		
	$res1=$con1->query($ins1);
				
	
	
	
}
//PARKING
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
   aa. advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            userlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid

    left JOIN ".$glambar_airtel.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
            AND subscriptionstartdate <='".$end_date."'
            AND amount = 0
            AND isrenew = 0
           and (charging_mode = 600404 or charging_mode = 600409 or charging_mode = 600398)
  
            AND subscriptiondetail.errorcode = 1000
           
    GROUP BY subscriptiondetail.txnid) aa
GROUP BY aa.dt , hr,advertiserid;";


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
	
	
	
	 
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
					
		
	$res1=$con1->query($ins1);
	
}

//cr

$sql1="SELECT 
    act, dt, hr, amt, act1,c.advertiserid,c.advname
FROM
    (SELECT 
        COUNT(txnid) act, dt, hr, SUM(amount) amt,advertiserid,advname
    FROM
        (SELECT 
        subscriptiondetail.txnid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            MAX(userlogid) atid,
            advertiser.advertiserid,
            advertiser.advname,
            amount
    FROM
        ".$glambar_airtel.".subscriptiondetail
    left JOIN ".$glambar_airtel.".userlog ON subscriptiondetail.txnid = userlog.txnid
    left JOIN ".$glambar_airtel.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <'".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND errorcode = 1000
           
            AND DATE(accesstime) = DATE(subscriptionstartdate)
    GROUP BY subscriptiondetail.txnid , dt , advertiser.advertiserid) b
    GROUP BY dt , hr,advertiserid) c,
    (SELECT 
        COUNT(userlogid) act1,
            DATE(AccessTime) dt1,
            HOUR(AccessTime) hr1,
     		advertiserid
    FROM
        ".$glambar_airtel.".userlog
    
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
            
    GROUP BY dt1 , hr1,advertiserid) d
WHERE
    d.dt1 = c.dt AND d.hr1 = c.hr and d.advertiserid=c.advertiserid;";
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
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
					
		
	$res1=$con1->query($ins1);
}
//callback


$sql1="SELECT COUNT( advertcallbackid ) act, DATE( senttime ) dt, HOUR( senttime ) hr, advertiser.advertiserid, advertiser.advname
FROM  ".$glambar_airtel.".advertcallback
LEFT JOIN  ".$glambar_airtel.".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
WHERE senttime >= '".$start_date."'
AND senttime <= '".$end_date."'
and isact!=0
GROUP BY dt, hr,advertiserid";


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
	
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','airtel_india','glambar') ";
					
		
	$res1=$con1->query($ins1);
}










/*
if($count!=6)
{
	//echo $count;
	
	$headers ="MIME-Version: 1.0"."\r\n";
	$headers .="Content-type:text/html;charset=UTF-8"."\r\n";
	$headers .="from :Support@loop360.co"."\r\n";
	//mail("mehul.gediya@loop360.co","cron error","<h2 style='color:red'>cron_trend_report_hotshots_airtel.php was not run successfully</h2>",$headers);
	$trendairtel=0;
	
}
else{
	$trendairtel=1;
	//$sql="update hotshotsnewdb_voda_0617.cron_report set cron_trend_airtel=".$trendairtel." where date='".$date1."'";
	
	$cur_date=date('Y-m-d H-i:s');
	$sql="update cron_report.cron_report set ran=".$trendairtel.", date='".$cur_date."' where cron_name='cron_trend_airtel'";
	$result = mysqli_query($con2,$sql) ;
}

} catch (Exception  $e) { 
 
  die ("We seem to be having file system issues. 
        We are sorry for the inconvenience."); 
 
} */
?>



