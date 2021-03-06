<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('unit-owner-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM unit_owners WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// UNIT OWNER ID
			$unit_owner_id = '';
			if(isset($_POST['unit_owner_id'])) {
				$unit_owner_id = strtolower(trim($_POST['unit_owner_id']));
				if(strlen($unit_owner_id) == 0) {
					$err++;
					$_SESSION['sys_unit_owners_edit_user_unit_owner_id_err'] = renderLang($unit_owners_unit_owner_id_required);
				} else {
					
					$_SESSION['sys_unit_owners_edit_unit_owner_id_val'] = $unit_owner_id;
					
					// check if user name already exists
					// $sql = $pdo->prepare("SELECT unit_owner_id FROM unit_owners WHERE unit_owner_id = :unit_owner_id AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					// $sql->bindParam(":unit_owner_id",$unit_owner_id);
					// $sql->execute();
					// if($sql->rowCount()) {
					// 	$err++;
					// 	$_SESSION['sys_unit_owners_edit_unit_owner_id_err'] = renderLang($unit_owners_unit_owner_id_exists);
					// }
				}
			}
			
			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_unit_owners_edit_status_val'] = $status;
				$status_exists = 0;
				foreach($status_arr as $status_data) {
					if($status_data[0] == $status_exists) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_unit_owners_edit_status_err'] = 'Please select a valid status.';
				}
			}

			// FIRSTNAME
			$firstname = '';
			if(isset($_POST['firstname'])) {
				$firstname = trim($_POST['firstname']);
				$_SESSION['sys_unit_owners_edit_firstname_val'] = $firstname;
				if(strlen($firstname) == 0) {
					$err++;
					$_SESSION['sys_unit_owners_edit_firstname_err'] = renderLang($unit_owners_firstname_required);
				}
			}

			// MIDDLENAME
			$middlename = '';
			if(isset($_POST['middlename'])) {
				$middlename = trim($_POST['middlename']);
				$_SESSION['sys_unit_owners_edit_middlename_val'] = $middlename;
			}
			
			// LASTNAME
			$lastname = '';
			if(isset($_POST['lastname'])) {
				$lastname = trim($_POST['lastname']);
				$_SESSION['sys_unit_owners_edit_lastname_val'] = $lastname;
				if(strlen($lastname) == 0) {
					$err++;
					$_SESSION['sys_unit_owners_edit_lastname_err'] = renderLang($unit_owners_lastname_required);
				}
			}

			// GENDER
			$gender = 0;
			if(isset($_POST['gender'])) {
				$gender = trim($_POST['gender']);
				$_SESSION['sys_unit_owners_edit_gender_val'] = $gender;
				$gender_exists = 0;
				foreach($gender_arr as $gender_data) {
					if($gender_data[0] == $gender_exists) {
						$gender_exists = 1;
					}
				}
				if(!$gender_exists) {
					$err++;
					$_SESSION['sys_unit_owners_edit_gender_err'] = renderLang($unit_owners_select_valid_gender);
				}
			}

			// CIVIL STATUS
			$civil_status = 0;
			if(isset($_POST['civil_status'])) {
				$civil_status = trim($_POST['civil_status']);
				$_SESSION['sys_unit_owners_edit_civil_status_val'] = $civil_status;
				$civil_status_exists = 0;
				foreach($civil_status_arr as $civil_status_data) {
					if($civil_status_data[0] == $civil_status_exists) {
						$civil_status_exists = 1;
					}
				}
				if(!$civil_status_exists) {
					$err++;
					$_SESSION['sys_unit_owners_edit_civil_status_err'] = renderLang($unit_owners_select_valid_civil_status);
				}
			}

			// BIRTHDATE
			$birthdate = '';
			if(isset($_POST['birthdate'])) {
				$birthdate = trim($_POST['birthdate']);
				$_SESSION['sys_unit_owners_edit_birthdate_val'] = $birthdate;
				if(strlen($birthdate) == 0) {
					$err++;
					$_SESSION['sys_unit_owners_edit_birthdate_err'] = renderLang($unit_owners_birthdate_required);
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
                $_SESSION['sys_unit_owners_edit_parking_val'] = $parking;
            }

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($unit_owner_id != $data['unit_owner_id']) {
					$tmp = 'unit_owners_unit_owner_id::'.$data['unit_owner_id'].'=='.$unit_owner_id;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'lang_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
				}
				if($firstname != $data['firstname']) {
					$tmp = 'unit_owners_firstname::'.$data['firstname'].'=='.$firstname;
					array_push($change_logs,$tmp);
				}
				if($middlename != $data['middlename']) {
					$tmp = 'unit_owners_middlename::'.$data['middlename'].'=='.$middlename;
					array_push($change_logs,$tmp);
				}
				if($lastname != $data['lastname']) {
					$tmp = 'unit_owners_lastname::'.$data['lastname'].'=='.$lastname;
					array_push($change_logs,$tmp);
				}
				if($gender != $data['gender']) {
					$tmp = 'unit_owners_gender::'.$data['gender'].'=='.$gender;
					array_push($change_logs,$tmp);
				}
				if($civil_status != $data['civil_status']) {
					$tmp = 'unit_owners_civil_status::'.$data['civil_status'].'=='.$civil_status;
					array_push($change_logs,$tmp);
				}
				if($birthdate != $data['birthdate']) {
					$tmp = 'unit_owners_birthdate::'.$data['birthdate'].'=='.$birthdate;
					array_push($change_logs,$tmp);
				}
				if($citizenship_id != $data['citizenship_id']) {
					$tmp = 'unit_owners_citizenship_id::'.$data['citizenship_id'].'=='.$citizenship_id;
					array_push($change_logs,$tmp);
                }
                if($parking != $data['parking']) {
					$tmp = 'unit_owners_parking::'.$data['parking'].'=='.$parking;
					array_push($change_logs,$tmp);
                }
				
				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account unit_owners table
					$sql = $pdo->prepare("UPDATE unit_owners SET
						unit_owner_id = :unit_owner_id,
						firstname = :firstname,
						middlename = :middlename,
						lastname = :lastname,
						gender = :gender,
						civil_status = :civil_status,
						birthdate = :birthdate,
						citizenship_id = :citizenship_id,
                        parking = :parking,
						status = :status
					WHERE id = ".$id);
					$sql->bindParam(":unit_owner_id",$unit_owner_id);
					$sql->bindParam(":firstname",$firstname);
					$sql->bindParam(":middlename",$middlename);
					$sql->bindParam(":lastname",$lastname);
					$sql->bindParam(":gender",$gender);
					$sql->bindParam(":civil_status",$civil_status);
					$sql->bindParam(":birthdate",$birthdate);
                    $sql->bindParam(":citizenship_id",$citizenship_id);
                    $sql->bindParam(":parking", $parking);
					$sql->bindParam(":status",$status);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('unit_owner',$id,'update',$change_log);

                    $_SESSION['sys_unit_owners_edit_suc'] = renderLang($unit_owners_unit_owner_updated);
                    header('location: /unit-owners');

				} else { // no changes made

					$_SESSION['sys_unit_owners_edit_err'] = renderLang($form_no_changes);
                    header('location: /edit-unit-owner/'.$id);
				}

			} else { // error found

                $_SESSION['sys_unit_owners_edit_err'] = renderLang($form_error);
                header('location: /edit-unit-owner/'.$id);

			}

		} else {

            $_SESSION['sys_unit_owners_edit_err'] = renderLang($form_id_not_found);
            header('location: /edit-unit-owner/'.$id);

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