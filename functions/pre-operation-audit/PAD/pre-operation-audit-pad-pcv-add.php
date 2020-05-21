<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('pre-operation-audit-PAD-add')) {

        $err = 0;

        // PCV

        $pcv_category = $_POST['pcv_category'];

            // prospect id
            $prospect_id = '';
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                }
            }

            // pcv audited by
            $pcv_audited_by = '';
            if(isset($_POST['pcv_audited_by'])) {
                $pcv_audited_by = trim($_POST['pcv_audited_by']);
                if(strlen($pcv_audited_by) == 0) {
                }
            }

            // pcv custodian
            $pcv_custodian = '';
            if(isset($_POST['pcv_custodian'])) {
                $pcv_custodian = trim($_POST['pcv_custodian']);
                if(strlen($pcv_custodian) == 0) {
                }
            }

            // pcv building manager
            $pcv_building_manager = '';
            if(isset($_POST['pcv_building_manager'])) {
                $pcv_building_manager = trim($_POST['pcv_building_manager']);
                if(strlen($pcv_building_manager) == 0) {
                }
            }

        // PCV particulars
            
            // pcv date
            $pcv_date = array();
            if(isset($_POST['pcv_date'])) {
                $pcv_date = $_POST['pcv_date'];
                if(empty($pcv_date)) {
                    $err++;
                }
            }

            // pcv payee
            $pcv_payee = array();
            if(isset($_POST['pcv_payee'])) {
                $pcv_payee = $_POST['pcv_payee'];
                if(empty($pcv_payee)) {
                }
            }

            // pcv particulars
            $pcv_particulars = array();
            if(isset($_POST['pcv_particulars'])) {
                $pcv_particulars = $_POST['pcv_particulars'];
                if(empty($pcv_particulars)) {
                }
            }

            // pcv no
            $pcv_no = array();
            if(isset($_POST['pcv_no'])) {
                $pcv_no = $_POST['pcv_no'];
                if(empty($pcv_no)) {
                }
            }

            // pcv amount
            $pcv_amount = array();
            if(isset($_POST['pcv_amount'])) {
                $pcv_amount = $_POST['pcv_amount'];
                if(empty($pcv_amount)) {
                }
            }
        // 

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO poa_pad_pcv (
                prospect_id, 
                accounting_supervisor, 
                pcf_custodian, 
                building_manager,
                category
            ) VALUES (
                :prospect_id,
                :accounting_supervisor, 
                :pcf_custodian, 
                :building_manager,
                :pcv_category
            )");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":accounting_supervisor", $pcv_audited_by);
            $sql->bindParam(":pcf_custodian", $pcv_custodian);
            $sql->bindParam(":building_manager", $pcv_building_manager);
            $sql->bindParam(":pcv_category", $pcv_category);
            $sql->execute();

            $pcv_id = $pdo->lastInsertId();

            $sql = $pdo->prepare("INSERT INTO poa_pad_pcv_particulars (
                pcv_id, 
                date, 
                payee, 
                particulars,
                pcv_no, 
                amount
            ) VALUES (
                :pcv_id, 
                :date, 
                :pcv_payee, 
                :pcv_particulars, 
                :pcv_no, 
                :pcv_amount
            )");
            $sql->bindParam(":pcv_id", $pcv_id);

            foreach($pcv_date as $key => $date) {

                if(!empty($pcv_payee[$key])) {

                    $sql->bindParam(":date", $date);
                    $sql->bindParam(":pcv_payee", $pcv_payee[$key]);
                    $sql->bindParam(":pcv_particulars", $pcv_particulars[$key]);
                    $sql->bindParam(":pcv_no", $pcv_no[$key]);
                    $sql->bindParam(":pcv_amount", $pcv_amount[$key]);
                    $sql->execute();

                    $particular_id = $pdo->lastInsertId();

                    $sql1 = $pdo->prepare("INSERT INTO poa_pad_pcv_findings (
                        particular_id, 
                        legend, 
                        status
                    ) VALUES (
                        :particular_id, 
                        :legend, 
                        :status
                    )");
                    $sql1->bindParam(":particular_id", $particular_id);

                    foreach($pre_op_audit_pcv_legend_arr as $legend_key => $val) {

                        $sql1->bindParam(":legend", $legend_key);
                        $sql1->bindParam(":status", $_POST['findings_'.$legend_key][$key]);
                        $sql1->execute();
                    }
                }
            }

            //systemlog
            systemLog('pre_operations_audit_PAD_PCV',$pcv_id,'add','');

            // push notification 
            $employees = getTable("employees");
            $users = getTable("users");
            foreach ($employees as $employee) {
                push_notification('pre-operations-audit-pad-pcv',$pcv_id,$employee['id'],'employee','pre_operations_audit_pad_pcv_add');
            }
            foreach ($users as $user) {
                push_notification('pre-operations-audit-pad-pcv',$pcv_id,$user['id'],'user','pre_operations_audit_pad_pcv_add');
            }

            $_SESSION['sys_pre_operation_audit_pad_suc'] = renderLang($pre_operation_audit_pad_pcv_saved);
            header('location: /pad-pcv-pre-operation-audit-list');

        } else {

            $_SESSION['sys_pre_operation_audit_pad_pcv_add_err'] = renderLang($form_error);
            header('location: /add-pcv-pre-operation-audit');

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