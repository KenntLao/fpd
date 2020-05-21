<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if(checkSession()) {

    $user_id = $_SESSION['sys_id'];
    $account_mode = $_SESSION['sys_account_mode'];

    // set all notifications as seen
    $sql = $pdo->prepare("UPDATE notifications SET 
        status = '1' WHERE user_id = :user_id AND account_mode = :account_mode AND status IS NULL");
    $sql->bindParam(":user_id", $user_id);
    $sql->bindParam(":account_mode", $account_mode);
    $sql->execute();

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');

}
?>