<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
		$err = 0;
		$table = '';
		$on = '';
		$where = '';	
		// PROCESS FORM


		// move_inout_id
		$move_inout_id = $_SESSION['sys_id'];

		// LOCATION
		$account_type = $_SESSION['sys_account_mode'];

		if ($account_type== 'unit_owner') {
			$table = 'unit_owners';
			$on = 'ON t.id = u.unit_owner_id';
			$where = 'WHERE t.id = '.$move_inout_id;
		}else{
			$table = 'unit_tenants';
			$on = 'ON t.unit_id = u.id JOIN tenants te ON t.tenant_id = te.id';
			$where = 'WHERE t.tenant_id = '.$move_inout_id;
		}


		$sql = $pdo->prepare("SELECT u.id FROM ".$table." t JOIN units u  ".$on." ".$where." LIMIT 1");
		$sql->execute();

		$data = $sql->fetch(PDO::FETCH_ASSOC);
		 if ($sql->rowCount()) {

		 	// UNIT NO
		 	$unit = $data['id'];
		 }else{
		 	$unit ='tbd';
		 }
		
		// PROCESS FORM

		// REQUEST
		$request = '';
		if(isset($_POST['request'])) {
			$request = trim($_POST['request']);
			$_SESSION['sys_user_move_inout_requests_add_request_val'] = $request;
			
		}

		// DATE
		$date = '';
		if(isset($_POST['date'])) {
			$date = ucwords(strtolower(trim($_POST['date'])));
			$_SESSION['sys_user_move_inout_requests_add_date_val'] = $date;
			
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
			$quantity = ucwords(strtolower(trim($_POST['quantity'])));
			$_SESSION['sys_user_move_inout_requests_add_quantity_val'] = $quantity;
			
		}

		// REMARKS 
		$remarks = '';
		if(isset($_POST['remarks'])) {
			$remarks = ucwords(strtolower(trim($_POST['remarks'])));
			$_SESSION['sys_user_move_inout_requests_add_remarks_val'] = $remarks;
			
		}

		// STATUS 
		$status = '';
		if(isset($_POST['status'])) {
			$status = ucwords(strtolower(trim($_POST['status'])));
			$_SESSION['sys_user_move_inout_requests_add_status_val'] = $status;
			
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
      
			$sql = $pdo->prepare("INSERT INTO move_inout_requests (
				request,
				date,
				quantity,
				unit,
				remarks,
				status
			) VALUES (
				:request,
				:date,
				:quantity,
				:unit,
				:remarks,
				:status
				
			)");
			$sql->bindParam(":request", $request);
			$sql->bindParam(":date", $date);
			$sql->bindParam(":quantity", $quantity);
			$sql->bindParam(":unit", $unit);
			$sql->bindParam(":remarks", $remarks);
			$sql->bindParam(":status", $status);
			$sql->execute();

			$id = $pdo->lastInsertId();

			$sql = $pdo->prepare("INSERT INTO move_inout_request_item (
				move_inout_id, 
                item_no, 
                item_description
            ) VALUES (
                :id, 
                :item_no, 
                :description
            )");

            $sql->bindParam(":id", $id);
            foreach($item_no as $key => $item) {

                if(!empty($item)) {
                    $sql->bindParam(":item_no", $item);
                    $sql->bindParam(":description", $description[$key]);
                    $sql->execute();
                }

            }

			
			// record to system log
			systemLog('occupants',$id,'add','');

			$_SESSION['sys_user_move_inout_requests_add_suc'] = renderLang($move_inout_requests_move_inout_request_added);
			header('location: /user-move-inout-requests');
			
		} else { // error found
			
			$_SESSION['sys_user_move_inout_requests_add_err'] = renderLang($form_error);
			header('location: /user-move-inout-request-add');
			
		}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>