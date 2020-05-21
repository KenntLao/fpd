<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if($_SESSION['sys_account_mode'] == 'employee') {

		// get time and day
		$epoch_time = time();

		// get employee
		$id = $_SESSION['sys_id'];
		$url = $_GET['url'];

		// check if employee is already logged in
		$sql = $pdo->prepare("SELECT id, employee_id, time_in, time_out FROM time_logs WHERE employee_id = :employee_id AND time_out=0 LIMIT 1");
		$sql->bindParam(":employee_id",$id);
		$sql->execute();
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$data_id = $data['id'];
			
			$time_rendered = $epoch_time - $data['time_in'];
			
			$sql2 = $pdo->prepare("UPDATE time_logs SET time_out = ".$epoch_time.", time_rendered = ".$time_rendered." WHERE id = ".$data_id);
			$sql2->execute();
			
			$_SESSION['sys_time_suc'] = renderLang($time_time_out_msg).' <strong>'.date('F j, Y - g:i:s a',$epoch_time).'</strong>';

			if(isset($_SESSION['sys_time_in'])) {
				unset($_SESSION['sys_time_in']);
			}

		} else {

			$_SESSION['sys_time_err'] = renderLang($time_not_timed_in);

		}

		header('location: '.$url);

	} else { // unauthorized to time in

		$_SESSION['sys_permission_err'] = renderLang($time_time_out_msg_err);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>