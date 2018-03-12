<?php require_once 'overall/header.php';


    $to = 'florian.ipate@gmail.com';
    $subject = "New idea from your department has been uploaded";
    $headers = "From:info@masseyandco.com\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<html><body>';
    $message .="<h4>Hellow,</h4>";
    $message .='<p>New idea from your department has been uploaded.</p>';
//                        $message .='<p>Activation code:<h1 style="color:blue;">' .  Input::get('secure'). "</h1></p>"; 
    $message .='<p>Thank you.</p>'; 
    $message .='</body></html>'; 
    mail($to, $subject, $message, $headers);


?>


<?php require_once 'overall/footer.php';?>
