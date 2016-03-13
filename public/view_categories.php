<?php
//view_categories.php

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
<?php
//check to make sure user is admin
if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1)
{//user is admin
    $q = "SELECT categories.category_id, categories.category_name, categories.category_description, COUNT(threads.thread_id) AS thread_count, COUNT(posts.post_id) AS post_count, MAX(DATE_FORMAT(posts.posted_on, '%e-%b-%y %l:%i %p')) AS latest FROM categories LEFT JOIN threads ON categories.category_id = threads.thread_id LEFT JOIN posts ON threads.thread_id = posts.thread_id GROUP BY categories.category_id";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 0)
//display messages
    {
        // Create a table:
        echo '
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="categories table-responsive">
                <h1>View Forums</h1>
                <table class="table table-bordered" align="center">

                    <tr>
                        <td>Forum</td>
                        <td>Description</td>
                        <td>Latest Post</td>
                        <td>Threads</td>
                        <td>Posts</td>
                        <td>Delete</td>
                    </tr>';

        // Fetch each thread:
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {

            echo '<tr>
                    <td><a href="forum.php?category_id=' . $row['category_id'] . '">' . $row['category_name'] . '</a></td>
                    <td>' . $row['category_description'] . '</td>
                    <td>' . $row['latest'] . '</td>
                    <td>' . $row['thread_count'] . '</td>
                    <td>' . $row['post_count'] . '</td>
                    <td><a href="delete_category.php?category_id=' . $row['category_id'] . '">Delete</a></td>
			</tr>';

        }

        echo '</table></div></div></div></div>'; // Complete the table.

    }
//no messages
    else
    {
        echo '<p>There are currently no categories configured.</p>';
    }
    ?>

    <div class="row">
        <div class="col-xs-12">
            <form class="form text-center" action="add_category.php" method="post" accept-charset="utf-8">
                <h3>Forum Settings (Add Forums)</h3>

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

                    <div id="fill_container"></div>
                <br />
                <div class="text-center">
                    <input class="btn btn-primary" type="submit" name="submit" value="submit" />
                </div>
            </form>
        </div>
    </div>
<?php
}
else
{//user is not admin
    echo 'User access restricted';
}