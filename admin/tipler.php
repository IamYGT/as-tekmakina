<?php require("../include/baglan.php");include("../include/fonksiyon.php"); 
		if(!isset($_SESSION['LOGIN']) && !in_array(array('login'))) {
			go("index.php",0);  
			exit();
		}
		define('TABLE',"arac_tip");
		define('AREA',"tipler");		
		if(!isset($do)) $do = null; 
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
	<!-- Form step -->
    <link href="vendor\jquery-steps-master\dist\jquery-steps.css" rel="stylesheet">
	<!-- Vectormap -->
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
    <link href="vendor\bootstrap-select\dist\css\bootstrap-select.min.css" rel="stylesheet">
		<link href="vendor/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="vendor\owl-carousel\owl.carousel.css" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fa27a1c3e4.js" crossorigin="anonymous"></script> 
	<link href="vendor/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
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
			if($do == 'yil') { 
			$sayfa = (isset($q) ? $q : 1);
				$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM ".TABLE." WHERE yil = {$yil_id} ")->fetchColumn();
				$limit = 10;
				$sonSayfa = ceil($toplam_veri_sayisi/$limit);
				$baslangic = ($sayfa-1)*$limit;
?>
					<div id="sortable_sonuc" class="col-lg-12"></div>
					<div style="margin-bottom: 15px;" class="col-xl-12">
						<a href="<?php echo AREA; ?>?do=add&yil&yil_id=<?php echo $yil_id ?>"><button style="float: right;"  type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni</button></a>
					</div>
					<div class="col-xl-12"> 
						<div class="table-responsive"> 
							<div id="example5_wrapper" class="dataTables_wrapper no-footer">
								<table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5" role="grid" aria-describedby="example5_info">
									<thead>
										<tr role="row"> 
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 1%;">Sıra</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 19%">Marka</th>  
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 20%">Model</th>  
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 30%">Yıl</th>  
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 50%">Motor</th>  
										<th class="sorting_asc" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Contact: activate to sort column descending" style="width: 10%" aria-sort="ascending"></th>
									</thead>
									<tbody id="sortable"> 
<?php
									$list = $db->query("SELECT * FROM ".TABLE." WHERE yil = {$yil_id} ORDER BY yil ASC LIMIT $baslangic,$limit "); 
										if ($list->rowCount()){
											foreach($list as $row){ 
											$year_info = $db->query("SELECT * FROM arac_yil WHERE yil_id = {$row["yil"]}")->fetch(PDO::FETCH_ASSOC);
											$model_info = $db->query("SELECT * FROM arac_model WHERE model_id = {$year_info["model_id"]}")->fetch(PDO::FETCH_ASSOC);
											$marka_info = $db->query("SELECT * FROM arac_marka WHERE marka_id = {$model_info["marka_id"]}")->fetch(PDO::FETCH_ASSOC);
?>
										<tr id="item-<?php echo $row["arac_id"]; ?>" role="row" class="even"> 
											<td class="sortable ui-sortable-handle" style="width:20px"><i class="fa fa-sort"></i></td>
											<td class=""><?php echo $marka_info["marka"]; ?></td>
											<td class=""><?php echo $model_info["model"]; ?></td>
											<td class=""><?php echo $year_info["yil"]; ?></td>
											<td class=""><?php echo $row["arac"]; ?></td>
											<td class="sorting_1">
												<div class="d-flex">
													<a class="contact-icon mr-3" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["arac_id"]; ?>&yil&yil_id=<?php echo $yil_id ?>"><i class="fas fa-edit" aria-hidden="true"></i></a>
													<a class="contact-icon" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["arac_id"]; ?>&yil&yil_id=<?php echo $yil_id ?>"><i class="fas fa-trash-alt"></i></a>
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
										$x = 5; 
										if($sayfa > 1){	
											$onceki = $sayfa-1;	
											echo '<a href="?do=yil&yil_id='.$yil_id.'&q='.$onceki.'" class="paginate_button previous disabled">Geri</a>';
										}	
										if($sayfa==1){
											echo '<span><a class="paginate_button current" >1</a></span>';
										} else {
											echo '<span><a href="?do=yil&yil_id='.$yil_id.'&q=1" class="paginate_button previous">1</a></span>';
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
												echo '<span><a href="?do=yil&yil_id='.$yil_id.'&q='.$i.'" class="paginate_button previous">'.$i.'</a></span>';
											}
											if($i==$sonSayfa) break;  
										}		
										if($sayfa < $sonSayfa){	  
											$sonraki = $sayfa+1;   
											echo '<a href="?do=yil&yil_id='.$yil_id.'&q='.$sonraki.'" class="paginate_button next disabled">İleri</a>';		  
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
					if(!empty($_POST['arac'])) {  
							$insert = $db->prepare("INSERT INTO ".TABLE." SET yil = ?, arac = ?, link = ?, oguc = ?, yguc = ?, gfark = ?, gyuz = ?, otork = ?, ytork = ?, tfark = ?, tyuz = ?, ytas = ?, yakit = ?, tip_durum = ?");
							$insert->execute(array($yil_id, $arac, Seo_Link_Cevir($arac), $oguc, $yguc, $gfark, $gyuz, $otork, $ytork, $tfark, $tyuz, $ytas, $yakit, $tip_durum));
							$last_id = $db->lastInsertId(); 
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$last_id.'&yil&yil_id='.$yil_id.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
						}else {
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					}else{  
						$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
					}
				} else {
?>
				<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: contents; "> 
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Motor Ekle</h4>
                            </div>
                            <div class="card-body">  
								<div class="form-group">
									<label for="name">Başlık</label>
									<input type="text" class="form-control" required="" name="arac" id="editname" />
								</div>
								<div class="row"> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="oguc">Eski HP</label>
											<input type="text" class="form-control" name="oguc" id="oguc" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="yguc">Yeni HP</label>
											<input type="text" class="form-control" name="yguc" id="yguc" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="gfark">HP Fark</label>
											<input type="text" class="form-control" name="gfark" id="gfark" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="gyuz">HP Yüzde Fark</label>
											<input type="text" class="form-control" name="gyuz" id="gyuz" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="otork">Eski Tork</label>
											<input type="text" class="form-control" name="otork" id="otork" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="ytork">Yeni Tork</label>
											<input type="text" class="form-control" name="ytork" id="ytork" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="tfark">Tork Farkı</label>
											<input type="text" class="form-control" name="tfark" id="tfark" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="tyuz">Tork Yüzde Fark</label>
											<input type="text" class="form-control" name="tyuz" id="tyuz" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="ytas">Yakıt Tasarrufu</label>
											<input type="text" class="form-control" name="ytas" id="ytas" />
										</div>
									</div>  
								</div>
								<div class="step-footer pull-right">
									<button type="submit" name="submitControl" value="1" class="step-btn1 btn mr-6 btn-primary">Kaydet</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3">  	
								<div class="form-group"> 
									<label for="">Yakıt Tipi</label>
									<select name="yakit" class="form-control">
										<option value="1">Benzin</option>
										<option value="2">Dizel</option> 
									</select>
								</div> 
								<div class="form-group"> 
									<label for="">Yayın Durumu</label>
									<select name="tip_durum" class="form-control">
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
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE arac_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					if(isset($submitControl)){
						if(!empty($_POST['arac'])) {  
							$update = $db->prepare("UPDATE ".TABLE." SET yil = ?, arac = ?, link = ?, oguc = ?, yguc = ?, gfark = ?, gyuz = ?, otork = ?, ytork = ?, tfark = ?, tyuz = ?, ytas = ?, yakit = ?, tip_durum = ? WHERE arac_id = ?");
							$update->execute(array($yil_id, $arac, Seo_Link_Cevir($arac), $oguc, $yguc, $gfark, $gyuz, $otork, $ytork, $tfark, $tyuz, $ytas, $yakit, $tip_durum, $id)); 
							if ($update) {
								echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$id.'&yil&yil_id='.$yil_id.'">';
								$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");   	
							}else {
								$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
							}
						}else{  
							$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız."); 
						}
					} else {
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE arac_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>

			<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: contents; "> 
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Motor Düzenle</h4>
                            </div>
                            <div class="card-body">  
								<div class="form-group">
									<label for="name">Başlık</label>
									<input type="text" class="form-control" required="" name="arac" value="<?php echo $row_info["arac"] ?>" />
								</div>
								<div class="row">  
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="oguc">Eski HP</label>
											<input type="text" class="form-control" name="oguc" id="oguc" value="<?php echo $row_info["oguc"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="yguc">Yeni HP</label>
											<input type="text" class="form-control" name="yguc" id="yguc" value="<?php echo $row_info["yguc"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="gfark">HP Fark</label>
											<input type="text" class="form-control" name="gfark" id="gfark" value="<?php echo $row_info["gfark"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="gyuz">HP Yüzde Fark</label>
											<input type="text" class="form-control" name="gyuz" id="gyuz" value="<?php echo $row_info["gyuz"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="otork">Eski Tork</label>
											<input type="text" class="form-control" name="otork" id="otork" value="<?php echo $row_info["otork"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="ytork">Yeni Tork</label>
											<input type="text" class="form-control" name="ytork" id="ytork" value="<?php echo $row_info["ytork"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="tfark">Tork Farkı</label>
											<input type="text" class="form-control" name="tfark" id="tfark" value="<?php echo $row_info["tfark"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="tyuz">Tork Yüzde Fark</label>
											<input type="text" class="form-control" name="tyuz" id="tyuz" value="<?php echo $row_info["tyuz"] ?>" />
										</div>
									</div> 
									<div class="col-lg-6"> 
										<div class="form-group">
											<label for="ytas">Yakıt Tasarrufu</label>
											<input type="text" class="form-control" name="ytas" id="ytas" value="<?php echo $row_info["ytas"] ?>" />
										</div>
									</div>  
								</div>
								<div class="step-footer pull-right">
									<button type="submit" name="submitControl" value="1" class="step-btn1 btn mr-6 btn-primary">Kaydet</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3">  	
								<div class="form-group"> 
									<label for="">Yakıt Tipi</label>
									<select name="yakit" class="form-control">
										<option value="1" <?php if ($row_info["yakit"] == "1") { echo "selected";}?>>Benzin</option>
										<option value="2" <?php if ($row_info["yakit"] == "2") { echo "selected";}?>>Dizel</option> 
									</select>
								</div> 
								<div class="form-group"> 
									<label for="">Yayın Durumu</label>
									<select name="tip_durum" class="form-control">
										<option value="1" <?php if ($row_info["tip_durum"] == "1") { echo "selected";}?>>Aktif</option>
										<option value="2" <?php if ($row_info["tip_durum"] == "2") { echo "selected";}?>>Pasif</option> 
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
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE arac_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					$update = $db->exec("DELETE FROM ".TABLE." WHERE arac_id = {$id};");
					if($update) {
						echo '<meta http-equiv="refresh" content="1;url='.AREA.'&yil&yil_id='.$yil_id.'">';
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
		
	
	<!-- Chart piety plugin files -->
    <script src="vendor\peity\jquery.peity.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="js\dashboard\dashboard-1.js"></script>
	
	
	<script src="vendor\jquery-steps-master\dist\jquery-steps.min.js"></script>
   <script>
    $('#demo').steps({
      onFinish: function (event, currentIndex) {
		  
				jQuery(function ($) {
				
				 var form = $(this);
				 $( "#form" ).submit();
				 $("#form")[0].submit();
				}); 
			
			
        
      }
    });
  </script> 
	
	<script src="vendor/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
	
	<script language="javascript" type="text/javascript">
		CKEDITOR.replace('ckeditor');
    </script>	
	<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css">
	<script type="text/javascript" src="vendor/jquery-ui/jquery-ui.js"></script>
	<script language="javascript" type="text/javascript">
	$(function() {
		$( "#sortable" ).sortable({
			revert: true,
			handle: ".sortable",
			stop: function (event, ui) {
				var data = $(this).sortable('serialize'); 
				$.ajax({
					type: "POST",
					dataType: "json",
					data: data,
					url: "/include/ajax.php?do=cars&action=row",
					success: function(msg){ 
						$("#sortable_sonuc").html(msg.islemMsj);
						setTimeout(function(){
							$("#sortable_sonuc").html("");
						},2000);
					}
				});
			}
		});
		$( "#sortable" ).disableSelection();
	});
	</script>	
</body>
</html>