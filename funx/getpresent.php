<?php
header('Content-type: text/plain');

$mac=$_GET['mac'];
$mac=strtolower($mac);
include("../config.inc.php");
$con = mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("kickstart",$con);
$query = mysql_query("SELECT * from hosts where mac=\"$mac\"");
$numrows = mysql_num_rows($query);
if ($numrows==0){
print "echo This workstation is not configured for kickstart installation.\n
echo Please open $deployment_url in a browser and add required fields.\n
echo This workstation will poweroff in 25 seconds\n
sleep 25\n
poweroff
sleep 10
";
}
else{
print "echo All set for deployment, engage thrusters!\n
";
}
?>
