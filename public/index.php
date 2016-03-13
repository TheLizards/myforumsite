<?php
// index.php

// Include header file
include ('includes/header.php');
?>

<div class="row intro">
    <div class=" col-xs-12 text-center">
        <h1 class="site_name">Welcome to <?php echo $site_name; ?>!</h1>
        <h3 class="title">We provide all the files needed to setup your own forum site today</h3>
    </div>
</div>

<div class="row features text-center">
    <div class="text-center left-box col-xs-12 col-md-4 text-centered">
        <img src="./img/forum.jpg" class="feature_image img-responsive" />
        <h4>Fully functioned forum site</h4>
    </div>

    <div class="center-box col-xs-12 col-md-4 text-centered">
        <img src="./img/responsive-icon.png" class="feature_image img-responsive" />
        <h4>Responsive, Custom Styles</h4>
    </div>

    <div class="right-box col-xs-12 col-md-4 text-centered">
        <img src="./img/open2.gif" class="feature_image img-responsive" />
        <h4>Free and Open Sourced</h4>
    </div>
</div>

<br />

<div class="row links text-center">
    <div class="col-xs-12">
        <a href="customize.php"><button class="btn btn-primary">Get Started Now!</button></a>
        <br />
        <h4>All code can be found on my GitHub Page linked below:</h4>
        <a href="https://github.com/JamesAten?tab=repositories"><img src="../img/github_logo.png" class="github_logo"></a>
    </div>
</div>


<?php

include ('includes/footer.html');