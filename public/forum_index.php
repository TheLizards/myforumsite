<?php
// index.php

// Include header file
include ('includes/header.php');

$q = 'SELECT site_name, title, about FROM settings WHERE setting_id = 1';
$r = mysqli_query($dbc, $q);

if(mysqli_num_rows($r) == 1)
{
    while($row = mysqli_fetch_array($r, MYSQL_ASSOC))
    {
        echo '
        <div class="row text-center">
            <div class="col-xs-12">
                <h1>Welcome to ' . $row['site_name'] . ' Forums</h1>
                    <h3>' . $row['title'] . '</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="about">
                    <h3>About:</h3>
                        <p>' . $row['about'] . '</p>
                </div>
            </div>
        </div>
        ';
    }
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="recent_posts">

            <h3>Most Recent Threads:</h3>

<?php

$q = "SELECT categories.category_id, categories.category_name, threads.thread_id, threads.subject, users.username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS first FROM threads INNER JOIN categories ON threads.category_id = categories.category_id INNER JOIN users ON threads.user_id = users.user_id INNER JOIN posts ON threads.thread_id = posts.thread_id GROUP BY threads.thread_id ORDER BY last DESC LIMIT 5;";
$r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0)
    //display messages
{
    // Create a table:
    echo '


            <table class="table table-bordered" cellspacing="2" cellpadding="2" align="center">
                <tr>
                    <td>Subject:</td>
                    <td>Posted By:</td>
                    <td>Posted On:</td>
                    <td>Replies:</td>
                    <td>Latest Reply:</td>
                </tr>';

    // Fetch each thread:
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
    {

        echo '<tr>
				<td><a href="read.php?category_id=' . $row['category_id'] . '&tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
				<td>' . $row['username'] . '</td>
				<td>' . $row['first'] . '</td>
				<td>' . $row['responses'] . '</td>
				<td>' . $row['last'] . '</td>
			</tr>';

    }

    echo '</table></div>'; // Complete the table.


}
else
{
    echo 'there are no messages to display';
}

?>

        </div>
    </div>
</div>

<?php

// Include the footer file
include ('includes/footer.html');
?>