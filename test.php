<?php
function put_mac($mac){
$newmac=str_replace(":","-",$mac);
system("ln -s /tftpboot/pxelinux.cfg/default /tftpboot/pxelinux.cfg/$newmac");
}
function rem_mac($mac){
$newmac=str_replace(":","-",$mac);
system ("rm -rf /tftpboot/pxelinux.cfg/$newmac");
}
?>

