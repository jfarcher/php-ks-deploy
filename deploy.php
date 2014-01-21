<?php
session_start();
if(!isset($_SESSION['authuser']) || !isset($_SESSION['authpass'])){
header("location:index.php");
}
else{
$authuser=$_SESSION['authuser'];
include ("config.inc.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php print "$company_title"; ?> Linux Deployment Portal</title>
  <link href="default.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<?php
$page=$_GET[page];
if ($page==""){$page="inventory";}
include("functions.php");
//$site=getsiteLDAP($authuser);
//include("config.inc.php");
?>

<body>
<div id="page"></div><div id="cornerTop" class="dimensions"></div>

<div id="header" class="dimensions">
  <h1><?php print "$company_title"; ?></h1>
  <h2>Linux Deployment Portal - <?php echo ucfirst($location); ?></h2>
</div>

<div id="navigationTop" class="dimensions">
  <ul>
    <li><a href="?page=inventory">Workstations</a></li>
<!--    <li><a href="?page=add">Add Workstation</a></li>
    <li><a href="?page=search">Search</a></li>-->
	<li><a href="?page=vv">Workstation Configs</a></li>
	<li><a href="?page=hw">Hardware Types</a></li>
	<li><a href="?page=cs">Config Scripts</a></li>
	
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
<div id="navigationSub" class="dimensions">
<ul>
<?php
if($page=="inventory" OR $page=="add" OR $page=="search"){
?>
<li><a href="?page=add">Add Workstation</a></li>
<li><a href="?page=search">Search</a></li>

<?php
}
if($page=="hw" OR $page=="hwadd"){
?>
<li><a href="?page=hwadd">Add Hardware Type</a></li>

<?php
}
if($page=="cs" OR $page=="csadd"){
?>
<li><a href="?page=csadd">Add Config Script</a></li>

<?php
}
?>
</ul>
</div>


<div id="mainSite" class="dimensions">
  <div id="mainLeft">
   <div id="Content">
   <?php
   if ($page=="add"){
   echo "<h2> Adding a Workstation Entry</h2>";
   include("addnode.php");
   }
   if ($page=="inventory"){
   echo "<h2>Workstation Inventory</h2>";
   include("inventory.php");
   }
   if ($page=="edit"){
   echo "<h2>Edit Workstation</h2>";
   
   include("edit.php");
   }
   if ($page=="delete"){
   
   echo "<h2>Delete Workstation</h2>";
    include("delete.php");
   
   $wkstn = getWorkstationDetails($id);
   
    echo $macaddress;
   }
   if ($page=="search"){
   echo "<h2>Search for a Workstation</h2>";
   
   include("search.php");
   }
   
   if ($page=="details"){
   echo "<h2>Workstation details:</h2>";
   
   include("details.php");
   }
   if ($page=="vv"){
   echo "<h2>Vault Access</h2>";
   include("vv.php");
   }
   if ($page=="hw"){
   echo "<h2>Hardware Types</h2>";
   include("hw.php");
   }
   if ($page=="cs"){
   echo "<h2>Config Scripts</h2>";
   include("configscripts.php");
   }
   ?>
     <!-- PLACE CONTENT HERE!! -->

   </div>
  </div>

  <div id="mainRight">
<h5>Links can  go here.</h5>
  </div>

  <div id="footer" class="dimensions">
  <?php
$con = mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("kickstart",$con);
$query=mysql_query("SELECT * from hosts");
$numrows=mysql_num_rows($query);
print "Database currently holds $numrows workstations.
";
mysql_close($con);
?>
  </div>
</div>
</body>
</html>


<?php
}
?>
