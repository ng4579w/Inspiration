<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
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
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> The latest posted ideas.
            <?php 
            if (Session::exists('new_post')){
            echo '<span style="color:#ff0000">' . Session::flash('new_post') . '</span><br>';
            }
            if (Session::exists('upload_image')){
            echo '<span style="color:#ff0000">' . Session::flash('upload_image') . '</span><br>';
            }
            if (Session::exists('upload_pdf')){
            echo '<span style="color:#ff0000">' . Session::flash('upload_pdf') . '</span><br>';
            }
            if (Session::exists('upload_word')){
            echo '<span style="color:#ff0000">' . Session::flash('upload_word') . '</span><br>';
            }
            ?>
            
            
            </div>
            <div class="chart">
                <?php require_once 'data/idea_data.php';?>            
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
                              if(!$user->hasPermission('qam')){
                                  if($number_of_idea->hide == 1){
                                      next($number_of_idea);
                                  } else {
                                      $i_no++;
                                      }
                                  } else {
                                      $i_no++;
                                      
                                  }                                                              
                                }                                                              
                        }
                    ?>
                    <li><a href="category_list.php?cat_name=<?php echo $category->cat_id;?>"><?php  echo $category->cat_name . ' (' . $i_no . ')'; ?></a></li>
                    <?php  }    
                    }
                    ?>
                </ul>
            </div>
            <div class="title"><i class="fa fa-window-close-o" aria-hidden="true"></i> Archive</div>
            <div class="chart">
            </div>
        </div>
    </div>
<?php require_once 'overall/footer.php';?>