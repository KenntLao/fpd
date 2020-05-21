<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-edit')) {
	
		$err = 0;
		
		// PROCESS FORM

		$id = $_POST['id'];

		$sql = $pdo->prepare("SELECT * FROM other_tasks WHERE id = :id AND temp_del = 0 LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		$_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }

		// TITLE
		$title = '';
		if(isset($_POST['title'])) {
			$title = $_POST['title'];
			
		}

		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = $_POST['status'];
			
		}

		$incharges = '';
        if(isset($_POST['incharges'])) {
            $incharges = $_POST['incharges'];
            if(empty($incharges)) {

            } else {

            	$incharges = implode(',' , $incharges);
           
            }
        }
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($title != $_data['title']) {
				$tmp = 'po_other_task_title::'.$_data['title'].'=='.$title;
				array_push($change_logs,$tmp);
			}
			if ($status != $_data['status']) {
				$tmp = 'po_other_task_status::'.$_data['status'].'=='.$status;
				array_push($change_logs,$tmp);
			}
			if ($incharges != $_data['incharges']) {
				$tmp = 'po_other_task_incharge::'.$_data['incharges'].'=='.$incharges;
				array_push($change_logs,$tmp);
			}

      
				$sql = $pdo->prepare("UPDATE other_tasks SET
					status = :status,
					title = :title,
					incharges = :incharges,
					attachment = :attachment
				WHERE id = :id");
					$sql->bindParam(":id", $id);
					$sql->bindParam(":status", $status);
					$sql->bindParam(":title", $title);
					$sql->bindParam(":incharges", $incharges);

					 // attachment
	                $attachments_arr = array();
	                $attachment_count = count($_FILES['attachment']);
	                if($attachment_count > 0) {

	                    if(!is_dir($sys_upload_dir.'other-task')) {
	                        mkdir($sys_upload_dir.'other-task', 0755, true);
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
	                            move_uploaded_file($file_tmp, $sys_upload_dir.'other-task/'.$attachment_name);

	                            $attachments_arr[] = $attachment_name;
	                            
	                        }

	                    }
	                }

	                if(!empty($attachments_arr)) {
	                    $attachment_name = implode(',', $attachments_arr);
	                } else {
	                    $attachment_name = getField('attachment', 'other_tasks', 'id = '.$id);
	                }

	                // attachment change log
	                if ($attachment_name != $_data['attachment']) {
	                    $tmp = 'other_task_attachment::'.$_data['attachment'].'=='.$attachment_name;
	                    array_push($change_logs,$tmp);
	                }


	                $sql->bindParam(":attachment", $attachment_name);
	                
					if (count($change_logs) > 0) {

						$sql->execute();

					}

			// systemlog
			$change_log = implode(';;',$change_logs);
			systemLog('other_task', $id, 'update', $change_log);

			// notification update other_task
			$employees = getTable('employees');
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('other-task', $id, $employee['id'], 'employee', 'other_task_updated');
			}
			foreach ($users as $user) {
				push_notification('other-task', $id, $user['id'], 'user', 'other_task_updated');
			}

			$_SESSION['sys_po_other_task_edit_suc'] = renderLang($po_other_task_updated);
			header('location: /pre-operation-other-tasks');
			
		} else { // error found
			
			$_SESSION['sys_po_other_task_edit_err'] = renderLang($form_error);
			header('location: /edit-pre-operation-other-task/'.$id);
			
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