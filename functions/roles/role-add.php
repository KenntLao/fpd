<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('role-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// ROLE NAME
		$role_name = '';
		if(isset($_POST['role_name'])) {
			$role_name = trim($_POST['role_name']);
			if(strlen($role_name) == 0) {
				$err++;
				$_SESSION['sys_roles_add_role_role_name_err'] = renderLang($roles_role_name_required);
			} else {

				$_SESSION['sys_roles_add_role_role_name_val'] = $role_name;

				// check if role name already exists
				$sql = $pdo->prepare("SELECT role_name FROM roles WHERE role_name = :role_name AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":role_name",$role_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_roles_add_role_role_name_err'] = renderLang($roles_role_name_exists);
				}
			}
		}
		
		// PERMISSIONS
		$permissions = '';
		if(isset($_POST['permissions'])) {
			$permissions = trim($_POST['permissions']);
			if(strlen($permissions) == 0) {
				$err++;
				$_SESSION['sys_roles_add_role_permissions_err'] = renderLang($roles_permission_required);
			} else {
				$_SESSION['sys_roles_add_role_permissions_val'] = $permissions;
			}
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			// cross check count of permissions
			$permissions_val_arr = explode(',',$permissions);
			if(count($permissions_val_arr) == $permissions_count) {
				$permissions = 'all';
			}
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO roles(
					id,
					role_name,
					permissions
				) VALUES(
					NULL,
					:role_name,
					:permissions
				)");
			$sql->bindParam(":role_name",$role_name);
			$sql->bindParam(":permissions",$permissions);
			$sql->execute();
			
			// get ID of new role
			$sql = $pdo->prepare("SELECT id, role_name FROM roles WHERE role_name = :role_name LIMIT 1");
			$sql->bindParam(":role_name",$role_name);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('role',$data['id'],'add','');

			$_SESSION['sys_roles_suc'] = renderLang($roles_role_added);
			header('location: /roles');
			
		} else { // error found
			
			$_SESSION['sys_roles_add_err'] = renderLang($form_error);
			header('location: /add-role');
			
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