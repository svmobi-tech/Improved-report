<?php
function login($email,$password)
{
	$sql="select * from admin_tbl where admin_email='$email' and admin_password='$password' ";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$num=mysql_num_rows($res);
	$_SESSION['aid']=$row['admin_id'];

	if($row > 0)
	{
		echo "<script>window.location='dashboard.php'</script>";
	}
	else
	{
		echo "<script>alert('Username and Password doest not match.');</script>";
	}
}
?>