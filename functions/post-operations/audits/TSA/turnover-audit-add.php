<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('turnover-audits')) {

        $err = 0;

        // form data
            $property_id = '';
            if(isset($_POST['property_id'])) {
                $property_id = trim($_POST['property_id']);
                if(strlen($property_id) == 0) {
                    $err++;
                }
            }
            
            $date_of_audit = '';
            if(isset($_POST['date_of_audit'])) {
                $date_of_audit = trim($_POST['date_of_audit']);
                if(strlen($date_of_audit) == 0) {
                    $err++;
                }
            }

            $date_presented = '';
            if(isset($_POST['date_presented'])) {
                $date_presented = trim($_POST['date_presented']);
            }

            $user_id = $_SESSION['sys_id'];
            $account_mode = $_SESSION['sys_account_mode'];
        // 

        // SECTION 1 SUMMARY
            // summary
            $summary = '';
            if(isset($_POST['summary'])) {
                $summary = trim($_POST['summary']);
            }
            // attachments
                // pre audit
                $pre_audit_meeting_attachments = array();
                if(isset($_FILES['pre_audit_meeting']['name'])) {
                    $pre_audit_meeting_attachments = $_FILES['pre_audit_meeting'];
                }
                // post audit
                $post_audit_meeting_attachments = array();
                if(isset($_FILES['post_audit_meeting']['name'])) {
                    $post_audit_meeting_attachments = $_FILES['post_audit_meeting'];
                }
            // conformance summary
                $summary_category = array();
                if(isset($_POST['summary_category'])) {
                    $summary_category = $_POST['summary_category'];
                }

                $summary_description = array();
                if(isset($_POST['summary_description'])) {
                    $summary_description = $_POST['summary_description'];
                }

                $summary_recommendation = array();
                if(isset($_POST['summary_recommendation'])) {
                    $summary_recommendation = $_POST['summary_recommendation'];
                }
            // 
        // 

        // SECTION 2 

        if($err == 0) {

            // main form
                $sql = $pdo->prepare("INSERT INTO post_audit_tsa (
                    property_id, 
                    date_of_audit, 
                    date_presented, 
                    created_by, 
                    account_mode
                ) VALUES (
                    :property_id, 
                    :date_of_audit, 
                    :date_presented, 
                    :created_by, 
                    :account_mode
                )");
                $sql->bindParam(":property_id", $property_id);
                $sql->bindParam(":date_of_audit", $date_of_audit);
                $sql->bindParam(":date_presented", $date_presented);
                $sql->bindParam(":created_by", $user_id);
                $sql->bindParam(":account_mode", $account_mode);
                $sql->execute();

                $post_tsa_id = $pdo->lastInsertId();
            // 

            // SECTION 1 SUMMARY

                $sql = $pdo->prepare("INSERT INTO post_audit_tsa_summary (
                    post_tsa_id, 
                    description, 
                    pre_audit_meeting, 
                    post_audit_meeting
                ) VALUES (
                    :post_tsa_id, 
                    :description, 
                    :pre_audit_meeting, 
                    :post_audit_meeting
                )");
                $sql->bindParam(":post_tsa_id", $post_tsa_id);
                $sql->bindParam(":description", $summary);

                // pre audit attachments
                    $attachments_arr = array();
                    $attachment_count = count($pre_audit_meeting_attachments);
                    
                    // check if directory exist
                    if(!is_dir($sys_upload_dir.'post-audit-tsa')) {
                        // create directory
                        mkdir($sys_upload_dir.'post-audit-tsa', 0755, true);
                    }

                    for($i = 0; $i < $attachment_count; $i++) {

                        if(!empty($pre_audit_meeting_attachments['name'][$i])) {
            
                            $file = explode('.', $pre_audit_meeting_attachments['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
                            // rename file
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $pre_audit_meeting_attachments['tmp_name'][$i];
                            $file_size = $pre_audit_meeting_attachments['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'post-audit-tsa/'.$attachment_name);
                            // push attachment name
                            $attachments_arr[] = $attachment_name;
                            
                        }

                    }

                    if(!empty($attachments_arr)) {
                        $pre_audit_meeting = implode(',', $attachments_arr);
                    } else {
                        $pre_audit_meeting = '';
                    }

                    $sql->bindParam(":pre_audit_meeting", $pre_audit_meeting);
                // 

                // post audit attachments
                    $attachments_arr = array();
                    $attachment_count = count($post_audit_meeting_attachments);
                    
                    // check if directory exist
                    if(!is_dir($sys_upload_dir.'post-audit-tsa')) {
                        // create directory
                        mkdir($sys_upload_dir.'post-audit-tsa', 0755, true);
                    }

                    for($i = 0; $i < $attachment_count; $i++) {

                        if(!empty($post_audit_meeting_attachments['name'][$i])) {
            
                            $file = explode('.', $post_audit_meeting_attachments['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
                            // rename file
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $post_audit_meeting_attachments['tmp_name'][$i];
                            $file_size = $post_audit_meeting_attachments['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'post-audit-tsa/'.$attachment_name);
                            // push attachment name
                            $attachments_arr[] = $attachment_name;
                            
                        }

                    }

                    if(!empty($attachments_arr)) {
                        $post_audit_meeting = implode(',', $attachments_arr);
                    } else {
                        $post_audit_meeting = '';
                    }

                    $sql->bindParam(":post_audit_meeting", $post_audit_meeting);
                //
                $sql->execute();

                $post_tsa_summary_id = $pdo->lastInsertId();
            
                // summary non-conformance
                    $sql = $pdo->prepare("INSERT INTO post_audit_tsa_summary_conformance (
                        post_tsa_summary_id, 
                        category,
                        description,
                        recommendation
                    ) VALUES (
                        :post_tsa_summary_id, 
                        :category, 
                        :description, 
                        :recommendation
                    )");
                    $sql->bindParam(":post_tsa_summary_id", $post_tsa_summary_id);
                    foreach($summary_category as $key => $category) {
                        if(!empty($summary_description[$key]) || !empty($summary_recommendation[$key])) {
                            $sql->bindParam(":category", $category);
                            $sql->bindParam(":description", $summary_description[$key]);
                            $sql->bindParam(":recommendation", $summary_recommendation[$key]);
                            $sql->execute();
                        }
                    }
                //
            // 

        } else {

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