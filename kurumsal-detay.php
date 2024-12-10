<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");

// Önce seçili dilde içeriği deneyelim
$tekil_veri_cek = $db->query("SELECT * FROM kurumsal 
                             WHERE haber_durum = 1 
                             AND haber_seo = '{$_GET["url"]}' 
                             AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);

if(!$tekil_veri_cek) {
    // Seçili dilde içerik yoksa, bu SEO URL'ye sahip TR içeriği bulalım
    $tr_veri = $db->query("SELECT * FROM kurumsal 
                          WHERE haber_durum = 1 
                          AND haber_seo = '{$_GET["url"]}' 
                          AND dil_id = 'tr'")->fetch(PDO::FETCH_ASSOC);
    
    if($tr_veri) {
        // TR içeriğin ust_id'sine göre seçili dildeki karşılığını bulalım
        $tekil_veri_cek = $db->query("SELECT * FROM kurumsal 
                                     WHERE haber_durum = 1 
                                     AND haber_ust_id = '{$tr_veri["haber_ust_id"]}' 
                                     AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);
        
        // Seçili dilde karşılığı yoksa TR içeriği gösterelim
        if(!$tekil_veri_cek) {
            $tekil_veri_cek = $tr_veri;
        }
    } else {
        // Hiç içerik bulunamadıysa 404 sayfasına yönlendir
        header("Location: ".$ayarlar["strURL"]."/404");
        exit;
    }
}

// Diğer dillerdeki karşılıklarını bulalım (dil menüsü için)
$dil_karsiliklari = $db->query("SELECT k.haber_seo, k.dil_id, d.dil_kod, d.dil_baslik 
                               FROM kurumsal k
                               INNER JOIN dil d ON d.dil_kod = k.dil_id  
                               WHERE k.haber_ust_id = '{$tekil_veri_cek["haber_ust_id"]}' 
                               AND k.haber_durum = 1")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <!-- Dil linkleri için canonical ve alternate tagları -->
       <link rel="canonical" href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $tekil_veri_cek["haber_seo"]; ?>" />
       <?php foreach($dil_karsiliklari as $dk) { ?>
           <link rel="alternate" hreflang="<?php echo $dk["dil_kod"]; ?>" 
                 href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $dk["haber_seo"]; ?>" />
       <?php } ?>
       <?php include 'css.php'; ?>
       <style>
       /* Genel Stiller */
       :root {
           --primary-color: #da963e;
           --secondary-color: #040404;
           --heading-color: #040404;
       }

       /* About Bölümü */
       .about-image-grid {
           position: relative;
           margin-bottom: 30px;
       }

       .about-image-grid .main-image {
           border-radius: 15px;
           overflow: hidden;
           box-shadow: 0 10px 30px rgba(0,0,0,0.1);
       }

       .experience-box {
           position: absolute;
           bottom: 30px;
           right: 30px;
           background: var(--primary-color);
           color: #fff;
           padding: 25px 35px;
           border-radius: 15px;
           text-align: center;
           box-shadow: 0 5px 20px rgba(0,0,0,0.2);
       }

       .year-count .count {
           font-size: 48px;
           font-weight: 700;
           line-height: 1;
           margin-bottom: 5px;
           display: block;
           color: #fff;
       }

       .year-count p {
           margin: 0;
           font-size: 16px;
           opacity: 0.9;
       }

       /* Misyon Vizyon Kalite Kartları */
       .mission-vision {
           background-color: #f8f9fa;
           padding: 80px 0;
       }

       .card {
           border: none;
           border-radius: 15px;
           box-shadow: 0 5px 25px rgba(0,0,0,0.05);
           transition: all 0.3s ease;
           height: 100%;
       }

       .card:hover {
           transform: translateY(-10px);
           box-shadow: 0 15px 35px rgba(0,0,0,0.1);
       }

       .card-body {
           padding: 2rem;
       }

       .icon-box {
           color: var(--primary-color);
           margin-bottom: 1.5rem;
       }

       .card-title {
           color: var(--secondary-color);
           font-size: 24px;
           margin-bottom: 1rem;
           font-weight: 600;
       }

       .card-text {
           color: #666;
           line-height: 1.6;
       }

       /* Hizmetler Bölümü */
       .services-section {
           padding: 80px 0;
           background: #fff;
       }

       .section-title {
           margin-bottom: 50px;
           text-align: center;
       }

       .section-title h2 {
           color: var(--secondary-color);
           font-size: 36px;
           font-weight: 700;
           margin-bottom: 20px;
       }

       .divider {
           width: 80px;
           height: 4px;
           background: var(--primary-color);
           margin: 15px auto;
           border-radius: 2px;
       }

       .service-card {
           border: none;
           border-radius: 15px;
           overflow: hidden;
           box-shadow: 0 5px 25px rgba(0,0,0,0.05);
           transition: all 0.3s ease;
           height: 100%;
       }

       .service-card:hover {
           transform: translateY(-10px);
           box-shadow: 0 15px 35px rgba(0,0,0,0.1);
       }

       .service-img {
           position: relative;
           overflow: hidden;
       }

       .service-img img {
           transition: all 0.5s ease;
       }

       .service-card:hover .service-img img {
           transform: scale(1.1);
       }

       .service-content {
           padding: 25px;
           background: #fff;
       }

       .service-content h4 {
           font-size: 20px;
           margin-bottom: 15px;
       }

       .service-content h4 a {
           color: var(--secondary-color);
           text-decoration: none;
           transition: color 0.3s ease;
       }

       .service-content h4 a:hover {
           color: var(--primary-color);
       }

       .service-content p {
           color: #666;
           margin: 0;
           line-height: 1.6;
       }

       /* About Content Bölümü */
       .about-content {
           padding: 20px;
       }

       .about-content .title {
           font-size: 36px;
           color: var(--secondary-color);
           font-weight: 700;
           margin-bottom: 20px;
       }

       .about-text {
           color: #666;
           line-height: 1.8;
           font-size: 16px;
       }

       /* Responsive Düzenlemeler */
       @media (max-width: 991px) {
           .experience-box {
               position: relative;
               bottom: auto;
               right: auto;
               margin-top: 20px;
               display: inline-block;
           }
           
           .section-title h2 {
               font-size: 30px;
           }
           
           .card-title {
               font-size: 20px;
           }
       }

       @media (max-width: 767px) {
           .about-content .title {
               font-size: 28px;
           }
           
           .service-content h4 {
               font-size: 18px;
           }
           
           .experience-box {
               width: 100%;
               text-align: center;
           }
       }

       /* Hero bölümü için arka plan */
       .page__title-area {
           background-image: url('/admin/images/image.jpg') !important;
           background-size: cover;
           background-position: center;
           position: relative;
       }

       .page__title-area::before {
           content: '';
           position: absolute;
           top: 0;
           left: 0;
           right: 0;
           bottom: 0;
           background: rgba(4, 4, 4, 0.6); /* var(--secondary-color) with opacity */
       }

       /* Diğer renk güncellemeleri */
       .card-title {
           color: var(--secondary-color);
       }

       .section-title h2 {
           color: var(--secondary-color);
       }

       .about-content .title {
           color: var(--secondary-color);
       }

       /* Hover efektlerinde primary renk kullanımı */
       .card:hover {
           border-color: var(--primary-color);
       }

       .service-card:hover .service-content h4 a {
           color: var(--primary-color);
       }

       /* Primary renk için buton ve link stilleri */
       .btn-primary {
           background-color: var(--primary-color);
           border-color: var(--primary-color);
       }

       .btn-primary:hover {
           background-color: var(--secondary-color);
           border-color: var(--secondary-color);
       }

       /* Text vurgu rengi */
       ::selection {
           background: var(--primary-color);
           color: #fff;
       }

       /* Breadcrumb renk güncellemesi */
       .breadcrumb-menu ul li a:hover {
           color: var(--primary-color);
       }
       </style>
    </head>
   <body>
     <?php include 'ust.php'; ?>
      <main>
       <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center" data-background="<?php echo $ayarlar["strURL"]; ?>/assets/img/bg/page-bg.jpg">
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="page__title-wrapper mt-100">
                     <div class="breadcrumb-menu">
                        <ul>
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                            <li><span><?php echo LANG('menu_kurumsal', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="about__area-2 pt-150 pb-90">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6">
                  <div class="about-image-grid">
                     <?php if($tekil_veri_cek["haber_resim"]) { ?>
                     <div class="main-image">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/image.jpg" 
                             alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>" class="img-fluid w-100 mb-4">
                     </div>
                     <?php } ?>
                     
                     <?php if($tekil_veri_cek["haber_yillik"]) { ?>
                     <div class="experience-box">
                        <div class="year-count">
                           <span class="count"><?php echo $tekil_veri_cek["haber_yillik"]; ?>+</span>
                           <p><?php echo LANG('yillik_tecrube', $lang); ?></p>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="about-content">
                     <div class="section-title mb-4">
                        <h2 class="title"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h2>
                        <div class="divider"></div>
                     </div>
                     
                     <div class="about-text">
                        <?php echo $tekil_veri_cek["haber_aciklama"]; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="mission-vision bg-light py-5">
         <div class="container">
            <div class="row">
               <?php if($tekil_veri_cek["haber_description"]) { ?>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100">
                     <div class="card-body text-center">
                        <div class="icon-box mb-3">
                           <i class="fas fa-bullseye fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title"><?php echo LANG('misyonumuz', $lang); ?></h4>
                        <p class="card-text"><?php echo $tekil_veri_cek["haber_description"]; ?></p>
                     </div>
                  </div>
               </div>
               <?php } ?>

               <?php if($tekil_veri_cek["haber_kisaaciklama"]) { ?>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100">
                     <div class="card-body text-center">
                        <div class="icon-box mb-3">
                           <i class="fas fa-eye fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title"><?php echo LANG('vizyonumuz', $lang); ?></h4>
                        <p class="card-text"><?php echo $tekil_veri_cek["haber_kisaaciklama"]; ?></p>
                     </div>
                  </div>
               </div>
               <?php } ?>

               <?php if($tekil_veri_cek["haber_kalite"]) { ?>
               <div class="col-lg-4 mb-4">
                  <div class="card h-100">
                     <div class="card-body text-center">
                        <div class="icon-box mb-3">
                           <i class="fas fa-award fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title"><?php echo LANG('kalite_politikamiz', $lang); ?></h4>
                        <p class="card-text"><?php echo $tekil_veri_cek["haber_kalite"]; ?></p>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </section>

      <section class="services-section py-5">
         <div class="container">
            <div class="section-title text-center mb-5">
               <h2><?php echo LANG('hizmetlerimiz_title', $lang); ?></h2>
               <div class="divider mx-auto"></div>
            </div>

            <div class="row">
               <?php
               $veri_cek = $db->query("SELECT * FROM hizmetler 
                                      WHERE haber_durum = 1 
                                      AND dil_id = '$lang' 
                                      ORDER BY haber_ust_id ASC LIMIT 4");
               if ($veri_cek->rowCount()){
                  foreach($veri_cek as $veri_listele){
               ?>
               <div class="col-lg-3 col-md-6 mb-4">
                  <div class="service-card">
                     <div class="service-img">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>" 
                             alt="<?php echo $veri_listele["haber_baslik"]; ?>" 
                             class="img-fluid w-100">
                     </div>
                     <div class="service-content p-4">
                        <h4><a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>">
                           <?php echo $veri_listele["haber_baslik"]; ?>
                        </a></h4>
                        <?php if($veri_listele["haber_kisaaciklama"]) { ?>
                        <p class="mb-0"><?php echo $veri_listele["haber_kisaaciklama"]; ?></p>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php
                  }
               } else {
                  echo '<div class="col-12 text-center">' . LANG('listelenecek_veri_bulunamadi', $lang) . '</div>';
               }
               ?>
            </div>
         </div>
      </section>
     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
