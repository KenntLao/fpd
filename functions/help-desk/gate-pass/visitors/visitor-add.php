<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('visitor-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		$user_id = $_SESSION['sys_id'];
		$user_account_mode = $_SESSION['sys_account_mode'];

        // sub_property_id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
        }

		// TIME IN
		$time_in = '';
		if(isset($_POST['time_in'])) {
			$time_in = trim($_POST['time_in']);
			$_SESSION['sys_visitors_add_time_in_val'] = $time_in;
			
		}

		// TIME OUT
		$time_out = '';
		if(isset($_POST['time_out'])) {
			$time_out = trim($_POST['time_out']);
			$_SESSION['sys_visitors_add_time_out_val'] = $time_out;
			
		}

		// NAME OF VISITOR
		$name_of_visitor = '';
		if(isset($_POST['name_of_visitor'])) {
			$name_of_visitor = trim($_POST['name_of_visitor']);
			$_SESSION['sys_visitors_add_name_of_visitor_val'] = $name_of_visitor;
			
		}

		// COMPANY / ADDRESS
		$company_address = '';
		if(isset($_POST['company_address'])) {
			$company_address = trim($_POST['company_address']);
			$_SESSION['sys_visitors_add_company_address_val'] = $company_address;
			
		}

		// PERSON TO VISIT
		$person_to_visit = '';
		if(isset($_POST['person_to_visit'])) {
			$person_to_visit = trim($_POST['person_to_visit']);
			$_SESSION['sys_visitors_add_person_to_visit_val'] = $person_to_visit;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_visitors_add_purpose_val'] = $purpose;
			
		}

		// PURPOSE OTHERS
		$purpose_others = '';
		if(isset($_POST['purpose_others'])) {
			$purpose_others = trim($_POST['purpose_others']);
			
		}

		// STATUS 
		$status = 0;
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_visitors_add_status_val'] = $status;
			
		}
		
		// VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors
        
            $curr_date = formatDate(time(), true, false);
        
            $sql = $pdo->prepare("INSERT INTO visitors (
            	sub_property_id,
                date,
                time_in,
                time_out,
                name_of_visitor,
                company_address,
                person_to_visit,
                purpose,
                purpose_others,
                status,
                created_by,
                account_type
            ) VALUES (
            	:sub_property_id,
                :date,
                :time_in,
                :time_out,
                :name_of_visitor,
                :company_address,
                :person_to_visit,
                :purpose,
                :purpose_others,
                :status,	
                :user_id,
                :user_account_mode
            )");

            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":date", $curr_date);
			$sql->bindParam(":time_in", $curr_time);
			$sql->bindParam(":time_out", $time_out);
			$sql->bindParam(":name_of_visitor", $name_of_visitor);
			$sql->bindParam(":company_address", $company_address);
			$sql->bindParam(":person_to_visit", $person_to_visit);
			$sql->bindParam(":purpose", $purpose);
			$sql->bindParam(":purpose_others", $purpose_others);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":user_id", $user_id);
			$sql->bindParam(":user_account_mode", $user_account_mode);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('visitor',$id,'add','');

			// notifications
			$employees = getTable('employees');
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('visitor', $id, $employee['id'], 'employee', 'visitor_add');
			}
			foreach ($users as $user) {
				push_notification('visitor', $id, $user['id'], 'user', 'visitor_add');
			}

			$_SESSION['sys_visitors_add_suc'] = renderLang($visitors_visitor_added);
			header('location: /visitors');
			
		} else { // error found
			
			$_SESSION['sys_contract_add_err'] = renderLang($form_error);
			header('location: /add-visitor');
			
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