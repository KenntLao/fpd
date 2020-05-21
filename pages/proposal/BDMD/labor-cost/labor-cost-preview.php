<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('proposal-bdd-labor-cost-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'proposal';

        $id = $_GET['id'];
        
        $labor_cost_direct_id = 0;
        $labor_cost_outsource_id = 0;
        $night_shift_personnel = 0;

        $sql = $pdo->prepare("SELECT * FROM labor_cost WHERE prospect_id = :prospect_id AND parent_version = 0 LIMIT 1");
        $sql->bindParam(":prospect_id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $labor_cost_direct_id = $data['id'];
            $personnel = $data['night_shift_personnel'];

            $sql1 = $pdo->prepare("SELECT * FROM labor_cost WHERE parent_version = :id AND temp_del = 0 AND prospect_id = :prospect_id ORDER BY version DESC");
            $sql1->bindParam(":id", $data['id']);
            $sql1->bindParam(":prospect_id", $data['prospect_id']);
            $sql1->execute();
            if($sql1->rowCount()) {
                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                $labor_cost_direct_id = $data1['id'];
                $personnel = $data1['night_shift_personnel'];
            }
            $night_shift_personnel += $personnel;
        }

        $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE prospect_id = :prospect_id AND parent_version = 0 LIMIT 1");
        $sql->bindParam(":prospect_id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $labor_cost_outsource_id = $data['id'];
            $personnel = $data['night_shift_personnel'];

            $sql1 = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE parent_version = :parent_id AND temp_del = 0 AND prospect_id = :prospect_id ORDER BY version DESC");
            $sql1->bindParam(":parent_id", $data['id']);
            $sql1->bindParam(":prospect_id", $data['prospect_id']);
            $sql1->execute();
            if($sql1->rowCount()) {
                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                $labor_cost_outsource_id = $data1['id'];
                $personnel = $data1['night_shift_personnel'];
            }

            $night_shift_personnel += $personnel;
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($labor_cost_preview); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1>
                                <i class="fas fa-handshake mr-3"></i><?php echo renderLang($proposals_labor_cost); ?>
                            </h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_proposal_labor_cost_edit_suc');
                    renderError('sys_proposal_labor_cost_edit_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($proposals_labor_cost_form); ?></h3>
                        </div>
                        <div class="card-body">
                            
                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="prospect_id"><?php echo renderLang($proposals_project); ?></label>
                                        <input type="text" class="form-control input-readonly" value="<?php echo getField("project_name", "prospecting", "id = ".$id); ?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-md-4">
                                    <label for="personnel_night_shift"><?php echo renderLang($labor_cost_needed_personnel_per_night_shift); ?></label>
                                    <input type="text" class="form-control input-readonly" name="personnel_night_shift" id="personnel_night_shift" value="<?php echo $night_shift_personnel; ?>" readonly>
                                </div>

                            </div>

                            <!-- labor cost -->
                            <div class="row">

                                <div class="col-12 table-responsive">
                                    <table class="table table-condensed table-bordered" id="labor-cost">
                                        <thead>
                                            <tr>
                                                <th rowspan="2"><p class="w300"><?php echo renderLang($labor_cost_position); ?></p></th>
                                                <th rowspan="2"><p class="w55"><?php echo renderLang($labor_cost_job_grade); ?></p></th>
                                                <th colspan="3" class="text-center bg-dark"><?php echo renderLang($labor_cost_compensation); ?></th>
                                                <th colspan="10" class="text-center bg-dark"><?php echo renderLang($labor_cost_government_mandated_benefits); ?></th>
                                                <th  colspan="8" class="text-center bg-dark"><?php echo renderLang($labor_cost_company_initiated_benefits); ?></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_monthly_labor_cost); ?></p></th>
                                                <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_admin_overhead); ?></p></th>
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
                                                <th><p class="w100"><?php echo renderLang($labor_cost_cib_insurance); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_chif); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_uniform); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_office_activities); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_performance_bonus); ?></p></th>
                                                <th><p class="w100"><?php echo renderLang($labor_cost_total_cib); ?></p></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE labor_cost_id = :direct_id");
                                            $sql->bindParam(":direct_id", $labor_cost_direct_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr class="direct-row">';
                                                        echo '<input type="hidden" name="labor_cost_id[]" value="'.$data['id'].'">';
                                                        // position
                                                        echo '<td>';
                                                            echo '<input type="text" name="position_id[]" class="form-control border-0 input-readonly text-primary" value="'.getField('position', 'positions_for_project', 'id = '.$data['position_id']).'" readonly>';
                                                            echo '<input type="hidden" class="position" value="'.$data['position_id'].'">';
                                                        echo '</td>';

                                                        echo '<td><input type="text" class="form-control border-0 job-grade input-readonly" name="" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 salary input-readonly" name="basic_salary[]" data-type="currency" value="'.$data['basic_salary'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 allowance input-readonly" name="allowance[]" data-type="currency" value="'.$data['allowance'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-compensation input-readonly" name="total_compensation[]" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 sss input-readonly" name="" value="₱1,600.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="₱30.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="₱100.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>';
                                                        echo '<td>';
                                                            echo '<input type="hidden" class="night-duty" value="'.$data['night_shift'].'">';
                                                            echo '<input type="text" class="form-control border-0 input-readonly" value="'.renderLang($yesno_arr[$data['night_shift']][1]).'" readonly>';
                                                        echo '</td>';
                                                        echo '<td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 total-gmb input-readonly" name="total_gmb[]" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 vl-sl input-readonly" name="vl_sl[]" value="'.$data['vl_sl'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly data-code=""></td>';
                                                        echo '<td></td>';
                                                        echo '<td><input type="text" class="form-control border-0 chif input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 office-activities input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 performance-bonus input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-cib input-readonly" name="total_cib[]" readonly></td>';
                                                        
                                                        echo '<td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly month-lc" name="monthly_lc[]" readonly></td>';
                                                        echo '<td></td>';
                                                        echo '<td><input type="text" class="form-control border-0 relief-pool input-readonly" name="relief_pool[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total input-readonly lc-total" name="total[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 round-up-total input-readonly" name="rounded_uo_total[]" readonly></td>';

                                                    echo '</tr>';
                                                }
                                            }
                                            
                                            $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource_positions WHERE labor_cost_id = :outsource_id");
                                            $sql->bindParam(":outsource_id", $labor_cost_outsource_id);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr class="outsource-row">';
                                                        echo '<input type="hidden" name="labor_cost_id[]" value="'.$data['id'].'">';
                                                        // position
                                                        echo '<td>';
                                                            echo '<input type="text" name="position_id[]" class="form-control border-0 input-readonly text-danger" value="'.getField('position', 'positions_for_project', 'id = '.$data['position_id']).'" readonly>';
                                                            echo '<input type="hidden" class="position" value="'.$data['position_id'].'">';
                                                        echo '</td>';

                                                        echo '<td><input type="text" class="form-control border-0 job-grade input-readonly" name="" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 salary input-readonly" name="basic_salary[]" data-type="currency" value="'.$data['basic_salary'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 allowance input-readonly" name="allowance[]" data-type="currency" value="'.$data['allowance'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-compensation input-readonly" name="total_compensation[]" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 sss input-readonly" name="" value="₱1,600.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="₱30.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="₱100.00" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>';
                                                        echo '<td>';
                                                            echo '<input type="hidden" class="night-duty" value="'.$data['night_shift'].'">';
                                                            echo '<input type="text" class="form-control border-0 input-readonly" value="'.renderLang($yesno_arr[$data['night_shift']][1]).'" readonly>';
                                                        echo '</td>';
                                                        echo '<td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 total-gmb input-readonly" name="total_gmb[]" readonly></td>';

                                                        echo '<td><input type="text" class="form-control border-0 vl-sl input-readonly" name="vl_sl[]" value="'.$data['vl_sl'].'" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly data-code=""></td>';
                                                        echo '<td><input type="text" class="form-control border-0 insurance input-readonly" name="" readonly value="₱100.00"></td>';
                                                        echo '<td><input type="text" class="form-control border-0 chif input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 office-activities input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 performance-bonus input-readonly" name="" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 total-cib input-readonly" name="total_cib[]" readonly></td>';
                                                        
                                                        echo '<td><input type="text" class="form-control border-0 sub-total input-readonly month-lc" name="sub_total[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 admin-overhead input-readonly" name="admin_overhead[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 relief-pool input-readonly" name="relief_pool[]" readonly></td>';
                                                        echo '<td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly lc-total" name="monthly_lc[]" readonly></td>';
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
                                                <th><p class="total_insurance"></p></th>
                                                <th><p class="total_chif"></p></th>
                                                <th><p class="total_uniform"></p></th>
                                                <th><p class="total_office_activities"></p></th>
                                                <th><p class="total_performance_bonus"></p></th>
                                                <th><p class="cib_total"></p></th>
                                                <th><p class="total_monthly_labor_cost"></p></th>
                                                <th><p class="total_admin_overhead"></p></th>
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

                        </div>
                        <div class="card-footer text-right">
                            <a href="/preview-labor-cost-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
                    
                    formatCurrency($this.closest('tr').find('.uniform'), "blur"); 
                    
                    if($this.closest('tr').hasClass('direct-row')) {
                        $this.closest('tr').find('.office-activities').val(data['office_activities_total']);
                        formatCurrency($this.closest('tr').find('.office-activities'), "blur");
                        compute($this, position_code);
                    }
                    if($this.closest('tr').hasClass('outsource-row')) {
                        compute_outsource($this);
                    }
                    
                    compute_combined_total();
                    $('#round_up_grand_total').val($('.total_round_up_total').html());

                });
                
            });
        //

        // nd total
            var personnel_number = $('#personnel_night_shift').val();
            var nd_amount = 1800;
            var nd_total = 0;
            nd_total = nd_amount * personnel_number;
            $('.total_nd').html(convert_to_currency(nd_total, "blur"));
        
        // night duty change
            $('.night-duty').each(function(){
                var $this = $(this);
                position_code = $this.closest('tr').find('.incentive-leave').attr('data-code');
                
                if($this.closest('tr').hasClass('direct-row')) {
                    compute($this, position_code);
                    night_diferential();
                } else {
                    compute_outsource($this);
                    outsource_night_differentials();
                }

            });
        //

        compute_combined_total();

    });

    function night_diferential() {

        var nd_total = $('.total_nd').html();
        nd_total = convertCurrency(nd_total);
        var total_night_duty = $('.total_night_duty').html();
        total_night_duty = convertCurrency(total_night_duty);

        var distributed_nd = nd_total / total_night_duty;

        $('.nd').each(function() {
            if($(this).closest('tr').hasClass('direct-row')) {
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
                compute_combined_total();
            }
        });

        $('#round_up_grand_total').val($('.total_round_up_total').html());

    }
    // OUTSOURCE NIGHT DIFFERENTIALS
    function outsource_night_differentials() {
        var nd_total = $('.total_nd').html();
        nd_total = convertCurrency(nd_total);
        var total_night_duty = $('.total_night_duty').html();
        total_night_duty = convertCurrency(total_night_duty);
        var distributed_nd = nd_total / total_night_duty;

        $('.nd').each(function () {
            if($(this).closest('tr').hasClass('outsource-row')) {
                var yes = $(this).closest('tr').find('.night-duty').val();
                if(yes == 1) {
                    $(this).closest('tr').find('.nd').val(convert_to_currency(distributed_nd, "blur"));
                } else {
                    $(this).closest('tr').find('.nd').val('');
                }
                get_total_gmb($(this));
                get_sub_total($(this));
                get_admin_overhead($(this));
                get_outsource_monthly_labor_cost($(this));
                compute_outsource_all_total();
                compute_combined_total();
            }
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