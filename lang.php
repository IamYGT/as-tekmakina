<?php require_once("include/baglan.php"); require_once("include/fonksiyon.php");
if (isset($_GET['l'])) {
   $return = $_GET["return"];
   $lang = EscapeData($_GET["l"]);
   $return = urldecode(EscapeData($_GET["return"]));
 
   unset($_COOKIE[$cookie_adi]); 
   setcookie($cookie_adi, $lang, time()+ (60*60*24*30));
 
   if ($varsayilanDil == $lang) {
	 header("Location: $return");
   }else{
	 header("Location: $return");
 
   }
 
}else{
   // set default lang
   setcookie($cookie_adi, $varsayilanDil, time()+ (60*60*24*30)); 
	 header("Location: $return");
}
exit;
?>