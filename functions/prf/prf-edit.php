<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prf-edit')) {
	
		$err = 0;
		$id = $_POST['id'];

        // check if exist
        $sql = $pdo->prepare("SELECT * FROM prf WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
		
        // PROCESS FORM
        
        // PROSPECT ID
        $prospect_id = '';
        if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
        }

        // NAME
        $name = array();
        if(isset($_POST['prf_name'])) {
            $name = $_POST['prf_name'];
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
		}

		// NUMBER OF STAFF
		$number_of_staff = array();
		if(isset($_POST['number-of-staff'])) {
			$number_of_staff = $_POST['number-of-staff'];
        }

        // STATUS
		$status = array();
		if(isset($_POST['status'])) {
			$status = $_POST['status'];
		}
        
        $code = $_POST['code'];
		
		// VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors

            $change_logs = array();
            if ($prospect_id != $_data['prospect_id']) {
                $tmp = 'prf_prospect_id::'.$_data['prospect_id'].'=='.$prospect_id;
                array_push($change_logs, $tmp);
            }
                

                $sql = $pdo->prepare("UPDATE prf SET 
                prospect_id =  :propect_id,
                attachment = :attachment
                WHERE id = :id");
                $sql->bindParam(":propect_id", $prospect_id);
                $sql->bindParam(":id", $id);
                // attachment
                $attachments_arr = array();
                $attachment_count = count($_FILES['attachment']);

                if($attachment_count > 0) {

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
                }

                if(!empty($attachments_arr)) {
                    $attachment_name = implode(',', $attachments_arr);
                } else {
                    $attachment_name = getField('attachment', 'prf', 'id = '.$id);
                }

                $sql->bindParam(":attachment", $attachment_name);
                $sql->execute();
  
                foreach($code as $key => $cd) {

                    $sql = $pdo->prepare("SELECT * FROM prf_departments WHERE id = :id LIMIT 1");
                    $sql->bindParam(":id", $cd);
                    $sql->execute();
                    if($sql->rowCount()) { // update
                        $_data2 = $sql->fetch(PDO::FETCH_ASSOC);

                        if ($department[$key] != $_data2['department']) {
                            echo $tmp = 'prf_department::'.$_data2['department'].'=='.$department[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($job_title[$key] != $_data2['job_title']) {
                            $tmp = 'prf_job_title::'.$_data2['job_title'].'=='.$job_title[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($number_of_staff[$key] != $_data2['number_of_staff']) {
                            $tmp = 'prf_number_of_staff::'.$_data2['number_of_staff'].'=='.$number_of_staff[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($status[$key] != $_data2['status']) {
                            $tmp = 'prf_status::'.$_data2['status'].'=='.$status[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($name[$key] != $_data2['name']) {
                            $tmp = 'prf_name::'.$_data2['name'].'=='.$name[$key];
                            array_push($change_logs, $tmp);
                        }

                        $sql1 = $pdo->prepare("UPDATE prf_departments SET
                            name = :name,
                            department = :department, 
                            job_title = :job_title, 
                            number_of_staff = :number_of_staff,
                            status = :status
                        WHERE id = :id");
                        $sql1->bindParam(":id", $cd);
                        $sql1->bindParam(":name", $name[$key]);
                        $sql1->bindParam(":department", $department[$key]);
                        $sql1->bindParam(":job_title", $job_title[$key]);
                        $sql1->bindParam(":number_of_staff", $number_of_staff[$key]);
                        $sql1->bindParam(":status", $status[$key]);
                        $sql1->execute();

                    } else { // insert

                        if(!empty($department[$key])) {
                            // inser to prf_departments
                            $sql1 = $pdo->prepare("INSERT INTO prf_departments (
                                prf_id, 
                                name,
                                department, 
                                job_title, 
                                number_of_staff,
                                status
                            ) VALUES (
                                :prf_id,
                                :name,
                                :department, 
                                :job_title, 
                                :number_of_staff,
                                :status
                            )");
                            $sql1->bindParam(":prf_id", $id);
                            $sql1->bindParam(":name", $name[$key]);
                            $sql1->bindParam(":department", $department[$key]);
                            $sql1->bindParam(":job_title", $job_title[$key]);
                            $sql1->bindParam(":number_of_staff", $number_of_staff[$key]);
                            $sql1->bindParam(":status", $status[$key]);
                            $sql1->execute();
                        }

                    }

                }

                // record to system log
                $change_log = implode(';;',$change_logs);
                systemLog('prf',$id,'update',$change_log);
    
                //notification update PRF
                $employees = getTable('employees');
                $users = getTable('users');
                foreach ($employees as $employee) {
                    push_notification('prf', $id, $employee['id'], 'employee', 'prf_updated');
                }
                foreach ($users as $user) {
                    push_notification('prf', $id, $user['id'], 'user', 'prf_updated');
                }
    
                $_SESSION['sys_prf_edit_suc'] = renderLang($prf_prf_updated);
                header('location: /prf-list');

            
        } else { // error found
			
			$_SESSION['sys_prf_edit_err'] = renderLang($form_error);
			header('location: /edit-prf/'.$id);
			
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