<?php
	require('lisans.php');
	function cURL($url){ 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$data = curl_exec($ch);
		curl_close($ch); 
		return $data;
	}
	$lisans['domain'] = getenv('HTTP_HOST');
	if (substr($lisans['domain'], 0, 4) == "www.")
	$lisans['domain'] = substr($lisans['domain'],4);
 
	$bas = "MEMSIDEA-";
	$son = "-2021";
	$m = "md5";
	$s = "sha1";
	  
	$lisans['hash'] = wordwrap(strtoupper($s ($s ($s ($s ($m ($s ($s ($m ($lisans['domain'].date('Ymd')))))))))),5,'-',true);
	$liskod = $lisans['hash'];
	$cevir=strrev($liskod);
	$bcs = "$bas$cevir$son";
 
	//if($bcs !== $lisanskodu){
		$lisans_cevap = file_get_contents('http://127.0.0.1/lisans/kontrol.php?domain='.$lisans['domain']);
		if($lisans_cevap != 'LISANSLI')
		 
		die('Yazılımı lisansız kullanamazsınız, Lütfen Memsidea ile iletişime geçiniz !!!');
		 
		$lyaz = fopen('lisans.php',"w+");
		@fwrite($lyaz,'<?php
		$lisanskodu="'.$bcs.'";
		?>');
		fclose($lyaz);
	//}
?>

