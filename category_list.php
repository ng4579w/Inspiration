<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
$category_list = $_GET['cat_name'];
$category_names = DB::getInstance()->get('category', array('cat_id', '=', $category_list));
$category_name = $category_names->first()->cat_name;
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
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> The latest of ideas from the category: <strong><?php echo $category_name;?></strong></div>
            <div class="chart">
                <?php require_once 'data/idea_cat_data.php'; ?>
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

