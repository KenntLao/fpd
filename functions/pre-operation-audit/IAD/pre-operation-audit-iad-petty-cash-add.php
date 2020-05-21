<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-IAD-add')) {

        $err = 0;

        $category = $_POST['category'];

        // collections
            // prospect_id
            $prospect_id = '';
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                }
            }

            // custodian
            $custodian = '';
            if(isset($_POST['custodian'])) {
                $custodian = trim($_POST['custodian']);
                if(strlen($custodian) == 0) {
                    $err++;
                }
            }

            // amount of fund
            $amount_of_fund = '';
            if(isset($_POST['amount_of_fund'])) {
                $amount_of_fund = trim($_POST['amount_of_fund']);
                if(strlen($amount_of_fund) == 0) {
                    $err++;
                }
            }

        // BILLS

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

            // bills total
            $bills_total = '';
            if(isset($_POST['bills_total'])) {
                $bills_total = trim($_POST['bills_total']);
            }

        // CHECKS
            
            // OR/AT no
            $check_or = array();
            if(isset($_POST['check_or'])) {
                $check_or = $_POST['check_or'];
            }

            // bank
            $check_bank = array();
            if(isset($_POST['check_bank'])) {
                $check_bank = $_POST['check_bank'];
            }

            // date
            $check_date = array();
            if(isset($_POST['check_date'])) {
                $check_date = $_POST['check_date'];
            }

            // amount
            $check_amount = array();
            if(isset($_POST['check_amount'])) {
                $check_amount = $_POST['check_amount'];
            }

            // checks total
            $checks_total = '';
            if(isset($_POST['checks_total'])) {
                $checks_total = $_POST['checks_total'];
            }
        // TOTALS
            
            // total_bills
            $total_bills = '';
            if(isset($_POST['total_bills'])) {
                $total_bills = trim($_POST['total_bills']);
            }

            // total_checks
            $total_checks = '';
            if(isset($_POST['total_checks'])) {
                $total_checks = trim($_POST['total_checks']);
            }

            // total_per_count1
            $total_per_count1 = '';
            if(isset($_POST['total_per_count1'])) {
                $total_per_count1 = trim($_POST['total_per_count1']);
            }

            // total_others
            $total_others = '';
            if(isset($_POST['total_others'])) {
                $total_others = trim($_POST['total_others']);
            }

            // total_to_be_counted_for
            $total_to_be_counted_for = '';
            if(isset($_POST['total_to_be_counted_for'])) {
                $total_to_be_counted_for = trim($_POST['total_to_be_counted_for']);
            }

            // total_per_count2
            $total_per_count2 = '';
            if(isset($_POST['total_per_count2'])) {
                $total_per_count2 = trim($_POST['total_per_count2']);
            }

            // total_overage
            $total_overage = '';
            if(isset($_POST['total_overage'])) {
                $total_overage = trim($_POST['total_overage']);
            }

        // INITIAL FINDINGS

            // item
            $item = array();
            if(isset($_POST['item'])) {
                $item = $_POST['item'];
            }

            // initial_remarks
            $initial_remarks = array();
            if(isset($_POST['initial_remarks'])) {
                $initial_remarks = $_POST['initial_remarks'];
            }

            // compliance
            $compliance = array();
            if(isset($_POST['compliance'])) {
                $compliance = $_POST['compliance'];
            }

        // CERTIFICATION

            // certify_type
            $certify_type = '';
            if(isset($_POST['certify_type'])) {
                $certify_type = trim($_POST['certify_type']);
            }

            // certify_amount
            $certify_amount = '';
            if(isset($_POST['certify_amount'])) {
                $certify_amount = trim($_POST['certify_amount']);
            }

            // certify_counted_by
            $certify_counted_by = '';
            if(isset($_POST['certify_counted_by'])) {
                $certify_counted_by = trim($_POST['certify_counted_by']);
            }

            // certify_date
            $certify_date = '';
            if(isset($_POST['certify_date'])) {
                $certify_date = trim($_POST['certify_date']);
            }

            // certify_location
            $certify_location = '';
            if(isset($_POST['certify_location'])) {
                $certify_location = trim($_POST['certify_location']);
            }

        // ACKNOWLEDGEMENT

            // counted_by
            $counted_by = '';
            if($_POST['counted_by']) {
                $counted_by = trim($_POST['counted_by']);
            }

            // acknowledge_by
            $acknowledge_by = '';
            if(isset($_POST['acknowledge_by'])) {
                $acknowledge_by = trim($_POST['acknowledge_by']);
            }

        // 

        if($err == 0) {

            // COLLECTION
                $sql = $pdo->prepare("INSERT INTO count_sheet_collections (
                    prospect_id, 
                    cashier, 
                    counted_by, 
                    account_mode, 
                    acknowledge_by, 
                    category
                ) VALUES (
                    :prospect_id, 
                    :cashier, 
                    :counted_by, 
                    :account_mode, 
                    :acknowledge_by, 
                    :category
                )");
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->bindParam(":cashier", $cashier);
                $sql->bindParam(":counted_by", $counted_by);
                $sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
                $sql->bindParam(":acknowledge_by", $acknowledge_by);
                $sql->bindParam(":category", $category);
                $sql->execute();

                $collection_id = $pdo->lastInsertId();
            // 

            // bills
                $sql = $pdo->prepare("INSERT INTO count_sheet_collection_bills (
                    collection_id, 
                    denomination, 
                    quantity, 
                    amount, 
                    total
                ) VALUES (
                    :collection_id, 
                    :denomination, 
                    :quantity, 
                    :amount, 
                    :total
                )");

                $sql->bindParam(":collection_id", $collection_id);

                foreach($denomination as $key => $denom) {

                    $sql->bindParam(":denomination", $denom);
                    $sql->bindParam(":quantity", $quantity[$key]);
                    $sql->bindParam(":amount", $amount[$key]);
                    $sql->bindParam(":total", $total[$key]);
                    $sql->execute();

                }
            // 

            // checks
                if($category == 'on-hand-collection') {

                    $sql = $pdo->prepare("INSERT INTO count_sheet_collection_checks (
                        collection_id, 
                        or_no, 
                        bank, 
                        date, 
                        amount
                    ) VALUES (
                        :collection_id, 
                        :or_no, 
                        :bank, 
                        :date, 
                        :amount
                    )");
                    $sql->bindParam(":collection_id", $collection_id);

                    foreach($check_or as $key => $or) {

                        if(!empty($or)) {
                            $sql->bindParam(":or_no", $or);
                            $sql->bindParam(":bank", $check_bank[$key]);
                            $sql->bindParam(":date", $check_date[$key]);
                            $sql->bindParam(":amount", $check_amount[$key]);
                            $sql->execute();
                        }

                    }

                }
            // 

            // totals
                $sql = $pdo->prepare("INSERT INTO count_sheet_collection_totals (
                    collection_id, 
                    bills_total, 
                    checks_total, 
                    total_bills_coins, 
                    total_checks, 
                    total_per_count_1, 
                    total_to_be_counted_for, 
                    total_per_count_2, 
                    total_overage, 
                    total_others
                ) VALUES (
                    :collection_id, 
                    :bills_total, 
                    :checks_total, 
                    :total_bills_coins, 
                    :total_checks, 
                    :total_per_count_1, 
                    :total_to_be_counted_for, 
                    :total_per_count_2, 
                    :total_overage, 
                    :total_others
                )");
                $sql->bindParam(":collection_id", $collection_id);
                $sql->bindParam(":bills_total", $bills_total);
                $sql->bindParam(":checks_total", $checks_total);
                $sql->bindParam(":total_bills_coins", $total_bills);
                $sql->bindParam(":total_checks", $total_checks);
                $sql->bindParam(":total_per_count_1", $total_per_count1);
                $sql->bindParam(":total_to_be_counted_for", $total_to_be_counted_for);
                $sql->bindParam(":total_per_count_2", $total_per_count2);
                $sql->bindParam(":total_overage", $total_overage);
                $sql->bindParam(":total_others", $total_others);
                $sql->execute();
            // 

            // FINDINGS

                $sql = $pdo->prepare("INSERT INTO count_sheet_collection_initial_finding (
                    collection_id, 
                    initial_finding, 
                    remarks, 
                    compliance
                ) VALUES (
                    :collection_id, 
                    :initial_finding, 
                    :remarks, 
                    :compliance
                )");
                $sql->bindParam(":collection_id", $collection_id);

                foreach($item as $key => $finding) {

                    $sql->bindParam(":initial_finding", $finding);
                    $sql->bindParam(":remarks", $initial_remarks[$key]);
                    $sql->bindParam(":compliance", $compliance[$key]);
                    $sql->execute();

                }

            // 

            // CERTIFICATION
                
                $sql = $pdo->prepare("INSERT INTO count_sheet_collection_certification (
                    collection_id, 
                    type, 
                    amount, 
                    counted_by, 
                    date, 
                    location
                ) VALUES (
                    :collection_id, 
                    :type, 
                    :amount, 
                    :counted_by, 
                    :date, 
                    :location
                )");
                $sql->bindParam(":collection_id", $collection_id);
                $sql->bindParam(":type", $certify_type);
                $sql->bindParam(":amount", $certify_amount);
                $sql->bindParam(":counted_by", $certify_counted_by);
                $sql->bindParam(":date", $certify_date);
                $sql->bindParam(":location", $certify_location);
                $sql->execute();

                // system log
                systemLog('pre_operation_audit_iad', $collection_id,'add','');

                // notification add PRE OPERATION AUDIT
                $employees = getTable('employees');
                $users = getTable('users');
				foreach ($employees as $employee) {
					push_notification('pre-operation-audit-iad', $collection_id, $employee['id'], 'employee', 'pre_operation_audit_iad_add');
				}
				foreach ($users as $user) {
					push_notification('pre-operation-audit-iad', $collection_id, $user['id'], 'user', 'pre_operation_audit_iad_add');
				}

            $_SESSION['sys_pre_operation_audit_iad_add_suc'] = renderLang($pre_operation_audit_iad_collection_saved);
            header('location: /add-iad-on-hand-collection');

        } else {

            $_SESSION['sys_pre_operation_audit_iad_collection_add_err'] = renderLang($form_error);
            header('location: /add-iad-on-hand-collection');

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