<?php
// Log dizini için alternatif yol ekle
$alternative_log_dirs = array(
    dirname(__DIR__) . '/logs',
    '/tmp/pumada_logs',
    sys_get_temp_dir()
);

// Yazılabilir log dizinini bul
$log_dir = null;
foreach ($alternative_log_dirs as $dir) {
    if (!file_exists($dir)) {
        @mkdir($dir, 0777, true);
    }
    if (is_writable($dir)) {
        $log_dir = $dir;
        break;
    }
}

if (!$log_dir) {
    $log_dir = sys_get_temp_dir();
}

// Log dosyası yolu
$log_file = $log_dir . '/error.log';

// Log dosyası izinlerini ayarla
if (!file_exists($log_file)) {
    @touch($log_file);
    @chmod($log_file, 0666);
}

// Dizin ve dosya izinlerini kontrol et
if (!is_writable($log_dir) || (file_exists($log_file) && !is_writable($log_file))) {
    error_log("Log dizini veya dosyası yazılabilir değil: $log_dir");
    // Alternatif olarak PHP hata logunu kullan
    ini_set('error_log', 'syslog');
}

// Özel hata işleyici
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Hata mesajını oluştur
    $error_message = date('[Y-m-d H:i:s] ') . "Hata: [$errno] $errstr - $errfile:$errline\n";
    
    // Alternatif log konumları
    $log_locations = array(
        dirname(__DIR__) . '/logs/error.log',
        sys_get_temp_dir() . '/error.log',
        'php://stderr'
    );
    
    // Her bir log konumunu dene
    foreach ($log_locations as $log_file) {
        if (@error_log($error_message, 3, $log_file)) {
            break;
        }
    }
    
    return true;
}

// Hata işleyiciyi ayarla
set_error_handler("customErrorHandler");

// Hata raporlama ayarları
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Varsayılan error_log konumunu ayarla
foreach (array($log_file, sys_get_temp_dir() . '/error.log', 'php://stderr') as $log_path) {
    if (@is_writable($log_path) || @is_writable(dirname($log_path))) {
        ini_set('error_log', $log_path);
        break;
    }
} 