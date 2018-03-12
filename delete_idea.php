<?php require_once 'overall/header.php'; 
error_reporting(E_ERROR);
if(!isset($_GET['idea_page'])){
    $idea_page=1;
} else{
    $idea_page = $_GET['idea_page'];
}
if(isset($_POST['yes'])){
    DB::getInstance()->delete('idea', array('idea_id', '=', $idea_page));
    DB::getInstance()->delete('attachment', array('idea_id', '=', $idea_page));
    Session::flash('delete_idea', 'You have removed the post successfully');
    Redirect::to('user_ideas_list.php?username=' . $user->data()->username);
}
if(isset($_POST['no'])){
    Redirect::to('qam.php');
}
?>
<div class="main-content">
    <div class="main">
        <div class="l_widget">
            <div class="title"> <i class="fa fa-bars" aria-hidden="true"></i> Menu</div>
            <div class="chart" style="text-align: left;">
                <?php require_once 'widgets/l_menu.php';?>
            </div>
        </div>
        <div class="m_widget">
            <div class="title" style="color: red;"><i class="fa fa-newspaper-o" aria-hidden="true"></i> You are about to DELETE the following Idea! </div>
            <div class="chart">
                <?php 
                $ideas=DB::getInstance()->get('idea', array('idea_id', '=', $idea_page));
                $p_date = $ideas->first()->posted_date;
                $date = date("d-m-Y H:i:s", strtotime($p_date));
                ?>                 
                <div class="post_data_container">
                    <div class="post_header"> 
                        <div class="post_title"> <?php  echo 'Post No '. $idea_page. ':'. ' ' . $ideas->first()->title; ?> </div> 
                        <div class="post_date"> <?php echo $date;?> </div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    <div class="post_content">
                        <?php
                        $attachments = DB::getInstance()->get('attachment', array('idea_id', '=', $idea_page));
                        if ($attachments->count()){            
                            foreach ($attachments->results() as $attachment){                 
                                $attachment = $attachments->first()->attachment;
                                echo '<img src="data:image;base64,'.base64_encode($attachment).' "/>';   
                            }   
                        }
                        $ideas=DB::getInstance()->get('idea', array('idea_id', '=', $idea_page));
                        echo escape($ideas->first()->content_text);
                    ?>
                                                
                    </div>
                    <div class="clear"></div>
                </div>
                    <div class="post_footer">
                    <div class="post_author"><?php 
                        $author_id = $ideas->first()->user_id;
                        $author_name= DB::getInstance()->get('users', array('id', '=', $author_id));
                        echo 'Author: '.  $author_name->first()->username; ?> </div>
                    </div>
                <div class="post_info">
                    <?php 
                        $user = new User();
                        if (!$user->isLoggedIn()){
                        ?>
                        <div class="tooltip">
                            <?php echo '<a href="comment.php?idea_page=' . $idea_page . '">      
                             <i class="fa fa-comment"></i></a>';                           
                            $no_com = 0;
                            $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $idea_page));
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
                           <span class="likes"><?php echo getLikes($idea_page); ?></span> 
                        <div class="tooltip">   
                           <i class="fa fa-thumbs-down dislike-btn-o"></i>
                           <span class="tooltiptext">You must be logged in</span>
                        </div>
                           <span class="dislikes"><?php echo getDislikes($idea_page); ?></span>
                        <?php
                        } else {                 
                            ?>
                        <div class="tooltip">
                            <?php echo '<a href="comment.php?idea_page=' . $idea_page. '">      
                             <i class="fa fa-comment"></i></a>'; 
                            $no_com = 0;
                            $no_comments = DB::getInstance()->get('comment', array('idea_id', '=', $idea_page));
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
                  
                             <i <?php if (userLiked($idea_page)): ?>
                                class="fa fa-thumbs-up like-btn"
                                 <?php else: ?>
                                      class="fa fa-thumbs-o-up like-btn"
                              <?php endif ?>
                              data-id="<?php echo $idea_page; ?>" aria-hidden="true"></i>
                                    <span class="likes"><?php echo getLikes($idea_page); ?></span>

                               <i <?php if (userDisliked($idea_page)): ?>
                                      class="fa fa-thumbs-down dislike-btn"
                              <?php else: ?>
                                      class ="fa fa-thumbs-o-down dislike-btn"
                              <?php endif ?>
                              data-id="<?php echo $idea_page; ?>" aria-hidden="true"></i> 
                                <span class="dislikes"><?php echo getDislikes($idea_page); ?></span>
                                <?php } ?>
                        </div>
                    <div class="clear"></div>                          
                    </div>               
                    <div class="buttons post_footer" style="margin: 20px; padding-top: 10px;">
                        <form method="post" >
                            <span style="color: red; font-size: 18px; "> Please confirm that you want to DELETE this post.</span><br>
                            <button class="btn_3" name="yes" type="submit" style="min-width: 100px;">Yes</button>
                            <button class="btn_3" name="no" type="submit" style="min-width: 100px; background-color: #F7BC2F; color: #252A4E; margin-left: 20px;">No</button>
                        </form>
                    </div>
                </div>                                                                                           
            </div>
        
        <div class="r_widget">
            <div class="title"> <i class="fa fa-th-list" aria-hidden="true"></i> Categories</div>
            <div class="chart">
                <ul>
                    <?php
                        $categories=DB::getInstance()->get('category', array('cat_id', '>', 0));
                        if(!$categories->count()){
                            echo 'There is no category list';
                        } else{                        
                        foreach ($categories->results() as $category){ 
                            $i_no=0;
                        $number_of_ideas= DB::getInstance()->get('idea', array('cat_id', '=', $category->cat_id));
                        if(!$number_of_ideas->count()){
                            $i_no = 0;
                        } else {
                            foreach ($number_of_ideas->results() as $number_of_idea){
                            $i_no++;
                            }
                        }
                    ?>
                    <li><a href="#"><?php  echo $category->cat_name . ' (' . $i_no . ')'; ?></a></li>
                    <?php  
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="title"><i class="fa fa-window-close-o" aria-hidden="true"></i> Archive</div>
            <div class="chart">
            </div>
        </div>
    <!--</div>-->
<?php require_once 'overall/footer.php';?>

