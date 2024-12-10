<?php require_once("include/baglan.php"); require_once("include/fonksiyon.php");

if (isset($_GET['l'])) {
    $lang = EscapeData($_GET["l"]);
    $return = isset($_GET["return"]) ? urldecode(EscapeData($_GET["return"])) : '/';
    
    // Dil kodunun geçerli olduğunu kontrol et
    $dil_kontrol = $db->prepare("SELECT dil_kod FROM dil WHERE dil_kod = ? AND dil_durum = 1");
    $dil_kontrol->execute([$lang]);
    
    if ($dil_kontrol->rowCount()) {
        setcookie($cookie_adi, $lang, time() + (60*60*24*30), '/');
        header("Location: " . $return);
    } else {
        // Geçersiz dil kodu - varsayılan dile yönlendir
        setcookie($cookie_adi, $varsayilanDil, time() + (60*60*24*30), '/');
        header("Location: " . $return);
    }
} else {
    // Dil parametresi yok - varsayılan dile yönlendir
    setcookie($cookie_adi, $varsayilanDil, time() + (60*60*24*30), '/');
    header("Location: /");
}
exit;
?>