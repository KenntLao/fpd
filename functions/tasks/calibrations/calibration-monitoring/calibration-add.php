<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('calibration-monitoring-add')) {
	
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
        $prepared_by = '';
        if (isset($_POST['prepared_by'])) {
        	$prepared_by = trim($_POST['prepared_by']);
        }

        $account_mode = $_SESSION['sys_account_mode'];

        //APPROVED BY
        // $approved_by = '';
        // if (isset($_POST['approved_by'])) {
        // 	$approved_by = trim($_POST['approved_by']);
        // }

		// CATEGORY
		$category = array();
		if(isset($_POST['category'])) {
			$category = $_POST['category'];
			
		}

		// EQUIPMENT
		$equipment = array();
		if(isset($_POST['equipment'])) {
			$equipment = $_POST['equipment'];
			
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

		// FREQUENCY
		$frequency = array();
		if(isset($_POST['frequency'])) {
			$frequency = $_POST['frequency'];
			
		}

		// ACCEPTED TOLERANCE
		$accepted_tolerance = array();
		if(isset($_POST['accepted_tolerance'])) {
			$accepted_tolerance = $_POST['accepted_tolerance'];
			
		}

		// NEXT CALIBRATION DATE
		$next_calibration_date = array();
		if(isset($_POST['next_calibration_date'])) {
			$next_calibration_date = $_POST['next_calibration_date'];
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$curr_date = formatDate(time(), true, false);
      
			$sql = $pdo->prepare("INSERT INTO calibrations (
				sub_property_id,
				prepared_by,
				approved_by,
				category,
				date_created,
				account_mode,
				status
			) VALUES (
				:sub_property_id,
				:prepared_by,
				:approved_by,
				:category,
				:date_created,
				:account_mode,
				:status
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":prepared_by", $prepared_by);
			$sql->bindParam(":approved_by", $approved_by);
			$sql->bindParam(":category", $calibration_category);
			$sql->bindParam(":date_created", $curr_date);
			$sql->bindParam(":account_mode", $account_mode);
			$sql->bindParam(":status", $status);
			$sql->execute();

			echo $id = $pdo->lastInsertId();

			$sql2 = $pdo->prepare("INSERT INTO calibration_monitoring (
				calibration_id,
				category,
				equipment,
				brand,
				serial_number,
				date_calibrated,
				frequency,
				accepted_tolerance,
				next_calibration_date
			) VALUES (
				:calibration_id,
				:category,
				:equipment,
				:brand,
				:serial_number,
				:date_calibrated,
				:frequency,
				:accepted_tolerance,
				:next_calibration_date
			)");
			$sql2->bindParam(":calibration_id", $id);

			foreach ($equipment as $key => $equipment_value) {

					if (!empty($category[$key])) {
						
						$sql2->bindParam(":category", $category[$key]);
						$sql2->bindParam(":equipment", $equipment_value);
						$sql2->bindParam(":brand", $brand[$key]);
						$sql2->bindParam(":serial_number", $serial_number[$key]);
						$sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
						$sql2->bindParam(":frequency", $frequency[$key]);
						$sql2->bindParam(":accepted_tolerance", $accepted_tolerance[$key]);
						$sql2->bindParam(":next_calibration_date", $next_calibration_date[$key]);
						$sql2->execute();

					}

			}

			//system log
			systemLog('calibration',$id,'add','');

			//notification add calibration monitoring
			$employees = getTable("employees");
			$users = getTable("users");
				foreach ($employees as $employee) {
					push_notification('calibration-monitoring', $id, $employee['id'], 'employee', 'calibration_monitoring_add');
				}
				foreach ($users as $user) {
					push_notification('calibration-monitoring', $id, $user['id'], 'user', 'calibration_monitoring_add');
				}

			$_SESSION['sys_calibration_monitoring_add_suc'] = renderLang($calibration_monitoring_added);
			header('location: /calibration-list');
			
		} else { // error found
			
			$_SESSION['sys_calibration_monitoring_add_err'] = renderLang($form_error);
			header('location: /add-calibration');
			
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