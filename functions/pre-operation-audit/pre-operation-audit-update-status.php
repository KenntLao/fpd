<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    $err_msg  = '';

    $status = '';
    if(isset($_POST['status'])) {
        $status = trim($_POST['status']);
        if(strlen($status) == 0) {
            $err_msg = 'error';
        }
    }

    $audit_id = '';
    if(isset($_POST['audit_id'])) {
        $audit_id = trim($_POST['audit_id']);
        if(strlen($audit_id) == 0) {
            $err_msg = 'error';
        }
    }

    $audit_type = '';
    if(isset($_POST['audit_type'])) {
        $audit_type = trim($_POST['audit_type']);
        if(strlen($audit_type) == 0) {
            $err_msg = 'error';
        }
    }

    if(empty($err_msg)) {

        if($audit_type == 'QEHS') {
            $sql = $pdo->prepare("UPDATE pre_operation_audit SET 
            status = :status 
            WHERE id = :id");
        }

        if($audit_type == 'TSA') {
            $sql = $pdo->prepare("UPDATE pre_operation_audit_tsa SET 
            status = :status 
            WHERE id = :id");
        }

        $sql->bindParam(":status", $status);
        $sql->bindParam(":id", $audit_id);
        $sql->execute();

        echo 'success';

        $_SESSION['sys_pre_operation_audit_add_suc'] = renderLang($pre_operation_audit_saved);

        if($audit_type == 'QEHS') {

            // record to system log
            systemLog('pre_operation_audit_QEHS',$audit_id ,'edit','');

            // notifications
            $notif = array();
            if($status == 2) {
                $notif = 'pre_operation_audit_returned';
            } else if($status == 3) {
                $notif = 'pre_operation_audit_approved';
            }

            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('pre-operation-audit-QEHS', $audit_id, $employee['id'], 'employee', $notif);
            }

            foreach($users as $user) {
                push_notification('pre-operation-audit-QEHS', $audit_id, $user['id'], 'user', $notif);
            }

        }

        if($audit_type == 'TSA') {

            // record to system log
            systemLog('pre_operation_audit_TSA',$audit_id ,'edit','');

            // notifications
            $notif = array();
            if($status == 2) {
                $notif = 'pre_operation_audit_returned';
            } else if($status == 3) {
                $notif = 'pre_operation_audit_approved';
            }

            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('pre-operation-audit-TSA', $audit_id, $employee['id'], 'employee', $notif);
            }

            foreach($users as $user) {
                push_notification('pre-operation-audit-TSA', $audit_id, $user['id'], 'user', $notif);
            }

        }

    } else {
        echo 'error';
    }

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	$err_msg = 'no-session';

}
?>