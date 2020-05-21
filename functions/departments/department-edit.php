<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('department-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM departments WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// DEPARTMENT CODE
			$department_code = '';
			if(isset($_POST['department_code'])) {
				$department_code = strtoupper(trim($_POST['department_code']));
				if(strlen($department_code) == 0) {
					$err++;
					$_SESSION['sys_departments_edit_user_department_code_err'] = renderLang($departments_department_code_required);
				} else {
					// check if department code already exists
					$sql = $pdo->prepare("SELECT department_code FROM departments WHERE department_code = :department_code AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":department_code",$department_code);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_departments_edit_department_code_err'] = renderLang($departments_department_code_exists);
					} else {
						$_SESSION['sys_departments_edit_department_code_val'] = $department_code;
					}
				}
			}

			// DEPARTMENT NAME
			$department_name = '';
			if(isset($_POST['department_name'])) {
				$department_name = trim($_POST['department_name']);
				if(strlen($department_name) == 0) {
					$err++;
					$_SESSION['sys_departments_edit_user_department_name_err'] = renderLang($departments_department_name_required);
				} else {
					// check if department code already exists
					$sql = $pdo->prepare("SELECT department_name FROM departments WHERE department_name = :department_name AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":department_name",$department_name);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_departments_edit_department_name_err'] = renderLang($departments_department_name_exists);
					} else {
						$_SESSION['sys_departments_edit_department_name_val'] = $department_name;
					}
				}
			}

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($department_code != $data['department_code']) {
					$tmp = 'departments_department_code::'.$data['department_code'].'=='.$department_code;
					array_push($change_logs,$tmp);
				}
				if($department_name != $data['department_name']) {
					$tmp = 'departments_department_name::'.$data['department_name'].'=='.$department_name;
					array_push($change_logs,$tmp);
				}

				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account language table
					$sql = $pdo->prepare("UPDATE departments SET
						department_code = :department_code,
						department_name = :department_name
					WHERE id = ".$id);
					$sql->bindParam(":department_code",$department_code);
					$sql->bindParam(":department_name",$department_name);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('department',$id,'update',$change_log);

					$_SESSION['sys_departments_edit_suc'] = renderLang($departments_department_updated);

				} else { // no changes made

					$_SESSION['sys_departments_edit_err'] = renderLang($form_no_changes);

				}

			} else { // error found

				$_SESSION['sys_departments_edit_err'] = renderLang($form_error);

			}

		} else {

			$_SESSION['sys_departments_edit_err'] = renderLang($form_id_not_found);

		}

		header('location: /edit-department/'.$id);
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>