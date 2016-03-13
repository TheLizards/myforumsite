<?php

//include header.php
include('includes/header.php');


//check that user_id is set
if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT, array('min_range' => 0)))
{
    $user_id = $_GET['user_id'];
    //MySQL select statement
    $q = "SELECT users.username, DATE_FORMAT(users.date_created, '%b-%e-%Y') AS joined, COUNT(posts.post_id - 1) AS post_count FROM users INNER JOIN posts ON users.user_id = posts.user_id AND users.user_id = '$user_id' AND posts.user_id = '$user_id'";
    $r = mysqli_query($dbc, $q);

    if(mysqli_num_rows($r) > 0)
    {
        while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            $username = $row['username'];
            $username = ucwords($username);
            echo "<h1>$username's Profile</h1>";
            echo '<p>Date Joined: ' . $row['joined'];
            echo '<p>Total # of Posts: ' . $row['post_count'];
            echo '<p>Last 5 Posts: ';

            if($row['post_count'] > 0)
            {
                $q = "SELECT categories.category_id, categories.category_name, threads.thread_id, threads.subject, posts.post_id, posts.message, DATE_FORMAT(posts.posted_on, '%b-%e-%y') AS posted, users.username FROM categories INNER JOIN threads ON categories.category_id = threads.category_id INNER JOIN posts ON threads.thread_id = posts.thread_id INNER JOIN users ON users.user_id = posts.user_id AND users.user_id = '$user_id' ORDER BY posts.posted_on DESC LIMIT 5";
                $r = mysqli_query($dbc, $q);

                if(mysqli_num_rows($r) > 0)
                {
                    while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
                    {
                        echo "
		    <table class='table table-bordered'>
		        <tr><td>{$row['username']} ({$row['posted']}) in <a href='../forum.php?category_id=1'>({$row['category_name']}</a>-><a href='../read.php?category_id=1&tid=1'>{$row['subject']})</a></td><tr>
		        <tr><td>{$row['message']}</td></tr></table>";

                    }
                }
            }

        }
    }
}
