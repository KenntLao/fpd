<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('move-inout-request-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// sub property id
		$sub_property_id = '';
		if(isset($_POST['sub_property_id'])) {
			$sub_property_id = trim($_POST['sub_property_id']);
			
		}

		// REQUEST
		$request = '';
		if(isset($_POST['request'])) {
			$request = trim($_POST['request']);
			$_SESSION['sys_move_inout_requests_add_request_val'] = $request;
			
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			$_SESSION['sys_move_inout_requests_add_date_val'] = $date;
			
		}

		// ITEM NUMBER
		$item_no = array();
		if(isset($_POST['item_no'])) {
			$item_no = $_POST['item_no'];
		}

		// description
		$description = array();
		if(isset($_POST['description'])) {
			$description = $_POST['description'];
		}

		// QUANTITY
		$quantity = '';
		if(isset($_POST['quantity'])) {
			$quantity = trim($_POST['quantity']);
			$_SESSION['sys_move_inout_requests_add_quantity_val'] = $quantity;
			
		}

		// PERSON / MATERIAL
		$person_material = '';
		if(isset($_POST['person_material'])) {
			$person_material = trim($_POST['person_material']);
			$_SESSION['sys_move_inout_requests_add_person_material_val'] = $person_material;

		}
		

		// UNIT
		$unit = '';
		if(isset($_POST['unit'])) {
			$unit = trim($_POST['unit']);
			$_SESSION['sys_move_inout_requests_add_unit_val'] = $unit;
			
		}

		// REMARKS 
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_move_inout_requests_add_remarks_val'] = $remarks;
			
		}

		// STATUS 
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_move_inout_requests_add_status_val'] = $status;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO move_inout_requests (
				sub_property_id,
				request,
				date,
				quantity,
				person_material,
				unit,
				remarks,
				status,
				attachment
			) VALUES (
				:sub_property_id,
				:request,
				:date,
				:quantity,
				:person_material,
				:unit,
				:remarks,
				:status,
				:attachment
				
			)");
			$sql->bindParam(":sub_property_id", $sub_property_id);
			$sql->bindParam(":request", $request);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":quantity", $quantity);
			$sql->bindParam(":person_material", $person_material);
			$sql->bindParam(":unit", $unit);
			$sql->bindParam(":remarks", $remarks);
			$sql->bindParam(":status", $status);

			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            if(!is_dir($sys_upload_dir.'move-inout-requests')) {
                mkdir($sys_upload_dir.'move-inout-requests', 0755, true);
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
                    move_uploaded_file($file_tmp, $sys_upload_dir.'move-inout-requests/'.$attachment_name);

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

			$sql2 = $pdo->prepare("INSERT INTO move_inout_request_item (
				move_inout_id, 
                item_no, 
                item_description,
                code
            ) VALUES (
                :id, 
                :item_no, 
                :description,
                :code
            )");

            $sql2->bindParam(":id", $id);
            $code = $unit.$id.'1';

            foreach($item_no as $key => $item) {

                if(!empty($item)) {
                    $sql2->bindParam(":item_no", $item);
                    $sql2->bindParam(":description", $description[$key]);
                    $sql2->bindParam(":code", $code);
                    $sql2->execute();

                    $code++;
                }

            }

			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_move_inout_requests_add_suc'] = renderLang($move_inout_requests_move_inout_request_added);
			header('location: /move-inout-requests');
			
		} else { // error found
			
			$_SESSION['sys_move_inout_requests_add_err'] = renderLang($form_error);
			header('location: /add-move-inout-request');
			
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