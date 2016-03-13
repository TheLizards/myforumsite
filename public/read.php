<?php
//read.php

//include header.php
include ('includes/header.php');

//set thread id FALSE
$tid = FALSE;
$category_id = FALSE;

//check if thread id has been submitted and it an integer greater than 1
if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) && $_GET['category_id'])
{
	
	// Create a shorthand version of the thread ID:
	$tid = $_GET['tid'];

    $category_id = $_GET['category_id'];

   	$posted = 'p.posted_on';

	// Run the query:
	$q = "SELECT t.subject, p.post_id, p.message, username, DATE_FORMAT($posted, '%e-%b-%y %l:%i %p') AS posted FROM threads AS t LEFT JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON p.user_id = u.user_id WHERE t.thread_id = $tid ORDER BY p.posted_on ASC";
	$r = mysqli_query($dbc, $q);
	if (!(mysqli_num_rows($r) > 0))
    {
		$tid = FALSE; // Invalid thread ID!
	}
	
} // End of isset($_GET['tid']) IF.

if ($tid)
{ // Get the messages in this thread...
	
	$printed = FALSE; // Flag variable.

	// Fetch each:
	while ($messages = mysqli_fetch_array($r, MYSQLI_ASSOC))
    {

		// Only need to print the subject once!
		if (!$printed)
        {
			echo "<h2>{$messages['subject']}</h2>\n";
			$printed = TRUE;
		}
	
		// Print the message:
        //if user is admin
        if(isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1)
        {
            echo "
		    <table class='table table-bordered'>
		        <tr><td>{$messages['username']} ({$messages['posted']}) - <a href='../delete_post.php?post_id={$messages['post_id']}'>Delete Posts</a></td><tr><tr><td>{$messages['message']}</td></tr></table>";
        }
        else
        {
            echo "
		    <table class='table table-bordered'>
		        <tr><td>{$messages['username']} ({$messages['posted']})</td><tr><tr><td>{$messages['message']}</td></tr></table>";

        }

	} // End of WHILE loop.
		
	// Show the form to post a message:
	include ('includes/post_form.php');
	
}
else
{ // Invalid thread ID!
	echo '<p>This page has been accessed in error.</p>';
}

include ('includes/footer.html');
?>