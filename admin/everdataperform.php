<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
$con1=$con;

$sum=0;
$start_date='';
$end_date='';
$start_date1='';
$end_date1='';
$operator='';
$product='';
$count=0;
$display='';

if(isset($_POST['submit']))
{
	
	
	
	$count=1;
	$operator=$_POST['operator'];
	$product=$_POST['product'];
	$date1=date('Y-m-d');
	
	$hours=$_POST['hours'];
	$display=$_POST['display']; 
	
	$b=$c=0;
	if($start_date == $end_date)
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}	
	else
	{
		$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
		$end_date=date('Y-m-d 00:00:00',strtotime($_POST['end_date']));
		$start_date1=date('Y-m-d',strtotime($_POST['start_date']));
		$end_date1=date('Y-m-d',strtotime($_POST['end_date']));
	}
	
	if($end_date1 == $date1 && $start_date1 == $date1)
	{
		$c=1;//currentdate
	}
	elseif($end_date1 == $date1 && $start_date1 != $date1)
	{
		
		$b=1;
		$c=1;
	}
	else{
		
		$b=1;
	}
	
		if($product=='gamebar')
		{
			
			if($operator=='Vodafone_Qatar')
			{
				$db='gamesdbnew_197_vodafone_qatar';
				$report='gamebardb_vodafone_qatar_report';
				$c=1;
			}
			else if($operator=='ooredoo_oman')
			{
				$db='gamesdb_ooredoo_oman_ma ';
				$dblog='gamesdblog_ooredoo_oman_ma';
				$report='gamebardb_vodafone_qatar_report';
				$c=1;
			}
			else if($operator=='sweden')
			{
				
				$db="gamebar_sweden";
				$report="gamebardb_vodafone_qatar_report";
				$dblog="gamebar_sweden_log";
				
				
			}
			
			else if($operator=='oman_omantel')
			{
				$db='fashionbardb_omantel';
				$dblog='Gamesdblog_omantel_oman';
				$report='gamebardb_vodafone_qatar_report';
				$c=1;
			}
			
			else if($operator=='cambodia')
			{
				$db='gamesdbnew_smart_cambodia';
				//$dblog='Gamesdblog_omantel_oman';
								$c=1;
				$report='gamebardb_vodafone_qatar_report';
			}
			
			else if($operator=='vodafone_egypt')
			{
				
				$db="gamebardb_vodafone_egypt";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$sql_ad="select * from ".$db.".advertiser where operator=1 ";
				$res_ad=mysqli_query($con,$sql_ad);
			}
			else if($operator=='indonesia')
			{
				$db='gamebardb_indonesia';
				$dblog='gamebardblog_indonesia';
				$report='gamebardb_vodafone_qatar_report';
				
			}
			
			else if($operator=='pk_telenor')
			{
				
				$db="gamebar_pk";
				$dblog="gamebar_pk_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='srilanka_gamestore')
			{
				
				$db="gamesdbnew_srilanka_dialog_gamestore";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				$c=1;
				
			}
			
			
			else if($operator=='pk_zong')
			{
				
				$db="gamebar_pk";
				$dblog="gamebar_pk_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='finland')
			{
				
				$db="fashionbardb_finland";
				$dblog="gamebar_pk_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			
			else if($operator=='spain')
			{
				
				$db="gamebardb_spain";
				$dblog="gamebardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='kwzain')
			{
				
				$db="fashionbardb_kwzain";
				$dblog="";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			
			else if($operator=='southafricamtn')
			{
				
				$db="fashionbardb_za";
				$dblog="";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='southafricacellc')
			{
				
				$db="fashionbardb_za";
				$dblog="";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='vodacom_za')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				
				$c=1;
				
			}
			
			else if($operator=='poland')
			{

			$db="gamebar_poland";
			$dblog="gamebar_poland_log";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			else if($operator=='myanmar')
			{

			$db="fashionbardb_myanmartelenor";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			
			else if($operator=='Bangladesh_Robi')
			{

			$db="gamesdbnew_robi_bangladesh";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
				if($display!='Clicks')
				{
				$c=1;			
				}
			}
			else if($operator=='srilanka')
			{

			$db="gamesdbnew_dialog_srilanka";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			else if($operator=='malaysia_cellcom')
			{

			$db="gamesdbnew_celcom_malaysia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			
			
			
			else if($operator=='all_greece')
			{
				$db="";
				$report="gamebardb_vodafone_qatar_report";
				
				$c=1;
				
			}	
			else if($operator=='gr2')
			{
				$db="";
				$report="gamebardb_vodafone_qatar_report";
				
				$c=1;
				
			}
			
			else if($operator=='france')
			{
				
				$db="gamebardb_france";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				$c=1;
				
			}
			else if($operator=='norway')
			{
				
				$db="gamebardb_norway";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				$c=1;
				
			}
			else if($operator=='netherland_netsmart')
			{
				
				$db="fashionbardb_nl";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				$c=1;
				
			}
			else if($operator=='zain_ksa')
			{
				
				$db="fashionbardb_timwezain";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='stc_ksa')
			{
				
				$db="fashionbardb_timwezain";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='all_ksa')
			{
				
				$db="fashionbardb_timwezain";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='mobily_ksa_weekly')
			{
				
				$db="fashionbardb_saweekly";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='saudiarabia_zain_weekly')
			{
				
				$db="fashionbardb_saweekly";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='stc_ksa_weekly')
			{
				
				$db="fashionbardb_saweekly";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='all_ksa_weekly')
			{
				
				$db="fashionbardb_saweekly";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			
			else if($operator=='uae_etisalat')
			{
				
				$db="fashionbardb_etisalat";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			
			else if($operator=='bahrain_zain')
			{
				
				$db="fashionbardb_bh";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			else if($operator=='bahrain_batelco' || $operator=='bahrain_stc' )
			{
				
				$db="gamesdb_batelviva_bahrain";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			
			else if($operator=='qatar_ooredoo')
			{
				
				$db="gamesdb_ooredoo_qatar_ma";
				$report="gamebardb_vodafone_qatar_report";
				//$dblog="gamesdblog_voda";
				
				$c=1;
			}
			
			
			else if($operator=='uae_du')
			{
				
				$db="gamesdb_uaedu_ma";
				
				//$dblog="gamesdblog_voda";
				
				
			}
			
			
			elseif($operator=='thailand')
			{
				$db='fashionbardb_game9305thailand';
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			/*else{
				$db='hotshotsnewdb_idea_0717';
			}*/
			
		}
		else{
			if($operator=='spain')
			{
				$db="fashionbardb_spain";
				$dblog="fashionbardblog_spain";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			
			else if($operator=='southafricamtn')
			{
				
				$db="fashionbardb_zaglam";
				$dblog="";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			else if($operator=='southafricacellc')
			{
				
				$db="fashionbardb_zaglam";
				$dblog="";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				
			}
			
			
			else if($operator=='poland')
			{

			$db="glambar_poland";
			$dblog="glambar_poland_log";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			else if($operator=='poland_teleaudio')
			{

			$db="glambar_plteleaudio";
			$dblog="glambar_plteleaudio_log";
			$report="gamebardb_vodafone_qatar_report";
			$advertiserdb="advertiserdb";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			else if($operator=='thailand')
			{

			$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			else if($operator=='newthailand')
			{

			//$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$c=1;			
			}
			
			else if($operator=='vodacom_wfh')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				//$sql_ad="select * from ".$db.".advertiser where serviceid=1";
				//$res_ad=mysqli_query($con,$sql_ad);
				
			}
			else if($operator=='vodacom_all')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				//$sql_ad="select * from ".$db.".advertiser where serviceid=1";
				//$res_ad=mysqli_query($con,$sql_ad);
				
			}
			else if($operator=='vodacom_fg')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				//$sql_ad="select * from ".$db.".advertiser where serviceid=1";
				//$res_ad=mysqli_query($con,$sql_ad);
				
			}
			else if($operator=='vodacom_bt')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				//$sql_ad="select * from ".$db.".advertiser where serviceid=1";
				//$res_ad=mysqli_query($con,$sql_ad);
				
			}
			else if($operator=='saudiarabia_zain')
			{
				$db="vodacom_za";
				$dblog="vodacom_za_log";
				$report="gamebardb_vodafone_qatar_report";
				$c=1;
				//$sql_ad="select * from ".$db.".advertiser where serviceid=1";
				//$res_ad=mysqli_query($con,$sql_ad);
				
			}
			
			
			
			
			
			
		}

	
	
	
	
	
	
	if($display == 'Count' || $display == 'Amount' || $display == 'ARPU')
	{
		//echo "hi";
		
		if($product=='gamebar')
		{
			
			$cnt = 0;
			$prevdate = "";
			$advname2 = [];
			$arrdt2 = [];
			$act2 = array();
			$dt2=[];
			//echo "hi1";
			//exit;
			if($b==1)
			{
				
				if($display == 'ARPU')
				{
					$sql2="select date,advertiser,hour,avg(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and operator='".$operator."' and product='".$product."' and type='".$display."' and hour <= '".$hours."' group by advertiser,date;";
				}
				else{
				 $sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and operator='".$operator."' and product='".$product."' and type='".$display."' and hour <= '".$hours."' group by advertiser,date;";
				
				}
				
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						if($display == 'ARPU')
						{
							$act2[$prevdate][$row2['advertiser']]= number_format($row2['sum'],2);
						}
						else{
							$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						}
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
						//$start_date=date('Y-m-d')." 00:00:00";
						//$end_date=date('Y-m-d')." 23:59:59";
				
				if($operator=='Vodafone_Qatar')
				{
					
						//$start_date=date('Y-m-d')." 00:00:00";
						//$end_date=date('Y-m-d')." 23:59:59";
				
							 
							 
							 $sql="	

									SELECT 
									COUNT(DISTINCT subscriber.msisdn) act,
									CASE
										WHEN advertiser_name IS NULL THEN 'other'
										ELSE advertiser_name
									END advname,
									subscriber.advertiserid advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
								FROM
									fashionbardb_qatarvodafone.subscriber
										LEFT JOIN
									commondbqatarvodafone.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate > '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) < '".$hours."'
										AND charging_mode = 'act'
										AND amount > 0
								GROUP BY dt , advertiser_name"; 
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				if($operator=='vodafone_egypt')
				{
					
				
						$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					 
							 
							  $sql="SELECT 
										COUNT(distinct subscriptiondetail.reqid) act,
										subscriptiondetail.msisdn,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										subscriptiondetail.advid,
										DATE(subscriptionstartdate) dt,
										SUM(amount) amt
									FROM
										".$db.".subscriptiondetail
											LEFT JOIN
										
										".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
									WHERE
										subscriptionstartdate > '".$start_date."'
											AND subscriptionstartdate < '".$end_date."'
											AND HOUR(subscriptionstartdate) < ".$hours."
											AND amount > 0
											AND isrenew = 0
									GROUP BY dt , advname"; 
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='indonesia')
				{
					
				
						$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					 
							 
							echo  $sql="							
								SELECT count(DISTINCT mo.clickid) act,
							   
									case when advname is null then 'other' else advname end advname,
									mo.advid,
									DATE(subscriptionstartdate) dt,
									sum(amount) amt
								 
							FROM
								".$db.".mo
							
							LEFT JOIN ".$db.".advertiser ON mo.advid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >'".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									and charging_mode='ACT'
									AND amount > 0
									
									
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='spain')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriprion_startdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriprion_startdate > '".$start_date."'
								AND subscriprion_startdate < '".$end_date."'
								AND HOUR(subscriprion_startdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='uae_etisalat')
				{
					$sql="	SELECT 
							COUNT(DISTINCT subscriber.clickid) act,
							advertiser_name advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_etisalat.subscriber
								LEFT JOIN
							commondbetisalat.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='finland')
				{
					$sql="SELECT 
							COUNT(DISTINCT subscriber.clickid) act,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_finland.subscriber
								LEFT JOIN
							commondbfinland.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name
						"; 
						 //echo $sql;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='thailand')
				{
					$sql="SELECT 
							COUNT(DISTINCT downloaddr.clickid) act,
							advertiser_name advname,
							downloaddr.advertiserid advid,
							DATE(downloaddatetime) dt
						FROM
							fashionbardb_game9305thailand.downloaddr
								LEFT JOIN
							commondbthailand.newadvertiser ON downloaddr.advertiserid = newadvertiser.advertiserid
						WHERE
							downloaddatetime > '".$start_date."'
								AND downloaddatetime < '".$end_date."'
								AND HOUR(downloaddatetime) < '".$hours."'
								AND charging_mode = 'act'
						GROUP BY dt , advertiser_name;
						"; 
						 //echo $sql;
					
				$res=mysqli_query($con11,$sql);
					
					
				}
				
				
				
				
				else if($operator=='bahrain_stc')
				{
					 $sql="call ".$db.".get_perform_count_stc('".$start_date."','".$end_date."',".$hours.")"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				else if($operator=='cambodia')
				{
					 $sql="call ".$db.".get_perform_count('".$start_date."','".$end_date."',".$hours.")"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				else if($operator=='bahrain_batelco')
				{
					 $sql="call ".$db.".get_perform_count_batelco('".$start_date."','".$end_date."',".$hours.")"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				else if($operator=='srilanka_gamestore')
				{
					 $sql="call ".$db.".get_perform_count('".$start_date."','".$end_date."',".$hours.")"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				
				else if($operator=='ooredoo_oman')
				{
					 $sql="SELECT 
							COUNT(DISTINCT msisdn) act,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_omooredoo.subscriber
								LEFT JOIN
							commondbomooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				else if($operator=='qatar_ooredoo')
				{
					 $sql="SELECT 
							COUNT(DISTINCT msisdn) act,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_qatarooredoo.subscriber
								LEFT JOIN
							commondbqatarooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				
				
				else if($operator=='uae_du')
				{
					 $sql="call ".$db.".get_perform_count('".$start_date."','".$end_date."',".$hours.")"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				
				
				else if($operator=='oman_omantel')
				{
					 $sql="SELECT 
							COUNT(DISTINCT msisdn) act,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_omantel.subscriber
								LEFT JOIN
							commondbomantel.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{
							//echo $row['dt'];exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					//print_r($dt2);exit;

					
				}
				
				
				else if($operator=='bahrain_zain')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.msisdn) act,
								advertiser_name advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_bh.subscriber
									LEFT JOIN
								commondbbh.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'act'
									AND amount > 0
							GROUP BY dt , advertiser_name
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='vodacom_za')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								and subscriber.serviceid=4
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				else if($operator=='stc_ksa')
				{
					$sql="		SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_timwezain.subscriber inner join 
							commondbksastc.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'act'
								and amount > 0
								and subscriber.operator='stc'
						GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='stc_ksa_weekly')
				{
					$sql="		SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'act'
								and amount > 0
								and subscriber.operator='stc'
						GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='mobily_ksa_weekly')
				{
					 $sql="		SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'act'
								and amount > 0
								and subscriber.operator='mobily'
						GROUP BY dt , advname;
						"; 
						// echo $sql;exit;
					
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='saudiarabia_zain_weekly')
				{
					$sql="		SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'act'
								and amount > 0
								and subscriber.operator='zain'
						GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				else if($operator=='saudiarabia_zain')
				{
					 $sql="		SELECT 
						DATE(subscriptionstartdate) dt,
						COUNT(DISTINCT msisdn) act,
							subscriber.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_timwezain.subscriber left join 
						commondbksazain.advertiser on subscriber.advertiserid=advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND HOUR(subscriptionstartdate) <=".$hours."
							AND charging_mode = 'act'
							and amount > 0
							and subscriber.operator='zain'
					GROUP BY dt , advname;
						"; 
						// echo $sql;exit;
					
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				else if($operator=='kwzain')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_slakwzain.subscriber
									LEFT JOIN
								commondbslakwzain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'act'
									AND amount > 0
							GROUP BY dt , advertiser_name
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='kwstc')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_slakwstc.subscriber
									LEFT JOIN
								commondbslakwstc.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'act'
									AND amount > 0
							GROUP BY dt , advertiser_name
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='southafricamtn')
				{
							$sql="							
									SELECT 
									DATE(subscriptionstartdate) dt,
									COUNT(DISTINCT clickid) act,
									subscriber.advertiserid advid,
									CASE
										WHEN advertiser_name IS NULL THEN 'OTHER'
										ELSE advertiser_name
									END advname,
									0 amt
								FROM
									".$db.".subscriber
										INNER JOIN
									commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND charging_mode = 'act'
										AND subscriber.operator = 'mtn'
										AND amount > 0
								GROUP BY dt , advname;
							"; 
							 echo $sql;
						
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='southafricacellc')
				{
						$sql="							
									SELECT 
									DATE(subscriptionstartdate) dt,
									COUNT(DISTINCT clickid) act,
									subscriber.advertiserid advid,
									CASE
										WHEN advertiser_name IS NULL THEN 'OTHER'
										ELSE advertiser_name
									END advname,
									0 amt
								FROM
									".$db.".subscriber
										INNER JOIN
									commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND charging_mode = 'act'
										AND subscriber.operator = 'cellc'
										AND amount > 0
								GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				else if($operator=='gr2')
				{
					$sql="							
								SELECT
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
							subscriber.advertiserid advid,
							CASE WHEN
							advertiser_name is null then 'OTHER'
							else
							advertiser_name
							END advname,
							0 amt
							FROM
							fashionbardb_greece.subscriber inner join
							commondbgreece.advertiser on subscriber.advertiserid=advertiser.advertiserid
							WHERE
							subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND HOUR(subscriptionstartdate) <".$hours."
							AND charging_mode = 'act'
							and amount > 0
							GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				else if($operator=='netherland_netsmart')
				{
								$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advertiser_name advname,
								subscriber.advertiserid,
								DATE(subscriptionstartdate) dt
								FROM
								".$db.".subscriber
								LEFT JOIN
								commondbnl.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								GROUP BY dt , advname;
						"; 
						 //echo $sql;
					//exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='france')
				{
								$sql="							
								SELECT COUNT(DISTINCT subscriber.txnid) act, advname, userlog.advertiserid advid, DATE(subscriptionstartdate) dt, SUM(amount) amt
								FROM
								".$db.".subscriber inner join ".$db.".userlog on subscriber.txnid = userlog.txnid
								LEFT JOIN
								".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'start-subscription'
								AND amount > 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					//exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='norway')
				{
								$sql="							
								SELECT COUNT(DISTINCT subscriber.txnid) act, advname, userlog.advertiserid advid, DATE(subscriptionstartdate) dt, SUM(amount) amt
								FROM
								".$db.".subscriber inner join ".$db.".userlog on subscriber.txnid = userlog.txnid
								LEFT JOIN
								".$db.".advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'start-subscription'
								AND amount > 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					//exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				
				
				
				
				
				else if($operator=='pk_telenor')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subsriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subsriptionstartdate > '".$start_date."'
								AND subsriptionstartdate < '".$end_date."'
								AND HOUR(subsriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								and mnc='06'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='pk_zong')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subsriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subsriptionstartdate > '".$start_date."'
								AND subsriptionstartdate < '".$end_date."'
								AND HOUR(subsriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								and mnc='04'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				else if($operator=='all_greece')
				{
					$sql="							
								SELECT 
								dt, SUM(act) act, SUM(amt) amt, advname, advertiserid
							FROM
								(SELECT 
									COUNT(DISTINCT subscriber.txnid) act,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										SUM(amount) amt
								FROM
									gamebardb_greecevf.subscriber
								INNER JOIN gamebardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
								LEFT JOIN gamebardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND amount > 0
										AND charging_mode = 'start-subscription'
										AND isrenew = 0
										AND HOUR(subscriptionstartdate) < ".$hours."
								GROUP BY dt , advname UNION ALL SELECT 
									COUNT(DISTINCT subscriber.txnid) act,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										SUM(amount) amt
								FROM
									gamebardb_greececosmote.subscriber
								INNER JOIN gamebardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
								LEFT JOIN gamebardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND amount > 0
										AND charging_mode = 'start-subscription'
										AND isrenew = 0
										AND HOUR(subscriptionstartdate) < ".$hours."
								GROUP BY dt , advname UNION ALL SELECT 
									COUNT(DISTINCT subscriber.txnid) act,
										advname,
										advertiser.advertiserid,
										DATE(subscriptionstartdate) dt,
										SUM(amount) amt
								FROM
									gamebardb_greecewind.subscriber
								INNER JOIN gamebardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
								LEFT JOIN gamebardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND amount > 0
										AND charging_mode = 'start-subscription'
										AND isrenew = 0
										AND HOUR(subscriptionstartdate) < ".$hours."
								GROUP BY dt , advname) cosmote
							GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='sweden')
				{
					 $sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								case when advname is null then 'other' else advname end advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					//exit;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				
				else if($operator=='poland')
				{
					 $sql="	
						SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								case when advname is null then 'other' else advname end advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								GROUP BY dt , advname
								
						"; 
						// echo $sql;exit;
					
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='myanmar')
				{
					 $sql="							
								SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) act,
								subscriber.advertiserid,
								advertiser_name advname,
								0 amt
						FROM
							".$db.".subscriber inner join 
							commondbmyanmar.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
						GROUP BY dt , subscriber.advertiserid;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='Bangladesh_Robi')
				{
					  $sql="SELECT 
								DATE(subscriptionstartdate) dt,
								COUNT(DISTINCT txnid) act,
								subscriptiondetail.advid,
								CASE
									WHEN
										subscriptiondetail.advid = - 1
											OR subscriptiondetail.advid IS NULL
									THEN
										'other'
									ELSE advname
								END advname,
								0 amt
							FROM
								".$db.".subscriptiondetail
									left JOIN
								".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) < '".$hours."'
									AND isrenew = 0
									AND charging_mode LIKE '%act%'
									AND amount > 0
							GROUP BY dt , subscriptiondetail.advid
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='srilanka')
				{
					  $sql="SELECT 
								DATE(subscriptionstartdate) dt,
								COUNT(DISTINCT txnid) act,
								subscriptiondetail.advid,
								CASE
									WHEN
										subscriptiondetail.advid = - 1
											OR subscriptiondetail.advid IS NULL
									THEN
										'other'
									ELSE advname
								END advname,
								0 amt
							FROM
								".$db.".subscriptiondetail
									left JOIN
								".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) < '".$hours."'
									AND isrenew = 0
									AND charging_mode LIKE '%act%'
									AND amount > 0
							GROUP BY dt , subscriptiondetail.advid
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='malaysia_cellcom')
				{
					  $sql="SELECT 
								DATE(subscriptionstartdate) dt,
								COUNT(DISTINCT txnid) act,
								subscriptiondetail.advid,
								CASE
									WHEN
										subscriptiondetail.advid = - 1
											OR subscriptiondetail.advid IS NULL
									THEN
										'other'
									ELSE advname
								END advname,
								0 amt
							FROM
								".$db.".subscriptiondetail
									left JOIN
								".$db.".advertiser ON subscriptiondetail.advid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) < '".$hours."'
									AND isrenew = 0
									AND charging_mode LIKE '%act%'
									AND amount > 0
							GROUP BY dt , subscriptiondetail.advid
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				
				
				
				
				
				
				
				
			}
		}
		else
		{
			$cnt = 0;
			$prevdate = "";
			$advname2 = [];
			$arrdt2 = [];
			$act2 = array();
			$dt2=[];
			
			
			
			
			if($b==1)
			{
				
				if($display == 'ARPU')
				{
					$sql2="select date,advertiser,hour,avg(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and operator='".$operator."' and product='".$product."' and type='".$display."' and hour < '".$hours."' group by advertiser,date;";
				}
				else{
				 $sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and operator='".$operator."' and product='".$product."' and type='".$display."' and hour < '".$hours."' group by advertiser,date;";
				
				}
				
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						if($display == 'ARPU')
						{
							$act2[$prevdate][$row2['advertiser']]= number_format($row2['sum'],2);
						}
						else{
							$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						}
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
						//$start_date=date('Y-m-d')." 00:00:00";
						//$end_date=date('Y-m-d')." 23:59:59";
			
				if($operator=='spain')
				{
					 $sql="	SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriprion_startdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriprion_startdate > '".$start_date."'
								AND subscriprion_startdate < '".$end_date."'
								AND HOUR(subscriprion_startdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='newthailand')
				{
					 $sql="
					 SELECT 
							COUNT(DISTINCT downloaddr.clickid) act,
							advertiser_name advname,
							downloaddr.advertiserid advid,
							DATE(downloaddatetime) dt
						FROM
							fashionbardb_glam9005thailand.downloaddr
								LEFT JOIN
							commondbthailand.newadvertiser ON downloaddr.advertiserid = newadvertiser.advertiserid
						WHERE
							downloaddatetime > '".$start_date."'
								AND downloaddatetime < '".$end_date."'
								AND HOUR(downloaddatetime) < ".$hours."
								AND charging_mode = 'act'
						GROUP BY dt , advertiser_name;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='southafricamtn')
				{
							$sql="							
									SELECT 
									DATE(subscriptionstartdate) dt,
									COUNT(DISTINCT clickid) act,
									subscriber.advertiserid advid,
									CASE
										WHEN advertiser_name IS NULL THEN 'OTHER'
										ELSE advertiser_name
									END advname,
									0 amt
								FROM
									".$db.".subscriber
										INNER JOIN
									commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND charging_mode = 'act'
										AND subscriber.operator = 'mtn'
										AND amount > 0
								GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='southafricacellc')
				{
						$sql="							
									SELECT 
									DATE(subscriptionstartdate) dt,
									COUNT(DISTINCT clickid) act,
									subscriber.advertiserid advid,
									CASE
										WHEN advertiser_name IS NULL THEN 'OTHER'
										ELSE advertiser_name
									END advname,
									0 amt
								FROM
									".$db.".subscriber
										INNER JOIN
									commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate >= '".$start_date."'
										AND subscriptionstartdate <= '".$end_date."'
										AND HOUR(subscriptionstartdate) <= ".$hours."
										AND charging_mode = 'act'
										AND subscriber.operator = 'cellc'
										AND amount > 0
								GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				
				
				else if($operator=='vodacom_wfh')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								and subscriber.serviceid=1
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				else if($operator=='vodacom_all')
				{
					 $sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='vodacom_fg')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								and subscriber.serviceid=2
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='vodacom_bt')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
								and subscriber.serviceid=3
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
			
				
				if($operator=='all_greece')
				{
					 $sql="	SELECT 
							dt, SUM(act) act, SUM(amt) amt, advname, advertiserid
							FROM
							(SELECT 
								COUNT(DISTINCT subscriber.txnid) act,
									advname,
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
							FROM
								glambardb_greecevf.subscriber
							INNER JOIN glambardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
							LEFT JOIN glambardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND amount > 0
									AND charging_mode = 'start-subscription'
									AND isrenew = 0
									AND HOUR(subscriptionstartdate) < '".$hours."'
							GROUP BY dt , advname UNION ALL SELECT 
								COUNT(DISTINCT subscriber.txnid) act,
									advname,
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
							FROM
								glambardb_greececosmote.subscriber
							INNER JOIN glambardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
							LEFT JOIN glambardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND amount > 0
									AND charging_mode = 'start-subscription'
									AND isrenew = 0
									AND HOUR(subscriptionstartdate) < '".$hours."'
							GROUP BY dt , advname UNION ALL SELECT 
								COUNT(DISTINCT subscriber.txnid) act,
									advname,
									advertiser.advertiserid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
							FROM
								glambardb_greecewind.subscriber
							INNER JOIN glambardb_greecevf.userlog ON subscriber.txnid = userlog.txnid
							LEFT JOIN glambardb_greecevf.advertiser ON userlog.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND amount > 0
									AND charging_mode = 'start-subscription'
									AND isrenew = 0
									AND HOUR(subscriptionstartdate) < '".$hours."'
							GROUP BY dt , advname) cosmote
							GROUP BY dt , advname;
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				else if($operator=='poland_teleaudio')
				{
					$sql="							
							select act,CONCAT(`advname`, ' ', `operator`) advname,advid,dt from (SELECT 
							COUNT(DISTINCT subscriber.clickid) act,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END advname,
							subscriber.advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt,
							operator
						FROM
							".$db.".subscriber
								LEFT JOIN
							".$advertiserdb.".advertiser ON subscriber.advid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
						GROUP BY dt , advname,operator)a
								
						"; 
						// echo $sql;exit;
					
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				else if($operator=='poland')
				{
					$sql="							
							SELECT 
								COUNT(DISTINCT subscriber.clickid) act,
								case when advname is null then 'other' else advname end advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'ACT'
								AND amount > 0
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				else if($operator=='thailand')
				{
					$sql="							
							select count(clickid)act,
							date(downloaddatetime)dt,
							aa.advertiserid advid,
							CASE WHEN
								advertiser_name is null then 'OTHER'
							else
								advertiser_name  
							END advname
							from(
							SELECT 
									 distinct clickid, downloaddatetime,downloaddr.advertiserid
								FROM
									".$db.".downloaddr
									
								WHERE 
									downloaddatetime >= '".$start_date."'
										AND downloaddatetime <= '".$end_date."'
									
										AND status_code = 'ok'
										AND charging_mode = 'act'
										and hour(downloaddatetime)<'".$hours."'
							)aa LEFT JOIN commondbthailand.advertiser ON aa.advertiserid = advertiser.advertiserid
							group by dt, advname;
											
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
					
					
					$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
					
					
				}
				
				
				
				
				
				
			
			}		
		}
	}

	elseif($display=='Clicks')
	{
		
	
		if($product=='gamebar')
		{
			
			if($b==1)
			{
				
				
				  $sql2="							
						select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='".$display."' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;
				";
				
				
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
						//$start_date=date('Y-m-d')." 00:00:00";
						//$end_date=date('Y-m-d')." 23:59:59";
					//echo "hi".$operator;exit;
			if($operator=='Vodafone_Qatar')
			{
			//	$db='hotshotsnewdb_voda_0617';
					//		$dblog='hotshotsdblog1';
					
					

					$sql="
								SELECT 
								COUNT(clickid) clicks,
								dt,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advertiser_name
								FROM
									fashionbardb_qatarvodafone.userlog
								LEFT JOIN commondbqatarvodafone.advertiser ON advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."') a
							GROUP BY dt , advertiser_name;
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
							if($b==1){
							$advname=array_merge($advname,$advname2);
								$act=array_merge($act,$act2);
								$arrdt=array_merge($arrdt,$arrdt2);
								$advname=array_unique($advname);
								$dt=array_merge($dt,$dt2);
							}
						//echo "hi";exit;
			}
			
			if($operator=='vodafone_egypt')
			{
			//	$db='hotshotsnewdb_voda_0617';
		//		$dblog='hotshotsdblog1';
				
				$start_date=date('Y-m-d')." 00:00:00";
						$end_date=date('Y-m-d')." 23:59:59";
					

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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='indonesia')
			{
				$start_date=date('Y-m-d')." 00:00:00";
				$end_date=date('Y-m-d')." 23:59:59";
				
				 $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='spain')
			{
			
				  $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='thailand')
			{
			
				  $sql="
					SELECT 
					COUNT(DISTINCT userlog.clickid) clicks,
					advertiser_name advname,
					userlog.advertiserid advid,
					DATE(accesstime) dt
				FROM
					fashionbardb_game9305thailand.userlog
						LEFT JOIN
					commondbthailand.newadvertiser ON userlog.advertiserid = newadvertiser.advertiserid
				WHERE
					accesstime > '".$start_date."'
						AND accesstime < '".$end_date."'
						AND HOUR(accesstime) < '".$hours."'
				GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='finland')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE 
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END  advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
						
					FROM
						fashionbardb_finland.userlog
					LEFT JOIN commondbfinland.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
				GROUP BY dt , advertiser_name;

				";
				
				//echo $sql;exit;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			else if($operator=='poland')
			{
			
				  $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='sweden')
			{
			
				  $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='srilanka_gamestore')
			{
			
				   $sql="call ".$db.".get_perform_clicks('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			
			
			
			
			
			else if($operator=='bahrain_stc')
			{
			
				   $sql="call ".$db.".get_perform_clicks_stc('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='cambodia')
			{
			
				   $sql="call ".$db.".get_perform_clicks('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='bahrain_batelco')
			{
			
				   $sql="call ".$db.".get_perform_clicks_batelco('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='ooredoo_oman')
			{
			
				   $sql="call ".$db.".get_perform_clicks('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			
			else if($operator=='qatar_ooredoo')
			{
			
				   $sql="SELECT 
						COUNT(clickid) clicks,
						dt,
						CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
						END advname
					FROM
						(SELECT 
							clickid, DATE(accesstime) dt, advertiser_name
						FROM
							fashionbardb_qatarooredoo.userlog
						LEFT JOIN commondbqatarooredoo.advertiser ON advertiser.advertiserid = userlog.advertiserid
						WHERE
							accesstime >= '".$start_date."'
								AND accesstime <= '".$end_date."'
								AND HOUR(accesstime) <= '".$hours."') a
					GROUP BY dt , advertiser_name;"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='uae_du')
			{
			
				   $sql="call ".$db.".get_perform_clicks('".$start_date."','".$end_date."',".$hours.")"; 					 
				
				
		//		echo $sql;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			else if($operator=='oman_omantel')
			{
			
				 $sql="SELECT 
						COUNT(clickid) clicks,
						dt,
						CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
						END advname
					FROM
						(SELECT 
							clickid, DATE(accesstime) dt, advertiser_name
						FROM
							fashionbardb_omantel.userlog
						LEFT JOIN commondbomantel.advertiser ON advertiser.advertiserid = userlog.advertiserid
						WHERE
							accesstime >= '".$start_date."'
								AND accesstime <= '".$end_date."'
								AND HOUR(accesstime) <= '".$hours."') a
					GROUP BY dt , advertiser_name;"; 					 
				
				
				//echo $sql;exit;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			
			
			else if($operator=='vodacom_za')
			{
			
				   $sql="
					SELECT 
							 case when  COUNT(clickid) is null then '0' 
							 else COUNT(clickid) end clicks, dt,
							case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									AND HOUR(accesstime) <= '".$hours."'
									and userlog.serviceid=4
									) a
					GROUP BY dt , advname; 
				";
				
				//echo $sql;exit;
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
				/*if($b==1){
					echo "hi2";exit;
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}*/
				//print_r($dt);exit;
			//echo "hi";exit;
			}
			
			else if($operator=='bahrain_zain')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END  advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
						
					FROM
						fashionbardb_bh.userlog
					LEFT JOIN commondbbh.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
				GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='saudiarabia_zain')
			{
			
				  $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_timwezain.userlog inner join 
						commondbksazain.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
							and operator='zain'
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='uae_etisalat')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END  advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
						
					FROM
						fashionbardb_etisalat.userlog
					LEFT JOIN commondbetisalat.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
				GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='stc_ksa')
			{
			
				  $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_timwezain.userlog inner join 
						commondbksastc.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
							and operator='stc'
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='stc_ksa_weekly')
			{
			
				  $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_saweekly.userlog inner join 
						commondbsaweekly.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
							and operator='stc'
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='saudiarabia_zain_weekly')
			{
			
				  $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_saweekly.userlog inner join 
						commondbsaweekly.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
							and operator='zain'
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='mobily_ksa_weekly')
			{
			
				  $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_saweekly.userlog inner join 
						commondbsaweekly.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
							and operator='mobily'
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='southafricamtn')
			{
			
				  $sql="
					SELECT 
					DATE(accesstime) dt,
					COUNT(DISTINCT clickid) clicks,
					userlog.advertiserid advid,
					CASE
						WHEN advertiser_name IS NULL THEN 'OTHER'
						ELSE advertiser_name
					END advname,
					0 amt
				FROM
					".$db.".userlog
						INNER JOIN
					commondbza.advertiser ON userlog.advertiserid = advertiser.advertiserid
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND HOUR(accesstime) <= ".$hours."
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='southafricacellc')
			{
			
				  $sql="
					SELECT 
					DATE(accesstime) dt,
					COUNT(DISTINCT clickid) clicks,
					userlog.advertiserid advid,
					CASE
						WHEN advertiser_name IS NULL THEN 'OTHER'
						ELSE advertiser_name
					END advname,
					0 amt
				FROM
					".$db.".userlog
						INNER JOIN
					commondbza.advertiser ON userlog.advertiserid = advertiser.advertiserid
				WHERE
					accesstime >= '".$start_date."'
						AND accesstime <= '".$end_date."'
						AND HOUR(accesstime) <= ".$hours."
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='kwstc')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE 
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END  advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
						
					FROM
						fashionbardb_slakwstc.userlog
					LEFT JOIN commondbslakwstc.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
				GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='kwzain')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE 
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END  advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
						
					FROM
						fashionbardb_slakwzain.userlog
					LEFT JOIN commondbslakwzain.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
				GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='gr2')
			{
			
				  $sql="
					SELECT
					DATE(accesstime) dt,
					COUNT(DISTINCT clickid) clicks,
					userlog.advertiserid advid,
					CASE WHEN
					advertiser_name is null then 'OTHER'
					else
					advertiser_name
					END advname,
					0 amt
					FROM
					fashionbardb_greece.userlog inner join
					commondbgreece.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
					accesstime >='".$start_date."'
					AND accesstime <= '".$end_date."'
					AND HOUR(accesstime) <= ".$hours."
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			else if($operator=='netherland_netsmart')
			{
			
				  $sql="
					SELECT 
					COUNT(clickid) clicks, dt,case when advertiser_name is null then 'other'
					else advertiser_name
					end advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
					FROM
						".$db.".userlog
					left JOIN commondbnl.advertiser on advertiser.advertiserid = userlog.advertiserid
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='france')
			{
			
				  $sql="
					SELECT 
					COUNT(txnid) clicks, dt,case when advname is null then 'other'
					else advname
					end advname
					FROM
					(SELECT txnid, DATE(accesstime) dt, advname
					FROM
					".$db.".userlog
					left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
					WHERE
					accesstime >= '".$start_date."'
					AND accesstime <= '".$end_date."'
					AND HOUR(accesstime) <= '".$hours."' ) a
					GROUP BY dt , advname


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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			else if($operator=='norway')
			{
			
				  $sql="
					SELECT 
					COUNT(txnid) clicks, dt,case when advname is null then 'other'
					else advname
					end advname
					FROM
					(SELECT txnid, DATE(accesstime) dt, advname
					FROM
					".$db.".userlog
					left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
					WHERE
					accesstime >= '".$start_date."'
					AND accesstime <= '".$end_date."'
					AND HOUR(accesstime) <= '".$hours."' ) a
					GROUP BY dt , advname


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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
		
			
			else if($operator=='pk_telenor')
			{
			
				 $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									and advertiser.serviceid=1
									
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='pk_zong')
			{
			
				 $sql="
					SELECT 
							COUNT(clickid) clicks, dt,case when advname is null then 'other'
							else advname
							end advname
						FROM
							(SELECT 
								clickid, DATE(accesstime) dt, advname
							FROM
								".$dblog.".userlog
							left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
							WHERE
								accesstime >= '".$start_date."'
									AND accesstime <= '".$end_date."'
									and advertiser.serviceid=2
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			else if($operator=='all_greece')
			{
			
				  $sql="
					SELECT 
						COUNT(txnid) clicks,
							dt,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END advname
					FROM
						(SELECT 
						txnid, DATE(accesstime) dt, advname
					FROM
						gamebardb_greecevf.userlog
					LEFT JOIN gamebardb_greecevf.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='sweden')
			{
			
				 $sql="
					SELECT 
					COUNT(txnid) clicks,
					dt,
					CASE
					WHEN advname IS NULL THEN 'other'
					ELSE advname
					END advname
					FROM
					(SELECT 
					txnid, DATE(accesstime) dt, advname
					FROM
					gamebardb_swedentelenor.userlog
					LEFT JOIN gamebardb_swedentelenor.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
					accesstime >= '".$start_date."'
					AND accesstime <= '".$end_date."'
					AND HOUR(accesstime) <= '".$hours."') a
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			else if($operator=='Bangladesh_Robi')
			{
				$start_date=date('Y-m-d')." 00:00:00";
					$end_date=date('Y-m-d')." 23:59:59";	
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			else if($operator=='srilanka')
			{
			
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			else if($operator=='malaysia_cellcom')
			{
			
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			else if($operator=='myanmar')
			{
			
				 $sql="
					SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
							userlog.advertiserid,
							advertiser_name advname,
							0 amt
					FROM
						".$db.".userlog inner join 
						commondbmyanmar.advertiser on userlog.advertiserid=advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <=  '".$end_date."'
							AND HOUR(accesstime) <=  '".$hours."'
					GROUP BY dt , userlog.advertiserid;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
			
			
			
			
			
			else if($operator=='ooredoo_oman')
			{
				//$db='hotshotsnewdb_airtel_0717';
				//echo "hi";exit;
				  
				  
				 
				$sql="SELECT 
					COUNT(clickid) clicks,
					dt,
					CASE
						WHEN advertiser_name IS NULL THEN 'other'
						ELSE advertiser_name
					END advname
				FROM
					(SELECT 
						clickid, DATE(accesstime) dt, advertiser_name
					FROM
						fashionbardb_omooredoo.userlog
					LEFT JOIN commondbomooredoo.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ''".$hours."'') a
				GROUP BY dt , advertiser_name;";
				
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
				
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			}
		}
		else
		{
			//$c=1;
			
			if($b==1)
			{
				
				
				 $sql2="							
						select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='".$display."' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;
				";
				
				
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
			
			
			
				if($operator=='spain')
				{
				
					 $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}

				if($operator=='newthailand')
				{
				
					 $sql="
						SELECT 
						COUNT(DISTINCT userlog.clickid) clicks,
						advertiser_name advname,
						userlog.advertiserid advid,
						DATE(accesstime) dt
					FROM
						fashionbardb_glam9005thailand.userlog
							LEFT JOIN
						commondbthailand.newadvertiser ON userlog.advertiserid = newadvertiser.advertiserid
					WHERE
						accesstime > '".$start_date."'
							AND accesstime < '".$end_date."'
							AND HOUR(accesstime) < ".$hours."
					GROUP BY dt , advertiser_name;
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
				
				
				else if($operator=='southafricamtn')
				{
				
					  $sql="
						SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
						userlog.advertiserid advid,
						CASE
							WHEN advertiser_name IS NULL THEN 'OTHER'
							ELSE advertiser_name
						END advname,
						0 amt
					FROM
						".$db.".userlog
							INNER JOIN
						commondbzaglam.advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
				else if($operator=='southafricacellc')
				{
				
					  $sql="
						SELECT 
						DATE(accesstime) dt,
						COUNT(DISTINCT clickid) clicks,
						userlog.advertiserid advid,
						CASE
							WHEN advertiser_name IS NULL THEN 'OTHER'
							ELSE advertiser_name
						END advname,
						0 amt
					FROM
						".$db.".userlog
							INNER JOIN
						commondbzaglam.advertiser ON userlog.advertiserid = advertiser.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND HOUR(accesstime) <= ".$hours."
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
			
				
				else if($operator=='vodacom_wfh')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."'
										and userlog.serviceid=1
										) a
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
				else if($operator=='vodacom_all')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."'
										) a
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
				
				
				else if($operator=='vodacom_fg')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."'
										and userlog.serviceid=2
										) a
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
				
				
				else if($operator=='vodacom_bt')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."'
										and userlog.serviceid=3
									) a
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			//echo "hi";exit;
			}
			
				
				
				if($operator=='all_greece')
				{
				
					 $sql="
						SELECT 
						COUNT(txnid) clicks,
							dt,
							CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
							END advname
					FROM
						(SELECT 
						txnid, DATE(accesstime) dt, advname
					FROM
						glambardb_greecevf.userlog
					LEFT JOIN glambardb_greecevf.advertiser ON advertiser.advertiserid = userlog.advertiserid
					WHERE
						accesstime >= '".$start_date."'
							AND accesstime <='".$end_date."'
							AND HOUR(accesstime) <= '".$hours."') a
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
			
				else if($operator=='poland_teleaudio')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$advertiserdb.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."' ) a
						GROUP BY dt , advname; 
					";
					
					//echo $sql;exit;
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
			
			
				
				else if($operator=='poland')
				{
				
					  $sql="
						SELECT 
								COUNT(clickid) clicks, dt,case when advname is null then 'other'
								else advname
								end advname
							FROM
								(SELECT 
									clickid, DATE(accesstime) dt, advname
								FROM
									".$dblog.".userlog
								left JOIN ".$db.".advertiser on advertiser.advertiserid = userlog.advertiserid
								WHERE
									accesstime >= '".$start_date."'
										AND accesstime <= '".$end_date."'
										AND HOUR(accesstime) <= '".$hours."' ) a
						GROUP BY dt , advname; 
					";
					
					//echo $sql;exit;
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				//echo "hi";exit;
				}
			
			
				else if($operator=='thailand')
				{
				
					 $sql="
						select count(clickid)clicks,
						date(accesstime)dt,
						aa.advertiserid advid,
						CASE WHEN
						advertiser_name is null then 'OTHER'
						else
						advertiser_name 
						END advname
						from(SELECT DISTINCT
						clickid, accesstime,advertiserid
						FROM
						".$db.".userlog
						WHERE
						accesstime >= '".$start_date."'
						AND accesstime <='".$end_date."'
						and hour(accesstime)<=".$hours."

						)aa LEFT JOIN commondbthailand.advertiser ON aa.advertiserid = advertiser.advertiserid
						group by dt, advname;
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
					
					
				//echo "hi";exit;
				
				}
			
				
				
				
				
			}	
		}
	
	}
	elseif($display=='CBS')
	{
		if($product=='gamebar')
		{
			
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			if($operator=='Vodafone_Qatar')
			{
				
				
				
					 $sql= "SELECT 
						COUNT(DISTINCT clickid) CBS,
						DATE(advertdatetime) dt,
						CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
						END advname
					FROM
						fashionbardb_qatarvodafone.advertcallback
							INNER JOIN
						commondbqatarvodafone.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
					WHERE
						advertdatetime >= '".$start_date."'
							AND advertdatetime <= '".$end_date."'
							AND HOUR(advertdatetime) <= '".$hours."'
							AND advertresponse != 'stop'
					GROUP BY dt , advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='finland')
			{
				
				
				
					 $sql= "SELECT 
							COUNT(DISTINCT clickid) CBS,
							DATE(advertdatetime) dt,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname
						FROM
							fashionbardb_finland.advertcallback
								INNER JOIN
							commondbfinland.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
						WHERE
							advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."'
								AND HOUR(advertdatetime) <= ''".$hours."''
								AND advertresponse != 'stop'
						GROUP BY dt , advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='thailand')
			{
				
				
				
					 $sql= "SELECT 
						COUNT(DISTINCT advertcallback.clickid) CBS,
						advertiser_name advname,
						advertcallback.advertiserid advid,
						DATE(advertdatetime) dt
					FROM
						fashionbardb_game9305thailand.advertcallback
							LEFT JOIN
						commondbthailand.newadvertiser ON advertcallback.advertiserid = newadvertiser.advertiserid
					WHERE
						advertdatetime > '".$start_date."'
							AND advertdatetime < '".$end_date."'
							AND HOUR(advertdatetime) < '".$hours."'
							AND action = 'act'
							and advertresponse != 'stop'
					GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			if($operator=='vodafone_egypt')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				$start_date=date('Y-m-d')." 00:00:00";
				$end_date=date('Y-m-d')." 23:59:59";
					 $sql= "SELECT COUNT(msisdn) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.txnid,advertcallback.msisdn, DATE(senttime) dt,advname FROM
						 ".$db.".advertcallback 
						left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						senttime > '".$start_date."'
						AND senttime <= '".$end_date."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='Bangladesh_Robi')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(txnid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.txnid,DATE(senttime) dt,advname FROM
						".$db.".advertcallback
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						senttime > '".$start_date."'
						AND senttime <= '".$end_date."'
						
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='srilanka')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(txnid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.txnid,DATE(senttime) dt,advname FROM
						".$db.".advertcallback
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						senttime > '".$start_date."'
						AND senttime <= '".$end_date."'
						
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='malaysia_cellcom')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(txnid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.txnid,DATE(senttime) dt,advname FROM
						".$db.".advertcallback
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						senttime > '".$start_date."'
						AND senttime <= '".$end_date."'
						
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			else if($operator=='indonesia')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
				$start_date=date('Y-m-d')." 00:00:00";
				$end_date=date('Y-m-d')." 23:59:59";
					 $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='spain')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='all_ksa')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								advertcallback.advertiserid advid,
								DATE(advertdatetime) dt
							FROM
								fashionbardb_timwezain.advertcallback
									LEFT JOIN
								commondbtimwezain.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >'".$start_date."'
									AND advertdatetime < '".$end_date."'
								 AND HOUR(advertdatetime) < ".$hours."
									AND action = 'cg'
									AND advertresponse != 'stop'
							GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='all_ksa_weekly')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								advertcallback.advertiserid advid,
								DATE(advertdatetime) dt
							FROM
								fashionbardb_saweekly.advertcallback
									LEFT JOIN
								commondbsaweekly.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >'".$start_date."'
									AND advertdatetime < '".$end_date."'
									AND HOUR(advertdatetime) < ".$hours."
									AND action = 'cg'
									AND advertresponse != 'stop'
							GROUP BY dt , advertiser_name;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
		
			else if($operator=='srilanka_gamestore')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "call ".$db.".get_perform_cbs('".$start_date."','".$end_date."',".$hours.")";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			else if($operator=='bahrain_batelco')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "call ".$db.".get_perform_cbs_batelco('".$start_date."','".$end_date."',".$hours.")";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='cambodia')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "call ".$db.".get_perform_cbs('".$start_date."','".$end_date."',".$hours.")";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			else if($operator=='bahrain_stc')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "call ".$db.".get_perform_cbs_stc('".$start_date."','".$end_date."',".$hours.")";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			else if($operator=='ooredoo_oman')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
				$sql= "SELECT 
						COUNT(DISTINCT clickid) CBS,
						DATE(advertdatetime) dt,
						CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
						END advname
					FROM
						fashionbardb_omooredoo.advertcallback
							left JOIN
						commondbomooredoo.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
					WHERE
						advertdatetime >= '".$start_date."'
							AND advertdatetime <= '".$end_date."'
							AND HOUR(advertdatetime) <= ".$hours."
							AND advertresponse != 'stop'
					GROUP BY dt , advname;";
				//echo $sql;exit;
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = $dt2=array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
				
				//print_r($dt);exit;
				
			}
			
			
			
			
			
			
			else if($operator=='qatar_ooredoo')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname
							FROM
								fashionbardb_qatarooredoo.advertcallback
									INNER JOIN
								commondbqatarooredoo.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
							GROUP BY dt , advname;";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			else if($operator=='mobily_ksa')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					$sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								advertiser.advertiser_name advname
							FROM
								fashionbardb_timwezain.advertcallback
									INNER JOIN
								commondbtimwezain.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
									AND advertcallback.operator = 'mobily'
							GROUP BY dt , advname;
							";
					  //echo $sql;exit;	
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			else if($operator=='uae_du')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "call ".$db.".get_perform_cbs('".$start_date."','".$end_date."',".$hours.")";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			
			else if($operator=='oman_omantel')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
    COUNT(DISTINCT clickid) CBS,
    DATE(advertdatetime) dt,
    CASE
        WHEN advertiser_name IS NULL THEN 'other'
        ELSE advertiser_name
    END advname
FROM
    fashionbardb_omantel.advertcallback
        left JOIN
    commondbomantel.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
WHERE
    advertdatetime >= '".$start_date."'
        AND advertdatetime <= '".$end_date."'
        AND HOUR(advertdatetime) <= '".$hours."'
        AND advertresponse != 'stop'
GROUP BY dt , advname;";
				$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			
			else if($operator=='bahrain_zain')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "select count(distinct msisdn) CBS, date(advertdatetime)  dt, advertiser.advertiser_name advname from 
							fashionbardb_bh.advertcallback 
							inner join commondbbh.advertiser on advertcallback.advertiserid = advertiser.advertiserid
							where 
							advertdatetime >=  '".$start_date."'
							and advertdatetime <= '".$end_date."'
							AND HOUR(advertdatetime) <= '".$hours."'
							AND
							advertresponse != 'stop'  group by dt, advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			else if($operator=='vodacom_za')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						and callbackresponse.serviceid=4
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='uae_etisalat')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "select count(distinct clickid) CBS, date(advertdatetime)  dt, advertiser.advertiser_name advname from 
							fashionbardb_etisalat.advertcallback 
							inner join commondbetisalat.advertiser on advertcallback.advertiserid = advertiser.advertiserid
							where 
							advertdatetime >=  '".$start_date."'
							and advertdatetime <= '".$end_date."'
							AND HOUR(advertdatetime) <= '".$hours."'
							AND
							advertresponse != 'stop'  group by dt, advname;";
							//echo $sql;exit;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			else if($operator=='stc_ksa')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								advertiser.advertiser_name advname
							FROM
								fashionbardb_timwezain.advertcallback
									INNER JOIN
								commondbtimwezain.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
									AND advertcallback.operator = 'stc'
							GROUP BY dt , advname;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='stc_ksa_weekly')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								advertiser.advertiser_name advname
							FROM
								fashionbardb_saweekly.advertcallback
									INNER JOIN
								commondbsaweekly.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
									AND advertcallback.operator = 'stc'
							GROUP BY dt , advname;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='saudiarabia_zain_weekly')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								advertiser.advertiser_name advname
							FROM
								fashionbardb_saweekly.advertcallback
									INNER JOIN
								commondbsaweekly.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
									AND advertcallback.operator = 'zain'
							GROUP BY dt , advname;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='mobily_ksa_weekly')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
								COUNT(DISTINCT clickid) CBS,
								DATE(advertdatetime) dt,
								advertiser.advertiser_name advname
							FROM
								fashionbardb_saweekly.advertcallback
									INNER JOIN
								commondbsaweekly.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
							WHERE
								advertdatetime >= '".$start_date."'
									AND advertdatetime <= '".$end_date."'
									AND HOUR(advertdatetime) <= '".$hours."'
									AND advertresponse != 'stop'
									AND advertcallback.operator = 'mobily'
							GROUP BY dt , advname;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='saudiarabia_zain')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT 
							COUNT(DISTINCT clickid) CBS,
							DATE(advertdatetime) dt,
							advertiser.advertiser_name advname
						FROM
							fashionbardb_timwezain.advertcallback
								INNER JOIN
							commondbtimwezain.advertiser ON advertcallback.advertiserid = advertiser.advertiserid
						WHERE
							advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."'
								AND HOUR(advertdatetime) <= '".$hours."'
								AND advertresponse != 'stop'
								AND advertcallback.operator = 'zain'
						GROUP BY dt , advname;
						";
						//echo $sql;exit;
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='southafricamtn')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT
							COUNT(clickid) CBS,
							DATE(advertdatetime) dt,
							aa.advertiserid advid,
							CASE
							WHEN advertiser_name IS NULL THEN 'OTHER'
							ELSE advertiser_name
							END advname
							FROM
							(SELECT DISTINCT
							clickid, advertdatetime, advertcallback.advertiserid
							FROM
							fashionbardb_za.advertcallback
							WHERE
							advertdatetime >= '".$start_date."'
							AND advertdatetime <= '".$end_date."'
							AND advertresponse != 'stop'
							and operator='mtn'
							AND action = 'cg'
							AND HOUR(advertdatetime) <= '".$hours."') aa
							LEFT JOIN
							commondbza.advertiser ON aa.advertiserid = advertiser.advertiserid
							GROUP BY dt , advname; ";
//						echo $sql;exit;
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='southafricacellc')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT
							COUNT(clickid) CBS,
							DATE(advertdatetime) dt,
							aa.advertiserid advid,
							CASE
							WHEN advertiser_name IS NULL THEN 'OTHER'
							ELSE advertiser_name
							END advname
							FROM
							(SELECT DISTINCT
							clickid, advertdatetime, advertcallback.advertiserid
							FROM
							fashionbardb_za.advertcallback
							WHERE
							advertdatetime >= '".$start_date."'
							AND advertdatetime <= '".$end_date."'
							AND advertresponse != 'stop'
							and operator='cellc'
							AND action = 'cg'
							AND HOUR(advertdatetime) <= '".$hours."') aa
							LEFT JOIN
							commondbza.advertiser ON aa.advertiserid = advertiser.advertiserid
							GROUP BY dt , advname; ";
//						echo $sql;exit;
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='kwstc')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "select count(distinct clickid) CBS, 
								date(advertdatetime)  dt, 
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname from 
								fashionbardb_slakwstc.advertcallback 
								inner join commondbslakwstc.advertiser on advertcallback.advertiserid = advertiser.advertiserid
								where 
								advertdatetime >=  '".$start_date."'
								and advertdatetime <= '".$end_date."'
								AND HOUR(advertdatetime) <= '".$hours."'
								AND
								advertresponse != 'stop'  group by dt, advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			else if($operator=='kwzain')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "select count(distinct clickid) CBS, 
								date(advertdatetime)  dt, 
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname from 
								fashionbardb_slakwzain.advertcallback 
								inner join commondbslakwzain.advertiser on advertcallback.advertiserid = advertiser.advertiserid
								where 
								advertdatetime >=  '".$start_date."'
								and advertdatetime <= '".$end_date."'
								AND HOUR(advertdatetime) <= '".$hours."'
								AND
								advertresponse != 'stop'  group by dt, advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			else if($operator=='france')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(txnid) CBS, dt,case when advname is null then 'other' else advname end advname
				FROM (SELECT DISTINCT advertcallback.msisdn txnid, DATE(senttime) dt, advname FROM
				".$db.".advertcallback
				left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
				WHERE senttime > '".$start_date."'
				AND senttime <='".$end_date."'
				AND HOUR(senttime) <= ".$hours.") a group by dt,advname";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='norway')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(txnid) CBS, dt,case when advname is null then 'other' else advname end advname
				FROM (SELECT DISTINCT advertcallback.msisdn txnid, DATE(senttime) dt, advname FROM
				".$db.".advertcallback
				left JOIN ".$db.".advertiser on advertiser.advertiserid = advertcallback.advertiserid
				WHERE senttime > '".$start_date."'
				AND senttime <='".$end_date."'
				AND HOUR(senttime) <= ".$hours.") a group by dt,advname";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			else if($operator=='gr2')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "select count(clickid) CBS,
							date(advertdatetime) dt,
							aa.advertiserid advid,
							CASE WHEN
							advertiser_name is null then 'OTHER'
							else
							advertiser_name
							END advname
							from(
							SELECT
							distinct clickid, advertdatetime,advertcallback.advertiserid
							FROM
							fashionbardb_greece.advertcallback

							WHERE
							advertdatetime >= '".$start_date."'
							AND advertdatetime <= '".$end_date."'
							AND advertresponse != 'stop'
							AND advertresponse != ''
							AND action = 'act'
							and hour(advertdatetime)<= '".$hours."'

							)aa LEFT JOIN commondbgreece.advertiser ON aa.advertiserid = advertiser.advertiserid
							group by dt, advname;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
		
			
			else if($operator=='all_greece')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT 
								dt, SUM(CBS) CBS, advname
								FROM
								(SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								gamebardb_greecevf.advertcallback
								LEFT JOIN gamebardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= ".$hours.") vf
								GROUP BY dt , advname UNION ALL SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								gamebardb_greececosmote.advertcallback
								LEFT JOIN gamebardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= ".$hours.") cosmote
								GROUP BY dt , advname UNION ALL SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								gamebardb_greecewind.advertcallback
								LEFT JOIN gamebardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= ".$hours.") wind
								GROUP BY dt , advname) callbacksent
								GROUP BY dt , advname;";
								
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='sweden')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='pk_telenor')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						and callbackresponse.serviceid='06'
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='pk_zong')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						and callbackresponse.serviceid='04'
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
		
			
			else if($operator=='poland')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						callbackresponse.clickid,DATE(requesttime) dt,advname FROM
						".$db.".callbackresponse
						
						left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
						WHERE
						requesttime > '".$start_date."'
						AND requesttime <= '".$end_date."'
						and issent=1
						
						AND HOUR(requesttime) <= '".$hours."'
						
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			else if($operator=='myanmar')
			{
				
				//$db='hotshotsnewdb_voda_0617';
				//$dblog='hotshotsdblog1';
				
					 $sql= "SELECT 
							DATE(advertdatetime) dt,
							COUNT(DISTINCT clickid) CBS,
							advertcallback.advertiserid,
							advertiser_name advname,
							0 amt
							FROM
							".$db.".advertcallback inner join 
							commondbmyanmar.advertiser on advertcallback.advertiserid=advertiser.advertiserid
							WHERE
							advertdatetime >= '".$start_date."'
							AND advertdatetime <=  '".$end_date."'
							AND HOUR(advertdatetime) <=  '".$hours."'
							AND action = 'act'
							AND advertresponse != 'stop' 
							GROUP BY dt , advertcallback.advertiserid;";
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
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			
			
			
			
			
			else if($operator=='netherland_netsmart')
			{
				//$db='hotshotsnewdb_airtel_0717';
			
				
				$sql="
				 SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
					FROM
					(SELECT DISTINCT
						advertcallback.clickid,DATE(advertdatetime) dt,advertiser_name advname FROM
						".$db.".advertcallback
						
						left JOIN commondbnl.advertiser on advertiser.advertiserid = advertcallback.advertiserid
						WHERE
						advertdatetime >'".$start_date."'
						AND advertdatetime <= '".$end_date."'
						AND (advertresponse !='' and advertresponse !='stop' and advertresponse is not null)
						
						AND HOUR(advertdatetime) <= '".$hours."'
						
						) s
						GROUP BY dt ,advname;
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
				
				if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
			}
			
			
			}
			
		
		}
		else
		{
			//$c=1;
			
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
			
			
				if($operator=='spain')
				{
						
						//$db='hotshotsnewdb_voda_0617';
						//$dblog='hotshotsdblog1';
						
							 $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
							FROM
							(SELECT DISTINCT
								callbackresponse.clickid,DATE(requesttime) dt,advname FROM
								".$db.".callbackresponse
								
								left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
								WHERE
								requesttime > '".$start_date."'
								AND requesttime <= '".$end_date."'
								and issent=1
								
								AND HOUR(requesttime) <= '".$hours."'
								
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
						if($b==1){
						$advname=array_merge($advname,$advname2);
							$act=array_merge($act,$act2);
							$arrdt=array_merge($arrdt,$arrdt2);
							$advname=array_unique($advname);
							$dt=array_merge($dt,$dt2);
						}
					}
				
				if($operator=='newthailand')
				{
						
						//$db='hotshotsnewdb_voda_0617';
						//$dblog='hotshotsdblog1';
						
							 $sql= "SELECT 
								COUNT(DISTINCT advertcallback.clickid) CBS,
								advertiser_name advname,
								advertcallback.advertiserid advid,
								DATE(advertdatetime) dt
							FROM
								fashionbardb_glam9005thailand.advertcallback
									LEFT JOIN
								commondbthailand.newadvertiser ON advertcallback.advertiserid = newadvertiser.advertiserid
							WHERE
								advertdatetime > '".$start_date."'
									AND advertdatetime < '".$end_date."'
									AND HOUR(advertdatetime) < ".$hours."
									AND action = 'act'
									and advertresponse != 'stop'
							GROUP BY dt , advertiser_name;";
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
						if($b==1){
						$advname=array_merge($advname,$advname2);
							$act=array_merge($act,$act2);
							$arrdt=array_merge($arrdt,$arrdt2);
							$advname=array_unique($advname);
							$dt=array_merge($dt,$dt2);
						}
					}
				
				
				else if($operator=='southafricamtn')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT
								COUNT(clickid) CBS,
								DATE(advertdatetime) dt,
								aa.advertiserid advid,
								CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
								END advname
								FROM
								(SELECT DISTINCT
								clickid, advertdatetime, advertcallback.advertiserid
								FROM
								fashionbardb_zaglam.advertcallback
								WHERE
								advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."'
								AND advertresponse != 'stop'
								and operator='mtn'
								AND action = 'cg'
								AND HOUR(advertdatetime) <= '".$hours."') aa
								LEFT JOIN
								commondbzaglam.advertiser ON aa.advertiserid = advertiser.advertiserid
								GROUP BY dt , advname; ";
	//						echo $sql;exit;
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
				else if($operator=='southafricacellc')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT
								COUNT(clickid) CBS,
								DATE(advertdatetime) dt,
								aa.advertiserid advid,
								CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
								END advname
								FROM
								(SELECT DISTINCT
								clickid, advertdatetime, advertcallback.advertiserid
								FROM
								fashionbardb_zaglam.advertcallback
								WHERE
								advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."'
								AND advertresponse != 'stop'
								and operator='cellc'
								AND action = 'cg'
								AND HOUR(advertdatetime) <= '".$hours."') aa
								LEFT JOIN
								commondbzaglam.advertiser ON aa.advertiserid = advertiser.advertiserid
								GROUP BY dt , advname; ";
	//						echo $sql;exit;
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
				
					
				
				else if($operator=='vodacom_wfh')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
						FROM
						(SELECT DISTINCT
							callbackresponse.clickid,DATE(requesttime) dt,advname FROM
							".$db.".callbackresponse
							
							left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
							WHERE
							requesttime > '".$start_date."'
							AND requesttime <= '".$end_date."'
							and issent=1
							and callbackresponse.serviceid=1
							
							AND HOUR(requesttime) <= '".$hours."'
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				else if($operator=='vodacom_all')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
						FROM
						(SELECT DISTINCT
							callbackresponse.clickid,DATE(requesttime) dt,advname FROM
							".$db.".callbackresponse
							
							left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
							WHERE
							requesttime > '".$start_date."'
							AND requesttime <= '".$end_date."'
							and issent=1
							
							AND HOUR(requesttime) <= '".$hours."'
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				else if($operator=='vodacom_fg')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
						FROM
						(SELECT DISTINCT
							callbackresponse.clickid,DATE(requesttime) dt,advname FROM
							".$db.".callbackresponse
							
							left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
							WHERE
							requesttime > '".$start_date."'
							AND requesttime <= '".$end_date."'
							and issent=1
							and callbackresponse.serviceid=2
							
							AND HOUR(requesttime) <= '".$hours."'
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				
				else if($operator=='vodacom_bt')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
						FROM
						(SELECT DISTINCT
							callbackresponse.clickid,DATE(requesttime) dt,advname FROM
							".$db.".callbackresponse
							
							left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
							WHERE
							requesttime > '".$start_date."'
							AND requesttime <= '".$end_date."'
							and issent=1
							and callbackresponse.serviceid=3
							
							AND HOUR(requesttime) <= '".$hours."'
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				
				
				if($operator=='all_greece')
				{
						
						//$db='hotshotsnewdb_voda_0617';
						//$dblog='hotshotsdblog1';
						
							 $sql= "SELECT 
								dt, SUM(CBS) CBS, advname
								FROM
								(SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								glambardb_greecevf.advertcallback
								LEFT JOIN glambardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= 24) vf
								GROUP BY dt , advname UNION ALL SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								glambardb_greececosmote.advertcallback
								LEFT JOIN glambardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= '".$hours."') cosmote
								GROUP BY dt , advname UNION ALL SELECT 
								COUNT(msisdn) CBS,
								dt,
								CASE
								WHEN advname IS NULL THEN 'other'
								ELSE advname
								END advname
								FROM
								(SELECT DISTINCT
								advertcallback.msisdn, DATE(senttime) dt, advname
								FROM
								glambardb_greecewind.advertcallback
								LEFT JOIN glambardb_greecevf.advertiser ON advertiser.advertiserid = advertcallback.advertiserid
								WHERE
								senttime >'".$start_date."'
								AND senttime <= '".$end_date."'
								AND HOUR(senttime) <= '".$hours."') wind
								GROUP BY dt , advname) callbacksent
								GROUP BY dt , advname;";
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
						if($b==1){
						$advname=array_merge($advname,$advname2);
							$act=array_merge($act,$act2);
							$arrdt=array_merge($arrdt,$arrdt2);
							$advname=array_unique($advname);
							$dt=array_merge($dt,$dt2);
						}
					}
				
			
				else if($operator=='poland')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						  $sql= "SELECT COUNT(clickid) CBS, dt,case when advname is null then 'other' else advname end advname
						FROM
						(SELECT DISTINCT
							callbackresponse.clickid,DATE(requesttime) dt,advname FROM
							".$db.".callbackresponse
							
							left JOIN ".$db.".advertiser on advertiser.advertiserid = callbackresponse.advertiserid
							WHERE
							requesttime > '".$start_date."'
							AND requesttime <= '".$end_date."'
							and issent=1
							
							AND HOUR(requesttime) <= '".$hours."'
							
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				
				else if($operator=='poland_teleaudio')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
					
						  $sql= "select CBS,CONCAT(`advname`, ' ', `operator`) advname,dt from (
									SELECT 
										COUNT(clickid) CBS,
										dt,
										CASE
											WHEN advname IS NULL THEN 'other'
											ELSE advname
										END advname,
										operator
									FROM
										(SELECT DISTINCT
											callbackresponse.clickid, DATE(requesttime) dt, advname,operator
										FROM
											".$db.".callbackresponse
											inner join ".$db.".subscriber on subscriber.clickid=callbackresponse.clickid
										LEFT JOIN ".$advertiserdb.".advertiser ON advertiser.advertiserid = callbackresponse.advertiserid
										WHERE
											requesttime > '".$start_date."'
												AND requesttime <= '".$end_date."'
												AND issent = 1
												AND HOUR(requesttime) <= ".$hours." and operator !='') s
												
									GROUP BY dt , advname,operator)a";
							
							//echo $sql;exit;
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				
				
				
				else if($operator=='thailand')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "select count(clickid)CBS,
								date(advertdatetime)dt,
								aa.advertiserid advid,
								CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name 
								END advname
								from(
								SELECT 
										 distinct clickid, advertdatetime,advertcallback.advertiserid
									FROM
										".$db.".advertcallback
										
									WHERE 
										advertdatetime >= '".$start_date."'
										AND advertdatetime <= '".$end_date."'
										AND advertresponse != 'stop'
										AND advertresponse != ''
										AND action = 'act'
											and hour(advertdatetime)<= ".$hours."
											
								)aa LEFT JOIN commondbthailand.advertiser ON aa.advertiserid = advertiser.advertiserid
								group by dt, advname; ";
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
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
					}
				}
			
				
			}
		}
	}
	else if ($display=='trial')
	{
			if($product=='gamebar')
		{
			if($operator=='indonesia')
			{
				$c=1;
			}
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
				if($operator=='vodacom_za')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								CASE WHEN
								advname is null then 'OTHER'
								else
								advname
								END advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								left JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								and subscriber.serviceid=4
								AND charging_mode = 'trial'
								AND amount = 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;exit;
					
				
				}
				
				
				else if($operator=='uae_etisalat')
					{
						//$sql="call gamesdb_mobily_saudi.get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
						$sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								advertiser_name advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_etisalat.subscriber
									LEFT JOIN
								commondbetisalat.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
							 //echo $sql;exit;
						
					
						
						
					}
					
				
				if($operator=='pk_telenor')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								CASE WHEN
								advname is null then 'OTHER'
								else
								advname
								END advname,
								subscriber.advid,
								DATE(subsriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								left JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subsriptionstartdate > '".$start_date."'
								AND subsriptionstartdate < '".$end_date."'
								AND HOUR(subsriptionstartdate) <= ".$hours."
								
								AND charging_mode = 'trial'
								AND amount = 0
								GROUP BY dt , advname
						"; 
						// echo $sql;exit;
					
				
				}
				
				
				
			
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
						
						
							$act[$row['advname']]= $row['low'];	
						
						
						
						if(!in_array($row['advname'], $advname)) 
							$advname[] = $row['advname'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
			
			
			
			
					}
				
				
			
			}
			
		
		}
		else
		{
			//$c=1;
			
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
					if($operator=='vodacom_wfh')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=1
									AND charging_mode = 'trial'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							// echo $sql;exit;
						
					
					}
					
					
					if($operator=='vodacom_all')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND charging_mode = 'trial'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							// echo $sql;exit;
						
					
					}
					
					
					
					else if($operator=='vodacom_fg')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=2
									AND charging_mode = 'trial'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
					else if($operator=='vodacom_bt')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=3
									AND charging_mode = 'trial'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
				
				
				
			
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
						
						
							$act[$row['advname']]= $row['low'];	
						
						
						
						if(!in_array($row['advname'], $advname)) 
							$advname[] = $row['advname'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
			
			
			
			
					}
				
				
			
			
			
			
			
				
				
			}
		}

			
	}
	else if ($display=='Pin confirmed')
	{
				if($product=='gamebar')
				{
					
					if($operator=='stc_ksa')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_timwezain.subscriber
								LEFT JOIN
							commondbtimwezain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
								AND subscriber.operator = 'stc'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					else if($operator=='stc_ksa_weekly')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_saweekly.subscriber
								LEFT JOIN
							commondbsaweekly.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
								AND subscriber.operator = 'stc'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					else if($operator=='finland')
					{
					$sql="SELECT 
							COUNT(DISTINCT subscriber.clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_finland.subscriber
								LEFT JOIN
							commondbfinland.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'cg'
						GROUP BY dt , advertiser_name"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					else if($operator=='thailand')
					{
					$sql="SELECT 
							COUNT(DISTINCT subscriber.clickid) cg,
							advertiser_name advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt
						FROM
							fashionbardb_game9305thailand.subscriber
								LEFT JOIN
							commondbthailand.newadvertiser ON subscriber.advertiserid = newadvertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					
					else if($operator=='all_ksa')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_timwezain.subscriber
								LEFT JOIN
							commondbtimwezain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					else if($operator=='all_ksa_weekly')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_saweekly.subscriber
								LEFT JOIN
							commondbsaweekly.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					
					else if($operator=='mobily_ksa_weekly')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_saweekly.subscriber
								LEFT JOIN
							commondbsaweekly.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
								AND subscriber.operator = 'mobily'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					else if($operator=='saudiarabia_zain_weekly')
					{
					$sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_saweekly.subscriber
								LEFT JOIN
							commondbsaweekly.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
								AND subscriber.operator = 'zain'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					else if($operator=='saudiarabia_zain')
					{
						$sql="SELECT 
								COUNT(DISTINCT clickid) cg,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_timwezain.subscriber
									LEFT JOIN
								commondbtimwezain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >'".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'cg'
									AND subscriber.operator = 'zain'
							GROUP BY dt , advertiser_name;"; 
							 //echo $sql;
						
					
						
						
					}
					else if($operator=='bahrain_zain')
					{
						$sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) cg,
								advertiser_name advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_bh.subscriber
									LEFT JOIN
								commondbbh.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'freetrial'
							GROUP BY dt , advertiser_name"; 
							 //echo $sql;
						
					
						
						
					}
					
					else if($operator=='bahrain_stc')
					{
						$sql="call gamesdb_batelviva_bahrain.get_perform_pinconfirm_stc('".$start_date."','".$end_date."',".$hours.")"; 
							 //echo $sql;
						
					
						
						
					}
					else if($operator=='bahrain_batelco')
					{
						$sql="call gamesdb_batelviva_bahrain.get_perform_pinconfirm_batelco('".$start_date."','".$end_date."',".$hours.")"; 
							 //echo $sql;
						
					
						
						
					}
					
					
					
					else if($operator=='qatar_ooredoo')
					{
						$sql="SELECT 
								COUNT(DISTINCT msisdn) cg,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_qatarooredoo.subscriber
									LEFT JOIN
								commondbqatarooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
							 //echo $sql;
						
					
						
						
					}
					
					
					else if($operator=='oman_omantel')
					{
						$sql="SELECT 
								COUNT(DISTINCT msisdn) cg,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_omantel.subscriber
									LEFT JOIN
								commondbomantel.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < '".$hours."'
									AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
							 //echo $sql;
						
					
						
						
					}
					
					
					
					else if($operator=='ooredoo_oman')
					{
						$sql="SELECT 
							COUNT(DISTINCT msisdn) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_omooredoo.subscriber
								LEFT JOIN
							commondbomooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'cg'
						GROUP BY dt , advertiser_name;"; 
							 //echo $sql;
						
					
						
						
					}
					
					
					
					
					else if($operator=='uae_du')
					{
						$sql="call ".$db.".get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
							 //echo $sql;
						
					
						
						
					}
					else if($operator=='mobily_ksa')
					{
						 $sql="SELECT 
							COUNT(DISTINCT clickid) cg,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_timwezain.subscriber
								LEFT JOIN
							commondbtimwezain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >'".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'cg'
								AND subscriber.operator = 'mobily'
						GROUP BY dt , advertiser_name;"; 
					
						
						
					}
					
					else if($operator=='uae_etisalat')
					{
						//$sql="call gamesdb_mobily_saudi.get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
						$sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) cg,
								advertiser_name advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_etisalat.subscriber
									LEFT JOIN
								commondbetisalat.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate >= '".$start_date."'
									AND subscriptionstartdate <= '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
							//echo $sql;exit;
						
					
						
						
					}
					
					else if($operator=='sweden')
					{
						//$sql="call gamesdb_mobily_saudi.get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
						$sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) cg,
								case when advname is null then 'other' else advname end advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'pinverified'
								AND amount = 0
								GROUP BY dt , advname"; 
							//echo $sql;exit;
						
					
						
						
					}
					
					else if($operator=='kwstc')
					{
						//$sql="call gamesdb_mobily_saudi.get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
						$sql="SELECT 
								COUNT(DISTINCT subscriber.clickid) cg,
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_slakwstc.subscriber
									LEFT JOIN
								commondbslakwstc.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'freetrial'
							GROUP BY dt , advertiser_name"; 
							//echo $sql;exit;
						
					
						
						
					}
					
					else if($operator=='kwzain')
					{
						//$sql="call gamesdb_mobily_saudi.get_perform_pinconfirm('".$start_date."','".$end_date."',".$hours.")"; 
						$sql="SELECT 
							COUNT(DISTINCT subscriber.clickid) cg,
							CASE 
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END  advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_slakwzain.subscriber
								LEFT JOIN
							commondbslakwzain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'freetrial'
						GROUP BY dt , advertiser_name"; 
							//echo $sql;exit;
						
					
						
						
					}
					
				
				
				
				
					
					
					
					
					
					
					
				}
				else{
					
					if($operator=='newthailand')
					{
					$sql="SELECT 
							COUNT(DISTINCT subscriber.clickid) cg,
							advertiser_name advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt
						FROM
							fashionbardb_glam9005thailand.subscriber
								LEFT JOIN
							commondbthailand.newadvertiser ON subscriber.advertiserid = newadvertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'act'
						GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
					
					
				}
				
				
				
				
					$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['cg'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				/*if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
					print_r($dt);exit;*/
	}
	else if ($display=='sentcg')
	{
				if($product=='gamebar')
				{
					
					if($operator=='southafricamtn')
					{
					$sql="SELECT
							COUNT(DISTINCT clickid) cg,
							CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
							FROM
							fashionbardb_za.subscriber
							LEFT JOIN
							commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
							subscriptionstartdate >'".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND HOUR(subscriptionstartdate) < ".$hours."
							AND subscriber.operator = 'mtn'
							AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					if($operator=='southafricacellc')
					{
					$sql="SELECT
							COUNT(DISTINCT clickid) cg,
							CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
							FROM
							fashionbardb_za.subscriber
							LEFT JOIN
							commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
							subscriptionstartdate >'".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND HOUR(subscriptionstartdate) < ".$hours."
							AND subscriber.operator = 'cellc'
							AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
				
				
					
					
					
					
					
					
					
				}
				else{
					
				if($operator=='southafricamtn')
					{
					$sql="SELECT
							COUNT(DISTINCT clickid) cg,
							CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
							FROM
							fashionbardb_zaglam.subscriber
							LEFT JOIN
							commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
							subscriptionstartdate >'".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND HOUR(subscriptionstartdate) < ".$hours."
							AND subscriber.operator = 'mtn'
							AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					if($operator=='southafricacellc')
					{
					$sql="SELECT
							COUNT(DISTINCT clickid) cg,
							CASE
							WHEN advertiser_name IS NULL THEN 'other'
							ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
							FROM
							fashionbardb_zaglam.subscriber
							LEFT JOIN
							commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
							subscriptionstartdate >'".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND HOUR(subscriptionstartdate) < ".$hours."
							AND subscriber.operator = 'cellc'
							AND charging_mode = 'cg'
							GROUP BY dt , advertiser_name;"; 
						// echo $sql;exit;
					
				
					
					}
					
				
					
					
				}
				
				
				
				
					$res=mysqli_query($con11,$sql);
				
				$cnt = 0;
				$prevdate = "";
				$advname = [];
				$arrdt = [];
				$act = array();
				while($row=mysqli_fetch_array($res))
				{	
					if($prevdate == "")
						$prevdate = $row['dt'];
					
					if($prevdate != $row['dt'])
					{
						$dt[$prevdate]= $act;		
						$act = array();
						$prevdate = $row['dt'];
					}
					
					
						$act[$row['advname']]= $row['cg'];	
					
					
					
					if(!in_array($row['advname'], $advname)) 
						$advname[] = $row['advname'];

					if(!in_array($row['dt'], $arrdt)) 
						$arrdt[] = $row['dt'];		
					
				}
				$dt[$prevdate]= $act;
				/*if($b==1){
				$advname=array_merge($advname,$advname2);
					$act=array_merge($act,$act2);
					$arrdt=array_merge($arrdt,$arrdt2);
					$advname=array_unique($advname);
					$dt=array_merge($dt,$dt2);
				}
					print_r($dt);exit;*/
	}
	
	
	else{
		
		
		if($product=='gamebar')
		{
			if($operator=='indonesia')
			{
				$c=1;
				$b=0;
			}
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."'  group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
				if($operator=='pk_telenor')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
							COUNT(DISTINCT subscriber.clickid) low,
							advname,
							subscriber.advid,
							DATE(subsriptionstartdate) dt,
							SUM(amount) amt
							FROM
							".$db.".subscriber
							LEFT JOIN
							".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
							WHERE
							subsriptionstartdate > '".$start_date."'
							AND subsriptionstartdate < '".$end_date."'
							AND HOUR(subsriptionstartdate) <= '".$hours."'
							AND charging_mode = 'low'
							and mnc='06'
							AND amount = 0
							GROUP BY dt , advname";
					
				}
				else if($operator=='Vodafone_Qatar')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
								COUNT(DISTINCT subscriber.msisdn) low,
								CASE
										WHEN advertiser_name IS NULL THEN 'other'
										ELSE advertiser_name
									END advname,
									subscriber.advertiserid advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
								FROM
									fashionbardb_qatarvodafone.subscriber
										LEFT JOIN
									commondbqatarvodafone.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate > '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) < '".$hours."'
										AND charging_mode = 'low'
										AND amount = 0
								GROUP BY dt , advertiser_name";
					
				}
				
				
				else if($operator=='finland')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE
										WHEN advertiser_name IS NULL THEN 'other'
										ELSE advertiser_name
									END advname,
									subscriber.advertiserid advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
								FROM
									fashionbardb_finland.subscriber
										LEFT JOIN
									commondbfinland.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate > '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) < '".$hours."'
										AND charging_mode = 'low'
								GROUP BY dt , advertiser_name";
					
				}
				
				
				
				
				else if($operator=='pk_zong')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
							COUNT(DISTINCT subscriber.clickid) low,
							advname,
							subscriber.advid,
							DATE(subsriptionstartdate) dt,
							SUM(amount) amt
							FROM
							".$db.".subscriber
							LEFT JOIN
							".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
							WHERE
							subsriptionstartdate > '".$start_date."'
							AND subsriptionstartdate < '".$end_date."'
							AND HOUR(subsriptionstartdate) <= '".$hours."'
							AND charging_mode = 'low'
							and mnc='04'
							AND amount = 0
							GROUP BY dt , advname";
					
				}
				else if($operator=='kwzain')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE 
										WHEN advertiser_name IS NULL THEN 'other'
										ELSE advertiser_name
									END  advname,
									subscriber.advertiserid advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
								FROM
									fashionbardb_slakwzain.subscriber
										LEFT JOIN
									commondbslakwzain.advertiser ON subscriber.advertiserid = advertiser.advertiserid
								WHERE
									subscriptionstartdate > '".$start_date."'
										AND subscriptionstartdate < '".$end_date."'
										AND HOUR(subscriptionstartdate) < ".$hours."
										AND charging_mode = 'low'
										AND amount > 0
								GROUP BY dt , advertiser_name";
					
				}
				
				else if($operator=='kwstc')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								CASE 
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END  advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_slakwstc.subscriber
									LEFT JOIN
								commondbslakwstc.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'low'
									AND amount > 0
							GROUP BY dt , advertiser_name";
					
				}
				
				
				else if($operator=='spain')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								advname,
								subscriber.advid,
								DATE(subscriprion_startdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriprion_startdate > '".$start_date."'
								AND subscriprion_startdate < '".$end_date."'
								AND HOUR(subscriprion_startdate) <= ".$hours."
								AND charging_mode = 'low'
								AND amount = 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='poland')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								LEFT JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND charging_mode = 'low'
								AND amount = 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='bahrain_stc')
				{
					$sql="	call gamesdb_batelviva_bahrain.get_perform_lowbalance_stc('".$start_date."','".$end_date."',".$hours.")";
						 //echo $sql;
					
				
				}
				else if($operator=='bahrain_batelco')
				{
					$sql="	call gamesdb_batelviva_bahrain.get_perform_lowbalance_batelco('".$start_date."','".$end_date."',".$hours.")";
						 //echo $sql;
					
				
				}
				
				else if($operator=='ooredoo_oman')
				{
					$sql="SELECT 
							COUNT(DISTINCT msisdn) low,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_omooredoo.subscriber
								LEFT JOIN
							commondbomooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < '".$hours."'
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name;";
						 //echo $sql;
					
				
				}
				
				else if($operator=='qatar_ooredoo')
				{
					$sql="	SELECT 
							COUNT(DISTINCT msisdn) low,
							CASE
								WHEN advertiser_name IS NULL THEN 'other'
								ELSE advertiser_name
							END advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_qatarooredoo.subscriber
								LEFT JOIN
							commondbqatarooredoo.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'act'
								AND amount > 0
						GROUP BY dt , advertiser_name;";
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='uae_du')
				{
					$sql="	call ".$db.".get_perform_lowbalance('".$start_date."','".$end_date."',".$hours.")";
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='oman_omantel')
				{
					$sql="	SELECT 
								COUNT(DISTINCT msisdn) low,
								CASE
									WHEN advertiser_name IS NULL THEN 'other'
									ELSE advertiser_name
								END advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_omantel.subscriber
									LEFT JOIN
								commondbomantel.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < '".$hours."'
									AND charging_mode = 'act'
									AND amount > 0
							GROUP BY dt , advertiser_name;";
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='bahrain_zain')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.msisdn) low,
								advertiser_name advname,
								subscriber.advertiserid advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
							FROM
								fashionbardb_bh.subscriber
									LEFT JOIN
								commondbbh.advertiser ON subscriber.advertiserid = advertiser.advertiserid
							WHERE
								subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) < ".$hours."
									AND charging_mode = 'low'
									AND amount > 0
							GROUP BY dt , advertiser_name
						"; 
						 //echo $sql;
					
				
				}
				
				else if($operator=='vodacom_za')
				{
					$sql="							
								SELECT 
								COUNT(DISTINCT subscriber.clickid) low,
								CASE WHEN
								advname is null then 'OTHER'
								else
								advname
								END advname,
								subscriber.advid,
								DATE(subscriptionstartdate) dt,
								SUM(amount) amt
								FROM
								".$db.".subscriber
								left JOIN
								".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								and subscriber.serviceid=4
								AND charging_mode = 'low'
								AND amount = 0
								GROUP BY dt , advname
						"; 
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='stc_ksa')
				{
					$sql="							
								SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_timwezain.subscriber inner join 
							commondbksastc.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'low'
								and operator='stc'
							   
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				else if($operator=='stc_ksa_weekly')
				{
					$sql="							
								SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'low'
								and operator='stc'
							   
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				else if($operator=='mobily_ksa_weekly')
				{
					$sql="							
								SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'low'
								and operator='mobily'
							   
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				else if($operator=='saudiarabia_zain_weekly')
				{
					$sql="							
								SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
								subscriber.advertiserid advid,
								CASE WHEN
										advertiser_name is null then 'OTHER'
									else
										advertiser_name  
									END advname,
								0 amt
						FROM
							fashionbardb_saweekly.subscriber inner join 
							commondbsaweekly.advertiser on subscriber.advertiserid=advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <=".$hours."
								AND charging_mode = 'low'
								and operator='zain'
							   
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
				else if($operator=='zain_ksa')
				{
					$sql="							
								SELECT 
						DATE(subscriptionstartdate) dt,
						COUNT(DISTINCT clickid) low,
							subscriber.advertiserid advid,
							CASE WHEN
									advertiser_name is null then 'OTHER'
								else
									advertiser_name  
								END advname,
							0 amt
					FROM
						fashionbardb_timwezain.subscriber inner join 
						commondbksazain.advertiser on subscriber.advertiserid=advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND HOUR(subscriptionstartdate) <=".$hours."
							AND charging_mode = 'low'
							and operator='zain'
						   
					GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
				else if($operator=='southafricamtn')
				{
					$sql="							
							SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
							subscriber.advertiserid advid,
							CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
							END advname,
							0 amt
						FROM
							".$db.".subscriber
								INNER JOIN
							commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND charging_mode = 'low'
								AND subscriber.operator = 'mtn'
								AND amount = 0
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
				else if($operator=='southafricacellc')
				{
					$sql="							
							SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
							subscriber.advertiserid advid,
							CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
							END advname,
							0 amt
						FROM
							".$db.".subscriber
								INNER JOIN
							commondbza.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND charging_mode = 'low'
								AND subscriber.operator = 'cellc'
								AND amount = 0
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
				
				else if($operator=='uae_etisalat')
				{
					$sql="	SELECT 
							COUNT(DISTINCT subscriber.clickid) low,
							advertiser_name advname,
							subscriber.advertiserid advid,
							DATE(subscriptionstartdate) dt,
							SUM(amount) amt
						FROM
							fashionbardb_etisalat.subscriber
								LEFT JOIN
							commondbetisalat.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate > '".$start_date."'
								AND subscriptionstartdate < '".$end_date."'
								AND HOUR(subscriptionstartdate) < ".$hours."
								AND charging_mode = 'low'
								AND amount > 0
						GROUP BY dt , advertiser_name
						"; 
						 //echo $sql;
					
				
				}
				
				
				
				
				
				else if($operator=='gr2')
				{
					
					//$db='hotshotsnewdb_voda_0617';
					//$dblog='hotshotsdblog1';
					
						 $sql= "
						SELECT 
						DATE(subscriptionstartdate) dt,
						COUNT(DISTINCT subscriber.clickid) low,
						subscriber.advertiserid advid,
						CASE
							WHEN advertiser_name IS NULL THEN 'OTHER'
							ELSE advertiser_name
						END advname,
						0 amt
					FROM
						fashionbardb_greece.subscriber
							INNER JOIN
						fashionbardb_greece.userlog ON subscriber.clickid = userlog.clickid
							INNER JOIN
						commondbgreece.advertiser ON subscriber.advertiserid = advertiser.advertiserid
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate <= '".$end_date."'
							AND accesstime >= '".$start_date."'
							AND accesstime <= '".$end_date."'
							AND DATE(accesstime) = DATE(subscriptionstartdate)
							AND HOUR(subscriptionstartdate) <= ".$hours."
							AND charging_mode = 'low'
					GROUP BY dt , advname;
						
						";
					
				}
				
				else if($operator=='indonesia')
				{
					
				
						
					 
							 
						  $sql="							
								select count(low)low,advid,advname,dt,amt from(SELECT DISTINCT mo.clickid low,
								case when advname is null then 'other' else advname end advname,
									mo.advid,
									DATE(subscriptionstartdate) dt,
									sum(amount) amt
								 
								FROM
								gamebardb_indonesia.mo

								LEFT JOIN gamebardb_indonesia.advertiser ON mo.advid = advertiser.advertiserid
								WHERE
								subscriptionstartdate >'".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and charging_mode='ACT'
									AND amount = 0
									group by dt,clickid)b group by dt,advname
						"; 
						// echo $sql;exit;
					
				
					
				}
				
				
				
				
				
				
			
					$res=mysqli_query($con11,$sql);
					
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=mysqli_fetch_array($res))
					{	
						if($prevdate == "")
							$prevdate = $row['dt'];
						
						if($prevdate != $row['dt'])
						{
							$dt[$prevdate]= $act;		
							$act = array();
							$prevdate = $row['dt'];
						}
						
						
							$act[$row['advname']]= $row['low'];	
						
						
						
						if(!in_array($row['advname'], $advname)) 
							$advname[] = $row['advname'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
			
			
			
			
					}
				
				
			
			}
			
		
		}
		else
		{
			//$c=1;
			
			if($b==1)
			{
				
				//echo $display;exit;
				$sql2="select date,advertiser,hour,sum(count)sum from ".$report.".perform_report where date >='".$start_date1."' and date<='".$end_date1."' and type='cbs' and hour <= '".$hours."' and operator='".$operator."' and product='".$product."' group by advertiser,date;";
				//echo $sql2;
			
				$res2=mysql_query($sql2,$con1);
					$dt2=[];
					$cnt = 0;
					$prevdate = "";
					$advname2 = [];
					$arrdt2 = [];
					$act2 = array();
					while($row2=mysql_fetch_array($res2))
					{	
							
						if($prevdate == "")
							$prevdate = $row2['date'];
						
						if($prevdate != $row2['date'])
						{
							$dt2[$prevdate]= $act2;		
							$act = array();
							$prevdate = $row2['date'];
						}
						
						
						
						$act2[$prevdate][$row2['advertiser']]= $row2['sum'];	
						
						
						
						//$act[$row['advname']]= number_format($row['cr'],2);	
						
						if(!in_array($row2['advertiser'], $advname2)) 
							$advname2[] = $row2['advertiser'];

						if(!in_array($row2['date'], $arrdt2)) 
							$arrdt2[] = $row2['date'];		
						
						
					}
					$dt2= $act2;
				
			}
			
			if($c==1)
			{
				
					//	$start_date=date('Y-m-d')." 00:00:00";
					//	$end_date=date('Y-m-d')." 23:59:59";
			
					if($operator=='spain')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									advname,
									subscriber.advid,
									DATE(subscriprion_startdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									LEFT JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriprion_startdate > '".$start_date."'
									AND subscriprion_startdate < '".$end_date."'
									AND HOUR(subscriprion_startdate) <= ".$hours."
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
				
				
					
					else if($operator=='southafricamtn')
				{
					$sql="							
							SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
							subscriber.advertiserid advid,
							CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
							END advname,
							0 amt
						FROM
							".$db.".subscriber
								INNER JOIN
							commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND charging_mode = 'low'
								AND subscriber.operator = 'mtn'
								AND amount = 0
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
				else if($operator=='southafricacellc')
				{
					$sql="							
							SELECT 
							DATE(subscriptionstartdate) dt,
							COUNT(DISTINCT clickid) low,
							subscriber.advertiserid advid,
							CASE
								WHEN advertiser_name IS NULL THEN 'OTHER'
								ELSE advertiser_name
							END advname,
							0 amt
						FROM
							".$db.".subscriber
								INNER JOIN
							commondbzaglam.advertiser ON subscriber.advertiserid = advertiser.advertiserid
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND HOUR(subscriptionstartdate) <= ".$hours."
								AND charging_mode = 'low'
								AND subscriber.operator = 'cellc'
								AND amount = 0
						GROUP BY dt , advname;
						"; 
						 //echo $sql;
					
				
				}
				
					
				
					
					else if($operator=='vodacom_wfh')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=1
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
					else if($operator=='vodacom_all')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
					
					else if($operator=='vodacom_fg')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=2
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
					else if($operator=='vodacom_bt')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									CASE WHEN
									advname is null then 'OTHER'
									else
									advname
									END advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									left JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									and subscriber.serviceid=3
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
				
					else if($operator=='poland')
					{
						$sql="							
									SELECT 
									COUNT(DISTINCT subscriber.clickid) low,
									advname,
									subscriber.advid,
									DATE(subscriptionstartdate) dt,
									SUM(amount) amt
									FROM
									".$db.".subscriber
									LEFT JOIN
									".$db.".advertiser ON subscriber.advid = advertiser.advertiserid
									WHERE
									subscriptionstartdate > '".$start_date."'
									AND subscriptionstartdate < '".$end_date."'
									AND HOUR(subscriptionstartdate) <= ".$hours."
									AND charging_mode = 'low'
									AND amount = 0
									GROUP BY dt , advname
							"; 
							 //echo $sql;
						
					
					}
					
			
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
						
						
							$act[$row['advname']]= $row['low'];	
						
						
						
						if(!in_array($row['advname'], $advname)) 
							$advname[] = $row['advname'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
					if($b==1){
					$advname=array_merge($advname,$advname2);
						$act=array_merge($act,$act2);
						$arrdt=array_merge($arrdt,$arrdt2);
						$advname=array_unique($advname);
						$dt=array_merge($dt,$dt2);
			
			
			
			
					}
				
				
			
			
			
			
			
				
				
			}
		}
	}
	
		
		
		
		
}
	
	

if($c!=1){
		$dt=$dt2;
		$advname=$advname2;
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
						<select name="product" class="form-control" id="product" onchange="myfun()">
							<option>Product</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glambar</option>
							
						</select>		
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<?php
						if($product == 'glambar')
						{ ?>
							<option>Operator</option>
							<option value="all_greece" <?php if($operator=='all_greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_All D</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_TMobile</option>
							<option value="poland_teleaudio" <?php if($operator=='poland_teleaudio'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_Teleaudio</option>
							<option value="southafricacellc" <?php if($operator=='southafricacellc'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Cellc</option>
							<option value="southafricamtn" <?php if($operator=='southafricamtn'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Mtn</option>
							<option value="vodacom_all" <?php if($operator=='vodacom_all'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_All</option>
							
							<option value="vodacom_wfh" <?php if($operator=='vodacom_wfh'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Wfh</option>
							<option value="vodacom_fg" <?php if($operator=='vodacom_fg'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Fg</option>
							<option value="vodacom_bt" <?php if($operator=='vodacom_bt'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Bt</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain_Vodafone</option>
							<option value="thailand" <?php if($operator=='thailand'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand</option>
							<option value="newthailand" <?php if($operator=='newthailand'){$selected='selected';}else{$selected='';} echo $selected; ?> >New_Thailand</option>
							
							
							
							

							
						<?php
						}
						else if($product == 'gamebar'){
						?>
							<option value="bahrain_batelco" <?php if($operator=='bahrain_batelco'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_Batelco</option>
							<option value="bahrain_stc" <?php if($operator=='bahrain_stc'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_Stc</option>
							<option value="bahrain_zain" <?php if($operator=='bahrain_zain'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bahrain_zain</option>
							<option value="Bangladesh_Robi" <?php if($operator=='Bangladesh_Robi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bangladesh_Robi</option>
							<option value="cambodia" <?php if($operator=='cambodia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Cambodia</option>
							
							<option value="vodafone_egypt" <?php if($operator=='vodafone_egypt'){$selected='selected';}else{$selected='';} echo $selected; ?> >Egypt</option>
							<option value="finland" <?php if($operator=='finland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Finland</option>
							<option value="france" <?php if($operator=='france'){$selected='selected';}else{$selected='';} echo $selected; ?> >France</option>
							<option value="all_greece" <?php if($operator=='all_greece'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_All D</option>
							<option value="gr2" <?php if($operator=='gr2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Greece_N</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?>>Indonesia</option>
							<option value="all_ksa" <?php if($operator=='all_ksa'){$selected='selected';}else{$selected='';} echo $selected; ?>>KSA_All</option>
							<option value="mobily_ksa" <?php if($operator=='mobily_ksa'){$selected='selected';}else{$selected='';} echo $selected; ?>>KSA_Mobily</option>
							<option value="stc_ksa" <?php if($operator=='stc_ksa'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Stc</option>
							<option value="saudiarabia_zain" <?php if($operator=='saudiarabia_zain'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Zain</option>
							<option value="all_ksa_weekly" <?php if($operator=='all_ksa_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?>>KSA_All_Weekly</option>
							
							<option value="mobily_ksa_weekly" <?php if($operator=='mobily_ksa_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?>>KSA_Mobily_weekly</option>
							<option value="stc_ksa_weekly" <?php if($operator=='stc_ksa_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Stc_weekly</option>
							<option value="saudiarabia_zain_weekly" <?php if($operator=='saudiarabia_zain_weekly'){$selected='selected';}else{$selected='';} echo $selected; ?> >KSA_Zain_weekly</option>
							
							<option value="kwstc" <?php if($operator=='kwstc'){$selected='selected';}else{$selected='';} echo $selected; ?> >KW_STC</option>
							<option value="kwzain" <?php if($operator=='kwzain'){$selected='selected';}else{$selected='';} echo $selected; ?> >KW_Zain</option>
							<option value="malaysia_cellcom" <?php if($operator=='malaysia_cellcom'){$selected='selected';}else{$selected='';} echo $selected; ?> >Malaysia_Cellcom</option>
							<option value="myanmar" <?php if($operator=='myanmar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Myanmar_Telenor</option>
							<option value="netherland_netsmart" <?php if($operator=='netherland_netsmart'){$selected='selected';}else{$selected='';} echo $selected; ?> >Netherland_N</option>
							<option value="norway" <?php if($operator=='norway'){$selected='selected';}else{$selected='';} echo $selected; ?> >Norway</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Oman_Ooredoo</option>
							<option value="oman_omantel" <?php if($operator=='oman_omantel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Oman_Omantel</option>
							
							<option value="pk_telenor" <?php if($operator=='pk_telenor'){$selected='selected';}else{$selected='';} echo $selected; ?> >Pakistan_Telenor</option>
							<option value="pk_zong" <?php if($operator=='pk_zong'){$selected='selected';}else{$selected='';} echo $selected; ?> >Pakistan_Zong</option>
							<option value="poland" <?php if($operator=='poland'){$selected='selected';}else{$selected='';} echo $selected; ?> >Poland_TMobile</option>
							<option value="qatar_ooredoo" <?php if($operator=='qatar_ooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Qatar_Ooredoo</option>
							<option value="Vodafone_Qatar" <?php if($operator=='Vodafone_Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Qatar_Vodafone</option>
							<option value="southafricacellc" <?php if($operator=='southafricacellc'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Cellc</option>
							<option value="southafricamtn" <?php if($operator=='southafricamtn'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Mtn</option>
							<option value="vodacom_za" <?php if($operator=='vodacom_za'){$selected='selected';}else{$selected='';} echo $selected; ?> >SouthAfrica_Vodacom</option>
							<option value="spain" <?php if($operator=='spain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spain_Vodafone</option>
							<option value="srilanka" <?php if($operator=='srilanka'){$selected='selected';}else{$selected='';} echo $selected; ?> >Srilanka_Apigate</option>
							<option value="srilanka_gamestore" <?php if($operator=='srilanka_gamestore'){$selected='selected';}else{$selected='';} echo $selected; ?> >Srilanka_Dialog</option>
							<option value="sweden" <?php if($operator=='sweden'){$selected='selected';}else{$selected='';} echo $selected; ?> >Sweden</option>
							<option value="uae_etisalat" <?php if($operator=='uae_etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?> >UAE_Etisalat</option>
							<option value="uae_du" <?php if($operator=='uae_du'){$selected='selected';}else{$selected='';} echo $selected; ?> >UAE_DU</option>
							<option value="thailand" <?php if($operator=='thailand'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand</option>

							

							
						<?php
						}
						else{
						?>
						<option>Operator</option>
						<?php
						}
						
						?>					
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date1!=''){echo date('d-m-Y',strtotime($start_date1));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date1!=''){echo date('d-m-Y',strtotime($end_date1));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
								<select name="display" class="form-control">
									
									<option value="Count" <?php $selected=''; if($display=='Count') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Count</option>
									<option value="Amount" <?php  $selected=''; if($display=='Amount') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Amount</option>
									<option value="ARPU" <?php  $selected=''; if($display=='ARPU') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>ARPU</option>
									<!--<option value="CR" <?php // $selected=''; if($display=='CR') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callback Rate</option>-->
									<option value="CBS" <?php  $selected=''; if($display=='CBS') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callback Sent</option>
									<option value="Clicks" <?php  $selected=''; if($display=='Clicks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Clicks</option>
									<option value="low" <?php  $selected=''; if($display=='low') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Low-Balance</option>
									<option value="trial" <?php  $selected=''; if($display=='trial') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Trial</option>
									<option value="Pin confirmed" <?php  $selected=''; if($display=='Pin confirmed') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Pin confirmed</option>
									<option value="sentcg" <?php  $selected=''; if($display=='sentcg') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Sent to CG</option>
								
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
									
																
									<?php  
									//print_r($dt);exit;

									foreach($dt as $key=>$val) { ?>
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
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>
<script type="text/javascript">
function myfun() {
	var x = document.getElementById("product").value;
    //alert(x);
	if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Greece_All D', 'all_greece');
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Poland_Teleaudio', 'poland_teleaudio');
		select.options[select.options.length] = new Option('SouthAfrica_Cellc', 'southafricacellc');
		select.options[select.options.length] = new Option('SouthAfrica_Mtn', 'southafricamtn');
		select.options[select.options.length] = new Option('SouthAfrica_All', 'vodacom_all');
		select.options[select.options.length] = new Option('SouthAfrica_Wfh', 'vodacom_wfh');
		select.options[select.options.length] = new Option('SouthAfrica_Fg', 'vodacom_fg');
		select.options[select.options.length] = new Option('SouthAfrica_Bt', 'vodacom_bt');
		select.options[select.options.length] = new Option('Spain_Vodafone', 'spain');
		select.options[select.options.length] = new Option('Thailand', 'thailand');
		select.options[select.options.length] = new Option('New_Thailand', 'newthailand');
		
		
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Bahrain_Batelco', 'bahrain_batelco');
		select.options[select.options.length] = new Option('Bahrain_STC', 'bahrain_stc');
		select.options[select.options.length] = new Option('Bahrain_Zain', 'bahrain_zain');
		select.options[select.options.length] = new Option('Bangladesh_Robi', 'Bangladesh_Robi');
		select.options[select.options.length] = new Option('Cambodia', 'cambodia');
		
		select.options[select.options.length] = new Option('Egypt', 'vodafone_egypt');
		select.options[select.options.length] = new Option('Finland', 'finland');
		
		select.options[select.options.length] = new Option('France', 'france');
		select.options[select.options.length] = new Option('Greece_N', 'gr2');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('KSA_All', 'all_ksa');
		
		select.options[select.options.length] = new Option('KSA_Mobily', 'mobily_ksa');
		
		select.options[select.options.length] = new Option('KSA_STC', 'stc_ksa');
		select.options[select.options.length] = new Option('KSA_Zain', 'saudiarabia_zain');
		select.options[select.options.length] = new Option('KSA_All_Weekly', 'all_ksa_weekly');
		
		select.options[select.options.length] = new Option('KSA_Mobily_weekly', 'mobily_ksa_weekly');
		
		select.options[select.options.length] = new Option('KSA_STC_weekly', 'stc_ksa_weekly');
		select.options[select.options.length] = new Option('KSA_Zain_weekly', 'saudiarabia_zain_weekly');
		
		select.options[select.options.length] = new Option('KW_STC', 'kwstc');
		select.options[select.options.length] = new Option('KW_Zain', 'kwzain');
		
		select.options[select.options.length] = new Option('Malaysia_Cellcom', 'malaysia_cellcom');
		select.options[select.options.length] = new Option('Myanmar_Telenor', 'myanmar');
		select.options[select.options.length] = new Option('Netherland_N', 'netherland_netsmart');
		select.options[select.options.length] = new Option('Norway', 'norway');
		select.options[select.options.length] = new Option('Oman_Ooredoo', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Oman_Omantel', 'oman_omantel');
		
		select.options[select.options.length] = new Option('Pakistan_Telenor', 'pk_telenor');
		select.options[select.options.length] = new Option('Pakistan_Zong', 'pk_zong');
		select.options[select.options.length] = new Option('Poland_TMobile', 'poland');
		select.options[select.options.length] = new Option('Qatar_Ooredoo', 'qatar_ooredoo');
		select.options[select.options.length] = new Option('Qatar_Vodafone', 'Vodafone_Qatar');
		
		//select.options[select.options.length] = new Option('SaudiArabia_Zain', 'saudiarabia_zain');
		select.options[select.options.length] = new Option('SouthAfrica_Cellc', 'southafricacellc');
		select.options[select.options.length] = new Option('SouthAfrica_Mtn', 'southafricamtn');
		select.options[select.options.length] = new Option('SouthAfrica_Vodacom', 'vodacom_za');
		select.options[select.options.length] = new Option('Spain_Vodafone', 'spain');
		select.options[select.options.length] = new Option('Srilanka_Apigate', 'srilanka');
		select.options[select.options.length] = new Option('Srilanka_Dialog', 'srilanka_gamestore');
		select.options[select.options.length] = new Option('Sweden', 'sweden');
		select.options[select.options.length] = new Option('UAE_Etisalat', 'uae_etisalat');
		select.options[select.options.length] = new Option('UAE_DU', 'uae_du');
		select.options[select.options.length] = new Option('Thailand', 'thailand');
		

		
		
	}
	
	/*if(x=="glambar")
	{
		 //alert("hi");
	document.getElementById('azharbeizan').style.visibility = 'hidden';
	}else
	{
		document.getElementById('azharbeizan').style.visibility = 'visible';
	}*/
}
</script>		
