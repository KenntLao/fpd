<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-edit')) {

        $err = 0;

        $id = $_POST['id'];

        $sql2 = $pdo->prepare("SELECT * FROM fund_count_sheet WHERE id = :id");
        $sql2->bindParam(":id", $id);
        $sql2->execute();
        if($sql2->rowCount()) {

            $status = 0;
            if(isset($_POST['status'])) {
                $status = trim($_POST['status']);
            }

            // FUND COUNT SHEET DATA
                $property_id = '';
                if(isset($_POST['property_id'])) {
                    $property_id = trim($_POST['property_id']);
                    if(strlen($property_id) == 0) {
                        $err++;
                    }
                }

                $custodian = '';
                if(isset($_POST['custodian'])) {
                    $custodian = trim($_POST['custodian']);
                }

                $amount_of_fund = '';
                if(isset($_POST['amount_of_fund'])) {
                    $amount_of_fund = trim($_POST['amount_of_fund']);
                }

                $acknowledge_by = '';
                if(isset($_POST['acknowledge_by'])) {
                    $acknowledge_by = trim($_POST['acknowledge_by']);
                }

                $user_id = $_SESSION['sys_id'];
                $account_mode = $_SESSION['sys_account_mode'];
            // 

            // BILLS DATA

                $bills_id = array();
                if(isset($_POST['bills_id'])) {
                    $bills_id = $_POST['bills_id'];
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

            // 

            // UNREPLENISHED VOUCHERS

                $findings_recommendations = '';
                if(isset($_POST['findings_recommendations'])) {
                    $findings_recommendations = trim($_POST['findings_recommendations']);
                }

                $voucher_custodian = '';
                if(isset($_POST['voucher_custodian'])) {
                    $voucher_custodian = trim($_POST['voucher_custodian']);
                }

                $voucher_building_manager = '';
                if(isset($_POST['voucher_building_manager'])) {
                    $voucher_building_manager = trim($_POST['voucher_building_manager']);
                }

                // PAYMENTS
                    $voucher_findings_id = array();
                    if(isset($_POST['voucher_findings_id'])) {
                        $voucher_findings_id = $_POST['voucher_findings_id'];
                    }

                    $voucher_dates = array();
                    if(isset($_POST['voucher_date'])) {
                        $voucher_dates = $_POST['voucher_date'];
                    }
                    
                    $voucher_payee = array();
                    if(isset($_POST['voucher_payee'])) {
                        $voucher_payee = $_POST['voucher_payee'];
                    }

                    $voucher_particulars = array();
                    if(isset($_POST['voucher_particulars'])) {
                        $voucher_particulars = $_POST['voucher_particulars'];
                    }

                    $voucher_pcv_no = array();
                    if(isset($_POST['voucher_pcv_no'])) {
                        $voucher_pcv_no = $_POST['voucher_pcv_no'];
                    }

                    $voucher_amount = array();
                    if(isset($_POST['voucher_amount'])) {
                        $voucher_amount = $_POST['voucher_amount'];
                    }

                    foreach($petty_cash_unreplenished_legend_arr as $key => $legend) {
                        ${'voucher_findings_'.$key} = array();
                        if(isset($_POST['voucher_findings_'.$key])) {
                            ${'voucher_findings_'.$key} = $_POST['voucher_findings_'.$key];
                        }
                    }

                // 
            // 

            // UNLIQUIDATED ADVANCES
                $advances_custodian = '';
                if(isset($_POST['advances_custodian'])) {
                    $advances_custodian = trim($_POST['advances_custodian']);
                }

                $advances_building_manager = '';
                if(isset($_POST['advances_building_manager'])) {
                    $advances_building_manager = trim($_POST['advances_building_manager']);
                }

                // PAYMENTS
                    $advances_findings_id = array();
                    if(isset($_POST['advances_findings_id'])) {
                        $advances_findings_id = $_POST['advances_findings_id'];
                    }

                    $advances_dates = array();
                    if(isset($_POST['advances_date'])) {
                        $advances_dates = $_POST['advances_date'];
                    }
                    
                    $advances_payee = array();
                    if(isset($_POST['advances_payee'])) {
                        $advances_payee = $_POST['advances_payee'];
                    }

                    $advances_particulars = array();
                    if(isset($_POST['advances_particulars'])) {
                        $advances_particulars = $_POST['advances_particulars'];
                    }

                    $advances_pcv_no = array();
                    if(isset($_POST['advances_pcv_no'])) {
                        $advances_pcv_no = $_POST['advances_pcv_no'];
                    }

                    $advances_amount = array();
                    if(isset($_POST['advances_amount'])) {
                        $advances_amount = $_POST['advances_amount'];
                    }

                    foreach($petty_cash_advances_lengend_arr as $key => $legend) {
                        ${'advances_findings_'.$key} = array();
                        if(isset($_POST['advances_findings_'.$key])) {
                            ${'advances_findings_'.$key} = $_POST['advances_findings_'.$key];
                        }
                    }

                // 
            //

            // TOTALs DATA

                $bills_total = '';
                if(isset($_POST['bills_total'])) {
                    $bills_total = trim($_POST['bills_total']);
                }

                $unreplenished_pcv = '';
                if(isset($_POST['unreplenished_pcv'])) {
                    $unreplenished_pcv = trim($_POST['unreplenished_pcv']);
                }

                $unliquidated_advances = '';
                if(isset($_POST['unliquidated_advances'])) {
                    $unliquidated_advances = trim($_POST['unliquidated_advances']);
                }

                $total_per_count1 = '';
                if(isset($_POST['total_per_count1'])) {
                    $total_per_count1 = trim($_POST['total_per_count1']);
                }

                $total_others = '';
                if(isset($_POST['total_others'])) {
                    $total_others = trim($_POST['total_others']);
                }

                $total_per_books = '';
                if(isset($_POST['total_per_books'])) {
                    $total_per_books = trim($_POST['total_per_books']);
                }

                $total_per_count2 = '';
                if(isset($_POST['total_per_count2'])) {
                    $total_per_count2 = trim($_POST['total_per_count2']);
                }

                $overage = '';
                if(isset($_POST['overage'])) {
                    $overage = trim($_POST['overage']);
                }

            // 

            // INITIAL FINDINGS DATA

                $findings_id = array();
                if(isset($_POST['findings_id'])) {
                    $findings_id = $_POST['findings_id'];
                }

                $items = array();
                if(isset($_POST['item'])) {
                    $items = $_POST['item'];
                }

                $remarks = array();
                if(isset($_POST['remarks'])) {
                    $remarks = $_POST['remarks'];
                }

                $findings = array();
                if(isset($_POST['findings'])) {
                    $findings = $_POST['findings'];
                }

            // 

            // CERTIFICATION DATA
            
                $certify_type = '';
                if(isset($_POST['certify_type'])) {
                    $certify_type = trim($_POST['certify_type']);
                }
            
                $certify_amount = '';
                if(isset($_POST['certify_amount'])) {
                    $certify_amount = trim($_POST['certify_amount']);
                }

                $certify_amount_value = '';
                if(isset($_POST['certify_amount_value'])) {
                    $certify_amount_value = trim($_POST['certify_amount_value']);
                }

                $certify_counted_by = '';
                if(isset($_POST['certify_counted_by'])) {
                    $certify_counted_by = trim($_POST['certify_counted_by']);
                }

                $certify_date = '';
                if(isset($_POST['certify_date'])) {
                    $certify_date = trim($_POST['certify_date']);
                }

                $certify_location = '';
                if(isset($_POST['certify_location'])) {
                    $certify_location = trim($_POST['certify_location']);
                }

            // 

            if($err == 0) {

                // fund count sheet
                    $sql = $pdo->prepare("UPDATE fund_count_sheet SET 
                        property_id = :property_id, 
                        custodian = :custodian, 
                        amount_of_fund = :amount_of_fund, 
                        acknowledge_by = :acknowledge_by,
                        unreplenished_recommendation = :unreplenished_recommendation,
                        unreplenished_custodian = :unreplenished_custodian,
                        unreplenished_building_manager = :unreplenished_building_manager,
                        unliquidated_custodian = :unliquidated_custodian,
                        unliquidated_building_manager = :unliquidated_building_manager,
                        status = :status 
                    WHERE id = :id");
                    $sql->bindParam(":id", $id);
                    $sql->bindParam(":property_id", $property_id);
                    $sql->bindParam(":custodian", $custodian);
                    $sql->bindParam(":amount_of_fund", $amount_of_fund);
                    $sql->bindParam(":acknowledge_by", $acknowledge_by);
                    $sql->bindParam(":unreplenished_recommendation", $findings_recommendations);
                    $sql->bindParam(":unreplenished_custodian", $voucher_custodian);
                    $sql->bindParam(":unreplenished_building_manager", $voucher_building_manager);
                    $sql->bindParam(":unliquidated_custodian", $advances_custodian);
                    $sql->bindParam(":unliquidated_building_manager", $advances_building_manager);
                    $sql->bindParam(":status", $status);
                    $sql->execute();
                // 

                // bills
                    foreach($bills_id as $key => $bill_id) {
                        $sql = $pdo->prepare("SELECT * FROM fund_count_sheet_bills WHERE id = :id");
                        $sql->bindParam(":id", $bill_id);
                        $sql->execute();
                        if($sql->rowCount()) { // update
                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                            $sql1 = $pdo->prepare("UPDATE fund_count_sheet_bills SET 
                                quantity = :quantity, 
                                amount = :amount 
                            WHERE id = :id");
                            $sql1->bindParam(":id", $bill_id);
                            $sql1->bindParam(":quantity", $quantity[$key]);
                            $sql1->bindParam(":amount", $amount[$key]);
                            $sql1->execute();

                        } else { // insert
                            $sql1 = $pdo->prepare("INSERT INTO fund_count_sheet_bills (
                                fund_count_sheet_id, 
                                denomination, 
                                quantity, 
                                amount
                            ) VALUES (
                                :fund_count_sheet_id, 
                                :denomination, 
                                :quantity, 
                                :amount
                            )");
                            $sql1->bindParam(":fund_count_sheet_id", $id);
                            $sql1->bindParam(":denomination", $denomination[$key]);
                            $sql1->bindParam(":quantity", $quantity[$key]);
                            $sql1->bindParam(":amount", $amount[$key]);
                            $sql1->execute();
                        }
                    }
                // 

                // unreplenished vouchers
                    foreach($voucher_findings_id as $key => $payment_id) {
                        $sql = $pdo->prepare("SELECT * FROM fund_count_sheet_unreplenished WHERE id = :id LIMIT 1");
                        $sql->bindParam(":id", $payment_id);
                        $sql->execute();
                        if($sql->rowCount()) { // update
                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                            $sql1 = $pdo->prepare("UPDATE fund_count_sheet_unreplenished SET 
                                date = :date, 
                                payee = :payee, 
                                particulars = :particulars, 
                                pcv_no = :pcv_no, 
                                amount = :amount, 
                                findings = :findings 
                            WHERE id = :id");
                            $sql1->bindParam(":id", $data['id']);
                            $sql1->bindParam(":date", $voucher_dates[$key]);
                            $sql1->bindParam(":payee", $voucher_payee[$key]);
                            $sql1->bindParam(":particulars", $voucher_particulars[$key]);
                            $sql1->bindParam(":pcv_no", $voucher_pcv_no[$key]);
                            $sql1->bindParam(":amount", $voucher_amount[$key]);
                            
                            $findings_arr = array();
                            foreach($petty_cash_unreplenished_legend_arr as $legend_key => $legend) {
                                $findings_arr[] = $legend_key.':'.${'voucher_findings_'.$legend_key}[$key];
                            }
                            $voucher_findings = implode(',', $findings_arr);
    
                            $sql1->bindParam(":findings", $voucher_findings);
                            $sql1->execute();

                        } else { // insert

                            $sql1 = $pdo->prepare("INSERT INTO fund_count_sheet_unreplenished (
                                fund_count_sheet_id, 
                                date, 
                                payee, 
                                particulars, 
                                pcv_no, 
                                amount, 
                                findings
                            ) VALUES (
                                :fund_count_sheet_id, 
                                :date, 
                                :payee, 
                                :particulars, 
                                :pcv_no, 
                                :amount, 
                                :findings
                            )");
                            $sql1->bindParam(":fund_count_sheet_id", $id);
                            $sql1->bindParam(":date", $voucher_dates[$key]);
                            $sql1->bindParam(":payee", $voucher_payee[$key]);
                            $sql1->bindParam(":particulars", $voucher_particulars[$key]);
                            $sql1->bindParam(":pcv_no", $voucher_pcv_no[$key]);
                            $sql1->bindParam(":amount", $voucher_amount[$key]);
                            
                            $findings_arr = array();
                            foreach($petty_cash_unreplenished_legend_arr as $legend_key => $legend) {
                                $findings_arr[] = $legend_key.':'.${'voucher_findings_'.$legend_key}[$key];
                            }
                            $voucher_findings = implode(',', $findings_arr);
    
                            $sql1->bindParam(":findings", $voucher_findings);
                            $sql1->execute();

                        }
                    }
                // 

                // unliquidated advances
                    foreach($advances_findings_id as $key => $payment_id) {
                        $sql = $pdo->prepare("SELECT * FROM fund_count_sheet_unliquidated WHERE id = :id LIMIT 1");
                        $sql->bindParam(":id", $payment_id);
                        $sql->execute();
                        if($sql->rowCount()) { // update
                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                            $sql1 = $pdo->prepare("UPDATE fund_count_sheet_unliquidated SET 
                                date = :date, 
                                payee = :payee, 
                                particulars = :particulars, 
                                pcv_number = :pcv_number, 
                                amount = :amount, 
                                findings = :findings 
                            WHERE id = :id");
                            $sql1->bindParam(":id", $data['id']);
                            $sql1->bindParam(":date", $advances_dates[$key]);
                            $sql1->bindParam(":payee", $advances_payee[$key]);
                            $sql1->bindParam(":particulars", $advances_particulars[$key]);
                            $sql1->bindParam(":pcv_number", $advances_pcv_no[$key]);
                            $sql1->bindParam(":amount", $advances_amount[$key]);
                            
                            $findings_arr = array();
                            foreach($petty_cash_advances_lengend_arr as $legend_key => $legend) {
                                $findings_arr[] = $legend_key.':'.${'advances_findings_'.$legend_key}[$key];
                            }
                            $advances_findings = implode(',', $findings_arr);
    
                            $sql1->bindParam(":findings", $advances_findings);
                            $sql1->execute();

                        } else { // insert

                            $sql1 = $pdo->prepare("INSERT INTO fund_count_sheet_unliquidated (
                                fund_count_sheet_id, 
                                date, 
                                payee, 
                                particulars, 
                                pcv_number, 
                                amount, 
                                findings
                            ) VALUES (
                                :fund_count_sheet_id, 
                                :date, 
                                :payee, 
                                :particulars, 
                                :pcv_number, 
                                :amount, 
                                :findings
                            )");
                            $sql1->bindParam(":fund_count_sheet_id", $id);
                            $sql1->bindParam(":date", $advances_dates[$key]);
                            $sql1->bindParam(":payee", $advances_payee[$key]);
                            $sql1->bindParam(":particulars", $advances_particulars[$key]);
                            $sql1->bindParam(":pcv_number", $advances_pcv_no[$key]);
                            $sql1->bindParam(":amount", $advances_amount[$key]);
                            
                            $findings_arr = array();
                            foreach($petty_cash_advances_lengend_arr as $legend_key => $legend) {
                                $findings_arr[] = $legend_key.':'.${'advances_findings_'.$legend_key}[$key];
                            }
                            $advances_findings = implode(',', $findings_arr);
    
                            $sql1->bindParam(":findings", $advances_findings);
                            $sql1->execute();
                        }
                    }
                // 

                // totals
                    $sql = $pdo->prepare("UPDATE fund_count_sheet_total SET 
                        total_bills = :total_bills, 
                        unreplenished_pcv = :unreplenished_pcv, 
                        unliquidated_advances = :unliquidated_advances, 
                        others = :others, 
                        total_per_count = :total_per_count, 
                        total_per_book = :total_per_book, 
                        overage_shortage = :overage 
                    WHERE fund_count_sheet_id = :id");
                    $total_per_counts = implode(':', array($total_per_count1, $total_per_count2));
                    $sql->bindParam(":id", $id);
                    $sql->bindParam(":total_bills", $bills_total);
                    $sql->bindParam(":unreplenished_pcv", $unreplenished_pcv);
                    $sql->bindParam(":unliquidated_advances", $unliquidated_advances);
                    $sql->bindParam(":others", $total_others);
                    $sql->bindParam(":total_per_count", $total_per_counts);
                    $sql->bindParam(":total_per_book", $total_per_books);
                    $sql->bindParam(":overage", $overage);
                    $sql->execute();
                // 

                // initial findings
                    foreach($findings_id as $key => $finding_id) {
                        $sql = $pdo->prepare("SELECT * FROM fund_count_sheet_findings WHERE id = :id");
                        $sql->bindParam(":id", $finding_id);
                        $sql->execute();
                        if($sql->rowCount()) {
                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                            $sql1 = $pdo->prepare("UPDATE fund_count_sheet_findings SET 
                                remarks = :remarks, 
                                compliance = :compliance 
                            WHERE id = :id");
                            $sql1->bindParam(":id", $finding_id);
                            $sql1->bindParam(":remarks", $remarks[$key]);
                            $sql1->bindParam(":compliance", $findings[$key]);
                            $sql1->execute();

                        } else {

                            $sql = $pdo->prepare("INSERT INTO fund_count_sheet_findings (
                                fund_count_sheet_id, 
                                item, 
                                remarks, 
                                compliance
                            ) VALUES (
                                :fund_count_sheet_id, 
                                :item, 
                                :remarks, 
                                :compliance
                            )");
                            $sql->bindParam(":fund_count_sheet_id", $id);
                            $sql->bindParam(":item", $items[$key]);
                            $sql->bindParam(":remarks", $remarks[$key]);
                            $sql->bindParam(":compliance", $findings[$key]);
                            $sql->execute();

                        }
                    }
                // 

                // certification
                    $sql = $pdo->prepare("UPDATE fund_count_sheet_certification SET 
                        type = :type, 
                        amount_text = :amount,
                        amount_currency = :amount_currency,
                        counted_by = :counted_by, 
                        date = :date, 
                        location = :location
                    WHERE fund_count_sheet_id = :id");
                    $sql->bindParam(":id", $id);
                    $sql->bindParam(":type", $certify_type);
                    $sql->bindParam(":amount", $certify_amount);
                    $sql->bindParam(":amount_currency", $certify_amount_value);
                    $sql->bindParam(":counted_by", $certify_counted_by);
                    $sql->bindParam(":date", $certify_date);
                    $sql->bindParam(":location", $certify_location);
                    $sql->execute();
                // 

                $_SESSION['sys_fund_count_sheet_edit_suc'] = renderLang($petty_cash_fund_count_sheet_updated);
                header('location: /edit-fund-count-sheet/'.$id);

            } else {

                $_SESSION['sys_fund_count_sheet_edit_err'] = renderLang($form_error);
                header('location: /edit-fund-count-sheet/'.$id);

            }

        } else { // no data
            $_SESSION['sys_fund_count_sheet_err'] = renderLang($lang_no_data);
            header('location: /fund-count-sheet-list');
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