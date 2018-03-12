<?php
$ideas = DB::getInstance()->get('idea', array('cat_id', '=', $category_list));
if(!$ideas->count()){
    echo '<strong>No ideas has been posted under this category.</strong>';
} else {
    foreach ($ideas->results() as $idea){
        $p_date = $idea->posted_date;
        $date = date("d-m-Y H:i:s", strtotime($p_date));
        $c_date = $idea->close_date;
        $date_1 = date("d-m-Y", strtotime($c_date. '-1 day'));
        $n_date = strtotime(date("Y-m-d"));
        $any = $idea->anonymous;
        ?>
            <div class="post_data_container">
                <div class="post_header"> 
                    <div class="post_title"> <?php  echo 'Post No '. $idea->idea_id. ':'. ' ' . $idea->title; ?> </div> 
                    <div class="post_date"> <?php echo $date;?> </div>
                    <div class="clear"></div>
                </div>
                <div>
                    <div class="post_content">
                        <?php
                            $attachments = DB::getInstance()->get('attachment', array('idea_id', '=', $idea->idea_id));
                            if ($attachments->count()){            
                                foreach ($attachments->results() as $attachment){                 
                                    $attachment = $attachments->first()->attachment;
                                    echo '<img src="data:image;base64,'.base64_encode($attachment).' "/>';   
                                }   
                            }
                            echo escape($idea->content_text);
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
                        $author_id = $idea->user_id;
                        $author_name= DB::getInstance()->get('users', array('id', '=', $author_id));
                        $author = $author_name->first()->username;
                        }
                        echo 'Author: '.  $author;
                    ?>  
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
                </div>
                <div class="post_info">
                <?php 
                    $user = new User();
                    if (!$user->isLoggedIn()){
                    ?>
                    <div class="tooltip">
                        <?php echo '<a href="comment.php?idea_page=' . $idea->idea_id . '"> <i class="fa fa-comment"></i></a>'; 
                        $no_com = 0;
                        $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $idea->idea_id));
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
                       <span class="likes"><?php echo getLikes($idea->idea_id); ?></span> 
                    <div class="tooltip">   
                       <i class="fa fa-thumbs-down dislike-btn-o"></i>
                       <span class="tooltiptext">You must be logged in</span>
                    </div>
                       <span class="dislikes"><?php echo getDislikes($idea->idea_id); ?></span>
                    <?php
                    } else {                 
                        ?>
                    <div class="tooltip">
                        <?php echo '<a href="comment.php?idea_page=' . $idea->idea_id . '"> <i class="fa fa-comment"></i></a>'; 
                        $no_com = 0;
                        $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $idea->idea_id));
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
                       if($ex ==1){                           
                           ?>
                            <div class="tooltip">
                                <i class="fa fa-thumbs-up like-btn-o"></i>
                                <span class="tooltiptext">Idea's Vote time is closed</span>
                            </div>
                               <span class="likes"><?php echo getLikes($idea->idea_id); ?></span> 
                            <div class="tooltip">   
                               <i class="fa fa-thumbs-down dislike-btn-o"></i>
                               <span class="tooltiptext">Idea's Vote time is closed</span>
                            </div>
                               <span class="dislikes"><?php echo getDislikes($idea->idea_id); ?></span>    
                             <?php                           
                       } else {                      
                       ?>
                         <i <?php if (userLiked($idea->idea_id)): ?>
                            class="fa fa-thumbs-up like-btn"
                             <?php else: ?>
                                  class="fa fa-thumbs-o-up like-btn"
                          <?php endif ?>
                          data-id="<?php echo $idea->idea_id; ?>" aria-hidden="true"></i>
                                <span class="likes"><?php echo getLikes($idea->idea_id); ?></span>

                           <i <?php if (userDisliked($idea->idea_id)): ?>
                                  class="fa fa-thumbs-down dislike-btn"
                          <?php else: ?>
                                  class ="fa fa-thumbs-o-down dislike-btn"
                          <?php endif ?>
                          data-id="<?php echo $idea->idea_id; ?>" aria-hidden="true"></i> 
                            <span class="dislikes"><?php echo getDislikes($idea->idea_id); ?></span>
                            <?php } } ?>
                    </div>
                <div class="clear"></div>
            </div>                           
        <?php
    }
}

