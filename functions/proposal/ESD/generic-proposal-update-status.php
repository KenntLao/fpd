<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-esd-approve') || checkPermission('proposal-esd-update-status')) {

        $err = 0;

        $id = '';
        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
            if(strlen($id) == 0) {
                $err++;
            }
        }
        
        $status = '';
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
            if(strlen($status) == 0) {
                $err++;
            }
        }


        if($err == 0) {

            $sql = $pdo->prepare("UPDATE proposal_esd_generic SET 
                status = :status
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            switch($status) {
                case 2: // returned
                    $_SESSION['sys_generic_proposal_esd_approve_suc'] = renderLang($proposals_esd_generic_returned);
                    break;
                case 3: // approved
                    $_SESSION['sys_generic_proposal_esd_approve_suc'] = renderLang($proposals_esd_generic_approved_by_deirector);
                    break;
                case 4:
                    $_SESSION['sys_generic_proposal_esd_approve_suc'] = renderLang($proposals_esd_generic_submitted);
                    break;
                case 5:
                    $_SESSION['sys_generic_proposal_esd_approve_suc'] = renderLang($proposals_esd_generic_approved_by_client);
                    break;
            }
            
            echo 'success';

        } else {
            $_SESSION['sys_generic_proposal_esd_approve_err'] = renderLang($form_error);
            echo 'error';
        }

    } else { // permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        echo 'invalid-permission';

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	echo 'no-session';

}
?>