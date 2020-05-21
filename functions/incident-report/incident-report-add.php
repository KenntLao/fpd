<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('incident-report-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// COMPLAINANT
		$complainant = $_SESSION['sys_id'];

		// LOCATION
		$account_type = $_SESSION['sys_account_mode'];

		// SERVICE
		$service = '';
		if(isset($_POST['service'])) {
			$service = trim($_POST['service']);
			$_SESSION['sys_incident_report_add_service_val'] = $service;
			
		}
		

		// UNIT NO
		$unit_id = '';
		if(isset($_POST['unit_id'])) {
			$unit_id = trim($_POST['unit_id']);
			$_SESSION['sys_incident_report_add_unit_id_val'] = $unit_id;
			
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			if (!strlen($date) == 0) {
				$date = strtotime($date);
			}
			$_SESSION['sys_incident_report_add_date_val'] = $date;
			
		}

		// TIME IN
		$time_in = '';
		if(isset($_POST['time_in'])) {
			$time_in = trim($_POST['time_in']);
			$_SESSION['sys_incident_report_add_time_in_val'] = $time_in;
			
		}

		// SEVERITY LEVEL
		$severity_level = '';
		if(isset($_POST['severity_level'])) {
			$severity_level = trim($_POST['severity_level']);
			$_SESSION['sys_incident_report_add_severity_level_val'] = $severity_level;
			
		}

		// REMARKS
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_incident_report_add_remarks_val'] = $remarks;
			
		}

		// DESCRIPTION
		$description = '';
		if(isset($_POST['description'])) {
			$description = trim($_POST['description']);
			$_SESSION['sys_incident_report_add_description_val'] = $description;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO incident_reports (
				service,
				unit_id,
				incident_date,
				incident_time,
				severity_level,
				remarks,
				description
			) VALUES (
				:service,
				:unit_id,
				:date,
				:time_in,
				:severity_level,
				:remarks,
				:description
				
			)");
			$sql->bindParam(":service", $service);
			$sql->bindParam(":unit_id", $unit_id);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":time_in", $time_in);
			$sql->bindParam(":severity_level", $severity_level);
			$sql->bindParam(":remarks", $remarks);
			$sql->bindParam(":description", $description);
			$sql->execute();

			$id = $pdo->lastInsertId();

			$target_category = 1;

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
							".$remark."_description,
							priority
						) VALUES (
							:unit_id,
							:target_id,
							:target_category,
							:".$remark."_no,
							:requestor_account_mode,
							:".$remark."_date,
							:".$remark."_nature,
							:".$remark."_description,
							:priority

						)");
							$sql3->bindParam(":unit_id", $unit_id);
							$sql3->bindParam(":target_id", $id);
							$sql3->bindParam(":target_category", $target_category);
							$sql3->bindParam(":".$remark."_no", $id_suggestion);
							$sql3->bindParam(":requestor_account_mode", $account_type);
							$sql3->bindParam(":".$remark."_date", $date);
							$sql3->bindParam(":".$remark."_nature", $service);
							$sql3->bindParam(":".$remark."_description", $description);
							$sql3->bindParam(":priority", $severity_level);
							$sql3->execute();
			
			// record to system log
			systemLog('service_request',$id,'add','');

			$_SESSION['sys_incident_report_add_suc'] = renderLang($service_requests_added);
			header('location: /incident-reports');
			
		} else { // error found
			
			$_SESSION['sys_incident_report_add_err'] = renderLang($form_error);
			header('location: /add-incident-report');
			
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