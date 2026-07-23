<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); //cluster 1
$con1=$con;



 $sql="select * from gamebardb_vodafone_qatar_report.cron_report";
				//echo $sql;
			
			$res=mysqli_query($con,$sql);




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
                    <h2>cron_reporting time Report</h2>
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
							
								<thead>
									<tr>
										
										<td><strong>Cron_Name</strong></td>
										<td><strong>Run</strong></td>
										<td><strong>Date</strong></td>
										
	
									</tr>
								</thead>


								<tbody>
								<?php
									/*
									if($perc > 15){echo "<span style='color:red;'>".$perc."</span>";}else{echo "<span style='color:green;'>".$perc."</span>";}
									*/
									$date2=date('Y-m-d',strtotime("-1 days"));
									$date2=$date2." 23:59:59";
									while($row=mysqli_fetch_array($res))
									{
										
								?>
								
									<tr>
										<td><?php echo $row['cron_name']; ?></td>
										<td><?php if($row['ran']==1) {echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>True</span>";} else {echo " <span style='color:white;font-weight:bold;background:red;padding:5px;'>false</span>"; }?></td>
										<td><?php if ($row['date']<$date2) {echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$row['date']."</span>";}else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$row['date']."</span>";} ?></td>
										
									</tr>
									
								<?php
								//echo "perc= ".$row['perc'];
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
