<?php require_once 'overall/header.php';
if(!$user->isLoggedIn()){
    Redirect::to('index.php'); 
    } else {
        if(!$user->hasPermission('qam')){
        Redirect::to('index.php');                      
        }
    }
?>
<div class="main-content">
    <div class="main">
        <div class="l_widget">
            <div class="title"> <i class="fa fa-bars" aria-hidden="true"></i> Menu</div>
            <div class="chart" style="text-align: left;">
                <?php require_once 'widgets/qam_left_menu.php';?>
            </div>
        </div>
        <div class="widget">
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> List of Categories
                <?php 
                    if (Session::exists('new_cat')){
                    echo ' ','<strong><span style="color:#00ff00">' . Session::flash('new_cat') . '</span></strong<br>';
                    }
                    if (Session::exists('delete_category')){
                    echo ' ','<strong><span style="color:#FF0000">' . Session::flash('delete_category') . '</span></strong<br>';
                    }
                ?>
            </div>
            <div class="chart">
                <?php require_once 'reports/categories_table.php';?>
            </div>
             <div class="small_form" style="margin-top: 20px; padding-top: 10px;">
                <form method="post" >
                    <div id="errors">
                        <?php require_once 'inc/add_category.php';?>
                    </div>
                    <div>
                        <label>Enter the new Category below:</label>
                        <input type="text" name="new_category" value="<?php echo Input::get('new_category')?>" placeholder="Enter Category mane " autocomplete="off">
                    </div>
                    <button class="btn_3" name="add_category" type="submit" style="min-width: 100px;">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php require_once 'overall/footer.php';?>


