<?php 
//error_reporting(0);
$con=new mysqli("10.34.240.214","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$product=$_GET['product'];

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 
if($product == 'glambar' || $product == 'GLAMBAR')
{
		
			
			$sql_ad="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='glambar' order by operator asc ";
			$res_ad=mysqli_query($con,$sql_ad);
		
		
		
}
else if($product == 'Gamebar' || $product == 'gamebar')
{
	
	$sql_ad="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='gamebar' order by operator asc";
		$res_ad=mysqli_query($con,$sql_ad);
	
	
}
else if($product == '11players' || $product == '11Players')
{
	
	$sql_ad="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='11Players' order by operator asc";
		$res_ad=mysqli_query($con,$sql_ad);
}
else 
{
	
	$sql_ad="select * from gamebardb_vodafone_qatar_report.mainreportquery where product='contest' order by operator asc";
		$res_ad=mysqli_query($con,$sql_ad);
}


?>
                          
                        
	<select name="operator" id="operator" class="form-control select1_multiple"  onchange="myfun1()"required >
		<option value="all">All</option>
		<?php
		
		while($row_ad=mysqli_fetch_array($res_ad))
		{
			//echo $row_ad[0];exit;
		?>
		<!--<option value="<?php //echo $row_ad['operator']; ?>"><?php //echo $row_ad['operator']; ?></option>-->
		<?php
		}
		?>
		
	</select>

	
	
<!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select1_single").select1({
          placeholder: "Select",
          allowClear: true
        });
		
        $(".select1_group").select1({});
        $(".select1_multiple").select1({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->