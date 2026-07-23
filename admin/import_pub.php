<?php

include("includes/connection.php");

//$con=mysql_connect("43.231.124.191","webserveruser","K&dN&r4a8N@du0") or die(mysql_error()); // Old Back
error_reporting(0);


if(isset($_POST['hotshots_voda']))
{
	$sql="
		SELECT 
			pub, a.advertiserid
		FROM
			(SELECT DISTINCT
				CASE
						WHEN
							referrerurl LIKE '%subid%'
						THEN
							CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 20)
								AS UNSIGNED)
						ELSE CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 20)
							AS UNSIGNED)
					END pub,
					advertiserid
			FROM
				hotshotsdblog1.annonymoustracking
			HAVING pub > 0 AND advertiserid > - 1) a
				LEFT JOIN
			hotshotsdb1.pub_approval ON pub_approval.pub_id = a.pub
		WHERE
			pub_approval.pub_id IS NULL";
		
		$res=mysql_query($sql);
		
		while($row=mysql_fetch_array($res))
		{
			$sql1=mysql_query("insert into hotshotsdb1.pub_approval (pub_id,advertiserid) values ('".$row['pub']."','".$row['advertiserid']."')");
		}
	
}

if(isset($_POST['hotshots_idea']))
{
	$sql="
		SELECT 
			pub, a.advertiserid
		FROM
			(SELECT DISTINCT
				CASE
						WHEN
							referrerurl LIKE '%subid%'
						THEN
							CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 20)
								AS UNSIGNED)
						ELSE CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 20)
							AS UNSIGNED)
					END pub,
					advertiserid
			FROM
				hotshotsdblog_idea.annonymoustracking
			HAVING pub > 0 AND advertiserid > - 1) a
				LEFT JOIN
			hotshotsdb_idea.pub_approval ON pub_approval.pub_id = a.pub
		WHERE
			pub_approval.pub_id IS NULL";
		
		$res=mysql_query($sql);
		
		while($row=mysql_fetch_array($res))
		{
			$sql1=mysql_query("insert into hotshotsdb_idea.pub_approval (pub_id,advertiserid) values ('".$row['pub']."','".$row['advertiserid']."')");
		}
	
}


if(isset($_POST['hotshots_airtel']))
{
	$sql="
		SELECT 
			pub, a.advertiserid
		FROM
			(SELECT DISTINCT
				CASE
						WHEN
							referrerurl LIKE '%subid%'
						THEN
							CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 20)
								AS UNSIGNED)
						ELSE CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 20)
							AS UNSIGNED)
					END pub,
					advertiserid
			FROM
				hotshotsdblog_airtel1.annonymoustracking
			HAVING pub > 0 AND advertiserid > - 1) a
				LEFT JOIN
			hotshotsdb_airtel1.pub_approval ON pub_approval.pub_id = a.pub
		WHERE
			pub_approval.pub_id IS NULL";
		
		$res=mysql_query($sql);
		
		while($row=mysql_fetch_array($res))
		{
			$sql1=mysql_query("insert into hotshotsdb_airtel1.pub_approval (pub_id,advertiserid) values ('".$row['pub']."','".$row['advertiserid']."')");
		}
	
}

if(isset($_POST['games_voda']))
{
	$sql="
		SELECT 
			pub, a.advertiserid
		FROM
			(SELECT DISTINCT
				CASE
						WHEN
							referrerurl LIKE '%subid%'
						THEN
							CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 20)
								AS UNSIGNED)
						ELSE CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 20)
							AS UNSIGNED)
					END pub,
					advertiserid
			FROM
				gamesdblog_voda.annonymoustracking
			HAVING pub > 0 AND advertiserid > - 1) a
				LEFT JOIN
			gamesdb_voda.pub_approval ON pub_approval.pub_id = a.pub
		WHERE
			pub_approval.pub_id IS NULL";
		
		$res=mysql_query($sql);
		
		while($row=mysql_fetch_array($res))
		{
			$sql1=mysql_query("insert into gamesdb_voda.pub_approval (pub_id,advertiserid) values ('".$row['pub']."','".$row['advertiserid']."')");
		}
	
}

if(isset($_POST['games_idea']))
{
	$sql="
		SELECT 
			pub, a.advertiserid
		FROM
			(SELECT DISTINCT
				CASE
						WHEN
							referrerurl LIKE '%subid%'
						THEN
							CAST(SUBSTR(referrerurl, LOCATE('subid', referrerurl) + 6, 20)
								AS UNSIGNED)
						ELSE CAST(SUBSTR(referrerurl, LOCATE('pubid', referrerurl) + 6, 20)
							AS UNSIGNED)
					END pub,
					advertiserid
			FROM
				gamesdblog_idea.annonymoustracking
			HAVING pub > 0 AND advertiserid > - 1) a
				LEFT JOIN
			gamesdb_idea.pub_approval ON pub_approval.pub_id = a.pub
		WHERE
			pub_approval.pub_id IS NULL";
		
		$res=mysql_query($sql);
		
		while($row=mysql_fetch_array($res))
		{
			$sql1=mysql_query("insert into gamesdb_idea.pub_approval (pub_id,advertiserid) values ('".$row['pub']."','".$row['advertiserid']."')");
		}
	
}
?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Import New PubID </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					<div class="x_content">
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
							<p>Hotshots</p>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
						 
						  <input type="submit" name="hotshots_voda"  value="Hotshots Vodafone" class="btn btn-success">
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12">
						 
						  <input type="submit" name="hotshots_idea"  value="Hotshots Idea" class="btn btn-success">
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12">
						 
						  <input type="submit" name="hotshots_airtel"  value="Hotshots Airtel" class="btn btn-success">
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
							<p>Games</p>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
						 
						  <input type="submit" name="games_voda"  value="GameZone Vodafone" class="btn btn-success">
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12">
						 
						  <input type="submit" name="games_idea"  value="GameZone Idea" class="btn btn-success">
						</div>
						
						
						
						
					</div>
                    </form>
                  
                </div>
				
              
              </div>
            </div>
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Output Records</h2>
							<ul class="nav navbar-right panel_toolbox">
							  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							  </li>
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
								  <li><a href="#">Settings 1</a>
								  </li>
								  <li><a href="#">Settings 2</a>
								  </li>
								</ul>
							  </li>
							  <li><a class="close-link"><i class="fa fa-close"></i></a>
							  </li>
							</ul>
							<div class="clearfix"></div>
						</div>
						
			<?php 	
			if($count==1)
			{
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
							
								
								<tr>
									<td><strong>Date</strong></td>
									<td><strong>Requestresponse</strong></td>
									<td><strong>Callbackrequests</strong></td>									
									<td><strong>Callbackresponses</strong></td>									
									<td><strong>Subscriptiondetail</strong></td>								
									<td><strong>Annonymoustracking</strong></td>					
								</tr>
							</thead>


							<tbody>
								<?php 
								while((($row=mysql_fetch_array($res)) && ($row1=mysql_fetch_array($res1))) 
									|| (($row=mysql_fetch_array($res)) || ($row1=mysql_fetch_array($res1))))
								{
								
								?>
								<tr>
								
									<td><?php echo $row['dt1'];  ?></td>
									
									<?php 
									if($row['cnt1'] != $row1['cnt1'])
									{
									?>
										<td style="color:#ff0000;font-weight:bold;"><?php echo $row['cnt1']."-".$row1['cnt1'];  ?></td>
									<?php
									}
									else
									{
									?>
										<td style="color:#228900;font-weight:bold;"><?php echo $row['cnt1']."-".$row1['cnt1'];  ?></td>
									<?php
									}
									?>
									
									<?php 
									if($row['cnt2'] != $row1['cnt2'])
									{
									?>
										<td style="color:#ff0000;font-weight:bold;"><?php echo $row['cnt2']."-".$row1['cnt2'];  ?></td>
									<?php
									}
									else
									{
									?>
										<td style="color:#228900;font-weight:bold;"><?php echo $row['cnt2']."-".$row1['cnt2'];  ?></td>
									<?php
									}
									?>
									
									<?php 
									if($row['cnt3'] != $row1['cnt3'])
									{
									?>
										<td style="color:#ff0000;font-weight:bold;"><?php echo $row['cnt3']."-".$row1['cnt3'];  ?></td>
									<?php
									}
									else
									{
									?>
										<td style="color:#228900;font-weight:bold;"><?php echo $row['cnt3']."-".$row1['cnt3'];  ?></td>
									<?php
									}
									?>
									
									<?php 
									if($row['cnt4'] != $row1['cnt4'])
									{
									?>
										<td style="color:#ff0000;font-weight:bold;"><?php echo $row['cnt4']."-".$row1['cnt4'];  ?></td>
									<?php
									}
									else
									{
									?>
										<td style="color:#228900;font-weight:bold;"><?php echo $row['cnt4']."-".$row1['cnt4'];  ?></td>
									<?php
									}
									?>
									
									<?php 
									if($row['cnt5'] != $row1['cnt5'])
									{
									?>
										<td style="color:#ff0000;font-weight:bold;"><?php echo $row['cnt5']."-".$row1['cnt5'];  ?></td>
									<?php
									}
									else
									{
									?>
										<td style="color:#228900;font-weight:bold;"><?php echo $row['cnt5']."-".$row1['cnt5'];  ?></td>
									<?php
									}
									?>
									
																	
								</tr>
								<?php
								}
								
								?>

								
							</tbody>
		
						</table>
					  </div>
				
			<?php
			}
			else
			{}
			?>
					</div>
                </div>
			</div>
		</div>
        <!-- /page content -->
	<?php
	include("includes/footer.php");
	?>   		