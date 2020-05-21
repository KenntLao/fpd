<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$err = 0;

$item_id = $_POST['item_id'];
$code = $_POST['code'];
$check = $_POST['is_checked'];

$sql = $pdo->prepare("SELECT id, is_checked FROM preventive_maintenance_activities WHERE frequency_code = :code");
$sql->bindParam(":code", $code);
$sql->execute();
if($sql->rowCount()) {
 
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    if($check != $data['is_checked']) {

        $sql = $pdo->prepare('UPDATE preventive_maintenance_activities SET is_checked = :check WHERE frequency_code = :code');
        $sql->bindParam(":check", $check);
        $sql->bindParam(":code", $code);
        $sql->execute();

    }

} else {

    $sql = $pdo->prepare("INSERT INTO preventive_maintenance_activities (
        item_to_check_id, 
        frequency_code, 
        is_checked) 
    VALUES (
        :item_id, 
        :code, 
        :check)");

    $sql->bindParam(":item_id", $item_id);
    $sql->bindParam(":code", $code);
    $sql->bindParam(":check", $check);
    $sql->execute();

}

?>