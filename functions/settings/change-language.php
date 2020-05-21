<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// get data
	$account_id = $_SESSION['sys_id'];
	$language_id = $_GET['id'];
	$url = $_GET['url'];
	
	// get sql table based on account mode
	switch($_SESSION['sys_account_mode']) {
		case 'user': $sql_table = 'users'; break;
		case 'employee': $sql_table = 'employees'; break;
	}
	
	// update account language table
	$sql = $pdo->prepare("UPDATE ".$sql_table." SET
			language = :language
		WHERE id = :id");
	$sql->bindParam(":id",$account_id);
	$sql->bindParam(":language",$language_id);
	$sql->execute();
	
	$_SESSION['sys_language'] = $language_id;
	
	// set alert message depending on language selected
	$toast_msg = '';
	switch($language_id) {
		case 0: $toast_msg = ' Language set to English.'; break;
		case 1: $toast_msg = ' 言語が日本語に変更されました。'; break;
	}
	$_SESSION['sys_alert_toast_success'] = $toast_msg;
	
	header('location: '.$url);

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');

}
?>