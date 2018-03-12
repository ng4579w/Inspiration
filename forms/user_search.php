<form id="admin" method="POST" style="max-width:400px; float: left;">
    <div id="errors">
        <?php require_once 'inc/user_search.inc.php'; ?> 
        <?php require_once 'inc/ch_permission.inc.php'; ?>
    </div>
    <div>
        <label>Username / ID:</label>
        <input type="text" name="username" placeholder="Enter ID or Username" value="<?php echo Input::get('username');?>" autocomplete="off">
    </div>               
    <button class="btn_4" type="submit" name="find">Find User</button> 
    <input type="hidden" name="token" value="<?php  echo Token::generate(); ?>"/>
</form><br>
<form id="admin" method="post" style="float:left;" >
    <div id="errors">
          
    </div>
    <table style="display: <?php echo $display?>; border-top:1px solid #000;">
        <tr>
            <th>Username / ID</th>
            <th>Email</th>
            <th>Department</th>
            <th>Log In Privileges</th>
        </tr>
        <tr>
            <td><?php echo $username;?></td>
            <td><?php echo $email;?></td>
            <td><?php echo $dp_name;?></td>
            <td>
                <select name="permission">
                    <option value = "" style="display: none;">  Select a Permission</option>
                    <?php $permissions=DB::getInstance()->get('user_group', array('user_group_id', '>', 0));
                    if($permissions->count()){
                    foreach ($permissions->results() as $permission){ ?>
                    <option value="<?php echo $permission->user_group_id; ?>"><?php  echo $permission->ug_name; ?></option>
                    <?php  }    
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr style="background-color: #fff;">
            <td>
                <button class="btn_4" type="submit" name="priv">Save Changes</button>
                <input type="hidden" name="user_id" value="<?php  echo $user_id; ?>"/>
                
            </td>
            <td>
                <button class="btn_3" type="submit" name="cancel">Cancel</button>
                
            </td>
        </tr>
    </table>
</form>
