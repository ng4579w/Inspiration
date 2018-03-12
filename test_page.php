<?php require_once 'overall/header.php';
//$conn = mysqli_connect('127.0.0.1', 'root', '', 'inspirations');
?>
<div class="main-content">
<?php
$ideas=DB::getInstance()->get('idea', array('idea_id', '>', 0));
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
$sql="SELECT * FROM idea LIMIT " . $the_page_start_result . ','. $idea_per_page;
$results= mysqli_query($conn, $sql);
while ($row= mysqli_fetch_array($results)){            
$p_date = $row['posted_date'];
    $date = date("d-m-Y H:i:s", strtotime($p_date)); 
    ?>
<div class="post_data_container">
    <div class="post_header"> 
        <div class="post_title"> <?php  echo $row['title']; ?> </div> 
        <div class="post_date"> <?php echo $date;?> </div>
        <div class="clear"></div>
    </div>
    <div class="post_content"><?php  echo escape($row['content_text']); ?></div>
    <div class="post_footer">
    <div class="post_author"><?php 
        $author_id = $row['user_id'];
//        $user = new User();
        $author_name= DB::getInstance()->get('users', array('id', '=', $author_id));
        echo 'Author: '.  $author_name->first()->username; ?> </div>
    </div>
    <div class="post_info">
            <?php 
            $user = new User();
            if (!$user->isLoggedIn()){
                ?>
                <div class="tooltip">
                    <i class="fa fa-comment"></i>
                </div>
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
            <i class="fa fa-comment"></i>
        </div>                   

         <i <?php if (userLiked($row['idea_id'])): ?>
                          class="fa fa-thumbs-up like-btn"
             <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $row['idea_id'] ?>" aria-hidden="true"></i>
                <span class="likes"><?php echo getLikes($row['idea_id']); ?></span>

           <i <?php if (userDisliked($row['idea_id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class ="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $row['idea_id'] ?>" aria-hidden="true"></i> 
            <span class="dislikes"><?php echo getDislikes($row['idea_id']); ?></span>
            <?php } ?>
    </div>
<div class="clear"></div>
    
    
    
    
</div>
    <?php
}
?>
 
<div class="page_number">
 <?php
for($page=1; $page<=$nuber_of_pages; $page++){
    echo '<a href="test_page.php?page=' . $page . '">'. $page . '</a>';
}
?>
</div>


<?php require_once 'overall/footer.php';?>



