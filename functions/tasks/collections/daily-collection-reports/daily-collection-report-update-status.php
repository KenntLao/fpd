<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    $status = $_POST['status'];
    $permission = 0;
    if($status == 2 || $status == 4) {
        $permission = checkPermission('daily-collection-report-verify');
    }
    if($status == 3) {
        $permission = checkPermission('daily-collection-report-approve');
    }

    if($permission) {

        $id = $_POST['id'];

        $sql = $pdo->prepare("SELECT * FROM daily_collection_reports WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $change_logs = array('lang_status::'.$data['status'],'=='.$status);

            $sql1 = $pdo->prepare("UPDATE daily_collection_reports SET 
                status = :status 
            WHERE id = :id");
            $sql1->bindParam(":status", $status);
            $sql1->bindParam(":id", $id);
            if($sql1->execute()) {
                echo 'success';
            }

            $sub_property_id = $data['sub_property_id'];

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
                $notification = 'daily_collection_report_verified';
            }
            // returned
            if($status == 4) {
                $notification = 'daily_collection_report_returned';
            }
            // approved
            if($status == 3) {
                $notification = 'daily_collection_report_approved';
            }
            
            foreach ($employees as $employee) {
                push_notification('daily-collection-report',$id,$employee, 'employee', $notification);
            }
            foreach ($users as $user) {
                push_notification('daily-collection-report',$id,$user['id'],'user',$notification);
            }

            // system log
            $change_log = implode(';;', $change_logs);
            systemLog('daily_collection_report',$id,'update', $change_log);

            $_SESSION['sys_daily_collection_report_status_suc'] = $status == 2 ? renderlang($daily_collection_report_verified) : renderlang($daily_collection_report_approved);

        } else {
            echo 'error';
        }

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');
    
    }

} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>