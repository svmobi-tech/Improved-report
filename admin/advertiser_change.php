<?php
//include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);

$commondb="commondb";

$operator='';
$product='';

$count=0;
$cc=0;
if(isset($_POST['submit']))
{
$commondb="commondb";
	$operator=strtolower($_POST['operator']);
	$product=strtolower($_POST['product']);
	
	if($product == 'glambar')
	{
	//$spo="spo_stopcallback";
	//$act="act_stopcallback";
	
	}
	elseif($product == 'gamebar')
	{
	//$spo="games_spo_stopcallback";
	//$act="games_act_stopcallback";
		if($operator=='indonesia')
		{
			$db='gamebardb_indonesia';
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
                    <h2>Publisher Blocking</h2>
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
					
						<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control select2_single" id="product">
							
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glambar</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamebar</option>
							
							
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control select2_single" id="operator">
						<?php
						if($product=='gamebar')
						{
						?>	
						
							<option value="indonesia" <?php if($operator=='indonesia'){$selected='selected';}else{$selected='';} echo $selected; ?> >Indonesia</option>
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
			?>	
					<form method="post">
			
					  <div class="x_content">
					  
					  <input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
					  <input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
					 
						
						<table id="" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td width="5%"><strong>Campaign ID</strong></td>
									<td><strong>Title</td>
									<td width="10%"><strong>URL</td>
									
									<td><strong>Totally Stop</strong></td>	
									<td><strong>Payout (USD)</strong></td>	
									<td><strong>SpillOver Callback Stop(%)</strong></td>
									<td><strong>Activation Callback Stop(%)</strong></td>
									<td  width="10%"><strong>Redirect URL</strong></td>
									
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_advertiser=$res_advertiser->fetch())
									{
										
										$sql_payout="select * from ".$commondb.".".$tbl." 
										where advertiser_id='".$row_advertiser['advertiser_id']."' order by payoutid desc limit 1";
										$res_payout=$conn->query($sql_payout);
										$row_payout=$res_payout->fetch();
										
										if($row_advertiser['advertiser_isactive'] != '1')
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}	
										
								?>
									<tr>
										<td><?php echo $row_advertiser['advertiser_id']; ?></td>
										<td><?php echo $row_advertiser['advertiser_name']; ?></td>
										<td><?php echo $row_advertiser['advertiser_url']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row_advertiser['advertiser_id'];?>" <?php echo $checked; ?>  ></td>
										
										
										<td><input type="text" style="width:60px;padding:3px;" value='<?php echo $row_payout['payout']; ?>' onblur="change_payout(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>')" placeholder="$"></td>
										
										<td><input type="text" style="width:60px;padding:3px;" value='<?php echo $row_advertiser[$spo]; ?>' onblur="stop_callback(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>','spo')" placeholder="%"></td>
										
										
										<td><input type="text" style="width:60px;padding:3px;" value='<?php echo $row_advertiser[$act]; ?>' onblur="stop_callback(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>','act')" placeholder="%"></td>
										
										<td><input type="text" style="width:300px;padding:3px;" value='<?php echo $row_advertiser['redirect_url']; ?>' onblur="change_redirect(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>')" placeholder="%"></td>
									</tr>
								
								
								
								<?php
									}
								
								?>
																
							</tbody>
		
						</table>
					  </div>
					
				</form>
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
		

<!-- Totally Stop -->
<script type="text/javascript">

$(document).ready(function() {
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
           
            var operator = $(".operator1").val();
			var product = $(".product1").val();
			
			$.ajax({
            type: "GET",
            url: "ajax/advertiser_blocking.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			});
			
			 
        }
        else {
			
			var val = $(this).val();
         
            var operator = $(".operator1").val();
			var product = $(".product1").val();

			$.ajax({
            type: "GET",
            url: "ajax/advertiser_blocking.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val  
			});
           
        }
    });
});

</script> 		



<!-- Spill over and same day activation na callback percentage -->

<script type="text/javascript">

function stop_callback(callbackstop_perc,advertiserid,operator,product,type)
{

		
		$.ajax({
            type: "GET",
            url: "ajax/stop_callback.php?operator="+operator+"&product="+product+"&callbackstop_perc="+callbackstop_perc+"&advertiserid="+advertiserid+"&type="+type       
			});			
			
			
}

</script> 	

<!-- Redirect URL -->	

<script type="text/javascript">

function change_redirect(url,advertiserid,operator,product)
{
	
		
		$.ajax({
            type: "GET",
            url: "ajax/change_redirect_url.php?operator="+operator+"&product="+product+"&url="+url+"&advertiserid="+advertiserid      
			});			
			
			
}


</script>

<!-- Change payout -->

<script type="text/javascript">

function change_payout(payout,advertiserid,operator,product)
{

		
		$.ajax({
            type: "GET",
            url: "ajax/change_payout.php?operator="+operator+"&product="+product+"&payout="+payout+"&advertiserid="+advertiserid      
			});			
			
			
}

</script> 
