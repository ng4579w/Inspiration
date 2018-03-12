<?php
    if(Input::exists()){
        $validate = new Validate();
        $validation=$validate->check($_POST, array(
            'current_pass' => array(
                'name'     => 'Your current Password',
                'required' => true,
                'min'      => 5,
                'max'      =>12
            ),
            'new_pass' =>array(
                'name'      =>'New password',
                'required' => true,
                'min'      => 5,
                'max'      =>12
            ),
            'new_pass_again' =>array(
                'name' => 'New password again',
                'required' => true,
                'matches'   => 'new_pass'
            )
        ));
        if($validation->passed()){
            if(password_verify(Input::get('current_pass'), $user->data()->password)){
                $user->update(array(
                    'password'=>password_hash(Input::get('new_pass_again'), PASSWORD_BCRYPT)
                ));
                   Session::flash('pass_change', 'Your password has changed successfully! Now you can log in using the new password.');
                $user->logout();
                Redirect::to('login.php');

            } else{
                echo '<span style="color:#ff0000;">Your Current Password is Incorect!</span><br>';
            }

        }else {
                foreach($validation->errors() as $error){
                echo '<span style="color:#f00">'. $error. '</span><br>';
            }
        }
    }                    
    


