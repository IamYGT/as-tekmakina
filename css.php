<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind CSS -->
<link href="<?php echo $ayarlar["strURL"]; ?>/assets/css/tailwind.css" rel="stylesheet">

<link rel="icon" type="image/x-icon" href="<?php echo $ayarlar["strURL"]; ?>/assets/img/favicon/favicon.ico">
<link rel="icon" type="image/svg+xml" href="<?php echo $ayarlar["strURL"]; ?>/assets/img/favicon/favicon.svg">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $ayarlar["strURL"]; ?>/assets/img/favicon/favicon-96x96.png">
<link rel="apple-touch-icon" href="<?php echo $ayarlar["strURL"]; ?>/assets/img/favicon/apple-touch-icon.png">
<link rel="manifest" href="<?php echo $ayarlar["strURL"]; ?>/assets/img/favicon/site.webmanifest">

<!-- Diğer CSS dosyaları -->
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/meanmenu.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/animate.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/owl-carousel.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/swiper-bundle.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/backtotop.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/magnific-popup.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/nice-select.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/flaticon.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/font-awesome-pro.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/spacing.css">
<link rel="stylesheet" href="<?php echo $ayarlar["strURL"]; ?>/assets/css/style.css">

<!-- Flag Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icon-css@4.1.7/css/flag-icons.min.css" />





<script>
  document.addEventListener('click', function(event) {
    const dropdowns = ['language-dropdown', 'mobile-language-dropdown'];

    dropdowns.forEach(function(id) {
      const dropdown = document.getElementById(id);
      const button = event.target.closest('button');

      if (dropdown && !button && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
      }
    });
  });
</script>

<style>
  /* Tailwind özel renk tanımlamaları */
  :root {
    --color-primary: #da963e;
    --color-secondary: #221E1F;
  }

  /* Tailwind utility class'ları */
  .bg-primary {
    background-color: var(--color-primary);
  }

  .bg-secondary {
    background-color: var(--color-secondary);
  }

  .text-primary {
    color: var(--color-primary);
  }

  .text-secondary {
    color: var(--color-secondary);
  }

  .border-primary {
    border-color: var(--color-primary);
  }

  .border-secondary {
    border-color: var(--color-secondary);
  }
</style>