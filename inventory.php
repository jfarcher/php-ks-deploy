<head>
<?php
?>

<link rel=stylesheet href="default.css" type="text/css" media=screen>

</head>

<?php
include("config.inc.php");
mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("$dbname");
$pagenum=$_GET[pagenum];

if (!(isset($pagenum))){
$pagenum = 1;
} 

$query=mysql_query("SELECT * from hosts");
$rows=mysql_num_rows($query);
//Number of rows per page
$pagerows = 15;

//if ($rows < 20){
//$query2 = mysql_query("SELECT * FROM hosts") or die("query2 error"); 
//$last="1";
//}
//else{
$last = ceil($rows/$pagerows);
if ($pagenum < 1)  {
  $pagenum = 1;
}
elseif ($pagenum > $last)  {
    $pagenum = $last;
  
} 
if ($rows!="0"){
$max = 'limit ' .($pagenum - 1) * $pagerows .',' .$pagerows;
}
$query2 = mysql_query("SELECT * FROM hosts order by hostname $max") or die("query2 error"); 

//}


if ($rows!="0"){
if ($pagenum==$last){
$disprows=$rows-($pagerows*$last-$pagerows);
}
else{
$disprows="$pagerows";
}
print "<table width=\"100%\">";
print "<tr><th align=left>Hostname</th><th align=left>IP Address</th><th align=left>MAC Address</th><th align=left>User</th><th>Redhat Version</th><th align=left>Hardware</th><th align=center>Deployable</th><th align=left>Edit</th><th align=left>Delete</th></tr>";

for($i = 0; $i < $disprows; $i++) {
$row = mysql_fetch_array($query2);
$hw=$row['hw'];
$hardware=get_hw($hw);

if($i % 2) {
echo "<tr bgcolor=\"#F5F6CE\">";
}
else{
echo "<tr bgcolor=\"#E0ECF8\">";
  
}
$macad=$row['mac'];
$deploy=get_deploy($macad);
if($deploy=="1"){
$depimg="yes16.png";
}
else{
$depimg="no16.png";
}
echo "<td><a href=\"?page=details&id=" .$row['id']."\">".$row['hostname']."</a></td><td>".$row['ip']."</td><td>".$row['mac']."</td><td>". $row['firstname'] . " " . $row['lastname'] . "(" . $row['user'] . ")</td><td> " .$row['os']. "</td><td>" .$hardware. "</td><td align=center><img src=\"img/$depimg\"></td><td><a href=\"?page=edit&id=" . $row['id'] . "\">Edit</a></td><td align=center><a href=\"?page=delete&id=" . $row['id'] . "\">X</a></td></tr>";
}


   

  echo "</table>";
echo "<p> --Page $pagenum of $last-- </p>";

if ($pagenum =="1")
  {
  echo " <<-First "; echo " "; $previous = $pagenum-1; echo " <-Previous ";
   }
  else  {
   echo " <a href='?page=inventory&pagenum=1'> <<-First</a> "; echo " "; $previous = $pagenum-1; echo " <a href='?page=inventory&pagenum=$previous'> <-Previous</a> ";
   } 
   
    echo " ---- ";
    if ($pagenum == $last)  { echo " Next -> "; echo " "; echo " Last ->> ";}  else { $next = $pagenum+1; echo " <a href='?page=inventory&pagenum=$next'>Next -></a> "; echo " "; echo " <a href='?page=inventory&pagenum=$last'>Last ->></a> "; } 
	//{
	//$macaddress=$row['mac'];
	//echo "<tr><td>".$row['hostname']."</td><td>".$row['ip']."</td><td>".$row['mac']."</td><td>". $row['firstname'] . " " . $row['lastname'] . "(" . $row['user'] . ")</td><td><a href=\"?page=edit&id=" . $row['id'] . "\">Edit</a></td></tr>";
	//}
}


?>

