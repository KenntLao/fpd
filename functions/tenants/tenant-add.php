<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if tenant has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('tenant-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// TENANT ID
		$tenant_id = '';
		if(isset($_POST['tenant_id'])) {
			$tenant_id = strtolower(trim($_POST['tenant_id']));
			if(strlen($tenant_id) == 0) {
				$err++;
				$_SESSION['sys_tenants_add_tenant_id_err'] = renderLang($tenants_tenant_id_required);
			} else {
				
				$_SESSION['sys_tenants_add_tenant_id_val'] = $tenant_id;
				
				// check if tenant ID already exists
				$sql = $pdo->prepare("SELECT tenant_id, temp_del FROM tenants WHERE tenant_id = :tenant_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":tenant_id",$tenant_id);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_tenants_add_tenant_id_err'] = renderLang($tenants_tenant_id_exists);
				}
			}
		}
		
		// FIRSTNAME
		$firstname = '';
		if(isset($_POST['firstname'])) {
			$firstname = trim($_POST['firstname']);
			$_SESSION['sys_tenants_add_firstname_val'] = $firstname;
			if(strlen($firstname) == 0) {
				$err++;
				$_SESSION['sys_tenants_add_firstname_err'] = renderLang($tenants_firstname_required);
			}
		}
		
		// MIDDLENAME
		$middlename = '';
		if(isset($_POST['middlename'])) {
			$middlename = trim($_POST['middlename']);
			$_SESSION['sys_tenants_add_middlename_val'] = $middlename;
		}
		
		// LASTNAME
		$lastname = '';
		if(isset($_POST['lastname'])) {
			$lastname = trim($_POST['lastname']);
			$_SESSION['sys_tenants_add_lastname_val'] = $lastname;
			if(strlen($lastname) == 0) {
				$err++;
				$_SESSION['sys_tenants_add_lastname_err'] = renderLang($tenants_lastname_required);
			}
		}
		
		// GENDER
		$gender = 0;
		if(isset($_POST['gender'])) {
			$gender = trim($_POST['gender']);
			$_SESSION['sys_tenants_add_gender_val'] = $gender;
			$gender_exists = 0;
			foreach($gender_arr as $gender_data) {
				if($gender_data[0] == $gender_exists) {
					$gender_exists = 1;
				}
			}
			if(!$gender_exists) {
				$err++;
				$_SESSION['sys_tenants_add_gender_err'] = renderLang($tenants_select_valid_gender);
			}
		}

		// BIRTHDATE
		$birthdate = '';
		if(isset($_POST['birthdate'])) {
			$birthdate = trim($_POST['birthdate']);
			$_SESSION['sys_tenants_add_birthdate_val'] = $birthdate;
			if(strlen($birthdate) == 0) {
				$err++;
				$_SESSION['sys_tenants_add_birthdate_err'] = renderLang($tenants_birthdate_required);
			}
		}
		
		// CITIZENSHIP ID
		$citizenship_id = '';
		if(isset($_POST['citizenship_id'])) {
			$citizenship_id = trim($_POST['citizenship_id']);
			$_SESSION['sys_tenants_add_citizenship_id_val'] = $citizenship_id;
			
		}

		// RELATIONSHIP TO OWNER
		$relationship_to_owner = '';
		if(isset($_POST['relationship_to_owner'])) {
			$relationship_to_owner = trim($_POST['relationship_to_owner']);
			$_SESSION['sys_tenants_add_relationship_to_owner_val'] = $relationship_to_owner;
			
		}

		// SOCIAL STATUS
		$social_status = '';
		if(isset($_POST['social_status'])) {
			$social_status = trim($_POST['social_status']);
			$_SESSION['sys_tenants_add_social_status_val'] = $social_status;
			
        }
        
        // PARKING
        $parking = '';
        if(isset($_POST['parking'])) {
            $parking = trim($_POST['parking']);
            $_SESSION['sys_tenants_add_parking_val'] = $parking;
        }

		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			$upass = encryptStr($tenant_id);
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO tenants(
                id,
                tenant_id,
                upass,
                firstname,
                middlename,
                lastname,
                gender,
                birthdate,
                citizenship_id,
                relationship_to_owner,
                social_status,
                parking
            ) VALUES(
                NULL,
                :tenant_id,
                :upass,
                :firstname,
                :middlename,
                :lastname,
                :gender,
                :birthdate,
                :citizenship_id,
                :relationship_to_owner,
                :social_status,
                :parking
            )");
			$sql->bindParam(":tenant_id",$tenant_id);
			$sql->bindParam(":upass",$upass);
			$sql->bindParam(":firstname",$firstname);
			$sql->bindParam(":middlename",$middlename);
			$sql->bindParam(":lastname",$lastname);
			$sql->bindParam(":gender",$gender);
			$sql->bindParam(":birthdate",$birthdate);
			$sql->bindParam(":citizenship_id",$citizenship_id);
			$sql->bindParam(":relationship_to_owner",$relationship_to_owner);
            $sql->bindParam(":social_status",$social_status);
            $sql->bindParam(":parking", $parking);
			$sql->execute();
			
			// get ID of new tenant
			$sql = $pdo->prepare("SELECT id, tenant_id FROM tenants WHERE tenant_id = :tenant_id LIMIT 1");
			$sql->bindParam(":tenant_id",$tenant_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('tenant',$data['id'],'add','');

			$_SESSION['sys_tenants_suc'] = renderLang($tenants_tenant_added);
			header('location: /tenants');
			
		} else { // error found
			
			$_SESSION['sys_tenants_add_err'] = renderLang($form_error);
			header('location: /add-tenant');
			
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