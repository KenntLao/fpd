<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('minutes-of-meeting-add')) {
	
		$err = 0;

		if (checkPermission('minutes-of-meeting-departments')){
			$mom_category = 0;
		}
		if (checkPermission('minutes-of-meeting-properties')){
			$mom_category = 1;
		}
		// PROCESS FORM

		// department
		$department_id = '';
		if(isset($_POST['department_id'])) {
			$department_id = trim($_POST['department_id']);
			
		}

		// Properties
		$property_id = '';
		if(isset($_POST['property_id'])) {
			$property_id = trim($_POST['property_id']);
			
		}

		// SUBJECT
		$subject = '';
		if(isset($_POST['subject'])) {
			$subject = trim($_POST['subject']);
			$_SESSION['sys_mom_add_subject_val'] = $subject;
			
		}

		// VENUE
		$venue = '';
		if(isset($_POST['venue'])) {
			$venue = trim($_POST['venue']);
			$_SESSION['sys_mom_add_venue_val'] = $venue;
			
		}

		// REMARK
		$mom_remarks = '';
		if(isset($_POST['mom_remarks'])) {
			$mom_remarks = trim($_POST['mom_remarks']);
			$_SESSION['sys_mom_add_mom_remarks_val'] = $mom_remarks;
			
		}

		// TYPE OF MEETING
		$type_of_meeting = '';
		if(isset($_POST['type_of_meeting'])) {
			$type_of_meeting = trim($_POST['type_of_meeting']);
			$_SESSION['sys_mom_add_type_of_meeting_val'] = $type_of_meeting;
			
		}

		// DATE
		$date_reserve = '';
		if(isset($_POST['date_reserve'])) {
			$date_reserve = trim($_POST['date_reserve']);
			$_SESSION['sys_mom_add_date_reserve_val'] = $date_reserve;
			
		}

		$time_from = '';
		if(isset($_POST['time_from'])) {
			$time_from = trim($_POST['time_from']);
			$_SESSION['sys_mom_add_time_from_val'] = $time_from;
			
		}

		$time_to = '';
		if(isset($_POST['time_to'])) {
			$time_to = trim($_POST['time_to']);
			$_SESSION['sys_mom_add_time_to_val'] = $time_to;
			
		}


		// RESERVED BY
		$reviewed_by = '';
		if(isset($_POST['reviewed_by'])) {
			$reviewed_by = trim($_POST['reviewed_by']);
			$_SESSION['sys_mom_add_reviewed_by_val'] = $reviewed_by;
			
		}

		// PREPARED BY
		$prepared_by = '';
		if(isset($_POST['prepared_by'])) {
			$prepared_by = trim($_POST['prepared_by']);
			$_SESSION['sys_mom_add_prepared_by_val'] = $prepared_by;
			
		}

		// APPROVED BY
		$approved_by = '';
		if(isset($_POST['approved_by'])) {
			$approved_by = trim($_POST['approved_by']);
			$_SESSION['sys_mom_add_approved_by_val'] = $approved_by;
			
		}

		// ORDER BY
		$order_by = '';
		if(isset($_POST['order_by'])) {
			$order_by = trim($_POST['order_by']);
			$_SESSION['sys_mom_add_order_by_val'] = $order_by;
			
		}

		// POSITION
		$position = array();
		if(isset($_POST['position'])) {
			$position = $_POST['position'];
			
		}

		// NAME
		$name = array();
		if(isset($_POST['name'])) {
			$name = $_POST['name'];
			
		}

		// DETAILS
		$details = array();
		if(isset($_POST['details'])) {
			$details = $_POST['details'];
			
		}

		// ACTION PLAN / STATUS
		$action_plan_status = array();
		if(isset($_POST['action_plan_status'])) {
			$action_plan_status = $_POST['action_plan_status'];
			
		}

		// RESPONSIBLE PARTY
		$responsible_party = array();
		if(isset($_POST['responsible_party'])) {
			$responsible_party = $_POST['responsible_party'];
			
		}

		// DUE DATE
		$due_date = array();
		if(isset($_POST['due_date'])) {
			$due_date = $_POST['due_date'];
			
		}

		// REMARKS
		$remarks = array();
		if(isset($_POST['remarks'])) {
			$remarks = $_POST['remarks'];
			
		}



		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

      		// INSERT 	
			$sql = $pdo->prepare("INSERT INTO minutes_of_meetings (

				department_id,
				property_id,
				subject,
				venue,
				remarks,
				type_of_meeting,
				time_to,
				time_from,
				date_reserve,
				reviewed_by,
				prepared_by,
				approved_by,
				order_by,
				mom_category,
				attachment

			) VALUES (

				:department_id,
				:property_id,
				:subject,
				:venue,
				:mom_remarks,
				:type_of_meeting,
				:time_to,
				:time_from,
				:date_reserve,
				:reviewed_by,
				:prepared_by,
				:approved_by,
				:order_by,
				:mom_category,
				:attachment
				
			)");
			$sql->bindParam(":department_id", $department_id);
			$sql->bindParam(":property_id", $property_id);
			$sql->bindParam(":subject", $subject);
			$sql->bindParam(":venue", $venue);
			$sql->bindParam(":mom_remarks", $mom_remarks);
			$sql->bindParam(":type_of_meeting", $type_of_meeting);
			$sql->bindParam(":time_to", $time_to);
			$sql->bindParam(":time_from", $time_from);
			$sql->bindParam(":date_reserve", $date_reserve);
			$sql->bindParam(":reviewed_by", $reviewed_by);
			$sql->bindParam(":prepared_by", $prepared_by);
			$sql->bindParam(":approved_by", $approved_by);
			$sql->bindParam(":order_by", $order_by);
			$sql->bindParam(":mom_category", $mom_category);

			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            if(!is_dir($sys_upload_dir.'minutes_of_meeting')) {
                mkdir($sys_upload_dir.'minutes_of_meeting', 0755, true);
            }

            for($i = 0; $i < $attachment_count; $i++) {

                if(!empty($_FILES['attachment']['name'][$i])) {
    
                    $file = explode('.', $_FILES['attachment']['name'][$i]);
                    $file_name = $file[0];
                    $file_ext = $file[1];
    
                    $time = time();
    
                    $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
    
                    $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                    $file_size = $_FILES['attachment']['size'][$i];
                    
                    // save file
                    move_uploaded_file($file_tmp, $sys_upload_dir.'minutes_of_meeting/'.$attachment_name);

                    $attachments_arr[] = $attachment_name;
                    
                }

            }

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = '';
            }

            $sql->bindParam(":attachment", $attachment_name);
			$sql->execute();

			$id = $pdo->lastInsertId();

			// INSERT TO mom_attendees
			$sql = $pdo->prepare("INSERT INTO mom_attendees (
				mom_id,
				name,
				position
			) VALUES (
				:mom_id,
				:name,
				:position 
			)");
			$sql->bindParam(":mom_id", $id);
			
				foreach ($name as $key => $attendees) {

					if (!empty($attendees)) {
					
						$sql->bindParam(":name", $attendees);
						$sql->bindParam(":position", $position[$key]);
						$sql->execute();
					}
				}

			// INSERT TO mom_action_plan
			$sql = $pdo->prepare("INSERT INTO mom_action_plan (
				mom_id,
				details,
				action_plan_status,
				responsible_party,
				due_date,
				remarks
			) VALUES (
				:mom_id,
				:details,
				:action_plan_status,
				:responsible_party,
				:due_date,
				:remarks
			)");
			$sql->bindParam(":mom_id", $id);

				foreach ($details as $key => $detail) {
					if (!empty($detail)) {
						$sql->bindParam(":details", $detail);
						$sql->bindParam(":action_plan_status", $action_plan_status[$key]);
						$sql->bindParam(":responsible_party", $responsible_party[$key]);
						$sql->bindParam(":due_date", $due_date[$key]);
						$sql->bindParam(":remarks", $remarks[$key]);
						$sql->execute();
					}
				}
			
			// record to system log
			systemLog('minutes_of_meeting',$id,'add','');

			//notification add MOM
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('minutes-of-meeting', $id, $employee['id'], 'employee', 'minutes_of_meeting_add');
				}
				foreach ($users as $user) {
					push_notification('minutes-of-meeting', $id, $user['id'], 'user', 'minutes_of_meeting_add');
				}

			$_SESSION['sys_mom_add_suc'] = renderLang($minutes_of_meeting_added);
			header('location: /minutes-of-meeting-list');
			
		} else { // error found
			
			$_SESSION['sys_mom_add_err'] = renderLang($form_error);
			header('location: /minutes-of-meeting-list');
			
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