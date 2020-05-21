<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('calibration-monitoring-edit')) {
	
		$err = 0;
		
		// PROCESS FORM
		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM calibrations WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }

		//STATUS
        $status = 0;
        if (isset($_POST['status'])) {
        	$status = trim($_POST['status']);
        }

        //PREPARED BY
        $prepared_by = '';
        if (isset($_POST['prepared_by'])) {
        	$prepared_by = trim($_POST['prepared_by']);
        }

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
		// MONITORING IDS
		$monitoring_ids = array();
		if(isset($_POST['monitoring_id'])) {
			$monitoring_ids = $_POST['monitoring_id'];
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($status != $_data['status']) {
				$tmp = 'calibration_status::'.$_data['status'].'=='.$status;
				array_push($change_logs,$tmp);
			}

			if (count($change_logs) > 0) {
      
				$sql = $pdo->prepare("UPDATE calibrations SET
					prepared_by = :prepared_by,
					approved_by = :approved_by,
					status = :status
				WHERE id = :id");
				$sql->bindParam(":id", $id);
				$sql->bindParam(":prepared_by", $prepared_by);
				$sql->bindParam(":approved_by", $approved_by);
				$sql->bindParam(":status", $status);
				$sql->execute();

			}

			foreach ($monitoring_ids as $key => $monitoring_id) {


				$sql1 = $pdo->prepare("SELECT * FROM calibration_monitoring WHERE id = :m_id");
				$sql1->bindParam(":m_id", $monitoring_id);
				$sql1->execute();
				if($sql1->rowCount()) {

                    $_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                    if ($category[$key] != $_data1['category']) {
                    	$tmp = 'calibration_category::'.$_data1['category'].'=='.$category[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($equipment[$key] != $_data1['equipment']) {
                    	$tmp = 'calibration_equipment::'.$_data1['equipment'].'=='.$equipment[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($brand[$key] != $_data1['brand']) {
                    	$tmp = 'calibration_brand::'.$_data1['brand'].'=='.$brand[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($serial_number[$key] != $_data1['serial_number']) {
                    	$tmp = 'calibration_serial_no::'.$_data1['serial_number'].'=='.$serial_number[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($date_calibrated[$key] != $_data1['date_calibrated']) {
                    	$tmp = 'calibration_date_calibrated::'.$_data1['date_calibrated'].'=='.$date_calibrated[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($frequency[$key] != $_data1['frequency']) {
                    	$tmp = 'calibration_frequency::'.$_data1['frequency'].'=='.$frequency[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($accepted_tolerance[$key] != $_data1['accepted_tolerance']) {
                    	$tmp = 'calibration_accepted_tolerance::'.$_data1['accepted_tolerance'].'=='.$accepted_tolerance[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($next_calibration_date[$key] != $_data1['next_calibration_date']) {
                    	$tmp = 'calibration_next_calibration_date::'.$_data1['next_calibration_date'].'=='.$next_calibration_date[$key];
                    	array_push($change_logs,$tmp);
                    }

                    if (count($change_logs) > 0) {

						$sql2 = $pdo->prepare("UPDATE calibration_monitoring SET
							calibration_id = :calibration_id,
							category = :category,
							equipment = :equipment,
							brand = :brand,
							serial_number = :serial_number,
							date_calibrated = :date_calibrated,
							frequency = :frequency,
							accepted_tolerance = :accepted_tolerance,
							next_calibration_date = :next_calibration_date
						WHERE id = :monitoring_id");
						$sql2->bindParam(":monitoring_id", $monitoring_id);
						$sql2->bindParam(":calibration_id", $id);
						$sql2->bindParam(":category", $category[$key]);
						$sql2->bindParam(":equipment", $equipment[$key]);
						$sql2->bindParam(":brand", $brand[$key]);
						$sql2->bindParam(":serial_number", $serial_number[$key]);
						$sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
						$sql2->bindParam(":frequency", $frequency[$key]);
						$sql2->bindParam(":accepted_tolerance", $accepted_tolerance[$key]);
						$sql2->bindParam(":next_calibration_date", $next_calibration_date[$key]);
						$sql2->execute();

                    }
				} else {

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

					if (!empty($equipment[$key])) {

						$sql2->bindParam(":calibration_id", $id);
						$sql2->bindParam(":category", $category[$key]);
						$sql2->bindParam(":equipment", $equipment[$key]);
						$sql2->bindParam(":brand", $brand[$key]);
						$sql2->bindParam(":serial_number", $serial_number[$key]);
						$sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
						$sql2->bindParam(":frequency", $frequency[$key]);
						$sql2->bindParam(":accepted_tolerance", $accepted_tolerance[$key]);
						$sql2->bindParam(":next_calibration_date", $next_calibration_date[$key]);
						$sql2->execute();

					}

				}
			}

			//system log
			$change_log = implode(';;',$change_logs);
			systemLog('calibration',$id,'update',$change_log);

			//notification add calibration monitoring
			$employees = getTable("employees");
			$users = getTable("users");
				foreach ($employees as $employee) {
					push_notification('calibration-monitoring', $id, $employee['id'], 'employee', 'calibration_monitoring_updated');
				}
				foreach ($users as $user) {
					push_notification('calibration-monitoring', $id, $user['id'], 'user', 'calibration_monitoring_updated');
				}

			$_SESSION['sys_calibration_monitoring_edit_suc'] = renderLang($calibration_monitoring_updated);
			header('location: /calibration-list');
			
		} else { // error found
			
			$_SESSION['sys_mail_logs_edit_err'] = renderLang($form_error);
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