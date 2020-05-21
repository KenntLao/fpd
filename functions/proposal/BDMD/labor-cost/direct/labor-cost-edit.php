<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-edit')) {

		$err = 0;

		$proposal_category = 'BDD';

        $id = $_POST['id'];

        $status = 0;
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
        }
        
        $personnel_night_shift = 1;
        if(isset($_POST['personnel_night_shift'])) {
            $personnel_night_shift = trim($_POST['personnel_night_shift']);
        }

		$labor_cost_id = array();
		if(isset($_POST['labor_cost_id'])) {
			$labor_cost_id = $_POST['labor_cost_id'];
		}

		$prospect_id = '';
		if(isset($_POST['prospect_id'])) {
			$prospect_id = trim($_POST['prospect_id']);
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

            $_data = getData($id, 'labor_cost');

            $change_logs = array();
            if ($personnel_night_shift != $_data['night_shift_personnel']) {
				$tmp = 'labor_cost_needed_personnel_per_night_shift::'.$_data['night_shift_personnel'].'=='.$personnel_night_shift;
				array_push($change_logs, $tmp);
            }
            if ($prospect_id != $_data['prospect_id']) {
				$tmp = 'proposals_project::'.$_data['prospect_id'].'=='.$prospect_id;
				array_push($change_logs, $tmp);
            }
            if ($status != $_data['status']) {
				$tmp = 'proposal_status::'.$_data['status'].'=='.$status;
				array_push($change_logs, $tmp);
			}

			$sql = $pdo->prepare("UPDATE labor_cost SET 
                prospect_id = :prospect_id,
                night_shift_personnel = :night_shift_personnel,
				rounded_up_total = :rounded_up_total, 
				proposal_category = :proposal_category,
                updated_by = :user_id,
                updated_by_account_mode = :user_account_mode,
                status = :status
            WHERE id = :id");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":night_shift_personnel", $personnel_night_shift);
			$sql->bindParam(":rounded_up_total", $round_up_grand_total);
			$sql->bindParam(":proposal_category", $proposal_category);
            $sql->bindParam(":user_id", $user_id);
            $sql->bindParam(":user_account_mode", $user_account_mode);
            $sql->bindParam(":status", $status);
			$sql->bindParam(":id", $id);
			$sql->execute();

			foreach($labor_cost_id as $key => $lc_id) {

				$sql = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE id = :id LIMIT 1");
				$sql->bindParam(":id", $lc_id);
				$sql->execute();
                if($sql->rowCount()) { // update
                    
                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    if ($position_ids[$key] != $data['position_id']) {
                        $tmp = 'labor_cost_position::'.$data['position_id'].'=='.$position_ids[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($basic_salary[$key] != $data['basic_salary']) {
                        $tmp = 'labor_cost_basic_salary::'.$data['basic_salary'].'=='.$basic_salary[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($allowance[$key] != $data['allowance']) {
                        $tmp = 'labor_cost_allowance::'.$data['allowance'].'=='.$allowance[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($night_duty[$key] != $data['night_shift']) {
                        $tmp = 'labor_cost_for_night_duty::'.$data['night_shift'].'=='.$night_duty[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($vl_sl[$key] != $data['vl_sl']) {
                        $tmp = 'labor_cost_vs_sl::'.$data['vl_sl'].'=='.$vl_sl[$key];
                        array_push($change_logs, $tmp);
                    }

                    $sql1 = $pdo->prepare("UPDATE labor_cost_positions SET 
                        position_id = :position_id, 
                        basic_salary = :basic_salary, 
                        allowance = :allowance, 
                        vl_sl = :vl_sl, 
                        night_shift =:night_shift,
                        nd = :nd, 
                        monthly_labor_cost = :monthly_labor_cost, 
                        refief_pool = :relief_pool,
                        total_compensation = :total_compensation,
                        total_gmb = :total_gmb,
                        total_cib = :total_cib,
                        total = :total, 
                        rounded_up_total = :rounded_up_total 
                    WHERE id = :id");
                    $sql1->bindParam(":position_id", $position_ids[$key]);
                    $sql1->bindParam(":basic_salary", $basic_salary[$key]);
                    $sql1->bindParam(":allowance", $allowance[$key]);
                    $sql1->bindParam(":vl_sl", $vl_sl[$key]);
                    $sql1->bindParam(":night_shift", $night_duty[$key]);
                    $sql1->bindParam(":nd", $nd[$key]);
                    $sql1->bindParam(":monthly_labor_cost", $monthly_lc[$key]);
                    $sql1->bindParam(":relief_pool", $relief_pool[$key]);
                    $sql1->bindParam(":total_compensation", $total_compensation[$key]);
                    $sql1->bindParam(":total_gmb", $total_gmb[$key]);
                    $sql1->bindParam(":total_cib", $total_cib[$key]);
                    $sql1->bindParam(":total", $total[$key]);
                    $sql1->bindParam(":rounded_up_total", $rounded_uo_total[$key]);
                    $sql1->bindParam(":id", $lc_id);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO labor_cost_positions (
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
                    if(checkVar($position_ids[$key])) {
                        $sql1->bindParam(":labor_cost_id", $id);
                        $sql1->bindParam(":position_id", $position_ids[$key]);
                        $sql1->bindParam(":basic_salary", $basic_salary[$key]);
                        $sql1->bindParam(":allowance", $allowance[$key]);
                        $sql1->bindParam(":vl_sl", $vl_sl[$key]);
                        $sql1->bindParam(":night_shift", $night_duty[$key]);
                        $sql1->bindParam(":nd", $nd[$key]);
                        $sql1->bindParam(":monthly_labor_cost", $monthly_lc[$key]);
                        $sql1->bindParam(":relief_pool", $relief_pool[$key]);
                        $sql1->bindParam(":total_compensation", $total_compensation[$key]);
                        $sql1->bindParam(":total_gmb", $total_gmb[$key]);
                        $sql1->bindParam(":total_cib", $total_cib[$key]);
                        $sql1->bindParam(":total", $total[$key]);
                        $sql1->bindParam(":rounded_up_total", $rounded_uo_total[$key]);
                        $sql1->execute();

                        $tmp = 'labor_cost_add::'.$position_ids[$key].'=='.$position_ids[$key];
                        array_push($change_logs, $tmp);

                    }
                }

            }

            if(!empty($change_logs)) {
                // record to system log
                $change_log = implode(';;', $change_logs);
                systemLog('labor_cost', $id, 'update', $change_log);
                
                $employees = getTable('employees');
                $users = getTable('users');
                foreach ($employees as $employee) {
                    push_notification('labor-cost-edit', $id, $employee['id'], 'employee', 'labor_cost_update');
                }
                foreach ($users as $user) {
                    push_notification('labor-cost-edit', $id, $user['id'], 'user', 'labor_cost_update');
                }

                $_SESSION['sys_proposal_labor_cost_edit_suc'] = renderlang($labor_cost_updated);
                header('location: /edit-labor-cost/'.$id);

            } else {
                $_SESSION['sys_proposal_labor_cost_edit_err'] = renderlang($form_no_changes);
                header('location: /edit-labor-cost/'.$id);
            }
            

		} else {

            $_SESSION['sys_proposal_labor_cost_edit_err'] = renderLang($form_error);
            header('location: /edit-labor-cost/'.$id);

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