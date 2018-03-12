<?php
//upload.php
if($_FILES["image_upload"]["name"] != '')
{
// $test = explode('.', $_FILES["file"]["name"]);
// $ext = end($test);
// $name = rand(100, 999) . '.' . $ext;
// $location = './upload/' . $name;  
// move_uploaded_file($_FILES["file"]["tmp_name"], $location);
    
    $filesize= '('.($_FILES["image_upload"]['size']/1000).'k)';
 echo $_FILES["image_upload"]['name']. ' '. $filesize;
} 
?>
