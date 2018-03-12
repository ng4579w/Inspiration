
<form method="post" id="admin">
    <div id="errors">
        <?php require_once 'inc/add_user_form.inc.php';?>
    </div> 
<table>
    <tr>
        <th>Username / ID</th>
        <th>Email</th>
        <th>Department</th>       
    </tr>
    <tr style="background-color: #fff;">
        <td>
            <input type="text" name="username" placeholder="ID or Username" value="<?php echo Input::get('username');?>" autocomplete="off">
        </td>
        <td>
            <input type="text" name="email" placeholder="Email" value="<?php echo Input::get('email');?>" autocomplete="off">
        </td>
        <td>
            <select name="department">
                <option value = "" style="display: none;">  Select a Department</option>
                <?php $departments=DB::getInstance()->get('department', array('dp_id', '>', 0));
                if($departments->count()){
                foreach ($departments->results() as $department){ ?>
                <option value="<?php echo $department->dp_id; ?>"><?php  echo $department->dp_name; ?></option>
                <?php  }    
                }
                ?>
            </select>        
        </td>        
    </tr>
    <tr>
        <td style="background-color: #fff;">
            <button class="btn_4" type="submit">Add New User</button>
            <input type="hidden" name="token" value="<?php  echo Token::generate(); ?>"/>
        </td>
    </tr>
</table>
</form>

