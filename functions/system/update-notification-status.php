<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$notification_id = $_POST['notif_id'];

$sql = $pdo->prepare("UPDATE notifications SET 
  status = '1' 
WHERE id = :id");
$sql->bindParam(":id", $notification_id);
$sql->execute();
?>