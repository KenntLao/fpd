<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-pod')) {
	
		$err = 0;
		
		// PROCESS FORM

		$proposal_category = $_POST['proposal_category'];

		// PROSPECT ID
		$prospect_id = '';
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
			$_SESSION['sys_proposal_letter_add_prospect_id_val'] = $prospect_id;
			
		}

		// DEAR NAME
		$dear_name = '';
		if(isset($_POST['dear_name'])) {
			$dear_name = trim($_POST['dear_name']);
			$_SESSION['sys_proposal_letter_add_dear_name_val'] = $dear_name;
			
		}

		// SERVICES
		$services = '';
		if(isset($_POST['services'])) {
			$services = trim($_POST['services']);
			$_SESSION['sys_proposal_letter_add_services_val'] = $services;
			
		}

		// CONTACT NAME
		$contact_name = '';
		if(isset($_POST['contact_name'])) {
			$contact_name = trim($_POST['contact_name']);
			$_SESSION['sys_proposal_letter_add_contact_name_val'] = $contact_name;
			
		}

		// POSITION
		$position = '';
		if(isset($_POST['position'])) {
			$position = trim($_POST['position']);
			$_SESSION['sys_proposal_letter_add_position_val'] = $position;
			
		}

		// TRUNKLINE NO.
		$trunkline_no = '';
		if(isset($_POST['trunkline_no'])) {
			$trunkline_no = trim($_POST['trunkline_no']);
			$_SESSION['sys_proposal_letter_add_trunkline_no_val'] = $trunkline_no;
			
		}

		// FAX NO.
		$fax_no = '';
		if(isset($_POST['fax_no'])) {
			$fax_no = trim($_POST['fax_no']);
			$_SESSION['sys_proposal_letter_add_fax_no_val'] = $fax_no;
			
		}

		// EMAIL
		$email = '';
		if(isset($_POST['email'])) {
			$email = trim($_POST['email']);
			$_SESSION['sys_proposal_letter_add_email_val'] = $email;
			
		}

		// sender
		$sender = '';
		if(isset($_POST['sender'])) {
			$sender = trim($_POST['sender']);
			$_SESSION['sys_proposal_letter_add_sender_val'] = $sender;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO proposal_introductory_letters (
				prospect_id,
				dear_name,
				services,
				contact_name,
				position,
				trunkline_no,
				fax_no,
				email,
				sender,
				proposal_category
			) VALUES (
				:prospect_id,
				:dear_name,
				:services,
				:contact_name,
				:position,
				:trunkline_no,
				:fax_no,
				:email,
				:sender,
				:proposal_category
				
			)");
			$sql->bindParam(":prospect_id", $prospect_id);
			$sql->bindParam(":dear_name", $dear_name);
			$sql->bindParam(":services", $services);
			$sql->bindParam(":contact_name", $contact_name);
			$sql->bindParam(":position", $position);
			$sql->bindParam(":trunkline_no", $trunkline_no);
			$sql->bindParam(":fax_no", $fax_no);
			$sql->bindParam(":email", $email);
			$sql->bindParam(":sender", $sender);
			$sql->bindParam(":proposal_category", $proposal_category);
			$sql->execute();

			$id = $pdo->lastInsertId();			


			$_SESSION['sys_proposal_letter_add_suc'] = renderLang($mail_logs_visitor_added);
			header('location: /pod-proposals');
			
		} else { // error found
			
			$_SESSION['sys_mail_logs_add_err'] = renderLang($form_error);
			header('location: /add-pod-introductory-letter-proposal/'.$id);
			
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