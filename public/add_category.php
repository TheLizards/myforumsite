<?php

//include header.php
include('includes/header.php');

//validate forum_number
if(isset($_POST['forum_number']) && !empty($_POST['forum_number']))
{
    $forum_number = $_POST['forum_number'];
}
else{
    $forum_number = 0;
}

//set $forums to store array of forum names
$forums_name = array();
$forums_desc = array();

//Loop through forum and add them to array
if($forum_number > 0 && $forum_number <= 12)
{
    for($i=1; $i<=$forum_number; $i++)
    {
        if(isset($_POST["forum_name_$i"]) && !empty($_POST["forum_name_$i"]))
        {
            //echo $_POST["forum_name_$i"];
            $forums_name[$i] = mysqli_real_escape_string($dbc, $_POST["forum_name_$i"]);

        }
        if(isset($_POST["forum_desc_$i"]) && !empty($_POST["forum_desc_$i"]))
        {
            //echo $_POST["forum_name_$i"];
            $forums_desc[$i] = mysqli_real_escape_string($dbc, $_POST["forum_desc_$i"]);
        }
    }
}

if($forum_number > 0 && $forum_number <= 12)
{
    for($i=1; $i<=$forum_number; $i++)
    {
        $forum_name = $forums_name[$i];

        $forum_description = $forums_desc[$i];

        echo $forum_name . '<br />';
        echo $forum_description . '<br />';

        if(isset($forums_name) && isset($forum_description) && $forums_name !== '' && $forum_description !== ''){
            $q = "INSERT INTO categories (category_name, category_description) VALUES ('$forum_name', '$forum_description')";
            $r = mysqli_query($dbc,$q);
            if($r){
                echo $forum_name . ' was inserted into the database' . '<br />';;
            }
            else{
                printf("Error: %s\n", mysqli_error($dbc));
                exit();

                //echo 'could not add ' . $forums_name[$i] . '<br />';
            }
        }
        else{
            echo 'Category name or description was not set';
        }
    }
}
else{
    echo 'No forum info was entered!';
}