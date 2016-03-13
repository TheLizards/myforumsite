<?php
// forum.php

// This page shows the threads in a forum.
include ('includes/header.php');


if (isset($_GET['category_id']) && filter_var($_GET['category_id'], FILTER_VALIDATE_INT) )
{
    // The query for retrieving all the threads in this forum, along with the original user,
// when the thread was first posted, when it was last replied to, and how many replies it's had:

    $category_id = $_GET['category_id'];
    //echo $category_id;

    /*$q = "SELECT c.category_id, t.thread_id, t.subject, username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT($last, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT($first, '%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON t.user_id = u.user_id INNER JOIN category AS c ON c.category_id = t.category_id WHERE category_id = $category_id  GROUP BY (p.thread_id) ORDER BY last DESC";
    $r = mysqli_query($dbc, $q);*/

    $q = "SELECT categories.category_id, categories.category_name, threads.thread_id, threads.subject, users.username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS first FROM threads INNER JOIN categories ON threads.category_id = $category_id INNER JOIN users ON threads.user_id = users.user_id INNER JOIN posts ON threads.thread_id = posts.thread_id WHERE categories.category_id = '$category_id';";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 0)
    //display messages
    {
        // Create a table:


        // Fetch each thread:
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            echo '
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div class="forums table-responsive">
                        <h1>' . $row['category_name'] . ' Forum</h1>
                        <table class="table table-bordered" cellspacing="2" cellpadding="2" align="center">
                            <tr>
                                <td>Subject:</td>
                                <td>Posted By:</td>
                                <td>Posted On:</td>
                                <td>Replys:</td>
                                <td>Latest Reply:</td>
                            </tr>';
                        echo '<tr>
                            <td><a href="read.php?category_id=' . $row['category_id'] . '&tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
                            <td>' . $row['username'] . '</td>
                            <td>' . $row['first'] . '</td>
                            <td>' . $row['responses'] . '</td>
                            <td>' . $row['last'] . '</td>
                        </tr>';

        }

        echo '</table></div></div></div></div>'; // Complete the table.


    }
    else
    {
        echo 'there are no messages to display';
    }
}
//no messages
else
{
	echo '<p>There are currently no messages in this forum.</p>';
}

// Include the HTML footer file:
include ('includes/footer.html');
?>