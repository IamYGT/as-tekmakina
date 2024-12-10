<?php
require("../include/baglan.php");
include("../include/fonksiyon.php");

if(isset($_FILES['files'])) {
    $ust_id = $_POST['ust_id'];
    $response = array();
    $uploadDir = "../uploads/gallery/";
    
    // Klasör yoksa oluştur
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_type = $_FILES['files']['type'][$key];
        
        // Benzersiz dosya adı oluştur
        $uniqueFileName = uniqid() . '_' . $file_name;
        
        if(move_uploaded_file($file_tmp, $uploadDir . $uniqueFileName)) {
            // Veritabanına kaydet
            $insert = $db->prepare("INSERT INTO galeri_resimler SET 
                galeri_ust_id = ?,
                galeri_resim = ?,
                galeri_tarih = NOW()");
            $insert->execute(array($ust_id, $uniqueFileName));
            
            if($insert) {
                $response[] = "Dosya başarıyla yüklendi: " . $file_name;
            } else {
                $response[] = "Veritabanı hatası: " . $file_name;
            }
        } else {
            $response[] = "Dosya yükleme hatası: " . $file_name;
        }
    }
    
    echo json_encode(array("messages" => $response));
}
?>
 