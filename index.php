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
                                            <span data-animation="fadeInUp" data-delay=".3s" style="margin-bottom: 20px; display: block; color: #f5f5f5; font-size: 1.1em;">
                                                <?php echo $veri_listele["slayt_baslik"]; ?>
                                            </span>
                                        <?php } ?>

                                        <?php if($veri_listele["slayt_aciklama"]) { ?>
                                            <h2 class="slider-title" data-animation="fadeInUp" data-delay=".6s" style="padding-top: 15px; font-size: 2.5em; font-weight: 600; line-height: 1.4; margin-bottom: 30px;">
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

          // Hizmet fotoğraflarını çek
          $hizmet_fotograflari = $db->query("SELECT haber_resim, haber_resim2, haber_resim3 
                                            FROM hizmetler 
                                            WHERE haber_durum = 1 
                                            AND dil_id = '$lang' 
                                            ORDER BY RAND() 
                                            LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

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
                           <?php if(isset($hizmet_fotograflari[0])) { ?>
                           <div class="sm-image__item w-img mb-30">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $hizmet_fotograflari[0]['haber_resim2']; ?>" 
                                   alt="Hizmet Görseli" style="width: 100%; height: 250px; object-fit: cover;">
                           </div>
                           <?php } ?>
                           
                           <?php if(isset($hizmet_fotograflari[1])) { ?>
                           <div class="sm-image__item w-img mb-30">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $hizmet_fotograflari[1]['haber_resim2']; ?>" 
                                   alt="Hizmet Görseli" style="width: 100%; height: 250px; object-fit: cover;">
                              <div class="sm-image__content">
                                 <div class="sm-number">
                                    <a href="#"><?php echo $veri_listele["haber_yillik"]; ?> <span>+</span></a>
                                    <p><?php echo LANG('yillik_tecrube', $lang); ?></p>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="about__sm-image">
                           <?php if(isset($hizmet_fotograflari[2])) { ?>
                           <div class="sm-image__item w-img mb-30">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $hizmet_fotograflari[2]['haber_resim2']; ?>" 
                                   alt="Hizmet Görseli" style="width: 100%; height: 250px; object-fit: cover;">
                           </div>
                           <?php } ?>
                           
                           <?php if(isset($hizmet_fotograflari[3])) { ?>
                           <div class="sm-image__item w-img mb-30">
                              <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $hizmet_fotograflari[3]['haber_resim2']; ?>" 
                                   alt="Hizmet Görseli" style="width: 100%; height: 250px; object-fit: cover;">
                           </div>
                           <?php } ?>
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
                      <a href="<?php echo $ayarlar["strURL"]; ?>/hizmetler" class="tp-join-btn">
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
                  <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>" 
                     class="service-card-link">
                     <div class="service-card">
                        <!-- Ana Resim -->
                        <div class="service-image">
                           <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>" 
                                alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                           <div class="service-overlay"></div>
                        </div>

                        <!-- İçerik -->
                        <div class="service-content">
                           <h3><?php echo $veri_listele["haber_baslik"]; ?></h3>
                           <p><?php echo strip_tags(mb_substr($veri_listele["haber_aciklama"], 0, 150)) . '...'; ?></p>

                           <!-- Ek Resimler -->
                           <div class="service-gallery">
                              <?php if($veri_listele["haber_resim2"]) { ?>
                              <div class="gallery-item">
                                 <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim2"]; ?>" 
                                      alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                              </div>
                              <?php } ?>
                              
                              <?php if($veri_listele["haber_resim3"]) { ?>
                              <div class="gallery-item">
                                 <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim3"]; ?>" 
                                      alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                              </div>
                              <?php } ?>
                           </div>

                           <!-- Detay Linki -->
                           <div class="service-link">
                              <?php echo LANG('detayli_bilgi', $lang); ?>
                              <i class="fas fa-arrow-right"></i>
                           </div>
                        </div>
                     </div>
                  </a>
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

      <!-- Hizmetler için stil eklemeleri -->
      <style>
      .service-card-link {
          display: block;
          text-decoration: none;
          color: inherit;
      }

      .service-card {
          background: #fff;
          border-radius: 15px;
          box-shadow: 0 5px 20px rgba(0,0,0,0.08);
          overflow: hidden;
          margin-bottom: 30px;
          transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
          position: relative;
      }

      .service-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 15px 30px rgba(218, 150, 62, 0.15);
      }

      .service-image {
          position: relative;
          height: 250px;
          overflow: hidden;
      }

      .service-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
      }

      .service-overlay {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: rgba(218, 150, 62, 0);
          transition: all 0.4s ease;
      }

      .service-card:hover .service-image img {
          transform: scale(1.08);
      }

      .service-card:hover .service-overlay {
          background: rgba(218, 150, 62, 0.2);
      }

      .service-content {
          padding: 25px;
          position: relative;
      }

      .service-content h3 {
          font-size: 22px;
          font-weight: 600;
          margin-bottom: 15px;
          color: #221E1F;
          transition: color 0.3s ease;
      }

      .service-card:hover .service-content h3 {
          color: #da963e;
      }

      .service-content p {
          color: #666;
          font-size: 15px;
          line-height: 1.6;
          margin-bottom: 20px;
          display: -webkit-box;
          -webkit-line-clamp: 3;
          -webkit-box-orient: vertical;
          overflow: hidden;
      }

      .service-gallery {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 10px;
          margin: 20px 0;
      }

      .gallery-item {
          height: 120px;
          border-radius: 8px;
          overflow: hidden;
          position: relative;
      }

      .gallery-item img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.4s ease;
      }

      .service-card:hover .gallery-item img {
          transform: scale(1.05);
      }

      .service-link {
          display: inline-flex;
          align-items: center;
          color: #da963e;
          font-weight: 500;
          margin-top: 10px;
          transition: all 0.3s ease;
      }

      .service-link i {
          margin-left: 8px;
          transition: transform 0.3s ease;
      }

      .service-card:hover .service-link i {
          transform: translateX(5px);
      }



      @media (max-width: 768px) {
          .service-content h3 {
              font-size: 20px;
          }
          
          .service-content p {
              font-size: 14px;
          }
          
          .gallery-item {
              height: 100px;
          }
      }
      </style>

      <!-- Referanslar Bölümü -->
      <section class="brand__area pb-80 pt-50">
         <div class="container">
            <div class="row align-items-end mb-50">
               <div class="col-xl-6 col-lg-6">
                  <div class="section__wrapper">
                     <h4 class="section__title"><?php echo LANG('referanslar', $lang); ?></h4>
                     
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="team__buttons text-lg-end">
                     <a href="<?php echo $ayarlar["strURL"]; ?>/referanslar" class="tp-join-btn">
                        <?php echo LANG('tum_referanslar', $lang); ?>
                        <i class="far fa-long-arrow-right"></i>
                     </a>
                  </div>
               </div>
            </div>

            <div class="brand__slider-wrapper">
               <div class="brand__slider swiper-container">
                  <div class="swiper-wrapper">
                     <?php
                     // Referansları getir
                     $list = $db->query("SELECT * FROM referanslar 
                                        WHERE referans_durum = 1 
                                        AND dil_id = '$lang' 
                                        ORDER BY row ASC");
                     foreach($list as $row){
                     ?>
                        <div class="brand__slider-item swiper-slide">
                           <a href="<?php echo $ayarlar["strURL"]; ?>/referanslar" class="brand-item">
                              <div class="brand-image">
                                 <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/references/<?php echo $row["referans_resim"]?>" 
                                      alt="<?php echo $row["referans_baslik"]; ?>"
                                      class="brand-img">
                              </div>
                              <div class="brand-content">
                                 <h4 class="brand-title"><?php echo $row["referans_baslik"]; ?></h4>
                                 <?php if($row["referans_description"]) { ?>
                                    <p class="brand-desc"><?php echo $row["referans_description"]; ?></p>
                                 <?php } ?>
                              </div>
                           </a>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Swiper için stil eklemeleri -->
      <style>
      .brand__slider-wrapper {
          position: relative;
          padding: 0 15px;
      }

      .brand-item {
          position: relative;
          display: flex;
          flex-direction: column;
          background: #fff;
          border-radius: 12px;
          padding: 20px;
          text-align: center;
          box-shadow: 0 5px 20px rgba(0,0,0,0.05);
          transition: all 0.4s ease;
          text-decoration: none;
          height: 100%;
          min-height: 250px; /* Sabit yükseklik */
      }

      .brand-item:hover {
          transform: translateY(-5px);
          box-shadow: 0 8px 25px rgba(218, 150, 62, 0.15);
      }

      .brand-image {
          flex: 0 0 120px; /* Sabit yükseklik */
          display: flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 15px;
          padding: 10px;
          background: #f8f9fa;
          border-radius: 8px;
      }

      .brand-img {
          max-width: 100%;
          max-height: 100px;
          width: auto;
          height: auto;
          filter: grayscale(100%);
          opacity: 0.7;
          transition: all 0.4s ease;
          object-fit: contain;
      }

      .brand-item:hover .brand-img {
          filter: grayscale(0);
          opacity: 1;
      }

      .brand-content {
          flex: 1;
          display: flex;
          flex-direction: column;
          justify-content: center;
      }

      .brand-title {
          font-size: 16px;
          color: #221E1F;
          margin-bottom: 8px;
          font-weight: 600;
          transition: color 0.3s ease;
          line-height: 1.4;
      }

      .brand-desc {
          font-size: 13px;
          color: #666;
          margin: 0;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
          line-height: 1.5;
      }

      .brand-item:hover .brand-title {
          color: #da963e;
      }

      /* Swiper düzenlemeleri */
      .brand__slider .swiper-slide {
          height: auto;
          padding: 10px;
      }

      @media (max-width: 768px) {
          .brand-item {
              min-height: 220px;
          }
          .brand-image {
              flex: 0 0 100px;
          }
          .brand-img {
              max-height: 80px;
          }
      }
      </style>

      <!-- Swiper için script düzenlemeleri -->
      <script>
      document.addEventListener('DOMContentLoaded', function() {
          new Swiper('.brand__slider', {
              slidesPerView: 2,
              spaceBetween: 20,
              loop: true,
              autoplay: {
                  delay: 3000,
                  disableOnInteraction: false,
              },
              breakpoints: {
                  640: {
                      slidesPerView: 3,
                  },
                  768: {
                      slidesPerView: 4,
                  },
                  1024: {
                      slidesPerView: 5,
                  },
              }
          });
      });
      </script>

      <section class="blog__area pt-50 pb-20">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6">
                  <div class="section__wrapper mb-40">
                     <h4 class="section__title"><?php echo LANG('haberler', $lang); ?></h4>
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
                        <div class="blog__item-2 blog__item-2-df mb-40" style="height: 100%; display: flex; flex-direction: column;">
                            <div class="blog__item-2-image">
                                <div class="blog__item-2-image-inner w-img" style="height: 250px; overflow: hidden;">
                                    <?php if($veri_listele["haber_resim"]) { ?>
                                        <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>">
                                            <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $veri_listele["haber_resim"]; ?>" 
                                                 alt="<?php echo $veri_listele["haber_baslik"]; ?>"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="blog__item-2-content" style="flex: 1; display: flex; flex-direction: column; padding: 20px;">
                                <div class="blog__meta" style="margin-bottom: 15px;">
                                    <div class="blog__author">
                                        <i class="fas fa-calendar"></i>
                                        <span><?php echo date("d/m/Y", strtotime($veri_listele["haber_tarih"])); ?></span>
                                    </div>
                                </div>
                                <h5 class="blog__sm-title" style="margin-bottom: 15px; min-height: 60px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>" style="font-size: 18px;">
                                        <?php echo $veri_listele["haber_baslik"]; ?>
                                    </a>
                                </h5>
                                <?php if($veri_listele["haber_kisaaciklama"]) { ?>
                                    <p style="margin-bottom: 20px; min-height: 75px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?php echo $veri_listele["haber_kisaaciklama"]; ?>
                                    </p>
                                <?php } ?>
                                <div class="blog__btn-2" style="margin-top: auto;">
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>" class="link-btn">
                                        <?php echo LANG('devamini_oku', $lang); ?> 
                                        <i class="fal fa-long-arrow-right"></i>
                                    </a>
                                </div>
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
