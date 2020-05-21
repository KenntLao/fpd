<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

$id = $_POST['id'];
$field = $_POST['field'];

if($field == 'equipment') {

    $sql = $pdo->prepare("SELECT id, serial_number, equipment_name FROM equipments WHERE sub_property_id = :id AND temp_del = 0");
    $sql->bindParam(":id", $id);
    $sql->execute();
    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

        echo '<option value="'.$data['id'].'">'.$data['equipment_name'].'</option>';
    }

    if(!($sql->rowCount())) {
        echo '<option value=""></option>';
    }

}

if($field == 'employee') {

    $building_id = '%,'.$id.',%';

    $sql = $pdo->prepare("SELECT firstname, middlename, lastname, id, employee_id FROM employees WHERE temp_del = 0 AND sub_property_ids like :id ");
    $sql->bindParam(":id", $building_id);
    $sql->execute();
    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
        $full_name = $data['firstname'].' '.(empty($data['middlename']) ? '' : $data['middlename'].' ').$data['lastname'];
        echo '<option value="'.$data['id'].'">['.$data['employee_id'].'] '.$full_name.'</option>';
    }
}
?>