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

            $sql = $pdo->prepare("UPDATE count_sheet_collections SET 
                status = :status 
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            switch($status) {
                case 2: // returned                     
                    $_SESSION['sys_count_sheet_approval_suc'] = renderLang($audits_iad_on_hand_collections_returned);
                    break;
                case 3: // success
                    $_SESSION['sys_count_sheet_approval_suc'] = renderLang($audits_iad_on_hand_collections_approved);
                    break;
            }

            echo 'success';

            // update cache data
                // get all count sheet data
                $tbl_fields = "csc.id, property_name, counted_by, account_mode, csc.status, csc.property_id";
                $query = "SELECT $tbl_fields FROM count_sheet_collections csc JOIN properties p ON(csc.property_id = p.id) WHERE csc.temp_del = 0";
                updateCache('count-sheets.json', $query);

        } else {
            $_SESSION['sys_count_sheet_approval_err'] = renderLang();
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