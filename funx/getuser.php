<?php
$mac=$_GET['mac'];
#$mac=str_replace("\"","","$mac");
$mac=strtolower($mac);
//$con = mysql_connect("localhost","kickstart","k1ckst4rt");
include("../config.inc.php");
$con = mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("kickstart",$con);
$query = "SELECT user from hosts where mac=\"$mac\"";

$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
	echo "$row[user]";
}
?>
