<?php
//header('Content-type: application/csv');
//header('Content-Disposition: attachment; filename='.$filename);
//ini_set("memory_limit","328M");
//echo "hi<br>";
//include("../includes/check_session.php");
//include("../includes/connection.php");
//error_reporting(0);
//$con=mysql_connect("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysql_error());
$con=new mysqli("10.125.0.50:3307","webserveruser","K&dN&r4a8N@du567") or die(mysqli_error());

				$startdate=$_GET['startdate'];
				$enddate=$_GET['enddate'];
				$db=$_GET['db'];
				$dblog=$_GET['dblog'];
				$advertiser=$_GET['advertiser'];
			 	$parameter=$_GET['parameter'];
				$todate=$_GET['dat2'];
				$operator=$_GET['operator'];
				if ($operator=="Airtel")
				{
					exit;
				}
				$newdate = date("Y-m-d", strtotime($todate));
				$startdate1=$newdate." 00:00:00";
				$enddate1=$newdate." 23:59:59";
				$advertiser=$_GET['advertiser'];
				$result1 = mysqli_query($con,"SELECT min(date(`AccessTime`)) date FROM ".$dblog.".`annonymoustracking`");
				while ($row4 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
					{
						$date3=$row4['date'];
					}
			//	exit;
				if($date3>$newdate)
				{
					$con=new mysqli("43.231.124.191","productionuser","Zb8#fNIsXnoP12") or die(mysqli_error());
					$date2=explode('-',$newdate);
					//echo $date3;
					//echo "<br>".$newdate;
					//echo $todate;
					 $year=$date2[0];
					 $mon=$date2[1];
					//exit;
					if($mon==1)
					{
						$month='Jan';
					}else if($mon==2)
					{
						$month='Feb';
					}else if($mon==3)
					{
						$month='Mar';
					}else if($mon==4)
					{
						$month='Apr';
					}else if($mon==5)
					{
						$month='May';
					}else if($mon==6)
					{
						$month='Jun';
					}else if($mon==7)
					{
						$month='Jul';
					}else if($mon==8)
					{
						$month='Aug';
					}else if($mon==9)
					{
						$month='Sep';
					}else if($mon==10)
					{
						$month='Oct';
					}else if($mon==11)
					{
						$month='Nov';
					}else if($mon==12)
					{
						$month='Dec';
					}
					$dblog=$dblog."_".$month."_".$year;
					$db=$db."_".$month."_".$year;
					
				}
				$filename = $todate.$parameter.".csv";
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename='.$filename);
				if($parameter=="'clicks'" && $advertiser==="all")
				{

					$output="";

					$sql="SELECT *  FROM ".$dblog.".annonymoustracking WHERE accesstime >=  '".$startdate1."' AND accesstime <=  '".$enddate1."'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					//$filename = $todate.$parameter.".csv";
					//header('Content-type: application/csv');
					//header('Content-Disposition: attachment; filename='.$filename);
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
					
					fputcsv($fp, $row);
	
					}
					//echo "hi2";
					print_r($row);
					fclose($fp);

				}
				if($parameter=="'clicks'" && $advertiser != "all")
				{
					
					$output="";
					//echo "hi";exit;
					$sql="SELECT *  FROM ".$dblog.".annonymoustracking WHERE accesstime >=  '".$startdate1."' AND accesstime <=  '".$enddate1."' and `advertiserid`=".$advertiser;
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					//$filename = $todate.$parameter.".csv";
					//header('Content-type: application/csv');
					//header('Content-Disposition: attachment; filename='.$filename);
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
					
					fputcsv($fp, $row);
	
					}
					//echo "hi2";
					print_r($row);
					fclose($fp);

				}
				else if($parameter=="'uniq'" && $advertiser=="all")
				{
					$output="";

					$sql="SELECT *  FROM ".$dblog.".annonymoustracking WHERE accesstime >=  '".$startdate1."' AND accesstime <=  '".$enddate1."' GROUP BY  `UserID` ";

					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

					
					
				}else if($parameter=="'uniq'" && $advertiser != "all")
				{
					$output="";

					$sql="SELECT *  FROM ".$dblog.".annonymoustracking WHERE accesstime >=  '".$startdate1."' AND accesstime <=  '".$enddate1."' and `advertiserid`=".$advertiser." GROUP BY  `UserID` ";
					echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

					
					
				}
				else if($parameter=="'act'" && $advertiser=="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct mobilenumber,DATE(subscriptionstartdate) dt,LEFT(charging_mode, 3) typ,amount,subscriptionstartdate,CASE WHEN amount = 0 THEN 0 ELSE 1 END bal FROM ".$db.".subscriber INNER JOIN ".$db.".subscriptiondetail ON subscriber.subscriberid = subscriptiondetail.subscriberid WHERE subscriptionstartdate >= '".$startdate1."' AND subscriptionstartdate <= '".$enddate1."' AND (charging_mode LIKE '%ACT%' and amount > 0) ";

					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'act'" && $advertiser != "all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct mobilenumber,DATE(subscriptionstartdate) dt,LEFT(charging_mode, 3) typ,amount,subscriptionstartdate,CASE WHEN amount = 0 THEN 0 ELSE 1 END bal FROM ".$db.".subscriber INNER JOIN ".$db.".subscriptiondetail ON subscriber.subscriberid =subscriptiondetail.subscriberid inner join ".$dblog.".annonymoustracking on UserID=mobilenumber WHERE subscriptionstartdate >= '".$startdate1."' AND subscriptionstartdate <= '".$enddate1."' AND (charging_mode LIKE '%ACT%' and amount > 0) and advertiserid=".$advertiser." and accesstime>='".$startdate1."' and accesstime<= '".$enddate1."'";
					echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'act'" && $advertiser=="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="select distinct subscriptiondetail.subscriberid,subscriber.mobilenumber,subscriptionstartdate dt, amount, isrenew from ".$db.".subscriptiondetail inner join ".$db.".subscriber on subscriptiondetail.subscriberid=subscriber.subscriberid  where subscriptionstartdate >= '".$startdate1."' and subscriptionstartdate <= '".$enddate1."' and subscriptionstartdate < subscriptionenddate and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE) and isrenew = 0";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'act'" && $advertiser !="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="select distinct subscriber.mobilenumber,subscriptiondetail.subscriberid,subscriptionstartdate dt, amount, isrenew from ".$db.".subscriptiondetail inner join ".$db.".subscriber on subscriptiondetail.subscriberid=subscriber.subscriberid inner join ".$dblog.".annonymoustracking on UserID=subscriber.mobilenumber where accesstime <= '".$enddate1."' and accesstime >= '".$startdate1."' and advertiserid=".$advertiser." and subscriptionstartdate >= '".$startdate1."' and subscriptionstartdate <= '".$enddate1."' and subscriptionstartdate < subscriptionenddate and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE) and isrenew = 0";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'renew'" && $advertiser=="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct mobilenumber,DATE(subscriptionstartdate) dt,LEFT(charging_mode, 3) typ,amount,subscriptionstartdate,CASE WHEN amount = 0 THEN 0 ELSE 1 END bal FROM ".$db.".subscriber INNER JOIN ".$db.".subscriptiondetail ON subscriber.subscriberid = subscriptiondetail.subscriberid WHERE subscriptionstartdate >= '".$startdate1."' AND subscriptionstartdate <= '".$enddate1."' AND (charging_mode LIKE '%REN%' and amount > 0)";

					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'renew'" && $advertiser!="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct mobilenumber,DATE(subscriptionstartdate) dt,LEFT(charging_mode, 3) typ,amount,subscriptionstartdate,CASE WHEN amount = 0 THEN 0 ELSE 1 END bal FROM hotshotsdb_idea.subscriber INNER JOIN hotshotsdb_idea.subscriptiondetail ON subscriber.subscriberid = subscriptiondetail.subscriberid inner join ".$dblog.".annonymoustracking on UserID=mobilenumber WHERE subscriptionstartdate >= '".$startdate1."' AND subscriptionstartdate <= '".$enddate1."' AND (charging_mode LIKE '%REN%' and amount > 0)and advertiserid=".$advertiser;
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'renew'" && $advertiser=="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="select distinct subscriptiondetail.subscriberid,subscriber.mobilenumber,subscriptionstartdate dt, amount, isrenew from ".$db.".subscriptiondetail inner join ".$db.".subscriber on subscriptiondetail.subscriberid=subscriber.subscriberid  where subscriptionstartdate >= '".$startdate1."' and subscriptionstartdate <= '".$enddate1."' and subscriptionstartdate < subscriptionenddate and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE) and isrenew = 1";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'renew'" && $advertiser!="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="select distinct subscriptiondetail.subscriberid,subscriber.mobilenumber,subscriptionstartdate dt, amount, isrenew from ".$db.".subscriptiondetail inner join ".$db.".subscriber on subscriptiondetail.subscriberid=subscriber.subscriberid inner join ".$dblog1.".annonymoustracking on UserID=subscriber.mobilenumber where subscriptionstartdate >= '".$startdate1."' and subscriptionstartdate <= '".$enddate1."' and subscriptionstartdate < subscriptionenddate and subscriptionstartdate != SUBDATE(subscriptionenddate, INTERVAL 30 MINUTE) and isrenew = 1 and advertiserid=".$advertiser." and accesstime <='".$enddate1."' and accesstime >= '".$startdate1."'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'act'" && $advertiser=="all" && $operator=="Airtel")
				{
					$output="";

					$sql="SELECT DISTINCT mobilenumber, DATE( subscriptionstartdate ) sdt, amount FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid WHERE subscriptionstartdate >=  '".$startdate1."' AND subscriptionstartdate <=  '".$enddate1."' AND isrenew =0 AND amount >0 ";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'renew'" && $advertiser=="all" && $operator=="Airtel")
				{
					$output="";

					$sql="SELECT DISTINCT mobilenumber, DATE( subscriptionstartdate ) sdt, amount FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid WHERE subscriptionstartdate >=  '".$startdate1."' AND subscriptionstartdate <=  '".$enddate1."' AND isrenew =1 AND amount >0 ";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'churn'" && $advertiser=="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="SELECT subscriber.mobilenumber, subscriptiondetail.subscriberid, subscriptionstartdate dt, amount, isrenew, charging_mode FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid WHERE subscriptionstartdate >=  '".$startdate1."' AND subscriptionstartdate <=  '".$enddate1."' AND (charging_mode =  'null') AND amount =0 ";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'churn'" && $advertiser=="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct  subscriptiondetail.subscriberid,subscriber.mobilenumber,subscriptionstartdate dt, amount, isrenew, charging_mode FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid inner join hotshotsdblog_idea.annonymoustracking on userid=mobilenumber WHERE subscriptionstartdate >='".$startdate1."' AND subscriptionstartdate <='".$enddate1."' AND (charging_mode like '%DCT%') and accesstime >=  '".$startdate1."' and accesstime <= '".$enddate1."'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'callback'" && $advertiser=="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct msisdn,requesturl,response,requesttime,responsetime,requestresponse.advertiserid  FROM hotshotsdb.requestresponse inner join hotshotsdblog_idea.annonymoustracking on userid=msisdn WHERE responsetime <='".$enddate1."' and responsetime >=  '".$startdate1."'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'callback'" && $advertiser=="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="SELECT DISTINCT msisdn, requesturl, response, requesttime, responsetime, requestresponse.advertiserid FROM ".$db.".requestresponse WHERE responsetime >=  '".$startdate1."' AND responsetime <=  '".$enddate1."'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				
				
				
				
				else if($parameter=="'churn'" && $advertiser!="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="SELECT subscriber.mobilenumber, subscriptiondetail.subscriberid, subscriptionstartdate dt, amount, isrenew, charging_mode FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid inner join ".$dblog.".annonymoustracking on UserID=subscriber.mobilenumber where accesstime <= '".$enddate1."' and accesstime >= '".$startdate1."' and advertiserid=10 and subscriptionstartdate >= '".$startdate1."' AND subscriptionstartdate <= '".$enddate1."' AND (charging_mode = 'null') AND amount =0  ";
					
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'churn'" && $advertiser!="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct  subscriptiondetail.subscriberid,subscriber.mobilenumber,subscriptionstartdate dt, amount, isrenew, charging_mode FROM ".$db.".subscriptiondetail INNER JOIN ".$db.".subscriber ON subscriptiondetail.subscriberid = subscriber.subscriberid inner join hotshotsdblog_idea.annonymoustracking on userid=mobilenumber WHERE subscriptionstartdate >='".$startdate1."' AND subscriptionstartdate <='".$enddate1."' AND (charging_mode like '%DCT%') and accesstime >=  '".$startdate1."' and accesstime <= '".$enddate1."' and advertiserid=".$advertiser;
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'callback'" && $advertiser!="all" && $operator=="Idea")
				{
					$output="";

					$sql="SELECT distinct msisdn,requesturl,response,requesttime,responsetime,requestresponse.advertiserid FROM ".$db.".requestresponse inner join ".$dblog.".annonymoustracking on userid=msisdn WHERE responsetime <='2017-01-01 23:59:59' and responsetime >= '2017-01-01 00:00:00' and annonymoustracking.advertiserid=8 and accesstime <='2017-01-01 23:59:59' and accesstime >= '2017-01-01 00:00:00'";
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				else if($parameter=="'callback'" && $advertiser!="all" && $operator=="Vodafone")
				{
					$output="";

					$sql="SELECT DISTINCT msisdn, requesturl, response, requesttime, responsetime, requestresponse.advertiserid FROM ".$db.".requestresponse WHERE responsetime >=  '".$startdate1."' AND responsetime <=  '".$enddate1."' and advertiserid=".$advertiser;
					//echo $sql;exit;
					$result = mysqli_query($con,$sql);
					
					$fp = fopen('php://output', 'w');

				
					$i=0;
					while ($fieldinfo=mysqli_fetch_field($result))
					{
						$output[$i]=$fieldinfo->name;
						$i++;
					}
	
					fputcsv($fp, $output);
			
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

					fputcsv($fp, $row);
	
					}

					fclose($fp);

				}
				
				
				
				//SELECT * FROM annonymoustracking WHERE AccessTime >=  "2016-12-25 00:00:00" AND AccessTime <=  "2016-12-25 23:59:59" GROUP BY  `UserID` 
?>
