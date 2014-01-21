<link type="text/css" href="default.css" rel="stylesheet">

</head>

<body>
<?php
//include("functions.php");
$id=$_GET[id];
$wkstn=getWorkstationDetails($id);
$hw=$wkstn[8];
$hardware=get_hw($hw);
print "<b>Hostname:</b> $wkstn[4]<BR>";
print "<b>Hardware:</b> $hardware <BR>";
print "<b>MAC Address:</b> $wkstn[1]<BR>";
print "<b>IP Address:</b> $wkstn[2]<BR>";
print "<b>User:</b> $wkstn[6] $wkstn[7] ($wkstn[5])<BR>";
print "<a href=\"?page=edit&id=" . $id . "\">Edit</a><BR><a href=\"?page=delete&id=" . $id . "\">Delete</a><BR>";
print "<a href=\"checklist.php?ipaddress=".$wkstn[2]."&hostname=".$wkstn[3]."&macaddress=".$wkstn[1]."&firstname=$wkstn[6]&surname=$wkstn[7]&username=$wkstn[5]&hw=$hw\" target=\"_new\">Print checklist</a>";

?>
