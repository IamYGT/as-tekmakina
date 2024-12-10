<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$tekil_veri_cek = $db->query("SELECT * FROM haberler 
                             WHERE haber_durum = 1 
                             AND haber_seo = '{$_GET["url"]}' 
                             AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);

if(!$tekil_veri_cek) {
    $tekil_veri_cek = $db->query("SELECT * FROM haberler 
                                 WHERE haber_durum = 1 
                                 AND haber_seo = '{$_GET["url"]}' 
                                 AND dil_id = 'tr'")->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - <?php echo $ayarlar["strTitle"]; ?></title>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/haberler"><?php echo LANG('menu_haberler', $lang); ?></a></li>
                            <li><span><?php echo $tekil_veri_cek["haber_baslik"]; ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="blog__details-area pt-120 pb-70">
         <div class="container custom-container-3">
            <div class="row">
               <div class="col-lg-8">
                  <div class="blog__wrapper mb-50">
                     <div class="tp-blog mb-50">
                     <div class="tp-blog__thumb m-img mb-35">
                       <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $tekil_veri_cek["haber_resim"]; ?>" alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                     </div> <div class="tp-blog__meta mb-15">
                           <span><a href="#"><i class="fal fa-clock"></i> <?php echo date("d/m/Y", strtotime($tekil_veri_cek["haber_tarih"])); ?></a></span>
                           <span><a href="#"><i class="far fa-user"></i> <?php echo $ayarlar["strTitle"]; ?></a></span>
                         </div>
                         <h1><?php echo $tekil_veri_cek["haber_baslik"]; ?></h1>
                       <?php echo $tekil_veri_cek["haber_aciklama"]; ?>
                     </div>
                   </div>
               </div>
               <div class="col-lg-4">
                  <div class="blog-sidebar__wrapper pl-30">

                     <div class="blog-sidebar__widget mb-55">
                        <div class="blog-sidebar__widget-head mb-30">
                           <h3 class="blog-sidebar__widget-title"><?php echo LANG('son_haberler', $lang); ?></h3>
                        </div>
                        <div class="blog-sidebar__widget-content">
                           <div class="rc__post-wrapper">

                                 <?php
                             				$veri_cek = $db->query("SELECT * FROM haberler 
                                                            WHERE haber_durum = 1 
                                                            AND dil_id = '$lang'
                                                            AND haber_ust_id != {$tekil_veri_cek['haber_ust_id']}
                                                            ORDER BY haber_ust_id DESC LIMIT 3");
                              				if ($veri_cek->rowCount()){
                             				foreach($veri_cek as $veri_listele){
                             ?> <div class="rc__post d-flex align-items-start">
                                 <div class="rc__thumb mr-20">
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>"><img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $veri_listele["haber_resim"]; ?>" alt="<?php echo 	$veri_listele["haber_baslik"]; ?>"></a>
                                 </div>
                                 <div class="rc__content">
                                    <h6 class="rc__title"><a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></h6>
                                    <div class="rc__meta">
                                       <span><i class="fal fa-clock"></i> <?php echo date("d/m/Y", strtotime($veri_listele["haber_tarih"])); ?></span>
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
                     <div class="blog-sidebar__widget mb-55">
                        <div class="blog-sidebar__widget-head mb-30">
                           <h3 class="blog-sidebar__widget-title"><?php echo LANG('hizmetlerimiz', $lang); ?></h3>
                        </div>
                        <div class="blog-sidebar__widget-content">
                              <ul>

                                    <?php
                                				$hizmetler = $db->query("SELECT * FROM hizmetler 
                                                            WHERE haber_durum = 1 
                                                            AND dil_id = '$lang' 
                                                            ORDER BY haber_ust_id ASC LIMIT 5");
                                 				if ($hizmetler->rowCount()){
                                				foreach($hizmetler as $veri_listele){
                                ?>
                                 <li><a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></li>
                                 <?php
                                           }
                                         }else{
                                           echo LANG('listelenecek_veri_bulunamadi', $lang);
                                         }
                                 ?>
                               </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
