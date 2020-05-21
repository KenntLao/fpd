<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-TSA-edit')) {

        $id = '';

        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
        }

        if ($_POST['category'] == 'system-pictures') {
           
            $sql = $pdo->prepare("DELETE FROM pre_operation_audit_tsa_system_pictures WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();

        }
        if ($_POST['category'] == 'site-location') {

            $sql = $pdo->prepare("DELETE FROM pre_operation_audit_tsa_fire_safety_and_security_site_location WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            
        }
        if ($_POST['category'] == 'as-built-plans') {

            $sql = $pdo->prepare("DELETE FROM pre_operation_audit_tsa_as_built_plans WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            
        }
        if ($_POST['category'] == 'equipment-manuals') {

            $sql = $pdo->prepare("DELETE FROM pre_operation_audit_tsa_equipment_manuals WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            
        }


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