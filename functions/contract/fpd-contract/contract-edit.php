<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('contract-edit')) {
	
		$err = 0;
		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM contract WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
		
    // PROCESS FORM

        $prospect_id = getField('prospect_id', 'contract', 'id = '.$id);
    
        $contract_contact_person = '';
        $contact_number = '';

        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $prospect_id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $contract_contact_person = $data['contact_person'];
        $contact_number = $data['mobile_number'];

		// ACQUISITION DATE
		$acquisition_date = '';
		if(isset($_POST['acquisition_date'])) {
			$acquisition_date = trim($_POST['acquisition_date']);
			$_SESSION['sys_contract_edit_acquisition_date_val'] = $acquisition_date;
			
		}

		// RENEWAL DATE
		$renewal_date = '';
		if(isset($_POST['renewal_date'])) {
			$renewal_date = trim($_POST['renewal_date']);
			$_SESSION['sys_contract_edit_renewal_date_val'] = $renewal_date;
			
		}

		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_contract_edit_status_val'] = $status;
			
		}
		
		$term_of_payment = '';
        if(isset($_POST['term'])) {
            $term_of_payment = trim($_POST['term']);
        }
        
        $advance_payment = '';
        if(isset($_POST['advance'])) {
            $advance_payment = trim($_POST['advance']);
        }

        $number_of_month = 0;
        if(isset($_POST['number_of_month'])) {
            $number_of_month = trim($_POST['number_of_month']);
        }

        // MODE OF PAYMENT
		$mode_of_payment = '';
		if(isset($_POST['mode_of_payment'])) {
			$mode_of_payment = $_POST['mode_of_payment'];
			if(!empty($mode_of_payment)) {
				foreach($mode_of_payment as $value) {
					$mode_of_payments[] = $value;
				}
				$mode_of_payment = implode(',',$mode_of_payments);
			}
		}

		// AMOUNT
		$amount = '';
		if(isset($_POST['amount'])) {
			$amount = trim($_POST['amount']);
			$_SESSION['sys_contract_add_amount_val'] = $amount;
			
        }

        // SECURITY DEPOSIT
		$security_deposit = '';
		if(isset($_POST['security_deposit'])) {
			$security_deposit = trim($_POST['security_deposit']);
			$_SESSION['sys_contract_add_security_deposit_val'] = $security_deposit;
			
        }

		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($acquisition_date != $_data['acquisition_date']) {
				$tmp = 'contract_acquisition_date::'.$_data['acquisition_date'].'=='.$acquisition_date;
				array_push($change_logs, $tmp);
			}
			if ($renewal_date != $_data['renewal_date']) {
				$tmp = 'contract_renewal_date::'.$_data['renewal_date'].'=='.$renewal_date;
				array_push($change_logs, $tmp);
			}
			if ($contract_contact_person != $_data['contract_contact_person']) {
				$tmp = 'contract_contact_person::'.$_data['contract_contact_person'].'=='.$contract_contact_person;
				array_push($change_logs, $tmp);
			}
			if ($contact_number != $_data['contact_number']) {
				$tmp = 'contract_contact_number::'.$_data['contact_number'].'=='.$contact_number;
				array_push($change_logs, $tmp);
			}
			if ($status != $_data['status']) {
				$tmp = 'contract_status::'.$_data['status'].'=='.$status;
				array_push($change_logs, $tmp);
			}
			if ($term_of_payment != $_data['term_of_payment']) {
				$tmp = 'contract_term_of_payment::'.$_data['term_of_payment'].'=='.$term_of_payment;
				array_push($change_logs, $tmp);
			}
			if ($advance_payment != $_data['advance_payment']) {
				$tmp = 'contract_advance_payment::'.$_data['advance_payment'].'=='.$advance_payment;
				array_push($change_logs, $tmp);
			}
			if ($number_of_month != $_data['number_of_month']) {
				$tmp = 'contract_number_of_month::'.$_data['number_of_month'].'=='.$number_of_month;
				array_push($change_logs, $tmp);
			}
			if ($mode_of_payment != $_data['mode_of_payment']) {
				$tmp = 'contract_mode_of_payment::'.$_data['mode_of_payment'].'=='.$mode_of_payment;
				array_push($change_logs, $tmp);
			}

			if (count($change_logs) > 0) {
      
				$sql = $pdo->prepare("UPDATE contract SET
					acquisition_date = :acquisition_date,
					renewal_date = :renewal_date,
					contract_contact_person = :contract_contact_person,
					contact_number = :contact_number,
					attachment = :attachment,
					status = :status,
	                term_of_payment = :term_of_payment,
	                advance_payment = :advance_payment,
	                number_of_month = :number_of_month,
	                mode_of_payment = :mode_of_payment,
	                amount = :amount,
	                security_deposit = :security_deposit
				 WHERE id = ".$id);
				$sql->bindParam(":acquisition_date", $acquisition_date);
				$sql->bindParam(":renewal_date", $renewal_date);
				$sql->bindParam(":contract_contact_person", $contract_contact_person);
				$sql->bindParam(":contact_number", $contact_number);
	            $sql->bindParam(":status", $status);
	            $sql->bindParam(":term_of_payment", $term_of_payment);
	            $sql->bindParam(":advance_payment", $advance_payment);
	            $sql->bindParam(":number_of_month", $number_of_month);
	            $sql->bindParam(":mode_of_payment", $mode_of_payment);
	            $sql->bindParam(":amount", $amount);
	            $sql->bindParam(":security_deposit", $security_deposit);

				// attachment
	            $attachments_arr = array();
	            $attachment_count = count($_FILES['attachment']);
	            if($attachment_count > 0) {

	                if(!is_dir($sys_upload_dir.'contracts')) {
	                    mkdir($sys_upload_dir.'contracts', 0755, true);
	                }

	                for($i = 0; $i < $attachment_count; $i++) {

	                    if(!empty($_FILES['attachment']['name'][$i])) {
	        
	                        $file = explode('.', $_FILES['attachment']['name'][$i]);
	                        $file_name = $file[0];
	                        $file_ext = $file[1];
	        
	                        $time = time();
	        
	                        $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
	        
	                        $file_tmp = $_FILES['attachment']['tmp_name'][$i];
	                        $file_size = $_FILES['attachment']['size'][$i];
	                        
	                        // save file
	                        move_uploaded_file($file_tmp, $sys_upload_dir.'contracts/'.$attachment_name);

	                        $attachments_arr[] = $attachment_name;
	                        
	                    }

	                }
	                
	            }//count

	            if(!empty($attachments_arr)) {
	                $attachment_name = implode(',', $attachments_arr);
	            } else {
	                $attachment_name = getField('attachment', 'contract', 'id = '.$id);
	            }

	            $sql->bindParam(":attachment", $attachment_name);

				$sql->execute();
			}


			//IF CONTRACT STATUS IS = 4(TERMINATED)
			if ($status == 4) {
				
				//systemlog
				systemLog('contract',$id,'add','');

				//notification add contract terminated
				$employees = getTable('employees');
				$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('contract-terminated', $id, $employee['id'], 'employee', 'contract_terminated_added');
				}
				foreach ($users as $user) {
					push_notification('contract-terminated', $id, $user['id'],'user', 'contract_terminated_added');
				}

			}

			//IF CONTRACT STATUS IS != 4(TERMINATED)
			if ($status != 4) {
			
				// record to system log
				$change_log = implode(';;',$change_logs);
				systemLog('contract',$id,'update',$change_log);

				// notification update CONTRACT
				$employees = getTable('employees');
				$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('contract', $id, $employee['id'], 'employee', 'contract_updated');
				}
				foreach ($users as $user) {
					push_notification('contract', $id, $user['id'], 'user', 'contract_updated');
				}
			}


			$_SESSION['sys_contract_edit_suc'] = renderLang($contract_updated);
			header('location: /contract-list');
			
		} else { // error found
			
			$_SESSION['sys_contract_edit_err'] = renderLang($form_error);
			header('location: /add-contract');
			
		}
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>