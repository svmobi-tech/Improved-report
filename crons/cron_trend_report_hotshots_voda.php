<?php
require_once __DIR__ . '/../admin/includes/config.php';
try{
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysqli_error());//cluster 2
$con1=$con2;
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';

$glambar_airtel='funzonedb_airtel';
$hotshots_airtel='hotshotsdb_airtel';
$gamebar_airtel='gamebardb_airtel';
//$hadb='gamebardb_vodafone_qatar_report';
$hvdb="gamebardb_vodafone_qatar";
$report="gamebardb_vodafone_qatar_report";
$gamebarlog_indonesia='gamebardblog_indonesia';
$gamebar_indonesia='gamebardb_indonesia';
$hadb=$report;
mysqli_query($con1,"delete from ".$report.".trend_report where date='".$date1."'");








//activation
 $sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(reqid) act,
    aa.advname advname,
	aa.advertiserid advertiserid,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.reqid,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hvdb.".subscriptiondetail
    INNER JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    INNER JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND amount > 0
            AND isrenew = 0) aa
GROUP BY aa.dt , hr,advname order by advname,hr;";
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
	
	 $ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}


$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(reqid) act,
    
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.reqid,
            
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hvdb.".subscriptiondetail
    
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND amount > 0
            AND isrenew = 0) aa
GROUP BY aa.dt , hr order by hr;";
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
	
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','0','all','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}









//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(reqid) act,
    aa.advname advname,
	aa.advertiserid advertiserid,
    SUM(amount) amt
FROM
    (SELECT DISTINCT
        subscriptiondetail.reqid,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hvdb.".subscriptiondetail
    INNER JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    INNER JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate > '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND amount > 0
            AND isrenew = 1) aa
GROUP BY aa.dt , hr,advname order by advname,hr;";


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
	
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}


//renew all
$sql1="SELECT 
    COUNT(msisdn) act,
  	HOUR (subscriptionstartdate) hr,
    SUM(amount) amt
FROM
    (
SELECT 
           distinct msisdn,
          max(subscriptionstartdate) subscriptionstartdate,
         	amount,
            isrenew
    FROM
        ".$hvdb.".subscriptiondetail 

    WHERE
        subscriptionstartdate >'".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0 
			and isrenew=1
        
        group by msisdn)aa  group by hr";
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
	$type="renew";
	
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','0','all','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}





//clicks

$sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, 

userlog.advertiserid, 
advname

FROM ".$hvdb.".userlog
left JOIN ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
	// `date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`, `operator`, `product`
	
	  $ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//clicks

$sql1="SELECT COUNT( txnid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr
FROM ".$hvdb.".userlog
WHERE accesstime >=  '".$start_date."'
AND accesstime <= '".$end_date."'
GROUP BY dt,hr
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
	$advname="all";
	$advertiserid="0";
	$type="clicks";
	
	
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}




//PARKING
$sql1="SELECT 
    COUNT(reqid) act, dt, hr, SUM(amount) amt,advertiserid,advname
FROM
    (SELECT DISTINCT
        subscriptiondetail.reqid,
            subscriptiondetail.msisdn,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
     		userlog.advertiserid,
     		advertiser.advname
    FROM
        ".$hvdb.".subscriptiondetail
    LEFT JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    inner join ".$hvdb.".advertiser on userlog.advertiserid=advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND charging_mode = 'PARKING') b
GROUP BY dt , hr,advertiserid
order by hr";




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
	
	
	
	 
	 
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
	
}

//cr

$sql1="SELECT 
    act, dt, hr, amt, act1,c.advertiserid,c.advname
FROM
    (SELECT 
        COUNT(reqid) act, dt, hr, SUM(amount) amt,advertiserid,advname
    FROM
        (SELECT DISTINCT
        reqid, dt, hr, amount,userlog.advertiserid,advname
    FROM
        ".$hvdb.".userlog
    INNER JOIN (SELECT 
        reqid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            MAX(userlogid) atid,
            amount,userlog.advertiserid,advertiser.advname
    FROM
        ".$hvdb.".subscriptiondetail
    INNER JOIN ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    INNER JOIN ".$hvdb.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 0
            AND amount > 0
           
            AND DATE(accesstime) = DATE(subscriptionstartdate)
    GROUP BY subscriptiondetail.reqid , dt , advertiser.advertiserid) a ON a.atid = userlogid ) b
    GROUP BY dt , hr,advertiserid) c,
    (SELECT 
        COUNT(userlogid) act1,
            DATE(AccessTime) dt1,
            HOUR(AccessTime) hr1,
            advertiserid
    FROM
        ".$hvdb.".userlog
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
	
	 
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
}
//callback


$sql1="SELECT 
    COUNT(advertcallbackid) act,
    DATE(senttime) dt,
    HOUR(senttime) hr,
    advertcallback.advertiserid,
    advertiser.advname
FROM
    ".$hvdb.".advertcallback
	left join ".$hvdb.".advertiser on advertcallback.advertiserid=advertiser.advertiserid
WHERE
    senttime > '".$start_date."'
        AND senttime < '".$end_date."'
       
GROUP BY dt , hr,advertiserid";


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
	
	
	 
	$ins1="INSERT INTO ".$report.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`product`,`operator`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','gamebar','Vodafone_Qatar') ";
					
		
	$res1=$con1->query($ins1);
}

//gamebar indonesia


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
					
		//exit;
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







//clicks
$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$gamebarlog_indonesia.".".$userlogna." limit 1 ";
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
				
	
	
	
}
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









//gamebar_airtel
/*

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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    
    left JOIN ".$gamebar_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
           
            AND amount > 0
            AND isrenew = 0
           and (charging_mode = 600382 or charging_mode = 600388 or charging_mode = 600375)
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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    
    LEFT JOIN ".$gamebar_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
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
            
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$gamebar_airtel.".subscriptiondetail
    left JOIN ".$gamebar_airtel.".advertiser ON subscriptiondetail.advertid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
            AND subscriptionstartdate <='".$end_date."'
            AND amount = 0
            AND isrenew = 0
            AND (charging_mode = 541729  or charging_mode = 548184 or charging_mode = 548185 or charging_mode = 548186 or charging_mode = 548178)
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
    left JOIN ".$gamebar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    left JOIN ".$gamebar_airtel.".advertiser ON advertiser.advertiserid = activeuserlog.advertiserid
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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    
    left JOIN ".$glambar_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    
    LEFT JOIN ".$glambar_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$glambar_airtel.".subscriptiondetail
    LEFT JOIN ".$glambar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid

    left JOIN ".$glambar_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
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
    left JOIN ".$glambar_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    left JOIN ".$glambar_airtel.".advertiser ON advertiser.advertiserid = activeuserlog.advertiserid
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
        ".$glambar_airtel.".activeuserlog
    
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





//hotshots_airtel

//activation
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    aa.advertiserid advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT 
        subscriptiondetail.txnid,
            ab.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hotshots_airtel.".subscriptiondetail
    LEFT JOIN (SELECT DISTINCT
        msisdn, txnid, advertiserid
    FROM
        ".$hotshots_airtel.".activeuserlog
    WHERE
        accesstime > '".$start_date."'
            AND accesstime < '".$end_date."') ab ON subscriptiondetail.txnid = ab.txnid
    LEFT JOIN ".$hotshots_airtel.".advertiser ON ab.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 541729
            AND charging_mode != 548184
            AND charging_mode != 548185
            AND charging_mode != 548186
            AND charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
GROUP BY aa.dt , hr , advertiserid";
//echo $sql1;
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
	
	 $ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//renew
$sql1="SELECT 
    aa.dt dt,
    hr,
    COUNT(txnid) act,
    aa.advertiserid advertiserid,
    aa.advname advname,
    SUM(amount) amt
FROM
    (SELECT 
        subscriptiondetail.txnid,
            ab.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount
    FROM
        ".$hotshots_airtel.".subscriptiondetail
    LEFT JOIN (SELECT DISTINCT
        msisdn, txnid, advertiserid
    FROM
        ".$hotshots_airtel.".activeuserlog
    WHERE
        accesstime > '".$start_date."'
            AND accesstime < '".$end_date."') ab ON subscriptiondetail.txnid = ab.txnid
    LEFT JOIN ".$hotshots_airtel.".advertiser ON ab.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND isrenew = 1
            AND (charging_mode != 541729
            AND charging_mode != 548184
            AND charging_mode != 548185
            AND charging_mode != 548186
            AND charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY subscriptiondetail.txnid) aa
GROUP BY aa.dt , hr , advertiserid";

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
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
					
		
	$res1=$con1->query($ins1);
				
	
	
	
}

//clicks
$userdate=date('dmY',strtotime("-1 days"));
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$hotshots_airtel.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}


 $sql1="SELECT COUNT( userlogid ) act, DATE( AccessTime ) dt, HOUR( AccessTime ) hr, userlog1.advertiserid, advname
FROM ".$hotshots_airtel.".".$userlogname." userlog1
left JOIN ".$hotshots_airtel.".advertiser ON userlog1.advertiserid = advertiser.advertiserid
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
	
	
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
				
		
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
            activeuserlog.msisdn,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            HOUR(subscriptionstartdate) hr,
            amount,
            MAX(userlogid)
    FROM
        ".$hotshots_airtel.".subscriptiondetail
    LEFT JOIN ".$hotshots_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid

    left JOIN ".$hotshots_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
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
	
	
	
	 
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
					
		
	$res1=$con1->query($ins1);
	
}

//cr
/*
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
        ".$hotshots_airtel.".subscriptiondetail
    left JOIN ".$hotshots_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    left JOIN ".$hotshots_airtel.".advertiser ON advertiser.advertiserid = activeuserlog.advertiserid
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
        ".$hotshots_airtel.".activeuserlog
    
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
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
					
		
	$res1=$con1->query($ins1);
}


//callback


$sql1="SELECT COUNT( advertcallbackid ) act, DATE( senttime ) dt, HOUR( senttime ) hr, advertiser.advertiserid, advertiser.advname
FROM  ".$hotshots_airtel.".advertcallback
LEFT JOIN  ".$hotshots_airtel.".advertiser ON advertiser.advertiserid = advertcallback.advertiserid
WHERE senttime >= '".$start_date."'
AND senttime <= '".$end_date."'

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
	
	
	 
	$ins1="INSERT INTO ".$hadb.".trend_report (`date`, `act`, `amt`, `type`, `advertiserid`, `advname`, `hr`,`operator`,`product`) values('".$date1."','".$act."','".$amt."','".$type."','".$advertiserid."','".$advname."','".$hr."','hotshots_airtel','glambar') ";
					
		
	$res1=$con1->query($ins1);
}
*/

echo $count;
//exit;
if($count<6)
{
	//echo $count;
	
	$headers ="MIME-Version: 1.0"."\r\n";
	$headers .="Content-type:text/html;charset=UTF-8"."\r\n";
	$headers .="from :Support@loop360.co"."\r\n";
	//mail("mehul.gediya@loop360.co","cron error","<h2 style='color:red'>cron_trend_report_hotshots_voda.php was not run successfully</h2>",$headers);
	$trendvoda=0;
	/*
	$headers ="MIME-Version: 1.0"."\r\n";
$headers .="Content-type:text/html;charset=UTF-8"."\r\n";
$headers .="from :Support@hotindiadeals.in"."\r\n";
mail($to,$subject,$message_body,$headers);
	*/
	
}
else{
	$trendvoda=1;
	//$sql="update ".$hvdb.".cron_report set cron_trend_voda=".$trendvoda." where date='".$date1."'";
	$cur_date=date('Y-m-d H:i:s');
	$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=".$trendvoda.", date='".$cur_date."' where cron_name='cron_trend_voda_qatar'";
	$result = mysqli_query($con2,$sql) ;
}

} catch (Exception  $e) { 
 
  die ("We seem to be having file system issues. 
        We are sorry for the inconvenience."); 
 
} 



?>
