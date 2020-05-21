<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if tenant has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('unit-owner-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// UNIT OWNER ID
		$unit_owner_id = '';
		if(isset($_POST['unit_owner_id'])) {
			$unit_owner_id = strtolower(trim($_POST['unit_owner_id']));
			if(strlen($unit_owner_id) == 0) {
				$err++;
				$_SESSION['sys_unit_owners_add_unit_owner_id_err'] = renderLang($unit_owners_unit_owner_id_required);
			} else {
				
				$_SESSION['sys_unit_owners_add_unit_owner_id_val'] = $unit_owner_id;
				
				// check if tenant ID already exists
				// $sql = $pdo->prepare("SELECT unit_owner_id, temp_del FROM unit_owners WHERE unit_owner_id = :unit_owner_id AND temp_del = 0 LIMIT 1");
				// $sql->bindParam(":unit_owner_id",$unit_owner_id);
				// $sql->execute();
				// if($sql->rowCount()) {
				// 	$err++;
				// 	$_SESSION['sys_unit_owners_add_unit_owner_id_err'] = renderLang($unit_owners_unit_owner_id_exists);
				// }
			}
		}
		
		// FIRSTNAME
		$firstname = '';
		if(isset($_POST['firstname'])) {
			$firstname = trim($_POST['firstname']);
			$_SESSION['sys_unit_owners_add_firstname_val'] = $firstname;
			if(strlen($firstname) == 0) {
				$err++;
				$_SESSION['sys_unit_owners_add_firstname_err'] = renderLang($unit_owners_firstname_required);
			}
		}
		
		// MIDDLENAME
		$middlename = '';
		if(isset($_POST['middlename'])) {
			$middlename = trim($_POST['middlename']);
			$_SESSION['sys_unit_owners_add_middlename_val'] = $middlename;
		}
		
		// LASTNAME
		$lastname = '';
		if(isset($_POST['lastname'])) {
			$lastname = trim($_POST['lastname']);
			$_SESSION['sys_unit_owners_add_lastname_val'] = $lastname;
			if(strlen($lastname) == 0) {
				$err++;
				$_SESSION['sys_unit_owners_add_lastname_err'] = renderLang($unit_owners_lastname_required);
			}
		}
		
		// GENDER
		$gender = 0;
		if(isset($_POST['gender'])) {
			$gender = trim($_POST['gender']);
			$_SESSION['sys_unit_owners_add_gender_val'] = $gender;
			$gender_exists = 0;
			foreach($gender_arr as $gender_data) {
				if($gender_data[0] == $gender_exists) {
					$gender_exists = 1;
				}
			}
			if(!$gender_exists) {
				$err++;
				$_SESSION['sys_unit_owners_add_gender_err'] = renderLang($unit_owners_select_valid_gender);
			}
		}
		
		// CIVIL STATUS
		$civil_status = 0;
		if(isset($_POST['civil_status'])) {
			$civil_status = trim($_POST['civil_status']);
			$_SESSION['sys_unit_owners_add_civil_status_val'] = $civil_status;
			$civil_status_exists = 0;
			foreach($civil_status_arr as $civil_status_data) {
				if($civil_status_data[0] == $civil_status_exists) {
					$civil_status_exists = 1;
				}
			}
			if(!$civil_status_exists) {
				$err++;
				$_SESSION['sys_unit_owners_add_civil_status_err'] = renderLang($unit_owners_select_valid_civil_status);
			}
		}

		// BIRTHDATE
		$birthdate = '';
		if(isset($_POST['birthdate'])) {
			$birthdate = trim($_POST['birthdate']);
			$_SESSION['sys_unit_owners_add_birthdate_val'] = $birthdate;
			if(strlen($birthdate) == 0) {
				$err++;
				$_SESSION['sys_unit_owners_add_birthdate_err'] = renderLang($unit_owners_birthdate_required);
			}
		}
		// CITIZENSHIP
		$citizenship_id = '';
		if(isset($_POST['citizenship_id'])) {
			$citizenship_id = trim($_POST['citizenship_id']);
			$_SESSION['sys_unit_owners_add_citizenship_id_val'] = $citizenship_id;
        }
        
        // PARKING
        $parking = '';
        if(isset($_POST['parking'])) {
            $parking = trim($_POST['parking']);
            $_SESSION['sys_unit_owners_add_parking_val'] = $parking;
        }
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			$upass = encryptStr($unit_owner_id);
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO unit_owners(
					id,
					unit_owner_id,
					upass,
					firstname,
					middlename,
					lastname,
					gender,
					civil_status,
					birthdate,
					citizenship_id,
                    parking
				) VALUES(
					NULL,
					:unit_owner_id,
					:upass,
					:firstname,
					:middlename,
					:lastname,
					:gender,
					:civil_status,
					:birthdate,
					:citizenship_id,
                    :parking
				)");
			$sql->bindParam(":unit_owner_id",$unit_owner_id);
			$sql->bindParam(":upass",$upass);
			$sql->bindParam(":firstname",$firstname);
			$sql->bindParam(":middlename",$middlename);
			$sql->bindParam(":lastname",$lastname);
			$sql->bindParam(":gender",$gender);
			$sql->bindParam(":civil_status",$civil_status);
			$sql->bindParam(":birthdate",$birthdate);
            $sql->bindParam(":citizenship_id",$citizenship_id);
            $sql->bindParam(":parking", $parking);
			$sql->execute();
			
			// get ID of new tenant
			$sql = $pdo->prepare("SELECT id, unit_owner_id FROM unit_owners WHERE unit_owner_id = :unit_owner_id LIMIT 1");
			$sql->bindParam(":unit_owner_id",$unit_owner_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('unit_owner',$data['id'],'add','');

			$_SESSION['sys_unit_owners_suc'] = renderLang($unit_owners_unit_owner_added);
			header('location: /unit-owners');
			
		} else { // error found
			
			$_SESSION['sys_unit_owners_add_err'] = renderLang($form_error);
			header('location: /add-unit-owner');
			
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