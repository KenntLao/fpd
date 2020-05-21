<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('move-inout-request-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// PROCESS FORM

		// REQUEST
		$request = '';
		if(isset($_POST['request'])) {
			$request = trim($_POST['request']);
			$_SESSION['sys_move_inout_requests_edit_request_val'] = $request;
			
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
			$_SESSION['sys_move_inout_requests_edit_date_val'] = $date;
			
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
			$_SESSION['sys_move_inout_requests_edit_quantity_val'] = $quantity;
			
		}
		// PERSON / MATERIAL
		$person_material = '';
		if(isset($_POST['person_material'])) {
			$person_material = trim($_POST['person_material']);
			$_SESSION['sys_move_inout_requests_edit_person_material_val'] = $person_material;
			
		}

		// UNIT
		$unit = '';
		if(isset($_POST['unit'])) {
			$unit = trim($_POST['unit']);
			$_SESSION['sys_move_inout_requests_edit_unit_val'] = $unit;
			
		}

		// REMARKS 
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = trim($_POST['remarks']);
			$_SESSION['sys_move_inout_requests_edit_remarks_val'] = $remarks;
			
		}

		// STATUS 
		$status = '';
		if(isset($_POST['status'])) {
			$status = trim($_POST['status']);
			$_SESSION['sys_move_inout_requests_edit_status_val'] = $status;
			
		}
		
		$code = $_POST['code'];

		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("UPDATE move_inout_requests SET
				request = :request,
				date = :date,
				quantity = :quantity,
				person_material = :person_material,
				unit = :unit,
				remarks = :remarks,
				status = :status,
				attachment = :attachment
			 WHERE id = :id");
			$sql->bindParam(":request", $request);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":quantity", $quantity);
			$sql->bindParam(":person_material", $person_material);
			$sql->bindParam(":unit", $unit);
			$sql->bindParam(":remarks", $remarks);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":id", $id);

			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);
            if($attachment_count > 0) {

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
                
            }//count

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = getField('attachment', 'move-inout-requests', 'id = '.$id);
            }

            $sql->bindParam(":attachment", $attachment_name);
			$sql->execute();

			$sql = $pdo->prepare("SELECT code FROM move_inout_request_item WHERE move_inout_id = :id");
			$sql->bindParam(":id", $id);
			$sql->execute();
			$codes = array();
			while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $codes[] = $data['code'];
                }

            	foreach($code as $key => $cd) {

                    if(in_array($cd, $codes)) { // update

                        $sql = $pdo->prepare("SELECT * FROM move_inout_request_item WHERE code = :code LIMIT 1");
                        $sql->bindParam(":code", $cd);
                        $sql->execute();
                        $_data2 = $sql->fetch(PDO::FETCH_ASSOC);
                        if(!$sql->rowCount()) {
                            $err2++;
                        }

                            $sql1 = $pdo->prepare("UPDATE move_inout_request_item SET 
                                item_no = :item_no, 
                                item_description = :description
                            WHERE code = :code");
                            $sql1->bindParam(":item_no", $item_no[$key]);
                            $sql1->bindParam(":description", $description[$key]);
                            $sql1->bindParam(":code", $cd);
                            $sql1->execute();
                

                    } else { // insert
                        
                        if(!empty($item_no[$key])) {
                            // inser to prf_departments
                            $sql1 = $pdo->prepare("INSERT INTO move_inout_request_item (
                                move_inout_id, 
                                item_no, 
                                item_description,
                                code
                            ) VALUES (
                                :move_inout_id,
                                :item_no, 
                                :description,
                                :code
                            )");
                            $sql1->bindParam(":move_inout_id", $id);
                            $sql1->bindParam(":item_no", $item_no[$key]);
                            $sql1->bindParam(":description", $description[$key]);
                            $sql1->bindParam(":code", $cd);
                            $sql1->execute();
                        }
                        
                    }

                }

			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_move_inout_requests_edit_suc'] = renderLang($move_inout_requests_updated);
			header('location: /move-inout-requests');
			
		} else { // error found
			
			$_SESSION['sys_move_inout_requests_edit_err'] = renderLang($form_error);
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