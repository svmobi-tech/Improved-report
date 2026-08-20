<?php
require_once __DIR__ . '/../admin/includes/config.php';
//$con=mysql_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysql_error());//cluster1
//$con1=mysqli_connect("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1
$con2=mysqli_connect(DB_PROD_HOST, DB_USER, DB_PASS) or die(mysql_error());//cluster 2

$con1=$con2;

date_default_timezone_set("Asia/Calcutta");
echo $date1=date('Y-m-d',strtotime("-3 days"));
$start_date=$date1.' 00:00:00';
$end_date=$date1.' 23:59:59';
$operator=['gamebardb_vodafone_qatar'];
$activation=0;


//mysqli_query($con1,"DELETE FROM gamebardb_vodafone_qatar_report.`activation_report` WHERE `date`='".$date1."'");
for($i=1;$i<=24;$i++)
{
			$hvact=$oman=$malaysia=$saact=$sagact=$gindonesia=$ooredoo_qatar=$glambar_airtel=$gamebar_airtel=$gamebar_idea=$gamebar_voda=$glamour_idea=$glamour_voda=$gamerussia=$glamerussia=$gamebar_egypt=$gamebar_southafrica_intarget=$glambar_southafrica_intarget=$gamebar_italy=$dialog_srilanka=0;
			
			//vodacom
			$vodacom=0;
			if($result1 = $con1->query("call vodacom_za.getactivation('".$start_date."',  '".$end_date."', ".$i.") "))
			{
				$activation++;
				
			$rows=mysqli_num_rows($result1);
			
			while($row1=mysqli_fetch_array($result1))
			{
				$vodacom=$row1['act'];
				$gidate=$row1['dt'];
				
			}
			}
			//$result1->close();
			$con1->next_result();
			
			
			
					
					 $sql55="update gamebardb_vodafone_qatar_report.activation_report set vodacom_all='".$vodacom."' where date='".$date1."' and hour='".$i."'";
					 $result33=mysqli_query($con1,$sql55) or die($con1->error);
			
			
}																		

?>