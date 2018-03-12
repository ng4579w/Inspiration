<?php require_once 'overall/header.php';?>
<div class="main-content">
    <div class="main" >
        <div class="m_widget"style="max-height: 100%;">
            <div class="title" style="text-align: center;">
                <i class="fa fa-ban"></i>
                <span>Account is suspended</span>
            </div>
            <div class="chart">
                <div class="ban_error">
                    <i class="fa fa-ban"></i>
                    <span><h1>
                        <?php 
                        if(Session::exists('block_user')){
                            echo Session::get('block_user');
                        }
                        ?>
                    </h1></span>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'overall/footer.php';?>


