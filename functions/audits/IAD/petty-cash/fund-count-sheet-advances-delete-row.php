<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-edit')) {

        $id = $_POST['id'];

        $time = time();
        
        $sql = $pdo->prepare("UPDATE fund_count_sheet_unliquidated SET temp_del = :curr_time WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":curr_time", $time);
        $sql->execute();

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>