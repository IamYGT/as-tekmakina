<?php require("../include/baglan.php");include("../include/fonksiyon.php"); 
if(!isset($_SESSION['LOGIN'])) {
    go("index.php",0);  
    exit();
}
define('TABLE',"galeriler");
define('AREA',"galeriler");
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
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 1%;">Row</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 115;">Title</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Date Applied: activate to sort column ascending" style="width: 115.6px;">Title</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 215.6px;">Resim</th>
										<th class="sorting" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Postition: activate to sort column ascending" style="width: 82px;">Date</th>
										<th class="sorting_asc" tabindex="0" aria-controls="example5" rowspan="1" colspan="1" aria-label="Contact: activate to sort column descending" style="width:1%;" aria-sort="ascending"></th>
									</thead>
									<tbody id="sortable">
<?php
									$list = $db->query("SELECT * FROM ".TABLE." WHERE dil_id = '".LANGUAGE_DEFAULT."' ORDER BY row ASC LIMIT $baslangic,$limit"); 
										if ($list->rowCount()){
											foreach($list as $row){ 
?>
										<tr id="item-<?php echo $row["galeri_ust_id"]; ?>" role="row" class="even"> 
											<td class="sortable ui-sortable-handle" style="width:20px"><i class="fa fa-sort"></i></td>
											<td class=""><?php echo $row["galeri_baslik"]; ?></td>
											<td class=""><?php if(isset($row["galeri_resim"])){ ?><img class="mr-3 " width="60" src="../uploads/gallery/<?php echo $row["galeri_resim"]; ?>" alt="<?php echo $row["galeri_baslik"]; ?>"><?php }else{ ?><img class="mr-3 " width="60" src="images/no_images.png" alt="<?php echo $row["galeri_baslik"]; ?>"><?php } ?></td>
											<td class=""><?php echo $row["galeri_tarih"]; ?></td>
											<td class="sorting_1">
												<div class="d-flex">
													<a class="contact-icon mr-3" href="<?php echo AREA; ?>?do=files&id=<?php echo $row["galeri_ust_id"]; ?>"><i class="fas fa-images" aria-hidden="true"></i></a>
													<a class="contact-icon mr-3" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["galeri_ust_id"]; ?>"><i class="fas fa-edit" aria-hidden="true"></i></a>
													<a class="contact-icon" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["galeri_ust_id"]; ?>"><i class="fas fa-trash-alt"></i></a>
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
				if(isset($submitControl)) {
					if(!empty($_POST['galeri_baslik'])) {
						$LastID = $db->query("SELECT galeri_id FROM ".TABLE." ORDER BY galeri_id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
						$LastID = $LastID["galeri_id"]+1;
						
						$upload = new Upload($_FILES['galeri_resim']);
						if ($upload->uploaded) {
							$upload->file_new_name_body = 'galeri_'.$LastID;
							$upload->image_resize = true;
							$upload->image_ratio_crop = true;
							$upload->image_x = 800;
							$upload->image_y = 600;
							$upload->allowed = array('image/*');
							$upload->process("../uploads/gallery");
							if ($upload->processed) {
								$galeri_resim = $upload->file_dst_name;
							}
						}
						
						foreach ($_POST AS $k=>$v) {
							${$k} = $v;
							if (substr($k,0,5) == "form_") {
								$key = str_replace("form_","",$k);
								$insert = $db->prepare("INSERT INTO ".TABLE." SET galeri_baslik = ?, galeri_seo = ?, galeri_aciklama = ?, galeri_resim = ?, dil_id = ?, galeri_durum = ?, galeri_ust_id = ?");
								$insert->execute(array($galeri_baslik[$key], Seo_Link_Cevir($galeri_baslik[$key]), $galeri_aciklama[$key], $galeri_resim, $key, $galeri_durum, $LastID));
							}
						}
						
						if ($insert) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=edit&id='.$LastID.'">';
							//go(AREA."?do=edit&id=".$LastID,1);
						}
					}
				}
?>
				<!-- Ekleme Formu -->
				<form action="" method="post" enctype="multipart/form-data" id="form">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Yeni Galeri Ekle</h4>
							</div>
							<div class="card-body">
								<!-- Tab Nav -->
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs" role="tablist">
										<?php
											$diller = $db->query("SELECT * FROM dil WHERE dil_durum = '1'");
											foreach ($diller as $d) {
												echo '<li class="nav-item">
														<a class="nav-link '.($d["dil_kod"] == "tr" ? 'active' : '').'" data-bs-toggle="tab" href="#'.$d["dil_kod"].'" role="tab">
															<span><img src="'.$d["dil_flag"].'" width="20"></span>
														</a>
													  </li>';
											}
										?>
									</ul>
									<div class="tab-content">
										<?php
											foreach ($diller as $d) {
										?>
											<div class="tab-pane <?php echo ($d["dil_kod"] == "tr" ? 'active' : ''); ?>" id="<?php echo $d["dil_kod"]; ?>" role="tabpanel">
												<input type="hidden" name="form_<?php echo $d["dil_kod"]; ?>" value="<?php echo $d["dil_kod"]; ?>">
												<div class="form-group">
													<label>Galeri Başlığı</label>
													<input type="text" class="form-control" name="galeri_baslik[<?php echo $d["dil_kod"]; ?>]">
												</div>
												<div class="form-group">
													<label>Galeri Açıklaması</label>
													<textarea class="form-control" name="galeri_aciklama[<?php echo $d["dil_kod"]; ?>]"></textarea>
												</div>
											</div>
										<?php } ?>
										
										<!-- Ortak Alanlar -->
										<div class="form-group">
											<label>Galeri Resmi</label>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
												<div>
													<span class="btn btn-primary btn-file">
														<span class="fileinput-new">Resim Seç</span>
														<span class="fileinput-exists">Değiştir</span>
														<input type="file" name="galeri_resim">
													</span>
													<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Sil</a>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Yayın Durumu</label>
											<select name="galeri_durum" class="form-control">
												<option value="1">Aktif</option>
												<option value="2">Pasif</option>
											</select>
										</div>
										<div class="form-group">
											<label>Galeri Tipi</label>
											<select name="galeri_tip" class="form-control">
												<option value="galeri" <?php echo ($row_info["galeri_tip"] == "galeri" ? 'selected' : ''); ?>>Galeri</option>
												<option value="referans" <?php echo ($row_info["galeri_tip"] == "referans" ? 'selected' : ''); ?>>Referans</option>
											</select>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary" name="submitControl">Kaydet</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
<?php 
			} else if($do == 'edit') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE galeri_ust_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) {
					if(isset($submitControl)){
						if(!empty($_POST['galeri_baslik']) || !empty($_POST['galeri_aciklama'])) {
							$image_info = $db->query("SELECT * FROM ".TABLE." WHERE galeri_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
								$upload = new Upload($_FILES['galeri_resim']);  
								if(!isset($_FILES['galeri_resim']['name'])) {
									$galeri_resim = null;
								} else if(!empty($_FILES['galeri_resim']['name'])) {
									$upload->file_auto_rename = true; 
									$upload->process("../uploads/gallery");
									if ($upload->processed) {
										$galeri_resim = $upload->file_dst_name;
									} else {
										$galeri_resim = null;
									}
								} else {
									$galeri_resim = $image_info["galeri_resim"];
								} 
								
							foreach ($_POST AS $k=>$v) {
								$v = $v;
								if (substr($k,0,5) == "form_") {
									$key = str_replace("form_","",$k);
									$update = $db->prepare("UPDATE ".TABLE." SET  galeri_baslik = ?, galeri_seo = ?, galeri_aciklama = ?, galeri_resim = ?, galeri_durum = ? WHERE galeri_ust_id = ? AND dil_id = ?");
									$update->execute(array($galeri_baslik[$key], Seo_Link_Cevir($galeri_baslik[$key]), $galeri_aciklama[$key], $galeri_resim, $galeri_durum, $id, $key));
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
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE galeri_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>

				<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; "> 
					<div class="col-xl-8 col-xxl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Galeriyi Düzenle</h4>
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
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Title</label>
																<input type="text" name="galeri_baslik[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Title" required="" value="<?php echo GetTableValue("galeri_baslik",TABLE,"where galeri_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Description</label>
																<input type="text" name="galeri_description[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Description" required="" value="<?php echo GetTableValue("galeri_description",TABLE,"where galeri_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Keywords</label>
																<input type="text" name="galeri_keywords[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Keywords" required="" value="<?php echo GetTableValue("galeri_keywords",TABLE,"where galeri_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Açıklama</label>
																<textarea class="form-control ckeditor" name="galeri_aciklama[<?php echo $LANGUAGE_CODE; ?>]"><?php echo GetTableValue("galeri_aciklama",TABLE,"where galeri_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?></textarea>
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
								<label>Resim</label>
								<small class="form-text text-muted">Seçmiş olduğunuz resim veri içeriğinde kullanılmaktadır.</small> 
								<?php if(empty($row_info["galeri_resim"])) {?>
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
												<img src="resim-sec.png" class="img-fluid img-thumbnail" alt="">
											</div> 
											<div>
												<span class="btn btn-primary btn-sm btn-file">
													<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
													<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
													<input type="file" name="galeri_resim" accept="image/*" id="galeri_resim">
												</span>
												<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
											</div>
										</div>
								<?php }else{?> 
										<div class="fileinput fileinput-exists" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 190px;">
												<img src="resim-sec.png" class="img-fluid img-thumbnail" alt="" />
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 303px; max-height: 190px; line-height: 190px;"><img src="../uploads/gallery/<?php echo $row_info["galeri_resim"]; ?>" class="img-fluid img-thumbnail"></div>
											<div>
												<span class="btn btn-primary btn-sm btn-file">
													<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
													<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
													<input type="file" name="galeri_resim" id="galeri_resim" >
													<div class="ripple-container"></div>
												</span>
												<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
											</div>
										</div>
								<?php }?>
								</div> 	
								<div class="form-group"> 
									<label for="">Yayın Durumu</label>
									<select name="galeri_durum" class="form-control">
										<option value="1" <?php if ($row_info["galeri_durum"] == "1") { echo "selected";}?>>Aktif</option>
										<option value="2" <?php if ($row_info["galeri_durum"] == "2") { echo "selected";}?>>Pasif</option> 
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
			}else if($do == 'files') {
				$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE galeri_ust_id = ?");
				$row_check->execute(array($id)); 
				if ($row_check->rowCount() > 0) { 
					$row_info = $db->query("SELECT * FROM ".TABLE." WHERE galeri_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
?>
	
				<div class="col-xl-12"> 
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Yüklenmiş Galeriler</h4>
						</div>
						<div class="card-body"> 						
							<div class="row">
								<?php
								$list = $db->query("SELECT * FROM files WHERE ustid = {$id} AND itable = 1");
								foreach($list as $row){
								?>
								<div class="col-lg-3">
									<div class="card">
									   <a href="javascript:;"><img src="../uploads/files/<?php echo $row["name"]; ?>" class="img-fluid" style="width:300px;height:150px"></a>
											<a href="<?php echo AREA; ?>?do=delete&id2=<?php echo $id; ?>&id=<?php echo $row["id"]; ?>&type=gallery" class="btn btn-block btn-danger"><i class="fa fa-trash"></i></a>
									</div>
								</div>
								<?php } ?>
							</div>
						</div> 
					</div> 
				</div> 
				<div class="col-xl-12"> 
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Galeriyi Yüklüyorsunuz</h4>
						</div>
						<div class="card-body"> 
							 <div class="form-group">
								<div class="dropzone dz-clickable" id="myDrop">
									<div class="dz-default dz-message" data-dz-message="">
										<span>Dosyaları yüklemek için buraya bırakın</span>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<button type="submit" id="add_file" class="btn btn-primary" name="submit"><i class="fa fa-upload"></i> Yükle</button>        
							</div> 
						</div>
					</div> 
				</div>  
<?php
				} else {
					$error = Bilgilendirme::Hata("Belirlenen veri bulunamadı.");  
				}
?>
<?php 
			}else if($_GET["do"] == 'delete') {
				if($type == "gallery"){
					$row_check = $db->prepare("SELECT * FROM files WHERE id = ?");
					$row_check->execute(array($id)); 
					if ($row_check->rowCount() > 0) {
						$update = $db->exec("DELETE FROM files WHERE id = {$id};");
						if($update) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'?do=files&id='.$id2.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde silindi"); 	 
						}else{
							$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");  
						}
					} 
				}else{
					$row_check = $db->prepare("SELECT * FROM ".TABLE." WHERE galeri_ust_id = ?");
					$row_check->execute(array($id)); 
					if ($row_check->rowCount() > 0) {
						$update = $db->exec("DELETE FROM ".TABLE." WHERE galeri_ust_id = {$id};");
						if($update) {
							echo '<meta http-equiv="refresh" content="1;url='.AREA.'">';
							$error = Bilgilendirme::Basarili("Başarılı şekilde silindi"); 	 
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
		
	
	<!-- Chart piety plugin files -->
    <script src="vendor\peity\jquery.peity.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="js\dashboard\dashboard-1.js"></script>
	
<?php if($do == 'add' || $do == 'edit'){ ?>	
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
<?php }   ?> 
	
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
					url: "/include/ajax.php?do=galleries&action=row",
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
<?php if($do == 'files'){ ?>
			<link rel="stylesheet" href="js/dropzone/dropzone.css" type="text/css"> 

  <script src="js/dropzone/dropzone.js"></script>
    <script>
	//Dropzone script
	Dropzone.autoDiscover = false;
	var myDropzone = new Dropzone("div#myDrop", {
		 paramName: "files", // The name that will be used to transfer the file
		 addRemoveLinks: true,
		 uploadMultiple: true,
		 autoProcessQueue: false,
		 parallelUploads: 50,
		 maxFilesize: 30, // MB
		 acceptedFiles: ".png, .jpeg, .jpg, .gif",
		 url: "actions.ajax.php",
		 params : {
				'ust_id' : '<?php echo $id;?>',
				'itable' : '1'
			},
	});
 
	 
	 /* Add Files Script*/
	 myDropzone.on("success", function(file, message){
		$("#msg").html(message);
		setTimeout(function(){
			window.location.href='galeriler?<?php echo $_SERVER["REDIRECT_QUERY_STRING"]; ?>'},0
		);
	 });
	 
	 myDropzone.on("error", function (data) {
		 $("#msg").html('<div class="alert alert-danger">Bir sorun var, lütfen tekrar deneyin!</div>');
	 });
	 
	 myDropzone.on("complete", function(file) {
		myDropzone.removeFile(file);
	 });
	 
	 $("#add_file").on("click",function (){
		myDropzone.processQueue();
	 });
	</script>  
<?php 	} ?>
	
</body>
</html>