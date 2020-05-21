<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-deposit-approve')) {

        $err = 0;

        $id = $_POST['id'];

        $status = $_POST['status'];

        if($err == 0) {

            $sub_property_id = getField('sub_property_id', 'daily_deposit', 'id = '.$id);

            $sql = $pdo->prepare("UPDATE daily_deposit SET 
                status = :status 
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            if($sql->execute()) {
                $_SESSION['sys_daily_deposit_approve_suc'] = renderLang($collections_daily_deposit_approved);
                echo 'success';
            }

            if(checkVar($sub_property_id)) {

                // Push Notification daily deposit
                $employees = array();
                $sub_property = '%,'.$sub_property_id.',%';
                $sql = $pdo->prepare("SELECT id FROM employees WHERE sub_property_ids LIKE :sub_property");
                $sql->bindParam(":sub_property", $sub_property);
                $sql->execute();
                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $employees[] = $data['id'];
                }
                $cluster_id = getSubPropertyCluster($sub_property_id);
                if(checkVar($cluster_id)) {
                    $cluster_assigned = getField('assigned', 'clusters', 'id = '.$cluster_id);
                    if($cluster_assigned) {
                        if(!in_array($cluster_assigned, $employees)) {
                            $employees[] = $cluster_assigned;
                        }
                    }
                }
                $users = getTable("users");
                $notification = '';
                // verified
                if($status == 2) {
                    $notification = 'daily_deposit_verify';
                }
                // returned
                if($status == 4) {
                    $notification = 'daily_deposit_return';
                }
                // approved
                if($status == 3) {
                    $notification = 'daily_deposit_approve';
                }
                
                foreach ($employees as $employee) {
                    push_notification('daily-deposit',$id,$employee,'employee',$notification);
                }
                foreach ($users as $user) {
                    push_notification('daily-deposit',$id,$user['id'],'user',$notification);
                }
            }
            
        } else {
            echo 'error';
        }
        
    } else {// permission not found
        
        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        echo 'invalid-permission';
        
    }
    
} else {// no session found, redirect to login page
  
    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    echo 'no-session';
}
?>