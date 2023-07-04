<?php
require_once("include/baglan.php"); require_once("include/fonksiyon.php"); 
 
if (isset($_COOKIE[$cookie_adi]) && !empty($_COOKIE[$cookie_adi])) {
   $lang = $_COOKIE[$cookie_adi]; 
 
}else{ // default
   setcookie($cookie_adi, $varsayilanDil, time()+ (60*60*24*30));
   $lang = $varsayilanDil; 
}
 
$secilen_dil_q = $db->query("select * from dil where dil_kod = '".$lang."'")->fetch(PDO::FETCH_ASSOC);
$secili_dil = $secilen_dil_q;
?>