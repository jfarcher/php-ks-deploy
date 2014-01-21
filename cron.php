<?php

//Create symlink
//check inventory table for deploy field = 1
//get mac & hw
//check if  file exists in /tftpboot if not create symlink based on mac
//if (!$file){
//exec("ln -s /tftpboot/build/$machinetype $macaddr");



$dir = "/tmp/";

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
        }
        closedir($dh);
    }




//Remove symlink

? >

