<table class="qam">
    <tr>
        <th>Department name</th>
        <th># Ideas</th>
        <th># Users</th>
        <th style="text-align: center;">Total ideas %</th>
    </tr>
    <?php 
    $departments = DB::getInstance()->get('department', array('dp_id', '>',0));
    if(!$departments->count()){
        echo 'The system does not have any department setting. ';
    } else {
        $ii=0;
        foreach ($departments->results() as $department){
            $ii++;
            ?>
            <tr>
                <td style="text-align: left; padding-left: 10px;">
                    <?php echo $department->dp_name;?>
                </td>
                <td>
                    <?php
                    $no_of_ideas_per_department = 0;
                    $no_users_per_department = 0;
                    $dp_id = $department->dp_id;
                    $dp_users = DB::getInstance()->get('users', array('department_id', '=', $dp_id));
                    if(!$dp_users->count()){
                        echo $no_of_ideas_per_department;
                    } else{
//                        $no_of_ideas_per_department = 0;
                        foreach ($dp_users->results() as $dp_users){
                            $no_users_per_department++; 
                            $user_id = $dp_users->id;
                            $dp_ideas = DB::getInstance()->get('idea', array('user_id', '=',$user_id));
                            if(!$dp_ideas->count()){
//                                 $no_of_ideas_per_department = 0;
                            } else {
                                foreach ($dp_ideas->results() as $dp_idea){
                                    $no_of_ideas_per_department++;
                                }
                            }
                        } 
                        echo $no_of_ideas_per_department;
                    }
                    
                    ?>
                </td>
                <td>
                    <?php echo $no_users_per_department;
                    
                    $t_idea=0;
                   $total_ideas = DB::getInstance()->get('idea', array('idea_id', '>', 0));
                   if ($total_ideas->count()){
                       
                       foreach ($total_ideas->results()as $total_idea){
                           $t_idea++;
                          
                       } 
                   }
                   $procent = (100/$t_idea)*$no_of_ideas_per_department;
                  
                    ?>
                </td>
                <td  style="width: 150px;">
                    <div id="<?php echo 'x'.$ii;?>" class="td_bg" style="width: <?php echo round($procent).'%'; ?>">
                      <?php  
                      echo round($procent);
                        
                      ?>
                    </div>          
                   
                </td>                
            </tr>  
            <?php
        }
        
    } 
    
    ?>
</table>


