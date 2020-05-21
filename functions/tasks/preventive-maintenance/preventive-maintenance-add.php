<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('preventive-maintenance-add')) {
        
        $err = 0;

        $building_id = '';
        if(isset($_POST['building_id'])) {
            $building_id = trim($_POST['building_id']);
            if(strlen($building_id) == 0){
                $err++;
            }
        }

        $equipment_id = '';
        if(isset($_POST['equipment_id'])) {
            $equipment_id = trim($_POST['equipment_id']);
            if(strlen($equipment_id) == 0){
                $err++;
            }
        }

        $frequency = '';
        if(isset($_POST['frequency'])) {
            $frequency = trim($_POST['frequency']);
            if(strlen($frequency) == 0){
                $err++;
            }
        }

        $employee_id = '';
        if(isset($_POST['employee_id'])) {
            $employee_id = trim($_POST['employee_id']);
            if(strlen($employee_id) == 0){
                $err++;
            }
        }

        $description = '';
        if(isset($_POST['description'])) {
            $description = trim($_POST['description']);
        }

        if($err == 0) {
            
            $sql = $pdo->prepare("INSERT INTO `preventive_maintenance` 
            (
                sub_property_id, 
                equipment_id, 
                employee_id, 
                frequency, 
                description,
                date) 
            VALUES (
                :building_id, 
                :equipment_id, 
                :employee_id, 
                :frequency, 
                :description,
                CURRENT_TIMESTAMP)");

            $sql->bindParam(":building_id", $building_id);
            $sql->bindParam(":equipment_id", $equipment_id);
            $sql->bindParam(":employee_id", $employee_id);
            $sql->bindParam(":frequency", $frequency);
            $sql->bindParam(":description", $description);

            $sql->execute();

            $_SESSION['sys_preventive_maintenance_add_suc'] = renderLang($preventive_maintenance_added);
            header('location: /frequency-preventive-maintenance/6');

        } else {

            $_SESSION['sys_preventive_maintenance_add_err'] = renderLang($form_error);
            header('location: /add-preventive-maintenance/'.$frequency);

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