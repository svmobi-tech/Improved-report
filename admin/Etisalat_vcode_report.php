<?php
include("includes/check_session.php");
include("includes/connection.php");

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); //cluster 1
$date1=date('Y-m-d');
$date2=date('Y-m-d', strtotime($date1 .' -2 day'));
$con1=$con;
error_reporting(0);
$sum=0;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));

if(isset($_POST['submit']))
{
	
	
	$count=1;
		$operator=$_POST['operator'];
		$product=$_POST['product'];
		
		//$type=$_POST['type'];
		//$display=$_POST['display']; 
		//$advertiserid=$_POST['advertiserid'];
		$b=$c=0;
		
		
		
	if($product== 'Hotshots')
	{
		
			
	}
	else
	{
		
		if($operator=='etisalat')
		{
			//echo "hi";
			$db="gamesdb_etisalat";
			$sql="SELECT 
				v.dt, v.cnt, activ.act, lowb.low, activ.amt
			FROM
				(SELECT 
					COUNT(msisdn) cnt, dt
				FROM
					(SELECT DISTINCT
					msisdn, DATE(date) dt
				FROM
					".$db.".Vcodenotification
				WHERE
					eventvalue = 'ok'
						AND date >= '".$start_date."'
						AND date <= '".$end_date."') a
				GROUP BY dt) v
					LEFT JOIN
				(SELECT 
					COUNT(msisdn) act, dt, SUM(amount) amt
				FROM
					(SELECT DISTINCT
					subscriber.msisdn, DATE(subscriptionstartdate) dt, amount
				FROM
					".$db.".subscriber
				INNER JOIN ".$db.".Vcodenotification ON subscriber.msisdn = Vcodenotification.msisdn
					AND charging_mode = 'SUB'
					AND amount > 0
					AND subscriptionstartdate >= '".$start_date."'
					AND subscriptionstartdate <= '".$end_date."'
					AND date >= '".$start_date."'
					AND date <= '".$end_date."') b
				GROUP BY dt) activ ON v.dt = activ.dt
					LEFT JOIN
				(SELECT 
					COUNT(msisdn) low, dt
				FROM
					(SELECT DISTINCT
					subscriber.msisdn, DATE(subscriptionstartdate) dt
				FROM
					".$db.".subscriber
				INNER JOIN ".$db.".Vcodenotification ON subscriber.msisdn = Vcodenotification.msisdn
					AND charging_mode = 'SUB'
					AND amount = 0
					AND subscriptionstartdate >= '".$start_date."'
					AND subscriptionstartdate <= '".$end_date."'
					AND date >= '".$start_date."'
					AND date <= '".$end_date."') b
				GROUP BY dt) lowb ON v.dt = lowb.dt"; 
				//echo $sql;
						
			$res=mysql_query($sql,$con1);
			
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
                    <h2>Sameday Churn Report</h2>
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
							
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
						<?php
						if($product == 'Hotshots')
						{ ?>
							
							
							
						<?php
						}
						else if($product == 'GamezZone'){
						?>
							<option value="etisalat" <?php if($operator=='etisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>Etisalt</option>
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
										<td><strong>V-Code Count</strong></td>
										<td><strong>Activation</strong></td>
										<td><strong>Low-Balance</strong></td>
										<td><strong>Amount</strong></td>
	
									</tr>
								</thead>


								<tbody>
								<?php
									$counttotal=0;
									$act=0;
									$dct=0;
									$amounttotal=0;
									
									
									while($row=mysql_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $row['dt']; ?></td>
										<td><?php echo $row['cnt']; $counttotal=$counttotal+$row['cnt'];?></td>
										<td><?php echo number_format($row['act']); $act=$act+$row['act']; ?></td>
										<td><?php echo number_format($row['low']); $dct=$dct+$row['dct']; ?></td>
										<td><?php echo number_format($row['amount']);  $amounttotal=$amounttotal+$row['amount'] ;?></td>
									</tr>
									
								<?php
								//echo "perc= ".$row['perc'];
									}
									
									
								?>
								
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><?php echo $counttotal; ?></strong></td>
									<td><strong><?php echo $act; ?></strong></td>
									<td><strong><?php echo $dct; ?></strong></td>
									<td><strong><?php echo $amounttotal; ?></strong></td>
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
		//select.options[select.options.length] = new Option('--operator--', '');
		//select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		//select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		//select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		select.options[select.options.length] = new Option('etisalat', 'etisalat');
		//select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
		//select.options[select.options.length] = new Option('srilanka', 'srilanka');
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