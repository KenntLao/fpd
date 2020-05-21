<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-edit')) {

        $err = 0;
        $id = $_POST['id'];

        // SUB PROPERTY ID
        $sub_property_id = $_POST['sub_property_id'];

        // UNIT ID
        $unit_id = '';
        $tenant_id = '';
        if(isset($_POST['unit_id'])) {
            $unit_ids = $_POST['unit_id'];
            $unit_arr = array();
            $tenant_ids = $_POST['tenant_id'];
            $tenant_arr = array();
            
            foreach($unit_ids as $key => $unit) {
                if(!empty($unit)) {
                    $unit_arr[] = $unit;
                    $tenant_arr[] = $tenant_ids[$key];
                }
            }
            $tenant_id = implode(',', $tenant_arr);
            $unit_id = implode(',', $unit_arr);
        }

        $others = '';
        if(isset($_POST['others'])) {
            $other_arr = $_POST['others'];
            $others = implode(',', array_filter($other_arr));
        }
        

        // check if exist
        $sql3 = $pdo->prepare("SELECT * FROM daily_collections WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql3->bindParam(":id", $id);
        $sql3->execute();
        $_data = $sql3->fetch(PDO::FETCH_ASSOC);
        if(!$sql3->rowCount()) {
            $err++;
        }

        // DATE
        $date = '';
        if(isset($_POST['collection_date'])) {
            $date = trim($_POST['collection_date']);
            if(empty($date)) {
                $err++;
                $_SESSION['sys_daily_collection_edit_date_err'] = renderLang($daily_collections_daily_collection_date_required);
            } else {
                $_SESSION['sys_daily_collection_edit_date_val'] = $date;
            }
        }

        // REFERENCE TYPE
        $voucher_type = '';
        if(isset($_POST['voucher_type'])) {
            $voucher_type = $_POST['voucher_type'];
        }


        $ar_number = '';
        $or_number = '';
        $pr_number = '';

        if ($voucher_type == '1') {

            // AR NUMBER
            if(isset($_POST['ar_number'])) {
                $ar_number = $_POST['ar_number'];
            }
        }
        if ($voucher_type == '2') {

            // OR NUMBER
            if(isset($_POST['or_number'])) {
                $or_number = $_POST['or_number'];
            }
        }
        if ($voucher_type == '3') {

            // PR NUMBER
            if(isset($_POST['pr_number'])) {
                $pr_number = $_POST['pr_number'];
            }
        }

        // PARTICULARS
        $particulars = '';
        if(isset($_POST['particulars'])) {
            $particulars_arr = $_POST['particulars'];
            $particulars = implode(', ', array_filter($particulars_arr));
        }

        // PAYMENT TYPE
        $payment_type = array();
        if(isset($_POST['payment_type'])) {
            $payment_type = $_POST['payment_type'];
        }

        // TRANSACTION DETAILS
        $transaction_detail = array();
        if(isset($_POST['transaction_details'])) {
            $transaction_detail = $_POST['transaction_details'];
        }

        // BANK
        $bank = array();
        if(isset($_POST['bank'])) {
            $bank = $_POST['bank'];
        }

        // BANK OTHER
        $other_bank = array();
        if(isset($_POST['other_bank'])) {
            $other_bank = $_POST['other_bank'];
        }

        // CHECK NUMBER
        $check_number = array();
        if(isset($_POST['check_number'])) {
            $check_number = $_POST['check_number'];
        }

        $date_of_check = array();
        if(isset($_POST['date_of_check'])) {
            $date_of_check = $_POST['date_of_check'];
        }

        // AMOUNT
        $amount = array();
        if(isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }

        // dc_id
        $dc_id = array();
        if(isset($_POST['dc_id'])) {
            $dc_id = $_POST['dc_id'];
        }
        
		$attachment = array();
		if(isset($_FILES['attachment']['name'])) {
			$attachment = $_FILES['attachment'];
		}

        $attachment2 = array();
        if(isset($_FILES['attachment2']['name'])) {
            $attachment2 = $_FILES['attachment2'];
        }

        if($err == 0) {

            $change_logs = array();
            if ($unit_id != $_data['unit_id']) {
                $tmp = 'daily_collections_daily_collection_unit::'.$_data['unit_id'].'=='.$unit_id;
                array_push($change_logs, $tmp);
            }
            if ($date != $_data['collection_date']) {
                $tmp = 'daily_collections_daily_collection_date::'.$_data['collection_date'].'=='.$date;
                array_push($change_logs, $tmp);
            }
            if ($voucher_type != $_data['voucher_type']) {
                 $tmp = 'daily_collections_daily_collection_voucher_type::'.$_data['voucher_type'].'=='.$voucher_type;
                 array_push($change_logs, $tmp);
            }
            if ($ar_number != $_data['ar_number']) {
                 $tmp = 'daily_collections_daily_collection_ar::'.$_data['ar_number'].'=='.$ar_number;
                 array_push($change_logs, $tmp);
            }
            if ($or_number != $_data['or_number']) {
                 $tmp = 'daily_collections_daily_collection_or::'.$_data['or_number'].'=='.$or_number;
                 array_push($change_logs, $tmp);
            }
            if ($pr_number != $_data['pr_number']) {
                 $tmp = 'daily_collections_daily_collection_pr::'.$_data['pr_number'].'=='.$pr_number;
                 array_push($change_logs, $tmp);
            }
            if ($particulars != $_data['particulars']) {
                $tmp = 'daily_collection_report_particulars::'.$_data['particulars'].'=='.$particulars;
                array_push($change_logs,$tmp);
            }
            // if ($amount != $_data['amount']) {
            //     $tmp = 'daily_collections_daily_collection_amount::'.$_data['amount'].'=='.$amount;
            //     array_push($change_logs,$tmp);
            // }
            // if ($bank != $_data['bank']) {
            //     $tmp = 'collections_check_voucher_bank::'.$_data['bank'].'=='.$bank;
            //     array_push($change_logs, $tmp);
            // }
            // if ($other_bank != $_data['other_bank']) {
            //     $tmp = 'collections_check_vouchers_other_bank::'.$_data['other_bank'].'=='.$other_bank;
            //     array_push($change_logs, $tmp);
            // }
            // if ($check_number != $_data['check_number']) {
            //     $tmp = 'collections_check_voucher_bank::'.$_data['check_number'].'=='.$check_number;
            //     array_push($change_logs, $tmp);
            // }

            $sql = $pdo->prepare("UPDATE daily_collections SET
                unit_id = :unit_id, 
                others = :others,
                tenant_ids = :tenant_ids,
                collection_date = :collection_date, 
                voucher_type = :voucher_type, 
                ar_number = :ar_number, 
                or_number = :or_number, 
                pr_number = :pr_number,
                particulars = :particulars, 
                attachment = :attachment,
                deposit_payment_slip_attachment = :attachment2
                
            WHERE id = ".$id);
            $sql->bindParam(":unit_id", $unit_id);
            $sql->bindParam(":others", $others);
            $sql->bindParam(":tenant_ids", $tenant_id);
            $sql->bindParam(":collection_date", $date);
            $sql->bindParam(":voucher_type", $voucher_type);
            $sql->bindParam(":ar_number", $ar_number);
            $sql->bindParam(":or_number", $or_number);
            $sql->bindParam(":pr_number", $pr_number);
            $sql->bindParam(":particulars", $particulars);
			
			// attachment
            $attachments_arr = array();
            $attachment_count = count($_FILES['attachment']);

            if(!is_dir($sys_upload_dir.'daily-collection')) {
                mkdir($sys_upload_dir.'daily-collection', 0755, true);
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
                    move_uploaded_file($file_tmp, $sys_upload_dir.'daily-collection/'.$attachment_name);

                    $attachments_arr[] = $attachment_name;
                    
                }

            }

            if(!empty($attachments_arr)) {
                $attachment_name = implode(',', $attachments_arr);
            } else {
                $attachment_name = getField('attachment', 'daily_collections', 'id = '.$id);
            }

            // attachment change log
            if ($attachment_name != $_data['attachment']) {
                $tmp = 'daily_collections_daily_collection_or_ar_pr_attachment::'.$_data['attachment'].'=='.$attachment_name;
                array_push($change_logs,$tmp);
            }

            $sql->bindParam(":attachment", $attachment_name);
            // end attachment

            // attachment2
            $attachments_arr2 = array();
            $attachment_count2 = count($_FILES['attachment2']);

            if(!is_dir($sys_upload_dir.'deposit-payment-slip')) {
                mkdir($sys_upload_dir.'deposit-payment-slip', 0755, true);
            }

            for($i = 0; $i < $attachment_count2; $i++) {

                if(!empty($_FILES['attachment2']['name'][$i])) {
    
                    $file2 = explode('.', $_FILES['attachment2']['name'][$i]);
                    $file_name2 = $file2[0];
                    $file_ext2 = $file2[1];
    
                    $time2 = time();
    
                    $attachment_name2 = $file_name2.'-'.$time2.'.'.$file_ext2;
    
                    $file_tmp2 = $_FILES['attachment2']['tmp_name'][$i];
                    $file_size2 = $_FILES['attachment2']['size'][$i];
                    
                    // save file
                    move_uploaded_file($file_tmp2, $sys_upload_dir.'deposit-payment-slip/'.$attachment_name2);

                    $attachments_arr2[] = $attachment_name2;
                    
                }

            }

            if(!empty($attachments_arr2)) {
                $attachment_name2 = implode(',', $attachments_arr2);
            } else {
                $attachment_name2 = getField('deposit_payment_slip_attachment', 'daily_collections', 'id = '.$id);
            }//

            // attachment change log
            if ($attachment_name2 != $_data['deposit_payment_slip_attachment']) {
                $tmp = 'daily_collections_daily_collection_deposit_payment_slip::'.$_data['deposit_payment_slip_attachment'].'=='.$attachment_name2;
                array_push($change_logs,$tmp);
            }

            $sql->bindParam(":attachment2", $attachment_name2);

            if (count($change_logs) > 0) {

                $sql->execute();

            }

            foreach($dc_id as $key => $key_id) {

                $sql1 = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE id = :id  LIMIT 1");
                $sql1->bindParam(":id", $key_id);
                $sql1->execute();
                if($sql1->rowCount()) {

                    $_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                    $sql2 = $pdo->prepare("UPDATE daily_collections_payment_types SET
                        daily_collection_id = :daily_collection_id,
                        payment_type = :payment_type, 
                        amount = :amount, 
                        bank = :bank,
                        other_bank = :other_bank,
                        check_number = :check_number,
                        date_of_check = :date_of_check,
                        transaction_details = :transaction_details
                    WHERE id = :id");

                    switch ($payment_type[$key]) {
                        case 0:
                           $banks = NULL;
                           $other_banks = NULL;
                           $check_numbers = NULL;
                           $date_of_checks = NULL;
                           $transaction_details = NULL;
                            break;

                        case 1:
                           $banks = $bank[$key];
                           $other_banks = $other_bank[$key];
                           $check_numbers = NULL;
                           $date_of_checks = NULL;
                           $transaction_details = $transaction_detail[$key];
                            break;

                        case 2:
                           $banks = $bank[$key];
                           $other_banks = $other_bank[$key];
                           $check_numbers = $check_number[$key];
                           $date_of_checks = $date_of_check[$key];
                           $transaction_details = NULL;
                            break;

                        case 3:
                           $banks = NULL;
                           $other_banks = NULL;
                           $check_numbers = NULL;
                           $date_of_checks = NULL;
                           $transaction_details = $transaction_detail[$key];
                            break;

                        case 4:
                           $banks = NULL;
                           $other_banks = NULL;
                           $check_numbers = NULL;
                           $date_of_checks = NULL;
                           $transaction_details = $transaction_detail[$key];
                            break;
                        
                        default: 

                            break;
                    }

                        $sql2->bindParam(":id", $key_id);
                        $sql2->bindParam(":daily_collection_id", $id);
                        $sql2->bindParam(":payment_type", $payment_type[$key]);
                        $sql2->bindParam(":amount", $amount[$key]);
                        $sql2->bindParam(":bank", $banks);
                        $sql2->bindParam(":other_bank", $other_banks);
                        $sql2->bindParam(":check_number", $check_numbers);
                        $sql2->bindParam(":date_of_check", $date_of_checks);
                        $sql2->bindParam(":transaction_details", $transaction_details);
                        $sql2->execute();

                } else {

                        $sql2 = $pdo->prepare("INSERT INTO daily_collections_payment_types (
                            daily_collection_id,
                            payment_type, 
                            amount, 
                            bank,
                            other_bank,
                            check_number,
                            date_of_check,
                            transaction_details
                        ) VALUES (
                            :daily_collection_id,
                            :payment_type, 
                            :amount, 
                            :bank,
                            :other_bank,
                            :check_number,
                            :date_of_check,
                            :transaction_details
                        )");

                        if (!empty($payment_type[$key])) {

                            $sql2->bindParam(":daily_collection_id", $id);
                            $sql2->bindParam(":payment_type", $payment_type[$key]);
                            $sql2->bindParam(":amount", $amount[$key]);
                            $sql2->bindParam(":bank", $bank[$key]);
                            $sql2->bindParam(":other_bank", $other_bank[$key]);
                            $sql2->bindParam(":check_number", $check_number[$key]);
                            $sql2->bindParam(":date_of_check", $date_of_check[$key]);
                            $sql2->bindParam(":transaction_details", $transaction_detail[$key]);
                            $sql2->execute();

                        }
                }
            }

            // system log
            $change_log = implode(';;',$change_logs);
            systemLog('daily_collection',$id,'update',$change_log);

            //notification edit daily collection
            $employees = array();
            $sub_property = '%,'.$sub_property_id.',%';
            $sql = $pdo->prepare("SELECT id FROM employees WHERE sub_property_ids LIKE :sub_property");
            $sql->bindParam(":sub_property", $sub_property);
            $sql->execute();
            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                $employees[] = $data['id'];
            }
            $cluster_id = getSubPropertyCluster($sub_property_id);
            if(checkVar($cluster_id)) {
                $cluster_assigned = getField('assigned', 'clusters', 'id = '.$cluster_id);
                if($cluster_assigned) {
                    if(!in_array($cluster_assigned, $employees)) {
                        $employees[] = $cluster_assigned;
                    }
                }
            }
            $users = getTable("users");
            foreach ($employees as $employee) {
                push_notification('daily-collection', $id, $employee, 'employee', 'daily_collection_updated');
            }
            foreach ($users as $user) {
                push_notification('daily-collection', $id, $user['id'], 'user', 'daily_collection_updated');
            }

            $_SESSION['sys_daily_collection_edit_suc'] = renderLang($daily_collections_updated);
            header('location: /daily-collections/1');
        } else {
            $_SESSION['sys_daily_collection_edit_err'] = renderLang($form_error);
            header('location: /edit-daily-collection/'.$id);
        }

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');
    
    }

} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');
  
}
?>