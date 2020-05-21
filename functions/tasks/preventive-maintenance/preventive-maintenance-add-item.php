<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

$form_msg = array();

$err = 0;

$id = $_POST['id'];

$sql = $pdo->prepare("SELECT id, temp_del, frequency FROM preventive_maintenance WHERE id = :id LIMIT 1");
$sql->bindParam(":id", $id);
$sql->execute();
$_data = $sql->fetch(PDO::FETCH_ASSOC);
if(!($sql->rowCount())){
    $err++;
    echo 'invalid id.';
} else if($_data['temp_del'] != 0) {
    $err++;
    
    $form_msg['type'] = 'error'; 
    $form_msg['msg'] = 'Preventive maintenance is deleted.';
}

$item = '';
if(isset($_POST['item'])) {
    $item = ucwords(strtolower(trim($_POST['item'])));
    if(strlen($item) == 0) {
        $err++;
        $form_msg['type'] = 'error'; 
        $form_msg['msg'] = 'Item is required.';
    }
}

if($err == 0) {
    
    $sql = $pdo->prepare("INSERT INTO preventive_maintenance_item_to_check (
        preventive_maintenance_id,
        item_to_check, 
        frequency) 
    VALUES (
        :id, 
        :item, 
        :frequency)");
    
    $sql->bindParam(":id", $_data['id']);
    $sql->bindParam(":item", $item);
    $sql->bindParam(":frequency", $_data['frequency']);

    if($sql->execute()) {

        $form_msg['type'] = 'success'; 
        $form_msg['msg'] = '';
    }

} else {
    $form_msg['type'] = 'error'; 
    $form_msg['msg'] = renderLang($form_error);
}

echo json_encode($form_msg);
   
?>