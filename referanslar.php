<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title>Referanslar - AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları </title>
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
                            <li><span>Referanslar</span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20">Referanslar</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="brand__area-2 brand-border pt-150 pb-120" data-background="assets/img/brand/brand-bg.jpg">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <div class="section-2__wrapper mb-55 text-center">
               <span class="st-2">AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları</span>
               <h4 class="section__title">Referanslar</h4>
            </div>
         </div>
      </div>
      <div class="row g-0">
        <?php

      $list = $db->query("SELECT * FROM files WHERE ustid = 2 AND itable = 1");
      foreach($list as $row){
      ?>
         <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="brand__image-item brand__image-item-br brand__image-item-bb">
               <a href="#"><img  style="width: 300px;" src="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $row["name"]?>" alt=""></a>
               <div class="brand__image-item-ab">
                  <a href="#"><img  style="width: 300px;" src="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $row["name"]?>" alt=""></a>
               </div>
            </div>
         </div>
         <?php
         }
         ?>
      </div>
   </div>
</section>
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
