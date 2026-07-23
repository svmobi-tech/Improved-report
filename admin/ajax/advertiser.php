<?php 
//error_reporting(0);
include("../includes/connection.php");
//$con=new mysqli("10.125.1.51:3308","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$operator=$_GET['operator'];
$product=$_GET['product'];

//$con1=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());
//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 
	
			
			$sql="select * from gamebardb_vodafone_qatar_report.operatorurls where product='".$product."' and operatorname='".$operator."' ";
			$res=mysqli_query($con,$sql);
			
			while($row=mysqli_fetch_array($res))
			{
				$query=$row['advertiserquery'];
			}
			
			
			//echo $query;exit;
			
			$res_ad=mysqli_query($con,$query);


?>
                          
                        
	<select name="advertiserid" class="form-control select1_multiple"  required >
		
		<?php
		
		while($row_ad=mysqli_fetch_array($res_ad))
		{
			//echo $row_ad[0];exit;
		?>
		<option value="<?php echo $row_ad['advertiserid']; ?>"><?php echo $row_ad['advname']; ?></option>
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