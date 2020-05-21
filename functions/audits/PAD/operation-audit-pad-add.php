<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-PAD-add')) {

        $err = 0;

        // CHECKLIST INFO
        
            // month
            $month = '';
            if(isset($_POST['month'])) {
                $month = trim($_POST['month']);
                if(strlen($month) == 0) {
                    $err++;
                }
            }

            // prospect
            $prospect_id = '';
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                }
            }

            // accounting assistant
            $accounting_assistant = '';
            if(isset($_POST['accounting_assistant'])) {
                $accounting_assistant = trim($_POST['accounting_assistant']);
                if(strlen($accounting_assistant) == 0) {

                }
            }

            // accounting supervisor
            $accounting_supervisor = '';
            if(isset($_POST['accounting_supervisor'])) {
                $accounting_supervisor = trim($_POST['accounting_supervisor']);
                if(strlen($accounting_supervisor) == 0) {

                }
            }

            // building manager
            $building_manager = '';
            if(isset($_POST['building_manager'])) {
                $building_manager = trim($_POST['building_manager']);
                if(strlen($building_manager) == 0) {

                }
            }

            // checked by
            $checked_by = '';
            if(isset($_POST['checked_by'])) {
                $checked_by = trim($_POST['checked_by']);
                if(strlen($checked_by) == 0) {

                }
            }

            // noted by
            $noted_by = '';
            if(isset($_POST['noted_by'])) {
                $noted_by = trim($_POST['noted_by']);
                if(strlen($noted_by) == 0) {

                }
            }

        // ITEMS TO BE CHECKED
            
            // reference_document
            $reference_document = array();
            if(isset($_POST['reference_document'])) {
                $reference_document = $_POST['reference_document'];
            }

            // checklist id
            $checklist_id = array();
            if(isset($_POST['checklist_id'])) {
                $checklist_id = $_POST['checklist_id'];
            }

            // status
            $status = array();
            if(isset($_POST['status'])) {
                $status = $_POST['status'];
            }

             // status
             $remarks = array();
             if(isset($_POST['remarks'])) {
                 $remarks = $_POST['remarks'];
             }

        if($err == 0) {

            // insert to poa_pad_checklist
            $sql = $pdo->prepare("INSERT INTO poa_pad_checklist (
                prospect_id, 
                month, 
                accounting_assistant, 
                accounting_supervisor, 
                building_manager, 
                checked_by, 
                noted_by
            ) VALUES (
                :prospect_id, 
                :month, 
                :accounting_assistant, 
                :accounting_supervisor, 
                :building_manager, 
                :checked_by, 
                :noted_by
            )");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":month", $month);
            $sql->bindParam(":accounting_assistant", $accounting_assistant);
            $sql->bindParam(":accounting_supervisor", $accounting_supervisor);
            $sql->bindParam(":building_manager", $building_manager);
            $sql->bindParam(":checked_by", $checked_by);
            $sql->bindParam(":noted_by", $noted_by);
            $sql->execute();

            $pad_checklist_id = $pdo->lastInsertId();

            // insert to poa_pad_checklist_item
            $sql = $pdo->prepare("INSERT INTO poa_pad_checklist_item (
                pad_checklist_id, 
                checklist_id, 
                reference_document, 
                status, 
                remarks
            ) VALUES (
                :pad_checklist_id, 
                :checklist_id, 
                :reference_document, 
                :status, 
                :remarks
            )");
            $sql->bindParam(":pad_checklist_id", $pad_checklist_id);

            foreach($checklist_id as $key => $check_id) {

                $sql->bindParam(":checklist_id", $check_id);
                $sql->bindParam(":reference_document", $reference_document[$key]);
                $sql->bindParam(":status", $status[$key]);
                $sql->bindParam(":remarks", $remarks[$key]);
                $sql->execute();

            }

            $_SESSION['sys_pre_operation_audit_pad_suc'] = renderLang($pre_operation_audit_pad_checklist_saved); 
            header('location: /operation-audit-pad-list');

        } else {

            $_SESSION['sys_pre_operation_audit_pad_add_err'] = renderLang($form_error); 
            header('location: /add-pad-operation-audit');

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