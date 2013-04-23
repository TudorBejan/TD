<?php

include("connection.php");

$latS = (double)$_POST['LatS'];
$lonS = (double)$_POST['LngS'];

$latD = (double)$_POST['LatD'];
$lonD = (double)$_POST['LngD'];

$d_minS = 42000;

function distance($lat1, $lat2, $lon1, $lon2)
{
	$distance  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2-$lon1));
	$distance  = acos($distance);
	$distance  = $distance * 6372.8;
	//$distance  = round($distance, 4);
	return $distance;
}
	
$dD = distance($latD, $latS, $lonD, $lonS);

$query = mysql_query("SELECT * FROM maps");
$count_maps_rows = mysql_num_rows($query);
$count_busy = 0;
while ($row = mysql_fetch_array($query))
{ 	
	$busy = $row['busy'];
	if ($busy == 1)
	{
		$count_busy = $count_busy + 1;
	}
}

if ( $count_maps_rows > $count_busy)
{
	
	$query1 = mysql_query("SELECT * FROM maps WHERE busy='0'");
	while ($row = mysql_fetch_array($query1))
	{ 		
		$dS = distance($latS, (double)$row['lat'], $lonS, (double)$row['lng']);
		
		if ($dS < $d_minS) 
		{
			$d_minS = $dS;
			$id_minS = $row['id'];
		}	
		
		header('Location: index.php');
	}
	
	
	
	$sql = mysql_query("UPDATE maps SET busy=1 WHERE id='$id_minS'");
	
	$sql1 = mysql_query("INSERT INTO comenzi_sursa(LatS, LngS, LatD, LngD, DistS, DistD, id_masina,done) ".
		   "VALUES ".
		   "('".$_POST['LatS']."','".$_POST['LngS']."','".$_POST['LatD']."','".$_POST['LngD']."','".$dS."','".$dD."','".$id_minS."',0)");
}
else
{
	if ($count_busy == $count_maps_rows)
	{
		echo 'Nu sunt taxiuri libere!';
		echo '<br /><a href="index.php">BACK</a>';
	}
}

?>
