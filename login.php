<?php
ob_start();

include("functions.php");
include("config.inc.php");
$authuser=$_POST['authuser'];
$authpass=$_POST['authpass'];

if (($result = ldap_authenticate()) == NULL) {
    header("location:index.php");
}
else{
session_start();
$_SESSION['authuser']="$authuser";
$_SESSION['authpass']="$authpass";
header("location:deploy.php");
}
ob_end_flush();
?>
