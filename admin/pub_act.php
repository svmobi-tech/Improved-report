<?php
include("includes/check_session.php");
//include("includes/connection.php");
$con=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;

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
$advertiserid='8'; 


if($product=='hotshots' || $product=='Hotshots')
{
	$db="hotshotsdb_idea_19_Jun_13_Jul";
			$dblog="hotshotsdblog_idea_19_Jun_13_Jul";
}
else
{
	$db="hotshotsdb_idea";
			$dblog="hotshotsdblog_idea";
}


// report logic below
	if($product=='hotshots' || $product=='Hotshots')
	{	
		$sql="select COUNT(mobilenumber) act, reff1, DATE(a.actdt) dt1 from ( 
		select distinct subscriptiondetail.subscriberid,mobilenumber, DATE(subscriptionstartdate) actdt,
		REPLACE(REPLACE(REPLACE(substr(referrerurl,locate('subid',referrerurl)+6,10),'&has',''),'h=',''),'h','') reff1 
		from ".$db.".subscriptiondetail 
		inner join ".$db.".subscriber on subscriber.subscriberid= subscriptiondetail.subscriberid 
		inner join ".$dblog.".annonymoustracking on annonymoustracking.userid=subscriber.mobilenumber 
		where charging_mode like '%ACT%' and amount > 0  and advertiserid='8' 
		and subscriptionstartdate>='".$start_date."' and subscriptionstartdate < '".$end_date."'
		and accesstime>='".$start_date."' and accesstime < '".$end_date."'
		and referrerurl like '%subid%' and DATE(accesstime) = DATE(subscriptionstartdate)) a group by dt1,reff1"; 
		
	}	
	else
	{
		$sql="select COUNT(mobilenumber) act, reff1, DATE(a.actdt) dt1 from ( 
		select distinct subscriptiondetail.subscriberid,mobilenumber, DATE(subscriptionstartdate) actdt,
		REPLACE(REPLACE(REPLACE(substr(referrerurl,locate('subid',referrerurl)+6,10),'&has',''),'h=',''),'h','') reff1 
		from '".$db."'.subscriptiondetail 
		inner join '".$db."'.subscriber on subscriber.subscriberid= subscriptiondetail.subscriberid 
		inner join '".$dblog."'.annonymoustracking on annonymoustracking.userid=subscriber.mobilenumber 
		where charging_mode like '%ACT%' and amount > 0  and advertiserid='8' 
		and subscriptionstartdate>='".$start_date."' and subscriptionstartdate < '".$end_date."'
		and accesstime>='".$start_date." and accesstime < '".$end_date."'
		and referrerurl like '%subid%' and DATE(accesstime) = DATE(subscriptionstartdate)) a group by dt1,reff1";
		
	}

	
	$res=mysql_query($sql);




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
                    <h2>PubID wise Report </h2>
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
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
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
							<h2>Output Records</h2>
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
									
									<td><strong>Pub ID</strong></td>
									<td><strong>Count</strong></td>
									
									
									
													
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$act_sum='';
								$dct_sum='';
								
								
								$a=0;
								
								while($row=mysql_fetch_array($res))
								{
								
								?>
								<tr>
									<td><?php echo $row['dt1'];  ?></td>
																	
									<td><?php echo $row['reff1'];  ?></td>									
									<td><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></td>
									
									
								</tr>
								<?php
								}
								?>

								<tr>
									<td>Total</td>
									
									<td></td>
									<td><?php  echo number_format($act_sum); ?></td>
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
		var product= $("#product").val();
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	   		