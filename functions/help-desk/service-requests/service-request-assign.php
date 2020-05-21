<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('service-request-add')) {
	
		$err = 0;


		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM service_requests WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
	
		$requestor_type = $_POST['account_type'];
		
		// PROCESS FORM

		// UNIT NO
		$unit_id = '';
		if(isset($_POST['unit'])) {
			$unit_id = trim($_POST['unit']);
			$_SESSION['sys_service_requests_edit_unit_val'] = $unit_id;
			
		}

		// SERVICE
		$service = '';
		if(isset($_POST['service'])) {
			$service = trim($_POST['service']);
			$_SESSION['sys_service_requests_edit_service_val'] = $service;
			
		}

		// DESCRIPTION
		$description = '';
		if(isset($_POST['description'])) {
			$description = trim($_POST['description']);
			$_SESSION['sys_service_requests_edit_description_val'] = $description;
			
		}

		// ASSESSMENT
		$assessment = '';
		if(isset($_POST['assessment'])) {
			$assessment = trim($_POST['assessment']);
			$_SESSION['sys_service_requests_edit_assessment_val'] = $assessment;
			
		}

		// REMARKS 
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_service_requests_edit_remarks_val'] = $remarks;
			
		}

		$target_category = 0;
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($service != $_data['service']) {
				$tmp = 'service_requests_service::'.$_data['service'].'=='.$service;
				array_push($change_logs,$tmp);
			}
			if ($unit_id != $_data['unit_id']) {
				$tmp = 'work_orders_unit_no::'.$_data['unit_id'].'=='.$unit_id;
				array_push($change_logs,$tmp);
			}
			if ($description != $_data['description']) {
				$tmp = 'service_requests_description::'.$_data['description'].'=='.$description;
				array_push($change_logs, $tmp);
			}
			if ($assessment != $_data['assessment']) {
				$tmp = 'service_requests_assessment::'.$_data['assessment'].'=='.$assessment;
				array_push($changes_logs, $tmp);
			}
			if ($remarks != $_data['remarks']) {
				$tmp = 'service_requests_remarks::'.$_data['remarks'].'=='.$remarks;
				array_push($change_logs, $tmp);
			}
      
			$sql = $pdo->prepare("UPDATE service_requests SET
				service = :service,
				unit_id = :unit_id,
				description = :description,
				assessment = :assessment,
				remarks = :remarks	
			WHERE id =".$id);
			$sql->bindParam(":service", $service);
			$sql->bindParam(":unit_id", $unit_id);
			$sql->bindParam(":description", $description);
			$sql->bindParam(":assessment", $assessment);
			$sql->bindParam(":remarks", $remarks);

			if (count($change_logs > 0)) {
				$sql->execute();
			}

			$service_id = $_POST['id'];
			$date = $_POST['date'];

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

            	$sql = $pdo->prepare("SELECT * FROM ".$table." WHERE target_id = :target_id");
            	$sql->bindParam(":target_id", $service_id);
            	$sql->execute();
            	if ($sql->rowCount()) {

	            	$data2 = $sql->fetch(PDO::FETCH_ASSOC);
	            	$order_no = $data2[$remark.'_no'];

	            	$sql = $pdo->prepare("UPDATE ".$table." SET 
	            		unit_id = :unit_id,
						target_id = :target_id,
						".$remark."_no = :".$remark."_no,
						requestor_account_mode = :requestor_account_mode,
						".$remark."_date = :".$remark."_date,
						".$remark."_nature = :".$remark."_nature,
						".$remark."_description = :".$remark."_description
					WHERE ".$remark."_no = :".$remark."_no");
					$sql->bindParam(":unit_id", $unit_id);
					$sql->bindParam(":target_id", $service_id);
					$sql->bindParam(":".$remark."_no", $order_no);
					$sql->bindParam(":requestor_account_mode", $requestor_type);
					$sql->bindParam(":".$remark."_date", $date);
					$sql->bindParam(":".$remark."_nature", $service);
					$sql->bindParam(":".$remark."_description", $description);
					$sql->execute();


	           } else {
	           	
					$sql = $pdo->prepare("SELECT ".$remark."_no FROM ".$table." ORDER BY id DESC LIMIT 1");
					$sql->execute();
					if($sql->rowCount()) {
						$data = $sql->fetch(PDO::FETCH_ASSOC);
						$id_suggestion = $data[''.$remark.'_no'] + 1;
					} else {
						$id_suggestion = 1001;
					}

						$sql = $pdo->prepare("INSERT INTO ".$table." ( 
								target_id,
								target_category,
								".$remark."_no,
								requestor_account_mode,
								".$remark."_date,
								".$remark."_nature,
								".$remark."_description
						) VALUES (
								:target_id,
								:target_category,
								:".$remark."_no,
								:requestor_account_mode,
								:".$remark."_date,
								:".$remark."_nature,
								:".$remark."_description

						)");
							$sql->bindParam(":target_id", $service_id);
							$sql->bindParam(":target_category", $target_category);
							$sql->bindParam(":".$remark."_no", $id_suggestion);
							$sql->bindParam(":requestor_account_mode", $requestor_type);
							$sql->bindParam(":".$remark."_date", $date);
							$sql->bindParam(":".$remark."_nature", $service);
							$sql->bindParam(":".$remark."_description", $description);
							$sql->execute();

	          	}

			// record to system log
	        $change_log = implode(';;',$change_logs);
			systemLog('service_requests',$id,'update',$change_log);

			$employees = getTable("employees");
			$users = getTable("users");
			foreach ($employees as $employee) {
				push_notification('service-requests',$id,$employee['id'],'employee','service_requests_updated_to_'.$table);
			}
			foreach ($users as $user) {
				push_notification('service-requests',$id,$user['id'],'user','service_requests_updated_to_'.$table);
			}

			$_SESSION['sys_service_requests_edit_suc'] = renderLang($service_requests_updated);
			header('location: /service-requests');
			
		} else { // error found
			
			$_SESSION['sys_service_requests_edit_err'] = renderLang($form_error);
			header('location: /service-request');
			
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