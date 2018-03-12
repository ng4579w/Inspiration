<?php
class Hash {
	public static function make($string, $salt =''){
		return hash('sha256', $string . $salt);
	}
	public static function salt($hash_length){
		return mcrypt_create_iv($hash_length);
		
	}
	public static function unique(){
		return self::make(uniqid());
		
	}
}

//password_hash($_POST['password'], PASSWORD_BCRYPT);
//password_verfy($_POST['password]), $user['password];