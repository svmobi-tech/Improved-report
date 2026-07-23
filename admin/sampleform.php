<?php
include("includes/check_session.php");
//include("includes/connection.php");

$con=new mysqli("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysqli_error());//cluster 2
$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$start_date='';
$end_date='';
$date1=date('Y-m-d');
$count=0;
$cc=0;

	
if(isset($_POST['submit']))
{
	
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
	
	$hours=$_POST['hours'];
	$count=1;
	$data['startdate']=$start_date;
	$data['enddate']=$end_date;
	
	
			if($end_date1 == $date1 && $start_date1 == $date1)
			{
				$db="hotshotsnewdb_idea";
				
				$sql="call hotshotsnewdb_idea.getactivation('".$start_date."',  '".$end_date."', ".$hours.") ";
				echo $sql;				
			
				$cc=1;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			elseif($end_date1 == $date1 && $start_date1 != $date1)
			{
				$db="hotshotsnewdb_idea";
			//	echo "hi2";
				$sql1="select * from hotshotsdb_idea.report where date >= '".$start_date."' and date < SUBDATE('".$end_date."', INTERVAL 1 DAY) and advertiser=0";
				//echo $sql1;
				$res1=mysqli_query($con,$sql1);
				
				//echo  $date1."hi3<br>";
				
				$start_date=date('Y-m-d 00:00:00');
				$end_date=date('Y-m-d 23:59:59');
				
				
				$sql="";
				
				//echo $sql;
				$cc=2;
				$res=mysqli_query($con1,$sql) or die(mysqli_error());
			}
			else
			{
				//echo "hi3";
				$sql="select * from hotshotsdb_idea.report where date >='".$start_date."' and date < '".$end_date."' and advertiser=0";
				$res=mysqli_query($con,$sql) or die(mysqli_error());
				$cc=3;
				
			}
			

	






$fields=mysqli_num_fields($res);// number of fields in table

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
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Hours
								<select name="hours" class="form-control">
									<?php
										for($i=24;$i>0;$i--)
										{
											if($i==$hours)
											{
												$selected='selected';
											}
											else
											{
												$selected='';
											}
										?>
											<option <?php echo $selected ?>><?php echo $i; ?></option>
										<?php
										}
									?>
								</select>
								
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
			if($count==1)
			{
				$k=$l=0;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
					
						<table id="datatable-buttons" class="table table-striped table-bordered">
						  <thead>
						 <th rowspan='2'> <center>Date </center></th>
						  <th colspan='3'><center> Hotshots</center> </th>
						 <th colspan='5'> <center>Gamezone</center></th>
						 <tr>
						 
						 <th><center>Vodafone</center> </th>
						  <th><center>Idea</center></th>
						  <th><center>Airtel</center></th>
						  <th><center>Vodafone</center> </th>
						  <th><center>Idea</center></th>
						  <th><center>Ooredoo</center></th>
						  <th><center>Etisalat</center> </th>
						  <th><center>Azerbaijan</center></th>
						  
						 </tr>
						  
						  </thead>
						  
						

							<tbody>
								<?php 
							//echo $sql;
								
									
								if($cc==1)
								{
									
									while($row=mysqli_fetch_array($res))
									{
										
										
								?>
									<tr>
										<td><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo "22"; ?></td>
										<td><?php echo "23";?></td>
										<td><?php echo "24";?></td>
										<td><?php echo "25"; ?></td>
										<td><?php echo "26";?></td>
										<td><?php echo "27";?></td>
										<td><?php echo "28"; ?></td>
										<td><?php echo "24";?></td>
										
										
										
									</tr>
								
								
								
								<?php
									}
									
								}
								elseif($cc==2)
								{
									if(mysqli_num_rows ($res1)>0)
									{
										$l=1;
									}
									while($row1=mysqli_fetch_array($res1))
									{
										
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row1['Date']));  ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['clicks']); $click_sum=$click_sum+$row1['clicks']; ?></a></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['uniq']); $uniq_sum=$uniq_sum+$row1['uniq'];?></a></td>
										<td><?php echo number_format($row1['cg']); $cg_sum=$cg_sum+$row1['cg'];?></td>
										<td><?php $conv=$row1['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['actcount']); $act_sum=$act_sum+$row1['actcount'];?></a></td>
										<td><?php echo number_format($row1['actamount']); $actamnt_sum=$actamnt_sum+$row1['actamount'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['renewcount']); $ren_sum=$ren_sum+$row1['renewcount']; ?></a></td>
										<td><?php echo number_format($row1['renewamount']); $renamnt_sum=$renamnt_sum+$row1['renewamount'];?></td>
										<td><?php echo number_format($count=$row1['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($amount=$row1['totalamount']); $amount_sum=$amount_sum+$amount;?></td>
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='churn'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['churn']); $churn_sum=$churn_sum+$row1['churn'];?></a></td>
										
										<td><?php echo number_format($row1['park']); $low_sum=$low_sum+$row1['park']; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row1['cbsent']); $cbsent_sum=$cbsent_sum+$row1['park']; ?></a></td>
										<td><?php echo $row1['cbsentpercent']."%"; ?></td>
										<td><?php echo number_format($advcost=$row1['advamount']); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
									</tr>
								<?php
									}
									while($row=mysqli_fetch_array($res))
									{
								?>
									<tr>
										<td><?php echo $dat2=date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></a></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></a></td>
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=($row['act']*100)/$row['clicks']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></a></td>
										<td><?php echo number_format($row['actamnt']); $actamnt_sum=$actamnt_sum+$row['actamnt'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['ren']); $ren_sum=$ren_sum+$row['ren']; ?></a></td>
										<td><?php echo number_format($row['renamnt']); $renamnt_sum=$renamnt_sum+$row['renamnt'];?></td>
										<td><?php echo number_format($count=$row['act']+$row['ren']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($amount=$row['actamnt']+$row['renamnt']); $amount_sum=$amount_sum+$amount;?></td>
										<td><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row1['churn'];?></td>
										<td><?php echo number_format($row['Low']); $low_sum=$low_sum+$row['Low'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['cbsent']; ?></a></td>
										<td><?php $cbs=($row['cbsent']*100)/$row['act']; echo number_format($cbs, 2, '.', '')."%"; ?></td>
										<td><?php echo number_format($advcost=$row['cbsent']*33); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
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
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='clicks'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></a></td>
										
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='uniq'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['uniq']); $uniq_sum=$uniq_sum+$row['uniq'];?></a></td>
										<td><?php echo number_format($row['cg']); $cg_sum=$cg_sum+$row['cg'];?></td>
										<td><?php $conv=$row['conversion']; echo number_format($conv, 2, '.', '')."%"; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='act'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['actcount']); $act_sum=$act_sum+$row['actcount'];?></a></td>
										<td><?php echo number_format($row['actamount']); $actamnt_sum=$actamnt_sum+$row['actamount'];?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='renew'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['renewcount']); $ren_sum=$ren_sum+$row['renewcount']; ?></a></td>
										<td><?php echo number_format($row['renewamount']); $renamnt_sum=$renamnt_sum+$row['renewamount'];?></td>
										<td><?php echo number_format($count=$row['totalcount']); $count_sum=$count_sum+$count; ?></td>
										<td><?php echo number_format($amount=$row['totalamount']); $amount_sum=$amount_sum+$amount;?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='churn'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['churn']); $churn_sum=$churn_sum+$row['churn'];?></a></td>
										<td><?php echo number_format($row['park']); $low_sum=$low_sum+$row['park']; ?></td>
										<td><a href="mehul_ajax/mehul_ajax.php?startdate=<?php echo $data['startdate']; ?>&enddate=<?php echo  $data['enddate'];?>&db=<?php echo $data['db'];?>&dblog=<?php echo $data['dblog'];?>&advertiser=<?php echo $data['advertiser'];?>&parameter='callback'&dat2=<?php echo $dat2;?>&operator=<?php echo $operator; ?>"><?php echo number_format($row['cbsent']); $cbsent_sum=$cbsent_sum+$row['park']; ?></a></td>
										<td><?php echo $row['cbsentpercent']."%"; ?></td>
										<td><?php echo number_format($advcost=$row['advamount']); $advcost_sum=$advcost_sum+$advcost; ?></td>
										
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
								
								
								
								
									<?php 
									}
									?>
							</tbody>
							
							
								
								
						</table>
						
					  </div>
				<!--<div id="advertiser"></div>-->
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
