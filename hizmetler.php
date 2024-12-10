<?php
require("include/baglan.php"); 
include("include/fonksiyon.php"); 
include_once("inc.lang.php");

// Hizmetleri seçili dilde getir
$hizmetler_query = $db->prepare("SELECT * FROM hizmetler 
                                WHERE dil_id = ? AND haber_durum = 1 
                                ORDER BY row ASC");
$hizmetler_query->execute([$lang]);
$hizmetler = $hizmetler_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?php echo LANG('services', $lang); ?> - <?php echo $ayarlar["strTitle"]; ?></title>
    <?php include 'css.php'; ?>
    <style>
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 30px 0;
        }

        /* Kart Stilleri */
        .service-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(218, 150, 62, 0.15);
        }

        /* Resim Alanı */
        .service-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .service-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(218, 150, 62, 0);
            transition: all 0.4s ease;
        }

        .service-card:hover .service-image img {
            transform: scale(1.08);
        }

        .service-card:hover .service-image::after {
            background: rgba(218, 150, 62, 0.2);
        }

        /* İçerik Alanı */
        .service-content {
            padding: 25px;
            position: relative;
        }

        .service-title {
            color: #221E1F;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .service-card:hover .service-title {
            color: #da963e;
        }

        .service-description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Link Alanı */
        .service-link {
            display: inline-flex;
            align-items: center;
            color: #da963e;
            font-weight: 500;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .service-link i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .service-card:hover .service-link i {
            transform: translateX(5px);
        }

        /* Responsive Düzenlemeler */
        @media (max-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .service-title {
                font-size: 20px;
            }

            .service-description {
                font-size: 14px;
            }

            .service-image {
                height: 220px;
            }
        }
    </style>
</head>

<body>
    <?php include 'ust.php'; ?>

    <!-- Sayfa Başlığı -->
    <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center" 
             data-background="<?php echo $ayarlar["strURL"]; ?>/assets/img/bg/services-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="page__title-wrapper mt-100">
                        <div class="breadcrumb-menu">
                            <ul>
                                <li><a href="<?php echo $ayarlar["strURL"]; ?>/"><?php echo LANG('homepage', $lang); ?></a></li>
                                <li><span><?php echo LANG('services', $lang); ?></span></li>
                            </ul>
                        </div>
                        <h3 class="page__title mt-20"><?php echo LANG('services', $lang); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hizmetler Listesi -->
    <section class="services-section pt-120 pb-120">
        <div class="container">
            <div class="services-grid">
                <?php foreach($hizmetler as $hizmet) { ?>
                    <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $hizmet["haber_seo"]; ?>" 
                       class="service-card">
                        <div class="service-image">
                            <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $hizmet["haber_resim"]; ?>" 
                                 alt="<?php echo $hizmet["haber_baslik"]; ?>">
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><?php echo $hizmet["haber_baslik"]; ?></h3>
                            <p class="service-description">
                                <?php echo strip_tags(mb_substr($hizmet["haber_aciklama"], 0, 150)) . '...'; ?>
                            </p>
                            <div class="service-link">
                                <?php echo LANG('read_more', $lang); ?>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'alt.php'; ?>
</body>
</html> 