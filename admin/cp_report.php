<?php
include("includes/check_session.php");
include("includes/connection.php");
 
error_reporting(0);
//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
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
	$aggregatorid=$_POST['aggregatorid']; 


// report logic below
	if($product=='Hotshots' || $product=='Hotshots')
	{
		
		if($operator=='Vodafone')
		{

			$db="hotshotsnewdb_voda_0617";
			$dblog="hotshotsdblog1";
		}
		elseif ($operator=='Airtel')
		{
			
		}
		else
		{
			
			
			$db="hotshotsnewdb_idea_0617";
			$dblog="hotshotsdblog_idea";
		}
		
	}
	else
	{
		if($operator=='Vodafone')
		{
			
			$db="gamesdb_voda";
			$dblog="gamesdblog_voda";
			
		}
		elseif ($operator=='Airtel')
		{
			
		}
		else
		{
			$db="gamesdb";
			$dblog="gamesdblog_idea";
			
		}
	}


	if($operator=='Idea')
	{
		if($product == 'Hotshots' )
		{
			 $sql="
				SELECT 
				dt,
				CASE
					WHEN circle IS NULL THEN 'Others'
					ELSE circle
				END circle,
				service_name,
				description,
				action,
				COUNT(*) cnt,
				amount,
				(COUNT(*) * amount) revenue
			FROM
				(SELECT 
					dt,
						circle,
						service_name,
						description,
						CASE action
							WHEN
								'activation'
							THEN
								CASE
									WHEN amount = 0 THEN 'lowbalance'
									ELSE action
								END
							ELSE action
						END action,
						amount
				FROM
					(SELECT 
					DATE(subscriptionstartdate) dt,
						circle,
						service service_name,
						CASE
							WHEN
								(service = '5LODHSF'
									OR service = 'LODHSF')
							THEN
								'Hotshots Fortnightly'
							WHEN
								(service = '5LODHSM'
									OR service = 'LODHSM')
							THEN
								'Hotshots Monthly'
							WHEN
								(service = '5LODHSW'
									OR service = 'LODHSW')
							THEN
								'Hotshots Weekly'
							WHEN
								(service = '5LODHSD'
									OR service = 'LODHSD')
							THEN
								'Hotshots Daily'
							ELSE '-'
						END description,
						CASE charging_mode
							WHEN 'DCT' THEN 'Deactivation'
							WHEN 'ACT' THEN 'Activation'
							WHEN 'REN' THEN 'Renewal'
							WHEN 'GRA' THEN 'Grace'
						END 'action',
						amount
				FROM
					(SELECT 
					service,
						LEFT(charging_mode, 3) charging_mode,
						subscriptionstartdate,
						amount,
						circle_name circle
				FROM
				   hotshotsnewdb_idea_0617.subscriptiondetail 
				INNER JOIN hotshotsnewdb_idea_0617.circleseries3 ON (SUBSTR(subscriptiondetail.msisdn, 3, 4) = circleseries3.series
					OR SUBSTR(subscriptiondetail.msisdn, 3, 5) = circleseries3.series)
				WHERE
					subscriptionstartdate >= '2017-03-03 00:00:00'
						AND subscriptionstartdate < '2017-03-03 23:59:59'
						AND charging_mode != '') b) c) d
			GROUP BY dt , circle , service_name , description , action
				"; 
				$res=mysql_query($sql,$con1) or die(mysql_error()); 
		}
		else
		{
			$sql="
				SELECT 
					dt,
					CASE
						WHEN circle IS NULL THEN 'Others'
						ELSE circle
					END circle,
					service_name,
					description,
					action,
					COUNT(*) cnt,
					amount,
					(COUNT(*) * amount) revenue
				FROM
					(SELECT 
						dt,
							circle,
							service_name,
							description,
							CASE action
								WHEN
									'activation'
								THEN
									CASE
										WHEN amount = 0 THEN 'lowbalance'
										ELSE action
									END
								ELSE action
							END action,
							amount
					FROM
						(SELECT 
						DATE(subscriptionstartdate) dt,
							circle,
							service service_name,
							CASE
								WHEN service = 'LDGZM' THEN 'Gameszone Monthly'
								WHEN service = 'LDGZN007'  THEN 'Gameszone Weekly'
								WHEN service = 'LDGZN015'  THEN 'Gameszone Fortnightly'
								WHEN service = 'LDGZN010' THEN 'Gameszone Ten Days'
								WHEN service = 'LDGZN001' THEN 'Gameszone Daily'							   
								ELSE '-'
							END description,
							CASE charging_mode
								WHEN 'DCT' THEN 'Deactivation'
								WHEN 'ACT' THEN 'Activation'
								WHEN 'REN' THEN 'Renewal'
								WHEN 'GRA' THEN 'Grace'
							END 'action',
							amount
					FROM
						(SELECT 
						service,
							LEFT(charging_mode, 3) charging_mode,
							subscriptionstartdate,
							amount,
							circle_name circle
					FROM
						".$db.".subscriber
					INNER JOIN ".$db.".subscriptiondetail ON subscriber.subscriberid=subscriptiondetail.subscriberid    
					INNER JOIN ".$db.".circleseries3 ON (SUBSTR(subscriber.mobilenumber, 3, 4) = circleseries3.series
						OR SUBSTR(subscriber.mobilenumber, 3, 5) = circleseries3.series)
					WHERE
						subscriptionstartdate >= '".$start_date."'
							AND subscriptionstartdate < '".$end_date."'
							AND charging_mode != '') b) c) d
				GROUP BY dt , circle , service_name , description , action
				"; 
				
		$res=mysql_query($sql,$con) or die(mysql_error()); 
		}
		
	}
	else if($operator=='Airtel')
	{

		if($product == 'Hotshots' )
		{
			$db='hotshotsnewdb_airtel_0617';
			$sql="SELECT 
						dt,
						CASE
							WHEN circle IS NULL THEN 'Others'
							ELSE circle
						END circle,
						service_name,
						description,
						action,
						COUNT(*) cnt,
						amount,
						(COUNT(*) * amount) revenue
					FROM
						(SELECT 
							dt, circle, service_name, description, action, amount
						FROM
							(SELECT 
							DATE(subscriptionstartdate) dt,
								circle circle,
								service service_name,
								CASE
									WHEN service = '140082' THEN 'Hotshots Monthly'
									
									ELSE '-'
								END description,
								CASE
									WHEN (isrenew = 0 AND amount > 0 and charging_mode != 541729 and errorcode = 1000) THEN 'Activation'
									WHEN (isrenew = 1 AND amount > 0 and charging_mode != 541729 and errorcode = 1000) THEN 'Renewal'
									WHEN
										(amount = 0
								AND charging_mode != 541729
								AND errorcode = 1001)
									THEN
										'Deactivation'
									WHEN  charging_mode = 541729 AND errorcode = 1000 THEN 'Parking'
								 
								END 'action',
								amount
						FROM
							(SELECT 
							subscriptiondetail.*, circleseries.*
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".circleseries ON (SUBSTR(subscriptiondetail.msisdn, 3, 4) = circleseries.series
							OR SUBSTR(subscriptiondetail.msisdn, 3, 5) = circleseries.series)
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND service != '') b) c) d
					GROUP BY dt , circle , service_name , description , action;
					"; 
				$res=mysql_query($sql,$con1) or die(mysql_error()); 
		}
		else{
			
		}
	}
	
	else
	{
		if($product == 'Hotshots' )
		{
			$sql="
					SELECT 
						dt,
						CASE
							WHEN circle IS NULL THEN 'Others'
							ELSE circle
						END circle,
						service_name,
						description,
						action,
						COUNT(*) cnt,
						amount,
						(COUNT(*) * amount) revenue
					FROM
						(SELECT 
							dt, circle, service_name, description, action, amount
						FROM
							(SELECT 
							DATE(subscriptionstartdate) dt,
								new_circle_name circle,
								service service_name,
								CASE
									WHEN service = 'LD_HSHOTM' THEN 'Hotshots Monthly'
									WHEN service = 'LD_HSHOTw' THEN 'Hotshots Weekly'
									ELSE '-'
								END description,
								CASE
									WHEN (isrenew = 0 AND amount > 0) THEN 'Activation'
									WHEN (isrenew = 1 AND amount > 0) THEN 'Renewal'
									WHEN
										(charging_mode = 'null'
											OR charging_mode = 'suspend')
									THEN
										'Deactivation'
									WHEN charging_mode = 'PARKING' THEN 'Parking'
									WHEN charging_mode = 'GRACE' THEN 'Grace'
								END 'action',
								amount
						FROM
							(SELECT 
							subscriptiondetail.*, circleseries3.*
						FROM
							".$db.".subscriptiondetail
						INNER JOIN ".$db.".circleseries3 ON (SUBSTR(subscriptiondetail.msisdn, 3, 4) = circleseries3.series
							OR SUBSTR(subscriptiondetail.msisdn, 3, 5) = circleseries3.series)
						WHERE
							subscriptionstartdate >= '".$start_date."'
								AND subscriptionstartdate <= '".$end_date."'
								AND service != '') b) c) d
					GROUP BY dt , circle , service_name , description , action;
		
			";
			$res=mysql_query($sql,$con1) or die(mysql_error()); 
		}
		else
		{
		$sql="
					SELECT 
						dt,
						CASE
							WHEN circle IS NULL THEN 'Others'
							ELSE circle
						END circle,
						service_name,
						description,
						action,
						COUNT(*) cnt,
						amount,
						(COUNT(*) * amount) revenue
					FROM
						(SELECT 
							dt, circle, service_name, description, action, amount
						FROM
							(SELECT 
							DATE(subscriptionstartdate) dt,
								new_circle_name circle,
								service service_name,
								CASE
									WHEN service = 'LD_GAMEM' THEN 'Gamezone Monthly'
									WHEN service = 'LD_GAMEW' THEN 'Gamezone Weekly'
									WHEN service = 'LD_GAMEF' THEN 'Gamezone Fortnightly'
									WHEN service = 'LD_GAMED' THEN 'Gamezone Daily'
									ELSE '-'
								END description,
								CASE
									WHEN (isrenew = 0 AND amount > 0) THEN 'Activation'
									WHEN (isrenew = 1 AND amount > 0) THEN 'Renewal'
									WHEN
										(charging_mode = 'null'
											OR charging_mode = 'suspend')
									THEN
										'Deactivation'
									WHEN charging_mode = 'PARKING' THEN 'Parking'
									WHEN charging_mode = 'GRACE' THEN 'Grace'
								END 'action',
								amount
						FROM 
							(SELECT 
							subscriptiondetail.*,circleseries3.*
						FROM
							".$db.".subscriber inner join 
							".$db.".subscriptiondetail on subscriber.subscriberid = subscriptiondetail.subscriberid
						INNER JOIN ".$db.".circleseries3 ON (SUBSTR(subscriber.mobilenumber, 3, 4) = circleseries3.series OR 
						SUBSTR(subscriber.mobilenumber, 3, 5) = circleseries3.series)
						WHERE
							subscriptionstartdate >= '".$start_date.".'
								AND subscriptionstartdate < '".$end_date.".'
								AND service != '') b) c) d
					GROUP BY dt , circle , service_name , description , action;
					";
					$res=mysql_query($sql,$con) or die(mysql_error()); 
		}
	
	}


$fields=mysql_num_fields($res);  // number of fields in table

//echo "<script>window.location='report.php';</script>";



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
                    <h2>CP Report</h2>
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
						<select name="product" class="form-control" id="product">
							<option>Product</option>
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="Gamezone" <?php if($product=='Gamezone'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamezone</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Select Operator</option>
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
			
			if($count==1)
			{
				
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Circle Name</strong></td>
									<td><strong>Service</strong></td>
									<td><strong>Description</strong></td>
									
									<td><strong>Action</strong></td>
									<td><strong>Count</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Revenue</strong></td>
								</tr>
							</thead>


							<tbody>
								<?php 
								$count_sum='';
								
								$revenue_sum='';
								
								
									
									while($row=mysql_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo $row['circle'];  ?></td>
										<td><?php echo $row['service_name']; $count_sum=$count_sum+$row['service_name']; ?></td>
										<td><?php echo $row['description']; ?></td>
										<td><?php echo $row['action']; ?></td>
										<td><?php echo number_format($row['cnt']); $count_sum=$count_sum+$row['cnt'];?></td>
										<td><?php echo number_format($row['amount']); ?></td>
										<td><?php echo number_format($row['revenue']); $revenue_sum=$revenue_sum+$row['revenue']; ?></td>
										
									</tr>
								
								
								
								<?php
									}
								
								
								?>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?php echo number_format($count_sum); ?></td>
									<td></td>
									<td><?php echo number_format($revenue_sum); ?></td>
									
								</tr>
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
	