<?php
$ideas=DB::getInstance()->get('idea', array('idea_id', '>', 0));
if(!$ideas->count()){
    echo 'No ideas has been posted.';
} else {
$idea_per_page =5;
$i=0; 
foreach ($ideas->results() as $idea){ 
        $i++;
}
$nuber_of_pages= ceil($i/$idea_per_page); 
if(!isset($_GET['page'])){
    $page=1;
} else{
    $page = $_GET['page'];
}
$the_page_start_result = ($page-1)*$idea_per_page;
if(!$user->hasPermission('qam')){
$sql="SELECT * FROM idea WHERE hide = '0' ORDER BY idea_id DESC LIMIT " . $the_page_start_result . ','. $idea_per_page;
} else {
  $sql="SELECT * FROM idea ORDER BY idea_id DESC LIMIT " . $the_page_start_result . ','. $idea_per_page;  
}
$results= mysqli_query($conn, $sql);
$no=0;
while ($row= mysqli_fetch_array($results)){ 
    $no++;
    $p_date = $row['posted_date'];
    $date = date("d-m-Y H:i:s", strtotime($p_date));
    $c_date = $row['close_date'];
    $date_1 = date("d-m-Y", strtotime($c_date. '-1 day'));
    $n_date = strtotime(date("Y-m-d"));
    $any = $row['anonymous'];
    $hidden = 'style="display: none;"';  
    if($user->hasPermission('qam')){
        $hidden = 'style="display: block;"';
    }
    if ($row['hide'] == 1){
        $hide_post = 'fa fa-eye-slash';
        $hide_text = 'Show this post';
    } else{
        $hide_post = 'fa fa-eye';
        $hide_text = 'Hide this Post';
    }
    ?>
<div class="post_data_container">
    <div class="post_header"> 
        <?php require_once 'srv.php'; ?>
        <div class="post_title" style="direction: <?php echo $hidden;?>"> <?php  echo $no . ') Post No' . $row['idea_id'] . ':'. ' ' . $row['title']; ?> </div>
        <i class="<?php echo $hide_post;?> hide-btn" <?php echo $hidden;?> data-id="<?php echo $row['idea_id']; ?>">
        </i>
        <div class="post_date"> <?php echo $date;?> </div>
        <div class="clear"></div>
    </div>
    <div>
    <div class="post_content">
    <?php
        $attachments = DB::getInstance()->get('attachment', array('idea_id', '=', $row['idea_id']));
        if ($attachments->count()){            
            foreach ($attachments->results() as $attachment){                 
                $attachment = $attachments->first()->attachment;
                echo '<img src="data:image;base64,'.base64_encode($attachment).' "/>';   
            }   
        }    
       echo escape($row['content_text']);
    ?>
    </div> 
    <div class="clear"></div>
    </div>
    <div class="post_footer">
    <div class="post_author">
        <?php 
        if($any == 1){
            $author = 'Anonymous';
        } else {        
            $author_id = $row['user_id'];
            $author_name= DB::getInstance()->get('users', array('id', '=', $author_id));
            $author = $author_name->first()->username;
            }
            if($author_name->first()->block == 1){
                $block_user = 'fa-ban';
            } else {
                $block_user = 'fa-universal-access';
            }
            echo 'Author: '.  $author;
        ?> 
    </div>
        <i class="fa <?php echo $block_user;?> block-btn" <?php echo $hidden;?> data-id="<?php echo $row['user_id']; ?>"></i>
    </div>
    <div class="post_cdate">
        <?php
        $ex_date = strtotime($c_date);
        if($ex_date > $n_date){
           echo '<span style="color:#419133"><strong>Open to like/dislike till: '. $c_date. ' 23:59:59 </strong></span>';
           $ex = 0;
        } else {
            echo '<span style="color:#D14424"><strong>Like/dislike closed on '. $c_date. ' at 23:59:59</strong><span>';
            $ex = 1;
        }
        ?>
    </div>
    <div class="post_info">
            <?php 
            $user = new User();
            if (!$user->isLoggedIn()){
                ?>
        <div class="tooltip">
               <?php echo '<a href="comment.php?idea_page=' . $row['idea_id'] . '"> <i class="fa fa-comment"></i></a>';  
            $no_com = 0;
            $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $row['idea_id']));
                if(!$no_comments->count()){
                    $no_com == 0;
                }else{
                    foreach ($no_comments->results() as $no_comment){
                        $no_com ++;
                    }
                }            
            ?>
                <span class="tooltiptext">Click here to view the comments for this idea.</span>
        </div>
            <span class="comm">
            <?php
                if($no_com ==0){
                    echo 'Be the first to comment on this post';
                } else {
                    echo $no_com; 
                }
            ?>
            </span>               
                <div class="tooltip">
                    <i class="fa fa-thumbs-up like-btn-o"></i>
                    <span class="tooltiptext">You must be logged in</span>
                </div>
                   <span class="likes"><?php echo getLikes($row['idea_id']); ?></span> 
                <div class="tooltip">   
                   <i class="fa fa-thumbs-down dislike-btn-o"></i>
                   <span class="tooltiptext">You must be logged in</span>
                </div>
                   <span class="dislikes"><?php echo getDislikes($row['idea_id']); ?></span>
                    <?php
            } else {                 
            ?>
        <div class="tooltip">
            <?php echo '<a href="comment.php?idea_page=' . $row['idea_id'] . '"><i class="fa fa-comment"></i></a>'; ?>      
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
            ?>
            <span class="tooltiptext">Click here to view the comments for this idea.</span>
        </div>
            <span class="comm">
            <?php
                if($no_com ==0){
                    echo 'Be the first to comment on this post';
                } else {
                    echo $no_com; 
                }
            ?>
            </span>                   
        <?php 
            if($ex == 1){                
                ?>
                 <div class="tooltip">
                    <i class="fa fa-thumbs-up like-btn-o"></i>
                    <span class="tooltiptext">Idea's Vote time is closed</span>
                </div>
                   <span class="likes"><?php echo getLikes($row['idea_id']); ?></span> 
                <div class="tooltip">   
                   <i class="fa fa-thumbs-down dislike-btn-o"></i>
                   <span class="tooltiptext">Idea's Vote time is closed</span>
                </div>
                   <span class="dislikes"><?php echo getDislikes($row['idea_id']); ?></span>                       
                <?php               
            } else {                                   
        ?>                           
         <i <?php if (userLiked($row['idea_id'])): ?>
                          class="fa fa-thumbs-up like-btn"
             <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $row['idea_id']; ?>" aria-hidden="true"></i>
                <span class="likes"><?php echo getLikes($row['idea_id']); ?></span>
           <i <?php if (userDisliked($row['idea_id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class ="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $row['idea_id']; ?>" aria-hidden="true"></i> 
            <span class="dislikes"><?php echo getDislikes($row['idea_id']); ?></span>                                                 
            <?php } } ?>
    </div>
<div class="clear"></div>  
</div>
    <?php } ?> 
    <div class="page_number">
        <?php
       for($page=1; $page<=$nuber_of_pages; $page++){
           echo '<a href="ideas_list.php?page=' . $page . '">'. $page . '</a>';
       }
       ?>
    </div>
<?php
    }
?>
