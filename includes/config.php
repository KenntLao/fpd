<?php
// start session
session_start();

// set default language
$default_lang_idx = 0; // English
if(isset($_SESSION['sys_language'])) {
	$default_lang_idx = $_SESSION['sys_language'];
}

// for encryption
$crypt_key = '4507';

// get actual link
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// DATABASE CONNECTION
$server = 'localhost'; $username = 'root'; $password = ''; $db = 'pms_db';
// $server = 'localhost'; $username = 'fpd_nexus_user'; $password = 'g9z(-_fdR98F'; $db = 'fpd_nexus_db';
$conn = 'mysql:host='.$server.';dbname='.$db.';charset=utf8';
try {
	$pdo = new PDO($conn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	echo $e->getMessage();
}

// COMMON INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');
require($_SERVER['DOCUMENT_ROOT'].'/includes/support/lang.php');
require($_SERVER['DOCUMENT_ROOT'].'/includes/support/permissions.php');

// SYSTEM DEFAULT SETTINGS
$sitename = array('FPD Nexus','');
$sitename = renderLang($sitename);
date_default_timezone_set('Asia/Manila');

$curr_time = date('H:i:s', time());

$sys_upload_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/';

$cache_dir = $_SERVER['DOCUMENT_ROOT'].'/caches/';

// configured base on id of department in database
$pod_dep_id = 1;
$hr_dep_id = 1;
$it_dep_id = 1;
$cad_dep_id = 1;

?>