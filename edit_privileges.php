<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
?>
<div class="main-content">
    <div class="title">
        Hello  <?php echo escape($user->data()->username); ?>
    </div>
    <div class="main">
        <div class="l_widget">
            <div class="title"> <i class="fa fa-bars" aria-hidden="true"></i> Menu</div>
            <div class="chart" style="text-align: left;">
                <?php require_once 'widgets/l_menu.php';?>
            </div>
        </div>
        <div class="widget mr-auto">
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Use the form below to Search for a user. 
            
            <?php
            if (Session::exists('permission')){
                echo '<span style="color:#198000">' . Session::flash('permission') . '</span><br>';
                }
            ?>
            </div>
            
            
                <?php require_once 'forms/user_search.php';?><br>
               
            
                
            
        </div>       
    </div>
<?php require_once 'overall/footer.php';?>