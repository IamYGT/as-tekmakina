﻿<?php require("../include/baglan.php");include("../include/fonksiyon.php");
		if(!isset($_SESSION['LOGIN']) ) {
			go("index.php",0);
			exit();
		}
		define('TABLE',"hizmetler");
		define('AREA',"hizmetler");
		if(!isset($do)) $do = null;
		$sayfa = (isset($q) ? $q : 1);
		$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM ".TABLE." WHERE dil_id = '".LANGUAGE_DEFAULT."' ")->fetchColumn();
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
			if($do == '') {
?>
					<div id="sortable_sonuc" class="col-lg-12"></div>
					<div style="margin-bottom: 15px;" class="col-xl-12">
						<a href="<?php echo AREA; ?>?do=add"><button style="float: right;"  type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni</button></a>
					</div>
					<div class="col-xl-12">
						<div class="table-responsive">
							<div id="example5_wrapper" class="dataTables_wrapper no-footer">
								<table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5" role="grid" aria-describedby="example5_info">
									<thead>
										<tr role="row">
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 1%;">Sıra</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 115.6px;">Başlık</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Resim 1160x600</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Postition: activate to sort column ascending" style="width: 82px;">Tarih</th>
										<th class="sorting_asc" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Contact: activate to sort column descending" style="width: 1%;" aria-sort="ascending"></th>
									</thead>
									<tbody id="sortable">
<?php
									$list = $db->query("SELECT h.*, 
													   GROUP_CONCAT(DISTINCT h2.dil_id) as diller,
													   GROUP_CONCAT(DISTINCT h2.haber_baslik ORDER BY h2.dil_id SEPARATOR '|||') as basliklar
													    FROM hizmetler h 
													    LEFT JOIN hizmetler h2 ON h.haber_ust_id = h2.haber_ust_id 
													    WHERE h.dil_id = 'tr' 
													    GROUP BY h.haber_ust_id 
													    ORDER BY h.row ASC 
													    LIMIT $baslangic,$limit");
										if ($list->rowCount()){
											foreach($list as $row){
?>
										<tr id="item-<?php echo $row["haber_ust_id"]; ?>" role="row" class="even">
											<td class="sortable ui-sortable-handle" style="width:20px"><i class="fa fa-sort"></i></td>
											<td class=""><?php echo $row["haber_baslik"]; ?></td>
											<td class=""><?php if(isset($row["haber_resim"])){ ?><img class="mr-3 " width="60" src="../uploads/services/<?php echo $row["haber_resim"]; ?>" alt="<?php echo $row["haber_baslik"]; ?>"><?php }else{ ?><img class="mr-3 " width="60" src="images/no_images.png" alt="<?php echo $row["haber_baslik"]; ?>"><?php } ?></td>
											<td class=""><?php echo $row["haber_tarih"]; ?></td>
											<td class="sorting_1">
												<div class="d-flex">
													<a class="contact-icon mr-3" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["haber_ust_id"]; ?>"><i class="fas fa-edit" aria-hidden="true"></i></a>
													<a class="contact-icon" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["haber_ust_id"]; ?>"><i class="fas fa-trash-alt"></i></a>
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
					if(!empty($_POST['haber_baslik']) || !empty($_POST['haber_aciklama'])) {
						$LastID = $db->query("SELECT haber_id FROM ".TABLE." ORDER BY haber_id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
						$LastID = $LastID["haber_id"]+1;
						
						// Ana resim
						$upload = new Upload($_FILES['haber_resim']);
						if ($upload->uploaded) {
							$upload->file_auto_rename = true;
							$upload->process("../uploads/services");
							if ($upload->processed) {
								$haber_resim = $upload->file_dst_name;
							}
						}
						
						// İkinci resim
						$upload2 = new Upload($_FILES['haber_resim2']);
						if ($upload2->uploaded) {
							$upload2->file_auto_rename = true;
							$upload2->process("../uploads/services");
							if ($upload2->processed) {
								$haber_resim2 = $upload2->file_dst_name;
							}
						}
						
						// Üçüncü resim
						$upload3 = new Upload($_FILES['haber_resim3']);
						if ($upload3->uploaded) {
							$upload3->file_auto_rename = true;
							$upload3->process("../uploads/services");
							if ($upload3->processed) {
								$haber_resim3 = $upload3->file_dst_name;
							}
						}

						foreach ($_POST AS $k=>$v) {
							$v = $v;
							if (substr($k,0,5) == "form_") {
								$key = str_replace("form_","",$k);
								$insert = $db->prepare("INSERT INTO ".TABLE." SET 
									haber_baslik = ?, 
									haber_seo = ?, 
									haber_aciklama = ?, 
									haber_description = ?, 
									haber_kisaaciklama = ?,  
									haber_resim = ?, 
									haber_resim2 = ?, 
									haber_resim3 = ?, 
									dil_id = ?, 
									haber_durum = ?, 
									haber_ust_id = ?");
								
								$insert->execute(array(
									$haber_baslik[$key], 
									Seo_Link_Cevir($haber_baslik[$key]), 
									$haber_aciklama[$key], 
									$haber_description[$key], 
									$haber_kisaaciklama[$key], 
									$haber_resim,
									$haber_resim2,
									$haber_resim3,
									$key, 
									$haber_durum, 
									$LastID
								));
							}
						}
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$LastID.'">';
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
                                <h4 class="card-title">Hizmet Ekle</h4>
                            </div>
                            <div class="card-body">
								<div class="step-app" id="demo">
									<ul class="step-steps">
<?php
							$list = $db->query("select * from dil where dil_durum = '1'");
								foreach ($list AS $row) {
									$LANGUAGE_ID = $row["dil_id"];
									$LANGUAGE_CODE = $row["dil_kod"];
									$LANGUAGE_TITLE = $row["dil_baslik"];
?>
									  <li data-step-target="step<?php echo $LANGUAGE_ID; ?>"><?php echo $LANGUAGE_TITLE; ?></li>
<?php
								}
?>
									</ul>
									<div class="step-content">
<?php
										$list = $db->query("select * from dil where dil_durum = '1'");
											foreach ($list AS $row) {
												$LANGUAGE_ID = $row["dil_id"];
												$LANGUAGE_CODE = $row["dil_kod"];
												$LANGUAGE_TITLE = $row["dil_baslik"];
?>
												<div class="step-tab-panel" data-step="step<?php echo $LANGUAGE_ID; ?>">
													<div class="row">
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Başlık</label>
																<input type="text" name="haber_baslik[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Başlık" required="">
															</div>
														</div>


														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Açıklama</label>
																<textarea class="form-control ckeditor" name="haber_aciklama[<?php echo $LANGUAGE_CODE; ?>]"></textarea>
															</div>
														</div>
													</div>
													<input type="hidden" name="form_<?php echo $LANGUAGE_CODE; ?>" value="<?php echo $LANGUAGE_CODE; ?>" />
												</div>
<?php
											}
?>
									</div>
									    <div class="step-footer pull-right">
											<button data-step-action="prev" class="step-btn1 btn btn-rounded btn-light">Geri</button>
											<button data-step-action="next" class="step-btn1 btn btn-rounded btn-primary">İleri</button>
											<button data-step-action="finish" class="step-btn1 btn btn-rounded btn-danger" type="submit">Kaydet</button>
											<input type="hidden" name="submitControl" value="1" />
										</div>
								</div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3">
								<div class="form-group mb-4">
									<label>Ana Resim (1160x600)</label>
									<small class="form-text text-muted">Ana görsel olarak kullanılacak resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
											<img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">
										</div>
										<div>
											<span class="btn btn-primary btn-sm btn-file">
												<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
												<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
												<input type="file" name="haber_resim" accept="image/*" id="haber_resim">
											</span>
											<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
										</div>
									</div>
								</div>

								<!-- Ek Resim 2 -->
								<div class="form-group mb-4">
									<label>Ek Resim 1 (570x380) <small class="text-muted">(Opsiyonel)</small></label>
									<small class="form-text text-muted">Sol alt bölümde gösterilecek ek resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
											<img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">
										</div>
										<div>
											<span class="btn btn-primary btn-sm btn-file">
												<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
												<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
												<input type="file" name="haber_resim2" accept="image/*" id="haber_resim2">
											</span>
											<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
										</div>
									</div>
								</div>

								<!-- Ek Resim 3 -->
								<div class="form-group mb-4">
									<label>Ek Resim 2 (570x380) <small class="text-muted">(Opsiyonel)</small></label>
									<small class="form-text text-muted">Sağ alt bölümde gösterilecek ek resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
											<img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">
										</div>
										<div>
											<span class="btn btn-primary btn-sm btn-file">
												<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
												<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
												<input type="file" name="haber_resim3" accept="image/*" id="haber_resim3">
											</span>
											<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
										</div>
									</div>
								</div>

								<!-- Yayın Durumu -->
								<div class="form-group">
									<label for="">Yayın Durumu</label>
									<select name="haber_durum" class="form-control">
										<option value="1" selected>Aktif</option>
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
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE haber_ust_id = ?");
				$row_check->execute(array($id));
				if ($row_check->rowCount() > 0) {
					if(isset($submitControl)){
						if(!empty($_POST['haber_baslik']) || !empty($_POST['haber_aciklama'])) {
							$image_info = $db->query("SELECT * FROM ".TABLE." WHERE haber_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
							
							// Ana resim
							$upload = new Upload($_FILES['haber_resim']);
							if(!isset($_FILES['haber_resim']['name'])) {
								$haber_resim = null;
							} else if(!empty($_FILES['haber_resim']['name'])) {
								$upload->file_auto_rename = true;
								$upload->process("../uploads/services");
								if ($upload->processed) {
									$haber_resim = $upload->file_dst_name;
								} else {
									$haber_resim = null;
								}
							} else {
								$haber_resim = $image_info["haber_resim"];
							}
							
							// İkinci resim
							$upload2 = new Upload($_FILES['haber_resim2']);
							if(!isset($_FILES['haber_resim2']['name'])) {
								$haber_resim2 = null;
							} else if(!empty($_FILES['haber_resim2']['name'])) {
								$upload2->file_auto_rename = true;
								$upload2->process("../uploads/services");
								if ($upload2->processed) {
									$haber_resim2 = $upload2->file_dst_name;
								} else {
									$haber_resim2 = null;
								}
							} else {
								$haber_resim2 = $image_info["haber_resim2"];
							}
							
							// Üçüncü resim
							$upload3 = new Upload($_FILES['haber_resim3']);
							if(!isset($_FILES['haber_resim3']['name'])) {
								$haber_resim3 = null;
							} else if(!empty($_FILES['haber_resim3']['name'])) {
								$upload3->file_auto_rename = true;
								$upload3->process("../uploads/services");
								if ($upload3->processed) {
									$haber_resim3 = $upload3->file_dst_name;
								} else {
									$haber_resim3 = null;
								}
							} else {
								$haber_resim3 = $image_info["haber_resim3"];
							}

							foreach ($_POST AS $k=>$v) {
								$v = $v;
								if (substr($k,0,5) == "form_") {
									$key = str_replace("form_","",$k);
									
									$update = $db->prepare("UPDATE ".TABLE." SET  
										haber_baslik = ?, 
										haber_seo = ?, 
										haber_aciklama = ?, 
										haber_description = ?, 
										haber_kisaaciklama = ?,  
										haber_resim = ?, 
										haber_resim2 = ?, 
										haber_resim3 = ?, 
										haber_durum = ? 
										WHERE haber_ust_id = ? AND dil_id = ?");
									
									$update->execute(array(
										$haber_baslik[$key], 
										Seo_Link_Cevir($haber_baslik[$key]), 
										$haber_aciklama[$key],  
										$haber_description[$key], 
										$haber_kisaaciklama[$key],  
										$haber_resim,
										$haber_resim2,
										$haber_resim3,
										$haber_durum, 
										$id, 
										$key
									));
								}
							}
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
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE haber_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>

				<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; ">
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Hizmet Düzenle</h4>
                            </div>
                            <div class="card-body">
								<div class="step-app" id="demo">
									<ul class="step-steps">
<?php
							$list = $db->query("select * from dil where dil_durum = '1'");
								foreach ($list AS $row) {
									$LANGUAGE_ID = $row["dil_id"];
									$LANGUAGE_CODE = $row["dil_kod"];
									$LANGUAGE_TITLE = $row["dil_baslik"];
?>
									  <li data-step-target="step<?php echo $LANGUAGE_ID; ?>"><?php echo $LANGUAGE_TITLE; ?></li>
<?php
								}
?>
									</ul>
									<div class="step-content">
<?php
										$list = $db->query("select * from dil where dil_durum = '1'");
											foreach ($list AS $row) {
												$LANGUAGE_ID = $row["dil_id"];
												$LANGUAGE_CODE = $row["dil_kod"];
												$LANGUAGE_TITLE = $row["dil_baslik"];
?>
												<div class="step-tab-panel" data-step="step<?php echo $LANGUAGE_ID; ?>">
													<div class="row">
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Başlık</label>
																<input type="text" name="haber_baslik[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Başlık" required="" value="<?php echo GetTableValue("haber_baslik",TABLE,"where haber_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
															</div>
														</div>
												 
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Açıklama</label>
																<textarea class="form-control ckeditor" name="haber_aciklama[<?php echo $LANGUAGE_CODE; ?>]"><?php echo GetTableValue("haber_aciklama",TABLE,"where haber_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?></textarea>
															</div>
														</div>
													</div>
													<input type="hidden" name="form_<?php echo $LANGUAGE_CODE; ?>" value="<?php echo $LANGUAGE_CODE; ?>" />
												</div>
<?php
											}
?>
									</div>
									    <div class="step-footer pull-right">
											<button data-step-action="prev" class="step-btn1 btn btn-rounded btn-primary">Geri</button>
											<button data-step-action="next" class="step-btn1 btn btn-rounded btn-primary">İleri</button>
											<button data-step-action="finish" class="step-btn1 btn btn-rounded btn-primary" type="submit">Kaydet</button>
											<input type="hidden" name="submitControl" value="1" />
										</div>
								</div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-4 col-xxl-4">
                        <div class="card">
                            <div class="card-body p-3">
								<div class="form-group mb-4">
									<label>Ana Resim (1160x600)</label>
									<small class="form-text text-muted">Ana görsel olarak kullanılacak resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<?php if(!empty($row_info["haber_resim"])) { ?>
											<div class="fileinput-preview img-thumbnail" style="max-width: 300px;">
												<img src="../uploads/services/<?php echo $row_info["haber_resim"]; ?>" class="img-fluid">
											</div>
										<?php } ?>
										<div class="mt-2">
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Resim Seç</span>
												<span class="fileinput-exists">Değiştir</span>
												<input type="file" name="haber_resim">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Kaldır</a>
										</div>
									</div>
								</div>

								<!-- Ek Resim 2 -->
								<div class="form-group mb-4">
									<label>Ek Resim 1 (570x380)</label>
									<small class="form-text text-muted">Sol alt bölümde gösterilecek ek resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<?php if(!empty($row_info["haber_resim2"])) { ?>
											<div class="fileinput-preview img-thumbnail" style="max-width: 300px;">
												<img src="../uploads/services/<?php echo $row_info["haber_resim2"]; ?>" class="img-fluid">
											</div>
										<?php } ?>
										<div class="mt-2">
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Resim Seç</span>
												<span class="fileinput-exists">Değiştir</span>
												<input type="file" name="haber_resim2">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Kaldır</a>
										</div>
									</div>
								</div>

								<!-- Ek Resim 3 -->
								<div class="form-group mb-4">
									<label>Ek Resim 2 (570x380)</label>
									<small class="form-text text-muted">Sağ alt bölümde gösterilecek ek resim.</small>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<?php if(!empty($row_info["haber_resim3"])) { ?>
											<div class="fileinput-preview img-thumbnail" style="max-width: 300px;">
												<img src="../uploads/services/<?php echo $row_info["haber_resim3"]; ?>" class="img-fluid">
											</div>
										<?php } ?>
										<div class="mt-2">
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Resim Seç</span>
												<span class="fileinput-exists">Değiştir</span>
												<input type="file" name="haber_resim3">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Kaldır</a>
										</div>
									</div>
								</div>

								<!-- Yayın Durumu -->
								<div class="form-group">
									<label for="">Yayın Durumu</label>
									<select name="haber_durum" class="form-control">
										<option value="1" <?php echo ($row_info["haber_durum"] == 1) ? 'selected' : ''; ?>>Aktif</option>
										<option value="2" <?php echo ($row_info["haber_durum"] == 2) ? 'selected' : ''; ?>>Pasif</option>
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
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE haber_ust_id = ?");
				$row_check->execute(array($id));
				if ($row_check->rowCount() > 0) {
					$update = $db->exec("DELETE FROM ".TABLE." WHERE haber_ust_id = {$id};");
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
					url: "/include/ajax.php?do=news&action=row",
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
