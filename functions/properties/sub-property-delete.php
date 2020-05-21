<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err_code = 1;

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('property-delete')) {

		$err = 0;

		// PROCESS FORM
		$id = $_POST['id'];
		$user_id = $_SESSION['sys_id'];
		$upass = $_POST['upass'];
		
		// if user deleting item
		if ($_SESSION['sys_account_mode'] == 'user') {
		
			// verify password
			$sql = $pdo->prepare("SELECT id, upass FROM users WHERE id = :user_id LIMIT 1");
			$sql->bindParam(":user_id",$user_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$upass_db = decryptStr($data['upass']);
		}

		// if employee deleting item
		if ($_SESSION['sys_account_mode'] == 'employee') {

			// verify password
			$sql = $pdo->prepare("SELECT id, upass FROM employees WHERE id = :employee_id LIMIT 1");
			$sql->bindParam(":employee_id",$user_id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$upass_db = decryptStr($data['upass']);
		}
		
		// check if passwords match
		if($upass_db == $upass) {
			
			$sql = $pdo->prepare("SELECT id FROM sub_properties WHERE id = :id LIMIT 1");
			$sql->bindParam(":id",$id);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// check if ID exists
			if($sql->rowCount()) {
				
				// delete property from properties table
				$epoch_time = time();
				$sql = $pdo->prepare("UPDATE sub_properties SET status = 2, temp_del = ".$epoch_time." WHERE id = :id LIMIT 1");
				$sql->bindParam(":id",$id);
				$sql->execute();
				
				// update employees under the deleted property
				$sql = $pdo->prepare("SELECT id, sub_property_ids FROM employees WHERE sub_property_ids LIKE '%,".$id.",%'");
				$sql->execute();
				while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
					
					$data_id = $data['id'];
					$sub_property_ids = str_replace(','.$id.',',',',$data['sub_property_ids']);
					
					// get property ids from sub properties
					$sub_property_ids_arr = explode(',',$sub_property_ids);
					$where = '';
					foreach($sub_property_ids_arr as $sub_property_id) {
						if($where == '') {
							$where = ' WHERE id = '.$sub_property_id;
						} else {
							$where .= ' OR id = '.$sub_property_id;
						}
					}
					$property_ids = array();
					$sql3 = $pdo->prepare("SELECT id, property_id FROM sub_properties".$where);
					$sql3->execute();
					while($data3 = $sql3->fetch(PDO::FETCH_ASSOC)) {
						if(!in_array($data3['property_id'],$property_ids)) {
							array_push($property_ids,$data3['property_id']);
						}
					}
					$property_ids = ','.implode($property_ids,',').',';
					
					$sql2 = $pdo->prepare("UPDATE employees SET property_ids = '".$property_ids."', sub_property_ids = '".$sub_property_ids."' WHERE id = ".$data_id);
					$sql2->execute();
				}
				
				// record to system log
				systemLog('property',$id,'delete','');

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

renderConfirmDelete($err_code,'sys_properties_suc','properties_messages_property_removed');
?>