<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('30-60-90-day-add')) {
	
		$err = 0;
		
		// PROCESS FORM

		// PROJECT NAME
		$prospect_id = 0;
		if(isset($_POST['prospect_id'])) {
            $prospect_id = trim($_POST['prospect_id']);
            if(strlen($prospect_id) == 0) {
                $err++;
                $_SESSION['sys_day_plan_add_prospect_id_err'] = renderLang($day_plans_project_required);
            } else {
                $_SESSION['sys_day_plan_add_prospect_id_suc'] = $prospect_id;
            }
		}

        // DEPLOYMENT DATE
        $deployment_date = '';
        if(isset($_POST['deployment'])) {
            $deployment_date = trim($_POST['deployment']);
            if(strlen($deployment_date) == 0) {
                $err++;
                $_SESSION['sys_day_plan_add_deployment_date_err'] = renderLang($day_plans_date_of_deployment_required);
            } else {
                $_SESSION['sys_day_plan_add_deployment_date_val'] = $deployment_date;
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

        // department
        $department_id = array();
        if(isset($_POST['department_id'])) {
            $department_id = $_POST['department_id'];
        }

        // remarks
        $plan_remarks = array();
        if(isset($_POST['plan_remarks'])) {
            $plan_remarks = $_POST['plan_remarks'];
        }

        // 30 day accomplished date
        $accomplished_date = array();
        if(isset($_POST['accomplished_date_30'])) {
            $accomplished_date['30'] = $_POST['accomplished_date_30'];
        }

        // 60 day accomplished date
        if(isset($_POST['accomplished_date_60'])) {
            $accomplished_date['60'] = $_POST['accomplished_date_60'];
        }

        // 90 day accomplished date
        if(isset($_POST['accomplished_date_90'])) {
            $accomplished_date['90'] = $_POST['accomplished_date_90'];
        }

		
		// VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors
            
            $created = time();
      
			$sql = $pdo->prepare("INSERT INTO day_plan (
                prospect_id, 
                deployment_date, 
                created_date) 
            VALUES (
                :prospect_id, 
                :deployment_date,
                :created)");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":deployment_date", $deployment_date);
            $sql->bindParam(":created", $created);
			$sql->execute();

            $id = $pdo->lastInsertId();
            
            // insert to day_plan_days
            $sql = $pdo->prepare("INSERT INTO `day_plan_days` (
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

            $sql->bindParam(":id", $id);
            foreach($plan_category as $key => $category) {
                if(!empty($plan_date[$key]) && !empty($plan_action[$key])) {

                    $sql->bindParam(":accomplished_date", $accomplished_date[$category]);
                    $sql->bindParam(":plan_category", $category);
                    $sql->bindParam(":plan_date", $plan_date[$key]);
                    $sql->bindParam(":plan_date_to", $plan_date_to[$key]);
                    $sql->bindParam(":plan_action", $plan_action[$key]);
                    $sql->bindParam(":department_id", $department_id[$key]);
                    $sql->bindParam(":plan_remarks", $plan_remarks[$key]);
                    $sql->execute();

                }
            }
			
			// record to system log
            systemLog('day_plan',$id ,'add','');

            // notifications
            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('day-plan', $id, $employee['id'], 'employee', 'day_plan_add');
            }

            foreach($users as $user) {
                push_notification('day-plan', $id, $user['id'], 'user', 'day_plan_add');
            }
            

			$_SESSION['sys_day_plan_add_suc'] = renderLang($day_plans_added);
			header('location: /30-60-90-day-plans');
			
		} else { // error found
			
			$_SESSION['sys_day_plan_add_err'] = renderLang($form_error);
			header('location: /add-30-60-90-day-plan');
			
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