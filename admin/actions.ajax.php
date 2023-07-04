<?php  require("../include/baglan.php");include("../include/fonksiyon.php"); 

require('az.multi.upload.class.php');
$rename	=	rand(1000,5000).time();
$upload	=	new ImageUploadAndResize();
$upload->uploadFiles('files', '../uploads/files', true, 250, '', 20, 20, $rename, 0777, 100, '850', '250');
 
foreach($upload->prepareNames as $name){ 
	$insert = $db->prepare("INSERT INTO files SET name = ?, ustid = ?, itable = ?");
	$insert->execute(array($name, $ust_id, $itable));
} 
 