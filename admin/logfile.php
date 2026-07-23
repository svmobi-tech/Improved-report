<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);



$operator='';
$product='';
$number='';
$number1='';
$block='';
$count=0;

$num=0;

if(isset($_POST['submit']))
{
	$count=1;
	$operator=$_POST['operator'];
	$product=$_POST['product'];
	$number="91".$_POST['number'];
	$number1=$_POST['number'];
	
	
	
	

if($product=='Hotshots')
{
	if($operator=='Vodafone')
	{
		$db="hotshotsdb1";
		$dblog="hotshotsdblog1";
		
		
			$sql="select * from ".$dblog.".annonymoustracking where userid='".$number."'";
			
			$array=array("hotshotsdblog1", "hotshotsdblog1_12_Aug_24_Aug", "hotshotsdblog1_13_Jul_29_Jul",
	"hotshotsdblog1_19_Jun_13_Jul","hotshotsdblog1_1_Aug_11_Aug","hotshotsdblog1_25_Aug_30_Aug",
	"hotshotsdblog1_25_Aug_30_Aug","hotshotsdblog1_Sep_2016");
			
			$sql1="select * from ".$db.".subscriber 
				inner join ".$db.".subscriptiondetail on subscriber.subscriberid = subscriptiondetail.subscriberid
				where mobilenumber = '".$number."'"; 
				
			$sql11="select COUNT(*) download from ".$db.".subscriberdownloads where msisdn = '".$number."'";
			
			$block="select * from ".$db.".blockedmsisdn where msisdn ='".$number."' ";
	}
	elseif($operator=='Idea')
	{
		$db="hotshotsdb_idea";
		$dblog="hotshotsdblog_idea";
	
			
			$array=array("hotshotsdblog_idea", "hhotshotsdblog_idea_12_Aug_24_Aug", "hotshotsdblog_idea_13_Jul_29_Jul",
	"hotshotsdblog_idea_19_Jun_13_Jul","hotshotsdblog_idea_1_Aug_11_Aug","hotshotsdblog_idea_25_Aug_30_Aug",
	"hotshotsdblog_idea_25_Aug_30_Aug","hotshotsdblog_idea_Sep_2016");
	
	
		
			$sql="select * from ".$dblog.".annonymoustracking where userid='".$number."'";
			
			$sql1="select * from ".$db.".subscriber 
				inner join ".$db.".subscriptiondetail on subscriber.subscriberid = subscriptiondetail.subscriberid
				where mobilenumber = '".$number."'";
				
			$sql11="select COUNT(*) download from ".$db.".subscriberdownloads where msisdn = '".$number."'";
			
			$block="select * from ".$db.".blockedmsisdn where msisdn ='".$number."' ";
	
	}
	else
	{
		
	}
}
else
{
	if($operator=='Vodafone')
	{
		$db="gamesdb_voda";
		$dblog="gamesdblog_voda";
		
			
			$array=array("gamesdblog_voda", "gamesdblog_voda_12_Aug_24_Aug", "gamesdblog_voda_13_Jul_29_Jul",
			"gamesdblog_voda_19_Jun_13_Jul","gamesdblog_voda_1_Aug_11_Aug","gamesdblog_voda_25_Aug_30_Aug",
			"gamesdblog_voda_25_Aug_30_Aug","gamesdblog_voda_Sep_2016");
		
			$sql="select * from ".$dblog.".annonymoustracking where userid='".$number."'";
			
			$sql1="select * from ".$db.".subscriber 
				inner join ".$db.".subscriptiondetail on subscriber.subscriberid = subscriptiondetail.subscriberid
				where mobilenumber = '".$number."'";
				
			$sql11="select COUNT(*) download from ".$db.".subscriberdownloads where msisdn = '".$number."'";
			
			$block="select * from ".$db.".blockedmsisdn where msisdn ='".$number."' ";
	}
	elseif($operator=='Idea')
	{
		$db="gamesdb";
		$dblog="gamesdblog_idea";
		
			$array=array("gamesdblog_idea", "gamesdblog_idea_12_Aug_24_Aug", "gamesdblog_idea_13_Jul_29_Jul",
			"gamesdblog_idea_19_Jun_13_Jul","gamesdblog_idea_1_Aug_11_Aug","gamesdblog_idea_25_Aug_30_Aug",
			"gamesdblog_idea_25_Aug_30_Aug","gamesdblog_idea_Sep_2016");
			
		
			$sql="select * from ".$dblog.".annonymoustracking where userid='".$number."'";
			
			$sql1="select * from ".$db.".subscriber 
				inner join ".$db.".subscriptiondetail on subscriber.subscriberid = subscriptiondetail.subscriberid
				where mobilenumber = '".$number."'";
				
			$sql11="select COUNT(*) download from ".$db.".subscriberdownloads where msisdn = '".$number."'";
			
			$block="select * from ".$db.".blockedmsisdn where msisdn ='".$number."' ";
	}
	else
	{
		
	}
}
$res=mysql_query($sql,$con);
$num=mysql_num_rows($res);


if($num==0)
{
	
	
	foreach($array as $a)
	{
		$conbc=mysql_connect("43.231.124.191","productionuser","Zb8#fNIsXnoP12") or die(mysql_error());
		$sql="select * from ".$a.".annonymoustracking where userid='".$number."'"; 
		$res=mysql_query($sql,$conbc);
		$num1=mysql_num_rows($res); 
		if($num1 > 0)
		{
			break;
		}	
		else
		{
			continue;
		}
	}
	
}
else
{}

$fields=mysql_num_fields($res);
$res1=mysql_query($sql1,$con);
$fields1=mysql_num_fields($res1);
$res11=mysql_query($sql11,$con);
$row11=mysql_fetch_array($res11);

$res_block=mysql_query($block,$con);
$num=mysql_num_rows($res_block); 


$download=$row11['download'];


	
}

//$res=mysql_query($sql) or die(mysql_error());
//$fields=mysql_num_fields($res);// number of fields in table

//echo "<script>window.location='report.php';</script>";



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
                    <h2>Logfile</h2>
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
					
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product">
							<option>Product</option>
							<option value="Hotshots" <?php if($product=='Hotshots'){$selected='selected';}else{$selected='';} echo $selected; ?> >Hotshots</option>
							<option value="GamezZone" <?php if($product=='GamezZone'){$selected='selected';}else{$selected='';} echo $selected; ?>>GamezZone</option>
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Operator</option>
							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Mobile No.
						<input class="form-control col-md-7 col-xs-12" name="number" id="number" value="<?php if($number1!=''){echo $number1;}else{ echo $number1;} ?>"  type="text">
						
						</div>
					
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Blocking<br/>
						<?php
						if($num == '1')
						{
							$checked= 'checked' ;
						}
						else
						{
							$checked='';
						}
						?>
						<td><input type="checkbox" class="myCheckbox"  <?php echo $checked; ?>  ></td>
						<?php
						?>
						</div>

                     
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>

		<?php 	
			if($count==1)
			{
			?>	
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Output Records 
							<small> <?php 
										if($download == 0)
											{ echo "Subscriber has no download item.";}
										else
											{echo "Subscriber downloaded item are '".$download."'.";} ?>
							</small>
							
							</h2>
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
						
						<table id="datatable" class="table table-striped table-bordered">
							
								<thead>
									<tr>
										<?php 
										while ($fieldinfo=mysql_fetch_field($res))
										{
											?>
											
											<?php if($fieldinfo->name == 'SessionID' || $fieldinfo->name == 'PageID'
																|| $fieldinfo->name == 'UserAction' ||
																$fieldinfo->name == 'bannerid' || $fieldinfo->name == 'planid' ||
																$fieldinfo->name == 'remotehost' || $fieldinfo->name == 'header' ||
																$fieldinfo->name == 'tokenid' || $fieldinfo->name == 'circle' 
																|| $fieldinfo->name == 'advertiserid')
																{}
																else
																{
																	echo "<td><strong>".$fieldinfo->name."</strong></td>";
																}
														?>
											
											<?php
										}
										while ($row=mysql_fetch_array($res))
										{
											
										?>
									</tr>
								</thead>


								<tbody>
									<tr>
										<?php 
										
											?>
											
											<?php
											for($i=0;$i<$fields;$i++)
											{
											?>
												
												<?php 
												if($i==1 || $i==3 || $i== 6 || $i==8 || $i==9 || $i==13 || $i==14 || $i==15 ||
													$i==16 || $i==17	)
												{}
												else{
												echo "<td class='trigger' data-clipboard-text='$row[$i]'>".substr($row[$i],0,30)."</td>";

												} ?>
												
											<?php
											}
											?>
											
											<?php
										}
										
											
										?>
									</tr>
									
																
								</tbody>
							
							
							
							
								
								
						</table>
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
						
						<table id="datatable" class="table table-striped table-bordered">
							
								<thead>
									<tr>
										<?php 
										while ($fieldinfo1=mysql_fetch_field($res1))
										{
											?>
											
											<?php  
											if($fieldinfo1->name == 'issubscriptionactive' || $fieldinfo1->name == 'circle' ||
											$fieldinfo1->name == 'newmn' ||
											$fieldinfo1->name == 'subscriptiondetailid' ||
											$fieldinfo1->name =='isrenew' || $fieldinfo1->name =='txnid' || 
											$fieldinfo1->name =='msisdn' || $fieldinfo1->name =='xnum' || $fieldinfo1->name =='mnum' ||
											
											$fieldinfo1->name =='mn' || $fieldinfo1->name == 'transid')
											{}
											else
											{
											echo "<td><strong>".$fieldinfo1->name."</strong></td>";
											} ?>
											
											<?php
										}
										while ($row1=mysql_fetch_array($res1))
										{
											
										?>
									</tr>
								</thead>


								<tbody>
									<tr>
										
											
											<?php
											for($i=0;$i<$fields1;$i++)
											{
											?>
												
												<?php
												if($operator == 'Idea')
												{
													if($i==2 || $i == 3 || $i==4 ||$i == 11 || $i==12 || $i==13 || $i==14 || $i==15 || $i==16 || $i==17 || $i==18)
													{
														
													}
													else{
													echo "<td  class='trigger' data-clipboard-text='$row1[$i]'>".$row1[$i]."</td>";	
													}	
												}
												else
												{
													if($i==2 || $i == 3 || $i==4 ||$i == 5  || $i==12 || $i==13 || $i==14 || $i==15 || $i==16 || $i==17 || $i==18)
													{
														
													}
													else{
													echo "<td  class='trigger' data-clipboard-text='$row1[$i]'>".$row1[$i]."</td>";	
													}	
												}
												
												 ?>
												
											<?php
											}
											?>
											
											<?php
										}
										
											
										?>
									</tr>
									
																
								</tbody>
		
						</table>
					  </div>
				
			
					</div>
                </div>
			</div>
			<?php
			}
			else
			{}
			?>
		</div>
        <!-- /page content -->

       <?php
	   include("includes/footer.php");
	   ?>

   <script src="clipboard.min.js"></script>

    
    <script>
	$(document).ready(function(){
new Clipboard('.trigger');

})
   </script>
   
   <script type="text/javascript">

$(document).ready(function() {
	
    $('.myCheckbox').change(function() {
		
    if ($(this).prop('checked')) {
			
            var number = 91+$('#number').val();
			$.ajax({
            type: "GET",
            url: "ajax/blockedmsisdn.php?number="+number+"&c="+'check'   	
			});
			
			 
        }
        else {
			
			var number = 91+$('#number').val();
			$.ajax({
            type: "GET",
			url: "ajax/blockedmsisdn.php?number="+number+"&c="+'uncheck'      
			});
           
        }
    });
});

</script> 	