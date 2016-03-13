<?php
//logout.php

//require config.inc.php
require ('includes/config.inc.php'); 

//include header.php
include ('includes/header.php');

//if session variable "first_name" is not set
if (!isset($_SESSION['user_id']))
{
    //redirect user
	$url = 'forum_index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}
else
{
    //logout user
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-3600); // Destroy the cookie.

}

// Print a customized message:
echo '<h3>You are now logged out.</h3>';

//include footer.html
include ('includes/footer.html');
?>