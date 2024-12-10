<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_anasayfa', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
      
    </head>
   <body>
     <?php include 'ust.php'; ?>
      <main>
       <section class="slider-area fix">
         <div class="swiper main-slider swiper-container swiper-container-fade">
            <div class="swiper-wrapper p-relative">
                <?php
                // Ana slayt sorgusu
                $veri_cek = $db->query("SELECT * FROM slayt 
                                       WHERE slayt_durum = 1 
                                       AND dil_id = '$lang' 
                                       ORDER BY row ASC");

                error_log("Slayt sorgusu - Dil: $lang, Sonuç: " . $veri_cek->rowCount());

                if ($veri_cek->rowCount()) {
                    foreach($veri_cek as $veri_listele) {
                ?>
                    <div class="item-slider sliderm-height p-relative swiper-slide">
                        <?php if($veri_listele["slayt_resim"]) { ?>
                            <div class="slide-bg" style="background: url(<?php echo $ayarlar["strURL"]; ?>/uploads/sliders/<?php echo $veri_listele["slayt_resim"]; ?>) no-repeat center center; background-size: cover;"></div>
                        <?php } ?>
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-contant mt-25">
                                        <?php if($veri_listele["slayt_baslik"]) { ?>
                                            <span data-animation="fadeInUp" data-delay=".3s">
                                                <?php echo $veri_listele["slayt_baslik"]; ?>
                                            </span>
                                        <?php } ?>

                                        <?php if($veri_listele["slayt_aciklama"]) { ?>
                                            <h2 class="slider-title" data-animation="fadeInUp" data-delay=".6s">
                                                <?php echo $veri_listele["slayt_aciklama"]; ?>
                                            </h2>
                                        <?php } ?>

                                        <div class="slider-button" data-animation="fadeInUp" data-delay=".9s">
                                            <?php if($veri_listele["slayt_buton"] && $veri_listele["slayt_butonlink"]) { ?>
                                                <a href="<?php echo $ayarlar["strURL"]; ?>/<?php echo $veri_listele["slayt_butonlink"]; ?>" 
                                                   class="tp-btn mr-30">
                                                    <?php echo $veri_listele["slayt_buton"]; ?>
                                                    <i class="fal fa-angle-right"></i>
                                                </a>
                                            <?php } ?>
                                            <a href="<?php echo $ayarlar["strURL"]; ?>/iletisim" class="tp-btn-2">
                                                <?php echo LANG('iletisim', $lang); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    error_log("Slayt bulunamadı - Dil: $lang");
                }
                ?>
            </div>
            <!-- Navigasyon butonları -->
            <div class="swiper-button-prev ms-button"><i class="far fa-long-arrow-left"></i></div>
            <div class="swiper-button-next ms-button"><i class="far fa-long-arrow-right"></i></div>
         </div>
      </section>
      <section class="main-slider-dot">
         <div class="container">
            <div class="swiper main-slider-nav">
               <div class="swiper-wrapper">
                 <?php
                // Alt slayt noktaları için sorgu
                $veri_cek = $db->query("SELECT * FROM slayt 
                                       WHERE slayt_durum = 1 
                                       AND dil_id = '$lang' 
                                       ORDER BY row ASC");

                if ($veri_cek->rowCount()) {
                    foreach($veri_cek as $veri_listele) {
                ?>
                    <div class="swiper-slide">
                        <div class="sm-button">
                            <div class="sm-services__text">
                                <?php if($veri_listele["slayt_baslik"]) { ?>
                                    <span><?php echo $veri_listele["slayt_baslik"]; ?></span>
                                <?php } ?>
                                
                                <?php if($veri_listele["slayt_aciklama"]) { ?>
                                    <h4><?php echo $veri_listele["slayt_aciklama"]; ?></h4>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                }
                ?>
               </div>
            </div>
         </div>
      </section>
      <?php
          $veri_cek = $db->query("SELECT * FROM kurumsal 
                                  WHERE haber_durum = 1 
                                  AND dil_id = '$lang' 
                                  ORDER BY haber_ust_id ASC 
                                  LIMIT 1");
          error_log("Anasayfa kurumsal sorgusu - Dil: $lang, Sonuç: " . $veri_cek->rowCount());

          if ($veri_cek->rowCount()) {
              foreach($veri_cek as $veri_listele) {
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
                                    <p><?php echo LANG('yillik_tecrube', $lang); ?></p>
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
                        <h4 class="section__title"><?php echo LANG('bizi_daha_yakindan_taniyin', $lang); ?></h4>
                        <div class="r-text">
                           <span><?php echo LANG('kurumsal', $lang); ?></span>
                        </div>
                     </div>
                      <?php if($veri_listele["haber_aciklama"]) { ?>
                          <?php echo $veri_listele["haber_aciklama"]; ?>
                      <?php } ?>
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

      <!-- Hizmetlerimiz Bölümü -->
      <section class="services__area pt-10 pb-85 fix">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6 col-md-6">
                  <div class="section__wrapper section__wrapper-2 mb-50">
                      <h4 class="section__title"><?php echo LANG('menu_hizmetler', $lang); ?></h4>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6">
                  <div class="services__more text-md-end mb-50">
                      <a href="<?php echo $ayarlar["strURL"]; ?>/hizmetler" class="tp-btn">
                          <?php echo LANG('tum_hizmetler', $lang); ?>
                          <i class="far fa-long-arrow-right"></i>
                      </a>
                  </div>
               </div>
            </div>

            <div class="row">
               <?php
               $veri_cek = $db->query("SELECT * FROM hizmetler 
                                      WHERE haber_durum = 1 
                                      AND dil_id = '$lang' 
                                      ORDER BY row ASC 
                                      LIMIT 3");
               if ($veri_cek->rowCount()){
                   foreach($veri_cek as $veri_listele){
               ?>
               <div class="col-xl-4 col-lg-4 col-md-6">
                  <div class="service-card" style="background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 30px; transition: all 0.3s ease;">
                     <!-- Ana Resim -->
                     <div class="service-image" style="position: relative; height: 250px; overflow: hidden;">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>" 
                             alt="<?php echo $veri_listele["haber_baslik"]; ?>"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                     </div>

                     <!-- İçerik -->
                     <div class="service-content" style="padding: 25px;">
                        <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; color: #040404;">
                           <?php echo $veri_listele["haber_baslik"]; ?>
                        </h3>
                        <p style="color: #666; font-size: 15px; line-height: 1.6; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                           <?php echo strip_tags(mb_substr($veri_listele["haber_aciklama"], 0, 150)) . '...'; ?>
                        </p>

                        <!-- Ek Resimler -->
                        <div class="service-gallery" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 20px 0;">
                           <?php if($veri_listele["haber_resim2"]) { ?>
                           <div class="gallery-item" style="height: 120px; border-radius: 8px; overflow: hidden;">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim2"]; ?>" 
                                   alt="<?php echo $veri_listele["haber_baslik"]; ?>"
                                   style="width: 100%; height: 100%; object-fit: cover;">
                           </div>
                           <?php } ?>
                           
                           <?php if($veri_listele["haber_resim3"]) { ?>
                           <div class="gallery-item" style="height: 120px; border-radius: 8px; overflow: hidden;">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim3"]; ?>" 
                                   alt="<?php echo $veri_listele["haber_baslik"]; ?>"
                                   style="width: 100%; height: 100%; object-fit: cover;">
                           </div>
                           <?php } ?>
                        </div>

                        <!-- Detay Linki -->
                        <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>" 
                           class="service-link" 
                           style="display: inline-flex; align-items: center; color: #da963e; font-weight: 500; text-decoration: none; transition: all 0.3s ease;">
                           <?php echo LANG('detayli_bilgi', $lang); ?>
                           <i class="fas fa-arrow-right" style="margin-left: 8px; transition: transform 0.3s ease;"></i>
                        </a>
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

      <section class="brand__area pb-50">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="brand__title text-center">
                     <span><?php echo LANG('referanslar', $lang); ?></span>
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
                     <h4 class="section__title"><?php echo LANG('haberler', $lang); ?></h4>
                     <div class="r-text">
                        <span><?php echo $ayarlar["strTitle"]; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="team__buttons text-lg-end">
                     <a href="<?php echo $ayarlar["strURL"]; ?>/haberler" class="tp-join-btn">
                        <?php echo LANG('diger_haberler', $lang); ?>
                     </a>
                  </div>
               </div>
            </div>
            <div class="row mt-40">
                <?php
                // Ana sayfa haberler sorgusu
                $veri_cek = $db->query("SELECT * FROM haberler 
                                       WHERE haber_durum = 1 
                                       AND dil_id = '$lang' 
                                       ORDER BY haber_ust_id DESC 
                                       LIMIT 3");

                error_log("Anasayfa haberler sorgusu - Dil: $lang, Sonuç: " . $veri_cek->rowCount());

                if ($veri_cek->rowCount()) {
                    foreach($veri_cek as $veri_listele) {
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="blog__item-2 blog__item-2-df mb-40">
                            <div class="blog__item-2-image">
                                <div class="blog__item-2-image-inner w-img">
                                    <?php if($veri_listele["haber_resim"]) { ?>
                                        <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>">
                                            <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $veri_listele["haber_resim"]; ?>" 
                                                 alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="blog__item-2-content">
                                <div class="blog__meta">
                                    <div class="blog__author">
                                        <i class="fas fa-calendar"></i>
                                        <span><?php echo date("d/m/Y", strtotime($veri_listele["haber_tarih"])); ?></span>
                                    </div>
                                </div>
                                <h5 class="blog__sm-title">
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>">
                                        <?php echo $veri_listele["haber_baslik"]; ?>
                                    </a>
                                </h5>
                                <?php if($veri_listele["haber_kisaaciklama"]) { ?>
                                    <p><?php echo $veri_listele["haber_kisaaciklama"]; ?></p>
                                <?php } ?>
                            </div>
                            <div class="blog__btn-2">
                                <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>" class="link-btn">
                                    <?php echo LANG('devamini_oku', $lang); ?> 
                                    <i class="fal fa-long-arrow-right"></i>
                                </a>
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
