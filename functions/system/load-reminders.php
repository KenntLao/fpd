<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// insert reminders of daily collection undepsited
$sql = $pdo->prepare("SELECT * FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON dc.id = dcpt.daily_collection_id LEFT JOIN sub_properties sp ON sp.id = dc.sub_property_id LEFT JOIN properties p ON sp.property_id = p.id WHERE dcpt.status = 0 AND dc.temp_del = 0");
$sql->execute();
while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
  $amount = str_replace(array('₱', ' ',  ','), '', $data['amount']);
  $amount = (float)$amount;
  echo $data['sub_property_id'].' = '.$data['collection_date'].' = '.$amount.'<br>';
}
?>