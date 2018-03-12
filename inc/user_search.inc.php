<?php 
$display='none';
if(isset($_POST['find'])){
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
            $validation =$validate->check($_POST, array(
                'username' => array(
                    'name'     => 'Username or ID',
                    'required' => true,
                    'min'      => 5,
                )
            ));
            if($validation->passed()){
                $username= Input::get('username');
                $user_name=DB::getInstance()->get('users', array('username', '=', $username));
                if(!$user_name->count()){
                    echo '<span style="color:#f00"> No user Found </span><br>'; 
                } else {
                    $display='inline-block';
                    $username =$user_name->results()[0]->username; 
                    $email = $user_name->results()[0]->email;
                    $user_id= $user_name->results()[0]->id;
                    $dp_id = $user_name->results()[0]->department_id;
                    $dp_names= DB::getInstance()->get('department', array('dp_id', '=', $dp_id));
                    $dp_name=$dp_names->results()[0]->dp_name;
                }
            } else{
                foreach($validation->errors() as $error){
                    echo '<span style="color:#f00">'. $error. '</span><br>';
                }
            }
    }
}
}
?>

