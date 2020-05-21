<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('unit-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		$unit_id = $_POST['id'];

		// TENANT ID
		$tenant_id = 0;
		if(isset($_POST['tenant_id'])) {
			$tenant_id = trim($_POST['tenant_id']);
		}


		// DATE FROM
		$date_from = '';
		if(isset($_POST['date_from'])) {
			$date_from = trim($_POST['date_from']);
			$date_from = strtotime($date_from);
		}

		// DATE TO
		$date_to = '';
		if(isset($_POST['date_to'])) {
			$date_to = trim($_POST['date_to']);
			$date_to = strtotime($date_to);
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			


			// inser to prf_departments
			$sql = $pdo->prepare("INSERT INTO unit_tenants (
				unit_id, 
				tenant_id, 
				date_from, 
				date_to
			) VALUES (
                :unit_id,
                :tenant_id, 
                :date_from, 
                :date_to
            )");
            $sql->bindParam(":unit_id", $unit_id);
            $sql->bindParam(":tenant_id", $tenant_id);
            $sql->bindParam(":date_from", $date_from);
            $sql->bindParam(":date_to", $date_to);
            $sql->execute();
            $id_no = $pdo->lastInsertId();

			// record to system log
			systemLog('unit_tenants',$id,'add','');

			$_SESSION['sys_unit_tenant_add_suc'] = renderLang($pfr_added);
			header('location: /unit/'.$id_no);
			
		} else { // error found
			
			$_SESSION['sys_unit_tenant_add_err'] = renderLang($form_error);
			header('location: /unit');
			
		}
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>