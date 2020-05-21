<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prf-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// PROSPECT ID
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
		}

		// DEPARTMENT
		$department = array();
		if(isset($_POST['department'])) {
			$department = $_POST['department'];
			if(empty($department)) {
				$err++;
			}
		}

		// JOB TITLE
		$job_title = array();
		if(isset($_POST['job-title'])) {
			$job_title = $_POST['job-title'];
			if(empty($job_title)) {
				
				
			}
		}

		// NUMBER OF STAFF
		$number_of_staff = array();
		if(isset($_POST['number-of-staff'])) {
			$number_of_staff = $_POST['number-of-staff'];
			if(empty($number_of_staff)) {
				
			}
		}

		// STATUS
		$status = array();
		if(isset($_POST['status'])) {
			$status = $_POST['status'];
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			// insert to prf
			$sql = $pdo->prepare("INSERT INTO prf (
				prospect_id,
				attachment
			) VALUES (
				:prospect_id,
				:attachment
			)");
			$sql->bindParam(":prospect_id", $prospect_id);
			 // attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            if(!is_dir($sys_upload_dir.'prf')) {
                mkdir($sys_upload_dir.'prf', 0755, true);
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
                    move_uploaded_file($file_tmp, $sys_upload_dir.'prf/'.$attachment_name);

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

			$prf_id = $pdo->lastInsertId();

			// inser to prf_departments
			$sql = $pdo->prepare("INSERT INTO prf_departments (
				prf_id, 
				department, 
				job_title, 
				number_of_staff,
                status,
                code
			) VALUES (
                :prf_id,
                :department, 
                :job_title, 
                :number_of_staff,
                :status,
                :code
            )");
            $sql->bindParam(":prf_id", $prf_id);

            $code = $prospect_id.$prf_id.'1';

            foreach($department as $key => $dept) {

                if(!empty($dept)) {

                    $sql->bindParam(":department", $dept);
                    $sql->bindParam(":job_title", $job_title[$key]);
                    $sql->bindParam(":number_of_staff", $number_of_staff[$key]);
                    $sql->bindParam(":status", $status[$key]);
                    $sql->bindParam(":code", $code);
                    $sql->execute();

                    $code++;

                }

            }

			// record to system log
			systemLog('prf',$prf_id,'add','');

			// notification CONTRACT
			$employees = getTable('employees');
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('prf', $prf_id, $employee['id'], 'employee', 'prf_add');
			}
			foreach ($users as $user) {
				push_notification('prf', $prf_id, $user['id'], 'user', 'prf_add');
			}

			$_SESSION['sys_prf_add_suc'] = renderLang($pfr_added);
			header('location: /prf-list');
			
		} else { // error found
			
			$_SESSION['sys_contract_add_err'] = renderLang($form_error);
			header('location: /add-prf');
			
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