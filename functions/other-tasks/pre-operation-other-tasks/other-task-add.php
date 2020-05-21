<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// DATE
		$date = time();

		// DEPARTMENT
		$department = '';
		if(isset($_POST['department_id'])) {
			$department = $_POST['department_id'];
			
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

        $user_id = $_SESSION['sys_id'];
        $account_mode = $_SESSION['sys_account_mode'];

		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO other_tasks (
				department_id,
				title,
				date,
				status,
				incharges,
                created_by,
                account_mode,
				attachment
			) VALUES (
				:department_id,
				:title,
				:date,
				:status,
				:incharges,
                :user_id,
                :account_mode,
				:attachment			
			)");
			$sql->bindParam(":department_id", $department);
			$sql->bindParam(":title", $title);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":status", $status);
            $sql->bindParam(":incharges", $incharges);
            $sql->bindParam(":user_id", $user_id);
            $sql->bindParam(":account_mode", $account_mode);

			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

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

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = '';
            }

            $sql->bindParam(":attachment", $attachment_name);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('other_task',$id,'add','');

			//notification add other task
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('other-task', $id, $employee['id'], 'employee', 'other_task_add');
				}
				foreach ($users as $user) {
					push_notification('other-task', $id, $user['id'], 'user', 'other_task_add');
				}

			$_SESSION['sys_po_other_task_add_suc'] = renderLang($po_other_task_added);
			header('location: /pre-operation-other-tasks');
			
		} else { // error found
			
			$_SESSION['sys_po_other_task_add_err'] = renderLang($form_error);
			header('location: /add-pre-operation-other-task');
			
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