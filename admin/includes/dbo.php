<?php
function login($email,$password)
{
	$sql="select * from admin_tbl where admin_email='$email' and admin_password='$password' ";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$num=mysql_num_rows($res);
	$_SESSION['aid']=$row['admin_id'];

	if($num > 0)
	{
		echo "<script>window.location='perform.php'</script>";
	}
	else
	{
		echo "<script>alert('Username and Password doest not match.');</script>";
	}
}


function do_register($adv_name,$adv_email,$adv_number,$adv_website,$adv_password,$adv_hs_advertiser,$adv_gm_advertiser)
{
	$sql="insert into advertiser_tbl (adv_name,adv_number,adv_website,adv_email,adv_password,adv_hs_advertiser,adv_gm_advertiser) 
	values ('$adv_name','$adv_number','$adv_website','$adv_email','$adv_password','$adv_hs_advertiser','$adv_gm_advertiser')";
	$res=mysql_query($sql);
	
}








?>