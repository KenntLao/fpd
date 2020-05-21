<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// get id of logged user
	$account_id = $_SESSION['sys_id'];

	// set error counter
	$err = 0;

	// get sql table based on account mode
	switch($_SESSION['sys_account_mode']) {
		case 'user': $sql_table = 'users'; break;
		case 'employee': $sql_table = 'employees'; break;
	}
	
	// get selected tab
	$_SESSION['sys_settings_tab_selected'] = $_POST['tab_selected'];
	
	// VALIDATE CURRENT PASSWORD
	$curr_password = trim($_POST['curr_password']);
	if(strlen($curr_password) == 0) {
		$err++;
		$_SESSION['sys_settings_change_password_curr_password'] = renderLang($settings_enter_current_password);
	} else {
		
		// get current password from database
		$sql = $pdo->prepare("SELECT id, upass FROM ".$sql_table." WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$account_id);
		$sql->execute();
		while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
			$upass = decryptStr($data['upass']);
		}
		
		// validate password entered for authentication
		if($curr_password != $upass) {
			$err++;
			$_SESSION['sys_settings_change_password_curr_password'] = renderLang($settings_invalid_password);
		}
		
	}
	
	// VALIDATE NEW PASSWORD
	$new_password = trim($_POST['new_password']);
	if(strlen($new_password) < 4) {
		$err++;
		$_SESSION['sys_settings_change_password_new_password'] = renderLang($settings_password_msg1);
	}
	
	// VALIDATE CONFIRM NEW PASSWORD
	$confirm_new_password = trim($_POST['confirm_new_password']);
	if(strlen($confirm_new_password) < 4) {
		$err++;
		$_SESSION['sys_settings_change_password_confirm_new_password'] = renderLang($settings_password_msg2);
	}
	
	// VALIDATE NEW AND CONFIRM PASSWORD
	if(strlen($new_password) >= 4 && strlen($confirm_new_password) >= 4) {
		if($new_password != $confirm_new_password) {
			$err++;
			$_SESSION['sys_settings_change_password_new_password'] = renderLang($settings_password_msg3);
			$_SESSION['sys_settings_change_password_confirm_new_password'] = renderLang($settings_password_msg3);
		}
	}
	
	// if there are no errors from the form entries
	if($err == 0) {
		
		$new_password = encryptStr($new_password);
		
		// update password
		$sql = $pdo->prepare("UPDATE ".$sql_table." SET
			upass = :upass
		WHERE id = :id");
		$sql->bindParam(":id",$account_id);
		$sql->bindParam(":upass",$new_password);
		$sql->execute();
		
		unset($_SESSION['sys_settings_change_password_curr_password']);
		unset($_SESSION['sys_settings_change_password_new_password']);
		unset($_SESSION['sys_settings_change_password_confirm_new_password']);
		$_SESSION['sys_settings_change_password_suc'] = renderLang($settings_password_change_success);
		
	} else {
		
		$_SESSION['sys_settings_change_password_err'] = renderLang($settings_form_error_msg);
		
	}
	
	header('location: /settings');
	
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');

}
?>