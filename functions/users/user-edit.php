<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('user-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID belongs to superadmin
		if($id != 1) {
		
			// check if ID exists
			$sql = $pdo->prepare("SELECT * FROM users WHERE id = ".$id." LIMIT 1");
			$sql->bindParam(":id",$id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			if($sql->rowCount()) {

				// PROCESS FORM

				// USER NAME
				$uname = '';
				if(isset($_POST['uname'])) {
					$uname = strtolower(trim($_POST['uname']));
					if(strlen($uname) == 0) {
						$err++;
						$_SESSION['sys_users_edit_user_uname_err'] = renderLang($users_uname_required);
					} else {
						
						$_SESSION['sys_users_edit_uname_val'] = $uname;
						
						// check if user name already exists
						$sql = $pdo->prepare("SELECT uname FROM users WHERE uname = :uname AND id <> ".$id." AND temp_del = 0 LIMIT 1");
						$sql->bindParam(":uname",$uname);
						$sql->execute();
						if($sql->rowCount()) {
							$err++;
							$_SESSION['sys_users_edit_uname_err'] = renderLang($users_uname_exists);
						}
					}
				}
				
				// STATUS
				$status = 0;
				if(isset($_POST['status'])) {
					$status = trim($_POST['status']);
					$_SESSION['sys_users_edit_status_val'] = $status;
					$status_exists = 0;
					foreach($status_arr as $status_data) {
						if($status_data[0] == $status_exists) {
							$status_exists = 1;
						}
					}
					if(!$status_exists) {
						$err++;
						$_SESSION['sys_users_edit_status_err'] = 'Please select a valid status.';
					}
				}

				// FIRSTNAME
				$firstname = '';
				if(isset($_POST['firstname'])) {
					$firstname = ucwords(strtolower(trim($_POST['firstname'])));
					$_SESSION['sys_users_edit_firstname_val'] = $firstname;
					if(strlen($firstname) == 0) {
						$err++;
						$_SESSION['sys_users_edit_firstname_err'] = renderLang($users_firstname_required);
					}
				}

				// LASTNAME
				$lastname = '';
				if(isset($_POST['lastname'])) {
					$lastname = ucwords(strtolower(trim($_POST['lastname'])));
					$_SESSION['sys_users_edit_lastname_val'] = $lastname;
					if(strlen($lastname) == 0) {
						$err++;
						$_SESSION['sys_users_edit_lastname_err'] = renderLang($users_lastname_required);
					}
				}

				// ROLES
				$role_ids = ',';
				if(isset($_POST['role_ids'])) {
					$role_ids = trim($_POST['role_ids']);
					if(strlen($role_ids) == 0) {
						$err++;
						$_SESSION['sys_users_edit_roles_err'] = renderLang($users_role_required);
					} else {
						$_SESSION['sys_users_edit_roles_val'] = $role_ids;
					}
				}

				// VALIDATE FOR ERRORS
				if($err == 0) { // there are no errors
					
					$roles = ','.$roles.',';

					// check for changes
					$change_logs = array();
					if($uname != $data['uname']) {
						$tmp = 'users_username::'.$data['uname'].'=='.$uname;
						array_push($change_logs,$tmp);
					}
					if($status != $data['status']) {
						echo $status.' '.$data['status'];
						$tmp = 'lang_status::'.$data['status'].'=='.$status;
						array_push($change_logs,$tmp);
					}
					if($firstname != $data['firstname']) {
						$tmp = 'users_firstname::'.$data['firstname'].'=='.$firstname;
						array_push($change_logs,$tmp);
					}
					if($lastname != $data['lastname']) {
						$tmp = 'users_lastname::'.$data['lastname'].'=='.$lastname;
						array_push($change_logs,$tmp);
					}
					if($role_ids != $data['role_ids']) {
						$tmp = 'roles_roles::'.$data['role_ids'].'=='.$role_ids;
						array_push($change_logs,$tmp);
					}

					// check if there is are changes made
					if(count($change_logs) > 0) {

						// update account language table
						$sql = $pdo->prepare("UPDATE users SET
							uname = :uname,
							status = :status,
							firstname = :firstname,
							lastname = :lastname,
							role_ids = :role_ids
						WHERE id = ".$id);
						$sql->bindParam(":uname",$uname);
						$sql->bindParam(":status",$status);
						$sql->bindParam(":firstname",$firstname);
						$sql->bindParam(":lastname",$lastname);
						$sql->bindParam(":role_ids",$role_ids);
						$sql->execute();

						// record to system log
						$change_log = implode(';;',$change_logs);
						systemLog('user',$id,'update',$change_log);

						$_SESSION['sys_users_edit_suc'] = renderLang($users_user_updated);

					} else { // no changes made

						$_SESSION['sys_users_edit_err'] = renderLang($form_no_changes);

					}

				} else { // error found

					$_SESSION['sys_users_edit_err'] = renderLang($form_error);

				}

			} else {

				$_SESSION['sys_users_edit_err'] = renderLang($form_id_not_found);

			}
			
			header('location: /edit-user/'.$id);
			
		} else {
			
			// !NEED TRANSLATION
			$_SESSION['sys_users_err'] = renderLang($users_messages_cannot_edit_superadmin);
			header('location: /users');
			
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