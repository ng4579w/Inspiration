<?php require_once 'overall/header.php';?>
<div class="main-content">
    <div class="title">       
        Hello  <?php
        $user = new User();
        echo escape($user->data()->username);         
        if (Session::exists('ch_pass')){
        echo '<span style="color:#ff0000">' . Session::flash('ch_pass') . '</span><br>';
        }?>
    </div>
    <form method="POST" style="max-width: 500px;">
    <div id="errors">
        <?php require_once 'inc/ch_pass.inc.php'; ?>  
    </div>
    <div>
        <label>Current Password:</label>
        <input type="password" name="current_pass" placeholder="Current Password" autocomplete="off">
    </div>
    <div>
        <label>New Password:</label><br/>
        <input type="password" name="new_pass" placeholder="Password" autocomplete="off">
    </div>
    <div>
        <label>New Password Again:</label><br/>
        <input type="password" name="new_pass_again" placeholder="Password" autocomplete="off">
    </div>
               
    <button class="btn_4" type="submit">Change Password</button> 
    <input type="hidden" name="token" value="<?php  echo Token::generate(); ?>"/>
</form>
<?php require_once 'overall/footer.php';?>