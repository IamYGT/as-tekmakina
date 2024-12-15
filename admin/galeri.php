<?php
require("../include/baglan.php");
include("../include/fonksiyon.php");

if (!isset($_SESSION['LOGIN'])) {
    go("index.php", 0);
    exit();
}

define('TABLE', "galeri_resimler");
define('AREA', "galeri");

$do = isset($_GET['do']) ? $_GET['do'] : '';
$sayfa = isset($_GET['q']) ? intval($_GET['q']) : 1;
$limit = 10;
$baslangic = ($sayfa - 1) * $limit;

// Hata ayıklama
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Veritabanı bağlantı kontrolü
if (!$db) {
    error_log("Veritabanı bağlantısı başarısız");
    die("Veritabanı bağlantısı kurulamadı");
}

// Toplam veri sayısı
$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM " . TABLE)->fetchColumn();
$sonSayfa = ceil($toplam_veri_sayisi / $limit);

// Galeri resimlerini listele
// Sıralama için galeri_tarih sütununu kullanıyoruz
$list = $db->prepare("SELECT * FROM " . TABLE . " ORDER BY galeri_tarih DESC LIMIT :baslangic, :limit");
$list->bindParam(':baslangic', $baslangic, PDO::PARAM_INT);
$list->bindParam(':limit', $limit, PDO::PARAM_INT);
$list->execute();

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Memsidea - Yönetim Paneli</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images\favicon.png">
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor\chartist\css\chartist.min.css">
    <link href="vendor\jquery-steps-master\dist\jquery-steps.css" rel="stylesheet">
    <link href="vendor\jqvmap\css\jqvmap.min.css" rel="stylesheet">
    <link href="vendor\bootstrap-select\dist\css\bootstrap-select.min.css" rel="stylesheet">
    <link href="vendor/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="vendor\owl-carousel\owl.carousel.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fa27a1c3e4.js" crossorigin="anonymous"></script>
    <link href="vendor/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="vendor/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="vendor/toastr/css/toastr.min.css" rel="stylesheet">
    <?php if ($do == 'add' || $do == 'edit') : ?>
        <script src="vendor/ck/ckeditor/ckeditor.js"></script>
        <script src="vendor/ck/ckfinder/ckfinder.js"></script>
    <?php endif; ?>
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <?php include("menu.php") ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <?php if ($do == '') : ?>
                        <div id="sortable_sonuc" class="col-lg-12"></div>
                        <div style="margin-bottom: 15px;" class="col-xl-12">
                            <a href="<?php echo AREA; ?>?do=add">
                                <button style="float: right;" type="button" class="btn btn-rounded btn-primary">
                                    <span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i></span>Yeni
                                </button>
                            </a>
                            <button style="float: right; margin-right: 10px;" type="button" class="btn btn-rounded btn-danger" id="delete-selected">
                                <span class="btn-icon-left text-danger"><i class="fa fa-trash color-danger"></i></span>Seçilenleri Sil
                            </button>
                        </div>
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <div id="example5_wrapper" class="dataTables_wrapper no-footer">
                                    <table class="table display mb-4 dataTablesCard card-table dataTable no-footer" id="example5">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>Sıra</th>
                                                <th>Resim</th>
                                                <th>Tarih</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable">
                                            <?php if ($list->rowCount() > 0) : ?>
                                                <?php while ($row = $list->fetch(PDO::FETCH_ASSOC)) : ?>
                                                    <tr id="item-<?php echo $row["resim_id"]; ?>">
                                                        <td><input type="checkbox" class="select-row" name="selected_images[]" value="<?php echo $row["resim_id"]; ?>"></td>
                                                        <td class="sortable align-middle" style="width:20px">
                                                            <i class="fa fa-sort"></i>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php if ($row["galeri_resim"]) : ?>
                                                                <img src="../uploads/gallery/<?php echo $row["galeri_resim"]; ?>" width="80" class="img-thumbnail" alt="Galeri Resmi">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="align-middle"><?php echo $row["galeri_tarih"]; ?></td>
                                                        <td class="align-middle">
                                                            <div class="d-flex">
                                                                <a class="btn btn-primary btn-sm mr-1" href="<?php echo AREA; ?>?do=edit&id=<?php echo $row["resim_id"]; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" href="<?php echo AREA; ?>?do=delete&id=<?php echo $row["resim_id"]; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Listelenecek veri bulunamadı.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($do == 'add') : ?>
                        <?php
                        if (isset($_POST['submitControl'])) {
                            if (!empty($_FILES['galeri_resim']['name'][0])) {
                                $files = $_FILES['galeri_resim'];
                                $uploaded_files = [];
                                $upload_errors = [];
                                foreach ($files['name'] as $key => $name) {
                                    $file = [
                                        'name' => $files['name'][$key],
                                        'type' => $files['type'][$key],
                                        'tmp_name' => $files['tmp_name'][$key],
                                        'error' => $files['error'][$key],
                                        'size' => $files['size'][$key]
                                    ];
                                    $upload = new Upload($file);
                                    if ($upload->uploaded) {
                                        $upload->file_auto_rename = true;
                                        $upload->process("../uploads/gallery");
                                        if ($upload->processed) {
                                            $uploaded_files[] = $upload->file_dst_name;
                                        } else {
                                            $upload_errors[] = "Dosya yüklenirken bir hata oluştu: " . $upload->error;
                                        }
                                    } else {
                                        $upload_errors[] = "Dosya yüklenirken bir hata oluştu: " . $upload->error;
                                    }
                                }
                                if (empty($upload_errors)) {
                                    $insert_success = true;
                                    foreach ($uploaded_files as $galeri_resim) {
                                        $insert = $db->prepare("INSERT INTO " . TABLE . " SET galeri_resim = ?, galeri_tarih = ?");
                                        if (!$insert->execute(array($galeri_resim, date('Y-m-d H:i:s')))) {
                                            $insert_success = false;
                                            $error = Bilgilendirme::Hata("Veritabanına kayıt sırasında bir hata oluştu.");
                                            break;
                                        }
                                    }
                                    if ($insert_success) {
                                        $success = Bilgilendirme::Basarili("Galeriye resimler başarıyla eklendi.");
                                    }
                                } else {
                                    $error = Bilgilendirme::Hata(implode("<br>", $upload_errors));
                                }
                            } else {
                                $error = Bilgilendirme::Hata("Lütfen en az bir resim seçiniz.");
                            }
                        }
                        ?>
                        <div class="col-lg-12">
                            <form id="form" action="" method="POST" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Galeri Resim Ekle</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-group">
                                                <label>Resim Seçiniz</label>
                                                <div id="preview-container" style="margin-bottom: 10px; border: 2px dashed #ccc; padding: 20px; text-align: center;">
                                                    <img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">
                                                </div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="input-group">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">Resim Seç</span>
                                                            <span class="fileinput-exists">Değiştir</span>
                                                            <input type="file" id="galeri_resim" name="galeri_resim[]" multiple>
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" name="submitControl" value="1">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php elseif ($do == 'edit') :
                        $row_check = $db->prepare("SELECT * FROM " . TABLE . " WHERE resim_id = ?");
                        $row_check->execute(array(intval($_GET["id"])));
                        if ($row_check->rowCount() > 0) {
                            $row = $row_check->fetch(PDO::FETCH_ASSOC);
                        } else {
                            go(AREA, 1);
                        }
                        if (isset($_POST['submitControl'])) {
                            if (!empty($_FILES['galeri_resim']['name'])) {
                                $file = $_FILES['galeri_resim'];
                                $upload = new Upload($file);
                                if ($upload->uploaded) {
                                    $upload->file_auto_rename = true;
                                    $upload->process("../uploads/gallery");
                                    if ($upload->processed) {
                                        $update = $db->prepare("UPDATE " . TABLE . " SET galeri_resim = ? WHERE resim_id = ?");
                                        $update->execute(array($upload->file_dst_name, intval($_GET["id"])));
                                        if ($update) {
                                            $success = Bilgilendirme::Basarili("Galeri resmi başarıyla güncellendi.");
                                        } else {
                                            $error = Bilgilendirme::Hata("Güncelleme sırasında bir hata oluştu.");
                                        }
                                    } else {
                                        $error = Bilgilendirme::Hata("Dosya yüklenirken bir hata oluştu: " . $upload->error);
                                    }
                                } else {
                                    $error = Bilgilendirme::Hata("Dosya yüklenirken bir hata oluştu: " . $upload->error);
                                }
                            } else {
                                $success = Bilgilendirme::Basarili("Galeri resmi başarıyla güncellendi.");
                            }
                        }
                        ?>
                        <div class="col-lg-12">
                            <form id="form" action="" method="POST" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Galeri Resim Düzenle</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-group">
                                                <label>Resim Seçiniz</label>
                                                <div id="preview-container" style="margin-bottom: 10px; border: 2px dashed #ccc; padding: 20px; text-align: center;">
                                                    <?php if ($row["galeri_resim"]) : ?>
                                                        <img src="../uploads/gallery/<?php echo $row["galeri_resim"]; ?>?v=<?php echo time(); ?>" class="img-fluid img-thumbnail" style="max-height: 190px;" alt="Galeri Resmi">
                                                    <?php else : ?>
                                                        <img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="input-group">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">Resim Seç</span>
                                                            <span class="fileinput-exists">Değiştir</span>
                                                            <input type="file" id="galeri_resim" name="galeri_resim">
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" name="submitControl" value="1">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php elseif ($do == 'delete') :
                        $delete = $db->prepare("DELETE FROM " . TABLE . " WHERE resim_id = ?");
                        $delete->execute(array(intval($_GET["id"])));
                        if ($delete) {
                            $success = Bilgilendirme::Basarili("Galeri resmi başarıyla silindi.");
                            go(AREA, 1);
                        } else {
                            $error = Bilgilendirme::Hata("Silme sırasında bir hata oluştu.");
                        }
                    endif; ?>
                    <?php if (isset($error)) : ?>
                        <div class="col-lg-12">
                            <div class="alert alert-secondary solid alert-dismissible fade show">
                                <strong>İşlem Sonucu!</strong>
                                <p><?php echo $error; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($success)) : ?>
                        <div class="col-lg-12">
                            <div class="alert alert-success solid alert-dismissible fade show">
                                <strong>İşlem Sonucu!</strong>
                                <p><?php echo $success; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php include("alt.php") ?>
    </div>
    <script src="vendor\global\global.min.js"></script>
    <script src="vendor\bootstrap-select\dist\js\bootstrap-select.min.js"></script>
    <script src="vendor\chart.js\Chart.bundle.min.js"></script>
    <script src="js\custom.min.js"></script>
    <script src="js\deznav-init.js"></script>
    <script src="vendor\owl-carousel\owl.carousel.js"></script>
    <script src="vendor\peity\jquery.peity.min.js"></script>
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
    <script>
        $(function() {
            $("#sortable").sortable({
                revert: true,
                handle: ".sortable",
                stop: function(event, ui) {
                    var data = $(this).sortable('serialize');
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: 'gallery_row',
                            item: data.split('item[]=').filter(Boolean).map(Number)
                        },
                        url: "/include/ajax.php",
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            toastr.error("Sıralama güncellenirken bir hata oluştu.");
                        }
                    });
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
    <script src="vendor/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            var previewContainer = $('#preview-container');

            previewContainer.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            previewContainer.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            previewContainer.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');

                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    var input = $('#galeri_resim');
                    input.prop('files', files);

                    previewContainer.empty();
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = $('<img >').attr('src', e.target.result).addClass('img-fluid img-thumbnail').css('max-height', '190px');
                            previewContainer.append(img);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $('#galeri_resim').on('change', function() {
                var files = $(this)[0].files;
                if (files.length > 0) {
                    previewContainer.empty();
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = $('<img >').attr('src', e.target.result).addClass('img-fluid img-thumbnail').css('max-height', '190px');
                            previewContainer.append(img);
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    previewContainer.html('<img src="https://via.placeholder.com/287x192.png?text=Select+Image" class="img-fluid img-thumbnail" alt="">');
                }
            });

            $('#select-all').on('click', function() {
                $('.select-row').prop('checked', this.checked);
            });

            $('#delete-selected').on('click', function() {
                var selected = [];
                $('input[name="selected_images[]"]:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length > 0) {
                    if (confirm('Seçilen resimleri silmek istediğinize emin misiniz?')) {
                        $.ajax({
                            type: "POST",
                            url: "/include/ajax.php",
                            data: {
                                action: 'gallery_delete_multiple',
                                ids: selected
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                                toastr.error("Resimler silinirken bir hata oluştu.");
                            }
                        });
                    }
                } else {
                    toastr.warning('Lütfen silmek için en az bir resim seçin.');
                }
            });
        });
    </script>
    <script src="vendor/toastr/js/toastr.min.js"></script>
</body>

</html>