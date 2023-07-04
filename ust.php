<div class="preloader"></div>
<div class="progress-wrap">
   <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
   </svg>
</div>
<header id="header-sticky" class="header-area">
   <div class="container-fluid">
         <div class="row align-items-center">
            <div class="col-xl-2 col-lg-2 col-md-6 col-6">
               <div class="logo-area">
                     <div class="logo">
                        <a href="<?php echo $ayarlar["strURL"]; ?>"><img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo-white.png" alt="As-Tek Makina Logo"></a>
                     </div>
               </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-6 col-6">
               <div class="menu-area">
                     <div class="main-menu">
                        <nav id="mobile-menu">
                           <ul>
                 <li><a href="<?php echo $ayarlar["strURL"]; ?>/index">Anasayfa</a></li>
                  <li class="has-dropdown"><a href="#">Kurumsal</a>
                     <ul class="sub-menu">
                       <?php
                           $veri_cek = $db->query("SELECT * FROM kurumsal WHERE haber_durum = 1  AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 6");
                           if ($veri_cek->rowCount()){
                           foreach($veri_cek as $veri_listele){
                     ?>  <li><a href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></li>
                     <?php
                             }
                           }else{
                             "Listelenecek veri bulunamadı.";
                           }
                     ?>
                      </ul>
                   </li>
                   <li class="has-dropdown"><a href="#">Hizmetlerimiz</a>
                      <ul class="sub-menu">

                        <?php
                            $veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1  AND dil_id = 'tr' ORDER BY haber_ust_id ASC LIMIT 6");
                            if ($veri_cek->rowCount()){
                            foreach($veri_cek as $veri_listele){
                      ?>  <li><a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"><?php echo 	$veri_listele["haber_baslik"]; ?></a></li>
                      <?php
                              }
                            }else{
                              "Listelenecek veri bulunamadı.";
                            }
                    ?>

                           </ul>
                                </li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/referanslar">Referanslar</a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/projeler">Projeler</a></li>
                                 <li><a href="<?php echo $ayarlar["strURL"]; ?>/haberler">Haberler</a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/iletisim">İletişim</a></li>
                           </ul>
                        </nav>
                     </div>
               </div>
               <div class="side-menu-icon d-lg-none text-end">
                  <a href="javascript:void(0)" class="info-toggle-btn f-right sidebar-toggle-btn"><i class="fal fa-bars"></i></a>
               </div>
            </div>
            <div class="col-xl-2 col-lg-3 d-none d-lg-block">
               <div class="header-info f-left">
                     <div class="info-item info-item-left">
                        <span>Telefon</span>
                        <h5><a href="tel:<?php echo $ayarlar["strPhone"]; ?>"><?php echo $ayarlar["strPhone"]; ?></a></h5>
                     </div>

               </div>
            </div>
         </div>
   </div>
</header>
<div class="sidebar__area">
   <div class="sidebar__wrapper">
      <div class="sidebar__close">
         <button class="sidebar__close-btn" id="sidebar__close-btn">
            <i class="fal fa-times"></i>
         </button>
      </div>
      <div class="sidebar__content">
         <div class="sidebar__logo mb-40">
            <a href="<?php echo $ayarlar["strURL"]; ?>/index">
            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo-black.png" alt="logo">
            </a>
         </div>

         <div class="mobile-menu fix"></div>
         <div class="sidebar__contact mt-30 mb-20">
            <h4>İletişim Bilgileri</h4>
            <ul>
               <li class="d-flex align-items-center">
                  <div class="sidebar__contact-icon mr-15">
                     <i class="fal fa-map-marker-alt"></i>
                  </div>
                  <div class="sidebar__contact-text">
                     <a  ><?php echo $ayarlar["strAddress"]; ?></a>
                  </div>
               </li>
               <li class="d-flex align-items-center">
                  <div class="sidebar__contact-icon mr-15">
                     <i class="far fa-phone"></i>
                  </div>
                  <div class="sidebar__contact-text">
                     <a href="tel:<?php echo $ayarlar["strPhone"]; ?>"><?php echo $ayarlar["strPhone"]; ?></a>
                  </div>
               </li>
               <li class="d-flex align-items-center">
                  <div class="sidebar__contact-icon mr-15">
                     <i class="fal fa-envelope"></i>
                  </div>
                  <div class="sidebar__contact-text">
                     <a href="mailto:<?php echo $ayarlar["strMail"]; ?>"><?php echo $ayarlar["strMail"]; ?></a>
                  </div>
               </li>
            </ul>
         </div>
         <div class="sidebar__social">
            <ul>
               <li><a href="<?php echo $ayarlar["strFacebook"]; ?>"><i class="fab fa-facebook-f"></i></a></li>
               <li><a href="<?php echo $ayarlar["strTwitter"]; ?>"><i class="fab fa-twitter"></i></a></li>
               <li><a href="<?php echo $ayarlar["strInstagram"]; ?>"><i class="fab fa-instagram"></i></a></li>
               <li><a href="<?php echo $ayarlar["strYoutube"]; ?>"><i class="fab fa-youtube"></i></a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
<div class="body-overlay"></div>
