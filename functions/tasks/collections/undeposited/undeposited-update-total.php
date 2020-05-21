<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('undeposited')) {

        $sql = $pdo->prepare("TRUNCATE TABLE collection_undeposited");
        $sql->execute();

        $sql = $pdo->prepare("SELECT sub_property_id, collection_date FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON dc.id = dcpt.daily_collection_id WHERE dcpt.status = 0 AND dc.temp_del = 0 GROUP BY sub_property_id, collection_date");
        $sql->execute();
        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

            $sql1 = $pdo->prepare("SELECT * FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.temp_del = 0 AND dc.sub_property_id = :id AND dc.collection_date = :date AND dcpt.status = 0");
            $sql1->bindParam(":id", $data['sub_property_id']);
            $sql1->bindParam(":date", $data['collection_date']);
            $sql1->execute();
            $total_amount = 0;
            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                $amount  = str_replace(array(',', '₱', 'P', ' '), '', $data1['amount']);
                $total_amount += floatval($amount);
            }

            $grand_total = '₱'.number_format($total_amount, 2, '.', ',');

            // check if exist
            $sql1 = $pdo->prepare("SELECT id FROM collection_undeposited WHERE sub_property_id = :id AND collection_date = :collection_date LIMIT 1");
            $sql1->bindParam(":id", $data['sub_property_id']);
            $sql1->bindParam(":collection_date", $data['collection_date']);
            $sql1->execute();
            if($sql1->rowCount()) { // update

                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                $sql2 = $pdo->prepare("UPDATE collection_undeposited SET 
                    grand_total = :grand_total 
                WHERE id = :id");
                $sql2->bindParam(":grand_total", $grand_total);
                $sql2->bindParam(":id", $data1['id']);
                $sql2->execute();

            } else { // insert

                $sql2 = $pdo->prepare("INSERT INTO collection_undeposited (
                    sub_property_id, 
                    collection_date, 
                    grand_total
                ) VALUES (
                    :sub_property_id, 
                    :collection_date, 
                    :grand_total
                )");
                $sql2->bindParam(":sub_property_id", $data['sub_property_id']);
                $sql2->bindParam(":collection_date", $data['collection_date']);
                $sql2->bindParam(":grand_total", $grand_total);
                $sql2->execute();
                
            }

        }

        echo 'success';

    } else {// permission not found
	}
  
} else {// no session found, redirect to login page
}
?>