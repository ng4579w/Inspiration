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
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Ideas Summery list</div>
            <div class="chart">
                <?php require_once 'reports/ideas_table.php';?>
            </div>
        </div>
    </div>
<?php require_once 'overall/footer.php';?>