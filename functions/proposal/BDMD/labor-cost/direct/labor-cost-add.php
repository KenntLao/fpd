<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-add')) {

		$err = 0;

        $proposal_category = 'BDD';

        $parent_version = 0;
        if(isset($_POST['id'])) {
            $parent_version = trim($_POST['id']);
        }

        $version = 1;
        if(isset($_POST['version'])) {
            $version = trim($_POST['version']);
        }
        
        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }

		$prospect_id = '';
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
        }
        
        $personnel_night_shift = 1;
        if(isset($_POST['personnel_night_shift'])) {
            $personnel_night_shift = trim($_POST['personnel_night_shift']);
        }

		$position_ids = array();
		if(isset($_POST['position_id'])) {
			$position_ids = $_POST['position_id'];
		}

		$basic_salary = array();
		if(isset($_POST['basic_salary'])) {
			$basic_salary = $_POST['basic_salary'];
		}

		$allowance = array();
		if(isset($_POST['allowance'])) {
			$allowance = $_POST['allowance'];
		}

		$vl_sl = array();
		if(isset($_POST['vl_sl'])) {
			$vl_sl = $_POST['vl_sl'];
        }
        
        $night_duty = array();
        if(isset($_POST['night_duty'])) {
            $night_duty = $_POST['night_duty'];
        }

		$nd = array();
		if(isset($_POST['nd'])) {
			$nd = $_POST['nd'];
		}

		$monthly_lc = array();
		if(isset($_POST['monthly_lc'])) {
			$monthly_lc = $_POST['monthly_lc'];
		}

		$relief_pool = array();
		if(isset($_POST['relief_pool'])) {
			$relief_pool = $_POST['relief_pool'];
        }
        
        $total_compensation = array();
        if(isset($_POST['total_compensation'])) {
            $total_compensation = $_POST['total_compensation'];
        }

        $total_gmb = array();
        if(isset($_POST['total_gmb'])) {
            $total_gmb = $_POST['total_gmb'];
        }

        $total_cib = array();
        if(isset($_POST['total_cib'])) {
            $total_cib = $_POST['total_cib'];
        }

		$total = array();
		if(isset($_POST['total'])) {
			$total = $_POST['total'];
		}

		$rounded_uo_total = array();
		if(isset($_POST['rounded_uo_total'])) {
			$rounded_uo_total = $_POST['rounded_uo_total'];
		}

		$round_up_grand_total = '';
		if(isset($_POST['round_up_grand_total'])) {
			$round_up_grand_total = trim($_POST['round_up_grand_total']);
        }
        
        $user_id = $_SESSION['sys_id'];
        $user_account_mode = $_SESSION['sys_account_mode'];

		if($err == 0) {

			$sql = $pdo->prepare("INSERT INTO labor_cost (
				prospect_id,
                night_shift_personnel,
				rounded_up_total,
				proposal_category,
                created_by,
                created_by_account_mode,
                status,
                parent_version,
                version
			) VALUES (
				:prospect_id, 
                :night_shift_personnel,
				:rounded_up_total,
				:proposal_category,
                :user_id,
                :user_account_mode,
                :status,
                :parent_version,
                :version
			)");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":night_shift_personnel", $personnel_night_shift);
			$sql->bindParam(":rounded_up_total", $round_up_grand_total);
            $sql->bindParam(":proposal_category", $proposal_category);
            $sql->bindParam(":user_id", $user_id);
            $sql->bindParam(":user_account_mode", $user_account_mode);
            $sql->bindParam(":status", $status);
            $sql->bindParam(":parent_version", $parent_version);
            $sql->bindParam(":version", $version);
			$sql->execute();

			$labor_cost_id = $pdo->lastInsertId();

			$sql = $pdo->prepare("INSERT INTO labor_cost_positions (
				labor_cost_id,
				position_id, 
				basic_salary, 
				allowance, 
				vl_sl,
                night_shift,
				nd, 
				monthly_labor_cost, 
				refief_pool,
                total_compensation,
                total_gmb,
                total_cib,
				total, 
				rounded_up_total
			) VALUES (
				:labor_cost_id,
				:position_id, 
				:basic_salary, 
				:allowance, 
				:vl_sl, 
                :night_shift,
				:nd, 
				:monthly_labor_cost, 
				:relief_pool, 
                :total_compensation,
                :total_gmb,
                :total_cib,
				:total, 
				:rounded_up_total
			)");
			$sql->bindParam(":labor_cost_id", $labor_cost_id);

			foreach($position_ids as $key => $position_id) {
				
				if(checkVar($position_id)) {
					$sql->bindParam(":position_id", $position_id);
					$sql->bindParam(":basic_salary", $basic_salary[$key]);
					$sql->bindParam(":allowance", $allowance[$key]);
                    $sql->bindParam(":vl_sl", $vl_sl[$key]);
                    $sql->bindParam(":night_shift", $night_duty[$key]);
					$sql->bindParam(":nd", $nd[$key]);
					$sql->bindParam(":monthly_labor_cost", $monthly_lc[$key]);
                    $sql->bindParam(":relief_pool", $relief_pool[$key]);
                    $sql->bindParam(":total_compensation", $total_compensation[$key]);
                    $sql->bindParam(":total_gmb", $total_gmb[$key]);
                    $sql->bindParam(":total_cib", $total_cib[$key]);
					$sql->bindParam(":total", $total[$key]);
					$sql->bindParam(":rounded_up_total", $rounded_uo_total[$key]);
					$sql->execute();
				}

            }
            
            // record to system log
            systemLog('labor_cost', $labor_cost_id, 'add','');
            
            $employees = getTable('employees');
			$users = getTable('users');
            foreach ($employees as $employee) {
                push_notification('labor-cost-add', $labor_cost_id, $employee['id'], 'employee', 'labor_cost_add');
            }
            foreach ($users as $user) {
                push_notification('labor-cost-add', $labor_cost_id, $user['id'], 'user', 'labor_cost_add');
            }

			$_SESSION['sys_proposal_labor_cost_add_suc'] = renderLang($proposals_labor_cost_added);
			header('location: /labor-cost-list');

		} else {

			$_SESSION['sys_proposal_labor_cost_add_err'] = renderLang($form_error);
			header('location: /add-labor-cost');

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