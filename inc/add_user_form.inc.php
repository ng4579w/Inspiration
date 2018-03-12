<?php
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
            $validation =$validate->check($_POST, array(
                'username' => array(
                    'name'     => 'Username or ID',
                    'required' => true,
                    'min'      => 5,
                ),
                'email' => array(
                    'name'=>'Email',
                    'required'=> true,
                    'min'   =>5,
                    'max'   =>60
                ),
                'department' => array(
                    'name'=> 'Adepartment selection',
                    'required'=>true
                )
            ));
            if($validation->passed()){
                $user= new User();
            try{
               $user->create(array(
                   'username'=> Input::get('username'),
                   'email'=> Input::get('email'), 
                   'password' => password_hash("password", PASSWORD_BCRYPT),
                   'department_id'  => Input::get('department')
//                   'user_group_id'  =>1   
               ));
            } catch (Exception $e){
               die($e->getMessage());
           }
            } else{
                    foreach($validation->errors() as $error){
                        echo '<span style="color:#f00;">'. $error. '</span><br>';
                    }
                }
    }
}

