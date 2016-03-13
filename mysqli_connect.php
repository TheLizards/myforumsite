<?php
//mysqli_connect.php
require('mysql_vars.php');

// Set the database access information as constants
DEFINE ('DB_USER', $db_user);
DEFINE ('DB_PASSWORD', $db_pass);
DEFINE ('DB_HOST', $db_host);
DEFINE ('DB_NAME', $db_name);

// Connect to Mysql using constants and table name
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

//if connection fails, trigger error
if(!$dbc)
{
    //try to connect without the database setup yet
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
    //Check if connection worked
    if(!$dbc)
    {
        trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
    }
    else
    {
        $q = "CREATE DATABASE '$db_name'";
        mysqli_query($dbc, $q);
    }

}
//connection was successful
else
{
    // Set encoding
    mysqli_set_charset($dbc, 'utf8');
}

