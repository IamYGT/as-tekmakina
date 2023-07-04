<?php require("../include/baglan.php");include("../include/fonksiyon.php");
		if(!isset($_SESSION['LOGIN']) && !in_array(array('login'))) {
			go("index.php",0);
			exit();
		}
		define('TABLE',"ayarlar");
		define('AREA',"ayarlar");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Memsidea - Yönetim Paneli</title>
    <!-- Favicon icon -->
    <link href="vendor\bootstrap-daterangepicker\daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="vendor\clockpicker\css\bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="vendor\jquery-asColorPicker\css\asColorPicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="vendor\bootstrap-material-datetimepicker\css\bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Pick date -->
    <link rel="stylesheet" href="vendor\pickadate\themes\default.css">
    <link rel="stylesheet" href="vendor\pickadate\themes\default.date.css">
    <!-- Custom Stylesheet -->
    <link href="vendor\bootstrap-select\dist\css\bootstrap-select.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fa27a1c3e4.js" crossorigin="anonymous"></script>
	<link href="vendor/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
	<link href="vendor\summernote\summernote.css" rel="stylesheet">
		<script src="vendor/ck/ckeditor/ckeditor.js"></script>
	<script src="vendor/ck/ckfinder/ckfinder.js"></script>


</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <?php include("menu.php")?>
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
<?php
				if (isset($submitControl)) {
					$settingsInfo = $db->query("select * from ".AREA." where ayar_id = '1'")->fetch(PDO::FETCH_ASSOC);
					$webSettings = json_decode($settingsInfo["ayar_icerik"], true);

					$upload = new Upload($_FILES['logo']);
					if(!isset($_FILES['logo']['name'])) {
						$logo = null;
					} else if(!empty($_FILES['logo']['name'])) {
						$upload->file_auto_rename = true;
						$upload->process("../assets/images");
						if ($upload->processed) {
							$logo = $upload->file_dst_name;
						} else {
							$logo = null;
						}
					} else {
						$logo = $webSettings["logo"];
					}

					$upload = new Upload($_FILES['footerLogo']);
					if(!isset($_FILES['footerLogo']['name'])) {
						$footerLogo = null;
					} else if(!empty($_FILES['footerLogo']['name'])) {
						$upload->file_auto_rename = true;
						$upload->process("../assets/images");
						if ($upload->processed) {
							$footerLogo = $upload->file_dst_name;
						} else {
							$footerLogo = null;
						}
					} else {
						$footerLogo = $webSettings["footerLogo"];
					}

					$upload = new Upload($_FILES['favicon']);
					if(!isset($_FILES['favicon']['name'])) {
						$favicon = null;
					} else if(!empty($_FILES['favicon']['name'])) {
						$upload->file_auto_rename = true;
						$upload->process("../assets/images");
						if ($upload->processed) {
							$favicon = $upload->file_dst_name;
						} else {
							$favicon = null;
						}
					} else {
						$favicon = $webSettings["favicon"];
					}
					$strSettings = array();
					foreach($_POST AS $key => $value) {
						if($key != 'submit' && $key != 'strRobots')
							$strSettings[$key] = trim($value);
					}

					if($strRobots){
						if(file_exists('../Robots.txt')) {
							unlink('../Robots.txt');
						}
						$dosya = fopen("../Robots.txt","a");
						fwrite($dosya,$strRobots);
						fwrite($dosya,"\r\n");
						fclose($dosya);
					}

					$strSettings['logo'] = $logo;
					$strSettings['footerLogo'] = $footerLogo;
					$strSettings['favicon'] = $favicon;
					$strSettings = json_encode($strSettings, JSON_UNESCAPED_UNICODE);
					$strSettings = addslashes($strSettings);
					$update = $db->prepare("UPDATE ".AREA." SET ayar_icerik = '{$strSettings}' WHERE ayar_id = ?");
					$update->execute(array(1));
					if($update){
						$error = Bilgilendirme::Basarili("Başarılı bir şekilde güncellendi.");
						echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
					}else{
						$error = Bilgilendirme::Hata("Hay Akis! Bir hata meydana geldi.");
					}

				}else{
				$settings = $db->query("select * from ".AREA." where ayar_id = '1'")->fetch(PDO::FETCH_ASSOC);
				$row_info = json_decode($settings["ayar_icerik"], true);
?>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Genel Ayarlar</h4>
                            </div>
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#site"><i class="las la-wrench mr-2"></i>Site</a>
                                        </li>



                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#sosyal"><i class="la la-user mr-2"></i> Sosyal Medya</a>
                                        </li>


                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#mail"><i class="las la-mail-bulk mr-2"></i>  Mail</a>
                                        </li>
										<?php if($_SESSION["uye_yetki"] == 1){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#menus"><i class="las la-bars mr-2"></i> Menü</a>
                                        </li>
										<?php } ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#robots"><i class="las la-home mr-2"></i> Robots.txt</a>
                                        </li>
                                    </ul>
									<form action="#" method="POST" enctype="multipart/form-data">
										<div class="tab-content">
											<div class="tab-pane fade show active" id="site" role="tabpanel">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="">Site İsmi <span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" class="form-control" id="" name="strTitle" placeholder="Site İsmi Giriniz.." value="<?php echo $row_info["strTitle"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions">Site Adresi <span class="text-danger">*</span></label>
																			<div class="col-lg-8">
																				<div class="input-group mb-3  input-success">
																					<input type="text" name="strURL" class="form-control" value="<?php echo $row_info["strURL"]?>">
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions">Logo<span class="text-danger">*</span>  </label>
																			<div class="col-lg-8">
																				<div class="input-group mb-3">
																					<div class="custom-file">
																						<input type="file" name="logo" class="custom-file-input">
																						<label class="custom-file-label">Dosya Seç</label>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions">  Logo (Footer)<span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<div class="input-group mb-3">
																					<div class="custom-file">
																						<input type="file" name="logoFooter" class="custom-file-input">
																						<label class="custom-file-label">Dosya Seç</label>

																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-12 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-2 col-form-label" for="val-suggestions">  Favicon<span class="text-danger">*</span> </label>
																			<div class="col-lg-10">
																				<div class="input-group mb-3">
																					<div class="custom-file">
																						<input type="file" name="favicon" class="custom-file-input">
																						<label class="custom-file-label">Dosya Seç</label>

																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions"> Telefon<span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" name="strPhone" class="form-control" placeholder="(+90)546 111 22 33"  value="<?php echo $row_info["strPhone"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions"> Fax <span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" name="strFax" class="form-control" placeholder="(+90)546 111 22 33"  value="<?php echo $row_info["strFax"]?>">
																			</div>
																		</div>
																	</div>

																	<div class="col-lg-12 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-2 col-form-label" for="val-suggestions"> E-posta<span class="text-danger">*</span> </label>
																			<div class="col-lg-10">
																				<input type="text" name="strMail" class="form-control" placeholder="info@alanadiniz.com"  value="<?php echo $row_info["strMail"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-12 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-2 col-form-label" for="val-suggestions">Adres<span class="text-danger">*</span> </label>
																			<div class="col-lg-10">
																				<textarea class="form-control" name="strAddress" rows="4" id="comment"><?php echo $row_info["strAddress"]?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-12 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-2 col-form-label" for="val-suggestions">Çalışma Saatleri <span class="text-danger">*</span> </label>
																			<div class="col-lg-10">
																				<textarea class="form-control" name="strAnalytics" rows="4" id="comment"><?php echo $row_info["strAnalytics"]?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-12 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-2 col-form-label" for="val-suggestions">Canlı Destek <span class="text-danger">*</span> </label>
																			<div class="col-lg-10">
																				<textarea class="form-control" name="strLiveSupport" rows="4" id="comment"><?php echo $row_info["strLiveSupport"]?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="val-suggestions"> Sayfa Gösterim Sayısı<span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="number" name="strPageLimit" class="form-control" value="<?php echo $row_info["strPageLimit"]?>">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="tab-pane" id="kurumsal">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">
																		<?php
															$list = $db->query("select * from dil where dil_durum = '1'");
																foreach ($list AS $row) {
																	$LANGUAGE_ID = $row["dil_id"];
																	$LANGUAGE_CODE = $row["dil_kod"];
																	$LANGUAGE_TITLE = $row["dil_baslik"];
	?>
																	<div class="col-xl-12 col-lg-12 mb-3">

																		<div class="form-group row">
																			<label class="text-label col-3"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i>  Hakkımızda</label>
 																					 <textarea class="form-control ckeditor col-6"  name="hakkimizda_<?php echo $LANGUAGE_CODE; ?>"> <?php echo $row_info["hakkimizda_".$LANGUAGE_CODE]?></textarea>
 																		</div>
																	</div>




	<?php
																}
	?>

																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">
																	<?php
															$list = $db->query("select * from dil where dil_durum = '1'");
																foreach ($list AS $row) {
																	$LANGUAGE_ID = $row["dil_id"];
																	$LANGUAGE_CODE = $row["dil_kod"];
																	$LANGUAGE_TITLE = $row["dil_baslik"];
	?>
																	<div class="col-xl-12 col-lg-12 mb-3">

																	 <div class="form-group row">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i>Alt Hakkımızda</label>
																				<div class="input-group  input-primary-o">
																					 <input  class="form-control" type="text"  name="kisahakkimizda_<?php echo $LANGUAGE_CODE; ?>"   value="<?php echo $row_info["kisahakkimizda_".$LANGUAGE_CODE]?>"> </input>
																				</div>
																		</div>
																	</div>



	<?php
																}
	?>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>


											<div class="tab-pane" id="bizitani">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">
																		<?php
															$list = $db->query("select * from dil where dil_durum = '1'");
																foreach ($list AS $row) {
																	$LANGUAGE_ID = $row["dil_id"];
																	$LANGUAGE_CODE = $row["dil_kod"];
																	$LANGUAGE_TITLE = $row["dil_baslik"];
	?>
																	<div class="col-xl-12 col-lg-12 mb-3">

																		<div class="form-group row">
																			<label class="text-label col-3"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i>  Bizi Tanıyın</label>
 																					 <textarea class="form-control ckeditor col-6"  name="bizitani_<?php echo $LANGUAGE_CODE; ?>"> <?php echo $row_info["bizitani_".$LANGUAGE_CODE]?></textarea>
 																		</div>
																	</div>




	<?php
																}
	?>

																</div>
															</div>
														</div>
													</div>
												</div>

												 </div>
											<div class="tab-pane" id="sayilar">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="row">
																<div class="col-xl-12 col-lg-12 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Ürün Sayısı <span class="text-danger">*</span> </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">

																				<input type="text" name="dosyasayisi" class="form-control" placeholder="Ürün Sayısı" value="<?php echo $row_info["dosyasayisi"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-12 col-lg-12 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Mutlu Müşteri <span class="text-danger">*</span></label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">

																				<input type="text" name="mutlumusteri" class="form-control" placeholder="Mutlu Müşteri"  value="<?php echo $row_info["mutlumusteri"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-12 col-lg-12 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Yıllık Tecrübe  <span class="text-danger">*</span>  </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">

																				<input type="text" name="tecrube" class="form-control" placeholder="Yıllık Tecrübe"  value="<?php echo $row_info["tecrube"]?>">
																			</div>
																		</div>
																	</div>
																</div>



															</div>
														</div>
													</div>
												</div>
											</div>


										<div class="tab-pane" id="sosyal">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="row">
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Facebook <span class="text-danger">*</span> </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strFacebook" class="form-control" placeholder="Kullanıcı Adı" value="<?php echo $row_info["strFacebook"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Google Harita Linki <span class="text-danger">*</span></label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strTwitter" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strTwitter"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Youtube  <span class="text-danger">*</span>  </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strYoutube" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strYoutube"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">İnstagram   <span class="text-danger">*</span> </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strInstagram" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strInstagram"]?>">
																			</div>
																		</div>
																	</div>
																</div>
	<?php
															$list = $db->query("select * from dil where dil_durum = '1'");
																foreach ($list AS $row) {
																	$LANGUAGE_ID = $row["dil_id"];
																	$LANGUAGE_CODE = $row["dil_kod"];
																	$LANGUAGE_TITLE = $row["dil_baslik"];
	?>
																	<div class="col-xl-12 col-lg-12 mb-3">
																		<div class="form-group row">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Whatsapp Numara</label>
																				<div class="input-group  input-primary-o">
																					<div class="input-group-prepend">
																						<span class="input-group-text">+</span>
																					</div>
																					<input type="text"  name="strWhatsappPhone_<?php echo $LANGUAGE_CODE; ?>" class="form-control" placeholder="905123456789" value="<?php echo $row_info["strWhatsappPhone_".$LANGUAGE_CODE]?>">
																				</div>
																		</div>
																	</div>
																	<div class="col-xl-12 col-lg-12 mb-3">
																		<div class="form-group row">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Whatsapp Mesaj</label>
																				<div class="input-group input-primary-o">
																					<div class="input-group-prepend">
																						<span class="input-group-text">+</span>
																					</div>
																					<input type="text"  name="strWhatsappMessage_<?php echo $LANGUAGE_CODE; ?>" class="form-control" placeholder="Mesajınız" value="<?php echo $row_info["strWhatsappMessage_".$LANGUAGE_CODE]?>">
																				</div>
																		</div>
																	</div>
	<?php
																}
	?>

															</div>
														</div>
													</div>
												</div>
											</div>


										<div class="tab-pane" id="sosyal">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="row">
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Facebook <span class="text-danger">*</span> </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strFacebook" class="form-control" placeholder="Kullanıcı Adı" value="<?php echo $row_info["strFacebook"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Google Harita Linki <span class="text-danger">*</span></label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strTwitter" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strTwitter"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">Youtube  <span class="text-danger">*</span>  </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strYoutube" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strYoutube"]?>">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6 mb-3">
																	<div class="form-group row">
																		<label class="col-lg-4 col-form-label" for="">İnstagram   <span class="text-danger">*</span> </label>
																		<div class="col-lg-8">
																			<div class="input-group mb-3 input-primary-o">
																				<div class="input-group-prepend">
																					<span class="input-group-text">@</span>
																				</div>
																				<input type="text" name="strInstagram" class="form-control" placeholder="Kullanıcı Adı"  value="<?php echo $row_info["strInstagram"]?>">
																			</div>
																		</div>
																	</div>
																</div>
	<?php
															$list = $db->query("select * from dil where dil_durum = '1'");
																foreach ($list AS $row) {
																	$LANGUAGE_ID = $row["dil_id"];
																	$LANGUAGE_CODE = $row["dil_kod"];
																	$LANGUAGE_TITLE = $row["dil_baslik"];
	?>
																	<div class="col-xl-12 col-lg-12 mb-3">
																		<div class="form-group row">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Whatsapp Numara</label>
																				<div class="input-group  input-primary-o">
																					<div class="input-group-prepend">
																						<span class="input-group-text">+</span>
																					</div>
																					<input type="text"  name="strWhatsappPhone_<?php echo $LANGUAGE_CODE; ?>" class="form-control" placeholder="905123456789" value="<?php echo $row_info["strWhatsappPhone_".$LANGUAGE_CODE]?>">
																				</div>
																		</div>
																	</div>
																	<div class="col-xl-12 col-lg-12 mb-3">
																		<div class="form-group row">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Whatsapp Mesaj</label>
																				<div class="input-group input-primary-o">
																					<div class="input-group-prepend">
																						<span class="input-group-text">+</span>
																					</div>
																					<input type="text"  name="strWhatsappMessage_<?php echo $LANGUAGE_CODE; ?>" class="form-control" placeholder="Mesajınız" value="<?php echo $row_info["strWhatsappMessage_".$LANGUAGE_CODE]?>">
																				</div>
																		</div>
																	</div>
	<?php
																}
	?>

															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="rakam">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="row">

																<div class="col-xl-12 col-lg-6 mb-3">
																	<div class="input-group mb-3 input-primary-o">
																		<div class="input-group-prepend">
																			<span class="input-group-text">Mutlu Müşteri</span>
																		</div>
																		<input type="text" name="strColorOne" class="form-control" placeholder="Mutlu Müşteri"  value="<?php echo $row_info["strColorOne"]?>">
																	</div>
																</div>


																<div class="col-xl-12 col-lg-6 mb-3">
																	<div class="input-group mb-3 input-primary-o">
																		<div class="input-group-prepend">
																			<span class="input-group-text">Yıllık Tecrübe</span>
																		</div>
																		<input type="text" name="strColorTwo" class="form-control" placeholder="Yıllık Tecrübe"  value="<?php echo $row_info["strColorTwo"]?>">
																	</div>
																</div>


																<div class="col-xl-12 col-lg-6 mb-3">
																	<div class="input-group mb-3 input-primary-o">
																		<div class="input-group-prepend">
																			<span class="input-group-text">Daire Sayısı</span>
																		</div>
																		<input type="text" name="strColorThree" class="form-control" placeholder="Daire Sayısı"  value="<?php echo $row_info["strColorThree"]?>">
																	</div>
																</div>


																<div class="col-xl-12 col-lg-6 mb-3">
																	<div class="input-group mb-3 input-primary-o">
																		<div class="input-group-prepend">
																			<span class="input-group-text">Blok Sayısı</span>
																		</div>
																		<input type="text" name="strMailTitle" class="form-control" placeholder="Blok Sayısı"  value="<?php echo $row_info["strMailTitle"]?>">
																	</div>
																</div>

															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="mail">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="">Mail Server <span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" class="form-control" id="" name="strMailHost" placeholder="Mail Server Giriniz.."  value="<?php echo $row_info["strMailHost"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="">Mail Port <span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" class="form-control" id="" name="strMailPort" placeholder="Mail Port Numarasını Giriniz.."  value="<?php echo $row_info["strMailPort"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="">Mail Adresi <span class="text-danger">*</span> </label>
																			<div class="col-lg-8">
																				<input type="text" class="form-control" id="" name="strMailAddress" placeholder="Mail Adresi Giriniz.."  value="<?php echo $row_info["strMailAddress"]?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-6 mb-3">
																		<div class="form-group row">
																			<label class="col-lg-4 col-form-label" for="">Mail Şifresi <span class="text-danger">*</span></label>
																			<div class="col-lg-8">
																				<input type="password" class="form-control" id="" name="strMailPassword" placeholder="Mail Şifresi Giriniz.."  value="<?php echo $row_info["strMailPassword"]?>">
																			</div>
																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php if($_SESSION["uye_yetki"] == 1){ ?>
											<div class="tab-pane" id="menus">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="form-validation">
																<div class="row">

																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusPages" value="2">
																					<input type="checkbox" name="iStatusPages" class="custom-control-input" id="iStatusPages" value="1" <?php if ($row_info["iStatusPages"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusPages">Sayfalar</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusMenus" value="2">
																					<input type="checkbox" name="iStatusMenus" class="custom-control-input" id="iStatusMenus" value="1" <?php if ($row_info["iStatusMenus"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusMenus">Menüler</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusCategories" value="2">
																					<input type="checkbox" name="iStatusCategories" class="custom-control-input" id="iStatusCategories" value="1" <?php if ($row_info["iStatusCategories"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusCategories">Kategoriler</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusSlides" value="2">
																					<input type="checkbox" name="iStatusSlides" class="custom-control-input" id="iStatusSlides" value="1" <?php if ($row_info["iStatusSlides"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusSlides">Slaytlar</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusNews" value="2">
																					<input type="checkbox" name="iStatusNews" class="custom-control-input" id="iStatusNews" value="1" <?php if ($row_info["iStatusNews"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusNews">Haberler</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusGallery" value="2">
																					<input type="checkbox" name="iStatusGallery" class="custom-control-input" id="iStatusGallery" value="1" <?php if ($row_info["iStatusGallery"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusGallery">Galeri</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusProjects" value="2">
																					<input type="checkbox" name="iStatusProjects" class="custom-control-input" id="iStatusProjects" value="1" <?php if ($row_info["iStatusProjects"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusProjects">Projeler</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusBrands" value="2">
																					<input type="checkbox" name="iStatusBrands" class="custom-control-input" id="iStatusBrands" value="1" <?php if ($row_info["iStatusBrands"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusBrands">Markalar</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusReferences" value="2">
																					<input type="checkbox" name="iStatusReferences" class="custom-control-input" id="iStatusReferences" value="1" <?php if ($row_info["iStatusReferences"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusReferences">Referanslar</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusTeams" value="2">
																					<input type="checkbox" name="iStatusTeams" class="custom-control-input" id="iStatusTeams" value="1" <?php if ($row_info["iStatusTeams"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusTeams">Ekibimiz</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusCars" value="2">
																					<input type="checkbox" name="iStatusCars" class="custom-control-input" id="iStatusCars" value="1" <?php if ($row_info["iStatusCars"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusCars">Araçlar</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusNewsletter" value="2">
																					<input type="checkbox" name="iStatusNewsletter" class="custom-control-input" id="iStatusNewsletter" value="1" <?php if ($row_info["iStatusNewsletter"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusNewsletter">eBülten</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-3 mb-3">
																		<div class="form-group row">
																			<div class="col-lg-4">
																				<div class="custom-control custom-switch toggle-switch text-right mr-5 mb-2">
																					<input type="hidden" name="iStatusLangs" value="2">
																					<input type="checkbox" name="iStatusLangs" class="custom-control-input" id="iStatusLangs" value="1" <?php if ($row_info["iStatusLangs"] == "1") { echo "checked";}?>>
																					<label class="custom-control-label" for="iStatusLangs">Dil</label>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<div class="tab-pane" id="robots">
												<div class="col-lg-12">
													<div class="card">
														<div class="card-body">
															<div class="col-lg-12 mb-2">
																<div class="form-group">
																	<label class="text-label">Robots.txt</label>
																	<textarea class="form-control" name="strRobots" cols="30" rows="10"><?php
																			if (file_exists("../Robots.txt")){
																				$dosya = fopen("../Robots.txt","r");
																				while (!feof($dosya)) {
																						$okunanveri = fgets($dosya, 4096);
																						echo $okunanveri;
																					}
																				fclose($dosya);
																			}
																	?></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-xl-12 mb-3">
											<button style="float:right;" type="submit" name="submitControl" value="1" class="btn mr-6 btn-primary">Kaydet</button>
										</div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
				}
?>

<?php

			if(isset($error)) {
?>
					<div class="col-lg-12">
						<div class="alert alert-secondary solid alert-dismissible fade show">
							<strong>İşlem Sonucu!</strong>
							<p><?php echo $error; ?></p>
						</div>
					</div>
<?php
			}
?>
                </div>
            </div>
        </div>
        <?php include("alt.php")?>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor\global\global.min.js"></script>
    <script src="vendor\bootstrap-select\dist\js\bootstrap-select.min.js"></script>
    <script src="js\custom.min.js"></script>
    <script src="js\deznav-init.js"></script>
    <script src="vendor\owl-carousel\owl.carousel.js"></script>
    <!-- asColorPicker -->
    <script src="vendor\jquery-asColor\jquery-asColor.min.js"></script>
    <script src="vendor\jquery-asGradient\jquery-asGradient.min.js"></script>
    <script src="vendor\jquery-asColorPicker\js\jquery-asColorPicker.min.js"></script>
    <!-- Material color picker -->
    <script src="vendor\bootstrap-material-datetimepicker\js\bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="vendor\pickadate\picker.js"></script>
    <script src="vendor\pickadate\picker.time.js"></script>
    <script src="vendor\pickadate\picker.date.js"></script>



    <!-- Daterangepicker -->
    <script src="js\plugins-init\bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="js\plugins-init\clock-picker-init.js"></script>
    <!-- asColorPicker init -->
    <script src="js\plugins-init\jquery-asColorPicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="js\plugins-init\material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="js\plugins-init\pickadate-init.js"></script>


   <!-- Summernote init -->
    <script src="js\plugins-init\summernote-init.js"></script>
	<script src="vendor\summernote\js\summernote.min.js"></script>
</body>

</html>
