<?php
require_once __DIR__ . '/../admin/includes/config.php';

$con2=mysqli_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysql_error());//cluster 2
//$con=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());//cluster1
$con1=$con2;
$con=mysql_connect(DB_PROD_HOST3, DB_USER, DB_PASS) or die(mysql_error());//cluster2
date_default_timezone_set("Asia/Calcutta");
//$result=mysql_query("truncate gamebardb_vodafone_qatar.subscriptiondetail",$con);
 $date1=date('Y-m-d',strtotime("-1 days"));
 $userdate=date('dmY',strtotime("-1 days"));
$startdate=$date1.' 00:00:00';
$enddate=$date1.' 23:59:59';
$report='gamebardb_vodafone_qatar_report';



mysqli_query($con1,"DELETE FROM gamebardb_vodafone_qatar_report.`callback_report` WHERE `dt` = '".$date1."';");



$count1=0;


//indonesia
$sql="SELECT 
	COUNT(cbsent) cbs,
	dt,
	CASE
		WHEN advname IS NULL THEN 'other'
		ELSE advname
	END advname,advertiserid
FROM
	(SELECT DISTINCT
		callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid
	FROM
		gamebardb_indonesia.callbackresponse
	
	LEFT JOIN gamebardb_indonesia.advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
	WHERE
		requesttime >='".$startdate."'
			AND requesttime <= '".$enddate."'
			and issent=1
			
			) a
GROUP BY dt , advname";




if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','indonesia')  ";
	$result1=mysql_query($sql4);

}
}


//glambar_thailand
$sql="select count(clickid)cbs, date(advertdatetime)dt, aa.advertiserid, CASE WHEN advertiser_name is null then 'OTHER' else advertiser_name END advname from( SELECT distinct clickid, advertdatetime,advertcallback.advertiserid FROM fashionbardb_thailand_0218.advertcallback WHERE advertdatetime >= '".$startdate."' AND advertdatetime <= '".$enddate."' AND advertresponse != 'stop' AND advertresponse != '' AND action = 'act' and hour(advertdatetime)<=24 )aa LEFT JOIN commondbthailand.advertiser ON aa.advertiserid = advertiser.advertiserid group by dt, advertiserid";




if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','thailand')  ";
	$result1=mysql_query($sql4);

}
}

//glambar_beeline



$sql="SELECT 
    dt, COUNT(txnid) cbs, advname, advertiserid
FROM
    (SELECT DISTINCT
        advertcallback.txnid,
            advertcallback.msisdn,
            DATE(senttime) dt,
            advname,
            advertiser.advertiserid
    FROM
        glambardb_beeline.advertcallback
    INNER JOIN glambardb_beeline.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$startdate."'
            AND senttime <= '".$enddate."') cbs
GROUP BY advname , dt";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','beeline')  ";
	$result1=mysql_query($sql4);

}
}




//gamebar_beeline



$sql="SELECT 
    dt, COUNT(txnid) cbs, advname, advertiserid
FROM
    (SELECT DISTINCT
        advertcallback.txnid,
            advertcallback.msisdn,
            DATE(senttime) dt,
            advname,
            advertiser.advertiserid
    FROM
        gamebardb_beeline.advertcallback
    INNER JOIN gamebardb_beeline.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$startdate."'
            AND senttime <= '".$enddate."') cbs
GROUP BY advname , dt";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','beeline')  ";
	$result1=mysql_query($sql4);

}
}




//glambar_tele2



$sql="SELECT 
    dt, COUNT(txnid) cbs, advname, advertiserid
FROM
    (SELECT DISTINCT
        advertcallback.txnid,
            advertcallback.msisdn,
            DATE(senttime) dt,
            advname,
            advertiser.advertiserid
    FROM
        glambardb_tele2.advertcallback
    INNER JOIN glambardb_tele2.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$startdate."'
            AND senttime <= '".$enddate."') cbs
GROUP BY advname , dt";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','tele2')  ";
	$result1=mysql_query($sql4);

}
}




//gamebar_tele2



$sql="SELECT 
    dt, COUNT(txnid) cbs, advname, advertiserid
FROM
    (SELECT DISTINCT
        advertcallback.txnid,
            advertcallback.msisdn,
            DATE(senttime) dt,
            advname,
            advertiser.advertiserid
    FROM
        gamebardb_tele2.advertcallback
    INNER JOIN gamebardb_tele2.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
    WHERE
        senttime >= '".$startdate."'
            AND senttime <= '".$enddate."') cbs
GROUP BY advname , dt";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','tele2')  ";
	$result1=mysql_query($sql4);

}
}



//glambar_airtel



$sql="SELECT 
		COUNT(cbsent) cbs,
		dt,
		CASE
			WHEN advname IS NULL THEN 'other'
			ELSE advname
		END advname,
		advertiserid
	FROM
		(SELECT DISTINCT
			advertcallback.txnid cbsent, DATE(senttime) dt, advname,advertiser.advertiserid
		FROM
			funzonedb_airtel.advertcallback
		LEFT JOIN funzonedb_airtel.subscriptiondetail ON subscriptiondetail.txnid = advertcallback.txnid
		LEFT JOIN funzonedb_airtel.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
		WHERE
			senttime >='".$startdate."'
				AND senttime <= '".$enddate."'
				
				) a
	GROUP BY dt , advname";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','airtel_india')  ";
	$result1=mysql_query($sql4);

}
}



//gamebar_airtel



$sql="SELECT 
		COUNT(cbsent) cbs,
		dt,
		CASE
			WHEN advname IS NULL THEN 'other'
			ELSE advname
		END advname,
		advertiserid
	FROM
		(SELECT DISTINCT
			advertcallback.txnid cbsent, DATE(senttime) dt, advname,advertiser.advertiserid
		FROM
			gamebardb_airtel.advertcallback
		LEFT JOIN gamebardb_airtel.subscriptiondetail ON subscriptiondetail.txnid = advertcallback.txnid
		LEFT JOIN gamebardb_airtel.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
		WHERE
			senttime >='".$startdate."'
				AND senttime <= '".$enddate."'
				
				) a
	GROUP BY dt , advname";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','airtel_india')  ";
	$result1=mysql_query($sql4);

}
}



//glambar Vodafone



$sql="SELECT 
    COUNT(advertcallbackid) cbs, DATE(senttime) dt,advertiser.advertiserid,advertiser.advname
FROM
    fashionbardb_svmobi.advertcallback
     INNER JOIN fashionbardb_svmobi.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
WHERE
    senttime >= '".$startdate."'
        AND senttime <= '".$enddate."'
GROUP BY dt , advertiserid";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','vodafone')  ";
	$result1=mysql_query($sql4);

}
}



//gamebar Vodafone



$sql="SELECT 
    COUNT(advertcallbackid) cbs, DATE(senttime) dt,advertiser.advertiserid,advertiser.advname
FROM
    gamebardb_svmobi.advertcallback
     INNER JOIN gamebardb_svmobi.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
WHERE
    senttime >= '".$startdate."'
        AND senttime <= '".$enddate."'
GROUP BY dt , advertiserid";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','vodafone')  ";
	$result1=mysql_query($sql4);

}
}



//gamebar egypt


$sql="SELECT 
    COUNT(advertcallbackid) cbs, DATE(senttime) dt,advertiser.advertiserid,advertiser.advname
FROM
    gamebardb_vodafone_egypt .advertcallback
     INNER JOIN gamebardb_vodafone_egypt .advertiser ON advertcallback.advertiserid = advertiser.advertiserid
WHERE
    senttime >= '".$startdate."'
        AND senttime <= '".$enddate."'
GROUP BY dt , advertiserid";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','egypt')  ";
	$result1=mysql_query($sql4);

}
}


//gamebar southafrica oxygen


$sql="SELECT 
	COUNT(cbsent) CBS,
	dt,
	CASE
		WHEN advname IS NULL THEN 'other'
		ELSE advname
	END advname,advertiserid
FROM
	(SELECT DISTINCT
		callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid
	FROM
		 fashionbardb_africa.callbackresponse
	
	LEFT JOIN  gamebarbardb_africa.advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
	WHERE
		requesttime >='".$startdate."'
			AND requesttime <= '".$enddate."'
			and issent=1
			and campaignid='43955'
			) a
GROUP BY dt , advname";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','southafrica_oxygen')  ";
	$result1=mysql_query($sql4);

}
}




//glambar southafrica oxygen


$sql="SELECT 
	COUNT(cbsent) cbs,
	dt,
	CASE
		WHEN advname IS NULL THEN 'other'
		ELSE advname
	END advname,advertiserid
FROM
	(SELECT DISTINCT
		callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid
	FROM
		 fashionbardb_africa.callbackresponse
	
	LEFT JOIN  fashionbardb_africa.advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
	WHERE
		requesttime >='".$startdate."'
			AND requesttime <= '".$enddate."'
			and issent=1
			and campaignid='43956'
			) a
GROUP BY dt , advname";

if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','southafrica_oxygen')  ";
	$result1=mysql_query($sql4);

}
}


//glambar southafrica_intarget

$sql="SELECT 
	COUNT(cbsent) cbs,
	dt,
	CASE
		WHEN advname IS NULL THEN 'other'
		ELSE advname
	END advname,advertiserid
FROM
	(SELECT DISTINCT
		callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid
	FROM
		glambardb_southafrica.callbackresponse
	
	LEFT JOIN glambardb_southafrica.advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
	WHERE
		requesttime >='".$startdate."'
			AND requesttime <= '".$enddate."'
			and issent=1
			
			) a
GROUP BY dt , advname";




if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','glambar','southafrica_intarget')  ";
	$result1=mysql_query($sql4);

}
}




//gamebar southafrica_intarget

$sql="SELECT 
	COUNT(cbsent) cbs,
	dt,
	CASE
		WHEN advname IS NULL THEN 'other'
		ELSE advname
	END advname,advertiserid
FROM
	(SELECT DISTINCT
		callbackresponse.clickid cbsent, DATE(requesttime) dt, advname,advertiser.advertiserid
	FROM
		gamebarbardb_africa.callbackresponse
	
	LEFT JOIN gamebarbardb_africa.advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
	WHERE
		requesttime >='".$startdate."'
			AND requesttime <= '".$enddate."'
			and issent=1
			
			) a
GROUP BY dt , advname";




if($result=mysql_query($sql,$con))
{
	$count1++;
while($row=mysql_fetch_array($result,MYSQL_ASSOC))
{
	$act=$row['cbs'];
	$advertiser=$row['advname'];
	$date2=$row['dt'];
	$advertiserid=$row['advertiserid'];
	
	//echo "hi";
	$sql4="INSERT INTO ".$report.".callback_report
	(`dt`,`advname`,`advertiserid`, cbs,`product`,`operator`) values('".$date2."','".$advertiser."','".$advertiserid."','".$act."','gamebar','southafrica_intarget')  ";
	$result1=mysql_query($sql4);

}
}



