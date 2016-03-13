<?php
//post.php

//include header.php
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	// Validate thread ID ($tid), which may not be present:
	if (isset($_POST['tid']) && filter_var($_POST['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) )
    {
		$tid = $_POST['tid'];
	}
    else
    {
		$tid = FALSE;
	}

    //validate $category_id
    if (isset($_POST['category_id']) && filter_var($_POST['category_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) )
    {
        $category_id = $_POST['category_id'];
    }
    else
    {
        $category_id = FALSE;
    }

	// If there's no thread ID, a subject must be provided:
	if (!$tid && empty($_POST['subject']))
    {
		$subject = FALSE;
		echo '<p>Please enter a subject for this post.</p>';
	}
    elseif (!$tid && !empty($_POST['subject']))
    {
		$subject = htmlspecialchars(strip_tags($_POST['subject']));
	} else
    { // Thread ID, no need for subject.
		$subject = TRUE;
	}
	
	// Validate the body:
	if (!empty($_POST['body']))
    {
		$body = htmlentities($_POST['body']);
	}
    else
    {
		$body = FALSE;
		echo '<p>Please enter a body for this post.</p>';
	}
	
	if ($subject && $body)
    { // OK!
		// Add the message to the database...
		
		if (!$tid)
        { // Create a new thread.
			$q = "INSERT INTO threads (category_id, user_id, subject) VALUES ($category_id, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1)
            {
				$tid = mysqli_insert_id($dbc);
			}
            else
            {
				echo '<p>Your post could not be handled due to a system error.</p>';
			}
		} // No $tid.
		
		if ($tid)
        { // Add this to the replies table:
			$q = "INSERT INTO posts(thread_id, category_id, user_id, message, posted_on) VALUES ($tid, $category_id, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1)
            {
				echo '<p>Your post has been entered.</p>';
			}
            else
            {
				echo '<p>Your post could not be handled due to a system error.</p>';
			}
		}
	
	}
    else
    { // Include the form:
		include ('includes/post_form.php');
	}

} else
{ // Display the form:
	include ('includes/post_form.php');
}

//include footer.html
include ('includes/footer.html');
?>