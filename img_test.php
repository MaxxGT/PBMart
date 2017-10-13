<?php
//https://www.verot.net/php_class_upload_samples.htm
include('class.upload.php-master/src/class.upload.php');


$foo = new Upload($_FILES['form_field']);

if ($foo->uploaded) {
   // save uploaded image with no changes
   $foo->Process('home/user/files/');
   if ($foo->processed) {
     echo 'original image copied<BR />';
   } else {
     echo 'error : ' . $foo->error;
   }
  /*
   // save uploaded image with a new name
   $foo->file_new_name_body = 'foo';
   $foo->Process('home/user/files/');
   if ($foo->processed) {
     echo 'image renamed "foo" copied<BR />';
   } else {
     echo 'error : ' . $foo->error;
   }
*/   
   // save uploaded image with a new name,
   // resized to 100px wide
   $foo->file_new_name_body = 'image_resized';
   $foo->image_resize = true;
   $foo->image_convert = 'jpg';
   //$foo->jpeg_quality  = 0;
   $foo->image_x = 200;
   $foo->image_y = 200;
   //$foo->image_ratio_y = true;
   $foo->Process('home/user/files/');
   if ($foo->processed) {
     echo 'image renamed, resized x=100
           and converted to GIF<BR />';
     $foo->Clean();
   } else {
     echo 'error : ' . $foo->error;
   } 
}else
{
	echo 'error';
}

?>
<form action='img_test.php' method='post' enctype="multipart/form-data">
	<input type="file" name="form_field" id="form_field" onchange="ValidateSingleInput(this, 'fToUpload');" />
	<input type='submit' />
</form>