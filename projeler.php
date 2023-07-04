<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title>Projeler - AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları </title>
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
                            <li><span>Projeler</span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20">Projeler</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
     <section class="portfolio-area pt-110 pb-110">
       <div class="container">
           <div id="portfolio-grid" class="row grid">
             <?php
                 $veri_cek = $db->query("SELECT * FROM projeler WHERE proje_durum = 1");
                 if ($veri_cek->rowCount()){
                 foreach($veri_cek as $veri_listele){
           ?> <div class="col-lg-4 col-md-6 grid-item cat2 cat4">
                <div class="portfolio-item mb-30">
                   <div class="portfolio-wrapper">
                      <div class="portfolio-image w-img">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>"> <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/projects/<?php echo $veri_listele["proje_resim"]; ?>" alt="<?php echo 	$veri_listele["proje_baslik"]; ?>"> </a>
                      </div>
                      <div class="portfolio-caption">
                         <p>As-Tek Kimya San. ve Tic. Ltd. Şti.</p>
                         <h6><a href="#"><?php echo 	$veri_listele["proje_baslik"]; ?></a></h6>
                      </div>
                      <div class="portfolio-caption-top">
                         <p><a href="#">As-Tek Kimya San. ve Tic. Ltd. Şti.</a></p>
                         <h6><a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>"><?php echo 	$veri_listele["proje_baslik"]; ?></a></h6>
                      </div>
                      <div class="portfolio-caption-bottom">
                         <a href="<?php echo $ayarlar["strURL"]; ?>/proje/<?php echo $veri_listele["proje_seo"]; ?>"><i class="fa-light fa-arrow-right-long"></i></a>
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
       </div>
   </section>
     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
