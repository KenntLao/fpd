<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('employee-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM employees WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// EMPLOYEE ID
			$employee_id = '';
			if(isset($_POST['employee_id'])) {
				$employee_id = trim($_POST['employee_id']);
				if(strlen($employee_id) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_user_employee_id_err'] = renderLang($employees_employee_id_required);
				} else {
					
					$_SESSION['sys_employees_edit_employee_id_val'] = $employee_id;
					
					// check if user name already exists
					$sql = $pdo->prepare("SELECT employee_id FROM employees WHERE employee_id = :employee_id AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":employee_id",$employee_id);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_employees_edit_employee_id_err'] = renderLang($employees_employee_id_exists);
					}
				}
			}

			// DEPARTMENT ID
			$department_id = 0;
			if(isset($_POST['department_id'])) {
				$department_id = trim($_POST['department_id']);
				if(strlen($department_id) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_department_id_err'] = renderLang($employees_department_id_required);
				} else {

					$_SESSION['sys_employees_edit_department_id_val'] = $department_id;

					// check if department ID is valid (existing or not deleted)
					$sql = $pdo->prepare("SELECT id, temp_del FROM departments WHERE id = :department_id AND temp_del=0 LIMIT 1");
					$sql->bindParam(":department_id",$department_id);
					$sql->execute();
					if($sql->rowCount()) {} else {
						$err++;
						$_SESSION['sys_employees_edit_department_id_err'] = renderLang($employees_department_id_invalid);
					}
				}
			}
			
			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_employees_edit_status_val'] = $status;
				$status_exists = 0;
				foreach($status_arr as $status_data) {
					if($status_data[0] == $status_exists) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_employees_edit_status_err'] = 'Please select a valid status.';
				}
			}

			// FIRSTNAME
			$firstname = '';
			if(isset($_POST['firstname'])) {
				$firstname = trim($_POST['firstname']);
				$_SESSION['sys_employees_edit_firstname_val'] = $firstname;
				if(strlen($firstname) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_firstname_err'] = renderLang($employees_firstname_required);
				}
			}

			// MIDDLENAME
			$middlename = '';
			if(isset($_POST['middlename'])) {
				$middlename = trim($_POST['middlename']);
				$_SESSION['sys_employees_edit_middlename_val'] = $middlename;
			}
			
			// LASTNAME
			$lastname = '';
			if(isset($_POST['lastname'])) {
				$lastname = trim($_POST['lastname']);
				$_SESSION['sys_employees_edit_lastname_val'] = $lastname;
				if(strlen($lastname) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_lastname_err'] = renderLang($employees_lastname_required);
				}
			}

			// GENDER
			$gender = 0;
			if(isset($_POST['gender'])) {
				$gender = trim($_POST['gender']);
				$_SESSION['sys_employees_edit_gender_val'] = $gender;
				$gender_exists = 0;
				foreach($gender_arr as $gender_data) {
					if($gender_data[0] == $gender_exists) {
						$gender_exists = 1;
					}
				}
				if(!$gender_exists) {
					$err++;
					$_SESSION['sys_employees_edit_gender_err'] = renderLang($employees_select_valid_gender);
				}
            }
            
            // CODE NAME
            $code_name = '';
            if(isset($_POST['code_name'])) {
                $code_name = trim($_POST['code_name']);
                if(strlen($code_name) == 0) {
                    $err++;
                    $_SESSION['sys_employees_edit_code_name_err'] = renderLang($employees_code_name_required);
                } else {

                    // check if code name is valid
                    if($data['code_name'] != $code_name) {
                        $exist = getField('id', 'employees', 'code_name = "'.$code_name.'"');
                        
                        if($exist) {
                            $err++;
                            $_SESSION['sys_employees_edit_code_name_err'] = renderLang($employees_code_name_exist);
                        }
                    }

                    $_SESSION['sys_employees_edit_code_name_val'] = $code_name;

                }
            }

			// ROLES
			$role_ids = ',';
			if(isset($_POST['role_ids'])) {
				$role_ids = trim($_POST['role_ids']);
				if(strlen($role_ids) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_roles_err'] = renderLang($employees_role_required);
				} else {
					$_SESSION['sys_employees_edit_roles_val'] = $role_ids;
				}
			}

			// SUB PROPERTIES
			$sub_property_ids = ',';
			if(isset($_POST['sub_property_ids'])) {
				$sub_property_ids = trim($_POST['sub_property_ids']);
				if(strlen($sub_property_ids) == 0) {
					$err++;
					$_SESSION['sys_employees_edit_sub_property_ids_err'] = renderLang($employees_sub_property_required);
				} else {
					$_SESSION['sys_employees_edit_sub_property_ids_val'] = $sub_property_ids;
				}
			}

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors
				
				// get property ids from sub properties
				$sub_property_ids_arr = explode(',',$sub_property_ids);
				$where = '';
				foreach($sub_property_ids_arr as $sub_property_id) {
					if($where == '') {
						$where = ' WHERE id = '.$sub_property_id;
					} else {
						$where .= ' OR id = '.$sub_property_id;
					}
				}

				$property_ids = array();
				$sql = $pdo->prepare("SELECT id, property_id FROM sub_properties".$where);
				$sql->execute();
				while($_data = $sql->fetch(PDO::FETCH_ASSOC)) {
					if(!in_array($_data['property_id'],$property_ids)) {
						array_push($property_ids,$_data['property_id']);
					}
				}
				$property_ids = ','.implode($property_ids,',').',';

				$role_ids = ','.$role_ids.',';
				$sub_property_ids = ','.$sub_property_ids.',';

				// check for changes
				$change_logs = array();
				if($employee_id != $data['employee_id']) {
					$tmp = 'employees_employee_id::'.$data['employee_id'].'=='.$employee_id;
					array_push($change_logs,$tmp);
				}
				if($department_id != $data['department_id']) {
					$tmp = 'departments_department::'.$data['department_id'].'=='.$department_id;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'lang_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
				}
				if($firstname != $data['firstname']) {
					$tmp = 'employees_firstname::'.$data['firstname'].'=='.$firstname;
					array_push($change_logs,$tmp);
				}
				if($middlename != $data['middlename']) {
					$tmp = 'employees_middlename::'.$data['middlename'].'=='.$middlename;
					array_push($change_logs,$tmp);
				}
				if($lastname != $data['lastname']) {
					$tmp = 'employees_lastname::'.$data['lastname'].'=='.$lastname;
					array_push($change_logs,$tmp);
				}
				if($gender != $data['gender']) {
					$tmp = 'employees_gender::'.$data['gender'].'=='.$gender;
					array_push($change_logs,$tmp);
                }
                if($code_name != $data['code_name']) {
					$tmp = 'employees_code_name::'.$data['code_name'].'=='.$code_name;
					array_push($change_logs,$tmp);
                }
				if($role_ids != $data['role_ids']) {
					$tmp = 'roles_roles::'.$data['role_ids'].'=='.$role_ids;
					array_push($change_logs,$tmp);
				}
				if($sub_property_ids != $data['sub_property_ids']) {
					$tmp = 'properties_properties::'.$data['sub_property_ids'].'=='.$sub_property_ids;
					array_push($change_logs,$tmp);
				}
				
				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account employees table
					$sql = $pdo->prepare("UPDATE employees SET
						employee_id = :employee_id,
						firstname = :firstname,
						middlename = :middlename,
						lastname = :lastname,
						gender = :gender,
                        code_name = :code_name,
						role_ids = :role_ids,
						property_ids = :property_ids,
						sub_property_ids = :sub_property_ids,
						department_id = :department_id,
						status = :status
					WHERE id = :id");
					$sql->bindParam(":id",$id);
					$sql->bindParam(":employee_id",$employee_id);
					$sql->bindParam(":firstname",$firstname);
					$sql->bindParam(":middlename",$middlename);
					$sql->bindParam(":lastname",$lastname);
                    $sql->bindParam(":gender",$gender);
                    $sql->bindParam(":code_name",$code_name);
					$sql->bindParam(":role_ids",$role_ids);
					$sql->bindParam(":property_ids",$property_ids);
					$sql->bindParam(":sub_property_ids",$sub_property_ids);
					$sql->bindParam(":department_id",$department_id);
					$sql->bindParam(":status",$status);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('employee',$id,'update',$change_log);

					$_SESSION['sys_employees_edit_suc'] = renderLang($employees_employee_updated);

				} else { // no changes made

					$_SESSION['sys_employees_edit_err'] = renderLang($form_no_changes);

				}

			} else { // error found

				$_SESSION['sys_employees_edit_err'] = renderLang($form_error);

			}

		} else {

			$_SESSION['sys_employees_edit_err'] = renderLang($form_id_not_found);

		}

		header('location: /edit-employee/'.$id);
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>