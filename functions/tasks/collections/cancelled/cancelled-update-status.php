<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('cancelled-collections')) {

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

			$sql = $pdo->prepare("UPDATE cancelled_collection SET 
				status = :status
			WHERE id = :id");
			$sql->bindParam(":status", $status);
			$sql->bindParam(":id", $id);
			$sql->execute();

			$_SESSION['sys_cancelled_collection_suc'] = renderLang($cancelled_collections_cancelled);
			echo 'success';

		} else {
			$_SESSION['sys_cancelled_collection_err'] = renderLang($form_somethig_went_wrong); 
			echo 'error';
		}

	} else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        echo 'invalid-permission';
        
    }
      
} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    echo 'no-session';
    
}
?>