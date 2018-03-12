<?php if(!$user->isLoggedIn()){
     echo ' <ul><li><a href="ideas_list.php">The latest ideas</a></li> </ul>';                                                                                                                 
        } else{
            $user = new User();
            $x_post = 0;
            $no_posts = DB::getInstance()->get('idea', array('user_id', '=', $user->data()->id));
            if(!$no_posts->count()){
              $x_post = 0;  
            } else {
                foreach ($no_posts->results() as $no_post){
                    $x_post++;
                }
            }
            $x_comm = 0;
            $no_comms = DB::getInstance()->get('comment', array('user_id', '=', $user->data()->id));
            if(!$no_comms->count()){
                $x_comm = 0;
            } else {
                foreach ($no_comms->results() as $no_comm){
                    $x_comm++;
                }
            }
            $last_log_id = DB::getInstance()->get('log_in', array('user_id', '=', $user->data()->id));
            if($last_log_id->count()){
                $l_id = 0;
                foreach ($last_log_id->results() as $last_log_id1){
                    $l_id++;
                }
              if ($l_id ==1){
            $label = 'First time logged in';
              } else{
                  $label = 'Last time logged in';
              }
            $last_date= $last_log_id->results()[$l_id-2]->log_in;
            }
            if($user->hasPermission('qam')){
                echo 
                '<ul>
                    <li>
                        <a href="qam.php">QAM Dashboard</a>
                    </li>
                </ul>';
            }
            if($user->hasPermission('admin')){
                echo 
                '<ul>
                    <li>
                        <a href="admin_page.php">Admin Dashboard</a>
                    </li>
                    <li>
                        <a href="edit_privileges.php">Grant user privileges </a>
                    </li>
                    <li>
                        <a href="add_user.php"> Add new user</a>
                    </li>
                </ul>';
            }
            echo 
            '<ul>
                <li>
                    <a href="ideas_list.php">The latest ideas</a>
                </li>
                <li>
                    <a href="new_idea_post.php">Post new idea</a>
                </li>
                <li>
                    <a href="user_ideas_list.php?username='. $user->data()->username .'"> All your posts</a> ('  . $x_post . ')
                </li>
                <li>
                    <a href="user_comment_list.php?username='. $user->data()->username .'"> All your comments </a> ('  . $x_comm. ')
                </li>
                <li><a href="ch_pass.php">Change Password</a></li>
                <li> '.$label.' <br>'.$last_date . '</li>
            </ul>';                                       
}