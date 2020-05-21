<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err_code = 1;

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('role-delete')) {

		$err = 0;

		// PROCESS FORM
		$id = $_POST['id'];
		
		if($id != 1) {
			
			$user_id = $_SESSION['sys_id'];
			$upass = $_POST['upass'];

			// verify password
			$sql = $pdo->prepare("SELECT id, upass FROM users WHERE id = :user_id LIMIT 1");
			$sql->bindParam(":user_id",$user_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$upass_db = decryptStr($data['upass']);

			// check if passwords match
			if($upass_db == $upass) {

				$sql = $pdo->prepare("SELECT id FROM roles WHERE id = :id LIMIT 1");
				$sql->bindParam(":id",$id);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_ASSOC);

				// check if ID exists
				if($sql->rowCount()) {

					// delete role from roles table
					$epoch_time = time();
					$sql = $pdo->prepare("UPDATE roles SET temp_del = ".$epoch_time." WHERE id = :id LIMIT 1");
					$sql->bindParam(":id",$id);
					$sql->execute();

					// update roles in users table
					$sql = $pdo->prepare("SELECT id, roles FROM users WHERE roles LIKE '%,".$id.",%'");
					$sql->execute();
					while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

						// get current row ID
						$data_id = $data['id'];

						// update roles, remove role ID, replace with comma
						$roles = $data['roles'];
						$roles = str_replace(','.$id.',',',',$roles);

						// update this row
						$sql2 = $pdo->prepare("UPDATE users SET roles = '".$roles."' WHERE id = ".$data_id." LIMIT 1");
						$sql2->execute();

					}

					// update roles in employees table
					$sql = $pdo->prepare("SELECT id, roles FROM employees WHERE roles LIKE '%,".$id.",%'");
					$sql->execute();
					while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

						// get current row ID
						$data_id = $data['id'];

						// update roles, remove role ID, replace with comma
						$roles = $data['roles'];
						$roles = str_replace(','.$id.',',',',$roles);

						// update this row
						$sql2 = $pdo->prepare("UPDATE employees SET roles = '".$roles."' WHERE id = ".$data_id." LIMIT 1");
						$sql2->execute();

					}

					// record to system log
					systemLog('role',$id,'delete','');

					$err_code = 0;

				} else {

					$err_code = 4;

				}

			} else {

				$err_code = 2;

			}
			
		} else {

			$err_code = 4;
			
		}

	} else { // permission not found
		
		$err_code = 3;

	}
}

renderConfirmDelete($err_code,'sys_roles_suc','roles_messages_role_removed');
?>