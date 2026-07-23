<?php
include("../includes/connection.php");
$con=new mysqli("10.34.240.214","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$calldata=strtolower($_GET['callbacktype']);
$operator=strtolower($_GET['operator']);
$product=strtolower($_GET['product']);
$callbackstop_perc=$_GET['callbackstop_perc'];

$callbackstop_perc1=round($_GET['callbackstop_perc']/10);
$advertiserid=$_GET['advertiserid'];
$db=$_GET['db'];
$advtable=$_GET['advtable'];
$condition=$_GET['condition'];



//$commondb="commondb";

	//ajax/make.php?operator="+operator+"&product="+product+"&callbackstop_perc="+callbackstop_perc+"&advertiserid="+advertiserid+"&type="+type+"&db="+database
	
				if($advertiserid=='mehul')
				{
					if($condition=='')
					{
						echo	$update_advertiser="update ".$db.".".$advtable." set ".$calldata." ='".$callbackstop_perc."'";
					}
					else{
						echo	$update_advertiser="update ".$db.".".$advtable." set ".$calldata." ='".$callbackstop_perc."' $condition";
						
					}
				
				}
				else{
					
					if($condition=='')
					{
						echo $update_advertiser="update ".$db.".".$advtable." set ".$calldata." ='".$callbackstop_perc."' where advertiserid = '".$advertiserid."'";
					}
					else{
						echo $update_advertiser="update ".$db.".".$advtable." set ".$calldata." ='".$callbackstop_perc."' $condition and  advertiserid = '".$advertiserid."'";
						
					}
				
				}
				$res_advertiser=mysqli_query($con,$update_advertiser);
				
				
		
	


?>