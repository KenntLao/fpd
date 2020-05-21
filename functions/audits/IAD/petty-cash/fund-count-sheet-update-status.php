<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-approve')) {

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

            $sql = $pdo->prepare("UPDATE fund_count_sheet SET 
                status = :status 
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            switch($status) {
                case 2: // returned                     
                    $_SESSION['sys_fund_count_sheet_approval_suc'] = renderLang($audits_iad_on_hand_collections_returned);
                    break;
                case 3: // success
                    $_SESSION['sys_fund_count_sheet_approval_suc'] = renderLang($audits_iad_on_hand_collections_approved);
                    break;
            }

            echo 'success';

        } else {
            $_SESSION['sys_fund_count_sheet_approval_err'] = renderLang($form_error);
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