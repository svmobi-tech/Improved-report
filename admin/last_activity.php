<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
$con1=$con;

date_default_timezone_set("Asia/Kolkata");
$date1=date("Y-m-d h:i:s" ,strtotime('-30 minutes'));
$date2=date('Y-m-d',strtotime("-1 days"));
$sum=0;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$display='';
$type='';
$date=date('my');
$count3=$count2=0;
if(isset($_POST['submit']))
{
	
	
	//$operator=$_POST['operator'];
	 $product=$_POST['product'];
	
	if($product=='Hotshots' )
	{
		//if($operator=='Vodafone')
		//{
			
		$count=1;
		$count2=1;
			
			
			$db='hotshotsnewdb_voda_0617';
			//$db1='hotshotsnewdb_voda_log_'.$date;
			
			$db1='hotshotsnewdb_voda_log_0617';
			$sql1="select * from (SELECT subscriptionstartdate maxact FROM ".$db.".subscriptiondetail WHERE amount > 0 AND isrenew = 0 order by subscriberid desc limit 1)a 
					left join 
					(SELECT subscriptionstartdate maxren FROM ".$db.".subscriptiondetail WHERE amount > 0 AND isrenew = 1 order by subscriberid desc limit 1 )b on a.maxact != b.maxren or a.maxact = b.maxren 

					left join (SELECT accesstime maxclicks FROM ".$db.".userlog order by userlogid desc limit 1)c on a.maxact != c.maxclicks or a.maxact = c.maxclicks
					left join (SELECT senttime maxcallback FROM ".$db.".advertcallback where isact!=0 order by advertcallbackid desc limit 1)d on a.maxact != d.maxcallback or a.maxact = d.maxcallback
					left join (SELECT `callbackresponsetime` maxcallreceive FROM ".$db1.".`callbackresponses` WHERE `callbackrequestinfo` like '%action=act%' and `callbackrequestinfo` like  '%status=success%' order by `callbackresponsesid` desc limit 1) e on a.maxact != e.maxcallreceive or a.maxact = e.maxcallreceive
			";
			
			//echo $sql1;exit;
			$res1=mysql_query($sql1,$con1);	
	//	}
		//else if($operator=='Idea')
		//{
			$db='hotshotsnewdb_idea_0717';
			//$db1='hotshotsnewdb_idea_log_'.$date;
			$db1='hotshotsnewdb_idea_log_0717';
			$sql2="SELECT 
						*
				FROM
					(SELECT 
						subscriptionstartdate maxact
					FROM
						".$db.".subscriptiondetail
					WHERE
						amount > 0
							AND (charging_mode LIKE '%act%'
							OR charging_mode LIKE '%UPGRD%')
					ORDER BY subscriberid DESC
					LIMIT 1) a
						LEFT JOIN
					(SELECT 
						subscriptionstartdate maxren
					FROM
						".$db.".subscriptiondetail
					WHERE
						amount > 0 AND isrenew = 1
					ORDER BY subscriberid DESC
					LIMIT 1) b ON a.maxact != b.maxren
						OR a.maxact = b.maxren
						LEFT JOIN
					(SELECT 
						accesstime maxclicks
					FROM
						".$db.".userlog
					ORDER BY userlogid DESC
					LIMIT 1) c ON a.maxact != c.maxclicks
						OR a.maxact = c.maxclicks
						LEFT JOIN
					(SELECT 
						senttime maxcallback
					FROM
						".$db.".advertcallback where isact!=0
					ORDER BY advertcallbackid DESC
					LIMIT 1) d ON a.maxact != d.maxcallback
						OR a.maxact = d.maxcallback
						LEFT JOIN
					(SELECT 
						`callbackresponsetime` maxcallreceive
					FROM
						".$db1.".`callbackresponses`
					WHERE
					`callbackrequestinfo` LIKE '%action=ACT%'
						AND `callbackrequestinfo` NOT LIKE '%status=BAL-LOW%'
						AND `callbackrequestinfo` NOT LIKE '%price=0.00'
					ORDER BY `callbackresponsesid` DESC
					LIMIT 1) e ON a.maxact != e.maxcallreceive
						OR a.maxact = e.maxcallreceive;";
						
						//echo $sql;exit;
						$res2=mysql_query($sql2,$con1);	
	//	}
	//	else{
			
			$db='hotshotsnewdb_airtel_0717';
			//$db1='hotshotsnewdb_airtel_log_'.$date;
			$db1='hotshotsnewdb_airtel_log_0817';
			$sql3="SELECT 
						*
					FROM
						(SELECT 
							subscriptionstartdate maxact
						FROM
							".$db.".subscriptiondetail
						WHERE
							 amount > 0
							AND isrenew = 0
							AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
							AND subscriptiondetail.errorcode = 1000
						ORDER BY subscriberid DESC
						LIMIT 1) a
							LEFT JOIN
						(SELECT 
							subscriptionstartdate maxren
						FROM
							".$db.".subscriptiondetail
						WHERE
							 amount > 0
							AND isrenew = 1
							AND (charging_mode != 541729  and charging_mode != 548184 and charging_mode != 548185 and charging_mode != 548186 and charging_mode != 548178)
							AND subscriptiondetail.errorcode = 1000
						ORDER BY subscriberid DESC
						LIMIT 1) b ON a.maxact != b.maxren
							OR a.maxact = b.maxren
							LEFT JOIN
						(SELECT 
							accesstime maxclicks
						FROM
							".$db.".userlog
						ORDER BY userlogid DESC
						LIMIT 1) c ON a.maxact != c.maxclicks
							OR a.maxact = c.maxclicks
							LEFT JOIN
						(SELECT 
							senttime maxcallback
						FROM
							".$db.".advertcallback
							where isact!=0
						ORDER BY advertcallbackid DESC
						LIMIT 1) d ON a.maxact != d.maxcallback
							OR a.maxact = d.maxcallback
							LEFT JOIN
						(SELECT 
							callbackresponsetime maxcallreceive
						FROM
							".$db1.".`callbackresponses`
						WHERE
						`callbackrequestinfo` LIKE '%<errorCode>1000</errorCode>%'
							AND `callbackrequestinfo` NOT LIKE '%<amount>0.0</amount>%'
							and `callbackrequestinfo` like '%<errorCode>1000</errorCode><errorMsg>Success</errorMsg>%'
						ORDER BY `callbackresponsesid` DESC
						LIMIT 1)e ON a.maxact != e.maxcallreceive
							OR a.maxact = e.maxcallreceive";
				//echo $sql;exit;
				$res3=mysql_query($sql3,$con1);	
		}
	
	else{
		
		$count=1;
		$count3=1;
		//vodafone
		$db='gamesdb_voda';
		$dblog='gamesdblog_voda';
	
		$sql1="select * from (SELECT 
				subscriptionstartdate maxact
					FROM
				".$db.".subscriptiondetail						
			WHERE
				isrenew = 0
				AND amount > 0
			order by subscriptiondetailid desc limit 1)a
			left join (SELECT 
				subscriptionstartdate maxren
				FROM
				".$db.".subscriptiondetail						
			WHERE
				isrenew = 0
				AND amount > 0
			order by subscriptiondetailid desc limit 1)b ON a.maxact != b.maxren
					OR a.maxact = b.maxren
			left join (select 
			AccessTime maxclicks
			from ".$dblog.". annonymoustracking
			order by AnnonymousTrackingID desc limit 1
			) c ON a.maxact != c.maxclicks
					OR a.maxact = c.maxclicks
			left join(select  requesttime maxcallback from ".$db.".requestresponse  order by requestresponseid desc  limit 1)d ON a.maxact != d.maxcallback
					OR a.maxact = d.maxcallback
					
			left join (SELECT `callbackresponsetime` maxcallreceive FROM ".$db.".callbackresponses WHERE (`callbackrequestinfo` like '%action=act%' or `callbackrequestinfo` like  '%status=success%') order by `callbackresponsesid` desc limit 1)e
			ON a.maxact != e.maxcallreceive OR a.maxact = e.maxcallreceive;";	
			$res1=mysql_query($sql1,$con);	
		
		//idea
		$db='gamesdb';
		$dblog='gamesdblog_idea';
		$sql2="SELECT 
					*
				FROM
					(SELECT 
						subscriptionstartdate maxact
					FROM
						".$db.".subscriptiondetail
					WHERE
						 charging_mode like '%ACT%' and amount > 0
					ORDER BY subscriptiondetailid DESC
					LIMIT 1) a
						LEFT JOIN
					(SELECT 
						subscriptionstartdate maxren
					FROM
						".$db.".subscriptiondetail
					WHERE
						charging_mode like '%REN%' and amount > 0
					ORDER BY subscriptiondetailid DESC
					LIMIT 1) b ON a.maxact != b.maxren
						OR a.maxact = b.maxren
						LEFT JOIN
					(SELECT 
						AccessTime maxclicks
					FROM
						".$dblog.".annonymoustracking
					ORDER BY AnnonymousTrackingID DESC
					LIMIT 1) c ON a.maxact != c.maxclicks
						OR a.maxact = c.maxclicks
						LEFT JOIN
					(SELECT 
						requesttime maxcallback
					FROM
						".$db.".requestresponse
					ORDER BY requestresponseid DESC
					LIMIT 1) d ON a.maxact != d.maxcallback
						OR a.maxact = d.maxcallback
						LEFT JOIN
					(SELECT 
						`callbackresponsetime` maxcallreceive
					FROM
						".$db.".callbackresponses
					WHERE
						`callbackrequestinfo` LIKE '%action=ACT%'
					AND `callbackrequestinfo` NOT LIKE '%status=BAL-LOW%'
					AND `callbackrequestinfo` NOT LIKE '%price=0.00'
					ORDER BY `callbackresponsesid` DESC
					LIMIT 1) e ON a.maxact != e.maxcallreceive
						OR a.maxact = e.maxcallreceive
						
						";
				$res2=mysql_query($sql2,$con);			
						
		$db='gamesdb_etisalat';
		$dblog='gamesdblog_etisalat';				
		$sql4="SELECT 
					*
				FROM
					(SELECT 
						`subscriptionstartdate` maxact
					FROM
						".$db.".subscriber
					WHERE
						 charging_mode like '%SUB%' and amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) a
						LEFT JOIN
					(SELECT 
						subscriptionstartdate maxren
					FROM
						".$db.".subscriber
					WHERE
						charging_mode like '%REN%' and amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) b ON a.maxact != b.maxren
						OR a.maxact = b.maxren
						LEFT JOIN
					(SELECT 
						AccessTime maxclicks
					FROM
						".$dblog.".annonymoustracking
					ORDER BY AnnonymousTrackingID DESC
					LIMIT 1) c ON a.maxact != c.maxclicks
						OR a.maxact = c.maxclicks
						LEFT JOIN
					(SELECT 
						requesttime maxcallback
					FROM
						".$db.".requestresponse
					ORDER BY requestresponseid DESC
					LIMIT 1) d ON a.maxact != d.maxcallback
						OR a.maxact = d.maxcallback
						LEFT JOIN
					(SELECT 
						`subscriptionstartdate` maxcallreceive
					FROM
						".$db.".subscriber

					ORDER BY `subscriberid` DESC
					LIMIT 1) e ON a.maxact != e.maxcallreceive
						OR a.maxact = e.maxcallreceive
						";
			$res4=mysql_query($sql4,$con);		
		
		$db='gamesdb_ooredoo_qatar';
		$dblog='gamesdblog_ooredoo_qatar';
		
		
		$sql5="SELECT 
					*
				FROM
					(SELECT 
						subscriptionstartdate maxact
					FROM
						".$db.".subscriber
					WHERE
						 isrenew = 0
						AND amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) a
						LEFT JOIN
					(SELECT 
						subscriptionstartdate maxren
					FROM
						".$db.".subscriber
					WHERE
						isrenew = 1
						AND amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) b ON a.maxact != b.maxren
						OR a.maxact = b.maxren
						LEFT JOIN
					(SELECT 
						AccessTime maxclicks
					FROM
						".$dblog.".annonymoustracking
					ORDER BY AnnonymousTrackingID DESC
					LIMIT 1) c ON a.maxact != c.maxclicks
						OR a.maxact = c.maxclicks
						LEFT JOIN
					(SELECT 
						requesttime maxcallback
					FROM
						".$db.".requestresponse
					ORDER BY requestresponseid DESC
					LIMIT 1) d ON a.maxact != d.maxcallback
						OR a.maxact = d.maxcallback
						LEFT JOIN
					(SELECT 
					   `subscriptionstartdate` maxcallreceive
					FROM
						".$db.".subscriber
					
					ORDER BY `subscriberid` DESC
					LIMIT 1) e ON a.maxact != e.maxcallreceive
						OR a.maxact = e.maxcallreceive
						";
			$res5=mysql_query($sql5,$con1);					
						
				$db="gamesdb_azerbaijan";
				$dblog="gamesdblog_azerbaijan";
				$sql6="SELECT 
					*
				FROM
					(SELECT 
						subscriptionstartdate maxact
					FROM
						".$db.".subscriber
					WHERE
						charging_mode = 'subscribed' 
						 AND amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) a
						LEFT JOIN
					(SELECT 
						subscriptionstartdate maxren
					FROM
						".$db.".subscriber
					WHERE
						 isrenew=1 
						AND amount > 0
					ORDER BY subscriberid DESC
					LIMIT 1) b ON a.maxact != b.maxren
						OR a.maxact = b.maxren
						LEFT JOIN
					(SELECT 
						AccessTime maxclicks
					FROM
						".$dblog.".annonymoustracking
					ORDER BY AnnonymousTrackingID DESC
					LIMIT 1) c ON a.maxact != c.maxclicks
						OR a.maxact = c.maxclicks
						LEFT JOIN
					(SELECT 
						requesttime maxcallback
					FROM
						".$db.".requestresponse
					ORDER BY requestresponseid DESC
					LIMIT 1) d ON a.maxact != d.maxcallback
						OR a.maxact = d.maxcallback
						LEFT JOIN
					(SELECT 
						`subscriptionstartdate` maxcallreceive
					FROM
						".$db.".subscriber
					
					ORDER BY `subscriberid` DESC
					LIMIT 1) e ON a.maxact != e.maxcallreceive
						OR a.maxact = e.maxcallreceive
						
						
					";
			$res6=mysql_query($sql6,$con);		
		
	}
	
	
	//}
	
	
	//$type=$_POST['type'];
	//$display=$_POST['display']; 
	//$advertiserid=$_POST['advertiserid'];
	
	//echo $operator;exit;
	
}



//$start_date2=$_POST['start_date'];
//$end_date2=$_POST['end_date'];
//$rows=mysql_fetch_array($res);


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
                    <h2>Last-Activity Report</h2>
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
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
						<?php 
						/*
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
						<?php
						if($product == 'Hotshots')
						{ ?>
							<option>Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						<?php
						}
						else if($product == 'GamezZone'){
						?>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							<option  id="azharbeizan" name="azharbeizan" value="Azharbeizan" <?php if($operator=='Azharbeizan'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azharbeizan</option>
							<option  id="ooredoo" name="ooredoo" value="ooredoo" <?php if($operator=='ooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Ooredoo-Qatar</option>
							<option  id="etisalat" name="etisalat" value="etisalat" <?php if($operator=='etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>etisalat</option>
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
						
						<?php
						*/
						/*
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date2));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
						
						</div>
						
						<?php
						
						/*
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Type
								<select name="type" class="form-control">
									
									<option value="Activation" <?php $selected=''; if($type=='Activation') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Activation</option>
									<option value="Renewal" <?php  $selected=''; if($type=='Renewal') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Renewal</option>
								<!--	<option value="Churn" <?php  //$selected=''; if($type=='Churn') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Churn</option> -->
									<option value="Clicks" <?php  $selected=''; if($type=='Clicks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Clicks</option>
								<!--	<option value="Total" <?php // $selected=''; if($type=='Total') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Total</option>-->
									<option value="Parking" <?php  $selected=''; if($type=='Parking') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Parking</option>
									<option value="CR" <?php  $selected=''; if($type=='CR') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>CR</option>
									<!--<option value="Aggr CR" <?php  //$selected=''; if($type=='Aggr CR') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Aggr CR</option>-->
									<option value="Callbacks" <?php  $selected=''; if($type=='Callbacks') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Callbacks</option>
								
								</select>
								
							</div>
							
							<?PHP
							*/
							/*<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
								<select name="display" class="form-control">
							
								<option value="Count" <?php  $selected=''; if($display=='Count') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Count</option>
								<option value="Amount" <?php  $selected=''; if($display=='Amount') {$selected='selected';} else{ $selcted='';}  echo $selected;  ?>>Amount</option>
							
								</select>
							</div>
							*/
						?>
						
						<?php
						/*
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 orm-group has-feedback first"> Advertiser
							<span class="response">
							</span>
							
							</div>
						<?php
						}
						else
						{
							
						?>
							<div class="col-md-2 col-sm-2 col-xs-3 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel">
									<option value="all">All</option>
									<?php
										
									while($row_ad=mysql_fetch_array($res_ad))
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
						*/
					
						
					
					?></div> 
					<div class="x_content">

                     
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
						
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							
							<thead><th></th>
							<th><center>click Time</center></th>
							<th><center>Activation Time<center></th>
							<th><center>Renewel Time<center></th>
							<th><center>CallBackSent Time<center></th>
							<th><center>CallBackReceive Time<center></th>
							
							</tr>
									
								</thead>


								<tbody>
								<?php 
								//<?php echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>0</span>"; 
								if($count==1)
								{
								while($rows=mysql_fetch_array($res1))
								{
									
								
								?>
									<tr><td>Vodafone</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td><span style='color:white;font-weight:bold;background:green;padding:5px;'> ".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxact']." </span></td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallback']." </span></td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']." </span></td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								while($rows=mysql_fetch_array($res2))
								{
									
								
								?>
									<tr><td>Idea</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxact']." </span></td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallback']." </span></td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								if($count2 == 1)
								{
								while($rows=mysql_fetch_array($res3))
								{
									
								
								?>
									<tr><td>Airtel</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxact']." </span></td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallback']." </span></td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']." </span></td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								}
								
								if($count3==1)
								{
								while($rows=mysql_fetch_array($res4))
								{
									
								
								?>
									<tr><td>Etisalat</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td><span style='color:white;font-weight:bold;background:green;padding:5px;'> ".$rows['maxact']." </span></td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallback']." </span></td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								while($rows=mysql_fetch_array($res5))
								{
									
								
								?>
									<tr><td>ooredoo_qatar</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td><span style='color:white;font-weight:bold;background:green;padding:5px;'> ".$rows['maxact']."</span> </td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td><span style='color:white;font-weight:bold;background:green;padding:5px;'> ".$rows['maxcallback']."</span> </td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']." </span></td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								while($rows=mysql_fetch_array($res6))
								{
									
								
								?>
									<tr><td>Azarbeizaan</td>
									<?php
									if($rows['maxclicks'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxclicks']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxclicks']." </span></td>";
									}
									
									if($rows['maxact'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxact']."</span> </td>";
									}
									else{
										echo "<td><span style='color:white;font-weight:bold;background:green;padding:5px;'> ".$rows['maxact']." </span></td>";
									}
									
									if($rows['maxren'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxren']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxren']." </span></td>";
									}
									if($rows['maxcallback'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallback']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallback']." </span></td>";
									}
									
									if($rows['maxcallreceive'] < $date1)
									{
										 echo "<td> <span style='color:white;font-weight:bold;background:red;padding:5px;'>".$rows['maxcallreceive']."</span> </td>";
									}
									else{
										echo "<td> <span style='color:white;font-weight:bold;background:green;padding:5px;'>".$rows['maxcallreceive']." </span></td>";
									}
									 
									
									
									?>
									
									</tr>
									
									
								<?php
								}
								}
								}
								?>	
								
								</tbody>
							
							
							
								
								
						</table>
					  </div>
				
			
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
		var product=$("#product").val();
		
        $.ajax({
            type: "GET",
          //  url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
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
	if(x =='Hotshots')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		select.options[select.options.length] = new Option('Airtel', 'Airtel');
	}
	else if(x =='GamezZone')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		select.options[select.options.length] = new Option('etisalat', 'etisalat');
		select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
	}
	
	
	/*if(x=="Hotshots")
	{
		 //alert("hi");
	document.getElementById('azharbeizan').style.visibility = 'hidden';
	}else
	{
		document.getElementById('azharbeizan').style.visibility = 'visible';
	}*/
}
</script>		
