<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$sayfa = (isset($q) ? $q : 1);
$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM haberler WHERE dil_id = '$lang' ")->fetchColumn();
$limit = 6; // Sayfa başına gösterilecek haber sayısını 6'ya çıkardık
$sonSayfa = ceil($toplam_veri_sayisi/$limit);
$baslangic = ($sayfa-1)*$limit;
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_haberler', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
       <style>
           .news-grid {
               display: grid;
               grid-template-columns: repeat(2, 1fr);
               gap: 30px;
               margin-bottom: 50px;
           }
           
           .news-card {
               background: #fff;
               border-radius: 15px;
               overflow: hidden;
               box-shadow: 0 5px 20px rgba(0,0,0,0.05);
               transition: all 0.4s ease;
               height: 100%;
               display: flex;
               flex-direction: column;
           }
           
           .news-card:hover {
               transform: translateY(-5px);
               box-shadow: 0 8px 25px rgba(218, 150, 62, 0.15);
           }
           
           .news-image {
               position: relative;
               height: 300px;
               overflow: hidden;
           }
           
           .news-image img {
               width: 100%;
               height: 100%;
               object-fit: cover;
               transition: transform 0.4s ease;
           }
           
           .news-card:hover .news-image img {
               transform: scale(1.05);
           }
           
           .news-date {
               position: absolute;
               top: 20px;
               right: 20px;
               background: rgba(218, 150, 62, 0.9);
               color: #fff;
               padding: 8px 15px;
               border-radius: 25px;
               font-size: 14px;
               font-weight: 500;
               display: flex;
               align-items: center;
               gap: 6px;
               backdrop-filter: blur(5px);
           }
           
           .news-content {
               padding: 30px;
               flex: 1;
               display: flex;
               flex-direction: column;
           }
           
           .news-title {
               font-size: 22px;
               font-weight: 600;
               margin-bottom: 15px;
               line-height: 1.4;
               color: #040404;
               transition: color 0.3s ease;
           }
           
           .news-card:hover .news-title {
               color: #da963e;
           }
           
           .news-desc {
               color: #666;
               font-size: 15px;
               line-height: 1.6;
               margin-bottom: 25px;
               display: -webkit-box;
               -webkit-line-clamp: 3;
               -webkit-box-orient: vertical;
               overflow: hidden;
           }
           
           .news-link {
               margin-top: auto;
               display: inline-flex;
               align-items: center;
               color: #da963e;
               font-weight: 500;
               gap: 8px;
               transition: all 0.3s ease;
           }
           
           .news-link:hover {
               gap: 12px;
               color: #040404;
           }
           
           .news-link i {
               transition: transform 0.3s ease;
           }
           
           .news-link:hover i {
               transform: translateX(3px);
           }
           
           /* Pagination Styles */
           .pagination {
               display: flex;
               justify-content: center;
               gap: 10px;
               margin-top: 50px;
           }
           
           .pagination a, .pagination span {
               display: flex;
               align-items: center;
               justify-content: center;
               width: 40px;
               height: 40px;
               border-radius: 8px;
               background: #fff;
               color: #040404;
               font-weight: 500;
               text-decoration: none;
               transition: all 0.3s ease;
               box-shadow: 0 3px 10px rgba(0,0,0,0.05);
           }
           
           .pagination .current {
               background: #da963e;
               color: #fff;
           }
           
           .pagination a:hover {
               background: #da963e;
               color: #fff;
           }
           
           @media (max-width: 991px) {
               .news-grid {
                   grid-template-columns: 1fr;
               }
               
               .news-image {
                   height: 250px;
               }
               
               .news-title {
                   font-size: 20px;
               }
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
                            <li><span><?php echo LANG('menu_haberler', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_haberler', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section class="blog__area pt-100 pb-100">
         <div class="container">
            <div class="news-grid">
               <?php
               $veri_cek = $db->query("SELECT * FROM haberler 
                                      WHERE haber_durum = 1 
                                      AND dil_id = '$lang' 
                                      ORDER BY haber_ust_id DESC 
                                      LIMIT $baslangic,$limit");

               if ($veri_cek->rowCount()) {
                   foreach($veri_cek as $row) {
               ?>
                   <article class="news-card">
                       <div class="news-image">
                           <?php if($row["haber_resim"]) { ?>
                               <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>">
                                   <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $row["haber_resim"]; ?>" 
                                        alt="<?php echo $row["haber_baslik"]; ?>">
                               </a>
                           <?php } ?>
                           <div class="news-date">
                               <i class="fas fa-calendar-alt"></i>
                               <?php echo date("d.m.Y", strtotime($row["haber_tarih"])); ?>
                           </div>
                       </div>
                       <div class="news-content">
                           <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>">
                               <h3 class="news-title"><?php echo $row["haber_baslik"]; ?></h3>
                           </a>
                           <?php if($row["haber_kisaaciklama"]) { ?>
                               <p class="news-desc"><?php echo $row["haber_kisaaciklama"]; ?></p>
                           <?php } ?>
                           <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>" 
                              class="news-link">
                               <?php echo LANG('devamini_oku', $lang); ?>
                               <i class="far fa-long-arrow-right"></i>
                           </a>
                       </div>
                   </article>
               <?php
                   }
               } else {
                   echo '<div class="col-12 text-center">' . LANG('listelenecek_veri_bulunamadi', $lang) . '</div>';
               }
               ?>
            </div>

            <?php if($toplam_veri_sayisi > $limit) { ?>
               <div class="pagination">
                   <?php
                   if($sayfa > 1){
                       $onceki = $sayfa-1;
                       echo '<a href="?q='.$onceki.'"><i class="far fa-angle-left"></i></a>';
                   }
                   
                   if($sayfa > 3) {
                       echo '<a href="?q=1">1</a>';
                       if($sayfa > 4) {
                           echo '<span>...</span>';
                       }
                   }
                   
                   for($i = max(1, $sayfa - 2); $i <= min($sayfa + 2, $sonSayfa); $i++) {
                       if($i == $sayfa) {
                           echo '<span class="current">'.$i.'</span>';
                       } else {
                           echo '<a href="?q='.$i.'">'.$i.'</a>';
                       }
                   }
                   
                   if($sayfa < $sonSayfa - 2) {
                       if($sayfa < $sonSayfa - 3) {
                           echo '<span>...</span>';
                       }
                       echo '<a href="?q='.$sonSayfa.'">'.$sonSayfa.'</a>';
                   }
                   
                   if($sayfa < $sonSayfa) {
                       $sonraki = $sayfa + 1;
                       echo '<a href="?q='.$sonraki.'"><i class="far fa-angle-right"></i></a>';
                   }
                   ?>
               </div>
            <?php } ?>
         </div>
      </section>
     </main>
     <?php include 'alt.php'; ?>
   </body>
</html>
