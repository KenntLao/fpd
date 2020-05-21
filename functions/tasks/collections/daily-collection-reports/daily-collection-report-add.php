<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-report-add')) {

        $err = 0;

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

        $exist = getField('id', 'daily_collection_reports', 'sub_property_id = '.$sub_property_id.' AND collection_date = '.formatDate($collection_date));
        $sql1 = $pdo->prepare("SELECT * FROM daily_collection_reports WHERE sub_property_id = :sub_property_id AND collection_date = :collection_date LIMIT 1");
        $sql1->bindParam(":sub_property_id", $sub_property_id);
        $sql1->bindParam(":collection_date", $collection_date);
        $sql1->execute();
        if(!$sql1->rowCount()) {

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

            $prepared_by = $_SESSION['sys_id'];
            $account_mode = $_SESSION['sys_account_mode'];

            if($err == 0) {

                $sql = $pdo->prepare("INSERT INTO daily_collection_reports (
                    sub_property_id, 
                    report_date, 
                    collection_date, 
                    grand_total, 
                    prepared_by, 
                    prepared_by_account_mode,
                    status
                ) VALUES (
                    :sub_property_id, 
                    :report_date, 
                    :collection_date, 
                    :grand_total, 
                    :prepared_by, 
                    :account_mode, 
                    :status
                )");
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->bindParam(":report_date", $report_date);
                $sql->bindParam(":collection_date", $collection_date);
                $sql->bindParam(":grand_total", $grand_total);
                $sql->bindParam(":prepared_by", $prepared_by);
                $sql->bindParam(":account_mode", $account_mode);
                $sql->bindParam(":status", $status);
                $sql->execute();

                $collection_report_id = $pdo->lastInsertId();

                $sql = $pdo->prepare("INSERT INTO daily_collection_report_cash_count (
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
                $sql->bindParam(":collection_report_id", $collection_report_id);
                foreach($denomination as $key => $denom) {
                    if(empty($quantity[$key])) {
                        $quantity_val = 0;
                    } else {
                        $quantity_val = $quantity[$key];
                    }
                    $sql->bindParam(":denomination", $denom);
                    $sql->bindParam(":quantity", $quantity_val);
                    $sql->bindParam(":amount", $amount[$key]);
                    $sql->execute();
                }

                // foreach($dc_id as $key => $id) {
                //     $sql = $pdo->prepare("UPDATE daily_collections_payment_types SET 
                //         status = :dc_status 
                //     WHERE id = :id");
                //     $sql->bindParam(":id", $id);
                //     $sql->bindParam(":dc_status", $dc_status[$key]);
                //     $sql->execute();
                // }

                //system log
                systemLog('daily_collection_report',$collection_report_id,'add','');

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
                    push_notification('daily-collection-report',$collection_report_id,$employee,'employee','daily_collection_report_add');
                }
                foreach ($users as $user) {
                   push_notification('daily-collection-report',$collection_report_id,$user['id'],'user','daily_collection_report_add');
                }

                $_SESSION['sys_daily_collection_report_add_suc'] = renderLang($daily_collection_report_added);
                header('location: /daily-collection-reports');

            } else {

                $_SESSION['sys_daily_collection_report_add_err'] = renderLang($form_error);
                header('location: /daily-collection-report-add');
                
            }
    
        } else { // existed
            
            $_SESSION['sys_daily_collection_report_add_err'] = renderLang($daily_collection_report_already_exist);
            header('location: /daily-collection-report-add');

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