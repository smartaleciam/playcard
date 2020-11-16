<?php
//set random name for the image, used time() for uniqueness
require_once('db.php'); 
$filename =  time() . '.jpg';
$filepath = 'uploads/';
if(!is_dir($filepath))
	mkdir($filepath);
if(isset($_FILES['webcam'])){	
	move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
	echo $filename;
}
?>
