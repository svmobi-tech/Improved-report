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
$action=$_GET['action'];
$product=$_GET['product'];
$country=$_GET['country'];



//$commondb="commondb";

	//ajax/make.php?operator="+operator+"&product="+product+"&callbackstop_perc="+callbackstop_perc+"&advertiserid="+advertiserid+"&type="+type+"&db="+database
	
				
						echo $update_advertiser="update gamebardb_vodafone_qatar_report.activationsetting set Action='".$action."' where Product='".$product."' and Country='".$country."'";
				
				$res_advertiser=mysqli_query($con,$update_advertiser);
				
				
		
	


?>