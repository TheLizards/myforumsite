

    <?php

    require("includes/header.php");

$q = <<<EOD

    USE h;

    INSERT INTO settings (site_name, title, about) VALUES ("kh", "h", "kjh
                ");

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

    