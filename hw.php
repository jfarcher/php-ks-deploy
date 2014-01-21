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

$query=mysql_query("SELECT * from hardware");
$rows=mysql_num_rows($query);
//Number of rows per page
$pagerows = 15;
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
$query2 = mysql_query("SELECT * FROM hardware order by id $max") or die("query2 error"); 

//}


if ($rows!="0"){
if ($pagenum==$last){
$disprows=$rows-($pagerows*$last-$pagerows);
}
else{
$disprows="$pagerows";
}
print "<table width=\"100%\">";
print "<tr><th align=left>Make</th><th align=left>Model</th><th>Config Script</th><th align=left>Edit</th><th align=left>Delete</th></tr>";

for($i = 0; $i < $disprows; $i++) {
$row = mysql_fetch_array($query2);
if($i % 2) {
echo "<tr bgcolor=\"#F5F6CE\">";
}
else{
echo "<tr bgcolor=\"#E0ECF8\">";
  
}
echo "<td>".$row['make']."</td><td>".$row['model']."</td><td>".$row['configscript']."<td><a href=\"?page=edit&id=" . $row['id'] . "\">Edit</a></td><td align=center><a href=\"?page=hwdelete&id=" . $row['client'] . "\">X</a></td></tr>";
}
echo "</table>";
echo "<p> --Page $pagenum of $last-- </p>";

if ($pagenum =="1")
  {
  echo " <<-First "; echo " "; $previous = $pagenum-1; echo " <-Previous ";
   }
  else  {
   echo " <a href='?page=hw&pagenum=1'> <<-First</a> "; echo " "; $previous = $pagenum-1; echo " <a href='?page=hw&pagenum=$previous'> <-Previous</a> ";
   } 
   
    echo " ---- ";
    if ($pagenum == $last)  { echo " Next -> "; echo " "; echo " Last ->> ";}  else { $next = $pagenum+1; echo " <a href='?page=hw&pagenum=$next'>Next -></a> "; echo " "; echo " <a href='?page=hw&pagenum=$last'>Last ->></a> "; } 
	}

mysql_close($con);

?>
