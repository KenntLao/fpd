<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-add')) {

		$err = 0;

		$id = 0;
		if(isset($_POST['id'])) {
			$id = trim($_POST['id']);
			if(!checkVar($id)) {
				$err++;
			}
		}

		$action_taken = '';
		if(isset($_POST['action_taken'])) {
			$action_taken = trim($_POST['action_taken']);
		}

		$user_id = $_SESSION['sys_id'];
		$user_account_mode = $_SESSION['sys_account_mode'];

		if($err == 0) {

			$sql = $pdo->prepare("UPDATE other_task_activities SET 
				action_taken = :action_taken, 
				action_taken_by = :user_id, 
				action_taken_by_account_mode = :user_account_mode 
			WHERE id = :id");
			$sql->bindParam(":action_taken", $action_taken);
			$sql->bindParam(":user_id", $user_id);
			$sql->bindParam(":user_account_mode", $user_account_mode);
			$sql->bindParam(":id", $id);
			$sql->execute();

			echo 'success';

		}

  	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);

}
?>