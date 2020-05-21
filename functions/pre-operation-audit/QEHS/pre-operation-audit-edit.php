<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS-add')) {

        $err = 0;

        $id = $_POST['id'];

        $project_id = '';
        if(isset($_POST['project_id'])) {
            $project_id = trim($_POST['project_id']);
            if(strlen($project_id) == 0) {
                $err++;
                $_SESSION['sys_pre_operation_audit_add_project_id_err'] = renderLang($pre_operation_audit_project_required);
            }
        }

        $status = 0;
        if(isset($_POST['save_status'])) {
            $status = $_POST['save_status'];
        }
        
        $auditee = '';
        if(isset($_POST['auditee'])) {
            $auditee = trim($_POST['auditee']);
        }

        $date_of_audit = '';
        if(isset($_POST['date_of_audit'])) {
            $date_of_audit = trim($_POST['date_of_audit']);
            if(strlen($date_of_audit) == 0) {
                $err++;
                $_SESSION['sys_pre_operation_audit_add_date_of_audit_err'] = renderLang($pre_operation_audit_date_of_audit_required);
            }
        }

        $auditors = array();
        if(isset($_POST['auditors'])) {
            $auditors = $_POST['auditors'];
            if(empty($auditors)) {

            }
        }

        $department = '';
        if(isset($_POST['department'])) {
            $department = $_POST['department'];
        }

        $checklist_id = array();
        if(isset($_POST['checklist_id'])) {
            $checklist_id = $_POST['checklist_id'];
        }

        $compliance = array();
        if(isset($_POST['compliance'])) {
            $compliance = $_POST['compliance'];
        }

        $action = array();
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }


        if($err == 0) {

            $auditors = implode(',', $auditors);

            $sql = $pdo->prepare("UPDATE pre_operation_audit SET 
            prospect_id = :project_id, 
            auditee = :auditee, 
            date_of_audit = :date_of_audit, 
            auditors = :auditors, 
            department =  :department,
            status = :status
            WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->bindParam(":project_id", $project_id);
            $sql->bindParam(":auditee", $auditee);
            $sql->bindParam(":date_of_audit", $date_of_audit);
            $sql->bindParam(":auditors", $auditors);
            $sql->bindParam(":department", $department);
            $sql->bindParam(":status", $status);
            $sql->execute();

            foreach($checklist_id as $key => $check_id) {

                $gaps = '';
                $act = '';

                $sql = $pdo->prepare("SELECT id, compliances, actions, auditor FROM pre_operation_audit_checklist WHERE audit_id = :id AND checklist_id = :check_id LIMIT 1");
                $sql->bindParam(":id", $id);
                $sql->bindParam(":check_id", $check_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    if($data['auditor'] == $_SESSION['sys_id']) {
                        $gaps = $compliance[$key];
                        $act = $action[$key];
                    } else {
                        

                        if(!empty($data['compliances']) && empty($compliance[$key])) {
                            $gaps = $data['compliances'];
                        } else {
                            $gaps = $compliance[$key];
                        }

                        if(!empty($data['actions']) && empty($action[$key])) {
                            $act = $data['actions'];
                        } else {
                            $act =$action[$key];
                        }

                    }

                    $sql1 = $pdo->prepare("UPDATE pre_operation_audit_checklist SET 
                    compliances = :compliance, 
                    actions = :actions,
                    auditor = :auditor
                    WHERE checklist_id = :check_id AND audit_id = :id");
                    $sql1->bindParam(":id", $id);
                    $sql1->bindParam(":check_id", $check_id);
                    $sql1->bindParam(":compliance", $gaps);
                    $sql1->bindParam(":actions", $act);
                    $sql1->bindParam(":auditor", $_SESSION['sys_id']);
                    $sql1->execute();

                } else { // insert

                    if(!empty($compliance[$key]) || !empty($action[$key])) {

                        $sql1 = $pdo->prepare("INSERT INTO pre_operation_audit_checklist (
                            audit_id, 
                            checklist_id,
                            compliances, 
                            actions,
                            auditor
                        ) VALUES (
                            :audit_id, 
                            :checklist_id,
                            :compliance, 
                            :actions,
                            :auditor
                        )");

                        $sql1->bindParam(":audit_id", $id);
                        $sql1->bindParam(":checklist_id", $check_id);
                        $sql1->bindParam(":compliance", $compliance[$key]);
                        $sql1->bindParam(":actions", $action[$key]);
                        $sql1->bindParam(":auditor", $_SESSION['sys_id']);
                        $sql1->execute();
                        
                    }

                }

            }

            if($status == 0) {
                $_SESSION['sys_pre_operation_audit_add_suc'] = renderLang($pre_operation_audit_saved);
                header('location: /edit-pre-operation-audit-checklist/'.$id);
            } else {
                $_SESSION['sys_pre_operation_audit_edit_suc'] = renderLang($pre_operation_audit_saved);
                header('location: /pre-operation-audits');
            } 

        } else {

            $_SESSION['sys_pre_operation_audit_add_err'] = renderLang($form_error);
            header('location: /edit-pre-operation-audit-checklist/'.$id);

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