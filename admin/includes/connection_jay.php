<?php
//$conn = mysql_connect('10.125.0.50','productionuser','Zb8#fNIsXnoP12') or die(mysql_error()); //localhost connection query
$conn = new PDO("mysql:host=10.34.240.214;", 'webserveruser', 'K&dN&r4a8N@du0') or die(print_r($conn->error));

date_default_timezone_set("Asia/Kolkata");

error_reporting(0);




?>
