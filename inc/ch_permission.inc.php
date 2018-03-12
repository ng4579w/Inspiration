<?php
if(isset($_POST['priv'])){
    if(Input::exists()){
        $validate = new Validate();
            $validation =$validate->check($_POST, array(
                'permission' => array(
                    'name'     => 'Select a Permission leve',
                    'required' => true,
                )
            ));
            if($validation->passed()){
                $user_id= Input::get('user_id');
                $ch_permission = DB::getInstance()->update('users', $user_id, array(
                    'user_group_id' => Input::get('permission')
                ));
                Session::flash('permission', 'The User Log in Privileges has been update.');
                Redirect::to('edit_privileges.php');
            }else{
                    foreach($validation->errors() as $error){
                        echo '<span style="color:#f00">'. $error. '</span><br>';
                    }
                }
    }
}
