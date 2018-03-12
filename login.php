<?php require_once 'overall/header.php';?>
<div class="main-content">
    <div class="hero">
        <?php if (Session::exists('pass_change')){
        echo '<span style="color:#ff0000">' . Session::flash('pass_change') . '</span><br>';
        }
        ?>
        <div class="main">
        <form method="POST">
            <div id="errors">
                <?php require_once 'inc/login.inc.php'; ?>  
            </div>
            <div>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo Input::get('username')?>" placeholder="ID or Username" autocomplete="off">
            </div>
            <div>
                <label>Password:</label><br/>
                <input type="password" name="user_pass" placeholder="Password" autocomplete="off">
            </div>
                <input type="checkbox" name="remember" id="tandc"/> 
                <label for="tandc">Remember me.</label>               
            <button class="btn_4" type="submit">Sign In</button> 
            <input type="hidden" name="token" value="<?php  echo Token::generate(); ?>"/>
        </form>
        </div>
    </div>
    
<?php require_once 'overall/footer.php';?>