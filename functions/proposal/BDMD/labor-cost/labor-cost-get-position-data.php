<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost')) {

        $results = array();

        $id = $_POST['id'];
        $sql = $pdo->prepare("SELECT * FROM positions_for_project WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $results = $data;

        }

        echo json_encode($results);

    } else { // permission not found

		// $_SESSION['sys_permission_err'] = renderLang($permission_message_1);

	}
} else { // no session found, redirect to login page

	// $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);

}
?>