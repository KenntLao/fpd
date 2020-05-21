<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('client-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM clients WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// CLIENT ID
			$client_id = '';
			if(isset($_POST['client_id'])) {
				$client_id = strtolower(trim($_POST['client_id']));
				if(strlen($client_id) == 0) {
					$err++;
					$_SESSION['sys_clients_edit_user_client_id_err'] = renderLang($clients_client_id_required);
				} else {
					
					$_SESSION['sys_clients_edit_client_id_val'] = $client_id;
					
					// check if user name already exists
					$sql = $pdo->prepare("SELECT client_id FROM clients WHERE client_id = :client_id AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":client_id",$client_id);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_clients_edit_client_id_err'] = renderLang($clients_client_id_exists);
					}
				}
			}

			// CLIENT NAME
			$client_name = '';
			if(isset($_POST['client_name'])) {
				$client_name = trim($_POST['client_name']);
				if(strlen($client_name) == 0) {
					$err++;
					$_SESSION['sys_clients_edit_client_name_err'] = renderLang($clients_client_name_required);
				} else {

					$_SESSION['sys_clients_edit_client_name_val'] = $client_name;

					// check if client ID already exists
					$sql = $pdo->prepare("SELECT client_name, temp_del FROM clients WHERE client_name = :client_name AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":client_name",$client_name);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_clients_edit_client_name_err'] = renderLang($clients_client_name_exists);
					}
				}
			}
			
			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_clients_edit_status_val'] = $status;
				$status_exists = 0;
				foreach($status_arr as $status_data) {
					if($status_data[0] == $status_exists) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_clients_edit_status_err'] = 'Please select a valid status.';
				}
			}
			
			// CONTACT PERSON
			$contact_person = '';
			if(isset($_POST['contact_person'])) {
				$contact_person = trim($_POST['contact_person']);
				$_SESSION['sys_clients_edit_contact_person_val'] = $contact_person;
				if(strlen($contact_person) == 0) {
					$err++;
					$_SESSION['sys_clients_edit_contact_person_err'] = renderLang($clients_contact_person_required);
				}
			}
			
			// CONTACT DETAILS
			$contact_details = '';
			if(isset($_POST['contact_details'])) {
				$contact_details = trim($_POST['contact_details']);
				$_SESSION['sys_clients_edit_contact_details_val'] = $contact_details;
				if(strlen($contact_details) == 0) {
					$err++;
					$_SESSION['sys_clients_edit_contact_details_err'] = renderLang($clients_contact_details_required);
				}
			}
			
			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($client_id != $data['client_id']) {
					$tmp = 'clients_client_id::'.$data['client_id'].'=='.$client_id;
					array_push($change_logs,$tmp);
				}
				if($client_name != $data['client_name']) {
					$tmp = 'clients_client_name::'.$data['client_name'].'=='.$client_name;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'lang_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
				}
				if($contact_person != $data['contact_person']) {
					$tmp = 'clients_contact_person::'.$data['contact_person'].'=='.$contact_person;
					array_push($change_logs,$tmp);
				}
				if($contact_details != $data['contact_details']) {
					$tmp = 'clients_contact_details::'.$data['contact_details'].'=='.$contact_details;
					array_push($change_logs,$tmp);
				}
				
				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account clients table
					$sql = $pdo->prepare("UPDATE clients SET
						client_id = :client_id,
						client_name = :client_name,
						contact_person = :contact_person,
						contact_details = :contact_details,
						status = :status
					WHERE id = ".$id);
					$sql->bindParam(":client_id",$client_id);
					$sql->bindParam(":client_name",$client_name);
					$sql->bindParam(":contact_person",$contact_person);
					$sql->bindParam(":contact_details",$contact_details);
					$sql->bindParam(":status",$status);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('client',$id,'update',$change_log);

					$_SESSION['sys_clients_edit_client_suc'] = renderLang($clients_client_updated);

				} else { // no changes made

					$_SESSION['sys_clients_edit_client_err'] = renderLang($form_no_changes);

				}

			} else { // error found

				$_SESSION['sys_clients_edit_client_err'] = renderLang($form_error);

			}

		} else {

			$_SESSION['sys_clients_edit_client_err'] = renderLang($form_id_not_found);

		}

		header('location: /edit-client/'.$id);
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>