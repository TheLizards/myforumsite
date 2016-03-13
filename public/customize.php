<?php
//customize.php

//include header.php
include('includes/header.php');

?>

<script>
    function addFields()
    {
        var number = document.getElementById("forum_number").value;
        var fill_container = document.getElementById("fill_container");
        while(fill_container.hasChildNodes())
        {
            fill_container.removeChild(fill_container.lastChild);
        }
        for(i=0; i<number; i++)
        {
            fill_container.appendChild(document.createTextNode("Sub-forum #" + (i+1) + ":  "));

            fill_container.appendChild(document.createElement("br"));

            fill_container.appendChild(document.createTextNode("name:  "));

            var input_name = document.createElement("input");
            input_name.setAttribute("id", "forum_name_" + (i+1));
            input_name.setAttribute("name", "forum_name_" + (i+1))
            input_name.setAttribute("class", "forum_create_input");
            input_name.type = "text";

            fill_container.appendChild(input_name);

            fill_container.appendChild(document.createTextNode("description:  "));

            var input_desc = document.createElement("input");
            input_desc.setAttribute("id", "forum_desc_" + (i+1));
            input_desc.setAttribute("name", "forum_desc_" + (i+1))
            input_desc.setAttribute("class", "forum_create_input");
            input_desc.type = "text";


            fill_container.appendChild(input_desc);

            fill_container.appendChild(document.createElement("br"));

        }
    }

</script>

<div class="row">
<div class="col-xs-12">
    <h1 class="text-center">Configure your site below:</h1>

    <form class="form" action="download_link.php" method="post" accept-charset="utf-8">
        <h3>General Settings</h3>
            <div class="form-group"
                <p>Admin Email (your email, used for error reporting): </p>
                <input class="form-control" name="admin_email" type="text" />
            </div>
            <div class="form-group"
                <p>Site Name (ex MyForumSite: </p>
                <input class="form-control" name="site_name" type="text" />
            </div>
            <div class="form-group"
                <p>Site Base URL (ex myforumsite.com): </p>
                <input class="form-control" name="base_url" type="text" />
            </div>
            <div class="form-group">
                <p>Title (give your site an interesting title): </p>
                <input class="form-control" name="title" type="text" />
            </div>
            <div class="form-group">
                <p>About (Give a detailed explanation of what your site is about): </p>
                <textarea class="form-control" name="about" >

                </textarea>
            </div>


        <!--<h3>Forum Settings (Add Forums)</h3>

            <p>Add up to 12 different sub-forums, provide name and description</p>
            <select name="forum_number" id="forum_number">
                <option value="0" selected>0</option>
                <option value="1" >1</option>
                <option value="2" >2</option>
                <option value="3" >3</option>
                <option value="4" >4</option>
                <option value="5" >5</option>
                <option value="6" >6</option>
                <option value="7" >7</option>
                <option value="8" >8</option>
                <option value="9" >9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>

            <a href="#" id="fill_details" onclick="addFields()">Fill Details</a>

            <div id="fill_container"></div>-->

        <h3>MySQL Settings (used to connect to database)</h3>
            <div class="form-group">
                <p>Database User (ex root): </p>
                <input class="form-control" name="db_user" type="text" />
            </div>
            <div class="form-group">
                <p>Database Password (ex pwd123): </p>
                <input class="form-control" name="db_pass" type="text" />
            </div>
            <div class="form-group">
                <p>Database Host (ex localhost): </p>
                <input class="form-control" name="db_host" type="text" />
            </div>
            <div class="form-group">
                <p>Database Name (ex myforumsite_db): </p>
                <input class="form-control" name="db_name" type="text" />
            </div>

            <div class="text-center">
                    <input class="btn btn-primary" type="submit" name="submit" value="submit" />
            </div>
    </form>