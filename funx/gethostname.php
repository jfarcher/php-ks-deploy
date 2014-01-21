<?php
$mac=$_GET['mac'];
$mac=strtolower($mac);
include("../config.inc.php");
$ip=$_SERVER['SERVER_ADDR'];
$con = mysql_connect("$dbhost","$dbuser","$dbpass")or die("1");
mysql_select_db("kickstart",$con);
$query = "SELECT fqdn from hosts where mac=\"$mac\"";
$result = mysql_query($query);
echo "HOSTNAME=";
echo mysql_result($result,0)."\n";
?>

