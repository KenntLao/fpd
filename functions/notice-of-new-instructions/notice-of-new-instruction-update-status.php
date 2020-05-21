<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    $err_msg = '';
    $err = 0;


    $status = 0;
    if(isset($_POST['status'])) {
        $status = trim($_POST['status']);
    }

    $nni_id = '';
    if(isset($_POST['nni_id'])) {
        $nni_id = trim($_POST['nni_id']);
        if(strlen($nni_id) == 0) {
            $err++;
            $err_msg = 'form_error';
        }
    }

    $assigned = getField('assigned', 'nni', 'id = '.$nni_id);
    if(isset($_POST['assigned'])) {
        $assigned = trim($_POST['assigned']);
    }

    $dep_assigned = 0;
    if(isset($_POST['dep_assigned'])) {
        $dep_assigned = trim($_POST['dep_assigned']);
    }

    $category = '';
    if(isset($_POST['category'])) {
        $category = trim($_POST['category']);
    }


    if($err == 0) {

        if ($status != 5) {

            $sql = $pdo->prepare("UPDATE nni SET 
                status = :status,
                assigned = :assigned
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":assigned", $assigned);
            $sql->bindParam(":id", $nni_id);
            if($sql->execute()) {
                $err_msg = 'success';
                $_SESSION['sys_nni_add_suc'] = renderLang($nni_updated);
            }

        }

    } else {

        $err_msg = 'form_error';

    }

    $prospect_id = getField('prospect_id','nni','id = '.$nni_id);
    
    if ($status == 2) {
        
        //system log
        systemLog('nni',$prospect_id,'update','');

        // notification BDD status = 2(Assigned)
        $users = getTable('users');
        push_notification('nni-status-assigned', $prospect_id, $assigned, 'employee', 'nni_status_assigned_update');
        foreach ($users as $user) {
            push_notification('nni-status-assigned', $prospect_id, $user['id'], 'user', 'nni_status_assigned_update');
        }
    }
    if ($status == 5) {

        // HR
        if($category == 'HR') {

            // HR_total
            $hr_total = 0;
            if(isset($_POST['HR_total'])) {
                $hr_total = trim($_POST['HR_total']);
            }

            $sql = $pdo->prepare("SELECT * FROM nni_hr_tab WHERE nni_id = :nni_id LIMIT 1");
            $sql->bindParam(":nni_id", $nni_id);
            $sql->execute();
            if($sql->rowCount()) {

                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $nni_hr_id = $data['id'];
                $sql1 = $pdo->prepare("UPDATE nni_hr_tab SET 
                    assigned = :hr_assigned,
                    status = '3',
                    budget_total = :hr_total
                WHERE id = :id");
                $sql1->bindParam(":hr_assigned", $dep_assigned);
                $sql1->bindParam(":id", $nni_hr_id);
                $sql1->bindParam(":hr_total", $hr_total);
                $sql1->execute();

            } else {

                $sql1 = $pdo->prepare("INSERT INTO nni_hr_tab (
                    nni_id, 
                    assigned,
                    status,
                    budget_total
                ) VALUES (
                    :nni_id,
                    :assigned,
                    '3',
                    :hr_total
                )");
                $sql1->bindParam(":assigned", $dep_assigned);
                $sql1->bindParam(":nni_id", $nni_id);
                $sql1->bindParam(":hr_total", $hr_total);
                $sql1->execute();

            }

            //system log
            systemLog('nni',$prospect_id,'update','');

            // notification BDD status = 5(For Execution)
            $users = getTable('users');
            push_notification('nni-status-for-execution', $prospect_id, $dep_assigned, 'employee', 'nni_status_for_execution_update');
            foreach ($users as $user) {
                push_notification('nni-status-for-execution', $prospect_id, $user['id'], 'user', 'nni_status_for_execution_update');
            }

        }
        // 

        // IT
        if($category == 'IT') {

            $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id LIMIT 1");
            $sql->bindParam(":nni_id", $nni_id);
            $sql->execute();
            if($sql->rowCount()) {

                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $nni_it_id = $data['id'];
                $sql1 = $pdo->prepare("UPDATE nni_it SET 
                    assigned = :it_assigned,
                    status = '3'
                WHERE id = :id");
                $sql1->bindParam(":it_assigned", $dep_assigned);
                $sql1->bindParam(":id", $nni_it_id);
                $sql1->execute();

            } else {

                $sql1 = $pdo->prepare("INSERT INTO nni_it (
                    nni_id, 
                    assigned,
                    status
                ) VALUES (
                    :nni_id, 
                    :assigned,
                    '3'
                )");
                $sql1->bindParam(":assigned", $dep_assigned);
                $sql1->bindParam(":nni_id", $nni_id);
                $sql1->execute();

            }

            //system log
            systemLog('nni',$prospect_id,'update','');

            // notification BDD status = 5(For Execution)
            $users = getTable('users');
            push_notification('nni-status-for-execution', $prospect_id, $dep_assigned, 'employee', 'nni_status_for_execution_update');
            foreach ($users as $user) {
                push_notification('nni-status-for-execution', $prospect_id, $user['id'], 'user', 'nni_status_for_execution_update');
            }

        } 
        // 

        // CAD
        if($category == 'CAD') {

            // vat_status
            $vat_status = 0;
            if(isset($_POST['vat_status'])) {
                $vat_status = $_POST['vat_status'];
            }

            $sql = $pdo->prepare("SELECT * FROM nni_cad_tab WHERE nni_id = :nni_id LIMIT 1");
            $sql->bindParam(":nni_id", $nni_id);
            $sql->execute();
            if($sql->rowCount()) {

                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $nni_cad_id = $data['id'];
                $sql1 = $pdo->prepare("UPDATE nni_cad_tab SET 
                    assigned = :dep_assigned,
                    status = '3',
                    vat = :vat
                WHERE id = :id");
                $sql1->bindParam(":dep_assigned", $dep_assigned);
                $sql1->bindParam(":id", $nni_cad_id);
                $sql1->bindParam(":vat", $vat_status);
                $sql1->execute();

            } else {

                $sql1 = $pdo->prepare("INSERT INTO nni_cad_tab (
                    nni_id, 
                    assigned,
                    status,
                    vat
                ) VALUES (
                    :nni_id, 
                    :assigned,
                    '3',
                    :vat
                )");
                $sql1->bindParam(":assigned", $dep_assigned);
                $sql1->bindParam(":nni_id", $nni_id);
                $sql1->bindParam(":vat", $vat_status);
                $sql1->execute();

            }

            //system log
            systemLog('nni',$prospect_id,'update','');

            // notification BDD status = 5(For Execution)
            $users = getTable('users');
            push_notification('nni-status-for-execution', $prospect_id,  $dep_assigned, 'employee', 'nni_status_for_execution_update');
            foreach ($users as $user) {
                push_notification('nni-status-for-execution', $prospect_id,  $user['id'], 'user', 'nni_status_for_execution_update');
            }

        }
        // 

        $err_msg = 'success';
        $_SESSION['sys_nni_add_suc'] = renderLang($nni_updated);

    }


} else { // no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    $err_msg = 'no session';
}

echo $err_msg;
?>