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
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Info Ideas per Department overall %.</div>
            <div class="chart">
                <?php require_once 'reports/department_statistics.php';?>
            </div>
            <div class="chart">
                <div id="container" style="min-width: 310px; height: 300px; max-width: 600px; margin-left: 20px"></div>
                <script src="js/pie.js"></script>
            </div>
    </div>
<?php require_once 'overall/footer.php';?>