<?php
session_start();
if(!session_is_registered(authuser)){
include("config.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php print "$company_title";?>Linux Deployment Portal</title>
  <link href="default.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="page"></div><div id="cornerTop" class="dimensions"></div>
<div id="header" class="dimensions">
  <h1><?php print "$company_title";?></h1>
  <h2>Linux Deployment Portal - <?php echo ucfirst($location); ?></h2>
</div>

<div id="mainSite" class="dimensions">
  <div id="mainLeft">
<div id="Content">
<BR><BR><BR><BR><BR><BR><BR><BR><BR>
<table width="300" border=0 align="center" cellpadding="0" cellspacing="1" >
<tr>
<form name="form 1" method="post" action="login.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" >
<tr>
<td colspan="3"><strong>Login</strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="authuser" type="text" id="authuser"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="authpass" type="password" id="authpass"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</div>
  <div id="footer" class="dimensions">
</div>
</div>
</body>
</html>
<?php
}
else{
header("location:deploy.php");
}
