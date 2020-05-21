<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('department-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// DEPARTMENT CODE
		$department_code = '';
		if(isset($_POST['department_code'])) {
			$department_code = strtoupper(trim($_POST['department_code']));
			if(strlen($department_code) == 0) {
				$err++;
				$_SESSION['sys_departments_add_department_code_err'] = renderLang($departments_department_code_required);
			} else {
				
				$_SESSION['sys_departments_add_department_code_val'] = $department_code;
				
				// check if user name already exists
				$sql = $pdo->prepare("SELECT department_code, temp_del FROM departments WHERE department_code = :department_code AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":department_code",$department_code);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_departments_add_department_code_err'] = renderLang($departments_department_code_exists);
				}
			}
		}
		
		// DEPARTMENT NAME
		$department_name = '';
		if(isset($_POST['department_name'])) {
			$department_name = trim($_POST['department_name']);
			if(strlen($department_name) == 0) {
				$err++;
				$_SESSION['sys_departments_add_department_name_err'] = renderLang($departments_department_name_required);
			} else {
				
				$_SESSION['sys_departments_add_department_name_val'] = $department_name;
				
				// check if user name already exists
				$sql = $pdo->prepare("SELECT department_name, temp_del FROM departments WHERE department_name = :department_name AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":department_name",$department_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_departments_add_department_name_err'] = renderLang($departments_department_name_exists);
				}
			}
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			$upass = encryptStr($department_code);
			$roles = ','.$roles.',';
			
			// insert into departments table
			$sql = $pdo->prepare("INSERT INTO departments(
					id,
					department_code,
					department_name
				) VALUES(
					NULL,
					:department_code,
					:department_name
				)");
			$sql->bindParam(":department_code",$department_code);
			$sql->bindParam(":department_name",$department_name);
			$sql->execute();
			
			// get ID of new department
			$sql = $pdo->prepare("SELECT id, department_code FROM departments WHERE department_code = :department_code LIMIT 1");
			$sql->bindParam(":department_code",$department_code);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('department',$data['id'],'add','');

			$_SESSION['sys_departments_suc'] = renderLang($departments_department_added);
			header('location: /departments');
			
		} else { // error found
			
			$_SESSION['sys_departments_add_err'] = renderLang($form_error);
			header('location: /add-department');
			
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