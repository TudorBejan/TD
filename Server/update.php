<?php 
	
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	//$busy = $_GET['busy'];
	$id = $_GET['id'];
	
	include("connection.php");
	$sql="UPDATE maps SET lat='$lat', lng='$lng' WHERE id='$id'";
	$retval = mysql_query( $sql, $connection );
	if(! $retval )
	{
		die('Could not enter data: ' . mysql_error());
	}
	
	$sql="SELECT * FROM comenzi_sursa WHERE id_masina='$id' and done='0'";
	$retval = mysql_query( $sql, $connection );
	if(! $retval )
	{
		die('Could not enter data: ' . mysql_error());
	}
	
	$row = @mysql_fetch_assoc($retval);
	$dist=distance($lat,$row['latD'],$lng,$row['lngD']);
	
	echo $dist;
	
	if ($dist<0.1)
	{	
		$sql="UPDATE maps SET busy='0' WHERE id='$id'";
		$retval = mysql_query( $sql, $connection );
		if(! $retval )
		{
			die('Could not enter data: ' . mysql_error());
		}
		
		$sql="UPDATE comenzi_sursa SET done='1' WHERE id_masina='$id' and done='0'";
		$retval = mysql_query( $sql, $connection );
		if(! $retval )
		{
			die('Could not enter data: ' . mysql_error());
		}
		
	}
	
	
	function distance($lat1, $lat2, $lon1, $lon2)
	{
		$distance  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2-$lon1));
		$distance  = acos($distance);
		$distance  = $distance * 6372.8;
		//$distance  = round($distance, 4);
		return $distance;
	}
?>