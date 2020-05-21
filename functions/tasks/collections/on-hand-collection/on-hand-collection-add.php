<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('collection-undeposited-add')) {

		$err = 0;

		$property_id = 0;
		if(isset($_POST['property_id'])) {
			$property_id = trim($_POST['property_id']);
			if(strlen($property_id) == 0) {
				$err++;
			}
		}

		$status = 0;
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
		}

		$cashier = '';
		if(isset($_POST['cashier'])) {
			$cashier = trim($_POST['cashier']);
		}

		$attachment = array();
		if(isset($_FILES['attachment']['name'])) {
			$attachment = $_FILES['attachment'];
		}

		// bills
		$denomination = array();
		if(isset($_POST['denomination'])) {
			$denomination = $_POST['denomination'];
		}

		$quantity = array();
		if(isset($_POST['quantity'])) {
			$quantity = $_POST['quantity'];
		}

		$amount = array();
		if(isset($_POST['amount'])) {
			$amount = $_POST['amount'];
		}

		// check
		$check_or = array();
		if(isset($_POST['check_or'])) {
			$check_or = $_POST['check_or'];
		}

		$check_bank = array();
		if(isset($_POST['check_bank'])) {
			$check_bank = $_POST['check_bank'];
		}

		$check_date = array();
		if(isset($_POST['check_date'])) {
			$check_date = $_POST['check_date'];
		}

		$check_amount = array();
		if(isset($_POST['check_amount'])) {
			$check_amount = $_POST['check_amount'];
		}

		// totals
		$total_bills = '';
		if(isset($_POST['total_bills'])) {
			$total_bills = trim($_POST['total_bills']);
		}

		$total_checks = '';
		if(isset($_POST['total_checks'])) {
			$total_checks = trim($_POST['total_checks']);
		}

		$total_per_count1 = '';
		if(isset($_POST['total_per_count1'])) {
			$total_per_count1 = trim($_POST['total_per_count1']);
		}

		$total_per_count2 = '';
		if(isset($_POST['total_per_count2'])) {
			$total_per_count2 = trim($_POST['total_per_count2']);
		}

		$total_others = '';
		if(isset($_POST['total_others'])) {
			$total_others = trim($_POST['total_others']);
		}

		$total_to_be_counted_for = '';
		if(isset($_POST['total_to_be_counted_for'])) {
			$total_to_be_counted_for = trim($_POST['total_to_be_counted_for']);
		}

		$total_overage = '';
		if(isset($_POST['total_overage'])) {
			$total_overage = trim($_POST['total_overage']);
		}

		$total_per_count = implode(',', array($total_per_count1, $total_per_count2));

		// DIRECT DEPOSIT
		$direct_deposit_amount = array();
		if(isset($_POST['direct_deposit_amount'])) {
			$direct_deposit_amount = $_POST['direct_deposit_amount'];
		}

		$direct_deposit_bank = array();
		if(isset($_POST['direct_deposit_bank'])) {
			$direct_deposit_bank = $_POST['direct_deposit_bank'];
		}

		$direct_deposit_date = array();
		if(isset($_POST['direct_deposit_date'])) {
			$direct_deposit_date = $_POST['direct_deposit_date'];
		}

		// CREDIT CARD
		$credit_card_amount = array();
		if(isset($_POST['credit_card_amount'])) {
			$credit_card_amount = $_POST['credit_card_amount'];
		}

		$credit_card_type = array();
		if(isset($_POST['credit_card_type'])) {
			$credit_card_type = $_POST['credit_card_type'];
		}

		$credit_card_date = array();
		if(isset($_POST['credit_card_date'])) {
			$credit_card_date = $_POST['credit_card_date'];
		}

		if($err == 0) {

			$sql = $pdo->prepare("INSERT INTO on_hand_collection (
				property_id, 
				cashier,
				status,
				attachment
			) VALUES (
				:property_id, 
				:cashier, 
				:status,
				:attachment
			)");
			$sql->bindParam(":property_id", $property_id);
			$sql->bindParam(":cashier", $cashier);
			$sql->bindParam(":status", $status);
			
			$attachment_name = '';
			if(!empty($attachment['name'])) {

				if(!is_dir($sys_upload_dir.'on-hand-collection')) {
					mkdir($sys_upload_dir.'on-hand-collection', 0755, true);
				}
    
				$file = explode('.', $attachment['name']);
				$file_name = $file[0];
				$file_ext = $file[1];

				$time = time();

				$attachment_name = $file_name.'-'.$time.'.'.$file_ext;

				$file_tmp = $attachment['tmp_name'];
				$file_size = $attachment['size'];
				
				// save file
				move_uploaded_file($file_tmp, $sys_upload_dir.'on-hand-collection/'.$attachment_name);
				
			}

			$sql->bindParam(":attachment", $attachment_name);
			$sql->execute();

			$collection_id = $pdo->lastInsertId();

			// BILLS
			$sql = $pdo->prepare("INSERT INTO on_hand_collection_bills (
				collection_id, 
				denomination, 
				quantity, 
				amount
			) VALUES (
				:collection_id, 
				:denomination, 
				:quantity, 
				:amount
			)");
			$sql->bindParam(":collection_id", $collection_id);

			foreach($denomination as $key => $denom) {

				$quantity_val = empty($quantity[$key]) ? 0 : $quantity[$key];

				$sql->bindParam(":denomination", $denom);
				$sql->bindParam(":quantity", $quantity_val);
				$sql->bindParam(":amount", $amount[$key]);
				$sql->execute();
			}

			// CHECKS
			$sql = $pdo->prepare("INSERT INTO on_hand_collection_checks (
				collection_id, 
				or_number, 
				bank, 
				date, 
				amount
			) VALUES (
				:collection_id, 
				:or_number, 
				:bank, 
				:date, 
				:amount
			)");
			$sql->bindParam(":collection_id", $collection_id);
			foreach($check_or as $key => $or) {
				$sql->bindParam(":or_number", $or);
				$sql->bindParam(":bank", $check_bank[$key]);
				$sql->bindParam(":date", $check_date[$key]);
				$sql->bindParam(":amount", $check_amount[$key]);
				$sql->execute();
			}

			// DIRECT DEPOSIT
			$sql = $pdo->prepare("INSERT INTO on_hand_collection_direct_deposit (
				collection_id, 
				amount, 
				bank, 
				date_deposited
			) VALUES (
				:collection_id,
				:amount, 
				:bank, 
				:date_deposited
			)");
			$sql->bindParam(":collection_id", $collection_id);
			foreach($direct_deposit_amount as $key => $amount) {
				if(!empty($amount)) {
					$sql->bindParam(":amount", $amount);
					$sql->bindParam(":bank", $direct_deposit_bank[$key]);
					$sql->bindParam(":date_deposited", $direct_deposit_date[$key]);
					$sql->execute();
				}
			}

			// CREDIT / DEBIT CARD
			$sql = $pdo->prepare("INSERT INTO on_hand_collection_credit_card (
				collection_id, 
				amount, 
				card_type, 
				date_of_payment
			) VALUES (
				:collection_id, 
				:amount, 
				:card_type, 
				:date_of_payment
			)");
			$sql->bindParam(":collection_id", $collection_id);
			foreach($credit_card_amount as $key => $amount) {

				if(!empty($amount)) {
					$sql->bindParam(":amount", $amount);
					$sql->bindParam(":card_type", $credit_card_type[$key]);
					$sql->bindParam(":date_of_payment", $credit_card_date[$key]);
					$sql->execute();
				}

			} 

			// TOTALS
			$sql = $pdo->prepare("INSERT INTO on_hand_collection_totals (
				collection_id, 
				total_bills, 
				total_checks, 
				total_per_count, 
				total_to_be_counted_for,
				overage_shortage, 
				others
			) VALUES (
				:collection_id,
				:total_bills, 
				:total_checks, 
				:total_per_count, 
				:total_to_be_counted_for, 
				:overage_shortage, 
				:others
			)");
			$sql->bindParam(":collection_id", $collection_id);
			$sql->bindParam(":total_bills", $total_bills);
			$sql->bindParam(":total_checks", $total_checks);
			$sql->bindParam(":total_per_count", $total_per_count);
			$sql->bindParam(":total_to_be_counted_for", $total_to_be_counted_for);
			$sql->bindParam(":overage_shortage", $total_overage);
			$sql->bindParam(":others", $total_others);
			$sql->execute();

			// record to system log
			systemLog('undeposited',$collection_id,'add','');
			// push notification
			$employees = getTable("employees");
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('undeposited-collection', $collection_id, $employee['id'],'employee', 'undeposited_collection_added');
			}
			foreach ($users as $user) {
				push_notification('undeposited-collection', $collection_id, $user['id'],'user', 'undeposited_collection_added');
			}

			$_SESSION['sys_undeposited_collection_add_suc'] = renderLang($collections_on_hand_added);
			header('location: /on-hand-collections');

		} else {
			$_SESSION['sys_on_hand_collection_add_err'] = renderLang($form_error);
			header('location: /add-on-hand-collections');
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