<?php
require_once __DIR__ . '/../admin/includes/config.php';

try{
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST4 . ':' . DB_PROD_PORT4, DB_USER, DB_PROD_PASS4) or die(mysql_error());//cluster 2
$con1=$con2;

$hidb="hotshotsnewdb_idea_0717";
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
mysqli_query($con1,"delete from ".$hidb.".trend_report where date='".$date1."'");
//exit;
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';


//echo "hi";exit;




//activation
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    aa.advname advname,
	aa.advertiserid,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hidb.".subscriptiondetail
    INNER JOIN ".$hidb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
    INNER JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
			
            AND amount > 0
            AND (charging_mode LIKE '%act%'
            OR charging_mode LIKE '%UPGRD%')) aa
GROUP BY aa.dt , hr,advertiserid;";


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
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}


$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.txnid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hidb.".subscriptiondetail
 
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
           AND amount > 0
            AND (charging_mode LIKE '%act%'
            OR charging_mode LIKE '%UPGRD%')) aa
GROUP BY aa.dt , hr";


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
	//$advname=$row1['advname'];
	//$advertiserid=$row1['advertiserid'];
	$type="activation";
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','0','all','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}






//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(msisdn) act,
    aa.advname advname,
    aa.advertiserid advertiserid,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hidb.".subscriptiondetail
    INNER JOIN ".$hidb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
    INNER JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 1
            AND amount > 0
            ) aa
GROUP BY aa.dt , hr, advertiserid;";


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
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}



$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(msisdn) act,
    
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.msisdn,
            
            
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hidb.".subscriptiondetail
		WHERE
        subscriptionstartdate >'".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 1
            AND amount > 0
            ) aa
GROUP BY aa.dt ,hr";


if($result1 = $con1->query($sql1))
{	
$count++;
}
while($row1=mysqli_fetch_array($result1))
{
	$hr=$row1['hr'];
	$act=$row1['act'];
	$amt=$row1['amt'];
	$advname='all';
	$advertiserid='0';
	$type="renew";
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}





//clicks

$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog.advertiserid, advname
FROM ".$hidb.".userlog
INNER JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
	
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
				
		
	$res1=$con1->query($ins1);
				
	
	
	
}


$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr
FROM ".$hidb.".userlog
WHERE accesstime >=  '".$start_date."'
AND accesstime <= '".$end_date."'
GROUP BY dt, hr
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
	$advname='all';
	$advertiserid='0';
	$type="clicks";
	
	
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
				
		
	$res1=$con1->query($ins1);
	
}



//PARKING
$sql1="SELECT COUNT( txnid ) act, 
dt, 
hr, 
SUM( amount ) amt, 
advertiserid,
case when advname is null then 'other'
else advname
end advname
FROM (
SELECT DISTINCT subscriptiondetail.txnid, subscriptiondetail.msisdn, DATE( subscriptionstartdate ) dt, HOUR( subscriptionstartdate ) hr, amount, userlog.advertiserid, advertiser.advname
FROM ".$hidb.".subscriptiondetail
LEFT JOIN ".$hidb.".userlog ON subscriptiondetail.txnid = userlog.txnid
LEFT JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
WHERE subscriptionstartdate >=  '".$start_date."'
AND subscriptionstartdate <= '".$end_date."'
AND charging_mode LIKE  '%ACT%'
AND amount =0
)b
GROUP BY dt, hr, advertiserid
";



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
	
	
	
	 
	 
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
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
            amount,
			advertiser.advertiserid,
			advertiser.advname
    FROM
        ".$hidb.".subscriptiondetail
    INNER JOIN ".$hidb.".userlog ON subscriptiondetail.txnid = userlog.txnid
    INNER JOIN ".$hidb.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        subscriptionstartdate >=  '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND charging_mode LIKE '%ACT%'
           
            AND DATE(accesstime) = DATE(subscriptionstartdate)
    GROUP BY subscriptiondetail.txnid , dt , advertiserid) b
    GROUP BY dt , hr,advertiserid) c,
    (SELECT 
        COUNT(userlogid) act1,
            DATE(AccessTime) dt1,
            HOUR(AccessTime) hr1,
			advertiserid
    FROM
        ".$hidb.".userlog
		
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
	
    GROUP BY dt1 , hr1 ,advertiserid) d
WHERE
    d.dt1 = c.dt AND d.hr1 = c.hr and c.advertiserid=d.advertiserid;";

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
	
	 
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
}
//callback


$sql1="SELECT COUNT( advertcallbackid ) act, DATE( senttime ) dt, HOUR( senttime ) hr, advertiser.advertiserid, advertiser.advname
FROM  ".$hidb.".advertcallback
LEFT JOIN  ".$hidb.".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
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
	
	
	 
	$ins1="INSERT INTO ".$hidb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."') ";
					
		
	$res1=$con1->query($ins1);
}


if($count!=8)
{
	//echo $count;
	
	$headers ="MIME-Version: 1.0"."\r\n";
	$headers .="Content-type:text/html;charset=UTF-8"."\r\n";
	$headers .="from :Support@loop360.co"."\r\n";
	//mail("mehul.gediya@loop360.co","cron error","<h2 style='color:red'>cron_trend_report_hotshots_idea.php was not run successfully</h2>",$headers);
	$trendidea=0;
	
	
}
else{
	$trendidea=1;
	//$sql="update hotshotsnewdb_voda_0617.cron_report set cron_trend_idea=".$trendidea." where date='".$date1."'";
	$cur_date=date('Y-m-d H-i:s');
	$sql="update cron_report.cron_report set ran=".$trendidea.", date='".$cur_date."' where cron_name='cron_trend_idea'";
	$result = mysqli_query($con2,$sql) ;
}

} catch (Exception  $e) { 
 
  die ("We seem to be having file system issues. 
        We are sorry for the inconvenience."); 
 
} 
