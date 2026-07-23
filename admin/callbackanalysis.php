<?php

ini_set('max_execution_time', 6000000);
error_reporting(0);
include("includes/check_session.php");
if($_SESSION['admin']==0)
{
	//echo "<script>alert('you are not allow to use this report');</script>";
	//			echo "<script>window.location='report.php'</script>";
	//header('location:report.php');
}
//include("includes/connection.php");
date_default_timezone_set("Asia/Calcutta");

$con=new mysqli("10.34.240.214","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2
$con3=new mysqli("10.34.240.214","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster 2





//$con1=new mysqli("10.125.0.50","webserveruser","K&dN&r4a8N@du0") or die(mysqli_error());//cluster1

$con1=$con;
$start_date='';
$end_date='';
$country='';
$product='';
$count=0;
$cc=0;
$sql_ad="select distinct(country) country from gamebardb_vodafone_qatar_report.mainreport ";
$res_op=mysqli_query($con,$sql_ad);
$year=date('Y');
$month=date('m');

$year1=$year;
$month1=$month;

if(isset($_POST['submit']))
{

$count=1;
$country=$_POST['country'];
$year=$_POST['year'];
$month=$_POST['month'];



$start_date=$year."-".$month."-01 00:00:00";
$enddate=date("Y-m-t", strtotime($start_date));
$end_date=$enddate." 23:59:59";
$eday=date("t", strtotime($enddate));

$laststartdate=date("Y-m-d",strtotime($start_date." -1 months"));
$lastenddate=date("Y-m-d",strtotime($start_date." -1 days"));

//exit;
if($month==$month1 && $year1==$year)
{
	$date1=date('d',strtotime('-1 days'));
	$e=0;
}
else{
	
	$date1=date("t", strtotime($enddate));
	$e=1;
	
}

//echo $date1;exit;
//print_r($_POST);
//exit;
if($e==0)
{

  $sql="SELECT 
    e.country,
    actcount,
    actamount * toinr actamount,
    renewcount,
    renewamount * toinr renewamount,
    totalcount,
    totalamount * toinr totalamount,
	cbsent,
    digiinvest * toinr digiinvest,
    revenueshare * toinr revenueshare,
	g.ptotalamount lastmonthrevenue
FROM
    (SELECT 
        country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            sum(digiinvest) digiinvest,
            sum(revenueshare) revenueshare
    FROM
        (SELECT 
        country,
            a.product,
            a.operator,
            actcount,
            actamount,
            renewcount,
            renewamount,
            totalcount,
            totalamount,
            cbsent,
            b.operator_cost,
			cbsent*b.operator_cost digiinvest,
            c.revenueshare revenueshare1,
			totalamount * revenueshare revenueshare
			
    FROM
        (SELECT 
        product,
            country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            operator
    FROM
        gamebardb_vodafone_qatar_report.`mainreport`
    WHERE
        `advertiser` = '0'
            AND `Date` >= '".$start_date."'
            AND Date <= '".$end_date."'
			AND operator != 'ZA_Vodacom_BT'
            AND operator != 'ZA_Vodacom_FG'
            AND operator != 'ZA_Vodacom'
            AND operator != 'ZA_Vodacom_WFH'
            AND operator != 'Thailand_9305_dtac'
            AND operator != 'Thailand_9305_Ais'
            AND operator != 'Thailand_new_9005_Ais'
            AND operator != 'Thailand_new_9005_Dtac'
            AND operator != 'Thailand_Old_7201_Dtac'
            AND operator != 'Thailand_Old_7201_Ais'
            AND operator != 'KSA_Weekly_Mobily'
            AND operator != 'KSA_Weekly_STC'
            AND operator != 'KSA_Weekly_zain'
            AND operator != 'KSA_Daily_Mobily'
            AND operator != 'KSA_Daily_STC'
            AND operator != 'KSA_Daily_zain'
    GROUP BY operator,product,country) a
    LEFT JOIN (SELECT 
        operator, operator_cost
    FROM
        gamebardb_vodafone_qatar_report.operatorcost) b ON a.operator = b.operator
    LEFT JOIN (SELECT 
        operator, revenueshare
    FROM
        gamebardb_vodafone_qatar_report.svmobi_revenueshare) c ON a.operator = c.operator
    GROUP BY operator,country,product,operator_cost,revenueshare) dd
    GROUP BY country) e
        INNER JOIN
    (SELECT 
        *
    FROM
        gamebardb_vodafone_qatar_report.currency) f ON e.country = f.country 
		left join 
		(select country,ptotalamount from gamebardb_vodafone_qatar_report.dashboard where date>='".$laststartdate."' and date <='".$lastenddate."' )g on g.country=e.country
		
		where totalcount>0";
	
	
			$res=mysqli_query($con,$sql);
			
			
			 $sql3="select SUM(ptotalamount)plasttotalamount from gamebardb_vodafone_qatar_report.dashboard where date>='".$laststartdate."' and date <='".$lastenddate."'";
			//echo $sql3;exit;
			$res3=mysqli_query($con,$sql3);
			
}else{
	
	$sql="SELECT 
    e.country,
    actcount,
    actamount * toinr actamount,
    renewcount,
    renewamount * toinr renewamount,
    totalcount,
    totalamount * toinr totalamount,
	cbsent,
    digiinvest * toinr digiinvest,
    revenueshare * toinr revenueshare,
	g.ptotalamount lastmonthrevenue
FROM
    (SELECT 
        country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            sum(digiinvest) digiinvest,
            sum(revenueshare) revenueshare
    FROM
        (SELECT 
        country,
            a.product,
            a.operator,
            actcount,
            actamount,
            renewcount,
            renewamount,
            totalcount,
            totalamount,
            cbsent,
            b.operator_cost,
			cbsent*b.operator_cost digiinvest,
            c.revenueshare revenueshare1,
			totalamount * revenueshare revenueshare
			
    FROM
        (SELECT 
        product,
            country,
            SUM(`actcount`) actcount,
            SUM(`actamount`) actamount,
            SUM(`renewcount`) renewcount,
            SUM(`renewamount`) renewamount,
            SUM(`totalcount`) totalcount,
            SUM(`totalamount`) totalamount,
            SUM(`cbsent`) cbsent,
            operator
    FROM
        gamebardb_vodafone_qatar_report.`mainreport`
    WHERE
        `advertiser` = '0'
            AND `Date` >= '".$start_date."'
            AND Date <= '".$end_date."'
			AND operator != 'ZA_Vodacom_BT'
            AND operator != 'ZA_Vodacom_FG'
            AND operator != 'ZA_Vodacom'
            AND operator != 'ZA_Vodacom_WFH'
            AND operator != 'Thailand_9305_dtac'
            AND operator != 'Thailand_9305_Ais'
            AND operator != 'Thailand_new_9005_Ais'
            AND operator != 'Thailand_new_9005_Dtac'
            AND operator != 'Thailand_Old_7201_Dtac'
            AND operator != 'Thailand_Old_7201_Ais'
            AND operator != 'KSA_Weekly_Mobily'
            AND operator != 'KSA_Weekly_STC'
            AND operator != 'KSA_Weekly_zain'
            AND operator != 'KSA_Daily_Mobily'
            AND operator != 'KSA_Daily_STC'
            AND operator != 'KSA_Daily_zain'
    GROUP BY operator,product,country) a
    LEFT JOIN (SELECT 
        operator, operator_cost
    FROM
        gamebardb_vodafone_qatar_report.operatorcost) b ON a.operator = b.operator
    LEFT JOIN (SELECT 
        operator, revenueshare
    FROM
        gamebardb_vodafone_qatar_report.svmobi_revenueshare) c ON a.operator = c.operator
    GROUP BY operator,country,product,operator_cost,revenueshare) dd
    GROUP BY country) e
        INNER JOIN
    (SELECT 
        *
    FROM
        gamebardb_vodafone_qatar_report.currency) f ON e.country = f.country 
		left join 
		(select country,ptotalamount from gamebardb_vodafone_qatar_report.dashboard where date>='".$laststartdate."' and date <='".$lastenddate."' )g on g.country=e.country
		
		where totalcount>0";
	
	//echo $sql;exit;
			$res=mysqli_query($con,$sql);
			
			
			 $sql3="select SUM(ptotalamount)plasttotalamount from gamebardb_vodafone_qatar_report.dashboard where date>='".$laststartdate."' and date <='".$lastenddate."'";
			//echo $sql3;exit;
			$res3=mysqli_query($con,$sql3);
	
}			

$start_date2=$start_date;
$end_date2=$end_date;

}

?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            
			<style>

.table>thead>tr>td{
	
	vertical-align:middle;
	padding:0px; !important
	}
	
 .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th
{
	border:1px solid #101010 !important;
}
 .table-bordered>thead>tr>td, .table-bordered>thead>tr>th
 {
	border:1px solid #f7f7f7 !important;
}

</style>

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						
						
							
							
						
						<!--<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php// if($start_date!=''){ echo date('d-m-Y',strtotime($start_date2)); } else { echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php //if($end_date!=''){echo date('d-m-Y',strtotime($end_date2));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						-->
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Month
						<select name="month" class="form-control" id="month" >
							<option value="01" <?php if($month=="01"){$selected='selected';}else{$selected='';} echo $selected; ?>>January</option>
							<option value="02" <?php if($month=="02"){$selected='selected';}else{$selected='';} echo $selected; ?> >February</option>
							<option value="03" <?php if($month=="03"){$selected='selected';}else{$selected='';} echo $selected; ?> >March</option>
							<option value="04" <?php if($month=="04"){$selected='selected';}else{$selected='';} echo $selected; ?> >April</option>
							<option value="05" <?php if($month=="05"){$selected='selected';}else{$selected='';} echo $selected; ?> >May</option>
							<option value="06" <?php if($month=="06"){$selected='selected';}else{$selected='';} echo $selected; ?> >June</option>
							<option value="07" <?php if($month=="07"){$selected='selected';}else{$selected='';} echo $selected; ?> >July</option>
							<option value="08" <?php if($month=="08"){$selected='selected';}else{$selected='';} echo $selected; ?> >August</option>
							<option value="09" <?php if($month=="09"){$selected='selected';}else{$selected='';} echo $selected; ?> >September</option>
							<option value="10" <?php if($month=="10"){$selected='selected';}else{$selected='';} echo $selected; ?> >October</option>
							<option value="11" <?php if($month=="11"){$selected='selected';}else{$selected='';} echo $selected; ?> >November</option>
							<option value="12" <?php if($month=="12"){$selected='selected';}else{$selected='';} echo $selected; ?> >December</option>
							
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Year
						<select name="year" class="form-control" id="year" >
							<option value="2018" <?php if($year=='2018'){$selected='selected';}else{$selected='';} echo $selected; ?>>2018</option>
							<option value="2019" <?php if($year=='2019'){$selected='selected';}else{$selected='';} echo $selected; ?>>2019</option>
							<option value="2020" <?php if($year=='2020'){$selected='selected';}else{$selected='';} echo $selected; ?>>2020</option>
							<option value="2021" <?php if($year=='2021'){$selected='selected';}else{$selected='';} echo $selected; ?> >2021</option>
							
						</select>
						
						</div>

						
						
						
	
						
						<div class="ccol-md-2 col-sm-2 col-xs-12 form-group has-feedback">
						 <br>
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						
						
			<?php 
			//echo $country;
			
				
			
				//echo $cc;exit;
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
					  <input type="button" onclick="tableToExcel('dataTables-example', 'W3C Example Table')" value="Export to Excel"><br><br>
						
												<table id="dataTables-example" class="table table-striped table-bordered">
							<thead style="background:#001a33;color:white">
							<tr><td><b>Country</b></td>
							<td><b>callbacksents</b></td>
							<td rowspan='2'><b>Digital<br>Investment</b></td>
							</tr>
							
							
								
							</thead>


							<tbody>
								<?php
								$totalact=$totalcbsent=$totalrenewcount=$totalrenewamount=$totaltotalcount=$totaltotalamount=$totaldigiinvest=$totalrevenue=$totalprofit=$totalptotal=$totalpdigitin=$totalprevenue=$totalpprofit=0;;
								while($row=mysqli_fetch_array($res))
								{
									$i=0;
									if($row['revenueshare']-$row['digiinvest'] < 0)
									{
										$i=1;
									}
									
								?>
									<tr <?php if($i==1){?> <?php }?>  style="background:white;color:Black">
									
									<!-- $sql="SELECT country,sum(`actcount`)actcount,sum(`actamount`)actamount,sum(`renewcount`)renewcount,sum(`renewamount`)renewamount,sum(`totalcount`)totalcount,sum(`totalamount`)totalamount,sum(`cbsent`) cbsent FROM gamebardb_vodafone_qatar_report.`mainreport` WHERE `advname`='all' and `Date`>='".$start_date."' and Date <='".$end_date."' group by country";-->
									<?php
									
									
									$country=$row['country'];
									
									$cbsent=$row['cbsent'];
									$totalcbsent=$totalcbsent+$cbsent;
									$totalact=$totalact+$actcount;
									$actamount=$row['actamount'];
									$totalactamount=$totalactamount+$actamount;
									$renewcount=$row['renewcount'];
									$totalrenewcount=$totalrenewcount+$renewcount;
									$renewamount=$row['renewamount'];
									$totalrenewamount=$totalrenewamount+$renewamount;
									$totalcount=$row['totalcount'];
									$totaltotalcount=$totaltotalcount+$totalcount;
									$totalamt=$row['totalamount'];
									$totaltotalamount=$totaltotalamount+$totalamt;
									$digitin=$row['digiinvest'];
									$totaldigiinvest=$totaldigiinvest+$digitin;
									$revenue=$row['revenueshare'];
									$totalrevenue=$totalrevenue+$revenue;
									$profit=$row['revenueshare']-$row['digiinvest'];
									$totalprofit=$totalprofit+$profit;
									$ptotal=$totalamt*$eday/$date1;
									$totalptotal=$totalptotal+$ptotal;
									$pdigitin=$digitin*$eday/$date1;
									$totalpdigitin=$totalpdigitin+$pdigitin;
									$prevenue=$revenue*$eday/$date1;
									$totalprevenue=$totalprevenue+$prevenue;
									$pprofit=$profit*$eday/$date1;
									$totalpprofit=$totalpprofit+$pprofit;
									
									?>
										<tr>
										<td style="background:grey;color:white"><b><?php echo $country;?></b> </td>
										<td><b><?php echo $cbsent;?></b> </td>
										
										<td><?php echo number_format($digitin,0,'.',',');?> </td>
										
									</tr>
								<?php
								}
								?>
								<tr style="background:#001a33;color:white; " >
								
								<td><b>Grand Total</b></td>
								<td><?php echo number_format($totalcbsent,0,'.',',');?> </td>
										
										<td><b><?php echo number_format($totaldigiinvest,0,'.',',');?></b> </td>
										
								
								</tr>
								
								
								
							</tbody>
							
							
								
								
						</table>
					  </div>
				<!--<div id="advertiser"></div>-->
			
					</div>
                </div>
			</div>
			
		</div>
        <!-- /page content -->
		
       <?php
	   include("includes/footer.php");
		?>
		
<script type="text/javascript">
 
</script>		
		
		
		
		
		
<script type="text/javascript">
 $(document).ready(function(){

   $("#product").change(function(){
		
		var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel1").val('');
			$("#t1").hide();
			$("#f1").show();
						
		}
       
		var product = $("#product").val();
        $.ajax({
            type: "GET",
            url: "ajax/find_country.php?product="+product         
			
        }).done(function(data){
            $(".response1").html(data);
			 
        });
    });
});
</script>
<script type="text/javascript">
function myfun1() {
var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel").val('');
			$("#t").hide();
			$("#f").show();
						
		}
        var country = $("#country").val();
		var product = $("#product").val();
        $.ajax({
            type: "GET",
            url: "ajax/advertiser.php?country="+country+"&product="+product         
			
        }).done(function(data){
            $(".response").html(data);
			 
        });

}	
</script>		




<script>
 function getdata(startdate,enddate,db,dblog,advertiser,parameter){

  
  if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("advertiser").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","mehul_ajax/mehul_ajax.php?startdate="+startdate+"&enddate="+enddate+"&db="+db+"&dblog="+dblog+"&advertiser="+advertiser+"&parameter="+parameter,true);
        xmlhttp.send();
    }
 
 </script>   
 <script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
