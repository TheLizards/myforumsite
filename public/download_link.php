<?php
//download.php

//include header.php
include('includes/header.php');

echo 'File should now download';
?>



<?php
//if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //validate admin_email
    if(isset($_POST['admin_email']) && !empty($_POST['admin_email']) && filter_var($_POST['admin_email'], FILTER_VALIDATE_EMAIL))
    {
        $admin_email = $_POST['admin_email'];
    }
    else
    {
        $admin_email = "test@testing.com";
    }

    //validate site_name
    if(isset($_POST['site_name']) && !empty($_POST['site_name']))
    {
        $site_name = $_POST['site_name'];
    }
    else{
        $site_name = "Default Site Name";
    }

    //validate base_url
    if(isset($_POST['base_url']) && !empty($_POST['base_url']))
    {
        $base_url = $_POST['base_url'];
    }
    else{
        $base_url = "example.com";
    }

    //validate title
    if(isset($_POST['title']) && !empty($_POST['title']))
    {
        $title = $_POST['title'];
    }
    else{
        $title = "Default Title";
    }

    //validate about
    if(isset($_POST['about']) && !empty($_POST['about']))
    {
        $about = $_POST['about'];
    }
    else{
        $about = "Default About";
    }

    //Handle MySQL Settings

    //validate db_user
    if(isset($_POST['db_user']) && !empty($_POST['db_user']))
    {
        $db_user = mysqli_real_escape_string($dbc, $_POST['db_user']);
    }
    else{
        $db_user = 'root';
    }

    //validate db_pass
    if(isset($_POST['db_pass']) && !empty($_POST['db_pass']))
    {
        $db_pass = mysqli_real_escape_string($dbc, $_POST['db_pass']);
    }
    else{
        $db_pass = '1234';
    }

    //validate db_host
    if(isset($_POST['db_host']) && !empty($_POST['db_host']))
    {
        $db_host = $_POST['db_host'];
    }
    else{
        $db_host = 'localhost';
    }

    //validate db_name
    if(isset($_POST['db_name']) && !empty($_POST['db_name']))
    {
        $db_name = mysqli_real_escape_string($dbc, $_POST['db_name']);
    }
    else{
        $db_name = 'demo';
    }

    //create folder for user if it does not exist
    if (!file_exists('../download/' . $admin_email)) {
        mkdir('../download/' . $admin_email, 0777, true);
    }

    //write file for MySQL info
    file_put_contents('../download/' . $admin_email . '/mysql_variables.php', '
    <?php

    $db_user = "' . $db_user . '";
    $db_pass = "' . $db_pass . '";
    $db_host = "' . $db_host . '";
    $db_name = "' . $db_name . '";

    $admin_email = "' . $admin_email . '";

    ');

    //write file for settings input
    file_put_contents('../download/' . $admin_email . '/mysql_settings_input.php', '

    <?php

    require("includes/header.php");

$q = <<<EOD

    USE ' . $db_name . ';

    INSERT INTO settings (site_name, title, about) VALUES ("' . $site_name . '", "' . $title . '", "' . $about . '");

EOD;

    $r = mysqli_multi_query($dbc, $q);

    if(!$r)
    {
        echo "Error entering settings data: " . mysqli_error($dbc);
    }
    else
    {
        echo "Settings information Added <br />";
    }

    ');

    //zip files
    $zipname = "/var/www/myforumsite.com/download/$admin_email/config.zip";
    $zip = new ZipArchive;

    $zip->open($zipname, ZipArchive::CREATE);
    //echo var_dump($zip) . '<br />';
    $path = "/var/www/myforumsite.com/download/$admin_email";
   // echo var_dump($path) . '<br />';
    $handle = opendir($path);
    //echo var_dump($handle) . '<br /';
    if($handle = opendir($path)) {
        //echo var_dump($handle);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && strstr($entry,'.php')) {
                //echo 'path: ' . $path . '<br />';
                //echo 'entry: ' . $entry . '<br />';
                $download_path = $path . '/' . $entry;
                //echo 'download_path: ' . $download_path . '<br />';
                $content = file_get_contents($download_path) . '<br />';
                //echo 'content: ' . var_dump($content) . '<br />';
                $zip->addFromString(pathinfo ($download_path, PATHINFO_BASENAME), $content);
            }
        }
        closedir($handle);
    }

    //echo var_dump($zip) . '<br />';

    $zip->close();

    $name = basename($zipname);

    ?>


    <script>
        var email = "<?php echo $admin_email; ?>";
        location.href = "download.php?email=" + email;
    </script>

<?php
}
?>


