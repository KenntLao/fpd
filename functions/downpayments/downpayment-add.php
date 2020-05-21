<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('billing-advice-add')) {
	
		$err = 0;
		
		// PROCESS FORM

        // PROJECT NAME
        $project_name = '';
        $contact_person = '';
        $contact_details = '';

        $reference_number = '';
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) != 0) {
                $sql = $pdo->prepare("SELECT reference_number, project_name, contact_person, telephone, mobile_number, email_address FROM prospecting WHERE id = :id");
                $sql->bindParam(":id", $prospect_id);
                $sql->execute();
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $reference_number = $data['reference_number'];
                $project_name = $data['project_name'];

                // contact person
                $contact_person = $data['contact_person'];
                $contact_details = (!empty($data['telephone']) ? $data['telephone'] : '').(!empty($data['mobile_number']) ? ';'.$data['mobile_number'] : '').(!empty($data['email_address']) ? ';'.$data['email_address'] : '');

            }
        }

        // check if property already created
        $ref_num = $reference_number.'%';
        $sql1 = $pdo->prepare("SELECT id FROM properties WHERE property_id LIKE :reference_number");
        $sql1->bindParam(":reference_number", $ref_num);
        $sql1->execute();

        $prospect_count = $sql1->rowCount();


		// PROPERTY CODE
		$property_code = '';
		if(isset($_POST['property_code'])) {
			$property_code = strtoupper(trim($_POST['property_code']));
            $_SESSION['sys_downpayment_add_property_code_val'] = $property_code;
            if(strlen($property_code) != 0) {
                if(strpos($reference_number ,'-')) {
                    $property = explode('-', $reference_number);
                    $reference_number = $property[0].'-'.$property_code;
                } else {
                    $reference_number = $reference_number.'-'.$property_code;
                }
                

            } else {
                $err++;
            }

        } 

		// AMOUNT
		$amount = '';
		if(isset($_POST['amount'])) {
			$amount = trim($_POST['amount']);
			$_SESSION['sys_downpayment_add_amount_val'] = $amount;
			
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			$_SESSION['sys_downpayment_add_date_val'] = $date;
			
		}

		// OR
		$or_num = '';
		if(isset($_POST['or_num'])) {
			$or_num = trim($_POST['or_num']);
			$_SESSION['sys_downpayment_add_or_num_val'] = $or_num;
			
		}
	
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO downpayments (
				prospect_id,
				amount,
				date,
				or_num,
                attachment
			) VALUES (
				:prospect_id,
				:amount,
				:date,
				:or_num,
                :attachment
				
			)");
			$sql->bindParam(":prospect_id", $prospect_id);
			$sql->bindParam(":amount", $amount);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":or_num", $or_num);
            
             // attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            // create directory
            if(!is_dir($sys_upload_dir.'downpayments')) {
                mkdir($sys_upload_dir.'downpayments', 0755, true);
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
                    move_uploaded_file($file_tmp, $sys_upload_dir.'downpayments/'.$attachment_name);

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
            
            $sql = $pdo->prepare("UPDATE prospecting SET 
            reference_number = :reference_number WHERE id = :id");
            $sql->bindParam(":reference_number", $reference_number);
            $sql->bindParam(":id", $prospect_id);
            $sql->execute();

            // check if already created
            if(!$prospect_count) {

                // add client from prospecting to clients
                $sql = $pdo->prepare("INSERT INTO clients (
                    client_id, 
                    client_name, 
                    contact_person, 
                    contact_details
                ) VALUES (
                    :client_id, 
                    :client_name, 
                    :contact_person, 
                    :contact_details
                )"); 

                $client_id = getField('client_id', 'clients', '1=1 ORDER BY id DESC');
                if(empty($client_id)) {
                    $client_id = '1001';
                } else {
                    $client_id++;
                }

                $sql->bindParam(":client_id", $client_id);
                $sql->bindParam(":client_name", $contact_person);
                $sql->bindParam(":contact_person", $contact_person);
                $sql->bindParam(":contact_details", $contact_details);
                $sql->execute();

                $client_id = $pdo->lastInsertId();

                // add prospect to properties
                $sql = $pdo->prepare("INSERT INTO properties (
                    property_id,
                    prospect_id,
                    property_code, 
                    property_name, 
                    client_id
                ) VALUES (
                    :property_id,
                    :prospect_id,
                    :property_code, 
                    :property_name, 
                    :client_id
                )");

                $sql->bindParam(":property_id", $reference_number);
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->bindParam(":property_code", $property_code);
                $sql->bindParam(":property_name", $project_name);
                $sql->bindParam(":client_id", $client_id);
                $sql->execute();

            }
			
			// record to system log
			systemLog('billing_advice',$id,'add','');

            //notification DOWNPAYMENT
            $employees = getTable('employees');
            $users = getTable('users');
                foreach ($employees as $employee) {
                    push_notification('billing-advice', $id, $employee['id'], 'employee', 'downpayment_add');
                }
                foreach ($users as $user) {
                    push_notification('billing-advice', $id, $user['id'], 'user', 'downpayment_add');
                }

			$_SESSION['sys_downpayment_add_suc'] = renderLang($downpayment_added);
			header('location: /downpayments');
			
		} else { // error found
			
			$_SESSION['sys_downpayment_add_err'] = renderLang($form_error);
			header('location: /add-downpayment');
			
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