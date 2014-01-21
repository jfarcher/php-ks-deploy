<?php
$mac=$_GET['mac'];
$mac=strtolower($mac);
include("../config.inc.php");
include("../functions.php");
$con = mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("kickstart",$con);
$query = mysql_query("update hosts set deploy=\"0\" where mac=\"$mac\"");
mysql_query($query);
unset_deploy($mac);
?>
