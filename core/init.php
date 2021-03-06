<?php
session_start();
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' =>'root',
		'password' => '',
		'db' => 'inspirations'
	),

	'remember' => array(
		'cookie_name'=> 'hash',
		'cookie_expiry' => 6044800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
//require_once("classes/Config.php");
//require_once("classes/Cookie.php");
//require_once("classes/DB.php");
//require_once("classes/Input.php");
//require_once("functions/sanitize.php");
//require_once("classes/Validate.php");
//require_once("classes/Session.php");
//require_once("classes/Token.php");
//require_once("classes/User.php");
//require_once("classes/Redirect.php");
//require_once("classes/Hash.php");
require_once 'functions/sanitize.php';
//require_once 'functions/rnd_str.php';

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));
    $user=new User();// 
	
	if($hashCheck->count()){
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
