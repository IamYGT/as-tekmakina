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
                  <div class="info-item info-item-left mb-2">
                     <span>Telefon</span>
                     <h5><a href="tel:<?php echo $ayarlar["strPhone"]; ?>"><?php echo $ayarlar["strPhone"]; ?></a></h5>
                  </div>
                  
                  <div class="relative">
                     <?php $diller = getDilListesi();
                     if(count($diller)): 
                         $current_lang = getCurrentDil();
                     ?>
                     <div class="relative inline-block text-left">
                        <button type="button" 
                                onclick="document.getElementById('language-dropdown').classList.toggle('hidden')"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-transparent hover:bg-white/10 focus:outline-none rounded-md">
                           <?php foreach($diller as $dil): 
                               if($dil['dil_kod'] == $current_lang): ?>
                                   <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
                                   <?php echo $dil['dil_baslik']; ?>
                               <?php endif; 
                           endforeach; ?>
                           <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                               <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                           </svg>
                        </button>
                        <div id="language-dropdown" class="hidden absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                           <div class="py-1">
                               <?php foreach($diller as $dil): ?>
                                   <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                                      class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                       <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
                                       <?php echo $dil['dil_baslik']; ?>
                                   </a>
                               <?php endforeach; ?>
                           </div>
                        </div>
                     </div>
                     <?php endif; ?>
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

         <div class="sidebar__language mb-20">
            <?php $diller = getDilListesi();
            if(count($diller)): 
                $current_lang = getCurrentDil();
            ?>
            <div class="relative inline-block text-left w-full">
                <button type="button" 
                        onclick="document.getElementById('mobile-language-dropdown').classList.toggle('hidden')"
                        class="inline-flex items-center justify-between w-full px-4 py-3 text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none border-b">
                    <?php foreach($diller as $dil): 
                        if($dil['dil_kod'] == $current_lang): ?>
                            <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
                            <?php echo $dil['dil_baslik']; ?>
                        <?php endif; 
                    endforeach; ?>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="mobile-language-dropdown" 
                     class="hidden absolute left-0 right-0 mt-1 bg-white shadow-lg z-50">
                    <?php foreach($diller as $dil): ?>
                        <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                           class="flex items-center px-4 py-3 text-base text-gray-700 hover:bg-gray-100 border-b last:border-b-0">
                            <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
                            <?php echo $dil['dil_baslik']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
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
