<div class="relative">
    <?php $diller = getDilListesi();
    if(count($diller)): 
        $current_lang = getCurrentDil();
    ?>
    <button type="button" 
            onclick="toggleLanguageDropdown(event)"
            class="flex items-center space-x-2 bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md transition-colors duration-300">
        <?php foreach($diller as $dil): 
            if($dil['dil_kod'] == $current_lang): ?>
            <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?> mr-2"></span>
            <span class="font-medium"><?php echo $dil['dil_baslik']; ?></span>
        <?php endif; endforeach; ?>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    
    <div id="language-dropdown" 
         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 transform opacity-0 scale-95 transition-all duration-200">
        <?php foreach($diller as $dil): ?>
        <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
           class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-primary hover:text-white transition-colors duration-200">
            <span class="fi fi-<?php echo getBayrakKodu($dil['dil_kod']); ?>"></span>
            <span><?php echo $dil['dil_baslik']; ?></span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div> 