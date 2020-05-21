<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('visitor-edit')) {
	
		$err = 0;

		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM visitors WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
		
        // PROCESS FORM
        
		// TIME OUT
		$time_out = '';
		if(isset($_POST['time_out'])) {
			$time_out = trim($_POST['time_out']);
			$_SESSION['sys_visitors_edit_time_out_val'] = $time_out;
			
		}

		// NAME OF VISITOR
		$name_of_visitor = '';
		if(isset($_POST['name_of_visitor'])) {
			$name_of_visitor = trim($_POST['name_of_visitor']);
			$_SESSION['sys_visitors_edit_name_of_visitor_val'] = $name_of_visitor;
			
		}

		// COMPANY / ADDRESS
		$company_address = '';
		if(isset($_POST['company_address'])) {
			$company_address = trim($_POST['company_address']);
			$_SESSION['sys_visitors_edit_company_address_val'] = $company_address;
			
		}

		// PERSON TO VISIT
		$person_to_visit = '';
		if(isset($_POST['person_to_visit'])) {
			$person_to_visit = trim($_POST['person_to_visit']);
			$_SESSION['sys_visitors_edit_person_to_visit_val'] = $person_to_visit;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_visitors_edit_purpose_val'] = $purpose;
			
		}

		// PURPOSE OTHERS
		if($purpose == 'Others') {

			$purpose_others = trim($_POST['purpose_others']);
			
		}else{

			$purpose_others = '';
		}

		// STATUS 
		$status = getField('status', 'visitors', 'id ='.$id);
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_visitors_edit_status_val'] = $status;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($time_out != $_data['time_out']) {
				$tmp = 'visitors_time_out::'.$_data['time_out'].'=='.$time_out;
				array_push($change_logs, $tmp);
			}
			if ($name_of_visitor != $_data['name_of_visitor']) {
				$tmp = 'visitors_name_of_visitor::'.$_data['name_of_visitor'].'=='.$name_of_visitor;
				array_push($change_logs, $tmp);
			}
			if ($company_address != $_data['company_address']) {
				$tmp = 'visitors_company_address::'.$_data['company_address'].'=='.$company_address;
				array_push($change_logs, $tmp);
			}
			if ($person_to_visit != $_data['person_to_visit']) {
				$tmp = 'visitors_person_to_visit::'.$_data['person_to_visit'].'=='.$person_to_visit;
				array_push($change_logs, $tmp);
			}
			if ($purpose != $_data['purpose']) {
				$tmp = 'visitors_purpose::'.$_data['purpose'].'=='.$purpose;
				array_push($change_logs, $tmp);
			}
			if ($purpose_others != $_data['purpose_others']) {
				$tmp = 'visitors_purpose_others::'.$_data['purpose_others'].'=='.$purpose_others;
				array_push($change_logs, $tmp);
			}
			if ($status != $_data['status']) {
				$tmp = 'visitors_status::'.$_data['status'].'=='.$status;
				array_push($change_logs, $tmp);
			}

			if (count($change_logs) > 0) {
      
				$sql = $pdo->prepare("UPDATE visitors SET 
					time_out = :time_out,
					name_of_visitor = :name_of_visitor,
					company_address = :company_address,
					person_to_visit = :person_to_visit,
					purpose = :purpose,
					purpose_others = :purpose_others,
					status = :status
	                WHERE id = :id");
	            $sql->bindParam(":id", $id);
				$sql->bindParam(":time_out", $time_out);
				$sql->bindParam(":name_of_visitor", $name_of_visitor);
				$sql->bindParam(":company_address", $company_address);
				$sql->bindParam(":person_to_visit", $person_to_visit);
				$sql->bindParam(":purpose", $purpose);
				$sql->bindParam(":purpose_others", $purpose_others);
				$sql->bindParam(":status", $status);
                $sql->execute();
                
                $_SESSION['sys_visitors_edit_suc'] = renderLang($visitors_updated);
			    header('location: /visitors');

			} else {
                $_SESSION['sys_visitors_edit_err'] = renderLang($form_no_changes);
                header('location: /edit-visitor/'.$id);
            }
			
			// record to system log
			$change_log = implode(';;',$change_logs);
			systemLog('visitor',$id,'update',$change_log);

			//notification update GATE PASS EMPLOYEE
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('visitor', $id, $employee['id'], 'employee', 'visitor_updated');
				}
				foreach ($users as $user) {
					push_notification('visitor', $id, $user['id'], 'user', 'visitor_updated');
				}
			
		} else { // error found
			
			$_SESSION['sys_visitors_edit_err'] = renderLang($form_error);
			header('location: /edit-visitor/'.$id);
			
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