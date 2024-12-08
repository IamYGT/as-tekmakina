<!-- Language Selector -->
<?php include 'components/language-switcher.php'; ?><!-- Scroll to Top Button -->


<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<!-- Header -->
<header
    id="mainHeader"
    class="fixed w-full top-0 left-0 z-40 bg-[#040404]">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-24">
            <!-- Mobile Menu Button ve Logo Container -->
            <div class="lg:hidden flex items-center justify-between w-full">
                <!-- Mobil Logo Container - Önce yazı.png görünür -->
                <div class="relative w-40 h-12 perspective logo-container">
                    <div class="absolute w-full h-full transition-all duration-500 transform backface-hidden logo-front">
                        <div class="h-full flex items-center justify-center">
                            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/yazi.png"
                                 alt="Pumada Group"
                                 class="h-6 w-auto object-contain">
                        </div>
                    </div>
                    <div class="absolute w-full h-full transition-all duration-500 transform backface-hidden rotate-y-180 logo-back">
                        <div class="h-full flex items-center justify-center">
                            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo_pumada.png"
                                 alt="Pumada Group"
                                 class="h-8 w-auto object-contain">
                        </div>
                    </div>
                </div>

                <!-- Menü Butonu -->
                <button 
                    onclick="toggleMobileMenu()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#da963e] focus:outline-none transition-colors duration-300"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Desktop Logo - Önce logo_pumada.png görünür -->
            <a href="<?php echo $ayarlar["strURL"]; ?>" class="hidden lg:block w-48 md:w-56 h-16 md:h-20">
                <div class="relative w-full h-full perspective logo-container">
                    <div class="absolute w-full h-full transition-all duration-500 transform backface-hidden logo-front">
                        <div class="h-full flex items-center justify-center">
                            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo_pumada.png"
                                 alt="Pumada Group"
                                 class="h-21 md:h-24 w-auto object-contain">
                        </div>
                    </div>
                    <div class="absolute w-full h-full transition-all duration-500 transform backface-hidden rotate-y-180 logo-back">
                        <div class="h-full flex items-center justify-center">
                            <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/yazi.png"
                                 alt="Pumada Group"
                                 class="h-10 md:h-12 w-auto object-contain">
                        </div>
                    </div>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex flex-1 justify-center">
                <ul class="flex items-center space-x-8">
                    <!-- Ana Menü -->
                    <li class="relative group">
                        <a href="<?php echo $ayarlar["strURL"]; ?>"
                            class="relative text-white py-8 px-3 inline-flex items-center hover:text-[#da963e] transition-colors duration-300">
                            <span>Anasayfa</span>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </li>

                    <!-- Kurumsal Dropdown - Otomatik açılır -->
                    <li class="relative group/kurumsal">
                        <button
                            class="text-white py-8 px-3 inline-flex items-center hover:text-[#da963e] transition-colors duration-300">
                            <span>Kurumsal</span>
                            <svg class="w-4 h-4 ml-1 transform transition-transform duration-300 group-hover/kurumsal:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover/kurumsal:scale-x-100 transition-transform duration-300"></span>
                        </button>

                        <!-- Dropdown içeriği -->
                        <div class="absolute left-0 mt-0 w-56 opacity-0 invisible group-hover/kurumsal:opacity-100 group-hover/kurumsal:visible transition-all duration-200">
                            <div class="pt-2">
                                <div class="bg-[#f5f5f5] rounded-lg shadow-lg border-t-2 border-[#da963e] py-2">
                                    <?php
                                    $veri_cek = $db->query("SELECT * FROM kurumsal WHERE haber_durum = 1 AND dil_id = '$lang' ORDER BY haber_ust_id ASC LIMIT 6");
                                    if ($veri_cek->rowCount()) {
                                        foreach ($veri_cek as $veri_listele) {
                                    ?>
                                            <a href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $veri_listele["haber_seo"]; ?>"
                                                class="block px-4 py-2 text-[#040404] hover:bg-[#da963e]/10 hover:text-[#da963e] transition-colors duration-300">
                                                <?php echo $veri_listele["haber_baslik"]; ?>
                                            </a>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Hizmetlerimiz Dropdown -->
                    <li class="relative group">
                        <button
                            class="text-white py-8 px-3 inline-flex items-center group-hover:text-[#da963e] transition-colors duration-300">
                            <span>Hizmetlerimiz</span>
                            <svg class="w-4 h-4 ml-1 transform transition-transform duration-300 group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </button>

                        <div class="absolute left-0 mt-0 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="pt-2">
                                <div class="bg-[#f5f5f5] rounded-lg shadow-lg border-t-2 border-[#da963e] py-2">
                                    <?php
                                    $veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1 AND dil_id = '$lang' ORDER BY haber_ust_id ASC LIMIT 8");
                                    if ($veri_cek->rowCount()) {
                                        foreach ($veri_cek as $veri_listele) {
                                    ?>
                                            <a href="<?php echo $ayarlar["strURL"]; ?>/hizmetler/<?php echo $veri_listele["haber_seo"]; ?>"
                                                class="block px-4 py-2 text-[#040404] hover:bg-[#da963e]/10 hover:text-[#da963e] transition-colors duration-300">
                                                <?php echo $veri_listele["haber_baslik"]; ?>
                                            </a>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Diğer Menü Öğeleri -->
                    <li class="relative group">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/projeler"
                            class="relative text-white py-8 px-3 inline-flex items-center group-hover:text-[#da963e] transition-colors duration-300 font-medium">
                            <span>Projeler</span>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/referanslar"
                            class="relative text-white py-8 px-3 inline-flex items-center group-hover:text-[#da963e] transition-colors duration-300 font-medium">
                            <span>Referanslar</span>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="<?php echo $ayarlar["strURL"]; ?>/iletisim"
                            class="relative text-white py-8 px-3 inline-flex items-center group-hover:text-[#da963e] transition-colors duration-300 font-medium">
                            <span>İletişim</span>
                            <span class="absolute bottom-6 left-0 w-full h-0.5 bg-[#da963e] transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Right Section -->
            <div class="hidden lg:flex items-center space-x-6">
                <!-- Phone -->
                <div class="text-white">
                    <p class="text-xs text-[#da963e]">Telefon</p>
                    <a href="tel:+38268622732"
                        class="text-base font-medium hover:text-[#da963e] transition-colors duration-300">
                        +382 68 622 732
                    </a>
                </div>

                <!-- Language Selector -->
                <div class="relative">
                    <?php $diller = getDilListesi();
                    if (count($diller)):
                        $current_lang = getCurrentDil();
                    ?>
                        <button type="button"
                            id="langButton"
                            class="flex items-center space-x-2 bg-secondary hover:bg-primary text-white px-4 py-2 rounded-md transition-colors duration-300">
                            <?php foreach ($diller as $dil):
                                if ($dil['dil_kod'] == $current_lang): ?>
                                    <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
                                    <span class="font-medium"><?php echo $dil['dil_baslik']; ?></span>
                            <?php endif;
                            endforeach; ?>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="langDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-secondary rounded-md shadow-lg z-50">
                            <?php foreach ($diller as $dil): ?>
                                <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                                    class="flex items-center space-x-2 px-4 py-2 text-white hover:bg-primary hover:text-white transition-colors duration-200">
                                    <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?>"></span>
                                    <span><?php echo $dil['dil_baslik']; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay"
        class="lg:hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-40 hidden"
        onclick="toggleMobileMenu(false)">
    </div>

    <!-- Mobile Menu Panel -->
    <div id="mobileMenuPanel"
        class="lg:hidden fixed top-0 right-0 w-[300px] h-full bg-[#040404] z-50 transform translate-x-full transition-transform duration-300 ease-in-out">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-white/10">
            <div class="flex items-center space-x-4">
                <!-- Logo Pumada -->
                <img src="<?php echo $ayarlar["strURL"]; ?>/assets/img/logo/logo_pumada.png"
                    alt="Pumada Group"
                    class="h-10 w-auto">

          
               
            </div>

            <button onclick="toggleMobileMenu(false)"
                class="p-2 text-white hover:text-[#da963e] transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Menu Content -->
        <div class="h-[calc(100%-64px)] flex flex-col">
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-2 space-y-1">
                    <!-- Ana Menü -->
                    <a href="<?php echo $ayarlar["strURL"]; ?>"
                        class="group flex items-center px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                        <span class="flex-1">Anasayfa</span>
                        <svg class="w-5 h-5 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <!-- Kurumsal Menu -->
                    <div class="menu-item" data-menu="kurumsal">
                        <button onclick="toggleMobileSubmenu('kurumsal')"
                            class="w-full group flex items-center justify-between px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                            <span>Kurumsal</span>
                            <svg class="menu-icon w-5 h-5 text-white/30 group-hover:text-[#da963e] transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu hidden pl-4 pr-2 overflow-hidden transition-all duration-300">
                            <?php
                            $veri_cek = $db->query("SELECT * FROM kurumsal WHERE haber_durum = 1 AND dil_id = '$lang' ORDER BY haber_ust_id ASC LIMIT 6");
                            if ($veri_cek->rowCount()) {
                                foreach ($veri_cek as $veri_listele) {
                            ?>
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/kurumsal/<?php echo $veri_listele["haber_seo"]; ?>"
                                        class="group flex items-center px-4 py-2 text-sm text-white/70 hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                                        <span class="flex-1"><?php echo $veri_listele["haber_baslik"]; ?></span>
                                        <svg class="w-4 h-4 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                    </div>

                    <!-- Hizmetlerimiz Menu -->
                    <div class="menu-item" data-menu="hizmetler">
                        <button onclick="toggleMobileSubmenu('hizmetler')"
                            class="w-full group flex items-center justify-between px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                            <span>Hizmetlerimiz</span>
                            <svg class="menu-icon w-5 h-5 text-white/30 group-hover:text-[#da963e] transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu hidden pl-4 pr-2 overflow-hidden transition-all duration-300">
                            <?php
                            $veri_cek = $db->query("SELECT * FROM hizmetler WHERE haber_durum = 1 AND dil_id = '$lang' ORDER BY haber_ust_id ASC LIMIT 8");
                            if ($veri_cek->rowCount()) {
                                foreach ($veri_cek as $veri_listele) {
                            ?>
                                    <a href="<?php echo $ayarlar["strURL"]; ?>/hizmet/<?php echo $veri_listele["haber_seo"]; ?>"
                                        class="group flex items-center px-4 py-2 text-sm text-white/70 hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                                        <span class="flex-1"><?php echo $veri_listele["haber_baslik"]; ?></span>
                                        <svg class="w-4 h-4 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                    </div>

                    <!-- Diğer Menü Öğeleri -->
                    <a href="<?php echo $ayarlar["strURL"]; ?>/projeler"
                        class="group flex items-center px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                        <span class="flex-1">Projeler</span>
                        <svg class="w-5 h-5 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="<?php echo $ayarlar["strURL"]; ?>/referanslar"
                        class="group flex items-center px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                        <span class="flex-1">Referanslar</span>
                        <svg class="w-5 h-5 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="<?php echo $ayarlar["strURL"]; ?>/iletisim"
                        class="group flex items-center px-4 py-3 text-base text-white hover:text-[#da963e] hover:bg-white/5 rounded-lg transition-all">
                        <span class="flex-1">İletişim</span>
                        <svg class="w-5 h-5 text-white/30 group-hover:text-[#da963e] transform group-hover:translate-x-1 transition-all"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-white/10">
                <!-- Dil Seçici -->
                <div class="mb-4">
                    <p class="text-sm text-[#da963e] mb-2">Dil Seçimi</p>
                    <div class="relative">
                        <button type="button"
                            onclick="toggleMobileLangDropdown()"
                            class="flex items-center justify-between w-full bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg transition-all">
                            <?php foreach ($diller as $dil):
                                if ($dil['dil_kod'] == $current_lang): ?>
                                    <div class="flex items-center space-x-2">
                                        <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?>"></span>
                                        <span><?php echo $dil['dil_baslik']; ?></span>
                                    </div>
                            <?php endif;
                            endforeach; ?>
                            <svg class="w-5 h-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="mobileLangDropdown"
                            class="hidden absolute bottom-full left-0 right-0 mb-1 bg-white/10 backdrop-blur-sm rounded-lg overflow-hidden">
                            <?php foreach ($diller as $dil): ?>
                                <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                                    class="flex items-center space-x-2 px-4 py-2 text-white hover:bg-white/10 transition-all">
                                    <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?>"></span>
                                    <span><?php echo $dil['dil_baslik']; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- İletişim -->
                <div class="flex items-center space-x-3 text-white">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#da963e]/10">
                        <svg class="w-5 h-5 text-[#da963e]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-[#da963e]">Bizi Arayın</p>
                        <a href="tel:+38268622732" class="text-lg font-medium hover:text-[#da963e] transition-colors">
                            +382 68 622 732
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Mobil menü yönetimi
    function toggleMobileMenu(show) {
        const overlay = document.getElementById('mobileMenuOverlay');
        const panel = document.getElementById('mobileMenuPanel');
        const body = document.body;

        if (show === undefined) {
            show = panel.classList.contains('translate-x-full');
        }

        if (show) {
            overlay.classList.remove('hidden');
            panel.classList.remove('translate-x-full');
            body.style.overflow = 'hidden';
            setTimeout(() => {
                overlay.classList.add('opacity-100');
            }, 10);
        } else {
            overlay.classList.remove('opacity-100');
            panel.classList.add('translate-x-full');
            body.style.overflow = '';
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }
    }

    // Alt menü yönetimi
    function toggleMobileSubmenu(menuId) {
        const menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(item => {
            const isCurrentMenu = item.dataset.menu === menuId;
            const submenu = item.querySelector('.submenu');
            const icon = item.querySelector('.menu-icon');

            if (isCurrentMenu) {
                const isHidden = submenu.classList.contains('hidden');
                submenu.classList.toggle('hidden');
                icon.style.transform = isHidden ? 'rotate(180deg)' : '';
            } else {
                submenu.classList.add('hidden');
                item.querySelector('.menu-icon').style.transform = '';
            }
        });
    }

    // Dil seçici yönetimi
    function toggleMobileLangDropdown() {
        const dropdown = document.getElementById('mobileLangDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Sayfa dışı tıklamalarda dropdown'ları kapat
    document.addEventListener('click', function(event) {
        const langDropdown = document.getElementById('mobileLangDropdown');
        const langButton = event.target.closest('button');

        if (langDropdown && !langButton && !langDropdown.contains(event.target)) {
            langDropdown.classList.add('hidden');
        }
    });
</script>

<style>
    :root {
        --color-primary: #da963e;
        --color-secondary: #040404;
    }

    .text-primary {
        color: var(--color-primary);
    }

    .bg-primary {
        background-color: var(--color-primary);
    }

    .hover\:text-primary:hover {
        color: var(--color-primary);
    }

    .hover\:bg-primary:hover {
        background-color: var(--color-primary);
    }

    .perspective {
        perspective: 1000px;
    }

    .backface-hidden {
        backface-visibility: hidden;
    }

    .rotate-y-180 {
        transform: rotateY(180deg);
    }

    /* Logo hover animasyonu için özel stiller */
    .logo-container:hover .logo-front {
        transform: rotateY(180deg);
    }

    .logo-container:hover .logo-back {
        transform: rotateY(0);
    }

    /* Flag Icons için gerekli stil */
    .fi {
        width: 1.2em;
        height: 1.2em;
        display: inline-block;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>