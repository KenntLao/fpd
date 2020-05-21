<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		$id = $_POST['id'];

        $ot_id = array();
        if(isset($_POST['ot_id'])) {
            $ot_id = $_POST['ot_id'];
        }

		$ot_code = array();
        if(isset($_POST['OT_code'])) {
            $ot_code = $_POST['OT_code'];
        }

        $ot_remarks = array();
        if(isset($_POST['OT_remarks'])) {
            $ot_remarks = $_POST['OT_remarks'];
        }

        $ot_date = array();
        if(isset($_POST['OT_date'])) {
            $ot_date = $_POST['OT_date'];
        }

        $ot_timeline = array();
        if(isset($_POST['OT_timeline'])) {
            $ot_timeline = $_POST['OT_timeline'];
        }
		
		// VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors
            
            foreach($ot_id as $key => $activity_id) {
                $sql = $pdo->prepare('SELECT * FROM other_task_activities WHERE id = :id');
                $sql->bindParam(":id", $activity_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    $sql1 = $pdo->prepare("UPDATE other_task_activities SET
						remarks = :remarks,
						date = :date,
						timeline = :timeline,
						activity_attachment = :activity_attachment
					WHERE id = :id");

					$sql1->bindParam(":id", $data['id']);

					// attachment
                    $attachment_name =  $data['activity_attachment'];
                    if(!empty($_FILES['OT_attachment']['name'][$key])) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'other-task-activities')) {
                            mkdir($sys_upload_dir.'other-task-activities', 0755, true);
                        }

                        $file = explode('.', $_FILES['OT_attachment']['name'][$key]);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES['OT_attachment']['tmp_name'][$key];
                        $file_size = $_FILES['OT_attachment']['size'][$key];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'other-task-activities/'.$attachment_name);

                    }

                    $sql1->bindParam(":activity_attachment", $attachment_name);
                    $sql1->bindParam(":remarks", $ot_remarks[$key]);
                    $sql1->bindParam(":date", $ot_date[$key]);
                    $sql1->bindParam(":timeline", $ot_timeline[$key]);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO other_task_activities (
						other_task_id,
						remarks,
						remarks_by,
						remarks_by_account_mode,
						date,
						timeline,
						code,
						activity_attachment
					) VALUES (
						:other_task_id,
						:remarks,
						:remarks_by,
						:remarks_by_account_mode,
						:date,
						:timeline,
						:code,
						:activity_attachment
					)");

					$sql1->bindParam(":other_task_id", $id);
					$sql1->bindParam(":remarks_by", $_SESSION['sys_id']);
					$sql1->bindParam(":remarks_by_account_mode", $_SESSION['sys_account_mode']);

					// attachment
                    $attachment_name = '';
                    if(!empty($_FILES['OT_attachment']['name'][$key])) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'other-task-activities')) {
                            mkdir($sys_upload_dir.'other-task-activities', 0755, true);
                        }

                        $file = explode('.', $_FILES['OT_attachment']['name'][$key]);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES['OT_attachment']['tmp_name'][$key];
                        $file_size = $_FILES['OT_attachment']['size'][$key];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'other-task-activities/'.$attachment_name);

                    }

                    $sql1->bindParam(":activity_attachment", $attachment_name);

                    if(!empty($ot_remarks[$key])) {
                        $sql1->bindParam(":remarks", $ot_remarks[$key]);
                        $sql1->bindParam(":date", $ot_date[$key]);
                        $sql1->bindParam(":timeline", $ot_timeline[$key]);
                        $sql1->bindParam(":code", $ot_code[$key]);
                        $sql1->execute();
                    }
                }
            }
			
			// record to system log
			systemLog('other_task_activities',$id,'add','');

			// notification update other_task
			$incharge = getField('incharges', 'other_tasks', 'id = '.$id);
			$assigned = explode(',', $incharge);

			$users = getTable('users');
			foreach($assigned as $assigned_id) {
				push_notification('other-task-activities', $id, $assigned_id, 'employee', 'other_task_activities_add_remars');
			}

			foreach ($users as $user) {
				push_notification('other-task-activities', $id, $user['id'], 'user', 'other_task_activities_add_remars');
			}

			$_SESSION['sys_po_other_task_activities_add_suc'] = renderLang($po_other_task_added);
			header('location: /add-activities-pre-operation-other-task/'.$id);
			
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