<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
if(!$user->isLoggedIn()){
        Redirect::to('index.php'); 
        } else {
            if(isset($_GET['username'])){
                $username= $_GET['username'];
                if($username!= $user->data()->username){
                Redirect::to('user_ideas_list.php?username='.$user->data()->username);                    
                }
            } 
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
        <div class="widget">
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> This is the list of all your posted ideas Click the links to view details.</div>
            <div class="chart">
                <?php require_once 'reports/user_ideas_table.php';?>
            </div>
        </div>
    </div>

<?php require_once 'overall/footer.php';?>


