<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$tekil_veri_cek = $db->query("SELECT * FROM projeler WHERE proje_durum = 1 AND proje_seo = '{$_GET["url"]}' AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);
if(!$tekil_veri_cek) {
    $tekil_veri_cek = $db->query("SELECT * FROM projeler WHERE proje_durum = 1 AND proje_seo = '{$_GET["url"]}' AND dil_id = 'tr'")->fetch(PDO::FETCH_ASSOC);
}
$categoryInfo = $db->query("SELECT * FROM kategoriler WHERE kategori_ust_id = {$tekil_veri_cek['kategori_id']} AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo $tekil_veri_cek["proje_baslik"]; ?>  - <?php echo $ayarlar["strTitle"]; ?></title>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/projeler"><?php echo LANG('menu_projeler', $lang); ?></a></li>
                            <li><span><?php echo $tekil_veri_cek["proje_baslik"]; ?> </span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["proje_baslik"]; ?> </h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="portfoilo__area pt-110 pb-30">
         <div class="container">
            <div class="row">
               <div class="col-xxl-8 col-xl-7 col-lg-7">
                  <div class="portfolio__details mb-50">
                     <div class="pt-d-image w-img mb-35">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/projects/<?php echo $tekil_veri_cek["proje_resim"]; ?>" alt="<?php echo $tekil_veri_cek["proje_baslik"]; ?>">
                     </div>
                     <h4 class="portfolio__details-title"><?php echo $tekil_veri_cek["proje_baslik"]; ?></h4>
                     <div class="project-details-info">
                         <?php if($tekil_veri_cek["proje_yil"]): ?>
                         <div class="info-item">
                             <span class="label"><?php echo LANG('proje_yili', $lang); ?>:</span>
                             <span class="value"><?php echo $tekil_veri_cek["proje_yil"]; ?></span>
                         </div>
                         <?php endif; ?>
                         
                         <?php if($tekil_veri_cek["proje_adres"]): ?>
                         <div class="info-item">
                             <span class="label"><?php echo LANG('proje_adresi', $lang); ?>:</span>
                             <span class="value"><?php echo $tekil_veri_cek["proje_adres"]; ?></span>
                         </div>
                         <?php endif; ?>
                         
                         <?php if($tekil_veri_cek["proje_metrekare"]): ?>
                         <div class="info-item">
                             <span class="label"><?php echo LANG('proje_metrekare', $lang); ?>:</span>
                             <span class="value"><?php echo $tekil_veri_cek["proje_metrekare"]; ?></span>
                         </div>
                         <?php endif; ?>
                     </div>
                     <div class="ptd-descriptiopn mb-25">
                       <?php echo $tekil_veri_cek["proje_aciklama"]; ?>
                     </div>
                     <div class="row">

                     <?php
                             $imagesList = $db->query("SELECT * FROM files WHERE ustid = {$tekil_veri_cek["proje_ust_id"]} AND itable = 2");
                             if ($imagesList->rowCount()){
                                 foreach($imagesList as $image){
                     ?>
                        <div class="col-lg-4">
                           <div class="pt-d-image mb-30 w-img">
                            <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $image["name"]; ?>" class="popup-link" >  <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $image["name"]; ?>" alt="portfoilo-img"> </a>
                           </div>
                        </div>
                        <?php
                                    }
                                }
                        ?>

                     </div>
                  </div>
               </div>
               <div class="col-xxl-4 col-xl-5 col-lg-5">
                  <div class="portfolio__sidebar mb-50">
                     <div class="blog-sidebar__widget mb-55">
                        <div class="blog-sidebar__widget-head mb-30">
                           <h3 class="blog-sidebar__widget-title"><?php echo LANG('hizmetlerimiz', $lang); ?></h3>
                        </div>
                        <div class="blog-sidebar__widget-content">
                              <ul>

                                    <?php
                                        $veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1 AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 5");
                                        if ($veri_cek->rowCount()){
                                        foreach($veri_cek as $veri_listele){
                                ?>
                                 <li><a style="color: #6a6a6a;" href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></li>
                                 <?php
                                           }
                                         }else{
                                           echo LANG('listelenecek_veri_bulunamadi', $lang);
                                         }
                                 ?>
                               </ul>
                        </div>
                     </div>
                     <div class="ps__form mb-40">
                        <h5 class="ps__title"><?php echo LANG('teklif_formu', $lang); ?></h5>
                        <form action="#">
                           <div class="contact-filed mb-20">
                               <input type="text" name="name" placeholder="<?php echo LANG('isminiz', $lang); ?>">
                           </div>
                           <div class="contact-filed contact-icon-mail mb-20">
                               <input type="text" name="email" placeholder="<?php echo LANG('eposta_adresiniz', $lang); ?>">
                           </div>
                           <div class="contact-filed contact-icon-message mb-20">
                              <textarea placeholder="<?php echo LANG('mesajiniz', $lang); ?>"></textarea>
                          </div>
                           <div class="form-submit text-center">
                               <button class="tp-btn w-100"><?php echo LANG('gonder', $lang); ?></button>
                           </div>
                       </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

     </main>

    <?php include 'alt.php'; ?>
    <script type="text/javascript">
    $('.popup-link').magnificPopup({
      type: 'image',
      mainClass: 'mfp-with-zoom',
      zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out',
      }
    });
    </script>

    <style media="screen">

    .mfp-with-zoom .mfp-container,
    .mfp-with-zoom.mfp-bg {
      opacity: 0;
      -webkit-backface-visibility: hidden;
      /* ideally, transition speed should match zoom duration */
      -webkit-transition: all 0.3s ease-out;
      -moz-transition: all 0.3s ease-out;
      -o-transition: all 0.3s ease-out;
      transition: all 0.3s ease-out;
    }

    .mfp-with-zoom.mfp-ready .mfp-container {
        opacity: 1;
    }
    .mfp-with-zoom.mfp-ready.mfp-bg {
        opacity: 0.8;
    }

    .mfp-with-zoom.mfp-removing .mfp-container,
    .mfp-with-zoom.mfp-removing.mfp-bg {
      opacity: 0;
    }
    </style>


   </body>
</html>
