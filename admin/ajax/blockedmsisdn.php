<?php
include("../includes/connection.php");

echo "<script>alert('sdf'); </script>";

echo $number=$_GET['number'];
echo $c=$_GET['c'];

if($c == 'check')
{
	
	$block1=mysql_query("insert into hotshotsdb1.blockedmsisdn (msisdn) values ('".$number."')");
	$block2=mysql_query("insert into hotshotsdb.blockedmsisdn (msisdn) values ('".$number."')");
	$block3=mysql_query("insert into hotshotsdb_idea.blockedmsisdn (msisdn) values ('".$number."')");
	$block4=mysql_query("insert into gamesdb_voda.blockedmsisdn (msisdn) values ('".$number."')");
}
else
{
	$block1=mysql_query("delete from hotshotsdb1.blockedmsisdn where msisdn ='".$number."' ");
	$block2=mysql_query("delete from hotshotsdb.blockedmsisdn where msisdn ='".$number."' ");
	$block3=mysql_query("delete from hotshotsdb_idea.blockedmsisdn where msisdn ='".$number."' ");
	$block4=mysql_query("delete from gamesdb_voda.blockedmsisdn where msisdn ='".$number."' ");
}	


?>