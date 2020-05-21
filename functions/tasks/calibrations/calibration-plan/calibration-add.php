<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('calibration-plan-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		$calibration_category = $_POST['calibration_category'];

		//STATUS
        $status = 0;
        if (isset($_POST['status'])) {
        	$status = trim($_POST['status']);
        }

		// sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        //PREPARED BY
        $prepared_by = $_SESSION['sys_id'];

        $account_mode = $_SESSION['sys_account_mode'];

		// INSTRUMENT
		$instruments = array();
		if(isset($_POST['instrument'])) {
			$instruments = $_POST['instrument'];
			
		}

		// BRAND
		$brand = array();
		if(isset($_POST['brand'])) {
			$brand = $_POST['brand'];
			
		}

		// SERIAL NUMBER
		$serial_number = array();
		if(isset($_POST['serial_number'])) {
			$serial_number = $_POST['serial_number'];
			
		}

		// DATE CALIBRATED
		$date_calibrated = array();
		if(isset($_POST['date_calibrated'])) {
			$date_calibrated = $_POST['date_calibrated'];
			
		}

		// DUE DATE CALIBRATION
		$due_date_calibration = array();
		if(isset($_POST['due_date_calibration'])) {
			$due_date_calibration = $_POST['due_date_calibration'];
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$curr_date = formatDate(time(), true, false);
      
			$sql = $pdo->prepare("INSERT INTO calibrations (
				sub_property_id,
				prepared_by,
				category,
				date_created,
				status,
				account_mode
			) VALUES (
				:sub_property_id,
				:prepared_by,
				:category,
				:date_created,
				:status,
				:account_mode
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":prepared_by", $prepared_by);
			$sql->bindParam(":category", $calibration_category);
			$sql->bindParam(":date_created", $curr_date);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":account_mode", $account_mode);
			$sql->execute();

			$id = $pdo->lastInsertId();

			$sql2 = $pdo->prepare("INSERT INTO calibration_plan (
				calibration_id,
				instrument,
				brand,
				serial_number,
				date_calibrated,
				due_date_calibration
			) VALUES (
				:calibration_id,
				:instrument,
				:brand,
				:serial_number,
				:date_calibrated,
				:due_date_calibration
			)");
			$sql2->bindParam(":calibration_id", $id);

			foreach ($instruments as $key => $instrument) {

					if (!empty($instrument)) {
						
						$sql2->bindParam(":instrument", $instrument);
						$sql2->bindParam(":brand", $brand[$key]);
						$sql2->bindParam(":serial_number", $serial_number[$key]);
						$sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
						$sql2->bindParam(":due_date_calibration", $due_date_calibration[$key]);
						$sql2->execute();

					}

			}

			//system log
			systemLog('calibration',$id,'add','');

			//notification add calibration plan
			$employees = getTable("employees");
			$users = getTable("users");
				foreach ($employees as $employee) {
					push_notification('calibration-plans', $id, $employee['id'], 'employee', 'calibration_plans_add');
				}
				foreach ($users as $user) {
					push_notification('calibration-plans', $id, $user['id'], 'user', 'calibration_plans_add');
				}

			$_SESSION['sys_calibration_plan_add_suc'] = renderLang($calibration_plan_added);
			header('location: /calibration-plans');
			
		} else { // error found
			
			$_SESSION['sys_calibration_plan_add_err'] = renderLang($form_error);
			header('location: /calibration-plan-add');
			
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