<?php require("../include/baglan.php");include("../include/fonksiyon.php");
		if(!isset($_SESSION['LOGIN'])) {
			go("index.php",0);
			exit();
		}
		define('TABLE',"haberler");
		define('AREA',"haberler");
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
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Resim 870x510</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Postition: activate to sort column ascending" style="width: 82px;">Tarih</th>
										<th class="sorting_asc" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Contact: activate to sort column descending" style="width: 1%;" aria-sort="ascending"></th>
									</thead>
									<tbody id="sortable">
<?php
									$list = $db->query("SELECT h.*, 
    GROUP_CONCAT(DISTINCT h2.dil_id) as diller,
    GROUP_CONCAT(DISTINCT h2.haber_baslik ORDER BY h2.dil_id SEPARATOR '|||') as basliklar
    FROM ".TABLE." h 
    LEFT JOIN ".TABLE." h2 ON h.haber_ust_id = h2.haber_ust_id 
    WHERE h.dil_id = 'tr'
    GROUP BY h.haber_ust_id 
    ORDER BY h.row ASC, h.haber_id DESC 
    LIMIT $baslangic,$limit");

									// Debug için
									error_log("Haber admin sorgusu sonucu: " . $list->rowCount() . " kayıt bulundu");

										if ($list->rowCount()){
											foreach($list as $row){
?>
										<tr id="item-<?php echo $row["haber_ust_id"]; ?>" role="row" class="even">
											<td class="sortable" style="width:20px">
												<i class="fa fa-sort"></i>
											</td>
											<td>
												<?php echo $row["haber_baslik"]; ?>
												<div class="mt-1">
													<?php
													foreach($db->query("SELECT * FROM dil WHERE dil_durum = 1") as $dil) {
														if(in_array($dil["dil_kod"], explode(',', $row["diller"]))) {
															echo '<span class="badge badge-success mr-1">'.$dil["dil_kod"].'</span>';
														} else {
															echo '<span class="badge badge-danger mr-1">'.$dil["dil_kod"].'</span>';
														}
													}
													?>
												</div>
											</td>
											<td>
												<?php if($row["haber_resim"]) { ?>
													<img src="../uploads/haberler/<?php echo $row["haber_resim"]; ?>" width="50" alt="">
												<?php } else { ?>
													<img src="images/no-image.jpg" width="50" alt="">
												<?php } ?>
											</td>
											<td><?php echo $row["haber_tarih"]; ?></td>
											<td>
												<div class="d-flex">
													<a class="btn btn-primary btn-sm mr-2" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["haber_ust_id"]; ?>">
														<i class="fa fa-edit"></i>
													</a>
													<a class="btn btn-danger btn-sm" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["haber_ust_id"]; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">
														<i class="fa fa-trash"></i>
													</a>
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
						$upload = new Upload($_FILES['haber_resim']);
						if ($upload->uploaded) {
								$upload->file_auto_rename = true;
								$upload->process("../uploads/haberler");
							if ($upload->processed){
								$haber_resim = $upload->file_dst_name;
							} else {
								$error = Bilgilendirme::Hata("Hay Aksi! Bir hata meydana geldi.".$upload->error);
							}
						}
						foreach ($_POST AS $k=>$v) {
							$v = $v;
							if (substr($k,0,5) == "form_") {
								$key = str_replace("form_","",$k);
								$insert = $db->prepare("INSERT INTO ".TABLE." SET haber_baslik = ?, haber_seo = ?, haber_aciklama = ?, haber_description = ?,   haber_kisaaciklama = ?,  haber_resim = ?,  dil_id = ?, haber_durum = ?, haber_ust_id = ?");
								$insert->execute(array($haber_baslik[$key], Seo_Link_Cevir($haber_baslik[$key]), $haber_aciklama[$key], $haber_description[$key],   $haber_kisaaciklama[$key], $haber_resim,  $key, $haber_durum, $LastID));
								$last_id = $db->lastInsertId();
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
                                <h4 class="card-title">Haber Ekle</h4>
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
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Kısa Açıklama</label>
																<input type="text" name="haber_kisaaciklama[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder=" Kısa Açıklama" required="">
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
								<div class="form-group">
									<label for="">Resim</label>
									<small class="form-text text-muted">Seçmiş olduğunuz resim veri içeriğinde kullanılmaktadır.</small>
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

								<div class="form-group">
									<label for="">Yayın Durumu</label>
									<select name="haber_durum" class="form-control">
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
			} else if($do == 'edit') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE haber_ust_id = ?");
				$row_check->execute(array($id));
				if ($row_check->rowCount() > 0) {
					if(isset($submitControl)){
						if(!empty($_POST['haber_baslik']) || !empty($_POST['haber_aciklama'])) {
							$image_info = $db->query("SELECT * FROM ".TABLE." WHERE haber_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
							
							// Resim yükleme işlemi
							$upload = new Upload($_FILES['haber_resim']);
							if(!isset($_FILES['haber_resim']['name'])) {
								$haber_resim = null;
							} else if(!empty($_FILES['haber_resim']['name'])) {
								$upload->file_auto_rename = true;
								$upload->process("../uploads/haberler");
								if ($upload->processed) {
									$haber_resim = $upload->file_dst_name;
								} else {
									$haber_resim = null;
								}
							} else {
								$haber_resim = $image_info["haber_resim"];
							}

							foreach ($_POST AS $k=>$v) {
								if (substr($k,0,5) == "form_") {
									$key = str_replace("form_","",$k);
									
									// Önce bu dil için kayıt var mı kontrol edelim
									$check = $db->prepare("SELECT * FROM ".TABLE." WHERE haber_ust_id = ? AND dil_id = ?");
									$check->execute([$id, $key]);
									
									if($check->rowCount() > 0) {
										// Güncelleme yapalım
										$update = $db->prepare("UPDATE ".TABLE." SET 
											haber_baslik = ?,
											haber_seo = ?,
											haber_aciklama = ?,
											haber_description = ?,
											haber_kisaaciklama = ?,
											haber_resim = ?,
											haber_durum = ?
											WHERE haber_ust_id = ? AND dil_id = ?");
										
										$update->execute([
											$haber_baslik[$key],
											Seo_Link_Cevir($haber_baslik[$key]),
											$haber_aciklama[$key],
											$haber_description[$key],
											$haber_kisaaciklama[$key],
											$haber_resim,
											$haber_durum,
											$id,
											$key
										]);
									} else {
										// Yeni kayıt ekleyelim
										$insert = $db->prepare("INSERT INTO ".TABLE." SET 
											haber_baslik = ?,
											haber_seo = ?,
											haber_aciklama = ?,
											haber_description = ?,
											haber_kisaaciklama = ?,
											haber_resim = ?,
											dil_id = ?,
											haber_durum = ?,
											haber_ust_id = ?");
										
										$insert->execute([
											$haber_baslik[$key],
											Seo_Link_Cevir($haber_baslik[$key]),
											$haber_aciklama[$key],
											$haber_description[$key],
											$haber_kisaaciklama[$key],
											$haber_resim,
											$key,
											$haber_durum,
											$id
										]);
									}
								}
							}
							
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$id.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde güncellendi");
							
						} else {
							$error = Bilgilendirme::Hata("Boş alan bıraktınız");
						}
					}
					
					// Form için mevcut değerleri çekelim
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE haber_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>
					<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; ">
						<div class="col-xl-8 col-xxl-8">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Haberi Düzenle</h4>
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
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Kısa Açıklama</label>
																<input type="text" name="haber_kisaaciklama[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Kısa Açıklama" required="" value="<?php echo GetTableValue("haber_kisaaciklama",TABLE,"where haber_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
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
									<div class="form-group">
										<label>Resim 870x510</label>
										<small class="form-text text-muted">Seçmiş olduğunuz resim veri içeriğinde kullanılmaktadır.</small>
										<?php if(empty($row_info["haber_resim"])) { ?>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
													<img src="resim-sec.png" class="img-fluid img-thumbnail" alt="">
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
										<?php } else { ?>
											<div class="fileinput fileinput-exists" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" style="width: 100%;height: 190px;line-height: 190px;">
													<img src="../uploads/haberler/<?php echo $row_info["haber_resim"]; ?>" class="img-fluid img-thumbnail" alt="">
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
										<?php } ?>
									</div>
									<div class="form-group">
										<label for="">Yayın Durumu</label>
										<select name="haber_durum" class="form-control">
											<option value="1" <?php if ($row_info["haber_durum"] == "1") { echo "selected";}?>>Aktif</option>
											<option value="2" <?php if ($row_info["haber_durum"] == "2") { echo "selected";}?>>Pasif</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
<?php
				} else {
					$error = Bilgilendirme::Hata("Belirlenen veri bulunamadı");
				}
			} else if($do == 'delete') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE haber_ust_id = ?");
				$row_check->execute(array($id));
				if ($row_check->rowCount() > 0) {
					$update = $db->prepare("DELETE FROM ".TABLE." WHERE haber_ust_id = ?");
					$update->execute(array($id));
					if($update) {
						echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
						$error = Bilgilendirme::Basarili("Başarılı şekilde silindi");
					} else {
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
