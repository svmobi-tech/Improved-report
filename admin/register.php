<?php 
include("includes/check_session.php");
include("includes/connection.php");
include("includes/dbo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$adv_name=$_POST['adv_name'];
	
	$adv_email=$_POST['adv_email'];
	$adv_number=$_POST['adv_number'];
	$adv_website=$_POST['adv_website'];
	$adv_password=$_POST['adv_password'];
	
	$adv_hs_advertiser=implode(',',$_POST['adv_hs_advertiser']);
	$adv_gm_advertiser=implode(',',$_POST['adv_gm_advertiser']);
	
	do_register($adv_name,$adv_email,$adv_number,$adv_website,$adv_password,$adv_hs_advertiser,$adv_gm_advertiser);
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>
<?php include("includes/top_navigation.php"); ?>

        <!-- page content -->
        <div class="right_col" role="main">

          <div class="footer_down">
           
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Advertiser Registration</h2>
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

                    <form class="form-horizontal"  method="post" action="register.php">

                      
                     

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Advertiser Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12"  name="adv_name" required   type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="adv_email" required class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Number <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="adv_number" required class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Website URL <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" name="adv_website" required  placeholder="www.website.com" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3">Password <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="password" type="password" name="adv_password" required class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  
					  
					  
					  <div class="item form-group" >
						<label  class="control-label col-md-3">HotShots Advertiser <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12 ">
												  
												
							<select name="adv_hs_advertiser[]" class="form-control select2_multiple" multiple="multiple" required >
								
								<?php
								$sql_ad="select * from hotshotsdblog1.advertiser";
								$res_ad=mysql_query($sql_ad);
								
								while($row_ad=mysql_fetch_array($res_ad))
								{
									
								?>
								<option value="<?php echo $row_ad[0]; ?>"><?php echo $row_ad[1]; ?></option>
								<?php
								}
								?>
								
							</select>
							</div>
						
					  </div>
					  
					  <div class="item form-group" >
						<label  class="control-label col-md-3">GamezZone Advertiser <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12 ">
												  
												
							<select name="adv_gm_advertiser[]" class="form-control select2_multiple" multiple="multiple" required >
								
								<?php
								$sql_ad1="select * from gamesdblog_voda.advertiser";
								$res_ad1=mysql_query($sql_ad1);
								
								while($row_ad1=mysql_fetch_array($res_ad1))
								{
									
								?>
								<option value="<?php echo $row_ad1[0]; ?>"><?php echo $row_ad1[1]; ?></option>
								<?php
								}
								?>
								
							</select>
							</div>
						
					  </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <input type="submit" name="submit" class="btn btn-success"  />
                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
		

<?php
include('includes/footer.php');
?>

<script type="text/javascript">
$(document).ready(function(){
	
	
    $("#product").change(function(){
		
		
	
        var product = $("#product").val();
	
		
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});





</script>
