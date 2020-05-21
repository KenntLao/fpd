<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prospecting-activity')) {

        $id = $_POST['id'];

        // remove attachment
        $sql = $pdo->prepare("UPDATE prospecting_activities SET 
            activity_attachment = ''
        WHERE id = :id");
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