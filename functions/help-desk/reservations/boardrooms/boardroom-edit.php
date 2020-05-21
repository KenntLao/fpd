<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('boardroom-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// PROCESS FORM

		// DATE
		$date_reserve = '';
		if(isset($_POST['date_reserve'])) {
			$date_reserve = trim($_POST['date_reserve']);
			$_SESSION['sys_boardroom_edit_date_reserve_val'] = $date_reserve;
			
		}

		$time_from = '';
		if(isset($_POST['time_from'])) {
			$time_from = trim($_POST['time_from']);
			$_SESSION['sys_boardroom_edit_time_from_val'] = $time_from;
			
		}

		$time_to = '';
		if(isset($_POST['time_to'])) {
			$time_to = trim($_POST['time_to']);
			$_SESSION['sys_boardroom_edit_time_to_val'] = $time_to;
			
		}

		// department
		$department = '';
		if(isset($_POST['department'])) {
			$department = trim($_POST['department']);
			$_SESSION['sys_boardroom_edit_department_val'] = $department;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = trim($_POST['purpose']);
			$_SESSION['sys_boardroom_edit_purpose_val'] = $purpose;
			
		}

		// RESERVED BY
		$reserved_by = '';
		if(isset($_POST['reserved_by'])) {
			$reserved_by = trim($_POST['reserved_by']);
			$_SESSION['sys_boardroom_edit_reserved_by_val'] = $reserved_by;
			
		}

		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_boardroom_edit_status_val'] = $status;
			
		}
		// ROOM
		$room = '';
		if(isset($_POST['room'])) {
			$room = trim($_POST['room']);
			$_SESSION['sys_boardroom_edit_room_val'] = $room;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("UPDATE boardrooms SET
				date_reserve = :date_reserve,
				time_from = :time_from,
				time_to = :time_to,
				department = :department,
				purpose = :purpose,
				reserved_by = :reserved_by,
				status = :status,
				room = :room
			WHERE id = ".$id);
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

			$_SESSION['sys_boardroom_edit_suc'] = renderLang($boardrooms_updated);
			header('location: /boardrooms');
			
		} else { // error found
			
			$_SESSION['sys_boardroom_edit_err'] = renderLang($form_error);
			header('location: /edit-boardroom');
			
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