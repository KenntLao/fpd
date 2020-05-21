<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('calibration-plan-edit')) {
	
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

        //APPROVED BY
        $approved_by = '';
        if (isset($_POST['approved_by'])) {
        	$approved_by = trim($_POST['approved_by']);
        }

		// EQUIPMENT
		$instrument = array();
		if(isset($_POST['instrument'])) {
			$instrument = $_POST['instrument'];
			
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
		// PLAN IDS
		$plan_ids = array();
		if(isset($_POST['plan_id'])) {
			$plan_ids = $_POST['plan_id'];
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($status != $_data['status']) {
				$tmp = 'calibration_status::'.$_data['status'].'=='.$status;
				array_push($change_logs,$tmp);
			}

			
      
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

			foreach ($plan_ids as $key => $plan_id) {

                
                $sql1 = $pdo->prepare("SELECT * FROM calibration_plan WHERE id = :p_id");
				$sql1->bindParam(":p_id", $plan_id);
				$sql1->execute();
				if($sql1->rowCount()) {

                    $_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                    if ($instrument[$key] != $_data1['instrument']) {
                    	$tmp = 'calibration_instrument::'.$_data1['instrument'].'=='.$instrument[$key];
                    	array_push($change_logs, $tmp);
                    }
                    if ($brand[$key] != $_data1['brand']) {
                    	$tmp = 'calibration_brand::'.$_data1['brand'].'=='.$brand[$key];
                    	array_push($change_logs, $tmp);
                    }
                    if ($serial_number[$key] != $_data1['serial_number']) {
                    	$tmp = 'calibration_serial_no::'.$_data1['serial_number'].'=='.$serial_number[$key];
                    	array_push($change_logs,$tmp);
                    }
                    if ($date_calibrated[$key] != $_data1['date_calibrated']) {
                        $tmp = 'calibration_date_calibrated::'.$_data1['date_calibrated'].'=='.$date_calibrated[$key];
                        array_push($change_logs,$tmp);
                    }
                    if ($due_date_calibration[$key] != $_data1['due_date_calibration']) {
                        $tmp = 'calibration_due_date_of_calibration::'.$_data1['due_date_calibration'].'=='.$due_date_calibration[$key];
                        array_push($change_logs,$tmp);
                    }

                    $sql2 = $pdo->prepare("UPDATE calibration_plan SET
                        calibration_id = :calibration_id,
                        instrument = :instrument,
                        brand = :brand,
                        serial_number = :serial_number,
                        date_calibrated = :date_calibrated,
                        due_date_calibration = :due_date_calibration
                    WHERE id = :plan_id");
                    $sql2->bindParam(":plan_id", $plan_id);
                    $sql2->bindParam(":calibration_id", $id);
                    $sql2->bindParam(":instrument", $instrument[$key]);
                    $sql2->bindParam(":brand", $brand[$key]);
                    $sql2->bindParam(":serial_number", $serial_number[$key]);
                    $sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
                    $sql2->bindParam(":due_date_calibration", $due_date_calibration[$key]);
                    $sql2->execute();

				} else {

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
						:serial_no,
						:date_calibrated,
						:due_date_calibration
					)");

					if (!empty($instrument[$key])) {

						$sql2->bindParam(":calibration_id", $id);
						$sql2->bindParam(":instrument", $instrument[$key]);
						$sql2->bindParam(":brand", $brand[$key]);
						$sql2->bindParam(":serial_no", $serial_no[$key]);
						$sql2->bindParam(":date_calibrated", $date_calibrated[$key]);
						$sql2->bindParam(":due_date_calibration", $due_date_calibration[$key]);
						$sql2->execute();

					}

				}
            }
            
            if (count($change_logs) > 0) {
                
                var_dump($change_logs);

                // //system log
                $change_log = implode(';;',$change_logs);
                systemLog('calibration',$id,'update',$change_log);

                //notification add calibration monitoring
                $employees = getTable("employees");
                $users = getTable("users");
                foreach ($employees as $employee) {
                    push_notification('calibration-plans', $id, $employee['id'], 'employee', 'calibration_plans_updated');
                }
                foreach ($users as $user) {
                    push_notification('calibration-plans', $id, $user['id'], 'user', 'calibration_plans_updated');
                }

                $_SESSION['sys_calibration_plan_edit_suc'] = renderLang($calibration_plan_updated);
                // header('location: /calibration-plans');

            } else {
                $_SESSION['sys_calibration_plan_edit_err'] = renderLang($form_no_changes);
                header('location: /calibration-plan-edit/'.$id);
            }
			
		} else { // error found
			
			$_SESSION['sys_calibration_plan_edit_err'] = renderLang($form_error);
			header('location: /calibration-plan-edit/'.$id);
			
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