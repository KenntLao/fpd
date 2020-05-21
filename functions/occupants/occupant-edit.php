<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('occupant-edit')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// OCCUPANT ID
		$id = trim($_POST['occupant_id']);
		$sql = $pdo->prepare("SELECT * FROM occupants WHERE id = :id LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {
			
			// UNIT ID
			$unit_id = '';
			if(isset($_POST['unit_id'])) {
				$unit_id = strtolower(trim($_POST['unit_id']));
				if(strlen($unit_id) == 0) {
					$err++;
					$_SESSION['sys_occupants_edit_unit_id_err'] = renderLang($occupants_unit_id_required);
				} else {
					$_SESSION['sys_occupants_edit_unit_id_val'] = $unit_id;
				}
			}
			
			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_occupants_edit_status_val'] = $status;
				$exist = 0;
				foreach($status_arr as $value) {
					if($value[0] == $status) {
						$exist = 1;
					}
				}
				if(!$exist) {
					$err++;
					$_SESSION['sys_occupants_edit_status_err'] = renderLang($lang_select_valid_status);
				}
			}
			
			// FIRSTNAME
			$firstname = '';
			if(isset($_POST['firstname'])) {
				$firstname = trim($_POST['firstname']);
				$_SESSION['sys_occupants_edit_firstname_val'] = $firstname;
				if(strlen($firstname) == 0) {
					$err++;
					$_SESSION['sys_occupants_edit_firstname_err'] = renderLang($occupants_firstname_required);
				}
			}
			
			// MIDDLENAME
			$middlename = '';
			if(isset($_POST['middlename'])) {
				$middlename = trim($_POST['middlename']);
				$_SESSION['sys_occupants_edit_middlename_val'] = $middlename;
			}
      
			// LASTNAME
			$lastname = '';
			if(isset($_POST['lastname'])) {
				$lastname = trim($_POST['lastname']);
				$_SESSION['sys_occupants_edit_lastname_val'] = $lastname;
				if(strlen($lastname) == 0) {
					$err++;
					$_SESSION['sys_occupants_edit_lastname_err'] = renderLang($occupants_lastname_required);
				}
			}
			
			// GENDER
			$gender = 0;
			if(isset($_POST['gender'])) {
				$gender = trim($_POST['gender']);
				$_SESSION['sys_occupants_edit_gender_val'] = $gender;
				$gender_exists = 0;
				foreach($gender_arr as $gender_data) {
					if($gender_data[0] == $gender) {
						$gender_exists = 1;
					}
				}
				if(!$gender_exists) {
					$err++;
					$_SESSION['sys_occupants_edit_gender_err'] = renderLang($occupants_select_valid_gender);
				}
			}
			
			// BIRTHDATE
			$birthdate = '';
			if(isset($_POST['birthdate'])) {
				$birthdate = trim($_POST['birthdate']);
				$_SESSION['sys_occupants_edit_birthdate_val'] = $birthdate;
				if(strlen($birthdate) == 0) {
					$err++;
					$_SESSION['sys_occupants_edit_birthdate_err'] = renderLang($occupants_birthdate_required);
				}
			}
			
			// CIVIL STATUS
			$civil_status = 0;
			if(isset($_POST['civil_status'])) {
				$civil_status = trim($_POST['civil_status']);
				$_SESSION['sys_occupants_edit_civil_status_val'] = $civil_status;
				$status_exists = 0;
				foreach($civil_status_arr as $value) {
					if($value[0] == $civil_status) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_occupants_edit_civil_status_err'] = renderLang($occupants_select_valid_civil_status);
				}
			}

            // CITIZENSHIP ID
            $citizenship_id = 0;
            if(isset($_POST['citizenship_id'])) {
                $citizenship_id = trim($_POST['citizenship_id']);
                $_SESSION['sys_occupants_edit_citizenship_id_val'] = $citizenship_id;

            }
            
            // RELATIONSHIP TO TENANT
            $relationship_to_tenant = 0;
            if(isset($_POST['relationship_to_tenant'])) {
                $relationship_to_tenant = trim($_POST['relationship_to_tenant']);
                $_SESSION['sys_occupants_edit_relationship_to_tenant_val'] = $relationship_to_tenant;
            }

            // SOCIAL STATUS
            $social_status = 0;
            if(isset($_POST['social_status'])) {
                $social_status = trim($_POST['social_status']);
                $_SESSION['sys_occupants_edit_social_status_val'] = $social_status;
            }
			
			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors
				
				$change_logs = array();
				if($unit_id != $data['unit_id']) {
					$tmp = 'occupants_unit_id::'.$data['unit_id'].'=='.$unit_id;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'occupants_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
				}
				if($firstname != $data['firstname']) {
					$tmp = 'occupants_firstname::'.$data['firstname'].'=='.$firstname;
					array_push($change_logs,$tmp);
				}
				if($middlename != $data['middlename']) {
					$tmp = 'occupants_middlename::'.$data['middlename'].'=='.$middlename;
					array_push($change_logs,$tmp);
				}
				if($lastname != $data['lastname']) {
					$tmp = 'occupants_lastname::'.$data['lastname'].'=='.$lastname;
					array_push($change_logs,$tmp);
				}
				if($gender != $data['gender']) {
					$tmp = 'occupants_gender::'.$data['gender'].'=='.$gender;
					array_push($change_logs,$tmp);
				}
				if($civil_status != $data['civil_status']) {
					$tmp = 'occupants_civil_status::'.$data['civil_status'].'=='.$civil_status;
					array_push($change_logs,$tmp);
				}
				if($birthdate != $data['birthdate']) {
					$tmp = 'occupants_birthdate::'.$data['birthdate'].'=='.$birthdate;
					array_push($change_logs,$tmp);
				}
				if($citizenship_id != $data['citizenship_id']) {
					$tmp = 'occupants_citizenship_id::'.$data['citizenship_id'].'=='.$citizenship_id;
					array_push($change_logs,$tmp);
				}
				
				if(count($change_logs) > 0) {
					
					$sql = $pdo->prepare("UPDATE occupants SET
						firstname = :firstname,
						middlename = :middlename,
						lastname = :lastname,
						gender = :gender,
						civil_status = :civil_status,
						birthdate = :birthdate,
						unit_id = :unit_id,
						citizenship_id = :citizenship_id,
						relationship_to_tenant = :relationship_to_tenant,
						social_status = :social_status,
						status = :status
					WHERE occupants.id = :id");
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
					$sql->bindParam(":status", $status);
					$sql->bindParam(":id", $id);
					$sql->execute();
					
					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('occupants',$id,'edit',$change_log);
					
					$_SESSION['sys_occupants_edit_suc'] = renderLang($occupants_occupant_updated);

				
				} else {
					
					$_SESSION['sys_occupants_edit_err'] = renderLang($form_no_changes);
				
				}
			
			} else { // error found
				
				$_SESSION['sys_occupants_edit_err'] = renderLang($form_error);
			
			}
			
			header('location: /occupants');
		
		} else {
			
			$_SESSION['sys_occupants_edit_err'] = renderLang($form_id_not_found);
			
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