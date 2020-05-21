<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-edit')) {

		$err = 0;

        $labor_cost_category = 'BDD';
        
        $id = $_POST['id'];

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

        $labor_cost_ids = array();
        if(isset($_POST['labor_cost_id'])) {
            $labor_cost_ids = $_POST['labor_cost_id'];
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
        
        $compensation = array();
        if(isset($_POST['compensation'])) {
            $compensation = $_POST['compensation'];
        }

        $gmb = array();
        if(isset($_POST['gmb'])) {
            $gmb = $_POST['gmb'];
        }

        $cib = array();
        if(isset($_POST['cib'])) {
            $cib = $_POST['cib'];
        }

        $sub_total = array();
        if(isset($_POST['sub_total'])) {
            $sub_total = $_POST['sub_total'];
        }

        $admin_overhead = array();
        if(isset($_POST['admin_overhead'])) {
            $admin_overhead = $_POST['admin_overhead'];
        }

        $monthly_labor_cost = array();
        if(isset($_POST['monthly_labor_cost'])) {
            $monthly_labor_cost = $_POST['monthly_labor_cost'];
        }

        $rounded_uo_total = array();
        if(isset($_POST['rounded_uo_total'])) {
            $rounded_uo_total = $_POST['rounded_uo_total'];
        }

        $total_monthly_labor_cost = '';
        if(isset($_POST['total_monthly_labor_cost'])) {
            $total_monthly_labor_cost = trim($_POST['total_monthly_labor_cost']);
        }

        $round_up_total = '';
        if(isset($_POST['round_up_total'])) {
            $round_up_total = trim($_POST['round_up_total']);
        }

        $user_id = $_SESSION['sys_id'];
        $user_account_mode = $_SESSION['sys_account_mode'];

		if($err == 0) {

			$sql = $pdo->prepare("UPDATE labor_cost_outsource SET 
                prospect_id = :prospect_id, 
                night_shift_personnel = :night_shift_personnel, 
                total_montly_labor_cost = :total_monthly_lc,
                updated_by = :updated_by,
                updated_by_account_mode = :updated_by_account_mode,
                status = :status,
                round_up_total = :round_up_total
            WHERE id = :id");
            $sql->bindParam(":prospect_id", $prospect_id);
            $sql->bindParam(":night_shift_personnel", $personnel_night_shift);
            $sql->bindParam(":total_monthly_lc", $total_monthly_labor_cost);
            $sql->bindParam(":updated_by", $user_id);
            $sql->bindParam(":updated_by_account_mode", $user_account_mode);
            $sql->bindParam(":status", $status);
            $sql->bindParam(":round_up_total", $round_up_total);
            $sql->bindParam(":id", $id);
            $sql->execute();
            
            foreach($labor_cost_ids as $key => $labor_cost_id) {

                $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource_positions WHERE id = :id");
                $sql->bindParam(":id", $labor_cost_id);
                $sql->execute();
                if($sql->rowCount()) { // updates
                    
                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    $sql1 = $pdo->prepare("UPDATE labor_cost_outsource_positions SET 
                        position_id = :position_id, 
                        basic_salary = :basic_salary, 
                        allowance = :allowance, 
                        vl_sl = :vl_sl, 
                        night_shift = :night_shift, 
                        nd = :nd,
                        total_compensation = :compensation,
                        total_gmb = :gmb,
                        total_cib = :cib,
                        sub_total = :sub_total, 
                        admin_overhead = :admin_overhead, 
                        montly_labor_cost = :monthly_labor_cost,
                        rounded_up_total = :rounded_up_total
                    WHERE id = :id");
                    $sql1->bindParam(":position_id", $position_ids[$key]);
                    $sql1->bindParam(":basic_salary", $basic_salary[$key]);
                    $sql1->bindParam(":allowance", $allowance[$key]);
                    $sql1->bindParam(":vl_sl", $vl_sl[$key]);
                    $sql1->bindParam(":night_shift", $night_duty[$key]);
                    $sql1->bindParam(":nd", $nd[$key]);
                    $sql1->bindParam(":compensation", $compensation[$key]);
                    $sql1->bindParam(":gmb", $gmb[$key]);
                    $sql1->bindParam(":cib", $cib[$key]);
                    $sql1->bindParam(":sub_total", $sub_total[$key]);
                    $sql1->bindParam(":admin_overhead", $admin_overhead[$key]);
                    $sql1->bindParam(":monthly_labor_cost", $monthly_labor_cost[$key]);
                    $sql1->bindParam(":rounded_up_total", $rounded_uo_total[$key]);
                    $sql1->bindParam(":id", $labor_cost_id);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO labor_cost_outsource_positions (
                        labor_cost_id,
                        position_id, 
                        basic_salary, 
                        allowance, 
                        vl_sl, 
                        night_shift, 
                        nd, 
                        total_compensation,
                        total_gmb,
                        total_cib,
                        sub_total, 
                        admin_overhead, 
                        montly_labor_cost,
                        rounded_up_total
                    ) VALUES (
                        :labor_cost_id,
                        :position_id, 
                        :basic_salary, 
                        :allowance,
                        :vl_sl, 
                        :night_shift, 
                        :nd,
                        :compensation,
                        :gmb,
                        :cib,
                        :sub_total, 
                        :admin_overhead, 
                        :monthly_lc,
                        :rounded_up_total
                    )");

                    if(strlen($position_ids[$key]) != 0) {
                        $sql1->bindParam(":labor_cost_id", $id);
                        $sql1->bindParam(":position_id", $position_ids[$key]);
                        $sql1->bindParam(":basic_salary", $basic_salary[$key]);
                        $sql1->bindParam(":allowance", $allowance[$key]);
                        $sql1->bindParam(":vl_sl", $vl_sl[$key]);
                        $sql1->bindParam(":night_shift", $night_duty[$key]);
                        $sql1->bindParam(":nd", $nd[$key]);
                        $sql1->bindParam(":compensation", $compensation[$key]);
                        $sql1->bindParam(":gmb", $gmb[$key]);
                        $sql1->bindParam(":cib", $cib[$key]);
                        $sql1->bindParam(":sub_total", $sub_total[$key]);
                        $sql1->bindParam(":admin_overhead", $admin_overhead[$key]);
                        $sql1->bindParam(":monthly_lc", $monthly_labor_cost[$key]);
                        $sql1->bindParam(":rounded_up_total", $rounded_uo_total[$key]);
                        $sql1->execute();
                    }

                }

            }

			$_SESSION['sys_labor_cost_outsource_edit_suc'] = renderLang($proposals_labor_cost_added);
			header('location: /outsource-labor-cost-list');

		} else {

			$_SESSION['sys_labor_cost_outsource_edit_err'] = renderLang($form_error);
			header('location: /edit-outsource-labor-cost/'.$id);

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