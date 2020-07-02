<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if form was submitted properly
if(isset($_POST['submit-login'])) {
	
	// toggle for valid credentials
	$valid_credentials = 0;
	
	// get form data
	$uname = '';
	$uname = trim($_POST['uname']);
	$upass = trim($_POST['upass']);
	
	// if username is not empty
	if(strlen($uname) > 0 && strlen($upass) > 0) {
	
		// set session for uname
		$_SESSION['sys_login_uname'] = $uname;
		
		// check users table first
		$user_upass = '';
		$sql = $pdo->prepare("SELECT * FROM users WHERE uname = :uname LIMIT 1");
		$sql->bindParam(":uname",$uname);
		$sql->execute();
		while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
			$user_upass = $data['upass'];
			$id = $data['id'];
			$_SESSION['sys_id'] = $data['id'];
			$_SESSION['sys_firstname'] = $data['firstname'];
			$_SESSION['sys_lastname'] = $data['lastname'];
			$_SESSION['sys_fullname'] = $data['firstname'].' '.$data['lastname'];
			$_SESSION['sys_photo'] = '/assets/images/profile/default.png';
			$_SESSION['sys_hris_photo'] = '../../assets/images/profile/default.png';
			$_SESSION['sys_role_ids'] = $data['role_ids'];
			$_SESSION['sys_language'] = $data['language'];
			$_SESSION['sys_data_per_page'] = $data['data_per_page'];
			$_SESSION['sys_account_mode'] = 'user';
			$status = $data['status'];
		}
		
		// check if password is valid from user data
		if($upass != '' && $user_upass != '') {
			
			if($upass == decryptStr($user_upass)) {

				// credential is valid
				$valid_credentials = 1;

			}

		}
		
		if(!$valid_credentials) { // else check in employees table
			
			$employee_upass = '';
			$sql = $pdo->prepare("SELECT * FROM hris_employees WHERE username = :emp_uname LIMIT 1");
			$sql->bindParam(":emp_uname",$uname);
			$sql->execute();
			while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
				$employee_upass = $data['password'];
				$id = $data['id'];
				$_SESSION['sys_id'] = $data['id'];
				$_SESSION['sys_firstname'] = $data['firstname'];
				$_SESSION['sys_lastname'] = $data['lastname'];
				$_SESSION['sys_fullname'] = $data['firstname'].' '.$data['lastname'];
				$_SESSION['sys_dep_id'] = $data['department_id'];
				if($data['employee_photo'] == '') {
					if($data['gender'] == 0) {
						$_SESSION['sys_photo'] = '/dist/img/avatar2.png';
					} else {
						$_SESSION['sys_photo'] = '/dist/img/avatar5.png';
					}
				} else {
					$_SESSION['sys_photo'] = 'hris/public/assets/images/employees/employee_photos/'.$data['employee_photo'];
					$_SESSION['sys_hris_photo'] =  'assets/images/employees/employee_photos/'.$data['employee_photo'];
				}
				$_SESSION['sys_role_ids'] = $data['role_id'];
				//$_SESSION['sys_department_id'] = $data['department_id'];
				//$_SESSION['sys_property_ids'] = explode($data['property_ids'],',');
				//$_SESSION['sys_language'] = $data['language'];
				//$_SESSION['sys_data_per_page'] = $data['data_per_page'];
				$_SESSION['sys_account_mode'] = 'employee';
				$status = $data['status'];
			}
			
			// check if password is valid from user data
			if($upass != '' && $employee_upass != '') {
				
				if($upass == password_verify($upass,$employee_upass)) {
					
					// credential is valid
					$valid_credentials = 1;
					
				}

			}

		}
		
		// check account status
		switch($status) {
			
			// ACTIVE
			case 0:
				
				// if credentials are valid, access system
				if($valid_credentials) {

					// check if remember me function is checked
					if(isset($_POST['remember_me'])) {
						// set cookie for .login type (username or email) and password
                        setcookie('sys_pms', $uname.'|'.$upass, time() + (86400 * 30), "/"); // set for 1 month
					} else {
                        unsetCookie('sys_pms'); // remove cookie if not checked
                    }
                    
                    setcookie('sys_logged', 'logged_in', time() + (86400 * 30), "/");

					// check if there is a role set (requires at least one role per account)
					if($_SESSION['sys_role_ids'] != ',') {

						// set role array session
						$_SESSION['sys_permissions'] = array();

						// all permission toggle
						$all_permission = 0;

						// create where clause for multiple roles
						$where = '';
						$role_ids_arr = explode(',',$_SESSION['sys_role_ids']);
						foreach($role_ids_arr as $role_id) {
							if($role_id != '') { // removes the beginning and end blanks from array
								if($where == '') {
									$where = ' WHERE id='.$role_id;
								} else {
									$where .= ' OR id='.$role_id;
								}
							}
						}
						
						// get permissions based on role_ids
						$sql = $pdo->prepare("SELECT id, permissions FROM roles".$where);
						$sql->bindParam(":employee_id",$uname);
						$sql->execute();
						while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
							if($data['permissions'] != 'all') {
								$permissions_arr_db = explode(',',$data['permissions']);
								$in_array = 0;
								foreach($permissions_arr_db as $permission) {
									if(!in_array($permission,$_SESSION['sys_permissions'])) {
										array_push($_SESSION['sys_permissions'],$permission);
									}
								}
							} else {
								$all_permission = 1;
							}
						}

						// get all permissions
						if($all_permission) {
							foreach($permissions_arr as $permissions_group) {
								foreach($permissions_group as $permission) {
									array_push($_SESSION['sys_permissions'],$permission['permission_code']);
								}
							}
						}

						// update last login time stamp
						$last_login = time();
						switch($_SESSION['sys_account_mode']) {
							case 'user':
								$sql = $pdo->prepare("UPDATE users SET last_login=".$last_login." WHERE id=".$id);
								break;
							case 'employee':
                                $sql = $pdo->prepare("UPDATE hris_employees SET last_login=".$last_login." WHERE id=".$id);
                                    // record to system log
                                    systemLog('login',$id,'login','');
								break;
						}
						$sql->execute();
						
						// check if employee and if timed in
					/*	if($_SESSION['sys_account_mode'] == 'employee') {
							
							// check if employee is already logged in
							$sql = $pdo->prepare("SELECT employee_id, time_in, time_out FROM time_logs WHERE employee_id = :employee_id AND time_out=0 LIMIT 1");
							$sql->bindParam(":employee_id",$id);
							$sql->execute();
							if($sql->rowCount()) {

								$data = $sql->fetch(PDO::FETCH_ASSOC);
								$_SESSION['sys_time_in'] = $data['time_in'];

							}
							
						}
					*/
						//SYSTEM LOGS
						$datetime = date('Y/m/d H:i:s');
						$user = $_SESSION['sys_login_uname'];
						$action = 'login';
						$sql = $pdo->prepare("INSERT INTO hris_system_logs(user,action,log_date_time) VALUES('". $user ."','". $action ."','". $datetime ."') ");
						$sql->bindParam(':user', $user);
						$sql->bindParam(':action', $action);
						$sql->bindParam(':log_date_time', $datetime);
						$sql->execute();


						// redirect to dashboard
                        header('location: /dashboard');
					} else { // else redirect to login page and display error details

						// !NEED TRANSLATION
						$_SESSION['sys_login_err'] = renderLang($login_msg_err_5); // "The account has no set role.<br>Please contact your web administrator."
						header('location: /');

					}

				} else { // else redirect to login page and display error details

					$_SESSION['sys_login_err'] = renderLang($login_msg_err_3); // "Invalid username or password."
					header('location: /');

				}
				
				break;

			// DEACTIVATED
			case 1:
				$_SESSION['sys_login_err'] = renderLang($login_msg_err_6); // "Account deactivated. Please contact your web administrator."
				header('location: /');
				break;
			
			// DELETED
			case 2:
				$_SESSION['sys_login_err'] = renderLang($login_msg_err_7); // "Account deleted. Please contact your web administrator."
				header('location: /');
				break;
				
		}
	
	} else { // else redirect to login page and display error details

		$_SESSION['sys_login_err'] = renderLang($login_msg_err_2); // "Please fill up the form properly."
		header('location: /');
		
	}
	
} else { // else redirect to login page and display error details
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_1); // "Please login properly."
	header('location: /');
	
}
?>