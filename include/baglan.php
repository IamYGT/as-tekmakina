<?php
	if(substr_count($_SERVER['PHP_SELF'], 'baglan.php'))
		exit();

	error_reporting(E_ALL);
	ini_set("log_errors", 0);
	ini_set("display_errors", 0);

	set_time_limit(0);
	ignore_user_abort(TRUE);

	#@ob_start("sanitize_output");
	@ob_start();
	@ob_implicit_flush();
	@session_start();

	if(substr_count($_SERVER['REQUEST_URI'], '.xml'))
		@header('Content-Type: text/xml; charset=utf-8');
	else
		@header('Content-Type: text/html; charset=utf-8');

	@date_default_timezone_set('Europe/Istanbul');

	define('ADMIN_DIRECTORY', 'admin');

	$dbname="astek_db";
	$dbuser="astek_db";
	$dbpass="Iyc$7s840";
	$host="localhost";

	try {
		$db = new PDO("mysql:host=".$host.";dbname=".$dbname.";charset=UTF8", $dbuser, $dbpass);
		$db->query("SET CHARACTER SET UTF8");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch ( PDOException $e ){
		 print $e->getMessage();
			echo
		   $error_message = date('Y-m-d G:i:s') . " [ERROR]: " . $e->getMessage() . "\n\r";
		   file_put_contents('PDOErrors.txt', $error_message, FILE_APPEND);
	}
