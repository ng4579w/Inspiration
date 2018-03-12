<?php 
$last_log_id = DB::getInstance()->get('log_in', array('user_id', '=', $user->data()->id));
            if($last_log_id->count()){
                $l_id = 0;
                $last_date = '';
                foreach ($last_log_id->results() as $last_log_id1){
                    $l_id++;
                }
              
              if ($l_id ==1){
                    $label = 'First time logged in';
                      } else{
                          $label = 'Last time logged in';

                    $last_date= $last_log_id->results()[$l_id-2]->log_in;
                    }
            
              }
echo
'<ul>
   <li>
       <a href="qam.php">QAM Dashboard</a>
   </li>
   <li>
       <a href="ideas_list.php"> Ideas Detailed list</a>
   </li>
   <li>
       <a href="categories.php">Categories List</a>
   </li>
   <li>
       <a href="ideas_report.php">Reports</a>
   </li>
   <li>
       <a href="ch_pass.php"> Change Password</a>
   </li>
   <li>
       <a href=""> Edit Profile</a>
   </li>
   <li>'.$label.' <br>'.$last_date . '</li>
</ul>';