<?php
include("includes/connection.php");

$start_date=date('Y-m-01');

$end_date=date('Y-m-d');
$db="hotshotsdb1";
$dblog="hotshotsdblog1";
$sql_report="select * from loop_reports.hotshots_voda where hsvoda_date >= '$start_date' and hsvoda_date < '$end_date'";
$res_report=mysql_query($sql_report);
echo $num=mysql_num_rows($res_report);


if($num == 0)
{
	while($start_date < $end_date)
	{
		$date1=date('Y-m-d',strtotime($start_date . "+1 days"));
		echo $hsvoda="select z.*, v.cbsent from (
					select clicks, uniq, dt, sum(actcnt) act, sum(actamnt) actamnt, 
					sum(rencnt) ren, sum(renamnt) renamnt, sum(LOWbal) Low, cg from (
					select clicks, uniq, dt, act, amt, case when typ = 'DCT' then act else 0 end dctcnt, 
					case when typ = 'ACT' and amt > 0 then act else 0 end ACTcnt,
					case when typ = 'ACT' and amt > 0 then amt else 0 end ACTAMNT, case when typ = 'REN' then act else 0 end RENcnt,
					case when typ = 'REN' then amt else 0 end RENAMNT,
					case when typ = 'ACT' and bal = 0 then act else 0 end LOWbal, bal, cg from (
					select ifnull(clicks,0) clicks, ifnull(uniq ,0) uniq, x.dt, act, amt, typ, bal, ifnull(cg,0) cg 
					from ( select count(*) act, dt, sum(amount) amt, case when isrenew = 0 then 'ACT' else 'REN' END typ, 1 bal 
					from ( select distinct subscriptiondetail.subscriberid, date(subscriptionstartdate)  dt, amount, isrenew 
					from ".$db.".subscriptiondetail  where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$date1."' 
					and subscriptionstartdate < subscriptionenddate and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE) 
					
					) a  group by dt, isrenew  
					union 
					select count(*) act, dt, 0 amt, 'ACT' typ, 0 bal 
					from  ( select distinct subscriptiondetail.subscriberid, date(subscriptionstartdate)  dt, amount, isrenew 
					from ".$db.".subscriptiondetail  where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$date1."' 
					and charging_mode = 'PARKING' ) a  group by dt ) x 
					left join (select count(clicks) clicks, dt from 
					( select userid clicks, date(AccessTime) dt from ".$dblog.".annonymoustracking 
					where accesstime > '".$start_date."'  and accesstime < '".$date1."'  ) y group by dt) 
					z on x.dt = z.dt 
					left join (select count(clicks) uniq, dt 
					from (select distinct userid clicks, dt 
					from (select userid , date(AccessTime) dt from  ".$dblog.".annonymoustracking  
					where accesstime > '".$start_date."'  and accesstime < '".$date1."' ) a) p group by dt ) q 
					on x.dt = q.dt left join (select count(msisdn) cg, dt from (select msisdn, date(requesttime) dt 
					from ".$db.".callbackrequests  where requesttime > '".$start_date."' and requesttime <  '".$date1."' 
					group by msisdn, dt ) j group by dt) k on x.dt = k.dt  
					union  
					select 0 clicks,0 uniq, dt, count(subscriberid) act, 0 amt, 'DCT' typ, 0 bal, 0 cg 
					from (select distinct date(subscriptiondetail.subscriptionstartdate) dt, subscriptiondetail.subscriberid, 
					subscriptiondetail.charging_mode  from ".$db.".subscriptiondetail 
					inner join (select * from ".$db.".subscriptiondetail  where amount > 0 and subscriptionstartdate < subscriptionenddate 
					and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE)) a 
					on a.subscriberid = subscriptiondetail.subscriberid  
					where subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate  
					and subscriptiondetail.subscriptionstartdate > a.subscriptionstartdate  
					and subscriptiondetail.subscriptiondetailid > a.subscriptiondetailid  
					and subscriptiondetail.charging_mode != 'PARKING' and subscriptiondetail.charging_mode != 'GRACE' 
					and subscriptiondetail.subscriptionstartdate >  '".$start_date."'
					and subscriptiondetail.subscriptionstartdate < '".$date1."') 
					w group by dt  order by dt asc, clicks asc) x) y where clicks > 0
					group by clicks, uniq, dt, cg) z inner join ( 
					select dt, sum(cnt) cbsent from ( 
					select dt, count(a.advertiserid) cnt, a.advertiserid, advname 
					from ( select distinct date(requesttime) dt , msisdn, advertiserid from ".$db.".requestresponse 
					where requesttime > '".$start_date."' and requesttime < '".$date1."'  ) a 
					inner join ".$dblog.".advertiser on a.advertiserid = advertiser.advertiserid 
					group by a.advertiserid , dt , advname ) b group by dt ) v on z.dt = v.dt order by dt"; 
			$res_hsvoda=mysql_query($hsvoda) or die(mysql_error());
			$row_hsvoda=mysql_fetch_array($res_hsvoda);
			
			$conv=($row_hsvoda['act']*100)/$row_hsvoda['clicks'];
			$count=$row_hsvoda['act']+$row_hsvoda['ren'];
			$amount=$row_hsvoda['actamnt']+$row_hsvoda['renamnt'];
			$cbs=(row_hsvoda)/$row_hsvoda['act'];
			$advcost=$row_hsvoda['cbsent']*33;
			
			
			$insert="INSERT INTO `loop_reports`.`hotshots_voda`(`hsvoda_date`,`hsvoda_clicks`,`hsvda_uniq`,`hsvoda_sentcg`,`hsvoda_cr`,`hsvoda_act_count`,
			`hsvoda_act_amount`,`hsvoda_ren_count`,`hsvoda_ren_amount`,`hsvoda_total_count`,`hsvoda_total_amount`,`hsvoda_churn`,
			`hsvoda_lowbal`,`hsvoda_lowconv`,`hsvoda_callbacks`,`hsvoda_callback_perc`,`hsvoda_adv_cost`,`hsvoda_loop_revnue`,`hsvoda_diff`,
			`hsvoda_profit`)
			VALUES
			('".$row_hsvoda['dt']."','".$row_hsvoda['clicks']."','".$row_hsvoda['uniq']."','".$row_hsvoda['cg']."','".$conv."','".$row_hsvoda['act']."','".$row_hsvoda['actamnt']."','".$row_hsvoda['ren']."',
			'".$row_hsvoda['renamnt']."','".$count."','".$amount."','','".$row_hsvoda['Low']."','','".$row_hsvoda['cbsent']."','".$cbs."','".$advcost."','','','')
			"; 
			
			$res=mysql_query($insert);

		$start_date=date('Y-m-d',strtotime($start_date . "+1 days"));
	}
}
else
{
	
	
	
}


?>