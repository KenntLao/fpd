<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    $id = $_POST['id'];

    $sql = $pdo->prepare("SELECT * FROM positions_for_project WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    $min = $data['minimum_basic_pay'];
    $max = $data['maximum_basic_pay'];

    $arr = array($min, $max);

    echo json_encode($arr);

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>