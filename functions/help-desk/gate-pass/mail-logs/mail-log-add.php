<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('mail-log-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// SUB PROPERTY ID
		$sub_property_id = '';
		if(isset($_POST['sub_property_id'])) {
			$sub_property_id = trim($_POST['sub_property_id']);
			
		}

		// REFERENCE NUMBER
		$reference_number = '';
		if(isset($_POST['reference_number'])) {
			$reference_number = trim($_POST['reference_number']);
			$_SESSION['sys_mail_logs_add_reference_number_val'] = $reference_number;
			
		}

		// DATE RECEIVED
		$date_received = '';
		if(isset($_POST['date_received'])) {
			$date_received = trim($_POST['date_received']);
			$_SESSION['sys_mail_logs_add_date_received_val'] = $date_received;
			
		}

		// ADDRESSEE
		$addressee = '';
		if(isset($_POST['addressee'])) {
			$addressee = trim($_POST['addressee']);
			$_SESSION['sys_mail_logs_add_addressee_val'] = $addressee;
			
		}

		// SENDER
		$sender = '';
		if(isset($_POST['sender'])) {
			$sender = trim($_POST['sender']);
			$_SESSION['sys_mail_logs_add_sender_val'] = $sender;
			
		}

		// DATE SENT
		$date_sent = '';
		if(isset($_POST['date_sent'])) {
			$date_sent = trim($_POST['date_sent']);
			$_SESSION['sys_mail_logs_add_date_sent_val'] = $date_sent;
			
		}

		// REMARKS
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_mail_logs_add_remarks_val'] = $remarks;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO mail_logs (
				sub_property_id,
				reference_number,
				date_received,
				addressee,
				sender,
				date_sent,
				remarks
			) VALUES (
				:sub_property_id,
				:reference_number,
				:date_received,
				:addressee,
				:sender,
				:date_sent,
				:remarks
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":reference_number", $reference_number);
			$sql->bindParam(":date_received", $date_received);
			$sql->bindParam(":addressee", $addressee);
			$sql->bindParam(":sender", $sender);
			$sql->bindParam(":date_sent", $date_sent);
			$sql->bindParam(":remarks", $remarks);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('mail_logs',$id,'add','');

			// notifications
			$employees = getTable('employees');
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('mail-logs', $id, $employee['id'], 'employee', 'gate_pass_employee_add');
			}
			foreach ($users as $user) {
				push_notification('mail-logs', $id, $user['id'], 'user', 'gate_pass_employee_add');
			}

			$_SESSION['sys_mail_logs_add_suc'] = renderLang($mail_logs_visitor_added);
			header('location: /mail-logs');
			
		} else { // error found
			
			$_SESSION['sys_mail_logs_add_err'] = renderLang($form_error);
			header('location: /add-mail-log');
			
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