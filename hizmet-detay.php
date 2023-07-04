<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$tekil_veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1 AND haber_seo = '{$_GET["url"]}' AND dil_id = 'tr' ")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları </title>
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
                            <li><a href="#">Hizmetlerimiz</a></li>
                            <li><span><?php echo $tekil_veri_cek["haber_baslik"]; ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="about__area pt-120 pb-155">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6">
                  <div class="about__image about__image-2">
                     <div class="about__image-big">
                        <img style="width: 100%;" src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $tekil_veri_cek["haber_resim"]; ?>" alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                  <div class="about__right-2">
                     <div class="about__info pb-20">
                        <div class="section-2__wrapper mb-30">
                           <h5 class="section__title-sm"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h5>
                        </div>
                        <p><?php echo $tekil_veri_cek["haber_aciklama"]; ?></p>
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
