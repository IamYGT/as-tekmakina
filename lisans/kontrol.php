<?php
	require("../include/baglan.php");include("../include/fonksiyon.php"); 
	$list = $db->query("SELECT * FROM lisans WHERE iStatus = 1");
		$domainList = array();
		foreach($list as $row){
			if($row["expiryTime"] >= date("Y-m-d H:i:s")){
				$domainList[] = $row["strDomain"];
			}
		} 
		
		if(in_array(urldecode($_GET['domain']),$domainList))
			echo 'LISANSLI';
		else
			echo 'IZINSIZ KULLANIM';
	
?>