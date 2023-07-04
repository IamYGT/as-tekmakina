<?php require("../include/baglan.php");include("../include/fonksiyon.php"); 
		if(!isset($_SESSION['LOGIN']) && !in_array(array('login'))) {
			go("index.php",0);  
			exit();
		}
		define('TABLE',"dil");
		define('AREA',"diller");
		if(!isset($do)) $do = null; 
		$sayfa = (isset($q) ? $q : 1);
		if($do == "words"){
			$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM dil_kelimeler ")->fetchColumn();
		} else {
			$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM ".TABLE." WHERE dil_id = '".LANGUAGE_DEFAULT."' ")->fetchColumn(); 
		} 
		$limit = 10;
		$sonSayfa = ceil($toplam_veri_sayisi/$limit);
		$baslangic = ($sayfa-1)*$limit;

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Memsidea - Yönetim Paneli</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images\favicon.png">
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor\chartist\css\chartist.min.css">
	<!-- Toast -->
    <link rel="stylesheet" href="vendor\toastr\css\toastr.min.css">
	<!-- Vectormap -->
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
    <link href="vendor\bootstrap-select\dist\css\bootstrap-select.min.css" rel="stylesheet">
		<link href="vendor/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="vendor\owl-carousel\owl.carousel.css" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fa27a1c3e4.js" crossorigin="anonymous"></script> 
	<link href="vendor/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
	
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
						<a onclick="alert('Yeni dil işlemleri için lütfen bizle iletişime geçiniz.');"><button style="float: right;"  type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni</button></a>
					</div>
					<div class="col-xl-12"> 
						<div class="table-responsive"> 
							<div id="example5_wrapper" class="dataTables_wrapper no-footer">
								<table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5" role="grid" aria-describedby="example5_info">
									<thead>
										<tr role="row"> 
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 30%;">Title</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 20%;">Kod</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 20%;">Resim</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 20%;">Varsayılan</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 10%;">Durum</th>
									</thead>
									<tbody> 
<?php
									$list = $db->query("SELECT * FROM ".TABLE." LIMIT $baslangic,$limit"); 
										if ($list->rowCount()){
											foreach($list as $row){ 
											switch($row["dil_varsayilan"]){
												case 1:
													$dil_varsayilan = array('type' => 'success', 'text' => 'Varsayılan');
													$default = '#';
													break;
												case 2:
													$dil_varsayilan = array('type' => 'danger', 'text' => 'Varsayılan Değil');
													$default = AREA.'?do=default&id='.$row["dil_id"].'&type=1';
													break;
											}
											switch($row["dil_durum"]){
												case 1:
													$dil_durum = array('type' => 'success', 'text' => 'Aktif');
													$status = 1;
													break;
												case 2:
													$dil_durum = array('type' => 'danger', 'text' => 'Pasif');
													$status = 2;
													break;
											}
											//$dil_varsayilan = ($row["dil_varsayilan"]  == 1) ? array('type' => 'success', 'text' => 'Varsayılan') : array('type' => 'danger', 'text' => 'Varsayılan Değil');
											//$dil_durum = ($row["dil_durum"]  == 1) ? array('type' => 'success', 'text' => 'Aktif') : array('type' => 'danger', 'text' => 'Pasif');

?>
										<tr role="row" class="even"> 
											<td class=""><?php echo $row["dil_baslik"]; ?></td>
											<td class=""><?php echo $row["dil_kod"]; ?></td>
											<td class=""><i class="flag-icon flag-icon-<?php echo $row["dil_kod"]; ?> icon-2x"></i></td>
											<td class=""><a href="<?php echo $default; ?>" class="btn btn-xs btn-<?php echo $dil_varsayilan["type"]; ?> mr-3"><?php echo $dil_varsayilan["text"]; ?></a></td>
											<td class=""><a href="<?php echo AREA; ?>?do=status&id=<?php echo $row["dil_id"]; ?>&type=<?php echo $status; ?>" class="btn btn-xs btn-<?php echo $dil_durum["type"]; ?> mr-3"><?php echo $dil_durum["text"]; ?></a></td>

										
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
			} else if($do == 'words') {
				if(isset($submitControl)){
					if(!empty($_POST['dil_baslik']) || !empty($_POST['dil_aciklama'])) {
						$upload = new Upload($_FILES['dil_resim']);
						if ($upload->uploaded) { 
								$upload->file_auto_rename = true;
								$upload->process("../uploads/categories");
							if ($upload->processed){  
								$dil_resim = $upload->file_dst_name;
							} else { 
								$error = Bilgilendirme::Hata("Hay Akis! Bir hata meydana geldi.".$upload->error);
							}
						}
						foreach ($_POST AS $k=>$v) {
							$v = $v;
							if (substr($k,0,5) == "form_") {
								$key = str_replace("form_","",$k);
								$insert = $db->prepare("INSERT INTO ".TABLE." SET dil_baslik = ?, dil_seo = ?, dil_aciklama = ?, dil_resim = ?, dil_id = ?, dil_durum = ?, dil_ust_id = ?");
								$insert->execute(array($dil_baslik[$key], Seo_Link_Cevir($dil_baslik[$key]), $dil_aciklama[$key], $dil_resim, $key, $dil_durum, time()));
								$last_id = $db->lastInsertId();
							}
						}
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.time().'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
						}else {
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					}else{  
						$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
					}
				} else {
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
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 115.6px;">Adı</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Anahtar</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Deger</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Dil</th>
									</thead>
									<tbody> 
<?php
									$langs = array();
									$langList = $db->query("SELECT * FROM dil WHERE dil_durum = 1");
									foreach($langList as $langRow){
										$langs[] = $langRow["dil_kod"];
									}
									$langs = implode("','",$langs);
									$list = $db->query("SELECT * FROM dil_kelimeler WHERE kod IN('$langs') LIMIT $baslangic,$limit"); 
										if ($list->rowCount()){
											foreach($list as $row){ 
?>
										<tr role="row" class="even"> 
											<td class=""><?php echo $row["adi"]; ?></td>
											<td class=""><?php echo $row["anahtar"]; ?></td>
											<td class=""><input type="text" name="deger" id="<?php echo $row["id"] ?>" value="<?php echo $row["deger"]?>" onchange="saveData(event,'<?php echo $row["id"] ?>')"> <span style="display:none"><?php echo $row["deger"]?></span> </td>
											<td class=""><?php echo $row["kod"]?></td> 
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
											echo '<a href="diller?do=words&q='.$onceki.'" class="paginate_button previous disabled">Geri</a>';
										}	
										if($sayfa==1){
											echo '<span><a class="paginate_button current" >1</a></span>';
										} else {
											echo '<span><a href="diller?do=words&q=1" class="paginate_button previous">1</a></span>';
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
												echo '<span><a href="diller?do=words&q='.$i.'" class="paginate_button previous">'.$i.'</a></span>';
											}
											if($i==$sonSayfa) break;  
										}		
										if($sayfa < $sonSayfa){	  
											$sonraki = $sayfa+1;   
											echo '<a href="diller?do=words&q='.$sonraki.'" class="paginate_button next disabled">İleri</a>';		  
										}	
								?> 
							</div>
						<?php } ?> 
							</div> 
						</div>
					</div> 
<?php 
				}
?>
<?php 
			} else if($do == 'add') {
				if(isset($submitControl)){
					if(!empty($_POST['adi']) || !empty($_POST['deger']) || !empty($_POST['anahtar'])) {
						$Dil = $db->query("select * from dil where dil_durum = '1'"); 	
						$langs = array();
						foreach ($Dil AS $DilListele) {
							if(!in_array($DilListele['dil_kod'], $langs)) {
								$langs[] = $DilListele['dil_kod'];
							}
						} 
						foreach($langs as $lang) {
							if(count($_POST['adi'][$lang])) {
								for($i=0;$i<count($_POST['adi'][$lang]);$i++) {
									$adi = $_POST['adi'][$lang][$i];
									$anahtar = $_POST['anahtar'][$lang][$i]; 
									$deger = $_POST['deger'][$lang][$i]; 

									$insert = $db->prepare("INSERT INTO dil_kelimeler SET adi = ?, anahtar = ?, deger = ?, kod = ?");
									$insert->execute(array($adi, $anahtar, $deger, $lang));
								}
							}
						}
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=words">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
						} else {
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					} else {  
						$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
					}
				} else {
?>
	
					<div class="col-xl-12"> 
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kelime Ekle</h4>
                            </div>
                            <div class="card-body"> 
								<form action="#" method="POST" enctype="multipart/form-data" id="form"> 
									<div class="row">
									<?php $k = 0; $a = 0;
										$Dilcik = $db->query("select * from ".TABLE." where dil_durum = '1'"); 
										foreach ($Dilcik AS $Dilim) {?>
										<div class="col-lg">
										<h6><?=$Dilim["dil_baslik"];?></h6>  
											<div class="form-group"> 
												<input class="form-control <?php if($a == 0){ echo "Sabit";}else{ echo "Tekrar";} ?> " name="adi[<?=$Dilim["dil_kod"]?>][<?=$k?>]" value="TEXT_" placeholder="adı" type="text">
											</div>
											<div class="form-group"> 
												<input class="form-control <?php if($a == 0){ echo "Sabit2";}else{ echo "Tekrar2";} ?>" name="anahtar[<?=$Dilim["dil_kod"]?>][<?=$k?>]" value="#" placeholder="anahtar" type="text">
											</div> 
											<div class="form-group"> 
												<input class="form-control" name="deger[<?=$Dilim["dil_kod"]?>][<?=$k?>]" value="" placeholder="deger" type="text">
											</div>  
										</div>
									<?php $a++; }  $k++;?> 
									</div>
									<div class="pull-right">
										<button class="btn btn-rounded btn-danger" type="submit">Kaydet</button>
										<input type="hidden" name="submitControl" value="1" />
									</div>
								</form>
                            </div>
                        </div>
					</div>
<?php 
				}
?>
<?php 
			}else if($do == 'default') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE dil_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {  
						$update = $db->exec("UPDATE ".TABLE." SET dil_varsayilan = 2");
						$update = $db->exec("UPDATE ".TABLE." SET dil_varsayilan = {$type} WHERE dil_id = {$id};");
						if($update) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde varsayılan olarak değiştirildi."); 	 
						}else{
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						} 
				} 
?>
<?php 
			}else if($do == 'status') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE dil_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					if($type == 1){
						$update = $db->exec("UPDATE ".TABLE." SET dil_durum = 2 WHERE dil_id = {$id};");
						if($update) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde pasif olarak değiştirildi."); 	 
						}else{
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					}else if($type == 2){
						$update = $db->exec("UPDATE ".TABLE." SET dil_durum = 1 WHERE dil_id = {$id};");
						if($update) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde aktif olarak değiştirildi."); 	 
						}else{
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						} 
					}
				} 
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
	<script src="vendor\chart.js\Chart.bundle.min.js"></script>
    <script src="js\custom.min.js"></script>
	<script src="js\deznav-init.js"></script>
	<script src="vendor\owl-carousel\owl.carousel.js"></script>
    <script src="vendor\peity\jquery.peity.min.js"></script>
	<script src="js\dashboard\dashboard-1.js"></script>
	
	
	
<?php 
		if($do == 'words' || $do == 'add') {
?>

	 <style type="text/css"> 
	   table input{
			font-size:14px;
			padding:5px 0px;
			display:block;
			width:100%;
			color: #03a9f4;
			cursor:pointer; 
			border: unset!important;
			background: transparent;
			text-decoration: underline;
			text-decoration-color: #40189d;
			text-decoration-style: dashed;
		} 
		table input:focus{
			outline: none;
			border-bottom: 1px dashed #40189d;
			text-decoration: none;
		}
		table tr {
			box-shadow: none;
		}
	</style>
	<script type="text/javascript">  
		$(document).ready(function() {
			// Setup - add a text input to each footer cell
			$('#example5 tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="'+title+' Ara" />' );
			} );
		 
			// DataTable
			var table = $('#example5').DataTable({
				pageLength: 12,
			});
		  
			// Apply the search
			table.columns().every( function () {
				var that = this;
		 
				$( 'input', this.footer() ).on( 'keyup change clear', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			} );
		} );
	</script>
	<script type="text/javascript"> 
		$(function() { 
		  $('.Sabit').on('change keyup', function() {
			var myVal, newVal = $.makeArray($('.Sabit').map(function(){
				if (myVal = $(this).val()) {
					return(myVal);
				}
			})).join(', ');
			$('.Tekrar').val(newVal);  
		  });
		 
		});
		$(function() {
		  $('.Sabit2').on('change keyup', function() {
			var myVal, newVal = $.makeArray($('.Sabit2').map(function(){
				if (myVal = $(this).val()) {
					return(myVal);
				}
			})).join(', ');
			$('.Tekrar2').val(newVal);  
		  });
		 
		});
	</script>
	<script type="text/javascript">  
		function saveData(event,key){
			var value = $('#'+event.target.id).val();
			$.post("guncelle.php",{
				key: key,
				value: value
			}, 
			function(response,status){  
				if (response == 1){
					toastr.success("Başarı ile düzenlendi", "Başarılı", {
						timeOut: 500000000,
						closeButton: !0,
						debug: !1,
						newestOnTop: !0,
						progressBar: !0,
						positionClass: "toast-top-right",
						preventDuplicates: !0,
						onclick: null,
						showDuration: "300",
						hideDuration: "1000",
						extendedTimeOut: "1000",
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut",
						tapToDismiss: !1
					}); 	
				}else if (response == 2){
					toastr.warning("Düzenlenirken hata oluştu!", "Hata", {
						timeOut: 500000000,
						closeButton: !0,
						debug: !1,
						newestOnTop: !0,
						progressBar: !0,
						positionClass: "toast-top-right",
						preventDuplicates: !0,
						onclick: null,
						showDuration: "300",
						hideDuration: "1000",
						extendedTimeOut: "1000",
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut",
						tapToDismiss: !1
					});
				}else if (response == 3){
					toastr.warning("Bilgilerde düzenlenecek herhangi bir değişiklik bulunamadı!", "Uyarı", {
						timeOut: 500000000,
						closeButton: !0,
						debug: !1,
						newestOnTop: !0,
						progressBar: !0,
						positionClass: "toast-top-right",
						preventDuplicates: !0,
						onclick: null,
						showDuration: "300",
						hideDuration: "1000",
						extendedTimeOut: "1000",
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut",
						tapToDismiss: !1
					});
				} 	
			}
			); 
		} 
	</script>
<?php 
		}
?>

    <!-- Toastr -->
    <script src="vendor\toastr\js\toastr.min.js"></script>

    <!-- All init script -->
    <script src="js\plugins-init\toastr-init.js"></script>
</body>
</html>