      <footer>
         <div class="footer-area pt-100 fix" style="background-color: #040404;">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                     <div class="footer__widget mb-40">
                        <h5 class="footer__widget-title"><?php echo LANG('footer_hizli_menu', $lang); ?></h5>
                        <div class="footer__widget-content">
                           <div class="footer__links">
                              <ul>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/index"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/#"><?php echo LANG('menu_hakkimizda', $lang); ?></a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/referanslar"><?php echo LANG('menu_referanslar', $lang); ?></a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/projeler"><?php echo LANG('menu_projeler', $lang); ?></a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/haberler"><?php echo LANG('menu_haberler', $lang); ?></a></li>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/iletisim"><?php echo LANG('menu_iletisim', $lang); ?></a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                     <div class="footer__widget mb-40">
                        <h5 class="footer__widget-title"><?php echo LANG('footer_kurumsal', $lang); ?></h5>
                        <div class="footer__widget-content">
                           <div class="footer__links">
                              <ul>
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
                        </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                     <div class="footer__widget mb-40">
                        <h5 class="footer__widget-title"><?php echo LANG('footer_hizmetlerimiz', $lang); ?></h5>
                        <div class="footer__widget-content">
                           <div class="footer__links">
                              <ul>
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
                              ?>                              </ul>
                        </div>
                        </div>
                     </div>
                  </div>
                     <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4">
                        <div class="footer__widget mb-40">
                           <div class="footer__logo">
                              <a href="<?php echo $ayarlar["strURL"]; ?>/index">
                                <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo_pumada.png" alt="Pumada">
                              </a>
                           </div>
                        </div>
                     </div>
               </div>
               <div class="footer__copyright white-bg mt-60">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="footer__copyright-text">
                           <p>Copyright © <a href="https://www.pumada.me" rel="dofollow">PUMADA GROUP DOO </a> <?php echo LANG('footer_copyright', $lang); ?></p>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="footer__copyright-links text-sm-end">
                          <p><?php echo LANG('footer_tasarim', $lang); ?> <a href="https://www.memsidea.com" rel="dofollow">Memsidea</a></p>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- <div class="footer__shape-1">
               <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/footer/footer-shape-1.png" alt="Astek Makina Shape">
            </div> -->
            <!-- <div class="footer__shape-2">
               <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/footer/footer-shape-2.png" alt="Astek Makina Shape">
            </div> -->
         </div>
      </footer>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/vendor/jquery.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/vendor/waypoints.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/bootstrap-bundle.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/meanmenu.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/swiper-bundle.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/owl-carousel.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/magnific-popup.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/parallax.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/backtotop.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/nice-select.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/counterup.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/wow.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/isotope-pkgd.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/imagesloaded-pkgd.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/ajax-form.js"></script>
      <script src="<?php echo $ayarlar["strURL"]; ?>/assets/js/main.js"></script>

</body>
</html>
