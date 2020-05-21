<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prospecting-add')) {

        $err = 0;

        $id = $_POST['id'];
        $category = $_POST['category'];
        $attachment = array();

        if($category == 'LOI') {

            $type = $_POST['LOI_type'];

            $activity_code = array();
            if(isset($_POST['LOI-code'])) {
                $activity_code[] = $_POST['LOI-code'];
            }

            $activity_date = array();
            if(isset($_POST['LOI-date'])) {
                $activity_date[] = trim($_POST['LOI-date']);
            }

            $activity_status = array();
            if(isset($_POST['LOI-status'])) {
                $activity_status[] = trim($_POST['LOI-status']);
            }

            if(isset($_FILES['LOI-attachment']['name'])) {
                $attachment = $_FILES['LOI-attachment']['name'];
                if(strlen($attachment) == 0 && $type == 'done') {
                    $value = getField('id', 'prospecting_activities', 'activity_attachment <> "" AND activity_category = "LOI" AND prospect_id = '.$id);
                    if($value === NULL) {
                        $err++;
                        $_SESSION['sys_prospecting_activity_add_LOI_attachment_err'] = renderLang($prospecting_attachment_required);
                    }
                }
            }

            $timeline = array('');
        }

        if($category == 'ACT_1') {

            $type = $_POST['ACT_1type'];

            $activity_code = array();
            if(isset($_POST['ACT_1-code'])) {
                $activity_code = $_POST['ACT_1-code'];
            }

            $activity_date = array();
            if(isset($_POST['ACT_1-date'])) {
                $activity_date = $_POST['ACT_1-date'];
            }

            $activity_status = array();
            if(isset($_POST['ACT_1-status'])) {
                $activity_status = $_POST['ACT_1-status'];
            }

            $timeline = array();
            if(isset($_POST['ACT_1-timeline'])) {
                $timeline = $_POST['ACT_1-timeline'];
            }

            if(isset($_FILES['ACT_1-attachment']['name'])) {
                $attachment = $_FILES['ACT_1-attachment']['name'];
                if(strlen($attachment) == 0 && $type == 'done') {
                    $value = getField('id', 'prospecting_activities', 'activity_attachment <> "" AND activity_category = "ACT_1" AND prospect_id = '.$id);
                    if($value === NULL) {
                        $err++;
                        $_SESSION['sys_prospecting_activity_add_ACT_1_attachment_err'] = renderLang($prospecting_attachment_required);
                    }
                }
            }

        }

        if($category == 'ACT_2') {

            $type = $_POST['ACT_2type'];

            $activity_code = array();
            if(isset($_POST['ACT_2-code'])) {
                $activity_code = $_POST['ACT_2-code'];
            }

            $activity_date = array();
            if(isset($_POST['ACT_2-date'])) {
                $activity_date = $_POST['ACT_2-date'];
            }

            $activity_status = array();
            if(isset($_POST['ACT_2-status'])) {
                $activity_status = $_POST['ACT_2-status'];
            }

            $timeline = array();
            if(isset($_POST['ACT_2-timeline'])) {
                $timeline = $_POST['ACT_2-timeline'];
            }

            if(isset($_FILES['ACT_2-attachment']['name'])) {
                $attachment = $_FILES['ACT_2-attachment']['name'];
                if(strlen($attachment) == 0 && $type == 'done') {
                    $value = getField('id', 'prospecting_activities', 'activity_attachment <> "" AND activity_category = "ACT_2" AND prospect_id = '.$id);
                    if($value === NULL) {
                        $err++;
                        $_SESSION['sys_prospecting_activity_add_ACT_2_attachment_err'] = renderLang($prospecting_attachment_required);
                    }
                }
            }

        }

        if($category == 'ACT_3') {

            $type = $_POST['ACT_3type'];

            $activity_code = array();
            if(isset($_POST['ACT_3-code'])) {
                $activity_code = $_POST['ACT_3-code'];
            }

            $activity_date = array();
            if(isset($_POST['ACT_3-date'])) {
                $activity_date = $_POST['ACT_3-date'];
            }

            $activity_status = array();
            if(isset($_POST['ACT_3-status'])) {
                $activity_status = $_POST['ACT_3-status'];
            }

            $timeline = array();
            if(isset($_POST['ACT_3-timeline'])) {
                $timeline = $_POST['ACT_3-timeline'];
            }

            if(isset($_FILES['ACT_3-attachment']['name'])) {
                $attachment = $_FILES['ACT_3-attachment']['name'];
                if(strlen($attachment) == 0 && $type == 'done') {
                    $value = getField('id', 'prospecting_activities', 'activity_attachment <> "" AND activity_category = "ACT_3" AND prospect_id = '.$id);
                    if($value === NULL) {
                        $err++;
                        $_SESSION['sys_prospecting_activity_add_ACT_3_attachment_err'] = renderLang($prospecting_attachment_required);
                    }
                }
            }

        }

        $act_category = 'ACT';
        $act_type = 'ongoing';

        $act_ids = array();
        if(isset($_POST['ACT_id'])) {
            $act_ids = $_POST['ACT_id'];
        }

        $act_remarks = '';
        if(isset($_POST['ACT-remarks'])) {
            $act_remarks = trim($_POST['ACT-remarks']);
        }

        $act_code = array();
        if(isset($_POST['ACT-code'])) {
            $act_code = $_POST['ACT-code'];
        }

        $act_date = array();
        if(isset($_POST['ACT-date'])) {
            $act_date = $_POST['ACT-date'];
        }

        $act_status = array();
        if(isset($_POST['ACT-status'])) {
            $act_status = $_POST['ACT-status'];
        }

        $act_timeline = array();
        if(isset($_POST['ACT-timeline'])) {
            $act_timeline = $_POST['ACT-timeline'];
        }


        if($err == 0) {

            $curr_time = time();

            $sql1 = $pdo->prepare('SELECT activity_code, activity_attachment FROM prospecting_activities WHERE prospect_id = :id');
            $sql1->bindParam(":id", $id);
            $sql1->execute();
            $fetch = array();
            $curr_attachment = array();
            while($data = $sql1->fetch(PDO::FETCH_ASSOC)) {
                $fetch[] = $data['activity_code']; 
                $curr_attachment[$data['activity_code']] = $data['activity_attachment'];
            }

            foreach($activity_code as $key => $code) {

                if(in_array($code, $fetch)) { // Update

                    $sql2 = $pdo->prepare("UPDATE prospecting_activities SET 
                        activity_type = :activity_type, 
                        activity_date = :activity_date, 
                        activity_status = :activity_status,
                        activity_timeline = :activity_timeline,
                        activity_attachment = :activity_attachment,
                        created_at = :created_at
                        WHERE prospect_id = :id AND activity_code = :code
                    ");

                    $sql2->bindParam(":id", $id);
                    $sql2->bindParam(":activity_type", $type);

                    $attachment_name = $curr_attachment[$code];
                    if(!empty($attachment)) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'activities')) {
                            mkdir($sys_upload_dir.'activities', 0755, true);
                        }

                        $file = explode('.', $_FILES[$category.'-attachment']['name']);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES[$category.'-attachment']['tmp_name'];
                        $file_size = $_FILES[$category.'-attachment']['size'];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'activities/'.$attachment_name);

                    }

                    $sql2->bindParam(":activity_attachment", $attachment_name);

                    if(!empty($activity_status[$key])) {

                        $sql2->bindParam(":code", $code);
                        $sql2->bindParam(":activity_date", $activity_date[$key]);
                        $sql2->bindParam(":activity_status", $activity_status[$key]);
                        $sql2->bindParam(":activity_timeline", $timeline[$key]);
                        $sql2->bindParam(":created_at", $curr_time);
                        $sql2->execute();
                    }

                } else { // Insert

                    $sql = $pdo->prepare("INSERT INTO prospecting_activities (
                        prospect_id,
                        activity_code,
                        activity_type, 
                        activity_category, 
                        activity_date, 
                        activity_status, 
                        activity_timeline, 
                        activity_attachment,
                        created_at,
                        created_by,
                        account_mode
                    ) VALUES (
                        :prospect_id,
                        :activity_code, 
                        :activity_type, 
                        :activity_category, 
                        :activity_date, 
                        :activity_status, 
                        :activity_timeline, 
                        :activity_attachment,
                        :created_at,
                        :created_by,
                        :account_mode
                    )");
        
                    $sql->bindParam(":prospect_id", $id);
                    $sql->bindParam(":activity_type", $type);
                    $sql->bindParam(":activity_category", $category);

                    // attachment
                    $attachment_name = '';
                    if(!empty($attachment)) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'activities')) {
                            mkdir($sys_upload_dir.'activities', 0755, true);
                        }

                        $file = explode('.', $_FILES[$category.'-attachment']['name']);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES[$category.'-attachment']['tmp_name'];
                        $file_size = $_FILES[$category.'-attachment']['size'];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'activities/'.$attachment_name);

                    }

                    $sql->bindParam(":activity_attachment", $attachment_name);
                        
                    if(!empty($activity_status[$key])) {
    
                        $sql->bindParam(":activity_code", $activity_code[$key]);
                        $sql->bindParam(":activity_date", $activity_date[$key]);
                        $sql->bindParam(":activity_status", $activity_status[$key]);
                        $sql->bindParam(":activity_timeline", $timeline[$key]);
                        $sql->bindParam(":created_at", $curr_time);
                        $sql->bindParam(":created_by", $_SESSION['sys_id']);
                        $sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
                        $sql->execute();
                    }

                }

            }

            // insert in activities
            foreach($act_ids as $key => $act_id) {

                $attachment_key = $key;

                $sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE id = :id");
                $sql->bindParam(":id", $act_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    $sql1 = $pdo->prepare("UPDATE prospecting_activities SET 
                        activity_type = :activity_type, 
                        activity_date = :activity_date, 
                        activity_status = :activity_status,
                        activity_timeline = :activity_timeline,
                        activity_attachment = :activity_attachment
                        WHERE prospect_id = :id AND activity_code = :code
                    ");

                    $sql1->bindParam(":id", $id);
                    $sql1->bindParam(":activity_type", $act_type);

                    // attachment
                    $attachment_name = $data['activity_attachment'];
                    if(!empty($_FILES[$act_category.'-attachment'.$attachment_key]['name'])) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'activities')) {
                            mkdir($sys_upload_dir.'activities', 0755, true);
                        }

                        $file = explode('.', $_FILES[$act_category.'-attachment'.$attachment_key]['name']);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES[$act_category.'-attachment'.$attachment_key]['tmp_name'];
                        $file_size = $_FILES[$act_category.'-attachment'.$attachment_key]['size'];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'activities/'.$attachment_name);

                    }

                    $sql1->bindParam(":activity_attachment", $attachment_name);
                        
                    if(!empty($act_status[$key])) {

                        $act_date_format = date('Y/m/d', strtotime($act_date[$key]));

                        $sql1->bindParam(":code", $act_code[$key]);
                        $sql1->bindParam(":activity_date", $act_date_format);
                        $sql1->bindParam(":activity_status", $act_status[$key]);
                        $sql1->bindParam(":activity_timeline", $act_timeline[$key]);
                        $sql1->execute();
                    }

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO prospecting_activities (
                        prospect_id,
                        activity_code,
                        activity_type, 
                        activity_category, 
                        activity_date, 
                        activity_status, 
                        activity_timeline, 
                        activity_attachment,
                        created_at,
                        created_by,
                        account_mode
                    ) VALUES (
                        :prospect_id,
                        :activity_code, 
                        :activity_type, 
                        :activity_category, 
                        :activity_date, 
                        :activity_status, 
                        :activity_timeline, 
                        :activity_attachment,
                        :created_at,
                        :created_by,
                        :account_mode
                    )");
        
                    $sql1->bindParam(":prospect_id", $id);
                    $sql1->bindParam(":activity_type", $act_type);
                    $sql1->bindParam(":activity_category", $act_category);

                    // attachment
                    $attachment_name = '';
                    if(!empty($_FILES[$act_category.'-attachment'.$attachment_key]['name'])) {

                        // create directory
                        if(!is_dir($sys_upload_dir.'activities')) {
                            mkdir($sys_upload_dir.'activities', 0755, true);
                        }

                        $file = explode('.', $_FILES[$act_category.'-attachment'.$attachment_key]['name']);
                        $file_name = $file[0];
                        $file_ext = $file[1];

                        $time = time();

                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                        $file_tmp = $_FILES[$act_category.'-attachment'.$attachment_key]['tmp_name'];
                        $file_size = $_FILES[$act_category.'-attachment'.$attachment_key]['size'];

                        // save file
                        move_uploaded_file($file_tmp, $sys_upload_dir.'activities/'.$attachment_name);

                    }

                    $sql1->bindParam(":activity_attachment", $attachment_name);
                        
                    if(!empty($act_status[$key])) {

                        $act_date_format = date('Y/m/d', strtotime($act_date[$key]));
    
                        $sql1->bindParam(":activity_code", $act_code[$key]);
                        $sql1->bindParam(":activity_date", $act_date_format);
                        $sql1->bindParam(":activity_status", $act_status[$key]);
                        $sql1->bindParam(":activity_timeline", $act_timeline[$key]);
                        $sql1->bindParam(":created_at", $curr_time);
                        $sql1->bindParam(":created_by", $_SESSION['sys_id']);
                        $sql1->bindParam(":account_mode", $_SESSION['sys_account_mode']);
                        $sql1->execute();
                    }

                }

            }

            // update other remarks in prospecting
            $sql = $pdo->prepare("UPDATE prospecting SET 
            other_remarks = :act_remarks 
            WHERE id = :id");
            $sql->bindParam(":act_remarks", $act_remarks);
            $sql->bindParam(":id", $id);
            $sql->execute();

            // record to system log
            systemLog('prospecting_activity',$id ,'edit', '');

            // notifications
            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('prospecting-activity', $id, $employee['id'], 'employee', 'prospecting_activities');
            }

            foreach($users as $user) {
                push_notification('prospecting-activity', $id, $user['id'], 'user', 'prospecting_activities');
            }

            $_SESSION['sys_prospecting_activity_add_suc'] = 'Saved.';
            header('location: /prospect-activities/'.$id);

        } else {
            $_SESSION['sys_prospecting_activity_add_err'] = renderLang($form_error);
            header('location: /prospect-activities/'.$id);
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