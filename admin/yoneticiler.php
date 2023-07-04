<?php require("../include/baglan.php");include("../include/fonksiyon.php"); 
		if(!isset($_SESSION['LOGIN']) && !in_array(array('login'))) {
			go("index.php",0);  
			exit();
		}
		define('TABLE',"uyeler");
		define('AREA',"yoneticiler");
		if(!isset($do)) $do = null; 
		$sayfa = (isset($q) ? $q : 1);
		$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM ".TABLE." ")->fetchColumn();
		$limit = 10;
		$sonSayfa = ceil($toplam_veri_sayisi/$limit);
		$baslangic = ($sayfa-1)*$limit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Yöneticiler - Memsidea Yem Otomasyonu</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images\favicon.png">
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor\chartist\css\chartist.min.css">
	<!-- Vectormap -->
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
    <link href="vendor\bootstrap-select\dist\css\bootstrap-select.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="vendor\owl-carousel\owl.carousel.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/fa27a1c3e4.js" crossorigin="anonymous"></script>

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
			if($do == '') {
?>			
					<div style="margin-bottom: 15px;" class="col-xl-12">
						<a href="<?php echo AREA; ?>?do=add"><button style="float: right;"  type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni</button></a>
					</div>
					<div class="col-xl-12">
						<div class="table-responsive">
							<div id="example5_wrapper" class="dataTables_wrapper no-footer">
								<table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5" role="grid" aria-describedby="example5_info">
									<thead>
										<tr role="row">
											<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 115.6px;">Adı Soyadı</th>
											<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Postition: activate to sort column ascending" style="width: 82px;">E-posta</th>
											<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 96.4px;">Telefon</th>
											<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Durumu</th>
										<th class="sorting_asc" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Contact: activate to sort column descending" style="width: 116.4px;" aria-sort="ascending"></th>
										</tr>
									</thead>
									<tbody>
<?php
									$iAuthority = ($_SESSION["uye_yetki"] == 1 ? null : "WHERE uye_yetki IN(1,2,3)");
									$list = $db->query("SELECT * FROM ".TABLE." ".$iAuthority." LIMIT $baslangic,$limit"); 
										if ($list->rowCount()){
											foreach($list as $row){
												switch($row["uye_yetki"]){
													case 1:
														$uyeYetki = "Super Admin";
														break;
													case 2:
														$uyeYetki = "Admin";
														break;
													case 3:
														$uyeYetki = "Editör";
														break;
												}
											$uye_durum = ($row["uye_durum"]  == 1) ? array('type' => 'success', 'text' => 'Aktif') : array('type' => 'danger', 'text' => 'Pasif');

?>
										<tr role="row" class="even">
											<td class="">
												<div class="media">
													<svg class="mr-3" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path
															d="M0.000732422 7.27273C0.000732422 3.25611 3.25684 0 7.27346 0H42.728C46.7446 0 50.0007 3.25611 50.0007 7.27273V42.7273C50.0007 46.7439 46.7446 50 42.728 50H7.27346C3.25684 50 0.000732422 46.7439 0.000732422 42.7273V7.27273Z"
															fill="#D3D3D3"
														></path>
														<path
															d="M0.000732422 7.27273C0.000732422 3.25611 3.25684 0 7.27346 0H42.728C46.7446 0 50.0007 3.25611 50.0007 7.27273V42.7273C50.0007 46.7439 46.7446 50 42.728 50H7.27346C3.25684 50 0.000732422 46.7439 0.000732422 42.7273V7.27273Z"
															fill="#40C7CF"
														></path>
														<path
															d="M12.8892 12.8887C14.4645 11.3134 16.3346 10.0639 18.3928 9.21132C20.451 8.35878 22.657 7.91999 24.8848 7.91999C27.1126 7.91999 29.3185 8.35878 31.3767 9.21132C33.4349 10.0639 35.305 11.3134 36.8803 12.8887C38.4556 14.464 39.7052 16.3341 40.5577 18.3923C41.4103 20.4505 41.8491 22.6565 41.8491 24.8843C41.8491 27.1121 41.4103 29.318 40.5577 31.3762C39.7052 33.4344 38.4556 35.3046 36.8803 36.8798L30.8825 30.8821C31.6702 30.0944 32.295 29.1594 32.7212 28.1303C33.1475 27.1011 33.3669 25.9982 33.3669 24.8843C33.3669 23.7704 33.1475 22.6674 32.7212 21.6383C32.295 20.6092 31.6702 19.6741 30.8825 18.8865C30.0949 18.0989 29.1598 17.4741 28.1307 17.0478C27.1016 16.6215 25.9987 16.4021 24.8848 16.4021C23.7709 16.4021 22.6679 16.6215 21.6388 17.0478C20.6097 17.4741 19.6746 18.0989 18.887 18.8865L12.8892 12.8887Z"
															fill="#8FD7FF"
														></path>
														<path
															d="M12.8892 36.8798C9.70778 33.6984 7.92048 29.3835 7.92048 24.8843C7.92048 20.385 9.70778 16.0701 12.8892 12.8887C16.0706 9.70727 20.3856 7.91997 24.8848 7.91996C29.384 7.91996 33.6989 9.70726 36.8803 12.8887L30.8825 18.8865C29.2918 17.2958 27.1344 16.4021 24.8848 16.4021C22.6352 16.4021 20.4777 17.2958 18.887 18.8865C17.2963 20.4772 16.4026 22.6346 16.4026 24.8843C16.4026 27.1339 17.2963 29.2913 18.887 30.882L12.8892 36.8798Z"
															fill="white"
														></path>
													</svg>
													<div class="media-body text-nowrap">
														<h6 class="text-black font-w600 fs-16 mb-0"><?php echo $row["uye_adsoyad"]; ?></h6>
														<span class="fs-14"><?php echo $uyeYetki; ?></span>
													</div>
												</div>
											</td>
											<td class=""><?php echo $row["uye_eposta"]; ?></td>
											<td class=""><?php echo $row["uye_telefon"]; ?></td> 
											<td class=""><a class="btn btn-xs btn-<?php echo $uye_durum["type"]; ?> mr-3" href="#"><?php echo $uye_durum["text"]; ?></a></td>
											<td class="sorting_1">
												<div class="d-flex">
													<a class="contact-icon mr-3" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["uye_id"]; ?>"><i class="fas fa-edit" aria-hidden="true"></i></a>
													<a class="contact-icon" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["uye_id"]; ?>"><i class="fas fa-trash-alt"></i></a>
												</div>
											</td> 
										</tr>
<?php 	
											}
										}else{
											echo '<tr><td colspan="5" class="text-center">Listelenecek veri bulunamadı.</td></tr>';
										}
?>
									</tbody>
								</table>
								<div class="dataTables_info" id="example5_info" role="status" aria-live="polite"><?php echo $toplam_veri_sayisi; ?> kayıttan <?php echo $sayfa; ?>-<?php echo $toplam_veri_sayisi; ?> arası gösteriliyor</div>
						<?php if($toplam_veri_sayisi > $limit){ ?>
							<div class="dataTables_paginate paging_simple_numbers" id="example5_paginate">
								<?php 
										$x = 2; 
										if($sayfa > 1){	
											$onceki = $sayfa-1;	
											echo '<a href="?q='.$onceki.'" class="paginate_button previous disabled">Geri</a>';
										}	
										if($sayfa==1){
											echo '<span><a class="paginate_button current" >1</a></span>';
										} else {
											echo '<span><a href="?q=1" class="paginate_button previous">1</a></span>';
										}
										if($sayfa-$x > 2){
											echo '...'; 
											$i = $sayfa-$x;
										} else { 			
											$i = 2; 		  
										}
										for($i; $i<=$sayfa+$x; $i++) {
											if($i==$sayfa){
												echo '<span><a href="#" class="paginate_button current">'.$i.'</a></span>';
											} else {
												echo '<span><a href="?q='.$i.'" class="paginate_button previous">'.$i.'</a></span>';
											}
											if($i==$sonSayfa) break;  
										}		
										if($sayfa < $sonSayfa){	  
											$sonraki = $sayfa+1;   
											echo '<a href="?q='.$sonraki.'" class="paginate_button next disabled">İleri</a>';		  
										}	
								?> 
							</div>
						<?php } ?> 
							</div> 
						</div>
					</div> 
<?php 
			} else if($do == 'add') {
				if(isset($submitControl)){
					if(!empty($_POST['uye_adsoyad']) || !empty($_POST['uye_eposta'])) {
							$insert = $db->prepare("INSERT INTO ".TABLE." SET uye_adsoyad = ?, uye_sifre = ?, uye_eposta = ?, uye_telefon = ?, uye_yetki = ?, uye_durum = ?");
							$insert->execute(array($uye_adsoyad, md5($_POST['uye_sifre']), $uye_eposta, $uye_telefon, $uye_yetki, $uye_durum));
							$last_id = $db->lastInsertId();
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$last_id.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
						}else {
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					}else{  
						$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
					}
				} else {
?>
				<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; "> 
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
							<div class="card-header">
								<h4 class="card-title">Yönetici Ekle</h4>
							</div>
							<div class="card-body"> 
								<div class="row">
									<div class="col-lg-12 mb-2">
										<div class="form-group">
											<label class="text-label">Ad Soyad</label>
											<input type="text" name="uye_adsoyad" class="form-control" placeholder="Ad Soyad" required="">
										</div>
									</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Eposta</label>
												<input type="text" name="uye_eposta" class="form-control" placeholder="Eposta" required="">
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Telefon</label>
												<input type="text" name="uye_telefon" class="form-control" placeholder="Telefon" required="">
											</div>
										</div>
										<div class="col-lg-12 mb-2">
											<div class="form-group">
												<label class="text-label">Şifre</label>
												<input type="text" name="uye_sifre" class="form-control" placeholder="Şifre" required="">
											</div>
										</div>
								</div>
								<div class="step-footer pull-right">
									<button class="step-btn1 btn btn-rounded btn-danger" type="submit">Kaydet</button>
									<input type="hidden" name="submitControl" value="1" />
								</div> 
							</div>
						</div>
                    </div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3"> 
								<div class="form-group"> 
									<label for="">Yetki</label>
									<select name="uye_yetki" class="form-control">
										<?php if($_SESSION["uye_yetki"] == 1){ ?><option value="1">Süper Admin</option><?php }?>
										<option value="2">Admin</option>
										<option value="3">Editör</option> 
									</select>
								</div> 
								<div class="form-group"> 
									<label for="">Yayın Durumu</label>
									<select name="uye_durum" class="form-control">
										<option value="1">Aktif</option>
										<option value="2">Pasif</option> 
									</select>
								</div> 
                            </div>
                        </div>
                    </div>
				</form>
<?php 
				}
?>
<?php 
			}else if($do == 'edit') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE uye_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					if(isset($submitControl)){
						if(!empty($_POST['uye_adsoyad']) || !empty($_POST['uye_eposta'])) {
							$image_info = $db->query("SELECT * FROM ".TABLE." WHERE uye_id = {$id}")->fetch(PDO::FETCH_ASSOC); 
						 
							if(!empty($_POST['uye_sifre'])) {
								$uye_sifre = md5($_POST['uye_sifre']);
							}else{
								$uye_sifre = $image_info["uye_sifre"];
							}
							$update = $db->prepare("UPDATE ".TABLE." SET uye_adsoyad = ?, uye_sifre = ?, uye_eposta = ?, uye_telefon = ?, uye_yetki = ?, uye_durum = ? WHERE uye_id = ?");
							$update->execute(array($uye_adsoyad, $uye_sifre, $uye_eposta, $uye_telefon, $uye_yetki, $uye_durum, $id));
							
							if ($update) {
								echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$id.'">';
								$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
							}else {
								$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
							}
						}else{  
							$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
						}
					} else {
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE uye_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>

				<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; "> 
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
							<div class="card-header">
								<h4 class="card-title">Yönetici Ekle</h4>
							</div>
							<div class="card-body"> 
								<div class="row">
									<div class="col-lg-12 mb-2">
										<div class="form-group">
											<label class="text-label">Ad Soyad</label>
											<input type="text" name="uye_adsoyad" class="form-control" placeholder="Ad Soyad" required="" value="<?php echo $row_info["uye_adsoyad"]; ?>">
										</div>
									</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Eposta</label>
												<input type="text" name="uye_eposta" class="form-control" placeholder="Eposta" required="" value="<?php echo $row_info["uye_eposta"]; ?>">
											</div>
										</div>
										<div class="col-lg-6 mb-2">
											<div class="form-group">
												<label class="text-label">Telefon</label>
												<input type="text" name="uye_telefon" class="form-control" placeholder="Telefon" required="" value="<?php echo $row_info["uye_telefon"]; ?>">
											</div>
										</div>
										<div class="col-lg-12 mb-2">
											<div class="form-group">
												<label class="text-label">Şifre</label>
												<input type="text" name="uye_sifre" class="form-control" placeholder="Şifre">
											</div>
										</div>
								</div>
								<div class="step-footer pull-right">
									<button class="step-btn1 btn btn-rounded btn-danger" type="submit">Kaydet</button>
									<input type="hidden" name="submitControl" value="1" />
								</div> 
							</div>
						</div>
                    </div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3"> 
								<div class="form-group"> 
									<label for="">Yetki</label>
									<select name="uye_yetki" class="form-control">
										<?php if($_SESSION["uye_yetki"] == 1){ ?><option value="1" <?php if ($row_info["uye_yetki"] == "1") { echo "selected";}?>>Süper Admin</option><?php }?>
										<option value="2" <?php if ($row_info["uye_yetki"] == "2") { echo "selected";}?>>Admin</option>
										<option value="3" <?php if ($row_info["uye_yetki"] == "3") { echo "selected";}?>>Editör</option> 
									</select>
								</div> 
								<div class="form-group"> 
									<label for="">Yayın Durumu</label>
									<select name="uye_durum" class="form-control">
										<option value="1" <?php if ($row_info["uye_durum"] == "1") { echo "selected";}?>>Aktif</option>
										<option value="2" <?php if ($row_info["uye_durum"] == "2") { echo "selected";}?>>Pasif</option> 
									</select>
								</div> 
                            </div>
                        </div>
                    </div>
				</form>
<?php 
					}
				
?>
<?php
				} else {
					$error = Bilgilendirme::Hata("Belirlenen veri bulunamadı.");  
				}
?>
<?php 
			}else if($_GET["do"] == 'delete') {  
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE uye_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					$update = $db->exec("DELETE FROM ".TABLE." WHERE uye_id = {$id};");
					if($update) {
						echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
						$error = Bilgilendirme::Basarili("Başarılı şekilde silindi"); 	 
					}else{
						$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
					}
				} 
			}
?>
<?php 

			if(isset($error)) {
?>
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-secondary solid alert-dismissible fade show">
								<strong>İşlem Sonucu!</strong>
								<p><?php echo $error; ?></p>
							</div>
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
	<script src="vendor\chart.js\Chart.bundle.min.js"></script>
    <script src="js\custom.min.js"></script>
	<script src="js\deznav-init.js"></script>
	<script src="vendor\owl-carousel\owl.carousel.js"></script>
		
	
	<!-- Chart piety plugin files -->
    <script src="vendor\peity\jquery.peity.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="js\dashboard\dashboard-1.js"></script>
	
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:15,
				nav:false,
				dots: false,
				left:true,
				navText: ['', ''],
				responsive:{
					0:{
						items:1
					},
					800:{
						items:2
					},	
					991:{
						items:2
					},			
					
					1200:{
						items:2
					},
					1600:{
						items:2
					}
				}
			})		
			jQuery('.testimonial-two').owlCarousel({
				loop:true,
				autoplay:true,
				margin:15,
				nav:false,
				dots: true,
				left:true,
				navText: ['', ''],
				responsive:{
					0:{
						items:1
					},
					600:{
						items:2
					},	
					991:{
						items:3
					},			
					
					1200:{
						items:3
					},
					1600:{
						items:4
					}
				}
			})					
		}
		
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>
</body>
</html>