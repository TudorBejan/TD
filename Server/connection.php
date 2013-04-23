<?php
// Opens a connection to a MySQL server
//$connection=mysql_connect ('mysql.hostinger.ro', 'u917062727_td','admin1');
$connection=mysql_connect ('localhost', 'root');
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
//$db_selected = mysql_select_db('u917062727_td', $connection);
$db_selected = mysql_select_db('taxidb', $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 
?>