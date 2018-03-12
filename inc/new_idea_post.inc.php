<?php
$user = new User();
   if (!$user->isLoggedIn()){
       Redirect::to('login.php');
   }  
  $user_department = $user->data()->department_id;
  if($user->hasPermission('qac')){
     $qac_email = $user->data()->email; 
  } else {
      $qacs = DB::getInstance()->get('users', array('department_id','=',$user_department));
      foreach ($qacs->results() as $qac){
          if ($qac->user_group_id == 4){
              $qac_email = $qac->email;
          }
      }
    }
//=================image upload =================
if(isset($_FILES['image_upload'])){
    $file = $_FILES['image_upload'];
    $imageName = addslashes($_FILES['image_upload']['name']);
    $imageTempName = addslashes($_FILES['image_upload']['tmp_name']);
    $imageSize = $_FILES['image_upload']['size'];
    $imageError = $_FILES['image_upload']['error'];
    $imageType = $_FILES['image_upload']['type'];
    $imageExt = explode('.', $imageName);
    $imageActualExt = strtolower(end($imageExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if ($imageTempName !=""){
    $imageTempName = file_get_contents($imageTempName);
    }
}
//===================pdf upload ===============================
if(isset($_FILES['pdf_upload'])){
    $pdf_file = $_FILES['pdf_upload'];
    $pdfName = addslashes($_FILES['pdf_upload']['name']);
    $pdfTempName = addslashes($_FILES['pdf_upload']['tmp_name']);
    $pdfSize = $_FILES['pdf_upload']['size'];
    $pdfError = $_FILES['pdf_upload']['error'];
    $pdfType = $_FILES['pdf_upload']['type'];
    $pdfExt = explode('.', $pdfName);
    $pdfActualExt = strtolower(end($pdfExt));
    $pdf_allowed = array('pdf');
    if ($pdfTempName !=""){
    $pdfTempName = file_get_contents($pdfTempName);
    }
}
//==================== Word Upload ==============================
if(isset($_FILES['word_upload'])){
    $word_file = $_FILES['word_upload'];
    $wordName = addslashes($_FILES['word_upload']['name']);
    $wordTempName = addslashes($_FILES['word_upload']['tmp_name']);
    $wordSize = $_FILES['word_upload']['size'];
    $wordError = $_FILES['word_upload']['error'];
    $wordType = $_FILES['word_upload']['type'];
    $wordExt = explode('.', $wordName);
    $wordActualExt = strtolower(end($wordExt));
    $word_allowed = array('docx', 'doc');
    if ($wordTempName !=""){
    $wordTempName = file_get_contents($wordTempName);
    }
}
//===================== validation ==============================
 if(Input::exists()){
     $validate= new Validate();
     $validation= $validate->check($_POST, array(
        'cat_id'=> array(
             'name' => 'Select a category',
             'required' => true
        ),
         'p_title' => array(
             'name' => 'A title for your proposal',
             'required' => true,
             'min' => 3,
             'max' => 150
         ),
         'message' => array(
             'name' => 'The post content',
             'required' => true,
             'min' => 100,
             'max' => 1000
             ),
         'close_date'=>array(
             'name'=> 'Voting closing date',
             'required' => true
         )
        ));
     if($validation->passed() && isset($_POST['tandc'])){
         if (isset($_POST['anonymus'])){
             $any = 1;
         } else {
             $any = 0;
         }
         $close_date = Input::get('close_date');
          $date = date("Y-m-d", strtotime($close_date.'+1 day'));
         if ($imageTempName =="" && $pdfTempName == "" && $wordTempName == ""){
            $user = new User();
            try{
               $user->post_idea(array(
                   'title'       => Input::get('p_title'),
                   'content_text'       => Input::get('message'), 
                   'user_id'     => $user->data()->id,
                   'posted_date'   => date('Y-m-d H:i:s'),
                   'cat_id'        => Input::get('cat_id'),
                   'close_date' => $date,
                   'anonymous'   => $any
               )); 
                    $subject = "New idea from your department has been uploaded";
                    $headers = "From:info@masseyandco.com\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message .='<h2>Hellow,'.' '. $qac->username.'</h2>';
                    $message .='<p>New idea from your department has been uploaded.</p>';
                    $message .='<p>For more details visit the link:http://masseyandco.com/ideas_list.php</p>'; 
                    $message .='<p>Thank you.</p>'; 
                    $message .='</body></html>'; 
                    mail($qac_email, $subject, $message, $headers);

               Session::flash('new_post', 'Your idea has been uploaded successfully'.' ' . $any);
               Redirect::to('ideas_list.php');

            } catch (Exception $e){
                  die($e->getMessage());
              }
         } else{
//==============================image upload============================================================
             if($imageTempName !=""){
             if(in_array($imageActualExt, $allowed)){
                if($imageError === 0){
                    if($imageSize <100000){
                        $user = new User();
                        try{
                           $user->post_idea(array(
                               'title'       => Input::get('p_title'),
                               'content_text'=> Input::get('message'), 
                               'user_id'     => $user->data()->id,
                               'posted_date' => date('Y-m-d H:i:s'),
                               'cat_id'      => Input::get('cat_id'),
                               'close_date' => $date,
                               'anonymous'   => $any
                           ));            
                        } catch (Exception $e){
                              die($e->getMessage());
                          }
//   ======================================================================================                     
                        $idea_ids= DB::getInstance()->get('idea', array('idea_id', '>', 0));
                        $x=-1;
                        foreach ($idea_ids->results() as $idea_id){
                            $x++;
                        }
                        $new_idea_id = $idea_ids->results()[$x]->idea_id;
                          
//     =====================================================================================                     
                        $user->attach_file(array(
                        'attachment_name'=> $imageName,
                        'attachment'     => $imageTempName,
                        'user_id'        =>$user->data()->id,
                        'idea_id'        => $new_idea_id
                        ));
                        $subject = "New idea from your department has been uploaded";
                        $headers = "From:info@masseyandco.com\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $message = '<html><body>';
                        $message .='<h2>Hellow,'.' '. $qac->username.'</h2>';
                        $message .='<p>New idea from your department has been uploaded.</p>';
                        $message .='<p>For more details visit the link:http://masseyandco.com/ideas_list.php</p>'; 
                        $message .='<p>Thank you.</p>'; 
                        $message .='</body></html>'; 
                        mail($qac_email, $subject, $message, $headers);
                        Session::flash('upload_image', 'Your have also adde a picture to your idea post');
                        Redirect::to('ideas_list.php');
                    } else{
                        echo 'The image you have chosen is too big!';
                    }
                } else{
                    echo 'There was a problem uploading the file!'; 
                }
            } else{
                echo 'The file you choose is not an image!';  
            }
         }
     }
//=======================================pdf upload =======================================================
            if($pdfTempName !=""){
             if(in_array($pdfActualExt, $pdf_allowed)){
                if($pdfError === 0){
                    if($pdfSize <4000000){
                        $user = new User();
                        $user->attach_file(array(
                        'attachment_name'  => $pdfName,
                        'attachment'     => $pdfTempName,
                        'user_id'   =>$user->data()->id,
                        'idea_id'   => $x+1
                        ));
                        try{
                           $user->post_idea(array(
                               'title'       => Input::get('p_title'),
                               'content_text'       => Input::get('message'), 
                               'user_id'     => $user->data()->id,
                               'posted_date'   => date('Y-m-d H:i:s'),
                               'cat_id'        => Input::get('cat_id'),
                               'close_date' => $date,
                               'anonymous'   => $any
                           ));
                           $subject = "New idea from your department has been uploaded";
                            $headers = "From:info@masseyandco.com\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $message = '<html><body>';
                            $message .='<h2>Hellow,'.' '. $qac->username.'</h2>';
                            $message .='<p>New idea from your department has been uploaded.</p>';
                            $message .='<p>For more details visit the link:http://masseyandco.com/ideas_list.php</p>'; 
                            $message .='<p>Thank you.</p>'; 
                            $message .='</body></html>'; 
                            mail($qac_email, $subject, $message, $headers);
                            Session::flash('upload_pdf', 'Your have also adde a PDF file to your idea post');
                            Redirect::to('ideas_list.php');           
                        } catch (Exception $e){
                              die($e->getMessage());
                          }
                        
                    } else{
                        echo 'The PDF file you have chosen is too big!';
                    }
                } else{
                    echo 'There was a problem uploading the file!'; 
                }
            } else{
                echo 'The file you choose is not a PDF!';  
            }
         }

//=================================== upload Word file===========================================================
        if($wordTempName !=""){
             if(in_array($wordActualExt, $word_allowed)){
                if($wordError === 0){
                    if($wordSize <100000){
                        $user = new User();
                        $user->attach_file(array(
                        'attachment_name'  => $wordName,
                        'attachment'     => $wordTempName,
                        'user_id'   =>$user->data()->id,
                        'idea_id'   => $x+1
                        ));
                        try{
                           $user->post_idea(array(
                               'title'       => Input::get('p_title'),
                               'content_text'       => Input::get('message'), 
                               'user_id'     => $user->data()->id,
                               'posted_date'   => date('Y-m-d H:i:s'),
                               'cat_id'        => Input::get('cat_id'),
                               'close_date' => $date,
                               'anonymous'   => $any
                           )); 
                           $subject = "New idea from your department has been uploaded";
                            $headers = "From:info@masseyandco.com\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $message = '<html><body>';
                            $message .='<h2>Hellow,'.' '. $qac->username.'</h2>';
                            $message .='<p>New idea from your department has been uploaded.</p>';
                            $message .='<p>For more details visit the link:http://masseyandco.com/ideas_list.php</p>'; 
                            $message .='<p>Thank you.</p>'; 
                            $message .='</body></html>'; 
                            mail($qac_email, $subject, $message, $headers);
                            Session::flash('upload_word', 'Your have also adde a word document to your idea post');
                            Redirect::to('ideas_list.php');           
                        } catch (Exception $e){
                              die($e->getMessage());
                          }                        
                    } else{
                        echo 'The Microsoft Office Word file you have chosen is too big!';
                    }
                } else{
                    echo 'There was a problem uploading the file!'; 
                }
            } else{
                echo 'The file you choose is not a Microsoft Office Word document!';  
            }
         } 
//===============================================================================================================
    } else{
         foreach($validation->errors() as $error){
            echo '<span style="color:#f00">'. $error. '</span><br>';
       }
       if(!isset($_POST['tandc'])){
            echo '<span style="color:#f00">You must agree with to the Terms & Conditions!</span><br>';
        }
    }
 }
 
