<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_projeler', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/" class="breadcrumb-item"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                            <li><span class="breadcrumb-item active"><?php echo LANG('menu_projeler', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_projeler', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
     <section class="portfolio-area pt-110 pb-110">
       <div class="container">
           <div id="portfolio-grid" class="row grid">
             <?php
                 $veri_cek = $db->query("SELECT * FROM projeler WHERE proje_durum = 1 AND dil_id = '$lang' ORDER BY proje_ust_id ASC");
                 
                 error_log("Projeler sorgusu için dil: " . $lang);
                 error_log("Bulunan proje sayısı: " . $veri_cek->rowCount());
                 
                 if ($veri_cek->rowCount()) {
                     foreach($veri_cek as $veri_listele) {
             ?> <div class="col-lg-4 col-md-6 grid-item">
                    <div class="portfolio-item mb-30">
                       <div class="portfolio-wrapper">
                          <div class="portfolio-image w-img">
                            <a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>">
                               <div class="project-image-container">
                                   <?php if($veri_listele["proje_resim"]) { ?>
                                       <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/projects/<?php echo $veri_listele["proje_resim"]; ?>" 
                                            alt="<?php echo $veri_listele["proje_baslik"]; ?>"
                                            class="portfolio-img"
                                            style="width: 100%; height: auto; object-fit: cover;">
                                   <?php } else { ?>
                                       <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/no-image.jpg" 
                                            alt="<?php echo $veri_listele["proje_baslik"]; ?>"
                                            class="portfolio-img"
                                            style="width: 100%; height: auto; object-fit: cover;">
                                   <?php } ?>
                               </div>
                            </a>
                          </div>
                          <div class="portfolio-caption">
                             <h6 class="portfolio-title">
                                 <a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>">
                                     <?php echo $veri_listele["proje_baslik"]; ?>
                                 </a>
                             </h6>
                             <p class="portfolio-description">
                                 <?php echo LANG('proje_detay', $lang); ?>
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>
                 <?php
                     }
                 } else {
                     echo '<div class="col-12 text-center">
                             <div class="alert alert-warning">
                                 '.LANG('listelenecek_veri_bulunamadi', $lang).'
                             </div>
                           </div>';
                     
                     $tum_projeler = $db->query("SELECT * FROM projeler")->rowCount();
                     error_log("Toplam proje sayısı: " . $tum_projeler);
                 }
             ?>
            </div>
       </div>
   </section>
     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
