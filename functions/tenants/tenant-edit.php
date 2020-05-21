<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('tenant-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM tenants WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// TENANT ID
			$tenant_id = '';
			if(isset($_POST['tenant_id'])) {
				$tenant_id = strtolower(trim($_POST['tenant_id']));
				if(strlen($tenant_id) == 0) {
					$err++;
					$_SESSION['sys_tenants_edit_user_tenant_id_err'] = renderLang($tenants_tenant_id_required);
				} else {
					
					$_SESSION['sys_tenants_edit_tenant_id_val'] = $tenant_id;
					
					// check if user name already exists
					$sql = $pdo->prepare("SELECT tenant_id FROM tenants WHERE tenant_id = :tenant_id AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":tenant_id",$tenant_id);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_tenants_edit_tenant_id_err'] = renderLang($tenants_tenant_id_exists);
					}
				}
			}
			
			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_tenants_edit_status_val'] = $status;
				$status_exists = 0;
				foreach($status_arr as $status_data) {
					if($status_data[0] == $status_exists) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_tenants_edit_status_err'] = 'Please select a valid status.';
				}
			}

			// FIRSTNAME
			$firstname = '';
			if(isset($_POST['firstname'])) {
				$firstname = trim($_POST['firstname']);
				$_SESSION['sys_tenants_edit_firstname_val'] = $firstname;
				if(strlen($firstname) == 0) {
					$err++;
					$_SESSION['sys_tenants_edit_firstname_err'] = renderLang($tenants_firstname_required);
				}
			}

			// MIDDLENAME
			$middlename = '';
			if(isset($_POST['middlename'])) {
				$middlename = trim($_POST['middlename']);
				$_SESSION['sys_tenants_edit_middlename_val'] = $middlename;
			}
			
			// LASTNAME
			$lastname = '';
			if(isset($_POST['lastname'])) {
				$lastname = trim($_POST['lastname']);
				$_SESSION['sys_tenants_edit_lastname_val'] = $lastname;
				if(strlen($lastname) == 0) {
					$err++;
					$_SESSION['sys_tenants_edit_lastname_err'] = renderLang($tenants_lastname_required);
				}
			}

			// GENDER
			$gender = 0;
			if(isset($_POST['gender'])) {
				$gender = trim($_POST['gender']);
				$_SESSION['sys_tenants_edit_gender_val'] = $gender;
				$gender_exists = 0;
				foreach($gender_arr as $gender_data) {
					if($gender_data[0] == $gender_exists) {
						$gender_exists = 1;
					}
				}
				if(!$gender_exists) {
					$err++;
					$_SESSION['sys_tenants_edit_gender_err'] = renderLang($tenants_select_valid_gender);
				}
			}


			// CITIZENSHIP ID
			$citizenship_id = '';
			if(isset($_POST['citizenship_id'])) {
				$citizenship_id = trim($_POST['citizenship_id']);
				$_SESSION['sys_tenants_edit_citizenship_id_val'] = $citizenship_id;
				
			}

			// RELATIONSHIP TO OWNER
			$relationship_to_owner = '';
			if(isset($_POST['relationship_to_owner'])) {
				$relationship_to_owner = trim($_POST['relationship_to_owner']);
				$_SESSION['sys_tenants_edit_relationship_to_owner_val'] = $relationship_to_owner;
				
			}

			// SOCIAL STATUS
			$social_status = '';
			if(isset($_POST['social_status'])) {
				$social_status = trim($_POST['social_status']);
				$_SESSION['sys_tenants_edit_social_status_val'] = $social_status;
				
            }
            
            // PARKING
            $parking = '';
            if(isset($_POST['parking'])) {
                $parking = trim($_POST['parking']);
                $_SESSION['sys_tenants_edit_parking_val'] = $parking;
            }

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($tenant_id != $data['tenant_id']) {
					$tmp = 'tenants_tenant_id::'.$data['tenant_id'].'=='.$tenant_id;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'lang_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
				}
				if($firstname != $data['firstname']) {
					$tmp = 'tenants_firstname::'.$data['firstname'].'=='.$firstname;
					array_push($change_logs,$tmp);
				}
				if($middlename != $data['middlename']) {
					$tmp = 'tenants_middlename::'.$data['middlename'].'=='.$middlename;
					array_push($change_logs,$tmp);
				}
				if($lastname != $data['lastname']) {
					$tmp = 'tenants_lastname::'.$data['lastname'].'=='.$lastname;
					array_push($change_logs,$tmp);
				}
				if($gender != $data['gender']) {
					$tmp = 'tenants_gender::'.$data['gender'].'=='.$gender;
					array_push($change_logs,$tmp);
                }
                if($citizenship_id != $data['citizenship_id']) {
					$tmp = 'lang_citizenship_global::'.$data['citizenship_id'].'=='.$citizenship_id;
					array_push($change_logs,$tmp);
                }
                if($relationship_to_owner != $data['relationship_to_owner']) {
					$tmp = 'tenants_relationship_to_owner::'.$data['relationship_to_owner'].'=='.$relationship_to_owner;
					array_push($change_logs,$tmp);
                }
                if($social_status != $data['social_status']) {
					$tmp = 'occupants_social_status::'.$data['social_status'].'=='.$social_status;
					array_push($change_logs,$tmp);
                }
                if($parking != $data['parking']) {
					$tmp = 'tenants_parking::'.$data['parking'].'=='.$parking;
					array_push($change_logs,$tmp);
				}
				
				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account tenants table
					$sql = $pdo->prepare("UPDATE tenants SET
						tenant_id = :tenant_id,
						firstname = :firstname,
						middlename = :middlename,
						lastname = :lastname,
						gender = :gender,
						status = :status,
						citizenship_id = :citizenship_id,
						relationship_to_owner = :relationship_to_owner,
						social_status = :social_status,
                        parking = :parking
					WHERE id = ".$id);
					$sql->bindParam(":tenant_id",$tenant_id);
					$sql->bindParam(":firstname",$firstname);
					$sql->bindParam(":middlename",$middlename);
					$sql->bindParam(":lastname",$lastname);
					$sql->bindParam(":gender",$gender);
					$sql->bindParam(":status",$status);
					$sql->bindParam(":citizenship_id",$citizenship_id);
					$sql->bindParam(":relationship_to_owner",$relationship_to_owner);
                    $sql->bindParam(":social_status",$social_status);
                    $sql->bindParam(":parking", $parking);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('tenant',$id,'update',$change_log);

                    $_SESSION['sys_tenants_edit_suc'] = renderLang($tenants_tenant_updated);
                    header('location: /tenants');

				} else { // no changes made

					$_SESSION['sys_tenants_edit_err'] = renderLang($form_no_changes);
                    header('location: /edit-tenant/'.$id);
				}

			} else { // error found

                $_SESSION['sys_tenants_edit_err'] = renderLang($form_error);
                header('location: /edit-tenant/'.$id);

			}

		} else {

            $_SESSION['sys_tenants_edit_err'] = renderLang($form_id_not_found);
            header('location: /edit-tenant/'.$id);

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