<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-PAD-edit')) {

        $err = 0;

        // PCC ID
        $pcc_id = $_POST['id'];

        // PCC
            // prospect id
            $prospect_id = 0;
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                }
            }

            // pcc date
            $pcc_date = '';
            if(isset($_POST['pcc_date'])) {
                $pcc_date = trim($_POST['pcc_date']);
                if(strlen($pcc_date) == 0) {
                    $err++;
                }
            }

            // pcc custodian
            $pcc_custodian = '';
            if(isset($_POST['pcc_custodian'])) {
                $pcc_custodian = trim($_POST['pcc_custodian']);
                if(strlen($pcc_custodian) == 0) {
                }
            }

            // pcc amount
            $pcc_amount = '';
            if(isset($_POST['pcc_amount'])) {
                $pcc_amount = trim($_POST['pcc_amount']);
                if(strlen($pcc_amount) == 0) {
                }
            }

            // TOTAL CASH ON HAND

            // pcc total cash on hand
            $pcc_total_cash = '';
            if(isset($_POST['pcc_total_cash'])) {
                $pcc_total_cash = trim($_POST['pcc_total_cash']);
                if(strlen($pcc_total_cash) == 0) {
                }
            }

            // pcc unreplenished
            $pcc_unreplenished = '';
            if(isset($_POST['pcc_unreplenished'])) {
                $pcc_unreplenished = trim($_POST['pcc_unreplenished']);
                if(strlen($pcc_unreplenished) == 0) {
                }
            }

            // pcc unliquidiated
            $pcc_unliquidated = '';
            if(isset($_POST['pcc_unliquidated'])) {
                $pcc_unliquidated = trim($_POST['pcc_unliquidated']);
                if(strlen($pcc_unliquidated) == 0) {
                }
            }

            // pcc total per count 1
            $pcc_total_per_count1 = '';
            if(isset($_POST['pcc_total_per_count1'])) {
                $pcc_total_per_count1 = trim($_POST['pcc_total_per_count1']);
                if(strlen($pcc_total_per_count1) == 0) {
                }
            }

            // pcc total per count 2
            $pcc_total_per_count2 = '';
            if(isset($_POST['pcc_total_per_count2'])) {
                $pcc_total_per_count2 = trim($_POST['pcc_total_per_count2']);
                if(strlen($pcc_total_per_count2) == 0) {
                }
            }

            // pcc replenished
            $pcc_replenished = '';
            if(isset($_POST['pcc_replenished'])) {
                $pcc_replenished = trim($_POST['pcc_replenished']);
                if(strlen($pcc_replenished) == 0) {
                }
            }

            // pcc total per books
            $pcc_total_per_books = '';
            if(isset($_POST['pcc_total_per_books'])) {
                $pcc_total_per_books = trim($_POST['pcc_total_per_books']);
                if(strlen($pcc_total_per_books) == 0) {
                }
            }

            // pcc overage
            $pcc_overage = '';
            if(isset($_POST['pcc_overage'])) {
                $pcc_overage = trim($_POST['pcc_overage']);
                if(strlen($pcc_overage) == 0) {
                }
            }

            // counted by
            $counted_by = '';
            if(isset($_POST['counted_by'])) {
                $counted_by = trim($_POST['counted_by']);
                if(strlen($counted_by) == 0) {
                }
            }

            // acknowledge by
            $acknowledge_by = '';
            if(isset($_POST['acknowledge_by'])) {
                $acknowledge_by = trim($_POST['acknowledge_by']);
                if(strlen($acknowledge_by) == 0) {
                }
            }

        // PCC CASH
            
            // denomination
            $denomination = array();
            if(isset($_POST['denomination'])) {
                $denomination = $_POST['denomination'];
            }

            // quantity
            $quantity = array();
            if(isset($_POST['quantity'])) {
                $quantity = $_POST['quantity'];
            } 

            // amount
            $amount = array();
            if(isset($_POST['amount'])) {
                $amount = $_POST['amount'];
            }

            // total
            $total = array();
            if(isset($_POST['total'])) {
                $total = $_POST['total'];
            }
            
        // PCC ITEMS

            // item
            $item = array();
            if(isset($_POST['item'])) {
                $item = $_POST['item'];
            }

            // item
            $status_compliance = array();
            if(isset($_POST['status_compliance'])) {
                $status_compliance = $_POST['status_compliance'];
            }

        // PCC CERTIFICATION

            // certify amount
            $certify_amount = '';
            if(isset($_POST['certify_amount'])) {
                $certify_amount = trim($_POST['certify_amount']);
            }

            // certify counted by
            $certify_counted_by = '';
            if(isset($_POST['certify_counted_by'])) {
                $certify_counted_by = trim($_POST['certify_counted_by']);
            }

            // certify date
            $certify_date = '';
            if(isset($_POST['certify_date'])) {
                $certify_date = trim($_POST['certify_date']);
            }

            // certify location
            $certify_location = '';
            if(isset($_POST['certify_location'])) {
                $certify_location = trim($_POST['certify_location']);
            }
            
        // 

        if($err == 0) {

            // Update poa_pad_pcc
            $sql = $pdo->prepare("UPDATE poa_pad_pcc SET 
            prospect_id = :prospect_id, 
            pcc_date = :pcc_date, 
            custodian = :pcc_custodian, 
            amount_of_fund = :pcc_amount, 
            total_cash_on_hand = :pcc_total_cash, 
            unreplenished = :pcc_unreplenished, 
            unliquidated = :pcc_unliquidated, 
            check_replenishment = :pcc_replenished, 
            total_per_count1 = :pcc_total_per_count1, 
            total_per_count2 = :pcc_total_per_count2, 
            total_per_books = :pcc_total_per_books, 
            overage_shortage = :pcc_overage, 
            counted_by = :counted_by, 
            acknowledge_by = :acknowledge_by 
            WHERE id = :id");
            $sql->bindParam(":id", $pcc_id);
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":pcc_date", $pcc_date);
            $sql->bindParam(":pcc_custodian", $pcc_custodian);
            $sql->bindParam(":pcc_amount", $pcc_amount);
            $sql->bindParam(":pcc_total_cash", $pcc_total_cash);
            $sql->bindParam(":pcc_unreplenished", $pcc_unreplenished);
            $sql->bindParam(":pcc_unliquidated", $pcc_unliquidated);
            $sql->bindParam(":pcc_replenished", $pcc_replenished);
            $sql->bindParam(":pcc_total_per_count1", $pcc_total_per_count1);
            $sql->bindParam(":pcc_total_per_count2", $pcc_total_per_count2);
            $sql->bindParam(":pcc_total_per_books", $pcc_total_per_books);
            $sql->bindParam(":pcc_overage", $pcc_overage);
            $sql->bindParam(":counted_by", $counted_by);
            $sql->bindParam(":acknowledge_by", $acknowledge_by);
            $sql->execute();

            // Update poa_pad_pcc_cash
            $sql = $pdo->prepare("UPDATE poa_pad_pcc_cash SET 
                quantity = :quantity, 
                amount = :amount, 
                total = :total 
            WHERE pcc_id = :pcc_id AND denomination = :denomination");
            $sql->bindParam(":pcc_id", $pcc_id);

            foreach($denomination as $key => $denom) {

                $sql->bindParam(":denomination", $denom);
                $sql->bindParam(":quantity", $quantity[$key]);
                $sql->bindParam(":amount", $amount[$key]);
                $sql->bindParam(":total", $total[$key]);
                $sql->execute();

            }

            // Update poa_pad_pcc_items
            $sql = $pdo->prepare("UPDATE poa_pad_pcc_items SET 
            status_compliance = :status_compliance 
            WHERE item_id = :item AND pcc_id = :pcc_id");
            $sql->bindParam(":pcc_id", $pcc_id);

            foreach($item as $key => $item_id) {

                $sql->bindParam(":item", $item_id);
                $sql->bindParam(":status_compliance", $status_compliance[$key]);
                $sql->execute();

            }

            // Update poa_pad_pcc_certification
            $sql = $pdo->prepare("UPDATE poa_pad_pcc_certification SET 
            amount = :certify_amount, 
            counted_by = :certify_counted_by, 
            date = :certify_date, 
            location = :certify_location 
            WHERE pcc_id = :pcc_id");
            $sql->bindParam(":pcc_id", $pcc_id);
            $sql->bindParam(":certify_amount", $certify_amount);
            $sql->bindParam(":certify_counted_by", $certify_counted_by);
            $sql->bindParam(":certify_date", $certify_date);
            $sql->bindParam(":certify_location", $certify_location);
            $sql->execute();


            $_SESSION['sys_pre_operation_audit_pad_suc'] = renderLang($pre_operation_audit_pad_pcc_updated);
            header('location: /operation-audit-pad-list');

        } else {

            $_SESSION['sys_pre_operation_audit_pad_pcc_add_err'] = renderLang($form_error);
            header('location: /edit-pad-pcc-operation-audit/'.$id);

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