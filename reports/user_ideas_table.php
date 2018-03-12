<table class="qam">
    <tr>
        <th>Select</th>
        <th>Idea Title</th>
        <th>Posted date </th>
        <th># Comment/s</th>
        <th># Like/s</th>
        <th># Dislike/s</th>
        <th>Actions</th>
    </tr>
    <?php 
        $user = new User();
        $id =$user->data()->id;
        $sql= "SELECT * FROM idea WHERE user_id = $id ORDER BY idea_id DESC";
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
        <td style="text-align: left;"><?php echo '<a href="comment.php?idea_page=' . $row['idea_id'] . '"> ' . $i . '.' . ' '. $row['title']. '</a>' ;?></td>
        <td><?php echo $date; ?></td>
        <td>
            <?php 
                $no_com = 0;
                $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $row['idea_id']));
                if(!$no_comments->count()){
                    $no_com == 0;
                }else{
                    foreach ($no_comments->results() as $no_comment){
                        $no_com ++;
                    }
                } 
                echo $no_com;
            ?>
        </td>
        <td>
            <?php echo getLikes($row['idea_id']); ?>
        </td>
        <td>
            <?php echo getDislikes($row['idea_id']); ?>
        </td>
        <td>
            <button class="btn_2"><a href="delete_idea.php?idea_page=<?php echo $row['idea_id']; ?>">Delete</a></button>
            
        </td>
    </tr>
  <?php
        }
            
    ?>
</table>
