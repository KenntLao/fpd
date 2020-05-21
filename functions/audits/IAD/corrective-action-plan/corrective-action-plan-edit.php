<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-edit')) {

        $err = 0;

        $status = 0;

        $id = $_POST['id'];
        $sql2 = $pdo->prepare("SELECT * FROM iad_audit_correctives WHERE id = :id LIMIT 1");
        $sql2->bindParam(":id", $id);
        $sql2->execute();
        if($sql2->rowCount()) {
            $_data = $sql2->fetch(PDO::FETCH_ASSOC);

            $property_id = '';
            if(isset($_POST['property_id'])) {
                $property_id = trim($_POST['property_id']);
                if(strlen($property_id) == 0) {
                    $err++;
                }
            }

            $reference_number = '';
            if(isset($_POST['reference_number'])) {
                $reference_number = trim($_POST['reference_number']);
            }

            $major_count = 0;
            if(isset($_POST['major_count'])) {
                $major_count = trim($_POST['major_count']);
                if(empty($major_count)) {
                    $major_count = 0;
                }
            }

            $minor_count = 0;
            if(isset($_POST['minor_count'])) {
                $minor_count = trim($_POST['minor_count']);
                if(empty($minor_count)) {
                    $minor_count = 0;
                }
            }

            $note_count = 0;
            if(isset($_POST['note_count'])) {
                $note_count = trim($_POST['note_count']);
                if(empty($note_count)) {
                    $note_count = 0;
                }
            }

            $attachments = array();
            if(isset($_FILES['attachments'])) {
                $attachments = $_FILES['attachments'];
            }

            // auditees
                $auditee_ids = array();
                if(isset($_POST['auditee_id'])) {
                    $auditee_ids = $_POST['auditee_id'];
                }

                $auditee_name = array();
                if(isset($_POST['auditee_name'])) {
                    $auditee_name = $_POST['auditee_name'];
                }

                $auditee_position = array();
                if(isset($_POST['auditee_position'])) {
                    $auditee_position = $_POST['auditee_position'];
                }
            // 

            // findings

                $covered_period = array();
                if(isset($_POST['covered_period'])) {
                    $covered_period = $_POST['covered_period'];
                }

                $findings_id = array();
                if(isset($_POST['findings_id'])) {
                    $findings_id = $_POST['findings_id'];
                }
            
                $category = array();
                if(isset($_POST['category'])) {
                    $category = $_POST['category'];
                }

                $sub_category = array();
                if(isset($_POST['sub_category'])) {
                    $sub_category = $_POST['sub_category'];
                }

                $findings_key = array();
                if(isset($_POST['findings_key'])) {
                    $findings_key = $_POST['findings_key'];
                }

                $covered_period = array();
                if(isset($_POST['covered_period'])) {
                    $covered_period = $_POST['covered_period'];
                }

                $findings = array();
                if(isset($_POST['findings'])) {
                    $findings = $_POST['findings'];
                }

                $complied = array();
                if(isset($_POST['complied'])) {
                    $complied = $_POST['complied'];
                }

                $classification = array();
                if(isset($_POST['classification'])) {
                    $classification = $_POST['classification'];
                }

                $risks = array();
                if(isset($_POST['risks'])) {
                    $risks = $_POST['risks'];
                }

                $recommendations = array();
                if(isset($_POST['recommendations'])) {
                    $recommendations = $_POST['recommendations'];
                }

                $root_cause = array();
                if(isset($_POST['root_cause'])) {
                    $root_cause = $_POST['root_cause'];
                }

                $correction = array();
                if(isset($_POST['correction'])) {
                    $correction = $_POST['correction'];
                }

                $corrective_action = array();
                if(isset($_POST['corrective_action'])) {
                    $corrective_action = $_POST['corrective_action'];
                }

                $timeline = array();
                if(isset($_POST['timeline'])) {
                    $timeline = $_POST['timeline'];
                }

                $responsible_party = array();
                if(isset($_POST['responsible_party'])) {
                    $responsible_party = $_POST['responsible_party'];
                }

                $verification_date = array();
                if(isset($_POST['verification_date'])) {
                    $verification_date = $_POST['verification_date'];
                }

            // 

            $user_id = $_SESSION['sys_id'];
            $account_mode = $_SESSION['sys_account_mode'];

            if($err == 0) {

                $sql = $pdo->prepare("UPDATE iad_audit_correctives SET 
                    property_id = :property_id, 
                    reference_number = :reference_number, 
                    major_count = :major_count, 
                    minor_count = :minor_count, 
                    note_count = :note_count, 
                    attachments = :attachments, 
                    status = :status
                WHERE id = :id");

                $sql->bindParam(":id", $id);

                // attachments
                $attachments_arr = array();
                if(!empty($attachments)) {
                    // create directory
                    if(!is_dir($sys_upload_dir.'corrective-action-plan')) {
                        mkdir($sys_upload_dir.'corrective-action-plan', 0755, true);
                    }

                    $attachment_count = count($attachments);
                    for($i = 0; $i < $attachment_count; $i++) {
                        if(!empty($attachments['name'][$i])) {
                            $file = explode('.', $attachments['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
            
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $attachments['tmp_name'][$i];
                            $file_size = $attachments['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'corrective-action-plan/'.$attachment_name);

                            $attachments_arr[] = $attachment_name;
                        }
                    }
                }
                if(!empty($attachments_arr)) {
                    $attachment_name = implode(',', $attachments_arr);
                } else {
                    $attachment_name = $_data['attachments'];
                }
                $sql->bindParam(":attachments", $attachment_name);

                $sql->bindParam(":property_id", $property_id);
                $sql->bindParam(":reference_number", $reference_number);
                $sql->bindParam(":major_count", $major_count);
                $sql->bindParam(":minor_count", $minor_count);
                $sql->bindParam(":note_count", $note_count);
                $sql->bindParam(":status", $status);
                $sql->execute();

                // auditees
                foreach($auditee_ids as $key => $auditee_id) {
                    $sql = $pdo->prepare("SELECT * FROM iad_audit_correctives_auditees WHERE id = :id LIMIT 1");
                    $sql->bindParam(":id", $auditee_id);
                    $sql->execute();
                    if($sql->rowCount()) {

                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE iad_audit_correctives_auditees SET 
                            name = :name, 
                            position = :position 
                        WHERE id = :id");
                        $sql1->bindParam(":id", $data['id']);
                        $sql1->bindParam(":name", $auditee_name[$key]);
                        $sql1->bindParam(":position", $auditee_position[$key]);
                        $sql1->execute();

                    } else {

                        $sql1 = $pdo->prepare("INSERT INTO iad_audit_correctives_auditees (
                            corrective_id, 
                            name, 
                            position
                        ) VALUES (
                            :corrective_id, 
                            :name, 
                            :position
                        )");
                        $sql1->bindParam(":corrective_id", $id);
                        $sql1->bindParam(":name", $auditee_name[$key]);
                        $sql1->bindParam(":position", $auditee_position[$key]);
                        $sql1->execute();

                    }

                }

                // findings
                foreach($findings_id as $key => $finding_id) {
                    // check if exist
                    $sql = $pdo->prepare("SELECT * FROM iad_audit_correctives_findings WHERE id = :id");
                    $sql->bindParam(":id", $finding_id);
                    $sql->execute();
                    if($sql->rowCount()) { // update
                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE iad_audit_correctives_findings SET 
                            findings_key = :findings_key,
                            findings = :findings,
                            covered_period = :covered_period,
                            complied = :complied,
                            classification = :classification, 
                            risks = :risks, 
                            recommendations = :recommendations, 
                            root_cause = :root_cause, 
                            correction = :correction, 
                            corrective_action = :corrective_action, 
                            timeline = :timeline, 
                            responsible_party = :responsible_party, 
                            verification_date = :verification_date 
                        WHERE id = :id");
                        $sql1->bindParam(":id", $data['id']);

                        $comply = $complied[$key];
                        if(!checkVar($complied[$key])){
                            $comply = NULL;
                        }

                        $covered = NULL;
                        if($category[$key] == 'A' && $sub_category[$key] == "3" && $findings[$key] == 0) {
                            $covered = $covered_period[0];
                        } else if($category[$key] == 'A' && $sub_category[$key] == "4" && $findings[$key] == 0) {
                            $covered = $covered_period[1];
                        }
                        
                        $sql1->bindParam(":findings_key", $findings_key[$key]);
                        $sql1->bindParam(":findings", $findings[$key]);
                        $sql1->bindParam(":covered_period", $covered);
                        $sql1->bindParam(":complied", $comply);
                        $sql1->bindParam(":classification", $classification[$key]);
                        $sql1->bindParam(":risks", $risks[$key]);
                        $sql1->bindParam(":recommendations", $recommendations[$key]);
                        $sql1->bindParam(":root_cause", $root_cause[$key]);
                        $sql1->bindParam(":correction", $correction[$key]);
                        $sql1->bindParam(":corrective_action", $corrective_action[$key]);
                        $sql1->bindParam(":timeline", $timeline[$key]);
                        $sql1->bindParam(":responsible_party", $responsible_party[$key]);
                        $sql1->bindParam(":verification_date", $verification_date[$key]);
                        $sql1->execute();

                    } else { // insert

                        $sql1 = $pdo->prepare("INSERT INTO iad_audit_correctives_findings (
                            corrective_id, 
                            findings_key, 
                            findings,
                            covered_period,
                            category, 
                            sub_category, 
                            complied, 
                            classification, 
                            risks, 
                            recommendations, 
                            root_cause, 
                            correction, 
                            corrective_action, 
                            timeline, 
                            responsible_party, 
                            verification_date
                        ) VALUES (
                            :corrective_id, 
                            :findings_key, 
                            :findings,
                            :covered_period,
                            :category, 
                            :sub_category, 
                            :complied, 
                            :classification, 
                            :risks, 
                            :recommendations, 
                            :root_cause, 
                            :correction, 
                            :corrective_action, 
                            :timeline, 
                            :responsible_party,
                            :verification_date
                        )");
    
                        $comply = $complied[$key];
                        if(!checkVar($complied[$key])){
                            $comply = NULL;
                        }

                        $covered = NULL;
                        if($category[$key] == 'A' && $sub_category[$key] == "3" && $findings[$key] == 0) {
                            $covered = $covered_period[0];
                        } else if($category[$key] == 'A' && $sub_category[$key] == "4" && $findings[$key] == 0) {
                            $covered = $covered_period[1];
                        }
    
                        $sql1->bindParam(":corrective_id", $id);
                        $sql1->bindParam(":findings_key", $findings_key[$key]);
                        $sql1->bindParam(":findings", $findings[$key]);
                        $sql1->bindParam(":covered_period", $covered);
                        $sql1->bindParam(":category", $category[$key]);
                        $sql1->bindParam(":sub_category", $sub_category[$key]);
                        $sql1->bindParam(":complied", $comply);
                        $sql1->bindParam(":classification", $classification[$key]);
                        $sql1->bindParam(":risks", $risks[$key]);
                        $sql1->bindParam(":recommendations", $recommendations[$key]);
                        $sql1->bindParam(":root_cause", $root_cause[$key]);
                        $sql1->bindParam(":correction", $correction[$key]);
                        $sql1->bindParam(":corrective_action", $corrective_action[$key]);
                        $sql1->bindParam(":timeline", $timeline[$key]);
                        $sql1->bindParam(":responsible_party", $responsible_party[$key]);
                        $sql1->bindParam(":verification_date", $verification_date[$key]);
                        $sql1->execute();

                    }
                }

                $_SESSION['sys_corrective_action_plan_edit_suc'] = renderLang($audits_iad_corrective_action_plan_added);
                header('location: /corrective-action-plan-list');

            } else {

                $_SESSION['sys_corrective_action_plan_edit_err'] = renderLang($form_error);
                header('location: /edit-corrective-action-plan/'.$id);

            }

        } else {
            $_SESSION['sys_corrective_action_plan_edit_err'] = renderLang($lang_no_data);
            header('location: /corrective-action-plan-list');
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