<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title>Anasayfa - AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları </title>
       <?php include 'css.php'; ?>
       <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tailwind ve mevcut CSS'in çakışmaması için özel stiller -->
    <style>
        /* Tailwind dropdown'ın üstte görünmesi için */
        .header-info .relative {
            z-index: 50;
        }
        
        /* Hover durumunda dropdown'ın görünmesi için */
        .group:hover .group-hover\:visible {
            visibility: visible;
        }
        
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
    </style>
    <meta http-equiv="Content-Security-Policy" 
          content="script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com;">
    </head>
   <body>
     <?php include 'ust.php'; ?>
      <main>
       <section class="slider-area fix">
         <div class="swiper main-slider swiper-container swiper-container-fade">
            <div class="swiper-wrapper p-relative">
                <?php
                            				$veri_cek = $db->query("SELECT * FROM slayt WHERE slayt_durum = 1 AND dil_id = 'tr' ORDER BY slayt_ust_id ASC LIMIT 99");
                             				if ($veri_cek->rowCount()){
                            				foreach($veri_cek as $veri_listele){
                            ?>
                             <div class="item-slider sliderm-height p-relative swiper-slide">
                                <div class="slide-bg" style="background: url(<?php echo $ayarlar["strURL"]; ?>/uploads/sliders/<?php echo $veri_listele["slayt_resim"]; ?>)"></div>
                                <div class="container">
                                   <div class="row ">
                                      <div class="col-lg-12">
                                         <div class="slider-contant mt-25">
                                             <span data-animation="fadeInUp" data-delay=".3s"><?php echo 	$veri_listele["slayt_baslik"]; ?></span>
                                             <h2 class="slider-title" data-animation="fadeInUp" data-delay=".6s"><?php echo 	$veri_listele["slayt_aciklama"]; ?></h2>
                                             <div class="slider-button" data-animation="fadeInUp" data-delay=".9s">
                                                 <a href="<?php echo $ayarlar["strURL"]; ?>/<?php echo 	$veri_listele["slayt_butonlink"]; ?>" class="tp-btn mr-30"><?php echo 	$veri_listele["slayt_buton"]; ?> <i class="fal fa-angle-right"></i></a>
                                                 <a href="<?php echo $ayarlar["strURL"]; ?>/iletisim" class="tp-btn-2">İletişim</a>
                                             </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                             <?php
                                       }
                                     }else{
                                       "Listelenecek veri bulunamadı.";
                                     }
                             ?>

            </div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev ms-button"><i class="far fa-long-arrow-left"></i></div>
            <div class="swiper-button-next ms-button"><i class="far fa-long-arrow-right"></i></div>
         </div>
      </section>
      <section class="main-slider-dot">
         <div class="container">
            <div class="swiper main-slider-nav">
               <div class="swiper-wrapper">
                 <?php
                                    $veri_cek = $db->query("SELECT * FROM slayt WHERE slayt_durum = 1 AND dil_id = 'tr' ORDER BY slayt_ust_id ASC LIMIT 99");
                                      if ($veri_cek->rowCount()){
                                    foreach($veri_cek as $veri_listele){
                             ?>
                  <div class="swiper-slide">
                     <div class="sm-button">

                        <div class="sm-services__text">
                              <span><?php echo 	$veri_listele["slayt_baslik"]; ?></span>
                           <h4><?php echo 	$veri_listele["slayt_aciklama"]; ?></h4>
                        </div>
                     </div>
                  </div>
                  <?php
                            }
                          }else{
                            "Listelenecek veri bulunamadı.";
                          }
                  ?>
               </div>
            </div>
         </div>
      </section>
      <?php
          $veri_cek = $db->query("SELECT * FROM kurumsal WHERE haber_durum = 1 AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 1");
          if ($veri_cek->rowCount()){
          foreach($veri_cek as $veri_listele){
      ?>
      <section class="about__area-2 pt-100 pb-50">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="about__sm-image about__sm-image-df">
                           <div class="sm-image__item w-img mb-30">
                              <a href="#"><img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/about/2/about-img-2.jpg" alt="ab-img"></a>
                           </div>
                           <div class="sm-image__item w-img mb-30">
                              <a href="#"><img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/about/2/about-img-3.jpg" alt="ab-img"></a>
                              <div class="sm-image__content">
                                 <div class="sm-number">
                                    <a href="#"><?php echo $veri_listele["haber_yillik"]; ?> <span>+</span></a>
                                    <p>Yıllık Tecrübe</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="about__sm-image">
                           <div class="sm-image__item w-img mb-30">
                              <a href="#"><img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/about/2/about-img-4.jpg" alt="ab-img"></a>
                           </div>
                           <div class="sm-image__item w-img mb-30">
                              <a href="#"><img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/about/2/about-img-5.jpg" alt="ab-img"></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="ab-left-content">
                     <div class="section__wrapper mb-30">
                        <h4 class="section__title">Bizi daha yakından <br> tanıyın.</h4>
                        <div class="r-text">
                           <span>KURUMSAL</span>
                        </div>
                     </div>
                      <?php echo $veri_listele["haber_aciklama"]; ?>
                  </div>
               </div>
            </div>
         </div>
      </section>    <?php
                    }
                  }else{
                    "Listelenecek veri bulunamadı.";
                  }
           ?>

      <section class="project__area pt-10 pb-85 fix">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="section__wrapper section__wrapper-2 mb-50">
                <h4 class="section__title">Projelerimiz</h4>
            </div>
         </div>
         <div class="col-xl-6 col-lg-6 col-md-6">
            <!-- If we need navigation buttons -->
            <div class="project__slider-arrow-wrapper mb-50 text-sm-end">
               <div class="project__slider-arrow">
                  <div class="project-button-prev ms-button-3 ms-button-3-border"><i class="far fa-long-arrow-left"></i> Geri</div>
                  <div class="project-button-next ms-button-3">İleri <i class="far fa-long-arrow-right"></i></div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12">
            <div class="project__slider project__slider-active swiper-container">
               <div class="project___slider-wrapper swiper-wrapper">
                 <?php
                     $veri_cek = $db->query("SELECT * FROM projeler WHERE proje_durum = 1");
                     if ($veri_cek->rowCount()){
                     foreach($veri_cek as $veri_listele){
                 ?>

                  <div class="project__slider-item swiper-slide">
                     <div class="project__slider-item-image mb-30" data-background="<?php echo $ayarlar["strURL"]; ?>/uploads/projects/<?php echo $veri_listele["proje_resim"]; ?>">
                        <div class="project__slider-item-overlay">
                           <a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>"><i class="fa-solid fa-plus"></i></a>
                        </div>
                     </div>
                     <span><a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>">AS-TEK Makina</a></span>
                     <h5 class="project__slider-item-title"><a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>"><?php echo 	$veri_listele["proje_baslik"]; ?></a></h5>
                  </div>
                  <?php
                          }
                        }else{
                          "Listelenecek veri bulunamadı.";
                        }
                  ?>
                </div>
            </div>
         </div>
      </div>
   </div>
</section>
      <section class="brand__area pb-50">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="brand__title text-center">
                     <span>Referanslar</span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div class="brand__slider swiper-container">
                     <div class="swiper-wrapper">
                       <?php

                     $list = $db->query("SELECT * FROM files WHERE ustid = 2 AND itable = 1");
                     foreach($list as $row){
                     ?>
                        <div class="brand__slider-item swiper-slide">
                        <a href="#"><img  style="width: 150px;" src="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $row["name"]?>" alt="Referanslar"></a>
                        </div>
                        <?php
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>


      <section class="blog__area pt-50 pb-20">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6">
                  <div class="section__wrapper mb-40">
                     <h4 class="section__title">Haberler</h4>
                     <div class="r-text">
                        <span>AS-TEK</span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="team__buttons text-lg-end">
                     <a href="<?php echo $ayarlar["strURL"]; ?>/haberler" class="tp-join-btn">Diğer Haberler </a>
                  </div>
               </div>
            </div>
            <div class="row mt-40">

                  <?php
              				$veri_cek = $db->query("SELECT * FROM haberler WHERE haber_durum = 1 AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 3");
               				if ($veri_cek->rowCount()){
              				foreach($veri_cek as $veri_listele){
              ?> <div class="col-xl-4 col-lg-4 col-md-6">
                  <div class="blog__item-2 blog__item-2-df mb-40">
                     <div class="blog__item-2-image">
                           <div class="blog__item-2-image-inner w-img">
                              <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>"><img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $veri_listele["haber_resim"]; ?>" alt="<?php echo 	$veri_listele["haber_baslik"]; ?>"></a>
                           </div>
                     </div>
                     <div class="blog__item-2-content">
                        <div class="blog__meta">
                           <div class="blog__author">
                              <i class="fas fa-calendar"></i>
                              <span><?php echo date("d/m/Y", strtotime($veri_listele["haber_tarih"])); ?></span>
                           </div>
                        </div>
                        <h5 class="blog__sm-title"><a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></h5>
                     </div>
                     <div class="blog__btn-2">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>" class="link-btn"> Devamını Oku <i class="fal fa-long-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <?php
                         }
                       }else{
                         "Listelenecek veri bulunamadı.";
                       }
               ?>
             </div>
         </div>
      </section>


     </main>

<?php include 'alt.php'; ?>
   </body>
</html>
