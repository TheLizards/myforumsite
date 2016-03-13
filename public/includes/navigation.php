<script>
    $(document).ready(function() {
        var url = window.location.pathname;
        $('li.menu').removeClass('active');
        $('li.menu a[href="..' + url + '"]').parent().addClass('active');
    })
</script>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../forum_index.php"><img class="brand-image" src='/img/speech_bubbles_silhouette_32.png'><span class="brand-text"><?php echo $site_name ?></span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li class="menu active""><a href="../forum_index.php">Home <span class="sr-only">(current)</span></a></li>
                <li class="menu"><a href="../categories.php" >Forum</a></li>
                <?php
                //if the user is logged in
                if(isset($_SESSION['user_id']))
                {
                    //if the user is on the forum.php page
                    if(basename($_SERVER['PHP_SELF']) == 'forum.php')
                    {
                        //echo '<li><a href="post.php" class="navlink">Create New Thread</a></li>';
                    }

                    echo '<li class="menu"><a href="../logout.php" class="menu">Logout</a></li>';
                    echo '<li class="menu"><a href="../change_password.php" class="menu" title="Change Password">Change Password</a></li>';

                    //if user is an admin
                    if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
                    {
                        echo '<li class="menu"><a href="../view_users.php" class="menu" title="View All Users">View All Users</a></li>';
                        echo '<li class="menu"><a href="../view_categories.php" class="menu" title="View All Categories">View All Categories</a></li>';
                        echo '<li class="menu"><a href="../settings.php" class="menu" title="Settings">Settings</a></li>';
                    }

                }
                else
                {
                    echo '<li class="menu"><a href="../register.php" class="menu">Register</a></li>' .
                        '<li class="menu"><a href="../login.php" class="menu">Login</a></li>';
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
