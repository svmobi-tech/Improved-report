<?php

ini_set('max_execution_time', 6000);

//include("includes/check_session.php");
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);
$con=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2





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
//exit;
$count=1;
$country=$_POST['country'];
$operator=$_POST['operator'];
$msisdn=$_POST['number'];

//$product=$_POST['product'];
	
	$sql_ad="select * from gamebardb_vodafone_qatar_report.unsub where operator='".$operator."' and country='".$country."'";
	
	$res_ad=mysqli_query($con,$sql_ad);
	
	//$ll=$operator=array();
	
	//$rowad=mysqli_fetch_array($res_ad);
	
	

	while($rowad=mysqli_fetch_array($res_ad))
	{
		
			//$arraykeys=array_keys($rowad);
			$url=$rowad['url'];
			$message =$rowad['message'];
		
	
	}
	
	
	$url1=str_replace("[msisdn]",$msisdn,$url);
	
	file_get_contents($url1);
	
	
	echo "<script>alert('".$message."');</script>";
	
	
	//print_r($operator);
	//exit;
	
	
	

	
}
?>

		<?php include("includes/header.php"); ?>
		<?php //include("includes/sidebar.php"); ?>
		<?php //include("includes/top_navigation.php"); ?>
            
			


        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Deactivate Your Number <small></small></h2>
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
					
						
						
						<?php
						
						 $sql_ad="select distinct(country)country from gamebardb_vodafone_qatar_report.unsub order by country asc";
							$res_op=mysqli_query($con3,$sql_ad);
							//echo $operator;exit;
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Country
								<span class="response1" id="f1">
								</span>
								<span id="t1">
								<select name="product" id="product" class="form-control select1_single sel1" onchange="myfun()">
									<option value="" >All</option>
									<?php
									
									
									while($row_op=mysqli_fetch_array($res_op))
									{
										if($row_op['country']==$country)
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
									?>
									<option value="<?php echo $row_op['country']; ?>" <?php echo $selected; ?>><?php echo $row_op['country']; ?></option>
									<?php
									}
									?>
									
								</select>
								
								
								
								</span>
							</div>
							
							
							<?php
						if($count==0)
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback first"> operator
							<span class="response1">
							</span>
							
							</div>
						<?php
						}
						else
						{
							//echo $operator;exit;
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> operator
								<span class="response1" id="f1">
								</span>
								<span id="t1">
								<select name="operator" id="operator" class="form-control select1_single sel1" onchange="myfun1()">
									<?php
									
									
									while($row_op=mysqli_fetch_array($res_op))
									{
										if($row_op['operator']==$operator)
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
									?>
									<option value="<?php echo $row_op['operator']; ?>" <?php echo $selected; ?>><?php echo $row_op['operator']; ?></option>
									<?php
									}
									?>
									
								</select>
								</span>
							</div>
						<?php
						}
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Number
								<input type='text' name='number' class="form-control" required>
							</div>
						
						
						
						<div class="col-md-9 col-sm-9 col-xs-12">
						 <div class="g-recaptcha" data-sitekey="6LeS3LwZAAAAAMe5LaYTVAabkO5DQgy-pDff0N-l" required></div>
						
						</div>
						<br><br><br><br>
						
						 <div class="col-md-9 col-sm-9 col-xs-12">
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
	


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function myfun() {
	var x = document.getElementById("product").value;
	alert(x);
	$.ajax({
            type: "GET",
            url: "ajax/find_operator.php?country="+x         
			
        }).done(function(data){
		
            $(".response1").html(data);
			 
        });
	
}


</script>