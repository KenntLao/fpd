<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

$unit_id = $_POST['unit_id'];

$empty = 0;

$sql = $pdo->prepare("SELECT firstname, middlename, lastname, uo.id FROM unit_owners uo LEFT JOIN units u ON(u.unit_owner_id = uo.id) WHERE uo.temp_del = 0 AND u.id = :unit_id");
$sql->bindParam(":unit_id", $unit_id);
$sql->execute();

if(!($sql->rowCount())) {
    $empty++;
}

while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
    $full_name = $data['firstname'].' '.$data['lastname'];
    echo '<option '.(isset($_SESSION['sys_job_order_add_requested_by_val']) && $_SESSION['sys_job_order_add_requested_by_val'] == $data['id'].',unit_owner' ? 'selected' : '').' value="'.$data['id'].',unit_owner">'.$full_name.'[unit owner]</option>';
}

$sql = $pdo->prepare("SELECT firstname, middlename, lastname, ut.id FROM unit_tenants ut LEFT JOIN tenants t ON(t.id = ut.tenant_id) WHERE t.temp_del = 0 AND ut.unit_id = :unit_id");
$sql->bindParam(":unit_id", $unit_id);
$sql->execute();

if(!($sql->rowCount())) {
    $empty++;
}

while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
    $full_name = $data['firstname'].' '.$data['lastname'];
    echo '<option '.(isset($_SESSION['sys_job_order_add_requested_by_val']) && $_SESSION['sys_job_order_add_requested_by_val'] == $data['id'].',unit_tenant' ? 'selected' : '').' value="'.$data['id'].',unit_tenant">'.$full_name.'[unit tenant]</option>';
}

if($empty == 2) {
    echo '<option></option>';
}

?>