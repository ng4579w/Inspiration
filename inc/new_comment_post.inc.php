<?php
$authors = DB::getInstance()->get('idea', array('idea_id', '=', $idea_page));
$author_id = $authors->first()->user_id;
$author_email = DB::getInstance()->get('users', array('id', '=', $author_id));
$auth_email = $author_email->first()->email;
$u_name =  $author_email->first()->username;
if(Input::exists()){
    $validate= new Validate();
     $validation= $validate->check($_POST, array(
         'message' => array(
             'name'     => 'The post content',
             'required' => true,
             'min'      => 5,
             'max'      => 500
         )        
     ));
    if($validation->passed() && isset($_POST['tandc'])){
        if (isset($_POST['anonymus'])){
             $any = 1;
         } else {
             $any = 0;
         }
        $user = new User();
        $user->post_comment(array(
            'idea_id'      => $idea_page,
            'user_id'      => $user->data()->id,
            'content_text' => Input::get('message'),             
            'posted_date'  => date('Y-m-d H:i:s'),
            'anonymous'    => $any
        ));
        $subject = "A New comment has been added to your idea";
        $headers = "From:info@masseyandco.com\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body>';
        $message .='<h2>Hellow,'.' '. $u_name .'</h2>';
        $message .='<p>A New comment has been added to your post.</p>';
        $message .='<p>For more details visit the link:http://masseyandco.com/comment.php?idea_page='.$idea_page.'</p>'; 
        $message .='<p>Thank you.</p>'; 
        $message .='</body></html>'; 
        mail($auth_email, $subject, $message, $headers);
        Session::flash('new_comment', 'Your comment has been uploaded successfully');
        Redirect::to('comment.php?idea_page=' .$idea_page);
    }
    else{
         foreach($validation->errors() as $error){
            echo '<span style="color:#f00">'. $error. '</span><br>';
       }
       if(!isset($_POST['tandc'])){
            echo '<span style="color:#f00">You must agree with to the Terms & Conditions!</span><br>';
        }
    }
}
