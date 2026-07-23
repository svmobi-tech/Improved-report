<?php 
include("../includes/connection.php");

$operator=$_GET['operator'];
$product=$_GET['product'];
$adv=$_GET['adv'];

//echo "<script>alert('".$adv."');</script>"; 

if($adv=='yeahmobi')
{
	
	if($product=='Hotshots')
	{
		
		//echo "<script>alert('".$operator."');</script>"; 
		if($operator == 'Vodafone')
		{
			
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 10 limit 10";
			$res11=mysql_query($sql11);
			
		}
		else
		{
			
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,71,6) AS UNSIGNED) ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 8 limit 10";
			$res11=mysql_query($sql11);
		}
	}
	else
	{
		//echo "<script>alert('".$operator."');</script>"; 
		if($operator == 'Vodafone')
		{
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_voda.annonymoustracking where advertiserid = 14 limit 10";
			$res11=mysql_query($sql11);
			
		}
		else
		{
			
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 1 limit 10";
			$res11=mysql_query($sql11);
		}
	}
}
else
{
	if($product=='Hotshots')
	{
		//echo "<script>alert('".$operator."');</script>"; 
		if($operator == 'Vodafone')
		{
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,87) AS UNSIGNED) ref from hotshotsdblog1.annonymoustracking where advertiserid = 39 limit 10";
			$res11=mysql_query($sql11);
			
		}
		else
		{
			
			$sql11="select  DISTINCT SUBSTRING(referrerURL,89)  ref from hotshotsdblog_idea.annonymoustracking where advertiserid = 40 limit 10";
			$res11=mysql_query($sql11);
		}
	}
	else
	{
		//echo "<script>alert('".$operator."');</script>"; 
		if($operator == 'Vodafone')
		{
			echo "<script>alert('hw');</script>"; 
			$sql11="select  DISTINCT SUBSTRING(referrerURL,88)  ref from gamesdblog_voda.annonymoustracking where advertiserid = 19 limit 10;";
			$res11=mysql_query($sql11);
			
		}
		else
		{
			
			$sql11="select  DISTINCT CAST(SUBSTRING(referrerURL,72,6) AS UNSIGNED) ref from gamesdblog_idea.annonymoustracking where advertiserid = 20 limit 10";
			$res11=mysql_query($sql11);
		}
	}
}

?>

<select name="pubid" class="form-control select2_single  ">
	<option value="all">All</option>
	<?php
		
	while($row11=mysql_fetch_array($res11))
	{
		
	?>
	<option value="<?php echo $row11['ref']; ?>"><?php echo $row11['ref'];?></option>
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
	