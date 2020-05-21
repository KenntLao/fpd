<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('inspection-fire-extinguiser-checklist-add')) {

        $err = 0;

        // sub property id
        $sub_property_id = '';
        if(isset($_POST['sub_property_id'])) {
            $sub_property_id = trim($_POST['sub_property_id']);
            if(strlen($sub_property_id) == 0) {
                $err++;
            }
        }

        // year
        $year = date('Y');

        // month
        $month = '';
        if(isset($_POST['month'])) {
            $month = trim($_POST['month']);
            if(strlen($month) == 0) {
                $err++;
            } else {
                // check if inspection already created for this month
                $sql = $pdo->prepare("SELECT * FROM task_inspection_fire_extinguisher WHERE year = :year AND month = :month AND sub_property_id = :sub_property_id AND temp_del = 0 LIMIT 1");
                $sql->bindParam(":year", $year);
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
            $room_department = trim($_POST['room_department']);
        }

        //  location /area
        $location_area = '';
        if(isset($_POST['location_area'])) {
            $location_area = trim($_POST['location_area']);
        }

        // tagging
        $tagging = '';
        if(isset($_POST['tagging'])) {
            $tagging = trim($_POST['tagging']);
        }

        // type
        $type = '';
        if(isset($_POST['type'])) {
            $type = trim($_POST['type']);
        }

        // conducted by
        $conducted_by = $_SESSION['sys_id'];
        // conducted date
        $conducted_date = date('Y-m-d');

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

            $sql = $pdo->prepare("INSERT INTO task_inspection_fire_extinguisher (
                sub_property_id, 
                month, 
                year, 
                room_department, 
                location_area, 
                tagging, 
                type, 
                conducted_by, 
                conducted_date
            ) VALUES (
                :sub_property_id, 
                :month, 
                :year, 
                :room_department, 
                :location_area, 
                :tagging, 
                :type, 
                :conducted_by, 
                :conducted_date
            )");
            $sql->bindParam(":sub_property_id", $sub_property_id);
            $sql->bindParam(":month", $month);
            $sql->bindParam(":year", $year);
            $sql->bindParam(":room_department", $room_department);
            $sql->bindParam(":location_area", $location_area);
            $sql->bindParam(":tagging", $tagging);
            $sql->bindParam(":type", $type);
            $sql->bindParam(":conducted_by", $conducted_by);
            $sql->bindParam(":conducted_date", $conducted_date);
            $sql->execute();

            $inspection_fe_id = $pdo->lastInsertId();

            $no = 1;
            foreach($item_no as $key => $item) {

                $sql = $pdo->prepare("INSERT INTO task_inspection_fire_extinguisher_checklist (
                    inspection_fe_id, 
                    item, 
                    standard, 
                    check_value, 
                    remarks, 
                    actions
                ) VALUES (
                    :inspection_fe_id, 
                    :item, 
                    :standard, 
                    :check_value, 
                    :remarks, 
                    :action
                )");
                if(!empty($standard[$key])) {

                    $sql->bindParam(":inspection_fe_id", $inspection_fe_id);
                    $sql->bindParam(":item", $no);
                    $sql->bindParam(":standard", $standard[$key]);
                    $sql->bindParam(":check_value", $check_status[$key]);
                    $sql->bindParam(":remarks", $remarks[$key]);
                    $sql->bindParam(":action", $action[$key]);
                    $sql->execute();
                    $no++;
                }
            }

            $_SESSION['sys_fire_extinguisher_inspection_checklist_add_suc'] = renderLang($fiec_added);
            header('location: /fire-extinguisher-inspection-list');

        } else {

            $_SESSION['sys_fire_extinguisher_inspection_checklist_add_err'] = renderLang($form_error);
            header('location: /add-fire-extinguisher-inspection-checklist');
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