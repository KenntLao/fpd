<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$department = '';
if(isset($_POST['department'])) {
    $department = trim($_POST['department']);
}

$user_id = $_SESSION['sys_id'];
$account_mode = $_SESSION['sys_account_mode'];

$nni_id = '';
if(isset($_POST['nni_id'])) {
    $nni_id = trim($_POST['nni_id']);
}

$prospect_id = getField('prospect_id', 'nni', 'id = '.$nni_id);

// HR information
if($department == 'HR') {

    $status = '';
    if(isset($_POST['nni_hr_status'])) {
        $status = trim($_POST['nni_hr_status']);
    }

    // HR budget Total
    $total = '';
    if(isset($_POST['HR_total'])) {
        $total = trim($_POST['HR_total']);
    }

    // nni hr id
    $nni_hr_id = array();
    if(isset($_POST['nni_hr_id'])) {
        $nni_hr_id = $_POST['nni_hr_id'];
    }

    // MANPOWER PLANTILLA
    $manpower_plantilla = array();
    if(isset($_POST['manpower_plantilla'])) {
        $manpower_plantilla = $_POST['manpower_plantilla']; 
    }

    // HEAD COUNT
    $head_count = array();
    if(isset($_POST['head_count'])) {
        $head_count = $_POST['head_count'];
    }

    // BUDGET BASE PAY
    $budget_base_pay = array();
    if(isset($_POST['budget_base_pay'])) {
        $budget_base_pay = $_POST['budget_base_pay'];
    }

    // BUDGET ALLOWANCE
    $budget_allowance = array();
    if(isset($_POST['budget_allowance'])) {
        $budget_allowance = $_POST['budget_allowance'];
    }

    // COMPENSATION
    $compensation = array();
    if(isset($_POST['compensation'])) {
        $compensation = $_POST['compensation'];
    }

    // GMB
    $gmb = array();
    if(isset($_POST['gmb'])) {
        $gmb = $_POST['gmb'];
    }

    // CIB
    $cib = array();
    if(isset($_POST['cib'])) {
        $cib = $_POST['cib'];
    }

    // LC TOTAL
    $lc_total = array();
    if(isset($_POST['lc_total'])) {
        $lc_total = $_POST['lc_total'];
    }

    // DEPLOYMENT DATE
    $deployment_date = array();
    if(isset($_POST['deployment_date'])) {
        $deployment_date = $_POST['deployment_date'];
    }

    $prf_name = array();
    if(isset($_POST['prf_name'])) {
        $prf_name = $_POST['prf_name'];
    }

    // SPECIAL QUALIFICATION
    $special_qualification = array();
    if(isset($_POST['special_qualification'])) {
        $special_qualification = $_POST['special_qualification'];
    }

    // HR REMARKS
    $hr_remarks = array();
    if(isset($_POST['hr_remarks'])) {
        $hr_remarks = $_POST['hr_remarks'];
    }

    $sql = $pdo->prepare("SELECT * FROM nni_hr_tab WHERE nni_id = :nni_id");
    $sql->bindParam(":nni_id", $nni_id);
    $sql->execute();
    if($sql->rowCount()) {
        
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $sql1 = $pdo->prepare("UPDATE nni_hr_tab SET 
            status = :status, 
            user_id = :user_id, 
            account_mode = :account_mode,
            budget_total = :total 
        WHERE id = :id");
        $sql1->bindParam(":status", $status);
        $sql1->bindParam(":user_id", $user_id);
        $sql1->bindParam(":account_mode", $account_mode);
        $sql1->bindParam(":id", $data['id']);
        $sql1->bindParam(":total", $total);
        $sql1->execute();

    } else {

        $sql1 = $pdo->prepare("INSERT INTO nni_hr_tab (
            nni_id, 
            status, 
            user_id, 
            account_mode,
            budget_total
        ) VALUES (
            :nni_id, 
            :status, 
            :user_id, 
            :account_mode
            :total
        )");
        $sql1->bindParam(":nni_id", $nni_id);
        $sql1->bindParam(":status", $status);
        $sql1->bindParam(":user_id", $user_id);
        $sql1->bindParam(":account_mode", $account_mode);
        $sql1->bindParam(":total", $total);
        $sql1->execute();

    }

    foreach($_POST['nni_hr_id'] as $key => $hr_id) {

        // check if existed
        $sql = $pdo->prepare("SELECT * FROM nni_hr WHERE id = :hr_id");
        $sql->bindParam(":hr_id", $hr_id);
        $sql->execute();
        if($sql->rowCount()) { // existed update

            $sql1 = $pdo->prepare("UPDATE nni_hr SET 
                manpower_plantilla = :manpower_plantilla, 
                head_count = :head_count, 
                budget_base_pay = :budget_base_pay, 
                budget_allowance = :budget_allowance,
                total_compensation = :compensation,
                total_gmb = :gmb,
                total_cib = :cib,
                total_lc = :lc_total,
                deployment_date = :deployment_date, 
                special_qualification = :special_qualification,
                name = :name,
                remarks = :hr_remarks 
            WHERE id = :hr_id");
            $sql1->bindParam(":hr_id",$hr_id);
            $sql1->bindParam(":manpower_plantilla", $manpower_plantilla[$key]);
            $sql1->bindParam(":head_count", $head_count[$key]);
            $sql1->bindParam(":budget_base_pay", $budget_base_pay[$key]);
            $sql1->bindParam(":budget_allowance", $budget_allowance[$key]);
            $sql1->bindParam(":compensation", $compensation[$key]);
            $sql1->bindParam(":gmb", $gmb[$key]);
            $sql1->bindParam(":cib", $cib[$key]);
            $sql1->bindParam(":lc_total", $lc_total[$key]);
            $sql1->bindParam(":deployment_date", $deployment_date[$key]);
            $sql1->bindParam(":special_qualification", $special_qualification[$key]);
            $sql1->bindParam(":name", $prf_name[$key]);
            $sql1->bindParam(":hr_remarks", $hr_remarks[$key]);
            $sql1->execute();

        } else { // not existed insert

            //INSERT NNI HR INFORMATION
            $sql1 = $pdo->prepare("INSERT INTO nni_hr (
                nni_id,
                manpower_plantilla,
                head_count,
                budget_base_pay,
                budget_allowance,
                total_compensation,
                total_gmb,
                total_cib,
                total_lc,
                deployment_date,
                special_qualification,
                name,
                remarks
            ) VALUES (
                :nni_id,
                :manpower_plantilla,
                :head_count,
                :budget_base_pay,
                :budget_allowance,
                :compensation,
                :gmb,
                :cib,
                :lc_total,
                :deployment_date,
                :special_qualification,
                :name,
                :hr_remarks
            )");

            $sql1->bindParam(":nni_id",$nni_id);
            if(!empty($manpower_plantilla[$key])) {

                $sql1->bindParam(":manpower_plantilla", $manpower_plantilla[$key]);
                $sql1->bindParam(":head_count", $head_count[$key]);
                $sql1->bindParam(":budget_base_pay", $budget_base_pay[$key]);
                $sql1->bindParam(":budget_allowance", $budget_allowance[$key]);
                $sql1->bindParam(":compensation", $compensation[$key]);
                $sql1->bindParam(":gmb", $gmb[$key]);
                $sql1->bindParam(":cib", $cib[$key]);
                $sql1->bindParam(":lc_total", $lc_total[$key]);
                $sql1->bindParam(":deployment_date", $deployment_date[$key]);
                $sql1->bindParam(":special_qualification", $special_qualification[$key]);
                $sql1->bindParam(":name", $prf_name[$key]);
                $sql1->bindParam(":hr_remarks", $hr_remarks[$key]);
                $sql1->execute();
            }

            $hr_id = $pdo->lastInsertId();
        
        }

    }

    // check if existed
    $sql = $pdo->prepare("SELECT * FROM prf WHERE prospect_id = :prospect_id AND temp_del = 0 LIMIT 1");
    $sql->bindParam(":prospect_id", $prospect_id);
    $sql->execute();
    $prf_id = 0;
    if($sql->rowCount()) { // update

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $prf_id = $data['id'];

        $sql1 = $pdo->prepare("UPDATE prf SET prospect_id = :prospect_id WHERE id = :id");
        $sql1->bindParam(":id", $prf_id);
        $sql1->bindParam(":prospect_id", $prospect_id);
        $sql1->execute();

        foreach($nni_hr_id as $key => $hr_id) {
            $code = $prospect_id.$prf_id.$key;

            $sql1 = $pdo->prepare("SELECT * FROM prf_departments WHERE code = :code LIMIT 1");
            $sql1->bindParam(":code", $code);
            $sql1->execute();
            if($sql1->rowCount()) { // update

                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                $sql2 = $pdo->prepare("UPDATE prf_departments SET 
                    job_title = :job_title, 
                    number_of_staff = :number_of_staff,
                    status = :status,
                    name = :name
                WHERE id = :id");
                if(!empty($manpower_plantilla[$key]) || !empty($head_count[$key])) {
                    $sql2->bindParam(":id", $data1['id']);
                    $sql2->bindParam(":job_title", $manpower_plantilla[$key]);
                    $sql2->bindParam(":number_of_staff", $head_count[$key]);
                    $sql2->bindParam(":status", $hr_remarks[$key]);
                    $sql2->bindParam(":name", $prf_name[$key]);
                    $sql2->execute();
                }

            } else { // insert

                $sql2 = $pdo->prepare("INSERT INTO prf_departments (
                    prf_id,
                    job_title,
                    number_of_staff,
                    code,
                    status
                ) VALUES (
                    :prf_id,
                    :job_title,
                    :number_of_staff,
                    :code,
                    :status
                )");
                if(!empty($manpower_plantilla[$key]) || !empty($head_count[$key])) {
                    $sql2->bindParam(":prf_id", $prf_id);
                    $sql2->bindParam(":job_title", $manpower_plantilla[$key]);
                    $sql2->bindParam(":number_of_staff", $head_count[$key]);
                    $sql2->bindParam(":code", $code);
                    $sql2->bindParam(":status", $hr_remarks[$key]);
                    $sql2->execute();
                }
            }

        }

    } else { // insert

        // INSERT PRF
        $sql1 = $pdo->prepare("INSERT INTO prf (
            prospect_id
        ) VALUES (
            :prf_prospect_id
        )");

        $sql1->bindParam(":prf_prospect_id", $prospect_id);
        $sql1->execute();

        $prf_id = $pdo->lastInsertId();

        $sql1 = $pdo->prepare("INSERT INTO prf_departments (
            prf_id,
            job_title,
            number_of_staff,
            code,
            status
        ) VALUES (
            :prf_id,
            :job_title,
            :number_of_staff,
            :code,
            :status
        )");
        $sql1->bindParam(":prf_id", $prf_id);
        foreach($nni_hr_id as $key => $hr_id) {
            if(!empty($manpower_plantilla[$key]) || !empty($head_count[$key])) {
                $code = $prospect_id.$prf_id.$key;
                $sql1->bindParam(":job_title", $manpower_plantilla[$key]);
                $sql1->bindParam(":number_of_staff", $head_count[$key]);
                $sql1->bindParam(":code", $code);
                $sql1->bindParam(":status", $hr_remarks[$key]);
                $sql1->execute();
            }
        }
    }

    if ($status == 1) {

        //system log
        systemLog('nni',$prospect_id,'add',''); 

        //notification hr status completed
        $employees = getTable('employees');
        $users = getTable('users');
        foreach ($employees as $employee) {
            push_notification('nni-hr-status-completed', $prospect_id, $employee['id'], 'employee', 'nni_hr_status_completed_update');
        }
        foreach ($users as $user) {
            push_notification('nni-hr-status-completed', $prospect_id, $user['id'], 'user', 'nni_hr_status_completed_update');
        }
    }
}

// IT information
if($department == 'IT') {

    $status = 0;
    if(isset($_POST['status'])) {
        $status = trim($_POST['status']);
    }

    // server_access
    $server_access = '';
    if(isset($_POST['server_access'])) {
        $server_access = $_POST['server_access'];
    }

    // it_position
    $it_position = array();
    if(isset($_POST['it_position'])) {
        $it_position = $_POST['it_position'];
    }
    
    // it staff id
    $it_staff_id = array();
    if(isset($_POST['it_staff_id'])) {
        $it_staff_id = $_POST['it_staff_id'];
    }

    // webpage_access
    $webpage_access = array();
    if(isset($_POST['access_0'])) {
        $webpage_access = $_POST['access_0'];
    }

    // my_fpd
    $my_fpd = array();
    if(isset($_POST['access_1'])) {
        $my_fpd = $_POST['access_1'];
    }

    // fpd_nexus
    $fpd_nexus = array();
    if(isset($_POST['access_2'])) {
        $fpd_nexus = $_POST['access_2'];
    }

    // acumatica
    $acumatica = array();
    if(isset($_POST['access_3'])) {
        $acumatica = $_POST['access_3'];
    }

    // it_name
    $it_name = array();
    if(isset($_POST['it_name'])) {
        $it_name = $_POST['it_name'];
    }

    // it_email
    $it_email = array();
    if(isset($_POST['it_email'])) {
        $it_email = $_POST['it_email'];
    }

    // IT
        // check if already exist
        $nni_it_id = 0;
        $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id");
        $sql->bindParam(":nni_id", $nni_id);
        $sql->execute();
        if($sql->rowCount()) { // exist update

            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $nni_it_id = $data['id'];

            $sql1 = $pdo->prepare("UPDATE nni_it SET 
                server_access = :server_access,
                status = :status
            WHERE id = :id");
            $sql1->bindParam(":id", $nni_it_id);
            $sql1->bindParam(":server_access", $server_access);
            $sql1->bindParam(":status", $status);
            $sql1->execute();

        } else { // do not exist insert

            //INSERT NNI IT INFORMATION
            $sql1 = $pdo->prepare("INSERT INTO nni_it (
                nni_id,
                server_access,
                status
            ) VALUES (
                :nni_id,
                :server_access,
                :status
            )");
            $sql1->bindParam(":nni_id", $nni_id);
            $sql1->bindParam(":server_access", $server_access);
            $sql1->bindParam(":status", $status);
            $sql1->execute();

            $nni_it_id = $pdo->lastInsertId();


        }
    // 

    // IT STAFFS
        foreach($it_staff_id as $key => $staff_id) {

            // check if exist
            $sql = $pdo->prepare("SELECT * FROM nni_it_staffs WHERE id = :id");
            $sql->bindParam(":id", $staff_id);
            $sql->execute();
            if($sql->rowCount()) { // existed update
                
                $data = $sql->fetch(PDO::FETCH_ASSOC);

                $server_access = implode(',',array($webpage_access[$key],$my_fpd[$key],$fpd_nexus[$key],$acumatica[$key]));

                $sql1 = $pdo->prepare("UPDATE nni_it_staffs SET 
                    position = :it_position, 
                    name = :it_name,
                    email_address = :it_email,
                    server_access = :server_access
                WHERE id = :id");
                $sql1->bindParam(":id", $staff_id);
                $sql1->bindParam(":it_name", $it_name[$key]);
                $sql1->bindParam(":it_position", $it_position[$key]);
                $sql1->bindParam(":it_email", $it_email[$key]);
                $sql1->bindParam(":server_access", $server_access);
                $sql1->execute();

            } else { // did not exist insert

                //INSERT NNI IT STAFFS
                $sql1 = $pdo->prepare("INSERT INTO nni_it_staffs (
                    nni_it_id,
                    name,
                    position,
                    email_address,
                    server_access
                ) VALUES (
                    :nni_it_id,
                    :it_name,
                    :it_position,
                    :it_email,
                    :server_access
                )");

                $server_access = implode(',',array($webpage_access[$key],$my_fpd[$key],$fpd_nexus[$key],$acumatica[$key]));

                if(!empty($it_position[$key])) {
                    $sql1->bindParam(":nni_it_id", $nni_it_id);
                    $sql1->bindParam(":it_name", $it_name[$key]);
                    $sql1->bindParam(":it_position", $it_position[$key]);
                    $sql1->bindParam(":it_email", $it_email[$key]);
                    $sql1->bindParam(":server_access", $server_access);
                    $sql1->execute();
                }
                
            }

        }


    if ($status == 1) {
    
        //system log
        systemLog('nni',$prospect_id,'add',''); 

        //notification it status completed
        $employees = getTable('employees');
        $users = getTable('users');
        foreach ($employees as $employee) {
            push_notification('nni-it-status-completed', $prospect_id, $employee['id'], 'employee', 'nni_it_status_completed_update');
        }
        foreach ($users as $user) {
            push_notification('nni-it-status-completed', $prospect_id, $user['id'], 'user', 'nni_it_status_completed_update');
        }
    }
}

// CAD information
if($department == 'CAD') {

    $status = 0;
    if(isset($_POST['nni_cad_status'])) {
        $status = trim($_POST['nni_cad_status']);
    }

    // nni cad id
    $nni_cad_id = array();
    if(isset($_POST['cad_id'])) {
        $nni_cad_id = $_POST['cad_id'];
    }

    // CAD property_administration
    $property_administration = array();
    if(isset($_POST['property_administration'])) {
        $property_administration = $_POST['property_administration'];
    }

    // CAD inclusions
    $revenue = array();
    if(isset($_POST['revenue'])) {
        $revenue = $_POST['revenue'];
    }

    // CAD terms
    $terms = array();
    if(isset($_POST['terms'])) {
        $terms = $_POST['terms'];
    }

    // TERM OPTION
    $term_option = array();
    if(isset($_POST['term_option'])) {
        $term_option = $_POST['term_option'];
    }

    // CAD cad_remarks
    $revenue_amount = array();
    if(isset($_POST['revenue_amount'])) {
        $revenue_amount = $_POST['revenue_amount'];
    }

    // vat_status
    $vat_status = 0;
    if(isset($_POST['vat_status'])) {
        $vat_status = $_POST['vat_status'];
    }

    // LABOR COST
    $labor_cost = '';
    if(isset($_POST['labor-cost'])) {
        $labor_cost = trim($_POST['labor-cost']);
    }

    // AMOUNT
    $amount = '';
    if(isset($_POST['amount'])) {
        $amount = $_POST['amount'];
        $_SESSION['sys_downpayment_add_amount_val'] = $amount;
        
    }

    // DATE
    $dp_date = '';
    if(isset($_POST['dp_date'])) {
        $dp_date = trim($_POST['dp_date']);
        
    }

    // OR
    $or_num = '';
    if(isset($_POST['or_num'])) {
        $or_num = trim($_POST['or_num']);
    }

    $sql = $pdo->prepare("SELECT * FROM nni_cad_tab WHERE nni_id = :nni_id LIMIT 1");
    $sql->bindParam(":nni_id", $nni_id);
    $sql->execute();
    if($sql->rowCount()) {

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $nni_cad_id = $data['id'];

        $sql1 = $pdo->prepare("UPDATE nni_cad_tab SET 
            status = :status, 
            user_id = :user_id, 
            account_mode = :account_mode,
            vat = :vat,
            labor_cost = :labor_cost
        WHERE id = :id");
        $sql1->bindParam(":id", $nni_cad_id);
        $sql1->bindParam(":status", $status);
        $sql1->bindParam(":user_id", $user_id);
        $sql1->bindParam(":account_mode", $account_mode);
        $sql1->bindParam(":vat", $vat_status);
        $sql1->bindParam(":labor_cost", $labor_cost);
        $sql1->execute();

    } else {

        $sql1 = $pdo->prepare("INSERT INTO nni_cad_tab (
            nni_id, 
            status, 
            user_id, 
            account_mode,
            vat,
            labor_cost
        ) VALUES (
            :nni_id, 
            :status, 
            :user_id, 
            :account_mode,
            :vat,
            :labor_cost
        )");
        $sql1->bindParam(":nni_id", $nni_id);
        $sql1->bindParam(":status", $status);
        $sql1->bindParam(":user_id", $user_id);
        $sql1->bindParam(":account_mode", $account_mode);
        $sql1->bindParam(":vat", $vat_status);
        $sql1->bindParam(":labor_cost", $labor_cost);
        $sql1->execute();

    }

    // DOWNPAYMENT
    // check if existing
    $sql = $pdo->prepare("SELECT * FROM downpayments WHERE prospect_id = :prospect_id AND temp_del = 0");
    $sql->bindParam(":prospect_id", $prospect_id);
    $sql->execute();
    if($sql->rowCount()) {  // update

        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $dp_id = $data['id'];

        $sql1 = $pdo->prepare("UPDATE downpayments SET 
            amount = :amount,
            date = :dp_date,
            or_num = :or_num
        WHERE id = :id");
        $sql1->bindParam(":id", $dp_id);
        $sql1->bindParam(":amount", $amount);
        $sql1->bindParam(":dp_date", $dp_date);
        $sql1->bindParam(":or_num", $or_num);
        $sql1->execute();

    } else { // insert
    }

    foreach($_POST['cad_id'] as $key => $cad_id) {

        // check if existed
        $sql = $pdo->prepare("SELECT * FROM nni_cad WHERE id = :nni_id LIMIT 1");
        $sql->bindParam(":nni_id", $cad_id);
        $sql->execute();
        if($sql->rowCount()) { // existed update
            
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $sql1 = $pdo->prepare("UPDATE nni_cad SET 
                property_administration = :property_administration,
                revenue_allocation = :revenue,
                terms = :terms,
                revenue_amount = :revenue_amount,
                term_option = :term_option
            WHERE id = :cad_id");
            $sql1->bindParam(":cad_id", $cad_id);
            $sql1->bindParam(":property_administration", $property_administration[$key]);
            $sql1->bindParam(":terms", $terms[$key]);
            $sql1->bindParam(":revenue", $revenue[$key]);
            $sql1->bindParam(":revenue_amount", $revenue_amount[$key]);
            $sql1->bindParam(":term_option", $term_option[$key]);
            $sql1->execute();


        } else { // not existed insert

            //INSERT NNI CAD INFORMATION
            $sql1 = $pdo->prepare("INSERT INTO nni_cad (
                nni_id,
                property_administration,
                revenue_allocation,
                terms,
                revenue_amount,
                term_option
            ) VALUES (
                :nni_cad_id,
                :property_administration,
                :revenue,
                :terms,
                :revenue_amount,
                :term_option
            )");

            if(!in_array($revenue[$key], $inclusions_arr)) {

                $sql1->bindParam(":nni_cad_id",$nni_id);
                if(!strlen($revenue[$key]) == 0) {
            
                    $sql1->bindParam(":property_administration", $property_administration[$key]);
                    $sql1->bindParam(":terms", $terms[$key]);
                    $sql1->bindParam(":revenue", $revenue[$key]);
                    $sql1->bindParam(":revenue_amount", $revenue_amount[$key]);
                    $sql1->bindParam(":term_option", $term_option[$key]);
                    $sql1->execute();
                }
                $cad_id = $pdo->lastInsertId();

            }
        }
    }

    if ($status == 1) {

        //system log
        systemLog('nni',$prospect_id,'add',''); 

        //notification it status completed
        $employees = getTable('employees');
        $users = getTable('users');
        foreach ($employees as $employee) {
            push_notification('nni-cad-status-completed', $prospect_id, $employee['id'], 'employee', 'nni_cad_status_completed_update');
        }
        foreach ($users as $user) {
            push_notification('nni-cad-status-completed', $prospect_id, $user['id'], 'user', 'nni_cad_status_completed_update');
        }
    }

}

$_SESSION['sys_nni_add_suc'] = renderLang($nni_updated);

// check if all department nni is completed
$hr_status = getField('status', 'nni_hr_tab', 'nni_id = '.$nni_id);
$it_status = getField('status', 'nni_it', 'nni_id = '.$nni_id);
$cad_status = getField('status', 'nni_cad_tab', 'nni_id = '.$nni_id);

if($hr_status == 1 && $it_status == 1 && $cad_status == 1) { // All are completed

    // update nni status to completed
    $sql = $pdo->prepare("UPDATE nni SET 
        status = '4' 
    WHERE id = :nni_id");
    $sql->bindParam(":nni_id", $nni_id);
    $sql->execute();

    //notification nni is completed
    $employees = getTable('employees');
    $users = getTable('users');
    foreach ($employees as $employee) {
        push_notification('nni-status-completed', $prospect_id, $employee['id'], 'employee', 'nni_has_been_completed');
    }
    foreach ($users as $user) {
        push_notification('nni-status-completed', $prospect_id, $user['id'], 'user', 'nni_has_been_completed');
    }

    $_SESSION['sys_nni_add_suc'] = renderLang($nni_updated);

}
?>