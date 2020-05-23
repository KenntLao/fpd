<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err_code = 1;

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operations-audit-TSA-delete')) {

		$err = 0;

		// PROCESS FORM
		$id = $_POST['id'];
		$user_id = $_SESSION['sys_id'];
		$upass = $_POST['upass'];
		
		// verify password
		$sql = $pdo->prepare("SELECT id, upass FROM users WHERE id = :user_id LIMIT 1");
		$sql->bindParam(":user_id",$user_id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		$upass_db = decryptStr($data['upass']);
		
		// check if passwords match
		if($upass_db == $upass) {
			
			$sql = $pdo->prepare("SELECT id FROM operations_audit_tsa WHERE id = :id LIMIT 1");
			$sql->bindParam(":id",$id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// check if ID exists
			if($sql->rowCount()) {
				
				// delete occupant from notice to proceed table
				$epoch_time = time();
				$sql = $pdo->prepare("UPDATE operations_audit_tsa SET temp_del = ".$epoch_time." WHERE id = :id LIMIT 1");
				$sql->bindParam(":id",$id);
				$sql->execute();
				
				// record to system log
				systemLog('operations_audit_TSA',$id,'delete','');

				$err_code = 0;
				
			} else {
				
				$err_code = 4;
				
			}
			
		} else {
			
			$err_code = 2;
			
		}

	} else { // permission not found
		
		$err_code = 3;

	}
}

renderConfirmDelete($err_code,'sys_operations_audit_tsa_suc','operation_audit_tsa_messages_tsa_removed');
?>