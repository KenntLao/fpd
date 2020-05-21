<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('user-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// USER NAME
		$uname = '';
		if(isset($_POST['uname'])) {
			$uname = strtolower(trim($_POST['uname']));
			if(strlen($uname) == 0) {
				$err++;
				$_SESSION['sys_users_add_uname_err'] = renderLang($users_uname_required);
			} else {
				
				$_SESSION['sys_users_add_uname_val'] = $uname;
				
				// check if user name already exists
				$sql = $pdo->prepare("SELECT uname, temp_del FROM users WHERE uname = :uname AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":uname",$uname);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_users_add_uname_err'] = renderLang($users_uname_exists);
				}
			}
		}
		
		// FIRSTNAME
		$firstname = '';
		if(isset($_POST['firstname'])) {
			$firstname = ucwords(strtolower(trim($_POST['firstname'])));
			$_SESSION['sys_users_add_firstname_val'] = $firstname;
			if(strlen($firstname) == 0) {
				$err++;
				$_SESSION['sys_users_add_firstname_err'] = renderLang($users_firstname_required);
			}
		}
		
		// LASTNAME
		$lastname = '';
		if(isset($_POST['lastname'])) {
			$lastname = ucwords(strtolower(trim($_POST['lastname'])));
			$_SESSION['sys_users_add_lastname_val'] = $lastname;
			if(strlen($lastname) == 0) {
				$err++;
				$_SESSION['sys_users_add_lastname_err'] = renderLang($users_lastname_required);
			}
		}
		
		// ROLES
		$role_ids = ',';
		if(isset($_POST['role_ids'])) {
			$role_ids = trim($_POST['role_ids']);
			if(strlen($role_ids) == 0) {
				$err++;
				$_SESSION['sys_users_add_roles_err'] = renderLang($users_role_required);
			} else {
				$_SESSION['sys_users_add_roles_val'] = $role_ids;
			}
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			$upass = encryptStr($uname);
			$role_ids = ','.$role_ids.',';
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO users(
					id,
					uname,
					upass,
					firstname,
					lastname,
					role_ids
				) VALUES(
					NULL,
					:uname,
					:upass,
					:firstname,
					:lastname,
					:role_ids
				)");
			$sql->bindParam(":uname",$uname);
			$sql->bindParam(":upass",$upass);
			$sql->bindParam(":firstname",$firstname);
			$sql->bindParam(":lastname",$lastname);
			$sql->bindParam(":role_ids",$role_ids);
			$sql->execute();
			
			// get ID of new user
			$sql = $pdo->prepare("SELECT id, uname FROM users WHERE uname = :uname LIMIT 1");
			$sql->bindParam(":uname",$uname);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('user',$data['id'],'add','');

			$_SESSION['sys_users_suc'] = renderLang($users_user_added);
			header('location: /users');
			
		} else { // error found
			
			$_SESSION['sys_users_add_err'] = renderLang($form_error);
			header('location: /add-user');
			
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