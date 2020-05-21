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

        // check if exist
        $sql = $pdo->prepare("SELECT * FROM poa_pad_pcc WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $pcc_id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }

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

            $change_logs = array();
            if ($pcc_date != $_data['pcc_date']) {
                $tmp = 'pre_operation_audit_pcc_date::'.$_data['pcc_date'].'=='.$pcc_date;
                array_push($change_logs,$tmp);
            }
            if ($pcc_custodian != $_data['custodian']) {
                $tmp = 'pre_operation_audit_pcc_custodian::'.$_data['custodian'].'=='.$pcc_custodian;
                array_push($change_logs,$tmp);
            }
            if ($pcc_amount != $_data['amount_of_fund']) {
                $tmp = 'pre_operation_audit_pcc_amount_of_fund::'.$_data['amount_of_fund'].'=='.$pcc_amount;
                array_push($change_logs,$tmp);
            }
            if ($pcc_total_cash != $_data['total_cash_on_hand']) {
                $tmp = 'pre_operation_audit_pcc_total_cash_on_hand::'.$_data['total_cash_on_hand'].'=='.$pcc_total_cash;
                array_push($change_logs,$tmp);
            }
            if ($pcc_unreplenished != $_data['unreplenished']) {
                $tmp = 'pre_operation_audit_pcc_unreplenished::'.$_data['unreplenished'].'=='.$pcc_unreplenished;
                array_push($change_logs,$tmp);
            }
            if ($pcc_unliquidated != $_data['unliquidated']) {
                $tmp = 'pre_operation_audit_pcc_unliquidated::'.$_data['unliquidated'].'=='.$pcc_unliquidated;
                array_push($change_logs,$tmp);
            }
            if ($pcc_replenished != $_data['check_replenishment']) {
                $tmp = 'pre_operation_audit_pcc_replenishment::'.$_data['check_replenishment'].'=='.$pcc_replenished;
                array_push($change_logs,$tmp);
            }
            if ($pcc_total_per_count1 != $_data['total_per_count1']) {
                $tmp = 'pre_operation_audit_pcc_total_per_count::'.$_data['total_per_count1'].'=='.$pcc_total_per_count1;
                array_push($change_logs,$tmp);
            }
            if ($pcc_total_per_count2 != $_data['total_per_count2']) {
                $tmp = 'pre_operation_audit_pcc_total_per_count::'.$_data['total_per_count2'].'=='.$pcc_total_per_count2;
                array_push($change_logs,$tmp);
            }
            if ($pcc_total_per_books != $_data['total_per_books']) {
                $tmp = 'pre_operation_audit_pcc_total_per_books::'.$_data['total_per_books'].'=='.$pcc_total_per_books;
                array_push($change_logs,$tmp);
            }
            if ($pcc_overage != $_data['overage_shortage']) {
                $tmp = 'pre_operation_audit_pcc_over_age::'.$_data['overage_shortage'].'=='.$pcc_overage;
                array_push($change_logs,$tmp);
            }
            if ($counted_by != $_data['counted_by']) {
                $tmp = 'pre_operation_audit_pcc_counted_by::'.$_data['counted_by'].'=='.$counted_by;
                array_push($change_logs,$tmp);
            }
            if ($acknowledge_by != $_data['acknowledge_by']) {
                $tmp = 'pre_operation_audit_pcc_acknowledge_by::'.$_data['acknowledge_by'].'=='.$acknowledge_by;
                array_push($change_logs,$tmp);
            }

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
            foreach($denomination as $key => $denom) {

                // check if exist
                $sql2 = $pdo->prepare("SELECT * FROM poa_pad_pcc_cash WHERE pcc_id = :pcc_id");
                $sql2->bindParam(":pcc_id", $pcc_id);
                $sql2->execute();
                $_data2 = $sql2->fetch(PDO::FETCH_ASSOC);
                if(!$sql2->rowCount()) {
                    $err++;
                }

                if ($quantity[$key] != $_data2['quantity']) {
                    $tmp = 'pre_operation_audit_pcc_quantity::'.$_data2['quantity'].'=='.$quantity[$key];
                    array_push($change_logs,$tmp);
                }
                if ($amount[$key] != $_data2['amount']) {
                    $tmp = 'pre_operation_audit_pcc_amount::'.$_data2['amount'].'=='.$amount[$key];
                    array_push($change_logs,$tmp);
                }
                if ($total[$key] != $_data2['total']) {
                    $tmp = 'pre_operation_audit_pcc_total::'.$_data2['total'].'=='.$total[$key];
                    array_push($change_logs,$tmp);
                }

                $sql = $pdo->prepare("UPDATE poa_pad_pcc_cash SET 
                    quantity = :quantity, 
                    amount = :amount, 
                    total = :total 
                WHERE pcc_id = :pcc_id AND denomination = :denomination");
                $sql->bindParam(":pcc_id", $pcc_id);
                $sql->bindParam(":denomination", $denom);
                $sql->bindParam(":quantity", $quantity[$key]);
                $sql->bindParam(":amount", $amount[$key]);
                $sql->bindParam(":total", $total[$key]);
                $sql->execute();

            }

        // Update poa_pad_pcc_items
            foreach($item as $key => $item_id) {

                // check if exist
                $sql2 = $pdo->prepare("SELECT * FROM poa_pad_pcc_items WHERE pcc_id = :pcc_id AND item_id = :item_id");
                $sql2->bindParam(":pcc_id", $pcc_id);
                $sql2->bindParam(":item_id", $item_id);
                $sql2->execute();
                $_data2 = $sql2->fetch(PDO::FETCH_ASSOC);
                if(!$sql2->rowCount()) {
                    $err++;
                }

                if ($status_compliance[$key] != $_data2['status_compliance']) {
                    $tmp = 'pre_operation_audit_pcc_status_compliance::'.$_data2['status_compliance'].'=='.$status_compliance[$key];
                    array_push($change_logs,$tmp);
                }


                $sql = $pdo->prepare("UPDATE poa_pad_pcc_items SET 
                status_compliance = :status_compliance 
                WHERE item_id = :item AND pcc_id = :pcc_id");
                $sql->bindParam(":pcc_id", $pcc_id);
                $sql->bindParam(":item", $item_id);
                $sql->bindParam(":status_compliance", $status_compliance[$key]);
                $sql->execute();

            }

            // check if exist
            $sql2 = $pdo->prepare("SELECT * FROM poa_pad_pcc_certification WHERE pcc_id = :pcc_id");
            $sql2->bindParam(":pcc_id", $pcc_id);
            $sql2->execute();
            $_data2 = $sql2->fetch(PDO::FETCH_ASSOC);
            if(!$sql2->rowCount()) {
                $err++;
            }

            if ($certify_amount != $_data2['amount']) {
               $tmp = 'pre_operation_audit_pcc_amount::'.$_data2['amount'].'=='.$certify_amount;
               array_push($change_logs,$tmp);
            }
            if ($certify_counted_by != $_data2['counted_by']) {
                $tmp = 'pre_operation_audit_pcc_counted_by::'.$_data2['counted_by'].'=='.$certify_counted_by;
                array_push($change_logs,$tmp);
            }
            if ($certify_date != $_data2['date']) {
                $tmp = 'pre_operation_audit_pcc_date::'.$_data2['date'].'=='.$certify_date;
                array_push($change_logs,$tmp);
            }
            if ($certify_location != $_data2['location']) {
                $tmp = 'pre_operation_audit_tsa_location::'.$_data2['location'].'=='.$certify_location;
                array_push($change_logs,$tmp);
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


            if (count($change_logs) > 0) {

                //systemlog
                $change_log = implode(';;',$change_logs);
                systemLog('pre_operation_audit_PAD_PCC',$pcc_id,'update',$change_log);

                // notification UPDATE PRE OPERATION AUDIT PCC
                $employees = getTable('employees');
                $users = getTable('users');
                foreach ($employees as $employee) {
                    push_notification('pre-operation-audit-pad-pcc', $pcc_id, $employee['id'], 'employee', 'pre_operation_audit_pad_pcc_update');
                }
                foreach ($users as $user) {
                    push_notification('pre-operation-audit-pad-pcc', $pcc_id, $user['id'], 'user', 'pre_operation_audit_pad_pcc_update');
                }

                $_SESSION['sys_pre_operation_audit_pad_suc'] = renderLang($pre_operation_audit_pad_pcc_updated);
                header('location: /pad-pcc-pre-operation-audit-list');

            } else {

                    $_SESSION['sys_pre_operation_audit_pad_pcc_edit_err'] = renderLang($form_no_changes);
                    header('location: /edit-pcc-pre-operation-audit/'.$pcc_id);
            }

        } else {

            $_SESSION['sys_pre_operation_audit_pad_pcc_add_err'] = renderLang($form_error);
            header('location: /edit-pcc-pre-operation-audit/'.$pcc_id);

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