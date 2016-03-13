<?php
//post_form.php

// Only display this form if the user is logged in:
if (isset($_SESSION['user_id']))
{
	// Display the form:
	echo '<form action="post.php" method="post" accept-charset="utf-8">';

	// If on read.php...
	if (isset($tid) && $tid)
    {
		// Print a caption:
		echo '<div class="form-group"><h3>Post a Reply:</h3>';

		// Add the thread ID as a hidden input:
		echo '<input class="form-control" name="tid" type="hidden" value="' . $tid . '" /></div>';

	}
    else
    { // New thread

		// Print a caption:
		echo '<div class="form-group"><h3>New Thread</h3>';
	
		// Create subject input:
		echo '<p>Subject: <input class="form-control" name="subject" type="text" size="60" maxlength="100" ';

		// Check for existing value:
		if (isset($subject))
        {
			echo "value=\"$subject\" ";
		}
	
		echo '/></p></div>';
	
	} // End of $tid IF.

    if(isset($category_id) && $category_id)
    {
        echo '<input class="form-control" name="category_id" type="hidden" value="' . $category_id . '" />';
    }
	
	// Create the body textarea:
	echo '<div class="form-group"><p><textarea class="form-control" name="body" rows="10" cols="60">';

	if (isset($body))
    {
		echo $body;
	}

	echo '</textarea></p></div>';
	
	// Finish the form:
	echo '<input class="btn btn-primary" name="submit" type="submit" value="Submit" />
	</form>';
	
}
else
{
	echo '<p>You must be logged in to post messages.</p>';
}

?>