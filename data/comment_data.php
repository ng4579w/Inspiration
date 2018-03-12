<?php
$comments=DB::getInstance()->get('comment', array('idea_id', '=', $idea_page));
if($comments->count()){
    $com_no = 0;
    foreach ($comments->results() as $comment){
        $com_no++;
        $c_date = $comment->posted_date;
        $comment_date = date("d-m-Y H:i:s", strtotime($c_date));
        $any_c = $comment->anonymous;
    ?>
    <div class="comment_data_container" style ="display: block;"> 
        <div class="post_header">
            <div class="post_title">Comment #<?php echo $com_no; ?></div>
            <div class="post_author" style="padding: 16px;">
                <?php 
                    if($any_c == 1){
                        $author_c = 'Anonymous';
                    } else {
                    $author_id = $comment->user_id;
                    $author_name= DB::getInstance()->get('users', array('id', '=', $author_id));
                    $author_c = $author_name->first()->username;
                    }
                    echo 'Author: '.  $author_c;
                ?> 
            </div>
            <div class="post_date"> <?php echo $comment_date;?> </div>
            <div class="clear"></div>
        </div>
        <div class="com_content">
            <?php echo $comment->content_text;?> 
        </div>
     </div>
    <?php } ?>
   
<?php } ?>


