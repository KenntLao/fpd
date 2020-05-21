<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-QEHS-add')) {

        $err = 0;

        $project_id = '';
        if(isset($_POST['project_id'])) {
            $project_id = trim($_POST['project_id']);
            if(strlen($project_id) == 0) {
                $err++;
                $_SESSION['sys_pre_operation_audit_add_project_id_err'] = renderLang($pre_operation_audit_project_required);
            }
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

            } else {
                $auditors = implode(',', $auditors);
            }
        }

        $department = '';
        if(isset($_POST['department'])) {
            $department = $_POST['department'];
        }


        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO pre_operation_audit (
                prospect_id, 
                auditee, 
                date_of_audit, 
                auditors,
                department
            ) VALUES (
                :project_id, 
                :auditee, 
                :date_of_audit, 
                :auditors,
                :department
            )");

            $sql->bindParam(":project_id", $project_id);
            $sql->bindParam(":auditee", $auditee);
            $sql->bindParam(":date_of_audit", $date_of_audit);
            $sql->bindParam(":auditors", $auditors);
            $sql->bindParam(":department", $department);
            $sql->execute();

            $id = $pdo->lastInsertId();

            $_SESSION['sys_pre_operation_audit_add_suc'] = renderLang($pre_operation_audit_saved);
            header('location: /pre-operation-audit-checklist/'.$id);

            // record to system log
            systemLog('pre-operation-audit-QEHS',$id ,'add','');

            // notifications
            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('pre-operation-audit-QEHS', $id, $employee['id'], 'employee', 'pre_operation_audit_add');
            }

            foreach($users as $user) {
                push_notification('pre-operation-audit-QEHS', $id, $user['id'], 'user', 'pre_operation_audit_add');
            }

        } else {

            $_SESSION['sys_pre_operation_audit_add_err'] = renderLang($form_error);
            header('location: /pre-operation-audit-checklist');

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