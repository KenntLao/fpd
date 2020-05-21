<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// PROJECT NAME
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			$_SESSION['sys_notice_to_proceed_add_date_val'] = $date;
			
		}

		// remarks
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_notice_to_proceed_add_remarks_val'] = $remarks;
			
		}
		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_notice_to_proceed_add_status_val'] = $status;
			
		}		
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO notice_to_proceed (
				prospect_id,
				date,
				status,
				attachment,
				remarks
			) VALUES (
				:prospect_id,
				:date,
				:status,
				:attachment,
				:remarks
				
			)");
			$sql->bindParam(":prospect_id", $prospect_id);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":remarks", $remarks);

			// attachment
			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            if(!is_dir($sys_upload_dir.'notice-to-proceeds')) {
                mkdir($sys_upload_dir.'notice-to-proceeds', 0755, true);
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
                    move_uploaded_file($file_tmp, $sys_upload_dir.'notice-to-proceeds/'.$attachment_name);

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
			
			// record to system log
			systemLog('notice_to_proceed',$id,'add','');

			// notification add NOTICE TO PROCEED
			$employees = getTable('employees');
			$users = getTable('users');
            foreach ($employees as $employee) {
                push_notification('notice-to-proceed', $id, $employee['id'], 'employee', 'notice_to_proceed_add');
            }
            foreach ($users as $user) {
                push_notification('notice-to-proceed', $id, $user['id'], 'user', 'notice_to_proceed_add');
            }

			$_SESSION['sys_notice_to_proceed_add_suc'] = renderLang($notice_to_proceed_added);
			header('location: /notice-to-proceed-list' );
			
		} else { // error found
			
			$_SESSION['sys_notice_to_proceed_add_err'] = renderLang($form_error);
			header('location: /add-notice-to-proceed');
			
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