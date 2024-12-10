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
                        <h4 class="section__title"><?php echo LANG('bizi_yakindan_taniyin', $lang); ?><br><?php echo LANG('bizi_yakindan_taniyin_2', $lang); ?></h4>
                        <div class="r-text">
                           <span><?php echo LANG('kurumsal_title', $lang); ?></span>
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
                     <h4 class="section__title"><?php echo LANG('hizmetlerimiz_title', $lang); ?></h4>
                     <div class="r-text">
                        <span><?php echo LANG('pumada_group', $lang); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12">
                  <div class="row">
                        <?php
                    				$veri_cek = $db->query("SELECT * FROM hizmetler 
                        WHERE haber_durum = 1 
                        AND dil_id = '$lang' 
                        ORDER BY haber_ust_id ASC LIMIT 4");
                     				if ($veri_cek->rowCount()){
                    				foreach($veri_cek as $veri_listele){
                    ?>  <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="history__item mb-30">
                           <div class="sm-item-thumb w-img">
                              <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>">
                                 <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>" 
                                      alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                              </a>
                           </div>
                           <div class="sm-item-content">
                              <h6>
                                 <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>">
                                    <?php echo $veri_listele["haber_baslik"]; ?>
                                 </a>
                              </h6>
                            </div>
                        </div>
                     </div>
                     <?php
                               }
                             }else{
                               echo LANG('listelenecek_veri_bulunamadi', $lang);
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
                     <li class="nav-item abst-item" role="presentation">
                        <button class="nav-link active abst-item-link" id="misyon-tab" data-bs-toggle="tab" data-bs-target="#misyon" type="button" role="tab" aria-controls="misyon" aria-selected="true">Misyonumuz <i class="fa-light fa-arrow-down-long"></i></button>
                     </li>
                     <li class="nav-item abst-item" role="presentation">
                        <button class="nav-link abst-item-link" id="vizyon-tab" data-bs-toggle="tab" data-bs-target="#vizyon" type="button" role="tab" aria-controls="vizyon" aria-selected="false">Vizyonumuz  <i class="fa-light fa-arrow-down-long"></i></button>
                     </li>

                    <?php if($tekil_veri_cek["haber_kalite"]) { ?>
                        <li class="nav-item abst-item" role="presentation">
                            <button class="nav-link abst-item-link" id="kalite-tab" data-bs-toggle="tab" data-bs-target="#kalite" type="button" role="tab" aria-controls="kalite" aria-selected="false">
                                <?php echo LANG('kalite_politikamiz', $lang); ?> 
                                <i class="fa-light fa-arrow-down-long"></i>
                            </button>
                        </li>
                    <?php } ?>
                  </ul>
               </div>
            </div>
         </div>

         <div class="container">
            <div class="row">
               <div class="tab-content company__about-tabs-content" id="myTabContent">
                  <?php if($tekil_veri_cek["haber_description"]) { ?>
                      <div class="tab-pane fade show active pt-90 pb-140" id="misyon" role="tabpanel" aria-labelledby="misyon-tab">
                          <div class="row justify-content-center">
                              <div class="col-xl-8">
                                  <div class="company__sm-about text-center">
                                      <div class="logo-wrapper mb-4">
                                          <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo_pumada.png" 
                                               alt="<?php echo $ayarlar["strTitle"]; ?>" 
                                               style="max-width: 300px;">
                                      </div>
                                      <div class="content">
                                          <?php echo $tekil_veri_cek["haber_description"]; ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php } ?>

                  <?php if($tekil_veri_cek["haber_kisaaciklama"]) { ?>
                      <div class="tab-pane fade pt-90 pb-140" id="vizyon" role="tabpanel" aria-labelledby="vizyon-tab">
                          <div class="row justify-content-center">
                              <div class="col-xl-8">
                                  <div class="company__sm-about text-center">
                                      <div class="logo-wrapper mb-4">
                                          <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/pumada_logo.png" 
                                               alt="<?php echo $ayarlar["strTitle"]; ?>" 
                                               style="max-width: 250px;">
                                      </div>
                                      <div class="content">
                                          <?php echo $tekil_veri_cek["haber_kisaaciklama"]; ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php } ?>

                  <?php if($tekil_veri_cek["haber_kalite"]) { ?>
                      <div class="tab-pane fade pt-90 pb-140" id="kalite" role="tabpanel" aria-labelledby="kalite-tab">
                          <div class="row justify-content-center">
                              <div class="col-xl-8">
                                  <div class="company__sm-about text-center">
                                      <div class="logo-wrapper mb-4">
                                          <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/yazi.png" 
                                               alt="<?php echo $ayarlar["strTitle"]; ?>" 
                                               style="max-width: 200px;">
                                      </div>
                                      <div class="content">
                                          <?php echo $tekil_veri_cek["haber_kalite"]; ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </section>
     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
