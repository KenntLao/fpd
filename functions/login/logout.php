<?php
// VERIFY LOG
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$account_mode = $_SESSION['sys_account_mode'];

session_destroy();
session_start();

// !NEED TRANSLATION
if($account_mode == 'unit_owner' || $account_mode == 'tenant') {

  $_SESSION['sys_user_login_suc'] = renderLang($login_logout_successfully);
  header('location: /user-login');

} else {

  $_SESSION['sys_login_suc'] = renderLang($login_logout_successfully);
  header('location: /');

}
?>