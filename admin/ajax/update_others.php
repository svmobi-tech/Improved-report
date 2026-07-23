<?php
include("../includes/connection.php");

$product=$_GET['product'];
$operator=$_GET['operator'];
$val=$_GET['val'];
$ad=$_GET['ad'];
$c=$_GET['c'];


if($product == 'Hotshots')
{
	
	if($operator == 'Vodafone')
	{
		if($ad == 'all')
		{
			
			if($c == 'check')
			{
				$sql="update hotshotsdb1.pub_approval set others_blackout = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb1.pub_approval set others_blackout = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb1.pub_approval set others_blackout = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb1.pub_approval set others_blackout = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		
	}
	else
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb_idea.pub_approval set others_blackout = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb_idea.pub_approval set others_blackout = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb_idea.pub_approval set others_blackout = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb_idea.pub_approval set others_blackout = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		
	}

}
else
{
	if($operator == 'Vodafone')
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update gamesdb_voda.pub_approval set others_blackout = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb_voda.pub_approval set others_blackout = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update gamesdb_voda.pub_approval set others_blackout = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb_voda.pub_approval set others_blackout = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
	}
	else
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update gamesdb.pub_approval set others_blackout = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb.pub_approval set others_blackout = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update gamesdb.pub_approval set others_blackout = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb.pub_approval set others_blackout = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
	}	
}

?>