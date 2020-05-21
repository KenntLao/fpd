<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-edit')) {

        $err = 0;

        $id = '';
        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
        }

        $curr_date = time();

        if($err == 0) {
            $sql = $pdo->prepare("UPDATE iad_audit_correctives_auditees SET 
                temp_del = :curr_date 
            WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->bindParam(":curr_date", $curr_date);
            $sql->execute();
            echo 'success';
        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		echo 'no-permission';

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	echo 'no-session';

}
?>