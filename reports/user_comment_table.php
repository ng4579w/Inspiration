<table class="qam">
    <tr>
        <th>Select</th>
        <th style="max-width: 200px;">Comment</th>
        <th>Posted date </th>
        <th>Idea Title</th>
        <th>Actions</th>
    </tr>
    <?php 
        $user = new User();
        $id =$user->data()->id;
        $sql= "SELECT * FROM comment WHERE user_id = $id ORDER BY idea_id DESC";
        $results= mysqli_query($conn, $sql);
        $i=0;
        while ($row= mysqli_fetch_array($results)){
                $i++;
                $post_date = $row['posted_date'];
                $date = date("d-m-Y", strtotime($post_date));
              ?>
    <tr>
        <td>
            <input type="checkbox" name="check_idea" id="check_idea"/> 
        </td>
        <td style="text-align: left; max-width: 300px;"><?php echo  $i . '.' . ' '. $row['content_text']  ;?></td>
        <td><?php echo $date; ?></td>
        <td>
            <?php
            $idea_id = $row['idea_id'];
            $sql_idea = "SELECT * FROM idea WHERE idea_id = $idea_id";
            $results_idea= mysqli_query($conn, $sql_idea);
            $row_idea= mysqli_fetch_array($results_idea);
            echo $row_idea['title'];
            ?>
             
        </td>

        <td>
            <button class="btn_2"><a href="delete_idea.php?idea_page=<?php echo $row['idea_id']; ?>">Delete</a></button>
            
        </td>
    </tr>
  <?php
        }
            
    ?>
</table>
