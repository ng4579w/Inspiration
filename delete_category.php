<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
if(!isset($_GET['cat_page'])){
    $cat_page=1;
} else{
    $cat_page = $_GET['cat_page'];
}
$no_i = 0;
$no_ideas = DB::getInstance()->get('idea', array('cat_id', '=', $cat_page));
if (!$no_ideas->count()){
    $no_i = 0;
} else {
    foreach ($no_ideas->results() as $no_idea) {
        $no_i++;
    }  
}
$xidea = 'Idea';
if(isset($_POST['yes'])){
    DB::getInstance()->delete('category', array('cat_id', '=', $cat_page));
    Session::flash('delete_category', 'You have removed the category successfully');
    Redirect::to('categories.php');
}
if(isset($_POST['no'])){
    Redirect::to('categories.php');
}
if(isset($_POST['back'])){
    Redirect::to('categories.php');
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
            <div class="title" style="color: red;"><i class="fa fa-newspaper-o" aria-hidden="true"></i> You are about to DELETE the following Category! </div>
            <div class="chart">
                <?php 
                $categories=DB::getInstance()->get('category', array('cat_id', '=', $cat_page));
                ?>
                <div class="post_data_container" style="padding: 50px;">                    
                    <?php 
                    if ($no_i > 1){
                        $xidea = 'Ideas';
                    } else {
                        $xidea = 'Idea';
                    }
                    if($no_i == 0){
                    echo 'The Category <strong> "'. $categories->first()->cat_name.'"</strong> has <strong>' . $no_i.'</strong> '.  $xidea . '.';
                    ?>
                     <div class="buttons post_footer" style="margin-top: 20px; padding-top: 10px;">
                        <form method="post" >
                            <span style="color: red; font-size: 18px; "> Please confirm that you want to DELETE this Category.</span><br>
                            <button class="btn_3" name="yes" type="submit" style="min-width: 100px;">Yes</button>
                            <button class="btn_3" name="no" type="submit" style="min-width: 100px; background-color: #F7BC2F; color: #252A4E; margin-left: 20px;">No</button>
                        </form>
                    </div>   
                    <?php
                    }else{
                    echo 'The Category <strong> "'. $categories->first()->cat_name.'"</strong> has <strong>' . $no_i.'</strong> '.  $xidea.'.';
                    ?>
                     <div class="buttons post_footer" style="margin-top: 20px; padding-top: 10px;">
                        <form method="post" >
                            <span style="color: red; font-size: 18px; "> You can not DELETE this Category. Please contact the system administrator.</span><br>
                            <button class="btn_3" name="back" type="submit" style="min-width: 100px;">Go Back</button>
                        </form>
                    </div>   
                    <?php
                    }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
<?php require_once 'overall/footer.php';?>