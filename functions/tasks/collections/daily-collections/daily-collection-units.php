<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$building_id = $_POST['id'];

$sql = $pdo->prepare("SELECT id, unit_name FROM units WHERE sub_property_id = :building_id");
$sql->bindParam(":building_id", $building_id);
$sql->execute();
while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
    echo '<option '.(isset($_SESSION['sys_daily_collection_add_unit_no_val']) && $_SESSION['sys_daily_collection_add_unit_no_val'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['unit_name'].'</option>';
}
?>