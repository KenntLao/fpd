<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('cancelled-collections')) {

        $err = 0;

        $collection_id = '';
        if(isset($_POST['collection_id'])) {
            $collection_id = trim($_POST['collection_id']);
            if(strlen($collection_id) == 0) {
                $err++;
            }
        }

        $cancelled_attachment = array();
        if(isset($_FILES['cancelled_attachment'])) {
            $cancelled_attachment = $_FILES['cancelled_attachment'];
        }

        $user_id = $_SESSION['sys_id'];
        $account_mode = $_SESSION['sys_account_mode'];

        if($err == 0) {

            $sql = $pdo->prepare("INSERT INTO cancelled_collection (
                collection_id, 
                attachment,
                user_id, 
                account_mode
            ) VALUES (
                :collection_id, 
                :attachment, 
                :user_id, 
                :account_mode
            )");
            $sql->bindParam(":collection_id", $collection_id);
            $sql->bindParam(":user_id", $user_id);
            $sql->bindParam(":account_mode", $account_mode);
            
            $attachment_name = '';
            if(!empty($cancelled_attachment)) {
                if(!is_dir($sys_upload_dir.'cancelled-collection')) {
                    mkdir($sys_upload_dir.'cancelled-collection', 0755, true);
                }

                $file = explode('.', $cancelled_attachment['name']);
                $file_name = $file[0];
                $file_ext = $file[1];

                $time = time();

                $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                $file_tmp = $cancelled_attachment['tmp_name'];
                $file_size = $cancelled_attachment['size'];
                
                // save file
                move_uploaded_file($file_tmp, $sys_upload_dir.'cancelled-collection/'.$attachment_name);

            }
            $sql->bindParam(":attachment", $attachment_name);
            $sql->execute();

            $_SESSION['sys_cancelled_collection_add_suc'] = renderLang($cancelled_collections_submitted_for_cancellation);
            echo 'success';

        } else {
            $_SESSION['sys_cancelled_collection_add_err'] = renderLang($form_something_went_wrong);
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