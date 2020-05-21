<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';

		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM labor_cost WHERE id = :id AND temp_del = 0 LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            $status = $_data['status'];
            $module_id = $_data['id'];
            
            $sql1 = $pdo->prepare("SELECT * FROM labor_cost WHERE parent_version = :id AND temp_del = 0 AND prospect_id = :prospect_id ORDER BY version DESC");
            $sql1->bindParam(":id", $_data['id']);
            $sql1->bindParam(":prospect_id", $_data['prospect_id']);
            $sql1->execute();
            if($sql1->rowCount()) {
                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                $status = $data1['status'];
                $module_id = $data1['id'];
            }

		} else {
			$_SESSION['sys_proposal_labor_cost_edit_err'] = renderLang($lang_no_data);
			header('location: /pre-operation-audit-tsa-list');
			exit();
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($proposals_labor_cost); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>

    <style>
    th {
        text-align: center;
    }
    </style>
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-handshake mr-3"></i><?php echo renderLang($proposals_labor_cost); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_labor_cost_approve_suc');
                    renderError('sys_labor_cost_approve_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($proposals_labor_cost_form); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-<?php echo $labor_cost_status_color_arr[$status]; ?>"><?php echo renderLang($labor_cost_status_arr[$status]); ?></button>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="prospect_id"><?php echo renderLang($proposals_project); ?></label>
                                        <input type="text" class="form-control input-readonly" value="<?php echo getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']); ?>" readonly>
                                    </div>
                                </div>

                            </div>

                            <!-- labor cost -->
                            <h4><?php echo renderLang($labor_cost_version).' '.$_data['version']; ?></h4>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 mb-4">
                                    <label for="personnel_night_shift"><?php echo renderLang($labor_cost_needed_personnel_per_night_shift); ?></label>
                                    <input type="number" class="form-control input-readonly personnel_night_shift" name="personnel_night_shift" value="<?php echo $_data['night_shift_personnel']; ?>" readonly>
                                </div>

                                <div class="col-12 table-responsive">
                                    <table class="table table-condensed table-bordered" id="labor-cost">
                                        <thead>
                                            <tr>
                                                <th rowspan="2"><p class="w300"><?php echo renderLang($labor_cost_position); ?></p></th>
                                                <th rowspan="2"><p class="w55"><?php echo renderLang($labor_cost_job_grade); ?></p></th>
                                                <th colspan="3" class="text-center bg-dark"><?php echo renderLang($labor_cost_compensation); ?></th>
                                                <th colspan="10" class="text-center bg-dark"><?php echo renderLang($labor_cost_government_mandated_benefits); ?></th>
                                                <th  colspan="7" class="text-center bg-dark"><?php echo renderLang($labor_cost_company_initiated_benefits); ?></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_monthly_labor_cost); ?></p></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_relief_pool); ?></p></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_total); ?></p></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_rounded_total); ?></p></th>
                                            </tr>
                                            <tr>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_basic_salary); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_allowance); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_total_compensation); ?></p></th>

                                                <th><p class="w100"><?php echo renderLang($labor_cost_sss); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_ecc); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_phic); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_hdmf); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_13th_month_pay); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_ra_7641); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_for_night_duty); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_night_differential); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_service_incentive_leave); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_total_gmb); ?></th>

                                                <th><p class="w100"><?php echo renderLang($labor_cost_vs_sl); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_incentive_leave); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_chif); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_uniform); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_office_activities); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_performance_bonus); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_total_cib); ?></p></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE labor_cost_id = :id");
                                            $sql->bindParam(":id", $id);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        echo '<input type="hidden" name="labor_cost_id[]" value="'.$data['id'].'">';
                                                        // position
                                                        echo '<td>';
                                                            echo '<input type="hidden" class="position" value="'.$data['position_id'].'">';
                                                            echo getField('position', 'positions_for_project', 'id = '.$data['position_id']);
                                                        echo '</td>';

                                                        echo '<td><input type="text" class="form-control border-0 job-grade input-readonly" name="" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 salary input-readonly" name="basic_salary[]" data-type="currency" value="'.$data['basic_salary'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 allowance input-readonly" name="allowance[]" data-type="currency" value="'.$data['allowance'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-compensation input-readonly" name="" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 sss input-readonly" name="" value="₱1,600.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="₱30.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="₱100.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>';
                                                        echo '<td>';
                                                            echo '<input type="hidden" class="night-duty" value="'.$data['night_shift'].'">';
                                                            echo renderLang($yesno_arr[$data['night_shift']][1]);
                                                        echo '</td>';
                                                        echo '<td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 total-gmb input-readonly" name="" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 vl-sl input-readonly" name="vl_sl[]" value="'.$data['vl_sl'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly data-code=""></td>';
                                                        echo '<td><input type="text" class="form-control border-0 chif input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 office-activities input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 performance-bonus input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-cib input-readonly" name="" readonly></td>';
                                                        
                                                        echo '<td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly" name="monthly_lc[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 relief-pool input-readonly" name="relief_pool[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total input-readonly" name="total[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 round-up-total input-readonly" name="rounded_uo_total[]" readonly></td>';

                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th><?php echo renderLang($proposals_totals); ?></th>
                                                <th><p></p></th>
                                                <th><p class="total_salary"></p></th>
                                                <th><p class="total_allowance"></p></th>
                                                <th><p class="compensation_total"></p></th>
                                                <th><p class="total_sss"></p></th>
                                                <th><p class="total_ecc"></p></th>
                                                <th><p class="total_phic"></p></th>
                                                <th><p class="total_hdmf"></p></th>
                                                <th><p class="total_13_month"></p></th>
                                                <th><p class="total_RA_7641"></p></th>
                                                <!-- night duty -->
                                                <th><p class="total_night_duty"></p></th>
                                                <th><p class="total_nd"></p></th>
                                                <th><p class="total_service_incentive_leave"></p></th>
                                                <th><p class="gmb_total"></p></th>
                                                <th><p></p></th>
                                                <th><p class="total_incentive_leave"></p></th>
                                                <th><p class="total_chif"></p></th>
                                                <th><p class="total_uniform"></p></th>
                                                <th><p class="total_office_activities"></p></th>
                                                <th><p class="total_performance_bonus"></p></th>
                                                <th><p class="cib_total"></p></th>
                                                <th><p class="total_monthly_labor_cost"></p></th>
                                                <th><p class="total_relief_pool"></p></th>
                                                <th><p class="total_total"></p></th>
                                                <th>
                                                    <p class="total_round_up_total"></p>
                                                    <input type="hidden" name="round_up_grand_total" id="round_up_grand_total">
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                            </div>

                            <?php 
                            $sql = $pdo->prepare("SELECT * FROM labor_cost WHERE parent_version = :id AND temp_del = 0");
                            $sql->bindParam(":id", $id);
                            $sql->execute();
                            $row_count = $sql->rowCount();
                            $num = 0;
                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) { 
                                $num++;?>
                                <br>
                                <h4>
                                    <?php 
                                    if($status == 3)  {
                                        if($num == $row_count) {
                                            $_version = $_SESSION['sys_language'] ? '最後の' : 'FINAL';
                                        } else {
                                            $_version = $data['version'];
                                        }
                                    } else {
                                        $_version = $data['version'];
                                    }
                                    echo renderLang($labor_cost_version).' '.$_version;
                                    ?>
                                    <?php 
                                    if($num == $row_count && $status != 3) {
                                        echo '<span class="ml-2"><a href="/edit-labor-cost/'.$data['id'].'" class="btn btn-xs btn-success" title="'.renderLang($labor_cost_edit).'"><i class="fa fa-pencil-alt"></i></button></a>';
                                    }
                                    ?>
                                </h4>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-4">
                                        <label for="personnel_night_shift"><?php echo renderLang($labor_cost_needed_personnel_per_night_shift); ?></label>
                                        <input type="number" class="form-control input-readonly personnel_night_shift" name="personnel_night_shift" value="<?php echo $data['night_shift_personnel']; ?>" readonly>
                                    </div>

                                    <div class="col-12 table-responsive">
                                        <table class="table table-condensed table-bordered" id="labor-cost">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2"><p class="w300"><?php echo renderLang($labor_cost_position); ?></p></th>
                                                    <th rowspan="2"><p class="w55"><?php echo renderLang($labor_cost_job_grade); ?></p></th>
                                                    <th colspan="3" class="text-center bg-dark"><?php echo renderLang($labor_cost_compensation); ?></th>
                                                    <th colspan="10" class="text-center bg-dark"><?php echo renderLang($labor_cost_government_mandated_benefits); ?></th>
                                                    <th  colspan="7" class="text-center bg-dark"><?php echo renderLang($labor_cost_company_initiated_benefits); ?></th>
                                                    <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_monthly_labor_cost); ?></p></th>
                                                    <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_relief_pool); ?></p></th>
                                                    <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_total); ?></p></th>
                                                    <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_rounded_total); ?></p></th>
                                                </tr>
                                                <tr>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_basic_salary); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_allowance); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_total_compensation); ?></p></th>

                                                    <th><p class="w100"><?php echo renderLang($labor_cost_sss); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_ecc); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_phic); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_hdmf); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_13th_month_pay); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_ra_7641); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_for_night_duty); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_night_differential); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_service_incentive_leave); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_total_gmb); ?></th>

                                                    <th><p class="w100"><?php echo renderLang($labor_cost_vs_sl); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_incentive_leave); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_chif); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_uniform); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_office_activities); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_performance_bonus); ?></p></th>
                                                    <th><p class="w100"><?php echo renderLang($labor_cost_total_cib); ?></p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql1 = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE labor_cost_id = :id");
                                                $sql1->bindParam(":id", $data['id']);
                                                $sql1->execute();
                                                if($sql1->rowCount()) {
                                                    while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                            echo '<input type="hidden" name="labor_cost_id[]" value="'.$data1['id'].'">';
                                                            // position
                                                            echo '<td>';
                                                                echo '<input type="hidden" class="position" value="'.$data1['position_id'].'">';
                                                                echo getField('position', 'positions_for_project', 'id = '.$data1['position_id']);
                                                            echo '</td>';

                                                            echo '<td><input type="text" class="form-control border-0 job-grade input-readonly" name="" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 salary input-readonly" name="basic_salary[]" data-type="currency" value="'.$data1['basic_salary'].'" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 allowance input-readonly" name="allowance[]" data-type="currency" value="'.$data1['allowance'].'" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total-compensation input-readonly" name="" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 sss input-readonly" name="" value="₱1,600.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="₱30.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="₱100.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>';
                                                            echo '<td>';
                                                                echo '<input type="hidden" class="night-duty" value="'.$data1['night_shift'].'">';
                                                                echo renderLang($yesno_arr[$data1['night_shift']][1]);
                                                            echo '</td>';
                                                            echo '<td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 total-gmb input-readonly" name="" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 vl-sl input-readonly" name="vl_sl[]" value="'.$data1['vl_sl'].'" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly data-code=""></td>';
                                                            echo '<td><input type="text" class="form-control border-0 chif input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 office-activities input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 performance-bonus input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total-cib input-readonly" name="" readonly></td>';
                                                            
                                                            echo '<td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly" name="monthly_lc[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 relief-pool input-readonly" name="relief_pool[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total input-readonly" name="total[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 round-up-total input-readonly" name="rounded_uo_total[]" readonly></td>';

                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($proposals_totals); ?></th>
                                                    <th><p></p></th>
                                                    <th><p class="total_salary"></p></th>
                                                    <th><p class="total_allowance"></p></th>
                                                    <th><p class="compensation_total"></p></th>
                                                    <th><p class="total_sss"></p></th>
                                                    <th><p class="total_ecc"></p></th>
                                                    <th><p class="total_phic"></p></th>
                                                    <th><p class="total_hdmf"></p></th>
                                                    <th><p class="total_13_month"></p></th>
                                                    <th><p class="total_RA_7641"></p></th>
                                                    <!-- night duty -->
                                                    <th><p class="total_night_duty"></p></th>
                                                    <th><p class="total_nd"></p></th>
                                                    <th><p class="total_service_incentive_leave"></p></th>
                                                    <th><p class="gmb_total"></p></th>
                                                    <th><p></p></th>
                                                    <th><p class="total_incentive_leave"></p></th>
                                                    <th><p class="total_chif"></p></th>
                                                    <th><p class="total_uniform"></p></th>
                                                    <th><p class="total_office_activities"></p></th>
                                                    <th><p class="total_performance_bonus"></p></th>
                                                    <th><p class="cib_total"></p></th>
                                                    <th><p class="total_monthly_labor_cost"></p></th>
                                                    <th><p class="total_relief_pool"></p></th>
                                                    <th><p class="total_total"></p></th>
                                                    <th>
                                                        <p class="total_round_up_total"></p>
                                                        <input type="hidden" name="round_up_grand_total" id="round_up_grand_total">
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    
                                </div>
                            <?php } ?>

                            <?php if(checkPermission('proposal-bdd-labor-cost-comments')) { ?>
                            <!-- comment box -->
                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'labor-cost' AND module_type = 'approval' AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
                                $sql->bindParam(":id", $id);
                                $sql->execute();
                                ?>
                                <div class="row mt-5">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6">

                                        <div class="card card-primary direct-chat direct-chat-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo renderLang($lang_comments); ?></h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="direct-chat-messages">

                                                    <?php 
                                                    if($sql->rowCount()) {
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            
                                                            if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['user_account_mode']) {
                                                            echo '<div class="direct-chat-msg right">';
                                                                echo '<div class="direct-chat-info clearfix">';

                                                                    echo '<span class="direct-chat-name float-right">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                    echo '<span class="direct-chat-timestamp float-left">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                    echo '</div>';

                                                                    echo '<img class="direct-chat-img" src="'.$_SESSION['sys_photo'].'" alt="message user image">';

                                                                    echo '<div class="direct-chat-text">';
                                                                        echo $data['comment'];
                                                                    echo '</div>';

                                                            echo '</div>';

                                                            } else {

                                                            echo '<div class="direct-chat-msg">';
                                                                echo '<div class="direct-chat-info clearfix">';

                                                                    echo '<span class="direct-chat-name float-left">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                    echo '<span class="direct-chat-timestamp float-right">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                echo '</div>';

                                                                    if($data['user_account_mode'] == 'user') {
                                                                        $photo = '/assets/images/profile/default.png';
                                                                    } else {
                                                                        $gender = getField('gender', 'employees', 'id = '.$data['user_id']);
                                                                        $photo = getField('photo', 'employees', 'id = '.$data['user_id']);
                                                                        if(!checkVar($photo)) {
                                                                            switch($gender) {
                                                                                case 0:
                                                                                    $photo = '/dist/img/avatar2.png';
                                                                                    break;
                                                                                case 1:
                                                                                    $photo = '/dist/img/avatar5.png';
                                                                            }
                                                                        }
                                                                    }

                                                                    echo '<img class="direct-chat-img" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';

                                                                    echo '<div class="direct-chat-text">';
                                                                        echo $data['comment'];
                                                                    echo '</div>';
                                                            echo '</div>';

                                                            }

                                                                
                                                        }
                                                    } else {
                                                        echo 'No Comment Yet.';
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <?php if(checkPermission('proposal-bdd-labor-cost-comment-add')) { ?>
                                                    <div class="input-group">
                                                        <input type="text" name="comment" placeholder="" class="form-control" id="comment-input">
                                                        <span class="input-group-append">
                                                            <button type="button" id="add-comment" class="btn btn-primary">Send</button>
                                                        </span>
                                                    </div>
                                                    <p id="err_msg" class="error-message text-danger mt-1"></p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php 
                            } 
                            ?>

                            <?php if(checkPermission('proposal-bdd-labor-cost-approval') && $status == 1) { ?>
                            <div class="row mt-3">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <button class="btn btn-danger approval" data-status="2"><i class="fa fa-reply mr-2"></i><?php echo renderLang($lang_return); ?></button>
                                    <button class="btn btn-success approval" data-status="3"><i class="fa fa-check mr-2"></i><?php echo renderLang($lang_approve); ?></button>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/labor-cost-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                            <?php if(checkPermission('proposal-bdd-labor-cost-edit') && $status == 2) { ?>
                                <a href="/labor-cost-new-version/<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-clone mr-1"></i><?php echo renderLang($labor_cost_new_version); ?></a>
                            <?php } ?>
                        </div>
                    </div>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/assets/js/labor-cost.js"></script>
    <script>
    $(function(){

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        <?php
        // approval notification
        if(isset($_SESSION['sys_labor_cost_approve_suc_alert'])) {
            ?>
            Toast.fire({
                type: 'success',
                title: '<?php echo $_SESSION['sys_labor_cost_approve_suc_alert']; ?>'
            });
            <?php
            unset($_SESSION['sys_labor_cost_approve_suc_alert']);
        }
        ?>

        // approval
            $('body').on('click', '.approval', function(e){
                e.preventDefault();

                var status = $(this).data('status');
                var id = <?php echo $module_id; ?>;

                $.post("/update-labor-cost-status", {
                    status:status, id:id
                }, function(data) {

                    switch(data) {
                        case "success":
                            window.location.reload();
                            break;
                        case "invalid-permission":
                            window.location.href = "/dashboard";
                            break;
                        case "no-session":
                            window.location.href = "/";
                            break;
                        default:
                            window.location.reload();
                            break;
                    }

                });

            });
        // 

        // add comment
            $('#add-comment').on('click', function(e){
                e.preventDefault();

                var comment = $('input[name="comment"]').val();
                var module = 'labor-cost';
                var module_type = "approval";
                var module_id = <?php echo $id; ?>;

                if(comment.trim() !== '') {
                    $.post('/add-comment', {
                        comment:comment, module:module, 
                        module_type:module_type, module_id:module_id
                    }, function(data){
                        window.location.reload();
                    });
                }

            });

            $('#comment-input').on('keypress', function(e){
                if(e.keyCode == '13') { // enter key
                    $('#add-comment').click();
                }
            });
        // 

        var position_code = '';

		// get position data on load 
            $('.position').each(function() {
                var id = $(this).val();
                var $this = $(this);

                $.post('/get-labor-cost-position-data', {
                    id:id
                }, function(result) {
                    var data = JSON.parse(result);

                    position_code = data['code'];
                    $this.closest('tr').find('.incentive-leave').attr('data-code', position_code);

                    $this.closest('tr').find('.job-grade').val(data['job_grade']);

                    $this.closest('tr').find('.uniform').val(data['uniform']);
                    $this.closest('tr').find('.office-activities').val(data['office_activities_total']);

                    formatCurrency($this.closest('tr').find('.uniform'), "blur");
                    formatCurrency($this.closest('tr').find('.office-activities'), "blur");
                    
                    compute($this, position_code);
                    
                    $('#round_up_grand_total').val($('.total_round_up_total').html());

                });
                
            });
        // 

        // ND total base on personnel number
            var nd_amount = 1800;
            var nd_total = 0;
            $('.personnel_night_shift').each(function(){
                var personnel_number = $(this).val();
                nd_total = nd_amount * personnel_number;
                $(this).closest('.row').find('.total_nd').html(convert_to_currency(nd_total, "blur"));
            });
        // 
        
        // night duty change

            $('.night-duty').each(function(){
                var $this = $(this);
                position_code = $this.closest('tr').find('.incentive-leave').attr('data-code');
                
                compute($this, position_code);
                night_diferential();

            });
        //

    });

    function night_diferential() {

        $('.total_nd').each(function(){

            var nd_total = $(this).html();
            nd_total = convertCurrency(nd_total);
            var total_night_duty = $(this).closest('tr').find('.total_night_duty').html();
            total_night_duty = convertCurrency(total_night_duty);

            var distributed_nd = nd_total / total_night_duty;

            $(this).closest('table').find('.nd').each(function() {
                var yes = $(this).closest('tr').find('.night-duty').val();                    
                if(yes == 1) {
                    $(this).closest('tr').find('.nd').val(convert_to_currency(distributed_nd, "blur"));
                } else {
                    $(this).closest('tr').find('.nd').val('');
                }
                get_total_gmb($(this));
                get_monthly_labor_cost($(this));
                get_relief_pool($(this));
                get_total($(this));
                get_total_round_up_total($(this));
                compute_all_total();
            });

        });

    }
    </script>
	
</body>

</html>
<?php
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>