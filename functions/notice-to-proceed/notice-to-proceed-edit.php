<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-edit')) {
	
		$err = 0;
		
        // PROCESS FORM
        
        // NTP ID if exist
        $id = $_POST['id'];
        $sql = $pdo->prepare("SELECT * FROM notice_to_proceed WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!($sql->rowCount())) {
            $err++;
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

			$change_logs = array();
			if ($date != $_data['date']) {
				$tmp = 'notice_to_proceed_date::'.$_data['date'].'=='.$date;
				array_push($change_logs, $tmp);
			}
			if ($remarks != $_data['remarks']) {
				$tmp = 'notice_to_proceed_remarks::'.$_data['remarks'].'=='.$remarks;
				array_push($change_logs, $tmp);
			}
			if ($status != $_data['status']) {
				$tmp = 'notice_to_proceed_status::'.$_data['status'].'=='.$status;
				array_push($change_logs, $tmp);
			}
      
            $sql = $pdo->prepare("UPDATE notice_to_proceed SET 
            date = :date, 
            remarks = :remarks, 
            attachment = :attachment, 
            status = :status 
            WHERE id = :id");

            $sql->bindParam(":date", $date);
            $sql->bindParam(":status", $status);
            $sql->bindParam(":remarks", $remarks);
            $sql->bindParam(":id", $id);

            // attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);
            if($attachment_count > 0) {

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
            }

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = getField('attachment', 'notice_to_proceed', 'id = '.$id);
            }

            $sql->bindParam(":attachment", $attachment_name);

            $sql->execute();
			
			// record to system log
			$change_log = implode(';;', $change_logs);
			systemLog('notice_to_proceed',$id,'update',$change_log);

			// notification edit NOTICE TO PROCEED
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('notice-to-proceed', $id, $employee['id'], 'employee', 'notice_to_proceed_updated');
				}
				foreach ($users as $user) {
					push_notification('notice-to-proceed', $id, $user['id'], 'user', 'notice_to_proceed_updated');
				}


			$_SESSION['sys_notice_to_proceed_edit_suc'] = renderLang($notice_to_proceed_updated);
			header('location: /edit-notice-to-proceed/'.$id);
			
		} else { // error found
			
			$_SESSION['sys_notice_to_proceed_edit_err'] = renderLang($form_error);
			header('location: /edit-notice-to-proceed/'.$id);
			
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