<?php

session_start();

$sifre = substr(md5(uniqid(rand(0, 6))), 0, 6);

$_SESSION['sifre'] = $sifre;

header('Content-type: image/png');

$sifre_uzunluk = strlen($sifre);
$genislik = imagefontwidth(5) * $sifre_uzunluk;
$yukseklik = imagefontheight(5);

$resim = imagecreate($genislik, $yukseklik);

$arka_renk = imagecolorallocatealpha($resim, 0, 0, 0, 127);
$yazi_renk = imagecolorallocate($resim, 85, 85, 85);
imagefill($resim, 0, 0, $arka_renk);

imagestring($resim, 5, 0, 0, $sifre, $yazi_renk);

imagepng($resim);

?>