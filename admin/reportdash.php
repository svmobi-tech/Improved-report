<?php

ini_set('max_execution_time', 6000);

//include("includes/check_session.php");
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(0);
$con=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.34.240.3","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2

$report='gamebardb_vodafone_qatar_report';



//$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1

$con1=$con;
$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$cc=0;
$date1=date('Y-m-d');



if(isset($_POST['submit']))
{
	//print_r($_POST);exit;

$count=1;
$operator=$_POST['operator'];
$product=$_POST['product'];
 $advertiserid=$_POST['advertiserid']; 
//print_r($_POST);
//exit;
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

	 $sql_ad="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='".$product."' and (mainreport_all is not null and mainreport_all !='') order by operator asc";
	$res_op=mysqli_query($con,$sql_ad);
	
	
	$sql="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='".$product."' and operator='".$operator."' ";
			$res=mysqli_query($con,$sql);
			
			while($row=mysqli_fetch_array($res))
			{
				$mainreportall=$row['mainreport_all'];
				$mainreport_advertiser=$row['mainreport_advertiser'];
				//$advertiserquery=$row['advertiserwise_query'];
			
			}
			
			if($advertiserid=='all')
			{
				$url=$mainreportall;
				$url1=$mainreportall;
				$adve=0;
				//$advertiserid=0;
			}
			else{
				$url=$mainreport_advertiser;
				$url1=$mainreport_advertiser;
				$adve=$advertiserid;
				
			}
			
			
			$query="select * from advertiserdb.advertiser order by advname asc";
	//echo $query;exit;
	
	
	
	$res_ad=mysqli_query($con,$query);
	//$advertiserwisequery=str_replace("[advid]",$advertiserid,$advertiserwisequery);
	//echo $advertiserwisequery;exit;
	
	
			//echo $advertiserwisequery;exit;		
//	$cc=1;
	/*$res1=mysqli_query($con1,$advertiserwisequery);
	
	while($row1=mysqli_fetch_array($res1))
			{
				$advid=$row1['advertiserid'];
				$advname=$row1['advname'];
				$uid=$row1['uid'];
			
			}
	*/
	
	
	
	
	$url=str_replace("[startdate]",$start_date,$url);
	$url=str_replace("[enddate]",$end_date,$url);
	
	$query=str_replace("[advid]",$adve,$url);
	
	
	
			if($end_date1 == $date1 && $start_date1 == $date1)
			{	
				
							// $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
							//echo $query;
							$cc=1;
								$res=mysqli_query($con,$query) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
					$sql1="select * from ".$report.".mainreport where date >='".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser='".$adve."' and operator='".$operator."' and product='".$product."'";
					$res1=mysqli_query($con,$sql1);
			
					$start_date=date('Y-m-d 00:00:00');
					$end_date=date('Y-m-d 23:59:59');
			
			
					$url1=str_replace("[startdate]",$start_date,$url1);
					$url1=str_replace("[enddate]",$end_date,$url1);
					
					$query1=str_replace("[advid]",$adve,$url1);
			
			// $sql="call ".$db.".mainreport('".$start_date."','".$end_date."','".$advertiserid."','04')";
			//echo $query1;
			$cc=2;
			$res=mysqli_query($con,$query1) or die(mysqli_error());
			
			}
			else
			{
				$sql="select * from ".$report.".mainreport where date >='".$start_date."' and date < '".$end_date."' and advertiser='".$adve."' and operator='".$operator."' and product='".$product."'";

			$cc=3;
			$res=mysqli_query($con,$sql) or die(mysqli_error());
			}
			
	//echo $url;
	//exit;

	//					exit;
	$start_date2=$_POST['start_date'];
$end_date2=$_POST['end_date'];

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
                    <h2>Search URLs <small></small></h2>
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
						<select name="product" class="form-control" id="product" >
							<option>Product</option>
							<option value="gamebar" <?php if($product=='gamebar'){$selected='selected';}else{$selected='';} echo $selected; ?>>Gamebar</option>
							<option value="glambar" <?php if($product=='glambar'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glambar</option>
							
						</select>
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
								<select name="operator" id="operator" class="form-control select1_single sel1" onchange="myfun1()" >
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
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){ echo date('d-m-Y',strtotime($start_date2)); } else { echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
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
							//echo $operator;exit;
						?>
							
							<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback two"> Advertiser
								<span class="response" id="f">
								</span>
								<span id="t">
								<select name="advertiserid" class="form-control select2_single sel">
									<option value='all'>All</option>
									<?php
									
									
									while($row_ad=mysqli_fetch_array($res_ad))
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
						

						<br><br><br><br>
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
			//echo $operator;
			
				$swq="select operator_cost from `gamebardb_vodafone_qatar_report`.`operatorcost` where operator='".$operator."'";
				$ser=mysqli_query($con3,$swq) or die(mysqli_error());
				while($wor=mysqli_fetch_array($ser))
				{
					$cost=$wor['operator_cost'];
				}
				
				$swq1="select revenueshare from `gamebardb_vodafone_qatar_report`.`svmobi_revenueshare` where operator='".$operator."'";
				$ser1=mysqli_query($con3,$swq1) or die(mysqli_error());
				while($wor1=mysqli_fetch_array($ser1))
				{
					 $revenue=$wor1['revenueshare'];
				}
				
				
				
				
				
				
				
				
				
			if($count==1)
			{
				$k=$l=0;
				//echo $cc;exit;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						<script type="text/javascript">

							function copytable(el) {
								var urlField = document.getElementById(el)   
								var range = document.createRange()
								range.selectNode(urlField)
								window.getSelection().addRange(range) 
								document.execCommand('copy')
							}

							</script>
							<input type=button value="Copy to Clipboard" onClick="copytable('datatable-buttons')">
						<table id="datatable-buttons" class="table-bordered" style="color:black;font-size:11px;">
							<!--<thead>
								<tr>

									<td><strong>Date</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>With mdn</strong></td><!--uniq
									<td><strong>Sent CG</strong></td>
									<td><strong>Conv %</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Renewal</strong></td>
									<td><strong>Amount</strong></td>
									<td><strong>Total Count</strong></td>
									<td><strong>Total Amount</strong></td>
									<td><strong>SVMobi Revenue</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Low Bal.</strong></td>
									<td><strong>Callback Sent</strong></td>
									<td><strong>Callback %</strong></td>
									<td><strong>Adv. Cost</strong></td>
									
									
									
								</tr>
							</thead>-->


							<tbody>
								<?php 
							//echo $sql;
								$click_sum='';
								$uniq_sum='';
								$cg_sum='';
								$act_sum='';
								$actamnt_sum='';
								$ren_sum='';
								$renamnt_sum='';
								$count_sum='';
								$amount_sum='';
								$low_sum='';
								$cbsent_sum='';
								$churn_sum='';
								$advcost_sum=$svmobiamount_sum='';
									
								if($cc==1)
								{
									//echo "hi";
									while($row=mysqli_fetch_array($res))
									{
										$ddate=date('d-m-Y',strtotime($row['dt']));
										$dclick=$row['clicks'];
										if($dclick=="")
										{
											$dclick=0;
										}
										$duniq=$row['uniq'];
										if($duniq == "")
										{
											$duniq=0;
											
										}
										$dcg=$row['cg'];
										$dconv=($row['act']*100)/$row['clicks'];
										$dact=$row['act'];
										
										$dactamnt=$row['actamnt'];
										
										$dren=$row['ren'];
										$drenamnt=$row['renamnt'];
										$dcount=$row['act']+$row['ren'];
										$damount=$row['actamnt']+$row['renamnt'];
										$churn=$row['dct'];
										$dlow=$row['Low'];
										$dcbsent=$row['cbsent'];
										if($dcbsent>0)
										{
										$dcbs=($dcbsent*100)/$row['act'];
										}else
										{
											$dcbs=0;
										}
										
										
											
										
										
										
										$dadvcost=$row['cbsent']*$cost;
										
										
								?>
									<tr>
										<td><?php echo $ddate; //date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($dclick); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($duniq); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										<td><?php echo number_format($dcg); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php echo number_format($dconv, 2, '.', ' ')."%"; ?></td>
										<td><?php echo number_format($dact); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($dactamnt); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($dren); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($drenamnt); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($dcount); $count_sum=$count_sum+$dcount; ?></td>
										<td><?php echo number_format($damount); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}
										
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										?>
										
										<td><?php echo number_format($churn); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($dlow); $low_sum=$low_sum+$row['Low'];?></td>

										<td><?php echo number_format($dcbsent); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></td>
										<td><?php echo number_format($dcbs)."%"; ?></td>
										<td><?php echo number_format($dadvcost); $advcost_sum=$advcost_sum+$dadvcost; ?></td>
										
										
									</tr>
								
								
								
								<?php
									}
									
								}
								elseif($cc==2)
								{
									
									
									if(mysqli_num_rows ($res1)>0)
									{
										$l=1;
										//echo "hi2";exit;
									}
									while($row1=mysqli_fetch_array($res1))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row1['Date']));  ?></td>
										<td><?php echo number_format($row1['clicks']); $click_sum=$click_sum+$row1['clicks']; ?></td>
										
										<td><?php echo number_format($row1['uniq']); $uniq_sum=$uniq_sum+$row1['uniq'];?></td>
										
										<td><?php echo number_format($row1['cg']); $cg_sum=$cg_sum+$row1['cg'];?></td>
										<td><?php $conv=$row1['conversion']; echo number_format($conv, 2, '.', ' ')."%"; ?></td>
										<td><?php echo number_format($row1['actcount']); $act_sum=$act_sum+$row1['actcount'];?></td>
										<td><?php echo number_format($row1['actamount']); $actamnt_sum=$actamnt_sum+$row1['actamount'];?></td>
										<td><?php echo number_format($row1['renewcount']); $ren_sum=$ren_sum+$row1['renewcount']; ?></a></td>
										<td><?php echo number_format($row1['renewamount']); $renamnt_sum=$renamnt_sum+$row1['renewamount'];?></td>
										<td><?php echo number_format($count=$row1['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row1['totalamount']); $amount_sum=$amount_sum+$damount;?></td>
										
										
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}
										else 
										{
										?>	
										<td><?php echo number_format($damount*0.6); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										<?php
										}
										?>
										<td><?php echo number_format($row1['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										
										<td><?php echo number_format($row1['park']); $low_sum=$low_sum+$row1['park']; ?></td>
										<td><?php echo number_format($row1['cbsent']); $cbsent_sum=$cbsent_sum+$row1['cbsent']; ?></td>
										<td><?php echo number_format($row1['cbsentpercent'])."%"; ?></td>
										<td><?php echo number_format($advcost=$row1['cbsent']*$cost); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
									while($row=mysqli_fetch_array($res))
									{
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=($row['act']*100)/$row['clicks']; echo number_format($conv, 2, '.', ' ')."%"; ?></td>
										<td><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($row['actamnt']); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><?php echo number_format($row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></td>
										<td><?php echo number_format($row['renamnt']); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($count=$row['act']+$row['ren']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['actamnt']+$row['renamnt']); $amount_sum=$amount_sum+$damount;?></td>
										<?php
										if($revenue!='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}else 
										{
										?>	
										<td><?php echo number_format($damount*0.6); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										
										
										<?php
										}
										?>
										
										
										
										<td><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										<td><?php echo number_format($row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php $cbs=($row['cbsent']*100)/$row['act']; echo number_format($cbs)."%"; ?></td>
										<?php
										
										
										
											$dadvcost1=$row['cbsent']*$cost;
										
										?>
										<td><?php echo number_format($dadvcost1); $advcost_sum=$advcost_sum+$dadvcost1; ?></td>
										
									</tr>
								<?php
									}
								}
								else
								{
									while($row=mysqli_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['Date']));  ?></td>
										<td><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										
										<td><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></td>
										
										
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=$row['conversion']; echo number_format($conv, 2, '.', ' ')."%"; ?></td>
										<td><?php echo number_format($row['actcount']); $act_sum=$act_sum+$row['actcount'];?></td>
										<td><?php echo number_format($row['actamount']); $actamnt_sum=$actamnt_sum+$row['actamount'];?></td>
										<td><?php echo number_format($row['renewcount']); $ren_sum=$ren_sum+$row['renewcount']; ?></td>
										<td><?php echo number_format($row['renewamount']); $renamnt_sum=$renamnt_sum+$row['renewamount'];?></td>
										<td><?php echo number_format($count=$row['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($damount=$row['totalamount']); $amount_sum=$amount_sum+$damount;?></td>
										
										<?php
										if($revenue !='')
										{
										?>	
										<td><?php echo number_format($damount*$revenue); $svmobiamount_sum=$svmobiamount_sum+$damount*$revenue;?></td>
										<?php
										}else 
										{
										?>	
										<td><?php echo number_format($damount*0.6); $svmobiamount_sum=$svmobiamount_sum+$damount*0.6;?></td>
										
										<?php
										}
										?>
										
										
										<td><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row['churn'];?></td>
										<td><?php echo number_format($row['park']); $low_sum=$low_sum+$row['park']; ?></td>
										<td><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></td>
										<td><?php echo number_format($row['cbsentpercent'])."%";?></td>
										<td><?php echo number_format($advcost=$row['cbsent']*$cost); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
								}
								if(mysqli_num_rows ($res)>0)
								{
									$k=1;
								}
								
								if($k==1 or $l==1)
									{
								?>
								
								
								
								<tr>
									
									
								</tr>
									<?php 
									}
									?>
							</tbody>
							
							
								
								
						</table>
					  </div>
				<!--<div id="advertiser"></div>-->
			<?php
			}
							
							
								
			
			
			
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
 
</script>		
		
		
		
		
		
<script type="text/javascript">
 $(document).ready(function(){

   $("#product").change(function(){
		
		var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel1").val('');
			$("#t1").hide();
			$("#f1").show();
						
		}
       
		var product = $("#product").val();
        $.ajax({
            type: "GET",
            url: "ajax/findoperatormainreport.php?product="+product         
			
        }).done(function(data){
			
			
            $(".response1").html(data);
			 
        });
    });
});
</script>
<script type="text/javascript">
function myfun1() {
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
            url: "ajax/advertisermainreport.php?operator="+operator+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });

}	
</script>		




<script type="text/javascript">
function myfun() {
	var x = document.getElementById("product").value;
    //alert(x);
	if(x =='glambar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Thailand', 'thailand_svobi');
		select.options[select.options.length] = new Option('New_Thailand', 'new_thailand');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Vodacom_Wfh', 'vodacom_wfh');
		select.options[select.options.length] = new Option('Vodacom_Fg', 'vodacom_fg');
		select.options[select.options.length] = new Option('Vodacom_Bt', 'vodacom_bt');
		select.options[select.options.length] = new Option('Cosmote_Greece', 'Cosmote_Greece');
		select.options[select.options.length] = new Option('Vodafone_Greece', 'Vodafone_Greece');
		select.options[select.options.length] = new Option('Wind_Greece', 'Wind_Greece');
		select.options[select.options.length] = new Option('All_Greece D', 'all_greece');
	}
	else if(x =='gamebar')
	{
		document.getElementById('operator').options.length = 0;
		var select = document.getElementById("operator");
		select.options[select.options.length] = new Option('--operator--', '');
		select.options[select.options.length] = new Option('Vodafone_Qatar', 'Vodafone_Qatar');
		
		select.options[select.options.length] = new Option('Ooredoo_Oman', 'ooredoo_oman');
		select.options[select.options.length] = new Option('Qatar_Gamestation', 'qatar_gamestation');
		select.options[select.options.length] = new Option('Ooredoo_Qatar', 'ooredoo_qatar');
		select.options[select.options.length] = new Option('Qu_Qatar', 'qu_qatar');
		select.options[select.options.length] = new Option('Cellcom_Malaysia', 'malaysia_cellcom');
		
		
		//select.options[select.options.length] = new Option('Airtel_India', 'airtel_india');
	//	select.options[select.options.length] = new Option('Bsnl_India', 'bsnl_india');
		select.options[select.options.length] = new Option('Spain', 'spain');
		select.options[select.options.length] = new Option('Indonesia', 'indonesia');
		select.options[select.options.length] = new Option('Egypt', 'egypt');
		select.options[select.options.length] = new Option('Du_Dubai', 'du_dubai');
		select.options[select.options.length] = new Option('Kenya_Oxygen', 'kenya_oxygen');
		
		select.options[select.options.length] = new Option('Myanmar', 'myanmar');
		//select.options[select.options.length] = new Option('Kazakistan', 'kazakistan');
	
		
		select.options[select.options.length] = new Option('Poland', 'poland');
		select.options[select.options.length] = new Option('Bangladesh', 'Bangladesh_Robi');
		select.options[select.options.length] = new Option('Srilanka', 'dialog_srilanka');
		select.options[select.options.length] = new Option('Cosmote_Greece', 'Cosmote_Greece');
		select.options[select.options.length] = new Option('Vodafone_Greece', 'Vodafone_Greece');
		select.options[select.options.length] = new Option('Wind_Greece', 'Wind_Greece');
		select.options[select.options.length] = new Option('All_Greece D', 'all_greece');
		//select.options[select.options.length] = new Option('Mts_Serbia', 'Mts_Serbia');
		//select.options[select.options.length] = new Option('Vip_Serbia', 'Vip_Serbia');
		select.options[select.options.length] = new Option('Du_UAE', 'du_uae');
		select.options[select.options.length] = new Option('Etisalad_UAE', 'etisalad_uae');
		select.options[select.options.length] = new Option('Palestine', 'palestine');
		select.options[select.options.length] = new Option('Blazon_etisalad', 'blazon_etisalad');
		select.options[select.options.length] = new Option('Algeria', 'algeria');
		select.options[select.options.length] = new Option('Kuwait-Zain', 'kwzain');
		select.options[select.options.length] = new Option('Kuwait-Viva', 'kwviva');
		select.options[select.options.length] = new Option('Pk-Telenor', 'pk_telenor');
		select.options[select.options.length] = new Option('U.K.', 'unitedkingdom');
		//select.options[select.options.length] = new Option('Upstream_Thailand', 'upstream_thailand');
		select.options[select.options.length] = new Option('NL-D', 'netherland');
		select.options[select.options.length] = new Option('NL-N', 'netherland_netsmart');
		select.options[select.options.length] = new Option('France', 'france');
		select.options[select.options.length] = new Option('Bahrain', 'bahrain');
		select.options[select.options.length] = new Option('Greece N', 'gr2');
		select.options[select.options.length] = new Option('Norway', 'norway');
		select.options[select.options.length] = new Option('Saudi_Mobily', 'saudi_mobily');
		
	}
	
	/*if(x=="glambar")
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
 
