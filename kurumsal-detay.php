<?php require("include/baglan.php");
include("include/fonksiyon.php");
include_once("inc.lang.php");

// Önce seçili dilde içeriği deneyelim
$tekil_veri_cek = $db->query("SELECT * FROM kurumsal 
                             WHERE haber_durum = 1 
                             AND haber_seo = '{$_GET["url"]}' 
                             AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);

if (!$tekil_veri_cek) {
    // Seçili dilde içerik yoksa, bu SEO URL'ye sahip TR içeriği bulalım
    $tr_veri = $db->query("SELECT * FROM kurumsal 
                          WHERE haber_durum = 1 
                          AND haber_seo = '{$_GET["url"]}' 
                          AND dil_id = 'tr'")->fetch(PDO::FETCH_ASSOC);

    if ($tr_veri) {
        // TR içeriğin ust_id'sine göre seçili dildeki karşılığını bulalım
        $tekil_veri_cek = $db->query("SELECT * FROM kurumsal 
                                     WHERE haber_durum = 1 
                                     AND haber_ust_id = '{$tr_veri["haber_ust_id"]}' 
                                     AND dil_id = '$lang'")->fetch(PDO::FETCH_ASSOC);

        // Seçili dilde karşılığı yoksa TR içeriği gösterelim
        if (!$tekil_veri_cek) {
            $tekil_veri_cek = $tr_veri;
        }
    } else {
        // Hiç içerik bulunamadıysa 404 sayfasına yönlendir
        header("Location: " . $ayarlar["strURL"] . "/404");
        exit;
    }
}

// Diğer dillerdeki karşılıklarını bulalım (dil menüsü için)
$dil_karsiliklari = $db->query("SELECT k.haber_seo, k.dil_id, d.dil_kod, d.dil_baslik 
                               FROM kurumsal k
                               INNER JOIN dil d ON d.dil_kod = k.dil_id  
                               WHERE k.haber_ust_id = '{$tekil_veri_cek["haber_ust_id"]}' 
                               AND k.haber_durum = 1")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?php echo $tekil_veri_cek["haber_baslik"]; ?> - <?php echo $ayarlar["strTitle"]; ?></title>
    <!-- Dil linkleri için canonical ve alternate tagları -->
    <link rel="canonical" href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $tekil_veri_cek["haber_seo"]; ?>" />
    <?php foreach ($dil_karsiliklari as $dk) { ?>
        <link rel="alternate" hreflang="<?php echo $dk["dil_kod"]; ?>"
            href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $dk["haber_seo"]; ?>" />
    <?php } ?>
    <?php include 'css.php'; ?>
    <style>
        /* Hero Bölümü */
        .page__title-area {
            position: relative;
            padding: 100px 0;
            background-size: cover;
            background-position: center;
            margin-bottom: 80px;
        }

        .page__title-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(34, 30, 31, 0.9), rgba(34, 30, 31, 0.7));
        }

        /* Ana Container Stilleri */
        .about-company {
            padding: 0 0 100px 0;
            background: #fff;
        }

        /* Görsel Wrapper */
        .company-image-wrapper {
            position: relative;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .company-image-wrapper:hover {
            transform: translateY(-5px);
        }

        /* Görsel Stilleri */
        .company-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .company-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.5));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .company-image:hover::before {
            opacity: 1;
        }

        .company-image img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .company-image:hover img {
            transform: scale(1.05);
        }

        /* Deneyim Badge Stilleri */
        .experience-badge {
            position: absolute;
            right: 30px;
            bottom: 0px;
            background: var(--primary-color);
            padding: 25px 35px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(218, 150, 62, 0.25);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .experience-badge:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(218, 150, 62, 0.3);
        }

        .experience-content {
            text-align: center;
            color: #fff;
        }

        .experience-number {
            display: block;
            font-size: 42px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
            background: linear-gradient(45deg, #fff, rgba(255, 255, 255, 0.9));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .experience-text {
            display: block;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        /* İçerik Stilleri */
        .company-content {
            padding: 20px 0 20px 40px;
        }

        .company-title {
            font-size: 36px;
            color: var(--secondary-color);
            margin-bottom: 25px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        .company-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .company-description {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
        }

        .company-description p {
            margin-bottom: 15px;
        }

        /* Misyon Vizyon Kartları */
        .mission-vision {
            background: #f8f9fa;
            padding: 80px 0;
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 20px;
            padding: 40px 30px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(218, 150, 62, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .card:hover .icon-box {
            background: var(--primary-color);
        }

        .icon-box i {
            font-size: 40px;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .card:hover .icon-box i {
            color: #fff;
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--secondary-color);
            font-weight: 700;
        }

        .card-text {
            color: #666;
            line-height: 1.7;
            font-size: 16px;
        }

        /* Responsive Düzenlemeler */
        @media (max-width: 991px) {
            .company-content {
                padding: 40px 0 0 0;
            }

            .company-image-wrapper {
                max-width: 100%;
                margin: 0 auto 80px;
            }

            .company-image img {
                height: 400px;
            }

            .experience-badge {
                right: 50%;
                transform: translateX(50%);
            }
        }

        @media (max-width: 767px) {
            .page__title-area {
                padding: 80px 0;
                margin-bottom: 60px;
            }

            .about-company {
                padding: 0 0 60px 0;
            }

            .company-title {
                font-size: 30px;
            }

            .company-image img {
                height: 350px;
            }

            .experience-badge {
                padding: 20px 30px;
            }

            .experience-number {
                font-size: 36px;
            }
        }

        @media (max-width: 575px) {
            .company-image-wrapper {
                margin-bottom: 70px;
            }

            .company-image img {
                height: 300px;
            }

            .experience-badge {
                padding: 15px 25px;
                bottom: 0px;
            }

            .experience-number {
                font-size: 32px;
            }

            .experience-text {
                font-size: 13px;
            }

            .card {
                padding: 30px 20px;
            }
        }

        /* Hizmetler Bölümü Stilleri */
        .services-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-title {
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 36px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
            position: relative;
        }

        .divider {
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
            margin-bottom: 30px;
        }

        .service-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(var(--primary-color-rgb), 0.05), rgba(var(--primary-color-rgb), 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .service-card:hover::after {
            opacity: 1;
        }

        .service-card-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .service-img {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .service-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            z-index: 2;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .3) 100%);
            transform: skewX(-25deg);
            transition: 0.75s;
        }

        .service-card:hover .service-img::before {
            animation: shine 1s;
        }

        @keyframes shine {
            100% {
                left: 125%;
            }
        }

        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .service-card:hover .service-img img {
            transform: scale(1.1);
        }

        .service-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
            padding: 25px !important;
            position: relative;
            z-index: 1;
        }

        .service-content::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .service-card:hover .service-content::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .service-content h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .service-card:hover .service-content h4 {
            color: var(--primary-color);
        }

        .service-content p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
            transition: color 0.3s ease;
        }

        .service-card:hover .service-content p {
            color: #444;
        }

        /* Responsive Düzenlemeler */
        @media (max-width: 991px) {
            .services-section {
                padding: 60px 0;
            }

            .section-title h2 {
                font-size: 32px;
            }
        }

        @media (max-width: 767px) {
            .section-title {
                margin-bottom: 40px;
            }

            .section-title h2 {
                font-size: 28px;
            }

            .service-img {
                height: 180px;
            }
        }

        @media (max-width: 575px) {
            .services-section {
                padding: 40px 0;
            }

            .service-content {
                padding: 20px !important;
            }

            .service-content h4 {
                font-size: 18px;
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
                                    <li><a href="<?php echo $ayarlar["strURL"]; ?>/"><?php echo LANG('menu_anasayfa', $lang); ?></a></li>
                                    <li><span><?php echo LANG('menu_kurumsal', $lang); ?></span></li>
                                </ul>
                            </div>
                            <h3 class="page__title mt-20"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-company py-20">
            <div class="container">
                <div class="row">
                    <!-- Görsel ve Deneyim Alanı -->
                    <div class="col-lg-6 mb-lg-0 mb-5">
                        <div class="company-image-wrapper">
                            <?php if ($tekil_veri_cek["haber_resim"]) { ?>
                                <div class="company-image">
                                    <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/image.jpg"
                                        alt="<?php echo $tekil_veri_cek["haber_baslik"]; ?>">
                                </div>
                            <?php } ?>

                            <?php if ($tekil_veri_cek["haber_yillik"]) { ?>
                                <div class="experience-badge">
                                    <div class="experience-content">
                                        <span class="experience-number"><?php echo $tekil_veri_cek["haber_yillik"]; ?>+</span>
                                        <span class="experience-text"><?php echo LANG('yillik_tecrube', $lang); ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- İçerik Alanı -->
                    <div class="col-lg-6">
                        <div class="company-content">
                            <h2 class="company-title"><?php echo $tekil_veri_cek["haber_baslik"]; ?></h2>
                            <div class="company-description">
                                <?php echo $tekil_veri_cek["haber_aciklama"]; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mission-vision bg-light py-5">
            <div class="container">
                <div class="row">
                    <?php if ($tekil_veri_cek["haber_description"]) { ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="icon-box mb-3">
                                        <i class="fas fa-bullseye fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="card-title"><?php echo LANG('misyonumuz', $lang); ?></h4>
                                    <p class="card-text"><?php echo $tekil_veri_cek["haber_description"]; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($tekil_veri_cek["haber_kisaaciklama"]) { ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="icon-box mb-3">
                                        <i class="fas fa-eye fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="card-title"><?php echo LANG('vizyonumuz', $lang); ?></h4>
                                    <p class="card-text"><?php echo $tekil_veri_cek["haber_kisaaciklama"]; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($tekil_veri_cek["haber_kalite"]) { ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="icon-box mb-3">
                                        <i class="fas fa-award fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="card-title"><?php echo LANG('kalite_politikamiz', $lang); ?></h4>
                                    <p class="card-text"><?php echo $tekil_veri_cek["haber_kalite"]; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section class="services-section py-5">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <h2><?php echo LANG('hizmetlerimiz_title', $lang); ?></h2>
                    <div class="divider mx-auto"></div>
                </div>

                <div class="row">
                    <?php
                    $veri_cek = $db->query("SELECT * FROM hizmetler 
                                      WHERE haber_durum = 1 
                                      AND dil_id = '$lang' 
                                      ORDER BY haber_ust_id ASC LIMIT 4");
                    if ($veri_cek->rowCount()) {
                        foreach ($veri_cek as $veri_listele) {
                    ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="service-card">
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"
                                        class="service-card-link"
                                        aria-label="<?php echo $veri_listele["haber_baslik"]; ?>"></a>
                                    <div class="service-img">
                                        <img src="<?php echo $ayarlar["strURL"]; ?>/uploads/services/<?php echo $veri_listele["haber_resim"]; ?>"
                                            alt="<?php echo $veri_listele["haber_baslik"]; ?>"
                                            class="img-fluid">
                                    </div>
                                    <div class="service-content">
                                        <h4><?php echo $veri_listele["haber_baslik"]; ?></h4>
                                        <?php if ($veri_listele["haber_kisaaciklama"]) { ?>
                                            <p><?php echo $veri_listele["haber_kisaaciklama"]; ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center">' . LANG('listelenecek_veri_bulunamadi', $lang) . '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php include 'alt.php'; ?>
</body>

</html>