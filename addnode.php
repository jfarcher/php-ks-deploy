<link type="text/css" href="default.css" rel="stylesheet">

</head>

<body>
<?php
//include("functions.php");
include("config.inc.php");
if(isset($_POST['macaddress'])){
$macaddress=stripslashes($_POST['macaddress']);
$ipaddress=stripslashes($_POST['ipaddress']);
$hostname=stripslashes($_POST['hostname']);
$username=stripslashes($_POST['username']);
$surname=stripslashes($_POST['surname']);
$firstname=stripslashes($_POST['firstname']);
$hw=$_POST['hw'];
$valid=$_POST['valid'];
$attempt=$_POST['attempt'];
$deploy=$_POST['deploy'];
if($deploy!="1"){
$deploy="0";
}
}
if($valid=="valid"){
$fixloc=ucfirst($location);
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$os="6";
$sql="insert into hosts VALUES(\"\",\"$macaddress\",\"$ipaddress\",\"$hostname\",\"$hostname$dnssuffix\",\"$username\",\"$firstname\",\"$surname\",\"$os\", \"$deploy\", \"$hw\")";
mysql_query($sql) or die(mysql_error());
sendEmail("$notify_email","$fromemail","New $fixloc Workstation added for deployment","A new workstation has been added for linux deployment $hostname for $firstname $surname at $fixloc");
if ($deploy=="1"){
set_deploy($macaddress);
}

header("location:index.php");
}
else{
	if ($attempt==""){$attempt="0";}
	else{
		$attempt=$attempt + 1;
		$macaddress = str_replace("-",":","$macaddress");
		if (strlen($macaddress)=="12"){$macaddress=wordwrap($macaddress,2,":",1);}
		if (!strlen($macaddress)=="17"){$mac_good= FALSE;
		if(!preg_match("/([A-G0-9]{2}\:?){6}/",$macaddress)){$mac_good= FALSE; $macerror="MAC badly formatted"; 
		$checkdup=checkMacinDB($macaddress);
		if ($checkdup=="1"){$mac_good=FALSE; $macerror="MAC already exists";}}} 
		else{$mac_good=TRUE;}
		}
?>



<div id="formstyle" class="form">
  <form id="form1" name="form1" method="post" action="?page=add" >
    <h1>Add Kickstart Workstation entry</h1>
    <p>Please enter details of the user and workstation</p>
    <label>Mac Address
        <?php 	if ($attempt=="0"){
				print"<span class=\"small\">Onboard NIC MAC</span></label> <input type=\"text\" name=\"macaddress\" id=\"macaddress\"/>";
				$error="1";
				}
			  else{
				if (!$mac_good=="1"){print"<span class=\"smallerror\">$macerror</span></label> <input type=\"text\" name=\"macaddress\" id=\"macaddress\"  value=\"$macaddress\"/>";
				$error="1";
				}
				else {print "<span class=\"smallgood\">Address OK</span></label> <input type=\"text\" name=\"macaddress\" id=\"macaddress\"  value=\"$macaddress\"/>";
				$error="0";}
		}
?>
    <label>IP Address
        <span class="small">Assigned IP Address</span>
    </label>
 <input type="text" name="ipaddress" id="ipaddress"   <?php if($ipaddress==""){ echo "value=\"$initip\"";} else { echo "value=\"$ipaddress\""; }?>>
    
    <label>Hostname
        <span class="small">Assigned Hostname</span>
    </label>
    <input type="text" name="hostname" id="hostname"   <?php if($hostname==""){ echo "value=\"\"";} else { echo "value=\"$hostname\""; }?>/>
	<label>LDAP Username
        <span class="small"></span>
    </label>
    <input type="text" name="username" id="username"   <?php if($username==""){ echo "value=\"\"";} else { echo "value=\"$username\""; }?>/>
	<label>First Name
        <span class="small">users first name</span>
    </label>
    <input type="text" name="firstname" id="firstname"   <?php if($firstname==""){ echo "value=\"\"";} else { echo "value=\"$firstname\""; }?>/>
	<label>Surname
        <span class="small">Users surname</span>
    </label>
    <input type="text" name="surname" id="surname"   <?php if($surname==""){ echo "value=\"\"";} else { echo "value=\"$surname\""; }?>/>
<label>Hardware<span class="small"></span></label>
<input type="hidden" name="ohw" value="<?php echo $hw;?>">
<?php
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
<br>
<label>Deploy Now?
<span class="small">Eligible for Deployment</span>
</label>
<input type="checkbox" name="deploy" value="1" Checked>
	<input type="hidden" name="attempt" value="<?php echo $attempt; ?>">
	
	<?php 
	if (!$error=="1"){print("<input type=\"hidden\" id=\"valid\" name=\"valid\" value=\"valid\"><button  type=\"submit\">Add Workstation</button>");}
	else {print("<button type=\"submit\">Validate</button>");}
	}?>
    <div class="spacer"></div>

  </form>
</div>

</body>
</html>
