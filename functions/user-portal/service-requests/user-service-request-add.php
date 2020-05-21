<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
		$err = 0;
		$table = '';
		$on = '';
		$where = '';
		$status = 0;	
		// PROCESS FORM

		// DATE
		$complaint_stamp = time();

		// COMPLAINANT
		$complainant = $_SESSION['sys_id'];

		// LOCATION
		$account_type = $_SESSION['sys_account_mode'];

		if ($account_type== 'unit_owner') {
			$table = 'unit_owners';
			$on = 'ON t.id = u.unit_owner_id';
			$where = 'WHERE t.id = '.$complainant;
		}else{
			$table = 'unit_tenants';
			$on = 'ON t.unit_id = u.id JOIN tenants te ON t.tenant_id = te.id';
			$where = 'WHERE t.tenant_id = '.$complainant;
		}


		$sql = $pdo->prepare("SELECT u.id FROM ".$table." t JOIN units u  ".$on." ".$where." LIMIT 1");
		$sql->execute();

		$data = $sql->fetch(PDO::FETCH_ASSOC);
		 if ($sql->rowCount()) {

		 	// UNIT NO
		 	$unit_no = $data['id'];
		 }else{
		 	$unit_no = 0;
		 }

		// SERVICE
		$service = '';
		if(isset($_POST['service'])) {
			$service = ucwords(strtolower(trim($_POST['service'])));
			$_SESSION['sys_sys_service_requests_add_service_val'] = $service;
			
		}

		// DESCRIPTION
		$description = '';
		if(isset($_POST['description'])) {
			$description = ucwords(strtolower(trim($_POST['description'])));
			$_SESSION['sys_sys_service_requests_add_description_val'] = $description;
			
		}

		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO service_requests (
				date,
				unit_id,
				complainant,
				account_type,
				assessment,
				description,
				service
			) VALUES (
				:date,
				:unit_id,
				:complainant,
				:account_type,
				:assessment,
				:description,
				:service
				
			)");
			$sql->bindParam(":date", $complaint_stamp);
			$sql->bindParam(":unit_id", $unit_no);
			$sql->bindParam(":complainant", $complainant);
			$sql->bindParam(":account_type", $account_type);
			$sql->bindParam(":assessment", $assessment);
			$sql->bindParam(":description", $description);
			$sql->bindParam(":service", $service);
			$sql->execute();

			$id = $pdo->lastInsertId();

			
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_sys_service_requests_add_suc'] = renderLang($service_requests_added);
			header('location: /user-service-requests');
			
		} else { // error found
			
			$_SESSION['sys_sys_service_requests_add_err'] = renderLang($form_error);
			header('location: /add-user-service-request');
			
		}
		
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>