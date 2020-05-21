<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
		$err = 0;
		
		// PROCESS FORM

		// DATE
		$time = '';
		if(isset($_POST['time'])) {
			$time = ucwords(strtolower(trim($_POST['time'])));
			$_SESSION['sys_user_boardroom_add_time_val'] = $time;
			
		}

		// department
		$department = '';
		if(isset($_POST['department'])) {
			$department = ucwords(strtolower(trim($_POST['department'])));
			$_SESSION['sys_user_boardroom_add_department_val'] = $department;
			
		}

		// PURPOSE
		$purpose = '';
		if(isset($_POST['purpose'])) {
			$purpose = ucwords(strtolower(trim($_POST['purpose'])));
			$_SESSION['sys_user_boardroom_add_purpose_val'] = $purpose;
			
		}

		// RESERVED BY
		$reserved_by = '';
		if(isset($_POST['reserved_by'])) {
			$reserved_by = trim($_POST['reserved_by']);
			$_SESSION['sys_user_boardroom_add_reserved_by_val'] = $reserved_by;
			
		}

		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO boardroom_reservation (
				time,
				department,
				purpose,
				reserved_by
			) VALUES (
				:time,
				:department,
				:purpose,
				:reserved_by
				
			)");
			$sql->bindParam(":time", $time);
			$sql->bindParam(":department", $department);
			$sql->bindParam(":purpose", $purpose);
			$sql->bindParam(":reserved_by", $reserved_by);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_user_boardroom_add_suc'] = renderLang($boardrooms_boardroom_reservation_added);
			header('location: /user-boardrooms');
			
		} else { // error found
			
			$_SESSION['sys_user_boardroom_add_err'] = renderLang($form_error);
			header('location: /user-boardroom-add');
			
		}
		

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>