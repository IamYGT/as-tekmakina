<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$tekil_veri_cek = $db->query("SELECT * FROM kurumsal WHERE haber_durum = 1 AND haber_seo = '{$_GET["url"]}' AND dil_id = 'tr' ")->fetch(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - PUMADA GROUP DOO</title>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/index">Anasayfa</a></li>
                            <li><span>Kurumsal</span></li>
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
                                    <a href="#"><?php echo $tekil_veri_cek["haber_yillik"]; ?> <span>+</span></a>
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
                     <?php echo $tekil_veri_cek["haber_aciklama"]; ?>  
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- about__area end -->

      <!-- history__area start -->
      <section class="history__area grey-bg-5 pt-120 pb-90 fix">
         <div class="history__right-bg">
            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/testimonial/testimonial-bg-1.jpg" alt="Hizmetlerimiz">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6">
                  <div class="section__wrapper mb-55">
                     <h4 class="section__title">Hizmetlerimiz</h4>
                     <div class="r-text">
                        <span>PUMADA GROUP</span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12">
                  <div class="row">
                        <?php
                    				$veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1 AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 4");
                     				if ($veri_cek->rowCount()){
                    				foreach($veri_cek as $veri_listele){
                    ?>  <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="history__item mb-30">
                           <div class="sm-item-thumb w-img">
                              <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"><img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>" alt="<?php echo 	$veri_listele["haber_baslik"]; ?>"></a>
                           </div>
                           <div class="sm-item-content">
                              <h6><a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></h6>
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
         </div>
      </section>

      <section class="company__about">
         <div class="row g-0">
            <div class="col-xl-12">
               <div class="company__about-tab">
                  <ul class="nav nav-tabs about-tabs" id="myTab" role="tablist">
                     <li class="nav-item abst-item abst-item" role="presentation">
                        <button class="nav-link abst-item-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Misyonumuz <i class="fa-light fa-arrow-down-long"></i></button>
                     </li>
                     <li class="nav-item abst-item" role="presentation">
                        <button class="nav-link active abst-item-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Vizyonumuz  <i class="fa-light fa-arrow-down-long"></i></button>
                     </li>

                     <li class="nav-item abst-item abst-item" role="presentation">
                        <button class="nav-link abst-item-link" id="kalite-tab" data-bs-toggle="tab" data-bs-target="#kalite" type="button" role="tab" aria-controls="kalite" aria-selected="true">Kalite Politikamız <i class="fa-light fa-arrow-down-long"></i></button>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row">
               <div class="tab-content company__about-tabs-content" id="myTabContent">
                  <div class="tab-pane fade pt-90 pb-140" id="home" role="tabpanel" aria-labelledby="home-tab">
                     <div class="row justify-content-center">
                        <div class="col-xl-8">
                           <div class="company__sm-about text-center">
                             <span class="animate"><img src="<?php echo $ayarlar["strURL"]; ?>\assets\img\logo\logo-black.png" alt="Logo" class="img-rounded center-block"></span>
                              <p><?php echo $tekil_veri_cek["haber_description"]; ?></p>
                           </div>
                        </div>
                     </div>
                   </div>
                  <div class="tab-pane fade show active pt-90 pb-140" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                     <div class="row justify-content-center">
                        <div class="col-xl-8">
                           <div class="company__sm-about text-center">
                              <span class="animate"><img src="<?php echo $ayarlar["strURL"]; ?>\assets\img\logo\logo-black.png" alt="Logo" class="img-rounded center-block"></span>
                              <p><?php echo $tekil_veri_cek["haber_kisaaciklama"]; ?></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade pt-90 pb-140" id="kalite" role="tabpanel" aria-labelledby="kalite-tab">
                     <div class="row justify-content-center">
                        <div class="col-xl-8">
                           <div class="company__sm-about text-center">
                             <span class="animate"><img src="<?php echo $ayarlar["strURL"]; ?>\assets\img\logo\logo-black.png" alt="Logo" class="img-rounded center-block"></span>
                              <p><?php echo $tekil_veri_cek["haber_kalite"]; ?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
