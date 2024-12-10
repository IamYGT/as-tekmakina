<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_referanslar', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
       <style>
           .brand__image-item {
               position: relative;
               overflow: hidden;
               background: #fff;
               padding: 25px;
               border-radius: 12px;
               box-shadow: 0 5px 20px rgba(0,0,0,0.08);
               transition: all 0.3s ease;
               height: 100%;
           }
           
           .brand__image-item:hover {
               transform: translateY(-5px);
               box-shadow: 0 8px 25px rgba(218, 150, 62, 0.2);
           }
           
           .brand__image-wrapper {
               position: relative;
               height: 180px;
               display: flex;
               align-items: center;
               justify-content: center;
               margin-bottom: 20px;
               border-radius: 8px;
               overflow: hidden;
               background: #f8f9fa;
           }
           
           .brand__image-item img {
               max-width: 100%;
               max-height: 160px;
               object-fit: contain;
               transition: all 0.4s ease;
           }
           
           .brand__image-item:hover img {
               transform: scale(1.05);
           }
           
           .brand__content {
               text-align: center;
           }
           
           .brand__title {
               font-size: 18px;
               font-weight: 600;
               color: #040404;
               margin-bottom: 12px;
               transition: color 0.3s ease;
           }
           
           .brand__image-item:hover .brand__title {
               color: #da963e;
           }
           
           .brand__description {
               font-size: 14px;
               color: #666;
               line-height: 1.6;
               margin-bottom: 15px;
               display: -webkit-box;
               -webkit-line-clamp: 3;
               -webkit-box-orient: vertical;
               overflow: hidden;
           }
           
           .brand__meta {
               font-size: 13px;
               color: #da963e;
               font-weight: 500;
           }
           
           .brand__overlay {
               position: absolute;
               inset: 0;
               background: rgba(218, 150, 62, 0.1);
               display: flex;
               align-items: center;
               justify-content: center;
               opacity: 0;
               transition: all 0.3s ease;
           }
           
           .brand__image-item:hover .brand__overlay {
               opacity: 1;
           }
       </style>
    </head>
   <body>
     <?php include 'ust.php'; ?>
      <main>
       <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center" 
                data-background="<?php echo $ayarlar["strURL"]; ?>/assets/img/bg/page-bg.jpg">
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="page__title-wrapper mt-100">
                     <div class="breadcrumb-menu">
                        <ul>
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                            <li><span><?php echo LANG('menu_referanslar', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_referanslar', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="brand__area-2 brand-border pt-150 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="section-2__wrapper mb-55 text-center">
                     <span class="st-2"><?php echo $ayarlar["strTitle"]; ?></span>
                     <h4 class="section__title"><?php echo LANG('menu_referanslar', $lang); ?></h4>
                  </div>
               </div>
            </div>
            <div class="row g-4">
              <?php
              // Referansları getir
              $list = $db->query("SELECT * FROM referanslar 
                                 WHERE referans_durum = 1 
                                 AND dil_id = '$lang' 
                                 ORDER BY row ASC");
              
              foreach($list as $row){
              ?>
               <div class="col-xl-3 col-lg-4 col-md-6">
                  <div class="brand__image-item">
                     <div class="brand__image-wrapper">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/references/<?php echo $row["referans_resim"]?>" 
                             alt="<?php echo $row["referans_baslik"]; ?>">
                        <div class="brand__overlay">
                           <i class="fas fa-eye"></i>
                        </div>
                     </div>
                     <div class="brand__content">
                        <h3 class="brand__title"><?php echo $row["referans_baslik"]; ?></h3>
                        <?php if($row["referans_aciklama"]) { ?>
                        <p class="brand__description">
                           <?php echo $row["referans_aciklama"]; ?>
                        </p>
                        <?php } ?>
                        <?php if($row["referans_description"]) { ?>
                        <div class="brand__meta">
                           <?php echo $row["referans_description"]; ?>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </section>
     </main>
     <?php include 'alt.php'; ?>
   </body>
</html>
