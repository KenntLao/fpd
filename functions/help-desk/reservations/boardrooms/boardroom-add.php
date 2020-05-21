<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('boardroom-add')) {
	
		$err = 0;
		
		// PROCESS FORM

        // sub_property_id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
        }

		// DATE
		$date_reserve = '';
		if(isset($_POST['date_reserve'])) {
			$date_reserve = trim($_POST['date_reserve']);
			$_SESSION['sys_boardroom_add_date_reserve_val'] = $date_reserve;
			
		}

		$time_from = '';
		if(isset($_POST['time_from'])) {
			$time_from = trim($_POST['time_from']);
			$_SESSION['sys_boardroom_add_time_from_val'] = $time_from;
			
		}

		$time_to = '';
		if(isset($_POST['time_to'])) {
			$time_to = trim($_POST['time_to']);
			$_SESSION['sys_boardroom_add_time_to_val'] = $time_to;
			
		}

		// department
		$department = '';
		if(isset($_POST['department'])) {
			$department = trim($_POST['department']);
			$_SESSION['sys_boardroom_add_department_val'] = $department;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_boardroom_add_purpose_val'] = $purpose;
			
		}

		// RESERVED BY
		$reserved_by = '';
		if(isset($_POST['reserved_by'])) {
			$reserved_by = trim($_POST['reserved_by']);
			$_SESSION['sys_boardroom_add_reserved_by_val'] = $reserved_by;
			
		}

		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_boardroom_add_status_val'] = $status;
			
		}

		// ROOM
		$room = '';
		if(isset($_POST['room'])) {
			$room = trim($_POST['room']);
			$_SESSION['sys_boardroom_add_room_val'] = $room;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO boardrooms (
				sub_property_id,
				date_reserve,
				time_from,
				time_to,
				department,
				purpose,
				reserved_by,
				status,
				room
			) VALUES (
				:sub_property_id,
				:date_reserve,
				:time_from,
				:time_to,
				:department,
				:purpose,
				:reserved_by,
				:status,
				:room
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":date_reserve", $date_reserve);
			$sql->bindParam(":time_from", $time_from);
			$sql->bindParam(":time_to", $time_to);
			$sql->bindParam(":department", $department);
			$sql->bindParam(":purpose", $purpose);
			$sql->bindParam(":reserved_by", $reserved_by);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":room", $room);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_boardroom_add_suc'] = renderLang($boardrooms_boardroom_reservation_added);
			header('location: /boardrooms');
			
		} else { // error found
			
			$_SESSION['sys_contract_add_err'] = renderLang($form_error);
			header('location: /boardrooms');
			
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