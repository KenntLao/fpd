<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-add')) {

        $err = 0;

        // sub_property_id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
        }


        
        $tenant_id = '';
        if(isset($_POST['tenant_id'])) {
            $tenant_ids = $_POST['tenant_id'];
            $tenant_id = implode(',', array_filter($tenant_ids));
        }

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


        // DATE
        $date = '';
        if(isset($_POST['collection_date'])) {
            $date = trim($_POST['collection_date']);
            if(empty($date)) {
                $err++;
                $_SESSION['sys_daily_collection_add_date_err'] = renderLang($daily_collections_daily_collection_date_required);
            } else {
                $_SESSION['sys_daily_collection_add_date_val'] = $date;
            }
        }

        // REFERENCE NO
        $voucher_type = '';
        if(isset($_POST['voucher_type'])) {
            $voucher_type = trim($_POST['voucher_type']);
        }

        $ar_number = '';
        if(isset($_POST['ar_number'])) {
            $ar_number = $_POST['ar_number'];
        }

        $or_number = '';
        if(isset($_POST['or_number'])) {
            $or_number = $_POST['or_number'];
        }

        $pr_number = '';
        if(isset($_POST['pr_number'])) {
            $pr_number = $_POST['pr_number'];
        }

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

        // AMOUNT
        $amount = array();
        if(isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }

        // BANK NAME
        $bank_name = array();
        if(isset($_POST['bank'])) {
            $bank_name = $_POST['bank'];
        }

        $other_bank = array();
        if(isset($_POST['other_bank'])) {
            $other_bank = $_POST['other_bank'];
        }

        $check_number = array();
        if(isset($_POST['check_number'])) {
            $check_number = $_POST['check_number'];
		}

        $date_of_check = array();
        if(isset($_POST['date_of_check'])) {
            $date_of_check = $_POST['date_of_check'];
        }

        $transaction_details = array();
        if(isset($_POST['transaction_details'])) {
            $transaction_details = $_POST['transaction_details'];
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

            $sql = $pdo->prepare("INSERT INTO daily_collections (
                sub_property_id,
                unit_id,
                others,
                tenant_ids,
                collection_date, 
                voucher_type, 
                or_number, 
                ar_number,
                pr_number,
                particulars, 
                attachment,
				deposit_payment_slip_attachment
            ) VALUES (
                :sub_property_id,
                :unit_id,
                :others,
                :tenant_ids,
                :date, 
                :voucher_type, 
                :or_number, 
                :ar_number,
                :pr_number,
                :particulars,
                :attachment,
				:attachment2
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":unit_id", $unit_id);
            $sql->bindParam(":others", $others);
            $sql->bindParam(":tenant_ids", $tenant_id);
            $sql->bindParam(":date", $date);
            $sql->bindParam(":voucher_type", $voucher_type);
            $sql->bindParam(":or_number", $or_number);
            $sql->bindParam(":ar_number", $ar_number);
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
                $attachment_name = '';
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
                $attachment_name2 = '';
            }//

            $sql->bindParam(":attachment2", $attachment_name2);
            $sql->execute();

            $id = $pdo->lastInsertId();

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
                :bank_name,
                :other_bank,
                :check_number,
                :date_of_check,
                :transaction_details
            )");
            $sql2->bindParam(":daily_collection_id", $id);

            foreach ($payment_type as $key => $payment) {

                if (strlen($payment) != 0) {

                    $sql2->bindParam(":payment_type", $payment);
                    $sql2->bindParam(":amount", $amount[$key]);
                    $sql2->bindParam(":bank_name", $bank_name[$key]);
                    $sql2->bindParam(":other_bank", $other_bank[$key]);
                    $sql2->bindParam(":check_number", $check_number[$key]);
                    $sql2->bindParam(":date_of_check", $date_of_check[$key]);
                    $sql2->bindParam(":transaction_details", $transaction_details[$key]);
                    $sql2->execute();

                }
            }

            //system log
            systemLog('daily_collection',$id,'add','');

            // notification add daily collection
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
                push_notification('daily-collection', $id, $employee, 'employee', 'daily_collection_add');
            }
            foreach ($users as $user) {
                push_notification('daily-collection', $id, $user['id'], 'user', 'daily_collection_add');
            }

            
            $_SESSION['sys_daily_collection_add_suc'] = renderLang($daily_collections_daily_collection_added);
            header('location: /daily-collections/1');
        } else {
            $_SESSION['sys_daily_collection_add_err'] = renderLang($form_error);
            header('location: /add-daily-collection');
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