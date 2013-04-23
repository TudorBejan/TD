<?php  

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

include("connection.php");

// Select all the rows in the markers table

$query = "SELECT * FROM maps WHERE 1";
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
} 

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);  
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("nr_masina", $row['Nr_masina']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("busy", $row['busy']);
} 

echo $dom->saveXML();

?>