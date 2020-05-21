<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('property-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// PROPERTY ID
		$property_id = '';
		if(isset($_POST['property_id'])) {
			$property_id = strtolower(trim($_POST['property_id']));
			if(strlen($property_id) == 0) {
				$err++;
				$_SESSION['sys_properties_add_property_id_err'] = renderLang($properties_property_id_required);
			} else {

				// check if property ID already exists
				$sql = $pdo->prepare("SELECT property_id, temp_del FROM properties WHERE property_id = :property_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":property_id",$property_id);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_properties_add_property_id_err'] = renderLang($properties_property_id_exists);
				}
			}
		}
		
		// PROPERTY CODE
		$property_code = '';
		if(isset($_POST['property_code'])) {
			$property_code = strtoupper(trim($_POST['property_code']));
			if(strlen($property_code) == 0) {
				$err++;
				$_SESSION['sys_properties_add_property_code_err'] = renderLang($properties_property_code_required);
			} else {
				
				$_SESSION['sys_properties_add_property_code_val'] = $property_code;
				
				// check if property code already exists
				$sql = $pdo->prepare("SELECT property_code, temp_del FROM properties WHERE property_code = :property_code AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":property_code",$property_code);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_properties_add_property_code_err'] = renderLang($properties_property_code_exists);
				} else {
                    $property_id = $property_id.'-'.$property_code;
                }
			}
		}
		
		// PROPERTY NAME
		$property_name = '';
		if(isset($_POST['property_name'])) {
			$property_name = trim($_POST['property_name']);
			if(strlen($property_name) == 0) {
				$err++;
				$_SESSION['sys_properties_add_property_name_err'] = renderLang($properties_property_name_required);
			} else {
				
				$_SESSION['sys_properties_add_property_name_val'] = $property_name;
				
				// check if property name already exists
				$sql = $pdo->prepare("SELECT property_name, temp_del FROM properties WHERE property_name = :property_name AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":property_name",$property_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_properties_add_property_name_err'] = renderLang($properties_property_name_exists);
				}
			}
		}
		
		// CLIENT ID
		$client_id = 0;
		if(isset($_POST['client_id'])) {
			$client_id = trim($_POST['client_id']);
			$_SESSION['sys_properties_add_client_id_val'] = $client_id;
        }
        
        // CLUSTER ID 
        $cluster_id = 0;
        if(isset($_POST['cluster'])) {
            $cluster_id = trim($_POST['cluster']);
        }
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			// insert into properties table
			$sql = $pdo->prepare("INSERT INTO properties(
					id,
					property_id,
					property_code,
					property_name,
					client_id,
                    cluster_id
				) VALUES(
					NULL,
					:property_id,
					:property_code,
					:property_name,
					:client_id,
                    :cluster_id
				)");
			$sql->bindParam(":property_id",$property_id);
			$sql->bindParam(":property_code",$property_code);
			$sql->bindParam(":property_name",$property_name);
            $sql->bindParam(":client_id",$client_id);
            $sql->bindParam(":cluster_id",$cluster_id);
			$sql->execute();
			
			// get ID of new property
			$sql = $pdo->prepare("SELECT id, property_code FROM properties WHERE property_code = :property_code LIMIT 1");
			$sql->bindParam(":property_code",$property_code);
			$sql->execute();
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            
            // insert in prospecting
            $sql = $pdo->prepare("INSERT INTO prospecting (
                reference_number, 
                project_name, 
                owner_developer, 
                location, 
                property_category,
                number_of_building, 
                property_age, 
                service_required, 
                other_services, 
                current_property_management, 
                other_remarks, 
                contact_person, 
                designation, 
                telephone, 
                mobile_number, 
                email_address, 
                remarks_on_contact_person, 
                referred_by, 
                lead_received_through, 
                other_lead_remarks, 
                due_date, 
                status, 
                declined_remarks, 
                date, 
                created_by, 
                account_mode, 
                prospecting_category, 
                temp_del
            ) VALUES (:project_id, :property_name, ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '3', ' ', :date, :user_id, :account_mode, '0', '0')");
            $curr_date = time();
            $sql->bindParam(":project_id", $property_id);
            $sql->bindParam(":property_name", $property_name);
            $sql->bindParam(":date", $curr_date);
            $sql->bindParam(":user_id", $_SESSION['sys_id']);
            $sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
            $sql->execute();
			
			// record to system log
			systemLog('property',$data['id'],'add','');

			$_SESSION['sys_properties_suc'] = renderLang($properties_property_added);
			header('location: /properties');
			
		} else { // error found
			
			$_SESSION['sys_properties_add_err'] = renderLang($form_error);
			header('location: /add-property');
			
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