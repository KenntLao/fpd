<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('proposal-esd')) {

        // clear sessions from forms
        clearSessions();

        // set page
        $page = 'proposal';

        header("Content-Type: application/json");

        // Procedures Here
        if (isset($_POST['id']) && !empty($_POST['id']) && is_numeric($_POST['id'])) {
            $sql = $pdo->prepare("SELECT * FROM prospecting WHERE status = 3 AND prospecting_category = 1 AND temp_del = 0 AND id = ".$_POST['id']);
            $sql->execute();
            if ($sql->rowCount()==0) {
                echo "{\"status\":\"not found\"}";
            } else {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $dataReturn = [
                    "status" => "ok",
                    "salutation" => $data['contact_person'],
                    "serviceType" => "Other Technical Services",
                    "serviceTypeOther" => mb_strtolower(renderLang($prospecting_service_required_arr[$data['service_required']])). " services",
                    "shortLocation" => $data['location'],
                    "addressLine1" => $data['location'],
                    "clientName" => $data['contact_person']
                ];
                echo json_encode($dataReturn, JSON_PRETTY_PRINT);
            }
        } else {
            echo "{\"status\":\"incomplete\"}";
        }

    } else { // permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
        header('location: /dashboard');

    }
} else { // no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
    header('location: /');

}
?>
