<?php 
include("../include/connection.php");
$db=$_POST['db'];
$sql = "SHOW TABLES FROM $db";
$result = mysql_query($sql);
?>
<label>Select Table</label>
	<select name="table" class="form-control select2">
		<option value="">Select Table</option>
		<?php
		while($row1=mysql_fetch_array($result))
		{
		?>
		<option value="<?php echo $row1[0]; ?>"><?php echo $row1[0]; ?></option>
		<?php
		}
		?>
	</select>
