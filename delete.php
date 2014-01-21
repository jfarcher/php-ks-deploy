<link type="text/css" href="default.css" rel="stylesheet">

</head>

<body>

<?php
//include("functions.php");
$confirm=$_GET[confirm];
$id=$_GET[id];
if($confirm==1){
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="DELETE from hosts where id=\"$id\"";
mysql_query($sql) or die(mysql_error());
header("location:index.php?page=inventory");
}
else{
echo "Are you sure you want to delete this workstation:<BR>";
$wkstn=getWorkstationDetails($id);
echo "Hostname: " .$wkstn[3]. "(MAC: " .$wkstn[1]. " )";
echo "<BR><a href=\"?page=delete&id=$id&confirm=1\">Yes</a>|<a href=\"?page=inventory\">No</a>";
}