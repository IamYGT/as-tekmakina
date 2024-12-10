<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_galeri', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
       <!-- Fancybox CSS -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
       <style>
           .gallery-grid {
               display: grid;
               grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
               gap: 30px;
               padding: 30px 0;
           }
           
           .gallery-item {
               position: relative;
               border-radius: 12px;
               overflow: hidden;
               box-shadow: 0 5px 15px rgba(0,0,0,0.1);
               transition: all 0.3s ease;
           }
           
           .gallery-item:hover {
               transform: translateY(-5px);
               box-shadow: 0 8px 25px rgba(0,0,0,0.15);
           }
           
           .gallery-image {
               width: 100%;
               height: 250px;
               object-fit: cover;
               transition: transform 0.3s ease;
           }
           
           .gallery-item:hover .gallery-image {
               transform: scale(1.05);
           }
           
           .gallery-overlay {
               position: absolute;
               inset: 0;
               background: rgba(0,0,0,0.5);
               display: flex;
               align-items: center;
               justify-content: center;
               opacity: 0;
               transition: opacity 0.3s ease;
           }
           
           .gallery-item:hover .gallery-overlay {
               opacity: 1;
           }
           
           .zoom-icon {
               color: white;
               font-size: 24px;
               transform: scale(0.5);
               transition: transform 0.3s ease;
           }
           
           .gallery-item:hover .zoom-icon {
               transform: scale(1);
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
                            <li><span><?php echo LANG('menu_galeri', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_galeri', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="gallery-section pt-120 pb-120">
         <div class="container">
            <div class="gallery-grid">
            <?php
            // Sadece galeri tipindeki resimleri getir
            $list = $db->query("SELECT gr.*, g.galeri_baslik 
                               FROM galeri_resimler gr 
                               INNER JOIN galeriler g ON gr.galeri_ust_id = g.galeri_ust_id 
                               WHERE g.dil_id = '$lang' 
                               AND (g.galeri_tip = 'galeri' OR g.galeri_tip IS NULL)
                               ORDER BY gr.galeri_tarih DESC");
            
            foreach($list as $row){
            ?>
               <div class="gallery-item">
                  <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/gallery/<?php echo $row["galeri_resim"]; ?>" 
                     data-fancybox="gallery"
                     data-caption="<?php echo $row["galeri_baslik"]; ?>">
                     <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/gallery/<?php echo $row["galeri_resim"]; ?>" 
                          alt="<?php echo $row["galeri_baslik"]; ?>"
                          class="gallery-image">
                     <div class="gallery-overlay">
                        <i class="fas fa-search-plus zoom-icon"></i>
                     </div>
                  </a>
               </div>
            <?php } ?>
            </div>
         </div>
      </section>
     </main>
     
     <?php include 'alt.php'; ?>
     
     <!-- Fancybox JS -->
     <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
     <script>
        Fancybox.bind("[data-fancybox]", {
            // Fancybox options
            loop: true,
            buttons: ["zoom", "slideShow", "fullScreen", "close"],
            animationEffect: "fade"
        });
     </script>
   </body>
</html> 