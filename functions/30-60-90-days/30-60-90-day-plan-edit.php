<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('30-60-90-day-edit')) {

        $err = 0;

        $id = $_POST['id'];
        $sql = $pdo->prepare("SELECT * FROM day_plan WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if($_data['temp_del'] != 0) {
            $err++;
            $_SESSION['sys_day_plan_edit_err'] = 'Day plan has been deleted.';
            header('location: /edit-30-60-90-day-plan/'.$_data['id']);
        }

        // PROJECT NAME
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) == 0) {
                $err++;
                $_SESSION['sys_day_plan_edit_prospect_id_err'] = renderLang($day_plans_project_required);
            } else {
                $_SESSION['sys_day_plan_edit_prospect_id_suc'] = $prospect_id;
            }
        }
        
        // status
        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

        // DEPLOYMENT DATE
        $deployment_date = '';
        if(isset($_POST['deployment'])) {
            $deployment_date = trim($_POST['deployment']);
            if(strlen($deployment_date) == 0) {
                $err++;
                $_SESSION['sys_day_plan_edit_deployment_date_err'] = renderLang($day_plans_date_of_deployment_required);
            } else {
                $_SESSION['sys_day_plan_edit_deployment_date_val'] = $deployment_date;
            }
        }

        // plan category
        $plan_category = array();
        if(isset($_POST['plan_category'])) {
            $plan_category = $_POST['plan_category'];
        }

        // plan_date
        $plan_date = array();
        if(isset($_POST['plan_date'])) {
            $plan_date = $_POST['plan_date'];
        }

        // plan date to
        $plan_date_to = array();
        if(isset($_POST['date_to'])) {
            $plan_date_to = $_POST['date_to'];
        }

        // plan_action
        $plan_action = array();
        if(isset($_POST['plan_action'])) {
            $plan_action = $_POST['plan_action'];
        }

        // plan_action
        $department_id = array();
        if(isset($_POST['department_id'])) {
            $department_id = $_POST['department_id'];
        }

        // plan_action
        $plan_remarks = array();
        if(isset($_POST['plan_remarks'])) {
            $plan_remarks = $_POST['plan_remarks'];
        }

        $accomplished_date = array();
        if(isset($_POST['accomplished_date_30'])) {
            $accomplished_date['30'] = $_POST['accomplished_date_30'];
        }

        if(isset($_POST['accomplished_date_60'])) {
            $accomplished_date['60'] = $_POST['accomplished_date_60'];
        }

        if(isset($_POST['accomplished_date_90'])) {
            $accomplished_date['90'] = $_POST['accomplished_date_90'];
        }

        // VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors

            $sql = $pdo->prepare("UPDATE day_plan SET 
            prospect_id = :prospect_id, 
            deployment_date = :deployment_date, 
            day_plan_status = :status 
            WHERE id = :id");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":deployment_date", $deployment_date);
            $sql->bindParam(":status", $status);
            $sql->bindParam(":id", $id);
            $sql->execute();

            foreach($plan_action as $key => $action) {

                $sql = $pdo->prepare("SELECT id FROM day_plan_days WHERE day_plan_id = :id AND plan_action = :action LIMIT 1");
                $sql->bindParam(":id", $id);
                $sql->bindParam(":action", $action);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $sql1 = $pdo->prepare("UPDATE day_plan_days SET 
                    to_be_accomplished_date = :accomplished_date, 
                    day_category = :plan_category, 
                    plan_date = :plan_date, 
                    plan_date_to = :plan_date_to,
                    plan_action = :plan_action, 
                    department_id = :department_id, 
                    plan_remarks = :plan_remarks 
                    WHERE day_plan_id = :id AND plan_action = :action");

                    $sql1->bindParam(":id", $id);
                    $sql1->bindParam(":action", $action);

                    $sql1->bindParam(":accomplished_date", $accomplished_date[$plan_category[$key]]);
                    $sql1->bindParam(":plan_category", $plan_category[$key]);
                    $sql1->bindParam(":plan_date", $plan_date[$key]);
                    $sql1->bindParam(":plan_date_to", $plan_date_to[$key]);
                    $sql1->bindParam(":plan_action", $action);
                    $sql1->bindParam(":department_id", $department_id[$key]);
                    $sql1->bindParam(":plan_remarks", $plan_remarks[$key]);
                    $sql1->execute();


                } else { // insert

                    if(!empty($action)) {

                        // insert to day_plan_days
                        $sql1 = $pdo->prepare("INSERT INTO `day_plan_days` (
                            day_plan_id, 
                            to_be_accomplished_date, 
                            day_category, 
                            plan_date, 
                            plan_date_to,
                            plan_action, 
                            department_id, 
                            plan_remarks) 
                        VALUES (
                            :id, 
                            :accomplished_date, 
                            :plan_category, 
                            :plan_date, 
                            :plan_date_to,
                            :plan_action, 
                            :department_id, 
                            :plan_remarks)");

                        $sql1->bindParam(":id", $id);
                        $sql1->bindParam(":accomplished_date", $accomplished_date[$plan_category[$key]]);
                        $sql1->bindParam(":plan_category", $plan_category[$key]);
                        $sql1->bindParam(":plan_date", $plan_date[$key]);
                        $sql1->bindParam(":plan_date_to", $plan_date_to[$key]);
                        $sql1->bindParam(":plan_action", $action);
                        $sql1->bindParam(":department_id", $department_id[$key]);
                        $sql1->bindParam(":plan_remarks", $plan_remarks[$key]);
                        $sql1->execute();
                    
                    }

                }

            }

            $_SESSION['sys_day_plan_edit_suc'] = renderLang($day_plans_udated);
            header('location: /30-60-90-day-plans');

        } else {

            $_SESSION['sys_day_plan_edit_err'] = renderLang($form_error);
            header('location: /edit-30-60-90-day-plan/'.$id);

        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

    }
    
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>