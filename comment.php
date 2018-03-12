<?php require_once 'overall/header.php'; 
error_reporting(E_ERROR);
$checktc  = ( preg_match('/tandc/', $_POST['tandc']) ? 'checked="checked"' : '' );
if(!isset($_GET['idea_page'])){
    $idea_page=1;
} else{
    $idea_page = $_GET['idea_page'];
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
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> The latest posted ideas. </div>
            <div class="chart">
                <?php require_once 'data/idea_page_data.php';?>                
                <div class="post_comment" <?php $user = new User(); if($user->isLoggedIn()){ echo 'style="display: block;"';}?>>
                    <form method="post" style=" background-color: #fff; width: 100%;">
                        <div id="errors">
                            <?php require_once 'inc/new_comment_post.inc.php';?>
                        </div>
                        <label style="color: #252A4E">Write a comment for this idea:</label>
                        <textarea name="message" placeholder="Maximum 500 words." style="border: 1px solid #252A4E; height: 100px;"><?php echo Input::get('message')?></textarea>
                        <input type="checkbox" name="anonymus" id="anonymus"/> 
                        <label for="anonymus" style="color: #252A4E">Check the box if you want to comment anonymously.</label>
                        <input type="checkbox" name="tandc" id="tandc" value="tandc" <?php echo $checktc; ?>/> 
                        <label for="tandc" style="color: #252A4E">I have read and agree to the <a href="#">Terms & Conditions</a></label>
                        <div class="buttons">
                        <button class="btn_3" name="post_art" type="submit">Post your comment</button>
                        <button class="btn_3" name="clear_form" type="reset" style="background-color: #F7BC2F; color: #252A4E">Clear Form</button>
                        </div>
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
                    <li><a href="category_list.php?cat_name=<?php echo $category->cat_id;?>"><?php  echo $category->cat_name . ' (' . $i_no . ')'; ?></a></li>
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



