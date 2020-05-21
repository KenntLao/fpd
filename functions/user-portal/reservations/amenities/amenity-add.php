<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	
		$err = 0;
		
		// PROCESS FORM

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = ucwords(strtolower(trim($_POST['date'])));
			$_SESSION['sys_user_amenities_add_date_val'] = $date;
			
		}

		// VENUE
		$venue = '';
		if(isset($_POST['venue'])) {
			$venue = ucwords(strtolower(trim($_POST['venue'])));
			$_SESSION['sys_user_amenities_add_venue_val'] = $venue;
			
		}

		// SUBJECT 
		$subject = '';
		if(isset($_POST['subject'])) {
			$subject = ucwords(strtolower(trim($_POST['subject'])));
			$_SESSION['sys_user_amenities_add_subject_val'] = $subject;
			
		}

		// PROJECT NAME
		$project_name = '';
		if(isset($_POST['project_name'])) {
			$project_name = trim($_POST['project_name']);
			$_SESSION['sys_user_amenities_add_project_name_val'] = $project_name;
			
		}


		// TIME STARTED/END
		$time_started_end = '';
		if(isset($_POST['time_started_end'])) {
			$time_started_end = ucwords(strtolower(trim($_POST['time_started_end'])));
			$_SESSION['sys_user_amenities_add_time_started_end_val'] = $time_started_end;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO amenities (
				date,
				venue,
				subject,
				project_name,
				time_started_end
			) VALUES (
				:date,
				:venue,
				:subject,
				:project_name,
				:time_started_end
			)");
			$sql->bindParam(":date", $date);
			$sql->bindParam(":venue", $venue);
			$sql->bindParam(":subject", $subject);
			$sql->bindParam(":project_name", $project_name);
			$sql->bindParam(":time_started_end", $time_started_end);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_user_amenities_add_suc'] = renderLang($amenities_reservation_added);
			header('location: /user-amenities');
			
		} else { // error found
			
			$_SESSION['sys_user_amenities_add_err'] = renderLang($form_error);
			header('location: /user-amenity-add');
			
		}
		
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>