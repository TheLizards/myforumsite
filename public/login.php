<?php
//login.php

//require config.inc.php
require ('includes/config.inc.php'); 

//include header.php
include ('includes/header.php');

//if there is a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Validate the email address:
	if (!empty($_POST['email']))
    {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	}
    else
    {
		$e = FALSE;
		echo '<p class="error">You forgot to enter your email address!</p>';
	}
	
	// Validate the password:
	if (!empty($_POST['pass']))
    {
		$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
	}
    else
    {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}
	
	if ($e && $p)
    { // If everything's OK.

		// Query the database:
		$q = "SELECT user_id, user_level FROM users WHERE (email='$e' AND pass=SHA1('$p'))";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (@mysqli_num_rows($r) == 1)
        { // A match was made.

			// Register the values:
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC); 
			mysqli_free_result($r);
			mysqli_close($dbc);
							
			// Redirect the user:
			$url = 'forum_index.php'; // Define the URL.
			ob_end_clean(); // Delete the buffer.
			header("Location: $url");
			exit(); // Quit the script.
				
		}
        else
        { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}
		
	}
    else
    { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}
	
	mysqli_close($dbc);

} // End of SUBMIT conditional.
?>

<!--- Login Form --->
<h1>Login</h1>
<p>Your browser must allow cookies in order to log in.</p>
<form action="login.php" method="post">
	<fieldset>
	<p><b>Email Address:</b> <input class="form-control" type="text" name="email" size="20" maxlength="60" /></p>
	<p><b>Password:</b> <input class="form-control" type="password" name="pass" size="20" maxlength="20" /></p>
	<div align="center"><input class="btn btn-primary" type="submit" name="submit" value="Login" /></div>
	</fieldset>
</form>
<br />

    <div class="text-center"><a href="forgot_password.php" title="Forgot Password"><button type="button" class="btn btn-primary center">Forgot Password</button></a></div>

<?php
//include footer.html
include ('includes/footer.html');

?>