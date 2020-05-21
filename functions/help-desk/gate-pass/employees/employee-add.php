<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('gate-pass-employee-add')) {
	
		$err = 0;
		
		// PROCESS FORM


		// PROSPECT ID
		$property_id = 0;
		if(isset($_POST['property_id'])) {
			$property_id = trim($_POST['property_id']);
		}

		// DEPARTMENT
		$person_department = '';
		if(isset($_POST['person_department'])) {
			$person_department = trim($_POST['person_department']);
			$_SESSION['sys_gate_pass_employees_add_person_department_val'] = $person_department;
			
		}

		// EMPLOYEES NAME
		$employee_name = '';
		if(isset($_POST['employee_name'])) {
			$employee_name = trim($_POST['employee_name']);
			$_SESSION['sys_gate_pass_employees_add_employee_name_val'] = $employee_name;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_gate_pass_employees_add_purpose_val'] = $purpose;
			
		}

		// TIME IN
		$time_in = '';
		if(isset($_POST['time_in'])) {
			$time_in = trim($_POST['time_in']);
			$_SESSION['sys_gate_pass_employees_add_time_in_val'] = $time_in;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$curr_date = formatDate(time(), true, false);
      
			$sql = $pdo->prepare("INSERT INTO gate_pass_employees (
				property_id,
				date,
				employee_name,
				purpose,
				time_in,
				person_department
			) VALUES (
				:property_id,
				:date,
				:employee_name,
				:purpose,
				:time_in,
				:person_department
				
			)");
			$sql->bindParam(":property_id", $property_id);
			$sql->bindParam(":date", $curr_date);
			$sql->bindParam(":employee_name", $employee_name);
			$sql->bindParam(":purpose", $purpose);
			$sql->bindParam(":time_in", $time_in);
			$sql->bindParam(":person_department", $person_department);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('gate_pass_employee',$id,'add','');

			// notifications
			$employees = getTable('employees');
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('gate-pass-employee', $id, $employee['id'], 'employee', 'gate_pass_employee_add');
			}
			foreach ($users as $user) {
				push_notification('gate-pass-employee', $id, $user['id'], 'user', 'gate_pass_employee_add');
			}

			$_SESSION['sys_gate_pass_employees_add_suc'] = renderLang($gate_pass_employees_employee_added);
			header('location: /gate-pass-employees');
			
		} else { // error found
			
			$_SESSION['sys_gate_pass_employees_add_err'] = renderLang($form_error);
			header('location: /add-gate-pass-employee/'.$id);
			
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