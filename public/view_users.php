<?php
//view_users.php

//include header.php
include('includes/header.php');

echo '
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="categories table-responsive">
                <h1>Users</h1>
                <table class="table table-bordered" cellspacing="2" cellpadding="2" align="center">
                    <tr>
                        <td>Username:</td>
                        <td>Email:</td>
                        <td>User Level:</td>
                        <td>Active:</td>
                        <td>Date Created:</td>
                        <td>Delete</td>
                    </tr>';

//check to make sure user is admin
if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
{//user is admin
    $q = 'SELECT users.user_id, users.username, users.email, users.user_level, users.active, users.date_created FROM users';
    $r = mysqli_query($dbc, $q);

    if(mysqli_num_rows($r) > 0)
    {//query was sucessful
        // Fetch each thread:
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {

            echo '<tr>
				<td><a href="users.php?user_id=' . $row['user_id'] . '">' . $row['username'] . '</a></td>
				<td>' . $row['email'] . '</td>
				<td>' . $row['user_level'] . '</td>
				<td>' . $row['active'] . '</td>
				<td>' . $row['date_created'] . '</td>

				<td><a href="delete_user.php?user_id=' . $row['user_id'] . '">Delete</a></td>
			</tr></div>';

        }
    }
    else
    {
        echo 'Query could not be completed, try again later';
    }
}
else
{//user is not admin
    echo 'User access restricted';
}