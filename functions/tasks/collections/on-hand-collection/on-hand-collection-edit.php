<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('collection-undeposited-edit')) {

		$err = 0;

		$id = $_POST['id'];
		$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE id = :id");
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
		$bill_id = array();
		if(isset($_POST['bill_id'])) {
			$bill_id = $_POST['bill_id'];
		}

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
		$check_id = array();
		if(isset($_POST['check_id'])) {
			$check_id = $_POST['check_id'];
		}

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
		$direct_deposit_id = array();
		if(isset($_POST['direct_deposit_id'])) {
			$direct_deposit_id = $_POST['direct_deposit_id'];
		}

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
		$credit_card_id = array();
		if(isset($_POST['credit_card_id'])) {
			$credit_card_id = $_POST['credit_card_id'];
		}

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

			$change_logs = array();
			if ($property_id != $_data['property_id']) {
				$tmp = 'pre_operation_audit_project::'.$_data['property_id'].'=='.$property_id;
				array_push($change_logs,$tmp);
			}
			if ($cashier != $_data['cashier']) {
				$tmp = 'pre_operation_audit_iad_cashier::'.$_data['cashier'].'=='.$cashier;
				array_push($change_logs,$tmp);
			}
			if ($status != $_data['status']) {
				$tmp = 'undeposited_status::'.$_data['status'].'=='.$status;
				array_push($change_logs,$tmp);
			}

			$sql = $pdo->prepare("UPDATE on_hand_collection SET 
				property_id = :property_id, 
				cashier = :cashier, 
				status = :status, 
				attachment = :attachment 
			WHERE id = :id");
			$sql->bindParam(":id", $id);
			$sql->bindParam(":property_id", $property_id);
			$sql->bindParam(":cashier", $cashier);
			$sql->bindParam(":status", $status);
			
			$attachment_name = $_data['attachment'];
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

			// attachment change log
            if ($attachment_name != $_data['attachment']) {
                $tmp = 'move_inout_requests_attachment::'.$_data['attachment'].'=='.$attachment_name;
                array_push($change_logs,$tmp);
            }

			$sql->bindParam(":attachment", $attachment_name);

			if (count($change_logs) > 0) {

				$sql->execute();
			}

			// BILLS
			foreach($bill_id as $key => $bill) {

				$sql = $pdo->prepare("SELECT * FROM on_hand_collection_bills WHERE id = :id");
				$sql->bindParam(":id", $bill);
				$sql->execute();
				if($sql->rowCount()) { // update

					$data = $sql->fetch(PDO::FETCH_ASSOC);

					if ($denomination[$key] != $data['denomination']) {
		                $tmp = 'pre_operation_audit_pcc_denomination::'.$data['denomination'].'=='.$denomination[$key];
		                array_push($change_logs,$tmp);
		            }
		            if ($quantity[$key] != $data['quantity']) {
		                $tmp = 'pre_operation_audit_pcc_quantity::'.$data['quantity'].'=='.$quantity[$key];
		                array_push($change_logs,$tmp);
		            }
		            if ($amount[$key] != $data['amount']) {
		                $tmp = 'pre_operation_audit_pcc_amount::'.$data['amount'].'=='.$amount[$key];
		                array_push($change_logs,$tmp);
		            }

		            if (count($change_logs) > 0) {

						$sql1 = $pdo->prepare("UPDATE on_hand_collection_bills SET 
							denomination = :denomination, 
							quantity = :quantity, 
							amount = :amount 
						WHERE id = :id");
						$sql1->bindParam(":id", $bill);
						$quantity_val = empty($quantity[$key]) ? 0 : $quantity[$key];
						$sql1->bindParam(":denomination", $denomination[$key]);
						$sql1->bindParam(":quantity", $quantity_val);
						$sql1->bindParam(":amount", $amount[$key]);
						$sql1->execute();
		            }
					
				} else { // insert

					$sql1 = $pdo->prepare("INSERT INTO on_hand_collection_bills (
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
					$sql1->bindParam(":collection_id", $id);
					$quantity_val = empty($quantity[$key]) ? 0 : $quantity[$key];
					$sql1->bindParam(":denomination", $denomination[$key]);
					$sql1->bindParam(":quantity", $quantity_val);
					$sql1->bindParam(":amount", $amount[$key]);
					$sql1->execute();

				}
			}

			// CHECKS
			foreach($check_id as $key => $check) {
				$sql = $pdo->prepare("SELECT * FROM on_hand_collection_checks WHERE id = :id");
				$sql->bindParam(":id", $check);
				$sql->execute();
				if($sql->rowCount()) {

					$data = $sql->fetch(PDO::FETCH_ASSOC);

					if ($check_or[$key] != $data['or_number']) {
		                $tmp = 'pre_operation_audit_iad_or_ar_no::'.$data['or_number'].'=='.$check_or[$key];
		                array_push($change_logs,$tmp);
		            }
		            if ($check_bank[$key] != $data['bank']) {
		                $tmp = 'pre_operation_audit_iad_bank::'.$data['bank'].'=='.$check_bank[$key];
		                array_push($change_logs,$tmp);
		            }
		            if ($check_date[$key] != $data['date']) {
		                $tmp = 'pre_operation_audit_pcc_date::'.$data['date'].'=='.$check_date[$key];
		                array_push($change_logs,$tmp);
		            }
		            if ($check_amount[$key] != $data['amount']) {
		                $tmp = 'pre_operation_audit_pcc_amount::'.$data['amount'].'=='.$check_amount[$key];
		                array_push($change_logs,$tmp);
		            }

		            if (count($change_logs) > 0) {
		             
						$sql1 = $pdo->prepare("UPDATE on_hand_collection_checks SET 
							or_number = :or_number, 
							bank = :bank, 
							date = :date, 
							amount = :amount 
						WHERE id = :id");
						$sql1->bindParam(":id", $check);
						$sql1->bindParam(":or_number", $check_or[$key]);
						$sql1->bindParam(":bank", $check_bank[$key]);
						$sql1->bindParam(":date", $check_date[$key]);
						$sql1->bindParam(":amount", $check_amount[$key]);
						$sql1->execute();

		            }

				} else {

					$sql1 = $pdo->prepare("INSERT INTO on_hand_collection_checks (
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
					$sql1->bindParam(":collection_id", $id);
					$sql1->bindParam(":or_number", $check_or[$key]);
					$sql1->bindParam(":bank", $check_bank[$key]);
					$sql1->bindParam(":date", $check_date[$key]);
					$sql1->bindParam(":amount", $check_amount[$key]);
					$sql1->execute();
				}
			}

			// OTHERS
			
				// DIRECT DEPOSIT
				foreach($direct_deposit_id as $key => $dd_id) {
					$sql = $pdo->prepare("SELECT * FROM on_hand_collection_direct_deposit WHERE id = :id LIMIT 1");
					$sql->bindParam(":id", $dd_id);
					$sql->execute();
					if($sql->rowCount()) { // update

						$data = $sql->fetch(PDO::FETCH_ASSOC);

						if ($direct_deposit_amount[$key] != $data['amount']) {
			                $tmp = 'pre_operation_audit_pcc_amount::'.$data['amount'].'=='.$direct_deposit_amount[$key];
			                array_push($change_logs,$tmp);
			            }
			            if ($direct_deposit_bank[$key] != $data['bank']) {
			                $tmp = 'collections_check_voucher_bank::'.$data['bank'].'=='.$direct_deposit_bank[$key];
			                array_push($change_logs,$tmp);
			            }
			            if ($direct_deposit_date[$key] != $data['date_deposited']) {
			                $tmp = 'collections_date_deposited::'.$data['date_deposited'].'=='.$direct_deposit_date[$key];
			                array_push($change_logs,$tmp);
			            }

			            if (count($change_logs) > 0) {

							$sql1 = $pdo->prepare("UPDATE on_hand_collection_direct_deposit SET 
								amount = :amount, 
								bank = :bank, 
								date_deposited = :date_deposited 
							WHERE id = :id");
							$sql1->bindParam(":id", $data['id']);
							$sql1->bindParam(":amount", $direct_deposit_amount[$key]);
							$sql1->bindParam(":bank", $direct_deposit_bank[$key]);
							$sql1->bindParam(":date_deposited", $direct_deposit_date[$key]);
							$sql1->execute();
			            }

					} else { // insert

						// DIRECT DEPOSIT
						$sql1 = $pdo->prepare("INSERT INTO on_hand_collection_direct_deposit (
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

						if(!empty($direct_deposit_amount[$key])) {
							$sql1->bindParam(":collection_id", $id);
							$sql1->bindParam(":amount", $direct_deposit_amount[$key]);
							$sql1->bindParam(":bank", $direct_deposit_bank[$key]);
							$sql1->bindParam(":date_deposited", $direct_deposit_date[$key]);
							$sql1->execute();
						}

					}
				}

				// CREDIT CARD
				foreach($credit_card_id as $key => $cc_id) {
					$sql = $pdo->prepare("SELECT * FROM on_hand_collection_credit_card WHERE id = :id");
					$sql->bindParam(":id", $cc_id);
					$sql->execute();
					if($sql->rowCount()) {
						$data = $sql->fetch(PDO::FETCH_ASSOC);

						if ($credit_card_amount[$key] != $data['amount']) {
			                $tmp = 'pre_operation_audit_pcc_amount::'.$data['amount'].'=='.$credit_card_amount[$key];
			                array_push($change_logs,$tmp);
			            }
			            if ($credit_card_type[$key] != $data['card_type']) {
			                $tmp = 'collections_card_type::'.$data['card_type'].'=='.$credit_card_type[$key];
			                array_push($change_logs,$tmp);
			            }
			            if ($credit_card_date[$key] != $data['date_of_payment']) {
			                $tmp = 'collections_date_of_payment::'.$data['date_of_payment'].'=='.$credit_card_date[$key];
			                array_push($change_logs,$tmp);
			            }

			            if (count($change_logs) > 0) {

							$sql1 = $pdo->prepare("UPDATE on_hand_collection_credit_card SET 
								amount = :amount, 
								card_type = :card_type, 
								date_of_payment = :date_of_payment 
							WHERE id = :id");
							$sql1->bindParam(":id", $data['id']);
							$sql1->bindParam(":amount", $credit_card_amount[$key]);
							$sql1->bindParam(":card_type", $credit_card_type[$key]);
							$sql1->bindParam(":date_of_payment", $credit_card_date[$key]);
							$sql1->execute();
			            }

					} else {

						$sql1 = $pdo->prepare("INSERT INTO on_hand_collection_credit_card (
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
						if(!empty($credit_card_amount[$key])) {
							$sql1->bindParam(":collection_id", $id);
							$sql1->bindParam(":amount", $credit_card_amount[$key]);
							$sql1->bindParam(":card_type", $credit_card_type[$key]);
							$sql1->bindParam(":date_of_payment", $credit_card_date[$key]);
							$sql1->execute();
						}

					}
				}

			// TOTALS
			$sql = $pdo->prepare("SELECT * FROM on_hand_collection_totals WHERE collection_id = :id");
			$sql->bindParam(":id", $id);
			$sql->execute();
			if($sql->rowCount()) {
				$_data2 = $sql->fetch(PDO::FETCH_ASSOC);
			} else {
				$err++;
			}

			if ($total_bills != $_data2['total_bills']) {
				$tmp = 'pre_operation_audit_iad_total_bills_and_coins::'.$_data2['total_bills'].'=='.$total_bills;
				array_push($change_logs,$tmp);
			}
			if ($total_checks != $_data2['total_checks']) {
				$tmp = 'pre_operation_audit_iad_total_checks::'.$_data2['total_checks'].'=='.$total_checks;
				array_push($change_logs,$tmp);
			}
			if ($total_per_count != $_data2['total_per_count']) {
				$tmp = 'pre_operation_audit_pcc_total_per_count::'.$_data2['total_per_count'].'=='.$total_per_count;
				array_push($change_logs,$tmp);
			}
			if ($total_to_be_counted_for != $_data2['total_to_be_counted_for']) {
				$tmp = 'pre_operation_audit_iad_total_to_be_counted_for::'.$_data2['total_to_be_counted_for'].'=='.$total_to_be_counted_for;
				array_push($change_logs,$tmp);
			}
			if ($total_overage != $_data2['overage_shortage']) {
				$tmp = 'pre_operation_audit_pcc_over_age::'.$_data2['overage_shortage'].'=='.$total_overage;
				array_push($change_logs,$tmp);
			}
			if ($total_others != $_data2['others']) {
				$tmp = 'pre_operation_audit_others::'.$_data2['others'].'=='.$total_others;
				array_push($change_logs,$tmp);
			}

			if (count($change_logs) > 0) {

				$sql =$pdo->prepare("UPDATE on_hand_collection_totals SET 
					total_bills = :total_bills, 
					total_checks = :total_checks, 
					total_per_count = :total_per_count, 
					total_to_be_counted_for = :total_to_be_counted_for, 
					overage_shortage = :overage_shortage,
					others = :others 
				WHERE collection_id = :collection_id");
				$sql->bindParam(":collection_id", $id);
				$sql->bindParam(":total_bills", $total_bills);
				$sql->bindParam(":total_checks", $total_checks);
				$sql->bindParam(":total_per_count", $total_per_count);
				$sql->bindParam(":total_to_be_counted_for", $total_to_be_counted_for);
				$sql->bindParam(":overage_shortage", $total_overage);
				$sql->bindParam(":others", $total_others);
				$sql->execute();
			}

			// record to system log
			$change_log = implode(';;',$change_logs);
			systemLog('undeposited',$id,'update',$change_log);
			// push notification
			$employees = getTable("employees");
			$users = getTable('users');
			foreach ($employees as $employee) {
				push_notification('undeposited-collection', $id, $employee['id'],'employee', 'undeposited_collection_updated');
			}
			foreach ($users as $user) {
				push_notification('undeposited-collection', $id, $user['id'],'user', 'undeposited_collection_updated');
			}

			$_SESSION['sys_collection_undeposited_edit_suc'] = renderLang($collections_on_hand_updated);
			header('location: /on-hand-collections');

		} else {
			$_SESSION['sys_collection_undeposited_edit_err'] = renderLang($form_error);
			header('location: /edit-on-hand-collection/'.$id);
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