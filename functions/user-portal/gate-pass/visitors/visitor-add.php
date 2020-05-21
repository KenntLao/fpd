<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	$err = 0;
		
		// PROCESS FORM

		// COMPLAINANT
		$created_by = $_SESSION['sys_id'];

		// LOCATION
		$account_type = $_SESSION['sys_account_mode'];

		// TIME IN
		$time_in = '';
		if(isset($_POST['time_in'])) {
			$time_in = trim($_POST['time_in']);
			
		}

		// TIME OUT
		$time_out = '';
		if(isset($_POST['time_out'])) {
			$time_out = trim($_POST['time_out']);
			
		}

		// NAME OF VISITOR
		$name_of_visitor = '';
		if(isset($_POST['name_of_visitor'])) {
			$name_of_visitor = trim($_POST['name_of_visitor']);			
		}

		// COMPANY / ADDRESS
		$company_address = '';
		if(isset($_POST['company_address'])) {
			$company_address = trim($_POST['company_address']);
			
		}

		// PERSON TO VISIT
		$person_to_visit = '';
		if(isset($_POST['person_to_visit'])) {
			$person_to_visit = trim($_POST['person_to_visit']);
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			
		}

		
		// VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors
        
            $curr_date = formatDate(time(), true, false);
        
            $sql = $pdo->prepare("INSERT INTO visitors (
                date,
                time_in,
                time_out,
                name_of_visitor,
                company_address,
                person_to_visit,
                purpose,
                created_by,
                account_type
            ) VALUES (
                :date,
                :time_in,
                :time_out,
                :name_of_visitor,
                :company_address,
                :person_to_visit,
                :purpose,
                :created_by,
                :account_type
            )");

            $sql->bindParam(":date", $curr_date);
			$sql->bindParam(":time_in", $curr_time);
			$sql->bindParam(":time_out", $time_out);
			$sql->bindParam(":name_of_visitor", $name_of_visitor);
			$sql->bindParam(":company_address", $company_address);
			$sql->bindParam(":person_to_visit", $person_to_visit);
			$sql->bindParam(":purpose", $purpose);
			$sql->bindParam(":created_by", $created_by);
			$sql->bindParam(":account_type", $account_type);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_user_portal_visitors_add_suc'] = renderLang($visitors_visitor_added);
			header('location: /user-visitors');
			
		} else { // error found
			
			$_SESSION['sys_user_portal_visitors_add_err'] = renderLang($form_error);
			header('location: /add-user-visitor');
			
		}

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>