<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('general-inspection-and-function-checkt-add') || checkPermission('proper-installation-general-inspection-and-function-check-add') || checkPermission('supply-voltage-and-load-current-reading-add') || checkPermission('power-and-grounding-wiring-add')) {

        $err = 0;

        // sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        // work_reference_no
        $work_reference_no = '';
        if(isset($_POST['work_reference_no'])) {
            $work_reference_no = trim($_POST['work_reference_no']);
        }

        //  rated_v_and_i
        $rated_v_and_i = '';
        if(isset($_POST['rated_v_and_i'])) {
            $rated_v_and_i = trim($_POST['rated_v_and_i']);
        }

        // customer
        $customer = '';
        if(isset($_POST['customer'])) {
            $customer = trim($_POST['customer']);
        }

        // test_equipment_used
        $test_equipment_used = '';
        if(isset($_POST['test_equipment_used'])) {
            $test_equipment_used = trim($_POST['test_equipment_used']);
        }

        // inspected_by
        $inspected_by = '';
        if(isset($_POST['inspected_by'])) {
            $inspected_by = trim($_POST['inspected_by']);
        }

        // inspected_date
        $inspected_date = '';
        if(isset($_POST['inspected_date'])) {
            $inspected_date = trim($_POST['inspected_date']);
        }

        // inspected_time
        $inspected_time = '';
        if(isset($_POST['inspected_time'])) {
            $inspected_time = trim($_POST['inspected_time']);
        }

        // checked_by
        $checked_by = '';
        if(isset($_POST['checked_by'])) {
            $checked_by = trim($_POST['checked_by']);
        }

        // checked_date
        $checked_date = '';
        if(isset($_POST['checked_date'])) {
            $checked_date = trim($_POST['checked_date']);
        }

        // checked_time
        $checked_time = '';
        if(isset($_POST['checked_time'])) {
            $checked_time = trim($_POST['checked_time']);
        }


        // category
        $category = '';
        if(isset($_POST['category'])) {
            $category = trim($_POST['category']);
        }

        // if category == (0) General Inspection & Function Check / Proper Installation, General Inspection & Function Check
        if ($category == 0 || $category == 1) {

            // item no
            $item_no = array();
            if(isset($_POST['item_no'])) {
                $item_no = $_POST['item_no'];
            }

            // Crirteria
            $criteria = array();
            if(isset($_POST['criteria'])) {
                $criteria = $_POST['criteria'];
            }

            // remarks
            $remarks = array();
            if(isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
            }

            // status
            $status = array();
            if(isset($_POST['status'])) {
                $status = $_POST['status'];
            }

        }

        // if category == (2) Supply Voltage & Load Current Reading
        if ($category == 2) {

            // LINE VOLTAGE

            // l1-l2
            $l1_12 = 'l1-l2';
            if(isset($_POST['l1-l2'])) {
                $l1_12 = $_POST['l1-l2'];
            }

            // l2-l3
            $l2_l3 = 'l2-l3';
            if(isset($_POST['l2-l3'])) {
                $l2_l3 = $_POST['l2-l3'];
            }

            // l1-l3
            $l1_l3 = 'l1-l3';
            if(isset($_POST['l1-l3'])) {
                $l1_l3 = $_POST['l1-l3'];
            }

            // LOAD CURRENT

            // u
            $load_current_u = 'load_current_u';
            if(isset($_POST['load_current_u'])) {
                $load_current_u = $_POST['load_current_u'];
            }

            // v
            $load_current_v = 'load_current_v';
            if(isset($_POST['load_current_v'])) {
                $load_current_v = $_POST['load_current_v'];
            }

            // w
            $load_current_w = 'load_current_w';
            if(isset($_POST['load_current_w'])) {
                $load_current_w = $_POST['load_current_w'];
            }

            // remarks
            $remarks = 'remarks';
            if(isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
            }
            
        }

        // if category == (3) Power & Grounding Wirings
        if ($category == 3) {

            // power_wirings
            $power_wirings = '';
            if(isset($_POST['power_wirings'])) {
                $power_wirings = $_POST['power_wirings'];
            }

            // grounding_wire
            $grounding_wire = '';
            if(isset($_POST['grounding_wire'])) {
                $grounding_wire = $_POST['grounding_wire'];
            }

            // remarks
            $remarks = array();
            if(isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
            }

        }

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO task_inspection_engineering_checklist (
                sub_property_id, 
                work_reference_no, 
                rated_v_and_i, 
                customer, 
                test_equipment_used, 
                inspected_by, 
                inspected_date, 
                inspected_time, 
                checked_by,
                checked_date,
                checked_time,
                category
            ) VALUES (
                :sub_property_id, 
                :work_reference_no, 
                :rated_v_and_i, 
                :customer, 
                :test_equipment_used, 
                :inspected_by, 
                :inspected_date, 
                :inspected_time, 
                :checked_by,
                :checked_date,
                :checked_time,
                :category
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":work_reference_no", $work_reference_no);
            $sql->bindParam(":rated_v_and_i", $rated_v_and_i);
            $sql->bindParam(":customer", $customer);
            $sql->bindParam(":test_equipment_used", $test_equipment_used);
            $sql->bindParam(":inspected_by", $inspected_by);
            $sql->bindParam(":inspected_date", $inspected_date);
            $sql->bindParam(":inspected_time", $inspected_time);
            $sql->bindParam(":checked_by", $checked_by);
            $sql->bindParam(":checked_date", $checked_date);
            $sql->bindParam(":checked_time", $checked_time);
            $sql->bindParam(":category", $category);
            $sql->execute();

            $id = $pdo->lastInsertId();

            // if category == (0/1) General Inspection & Function Check / Proper Installation, General Inspection & Function Check
            if ($category == 0 || $category == 1) {
                foreach($item_no as $key => $item) {

                    $sql = $pdo->prepare("INSERT INTO task_inspection_engineer_general_and_function_check (
                        engineering_id, 
                        item_no,
                        criteria,
                        remarks, 
                        status
                    ) VALUES (
                        :engineering_id, 
                        :item_no,
                        :criteria, 
                        :remarks, 
                        :status
                    )");
                    if(checkVar($item)) {

                        $sql->bindParam(":engineering_id", $id);
                        $sql->bindParam(":item_no", $item);
                        $sql->bindParam(":criteria", $criteria[$key]);
                        $sql->bindParam(":remarks", $remarks[$key]);
                        $sql->bindParam(":status", $status[$key]);
                        $sql->execute();
                    }
                }

                // notification for (0) General Inspection & Function Check
                if ($category == 0) {

                    // system log
                    systemLog('inspection',$id,'add','');

                    //notification add
                    $employees = getTable('employees');
                    $users = getTable('users');
                        foreach ($employees as $employee) {
                            push_notification('general-inspection-and-function-check', $id, $employee['id'], 'employee','general_inspection_and_function_check_add');
                        }
                        foreach ($users as $user) {
                           push_notification('general-inspection-and-function-check', $id, $user['id'], 'user', 'general_inspection_and_function_check_add');
                        }

                }

                // notification for (1) Proper Installation, General Inspection & Function Check
                if ($category == 1) {

                    // system log
                    systemLog('inspection',$id,'add','');

                    //notification add
                    $employees = getTable('employees');
                    $users = getTable('users');
                        foreach ($employees as $employee) {
                            push_notification('proper-installation-general-inspection-and-function-check', $id, $employee['id'], 'employee','proper_installation_general_inspection_and_function_check_add');
                        }
                        foreach ($users as $user) {
                           push_notification('proper-installation-general-inspection-and-function-check', $id, $user['id'], 'user', 'proper_installation_general_inspection_and_function_check_add');
                        }

                }

            }

            // if category == (2) Power & Grounding Wirings
            if ($category == 2) {

                $sql = $pdo->prepare("INSERT INTO task_inspection_engineer_supply_voltage_and_load_current_reading (
                    engineering_id, 
                    l1_l2,
                    l2_l3,
                    l1_l3,
                    u,
                    v,
                    w,
                    remarks
                ) VALUES (
                    :engineering_id, 
                    :l1_l2,
                    :l2_l3, 
                    :l1_l3, 
                    :u, 
                    :v, 
                    :w, 
                    :remarks
                )");

                    $sql->bindParam(":engineering_id", $id);
                    $sql->bindParam(":l1_l2", $l1_12);
                    $sql->bindParam(":l2_l3", $l2_l3);
                    $sql->bindParam(":l1_l3", $l1_l3);
                    $sql->bindParam(":u", $load_current_u);
                    $sql->bindParam(":v", $load_current_v);
                    $sql->bindParam(":w", $load_current_w);
                    $sql->bindParam(":remarks", $remarks);
                    $sql->execute();

                    // system log
                    systemLog('inspection',$id,'add','');

                    // notification add
                    $employees = getTable('employees');
                    $users = getTable('users');
                        foreach ($employees as $employee) {
                            push_notification('supply-voltage-and-load-current-reading', $id, $employee['id'], 'employee', 'supply_voltage_and_load_current_reading_add');
                        }
                        foreach ($users as $user) {
                            push_notification('supply-voltage-and-load-current-reading', $id, $user['id'], 'user', 'supply_voltage_and_load_current_reading_add');
                        }

                
            }

            // if category == (3) Power & Grounding Wirings
            if ($category == 3) {
                
                $sql = $pdo->prepare("INSERT INTO task_inspection_engineer_power_and_grounding_wirings (
                    engineering_id, 
                    power_wirings,
                    grounding_wire,
                    remarks
                ) VALUES (
                    :engineering_id, 
                    :power_wirings,
                    :grounding_wire, 
                    :remarks
                )");

                    $sql->bindParam(":engineering_id", $id);
                    $sql->bindParam(":power_wirings", $power_wirings);
                    $sql->bindParam(":grounding_wire", $grounding_wire);
                    $sql->bindParam(":remarks", $remarks);
                    $sql->execute();

                    // system log
                    systemLog('inspection',$id,'add','');

                    //notification add
                    $employees = getTable('employees');
                    $users = getTable('users');
                        foreach ($employees as $employee) {
                            push_notification('power-and-grounding-wirings', $id, $employee['id'], 'employee', 'power_and_grounding_wirings_add');
                        }
                        foreach ($users as $user) {
                            push_notification('power-and-grounding-wirings', $id, $user['id'], 'user', 'power_and_grounding_wirings_add');
                        }

            }

            $location_suc = '';
            $location_err = '';

            if ($category == 0) {
                
                $location_suc = 'general-inspection-list';
                $location_err = 'add-general-inspection-sheet';
                $_SESSION['sys_general_inspection_checklist_add_suc'] = renderLang($inspection_added_general_inspection_and_function_check);
            }
            if ($category == 1) {
                
                $location_suc = 'proper-installation-inspection-list';
                $location_err = 'add-proper-installation-inspection-sheet';
                $_SESSION['sys_proper_installation_inspection_checklist_add_suc'] = renderLang($inspection_added_proper_installation_general_inspection_and_function_check);
            }
            if ($category == 2) {
                
                $location_suc = 'supply-voltage-inspection-list';
                $location_err = 'add-supply-voltage-inspection-sheet';
                $_SESSION['sys_supply_voltage_inspection_checklist_add_suc'] = renderLang($inspection_added_supply_voltage_and_load_current_reading);
            }
            if ($category == 3) {
                
                $location_suc = 'power-inspection-list';
                $location_err = 'add-power-inspection-sheet';
                $_SESSION['sys_power_inspection_checklist_add_suc'] = renderLang($inspection_added_power_and_grounding_wirings);
            }

            header('location: /'.$location_suc);

        } else {

            $_SESSION['sys_fire_extinguisher_inspection_checklist_add_err'] = renderLang($form_error);
            header('location: /'.$location_err.'/'.$id);
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