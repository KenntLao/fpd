<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('service-request-add')) {
	
		$err = 0;

		$date = time();
		
		// PROCESS FORM

		// COMPLAINANT
		$complainant = $_SESSION['sys_id'];

		// LOCATION
		$account_type = $_SESSION['sys_account_mode'];

		// UNIT NO
		$unit_id = '';
		if(isset($_POST['unit'])) {
			$unit_id = trim($_POST['unit']);
			$_SESSION['sys_service_requests_add_unit_val'] = $unit_id;
			
		}

		// DESCRIPTION
		$description = '';
		if(isset($_POST['description'])) {
			$description = trim($_POST['description']);
			$_SESSION['sys_service_requests_add_description_val'] = $description;
			
		}

		// SERVICE
		$service = '';
		if(isset($_POST['service'])) {
			$service = trim($_POST['service']);
			$_SESSION['sys_service_requests_add_service_val'] = $service;
			
		}

		// ASSESSMENT
		$assessment = '';
		if(isset($_POST['assessment'])) {
			$assessment = trim($_POST['assessment']);
			$_SESSION['sys_service_requests_add_assessment_val'] = $assessment;
			
		}

		// REMARKS
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_service_requests_add_remarks_val'] = $remarks;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO service_requests (
				date,
				complainant,
				account_type,
				unit_id,
				description,
				service,
				assessment,
				remarks
			) VALUES (
				:date,
				:complainant,
				:account_type,
				:unit_id,
				:description,
				:service,
				:assessment,
				:remarks
				
			)");
			$sql->bindParam(":date", $date);
			$sql->bindParam(":complainant", $complainant);
			$sql->bindParam(":account_type", $account_type);
			$sql->bindParam(":unit_id", $unit_id);
			$sql->bindParam(":description", $description);
			$sql->bindParam(":service", $service);
			$sql->bindParam(":assessment", $assessment);
			$sql->bindParam(":remarks", $remarks);
			$sql->execute();

			$id = $pdo->lastInsertId();

			$target_category = 0;

			if($remarks == 0) {
					$table = 'task_job_order';
					$remark = 'job_order';
			}
			if($remarks == 1) {
					$table = 'task_work_order';
					$remark = 'work_order';
			}
			else{

			}

			$sql2 = $pdo->prepare("SELECT ".$remark."_no FROM ".$table." ORDER BY id DESC LIMIT 1");
					$sql2->execute();
					if($sql2->rowCount()) {
						$_data = $sql2->fetch(PDO::FETCH_ASSOC);
						$id_suggestion = $_data[''.$remark.'_no'] + 1;
					} else {
						$id_suggestion = 1001;
					}

						$sql3 = $pdo->prepare("INSERT INTO ".$table." ( 
							unit_id,
							target_id,
							target_category,
							".$remark."_no,
							requestor_account_mode,
							".$remark."_date,
							".$remark."_nature,
							".$remark."_description
						) VALUES (
							:unit_id,
							:target_id,
							:target_category,
							:".$remark."_no,
							:requestor_account_mode,
							:".$remark."_date,
							:".$remark."_nature,
							:".$remark."_description

						)");
							$sql3->bindParam(":unit_id", $unit_id);
							$sql3->bindParam(":target_id", $id);
							$sql3->bindParam(":target_category", $target_category);
							$sql3->bindParam(":".$remark."_no", $id_suggestion);
							$sql3->bindParam(":requestor_account_mode", $account_type);
							$sql3->bindParam(":".$remark."_date", $date);
							$sql3->bindParam(":".$remark."_nature", $service);
							$sql3->bindParam(":".$remark."_description", $description);
							$sql3->execute();
			
			// record to system log
			systemLog('service_requests',$id,'add','');

			// push notifications
			$employees = getTable("employees");
			$users = getTable("users");
			foreach ($employees as $employee) {
				push_notification('service-requests',$id,$employee['id'],'employee','service_requests_added_to_'.$table);
			}
			foreach ($users as $user) {
				push_notification('service-requests',$id,$user['id'],'user','service_requests_added_to_'.$table);
			}

			$_SESSION['sys_service_requests_add_suc'] = renderLang($service_requests_added);
			header('location: /service-requests');
			
		} else { // error found
			
			$_SESSION['sys_service_requests_add_err'] = renderLang($form_error);
			header('location: /add-service-request');
			
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