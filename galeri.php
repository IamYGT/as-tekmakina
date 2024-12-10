<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title><?php echo LANG('galeri', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/index"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                            <li><span><?php echo LANG('menu_galeri', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_galeri', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="team__area pt-120 pb-90">
         <div class="container">
            <div class="row">
              <?php

          $list = $db->query("SELECT * FROM files WHERE ustid = 1 AND itable = 1");
          foreach($list as $row){
          ?>  <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="team__item-grid mb-30">
                     <div class="team__item-grid-thumb w-img">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $row["name"]?>"  class="popup-link" ><img src="<?php echo $ayarlar["strURL"]; ?>/uploads/files/<?php echo $row["name"]?>" alt="<?php echo $ayarlar["strTitle"]; ?>"></a>
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
div {
  text-align: center;
}

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
