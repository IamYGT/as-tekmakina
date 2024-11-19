<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Sadece dil seçici için Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<style type="text/tailwindcss">
  @layer utilities {
    .language-dropdown {
      @apply absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50;
    }
    
    .language-option {
      @apply flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100;
    }
  }
</style>

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>

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
