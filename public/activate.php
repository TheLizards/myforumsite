<?php
//activate.php

//require config.inc.php
require ('includes/config.inc.php');

//include header.php
include ('includes/header.php');

// If $x and $y are set
if (isset($_GET['x'], $_GET['y'])
    //validate the email and activation
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
	&& (strlen($_GET['y']) == 32 )
	)
{

	// Update the database...
	require(MYSQL);
	$q = "UPDATE users SET active=NULL WHERE (email='" . mysqli_real_escape_string($dbc, $_GET['x']) . "' AND active='" . mysqli_real_escape_string($dbc, $_GET['y']) . "') LIMIT 1";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	// Print a customized message:
	if (mysqli_affected_rows($dbc) == 1)
    {
		echo "<h3>Your account is now active. You may now log in.</h3>";
	} else
    {
		echo '<p class="error">Your account could not be activated. Please re-check the link or contact the system administrator.</p>'; 
	}

    //close mysql connection
	mysqli_close($dbc);

}
//redirect user
else
{

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}

//include footer.html
include ('includes/footer.html');
?>