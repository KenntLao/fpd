<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('amenity-add')) {
	
		$err = 0;
		
		// PROCESS FORM

        // sub_property_id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
        }

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			$_SESSION['sys_amenities_add_date_val'] = $date;
			
		}

		// VENUE
		$venue = '';
		if(isset($_POST['venue'])) {
			$venue = trim($_POST['venue']);
			$_SESSION['sys_amenities_add_venue_val'] = $venue;
			
		}

		// SUBJECT 
		$subject = '';
		if(isset($_POST['subject'])) {
			$subject = trim($_POST['subject']);
			$_SESSION['sys_amenities_add_subject_val'] = $subject;
			
		}

		// PROJECT NAME
		$project_name = '';
		if(isset($_POST['project_name'])) {
			$project_name = trim($_POST['project_name']);
			$_SESSION['sys_amenities_add_project_name_val'] = $project_name;
			
		}


		// TIME STARTED/END
		$time_started_end = '';
		if(isset($_POST['time_started_end'])) {
			$time_started_end = trim($_POST['time_started_end']);
			$_SESSION['sys_amenities_add_time_started_end_val'] = $time_started_end;
			
		}

		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_amenities_add_status_val'] = $status;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO amenities (
				sub_property_id,
				date,
				venue,
				subject,
				project_name,
				time_started_end,
				status
			) VALUES (
				:sub_property_id,
				:date,
				:venue,
				:subject,
				:project_name,
				:time_started_end,
				:status
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":venue", $venue);
			$sql->bindParam(":subject", $subject);
			$sql->bindParam(":project_name", $project_name);
			$sql->bindParam(":time_started_end", $time_started_end);
			$sql->bindParam(":status", $status);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_amenities_add_suc'] = renderLang($amenities_reservation_added);
			header('location: /amenities');
			
		} else { // error found
			
			$_SESSION['sys_amenities_add_err'] = renderLang($form_error);
			header('location: /add-amenity');
			
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