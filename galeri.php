<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <title><?php echo LANG('menu_galeri', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
    <?php include 'css.php'; ?>
    
    <!-- Ek CSS Kütüphaneleri -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css"  />
    <style>
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .gallery-item {
            width: calc(33.33% - 20px);
            margin: 10px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            background-color: #fff;
            position: relative;
        }
        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .gallery-item a {
            display: block;
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            aspect-ratio: 4/3;
            transition: transform 0.4s ease;
            border-radius: 12px 12px 0 0;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .gallery-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: 12px;
        }
        .gallery-item:hover::before {
            opacity: 1;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-slide img {
            display: block;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        @media (max-width: 992px) {
            .gallery-item {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 768px) {
            .gallery-item {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 576px) {
            .gallery-item {
                width: calc(100% - 20px);
            }
        }
    </style>
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
                                    <li><a href="<?php echo $ayarlar["strURL"]; ?>/" class="breadcrumb-item"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                                    <li><span class="breadcrumb-item active"><?php echo LANG('menu_galeri', $lang); ?></span></li>
                                </ul>
                            </div>
                            <h3 class="page__title mt-20"><?php echo LANG('menu_galeri', $lang); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="portfolio-area pt-110 pb-110">
            <div class="container">
                <div class="gallery-container">
                    <?php
                        $veri_cek = $db->query("SELECT * FROM galeri_resimler ORDER BY galeri_tarih DESC");
                        if ($veri_cek->rowCount()) {
                            foreach($veri_cek as $veri_listele) {
                    ?>
                        <div class="gallery-item">
                            <a href="<?php echo $ayarlar["strURL"]; ?>/uploads/gallery/<?php echo $veri_listele["galeri_resim"]; ?>" data-fancybox="gallery">
                                <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/gallery/<?php echo $veri_listele["galeri_resim"]; ?>" alt="Galeri Resmi">
                            </a>
                        </div>
                    <?php
                            }
                        } else {
                            echo '<div class="col-12 text-center">
                                    <div class="alert alert-warning">
                                        '.LANG('listelenecek_veri_bulunamadi', $lang).'
                                    </div>
                                </div>';
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php include 'alt.php'; ?>
    
    <!-- Ek JavaScript Kütüphaneleri -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-fancybox="gallery"]').fancybox({
                buttons: [
                    "slideShow",
                    "thumbs",
                    "close"
                ],
                loop: true,
                animationEffect: "zoom",
                transitionEffect: "slide",
            });
        });
    </script>
</body>
</html>