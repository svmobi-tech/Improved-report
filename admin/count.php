<?php 

$con=mysql_connect("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysql_error()); // Live Server
$con1=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back

$id='';
echo $sql="select * from hotshotsdb1.callbackrequests where requesttime  >= '2016-11-03 00:00:00' and  requesttime < '2016-11-03 23:59:59'"; 
$res=mysql_query($sql,$con);

$num=mysql_num_rows($res);
$num; 
while($row=mysql_fetch_array($res))
{
	$sql1="select * from hotshotsdb1_Nov_2016.callbackrequests where  requesttime >= '2016-11-03 00:00:00' and  requesttime < '2016-11-03 23:59:59'
	and requestid = '".$row['requestid']."' "; 
	$res1=mysql_query($sql1,$con1);
	$row1=mysql_num_rows($res1);
	if($row1 == 0)
	{
		$id.=$row['requestid'].",</br>";
	}
	else
	{}
		
	
}

echo $id;
	
?>