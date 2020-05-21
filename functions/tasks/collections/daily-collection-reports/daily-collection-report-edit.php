<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-report-edit')) {

        $err = 0;
        $exist = 0;

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

        $sub_property_id = 0;
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            } else {
                $exist = getField('id', 'sub_properties', 'id = '.$sub_property_id);
                if(checkVar($exist)) {

                } else {
                    $err++;
                }
            }
        }

        $collection_date = '';
        if(isset($_POST['collection_date'])) {
            $collection_date = trim($_POST['collection_date']);
        }

        $id = $_POST['id'];
        $sql1 = $pdo->prepare("SELECT * FROM daily_collection_reports WHERE temp_del = 0 AND id = :id");
        $sql1->bindParam(":id", $id);
        $sql1->execute();
        if($sql1->rowCount()) {

            $_data = $sql1->fetch(PDO::FETCH_ASSOC);

            if($_data['sub_property_id'] != $sub_property_id || $_data['collection_date'] != $collection_date) {

                $exist = getField('id', 'daily_collection_reports', 'sub_property_id = '.$sub_property_id.' AND collection_date = '.formatDate($collection_date));
                $sql2 = $pdo->prepare("SELECT * FROM daily_collection_reports WHERE sub_property_id = :sub_property_id AND collection_date = :collection_date LIMIT 1");
                $sql2->bindParam(":sub_property_id", $sub_property_id);
                $sql2->bindParam(":collection_date", $collection_date);
                $sql2->execute();
                if($sql2->rowCount()) {
                    $err++;
                    $exist++;
                }

            }

            $report_date = '';
            if(isset($_POST['report_date'])) {
                $report_date = trim($_POST['report_date']);
                if(strlen($report_date) == 0) {
                    $err++;
                }
            }

            $dc_id = array();
            if(isset($_POST['dc_id'])) {
                $dc_id = $_POST['dc_id'];
            }

            $dc_status = array();
            if(isset($_POST['daily_collection_status'])) {
                $dc_status = $_POST['daily_collection_status'];
            }

            $grand_total = '';
            if(isset($_POST['grand_total'])) {
                $grand_total = trim($_POST['grand_total']);
            }

            // cash on hand
            $cash_count_id = array();
            if(isset($_POST['cash_count_id'])) {
                $cash_count_id = $_POST['cash_count_id'];
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

            if($err == 0) {

                $change_logs = array();
                
                if($sub_property_id != $_data['sub_property_id']) {
                    $tmp = 'daily_collections_daily_collection_building::'.$_data['sub_property_id'].'=='.$sub_property_id;
                    $change_logs[] = $tmp;
                }
                if($report_date != $_data['report_date']) {
                    $tmp = 'daily_collection_report_date::'.$_data['report_date'].'=='.$report_date;
                    $change_logs[] = $tmp;
                }
                if($collection_date != $_data['collection_date']) {
                    $tmp = 'daily_collection_date::'.$_data['collection_date'].'=='.$collection_date;
                    $change_logs[] = $tmp;
                }
                if($grand_total != $_data['grand_total']) {
                    $tmp = 'daily_collection_report_grand_total::'.$_data['grand_total'].'=='.$grand_total;
                    $change_logs[] = $tmp;
                }
                if($status != $_data['status']) {
                    $tmp = 'lang_status::'.$_data['status'].'=='.$status;
                    $change_logs[] = $tmp;
                }

                $sql = $pdo->prepare("UPDATE daily_collection_reports SET 
                    sub_property_id = :sub_property_id, 
                    report_date = :report_date, 
                    collection_date = :collection_date, 
                    grand_total = :grand_total, 
                    status = :status 
                WHERE id = :id");
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->bindParam(":report_date", $report_date);
                $sql->bindParam(":collection_date", $collection_date);
                $sql->bindParam(":grand_total", $grand_total);
                $sql->bindParam(":status", $status);
                $sql->bindParam(":id", $id);
                $sql->execute();

                foreach($cash_count_id as $key => $bill_id) {

                    $sql = $pdo->prepare("SELECT * FROM daily_collection_report_cash_count WHERE id = :id");
                    $sql->bindParam(":id", $bill_id);
                    $sql->execute();
                    if($sql->rowCount()) { // update

                        $_data = $sql->fetch(PDO::FETCH_ASSOC);

                        if($quantity[$key] != $_data['quantity']) {
                            $tmp = 'pre_operation_audit_pcc_quantity::'.$_data['quantity'].'=='.$quantity[$key];
                            $change_logs[] = $tmp;
                        }
                        if($amount[$key] != $_data['amount']) {
                            $tmp = 'pre_operation_audit_pcc_amount::'.$_data['amount'].'=='.$amount[$key];
                            $change_logs[] = $tmp;
                        }

                        $sql1 = $pdo->prepare("UPDATE daily_collection_report_cash_count SET 
                            quantity = :quantity, 
                            amount = :amount 
                        WHERE id = :id");
                        if(empty($quantity[$key])) {
                            $quantity_val = 0;
                        } else {
                            $quantity_val = $quantity[$key];
                        }
                        $sql1->bindParam(":quantity", $quantity_val);
                        $sql1->bindParam(":amount", $amount[$key]);
                        $sql1->bindParam(":id", $_data['id']);
                        $sql1->execute();

                    } else { // insert

                        $sql1 = $pdo->prepare("INSERT INTO daily_collection_report_cash_count (
                            collection_report_id, 
                            denomination, 
                            quantity, 
                            amount
                        ) VALUES (
                            :collection_report_id, 
                            :denomination, 
                            :quantity, 
                            :amount
                        )");
                        if(empty($quantity[$key])) {
                            $quantity_val = 0;
                        } else {
                            $quantity_val = $quantity[$key];
                        }
                        $sql1->bindParam(":collection_report_id", $id);
                        $sql1->bindParam(":denomination", $denomination[$key]);
                        $sql1->bindParam(":quantity", $quantity_val);
                        $sql1->bindParam(":amount", $amount[$key]);
                        $sql1->execute();

                    }

                }

                if(!empty($change_logs)) {

                    // record to system log
                    $change_log = implode(';;', $change_logs);
                    systemLog('daily_collection_report',$id,'update', $change_log);

                    // Push Notification daily collection report
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
                        push_notification('daily-collection-report',$id,$employee,'employee','daily_collection_report_update');
                    }
                    foreach ($users as $user) {
                        push_notification('daily-collection-report',$id,$user['id'],'user','daily_collection_report_update');
                    }
                    
                    $_SESSION['sys_daily_collection_report_edit_suc'] = renderLang($daily_collection_report_updated);
                    header('location: /daily-collection-reports');

                } else {

                    $_SESSION['sys_daily_collection_report_edit_err'] = renderLang($form_no_changes);
                    header('location: /daily-collection-report-edit/'.$id);

                }

            } else {

                if($exist) {
                    $_SESSION['sys_daily_collection_report_edit_err_exist'] = renderLang($daily_collection_report_already_exist);
                } else {
                    $_SESSION['sys_daily_collection_report_edit_err'] = renderLang($form_error);
                }
                
                header('location: /daily-collection-report-edit/'.$id);
                
            }
    
        } else { // no data fount
            
            $_SESSION['sys_daily_collection_report_edit_err'] = renderLang($lang_no_data);
            header('location: /daily-collection-report-edit/'.$id);

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