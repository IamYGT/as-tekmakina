<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");

// Önce seçili dilde haberi ara
$tekil_veri_cek = $db->query("SELECT h.*, 
    (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'tr') as tr_seo,
    (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'en') as en_seo,
    (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'ar') as ar_seo,
    (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'ru') as ru_seo
    FROM haberler h
    WHERE h.haber_durum = 1 
    AND h.haber_seo = '{$_GET["url"]}' 
    AND h.dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);

// Seçili dilde bulunamazsa varsayılan dilde ara
if(!$tekil_veri_cek) {
    // Önce SEO URL'den haberin üst ID'sini bul
    $haber_ust_id = $db->query("SELECT haber_ust_id FROM haberler 
                               WHERE haber_seo = '{$_GET["url"]}' 
                               LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    
    if($haber_ust_id) {
        // Üst ID ile seçili dildeki karşılığını bul
        $tekil_veri_cek = $db->query("SELECT h.*, 
            (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'tr') as tr_seo,
            (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'en') as en_seo,
            (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'ar') as ar_seo,
            (SELECT haber_seo FROM haberler WHERE haber_ust_id = h.haber_ust_id AND dil_id = 'ru') as ru_seo
            FROM haberler h
            WHERE h.haber_durum = 1 
            AND h.haber_ust_id = '{$haber_ust_id["haber_ust_id"]}'
            AND h.dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);
    }
}

// Haber bulunamadıysa 404 sayfasına yönlendir
if(!$tekil_veri_cek) {
    header("Location: ".$ayarlar["strURL"]."/404");
    exit;
}

// Dil değiştirme URL'lerini oluştur
$dil_url = array();
foreach(['tr','en','ar','ru'] as $d) {
    $seo_col = $d.'_seo';
    if($tekil_veri_cek[$seo_col]) {
        $dil_url[$d] = $ayarlar["strURL"].'/'.$d.'/haber/'.$tekil_veri_cek[$seo_col];
    } else {
        $dil_url[$d] = $ayarlar["strURL"].'/'.$d;
    }
}

// Mevcut dil URL'sini session'a kaydet
$_SESSION['current_lang_url'] = $dil_url[$lang];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - <?php echo $ayarlar["strTitle"]; ?></title>
       <?php include 'css.php'; ?>
       <style>
           .news-detail {
               background: #fff;
               border-radius: 20px;
               box-shadow: 0 5px 30px rgba(0,0,0,0.05);
               overflow: hidden;
               margin-bottom: 40px;
           }
           
           .news-detail__image {
               position: relative;
               height: 500px;
               overflow: hidden;
           }
           
           .news-detail__image img {
               width: 100%;
               height: 100%;
               object-fit: cover;
           }
           
           .news-detail__date {
               position: absolute;
               bottom: 30px;
               left: 30px;
               background: rgba(218, 150, 62, 0.9);
               color: #fff;
               padding: 12px 25px;
               border-radius: 30px;
               font-size: 15px;
               font-weight: 500;
               display: flex;
               align-items: center;
               gap: 8px;
               backdrop-filter: blur(5px);
           }
           
           .news-detail__content {
               padding: 40px;
           }
           
           .news-detail__title {
               font-size: 32px;
               font-weight: 700;
               color: #040404;
               margin-bottom: 25px;
               line-height: 1.4;
           }
           
           .news-detail__text {
               color: #666;
               font-size: 16px;
               line-height: 1.8;
           }
           
           .news-detail__text p {
               margin-bottom: 20px;
           }
           
           .news-detail__text img {
               max-width: 100%;
               height: auto;
               border-radius: 12px;
               margin: 25px 0;
           }
           
           /* Sidebar Styles */
           .sidebar {
               position: sticky;
               top: 30px;
           }
           
           .sidebar-widget {
               background: #fff;
               border-radius: 15px;
               padding: 30px;
               box-shadow: 0 5px 20px rgba(0,0,0,0.05);
               margin-bottom: 30px;
           }
           
           .sidebar-title {
               font-size: 20px;
               font-weight: 600;
               color: #040404;
               margin-bottom: 25px;
               padding-bottom: 15px;
               border-bottom: 2px solid #f5f5f5;
               position: relative;
           }
           
           .sidebar-title:after {
               content: '';
               position: absolute;
               bottom: -2px;
               left: 0;
               width: 50px;
               height: 2px;
               background: #da963e;
           }
           
           .recent-post {
               display: flex;
               align-items: start;
               gap: 15px;
               padding: 15px 0;
               border-bottom: 1px solid #f5f5f5;
               transition: all 0.3s ease;
           }
           
           .recent-post:last-child {
               border: none;
               padding-bottom: 0;
           }
           
           .recent-post:hover {
               transform: translateX(5px);
           }
           
           .recent-post__image {
               width: 80px;
               height: 80px;
               border-radius: 10px;
               overflow: hidden;
               flex-shrink: 0;
           }
           
           .recent-post__image img {
               width: 100%;
               height: 100%;
               object-fit: cover;
           }
           
           .recent-post__content {
               flex: 1;
           }
           
           .recent-post__title {
               font-size: 15px;
               font-weight: 500;
               line-height: 1.4;
               margin-bottom: 8px;
               display: -webkit-box;
               -webkit-line-clamp: 2;
               -webkit-box-orient: vertical;
               overflow: hidden;
               color: #040404;
               transition: color 0.3s ease;
           }
           
           .recent-post:hover .recent-post__title {
               color: #da963e;
           }
           
           .recent-post__date {
               font-size: 13px;
               color: #666;
               display: flex;
               align-items: center;
               gap: 5px;
           }
           
           .service-list {
               list-style: none;
               padding: 0;
               margin: 0;
           }
           
           .service-list li {
               border-bottom: 1px solid #f5f5f5;
           }
           
           .service-list li:last-child {
               border: none;
           }
           
           .service-list a {
               display: flex;
               align-items: center;
               justify-content: space-between;
               padding: 15px 0;
               color: #040404;
               transition: all 0.3s ease;
           }
           
           .service-list a:hover {
               color: #da963e;
               padding-left: 10px;
           }
           
           .service-list i {
               font-size: 12px;
               transition: transform 0.3s ease;
           }
           
           .service-list a:hover i {
               transform: translateX(5px);
           }
           
           @media (max-width: 991px) {
               .news-detail__image {
                   height: 400px;
               }
               
               .news-detail__title {
                   font-size: 28px;
               }
               
               .sidebar {
                   margin-top: 40px;
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

      <section class="blog__details-area pt-100 pb-100">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                  <article class="news-detail">
                     <div class="news-detail__image">
                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $tekil_veri_cek["haber_resim"]; ?>" 
                             alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                        <div class="news-detail__date">
                           <i class="fas fa-calendar-alt"></i>
                           <?php echo date("d.m.Y", strtotime($tekil_veri_cek["haber_tarih"])); ?>
                        </div>
                     </div>
                     <div class="news-detail__content">
                        <h1 class="news-detail__title"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h1>
                        <div class="news-detail__text">
                           <?php echo $tekil_veri_cek["haber_aciklama"]; ?>
                        </div>
                     </div>
                  </article>
               </div>

               <div class="col-lg-4">
                  <aside class="sidebar">
                     <!-- Son Haberler -->
                     <div class="sidebar-widget">
                        <h3 class="sidebar-title"><?php echo LANG('son_haberler', $lang); ?></h3>
                        <?php
                        $veri_cek = $db->query("SELECT * FROM haberler 
                                              WHERE haber_durum = 1 
                                              AND dil_id = '$lang'
                                              AND haber_ust_id != {$tekil_veri_cek['haber_ust_id']}
                                              ORDER BY haber_ust_id DESC LIMIT 3");
                        if ($veri_cek->rowCount()){
                           foreach($veri_cek as $veri_listele){
                        ?>
                           <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $veri_listele["haber_seo"]; ?>" 
                              class="recent-post">
                              <div class="recent-post__image">
                                 <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $veri_listele["haber_resim"]; ?>" 
                                      alt="<?php echo $veri_listele["haber_baslik"]; ?>">
                              </div>
                              <div class="recent-post__content">
                                 <h4 class="recent-post__title"><?php echo $veri_listele["haber_baslik"]; ?></h4>
                                 <div class="recent-post__date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo date("d.m.Y", strtotime($veri_listele["haber_tarih"])); ?>
                                 </div>
                              </div>
                           </a>
                        <?php
                           }
                        }
                        ?>
                     </div>

                     <!-- Hizmetlerimiz -->
                     <div class="sidebar-widget">
                        <h3 class="sidebar-title"><?php echo LANG('hizmetlerimiz', $lang); ?></h3>
                        <ul class="service-list">
                           <?php
                           $hizmetler = $db->query("SELECT * FROM hizmetler 
                                                   WHERE haber_durum = 1 
                                                   AND dil_id = '$lang' 
                                                   ORDER BY haber_ust_id ASC LIMIT 5");
                           if ($hizmetler->rowCount()){
                              foreach($hizmetler as $hizmet){
                           ?>
                              <li>
                                 <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $hizmet["haber_seo"]; ?>">
                                    <?php echo $hizmet["haber_baslik"]; ?>
                                    <i class="far fa-long-arrow-right"></i>
                                 </a>
                              </li>
                           <?php
                              }
                           }
                           ?>
                        </ul>
                     </div>
                  </aside>
               </div>
            </div>
         </div>
      </section>
     </main>
     <?php include 'alt.php'; ?>
   </body>
</html>
