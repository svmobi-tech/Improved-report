<?php
include("includes/check_session.php");
include("includes/connection.php");
//error_reporting(0);
//$conn = mysql_connect('10.125.0.50','productionuser','Zb8#fNIsXnoP12') or die(mysql_error());

if($_GET['product']=='hotshots')
{
	$sql_item="select  * from hotshotsdb1.items ";
	$res_item=mysql_query($sql_item);
}
else
{
	$sql_game="select  * from gamesdb.product where assettype='Android'";
	$res_game=mysql_query($sql_game);
}

	


$start_date='';
$end_date='';
$operator='';
$count=0;

if(isset($_POST['submit']))
{
	
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
	
	
	$operator=$_POST['operator'];
	
	$pid=$_POST['pid'];
	
	$count=1;
	
	if($_GET['product'] == 'hotshots')
	{
		if($pid=='All')
		{
			if($operator == 'Vodafone')
			{
				
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p 
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb1.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
			elseif($operator == 'Airtel')
			{
				
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p 
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb_airtel1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb_airtel1.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
			else
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."'	group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
				
			}
		}
		else
		{
			if($operator == 'Vodafone')
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p 
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb1.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."'		
							and	items.itemid='".$pid."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
			elseif($operator == 'Airtel')
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p 
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb_airtel1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb_airtel1.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."'		
							and	items.itemid='".$pid."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
			else
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  items.title p
							from hotshotsdb.subscriberdownloads 
							inner join hotshotsdb1.items on subscriberdownloads.itemid = items.itemid
							inner join hotshotsdb_idea.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
							and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."'
							and	items.itemid='".$pid."'	group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
		}
	}
	else
	{
		if($pid=='All')
		{
			if($operator == 'Vodafone')
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  product.productname p 
								from gamesdb_voda.subscriberdownloads 
								inner join gamesdb.product on subscriberdownloads.productid = product.productcode
								inner join gamesdb_voda.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
								and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
			else
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  product.productname p 
								from gamesdb_voda.subscriberdownloads 
								inner join gamesdb.product on subscriberdownloads.productid = product.productcode
								inner join gamesdb.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
								and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
		}
		else
		{
			if($operator == 'Vodafone')
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  product.productname p 
								from gamesdb_voda.subscriberdownloads 
								inner join gamesdb.product on subscriberdownloads.productid = product.productcode
								inner join gamesdb_voda.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
								and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' 
								and  product.productid='".$pid."' group by dt,p"; 
				$res_dwnld=mysql_query($sql_dwnld);
			}
			else
			{
				$sql_dwnld="select count(userdownloadid) download_count, DATE(downloadstarttime) dt,  product.productname p 
								from gamesdb_voda.subscriberdownloads 
								inner join gamesdb.product on subscriberdownloads.productid = product.productcode
								inner join gamesdb.subscriber on subscriber.mobilenumber=subscriberdownloads.msisdn
								and downloadstarttime >= '".$start_date."' and downloadstarttime < '".$end_date."' 
								and product.productid='".$pid."' group by dt,p";
				$res_dwnld=mysql_query($sql_dwnld);
			}
		}
	}	
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
                    <h2>Download Count Report</h2>
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
					
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control">
							<option>Select Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						<?php
						if($_GET['product']=='hotshots')
						{
						?>
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Item Name
							<select name="pid" class="form-control select2_single">
							<option value="All">All</option>
							<?php
								while($row_item=mysql_fetch_array($res_item))
								{
									if($row_item['itemid'] == $pid)
									{
										$selected='selected';
									}
									else
									{
										$selected='';
									}
									
								?>
								<option value="<?php echo $row_item['itemid']; ?>" <?php echo $selected; ?>><?php echo $row_item['title']; ?></option>
								<?php
							
								}
							?>
							</select>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Games
							<select name="pid" class="form-control select2_single">
							<option value="All">All</option>
							<?php
								while($row_game=mysql_fetch_array($res_game))
								{
									if($row_game['productid'] == $pid)
									{
										$selected='selected';
									}
									else
									{
										$selected='';
									}
									
								?>
								<option value="<?php echo $row_game['productid']; ?>" <?php echo $selected; ?>><?php echo $row_game['productname']; ?></option>
								<?php
							
								}
								?>
							</select>
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
			if($count==1)
			{
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Game</strong></td>
									<td><strong>Download Count</strong></td>
								</tr>
							</thead>
							<tbody>
								<?php 
								
								while($row_dwnld=mysql_fetch_array($res_dwnld))
								{
								
								?>
								<tr>
									<td><?php echo $row_dwnld['dt'];  ?></td>
									<td><?php echo $row_dwnld['p'];  ?></td>
									<td><?php echo $row_dwnld['download_count'];  ?></td>																		
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

