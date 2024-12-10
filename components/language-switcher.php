<div class="relative">
    <?php $diller = getDilListesi();
    if(count($diller)): 
        $current_lang = getCurrentDil();
    ?>
    <button type="button" 
            id="desktop-lang-button"
            class="flex items-center space-x-2 text-white hover:text-[#da963e] transition-all duration-300">
        <?php foreach($diller as $dil): 
            if($dil['dil_kod'] == $current_lang): ?>
            <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?> text-lg"></span>
            <span class="text-sm font-medium"><?php echo strtoupper($dil['dil_kod']); ?></span>
        <?php endif; endforeach; ?>
        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <div id="desktop-lang-dropdown" 
         class="hidden absolute right-0 mt-2 w-40 bg-[#221E1F] rounded-lg shadow-lg border border-white/10">
        <?php foreach($diller as $dil): ?>
        <a href="<?php echo $ayarlar["strURL"]; ?>/lang.php?l=<?php echo $dil['dil_kod']; ?>&return=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
           class="flex items-center space-x-2 px-4 py-2 text-sm text-white hover:bg-[#da963e]/10 hover:text-[#da963e] transition-all duration-200">
            <span class="flag-icon flag-icon-<?php echo getBayrakKodu($dil['dil_kod']); ?>"></span>
            <span><?php echo strtoupper($dil['dil_kod']); ?></span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div> 