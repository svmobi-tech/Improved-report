<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);


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


// report logic below
	if($product=='hotshots' || $product=='Hotshots')
	{
		
		if($operator=='Vodafone')
		{
			$sql_ad="select * from hotshotsdblog1.advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad);
			
			$db="hotshotsdb1";
			$dblog="hotshotsdblog1";
		}
		elseif ($operator=='Airtel')
		{
			$db="hotshotsdb_airtel";
			$dblog="hotshotsdblog_airtel";
		}
		else
		{
			$sql_ad="select * from hotshotsdblog_idea.advertiser where operator=2 ";
			$res_ad=mysql_query($sql_ad);
			
			$db="hotshotsdb_idea";
			$db1="hotshotsdb";
			$dblog="hotshotsdblog_idea";
		}
		
	}
	else
	{
		if($operator=='Vodafone')
		{
			
			$db="gamesdb_voda";
			$dblog="gamesdblog_voda";
			
			$sql_ad="select * from ".$dblog.".advertiser where operator=1 ";
			$res_ad=mysql_query($sql_ad);
		}
		elseif ($operator=='Airtel')
		{
			$db="hotshotsdb_airtel";
			$dblog="hotshotsdblog_airtel";
		}
		else
		{
			
			$db="gamesdb";
			
			$dblog="gamesdblog_idea";
			$sql_ad="select * from ".$dblog.".advertiser where operator=2 ";
			$res_ad=mysql_query($sql_ad);
		}
	}

	


	if($operator=='Vodafone')
	{
		if($product == 'hotshots' || $product == 'Hotshots')
		{
			$sql="select * from hotshotsdb1.pub_approval where advertiserid = '".$advertiserid."'";	
				
			$sql1="select * from 
				( select count(*) total from hotshotsdb1.pub_approval where advertiserid ='".$advertiserid."') a ,							
				( select count(*) act from hotshotsdb1.pub_approval where  activation=1 and advertiserid ='".$advertiserid."') b,
				( select count(*) spl from hotshotsdb1.pub_approval where  spillover=1 and advertiserid ='".$advertiserid."') c,
				( select count(*) cbs from hotshotsdb1.pub_approval where  callback=1 and advertiserid ='".$advertiserid."') d,
				( select count(*) oth from hotshotsdb1.pub_approval where  others_blackout=1 and advertiserid ='".$advertiserid."') e
				";  
			$res1=mysql_query($sql1);
			$row1=mysql_fetch_array($res1);
			
			if($row1['total']==$row1['act'])
			{
				$check1="checked";
			}
			if($row1['total']==$row1['spl'])
			{
				$check2="checked";
			}
			if($row1['total']==$row1['cbs'])
			{
				$check3="checked";
			}
			if($row1['total']==$row1['oth'])
			{
				$check4="checked";
			}
			
			
			
		}
		else
		{	
			$sql="select * from gamesdb_voda.pub_approval where advertiserid = '".$advertiserid."'";

			$sql1="select * from 
				( select count(*) total from gamesdb_voda.pub_approval where advertiserid ='".$advertiserid."') a ,							
				( select count(*) act from gamesdb_voda.pub_approval where  activation=1 and advertiserid ='".$advertiserid."') b,
				( select count(*) spl from gamesdb_voda.pub_approval where  spillover=1 and advertiserid ='".$advertiserid."') c,
				( select count(*) cbs from gamesdb_voda.pub_approval where  callback=1 and advertiserid ='".$advertiserid."') d,
				( select count(*) oth from gamesdb_voda.pub_approval where  others_blackout=1 and advertiserid ='".$advertiserid."') e
				"; 
			$res1=mysql_query($sql1);
			$row1=mysql_fetch_array($res1);
			
			if($row1['total']==$row1['act'])
			{
				$check1="checked";
			}
			if($row1['total']==$row1['spl'])
			{
				$check2="checked";
			}
			if($row1['total']==$row1['cbs'])
			{
				$check3="checked";
			}
			if($row1['total']==$row1['oth'])
			{
				$check4="checked";
			}
		}	
	}
	else
	{
		if($product == 'hotshots' || $product == 'Hotshots')
		{
			$sql="select * from hotshotsdb_idea.pub_approval where advertiserid = '".$advertiserid."'";

			
			$sql1="select * from 
				( select count(*) total from hotshotsdb_idea.pub_approval where advertiserid ='".$advertiserid."') a ,							
				( select count(*) act from hotshotsdb_idea.pub_approval where  activation=1 and advertiserid ='".$advertiserid."') b,
				( select count(*) spl from hotshotsdb_idea.pub_approval where  spillover=1 and advertiserid ='".$advertiserid."') c,
				( select count(*) cbs from hotshotsdb_idea.pub_approval where  callback=1 and advertiserid ='".$advertiserid."') d,
				( select count(*) oth from hotshotsdb_idea.pub_approval where  others_blackout=1 and advertiserid ='".$advertiserid."') e
				"; 
			$res1=mysql_query($sql1);
			$row1=mysql_fetch_array($res1);
			
			if($row1['total']==$row1['act'])
			{
				$check1="checked";
			}
			if($row1['total']==$row1['spl'])
			{
				$check2="checked";
			}
			if($row1['total']==$row1['cbs'])
			{
				$check3="checked";
			}
			if($row1['total']==$row1['oth'])
			{
				$check4="checked";
			}
		}
		else
		{
			$sql="select * from gamesdb.pub_approval where advertiserid = '".$advertiserid."'"; 
			
			
			$sql1="select * from 
				( select count(*) total from gamesdb.pub_approval where advertiserid ='".$advertiserid."') a ,							
				( select count(*) act from gamesdb.pub_approval where  activation=1 and advertiserid ='".$advertiserid."') b,
				( select count(*) spl from gamesdb.pub_approval where  spillover=1 and advertiserid ='".$advertiserid."') c,
				( select count(*) cbs from gamesdb.pub_approval where  callback=1 and advertiserid ='".$advertiserid."') d,
				( select count(*) oth from gamesdb.pub_approval where  others_blackout=1 and advertiserid ='".$advertiserid."') e
				"; 
			$res1=mysql_query($sql1);
			$row1=mysql_fetch_array($res1);
			
			if($row1['total']==$row1['act'])
			{
				$check1="checked";
			}
			if($row1['total']==$row1['spl'])
			{
				$check2="checked";
			}
			if($row1['total']==$row1['cbs'])
			{
				$check3="checked";
			}
			if($row1['total']==$row1['oth'])
			{
				$check4="checked";
			}
		}
	
	}

$res=mysql_query($sql) or die(mysql_error());
$fields=mysql_num_fields($res);// number of fields in table

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
                    <h2>PubID Wise Activation And Spillover Setting</h2>
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
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Select Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
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
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel" id="ad">
									<option value="0">Select Advertiser</option>
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
					<form method="post">
			
					  <div class="x_content">
					  
					  <input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
					  <input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
					 
						
						<table id="" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>PubID</strong></td>
									<td><strong>Stop Activation<INPUT type="checkbox" id="selectall1" name="chk[]" <?php echo $check1; ?> /></strong></td>
									<td><strong>Stop Spillover<INPUT type="checkbox" id="selectall2" name="chk[]" <?php echo $check2; ?> /></strong></td>	
									<td><strong>Stop Callback<INPUT type="checkbox" id="selectall3" name="chk[]" <?php echo $check3; ?> /></strong></td>
									<td><strong>Stop Others<INPUT type="checkbox" id="selectall4" name="chk[]" <?php echo $check4; ?> /></strong></td>									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row=mysql_fetch_array($res))
									{
										if($row['activation'] == '1')
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}

										
										if($row['spillover'] == '1')
										{
											$checked1="checked";
										}
										else
										{
											$checked1="";
										}
										
										if($row['callback'] == '1')
										{
											$checked2="checked";
										}
										else
										{
											$checked2="";
										}
										
										if($row['others_blackout'] == '1')
										{
											$checked3="checked";
										}
										else
										{
											$checked3="";
										}

										
										
										
								?>
									<tr>
										<td><?php echo $row['pub_id']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row['pub_approval_id'];?>" <?php echo $checked; ?>  ></td>
										<td><input type="checkbox" class="myCheckbox1" value="<?php echo $row['pub_approval_id'];?>" <?php echo $checked1; ?>  ></td>
										<td><input type="checkbox" class="myCheckbox2" value="<?php echo $row['pub_approval_id'];?>" <?php echo $checked2; ?>  ></td>
										<td><input type="checkbox" class="myCheckbox3" value="<?php echo $row['pub_approval_id'];?>" <?php echo $checked3; ?>  ></td>
										
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
            url: "ajax/find_advertiser_pub_setting.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	 



<script type="text/javascript">

$(document).ready(function() {
    $('#selectall1').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $("#ad").val();
			
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val+"&ad="+'all'       
			});
			
			 
        }
        else {
			
			var val = $("#ad").val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val+"&ad="+'all'      
			});
           
        }
    });
});

</script> 	

<script type="text/javascript">

$(document).ready(function() {
    $('#selectall2').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $("#ad").val();
			
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_spl.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val+"&ad="+'all'       
			});
			
			 
        }
        else {
			
			var val = $("#ad").val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update_spl.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val+"&ad="+'all'      
			});
           
        }
    });
});

</script> 	
	
<script type="text/javascript">

$(document).ready(function() {
    $('#selectall3').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $("#ad").val();
			
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_callback.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val+"&ad="+'all'       
			});
			
			 
        }
        else {
			
			var val = $("#ad").val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update_callback.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val+"&ad="+'all'      
			});
           
        }
    });
});

</script> 

<script type="text/javascript">

$(document).ready(function() {
    $('#selectall4').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $("#ad").val();
		
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_others.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val+"&ad="+'all'       
			});
			
			 
        }
        else {
			
			var val = $("#ad").val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update_others.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val+"&ad="+'all'      
			});
           
        }
    });
});

</script> 


<script type="text/javascript">

$(document).ready(function() {
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			});
			
			 
        }
        else {
			
			var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val      
			});
           
        }
    });
});

</script> 		


<script type="text/javascript">

$(document).ready(function() {
    $('.myCheckbox1').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			$.ajax({
            type: "GET",
            url: "ajax/update_spl.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			
			
			});
			
			 
        }
        else {
			
			var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_spl.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val      
			
			
			});
           
        }
    });
});

</script> 	


<script type="text/javascript">

$(document).ready(function() {
	
    $('.myCheckbox2').change(function() {
		
    if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_callback.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			
			
			});
			
			 
        }
        else {
			
			var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_callback.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val      
			
			
			});
           
        }
    });
});

</script> 		

<script type="text/javascript">

$(document).ready(function() {
	
    $('.myCheckbox3').change(function() {
		
    if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_others.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			
			
			});
			
			 
        }
        else {
			
			var val = $(this).val();
            var product = $(".product1").val();
            var operator = $(".operator1").val();
			
			
			$.ajax({
            type: "GET",
            url: "ajax/update_others.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val      
			
			
			});
           
        }
    });
});

</script> 

