<?php

include("connection.php");

$query = mysql_query("SELECT * FROM maps");
$rows_count = mysql_num_rows($query);

$sql2 = mysql_query("SELECT * FROM maps");
$rows2_count = 0;
while ($row = mysql_fetch_array($sql2))
{
	$busy = $row['busy'];
	if ($busy == 1)
	{
		$rows2_count = $rows2_count + 1;
	}
}

if ($rows2_count == $rows_count)
{
	echo 'Nu sunt taxiuri libere!<br />';
	echo '<a href="index.php">BACK</a>';
}
else
{
	$latS=(double)$_POST['LatS'];
	$lonS=(double)$_POST['LngS'];
	
	$latD=(double)$_POST['LatD'];
	$lonD=(double)$_POST['LngD'];
	
	$d_minS= 42000;
	
	$dD = distance($latD, $latS, $lonD, $lonS);
	
	while ($row = @mysql_fetch_assoc($retval2))
	{ 
		//echo $row['id'] . ' ' . $row['lat'] . ' ' . $row['lng']; //aici? same shit
		
		$dS=distance($latS, (double)$row['lat'], $lonS, (double)$row['lng']);
		
		if ($dS<$d_minS) {
			$d_minS=$dS;
			$id_minS=$row['id'];
		}	
		
		header('Location: index.php');
		
		//echo '    '. $dS;
		//echo '<br />';
		
		//echo $d_minS . '    '. $id_minS;
		
	}
	
		function distance($lat1, $lat2, $lon1, $lon2)
		{
			$distance  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2-$lon1));
			$distance  = acos($distance);
			$distance  = $distance * 6372.8;
			//$distance  = round($distance, 4);
			return $distance;
		}
	
	$sql="UPDATE maps SET busy=1 WHERE id='$id_minS'";
	$retval = mysql_query( $sql, $connection );
	if(! $retval )
	{
	  die('Could not enter data: ' . mysql_error());
	}
	
	$sql = "INSERT INTO comenzi_sursa(LatS, LngS, LatD, LngD, DistS, DistD, id_masina,done) ".
		   "VALUES ".
		   "('".$_POST['LatS']."','".$_POST['LngS']."','".$_POST['LatD']."','".$_POST['LngD']."','".$dS."','".$dD."','".$id_minS."',0)";
	
	$retval = mysql_query( $sql, $connection );
	if(! $retval )
	{
	  die('Could not enter data: ' . mysql_error());
	}
	//else
	  //   header('Location: index.php');
	}
	
	//if(! $sql2 )
	//{
	//	die('Could not enter data: ' . mysql_error());
	//}


?>
