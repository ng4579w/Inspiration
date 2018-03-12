<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
    if(!$user->isLoggedIn()){
        Redirect::to('index.php'); 
        } else {
            if(!$user->hasPermission('admin')){
            Redirect::to('index.php');                      
            }
        }
?>
<div class="main-content">
    <div class="title">
        Hello  <?php echo escape($user->data()->username); ?>
    </div>
    <div class="main">
        <div class="l_widget">
            <div class="title"> <i class="fa fa-bars" aria-hidden="true"></i> Menu</div>
            <div class="chart" style="text-align: left;">
                <?php require_once 'widgets/l_menu.php';?>
            </div>
        </div>
        <div class="widget">
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Title of this page here!!</div>
            <div class="chart">
                <?php 
                $dbname = Config::get('mysql/db');
                $sql = "SHOW TABLES FROM $dbname";
                $result = mysqli_query($conn, $sql);
                
         echo '<table class="qam"><tr><th> #</th>
                <th>Database Tables</th>
                <th>#Tuples</th></tr>';
         if ( mysqli_num_rows($result) > 0 ) {
            echo "<tbody>\n";
            for ( $i = 0 ; $i < mysqli_num_rows($result) ; $i++ ) {
               echo '<tr><td>' . ($i + 1) . '</td>';
              $row = mysqli_fetch_row($result);
               for ( $j = 0 ; $j < mysqli_num_fields($result) ; $j++ ) {
                  echo '<td style="text-align: left;"><a href="#">' . nl2br(htmlspecialchars($row[$j])) . '</a></td>';
                  $tb_name = nl2br(htmlspecialchars($row[$j]));
                  $tuples = "SELECT * FROM $tb_name";
                  $tp_result = mysqli_query($conn, $tuples);
                  echo '<td>' . mysqli_num_rows($tp_result) . '</td>';
               }
               echo "</tr>\n";
            }
            echo "</tbody>\n";
         } echo "</table>\n";
         
                ?>           
            </div>
        </div>       
    </div>
<?php require_once 'overall/footer.php';?>