<?php require("../include/baglan.php");
include("../include/fonksiyon.php");
if (!isset($_SESSION['LOGIN'])) {
	go("index.php", 0);
	exit();
}
define('TABLE', "projeler");
define('AREA', "projeler");
if (!isset($do)) $do = null;
$sayfa = (isset($q) ? $q : 1);
$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM ".TABLE." WHERE dil_id = 'tr'")->fetchColumn();
$limit = 10;
$sonSayfa = ceil($toplam_veri_sayisi / $limit);
$baslangic = ($sayfa - 1) * $limit;

// En üste ekleyelim
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Veritabanı bağlantı kontrolü
if(!$db) {
    error_log("Veritabanı bağlantısı başarısız");
    die("Veritabanı bağlantısı kurulamadı");
}

// Proje listeleme sorgusunu güncelleyelim
$list = $db->query("SELECT p.*, 
    GROUP_CONCAT(DISTINCT p2.dil_id) as diller,
    GROUP_CONCAT(DISTINCT p2.proje_baslik ORDER BY p2.dil_id SEPARATOR '|||') as basliklar,
    p.proje_yil,
    p.proje_adres,
    p.proje_metrekare,
    p.proje_daire,
    p.proje_blok,
    p.proje_tamamlanma
    FROM ".TABLE." p 
    LEFT JOIN ".TABLE." p2 ON p.proje_ust_id = p2.proje_ust_id 
    WHERE p.dil_id = 'tr' 
    GROUP BY p.proje_ust_id 
    ORDER BY p.row ASC, p.proje_id DESC 
    LIMIT $baslangic,$limit");

// Dil tablosunu kontrol et
try {
    $dil_list = $db->query("SELECT * FROM dil WHERE dil_durum = 1");
    error_log("Aktif dil sayısı: " . $dil_list->rowCount());
    while($dil = $dil_list->fetch(PDO::FETCH_ASSOC)) {
        error_log("Dil: " . print_r($dil, true));
    }
} catch(PDOException $e) {
    error_log("Dil tablosu sorgusu hatası: " . $e->getMessage());
}

// Proje sayısını kontrol et
try {
    $total_tr = $db->query("SELECT COUNT(*) FROM ".TABLE." WHERE dil_id = 'tr'")->fetchColumn();
    $total_all = $db->query("SELECT COUNT(*) FROM ".TABLE)->fetchColumn();
    error_log("Toplam TR proje sayısı: " . $total_tr);
    error_log("Toplam proje sayısı: " . $total_all);
} catch(PDOException $e) {
    error_log("Proje sayısı sorgusu hatası: " . $e->getMessage());
}

// Ajax işlemlerini kontrol et
$ajax_url = $ayarlar["strURL"] . "/include/ajax.php?do=projects&action=row";
error_log("Ajax URL: " . $ajax_url);

// LANGUAGE_DEFAULT kontrolü
error_log("LANGUAGE_DEFAULT: " . LANGUAGE_DEFAULT);

// Debug için
error_log("Toplam proje sayısı: " . $toplam_veri_sayisi);
error_log("SQL Sorgusu: SELECT * FROM ".TABLE." WHERE dil_id = 'tr' ORDER BY proje_ust_id DESC LIMIT $baslangic,$limit");
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
	<!-- jQuery UI -->
	<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
	<link href="vendor/jquery-ui/jquery-ui.css" rel="stylesheet">
	<?php if ($do == 'add' || $do == 'edit'): ?>
	<script src="vendor/ck/ckeditor/ckeditor.js"></script>
	<script src="vendor/ck/ckfinder/ckfinder.js"></script>
	<?php endif; ?>
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
		<?php include("menu.php") ?>
		<div class="content-body">
			<!-- row -->
			<div class="container-fluid">
				<div class="row">
					<?php
					if ($do == '') {
					?>
						<div id="sortable_sonuc" class="col-lg-12"></div>
						<div style="margin-bottom: 15px;" class="col-xl-12">
							<a href="<?php echo AREA; ?>?do=add"><button style="float: right;" type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni</button></a>
						</div>
						<div class="col-xl-12">
							<div class="table-responsive">
								<div id="example5_wrapper" class="dataTables_wrapper no-footer">
									<table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5">
										<thead>
											<tr role="row">
												<th>Sıra</th>
												<th>Başlık</th>
												<th>Resim</th>
												<th>Durum</th>
												<th>İşlemler</th>
											</tr>
										</thead>
										<tbody id="sortable">
											<?php
											if ($list->rowCount()) {
												foreach($list as $row) {
													$diller = explode(',', $row["diller"]);
													$basliklar = explode('|||', $row["basliklar"]);
											?>
													<tr id="item-<?php echo $row["proje_ust_id"]; ?>">
														<td class="sortable" style="width:20px">
															<i class="fa fa-sort"></i>
														</td>
														<td>
															<?php echo $row["proje_baslik"]; ?>
															<div class="mt-1">
																<?php
																foreach($db->query("SELECT * FROM dil WHERE dil_durum = 1") as $dil) {
																	if(in_array($dil["dil_kod"], $diller)) {
																		echo '<span class="badge badge-success mr-1">'.$dil["dil_kod"].'</span>';
																	} else {
																		echo '<span class="badge badge-danger mr-1">'.$dil["dil_kod"].'</span>';
																	}
																}
																?>
															</div>
														</td>
														<td>
															<?php if($row["proje_resim"]) { ?>
																<img src="../uploads/projects/<?php echo $row["proje_resim"]; ?>" width="50" alt="">
															<?php } ?>
														</td>
														<td><?php echo ($row["proje_durum"] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Pasif</span>'; ?></td>
														<td>
															<div class="d-flex">
																<a class="btn btn-primary btn-sm mr-2" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["proje_ust_id"]; ?>">
																	<i class="fa fa-edit"></i>
																</a>
																<a class="btn btn-danger btn-sm" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["proje_ust_id"]; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">
																	<i class="fa fa-trash"></i>
																</a>
															</div>
														</td>
													</tr>
											<?php 
												}
											} else {
												echo '<tr><td colspan="5" class="text-center">Listelenecek veri bulunamadı.</td></tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php
					} else if ($do == 'add') {
						if (isset($submitControl)) {
							if (!empty($_POST['proje_baslik']) || !empty($_POST['proje_aciklama'])) {
								$LastID = $db->query("SELECT proje_id FROM " . TABLE . " ORDER BY proje_id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
								$LastID = $LastID["proje_id"] + 1;
								$upload = new Upload($_FILES['proje_resim']);
								if ($upload->uploaded) {
									$upload->file_auto_rename = true;
									$upload->process("../uploads/projects");
									if ($upload->processed) {
										$proje_resim = $upload->file_dst_name;
									} else {
										$error = Bilgilendirme::Hata("Hay Aksi! Bir hata meydana geldi." . $upload->error);
									}
								}
								foreach ($_POST as $k => $v) {
									$v = $v;
									if (substr($k, 0, 5) == "form_") {
										$key = str_replace("form_", "", $k);
										$insert = $db->prepare("INSERT INTO " . TABLE . " SET proje_baslik = ?, proje_seo = ?, proje_aciklama = ?, proje_yil = ?,  proje_adres = ?, proje_metrekare = ?, proje_daire = ?, proje_blok = ?, proje_tamamlanma = ?, proje_resim = ?, dil_id = ?, kategori_id = ?, proje_durum = ?, proje_ust_id = ?");
										$insert->execute(array($proje_baslik[$key], Seo_Link_Cevir($proje_baslik[$key]), $proje_aciklama[$key], $proje_yil[$key], $proje_adres[$key], $proje_metrekare[$key], $proje_daire[$key], $proje_blok[$key],  $proje_tamamlanma[$key], $proje_resim, $key, $kategori_id, $proje_durum, $LastID));
										$last_id = $db->lastInsertId();
									}
								}
								if ($insert) {
									echo '<meta http-equiv="refresh" content="1;url=' . AREA . '?do=edit&id=' . $LastID . '">';
									$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");
								} else {
									$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");
								}
							} else {
								$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız.");
							}
						} else {
						?>
							<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; ">
								<div class="col-xl-8 col-xxl-8">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">Proje Ekle</h4>
										</div>
										<div class="card-body">
											<div class="step-app" id="demo">
												<ul class="step-steps">
													<?php
													$list = $db->query("select * from dil where dil_durum = '1'");
													foreach ($list as $row) {
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
													foreach ($list as $row) {
														$LANGUAGE_ID = $row["dil_id"];
														$LANGUAGE_CODE = $row["dil_kod"];
														$LANGUAGE_TITLE = $row["dil_baslik"];
													?>
														<div class="step-tab-panel" data-step="step<?php echo $LANGUAGE_ID; ?>">
															<div class="row">
																<div class="col-lg-12 mb-2">
																	<div class="form-group">
																		<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Proje İsmi</label>
																		<input type="text" name="proje_baslik[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Proje İsmi" required="">
																	</div>
																</div>

																<div class="col-lg-12 mb-2">
																	<div class="form-group">
																		<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Açıklama</label>
																		<textarea class="form-control ckeditor" name="proje_aciklama[<?php echo $LANGUAGE_CODE; ?>]"></textarea>
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
												<label for="">Kategoriler</label>
												<select name="kategori_id" class="form-control">
													<option value="">Kategori Seçiniz</option>
													<?php CategoryOption(0, 0, null);  ?>
												</select>
											</div>
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
															<input type="file" name="proje_resim" accept="image/*" id="proje_resim">
														</span>
														<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="">Yayın Durumu</label>
												<select name="proje_durum" class="form-control">
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
					} else if ($do == 'edit') {
						$row_check = $db->prepare("SELECT * FROM " . TABLE . " WHERE proje_ust_id = ?");
						$row_check->execute(array($id));
						if ($row_check->rowCount() > 0) {
							if (isset($submitControl)) {
								if (!empty($_POST['proje_baslik']) || !empty($_POST['proje_aciklama'])) {
									$image_info = $db->query("SELECT * FROM " . TABLE . " WHERE proje_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
									$upload = new Upload($_FILES['proje_resim']);
									if (!isset($_FILES['proje_resim']['name'])) {
										$proje_resim = null;
									} else if (!empty($_FILES['proje_resim']['name'])) {
										$upload->file_auto_rename = true;
										$upload->process("../uploads/projects");
										if ($upload->processed) {
											$proje_resim = $upload->file_dst_name;
										} else {
											$proje_resim = null;
										}
									} else {
										$proje_resim = $image_info["proje_resim"];
									}

									foreach ($_POST as $k => $v) {
										$v = $v;
										if (substr($k, 0, 5) == "form_") {
											$key = str_replace("form_", "", $k);
											$update = $db->prepare("UPDATE " . TABLE . " SET  	 proje_baslik = ?, proje_seo = ?, proje_aciklama = ?, proje_yil = ?,  proje_adres = ?, proje_metrekare = ?, proje_daire = ?, proje_blok = ?, proje_tamamlanma = ?, proje_resim = ?, proje_durum = ?, kategori_id = ? WHERE proje_ust_id = ? AND dil_id = ?");
											$update->execute(array($proje_baslik[$key], Seo_Link_Cevir($proje_baslik[$key]), $proje_aciklama[$key], $proje_yil[$key], $proje_adres[$key], $proje_metrekare[$key], $proje_daire[$key], $proje_blok[$key],  $proje_tamamlanma[$key], $proje_resim, $proje_durum, $kategori_id, $id, $key));
										}
									}
									if ($update) {
										echo '<meta http-equiv="refresh" content="1;url=' . AREA . '?do=edit&id=' . $id . '">';
										$error = Bilgilendirme::Basarili("Başarılı şekilde Eklendi, görüntülemek üzere yönlendiriliyorsunuz..");
									} else {
										$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");
									}
								} else {
									$error = Bilgilendirme::Hata("Hoppala! Boş alan bıraktınız.");
								}
							} else {
								$row_info = $db->query("SELECT * FROM " . TABLE . " WHERE proje_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);

								// Proje değişkenlerini tanımlayalım
								$proje_yil = isset($row_info['proje_yil']) ? $row_info['proje_yil'] : '';
								
								echo '<form action="#" method="POST" enctype="multipart/form-data" id="form" style="display: inline-flex; ">';
									echo '<div class="col-xl-8 col-xxl-8">';
										echo '<div class="card">';
											echo '<div class="card-header">';
												echo '<h4 class="card-title">Projeyi Düzenle</h4>';
											echo '</div>';
											echo '<div class="card-body">';
												echo '<div class="step-app" id="demo">';
													echo '<ul class="step-steps">';
														$list = $db->query("select * from dil where dil_durum = '1'");
														foreach ($list as $row) {
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
														foreach ($list as $row) {
															$LANGUAGE_ID = $row["dil_id"];
															$LANGUAGE_CODE = $row["dil_kod"];
															$LANGUAGE_TITLE = $row["dil_baslik"];
														?>
															<div class="step-tab-panel" data-step="step<?php echo $LANGUAGE_ID; ?>">
																<div class="row">
																	<div class="col-lg-12 mb-2">
																		<div class="form-group">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Başlık</label>
																			<input type="text" name="proje_baslik[<?php echo $LANGUAGE_CODE; ?>]" class="form-control" placeholder="Başlık" required="" value="<?php echo GetTableValue("proje_baslik", TABLE, "where proje_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?>">
																		</div>
																	</div>

																	<div class="col-lg-12 mb-2">
																		<div class="form-group">
																			<label class="text-label"><i class="flag-icon flag-icon-<?php echo $LANGUAGE_CODE; ?> icon-2x"></i> Açıklama</label>
																			<textarea class="form-control ckeditor" name="proje_aciklama[<?php echo $LANGUAGE_CODE; ?>]"><?php echo GetTableValue("proje_aciklama", TABLE, "where proje_ust_id = {$id} and dil_id = '{$LANGUAGE_CODE}' "); ?></textarea>
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
													<label for="">Kategoriler</label>
													<select name="kategori_id" class="form-control">
														<option value="">Kategori Seçiniz</option>
														<?php CategoryOption(0, 0, $row_info["kategori_id"]); ?>
													</select>
												</div>
												<div class="form-group">
													<label>Resim</label>
													<small class="form-text text-muted">Seçmiş olduğunuz resim veri içeriğinde kullanılmaktadır.</small>
													<?php if (empty($row_info["proje_resim"])) { ?>
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%;height: 190px;line-height: 190px;">
																<img src="resim-sec.png" class="img-fluid img-thumbnail" alt="">
															</div>
															<div>
																<span class="btn btn-primary btn-sm btn-file">
																	<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
																	<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
																	<input type="file" name="proje_resim" accept="image/*" id="proje_resim">
																</span>
																<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
															</div>
														</div>
													<?php } else { ?>
														<div class="fileinput fileinput-exists" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 190px;">
																<img src="resim-sec.png" class="img-fluid img-thumbnail" alt="" />
															</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 303px; max-height: 190px; line-height: 190px;"><img src="../uploads/projects/<?php echo $row_info["proje_resim"]; ?>" class="img-fluid img-thumbnail"></div>
															<div>
																<span class="btn btn-primary btn-sm btn-file">
																	<span class="fileinput-new"><span class="fui-image"></span>Resim Seç</span>
																	<span class="fileinput-exists"><span class="fui-gear"></span>Değiştir</span>
																	<input type="file" name="proje_resim" id="proje_resim">
																	<div class="ripple-container"></div>
																</span>
																<a href="#" class="btn btn-primary btn-sm fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>Vazgeç</a>
															</div>
														</div>
													<?php } ?>
												</div>
												<div class="form-group">
													<label for="">Yayın Durumu</label>
													<select name="proje_durum" class="form-control">
														<option value="1" <?php if ($row_info["proje_durum"] == "1") {
																				echo "selected";
																			} ?>>Aktif</option>
														<option value="2" <?php if ($row_info["proje_durum"] == "2") {
																				echo "selected";
																			} ?>>Pasif</option>
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
					} else if ($do == 'files') {
						$row_check = $db->prepare("SELECT * FROM " . TABLE . " WHERE proje_ust_id = ?");
						$row_check->execute(array($id));
						if ($row_check->rowCount() > 0) {
							$row_info = $db->query("SELECT * FROM " . TABLE . " WHERE proje_ust_id = {$id}")->fetch(PDO::FETCH_ASSOC);
						?>

							<div class="col-xl-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Yüklenmiş Galeriler</h4>
									</div>
									<div class="card-body">
										<div class="row">
											<?php
											$list = $db->query("SELECT * FROM files WHERE ustid = {$id} AND itable = 2");
											foreach ($list as $row) {
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
					} else if ($_GET["do"] == 'delete') {
						if ($type == "gallery") {
							$row_check = $db->prepare("SELECT * FROM files WHERE id = ?");
							$row_check->execute(array($id));
							if ($row_check->rowCount() > 0) {
								$update = $db->exec("DELETE FROM files WHERE id = {$id};");
								if ($update) {
									echo '<meta http-equiv="refresh" content="1;url=' . AREA . '?do=files&id=' . $id2 . '">';
									$error = Bilgilendirme::Basarili("Başarılı şekilde silindi");
								} else {
									$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");
								}
							}
						} else {
							$row_check = $db->prepare("SELECT * FROM " . TABLE . " WHERE proje_ust_id = ?");
							$row_check->execute(array($id));
							if ($row_check->rowCount() > 0) {
								$update = $db->exec("DELETE FROM " . TABLE . " WHERE proje_ust_id = {$id};");
								if ($update) {
									echo '<meta http-equiv="refresh" content="1;url=' . AREA . '">';
									$error = Bilgilendirme::Basarili("Başarılı şekilde silindi");
								} else {
									$error = Bilgilendirme::Hata("Bir Hata meydana geldi, daha sonra tekrar deneyiniz.");
								}
							}
						}
					}
					?>
					<?php

					if (isset($error)) {
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
		<?php include("alt.php") ?>

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

	<?php if ($do == 'add' || $do == 'edit') { ?>
		<script src="vendor\jquery-steps-master\dist\jquery-steps.min.js"></script>
		<script>
			$('#demo').steps({
				onFinish: function(event, currentIndex) {

					jQuery(function($) {

						var form = $(this);
						$("#form").submit();
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
			$("#sortable").sortable({
				revert: true,
				handle: ".sortable",
				stop: function(event, ui) {
					var data = $(this).sortable('serialize');
					$.ajax({
						type: "POST",
						dataType: "json",
						data: data,
						url: "/include/ajax.php?do=projects&action=row",
						success: function(msg) {
							$("#sortable_sonuc").html(msg.islemMsj);
							setTimeout(function() {
								$("#sortable_sonuc").html("");
							}, 2000);
						}
					});
				}
			});
			$("#sortable").disableSelection();
		});
	</script>
	<?php if ($do == 'files') { ?>
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
				params: {
					'ust_id': '<?php echo $id; ?>',
					'itable': '2'
				},
			});


			/* Add Files Script*/
			myDropzone.on("success", function(file, message) {
				$("#msg").html(message);
				setTimeout(function() {
					window.location.href = 'projeler?<?php echo $_SERVER["REDIRECT_QUERY_STRING"]; ?>'
				}, 0);
			});

			myDropzone.on("error", function(data) {
				$("#msg").html('<div class="alert alert-danger">Bir sorun var, lütfen tekrar deneyin!</div>');
			});

			myDropzone.on("complete", function(file) {
				myDropzone.removeFile(file);
			});

			$("#add_file").on("click", function() {
				myDropzone.processQueue();
			});
		</script>
	<?php 	} ?>
	<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
	<script>
	$(document).ready(function() {
		$("#sortable").sortable({
			handle: '.sortable',
			update: function(event, ui) {
				var data = $(this).sortable('serialize');
				$.ajax({
					type: "POST",
					dataType: "json",
					data: data,
					url: "<?php echo $ayarlar["strURL"]; ?>/include/ajax.php?do=projects&action=row",
					success: function(msg) {
						if(msg.status == 'success') {
							toastr.success('Sıralama güncellendi');
						} else {
							toastr.error('Bir hata oluştu');
						}
					}
				});
			}
		});
		$("#sortable").disableSelection();
	});
	</script>

</body>

</html>
</html>