<?php require("../include/baglan.php");  include("../include/fonksiyon.php");
	if(isset($_SESSION['LOGIN'])) {
		go("anasayfa",0);  
		exit();
	}
if ($_POST) {
	$uye_eposta = trim($_POST["uye_eposta"]);
	$uye_sifre = trim($_POST["uye_sifre"]);
	$sifre = md5($uye_sifre);
	if (empty($uye_eposta) || empty($uye_sifre)) {
		$Uyari[] = Uyari::Hata("Hoppala! Boş alan bıraktınız.");
	}else {
		$varmi = $db->prepare("SELECT * FROM uyeler where uye_eposta=? AND uye_sifre=?");
		$varmi->execute(array(
			$uye_eposta,
			md5($uye_sifre)
		));
		if ($varmi->rowCount() > 0) {
			$dizi = $varmi->fetch(PDO::FETCH_ASSOC);
			if ($dizi["uye_durum"] == 2) { 
				$Uyari[] = Uyari::Bilgi("Hata Üyeliğinize son verilmiştir.");
			}else {
				$_SESSION['LOGIN'] = TRUE;
				$_SESSION['uye_id'] = $dizi["uye_id"];
				$_SESSION['uye_adsoyad'] = $dizi["uye_adsoyad"];
				$_SESSION['uye_eposta'] = $dizi["uye_eposta"];
				$_SESSION['uye_yetki'] = $dizi["uye_yetki"];
				$_SESSION['HASH'] = md5($dizi["uye_eposta"]. time());
				if ($dizi) { 
					go("anasayfa.php", 0);
				}else {
					$Uyari[] = Uyari::Hata("Hay Akis! Bir hata meydana geldi." . $errorInfo = DB::getLastError());
				}
			}
		}else {
			$Uyari[] = Uyari::Tehlike("Hey! Ne yapmaya çalışıyorsun sen.");
		}
	}
}  
?>
<!DOCTYPE html>
<html lang="tr" class="h-100"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Memsidea - Yönetim Paneline Hoşgeldiniz</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images\favicon.png">
    <link href="css\style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index"><img src="images\logo.png" alt="Panel"> </a>
									</div>
                                    <h4 class="text-center mb-4 text-white">Memsidea <br>Yönetim Paneline Hoşgeldiniz.</h4>
									<?php if(isset($Uyari)){ foreach($Uyari AS $UyariListele){ echo $UyariListele;} } ?>
                                    <form action="" method="POST" accept-charset="UTF-8">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>E-posta Adresiniz</strong></label>
                                            <input type="email" name="uye_eposta" class="form-control"  placeholder="E-posta Adresinizi giriniz..." value="">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Şifre</strong></label>
                                            <input type="password" name="uye_sifre"  class="form-control" placeholder="Şifrenizi giriniz.." value="">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1 text-white">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Beni Hatırla</label>
												</div>
                                            </div>
                                             
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Giriş Yap</button>
                                        </div>
                                    </form>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor\global\global.min.js"></script>
	<script src="vendor\bootstrap-select\dist\js\bootstrap-select.min.js"></script>
    <script src="js\custom.min.js"></script>
    <script src="js\deznav-init.js"></script>

</body>

</html>