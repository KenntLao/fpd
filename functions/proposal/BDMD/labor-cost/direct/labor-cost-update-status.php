<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-approval')) {

        $err = 0;

        $id = '';
        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
            if(strlen($id) == 0) {
                $err++;
            }
        }

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
            if(strlen($status) == 0) {
                $err++;
            }
        }

        if($err == 0) {

            $curr_status = getField('status', 'labor_cost', 'id = '.$id);
            
            $change_logs = array();
            if ($status != $curr_status) {
                $tmp = 'proposal_status::'.$curr_status.'=='.$status;
                array_push($change_logs, $tmp);
            }

            $sql = $pdo->prepare("UPDATE labor_cost SET 
                status = :status 
            WHERE id =:id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            switch($status) {
                case 2: // returned
                    $_SESSION['sys_labor_cost_approve_suc'] = renderLang($labor_cost_returned);
                    $_SESSION['sys_labor_cost_approve_suc_alert'] = renderLang($labor_cost_returned);
                    $notif_msg = 'labor_cost_returned';
                    $notif_permission = 'labor-cost-returned';
                    break;
                case 3: // approved
                    $_SESSION['sys_labor_cost_approve_suc'] = renderLang($labor_cost_approved);
                    $_SESSION['sys_labor_cost_approve_suc_alert'] = renderLang($labor_cost_approved);
                    $notif_msg = 'labor_cost_approved';
                    $notif_permission = 'labor-cost-approved';
                    break;
            }

            if(!empty($change_logs)) {
                $change_log = implode(';;', $change_logs);
                systemLog('labor_cost', $id, 'update', $change_log);

                // push notifications
                $employees = getTable("employees");
                $users = getTable("users");
                foreach ($employees as $employee) {
                    push_notification($notif_permission,$id,$employee['id'],'employee',$notif_msg);
                }
                foreach ($users as $user) {
                    push_notification($notif_permission,$id,$user['id'],'user',$notif_msg);
                }
            }

            echo 'success';

        } else {

            $_SESSION['sys_labor_cost_approve_err'] = renderLang($form_something_went_wrong);
            echo 'error';
        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		echo 'invalid-permission';

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	echo 'no-permission';

}
?>