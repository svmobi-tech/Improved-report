<?php
include("includes/check_session.php");
include("includes/connection.php");
//error_reporting(0);

$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;

$adv=$_GET['adv'];
if(isset($_POST['submit']))
{
	$count=1;
	$operator=$_POST['operator'];
	$product=$_POST['product'];
	if($start_date == $end_date)
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
	}	
	else
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
	}
	$pubid=$_POST['pubid']; 
	
	if($adv=='yeahmobi')
	{
		if($product == 'Hotshots')
		{
			if($operator == 'Vodafone')
			{
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 10 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref 
					from hotshotsdblog1.annonymoustracking inner join hotshotsdb1.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join hotshotsdb1.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and isrenew=0 and amount > 0 and advertiserid=10 
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref1 
					from hotshotsdblog1.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=10 
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 10 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref  from hotshotsdblog1.annonymoustracking 
					inner join hotshotsdb1.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join hotshotsdb1.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,71,6) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and isrenew=0 and amount > 0 and advertiserid=10  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref1  from hotshotsdblog1.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=10  
					and CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.ref=b.ref1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
			}
			else
			{
				
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 8 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref 
					from hotshotsdblog_idea.annonymoustracking inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join hotshotsdb_idea.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and charging_mode like '%ACT%' and amount > 0 and advertiserid=8 
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref1 
					from hotshotsdblog_idea.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=8 
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				
				}
				else
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 8 limit 10";
					$res11=mysql_query($sql11);
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt, CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref 
					from hotshotsdblog_idea.annonymoustracking 
					inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join hotshotsdb_idea.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,71,6) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0  and advertiserid=8  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref1  from hotshotsdblog_idea.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=8  
					and CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
			}
		}
		else
		{
			
			if($operator == 'Vodafone')
			{
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_voda.annonymoustracking where advertiserid = 14 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref 
					from gamesdblog_voda.annonymoustracking inner join gamesdb_voda.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join gamesdb_voda.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and isrenew=0 and amount > 0 and advertiserid=14 
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref1 
					from gamesdblog_voda.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=14 
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_voda.annonymoustracking where advertiserid = 14 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_voda.annonymoustracking 
					inner join gamesdb_voda.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join gamesdb_voda.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and isrenew=0 and amount > 0 and advertiserid=14  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED) ref1 from gamesdblog_voda.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=14  
					and CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
				
				
			}
			else
			{
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 1 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref 
					from gamesdblog_idea.annonymoustracking inner join gamesdb.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join gamesdb.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and charging_mode like '%ACT%' and amount > 0 and advertiserid=1 
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref1 
					from gamesdblog_idea.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=1
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 1 limit 10";
					$res11=mysql_query($sql11);
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED) ref
					from gamesdblog_idea.annonymoustracking 
					inner join gamesdb.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join gamesdb.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0 and advertiserid=1  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED) ref1 from gamesdblog_idea.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=1  
					and CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
				
			}
		}
	}
	else
	{
		if($product == 'Hotshots')
		{			
			if($operator == 'Vodafone')
			{
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 39 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref 
					from hotshotsdblog1.annonymoustracking inner join hotshotsdb1.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join hotshotsdb1.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and isrenew=0 and amount > 0 and advertiserid=39
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref1 
					from hotshotsdblog1.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=39 
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 39 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref  from hotshotsdblog1.annonymoustracking 
					inner join hotshotsdb1.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join hotshotsdb1.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,87) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and isrenew=0 and amount > 0 and advertiserid=39  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref1  from hotshotsdblog1.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=39  
					and CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
			}
			else
			{
				
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,89) AS UNSIGNED) ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 40 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,89) AS UNSIGNED) ref 
					from hotshotsdblog_idea.annonymoustracking inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join hotshotsdb_idea.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and charging_mode like '%ACT%' and amount > 0 and advertiserid=40
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,89) AS UNSIGNED) ref1 
					from hotshotsdblog_idea.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=40 
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT SUBSTRING(referrerURL,89)  ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 40 limit 10";
					$res11=mysql_query($sql11);
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,  SUBSTRING(referrerURL,89) ref 
					from hotshotsdblog_idea.annonymoustracking 
					inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join hotshotsdb_idea.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					SUBSTRING(referrerURL,89)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0  and advertiserid=40  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,SUBSTRING(referrerURL,89) ref1  from hotshotsdblog_idea.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=40  
					and SUBSTRING(referrerURL,89) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
			}
		}
		else
		{
			
			if($operator == 'Vodafone')
			{
				if($pubid=='all')
				{
				echo	$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,88) AS UNSIGNED) ref from gamesdblog_voda.annonymoustracking where advertiserid = 19 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,88) AS UNSIGNED) ref 
					from gamesdblog_voda.annonymoustracking inner join gamesdb_voda.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join gamesdb_voda.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and isrenew=0 and amount > 0 and advertiserid=19
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,88) AS UNSIGNED) ref1 
					from gamesdblog_voda.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=19
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					$sql11="select  DISTINCT SUBSTRING(referrerURL,88)  ref from gamesdblog_voda.annonymoustracking where advertiserid = 19 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,
					 SUBSTRING(referrerURL,88) ref from gamesdblog_voda.annonymoustracking 
					inner join gamesdb_voda.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join gamesdb_voda.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					 SUBSTRING(referrerURL,88)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and isrenew=0 and amount > 0 and advertiserid=19  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,
					 SUBSTRING(referrerURL,88) ref1 from gamesdblog_voda.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=19
					and  SUBSTRING(referrerURL,88) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
				
				
			}
			else
			{
				if($pubid=='all')
				{
					$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 20 limit 10";
					$res11=mysql_query($sql11);
					
					
					
					$sql="select act,amt,click,dt,a.ref r from (
					select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref 
					from gamesdblog_idea.annonymoustracking inner join gamesdb.subscriber on subscriber.mobilenumber = annonymoustracking.userid 
					inner join gamesdb.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid 
					where subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and accesstime >= '".$start_date."' and accesstime < '".$end_date."' and charging_mode like '%ACT%' and amount > 0 and advertiserid=20
					and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a, ( 
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref1 
					from gamesdblog_idea.annonymoustracking where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=20
					group by dt1,ref1) b where a.ref=b.ref1 group by a.dt,a.ref;";
				
					$res=mysql_query($sql);
				}
				else
				{
					echo $sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 20 limit 10";
					$res11=mysql_query($sql11);
					
					$sql="select act,amt,click,dt,a.ref r from
					(select count(*) act,SUM(amount) amt, DATE(subscriptiondetail.subscriptionstartdate) dt,CAST(SUBSTRING(annonymoustracking.referrerURL,87) AS UNSIGNED) ref
					from gamesdblog_idea.annonymoustracking 
					inner join gamesdb.subscriber on subscriber.mobilenumber = annonymoustracking.userid
					inner join gamesdb.subscriptiondetail on subscriptiondetail.subscriberid=subscriber.subscriberid
					where
					CAST(SUBSTRING(annonymoustracking.referrerURL,87) AS UNSIGNED)='".$pubid."'
					and 
					subscriptiondetail.subscriptionstartdate >= '".$start_date."' and subscriptiondetail.subscriptionstartdate < '".$end_date."'
					and 
					accesstime >= '".$start_date."' and accesstime < '".$end_date."'
					and charging_mode like '%ACT%' and amount > 0  and advertiserid=20  and DATE(accesstime)=DATE(subscriptionstartdate) group by dt,ref)a,
					(
					select count(annonymoustrackingid) click, DATE(accesstime) dt1,
					CAST(SUBSTRING(annonymoustracking.referrerURL,72,6) AS UNSIGNED) ref1 from gamesdblog_idea.annonymoustracking 
					where accesstime >= '".$start_date."' and accesstime < '".$end_date."' and advertiserid=20  
					and CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ='".$pubid."'
					group by dt1,ref1) b where a.dt=b.dt1 group by dt,a.ref
					";
				
					$res=mysql_query($sql);
				}
				
			}
		}

	}
	
		
	
	
	
}

//$res=mysql_query($sql) or die(mysql_error());
//$fields=mysql_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";



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
                    <h2>PubID wise Report</h2>
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
					<input type="text" hidden value="<?php echo $count; ?>"   id="check1">
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product">
							<option>Product</option>
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback first"> Pub ID
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Pub ID
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="pubid" class="form-control select2_single sel">
									<option value="all">All</option>
									<?php
										
									while($row11=mysql_fetch_array($res11))
									{
										if($row11['ref'] == $pubid)
										{
											$selected='selected';
										}
										else
										{
												$selected='';
										}
										?>
									<option value="<?php echo $row11['ref']; ?>" <?php echo $selected; ?>><?php echo $row11['ref'];?></option>
									<?php
									}
									?>	
								</select>
								</span>
							</div>
						<?php
						}
						?>
						

                     
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
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
							<h2>Output Records <small></small></h2>
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
									<td><strong>PubID</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>CR %</strong></td>
									<td><strong>ARPU</strong></td>
									
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								while($row=mysql_fetch_array($res))
								{
								
								?>
								<tr>
									<td><?php echo $row['dt'];  ?></td>
									<td><?php echo $row['r'];  ?></td>
									<td><?php echo number_format($row['act']);  ?></td>
									<td><?php echo number_format($row['click']);  ?></td>
									<td><?php echo number_format(($row['act']/$row['click'])*100,2); ?></td>
									<td><?php echo number_format(($row['amt']/$row['act']),2); ?></td>
									
								</tr>
								<?php
								}
								?>					
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
		var product = $("#product").val();		
        $.ajax({
            type: "GET",
            url: "ajax/find_pub.php?operator="+operator+"&product="+product+"&adv="+'<?php echo $adv; ?>'         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	   

