<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('contract-add')) {
	
		$err = 0;
		
		// PROCESS FORM

        $contract_contact_person = '';
        $contact_number = '';
		// PROJECT NAME
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) != 0) {
                $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
                $sql->bindParam(":id", $prospect_id);
                $sql->execute();
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $contract_contact_person = $data['contact_person'];
                $contact_number = $data['mobile_number'];
            }
        }

		// ACQUISITION DATE
		$acquisition_date = '';
		if(isset($_POST['acquisition_date'])) {
			$acquisition_date = trim($_POST['acquisition_date']);
			$_SESSION['sys_contract_add_acquisition_date_val'] = $acquisition_date;
			
		}

		// RENEWAL DATE
		$renewal_date = '';
		if(isset($_POST['renewal_date'])) {
			$renewal_date = trim($_POST['renewal_date']);
			$_SESSION['sys_contract_add_renewal_date_val'] = $renewal_date;
			
        }
        
		// STATUS
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_contract_add_status_val'] = $status;
			
        }
        
        $term_of_payment = '';
        if(isset($_POST['term'])) {
            $term_of_payment = trim($_POST['term']);
        }
        
        $advance_payment = '';
        if(isset($_POST['advance'])) {
            $advance_payment = trim($_POST['advance']);
        }

        $number_of_month = '';
        if(isset($_POST['number_of_month'])) {
            $number_of_month = trim($_POST['number_of_month']);
        }

        // MODE OF PAYMENT
		$mode_of_payments = array();
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
      
			$sql = $pdo->prepare("INSERT INTO contract (
				prospect_id,
				acquisition_date,
				renewal_date,
				contract_contact_person,
				contact_number,
				attachment,
				status,
                term_of_payment,
                advance_payment,
                number_of_month,
                mode_of_payment,
                amount,
                security_deposit
			) VALUES (
				:prospect_id,
				:acquisition_date,
				:renewal_date,
				:contract_contact_person,
				:contact_number,
				:attachment,
				:status,
				:term_of_payment,
                :advance_payment,
                :number_of_month,
                :mode_of_payment,
                :amount,
                :security_deposit
			)");
			$sql->bindParam(":prospect_id", $prospect_id);
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

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = '';
            }

            $sql->bindParam(":attachment", $attachment_name);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
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
			systemLog('contract',$id,'add','');

			// notification CONTRACT
			$employees = getTable('employees');
			$users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('contract', $id, $employee['id'], 'employee', 'contract_added');
				}
				foreach ($users as $user) {
					push_notification('contract', $id, $user['id'], 'user', 'contract_added');
				}

			}

			$_SESSION['sys_contract_add_suc'] = renderLang($contract_added);
			header('location: /contract-list');
			
		} else { // error found
			
			$_SESSION['sys_contract_add_err'] = renderLang($form_error);
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