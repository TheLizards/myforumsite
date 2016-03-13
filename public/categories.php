<?php
// forum.php

// This page shows the threads in a forum.
include ('includes/header.php');

$q = "SELECT categories.category_id, categories.category_name, categories.category_description, COUNT(threads.thread_id) AS thread_count, COUNT(posts.post_id) AS post_count, MAX(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS latest FROM categories LEFT JOIN threads ON categories.category_id = threads.thread_id LEFT JOIN posts ON threads.thread_id = posts.thread_id GROUP BY categories.category_id";
$r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0)
//display messages
{
    // Create a table:
    echo '
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="categories table-responsive">
                <h1>Forums</h1>
                <table class="table table-bordered" align="center">

                    <tr>
                        <td>Forum</td>
                        <td>Description</td>
                        <td>Latest Post</td>
                        <td>Threads</td>
                        <td>Posts</td>
                    </tr>';

    // Fetch each thread:
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
    {

        echo '<tr>
                    <td><a href="forum.php?category_id=' . $row['category_id'] . '">' . $row['category_name'] . '</a></td>
                    <td>' . $row['category_description'] . '</td>
                    <td>' . $row['latest'] . '</td>
                    <td>' . $row['thread_count'] . '</td>
                    <td>' . $row['post_count'] . '</td>
			</tr>';

    }

    echo '</table></div></div></div></div>'; // Complete the table.

}
//no messages
else
{
    echo '<p>There are currently no categories configured.</p>';
}

// Include the HTML footer file:
include ('includes/footer.html');
?>