<?php
//delete_post.php

//include header.php
include('includes/header.php');

//make sure user is an admin
if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
{
    if (isset($_GET['post_id']) && filter_var($_GET['post_id'], FILTER_VALIDATE_INT, array('min_range' => 0)))
    {
        $post_id = $_GET['post_id'];
        $q = "DELETE FROM posts WHERE post_id = '$post_id'";
        $r = mysqli_query($dbc, $q);

        if(mysqli_affected_rows($dbc)> 0)
        {
            echo 'post_id: ' . $post_id . ' has been deleted';
        }
        else{
            echo 'post could not be deleted';
        }
    }
    else{
        echo 'post_id is not set';
    }
}
else
{
    echo 'you do not have permission';
}
