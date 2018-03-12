<?php
class User {
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn = true;
				} else{
					//process logout
				}
			}
			
		} else{
			$this->find($user);
		}
	}
	public function update($fields = array(), $id = null){
		if(!$id && $this->isLoggedIn()){
			$id=$this->data()->id;
		}
		if(!$this->_db->update('users', $id, $fields)){
			throw new Exception('There was a problem updating.');
		}
	}
	public function create($fields = array()){
		if(!$this->_db->insert('users', $fields)){
			throw new Exception('There was a problem creating an account.');
		}
	}
        public function post_idea($fields = array()){
		if(!$this->_db->insert('idea', $fields)){
			throw new Exception('There was a problem posting your message.');
		}
	}
        public function post_comment($fields = array()){
		if(!$this->_db->insert('comment', $fields)){
			throw new Exception('There was a problem posting your message.');
		}
	}
        public function attach_file($fields = array()){
		if(!$this->_db->insert('attachment', $fields)){
			throw new Exception('There was a problem attaching the file to your ideaa.');
		}
	}
	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db ->get('users', array($field, '=', $user));
			if($data ->count()){
				$this ->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	public function login($username = null, $password = null, $remember = false){	
		if(!$username && !$password && $this->exists()){
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			if($user){
				if(password_verify($password, $this->data()->password)){
					Session::put($this->_sessionName, $this->data()->id);
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this -> _db -> get('user_session', array('user_id', '=', $this->data()->id));
						if(!$hashCheck -> count()){
							$this->_db->insert('user_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}
	public function hasPermission($key){
		$group = $this->_db->get('user_group', array('user_group_id', '=', $this->data()->user_group_id));
		if($group->count()){
			$permission = json_decode($group->first()->permission, true);
			 if($permission[$key] == true) {
				return true;
			} 
		}
		return false;
		
	}
//	public function profile($key){
//		$profile=$this->_db->get('lecturer', array('username','=', $this->data()->username));
//		print_r ($profile->first());
//		
//	}
	public function exists(){
		return (!empty($this->_data)) ? true : false;
		
	}
	public function logout(){
		
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	public function data() {
		return $this->_data;
	}
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
}
