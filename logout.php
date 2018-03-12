<?php
include 'core/init.php';
$user= new User();
if(Session::exists('user_log')){
$time_log = Session::get('user_log');
$lg_out = DB::getInstance()->update('log_in',$time_log, array(
    'log_out' => date('Y-m-d H-i-s')   
));
}
Session::delete('user_log');
$user->logout();
Redirect::to('index.php');
