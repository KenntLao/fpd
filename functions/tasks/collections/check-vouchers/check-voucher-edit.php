<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('check-voucher-edit')) {

		$err = 0;

		$id = $_POST['id'];
		// check if exist
		$sql = $pdo->prepare("SELECT * FROM check_voucher WHERE id = :id LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
		} else {
			$err++;
		}

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

            $change_logs = array();

            if ($property_id != $_data['property_id']) {
                $tmp = 'module_property::'.$_data['property_id'].'=='.$property_id;
                $change_logs[] = $tmp;
            }
            if ($date != $_data['date']) {
                $tmp = 'lang_date::'.$_data['date'].'=='.$date;
                $change_logs[] = $tmp;
            }
            if ($reference_number != $_data['reference_number']) {
                $tmp = 'collections_check_voucher_reference_number::'.$_data['reference_number'].'=='.$reference_number;
                $change_logs[] = $tmp;
            }
            if ($bank != $_data['bank']) {
                $tmp = 'collections_check_voucher_bank::'.$_data['bank'].'=='.$bank;
                $change_logs[] = $tmp;
            }
            if ($amount != $_data['amount']) {
                $tmp = 'collections_check_voucher_amount::'.$_data['amount'].'=='.$amount;
                $change_logs[] = $tmp;
            }
            if ($check_number != $_data['check_number']) {
                $tmp = 'collections_check_voucher_check_number::'.$_data['check_number'].'=='.$check_number;
                $change_logs[] = $tmp;
            }
            if ($particulars != $_data['particulars']) {
                $tmp = 'collections_check_voucher_particulars::'.$_data['particulars'].'=='.$particulars;
                $change_logs[] = $tmp;
            }

            if ($payee != $_data['payee']) {
                $tmp = 'collections_check_voucher_payee::'.$_data['payee'].'=='.$payee;
                $change_logs[] = $tmp;
            }

            if(!empty($change_logs)) {
                
                $sql = $pdo->prepare("UPDATE check_voucher SET 
                    property_id = :property_id,
                    date = :date, 
                    reference_number = :reference_number, 
                    bank = :bank, 
                    other_bank = :other_bank, 
                    amount = :amount, 
                    check_number = :check_number, 
                    particulars = :particulars,
                    payee = :payee
                WHERE id = :id");
                $sql->bindParam(":property_id", $property_id);
                $sql->bindParam(":date", $date);
                $sql->bindParam(":reference_number", $reference_number);
                $sql->bindParam(":bank", $bank);
                $sql->bindParam(":other_bank", $other_bank);
                $sql->bindParam(":amount", $amount);
                $sql->bindParam(":check_number", $check_number);
                $sql->bindParam(":particulars", $particulars);
                $sql->bindParam(":payee", $payee);
                $sql->bindParam(":id", $id);
                $sql->execute();

                // record to system log
                $change_log = implode(';;', $change_logs);
                systemLog('check_voucher',$id,'update', $change_log);
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
                    push_notification('check-voucher', $id, $employee, 'employee', 'check_voucher_updated');
                }
                foreach ($users as $user) {
                    push_notification('check-voucher', $id, $user['id'],'user', 'check_voucher_updated');
                }

                $_SESSION['sys_check_voucher_edit_suc'] = renderLang($collections_check_voucher_updated);
                header('location: /check-vouchers');

            } else {
                $_SESSION['sys_check_voucher_edit_err'] = renderLang($form_no_changes);
                header('location: /edit-check-voucher/'.$id);
            }

		} else {

            $_SESSION['sys_check_voucher_edit_err'] = renderLang($form_error);
            header('location: /edit-check-voucher/'.$id);

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