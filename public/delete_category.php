<?php
//delete_category.php

//include header.php
include('includes/header.php');

//make sure user is an admin
if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
{
    if (isset($_GET['category_id']) && filter_var($_GET['category_id'], FILTER_VALIDATE_INT, array('min_range' => 0)))
    {
        $category_id = $_GET['category_id'];
        $q = "DELETE FROM categories WHERE category_id = '$category_id'";
        $r = mysqli_query($dbc, $q);

        if(mysqli_affected_rows($dbc)> 0)
        {
            echo 'category_id ' . $category_id . ' has been deleted';
        }
        else{
            echo 'category could not be deleted';
        }
    }
    else{
        echo 'category_id is not set';
    }
}
else
{
    echo 'you do not have permission';
}
