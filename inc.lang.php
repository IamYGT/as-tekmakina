<?php
require_once("include/baglan.php"); require_once("include/fonksiyon.php"); 
 
// Mevcut dili al
$lang = getCurrentDil();
 
// Seçilen dilin bilgilerini al
try {
    $dil_sorgu = $db->prepare("SELECT * FROM dil WHERE dil_kod = ? AND dil_durum = 1");
    $dil_sorgu->execute([$lang]);
    $secili_dil = $dil_sorgu->fetch(PDO::FETCH_ASSOC);
    
    // Eğer seçili dil bulunamazsa varsayılan dili kullan
    if (!$secili_dil) {
        $dil_sorgu->execute([$varsayilanDil]);
        $secili_dil = $dil_sorgu->fetch(PDO::FETCH_ASSOC);
        setcookie($cookie_adi, $varsayilanDil, time() + (60*60*24*30), '/');
        $lang = $varsayilanDil;
    }
} catch (Exception $e) {
    error_log("Dil yükleme hatası: " . $e->getMessage());
    // Hata durumunda varsayılan dili kullan
    $lang = $varsayilanDil;
}
 
// Dil çevirilerini yükle
$translations = array();
try {
    $kelimeler_sorgu = $db->prepare("SELECT anahtar, deger FROM dil_kelimeler WHERE kod = ?");
    $kelimeler_sorgu->execute([$lang]);
    while ($row = $kelimeler_sorgu->fetch(PDO::FETCH_ASSOC)) {
        $translations[$row['anahtar']] = $row['deger'];
    }
} catch (Exception $e) {
    error_log("Çeviri yükleme hatası: " . $e->getMessage());
}
?>