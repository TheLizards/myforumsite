<?php
//delete_user.php

//include header.php
include('includes/header.php');

//make sure user is an admin
if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
{
    if (isset($_GET['user_id']) && filter_var($_GET['user_id'], FILTER_VALIDATE_INT, array('min_range' => 0)))
    {
        $user_id = $_GET['user_id'];
        $q = "DELETE FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($dbc, $q);

        if(mysqli_affected_rows($dbc)> 0)
        {
            echo 'user_id ' . $user_id . ' has been deleted';
        }
        else{
            echo 'user could not be deleted';
        }
    }
    else{
        echo 'user_id is not set';
    }
}
else
{
    echo 'you do not have permission';
}
