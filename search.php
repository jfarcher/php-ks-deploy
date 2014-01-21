<link type="text/css" href="default.css" rel="stylesheet">

</head>

<body>
<?php
//include("functions.php");
$searched=$_POST[searched];
if ($searched=="1"){
$search=$_POST[search];
$search=trim($search);
$limit=10;
if ($search=="")
{
?>
<p>Your search was blank please try again:</p>
<form name="form" action="?page=search" method="post">
  <input type="hidden" name="searched" value="1" />
  <input type="text" name="search" />
  <input type="submit" name="Submit" value="Search" />
</form>
<?php

}
//if (!isset($search))
//{
?>
<!--<p>Your search was blank please try again:</p>
<form name="form" action="?page=search" method="post">
  <input type="hidden" name="searched" value="1" />
  <input type="text" name="search" />
  <input type="submit" name="Submit" value="Search" />
</form>-->
<?php
//}
include("config.inc.php");
mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("$dbname");
$query = "select * from hosts where hostname like \"%$search%\" order by hostname";
$result=mysql_query($query);
$rows=mysql_num_rows($result);
if ($rows == 0)
  {
  echo "<h3>Results</h3>";
  echo "<p>Sorry, your search: &quot;" . $search . "&quot; returned zero results</p>";
?>
<p>Please try again:</p>
<form name="form" action="?page=search" method="post">
  <input type="hidden" name="searched" value="1" />
  <input type="text" name="search" />
  <input type="submit" name="Submit" value="Search" />
</form>
<?php  
}
else{
if (empty($s)) {
  $s=0;
  }

$pagerows = 15;

$last = ceil($rows/$pagerows);
if ($pagenum < 1)  {
  $pagenum = 1;
}
elseif ($pagenum > $last)  {
    $pagenum = $last;
  
} 

$max = 'limit ' .($pagenum - 1) * $pagerows .',' .$pagerows;

$query2 = mysql_query("SELECT * FROM hosts where hostname like \"%$search%\" order by hostname $max") or die("query2 error"); 

//}



if ($pagenum==$last){
$disprows=$rows-($pagerows*$last-$pagerows);
}
else{
$disprows="$pagerows";
}
print "<table width=\"100%\">";
print "<tr><th align=left>Hostname</th><th align=left>IP Address</th><th align=left>MAC Address</th><th align=left>User</th><th>Hardware</th><th align=left>Edit</th><th align=left>Delete</th></tr>";

for($i = 0; $i < $disprows; $i++) {
$row = mysql_fetch_array($query2);
$hw=$row['hw'];
$hardware=get_hw($hw);

if($i % 2) {
echo "<tr bgcolor=\"#E0FFCC\">";
}
else{
echo "<tr bgcolor=\"#E0ECF8\">";
  
}
echo "<td><a href=\"?page=details&id=" .$row['id']."\">".$row['hostname']."</a></td><td>".$row['ip']."</td><td>".$row['mac']."</td><td>". $row['firstname'] . " " . $row['lastname'] . "(" . $row['user'] . ")</td><td>" .$hardware. "</td><td><a href=\"?page=edit&id=" . $row['id'] . "\">Edit</a></td><td align=center><a href=\"?page=delete&id=" . $row['id'] . "\">X</a></td></tr>";
}


   

  echo "</table>";
echo "<p> --Page $pagenum of $last-- <p>";

if ($pagenum =="1")
  {
  echo " <<-First "; echo " "; $previous = $pagenum-1; echo " <-Previous ";
   }
  else  {
   echo " <a href='?page=search&searched=1&pagenum=1'> <<-First</a> "; echo " "; $previous = $pagenum-1; echo " <a href='?page=search&searched=1&pagenum=$previous'> <-Previous</a> ";
   } 
   
    echo " ---- ";
    if ($pagenum == $last)  { echo " Next -> "; echo " "; echo " Last ->> ";}  else { $next = $pagenum+1; echo " <a href='?page=search&searched=1&pagenum=$next'>Next -></a> "; echo " "; echo " <a href='?page=search&searched=1&pagenum=$last'>Last ->></a> "; } 
	//{
	//$macaddress=$row['mac'];
	//echo "<tr><td>".$row['hostname']."</td><td>".$row['ip']."</td><td>".$row['mac']."</td><td>". $row['firstname'] . " " . $row['lastname'] . "(" . $row['user'] . ")</td><td><a href=\"?page=edit&id=" . $row['id'] . "\">Edit</a></td></tr>";
	//}
mysql_close($con);
 
  echo "<p>Showing results $b to $a of $numrows</p>";

}
}



else{

?>

<form name="form" action="?page=search" method="post">
  <input type="hidden" name="searched" value="1" />
  <input type="text" name="search" />
  <input type="submit" name="Submit" value="Search" />
</form>

<?php
}
?>
