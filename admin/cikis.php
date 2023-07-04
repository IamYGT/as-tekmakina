<?php require("../include/baglan.php"); include("../include/fonksiyon.php");
unset($_SESSION);
session_unset();
session_destroy();
session_write_close(); 
header('Location: index.php'); 
$db = null; 
?>