<?php
//header.php

//set encoding to utf-8
header('Content-Type: text/html; charset=UTF-8');

//output buffering
ob_start();

//start session
session_start();

//include mysqli_connect.php
require('../mysqli_connect.php');

$q = "SELECT site_name FROM settings WHERE setting_id = 1";
$r = mysqli_query($dbc, $q);

if($r)
{
    while($row = mysqli_fetch_array($r, MYSQL_ASSOC))
    {
        $site_name = $row['site_name'];
    }
}

?>

<!--- Start HTML --->
<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"  />
    <link rel="stylesheet" type="text/css" href="../css/style.css"  />
    <link rel="stylesheet" type="text/css" href="../css/present.css"  />
    <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        // Load this when the DOM is ready
        $(function(){
            // You used .myCarousel here.
            // That's the class selector not the id selector,
            // which is #myCarousel
            $('#myCarousel').carousel();
        });
    </script>

    <title>
        <?php echo $site_name ?>
    </title>

</head>
<body>
    <?php include('navigation.php');?>

    <div class="body_container container-fluid ">

