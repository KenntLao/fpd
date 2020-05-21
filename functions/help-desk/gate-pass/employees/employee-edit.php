<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('gate-pass-employee-edit')) {
	
		$err = 0;
		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM gate_pass_employees WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
		
		// PROCESS FORM



		// PROSPECT ID
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
		}

		// DEPARTMENT
		$person_department = '';
		if(isset($_POST['person_department'])) {
			$person_department = trim($_POST['person_department']);
			$_SESSION['sys_gate_pass_employees_edit_person_department_val'] = $person_department;
			
		}

		// EMPLOYEES NAME
		$employee_name = '';
		if(isset($_POST['employee_name'])) {
			$employee_name = trim($_POST['employee_name']);
			$_SESSION['sys_gate_pass_employees_edit_employee_name_val'] = $employee_name;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_gate_pass_employees_edit_purpose_val'] = $purpose;
			
		}

		// TIME OUT
		$time_out = '';
		if(isset($_POST['time_out'])) {
			$time_out = trim($_POST['time_out']);
			$_SESSION['sys_gate_pass_employees_edit_time_out_val'] = $time_out;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($prospect_id != $_data['prospect_id']) {
				$tmp = 'gate_pass_employees_project_name::'.$_data['prospect_id'].'=='.$prospect_id;
				array_push($change_logs, $tmp);
			}
			if ($person_department != $_data['person_department']) {
				$tmp = 'gate_pass_employees_person_department::'.$_data['person_department'].'=='.$person_department;
				array_push($change_logs, $tmp);
			}
			if ($employee_name != $_data['employee_name']) {
				$tmp = 'gate_pass_employees_employee_name::'.$_data['employee_name'].'=='.$employee_name;
				array_push($change_logs, $tmp);
			}
			if ($employee_name != $_data['employee_name']) {
				$tmp = 'gate_pass_employees_employee_name::'.$_data['employee_name'].'=='.$employee_name;
				array_push($change_logs, $tmp);
			}
			if ($purpose != $_data['purpose']) {
				$tmp = 'gate_pass_employees_purpose::'.$_data['purpose'].'=='.$purpose;
				array_push($change_logs, $tmp);
			}
			if ($time_out != $_data['time_out']) {
				$tmp = 'gate_pass_employees_time_out::'.$_data['time_out'].'=='.$time_out;
				array_push($change_logs, $tmp);
			}

			if (count($change_logs) > 0) {
      
				$sql = $pdo->prepare("UPDATE gate_pass_employees SET
					prospect_id = :prospect_id,
					person_department = :person_department,
					employee_name = :employee_name,
					purpose = :purpose,
					time_out = :time_out
				WHERE id = ".$id);
				$sql->bindParam(":prospect_id", $prospect_id);
				$sql->bindParam(":person_department", $person_department);
				$sql->bindParam(":employee_name", $employee_name);
				$sql->bindParam(":purpose", $purpose);
				$sql->bindParam(":time_out", $time_out);
				$sql->execute();

			}
			
			// record to system log
			$change_log = implode(';;',$change_logs);
			systemLog('gate_pass_employee',$id,'update',$change_log);

			//notification update GATE PASS EMPLOYEE
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('gate-pass-employee', $id, $employee['id'], 'employee', 'gate_pass_employee_updated');
				}
				foreach ($users as $user) {
					push_notification('gate-pass-employee', $id, $user['id'], 'user', 'gate_pass_employee_updated');
				}

			$_SESSION['sys_gate_pass_employees_edit_suc'] = renderLang($gate_pass_employees_updated);
			header('location: /gate-pass-employees');
			
		} else { // error found
			
			$_SESSION['sys_contract_add_err'] = renderLang($form_error);
			header('location: /edit-gate-pass-employee');
			
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