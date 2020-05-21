<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-edit')) {

        $id = $_POST['id'];
        $curr_date = time();

        $sql = $pdo->prepare("UPDATE count_sheet_collection_undeposited SET 
            temp_del = :curr_date 
        WHERE id = :id");
        $sql->bindParam(":curr_date", $curr_date);
        $sql->bindParam(":id", $id);
        $sql->execute();

        echo 'success';

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		echo 'invalid-permission';

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	echo 'no-session';

}
?>