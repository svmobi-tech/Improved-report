<?php 
include("../includes/connection.php");

$operator=$_GET['operator'];
$product=$_GET['product'];

//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 

if($product == 'hotshots' || $product == 'Hotshots')
{
	if($operator == 'Vodafone')
	{
		$sql11="select * from hotshotsdblog1.advertiser where operator=1 ";
		$res11=mysql_query($sql11);
		
	}
	else
	{
		
		$sql11="select * from hotshotsdblog1.advertiser where operator = 2 ";
		$res11=mysql_query($sql11);
	}
}
else
{
	if($operator == 'Vodafone')
	{
		$sql11="select * from gamesdblog_idea.advertiser where operator=1";
		$res11=mysql_query($sql11);
		
	}
	else
	{
	
		$sql11="select * from gamesdblog_idea.advertiser where operator = 2";
		$res11=mysql_query($sql11);
	}
}



?>
                          
                        
	<select name="advertiserid" class="form-control select2_multiple" id="ad"  required >
		<option value="0">Select Advertiser</option>
		<?php
		while($row_ad=mysql_fetch_array($res11))
		{

		?>
		<option value="<?php echo $row_ad[0]; ?>"><?php echo $row_ad[1]; ?></option>
		<?php
		}
		?>
		
	</select>

	
	
<!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->