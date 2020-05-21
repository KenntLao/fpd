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
        
        $parent_id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE temp_del = 0 AND id = :id LIMIT 1");
        $sql->bindParam(":id", $parent_id);
        $sql->execute();
        if($sql->rowCount()) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $prospect_id = $data['prospect_id'];
            $night_shift = $data['night_shift_personnel'];
            $id = $data['id'];
            $latest_version = $data['version'];

            $sql1 = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE parent_version = :parent_id AND temp_del = 0 AND prospect_id = :prospect_id ORDER BY version DESC");
            $sql1->bindParam(":parent_id", $parent_id);
            $sql1->bindParam(":prospect_id", $data['prospect_id']);
            $sql1->execute();
            if($sql1->rowCount()) {
                $_data = $sql1->fetch(PDO::FETCH_ASSOC);
                $prospect_id = $_data['prospect_id'];
                $night_shift = $_data['night_shift_personnel'];
                $id = $_data['id'];
                $latest_version = $_data['version'];
            }

            $version = (int)$latest_version + 1;
            
        } else {
            $_SESSION['sys_labor_cost_outsource_edit_err'] = renderLang($lang_no_data);
            header('location: /outsource-labor-cost-list');
            exit();
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($labor_cost_outsource); ?> &middot; <?php echo $sitename; ?></title>
	
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
                                <i class="fas fa-handshake mr-3"></i><?php echo renderLang($labor_cost_outsource); ?>
                                <small class="fa fa-chevron-right ml-2 mr-2"></small>
                                <?php echo getField('project_name', 'prospecting', 'id = '.$prospect_id); ?>
                                <small class="ml-2"><?php echo renderLang($labor_cost_version).' '.$version; ?></small>
                            </h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_labor_cost_outsource_add_err');
                    ?>

					<form action="/submit-add-outsource-labor-cost" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($labor_cost_outsource); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="parent_version" value="<?php echo $parent_id; ?>">
                                <input type="hidden" name="version" value="<?php echo $version; ?>">
                                <input type="hidden" name="prospect_id" value="<?php echo $prospect_id; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id"><?php echo renderLang($proposals_project); ?></label>
                                            <input type="text" class="form-control input-readonly" value="<?php echo getField('project_name', 'prospecting', 'id = '.$prospect_id); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <label for="personnel_night_shift"><?php echo renderLang($labor_cost_needed_personnel_per_night_shift); ?></label>
                                        <input type="number" class="form-control" name="personnel_night_shift" id="personnel_night_shift" value="<?php echo $night_shift; ?>">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="w35"></th>
                                                        <th rowspan="2"><p class="w300"><?php echo renderLang($labor_cost_position); ?></p></th>
                                                        <th rowspan="2"><p class="w55"><?php echo renderLang($labor_cost_job_grade); ?></p></th>
                                                        <th colspan="3" class="text-center bg-dark"><?php echo renderLang($labor_cost_compensation); ?></th>
                                                        <th colspan="10" class="text-center bg-dark"><?php echo renderLang($labor_cost_government_mandated_benefits); ?></th>
                                                        <th  colspan="5" class="text-center bg-dark"><?php echo renderLang($labor_cost_company_initiated_benefits); ?></th>
                                                        
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_sub_total); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_admin_overhead); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($labor_cost_total_monthly_labor_cost); ?></p></th>
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
                                                        <th><p class="w100"><?php echo renderLang($labor_cost_uniform); ?></p></th>
                                                        <th><p class="w100"><?php echo renderLang($labor_cost_total_cib); ?></p></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource_positions WHERE labor_cost_id = :id");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                            echo '<input type="hidden" name="labor_cost_id[]" value="'.$data['id'].'">';
                                                            echo '<td>';
                                                                echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                            echo '</td>';
                                                            // position
                                                            echo '<td>';
                                                                echo '<select name="position_id[]" class="form-control border-0 position select2">';
                                                                    $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                                    $sql1->execute();
                                                                    while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option '.($data['position_id'] == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.$data1['position'].'</option>';
                                                                    }
                                                                echo '</select>';
                                                            echo '</td>';

                                                            echo '<td><input type="text" class="form-control border-0 job-grade input-readonly" name="" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 salary" name="basic_salary[]" data-type="currency" value="'.$data['basic_salary'].'"></td>';
                                                            echo '<td><input type="text" class="form-control border-0 allowance" name="allowance[]" data-type="currency" value="'.$data['allowance'].'"></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total-compensation input-readonly" name="compensation[]" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 sss input-readonly" name="" value="₱1,600.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="₱30.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="₱100.00" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>';
                                                            echo '<td>';
                                                                echo '<select name="night_duty[]" class="form-control border-0 night-duty">';
                                                                    foreach($yesno_arr as $yesno) {
                                                                        echo '<option '.($data['night_shift'] == $yesno[0] ? 'selected' : '').' value="'.$yesno[0].'">'.renderLang($yesno[1]).'</option>';
                                                                    }
                                                                echo '</select>';
                                                            echo '</td>';
                                                            echo '<td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total-gmb input-readonly" name="gmb[]" readonly></td>';

                                                            echo '<td><input type="text" class="form-control border-0 vl-sl" name="vl_sl[]" value="'.$data['vl_sl'].'"></td>';
                                                            echo '<td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 insurance input-readonly" name="" readonly value="₱100.00"></td>';
                                                            echo '<td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 total-cib input-readonly" name="cib[]" readonly></td>';
                                                            
                                                            echo '<td><input type="text" class="form-control border-0 sub-total input-readonly" name="sub_total[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 admin-overhead input-readonly" name="admin_overhead[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly" name="monthly_labor_cost[]" readonly></td>';
                                                            echo '<td><input type="text" class="form-control border-0 round-up-total input-readonly" name="rounded_uo_total[]" readonly></td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                    <tr class="default-row <?php echo $sql->rowCount() ? 'd-none' : ''; ?>">
                                                        <input type="hidden" name="labor_cost_id[]" id="0">
                                                        <th>
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                        </th>
                                                        <!-- position -->
                                                        <td>
                                                            <select name="position_id[]" class="form-control border-0 position select2">
                                                                <option value=""></option>
                                                                <?php 
                                                                $sql = $pdo->prepare("SELECT * FROM positions_for_project");
                                                                $sql->execute();
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo '<option value="'.$data['id'].'">'.$data['position'].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <!-- job grade -->
                                                        <td><input type="text" class="form-control border-0 job-grade" name=""></td>
                                                        
                                                        <!-- Compensation -->
                                                        <td><input type="text" class="form-control border-0 salary" name="basic_salary[]" data-type="currency"></td>
                                                        <td><input type="text" class="form-control border-0 allowance" name="allowance[]" data-type="currency"></td>
                                                        <td><input type="text" class="form-control border-0 total-compensation input-readonly" name="compensation[]" readonly></td>

                                                        <!-- GMB -->
                                                        <td><input type="text" class="form-control border-0 sss input-readonly" name="" value="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 ecc input-readonly" name="" value="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 phic input-readonly" name="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 hdmf input-readonly" name="" value="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 month-13 input-readonly" name="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 RA-7641 input-readonly" name="" readonly></td>
                                                        <!-- for night duty -->
                                                        <td>
                                                            <select name="night_duty[]" class="form-control border-0 night-duty">
                                                                <?php 
                                                                foreach($yesno_arr as $yesno) {
                                                                    echo '<option value="'.$yesno[0].'">'.renderLang($yesno[1]).'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control border-0 nd input-readonly" name="nd[]" data-type="currency" readonly></td>
                                                        <td><input type="text" class="form-control border-0 service-incentive-leave input-readonly" readonly></td>
                                                        <td><input type="text" class="form-control border-0 total-gmb input-readonly" name="gmb[]" readonly></td>

                                                        <!-- CIB -->
                                                        <td><input type="text" class="form-control border-0 vl-sl" name="vl_sl[]"></td>
                                                        <td><input type="text" class="form-control border-0 incentive-leave input-readonly" name="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 insurance input-readonly" name="" readonly value=""></td>
                                                        <td><input type="text" class="form-control border-0 uniform input-readonly" name="" readonly></td>
                                                        <td><input type="text" class="form-control border-0 total-cib input-readonly" name="cib[]" readonly></td>

                                                        <td><input type="text" class="form-control border-0 sub-total input-readonly" name="sub_total[]" readonly></td>
                                                        <td><input type="text" class="form-control border-0 admin-overhead input-readonly" name="admin_overhead[]" readonly></td>
                                                        <td><input type="text" class="form-control border-0 monthly-labor-cost input-readonly" name="monthly_labor_cost[]" readonly></td>
                                                        <td><input type="text" class="form-control border-0 round-up-total input-readonly" name="rounded_uo_total[]" readonly></td>

                                                    </tr>
                                                </tbody>
                                                <thead>
                                                    <tr>
                                                        <th></th>
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
                                                        <th><p class="total_uniform"></p></th>
                                                        <th><p class="cib_total"></p></th>

                                                        <th><p class="total_sub_total"></p></th>
                                                        <th><p class="total_admin_overhead"></p></th>
                                                        <th>
                                                            <p class="total_monthly_labor_cost"></p>
                                                            <input type="hidden" name="total_monthly_labor_cost" id="total_monthly_labor_cost">
                                                        </th>
                                                        <th>
                                                            <p class="total_round_up_total"></p>
                                                            <input type="hidden" name="round_up_total">
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right mt-3">
										<button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
									</div>
                                </div>

                                <!-- Status -->
                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="save-status" name="status" value="0">
                                            <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="card-footer text-right">
                                <a href="/outsource-labor-cost-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($labor_cost_new_version); ?></button>
                            </div>
                        </div>

                    </form>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/assets/js/labor-cost.js"></script>
    <script>
    $(function() {

        // change save status 
            $('#save-status').on('change', function(){

                if($(this).is(':checked')) {
                    $(this).val('1');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
                    $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_for_submission); ?>');

                } else {
                    $(this).val('0');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                    $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
                }

            });
        // 

        // Add row
            $('.add-row').on('click', function(e){
                e.preventDefault();

                var field = $(this).closest('.row').find('tbody').find('tr:nth-child(1)').html();
                $(this).closest('.row').find('tbody').append('<tr>'+field+'</tr>');
                $(this).closest('.row').find('tbody').find('tr:nth-last-child(1)').find('input').each(function(){
                    $(this).val("");
                });
                $(this).closest('.row').find('tbody').find('tr:nth-last-child(1)').find('input[name="labor_cost_id[]"]').val("0");
                $(this).closest('.row').find('tbody').find('tr:nth-last-child(1)').find('.position').closest('td').remove();
                $(this).closest('.row').find('tbody').find('tr:nth-last-child(1)').find('.job-grade').closest('td').before('<td><select name="position_id[]" class="form-control border-0 position select2"><option value=""></option><?php 
                $sql = $pdo->prepare("SELECT * FROM positions_for_project");
                $sql->execute();
                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="'.$data['id'].'">'.$data['position'].'</option>';
                }
                ?></select></td>');
                $('.select2').each(function(){
                    $(this).select2({
                        width: "100%"
                    });
                });

                $('.sss').each(function(){
                    if($(this).closest('tr').hasClass('default-row')) {
                        $(this).val("");
                    } else {
                        $(this).val("₱1,600.00");
                    }
				});

				$('.ecc').each(function(){
                    if($(this).closest('tr').hasClass('default-row')) {
                        $(this).val("");
                    } else {
                        $(this).val("₱30.00");
                    }
				});

				$('.hdmf').each(function(){
                    if($(this).closest('tr').hasClass('default-row')) {
                        $(this).val("");
                    } else {
                        $(this).val("₱100.00");
                    }
				});

                $('.insurance').each(function(){
                    if($(this).closest('tr').hasClass('default-row')) {
                        $(this).val("");
                    } else {
                        $(this).val("₱100.00");
                    }
                });

            });
        // 
        
        // remove row
            $('body').on('click', '.remove-row', function(e){
                var $this = $(this);
                e.preventDefault();
                if($(this).closest('tbody').children('tr').length != 2) {
                        $this.closest('tr').remove();
                } else {
                    alert('last row cannot be deleted');
                }
            });
        // 

        // change value base on position
            // compute on load
            $('.position').each(function(){
                var id = $(this).val();
                var $this = $(this);

                $.post('/get-labor-cost-position-data', {
                    id:id
                }, function(result) {
                    var data = JSON.parse(result);

                    $this.closest('tr').find('.job-grade').val(data['job_grade']);
                    $this.closest('tr').find('.salary').val(convert_to_currency(data['minimum_basic_pay'], "blur"));

                    $this.closest('tr').find('.uniform').val(convert_to_currency(data['uniform'], "blur"));
                    
                    compute_outsource($this);
                    
                });
            });


            $('body').on('change', '.position', function(){
                var id = $(this).val();
                var $this = $(this);

                $.post('/get-labor-cost-position-data', {
                    id:id
                }, function(result) {
                    var data = JSON.parse(result);

                    $this.closest('tr').find('.job-grade').val(data['job_grade']);
                    $this.closest('tr').find('.salary').val(convert_to_currency(data['minimum_basic_pay'], "blur"));

                    $this.closest('tr').find('.uniform').val(convert_to_currency(data['uniform'], "blur"));
                    
                    compute_outsource($this);
                    
                });

            });
        //  

        // compute on change
            $('body').on('change', '.salary, .allowance, .vl-sl', function(){
                var $this = $(this);

                var salary = $this.closest('tr').find('.salary').val();
                salary = convertCurrency(salary);
                var id = $this.closest('tr').find('.position').val();

                $.post('/get-labor-cost-position-data', {
                    id:id
                }, function(result) {
                    
                    var data = JSON.parse(result);

                    var max = convertCurrency(data['maximum_basic_pay']);
                    var min = convertCurrency(data['minimum_basic_pay']);

                    // get error if salary exeeded maximum value
                    if(salary > max) {
                        alert('<?php echo renderLang($proposals_exceed_maximum); ?>');
                        $this.closest('tr').find('.salary').val(convert_to_currency(data['maximum_basic_pay'], "blur"));
                    }
                    // get error if salary is below minimum
                    if(salary < min) {
                        alert('<?php echo renderLang($proposals_below_minimum); ?>');
                        $this.closest('tr').find('.salary').val(convert_to_currency(data['minimum_basic_pay'], "blur"));
                    }

                    compute_outsource($this);

                });

            });
        // 

        // ND total base on personnel number
            var personnel_number = $('#personnel_night_shift').val();
            var nd_amount = 1800;
            var nd_total = 0;
            nd_total = nd_amount * personnel_number;
            $('.total_nd').html(convert_to_currency(nd_total, "blur"));

            $('#personnel_night_shift').on('change', function(){
                personnel_number = $(this).val();
                nd_amount = 1800;
                nd_total = 0;
                nd_total = nd_amount * personnel_number;
                $('.total_nd').html(convert_to_currency(nd_total, "blur"))

                outsource_night_differentials();
            });
        // 

        // night duty change
            $('.night-duty').each(function(){
                var $this = $(this);
                
                compute_outsource($this);
                outsource_night_differentials();
            });

            $('body').on('change', '.night-duty', function() {
                var $this = $(this);
                
                compute_outsource($this);
                outsource_night_differentials();

            });
        //

    });

    // OUTSOURCE NIGHT DIFFERENTIALS
    function outsource_night_differentials() {
        var nd_total = $('.total_nd').html();
        nd_total = convertCurrency(nd_total);
        var total_night_duty = $('.total_night_duty').html();
        total_night_duty = convertCurrency(total_night_duty);
        var distributed_nd = nd_total / total_night_duty;

        $('.nd').each(function () {
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