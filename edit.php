<?php
$id=$_GET["id"];
if ($id==""){
$id=$_POST["id"];
}
$macaddress=$_POST["macaddress"];
//include("functions.php");
$wkstn=getWorkstationDetails($id);
$id=$wkstn[0];
?>

<link type="text/css" href="default.css" rel="stylesheet">

</head>

<body>
<?php
if ($id==""){
print "For now please select a workstation from the inventory to edit.";

}
else{
$update=$_POST['update'];
$macaddress = str_replace("-",":","$macaddress");

if ($update=="1"){
$id=$_POST[id];
$ipaddress=$_POST[ipaddress];
$hostname=$_POST[hostname];
$fqdn=$hostname.$dnssuffix;
$username=$_POST[username];
$firstname=$_POST[firstname];
$surname=$_POST[surname];
$hw=$_POST[hw];
$deploy=$_POST['deploy'];
if($deploy!="1"){
$deploy="0";
}


if (strlen($macaddress)=="12"){$macaddress=wordwrap($macaddress,2,":",1);}
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql = "update hosts set mac=\"$macaddress\", ip=\"$ipaddress\", hostname=\"$hostname\", fqdn=\"$fqdn\", user=\"$username\", firstname=\"$firstname\", lastname=\"$surname\",deploy=\"$deploy\",hw=\"$hw\" where id=\"$id\" ";
mysql_query($sql) or die(mysql_error());

if ($deploy=="1"){
sendEmail("$notify_email","$from_email","New $fixloc Workstation added for deployment","A new workstation has been updated, set for linux deployment $hostname($macaddress) for $firstname $surname at $fixloc");
//include("functions.php");
set_deploy($macaddress);
}
else{
//include("functions.php");
unset_deploy($macaddress);
}
header("location:index.php");

}
else {



  
	//	$macaddress = str_replace("-",":","$macaddress");
	//	if (strlen($macaddress)=="12"){$macaddress=wordwrap($macaddress,2,":",1);}
	//	if (!strlen($macaddress)=="17"){$mac_good= FALSE;}
	//	if(!preg_match("/([A-G0-9]{2}\:?){6}/",$macaddress)){$mac_good= FALSE;} else{$mac_good=TRUE;} 
$mac=$wkstn[1];
?>



<div id="formstyle" class="form">
  <form id="form1" name="form1" method="post" action="?page=edit" >
    <h1>Edit Kickstart Workstation entry</h1>
    <p>Please modify details of the user and workstation</p>
    <label>Mac Address
        <span class="small">Onboard NIC MAC</span>
    </label>
    <input type="text" name="macaddress" id="macaddress" value="<?php echo $wkstn[1]; ?>"/>
				    
    <label>IP Address
        <span class="small">Assigned IP Address</span>
    </label>
    <input type="text" name="ipaddress" id="ipaddress" value="<?php echo $wkstn[2];?>"/>
    
    <label>Hostname
        <span class="small">Assigned Hostname</span>
    </label>
    <input type="text" name="hostname" id="hostname" value="<?php echo $wkstn[3]; ?>" />
	<label>LDAP Username
        <span class="small"></span>
    </label>
    <input type="text" name="username" id="username" value="<?php echo $wkstn[5]; ?>" />
	<label>First Name
        <span class="small">users first name</span>
    </label>
    <input type="text" name="firstname" id="firstname" value="<?php echo $wkstn[6]; ?>" />
	<label>Surname
        <span class="small">Users surname</span>
    </label>
    <input type="text" name="surname" id="surname" value="<?php echo $wkstn[7]; ?>" />
<label>Hardware<span class="small"></span></label>

<input type="hidden" name="ohw" value="<?php echo $hw;?>">
<?php
$hw=$wkstn[8];
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT * FROM hardware";
$result=mysql_query($sql) or die(mysql_error());

$options="";

print "<select name=\"hw\">";
while($row = mysql_fetch_array($result)){
echo '<option value="'.$row['id'].'"';
  if ($row['id']==$hw){

    echo ' selected';
  }
echo '>'.$row["make"] . " " . $row["model"] . '</option>'."\n";
}
?>
</select>
<?php
$deploy=get_deploy($mac);
if ($deploy=="1"){
$checked="Checked";
}
?>
<label>Deploy Now?
<span class="small">Eligible for Deployment</span>
</label>
<input type="checkbox" name="deploy" value="1" <?php echo $checked;?> />

	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="update" value="1">
	<button  type="submit">Update Workstation</button>
<?php
	}?>
    <div class="spacer"></div>

  </form>
</div>
<?php
}

?>
</body>
</html>
