<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if employee has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('employee-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// EMPLOYEE ID
		$employee_id = '';
		if(isset($_POST['employee_id'])) {
			$employee_id = trim($_POST['employee_id']);
			if(strlen($employee_id) == 0) {
				$err++;
				$_SESSION['sys_employees_add_employee_id_err'] = renderLang($employees_employee_id_required);
			} else {
				
				$_SESSION['sys_employees_add_employee_id_val'] = $employee_id;
				
				// check if employee ID already exists
				$sql = $pdo->prepare("SELECT employee_id, temp_del FROM employees WHERE employee_id = :employee_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":employee_id",$employee_id);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_employees_add_employee_id_err'] = renderLang($employees_employee_id_exists);
				}
			}
		}
		
		// DEPARTMENT ID
		$department_id = 0;
		if(isset($_POST['department_id'])) {
			$department_id = trim($_POST['department_id']);
			if(strlen($department_id) == 0) {
				$err++;
				$_SESSION['sys_employees_add_department_id_err'] = renderLang($employees_department_id_required);
			} else {
				$_SESSION['sys_employees_add_department_id_val'] = $department_id;
			}
		}
		
		// FIRSTNAME
		$firstname = '';
		if(isset($_POST['firstname'])) {
			$firstname = trim($_POST['firstname']);
			$_SESSION['sys_employees_add_firstname_val'] = $firstname;
			if(strlen($firstname) == 0) {
				$err++;
				$_SESSION['sys_employees_add_firstname_err'] = renderLang($employees_firstname_required);
			}
		}
		
		// MIDDLENAME
		$middlename = '';
		if(isset($_POST['middlename'])) {
			$middlename = trim($_POST['middlename']);
			$_SESSION['sys_employees_add_middlename_val'] = $middlename;
		}
		
		// LASTNAME
		$lastname = '';
		if(isset($_POST['lastname'])) {
			$lastname = trim($_POST['lastname']);
			$_SESSION['sys_employees_add_lastname_val'] = $lastname;
			if(strlen($lastname) == 0) {
				$err++;
				$_SESSION['sys_employees_add_lastname_err'] = renderLang($employees_lastname_required);
			}
		}
		
		// GENDER
		$gender = 0;
		if(isset($_POST['gender'])) {
			$gender = trim($_POST['gender']);
			$_SESSION['sys_employees_add_gender_val'] = $gender;
			$gender_exists = 0;
			foreach($gender_arr as $gender_data) {
				if($gender_data[0] == $gender_exists) {
					$gender_exists = 1;
				}
			}
			if(!$gender_exists) {
				$err++;
				$_SESSION['sys_employees_add_gender_err'] = renderLang($employees_select_valid_gender);
			}
        }
        
        // CODE NAME
        $code_name = '';
        if(isset($_POST['code_name'])) {
            $code_name = trim($_POST['code_name']);
            if(strlen($code_name) == 0) {
                $err++;
                $_SESSION['sys_employees_add_code_name_err'] = renderLang($employees_code_name_required);
            } else {

                // check if code name is valid
                $exist = getField('id', 'employees', 'code_name = "'.$code_name.'"');
                
                if($exist) {
                    $err++;
                    $_SESSION['sys_employees_add_code_name_err'] = renderLang($employees_code_name_exist);
                } else {
                    $_SESSION['sys_employees_add_code_name_val'] = $code_name;
                }
            }
        }
		
		// ROLES
		$role_ids = ',';
		if(isset($_POST['role_ids'])) {
			$role_ids = trim($_POST['role_ids']);
			if(strlen($role_ids) == 0) {
				$err++;
				$_SESSION['sys_employees_add_roles_err'] = renderLang($employees_role_required);
			} else {
				$_SESSION['sys_employees_add_roles_val'] = $role_ids;
			}
		}
		
		// SUB PROPERTIES
		$sub_property_ids = ',';
		if(isset($_POST['sub_property_ids'])) {
			$sub_property_ids = trim($_POST['sub_property_ids']);
			if(strlen($sub_property_ids) == 0) {
				$err++;
				$_SESSION['sys_employees_add_sub_property_ids_err'] = renderLang($employees_sub_property_required);
			} else {
				$_SESSION['sys_employees_add_sub_property_ids_val'] = $sub_property_ids;
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
			while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
				if(!in_array($data['property_id'],$property_ids)) {
					array_push($property_ids,$data['property_id']);
				}
			}
			$property_ids = ','.implode($property_ids,',').',';
			
			$upass = encryptStr($employee_id);
			$role_ids = ','.$role_ids.',';
			$sub_property_ids = ','.$sub_property_ids.',';
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO employees(
					id,
					employee_id,
					upass,
					firstname,
					middlename,
					lastname,
					gender,
                    code_name,
					role_ids,
					department_id,
					property_ids,
					sub_property_ids
				) VALUES(
					NULL,
					:employee_id,
					:upass,
					:firstname,
					:middlename,
					:lastname,
					:gender,
                    :code_name,
					:role_ids,
					:department_id,
					:property_ids,
					:sub_property_ids
				)");
			$sql->bindParam(":employee_id",$employee_id);
			$sql->bindParam(":upass",$upass);
			$sql->bindParam(":firstname",$firstname);
			$sql->bindParam(":middlename",$middlename);
			$sql->bindParam(":lastname",$lastname);
            $sql->bindParam(":gender",$gender);
            $sql->bindParam(":code_name",$code_name);
			$sql->bindParam(":role_ids",$role_ids);
			$sql->bindParam(":department_id",$department_id);
			$sql->bindParam(":property_ids",$property_ids);
			$sql->bindParam(":sub_property_ids",$sub_property_ids);
			$sql->execute();
			
			// get ID of new employee
			$sql = $pdo->prepare("SELECT id, employee_id FROM employees WHERE employee_id = :employee_id LIMIT 1");
			$sql->bindParam(":employee_id",$employee_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('employee',$data['id'],'add','');

			$_SESSION['sys_employees_suc'] = renderLang($employees_employee_added);
			header('location: /employees');
			
		} else { // error found
			
			$_SESSION['sys_employees_add_err'] = renderLang($form_error);
			header('location: /add-employee');
			
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