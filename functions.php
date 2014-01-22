<?php

function ldap_authenticate() {
include("config.inc.php");
    global $ldapconfig;
    global $ldapserver;
    global $ldapbasedn;
    global $authuser;
    global $authpass;
    global $attr;
    $attr= "memberUid";
    
if ($authuser != "" && $authpass != "") {
        $ds=ldap_connect($ldapserver);
        $r = ldap_search( $ds, $ldapbasedn, 'uid=' . $authuser);
        $ldapuserdn= "uid=".$authuser.",$ldap_user_dn";
        
        if ($r) {
                        
            $result = ldap_get_entries( $ds, $r);
            if ($result[0]) {
             if (ldap_bind( $ds, $result[0]['dn'], $authpass) ) {
                 $g = ldap_compare($ds, $ldapgroup, $attr, $authuser);
                 if ($g === -1){
                 return NULL;
                 }
                 if ($g == TRUE){
                 return $result[0];
                 }
                }
              ldap_unbind($ds);  
            }
            
        }
     }    
}
function mysql_authenticate() {
return "archerj";
}
function getWorkstationDetails($id){
include("config.inc.php");
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die("db connect failed");

mysql_select_db("$dbname") or die("db select failed");
$sql=("SELECT * from hosts where id=\"$id\"");

$result = mysql_query($sql) or die ("Query Failed");
$row = mysql_fetch_array($result);
$id=$row['id'];
$macaddress=$row['mac'];
$ipaddress=$row['ip'];
$hostname=$row['hostname'];
$fqdn=$row['fqdn'];
$user=$row['user'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$hw=$row['hw'];
$returnarray=array($id,$macaddress,$ipaddress,$hostname,$fqdn,$user,$firstname,$lastname,$hw);
return $returnarray;
mysql_close();
}
function get_hw($id){
include("config.inc.php");
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die("db connect failed");

mysql_select_db("$dbname") or die("db select failed");
$sql=("SELECT * from hardware where id=\"$id\"");

$result = mysql_query($sql) or die ("Query Failed");
$row = mysql_fetch_array($result); 
$make=$row['make'];
$model=$row['model'];
$hardware = "$make $model";
return $hardware;
}

function checkMacAddress($macaddress){
if (strlen($macaddress=="17")){
$mac_good=TRUE;
}
else{
$mac_good=FALSE;
}
return $mac_good;
}

function checkMacinDB($macaddress){
include("config.inc.php");
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die("db connect failed");
mysql_select_db("$dbname") or die("db select failed");
$sql=("SELECT * from hosts where mac=\"$macaddress\"");
$result = mysql_query($sql) or die ("Query Failed");
$numrows = mysql_num_rows($result);
if (!$numrows=="0"){
$exists="1";
}
else{
$exists="0";
}
return $exists;
}

function getLDAPID($username){
include("config.inc.php");
//Old method using getent - ideal if php-ldap not installed
//$LDAPID=exec("getent passwd $username");
//$LDAPID=split(":",$LDAPID);
//$LDAPID=$LDAPID[2];
//return $LDAPID;
$filter = "(uid=$username)";
$ldap_user  = "uid=".$username.",$base_dn";
$ds = ldap_connect( $ldapserver);
$r=ldap_search($ds, $base_dn, $filter);
$info = ldap_get_entries($ds, $r);
$data=$info[0][11];
return $info[0]['uidnumber'][0];
ldap_close($connect);
}


function set_deploy($mac){
$newmac=str_replace(":","-",$mac);
$newmac=strtolower($newmac);
system("cp /tftpboot/pxelinux.cfg/configs/workstation /tftpboot/pxelinux.cfg/01-$newmac");
}
function set_deployv2($mac,$configscript){
$newmac=str_replace(":","-",$mac);
$newmac=strtolower($newmac);
system("cp /tftpboot/pxelinux.cfg/configs/$configsscript /tftpboot/pxelinux.cfg/01-$newmac");
}
function unset_deploy($mac){
$newmac=str_replace(":","-",$mac);
$newmac=strtolower($newmac);
if ($newmac!=""){system ("rm -rf /tftpboot/pxelinux.cfg/01-$newmac");}
}
function get_deploy($mac){
include("config.inc.php");
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die("db connect failed");
mysql_select_db("$dbname") or die("db select failed");
$sql=("SELECT * from hosts where mac=\"$mac\" and deploy=\"1\"");
$result = mysql_query($sql) or die ("Query Failed");
$numrows = mysql_num_rows($result);
if ($numrows!="0"){
$deploy="1";
$image="yes16.png";
}
else{
$deploy="0";
$image="no16.png";
}
return $deploy;
}

function sendEmail ($to, $from, $subject, $message){

$headers = "From: " . $from . " <" . $from . ".\r\n";
$headers .= "Return-Path: " . $from . " <" . $from . ">\r\n";
$headers .= "Reply-To: " . $from . " <" . $from . ">\r\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

return mail($to,$subject,$message,$headers);
}

?>
