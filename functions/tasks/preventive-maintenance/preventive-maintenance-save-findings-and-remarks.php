<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('preventive-maintenance-checklist')) {

		$err = 0;

		$data = array();
		if ($_POST['data']) {
			$data = $_POST['data'];
		}

		//Insert findings and Remarks
		//legend: $value[0]>>contains id, $value[1]>>contains findings, $value[2]>> contains remarks
		foreach ($data as $key => $value) {

			$sql = $pdo->prepare("
				UPDATE 
					`preventive_maintenance_item_to_check` 
				SET 
					`findings`=:findings, 
					`remarks`=:remarks 
				WHERE 
					id = :id");
			$sql->bindParam(":findings", $value[1]);
			$sql->bindParam(":remarks", $value[2]);
			$sql->bindParam(":id", $value[0]);
			$sql->execute();


		}

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');

}

} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>