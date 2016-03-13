<?php
//config.php

//error reporting settings

//your web sites name
DEFINE('SITE_NAME', "your sites name");
//is the site live?
DEFINE('LIVE', 'FALSE');
//the admin email address where error logs may get sent or where users will contact the admin
DEFINE('EMAIL', 'emailadddress');

//define paths
//this ipath of the url of your website
DEFINE('BASE_URL', 'myforumsite.dev');
//the relative path location of the mysqli_connect.php file we just created to connect to the database
DEFINE('MYSQL', 'mysqli_connect.php');

//time zone settings
date_default_timezone_set('US/Eastern');

//error handler function
function error_handler($e_number, $e_message, $e_file, $e_line, $e_vars)
{
    //error message
    $message = "There was an error while processing this script: '$e_file' on line $e_line: $e_message\n";
    $message .= "Date/Time: " . date('n-j-y H:i:s'). "\n";

    //if NOT live
    if(!LIVE)
    {
        //show the error message
        echo 'div class="error">' . nl2br($message);
        //print array of variables
        echo '<pre>' . print_r($e_vars,1) . "\n";
        //print history of function calls
        debug_print_backtrace();
        echo '</pre></div>';
    }
    //if live
    //don't show error message
    else
    {
        //create body of email
        $body = $message . "\n" . print_r($e_vars, 1);
        //email error to admin
        mail(EMAIL, 'Site Error!', $body, 'From: admin@gmail.com');

        //if error message is not an E_NOTICE, print generic error message for user
        if($e_number != E_NOTICE)
        {
            echo 'div class="error">A system error occurred. We apologize for the inconvenience.</div>';

        }
    }
}

//set error handler
set_error_handler('error_handler');


