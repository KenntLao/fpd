<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if($_SESSION['sys_account_mode'] == 'employee') {

		// get time and day
		$epoch_time = time();
		$date_code = date('Ymd',time());
		
		// get employee
		$id = $_SESSION['sys_id'];
		$url = $_GET['url'];
		
		// check if employee is already logged in
		$sql = $pdo->prepare("SELECT employee_id, time_out FROM time_logs WHERE employee_id = :employee_id AND time_out=0 LIMIT 1");
		$sql->bindParam(":employee_id",$id);
		$sql->execute();
		if($sql->rowCount()) {
			
			$_SESSION['sys_time_err'] = renderLang($time_already_timed_in);
			
		} else {
			
			// time in employee
			$sql = $pdo->prepare("INSERT INTO time_logs(
					id,
					employee_id,
					time_in,
					date_code
				) VALUES(
					NULL,
					:employee_id,
					:time_in,
					:date_code
			)");
			$sql->bindParam(":employee_id",$id);
			$sql->bindParam(":time_in",$epoch_time);
			$sql->bindParam(":date_code",$date_code);
			$sql->execute();
			
			$_SESSION['sys_time_in'] = $epoch_time;
			$_SESSION['sys_time_suc'] = renderLang($time_time_in_msg).' <strong>'.date('F j, Y - g:i:s a',$epoch_time).'</strong>';
			
		}
		
		header('location: '.$url);

	} else { // unauthorized to time in

		$_SESSION['sys_permission_err'] = renderLang($time_time_in_msg_err);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>