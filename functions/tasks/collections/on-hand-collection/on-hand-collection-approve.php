<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('collection-undeposited-approve')) {

		$id = $_POST['id'];

		$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
		} else {
			$err++;
		}

		$change_logs = array();
		if ('2' != $_data['status']) {
			$tmp = 'undeposited_status::'.$_data['status'].'== 2';
			array_push($change_logs, $tmp);
		}

		$sql = $pdo->prepare("UPDATE on_hand_collection SET 
			status = '2' 
		WHERE id = :id");
		$sql->bindParam(":id", $id);
		if($sql->execute()) {
			echo 'success';
		}

		//system log
		$change_log = implode(';;',$change_logs);
		systemLog('undeposited',$id,'update',$change_log);

		$employees = getTable("employees");
		$users = getTable("users");
		foreach ($employees as $employee) {
			push_notification('undeposited-collection', $id, $employee['id'], 'employee', 'undeposited_collection_approved');
		}
		foreach ($users as $user) {
			push_notification('undeposited-collection', $id, $user['id'], 'user', 'undeposited_collection_approved');
		}

		// push notification

    } else {// permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
      
	}
    
} else {// no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	
}
?>