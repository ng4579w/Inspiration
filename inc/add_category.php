<?php 
if(!$user->isLoggedIn()){
    Redirect::to('index.php'); 
    } else {
        if(!$user->hasPermission('qam')){
        Redirect::to('index.php');                      
        } else {
            if(Input::exists()){
                $validate= new Validate();
                 $validation= $validate->check($_POST, array(
                    'new_category'=> array(
                         'name' => 'Enter new category name',
                         'required' => true
                    )
                ));
                if($validation->passed()){
                    
                    DB::getInstance()->insert('category', array(
                        'cat_name'=> Input::get('new_category')
                    ));
                    Session::flash('new_cat', 'The new Category has been added successfully');
               Redirect::to('categories.php');
                    
                } else{
                    foreach($validation->errors() as $error){
                       echo '<span style="color:#f00">'. $error. '</span><br>';
                  }
            }
            
        }
    }
    

    }