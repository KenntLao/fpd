<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('occupant-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// UNIT ID
		$unit_id = '';
		if(isset($_POST['unit_id'])) {
			$unit_id = strtolower(trim($_POST['unit_id']));
			if(strlen($unit_id) == 0) {
				$err++;
				$_SESSION['sys_occupants_add_unit_id_err'] = renderLang($occupants_unit_id_required);
			} else {
				
				$_SESSION['sys_occupants_add_unit_id_val'] = $unit_id;
        
			}
		}
		
		// FIRSTNAME
		$firstname = '';
		if(isset($_POST['firstname'])) {
			$firstname = trim($_POST['firstname']);
			$_SESSION['sys_occupants_add_firstname_val'] = $firstname;
			if(strlen($firstname) == 0) {
				$err++;
				$_SESSION['sys_occupants_add_firstname_err'] = renderLang($occupants_firstname_required);
			}
		}
		
		// MIDDLENAME
		$middlename = '';
		if(isset($_POST['middlename'])) {
			$middlename = trim($_POST['middlename']);
			$_SESSION['sys_occupants_add_middlename_val'] = $middlename;
		}
		
		// LASTNAME
		$lastname = '';
		if(isset($_POST['lastname'])) {
			$lastname = trim($_POST['lastname']);
			$_SESSION['sys_occupants_add_lastname_val'] = $lastname;
			if(strlen($lastname) == 0) {
				$err++;
				$_SESSION['sys_occupants_add_lastname_err'] = renderLang($occupants_lastname_required);
			}
		}
		
		// GENDER
		$gender = 0;
		if(isset($_POST['gender'])) {
			$gender = trim($_POST['gender']);
			$_SESSION['sys_occupants_add_gender_val'] = $gender;
			$gender_exists = 0;
			foreach($gender_arr as $gender_data) {
				if($gender_data[0] == $gender) {
					$gender_exists = 1;
				}
			}
			if(!$gender_exists) {
				$err++;
				$_SESSION['sys_occupants_add_gender_err'] = renderLang($occupants_select_valid_gender);
			}
		}

		// BIRTHDATE
		$birthdate = '';
		if(isset($_POST['birthdate'])) {
			$birthdate = trim($_POST['birthdate']);
			$_SESSION['sys_occupants_add_birthdate_val'] = $birthdate;
			if(strlen($birthdate) == 0) {
				$err++;
				$_SESSION['sys_occupants_add_birthdate_err'] = renderLang($occupants_birthdate_required);
			}
		}
		
		// CIVIL STATUS
		$civil_status = 0;
		if(isset($_POST['civil_status'])) {
			$civil_status = trim($_POST['civil_status']);
			$_SESSION['sys_occupants_add_civil_status_val'] = $civil_status;
			$status_exists = 0;
			foreach($civil_status_arr as $status) {
				if($status[0] == $civil_status) {
					$status_exists = 1;
				}
			}
			if(!$status_exists) {
				$err++;
				$_SESSION['sys_occupants_add_civil_status_err'] = renderLang($occupants_select_valid_civil_status);
			}
		}

		// CITIZENSHIP ID
		$citizenship_id = 0;
		if(isset($_POST['citizenship_id'])) {
			$citizenship_id = trim($_POST['citizenship_id']);
			$_SESSION['sys_occupants_add_citizenship_id_val'] = $citizenship_id;
		}
		
		// RELATIONSHIP TO TENANT
		$relationship_to_tenant = 0;
		if(isset($_POST['relationship_to_tenant'])) {
			$relationship_to_tenant = trim($_POST['relationship_to_tenant']);
			$_SESSION['sys_occupants_add_relationship_to_tenant_val'] = $relationship_to_tenant;
		}

		// SOCIAL STATUS
		$social_status = 0;
		if(isset($_POST['social_status'])) {
			$social_status = trim($_POST['social_status']);
			$_SESSION['sys_occupants_add_social_status_val'] = $social_status;
		}

		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO occupants (
				firstname,
				middlename,
				lastname,
				gender,
				civil_status,
				birthdate,
				unit_id,
				citizenship_id,
				relationship_to_tenant,
				social_status
			) VALUES (
				:firstname,
				:middlename,
				:lastname,
				:gender,
				:civil_status,
				:birthdate,
				:unit_id,
				:citizenship_id,
				:relationship_to_tenant,
				:social_status
			)");
			$sql->bindParam(":firstname", $firstname);
			$sql->bindParam(":middlename", $middlename);
			$sql->bindParam(":lastname", $lastname);
			$sql->bindParam(":gender", $gender);
			$sql->bindParam(":civil_status", $civil_status);
			$sql->bindParam(":birthdate", $birthdate);
			$sql->bindParam(":unit_id", $unit_id);
			$sql->bindParam(":citizenship_id", $citizenship_id);
			$sql->bindParam(":relationship_to_tenant", $relationship_to_tenant);
			$sql->bindParam(":social_status", $social_status);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_occupants_suc'] = renderLang($occupants_occupant_added);
			header('location: /occupants');
			
		} else { // error found
			
			$_SESSION['sys_occupants_add_err'] = renderLang($form_error);
			header('location: /add-occupant');
			
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