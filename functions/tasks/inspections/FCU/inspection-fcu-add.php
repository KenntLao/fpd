<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('fcu-monthly-inspection-add')) {

        $err = 0;

        // sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        // date
        $date = '';
        if(isset($_POST['date'])) {
            $date = trim($_POST['date']);
        }

        //  model_no
        $model_no = '';
        if(isset($_POST['model_no'])) {
            $model_no = trim($_POST['model_no']);
        }

        // location_unit_no
        $location_unit_no = '';
        if(isset($_POST['location_unit_no'])) {
            $location_unit_no = trim($_POST['location_unit_no']);
        }

        // serial_no
        $serial_no = '';
        if(isset($_POST['serial_no'])) {
            $serial_no = trim($_POST['serial_no']);
        }

        // time_started
        $time_started = '';
        if(isset($_POST['time_started'])) {
            $time_started = trim($_POST['time_started']);
        }

        // time_finished
        $time_finished = '';
        if(isset($_POST['time_finished'])) {
            $time_finished = trim($_POST['time_finished']);
        }

        // recommendations
        $recommendations = '';
        if(isset($_POST['recommendations'])) {
            $recommendations = trim($_POST['recommendations']);
        }

        // conducted_by
        $conducted_by = '';
        if(isset($_POST['conducted_by'])) {
            $conducted_by = trim($_POST['conducted_by']);
        }

        // acknowledged_by
        $acknowledged_by = '';
        if(isset($_POST['acknowledged_by'])) {
            $acknowledged_by = trim($_POST['acknowledged_by']);
        }

        // noted_by
        $noted_by = '';
        if(isset($_POST['noted_by'])) {
            $noted_by = trim($_POST['noted_by']);
        }

        // checklist

        // scope_of_works
        $scope_of_works = array();
        if(isset($_POST['scope_of_works'])) {
            $scope_of_works = $_POST['scope_of_works'];
        }

        // remarks
        $remarks = array();
        if(isset($_POST['remarks'])) {
            $remarks = $_POST['remarks'];
        }

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO task_inspection_maintenance_fcu (
                sub_property_id, 
                date, 
                model_no, 
                location_unit_no, 
                serial_no, 
                time_started, 
                time_finished, 
                recommendations, 
                conducted_by,
                acknowledged_by,
                noted_by
            ) VALUES (
                :sub_property_id, 
                :date, 
                :model_no, 
                :location_unit_no, 
                :serial_no, 
                :time_started, 
                :time_finished, 
                :recommendations, 
                :conducted_by,
                :acknowledged_by,
                :noted_by
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":date", $date);
            $sql->bindParam(":model_no", $model_no);
            $sql->bindParam(":location_unit_no", $location_unit_no);
            $sql->bindParam(":serial_no", $serial_no);
            $sql->bindParam(":time_started", $time_started);
            $sql->bindParam(":time_finished", $time_finished);
            $sql->bindParam(":recommendations", $recommendations);
            $sql->bindParam(":conducted_by", $conducted_by);
            $sql->bindParam(":acknowledged_by", $acknowledged_by);
            $sql->bindParam(":noted_by", $noted_by);
            $sql->execute();

            $id = $pdo->lastInsertId();

            foreach($scope_of_works as $key => $scope_of_work) {

                $sql = $pdo->prepare("INSERT INTO task_inspection_maintenance_fcu_items (
                    fcu_id, 
                    scope_of_works,
                    remarks
                ) VALUES (
                    :fcu_id, 
                    :scope_of_works, 
                    :remarks
                )");

                    $sql->bindParam(":fcu_id", $id);
                    $sql->bindParam(":scope_of_works", $scope_of_work);
                    $sql->bindParam(":remarks", $remarks[$key]);
                    $sql->execute();
            }

            //system log
            systemLog('inspection',$id,'add','');

            //notification add fcu
            $employees = getTable("employees");
            $users = getTable("users");
                foreach ($employees as $employee) {
                    push_notification('fcu-monthly-inspections', $id, $employee['id'], 'employee','fcu_monthly_inspections_add');
                }
                foreach ($users as $user) {
                    push_notification('fcu-monthly-inspections', $id, $user['id'], 'user', 'fcu_monthly_inspections_add');
                }

            $_SESSION['sys_fcu_inspection_checklist_add_suc'] = renderLang($inspection_fcu_added);
            header('location: /fcu-monthly-inspection-list');

        } else {

            $_SESSION['sys_fcu_inspection_checklist_add_err'] = renderLang($form_error);
            header('location: /add-fcu-inspection/'.$id);
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