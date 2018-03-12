<?php require_once 'overall/header.php';?>
<div class="main-content">
    <div class="hero">
        <div id="comments">
            <embed src="images/light.svg" width="30%" height="100%" style="float: left;">
            <div class="hero_text"> 
               <h1 class="animationText">University Viewpoint</h1><br>
               
              <p class="animationText1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ultrices dictum tempus. Duis id sem vulputate, aliquam eros vitae, dignissim diam. Fusce mattis magna nulla.</p>
              <div class="clear"></div>
           </div>  
              <div class="clear"></div>          
            </div>
    </div>
    <div class="main">
    <div class="widget">
        <div class="title" style="text-align: center;">The list of latest posted ideas.</div>
        <div class="chart" style="text-align: left;">
            <?php 
            $sql= "SELECT * FROM idea ORDER BY idea_id DESC LIMIT 5";
            $results= mysqli_query($conn, $sql);
            $i=0;
            while ($row= mysqli_fetch_array($results)){
                $i++;
                ?>
            <div class="list_item">
                <?php echo '<a href="comment.php?idea_page=' . $row['idea_id'] . '">' . $i . '.' . ' '. $row['title'] . '</a>';?>
            </div> <?php
            }
            ?>            
            <div class="btn_1">
            <a href="ideas_list.php"> Read More <i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
            </div>
        </div>                    
    </div>
    <div class="widget">
        <div class="title" style="text-align: center">The list of most popular ideas</div>
         <div class="chart" style="text-align: left;">
            <div class="list_item">
                <a href="#">1. The latest idea example one.</a>
            </div>
            <div class="list_item">
                <a href="">2. The latest idea example two.</a>
            </div>
            <div class="list_item">
                <a href="">3. The latest idea example three.</a>
            </div>
            <div class="list_item">
                <a href="">4. The latest idea example four.</a>
            </div>
            <div class="list_item">
                <a href="">5. The latest idea example five.</a>
            </div> 
            <div class="btn_1">
            <a href="populr_idea.php"> Read More <i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
            </div>
        </div> 
    </div>
    <div class="widget">
        <div class="title" style="text-align: center">The list of ideas for which Voting is ending soon.</div>
         <div class="chart" style="text-align: left;">
            <div class="list_item">
                <a href="#">1. The latest idea example one.</a>
            </div>
            <div class="list_item">
                <a href="">2. The latest idea example two.</a>
            </div>
            <div class="list_item">
                <a href="">3. The latest idea example three.</a>
            </div>
            <div class="list_item">
                <a href="">4. The latest idea example four.</a>
            </div>
            <div class="list_item">
                <a href="">5. The latest idea example five.</a>
            </div>
            <div class="btn_1">
            <a href="end_soon.php"> Read More <i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
            </div>
        </div> 
    </div>                
</div>
<?php require_once 'overall/footer.php';?>