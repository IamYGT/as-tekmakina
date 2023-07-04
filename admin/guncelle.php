<?php  require("../include/baglan.php"); include("../include/fonksiyon.php");
  		if(!isset($_SESSION['LOGIN']) && !in_array(array('login'))) {
			go("index.php",0);  
			exit();
		}
		if ($_POST) { // Post olup olmadığını kontrol ediyoruz. 
			$TextValue = ltrim(strip_tags($_POST['value']));
			$TextKey = strip_tags($_POST['key']); 
			$update = $db->exec("UPDATE dil_kelimeler SET deger = '$TextValue' WHERE id = '$TextKey'"); 
			if($update) {
				echo 1;  //Başarı ile düzenlendi
			} else {
				if($db->errorCode()) {
					echo 2; //Düzenlenirken hata oluştu
				} else {
					echo 3; //Bilgilerde düzenlenecek herhangi bir değişiklik bulunamadı
				}
			}  
		}
?>  