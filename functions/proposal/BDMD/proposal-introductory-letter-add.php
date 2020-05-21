<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-add')) {
	
		$err = 0;

		// LETTER ID
        $letter_id = 0;
        if (isset($_POST['id'])) {
            $letter_id = $_POST['id'];
            $_SESSION['sys_proposal_letter_add_id_val'] = $letter_id;
        }

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

		    // Append Operation
		    if ($letter_id===0) {

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

            	//system log 
                systemLog('proposal',$id,'add','');

                // push notification proposal introductory letter
                $employees = getTable("employees");
                $users = getTable("users");
                foreach ($employees as $employee) {
                	push_notification('proposal-introductory-letter', $id, $employee['id'], 'employee','proposal_introductory_letter_add');
                }
                foreach ($users as $user) {
                	push_notification('proposal-introductory-letter', $id, $user['id'], 'user', 'proposal_introductory_letter_add');
                }

            } else {

		        $sql = $pdo->prepare("SELECT * FROM proposal_introductory_letters WHERE id = :id AND temp_del = 0 LIMIT 1");
		        $sql->bindParam(":id", $letter_id);
		        $sql->execute();
		        $_data = $sql->fetch(PDO::FETCH_ASSOC);
		        if(!$sql->rowCount()) {
		            $err++;
		        }

		        $change_logs = array();
		        if ($dear_name != $_data['dear_name']) {
		        	$tmp = 'proposals_introductory_letter_dear::'.$_data['dear_name'].'=='.$dear_name;
		        	array_push($change_logs, $tmp);
		        }
		        if ($services != $_data['services']) {
		        	$tmp = 'prospecting_service_required::'.$_data['services'].'=='.$services;
		        	array_push($change_logs, $tmp);
		        }
		        if ($contact_name != $_data['contact_name']) {
		        	$tmp = 'proposals_introductory_letter_name::'.$_data['contact_name'].'=='.$contact_name;
		        	array_push($change_logs, $tmp);
		        }
		        if ($position != $_data['position']) {
		        	$tmp = 'proposals_introductory_letter_position::'.$_data['position'].'=='.$position;
		        	array_push($change_logs, $tmp);
		        }
		        if ($trunkline_no != $_data['trunkline_no']) {
		        	$tmp = 'proposals_introductory_letter_trunkline_no::'.$_data['trunkline_no'].'=='.$trunkline_no;
		        	array_push($change_logs, $tmp);
		        }
		        if ($fax_no != $_data['fax_no']) {
		        	$tmp = 'proposals_introductory_letter_fax_no::'.$_data['fax_no'].'=='.$fax_no;
		        	array_push($change_logs, $tmp);
		        }
		        if ($email != $_data['email']) {
		        	$tmp = 'proposals_introductory_letter_email::'.$_data['email'].'=='.$email;
		        	array_push($change_logs, $tmp);
		        }
		        if ($sender != $_data['sender']) {
		        	$tmp = 'calibration_prepared_by::'.$_data['sender'].'=='.$sender;
		        	array_push($change_logs, $tmp);
		        }

		        if (count($change_logs) > 0) {

			        // UPDATE OPERATION
	                $sql = $pdo->prepare("UPDATE proposal_introductory_letters
			         SET prospect_id = :prospect_id, 
			             dear_name = :dear_name,
			             services = :services,
			             contact_name = :contact_name,
			             position = :position,
			             trunkline_no = :trunkline_no,
			             fax_no = :fax_no,
			             email = :email,
			             sender = :sender,
			             proposal_category = :proposal_category
	                 WHERE id = :id ");

	                $sql->bindParam(":id", $letter_id);
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

	                //system log
	                $change_log = implode(';;',$change_logs);
	                systemLog('proposal',$letter_id,'update',$change_log);

	                //notification UPDATE proposal introductory letter
	                $employees = getTable("employees");
	                $users = getTable("users");
	                foreach ($employees as $employee) {
	                	push_notification('proposal-introductory-letter', $letter_id, $employee['id'], 'employee', 'proposal_introductory_letter_updated');
	                }
	                foreach ($users as $user) {
	                	push_notification('proposal-introductory-letter', $letter_id, $user['id'], 'user', 'proposal_introductory_letter_updated');
	                }

                
		        }

            }



			$_SESSION['sys_proposal_letter_add_suc'] = renderLang($mail_logs_visitor_added);
			header('location: /bdmd-introductory-letters-list');
			
		} else { // error found
			
			$_SESSION['sys_mail_logs_add_err'] = renderLang($form_error);
			header('location: /add-bdmd-introductory-letter-proposal/'.$id);
			
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