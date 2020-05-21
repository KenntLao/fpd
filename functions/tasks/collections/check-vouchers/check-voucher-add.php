<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('check-voucher-add')) {

		$err = 0;

		$property_id = 0;
		if(isset($_POST['property_id'])) {
			$property_id = trim($_POST['property_id']);
		}

		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
		}

		$reference_number = '';
		if(isset($_POST['reference_number'])) {
			$reference_number = trim($_POST['reference_number']);
		}

		$bank = '';
		if(isset($_POST['bank'])) {
			$bank = trim($_POST['bank']);
		}

		$other_bank = '';
		if(isset($_POST['other_bank'])) {
			$other_bank = trim($_POST['other_bank']);
		}

		$amount = '';
		if(isset($_POST['amount'])) {
			$amount = trim($_POST['amount']);
		}

		$check_number = '';
		if(isset($_POST['check_number'])) {
			$check_number = trim($_POST['check_number']);
		}

		$particulars = '';
		if(isset($_POST['particulars'])) {
			$particulars = trim($_POST['particulars']);
		}

		$payee = '';
		if(isset($_POST['payee'])) {
			$payee = trim($_POST['payee']);
		}

		if($err == 0) {

			$sql = $pdo->prepare("INSERT INTO check_voucher (
				property_id, 
				date, 
				reference_number, 
				bank, 
				other_bank, 
				amount, 
				check_number, 
				particulars,
				payee
			) VALUES (
				:property_id, 
				:date, 
				:reference_number, 
				:bank, 
				:other_bank, 
				:amount, 
				:check_number, 
				:particulars,
				:payee
			)");
			$sql->bindParam(":property_id", $property_id);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":reference_number", $reference_number);
			$sql->bindParam(":bank", $bank);
			$sql->bindParam(":other_bank", $other_bank);
			$sql->bindParam(":amount", $amount);
			$sql->bindParam(":check_number", $check_number);
			$sql->bindParam(":particulars", $particulars);
			$sql->bindParam(":payee", $payee);
			$sql->execute();

			$id = $pdo->lastInsertId();

			// record to system log
			systemLog('check_voucher',$id,'add','');
            // push notification
            $employees = array();
            $property = '%,'.$property_id.',%';
            $sql = $pdo->prepare("SELECT id FROM employees WHERE property_ids LIKE :property");
            $sql->bindParam(":property", $property);
            $sql->execute();
            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                $employees[] = $data['id'];
            }
            $cluster_id = getField('cluster_id', 'properties', 'id = '.$property_id);
            if(checkVar($cluster_id)) {
                $cluster_assigned = getField('assigned', 'clusters', 'id = '.$cluster_id);
                if($cluster_assigned) {
                    if(!in_array($cluster_assigned, $employees)) {
                        $employees[] = $cluster_assigned;
                    }
                }
            }
			$users = getTable('users');
			foreach($employees as $employee) {
				push_notification('check-voucher', $id, $employee, 'employee', 'check_voucher_added');
			}
			foreach ($users as $user) {
				push_notification('check-voucher', $id, $user['id'],'user', 'check_voucher_added');
			}

			$_SESSION['sys_check_voucher_add_suc'] = renderlang($collections_check_voucher_added);
			header('location: /check-vouchers');

		} else {

			$_SESSION['sys_check_voucher_add_err'] = renderLang($form_error);
			header('location: /add-check-voucher');

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