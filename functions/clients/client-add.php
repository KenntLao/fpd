<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if client has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('client-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// CLIENT ID
		$client_id = '';
		if(isset($_POST['client_id'])) {
			$client_id = strtolower(trim($_POST['client_id']));
			if(strlen($client_id) == 0) {
				$err++;
				$_SESSION['sys_clients_add_client_id_err'] = renderLang($clients_client_id_required);
			} else {
				
				$_SESSION['sys_clients_add_client_id_val'] = $client_id;
				
				// check if client ID already exists
				$sql = $pdo->prepare("SELECT client_id, temp_del FROM clients WHERE client_id = :client_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":client_id",$client_id);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_clients_add_client_id_err'] = renderLang($clients_client_id_exists);
				}
			}
		}
		
		// CLIENT NAME
		$client_name = '';
		if(isset($_POST['client_name'])) {
			$client_name = trim($_POST['client_name']);
			if(strlen($client_name) == 0) {
				$err++;
				$_SESSION['sys_clients_add_client_name_err'] = renderLang($clients_client_name_required);
			} else {
				
				$_SESSION['sys_clients_add_client_name_val'] = $client_name;
				
				// check if client ID already exists
				$sql = $pdo->prepare("SELECT client_name, temp_del FROM clients WHERE client_name = :client_name AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":client_name",$client_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_clients_add_client_name_err'] = renderLang($clients_client_name_exists);
				}
			}
		}
		
		// CONTACT PERSON
		$contact_person = '';
		if(isset($_POST['contact_person'])) {
			$contact_person = trim($_POST['contact_person']);
			$_SESSION['sys_clients_add_contact_person_val'] = $contact_person;
			if(strlen($contact_person) == 0) {
				$err++;
				$_SESSION['sys_clients_add_contact_person_err'] = renderLang($clients_contact_person_required);
			}
		}
		
		// CONTACT DETAILS
		$contact_details = '';
		if(isset($_POST['contact_details'])) {
			$contact_details = trim($_POST['contact_details']);
			$_SESSION['sys_clients_add_contact_details_val'] = $contact_details;
			if(strlen($contact_details) == 0) {
				$err++;
				$_SESSION['sys_clients_add_contact_details_err'] = renderLang($clients_contact_details_required);
			}
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			// update account language table
			$sql = $pdo->prepare("INSERT INTO clients(
					id,
					client_id,
					client_name,
					contact_person,
					contact_details
				) VALUES(
					NULL,
					:client_id,
					:client_name,
					:contact_person,
					:contact_details
				)");
			$sql->bindParam(":client_id",$client_id);
			$sql->bindParam(":client_name",$client_name);
			$sql->bindParam(":contact_person",$contact_person);
			$sql->bindParam(":contact_details",$contact_details);
			$sql->execute();
			
			// get ID of new client
			$sql = $pdo->prepare("SELECT id, client_id FROM clients WHERE client_id = :client_id LIMIT 1");
			$sql->bindParam(":client_id",$client_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('client',$data['id'],'add','');

			$_SESSION['sys_clients_suc'] = renderLang($clients_client_added);
			header('location: /clients');
			
		} else { // error found
			
			$_SESSION['sys_clients_add_client_err'] = renderLang($form_error);
			header('location: /add-client');
			
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