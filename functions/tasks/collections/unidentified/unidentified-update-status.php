<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('unidentified')) {

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

        if($err == 0) {

            $sql = $pdo->prepare("UPDATE unidentified SET 
                status = :status 
            WHERE id = :id");
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            echo $status;

        } else {
            echo 'error';
        }


    } else {
        echo 'invalid-permission';
    }

} else {
    echo 'no-session';
}