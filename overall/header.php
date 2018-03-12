<?php 
ob_start();
require_once 'core/init.php';
require_once 'server.php';
require_once 'srv.php';
//$user = new User();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initioal-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/charts.css">
        <link rel="stylesheet" type="text/css" href="css/animation.css">
        <link rel="stylesheet" type="text/css" href="css/post_data_style.css">
        <link rel="stylesheet" type="text/css" href="css/form_style.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        
        <script src="js/main.js"></script>      
        <title>Inspiration University Viewpoint</title>
    </head>
    <body>
        <div class="header"> 
            <div class="logo"><a href="index.php">
                  <img src="images/light_1.svg">  
                <h1 style="float: right">
                    
                    <span>Inspiration</span>
                </h1>
                <div class="clear"></div>
                </a></div>
            <a href="#" class="nav-trigger"><span></span></a>
        <div class="top-nav">
            <?php 
//             $user = new User();
              if ($user->isLoggedIn()){
                  ?>
            <div class="profile">
                <img src="./images/profile_icon.png">
                <span><?php echo $user->data()->username;?></span>
                <div class="clear"></div>
            </div> 
                  <?php
              }
            ?>
            <nav>
                <ul>
                    <li class="">
                        <a href="index.php">
                            <span><i class="fa fa-home" aria-hidden="true"></i></span>
                            <samp>Home</samp>
                        </a>
                    </li>
                    <li class="">
                        <a href="about.php">
                            <span><i class="fa fa-list-alt"></i></span>
                            <samp>About</samp>
                        </a>
                    </li>
                    <?php 
                        $user = new User();
                        if ($user->isLoggedIn()){
                            
                        ?>
                    <li class="">
                        <a href="logout.php">
                            <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                            <samp>Log Out</samp>
                        </a>
                    </li>
                        <?php }else {?>                    
                    <li class="">
                        <a href="login.php">
                            <span><i class="fa fa-sign-in" aria-hidden="true"></i></span>
                            <samp>Log In</samp>
                            
                        </a>
                    </li>
                        <?php }?>
                </ul>
            </nav>
        </div>
            
    </div>