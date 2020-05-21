<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

  if(checkPermission('property-add')) {

    $err = 0;

    // BUILDING
    $building_id = '';
    if(isset($_POST['building_id'])) {
        $building_id = trim($_POST['building_id']);
        if(strlen($building_id) == 0) {
            $err++;
            $_SESSION['sys_equipment_add_building_id_err'] = renderLang($equipments_building_required);
        } else {
            $sql = $pdo->prepare("SELECT id FROM sub_properties WHERE id = :building_id AND temp_del = 0");
            $sql->bindParam(":building_id", $building_id);
            $sql->execute();
            if(!($sql->rowCount())) {
                $err++;
                $_SESSION['sys_equipment_add_building_id_err'] = renderLang($equipments_building_not_exists);
            } else {
                $_SESSION['sys_equipment_add_building_id_val'] = $building_id;
            }
        }
    }

    // SERIAL NUMBER
    $serial_number = '';
    if(isset($_POST['serial_number'])){
        $serial_number = trim($_POST['serial_number']);
        if(strlen($serial_number) == 0){
            $err++;
            $_SESSION['sys_equipment_add_serial_number_err'] = renderLang($equipments_serial_number_required);
        } else {
            $_SESSION['sys_equipment_add_serial_number_val'] = $serial_number;
        }
    }

    // DESCRIPTION
    $description = '';
    if(isset($_POST['description'])) {
        $description = trim($_POST['description']);
        if(strlen($_POST['description']) != 0) {
            $_SESSION['sys_equipment_add_description_val'] = $description;
        }
    }

    // DATE ACQUIRED
    $date_acquired = '';
    if(isset($_POST['date'])) {
        $date_acquired = trim($_POST['date']);
        if(empty($date_acquired)) {
            $err++;
            $_SESSION['sys_equipment_add_date_err'] = renderLang($equipments_date_acquired_required);
        }
    }

    // AMOUNT
    $amount = '';
    if(isset($_POST['amount'])) {
        $amount = trim($_POST['amount']);
        if(empty($amount)) {
            $err++;
            $_SESSION['sys_equipment_add_amount_err'] = renderLang($equipments_amount_required);
        } else {
            $_SESSION['sys_equipment_add_amount_val'] = $amount;
        }
    }

    // SUPPLIER
    $supplier = '';
    if(isset($_POST['supplier'])) {
        $supplier = trim($_POST['supplier']);
        if(empty($supplier)) {
            $err++;
            $_SESSION['sys_equipment_add_supplier_err'] = renderLang($equipments_supplier_required); 
        } else {
            $_SESSION['sys_equipment_add_supplier_val'] = $supplier;
        }
    }

    if($err == 0) {

        $sql = $pdo->prepare("INSERT INTO equipments (
            sub_property_id, 
            serial_number, 
            equipment_description, 
            date_acquired, 
            amount, 
            supplier) 
            VALUES 
            (:building_id,
            :serial_number, 
            :description, 
            :date, 
            :amount, 
            :supplier)");
        $sql->bindParam(":building_id", $building_id);
        $sql->bindParam(":serial_number", $serial_number);
        $sql->bindParam(":description", $description);
        $sql->bindParam(":date", $date_acquired);
        $sql->bindParam(":amount", $amount);
        $sql->bindParam(":supplier", $supplier);
        $sql->execute();

        $_SESSION['sys_equipment_add_suc'] = renderLang($equipments_equipment_added);
        header('location: /add-equipment');
    } else {
        $_SESSION['sys_equipment_add_err'] = renderLang($form_error);
        header('location: /add-equipment');
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