<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('inspection-emergency-light-checklist-add')) {

        $err = 0;

        // sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        // month
        $month = '';
        if(isset($_POST['month'])) {
            $month = trim($_POST['month']);
            if(strlen($month) == 0) {
                $err++;
            } else {
                // check if inspection already created for this month
                $sql = $pdo->prepare("SELECT * FROM task_inspection_emergency_light WHERE month = :month AND sub_property_id = :sub_property_id AND temp_del = 0 LIMIT 1");
                $sql->bindParam(":month", $month);
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->execute();
                if($sql->rowCount()) {
                    // $err++;
                    // already created
                }
            }
        }

        // room department
        $room_department = '';
        if(isset($_POST['room_department'])) {
            $room_department = $_POST['room_department'];
        }

        //  location /area
        $location_area = '';
        if(isset($_POST['location_area'])) {
            $location_area = trim($_POST['location_area']);
        }

        // conducted by
        $conducted_by = $_SESSION['sys_id'];
        // conducted date
        $conducted_date = date('Y-m-d');

        //  reviewed by
        $reviewed_by = '';
        if(isset($_POST['reviewed_by'])) {
            $reviewed_by = trim($_POST['reviewed_by']);
        }

        //  reviewed date
        $reviewed_date = '';
        if(isset($_POST['reviewed_date'])) {
            $reviewed_date = trim($_POST['reviewed_date']);
        }

        // checklist
        // item no
        $item_no = array();
        if(isset($_POST['item_no'])) {
            $item_no = $_POST['item_no'];
        }

        // standard
        $standard = array();
        if(isset($_POST['standard'])) {
            $standard = $_POST['standard'];
        }

        // remarks
        $remarks = array();
        if(isset($_POST['remarks'])) {
            $remarks = $_POST['remarks'];
        }

        // action
        $action = array();
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }

        // check_status
        $check_status = array();
        if(isset($_POST['check_status'])) {
            $check_status = $_POST['check_status'];
        }

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO task_inspection_emergency_light (
                sub_property_id, 
                month, 
                conducted_by, 
                conducted_date,
                room_department, 
                location_area,
                reviewed_by,
                reviewed_date
            ) VALUES (
                :sub_property_id, 
                :month, 
                :conducted_by, 
                :conducted_date,
                :room_department, 
                :location_area,
                :reviewed_by,
                :reviewed_date
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":month", $month);
            $sql->bindParam(":conducted_date", $conducted_date);
            $sql->bindParam(":conducted_by", $conducted_by);
            $sql->bindParam(":room_department", $room_department);
            $sql->bindParam(":location_area", $location_area);
            $sql->bindParam(":reviewed_by", $reviewed_by);
            $sql->bindParam(":reviewed_date", $reviewed_date);
            $sql->execute();

            $inspection_el_id = $pdo->lastInsertId();

            $no = 1;
            foreach($item_no as $key => $item) {

                $sql = $pdo->prepare("INSERT INTO task_inspection_emergency_light_checklist (
                    inspection_el_id, 
                    item, 
                    standard, 
                    check_value, 
                    remarks, 
                    actions
                ) VALUES (
                    :inspection_el_id, 
                    :item, 
                    :standard, 
                    :check_value, 
                    :remarks, 
                    :action
                )");
                if(!empty($standard[$key])) {

                    $sql->bindParam(":inspection_el_id", $inspection_el_id);
                    $sql->bindParam(":item", $no);
                    $sql->bindParam(":standard", $standard[$key]);
                    $sql->bindParam(":check_value", $check_status[$key]);
                    $sql->bindParam(":remarks", $remarks[$key]);
                    $sql->bindParam(":action", $action[$key]);
                    $sql->execute();
                    $no++;
                }
            }

            $_SESSION['sys_emergency_light_inspection_checklist_add_suc'] = renderLang($emergency_light_added);
            header('location: /emergency-light-inspection-list');

        } else {

            $_SESSION['sys_emergency_light_inspection_checklist_add_err'] = renderLang($form_error);
            header('location: /add-emergency-light-inspection-checklist');
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