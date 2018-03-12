<?php
if (isset($_POST['action1'])) {
  $hide_id = $_POST['hide_id'];
  $action1 = $_POST['action1'];
  switch ($action1) {
  	case 'hidepost':
         $sql_hide="UPDATE idea SET hide = '1' WHERE idea_id  = $hide_id";
        break;
  	case 'showpost':
          $sql_hide="UPDATE idea SET hide = '0' WHERE idea_id  = $hide_id";
        break;
  	default:
            break;
  }
  // execute query to effect changes in the database ...
  mysqli_query($conn, $sql_hide);
  exit(0);
}
if (isset($_POST['action2'])) {
  $block_id = $_POST['block_id'];
  $action2 = $_POST['action2'];
  switch ($action2) {
  	case 'user_is_blocked':
         $sql_block="UPDATE users SET block = '1' WHERE id  = $block_id";
         $sql_hide = "UPDATE idea SET hide = '1' WHERE user_id = $block_id";
        break;
  	case 'user_have_access':
          $sql_block="UPDATE users SET block = '0' WHERE id  = $block_id";
          $sql_hide = "UPDATE idea SET hide = '0' WHERE user_id = $block_id";
        break;
  	default:
            break;
  }
  // execute query to effect changes in the database ...
  mysqli_query($conn, $sql_block);
  mysqli_query($conn, $sql_hide);
  exit(0);
}
