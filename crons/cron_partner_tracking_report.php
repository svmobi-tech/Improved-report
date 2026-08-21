<?php
require_once __DIR__ . '/../admin/includes/config.php';

//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST3 . ':' . DB_PROD_PORT3, DB_USER, DB_PASS) or die(mysql_error());//cluster 2
$con1=$con2;
date_default_timezone_set("Asia/Calcutta");
$date1=date('Y-m-d',strtotime("-1 days"));
$userdate=date('dmY',strtotime("-1 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';

$hvdb="gamebardb_vodafone_qatar";
$report="gamebardb_vodafone_qatar_report";

$ooredoolog="gamesdblog_ooredoo_oman";
$ooredoodb="gamesdb_ooredoo_oman";
$gamebardb_airtel='gamebardb_airtel';
$funzonedb_airtel='funzonedb_airtel';
$indonesia='gamebardb_indonesia';
$indonesialog='gamebardblog_indonesia';
$partner=0;
mysqli_query($con1,"DELETE FROM ".$report.".`report_partner_tracking` WHERE `date`='".$date1."';");


//gamebar_airtel
/*
 $userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$gamebardb_airtel.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}




 $sql="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertiserid advertise ,
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
			advertiserid,
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
        dt, adv1,advertiserid, clicks, act, typ, total_amount
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
			b.advertiserid,
            clicks,
            act,
            typ,
            amount total_amount
    FROM
        (SELECT 
        COUNT(msisdn) clicks, dt, advname,advertiserid
    FROM
        (SELECT 
        msisdn,
            DATE(accesstime) dt,
            advname,
            advertiser.advertiserid
    FROM
        ".$gamebardb_airtel.".".$userlogname." userlog1
    LEFT JOIN ".$gamebardb_airtel.".advertiser ON advertiser.advertiserid = userlog1.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime <= '".$end_date."') a
    GROUP BY dt , advname) b
    LEFT JOIN (SELECT 
        act, dt, advname, amount, typ
    FROM
        (SELECT 
        COUNT(DISTINCT subscriptiondetail.txnid) act,
            activeuserlog.msisdn,
            accesstime,
            SUM(amount) amount,
            advname,
            1 typ,
            activeuserlog.advertiserid,
            DATE(subscriptionstartdate) dt,
            MAX(userlogid)
    FROM
       ".$gamebardb_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebardb_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    INNER JOIN ".$gamebardb_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(subscriptionstartdate) = DATE(accesstime)
            AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY advname
    ORDER BY msisdn) b
    GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
    GROUP BY dt , adv1) m UNION SELECT 
        dt,
            advname adv1,
			advertiserid,
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
       ".$gamebardb_airtel.".subscriptiondetail
    LEFT JOIN ".$gamebardb_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    LEFT JOIN ".$gamebardb_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(accesstime) < DATE(subscriptionstartdate)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 600381  and charging_mode != 600382 and charging_mode != 600387 and charging_mode != 600388 and charging_mode != 600374 and charging_mode != 600375)
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
        ".$gamebardb_airtel.".advertcallback
    LEFT JOIN ".$gamebardb_airtel.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$start_date."'
            AND senttime <= '".$end_date."') aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1";


//$result3=mysqli_query($con1,$sql);	
if($result = $con1->query($sql))
{
	$partner++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt'];
	$advname=$row['adv1'];
	$advertiserid=$row['advertise'];
	$clicks=$row['clicks'];
	$activation=$row['act'];
	$amount=$row['total_amount'];
	$spo=$row['spo'];
	$spoamount=$row['total_amount1'];
	$cbs=$row['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row['act']/$row['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row['cbs']*0.55*67)/$row['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row['total_amount']/$row['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	  $sql1="INSERT INTO gamebardb_vodafone_qatar_report.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`,`operator`,`product`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."','airtel_india','gamebar')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}

}





//funzonedb_airtel

$userlogna="userlog_".$userdate;
 
  $sql22="select 1 from ".$funzonedb_airtel.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}
 



 $sql="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertiserid advertise ,
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
			advertiserid,
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
        dt, adv1,advertiserid, clicks, act, typ, total_amount
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
			b.advertiserid,
            clicks,
            act,
            typ,
            amount total_amount
    FROM
        (SELECT 
        COUNT(msisdn) clicks, dt, advname,advertiserid
    FROM
        (SELECT 
        msisdn,
            DATE(accesstime) dt,
            advname,
            advertiser.advertiserid
    FROM
        ".$funzonedb_airtel.".".$userlogname." userlog1
    LEFT JOIN ".$funzonedb_airtel.".advertiser ON advertiser.advertiserid = userlog1.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime <= '".$end_date."') a
    GROUP BY dt , advname) b
    LEFT JOIN (SELECT 
        act, dt, advname, amount, typ
    FROM
        (SELECT 
        COUNT(DISTINCT subscriptiondetail.txnid) act,
            activeuserlog.msisdn,
            accesstime,
            SUM(amount) amount,
            advname,
            1 typ,
            activeuserlog.advertiserid,
            DATE(subscriptionstartdate) dt,
            MAX(userlogid)
    FROM
       ".$funzonedb_airtel.".subscriptiondetail
    LEFT JOIN ".$funzonedb_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    INNER JOIN ".$funzonedb_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(subscriptionstartdate) = DATE(accesstime)
            AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 600396
            AND charging_mode != 600398
            AND charging_mode != 600408
            AND charging_mode != 600409
            AND charging_mode != 600403
            AND charging_mode != 600404)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY advname
    ORDER BY msisdn) b
    GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
    GROUP BY dt , adv1) m UNION SELECT 
        dt,
            advname adv1,
			advertiserid,
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
       ".$funzonedb_airtel.".subscriptiondetail
    LEFT JOIN ".$funzonedb_airtel.".activeuserlog ON subscriptiondetail.txnid = activeuserlog.txnid
    LEFT JOIN ".$funzonedb_airtel.".advertiser ON activeuserlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(accesstime) < DATE(subscriptionstartdate)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 600396
            AND charging_mode != 600398
            AND charging_mode != 600408
            AND charging_mode != 600409
            AND charging_mode != 600403
            AND charging_mode != 600404)
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
        ".$funzonedb_airtel.".advertcallback
    LEFT JOIN ".$funzonedb_airtel.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$start_date."'
            AND senttime <= '".$end_date."') aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1";


//$result3=mysqli_query($con1,$sql);	
if($result = $con1->query($sql))
{
	$partner++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt'];
	$advname=$row['adv1'];
	$advertiserid=$row['advertise'];
	$clicks=$row['clicks'];
	$activation=$row['act'];
	$amount=$row['total_amount'];
	$spo=$row['spo'];
	$spoamount=$row['total_amount1'];
	$cbs=$row['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row['act']/$row['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row['cbs']*0.55*67)/$row['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row['total_amount']/$row['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	  $sql1="INSERT INTO gamebardb_vodafone_qatar_report.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`,`operator`,`product`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."','airtel_india','glambar')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}

}
*/

//vodafone_qatar




  $sql="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertise,
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
            END spamount,advertise
    FROM
        (SELECT 
        dt, adv1,m.advertise, clicks, act, typ, total_amount
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
            clicks,
            act,
            typ,
            SUM(amount) total_amount,
			advertise
    FROM
        (SELECT 
        COUNT(msisdn) clicks, dt, advname,advertise
    FROM
        (SELECT 
        msisdn,
            DATE(accesstime) dt,
            CASE
                WHEN advname IS NULL THEN 'other'
                ELSE advname
            END advname,
            advertiser.advertiserid advertise
    FROM
         ".$hvdb.".userlog
    LEFT JOIN  ".$hvdb.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        accesstime >='".$start_date."'
            AND accesstime <= '".$end_date."') a
    GROUP BY dt , advname) b
    LEFT JOIN (SELECT 
        COUNT(reqid) act,
            dt,
            advname,
            SUM(amount) amount,
            typ,
            advertiserid
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
         ".$hvdb.".subscriptiondetail
    LEFT JOIN  ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    LEFT JOIN  ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(accesstime) = DATE(subscriptionstartdate)
            AND amount > 0
            AND isrenew = 0
    GROUP BY subscriptiondetail.txnid) b
    GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
    GROUP BY dt , adv1) m UNION SELECT 
        dt,
            CASE
                WHEN advname IS NULL THEN 'other'
                ELSE advname
            END adv1,
			advertiserid,
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
         ".$hvdb.".subscriptiondetail
    LEFT JOIN  ".$hvdb.".userlog ON subscriptiondetail.reqid = userlog.txnid
    LEFT JOIN  ".$hvdb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >='".$start_date."'
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
        (SELECT 
        txnid cbs, DATE(senttime) dt, advname
    FROM
         ".$hvdb.".advertcallback
    LEFT JOIN  ".$hvdb.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >='".$start_date."'
            AND senttime <= '".$end_date."' and isact!=0) aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1";


//$result3=mysqli_query($con1,$sql);	
if($result = $con1->query($sql))
{
	$partner++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt'];
	$advname=$row['adv1'];
	$advertiserid=$row['advertise'];
	$clicks=$row['clicks'];
	$activation=$row['act'];
	$amount=$row['total_amount'];
	$spo=$row['spo'];
	$spoamount=$row['total_amount1'];
	$cbs=$row['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row['act']/$row['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row['cbs']*0.55*67)/$row['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row['total_amount']/$row['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	  $sql1="INSERT INTO gamebardb_vodafone_qatar_report.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`,`operator`,`product`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."','Vodafone_Qatar','gamebar')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}

}


							$sql="SELECT 
								dt,
								adv1,
								clicks,
								act,
								actsp spo,
								total_amount,
								total_amount1,
								cbs
							FROM
								(SELECT 
									COUNT(*) clicks,
										DATE(accesstime) dt,
										advertiser.advname adv1
								FROM
									".$ooredoolog.".annonymoustracking
								INNER JOIN ".$ooredoolog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime < '".$end_date."'
										AND operator = 1
								GROUP BY dt , adv1) a
									left JOIN
								(SELECT 
									COUNT(msisdn) act, SUM(amount) total_amount, sdt, adv2
								FROM
									(SELECT DISTINCT
									msisdn, amount, sdt, DATE(accesstime) acsdt, adv2
								FROM
									".$ooredoolog.".annonymoustracking
								INNER JOIN (SELECT 
									msisdn,
										DATE(subscriptionstartdate) sdt,
										amount,
										MAX(annonymoustrackingid) atid,
										advertiser.advname adv2
								FROM
									".$ooredoodb.".subscriber 
								INNER JOIN ".$ooredoolog.".annonymoustracking ON msisdn = userid
								INNER JOIN ".$ooredoolog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND isrenew = 0
										AND amount > 0
										AND DATE(accesstime) = DATE(subscriptionstartdate)
										AND annonymoustracking.advertiserid > - 1
										AND operator = 1
										AND accesstime >= '".$start_date."'
										AND accesstime < '".$end_date."'
								GROUP BY subscriber.subscriberid , sdt , adv2) aa ON aa.atid = annonymoustrackingid) bb
								GROUP BY sdt , adv2) b ON a.dt = b.sdt AND a.adv1 = b.adv2
									left JOIN
								(SELECT 
									COUNT(*) actsp,
										SUM(u.amount) total_amount1,
										u.sdt dt22,
										u.adv4
								FROM
									(SELECT DISTINCT
									msisdn, sdt, DATE(accesstime) acsdt, adv3
								FROM
									".$ooredoolog.".annonymoustracking
								INNER JOIN (SELECT 
									msisdn,
										DATE(subscriptionstartdate) sdt,
										MAX(annonymoustrackingid) atid,
										advertiser.advname adv3
								FROM
									".$ooredoodb.".subscriber 
								INNER JOIN ".$ooredoolog.".annonymoustracking ON msisdn = userid
								INNER JOIN ".$ooredoolog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND isrenew = 0
										AND amount > 0
										AND operator = 1
										AND DATE(accesstime) = DATE(subscriptionstartdate)
										AND annonymoustracking.advertiserid > - 1
										AND accesstime >= '".$start_date."'
										AND accesstime < '".$end_date."'
								GROUP BY subscriber.subscriberid , sdt , adv3) a ON a.atid = annonymoustrackingid) x
								RIGHT JOIN (SELECT DISTINCT
									msisdn, amount, sdt, DATE(accesstime) acsdt, adv4
								FROM
									".$ooredoolog.".annonymoustracking
								INNER JOIN (SELECT 
									msisdn,
										DATE(subscriptionstartdate) sdt,
										amount,
										MAX(annonymoustrackingid) atid,
										advertiser.advname adv4
								FROM
									 ".$ooredoodb.".subscriber 
								INNER JOIN ".$ooredoolog.".annonymoustracking ON msisdn = userid
								INNER JOIN ".$ooredoolog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND isrenew = 0
										AND amount > 0
										AND operator = 1
										AND annonymoustracking.advertiserid > - 1
										AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
										AND accesstime < '".$end_date."'
								GROUP BY subscriber.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.msisdn = u.msisdn
								GROUP BY dt22 , adv4) c ON b.sdt = c.dt22 AND b.adv2 = c.adv4
									left JOIN
								(SELECT 
									COUNT(*) cbs, DATE(requesttime) dt3, advertiser.advname adv5
								FROM
									".$ooredoodb.".requestresponse
								INNER JOIN ".$ooredoolog.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
								WHERE
									requesttime >= '".$start_date."'
										AND requesttime < '".$end_date."'
								GROUP BY dt3 , adv5) d ON c.dt22 = d.dt3 AND c.adv4 = d.adv5
							GROUP BY dt , adv1";


//$result3=mysqli_query($con1,$sql);	
if($result = $con1->query($sql))
{
	$partner++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt'];
	$advname=$row['adv1'];
	
	$clicks=$row['clicks'];
	$activation=$row['act'];
	$amount=$row['total_amount'];
	$spo=$row['spo'];
	$spoamount=$row['total_amount1'];
	$cbs=$row['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row['act']/$row['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row['cbs']*0.55*67)/$row['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row['total_amount']/$row['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	  $sql1="INSERT INTO gamebardb_vodafone_qatar_report.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`,`operator`,`product`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."','ooredoo_oman','gamebar')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}

}


$userlogna="userlog_".$userdate;
  $sql22="select 1 from ".$indonesialog.".".$userlogna." limit 1 ";
if($result22 = $con1->query($sql22))
{
	 $userlogname=$userlogna;
}
else{
	
	 $userlogname='userlog';
}
 


  $sql="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertise,
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
			advertise,
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
        dt, adv1,advertise, clicks, act, typ, total_amount
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
			b.advertiserid advertise,
            clicks,
            act,
            typ,
            amount total_amount
    FROM
        (SELECT 
        COUNT(clickid) clicks, dt, advname,advertiserid
    FROM
        (SELECT 
        clickid,
            DATE(accesstime) dt,
            advname,
            advertiser.advertiserid
    FROM
        ".$indonesialog.".".$userlogname." userlog1
    LEFT JOIN ".$indonesia.".advertiser ON advertiser.advertiserid = userlog1.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime <= '".$end_date."') a
    GROUP BY dt , advname) b
    LEFT JOIN (SELECT 
        act, dt, advname, amount, typ
    FROM
        (SELECT 
        COUNT(DISTINCT mo.clickid) act,
            SUM(amount) amount,
            advname,
            1 typ,
            DATE(subscriptionstartdate) dt
    FROM
        ".$indonesia.".mo
    INNER JOIN ".$indonesia.".advertiser ON mo.advid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND amount > 0
            AND charging_mode = 'ACT'
            AND pull_tid IS NOT NULL
    GROUP BY advname
    ORDER BY clickid) b
    GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
    GROUP BY dt , adv1) m UNION SELECT 
        dt,
            advname adv1,
			advertiserid,
            0 clicks,
            COUNT(a.spo) act,
            2 typ,
            SUM(amount) total_amount
    FROM
        (SELECT DISTINCT
        mo.clickid spo,
            advname,
            advertiser.advertiserid,
            DATE(subscriptionstartdate) dt,
            amount
    FROM
        ".$indonesia.".mo
    LEFT JOIN ".$indonesia.".advertiser ON mo.advid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND pull_tid IS NULL
            AND amount > 0
            AND charging_mode = 'ACT'
    GROUP BY mo.clickid) a
    GROUP BY dt , advname) aa) bb
        LEFT JOIN
    (SELECT 
        COUNT(cbs) cbs, dt, advname
    FROM
        (SELECT DISTINCT
        clickid cbs, DATE(requesttime) dt, advname
    FROM
        ".$indonesia.".callbackresponse
    LEFT JOIN ".$indonesia.".advertiser ON callbackresponse.advertiserid = advertiser.advertiserid
    WHERE
        requesttime >= '".$start_date."'
            AND requesttime <= '".$end_date."'
            AND issent = 1) aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1;";


//$result3=mysqli_query($con1,$sql);	
if($result = $con1->query($sql))
{
	$partner++;

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	$date=$row['dt'];
	$advname=$row['adv1'];
	$advertiserid=$row['advertise'];
	$clicks=$row['clicks'];
	$activation=$row['act'];
	 $amount=$row['total_amount'];
	$spo=$row['spo'];
	$spoamount=$row['total_amount1'];
	$cbs=$row['cbs'];
	if($activation>0)
	{
		$cr3=number_format(($row['act']/$row['clicks'])*100,2);
	}else
	{
		$cr3=0;
	}
	if($cbs>0)
	{
		$coa3=number_format(($row['cbs']*0.55*67)/$row['act'],2);
	}
	else
	{
		$coa3=0;
	}
	if($amount>0)
	{
		$arpu3=number_format($amount/$row['act'],2);
	}
	else
	{
		$arpu3=0;
	}
	
	
	  $sql1="INSERT INTO gamebardb_vodafone_qatar_report.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`,`operator`,`product`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr3."','".$coa3."','".$arpu3."','indonesia','gamebar')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}

}








/*
$sql2="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertiserid,
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
			advertiserid,
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
        dt, adv1, clicks, act, typ, total_amount,advertiserid
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
            clicks,
            act,
            typ,
            amount total_amount,advertiserid
    FROM
        (SELECT 
        COUNT(msisdn) clicks, dt, advname,advertiserid
    FROM
        (SELECT 
        msisdn,
            DATE(accesstime) dt,
            advname,
            advertiser.advertiserid
    FROM
        ".$hadb.".userlog
    LEFT JOIN ".$hadb.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime <= '".$end_date."') a
    GROUP BY dt , advname) b
    LEFT JOIN (SELECT 
        act, dt, advname, amount, typ
    FROM
        (SELECT 
        COUNT(DISTINCT subscriptiondetail.txnid) act,
            userlog.msisdn,
            accesstime,
            SUM(amount) amount,
            advname,
            1 typ,
            advertcallback.advertiserid,
            DATE(subscriptionstartdate) dt,
            MAX(userlogid)
    FROM
        ".$hadb.".subscriptiondetail
    LEFT JOIN ".$hadb.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
    INNER JOIN ".$hadb.".advertcallback ON subscriptiondetail.txnid = advertcallback.txnid
    INNER JOIN ".$hadb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(subscriptionstartdate) = DATE(accesstime)
            AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
            AND subscriptiondetail.errorcode = 1000
    GROUP BY advname
    ORDER BY msisdn) b
    GROUP BY dt , advname) c ON b.dt = c.dt AND b.advname = c.advname
    GROUP BY dt , adv1) m UNION SELECT 
        dt,
            advname adv1,
			advertiserid,
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
        ".$hadb.".subscriptiondetail
    LEFT JOIN ".$hadb.".userlog ON subscriptiondetail.txnid = userlog.txnid
    LEFT JOIN ".$hadb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate <= '".$end_date."'
            AND DATE(accesstime) < DATE(subscriptionstartdate)
            AND amount > 0
            AND isrenew = 0
            AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
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
        ".$hadb.".advertcallback
    LEFT JOIN ".$hadb.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$start_date."'
            AND senttime <= '".$end_date."' and isact=1) aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1;";


//$result3=mysqli_query($con1,$sql);	
//$result2 = $con1->query($sql2);
if($result2 = $con1->query($sql2))
{
	$partner++;

while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC))
{
	$date=$row2['dt'];
	$advname=$row2['adv1'];
	$advertiserid=$row2['advertiserid'];
	$clicks=$row2['clicks'];
	$activation=$row2['act'];
	$amount=$row2['total_amount'];
	$spo=$row2['spo'];
	$spoamount=$row2['total_amount1'];
	$cbs=$row2['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row2['act']/$row2['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row2['cbs']*0.55*67)/$row2['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row2['total_amount']/$row2['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	$sql1="INSERT INTO hotshotsnewdb_airtel_0717.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."')  ";
					
			
					 $result1=mysqli_query($con1,$sql1);
	
	
	
}
}


$sql3="SELECT 
    bb.dt dt,
    CASE
        WHEN adv1 IS NULL THEN 'other'
        ELSE adv1
    END adv1,
	advertiserid,
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
			advertiserid,
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
        dt, adv1,advertiserid, clicks, act, typ, total_amount
    FROM
        (SELECT 
        b.dt dt,
            b.advname adv1,
			b.advertiserid,
            clicks,
            act,
            typ,
            SUM(amount) total_amount
    FROM
        (SELECT 
        COUNT(msisdn) clicks, dt, advname,advertiserid
    FROM
        (SELECT 
        msisdn,
            DATE(accesstime) dt,
            advname,
            advertiser.advertiserid
    FROM
        ".$hidb.".userlog
    LEFT JOIN ".$hidb.".advertiser ON advertiser.advertiserid = userlog.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime <= '".$end_date."') a
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
        ".$hidb.".subscriptiondetail
    LEFT JOIN ".$hidb.".userlog ON subscriptiondetail.txnid = userlog.txnid
    LEFT JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
			advertiserid,
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
        ".$hidb.".subscriptiondetail
    LEFT JOIN ".$hidb.".userlog ON subscriptiondetail.txnid = userlog.txnid
    LEFT JOIN ".$hidb.".advertiser ON userlog.advertiserid = advertiser.advertiserid
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
        ".$hidb.".advertcallback
    LEFT JOIN ".$hidb.".advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$start_date."'
            AND senttime <= '".$end_date."') aa1
    GROUP BY dt , advname) cc ON bb.dt = cc.dt AND bb.adv1 = cc.advname
GROUP BY dt , adv1;";


//$result3=mysqli_query($con1,$sql);	
//$result3 = $con1->query($sql3);
if($result3 = $con1->query($sql3))
{
	$partner++;
while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
{
	$date=$row3['dt'];
	$advname=$row3['adv1'];
	$advertiserid=$row3['advertiserid'];
	$clicks=$row3['clicks'];
	$activation=$row3['act'];
	$amount=$row3['total_amount'];
	$spo=$row3['spo'];
	$spoamount=$row3['total_amount1'];
	$cbs=$row3['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row3['act']/$row3['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row3['cbs']*0.55*67)/$row3['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row3['total_amount']/$row3['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
	$sql4="INSERT INTO hotshotsnewdb_idea_0717.report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."')  ";
					
			
					 $result4=mysqli_query($con1,$sql4);
	
	
	
}
}



$sql4="SELECT 
    dt,
    adv1,
	advertiserid,
    clicks,
    act,
    actsp spo,
    total_amount,
    total_amount1,
    cbs
FROM
    (SELECT 
        COUNT(*) clicks,
            DATE(accesstime) dt,
            advertiser.advname adv1,
			advertiser.advertiserid
    FROM
        ".$gvdblog.".annonymoustracking
    INNER JOIN ".$gvdblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
            AND operator = 1
    GROUP BY dt , adv1) a
        INNER JOIN
    (SELECT 
        COUNT(mobilenumber) act, SUM(amount) total_amount, sdt, adv2
    FROM
        (SELECT DISTINCT
        mobilenumber, amount, sdt, DATE(accesstime) acsdt, adv2
    FROM
        ".$gvdblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            amount,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv2
    FROM
        ".$gvdb.".subscriptiondetail
    INNER JOIN ".$gvdb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gvdblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gvdblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND DATE(accesstime) = DATE(subscriptionstartdate)
            AND annonymoustracking.advertiserid > - 1
            AND operator = 1
            AND accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt , adv2) aa ON aa.atid = annonymoustrackingid) bb
    GROUP BY sdt , adv2) b ON a.dt = b.sdt AND a.adv1 = b.adv2
        INNER JOIN
    (SELECT 
        COUNT(*) actsp,
            SUM(u.amount) total_amount1,
            u.sdt dt22,
            u.adv4
    FROM
        (SELECT DISTINCT
        mobilenumber, sdt, DATE(accesstime) acsdt, adv3
    FROM
        ".$gvdblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv3
    FROM
        ".$gvdb.".subscriptiondetail
    INNER JOIN ".$gvdb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gvdblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gvdblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND operator = 1
            AND DATE(accesstime) = DATE(subscriptionstartdate)
            AND annonymoustracking.advertiserid > - 1
            AND accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt , adv3) a ON a.atid = annonymoustrackingid) x
    RIGHT JOIN (SELECT DISTINCT
        mobilenumber, amount, sdt, DATE(accesstime) acsdt, adv4
    FROM
        ".$gvdblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            amount,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv4
    FROM
        ".$gvdb.".subscriptiondetail
    INNER JOIN ".$gvdb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gvdblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gvdblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND isrenew = 0
            AND amount > 0
            AND operator = 1
            AND annonymoustracking.advertiserid > - 1
            AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.mobilenumber = u.mobilenumber
    GROUP BY dt22 , adv4) c ON b.sdt = c.dt22 AND b.adv2 = c.adv4
        INNER JOIN
    (SELECT 
        COUNT(*) cbs, DATE(requesttime) dt3, advertiser.advname adv5
    FROM
        ".$gvdb.".requestresponse
    INNER JOIN ".$gvdblog.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
    WHERE
        requesttime >= '".$start_date."'
            AND requesttime < '".$end_date."'
    GROUP BY dt3 , adv5) d ON c.dt22 = d.dt3 AND c.adv4 = d.adv5
GROUP BY dt , adv1";


//$result3=mysqli_query($con1,$sql);	
//$result4 = $con2->query($sql4);
if($result4 = $con1->query($sql4))
{
	$partner++;
while($row4=mysqli_fetch_array($result4,MYSQLI_ASSOC))
{
	$date=$row4['dt'];
	$advname=$row4['adv1'];
	$advertiserid=$row4['advertiserid'];
	$clicks=$row4['clicks'];
	$activation=$row4['act'];
	$amount=$row4['total_amount'];
	$spo=$row4['spo'];
	$spoamount=$row4['total_amount1'];
	$cbs=$row4['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row4['act']/$row4['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row4['cbs']*0.55*67)/$row4['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row4['total_amount']/$row4['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
				$sql5="INSERT INTO ".$gvdb.".report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."')  ";
					
			
					 $result5=mysqli_query($con2,$sql5);
	
	
	
}
}


$sql5="SELECT 
    dt,
    adv1,
	advertiserid,
    clicks,
    act,
    actsp,
    total_amount,
    total_amount1,
    cbs
FROM
    (SELECT 
        COUNT(*) clicks,
            DATE(accesstime) dt,
            advertiser.advname adv1,
     		advertiser.advertiserid
    FROM
        ".$gidblog.".annonymoustracking
    INNER JOIN ".$gidblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
            AND operator = 2
    GROUP BY dt , adv1) a
        INNER JOIN
    (SELECT 
        COUNT(mobilenumber) act, SUM(amount) total_amount, sdt, adv2
    FROM
        (SELECT DISTINCT
        mobilenumber, amount, sdt, DATE(accesstime) acsdt, adv2
    FROM
        ".$gidblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            amount,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv2
    FROM
        ".$gidb.".subscriptiondetail
    INNER JOIN ".$gidb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gidblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gidblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND charging_mode LIKE '%ACT%'
            AND amount > 0
            AND DATE(accesstime) = DATE(subscriptionstartdate)
            AND annonymoustracking.advertiserid > - 1
            AND operator = 2
            AND accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt , adv2) aa ON aa.atid = annonymoustrackingid) bb
    GROUP BY sdt , adv2) b ON a.dt = b.sdt AND a.adv1 = b.adv2
        INNER JOIN
    (SELECT 
        COUNT(*) actsp,
            SUM(u.amount) total_amount1,
            u.sdt dt22,
            u.adv4
    FROM
        (SELECT DISTINCT
        mobilenumber, sdt, DATE(accesstime) acsdt, adv3
    FROM
        ".$gidblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv3
    FROM
        ".$gidb.".subscriptiondetail
    INNER JOIN ".$gidb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gidblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gidblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND charging_mode LIKE '%ACT%'
            AND amount > 0
            AND operator = 2
            AND DATE(accesstime) = DATE(subscriptionstartdate)
            AND annonymoustracking.advertiserid > - 1
            AND accesstime >= '".$start_date."'
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt , adv3) a ON a.atid = annonymoustrackingid) x
    RIGHT JOIN (SELECT DISTINCT
        mobilenumber, amount, sdt, DATE(accesstime) acsdt, adv4
    FROM
        ".$gidblog.".annonymoustracking
    INNER JOIN (SELECT 
        mobilenumber,
            DATE(subscriptionstartdate) sdt,
            amount,
            MAX(annonymoustrackingid) atid,
            advertiser.advname adv4
    FROM
        ".$gidb.".subscriptiondetail
    INNER JOIN ".$gidb.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
    INNER JOIN ".$gidblog.".annonymoustracking ON mobilenumber = userid
    INNER JOIN ".$gidblog.".advertiser ON annonymoustracking.advertiserid = advertiser.advertiserid
    WHERE
        subscriptionstartdate >= '".$start_date."'
            AND subscriptionstartdate < '".$end_date."'
            AND charging_mode LIKE '%ACT%'
            AND amount > 0
            AND operator = 2
            AND annonymoustracking.advertiserid > - 1
            AND accesstime >= SUBDATE('".$start_date."', INTERVAL 7 DAY)
            AND accesstime < '".$end_date."'
    GROUP BY subscriptiondetail.subscriberid , sdt) a ON a.atid = annonymoustrackingid) u ON x.mobilenumber = u.mobilenumber
    GROUP BY dt22 , adv4) c ON b.sdt = c.dt22 AND b.adv2 = c.adv4
        INNER JOIN
    (SELECT 
        COUNT(*) cbs, DATE(requesttime) dt3, advertiser.advname adv5
    FROM
        ".$gidb.".requestresponse
    INNER JOIN ".$gidblog.".advertiser ON advertiser.advertiserid = requestresponse.advertiserid
    WHERE
        requesttime >= '".$start_date."'
            AND requesttime < '".$end_date."'
    GROUP BY dt3 , adv5) d ON c.dt22 = d.dt3 AND c.adv4 = d.adv5
GROUP BY dt , adv1";

//$result5 = $con2->query($sql5);
if($result5 = $con1->query($sql5))
{
	$partner++;
while($row5=mysqli_fetch_array($result5,MYSQLI_ASSOC))
{
	$date=$row5['dt'];
	$advname=$row5['adv1'];
	$advertiserid=$row5['advertiserid'];
	$clicks=$row5['clicks'];
	$activation=$row5['act'];
	$amount=$row5['total_amount'];
	$spo=$row5['spo'];
	$spoamount=$row5['total_amount1'];
	$cbs=$row5['cbs'];
	if($activation>0)
	{
		$cr=number_format(($row5['act']/$row5['clicks'])*100,2);
	}else
	{
		$cr=0;
	}
	if($cbs>0)
	{
		$coa=number_format(($row5['cbs']*0.55*67)/$row5['act'],2);
	}
	else
	{
		$coa=0;
	}
	if($amount>0)
	{
		$arpu=number_format($row5['total_amount']/$row5['act'],2);
	}
	else
	{
		$arpu=0;
	}
	
	
				$sql5="INSERT INTO ".$gidb.".report_partner_tracking
					(`date`, `advname`, `advertiserid`, `clicks`, `activation`, `amount`, `spo`, `spoamount`, `cbs`,`cr`,`coa`,`arpu`) values('".$date1."','".$advname."','".$advertiserid."','".$clicks."','".$activation."','".$amount."','".$spo."','".$spoamount."','".$cbs."','".$cr."','".$coa."','".$arpu."')  ";
					
			
					 $result5=mysqli_query($con2,$sql5);
	
	
	
}
}*/
echo $partner;
$partnercount=0;
if($partner==1)
{
	$partnercount=1;
	//$sql="update gamebardb_vodafone_qatar.cron_report set cron_partner_tracking=".$partnercount." where date='".$date1."'";
	$cur_date=date('Y-m-d H-i:s');
	$sql="update gamebardb_vodafone_qatar_report.cron_report set ran=".$partnercount.", date='".$cur_date."' where cron_name='cron_partner_tracking'";
	$result = mysqli_query($con2,$sql) ;
}







?>