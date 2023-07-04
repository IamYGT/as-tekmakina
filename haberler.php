<?php require("include/baglan.php"); include("include/fonksiyon.php"); include_once("inc.lang.php");
$sayfa = (isset($q) ? $q : 1);
$toplam_veri_sayisi = $db->query("SELECT COUNT(*) FROM haberler WHERE dil_id = 'tr' ")->fetchColumn();
$limit = 4; //gösterilecek veri sayısı
$sonSayfa = ceil($toplam_veri_sayisi/$limit);
$baslangic = ($sayfa-1)*$limit;

?>
<!DOCTYPE html>
<html lang="tr">
   <head>
       <title>Haberler - AS-TEK Makina Teçhizat Kimya ve Laboratuvar Ekipmanları </title>
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
                            <li><a href="<?php echo $ayarlar["strURL"]; ?>/index">Anasayfa</a></li>
                            <li><span>Haberler</span></li>
                        </ul>
                    </div>
                     <h3 class="page__title mt-20">Haberler</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <div class="blog__area pt-80 pb-65">
   <div class="container custom-container-3">
      <div class="row">
         <div class="col-lg-12">
           <div class="row">
             <?php
             		$list = $db->query("SELECT * FROM haberler WHERE  dil_id = 'tr' ORDER BY haber_ust_id DESC LIMIT $baslangic,$limit");
             			if ($list->rowCount()){
             				foreach($list as $row){
             ?>
               <div style="padding: 30px;" class="tp-blog mb-30 col-lg-6 col-12">
                  <div class="tp-blog__thumb m-img mb-15">
                     <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>"><img src="<?php echo $ayarlar["strURL"]; ?>/uploads/haberler/<?php echo $row["haber_resim"]; ?>" alt="<?php echo $row["haber_baslik"]; ?>"></a>
                  </div>
                  <div class="tp-blog__content">
                     <div style="margin-bottom: 12px;" class="tp-blog__meta mb-15">
                        <span><a href="#"><i class="fal fa-clock"></i> <?php echo date("d/m/Y", strtotime($row["haber_tarih"])); ?> </a></span>
                        <span><a href="#"><i class="far fa-user"></i> As-Tek Makina</a></span>
                      </div>
                     <h3 class="tp-blog__title mb-15"><a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>"><?php echo $row["haber_baslik"]; ?></a></h3>
                     <p><?php echo $row["haber_kisaaciklama"]; ?></p>
                     <div class="tp-blog-btn mt-25">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/haber/<?php echo $row["haber_seo"]; ?>" class="tp-btn">Devamını Oku</a>
                     </div>
                  </div>
               </div>
               <?php
                       }
                     }else{
                       echo 'Listelenecek veri bulunamadı.';
                     }
               ?>
             </div>
               <?php if($toplam_veri_sayisi > $limit){ ?>

               <div class="tp-pagination">
                  <nav>
                     <ul>

                       <?php
                         $x = 2;
                         if($sayfa > 1){
                           $onceki = $sayfa-1;
                           echo '<li><a href="?q='.$onceki.'"> <i class="far fa-angle-left"></i> </a> </li>';
                         }
                         if($sayfa==1){
                           echo '<li> <span class="current">1</span></li>';
                         } else {
                           echo '<li><a href="?q=1" >1</a></li>';
                         }
                         if($sayfa-$x > 2){
                           echo '...';
                           $i = $sayfa-$x;
                         } else {
                           $i = 2;
                         }
                         for($i; $i<=$sayfa+$x; $i++) {
                           if($i==$sayfa){
                             echo '<li> <span class="current">'.$i.'</span></li>';
                           } else {
                             echo '<li><a href="?q='.$i.'" >'.$i.'</a></li>';
                           }
                           if($i==$sonSayfa) break;
                         }
                         if($sayfa < $sonSayfa){
                           $sonraki = $sayfa+1;
                           echo '<li><a href="?q='.$sonraki.'"> <i class="far fa-angle-right"> </i></a> </li>';
                         }
                     ?>
                     </ul>
                   </nav>
               </div>
                    <?php } ?>
          </div>
         </div>
   </div>
</div>

     </main>
<?php include 'alt.php'; ?>
   </body>
</html>
