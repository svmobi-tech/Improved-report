<?php
include("includes/check_session.php");
include("includes/connection.php");

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); //cluster 1
$con1=$con;
error_reporting(0);


 $sql="select * from gamebardb_vodafone_qatar_report.operatorcost";
				//echo $sql;
			
			$res=mysql_query($sql,$con);




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
                    <h2>Update advertising cost</h2>
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
										
										<td><strong>product</strong></td>
										<td><strong>operator</strong></td>
										<td><strong>operator-cost</strong></td>
										<td><strong>Last-Update</strong></td>
	
									</tr>
								</thead>


								<tbody>
								<?php
									/*<input type='hidden' name='id' id='id' value='<?php echo $row['id']; ?>' >
								
									if($perc > 15){echo "<span style='color:red;'>".$perc."</span>";}else{echo "<span style='color:green;'>".$perc."</span>";}
									*/
									$date2=date('Y-m-d',strtotime("-1 days"));
									$date2=$date2." 23:59:59";
									while($row=mysql_fetch_array($res))
									{
										
								?>
									<tr>
										<td><?php echo $row['product']; ?></td>
										<td><?php echo $row['operator_name']; ?></td>
										
										<td><input type='text' name='operatorcost' id='' onblur="myFunction()" value="<?php echo $row['operator_cost']; ?>" ></td>
										<td> <?php echo $row['lastupdate']; ?> </td>
										
									</tr>
								<?php
								//echo "perc= ".$row['perc'];
									}
									
								
									
								?>
								
								
								</tbody>
								
							
							
							<input type='submit' name='submit'>
							
							
								
								
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
	   
	  <script type="text/javascript">
	/*	$(document).ready(function(){

		   $("#operatorcost").change(function(){
				
				alert('operator');
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
		});*/
	   </script>
	   
  <script type="text/javascript">
  function myFunction() {
    var x = document.getElementById("operatorcost");
    x.value = x.value.toUpperCase();
	
	//alert('xyz');
}
  
  </script>
	   