<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('service-provider-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// SUB PROPERTY ID
		$sub_property_id = '';
		if(isset($_POST['sub_property_id'])) {
			$sub_property_id = trim($_POST['sub_property_id']);
			
		}

		// NAME OF SUPPLIER
		$name_of_the_company = '';
		if(isset($_POST['name_of_the_company'])) {
			$name_of_the_company = trim($_POST['name_of_the_company']);
			$_SESSION['sys_service_providers_add_name_of_the_company_val'] = $name_of_the_company;
			
		}

		// ITEMS
		$services = '';
		if(isset($_POST['services'])) {
			$services = trim($_POST['services']);
			$_SESSION['sys_service_providers_add_services_val'] = $services;
			
		}
		// QUANTITY
		$contact_person = '';
		if(isset($_POST['contact_person'])) {
			$contact_person = trim($_POST['contact_person']);
			$_SESSION['sys_service_providers_add_contact_person_val'] = $contact_person;
			
		}

		// DATE
		$mobile_number = '';
		if(isset($_POST['mobile_number'])) {
			$mobile_number = trim($_POST['mobile_number']);
			$_SESSION['sys_service_providers_add_mobile_number_val'] = $mobile_number;
			
		}

		// NAME DESIGNATION
		$landline_number = '';
		if(isset($_POST['landline_number'])) {
			$landline_number = trim($_POST['landline_number']);
			$_SESSION['sys_service_providers_add_landline_number_val'] = $landline_number;
			
		}

		// PO#
		$email_address = '';
		if(isset($_POST['email_address'])) {
			$email_address = trim($_POST['email_address']);
			$_SESSION['sys_service_providers_add_email_address_val'] = $email_address;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO service_providers (
				sub_property_id,
				name_of_the_company,
				services,
				contact_person,
				mobile_number,
				landline_number,
				email_address
			) VALUES (
				:sub_property_id,
				:name_of_the_company,
				:services,
				:contact_person,
				:mobile_number,
				:landline_number,
				:email_address
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":name_of_the_company", $name_of_the_company);
			$sql->bindParam(":services", $services);
			$sql->bindParam(":contact_person", $contact_person);
			$sql->bindParam(":mobile_number", $mobile_number);
			$sql->bindParam(":landline_number", $landline_number);
			$sql->bindParam(":email_address", $email_address);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			// systemLog('occupants',$id,'add','');

			$_SESSION['sys_service_providers_add_suc'] = renderLang($service_providers_service_provider_added);
			header('location: /service-providers');
			
		} else { // error found
			
			$_SESSION['sys_service_providers_add_err'] = renderLang($form_error);
			header('location: /add-service-provider');
			
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