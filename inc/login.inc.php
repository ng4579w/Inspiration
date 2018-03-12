<?php    
    if(Token::check(Input::get('token'))){
        if(Input::exists()){
        $validate= new Validate();
            $validation= $validate->check($_POST, array(
            'username'=>array(
                'name' => 'ID or Username',
                'required'  => true,
                'min'       => 5,
                'max'       =>15
            ),
            'user_pass'=>array(
                'name' => 'Password',
                'required'  => true,
                'min'       => 5,
                'max'       =>15
            )
            ));
            if($validation->passed()){
                $user = new User();
                    $remember = (Input::get('remember') === 'on') ? true : false;
                    $login = $user->login(Input::get('username'), Input::get('user_pass'), $remember);
                   if($login){                         
                         if (Input::get('user_pass') == 'password'){
                             Session::flash('ch_pass', ', you are logging in for the first time.Please change your default password');
                             Redirect::to('ch_pass.php');
                         }
                          if($user->data()->block == 1){
                              Session::put('block_user', 'Your account is temporarily suspended!');
                              $user->logout();
                              Redirect::to('block_user.php');                          
                         } else {
                             $xuser_id =$user->data()->id;
                             $user_log = DB::getInstance()->insert('log_in', array(
                                 'user_id' => $user->data()->id,
                                 'log_in' => date('Y-m-d H-i-s')                            
                             ));
                             $logs = "SELECT * FROM log_in WHERE user_id = $xuser_id  ORDER BY id DESC";
                             $xlog = mysqli_query($conn, $logs); 
                             $row_log = mysqli_fetch_array($xlog);
                             $user_log_id = $row_log['id'];
                             Session::put('user_log', $user_log_id);
                            if($user->hasPermission('admin')){
                                Redirect::to('admin_page.php');                      
                                }
                            if($user->hasPermission('qam')){
                                Redirect::to('qam.php');                      
                                }
                            
                            Redirect::to('ideas_list.php');
                         }
                     } else {
                         echo '<span style="color:#f00"> Sorry, logging in failed</span>';
                     }
                }else {
                     foreach($validation->errors() as $error){
                     echo '<span style="color:#f00">'. $error. '</span><br>';
                }
            }
        }
    }


