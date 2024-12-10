<?php 
require("include/baglan.php");
include("include/fonksiyon.php");
include_once("inc.lang.php");

// URL'den son segmenti al (haber_seo)
$current_url = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', trim($current_url, '/'));
$seo_url = end($url_parts);

$lang = getCurrentDil();

// Önce mevcut SEO URL ile eşleşen tüm dillerdeki içeriği bul
$find_content = $db->prepare("SELECT haber_ust_id FROM hizmetler WHERE haber_seo = ? LIMIT 1");
$find_content->execute([$seo_url]);
$content = $find_content->fetch(PDO::FETCH_ASSOC);

if ($content) {
    // Eğer içerik bulunduysa, mevcut dildeki versiyonunu al
    $hizmet_query = $db->prepare("SELECT * FROM hizmetler WHERE haber_ust_id = ? AND dil_id = ? AND haber_durum = 1");
    $hizmet_query->execute([$content['haber_ust_id'], $lang]);
    $tekil_veri_cek = $hizmet_query->fetch(PDO::FETCH_ASSOC);
    
    if ($tekil_veri_cek) {
        // Eğer farklı bir SEO URL'e sahipse yönlendir
        if ($tekil_veri_cek['haber_seo'] != $seo_url) {
            header("Location: " . $ayarlar["strURL"] . "/hizmet/" . $tekil_veri_cek['haber_seo']);
            exit;
        }
    } else {
        // Mevcut dilde içerik yoksa 404'e yönlendir
        header("Location: " . $ayarlar["strURL"] . "/404");
        exit;
    }
} else {
    // İçerik hiç bulunamadıysa 404'e yönlendir
    header("Location: " . $ayarlar["strURL"] . "/404");
    exit;
}

// Diğer dillerdeki karşılıklarını bul
$dil_karsiliklari = [];
$other_langs_query = $db->prepare("SELECT h.haber_seo, d.dil_kod 
                                  FROM hizmetler h 
                                  INNER JOIN dil d ON h.dil_id = d.dil_kod 
                                  WHERE h.haber_ust_id = ? AND h.haber_durum = 1");
$other_langs_query->execute([$tekil_veri_cek["haber_ust_id"]]);
$dil_karsiliklari = $other_langs_query->fetchAll(PDO::FETCH_ASSOC);

// Hit sayısını artır
$hit_update = $db->prepare("UPDATE hizmetler SET haber_hit = haber_hit + 1 WHERE haber_id = ?");
$hit_update->execute([$tekil_veri_cek["haber_id"]]);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
   <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - <?php echo $ayarlar["strTitle"]; ?></title>
   <!-- Dil linkleri için canonical ve alternate tagları -->
   <link rel="canonical" href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $tekil_veri_cek["haber_seo"]; ?>" />
   <?php foreach($dil_karsiliklari as $dk) { ?>
       <link rel="alternate" hreflang="<?php echo $dk["dil_kod"]; ?>" 
             href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $dk["haber_seo"]; ?>" />
   <?php } ?>
   <?php include 'css.php'; ?>
   <!-- Fancybox CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
   <style>
      .service-images-grid {
         display: grid;
         grid-template-columns: repeat(2, 1fr);
         gap: 25px;
         margin-top: 20px;
      }

      .service-img {
         position: relative;
         overflow: hidden;
         border-radius: 12px;
         box-shadow: 0 5px 20px rgba(0,0,0,0.1);
         background: #fff;
         height: 100%;
         cursor: pointer;
      }

      .service-img img {
         width: 100%;
         height: 280px;
         object-fit: contain;
         padding: 15px;
         transition: all 0.4s ease;
      }

      .service-img:hover img {
         transform: scale(1.05);
      }

      .service-img.main-img {
         grid-column: span 2;
      }

      .service-img.main-img img {
         height: 400px;
      }

      .service-content {
         padding: 30px;
         background: #f8f9fa;
         border-radius: 12px;
         margin-bottom: 30px;
      }

      .service-content h4 {
         color: #da963e;
         font-size: 24px;
         margin-bottom: 20px;
         font-weight: 600;
      }

      .service-content p {
         color: #666;
         line-height: 1.8;
         margin-bottom: 20px;
      }

      .service-features {
         margin: 25px 0;
         padding: 0;
         list-style: none;
      }

      .service-features li {
         position: relative;
         padding-left: 30px;
         margin-bottom: 15px;
         color: #444;
      }

      .service-features li:before {
         content: "\f00c";
         font-family: "Font Awesome 5 Pro";
         position: absolute;
         left: 0;
         top: 2px;
         color: #da963e;
      }

      .zoom-icon {
         position: absolute;
         right: 15px;
         bottom: 15px;
         background: rgba(218, 150, 62, 0.9);
         color: white;
         width: 40px;
         height: 40px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         opacity: 0;
         transition: all 0.3s ease;
      }

      .service-img:hover .zoom-icon {
         opacity: 1;
      }

      @media (max-width: 768px) {
         .service-images-grid {
            grid-template-columns: 1fr;
            gap: 20px;
         }
         
         .service-img.main-img {
            grid-column: span 1;
         }
         
         .service-img img,
         .service-img.main-img img {
            height: 250px;
         }
      }
   </style>
</head>

<body>
   <?php include 'ust.php'; ?>
   <main>
      <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center" data-background="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim"]; ?>">
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="page__title-wrapper mt-100">
                     <div class="breadcrumb-menu">
                        <ul>
                           <li><a href="<?php echo $ayarlar["strURL"]; ?>/"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                           <li><a href="<?php echo $ayarlar["strURL"]; ?>/hizmetler"><?php echo LANG('menu_hizmetler', $lang); ?></a></li>
                           <li><span><?php echo $tekil_veri_cek["haber_baslik"]; ?></span></li>
                        </ul>
                     </div>
                     <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="about__area pt-120 pb-155">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6">
                  <div class="about__right-2">
                     <div class="service-content">
                        <h4><?php echo $tekil_veri_cek["haber_baslik"]; ?></h4>
                        <p><?php echo $tekil_veri_cek["haber_aciklama"]; ?></p>
                        
                        <ul class="service-features">
                           <li><?php echo LANG('service_feature_1', $lang); ?></li>
                           <li><?php echo LANG('service_feature_2', $lang); ?></li>
                           <li><?php echo LANG('service_feature_3', $lang); ?></li>
                           <li><?php echo LANG('service_feature_4', $lang); ?></li>
                           <li><?php echo LANG('service_feature_5', $lang); ?></li>
                        </ul>

                        <div class="service-contact mt-4">
                           <p class="mb-2"><strong><i class="fas fa-phone-alt me-2"></i><?php echo LANG('contact_phone', $lang); ?>:</strong> <?php echo $ayarlar["strPhone"]; ?></p>
                           <p><strong><i class="fas fa-envelope me-2"></i><?php echo LANG('contact_email', $lang); ?>:</strong> <?php echo $ayarlar["strMail"]; ?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="service-images-grid">
                     <?php if($tekil_veri_cek["haber_resim"]) { ?>
                     <div class="service-img main-img">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim"]; ?>" 
                           data-fancybox="gallery">
                           <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim"]; ?>" 
                                alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                           <div class="zoom-icon" title="<?php echo LANG('zoom_image', $lang); ?>">
                              <i class="fas fa-search-plus"></i>
                           </div>
                        </a>
                     </div>
                     <?php } ?>

                     <?php if($tekil_veri_cek["haber_resim2"]) { ?>
                     <div class="service-img">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim2"]; ?>" 
                           data-fancybox="gallery">
                           <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim2"]; ?>" 
                                alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                           <div class="zoom-icon" title="<?php echo LANG('zoom_image', $lang); ?>">
                              <i class="fas fa-search-plus"></i>
                           </div>
                        </a>
                     </div>
                     <?php } ?>

                     <?php if($tekil_veri_cek["haber_resim3"]) { ?>
                     <div class="service-img">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim3"]; ?>" 
                           data-fancybox="gallery">
                           <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim3"]; ?>" 
                                alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                           <div class="zoom-icon" title="<?php echo LANG('zoom_image', $lang); ?>">
                              <i class="fas fa-search-plus"></i>
                           </div>
                        </a>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php include 'alt.php'; ?>
   
   <!-- Fancybox JS -->
   <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
   <script>
      Fancybox.bind("[data-fancybox]", {
         // Fancybox options
      });
   </script>
</body>

</html>