<?php

date_default_timezone_set("Asia/Calcutta");
//error_reporting(0);
$con=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2


//$conn=mysqli_connect('10.34.240.3','webserveruser','K&dN&r4a8N@du0');


//$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1

$year=date('Y',strtotime('-1 months'));
$month=date('m',strtotime('-1 months'));

$year1=$year;
$month1=$month;



$start_date=$year."-".$month."-01 00:00:00";
$enddate=date("Y-m-t", strtotime($start_date));
$end_date=$enddate." 23:59:59";
$eday=date("t", strtotime($enddate));

//exit;
	
	$date1=date("t", strtotime($enddate));
	$e=1;
	


	$sql1="delete from gamebardb_vodafone_qatar_report.`dashboard` where date>='".$start_date."' and date<='".$end_date."'";
				
				$res1=mysqli_query($con,$sql1);
	
//echo $date1;exit;
//print_r($_POST);
//exit;

$laststartdate=date("Y-m-d",strtotime($start_date." -1 months"));
$lastenddate=date("Y-m-d",strtotime($start_date." -1 days"));

 echo  $sql="SELECT 
    e.country,
    actcount,
    actamount * toinr actamount,
    renewcount,
    renewamount * toinr renewamount,
    totalcount,
    totalamount * toinr totalamount,
    digiinvest * toinr digiinvest,
    revenueshare * toinr revenueshare,
    g.ptotalamount lastmonthrevenue
FROM
    (SELECT 
        country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            SUM(digiinvest) digiinvest,
            SUM(revenueshare) revenueshare
    FROM
        (SELECT 
        country,
            a.product,
            a.operator,
            actcount,
            actamount,
            renewcount,
            renewamount,
            totalcount,
            totalamount,
            cbsent,
            b.operator_cost,
            cbsent * b.operator_cost digiinvest,
            c.revenueshare revenueshare1,
            totalamount * revenueshare revenueshare
    FROM
        (SELECT 
        product,
            country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            operator
    FROM
        gamebardb_vodafone_qatar_report.`mainreport`
    WHERE
        `advertiser` = '0'
            AND `Date` >= '".$start_date."'
            AND Date <= '".$end_date."'
            AND operator != 'ZA_Vodacom_BT'
            AND operator != 'ZA_Vodacom_FG'
            AND operator != 'ZA_Vodacom'
            AND operator != 'ZA_Vodacom_WFH'
            AND operator != 'Thailand_9305_dtac'
            AND operator != 'Thailand_9305_Ais'
            AND operator != 'Thailand_new_9005_Ais'
            AND operator != 'Thailand_new_9005_Dtac'
            AND operator != 'Thailand_new_9005_Truemove'
			AND operator != 'KSA_Weekly_Mobily'
            AND operator != 'KSA_Weekly_STC'
            AND operator != 'KSA_Weekly_zain'
            AND operator != 'KSA_Daily_Mobily'
            AND operator != 'KSA_Daily_STC'
            AND operator != 'KSA_Daily_zain'
    GROUP BY operator,product,country) a
    LEFT JOIN (SELECT 
        operator, operator_cost
    FROM
        gamebardb_vodafone_qatar_report.operatorcost) b ON a.operator = b.operator
    LEFT JOIN (SELECT 
        operator, revenueshare
    FROM
        gamebardb_vodafone_qatar_report.svmobi_revenueshare) c ON a.operator = c.operator
        
       group by product,operator,country,operator_cost,revenueshare) dd
    GROUP BY country) e
        INNER JOIN
    (SELECT 
        *
    FROM
        gamebardb_vodafone_qatar_report.currency) f ON e.country = f.country
        LEFT JOIN
    (SELECT 
        country, ptotalamount
    FROM
        gamebardb_vodafone_qatar_report.dashboard
    WHERE
        date >= '".$laststartdate."'
            AND date <= '".$lastenddate."') g ON g.country = e.country
WHERE
    totalcount > 0";
	
	//echo $sql;exit;
			$res=mysqli_query($con,$sql);

			while($row=mysqli_fetch_array($res,MYSQLI_ASSOC))
			{
				
				$country=$row['country'];
				$actcount=$row['actcount'];
				$actamount=number_format($row['actamount'],2,'.','');
				$rencount=$row['renewcount'];
				$renamount=number_format($row['renewamount'],2,'.','');
				$totalcount=$row['totalcount'];
				$totalamt=number_format($row['totalamount'],2,'.','');
				$digitin=number_format($row['digiinvest'],2,'.',''); 
				$revenue=number_format($row['revenueshare'],2,'.','');
				$profit=number_format($row['revenueshare']-$row['digiinvest'],2,'.','');
				$ptotalamount=number_format($totalamt*$eday/$date1,2,'.','');
				$pdigitalinvest= number_format($digitin*$eday/$date1,2,'.','');
				$psvmobirevenue=number_format($revenue*$eday/$date1,2,'.','');
				$pprofit=number_format($profit*$eday/$date1,2,'.','');

				
				
			echo 	$sql1="INSERT INTO gamebardb_vodafone_qatar_report.`dashboard`(`date`, `country`, `actcount`, `actamount`, `rencount`, `renamount`, `totalcount`, `totalamount`, `digiinvest`, `svmobirevenue`, `profit`,`ptotalamount`, `pdigiinvest`, `psvmobirevenue`, `pprofit`) values ('".$start_date."','".$country."','".$actcount."','".$actamount."','".$rencount."','".$renamount."','".$totalcount."','".$totalamt."','".$digitin."','".$revenue."','".$profit."','".$ptotalamount."','".$pdigitalinvest."','".$psvmobirevenue."','".$pprofit."');";
				
				$res1=mysqli_query($con,$sql1);
			}


?>