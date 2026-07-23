<?php
include("includes/check_session.php");
//include("includes/connection.php");
error_reporting(0);
$con=mysql_connect("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysql_error());//cluster 2
$con2=mysqli_connect("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysql_error());//cluster 2
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
//global $con;
//global $con1;
$con1=$con2;

$gvact=$giact=$gooact=$geact=$gazact=0;
$start_date='';
$end_date='';
$date1=date('Y-m-d');
$count=0;
$cc=0;

$start_date2=$_POST['start_date'];
$end_date2=$_POST['end_date'];


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
					
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date2!=''){echo date('d-m-Y',strtotime($start_date2));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date2!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
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
			//echo $sql;
			if(isset($_POST['submit']))
			{
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
					
						<table id="datatable-buttons" class="table table-striped table-bordered">
						 
						  <thead>
						 <th rowspan='2'> <center>Date </center></th>
						  <th colspan='3'><center> Hotshots</center> </th>
						 <th colspan='2'> <center>Gamezone</center></th>
						 <th colspan='2'> <center>Total</center></th>
						 <tr>
						 
						 <th><center>Vodafone</center> </th>
						  <th><center>Idea</center></th>
						  <th><center>Airtel</center></th>
						  <th><center>Vodafone</center> </th>
						  <th><center>Idea</center></th>
						  <th><center>Vodafone</center> </th>
						  <th><center>Idea</center></th>
						  
						 </tr>
						  
						  </thead>
						  
						
							
							<tbody>
								<?php 
							//echo $sql;
								
										if($start_date == $end_date)
										{
											$start_date=date('Y-m-d 00:00:00',strtotime($_POST['start_date']));
											$end_date=date('Y-m-d 23:59:59',strtotime($_POST['end_date']));
											//$hour=$_POST['hours'];
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
									
										$count=1;
										
												
												
										 //$next_date = date('Y-m-d', strtotime($date1 .' +1 day'));
											//	$start_date	=date('Y-m-d', strtotime($start_date .' -1 day'));
											if($end_date1 == $date1 && $start_date1 == $date1)
											{
												//echo "hi1";
													
												$hotshotperci=$hotshotpercv=$hotshotperca=$gamepercv=$gameperci=0;
												$hotshotactv=$gameactv=$hotshotdactv=$gamedactv=$hotshotacti=$gameacti=$hotshotdacti=$gamedacti=0;
												
												//hotshots idea			
												$sql="call hotshotsnewdb_idea_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													 $hotshotperci= $row3['perc'];
													 $hotshotacti=$row3['act'];
													 $hotshotdacti=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												//hotshots voda 
												$sql="call hotshotsnewdb_voda_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$hotshotpercv= $row3['perc'];
													$hotshotactv=$row3['act'];
													$hotshotdactv=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												
												
												//hotshots airtel
												$sql="call hotshotsnewdb_airtel_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$hotshotperca= $row3['perc'];
													$hotshotacta=$row3['act'];
													$hotshotdacta=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												
												
												//games voda
												$sql="call gamesdb_voda.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con2,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$gamepercv= $row3['perc'];
													$gameactv=$row3['act'];
													$gamedactv=$row3['dct'];
												
												}
												$result3->close();
												$con2->next_result();
											
												// games idea
												$sql="call gamesdb.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con2,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$gameperci= $row3['perc'];
													$gameacti=$row3['act'];
													$gamedacti=$row3['dct'];
												
												}
												$result3->close();
												$con2->next_result();
												
												
												
												
												$percvodaact=$hotshotactv + $gameactv;
												$percvodadect=$hotshotdactv + $gamedactv;

												$totalpercentvoda=$percvodadect / $percvodaact * 100;
												
												
												$percideaact=$hotshotacti + $gameacti;
												$percideadect=$hotshotdacti + $gamedacti;

												$totalpercentidea=$percideadect / $percideaact * 100;
												
												$cc=1;
												
													$hotshotpercv= round($hotshotpercv,2);
													 $hotshotperci= round($hotshotperci,2);
													 $hotshotperca= round($hotshotperca,2);
													 $gamepercv= round($gamepercv,2);
													 $gameperci= round( $gameperci,2);
													 $totalpercentidea= round( $totalpercentidea,2);
													 $totalpercentvoda= round($totalpercentvoda,2);
												
											
												if($hotshotpercv==null)
												{
													$hotshotpercv=0; 
												}
												if($hotshotperci==null)
												{
													$hotshotperci=0; 
												}
												if($hotshotperca==null)
												{
													$hotshotperca=0; 
												}
												if($gamepercv==null)
												{
													$gamepercv=0; 
												}
												if($gameperci==null)
												{
													$gameperci=0; 
												}
												

											
											?>
										
											
												<tr>
														<td><?php echo $date1 ?></td>
														
														
														<td><?php if($hotshotpercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotpercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotpercv."</span>";}?></td>
														
														<td><?php if($hotshotperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperci."</span>";}?></td>
														
														<td><?php if($hotshotperca >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperca."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperca."</span>";}?></td>
														
														
														<td><?php if($gamepercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gamepercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gamepercv."</span>";}?></td>
														
														
														<td><?php if($gameperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gameperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gameperci."</span>";}?></td>
														
														
														<td><?php if($totalpercentvoda >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentvoda."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentvoda."</span>";}?></td>
														
														<td><?php if($totalpercentidea >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentidea."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentidea."</span>";}?></td>
																			
																			
																			
																			
												</tr>
												<?php
														
										
										
										
										

												//echo $start_date."<br>";
												//echo $end_date."<br><br>";
												//echo "<script>window.location='report.php';</script>";
												//$date1 = date('Y-m-d', strtotime($date1 .' +1 day'));
											}
											elseif($end_date1 == $date1 && $start_date1 != $date1)
											{
												//echo "hi2";
											
												 $sql1="select * from hotshotsdb1.samedaydeactivation where date >= '".$start_date1."' and date <= '".$end_date1."'";
												 $result3=mysqli_query($con2,$sql1);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													 
													 $date=$row3['date'];
													 $hotshotpercv= round($row3['hotshots_voda'],2);
													 $hotshotperci= round($row3['hotshots_idea'],2);
													 $hotshotperca= round($row3['hotshots_airtel'],2);
													 $gamepercv= round($row3['games_voda'],2);
													 $gameperci= round($row3['games_idea'],2);
													 $totalpercentidea= round($row3['total_idea'],2);
													 $totalpercentvoda= round($row3['total_voda'],2);
													?>
												
													<tr>
															<td><?php echo $date ?></td>
															
															
															<td><?php if($hotshotpercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotpercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotpercv."</span>";}?></td>
															
															<td><?php if($hotshotperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperci."</span>";}?></td>
															
															<td><?php if($hotshotperca >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperca."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperca."</span>";}?></td>
															
															
															<td><?php if($gamepercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gamepercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gamepercv."</span>";}?></td>
															
															
															<td><?php if($gameperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gameperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gameperci."</span>";}?></td>
															
															
															<td><?php if($totalpercentvoda >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentvoda."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentvoda."</span>";}?></td>
															
															<td><?php if($totalpercentidea >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentidea."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentidea."</span>";}?></td>
																			
																			
																			
																			
												</tr>
												<?php
												
												
												
												}
												
												$start_date=date('Y-m-d 00:00:00');
												$end_date=date('Y-m-d 23:59:59');
												
												$hotshotperci=$hotshotpercv=$hotshotperca=$gamepercv=$gameperci=0;
												$hotshotactv=$gameactv=$hotshotdactv=$gamedactv=$hotshotacti=$gameacti=$hotshotdacti=$gamedacti=0;
												
												//hotshots idea			
												$sql="call hotshotsnewdb_idea_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													 $hotshotperci= $row3['perc'];
													 $hotshotacti=$row3['act'];
													 $hotshotdacti=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												//hotshots voda 
												$sql="call hotshotsnewdb_voda_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$hotshotpercv= $row3['perc'];
													$hotshotactv=$row3['act'];
													$hotshotdactv=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												
												
												//hotshots airtel
												$sql="call hotshotsnewdb_airtel_0617.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con1,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$hotshotperca= $row3['perc'];
													$hotshotacta=$row3['act'];
													$hotshotdacta=$row3['dct'];
												
												}
												$result3->close();
												$con1->next_result();
												
												
												
												//games voda
												$sql="call gamesdb_voda.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con2,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$gamepercv= $row3['perc'];
													$gameactv=$row3['act'];
													$gamedactv=$row3['dct'];
												
												}
												$result3->close();
												$con2->next_result();
											
												// games idea
												$sql="call gamesdb.samedaydct('".$start_date."','".$end_date."')";
												 $result3=mysqli_query($con2,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													$gameperci= $row3['perc'];
													$gameacti=$row3['act'];
													$gamedacti=$row3['dct'];
												
												}
												$result3->close();
												$con2->next_result();
												
												
												
												
												$percvodaact=$hotshotactv + $gameactv;
												$percvodadect=$hotshotdactv + $gamedactv;

												$totalpercentvoda=$percvodadect / $percvodaact * 100;
												
												
												$percideaact=$hotshotacti + $gameacti;
												$percideadect=$hotshotdacti + $gamedacti;

												$totalpercentidea=$percideadect / $percideaact * 100;
												
												$cc=1;
											
													$hotshotpercv= round($hotshotpercv,2);
													 $hotshotperci= round($hotshotperci,2);
													 $hotshotperca= round($hotshotperca,2);
													 $gamepercv= round($gamepercv,2);
													 $gameperci= round( $gameperci,2);
													 $totalpercentidea= round( $totalpercentidea,2);
													 $totalpercentvoda= round($totalpercentvoda,2);
												
												
												if($hotshotpercv==null)
												{
													$hotshotpercv=0; 
												}
												if($hotshotperci==null)
												{
													$hotshotperci=0; 
												}
												if($hotshotperca==null)
												{
													$hotshotperca=0; 
												}
												if($gamepercv==null)
												{
													$gamepercv=0; 
												}
												if($gameperci==null)
												{
													$gameperci=0; 
												}
												

											
											?>
										
											
												<tr>
															<td><?php echo $date1 ?></td>
															
															
															<td><?php if($hotshotpercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotpercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotpercv."</span>";}?></td>
															
															<td><?php if($hotshotperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperci."</span>";}?></td>
															
															<td><?php if($hotshotperca >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperca."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperca."</span>";}?></td>
															
															
															<td><?php if($gamepercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gamepercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gamepercv."</span>";}?></td>
															
															
															<td><?php if($gameperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gameperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gameperci."</span>";}?></td>
															
															
															<td><?php if($totalpercentvoda >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentvoda."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentvoda."</span>";}?></td>
															
															<td><?php if($totalpercentidea >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentidea."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentidea."</span>";}?></td>
																			
																			
																			
																			
												</tr>
												
												
												<?php
												
											}
											else
											{
												//echo "hi3";
											$sql="select * from hotshotsdb1.samedaydeactivation where date >='".$start_date1."' and date <= '".$end_date1."'";
												 $result3=mysqli_query($con2,$sql);	
												
												while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC))
												{
													 
													 $date=$row3['date'];
													 $hotshotpercv= round($row3['hotshots_voda'],2);
													 $hotshotperci= round($row3['hotshots_idea'],2);
													 $hotshotperca= round($row3['hotshots_airtel'],2);
													 $gamepercv= round($row3['games_voda'],2);
													 $gameperci= round($row3['games_idea'],2);
													 $totalpercentidea= round($row3['total_idea'],2);
													 $totalpercentvoda= round($row3['total_voda'],2);
													?>
												
													<tr>
															<td><?php echo $date ?></td>
															
															
															<td><?php if($hotshotpercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotpercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotpercv."</span>";}?></td>
															
															<td><?php if($hotshotperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperci."</span>";}?></td>
															
															<td><?php if($hotshotperca >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$hotshotperca."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$hotshotperca."</span>";}?></td>
															
															
															<td><?php if($gamepercv >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gamepercv."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gamepercv."</span>";}?></td>
															
															
															<td><?php if($gameperci >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$gameperci."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$gameperci."</span>";}?></td>
															
															
															<td><?php if($totalpercentvoda >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentvoda."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentvoda."</span>";}?></td>
															
															<td><?php if($totalpercentidea >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$totalpercentidea."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$totalpercentidea."</span>";}?></td>
																			
																			
																			
																			
												</tr>
												<?php
												
												
												
												}
											}
			
											
								
			}
								?>
							</tbody>
							
							
								
								
						</table>
						
					  </div>
				<!--<div id="advertiser"></div>-->
			
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
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>
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
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		select.options[select.options.length] = new Option('etisalat', 'etisalat');
		select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo');
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
<script>
 function getdata(startdate,enddate,db,dblog,advertiser,parameter){

  
  if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("advertiser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","mehul_ajax/mehul_ajax.php?startdate="+startdate+"&enddate="+enddate+"&db="+db+"&dblog="+dblog+"&advertiser="+advertiser+"&parameter="+parameter,true);
        xmlhttp.send();
    }
 
 </script>   
<script>
	/*function myFunction() {
    var x = document.getElementById("product").value;
	
	//document.getElementById("demo").innerHTML = "You selected: " + x;
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
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone', 'Vodafone');
		select.options[select.options.length] = new Option('Idea', 'Idea');
		//select.options[select.options.length] = new Option('Airtel', 'Airtel');
		select.options[select.options.length] = new Option('Azharbeizan', 'Azharbeizan');
		//select.options[select.options.length] = new Option('etisalat', 'etisalat');
		//select.options[select.options.length] = new Option('ooredoo_qatar', 'ooredoo_qatar');
	}
	
	//document.getElementById("demo").innerHTML = "You selected: " + x;
	}
	
	*/
	</script> 
