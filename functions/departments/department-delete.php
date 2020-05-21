<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err_code = 1;

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('department-delete')) {

		$err = 0;

		// PROCESS FORM
		$id = $_POST['id'];
		$user_id = $_SESSION['sys_id'];
		$upass = $_POST['upass'];
		
		// if user deleting item
		if ($_SESSION['sys_account_mode'] == 'user') {
		
			// verify password
			$sql = $pdo->prepare("SELECT id, upass FROM users WHERE id = :user_id LIMIT 1");
			$sql->bindParam(":user_id",$user_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$upass_db = decryptStr($data['upass']);
		}

		// if employee deleting item
		if ($_SESSION['sys_account_mode'] == 'employee') {

			// verify password
			$sql = $pdo->prepare("SELECT id, upass FROM employees WHERE id = :employee_id LIMIT 1");
			$sql->bindParam(":employee_id",$user_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$upass_db = decryptStr($data['upass']);
		}
		
		// check if passwords match
		if($upass_db == $upass) {
			
			$sql = $pdo->prepare("SELECT id FROM departments WHERE id = :id LIMIT 1");
			$sql->bindParam(":id",$id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// check if ID exists
			if($sql->rowCount()) {
				
				// delete department from departments table
				$epoch_time = time();
				$sql = $pdo->prepare("UPDATE departments SET status = 2, temp_del = ".$epoch_time." WHERE id = :id LIMIT 1");
				$sql->bindParam(":id",$id);
				$sql->execute();
				
				// update employees under the deleted department
				$sql = $pdo->prepare("UPDATE employees SET department_id = 0 WHERE department_id = :department_id");
				$sql->bindParam(":department_id",$id);
				$sql->execute();
				
				// record to system log
				systemLog('department',$id,'delete','');

				$err_code = 0;
				
			} else {
				
				$err_code = 4;
				
			}
			
		} else {
			
			$err_code = 2;
			
		}

	} else { // permission not found
		
		$err_code = 3;

	}
}

renderConfirmDelete($err_code,'sys_departments_suc','departments_messages_department_removed');
?>