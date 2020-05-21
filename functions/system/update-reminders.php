<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if(checkSession()) {

    $sql = $pdo->prepare("TRUNCATE reminders");
    $sql->execute();

    if($_SESSION['sys_account_mode'] == 'user') {
        $properties = getTable('properties WHERE temp_del = 0');
        foreach($properties as $property) {
            $user_property_ids[] = $property['id'];
        }

        $sub_properties = getTable('sub_properties WHERE temp_del = 0');
        foreach($sub_properties as $sub_property) {
            $user_sub_property_ids[] = $sub_property['id'];
        }

    } else {
        $user_sub_property_ids = $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];
        $user_property_ids = $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];
    }

    $components = array(
        'target_id' => '19',
        'module' => 'labor-cost',
        'reminder_date' => '2020-04-23',
        'user_id' => '1',
        'account_mode' => 'user',
        'message' => 'SAMPLE REMINDER'
    );

    $reminders = array();
    $current_date = date('Y-m-d');

    // collection undeposited
    foreach($user_sub_property_ids as $sub_property_id) {

        // property details
        $sql = $pdo->prepare("SELECT property_name, sub_property_name FROM sub_properties sp JOIN properties p ON(sp.property_id = p.id) WHERE sp.id = :id");
        $sql->bindParam(":id", $sub_property_id);
        $sql->execute();
        if($sql->rowCount()) {

            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $sql1 = $pdo->prepare("SELECT * FROM collection_undeposited WHERE sub_property_id = :sub_property_id");
            $sql1->bindParam(":sub_property_id", $sub_property_id);
            $sql1->execute();
            if($sql1->rowCount()) {
                $grand_total = 0;
                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                    $amount = str_replace(array('P', ',', '₱', ''), '', $data1['grand_total']);
                    $grand_total += floatval($amount);
                }
    
                $reminders[] = array(
                    'target_id' => $sub_property_id,
                    'module' => 'collection',
                    'reminder_date' => $current_date,
                    'user_id' => $_SESSION['sys_id'],
                    'account_mode' => $_SESSION['sys_account_mode'],
                    'message' => 'UNDEPOSITED: '.'₱'.number_format($grand_total, 2, '.', ',').' '.$data['sub_property_name'].' ['.$data['property_name'].']'
                );
            }
        }
    }

    foreach($reminders as $reminder) {
        pushReminder($reminder);
    }

    // set all reminders for this user
    $_SESSION['sys_reminders'] = array();

    $current_date = date_create(date('Y-m-d'));

    $sql = $pdo->prepare("SELECT * FROM reminders WHERE user_id = :user_id AND user_account_mode = :account_mode AND status = 0");
    $sql->bindParam(":user_id", $_SESSION['sys_id']);
    $sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
    $sql->execute();
    if($sql->rowCount()) {
        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            $diff = date_diff($current_date, date_create($data['reminder_date']))->format("%R%a");
            if($diff <= 0) {
                $_SESSION['sys_reminders'][$data['module']][] = array(
                    'reminder_message' => $data['reminder_msg'],
                    'target_id' => $data['target_id'],
                    'module' => $data['module'],
                    'reminder_date' => $data['reminder_date']
                );
            }
        }
    }

    header('location: /dashboard');

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');

}
?>