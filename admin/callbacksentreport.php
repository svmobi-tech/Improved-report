<?php

ini_set('max_execution_time', 6000);

//include("includes/check_session.php");
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);
$con=new mysqli("10.125.1.51","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.125.1.51","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2





//$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1

$con1=$con;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$cc=0;
if(isset($_POST['submit']))
{

$count=1;
$operator=$_POST['operator'];
$product=$_POST['product'];
$date1=date('Y-m-d');
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
   $advertiserid=$_POST['advertiserid']; 
//echo $operator;

// report logic below
	if($product=='glambar' || $product=='glambar')
	{
		if($operator=='southafrica')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='idea')
		{
			$db="glamourworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='southafrica_intarget')
		{
			$db="glambardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="glambardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='thailand_svobi')
		{
			$db="fashionbardb_thailand_0218";
			$report="gamebardb_vodafone_qatar_report";
		/*	$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);*/
		}
		else if($operator=='vodafone')
		{
			$db="glamourworld_voda";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=1 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='bsnl_india')
		{
			$db="bsnlfashionbar";
			$report="gamebardb_vodafone_qatar_report";
			 $sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3   group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='airtel_india')
		{
			
			$db="funzonedb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='portugal')
		{
			
			$db="fashionbardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_biline')
		{
			
			$db="glambardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="glambardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
	}
	else
	{
		//echo $operator;exit;
		if($operator=='du_dubai')
		{
			
			$db="gamesdb_uaedu";
			$report="gamebardb_vodafone_qatar_report";
			$dblog="gamesdblog_uaedu";
			
			$sql_ad="select * from ".$dblog.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		
		else if($operator=='Vodafone_Qatar')
		{
			
			$db="gamebardb_vodafone_qatar";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='egypt')
		{
			
			$db="gamebardb_vodafone_egypt";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='indonesia')
		{
			
			$db="gamebardb_indonesia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='portugal')
		{
			
			$db="gamebardb_portugal";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='kenya_oxygen')
		{
			$db="gamebardb_kenya";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		elseif($operator=='ooredoo_oman')
		{
			$db="gamesdb_ooredoo_oman";
			$dblog="gamesdblog_ooredoo_oman";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		elseif($operator=='malaysia_cellcom')
		{
			$db="gamesdbnew_celcom_malaysia";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='idea')
		{
			$db="gamesworld_idea";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=2 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='vodafone')
		{
			$db="gamesworld_voda";
			$report="gamebardb_vodafone_qatar_report";
			
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=1 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
			
		}
		else if($operator=='bsnl_india')
		{
			$db="bsnlgamebar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select distinct(aggregator) advertiserid,aggregator_name advname from aggregator_common.aggregators  where operator=3 group by aggregator";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='south-africa')
		{
			
			$db="fashionbardb_africa";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='airtel_india')
		{
			
			$db="gamebardb_airtel";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			$dblog='gamebarbardb_africa';
			
			$sql_ad="select * from ".$db.".advertiser where operator=1 ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		elseif($operator=='ooredoo_qatar')
		{
			$db="gamesdb_ooredoo_qatar";
			$dblog="gamesdblog_ooredoo_qatar";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$dblog.".advertiser ";
			$res_ad=mysqli_query($con1,$sql_ad);
			
		}
		else if($operator=='southafrica_intarget')
		{
			$db="gamebardb_southafrica";
			$report="gamebardb_vodafone_qatar_report";
			$sql_ad="select * from ".$db.".advertiser ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_biline')
		{
			
			$db="gamebardb_beeline";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
		else if($operator=='rusia_tele2')
		{
			
			$db="gamebardb_tele2";
			$report="gamebardb_vodafone_qatar_report";
			//$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$db.".advertiser  ";
			$res_ad=mysqli_query($con,$sql_ad);
		}
	
	}

	
	$data['startdate']=$start_date;
	$data['enddate']=$end_date;
	$data['db']=$db;
	//$data['dblog']=$dblog;
	$data['advertiser']=$advertiserid;
	//echo $operator;exit;

	if($operator=='Vodafone_Qatar')
	{//vodafone
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
		
		}
	}
	
	else if($operator=='southafrica_intarget')
	{
		if($product=='glambar' || $product=='Glambar')
		{
			
		}
		else{
			
			
			
		}
	}
	
	if($operator=='rusia_biline')
	{
		if($product=='glambar' || $product=='Glambar')
		{
			
		}
		else{
			
			
		}
	}
	
	
	else if($operator=='rusia_tele2')
	{
	}
	
	
	if($operator=='egypt')
	{//egypt
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
		}
		
	}
	
	else if($operator=='du_dubai')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
		}
		
	}
	
	else if($operator=='ooredoo_oman')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		}
		
	}
	else if($operator=='malaysia_cellcom')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
		}
		
	}
	
	else if($operator=='south-africa')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			
		}
	}
	
	
	else if($operator=='kenya_oxygen')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
		}
	}
	
	
	else if($operator=='indonesia')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		}
		else{
			
			
		}
	}
	
	else if($operator=='thailand_svobi')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			//NONE
		
		}
		else{
			
			 /* $sql="SELECT 
						dt,
						SUM(clicks) clicks,
						SUM(cbr) cg,
						SUM(low) park,
						SUM(act) act,
						SUM(ren) ren,
						SUM(dct) churn,
						SUM(cbs) cbsent,
						sum(low)Low
					FROM
						(SELECT 
							COUNT(clickid) clicks,
								0 cbr,
								DATE(accesstime) dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT DISTINCT
							clickid, accesstime
						FROM
							".$db.".userlog
						WHERE
							accesstime >= '".$start_date."'
								AND accesstime <= '".$end_date."') a
						GROUP BY dt UNION SELECT 
							0 clicks,
								COUNT(clickid) cbr,
								DATE(subscriptionstartdate) dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, subscriptionstartdate, charging_mode
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."') a
						WHERE
							charging_mode = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(subscriptionstartdate) dt,
								COUNT(clickid) dct,
								0 cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, subscriptionstartdate, charging_mode
						FROM
							".$db.".subscriber
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."') a
						WHERE
							charging_mode = 'dct') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(advertdatetime) dt,
								0 dct,
								COUNT(clickid) cbs,
								0 act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, advertdatetime, advertresponse, action
						FROM
							".$db.".advertcallback
						WHERE
							advertdatetime >= '".$start_date."'
								AND advertdatetime <= '".$end_date."') a
						WHERE
							advertresponse != 'stop'
								AND advertresponse != ''
								AND action = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(downloaddatetime) dt,
								0 dct,
								0 cbs,
								COUNT(*) act,
								0 ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							clickid, downloaddatetime, status_code, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							status_code = 'ok'
								AND charging_mode = 'act') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								DATE(downloaddatetime) dt,
								0 dct,
								0 cbs,
								0 act,
								COUNT(*) ren,
								0 low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							msisdn, downloaddatetime, status_code, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							status_code = 'ok'
								AND charging_mode = 'ren') b
						GROUP BY dt UNION SELECT 
							0 clicks,
								0 cbr,
								dt,
								0 dct,
								0 cbs,
								0 act,
								0 ren,
								COUNT(*) low
						FROM
							(SELECT 
							*
						FROM
							(SELECT DISTINCT
							msisdn, DATE(downloaddatetime) dt, charging_mode
						FROM
							".$db.".downloaddr
						WHERE
							downloaddatetime >= '".$start_date."'
								AND downloaddatetime <= '".$end_date."') a
						WHERE
							charging_mode = 'low') b
						GROUP BY dt) b
					GROUP BY dt;";*/
					$cc=2;
					$res=mysqli_query($con1,$sql) or die(mysqli_error());
			
			
		}
	}
	
	
	
	else if($operator=='portugal')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
		
		}
		else{
			
			
		}
	}
	
	else if($operator=='airtel_india')
	{
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
		}
		else{
			
			
		}
		
	}
	
	elseif($operator=='ooredoo_qatar')
	{
		
		if($product=='gamebar' || $product=='gamebar')
		{
			
			
				
		}
		else{
			
			
		}
		
	}
}




//echo $count;exit;
$fields=mysqli_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";
$start_date2=$_POST['start_date'];
$end_date2=$_POST['end_date'];

	//					exit;

}
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
                    <h2>Search Report <small>Clicks, Activation, Deactivation, Churn, Amount, Revenue</small></h2>
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
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Oxygen</option>
							<option value="southafrica_intarget" <?php if($operator=='southafrica_intarget'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Intarget</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_India</option>
							<option value="idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?> >Idea_India</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Airtel_India
							</option>
							<!--<option value="bsnl_india" <?php //if($operator=='bsnl_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bsnl_India
							</option>-->
							<option value="kenya_oxygen" <?php if($operator=='kenya_oxygen'){$selected='selected';}else{$selected='';} echo $selected; ?> >Kenya_Oxygen
							</option>
							<option value="thailand_svobi" <?php if($operator=='thailand_svobi'){$selected='selected';}else{$selected='';} echo $selected; ?> >Thailand
							</option>
							<option value="portugal" <?php if($operator=='portugal'){$selected='selected';}else{$selected='';} echo $selected; ?> >Portugal</option>
							<option value="rusia_biline" <?php if($operator=='rusia_biline'){$selected='selected';}else{$selected='';} echo $selected; ?> >Biline Rusia</option>
							<option value="rusia_tele2" <?php if($operator=='rusia_tele2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tele2 Rusia</option>
							<!--<option value="Airtel" <?php //if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php //if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>-->
						<?php
						}
						else if($product == 'gamebar'){
						?>
							<option value="Vodafone_Qatar" <?php if($operator=='Vodafone_Qatar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_Qatar</option>
								<option value="ooredoo_qatar" <?php if($operator=='ooredoo_qatar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Qatar</option>
							<option value="ooredoo_oman" <?php if($operator=='ooredoo_oman'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo_Oman</option>
							<option value="malaysia_cellcom" <?php if($operator=='malaysia_cellcom'){$selected='selected';}else{$selected='';} echo $selected; ?>>cellcom_Malaysia</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone_India</option>
							<option value="idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?> >Idea_India</option>
							<option value="airtel_india" <?php if($operator=='airtel_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Airtel_India
							</option>
							<!--<option value="bsnl_india" <?php //if($operator=='bsnl_india'){$selected='selected';}else{$selected='';} echo $selected; ?> >Bsnl_India
							</option>-->
							<option value="south-africa" <?php if($operator=='south-africa'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Oxygen</option>
							<option value="southafrica_intarget" <?php if($operator=='southafrica_intarget'){$selected='selected';}else{$selected='';} echo $selected; ?> >South-Africa Intarget</option>
							
							<option value="portugal" <?php if($operator=='portugal'){$selected='selected';}else{$selected='';} echo $selected; ?> >Portugal</option>
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Indonesia</option>
							<option value="egypt" <?php if($operator=='egypt'){$selected='selected';}else{$selected='';} echo $selected; ?> >Egypt</option>
							<option value="du_dubai" <?php if($operator=='du_dubai'){$selected='selected';}else{$selected='';} echo $selected; ?> >Du_Dubai</option>
							<option value="kenya_oxygen" <?php if($operator=='kenya_oxygen'){$selected='selected';}else{$selected='';} echo $selected; ?> >Kenya_Oxygen
							</option>
							<option value="rusia_biline" <?php if($operator=='rusia_biline'){$selected='selected';}else{$selected='';} echo $selected; ?> >Biline Rusia</option>
							<option value="rusia_tele2" <?php if($operator=='rusia_tele2'){$selected='selected';}else{$selected='';} echo $selected; ?> >Tele2 Rusia</option>
							<!--<option  id="azharbeizan" name="azharbeizan" value="Azharbeizan" <?php //if($operator=='Azharbeizan'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azharbeizan</option>
							<option  id="ooredoo" name="ooredoo" value="ooredoo" <?php //if($operator=='ooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo-Qatar</option>
							<option  id="srilanka" name="srilanka" value="srilanka" <?php //if($operator=='srilanka'){$selected='selected';}else{$selected='';} echo $selected; ?>>srilanka</option>
							<option  id="etisalat" name="etisalat" value="etisalat" <?php //if($operator=='etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>etisalat</option>-->
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
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){ echo date('d-m-Y',strtotime($start_date2)); } else { echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						
						<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback first"> Advertiser
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
							//echo $operator;exit;
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel">
									<?php
									
									if($operator == 'vodafone' or $operator == 'idea' or $operator=='bsnl_india'){
										
									
									
									
									}
									else{
										
										echo "<option value='all'>All</option>";
									}
									while($row_ad=mysqli_fetch_array($res_ad))
									{
										if($row_ad['advertiserid']==$advertiserid)
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
									?>
									<option value="<?php echo $row_ad['advertiserid']; ?>" <?php echo $selected; ?>><?php echo $row_ad['advname']; ?></option>
									<?php
									}
									?>
									
								</select>
								</span>
							</div>
						<?php
						}
						?>
						

                     
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
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
			//echo $sql;
			
				$swq="select operator_cost from `gamebardb_vodafone_qatar_report`.`operatorcost` where operator='".$operator."'";
				$ser=mysqli_query($con3,$swq) or die(mysqli_error());
				while($wor=mysqli_fetch_array($ser))
				{
					$cost=$wor['operator_cost'];
				}
			if($count==1)
			{
				$k=$l=0;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>With mdn</strong></td><!--uniq-->
									<td><strong>Sent CG</strong></td>
									<td><strong>Conv %</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Renewal</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Total Count</strong></td>
									<td><strong>Total Amount</strong></td>
									<td><strong>SVMobi Revenue</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Low Bal.</strong></td>
									<td><strong>Callback Sent</strong></td>
									<td><strong>Callback %</strong></td>
									<td><strong>Adv. Cost</strong></td>
									
									
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
							//echo $sql;
								$click_sum='';
								$uniq_sum='';
								$cg_sum='';
								$act_sum='';
								$actamnt_sum='';
								$ren_sum='';
								$renamnt_sum='';
								$count_sum='';
								$amount_sum='';
								$low_sum='';
								$cbsent_sum='';
								$churn_sum='';
								$advcost_sum=$svmobiamount_sum='';
									
								if($cc==1)
								{
									
									while($row=mysqli_fetch_array($res))
									{
										$ddate=date('d-m-Y',strtotime($row['dt']));
										$dclick=$row['clicks'];
										if($dclick=="")
										{
											$dclick=0;
										}
										$duniq=$row['uniq'];
										if($duniq == "")
										{
											$duniq=0;
											
										}
										$dcg=$row['cg'];
										$dconv=($row['act']*100)/$row['clicks'];
										$dact=$row['act'];
										
										$dactamnt=$row['actamnt'];
										
										$dren=$row['ren'];
										$drenamnt=$row['renamnt'];
										$dcount=$row['act']+$row['ren'];
										$damount=$row['actamnt']+$row['renamnt'];
										$churn=$row['dct'];
										$dlow=$row['Low'];
										$dcbsent=$row['cbsent'];
										if($dcbsent>0)
										{
										$dcbs=($dcbsent*100)/$row['act'];
										}else
										{
											$dcbs=0;
										}
										
										
											
										
										
										
										$dadvcost=$row['cbsent']*$cost;
										
										//$dadvcost=$row['cbsent']*12;
										
										/*if($operator=='Idea')
										{	
										$dadvcost=$row['cbsent']*34;
										}
										elseif($operator=='Vodafone_Qatar')
										{
											//echo "hi <br>";
											 $dadvcost=$row['cbsent']*12.75;
										}
										
										else if($operator=='malaysia_cellcom')
										{
											$dadvcost=$row['cbsent']*3.87;
										}
										else if($operator=='ooredoo_oman')
										{
											$dadvcost=$row['cbsent']*1.37;
										}
									
										
										else
										{
											$dadvcost=$row['cbsent']*2;
										}*/
										
										
								?>
									<tr>
										<td><?php echo $ddate; //date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($dclick); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($duniq); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										<td><?php echo number_format($dcg); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php echo number_format($dconv, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dact); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($dactamnt,2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($dren); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($drenamnt,2,'.',''); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($dcount); $count_sum=$count_sum+$dcount; ?></td>
										<td><?php echo number_format($damount,2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($operator=='Vodafone_Qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}else if($operator=='ooredoo_oman')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										else if($operator=='kenya_oxygen')
										{
										?>	
										<td><?php echo number_format($damount*0.3,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										
										else if($operator=='ooredoo_qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='malaysia_cellcom')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='airtel_india')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='south-africa' or $operator='southafrica_intarget')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='portugal')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='indonesia')
										{
										?>	
										<td><?php echo number_format($damount*0.4); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										?>
										
										<td><?php echo number_format($churn); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($dlow); $low_sum=$low_sum+$row['Low'];?></td>

										<td><?php echo number_format($dcbsent); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></td>
										<td><?php echo number_format($dcbs, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dadvcost, 2, '.', ''); $advcost_sum=$advcost_sum+$dadvcost; ?></td>
										
										
									</tr>
								
								
								
								<?php
									}
									
								}
								elseif($cc==2)
								{
									if(mysqli_num_rows ($res1)>0)
									{
										$l=1;
									}
									while($row1=mysqli_fetch_array($res1))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row1['Date']));  ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['clicks']); $click_sum=$click_sum+$row1['clicks']; ?></a></td>
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['uniq']); $uniq_sum=$uniq_sum+$row1['uniq'];?></a></td>
										
										<td><?php echo number_format($row1['cg']); $cg_sum=$cg_sum+$row1['cg'];?></td>
										<td><?php $conv=$row1['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['actcount']); $act_sum=$act_sum+$row1['actcount'];?></a></td>
										<td><?php echo number_format($row1['actamount']); $actamnt_sum=$actamnt_sum+$row1['actamount'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['renewcount']); $ren_sum=$ren_sum+$row1['renewcount']; ?></a></td>
										<td><?php echo number_format($row1['renewamount']); $renamnt_sum=$renamnt_sum+$row1['renewamount'];?></td>
										<td><?php echo number_format($count=$row1['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row1['totalamount']); $amount_sum=$amount_sum+$damount;?></td>
										
									
										<?php
										if($operator=='Vodafone_Qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}else if($operator=='ooredoo_oman')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										else if($operator=='ooredoo_qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='malaysia_cellcom')
										{
										?>	
										<td><?php echo number_format($damount*0.45,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.45;?></td>
										<?php
										}
										else if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='airtel_india')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='south-africa' or $operator='southafrica_intarget')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='kenya_oxygen' )
										{
										?>	
										<td><?php echo number_format($damount*0.3,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='portugal')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='indonesia')
										{
										?>	
										<td><?php echo number_format($damount*0.4); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										?>

										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='churn'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['churn']); $churn_sum=$churn_sum+$row1['churn'];?></a></td>
										
										<td><?php echo number_format($row1['park']); $low_sum=$low_sum+$row1['park']; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['cbsent']); $cbsent_sum=$cbsent_sum+$row1['cbsent']; ?></a></td>
										<td><?php echo number_format($row1['cbsentpercent'], 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($advcost=$row1['cbsent']*$cost, 2, '.', ''); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
									while($row=mysqli_fetch_array($res))
									{
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></a></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></a></td>
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=($row['act']*100)/$row['clicks']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></a></td>
										<td><?php echo number_format($row['actamnt']); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></a></td>
										<td><?php echo number_format($row['renamnt']); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($count=$row['act']+$row['ren']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['actamnt']+$row['renamnt']); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($operator=='Vodafone_Qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}else if($operator=='ooredoo_oman')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										else if($operator=='ooredoo_qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='malaysia_cellcom')
										{
										?>	
										<td><?php echo number_format($damount*0.45,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.45;?></td>
										<?php
										}
										else if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='airtel_india')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='south-africa' or $operator ='southafrica_intarget')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='kenya_oxygen')
										{
										?>	
										<td><?php echo number_format($damount*0.3,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										
										else if($operator=='portugal')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='indonesia')
										{
										?>	
										<td><?php echo number_format($damount*0.4); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										?>
										
										
										
										<td><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										<td><?php echo number_format($row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php $cbs=($row['cbsent']*100)/$row['act']; echo number_format($cbs, 2, '.', '')."%"; ?></td>
										<?php
										
										
										
											$dadvcost1=$row['cbsent']*$cost;
										
										?>
										<td><?php echo number_format($dadvcost1, 2, '.', ''); $advcost_sum=$advcost_sum+$dadvcost1; ?></td>
										
									</tr>
								<?php
									}
								}
								else
								{
									while($row=mysqli_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['Date']));  ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></a></td>
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></a></td>
										
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=$row['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['actcount']); $act_sum=$act_sum+$row['actcount'];?></a></td>
										<td><?php echo number_format($row['actamount']); $actamnt_sum=$actamnt_sum+$row['actamount'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['renewcount']); $ren_sum=$ren_sum+$row['renewcount']; ?></a></td>
										<td><?php echo number_format($row['renewamount']); $renamnt_sum=$renamnt_sum+$row['renewamount'];?></td>
										<td><?php echo number_format($count=$row['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['totalamount']); $amount_sum=$amount_sum+$damount;?></td>
										
										<?php
										if($operator=='Vodafone_Qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}else if($operator=='ooredoo_oman')
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										else if($operator=='ooredoo_qatar')
										{
										?>	
										<td><?php echo number_format($damount*0.35,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.35;?></td>
										<?php
										}
										else if($operator=='malaysia_cellcom')
										{
										?>	
										<td><?php echo number_format($damount*0.45,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.45;?></td>
										<?php
										}
										else if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='airtel_india')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='south-africa' or $operator='southafrica_intarget')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='portugal')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='kenya_oxygen')
										{
										?>	
										<td><?php echo number_format($damount*0.3,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='indonesia')
										{
										?>	
										<td><?php echo number_format($damount*0.4); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.4;?></td>
										<?php
										}
										?>
										
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='churn'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row['churn'];?></a></td>
										<td><?php echo number_format($row['park']); $low_sum=$low_sum+$row['park']; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php echo number_format($row['cbsentpercent'], 2, '.', '')."%";?></td>
										<td><?php echo number_format($advcost=$row['cbsent']*$cost, 2, '.', ''); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
								}
								if(mysqli_num_rows ($res)>0)
								{
									$k=1;
								}
								
								if($k==1 or $l==1)
									{
								?>
								
								
								
								<tr>
									<td>Total</td>
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format($uniq_sum); ?></td>
									<td><?php echo number_format($cg_sum); ?></td>
									<td></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo  number_format($actamnt_sum,2,'.','');?></td>
									<td><?php echo number_format($ren_sum); ?></td>
									<td><?php echo number_format($renamnt_sum,2,'.',''); ?></td>
									<td><?php echo number_format($count_sum); ?></td>
									<td><?php echo number_format($amount_sum,2,'.',''); ?></td>
									<td><?php echo number_format($svmobiamount_sum,2,'.',''); ?></td>
									<td><?php echo number_format($churn_sum); ?></td>
									<td><?php echo number_format($low_sum); ?></td>
									<td><?php echo number_format($cbsent_sum); ?></td>
									<td></td>
									<td><?php echo number_format($advcost_sum, 2, '.', ''); ?></td>
									
									
								</tr>
									<?php 
									}
									?>
							</tbody>
							
							
								
								
						</table>
					  </div>
				<!--<div id="advertiser"></div>-->
			<?php
			}
			else if($count==2)
			{
				//echo "hi";exit;
			?>	
			
			<div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>With mdn</strong></td><!--uniq-->
									
									<td><strong>Conv %</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Renewal</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Total Count</strong></td>
									<td><strong>Total Amount</strong></td>
									<td><strong>SVMobi Revenue</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Low Bal.</strong></td>
									<td><strong>%Low Conv</strong></td>

										
								</tr>
							</thead>


							<tbody>
							<?php
							
							while($row=mysqli_fetch_array($res))
							{
								?>
									<tr>
										<td><?php echo $row['dt']; //date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($dclick=$row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($duniq=$row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										<td><?php echo number_format($dconv=$row['conv'], 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($dact=$row['act']); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($dactamnt=$row['actamnt'],2,'.',''); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($dren=$row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($drenamnt=$row['renamnt'],2,'.',''); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($dcount=$row['totalcount']); $count_sum=$count_sum+$dcount; ?></td>
										<td><?php echo number_format($damount=$row['totalamount'],2,'.',''); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($operator=='vodafone')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										else if($operator=='idea')
										{
										?>	
										<td><?php echo number_format($damount*0.5,2,'.',''); $svmobiamount_sum=$svmobiamount_sum+$damount*0.5;?></td>
										<?php
										}
										?>
										<td><?php echo number_format($churn=$row['dct']); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($dlow=$row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><?php echo number_format($row['lowconv'], 2, '.', '')."%"; ?></td>

									
										
										
										
										
									</tr>
								<?php
							}
							
							?>
							</tbody>
							</table>
					  </div>
			
			<?php	
			}
			else{
				
			}
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
		select.options[select.options.length] = new Option('South-Africa Oxygen', 'south-africa');
		select.options[select.options.length] = new Option('South-Africa Intarget', 'southafrica_intarget');
		select.options[select.options.length] = new Option('Idea_India', 'idea');
		select.options[select.options.length] = new Option('Vodafone_India', 'vodafone');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
	//	select.options[select.options.length] = new Option('Bsnl_India', 'bsnl_india');
		select.options[select.options.length] = new Option('Thailand', 'thailand_svobi');
		select.options[select.options.length] = new Option('Portugal', 'portugal');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		select.options[select.options.length] = new Option('Biline Rusia', 'rusia_biline');
		select.options[select.options.length] = new Option('Tele2 Rusia', 'rusia_tele2');
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		select.options[select.options.length] = new Option('South-Africa Oxygen', 'south-africa');
		select.options[select.options.length] = new Option('South-Africa Intarget', 'southafrica_intarget');
		select.options[select.options.length] = new Option('Ooredoo_Oman', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Ooredoo_Qatar', 'ooredoo_qatar');
		select.options[select.options.length] = new Option('Cellcom_Malaysia', 'malaysia_cellcom');
		select.options[select.options.length] = new Option('Idea_India', 'idea');
		select.options[select.options.length] = new Option('Vodafone_India', 'vodafone');
		select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
	//	select.options[select.options.length] = new Option('Bsnl_India', 'bsnl_india');
		select.options[select.options.length] = new Option('Portugal', 'portugal');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Egypt', 'egypt');
		select.options[select.options.length] = new Option('Du_Dubai', 'du_dubai');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		select.options[select.options.length] = new Option('Biline Rusia', 'rusia_biline');
		select.options[select.options.length] = new Option('Tele2 Rusia', 'rusia_tele2');
		
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
<script>
 function getdata(startdate,enddate,db,dblog,advertiser,parameter){

  
  if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("advertiser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","mehul_ajax/mehul_ajax.php?startdate="+startdate+"&enddate="+enddate+"&db="+db+"&dblog="+dblog+"&advertiser="+advertiser+"&parameter="+parameter,true);
        xmlhttp.send();
    }
 
 </script>   
<script>
	/*function myFunction() {
    var x = document.getElementById("product").value;
	
	//document.getElementById("demo").innerHTML = "You selected: " + x;
    if(x =='Hotshots')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		select.options[select.options.length] = new Option('Airtel', 'Airtel');
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		//select.options[select.options.length] = new Option('etisalat', 'etisalat');
		//select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo_qatar');
	}
	
	//document.getElementById("demo").innerHTML = "You selected: " + x;
	}
	
	*/
	</script> 
