<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-edit')) {

        $id = '';
        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
        }

        $sql = $pdo->prepare("DELETE FROM labor_cost_positions WHERE id = :id");
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