<?php
include("includes/check_session.php");
include("includes/connection.php");
$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
error_reporting(0);
$sum=0;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$display='';

if(isset($_POST['submit']))
{
	$count=1;
	$operator=$_POST['operator'];
	$product=$_POST['product'];

	//$start_date=$_POST['start_date']; 
	//$end_date=$_POST['end_date']; 
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
	$display=$_POST['display']; 
	$hours=$_POST['hours'];
	
	if($display == 'Count' || $display == 'Amount' || $display == 'ARPU')
	{
		if($product=='Hotshots')
		{
			if($operator=='Vodafone')
			{
				$db='hotshotsnewdb_voda_0417';
				$dblog='hotshotsdblog1';
						 $sql="							
							SELECT count(DISTINCT
							subscriptiondetail.reqid) act,
						   userlog.msisdn,
								case when advname is null then 'other' else advname end advname,
								userlog.advertiserid,
								DATE(subscriptionstartdate) dt,
								sum(amount) amt
							 
						FROM
							".$db.".subscriptiondetail
						left JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND amount > 0
								AND isrenew = 0
								
						GROUP BY dt, advname
					"; 
					 //echo $sql;
				
			$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					if($display=='Count')
					{
						$act[$row['advname']]= $row['act'];	
					}
					elseif($display=='Amount')
					{
						$act[$row['advname']]= $row['amt'];	
					}
					else
					{
						$act[$row['advname']]= number_format($row['amt']/$row['act'],2);
					}
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
				
			}
			elseif($operator=='Airtel')
			{
				//echo "hi<br>";
				$db='hotshotsnewdb_airtel_0417';
				//$dblog='hotshotsdblog_airtel1';
						/*$sql="SELECT 
								COUNT(mobilenumber) act, sdt dt, advname,   (IFNULL(amount, 0)) * COUNT(mobilenumber) amt
							FROM
								(SELECT 
									DISTINCT mobilenumber,
										DATE(subscriptionstartdate) sdt,
										MAX(annonymoustrackingid) atid,
										amount,
										advertiserid
								FROM
									".$db.".subscriptiondetail
								INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid
								INNER JOIN ".$dblog.".annonymoustracking ON mobilenumber = userid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND isrenew = 0
										AND amount > 0
										
										
										AND advertiserid > 0
								GROUP BY subscriptiondetail.subscriberid , sdt) a
									RIGHT JOIN
								".$dblog.".advertiser ON a.advertiserid = advertiser.advertiserid
							
							GROUP BY dt , advname having act > 0";*/ 
					$sql="SELECT 
							aa.dt dt,
							COUNT(DISTINCT aa.txnid) act,
							sum(aa.amount) amt,
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
							END advname
						FROM
							(SELECT DISTINCT
								subscriptiondetail.txnid,
									userlog.msisdn,
									amount,
									advname,
									advertcallback.advertiserid,
									DATE(subscriptionstartdate) dt,
									MAX(userlogid)
							FROM
								".$db.".subscriptiondetail
							LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
							INNER JOIN ".$db.".advertcallback ON subscriptiondetail.txnid = advertcallback.txnid
							INNER JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND amount > 0
									AND isrenew = 0
									AND subscriptiondetail.charging_mode != 541729
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
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND amount = 0
									AND subscriptiondetail.charging_mode != 541729
									AND subscriptiondetail.errorcode = 1001
									AND subscriptiondetail.subscriptionstartdate = subscriptiondetail.subscriptionenddate) bb ON aa.msisdn = bb.msisdn
						GROUP BY aa.dt , advertiser
					"; 
					//echo $sql."<br>";
				$res=mysql_query($sql,$con1);
				
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					if($display=='Count')
					{
						$act[$row['advname']]= $row['act'];	
						
					}
					elseif($display=='Amount')
					{
						$act[$row['advname']]= $row['amt'];	
					}
					else
					{
						$act[$row['advname']]= number_format($row['amt']/$row['act'],2);
					}
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
			else
			{
				$db='hotshotsnewdb_idea_0417';
				$dblog='hotshotsdblog_idea';
			
				$sql="							
							SELECT 
								aa.dt dt, COUNT(txnid) act, 
								case when aa.advname is null then 'other'
							else aa.advname
							end advname,	
							sum(amount) amt
							FROM
								(SELECT DISTINCT
									subscriptiondetail.txnid,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										amount
										
								FROM
									".$db.".subscriptiondetail
								left JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
								left JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate > '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND amount > 0
										AND (charging_mode like '%act%' or charging_mode like '%UPGRD%') ) aa
							GROUP BY aa.dt , aa.advname;
						
					"; 
					//echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					if($display=='Count')
					{
						$act[$row['advname']]= $row['act'];	
					}
					elseif($display=='Amount')
					{
						$act[$row['advname']]= $row['amt'];	
					}
					else
					{
						$act[$row['advname']]= number_format($row['amt']/$row['act'],2);
					}
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
		}
		else
		{
			if($operator=='Vodafone')
			{
				$db='gamesdb_voda';
				$dblog='gamesdblog_voda';
				$sql="select count(mobilenumber) act, sdt dt, ad advname,sum(amount) amt from (
						select distinct mobilenumber, sdt, date(accesstime) acsdt, ad, amount 
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber, date(subscriptionstartdate) sdt, max(annonymoustrackingid) atid, amount,advertiser.advname ad
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and isrenew=0 and amount > 0 
						and annonymoustracking.advertiserid > -1 and HOUR(subscriptionstartdate)< ".$hours."
						 and operator=1 
						group by subscriptiondetail.subscriberid, sdt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b
						group by sdt, ad;
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					if($display=='Count')
					{
						$act[$row['advname']]= $row['act'];	
					}
					elseif($display=='Amount')
					{
						$act[$row['advname']]= $row['amt'];	
					}
					else
					{
						$act[$row['advname']]= number_format($row['amt']/$row['act'],2);
					}
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				$db='gamesdb';
				$dblog='gamesdblog_idea';
				
				$sql="select count(mobilenumber) act, sdt dt, ad advname,sum(amount) amt from (
						select distinct mobilenumber, sdt, date(accesstime) acsdt, ad, amount 
						from ".$dblog.".annonymoustracking inner join (
						select mobilenumber, date(subscriptionstartdate) sdt, max(annonymoustrackingid) atid, amount,advertiser.advname ad
						from ".$db.".subscriptiondetail 
						inner join ".$db.".subscriber on subscriptiondetail.subscriberid = subscriber.subscriberid
						inner join ".$dblog.".annonymoustracking on mobilenumber = userid
						inner join ".$dblog.".advertiser on advertiser.advertiserid=annonymoustracking.advertiserid
						where subscriptionstartdate >= '".$start_date."' and subscriptionstartdate < '".$end_date."' 
						and charging_mode like '%ACT%' and amount > 0 
						and annonymoustracking.advertiserid > -1 and HOUR(subscriptionstartdate)< ".$hours."
						and operator=2 
						group by subscriptiondetail.subscriberid, sdt, advertiser.advertiserid) a on a.atid = annonymoustrackingid) b
						group by sdt, ad;
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					if($display=='Count')
					{
						$act[$row['advname']]= $row['act'];	
					}
					elseif($display=='Amount')
					{
						$act[$row['advname']]= $row['amt'];	
					}
					else
					{
						$act[$row['advname']]= number_format($row['amt']/$row['act'],2);
					}
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
		}
	}
	elseif($display=='Clicks')
	{
	//echo "hi";
		if($product=='Hotshots')
		{
			if($operator=='Vodafone')
			{
				$db='hotshotsnewdb_voda_0417';
				$dblog='hotshotsdblog1';
				$sql="
					SELECT 
							COUNT(txnid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								txnid, DATE(accesstime) dt, advname
							FROM
								".$db.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."' ) a
					GROUP BY dt , advname; 
				";
		//		echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act[] = [];
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['clicks'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
			elseif($operator=='Airtel')
			{
				$db='hotshotsnewdb_airtel_0417';
				$sql="SELECT 
							COUNT(txnid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								txnid, DATE(accesstime) dt, advname
							FROM
								".$db.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."' ) a
					GROUP BY dt , advname";
				
				//echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act[] = [];
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['clicks'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				
				$db='hotshotsnewdb_idea_0417';
				$dblog1='hotshotsdblog1';
				
				$sql="
					SELECT 
							COUNT(txnid) clicks, dt, 
							case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								txnid, DATE(accesstime) dt, advname
							FROM
								".$db.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."' ) a
					GROUP BY dt , advname; 
				";
				//echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act[] = [];
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['clicks'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
		}
		else
		{
			if($operator=='Vodafone')
			{
				
				$dblog='gamesdblog_voda';
				$sql="SELECT COUNT(annonymoustrackingid) clicks, DATE(accesstime) dt, 
				case when advname is null then 'other'
				else advname 
				end advname
				from ".$dblog.".annonymoustracking 
				left join ".$dblog.".advertiser on advertiser.advertiserid = annonymoustracking.advertiserid and operator=1 and
				HOUR(accesstime) < ".$hours." where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt,advname
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act[] = [];
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['clicks'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
			else
			{
				
				$dblog='gamesdblog_idea';
			
				
				$sql="SELECT COUNT(annonymoustrackingid) clicks, DATE(accesstime) dt, advname  from ".$dblog.".annonymoustracking 
				inner join ".$dblog.".advertiser on advertiser.advertiserid = annonymoustracking.advertiserid and operator=2 and
				HOUR(accesstime) < ".$hours." where accesstime >= '".$start_date."' and accesstime < '".$end_date."' group by dt,advname
				";
				$res=mysql_query($sql,$con);


				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act[] = [];
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['clicks'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
		}
	}
	elseif($display=='CBS')
	{
		if($product=='Hotshots')
		{
			if($operator=='Vodafone')
			{
				
				$db='hotshotsnewdb_voda_0417';
				$dblog='hotshotsdblog1';
				
			$sql= "SELECT COUNT(msisdn) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.txnid,advertcallback.msisdn, DATE(senttime) dt,advname FROM
						".$db.".subscriptiondetail
						INNER JOIN ".$db.".advertcallback ON subscriptiondetail.reqid = advertcallback.txnid
						left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						senttime > '".$start_date."'
						AND senttime <= '".$end_date."'
						and advertcallback.isact != 0
						AND HOUR(senttime) <= '".$hours."'
						
						) s
						gROUP BY dt ,advname";
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['CBS'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
			elseif($operator=='Airtel')
			{
				$db='hotshotsnewdb_airtel_0417';
				
				
				
				$sql="SELECT 
								COUNT(cbsent) CBS, dt,case when advname is null then 'other'
							else advname
							end advname
							FROM
								(SELECT DISTINCT
									advertcallback.txnid cbsent, DATE(senttime) dt,advname
								FROM
									".$db.".advertcallback
								left JOIN ".$db.".subscriptiondetail ON subscriptiondetail.txnid = advertcallback.txnid
                                left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
								WHERE
									senttime >= '".$start_date."'
										AND senttime <= '".$end_date."'
										and advertcallback.isact != 0
                                        AND HOUR(senttime) <= '".$hours."') a
							GROUP BY dt,advname
				";
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['CBS'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				
				$db='hotshotsnewdb_idea_0417';
				$dblog='hotshotsdblog_idea';
				
				$sql="
							SELECT 
								COUNT(cbsent) CBS, dt,case when advname is null then 'other'
							else advname
							end advname
							FROM
								(SELECT DISTINCT
									advertcallback.txnid cbsent, DATE(senttime) dt,advname
								FROM
									".$db.".advertcallback
								left JOIN ".$db.".subscriptiondetail ON subscriptiondetail.msisdn = advertcallback.msisdn
                                left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
								WHERE
									senttime >= '".$start_date."'
										AND senttime <= '".$end_date."'
                                        AND HOUR(senttime) <= '".$hours."') a
							GROUP BY dt,advname
				";
				//echo $sql;
				
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['CBS'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
		}
		else
		{
			if($operator=='Vodafone')
			{
				
				$db='gamesdb_voda';
				$dblog='gamesdblog_voda';
				$sql="SELECT COUNT(requestresponseid) CBS, DATE(requesttime) dt, advname  from ".$db.".requestresponse 
				inner join ".$dblog.".advertiser on advertiser.advertiserid = requestresponse.advertiserid and operator=1 and
				HOUR(requesttime) < ".$hours." where requesttime >= '".$start_date."' and requesttime < '".$end_date."' group by dt,advname
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['CBS'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				
				$db='gamesdb';
				$dblog='gamesdblog_idea';
				
				$sql="SELECT COUNT(requestresponseid) CBS, DATE(requesttime) dt, advname  from ".$db.".requestresponse 
				inner join ".$dblog.".advertiser on advertiser.advertiserid = requestresponse.advertiserid and operator=2 and
				HOUR(requesttime) < ".$hours." where requesttime >= '".$start_date."' and requesttime < '".$end_date."' group by dt,advname
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['CBS'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
		}
	}
	else
	{
		if($product=='Hotshots')
		{
			if($operator=='Vodafone')
			{
				
				$db='hotshotsnewdb_voda_0417';
				//$dblog='hotshotsdblog1';
				$sql="SELECT 
						c.dt dt,
						b.act1 act,
						c.act act1,
						c.advname advname,
						(c.act / b.act1) * 100 cr
					FROM
						(SELECT 
							COUNT(userlogid) act1, advertiserid aid,date(accesstime) dt
						FROM
							".$db.".userlog
						WHERE
							accesstime >= '".$start_date."'
								AND accesstime <= '".$end_date."'
								and HOUR(accesstime)<= ".$hours."
						GROUP BY aid,dt) b
							inner JOIN
						(SELECT 
							COUNT(DISTINCT subscriptiondetail.reqid) act,
								userlog.msisdn,
								CASE
									WHEN advname IS NULL THEN 'other'
									ELSE advname
								END advname,
								userlog.advertiserid aid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
						FROM
							".$db.".subscriptiondetail
						LEFT JOIN ".$db.".userlog ON subscriptiondetail.reqid = userlog.txnid
						LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND amount > 0
								AND isrenew = 0
						GROUP BY userlog.advertiserid,dt) c ON b.aid = c.aid and b.dt=c.dt
					GROUP BY dt , advname
				";
				//echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= number_format($row['cr'],2);	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			elseif($operator=='Airtel')
			{
				
				$db='hotshotsnewdb_airtel_0417';
				$dblog='hotshotsdblog_airtel1';
				echo $sql="SELECT 
					c.dt dt,
					b.act1 act,
					c.act act1,
					CASE
					WHEN c.advname IS NULL THEN 'other'
					ELSE c.advname
					end advname,
						
				   
					(c.act / b.act1) * 100 cr
				FROM
					(SELECT 
						COUNT(userlogid) act1, advertiserid aid
					FROM
						".$db.".userlog
					WHERE
						accesstime > '".$start_date."'
							AND accesstime < '".$end_date."'
					GROUP BY aid) b
						LEFT JOIN
					(SELECT 
						COUNT(DISTINCT subscriptiondetail.txnid) act,
							userlog.msisdn,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END advname,
							userlog.advertiserid aid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
					FROM
						".$db.".subscriptiondetail
					LEFT JOIN ".$db.".userlog ON subscriptiondetail.txnid = userlog.txnid
					LEFT JOIN ".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND HOUR(subscriptionstartdate) <= ".$hours."
							AND amount > 0
							AND isrenew = 0
					GROUP BY advname) c ON b.aid = c.aid
				GROUP BY dt , advname
				";
				//echo $sql;
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= number_format($row['cr'],2);	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				
				$db='hotshotsnewdb_idea_0417';
				$dblog='hotshotsdblog_idea';
				
			$sql="SELECT 
							b.dt dt, clicks act, act act1, b.advname advname, (act/clicks)*100 cr
						FROM
							(SELECT 
								COUNT(txnid) clicks, dt, advname, aid
							FROM
								(SELECT DISTINCT
								txnid,
									msisdn,
									DATE(accesstime) dt,
									advertiser.advertiserid aid,
									advname
							FROM
								".$db.".userlog
							INNER JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."') a
							GROUP BY dt , aid) b
								INNER JOIN
							(SELECT 
								COUNT(a.act) act, dt, a.aid, a.advname
							FROM
								(SELECT DISTINCT
								subscriptiondetail.reqid act,
									DATE(subscriptionstartdate) dt,
									advertiser.advertiserid aid,
									advname,
									MAX(accesstime)
							FROM
								".$db.".subscriptiondetail
							INNER JOIN ".$db.".userlog ON subscriptiondetail.msisdn = userlog.msisdn
							INNER JOIN ".$db.".advertiser ON advertiser.advertiserid = userlog.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."'
									AND amount > 0
									AND (charging_mode like '%ACT%' or charging_mode like '%UPGRD%')
							GROUP BY subscriptiondetail.reqid) a
							GROUP BY dt , aid) c ON b.dt = c.dt AND b.aid = c.aid
						GROUP BY dt , c.aid
				";
				$res=mysql_query($sql,$con1);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= number_format($row['cr'],2);	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
		}
		else
		{
			if($operator=='Vodafone')
			{
				
				$db='gamesdb_voda';
				$dblog='gamesdblog_voda';
				$sql="select ifnull(((cbcnt/reqcnt) * 100),0) cr, a.dt dt, advname from (  
					select count(AnnonymousTrackingID) reqcnt, advertiserid, date(accesstime) dt  from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and  accesstime < '".$end_date."' and HOUR(accesstime) < ".$hours." and advertiserid > 0 and userid is not null  
					group by advertiserid, dt ) a 
					left join (  
					select count(*) cbcnt, advertiserid, date(requesttime) dt from ".$db.".requestresponse   
					where requesttime >= '".$start_date."' and  requesttime < '".$end_date."' and HOUR(requesttime) < ".$hours."
					group by advertiserid, dt 
					) b on a.advertiserid = b.advertiserid and a.dt = b.dt  
					inner join ".$dblog.".advertiser on a.advertiserid = advertiser.advertiserid where operator=1  order by dt, a.advertiserid
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= number_format($row['cr'],2);	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
			}
			else
			{
				
				$db='gamesdb_idea';
				$dblog='gamesdblog_idea';
				
				$sql="select ifnull(((cbcnt/reqcnt) * 100),0) cr, a.dt dt, advname from (  
					select count(AnnonymousTrackingID) reqcnt, advertiserid, date(accesstime) dt  from ".$dblog.".annonymoustracking   
					where accesstime >= '".$start_date."' and  accesstime < '".$end_date."' and HOUR(accesstime) < ".$hours." and advertiserid > 0 and userid is not null  
					group by advertiserid, dt ) a 
					left join (  
					select count(*) cbcnt, advertiserid, date(requesttime) dt from ".$db.".requestresponse   
					where requesttime >= '".$start_date."' and  requesttime < '".$end_date."' and HOUR(requesttime) < ".$hours."
					group by advertiserid, dt 
					) b on a.advertiserid = b.advertiserid and a.dt = b.dt  
					inner join ".$dblog.".advertiser on a.advertiserid = advertiser.advertiserid where operator=2   order by dt, a.advertiserid
				";
				$res=mysql_query($sql,$con);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysql_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= number_format($row['cr'],2);	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				
			}
		}
	}
	
	
}

//$res=mysql_query($sql) or die(mysql_error());
//$fields=mysql_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";

//echo $sql;

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
                    <h2>Perform Report</h2>
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
						
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
								<select name="display" class="form-control">
									
									<option value="Count" <?php $selected=''; if($display=='Count') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Count</option>
									<option value="Amount" <?php  $selected=''; if($display=='Amount') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Amount</option>
									<option value="ARPU" <?php  $selected=''; if($display=='ARPU') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>ARPU</option>
									<option value="CR" <?php  $selected=''; if($display=='CR') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callback Rate</option>
									<option value="CBS" <?php  $selected=''; if($display=='CBS') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callback Sent</option>
									<option value="Clicks" <?php  $selected=''; if($display=='Clicks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Clicks</option>
								
								</select>
								
							</div>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Hours
								<select name="hours" class="form-control">
									<?php
										for($i=24;$i>0;$i--)
										{
											if($i==$hours)
											{
												$selected='selected';
											}
											else
											{
												$selected='';
											}
										?>
											<option <?php echo $selected ?>><?php echo $i; ?></option>
										<?php
										}
									?>
								</select>
								
							</div>
						
						

                     
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
				//print_r($advname);exit;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							
								<thead>
									<tr>
										
										<td><strong>Date</strong></td>
										
										<?php
										foreach($advname as $key=>$val)
										{
											?>
											<td><?php echo $val; ?></td>
											<?php
										}
										?>
										<td><strong>Total</strong></td>
											
									</tr>
								</thead>


								<tbody>
									
																
									<?php   foreach($dt as $key=>$val) { ?>
										<tr>

											<td><?php echo $key; ?></td>
											<?php $sum=0; foreach($advname as $adkey=>$adval) { 
											if(array_key_exists($adval, $val))
											{
											?>

											<td><?php echo $a=$val[$adval]; $sum=$sum+$a;?></td>

											<?php 
											}
											else
											{
											?>
											<td><?php echo '0'; ?></td>
											<?php

											}
											}?>
											<td><?php echo $sum; ?></td>
										</tr>

									<?php } ?>
																
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
