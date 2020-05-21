<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-deposit-edit')) {

        $err = 0;
        $err_msg = renderLang($form_error);

        $id = $_POST['id'];
        $sql = $pdo->prepare("SELECT * FROM daily_deposit WHERE id = :id AND temp_del = 0");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if(!$sql->rowCount()) {
            $err++;
            $err_msg = renderLang($lang_no_data);
        }

        $sub_property_id = $_POST['sub_property_id'];

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

        $deposit_date = '';
        if(isset($_POST['deposit_date'])) {
            $deposit_date = trim($_POST['deposit_date']);
        }

        $total_deposited = '';
        if(isset($_POST['total_deposited'])) {
            $total_deposited = trim($_POST['total_deposited']);
        }

        $reference_ids = array();
        if(isset($_POST['reference_id'])) {
            $reference_ids = $_POST['reference_id'];
        }

        $deposit_slip = array();
        if(isset($_POST['deposit_slip'])) {
            $deposit_slip = $_POST['deposit_slip'];
        }

        $deposit_reference = array();
        if(isset($_POST['deposit_reference'])) {
            $deposit_reference = $_POST['deposit_reference'];
        }

        $payment_type_id = array();
        if(isset($_POST['payment_type_id'])) {
            $payment_type_id = $_POST['payment_type_id'];
        }

        $reference_number = array();
        if(isset($_POST['reference_number'])) {
            $reference_number = $_POST['reference_number'];
        }

        if($err == 0) {

            $sql = $pdo->prepare("UPDATE daily_deposit SET 
                deposit_date = :deposit_date, 
                total_deposited = :total_deposited,
                status = :status
            WHERE id = :id");
            $sql->bindParam(":id", $id);
            $sql->bindParam(":deposit_date", $deposit_date);
            $sql->bindParam(":total_deposited", $total_deposited);
            $sql->bindParam(":status", $status);
            $sql->execute();

            foreach($reference_ids as $key => $reference_id) {
                $sql = $pdo->prepare("SELECT * FROM daily_deposit_reference WHERE id = :id LIMIT 1");
                $sql->bindParam(":id", $reference_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $sql1 = $pdo->prepare("UPDATE daily_deposit_reference SET 
                        deposit_reference = :deposit_reference, 
                        attachments = :attachment
                    WHERE id = :id");
                    $sql1->bindParam(":id", $data['id']);
                    $sql1->bindParam(":deposit_reference", $deposit_reference[$key]);
                    // attachment
                    $attachment_name = $data['attachments'];
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
                    $sql1->bindParam(":attachment", $attachment_name);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO daily_deposit_reference (
                        deposit_id, 
                        deposit_reference, 
                        attachments
                    ) VALUES (
                        :deposit_id, 
                        :deposit_reference, 
                        :attachments
                    )");
                    $sql1->bindParam(":deposit_id", $id);
                    if(strlen($deposit_reference[$key]) != 0 || !empty($_FILES['attachment']['name'][$key])) {

                        $sql1->bindParam(":deposit_reference", $deposit_reference[$key]);
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
                        $sql1->bindParam(":attachments", $attachment_name);
                        $sql1->execute();

                    }
                }
            }

            foreach($payment_type_id as $key => $payment_id) {
                $curr_date = '';
                $pay_status = 0;
                if(strlen(trim($reference_number[$key])) != 0) {
                    $pay_status = 1;
                    $deposited_date = getField('recorded_date', 'daily_collections_payment_types', 'id = '.$payment_id);
                    if(checkVar($deposited_date)) {
                        $curr_date = $deposited_date;
                    } else {
                        $curr_date = formatDate(time(), true);
                    }
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
            systemLog('daily_deposit',$id,'edit','');

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
                push_notification('daily-deposit',$id,$employee,'employee','daily_deposit_update');
            }
            foreach ($users as $user) {
               push_notification('daily-deposit',$id,$user['id'],'user','daily_deposit_update');
            }

            $_SESSION['sys_daily_deposit_edit_suc'] = renderLang($collections_daily_deposit_updated);
            header('location: /edit-daily-deposit/'.$id);

        } else {

            $_SESSION['sys_daily_deposit_edit_err'] = $err_msg;
            header('location: /edit-daily-deposit/'.$id);

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