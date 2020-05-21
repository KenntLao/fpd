<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-deposit-add')) {

        $err = 0;

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        $date = '';
        if(isset($_POST['date'])) {
            $date = trim($_POST['date']);
            if(strlen($date) == 0) {
                $err++;
            }
        }

        $sql1 = $pdo->prepare("SELECT * FROM daily_deposit WHERE sub_property_id = :sub_property_id AND recorded_date = :date");
        $sql1->bindParam(":sub_property_id", $sub_property_id);
        $sql1->bindParam(":date", $date);
        $sql1->execute();
        if(!$sql1->rowCount()) {

            
            $deposit_date = '';
            if(isset($_POST['deposit_date'])) {
                $deposit_date = trim($_POST['deposit_date']);
            }
            
            $total_deposited = '';
            if(isset($_POST['total_deposited'])) {
                $total_deposited = trim($_POST['total_deposited']);
            }
            
            $deposit_reference = array();
            if(isset($_POST['deposit_reference'])) {
                $deposit_reference = $_POST['deposit_reference'];
            }
            
            $payment_type_id = array();
            if(isset($_POST['payment_type_id'])) {
                $payment_type_id = $_POST['payment_type_id'];
            }

            $deposited_date = array();
            if(isset($_POST['deposited_date'])) {
                $deposited_date = $_POST['deposited_date'];
            }

            $deposit_slip = array();
            if(isset($_POST['deposit_slip'])) {
                $deposit_slip = $_POST['deposit_slip'];
            }
            
            $reference_number = array();
            if(isset($_POST['reference_number'])) {
                $reference_number = $_POST['reference_number'];
            }
            
            $deposited_by = $_SESSION['sys_id'];
            $account_mode = $_SESSION['sys_account_mode'];
            
            if($err == 0) {
                
                $sql = $pdo->prepare("INSERT INTO daily_deposit (
                    sub_property_id, 
                    deposit_date, 
                    recorded_date,
                    total_deposited, 
                    deposited_by, 
                    account_mode,
                    status
                ) VALUES (
                    :sub_property_id, 
                    :deposit_date,
                    :recorded_date, 
                    :total_deposited, 
                    :deposited_by, 
                    :account_mode,
                    :status
                )");
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->bindParam(":deposit_date", $deposit_date);
                $sql->bindParam(":recorded_date", $date);
                $sql->bindParam(":total_deposited", $total_deposited);
                $sql->bindParam(":deposited_by", $deposited_by);
                $sql->bindParam(":account_mode", $account_mode);
                $sql->bindParam(":status", $status);
                $sql->execute();
                
                $deposit_id = $pdo->lastInsertId();
                
                $sql = $pdo->prepare("INSERT INTO daily_deposit_reference (
                    deposit_id, 
                    deposit_reference, 
                    attachments
                ) VALUES (
                    :deposit_id, 
                    :deposit_reference, 
                    :attachments
                )");
                $sql->bindParam(":deposit_id", $deposit_id);
                foreach($deposit_reference as $key => $reference) {
                    if(strlen($reference) != 0 || !empty($_FILES['attachment']['name'][$key])) {
                        // deposit reference
                        $sql->bindParam(":deposit_reference", $reference);
                        // attachment
                        $attachment_name = '';
                        if(!empty($_FILES['attachment']['name'][$key])) {
                            
                            if(!is_dir($sys_upload_dir.'daily-deposit')) {
                                mkdir($sys_upload_dir.'daily-deposit', 0755, true);
                            }
                            
                            $file = explode('.', $_FILES['attachment']['name'][$key]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
                            
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
                            
                            $file_tmp = $_FILES['attachment']['tmp_name'][$key];
                            $file_size = $_FILES['attachment']['size'][$key];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'daily-deposit/'.$attachment_name);
                            
                        }
                        $sql->bindParam(":attachments", $attachment_name);
                        $sql->execute();
                        
                    }
                }
                
                foreach($payment_type_id as $key => $payment_id) {
                    $curr_date = "";
                    $pay_status = 0;
                    if(strlen(trim($reference_number[$key])) != 0) {
                        $pay_status = 1;
                        $curr_date = formatDate(time(), true);
                    }

                    $sql = $pdo->prepare("UPDATE daily_collections_payment_types SET 
                    reference_number = :reference_number, 
                    status = :status,
                    recorded_date = :recorded_date,
                    deposit_slip = :deposit_slip
                    WHERE id = :id");
                    $sql->bindParam(":reference_number", $reference_number[$key]);
                    $sql->bindParam(":status", $pay_status);
                    $sql->bindParam(":id", $payment_id);
                    $sql->bindParam(":recorded_date", $curr_date);
                    $sql->bindParam(":deposit_slip", $deposit_slip[$key]);
                    $sql->execute();
                }

                //system log
                systemLog('daily_deposit',$deposit_id,'add','');

                // Push Notification daily deposit
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
                    push_notification('daily-deposit',$deposit_id,$employee['id'],'employee','daily_deposit_add');
                }
                foreach ($users as $user) {
                   push_notification('daily-deposit',$deposit_id,$user['id'],'user','daily_deposit_add');
                }
                
                $_SESSION['sys_daily_deposit_add_suc'] = renderLang($collections_daily_deposit_added);
                header('location: /daily-deposit-list');
                
            } else {

                $_SESSION['sys_daily_deposit_add_err'] = renderLang($form_error);
                header('location: /add-daily-deposit/'.$date.'-'.$sub_property_id);
                
            }

        } else { // existed

            $_SESSION['sys_daily_deposit_add_err'] = renderLang($collections_daily_deposit_existed);
            header('location: /add-daily-deposit/'.$date.'-'.$sub_property_id);

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