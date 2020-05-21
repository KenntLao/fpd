<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('daily-collection-update-status')) {

        $err = 0;

        $id = 0;
        if(isset($_POST['id'])) {
            $id = trim($_POST['id']);
            if(strlen($id) == 0) {
                $err++;
            }
        }

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
            if(strlen($status) == 0) {
                $err++;
            }
        }

        $curr_date = '';
        if($status == 1) {
            $curr_date = formatDate(time(), true);
        }

        if($err == 0) {

            $sql = $pdo->prepare("UPDATE daily_collections_payment_types SET 
                status = :status,
                recorded_date = :curr_date
            WHERE id =:id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":curr_date", $curr_date);
            $sql->bindParam(":id", $id);
            $sql->execute();

            echo 'success';

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