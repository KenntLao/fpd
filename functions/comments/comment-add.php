<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    $err = 0;

    // comment
    $comment = '';
    if(isset($_POST['comment'])) {
        $comment = trim($_POST['comment']);
    }

    // module
    $module = '';
    if(isset($_POST['module'])) {
        $module = trim($_POST['module']);
    }  

    // module type
    $module_type = '';
    if(isset($_POST['module_type'])) {
        $module_type = trim($_POST['module_type']);
    }

    // module id
    $module_id = '';
    if(isset($_POST['module_id'])) {
        $module_id = trim($_POST['module_id']);
        if(strlen($module_id) == 0) {
            $err++;
        }
    }

    $date = time();
    $user_id = $_SESSION['sys_id'];
    $user_account_mode = $_SESSION['sys_account_mode'];

    if($err == 0) {

        $sql = $pdo->prepare("INSERT INTO comments (
            module, 
            module_type, 
            module_id, 
            comment, 
            comment_date, 
            user_id, 
            user_account_mode
        ) VALUES (
            :module, 
            :module_type, 
            :module_id, 
            :comment, 
            :comment_date, 
            :user_id, 
            :user_account_mode
        )");
        $sql->bindParam(":module", $module);
        $sql->bindParam(":module_type", $module_type);
        $sql->bindParam(":module_id", $module_id);
        $sql->bindParam(":comment", $comment);
        $sql->bindParam(":comment_date", $date);
        $sql->bindParam(":user_id", $user_id);
        $sql->bindParam(":user_account_mode", $user_account_mode);
        $sql->execute();

        echo 'success'.$module_type;

    } else {
        echo 'error';
    }

} else { // no session found, redirect to login page

	echo renderLang($login_msg_err_4);

}
?>