<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
   <head>
       <title><?php echo LANG('menu_iletisim', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
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
                            <li><span><?php echo LANG('menu_iletisim', $lang); ?></span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20"><?php echo LANG('menu_iletisim', $lang); ?></h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
       <section class="contact__area pt-120 pb-80" data-background="<?php echo $ayarlar["strURL"]; ?>/assets/img/bg/contact-bg.png">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-6">
                  <div class="contact__item text-center mb-30">
                     <div class="contact__icon mb-35">
                        <i class="fal fa-envelope-open-text"></i>
                     </div>
                     <h5 class="contact__title mb-25"><?php echo LANG('eposta', $lang); ?></h5>
                     <div class="contact__text">
                        <p><a href="mailto:<?php echo $ayarlar["strMail"]; ?>"><?php echo $ayarlar["strMail"]; ?></a></p>
                      </div>

                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="contact__item text-center mb-30">
                     <div class="contact__icon mb-35">
                        <i class="fa-light fa-phone"></i>
                     </div>
                     <h5 class="contact__title mb-25"><?php echo LANG('telefon', $lang); ?></h5>
                     <div class="contact__text">
                        <p><a href="tel:<?php echo $ayarlar["strPhone"]; ?>"><?php echo $ayarlar["strPhone"]; ?></a></p>
                        <p><a href="tel:<?php echo $ayarlar["strFax"]; ?>"><?php echo $ayarlar["strFax"]; ?></a></p>
                      </div>

                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="contact__item text-center mb-30">
                     <div class="contact__icon mb-35">
                        <i class="fa-light fa-map-location-dot"></i>
                     </div>
                     <h5 class="contact__title mb-25"><?php echo LANG('adres', $lang); ?></h5>
                     <div class="contact__text">
                        <p><a href="#"><?php echo $ayarlar["strAddress"]; ?></a></p>
                     </div>

                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="contact__item text-center mb-30">
                     <div class="contact__icon mb-35">
                        <i class="fa-light fa-bullseye-arrow"></i>
                     </div>
                     <h5 class="contact__title mb-25"><?php echo LANG('sosyal_medya', $lang); ?></h5>
                     <div class="contact__social mt-30">
                        <a href="<?php echo $ayarlar["strFacebook"]; ?>"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="<?php echo $ayarlar["strTwitter"]; ?>"><i class="fa-brands fa-twitter"></i></a>
                        <a href="<?php echo $ayarlar["strInstagram"]; ?>"><i class="fa-brands fa-instagram"></i></a>
                        <a href="<?php echo $ayarlar["strYoutube"]; ?>"><i class="fa-brands fa-youtube"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- contact__area end -->

      <!-- contact__area-2 start -->
      <section class="contact__area-2">
         <div class="container">
            <div class="contact__form">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="section__wrapper mb-45">
                           <h4 class="section__title"><?php echo LANG('iletisim_formuyla_bizlere_ulasabilirsiniz', $lang); ?></h4>
                           <div class="r-text">
                              <span><?php echo LANG('iletisim', $lang); ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-12">
                        <form id="contact-form" action="mail.php" method="POST">
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="contact-filed mb-20">
                                    <input type="text" name="isim" placeholder="<?php echo LANG('isminiz', $lang); ?>">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="contact-filed contact-icon-telefon mb-20">
                                    <input type="text" name="telefon" placeholder="<?php echo LANG('telefon', $lang); ?>">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="contact-filed contact-icon-konu mb-20">
                                    <input type="text" name="konu" placeholder="<?php echo LANG('konu', $lang); ?>">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="contact-filed contact-icon-mail mb-20">
                                    <input email="text" name="eposta" placeholder="<?php echo LANG('eposta_adresiniz', $lang); ?>">
                                </div>
                              </div>
                           </div>
                           <div class="contact-filed contact-icon-message mb-25">
                                 <textarea placeholder="<?php echo LANG('mesajiniz', $lang); ?>" name="mesaj"></textarea>
                          </div>
                           <div class="form-submit text-center">
                               <button class="tp-btn" type="submit"><?php echo LANG('gonder', $lang); ?></button>
                           </div>
                           <p class="ajax-response"></p>
                       </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- contact__area-2 end -->

      <!-- contact__map start -->
      <section class="contact__map">
         <div class="contact__map-wrap">
             <iframe id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3187.3862978185!2d35.26088911529485!3d36.97671137991262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1ab7b66568e5687e!2zMzbCsDU4JzM2LjIiTiAzNcKwMTUnNDcuMSJF!5e0!3m2!1str!2str!4v1655891541953!5m2!1str!2str"></iframe>
              <div class="contact__map-icon">
                  <i class="fa-solid fa-location-dot"></i>
                  <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/bg/contact-icon-bg.png" alt="">
             </div>
         </div>
      </section>
      <!-- contact__map end -->

     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
