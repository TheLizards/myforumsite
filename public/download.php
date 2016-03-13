<?php

$admin_email = $_GET['email'];
//$admin_email = 'test@testing.com';

$zipname = "/var/www/myforumsite.com/download/$admin_email/config.zip";
$name = basename($zipname);
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$name);
header('Content-Length: ' . filesize($zip));
print readfile($zipname);

rmdir("/var/www/myforumsite.com/download/$admin_email");

?>


