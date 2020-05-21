<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('minutes-of-meeting-edit')) {
	
		$err = 0;

		$id = $_POST['id'];

		$sql = $pdo->prepare("SELECT * FROM minutes_of_meetings WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }

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
			
		}

		// REMARK
		$mom_remarks = '';
		if(isset($_POST['mom_remarks'])) {
			$mom_remarks = trim($_POST['mom_remarks']);
			
		}

		// TYPE OF MEETING
		$type_of_meeting = '';
		if(isset($_POST['type_of_meeting'])) {
			$type_of_meeting = trim($_POST['type_of_meeting']);
			
		}

		// DATE
		$date_reserve = '';
		if(isset($_POST['date_reserve'])) {
			$date_reserve = trim($_POST['date_reserve']);
			
		}

		$time_from = '';
		if(isset($_POST['time_from'])) {
			$time_from = trim($_POST['time_from']);
			
		}

		$time_to = '';
		if(isset($_POST['time_to'])) {
			$time_to = trim($_POST['time_to']);
			
		}


		// RESERVED BY
		$reviewed_by = '';
		if(isset($_POST['reviewed_by'])) {
			$reviewed_by = trim($_POST['reviewed_by']);
			
		}

		// PREPARED BY
		$prepared_by = '';
		if(isset($_POST['prepared_by'])) {
			$prepared_by = trim($_POST['prepared_by']);
			
		}

		// APPROVED BY
		$approved_by = '';
		if(isset($_POST['approved_by'])) {
			$approved_by = trim($_POST['approved_by']);
			
		}

		// ORDER BY
		$order_by = '';
		if(isset($_POST['order_by'])) {
			$order_by = trim($_POST['order_by']);
			
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


		// attendees id
		$attendees_ids = array();
		if(isset($_POST['attendees_id'])) {
			$attendees_ids = $_POST['attendees_id'];
			
		}


		// action_plan_id
		$action_plan_ids = array();
		if(isset($_POST['action_plan_id'])) {
			$action_plan_ids = $_POST['action_plan_id'];
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($department_id != $_data['department_id']) {
				$tmp = 'mom_department::'.$_data['department_id'].'=='.$department_id;
				array_push($change_logs, $tmp);
			}
			if ($property_id != $_data['property_id']) {
				$tmp = 'mom_project_name::'.$_data['property_id'].'=='.$property_id;
				array_push($change_logs, $tmp);
			}
			if ($subject != $_data['subject']) {
				$tmp = 'mom_subject::'.$_data['subject'].'=='.$subject;
				array_push($change_logs, $tmp);
			}
			if ($venue != $_data['venue']) {
				$tmp = 'mom_venue::'.$_data['venue'].'=='.$venue;
				array_push($change_logs,$tmp);
			}
			if ($mom_remarks != $_data['remarks']) {
				$tmp = 'mom_remarks::'.$_data['remarks'].'=='.$mom_remarks;
				array_push($change_logs,$tmp);
			}
			if ($type_of_meeting != $_data['type_of_meeting']) {
				$tmp = 'mom_type_of_meeting::'.$_data['type_of_meeting'].'=='.$type_of_meeting;
				array_push($change_logs,$tmp);
			}
			if ($time_to != $_data['time_to']) {
				$tmp = 'boardrooms_time_to::'.$_data['time_to'].'=='.$time_to;
				array_push($change_logs,$tmp);
			}
			if ($time_from != $_data['time_from']) {
				$tmp = 'boardrooms_time_from::'.$_data['time_from'].'=='.$time_from;
				array_push($change_logs,$tmp);
			}
			if ($date_reserve != $_data['date_reserve']) {
				$tmp = 'boardrooms_date::'.$_data['date_reserve'].'=='.$date_reserve;
				array_push($change_logs,$tmp);
			}
			if ($reviewed_by != $_data['reviewed_by']) {
				$tmp = 'mom_reviewed_by::'.$_data['reviewed_by'].'=='.$reviewed_by;
				array_push($change_logs,$tmp);
			}
			if ($prepared_by != $_data['prepared_by']) {
				$tmp = 'mom_prepared_by::'.$_data['prepared_by'].'=='.$prepared_by;
				array_push($change_logs,$tmp);
			}
			if ($approved_by != $_data['approved_by']) {
				$tmp = 'mom_approved_by::'.$_data['approved_by'].'=='.$approved_by;
				array_push($change_logs,$tmp);
			}
			if ($order_by != $_data['order_by']) {
				$tmp = 'mom_called_by::'.$_data['order_by'].'=='.$order_by;
				array_push($change_logs,$tmp);
			}

      		// INSERT 	
			$sql = $pdo->prepare("UPDATE minutes_of_meetings SET
				department_id = :department_id,
				property_id = :property_id,
				subject = :subject,
				venue = :venue,
				remarks = :mom_remarks,
				type_of_meeting = :type_of_meeting,
				time_to = :time_to,
				time_from = :time_from,
				date_reserve = :date_reserve,
				reviewed_by = :reviewed_by,
				prepared_by = :prepared_by,
				approved_by = :approved_by,
				order_by = :order_by,
				mom_category = :mom_category,
				attachment = :attachment
			WHERE id = :id");
			$sql->bindParam(":id", $id);
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
            if($attachment_count > 0) {

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
            }

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = getField('attachment', 'minutes_of_meetings', 'id = '.$id);
            }

            // attachment change log
            if ($attachment_name != $_data['attachment']) {
                $tmp = 'move_inout_requests_attachment::'.$_data['attachment'].'=='.$attachment_name;
                array_push($change_logs,$tmp);
            }

            $sql->bindParam(":attachment", $attachment_name);

            if (count($change_logs) > 0) {

				$sql->execute();

			}

			foreach ($attendees_ids as $key2 => $attendees_id) {

				$sql1 = $pdo->prepare("SELECT * FROM mom_attendees WHERE id = :id");
				$sql1->bindParam(":id", $attendees_id);
				$sql1->execute();
				if ($sql1->rowcount()) {

					$_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

					if ($name[$key2] != $_data1['name']) {
						$tmp = 'mom_name::'.$_data1['name'].'=='.$name[$key2];
						array_push($change_logs,$tmp);
					}
					if ($position[$key2] != $_data1['position']) {
						$tmp = 'mom_position::'.$_data1['position'].'=='.$position[$key2];
						array_push($change_logs,$tmp);
					}

					if (count($change_logs) > 0) {

						$sql = $pdo->prepare("UPDATE mom_attendees SET
							mom_id = :mom_id,
							name = :name,
							position = :position
						WHERE id = :id");
							$sql->bindParam(":id", $attendees_id);
							$sql->bindParam(":mom_id", $id);
							$sql->bindParam(":name", $name[$key2]);
							$sql->bindParam(":position", $position[$key2]);
							$sql->execute();

					}

				} else {// INSERT TO mom_attendees

					$sql = $pdo->prepare("INSERT INTO mom_attendees (
						mom_id,
						name,
						position
					) VALUES (
						:mom_id,
						:name,
						:position 
					)");
					if (!empty($name[$key2])) {
						$sql->bindParam(":mom_id", $id);
						$sql->bindParam(":name", $name[$key2]);
						$sql->bindParam(":position", $position[$key2]);
						$sql->execute();
					}
				}

			}

			foreach ($action_plan_ids as $key => $action_plan_id) {

				$sql1 = $pdo->prepare("SELECT * FROM mom_action_plan WHERE id = :id");
				$sql1->bindParam(":id", $action_plan_id);
				$sql1->execute();
				if ($sql1->rowcount()) {

					$_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

					if ($details[$key] != $_data1['details']) {
						$tmp = 'mom_details::'.$_data1['details'].'=='.$details[$key];
						array_push($change_logs,$tmp);
					}
					if ($action_plan_status[$key] != $_data1['action_plan_status']) {
						$tmp = 'mom_action_plan_status::'.$_data1['action_plan_status'].'=='.$action_plan_status[$key];
						array_push($change_logs,$tmp);
					}
					if ($responsible_party[$key] != $_data1['responsible_party']) {
						$tmp = 'mom_responsible_party::'.$_data1['responsible_party'].'=='.$responsible_party[$key];
						array_push($change_logs,$tmp);
					}
					if ($due_date[$key] != $_data1['due_date']) {
						$tmp = 'mom_due_date::'.$_data1['due_date'].'=='.$due_date[$key];
						array_push($change_logs,$tmp);
					}
					if ($remarks[$key] != $_data1['remarks']) {
						$tmp = 'mom_remarks::'.$_data1['remarks'].'=='.$remarks[$key];
						array_push($change_logs,$tmp);
					}

					if (count($change_logs) > 0) {

						$sql = $pdo->prepare("UPDATE mom_action_plan SET
							mom_id = :mom_id,
							details = :details,
							action_plan_status = :action_plan_status,
							responsible_party = :responsible_party,
							due_date = :due_date,
							remarks = :remarks
						WHERE id = :id");
						$sql->bindParam(":id", $action_plan_id);
						$sql->bindParam(":mom_id", $id);
						$sql->bindParam(":details", $details[$key]);
						$sql->bindParam(":action_plan_status", $action_plan_status[$key]);
						$sql->bindParam(":responsible_party", $responsible_party[$key]);
						$sql->bindParam(":due_date", $due_date[$key]);
						$sql->bindParam(":remarks", $remarks[$key]);
						$sql->execute();

					}

				} else {// INSERT TO mom_action_plan

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

					if (!empty($details[$key])) {
						$sql->bindParam(":mom_id", $id);
						$sql->bindParam(":details", $details[$key]);
						$sql->bindParam(":action_plan_status", $action_plan_status[$key]);
						$sql->bindParam(":responsible_party", $responsible_party[$key]);
						$sql->bindParam(":due_date", $due_date[$key]);
						$sql->bindParam(":remarks", $remarks[$key]);
						$sql->execute();
					}

				}
			

			
			}
			
			// record to system log
			$change_log = implode(';;',$change_logs);
			systemLog('minutes_of_meeting',$id,'update',$change_log);

			//notification add MOM
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('minutes-of-meeting', $id, $employee['id'], 'employee', 'minutes_of_meeting_updated');
				}
				foreach ($users as $user) {
					push_notification('minutes-of-meeting', $id, $user['id'], 'user', 'minutes_of_meeting_updated');
				}

			$_SESSION['sys_mom_edit_suc'] = renderLang($minutes_of_meeting_updated);
			header('location: /minutes-of-meeting-list');
			
		} else { // error found
			
			$_SESSION['sys_mom_add_err'] = renderLang($form_error);
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