<?php
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " [ERROR] $errstr in $errfile on line $errline\n";
    error_log($error_message, 3, __DIR__ . '/../logs/error.log');
    
    if (ini_get('display_errors')) {
        echo "<pre>$error_message</pre>";
    }
    
    return true;
}

set_error_handler("customErrorHandler");
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 