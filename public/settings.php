<?php
//settings.php

//include header.php
include('includes/header.php');

// If user_id session variable is not set, redirect user
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_level']) || $_SESSION['user_level'] != 1)
{

    $url = '../forum_index.php'; // Define the URL.
    ob_end_clean(); // Delete the buffer.
    header("Location: $url");
    exit(); // Quit the script.

}

//if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Trim all the incoming data:
    $trimmed = array_map('trim', $_POST);

    //make no assumptions
    $site_name = $title = $about = FALSE;

    //validate site_name
    if(isset($trimmed['site_name']))
    {
        $site_name = mysqli_real_escape_string($dbc, $trimmed['site_name']);
    }
    else
    {
        echo 'please enter a site name';
    }

    //validate title
    if(isset($trimmed['title']))
    {
        $title = mysqli_real_escape_string($dbc, $trimmed['title']);
    }
    else
    {
        echo 'please enter a title';
    }

    //validate about
    if(isset($trimmed['about']))
    {
        $about = mysqli_real_escape_string($dbc, $trimmed['about']);
    }
    else
    {
        echo 'please enter an about section';
    }

    if($site_name && $title && $about)
    {
        $q = "SELECT setting_id FROM settings WHERE setting_id = 1";
        $r = mysqli_query($dbc, $q);

        if(mysqli_num_rows($r) == 0)
        {
            $q = "INSERT INTO settings (site_name, title, about) VALUES ('$site_name', '$title', '$about')";
            $r = mysqli_query($dbc, $q);

            if(mysqli_affected_rows($dbc) == 1)
            {
                echo 'your new settings have been saved';
            }
            else
            {
                echo ' your settings we not able to be saved, try again later';
            }
        }
        else
        {
            $q = "UPDATE settings SET site_name = '$site_name', title='$title', about='$about' WHERE setting_id = 1";
            $r = mysqli_query($dbc, $q);

            if(mysqli_affected_rows($dbc) == 1)
            {
                echo 'your new settings have been updated';
            }
            else
            {
                echo ' your settings we not able to be updated, try again later';
            }
        }

    }
}
//if form has not been submitted yet
else{

    $q = "SELECT setting_id, site_name, title, about FROM settings WHERE setting_id = 1";
    $r = mysqli_query($dbc, $q);

    if(mysqli_num_rows($r) == 1)
    {
        $row = mysqli_fetch_array($r, MYSQL_ASSOC);

        if(isset($row['setting_id']))
        {
            $setting_id = $row['setting_id'];
        }

        if(isset($row['site_name']))
        {
            $site_name = $row['site_name'];
        }

        if(isset($row['title']))
        {
            $title = $row['title'];
        }

        if(isset($row['about']))
        {
            $about = $row['about'];
        }
    }
    else
    {
        echo 'there are not any settings currently set';
    }

    echo '
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center">User Settings</h1>

                <form class="form" action="settings.php" method="post" accept-charset="utf-8">
                    <div class="form-group"
                        <p>Site Name: </p>
                        <input class="form-control" name="site_name" type="text" ';

                        if(isset($site_name))
                        {
                            echo 'value="' . $site_name . '"';
                        }

                        echo ' />';

    echo '
            </div>
            <div class="form-group">
                <p>Title: </p>
                <input class="form-control" name="title" type="text" ';

                if(isset($title))
                {
                    echo 'value="' . $title . '"';
                }

                echo ' />';

    echo '
            </div>
            <div class="form-group">
                <p>About: </p>
                <textarea class="form-control" name="about" >';

                if(isset($about))
                {
                    echo $about;
                }

                echo '</textarea>';

    echo '
            </div>
            <div class="text-center">
                <input class="btn btn-primary" type="submit" name="submit" value="update" />
            </div>
        </form>
    ';
}


