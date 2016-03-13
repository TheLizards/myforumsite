<?php
//register.php

// require config file
require ('includes/config.inc.php');

//include header file
include ('includes/header.php');

//if the form method is set to POST
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ // Handle the form.

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$un = $e = $p = FALSE;
	
	// Check for a username:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['username']))
    {
		$un = mysqli_real_escape_string($dbc, $trimmed['username']);
	}
    else
    {
		echo '<p class="error">Please enter a username!</p>';
	}
	
	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL))
    {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	}
    else
    {
		echo '<p class="error">Please enter a valid email address!</p>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['password1']) )
    {
		if ($trimmed['password1'] == $trimmed['password2'])
        {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		}
        else
        {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	}
    else
    {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	if ($un && $e && $p)
    { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0)
        { // Available.

			// Create the activation code:
			$a = md5(uniqid(rand(), true));

			// Add the user to the database:
			$q = "INSERT INTO users(username, email, pass, active, date_created) VALUES ('$un','$e', SHA1('$p'), '$a', NOW())";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1)
            { // If it ran OK.

				// Send the email:
				$body = "Thank you for registering at " . SITE_NAME . ". To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: ' . EMAIL);
				
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			}
            else
            { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		}
        else
        { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	}
    else
    { // If one of the data tests failed.
		echo '<p class="error">Please try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>
	
<h1>Register</h1>
<form action="register.php" method="post">
	<fieldset>

    <div class="form-group"><p><b>Username:</b> <input required class="form-control" type="text" name="username" size="20" maxlength="20" value="<?php if (isset($trimmed['username'])) echo $trimmed['username']; ?>" /></p>

    <div class="form-group"><p><b>Email Address:</b> <input required class="form-control" type="text" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" /> </p>

    <div class="form-group"><p><b>Password:</b> <input required class="form-control" type="password" name="password1" size="20" maxlength="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" /> <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small></p>

    <div class="form-group"><p><b>Confirm Password:</b> <input reqclass="form-control" type="password" name="password2" size="20" maxlength="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>" /></p>
	</fieldset>

    <div class="form-group"><div align="center"><input type="submit" class="btn btn-primary" name="submit" value="Register" /></div>

</form>

<?php
//include footer file
include ('includes/footer.html');
?>