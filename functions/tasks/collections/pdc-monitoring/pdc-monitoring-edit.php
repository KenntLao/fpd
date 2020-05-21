<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('pdc-monitoring')) {

        $err = 0;

        $module_id = $_POST['id'];

        $ids = array();
        if(isset($_POST['dcpt_id'])) {
            $ids = $_POST['dcpt_id'];
        }

        $deposit_date = array();
        if(isset($_POST['deposit_date'])) {
            $deposit_date = $_POST['deposit_date'];
        }

        $receipt_type = array();
        if(isset($_POST['receipt_type'])) {
            $receipt_type = $_POST['receipt_type'];
        }

        $receipt_number = array();
        if(isset($_POST['receipt_number'])) {
            $receipt_number = $_POST['receipt_number'];
        }

        if($err == 0) {

            $change_logs = array();

            foreach($ids as $key => $id) {

                $sql = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE id = :id LIMIT 1");
                $sql->bindParam(":id", $id);
                $sql->execute();
                if($sql->rowCount()) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    if(checkVar($receipt_number[$key])) {

                        if ($receipt_number[$key] != $data['reference_number']) {
                            $tmp = 'pdc_receipt_number::'.$data['reference_number'].'=='.$receipt_number[$key];
                            $change_logs[] = $tmp;
                        }
                        if ($receipt_type[$key] != $data['receipt_type']) {
                            $tmp = 'pdc_receipt_type::'.$data['receipt_type'].'=='.$receipt_type[$key];
                            $change_logs[] = $tmp;
                        }
                        if ($deposit_date[$key] != $data['recorded_date']) {
                            $tmp = 'pdc_date_deposited::'.$data['recorded_date'].'=='.$deposit_date[$key];
                            $change_logs[] = $tmp;
                        }
                        if (1 != $data['status']) {
                            $tmp = 'lang_status::'.$data['status'].'==1';
                            $change_logs[] = $tmp;
                        }

                        $sql1 = $pdo->prepare("UPDATE daily_collections_payment_types SET 
                            reference_number = :receipt_number, 
                            receipt_type = :receipt_type,
                            status = '1',
                            recorded_date = :deposited_date
                        WHERE id = :id");
                        $sql1->bindParam(":receipt_number", $receipt_number[$key]);
                        $sql1->bindParam(":receipt_type", $receipt_type[$key]);
                        $sql1->bindParam(":deposited_date", $deposit_date[$key]);
                        $sql1->bindParam(":id", $id);
                        $sql1->execute();

                    }
                    
                }

            }

            if(!empty($change_logs)) {
                
                $_SESSION['sys_pdc_monitoring_add_suc'] = renderLang($pdc_monitoring_saved);
                header('location: /add-pdc-monitoring/'.$module_id);
                
            } else {

                $_SESSION['sys_pdc_monitoring_add_err'] = renderLang($form_no_changes);
                header('location: /add-pdc-monitoring/'.$module_id);

            }


        } else {

            $_SESSION['sys_pdc_monitoring_add_err'] = renderLang($form_error);
            header('location: /add-pdc-monitoring/'.$module_id);

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