<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('billing-advice')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'billing-advice';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($billing_advice_new); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($billing_advice_new); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <form action="">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($billing_advice_new_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($billing_advice_project); ?></label>
                                            <select name="" id="" class="form-control select2">
                                                <?php
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
												}
												?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($lang_date); ?></label>
                                            <input type="text" class="form-control date" name="" id="">
                                        </div>
                                    </div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="" class="text-uppercase"><?php echo renderLang($billing_advice_from); ?></label>
											<input type="text" class="form-control">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="" class="text-uppercase"><?php echo renderLang($billing_advice_to); ?></label>
											<input type="text" class="form-control">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="" class="text-uppercase"><?php echo renderLang($billing_advice_cc); ?></label>
											<input type="text" class="form-control">
										</div>
									</div>

                                </div>

								<div class="row mb-4">
								
									<div class="col-lg-6 col-md-6">
										<label for="" class="text-uppercase"><?php echo renderLang($billing_advice_re); ?></label>
										<input type="text" class="form-control">
									</div>

								</div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed text-center">
                                                <!-- CHARGES -->
                                                <thead>
                                                    <tr class="bg-dark">
                                                        <th class="text-center" colspan="4"><?php echo renderLang($billing_advice_charges); ?></th>
                                                    </tr>
                                                    <tr class="bg-gray">
                                                        <th><p class="pb-3"><?php echo renderLang($billing_advice_pariculars); ?></p></th>
                                                        <th><p class="pb-3"><?php echo renderLang($billing_advice_current_rate); ?></p></th>
                                                        <th class="w250">
                                                            <div class="form-group p-0 m-0">
                                                                <?php echo renderLang($billing_advice_new_approved_rate); ?>
																<?php echo renderLang($billing_advice_effective); ?>
                                                                <input type="text" class="form-control input-sm date">
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
														<th><?php echo renderLang($billing_advice_administration_fee); ?></th>
														<td></td>
														<td></td>
                                                    </tr>
													<tr>
														<th><?php echo renderLang($billing_advice_labor_cost_fpd); ?></th>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<th><?php echo renderLang($billing_advice_labor_cost_outsourced); ?></th>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<th><?php echo renderLang($billing_advice_sub_total); ?></th>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<th><?php echo renderLang($billing_advice_12_vat); ?></th>
														<td></td>
														<td></td>
													</tr>
													<tr class="bg-gray">
														<th><?php echo renderLang($billing_advice_total_property_admin_charges); ?></th>
														<td></td>
														<td></td>
													</tr>
                                                </tbody>
                                            </table>
                                        </div>

										<div class="table-responsive">
											<table class="table table-bordered table-condensed text-center">
												<thead>
													<tr>
														<th colspan="6" class="bg-dark"><?php echo renderLang($billing_advice_manpower); ?></th>
													</tr>
													<tr>
														<th></th>
														<th><?php echo renderLang($billing_advice_name); ?></th>
														<th><?php echo renderlang($billing_advice_position); ?></th>
														<th><?php echo renderLang($billing_advice_new_approved_rate); ?></th>
														<th><?php echo renderLang($billing_advice_date_of_employment); ?></th>
													</tr>
												</thead>
												<tbody>
													<tr class="default-row">
														<td>
															<select name="" id="" class="form-control border-0">
															<?php 
															foreach($billing_advice_labor_type_arr as $key => $labor_type) {
																echo '<option value="'.$key.'">'.renderLang($labor_type).'</option>';	
															}
															?>
															</select>
														</td>
														<td><input type="text" class="form-control border-0"></td>
														<td>
															<select name="" id="" class="form-control border-0">
															<?php 
															$sql = $pdo->prepare("SELECT * FROM positions_for_project");
															$sql->execute();
															while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																echo '<option value="'.$data['id'].'">'.$data['position'].'</option>';
															}
															?>
															</select>
														</td>
														<td><input type="text" class="form-control border-0" data-type="currency"></td>
														<td><input type="text" class="form-control border-0 date"></td>
													</tr>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="6" class="text-right"><button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button></td>
													</tr>
												</tfoot>
											</table>
										</div>

										<div class="table-responsive">
											<table class="table table-bordered table-condensed">
												<thead>
													<tr>
														<th class="bg-dark"><?php echo renderLang($billing_advice_check_corresponding_nature); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($billing_advice_nature_arr as $key => $billing_advice) {
														echo '<tr>';
															echo '<td>';
																echo '<div class="icheck-primary">';
																	echo '<input type="checkbox" id="nature-'.$key.'" name="amenity_name[]" value="'.$key.'"/>';
																	echo '<label for="nature-'.$key.'">'.renderLang($billing_advice['title']).'</label>';
																	echo '<ul>';
																	foreach($billing_advice['list'] as $bill_key => $bill_list) {
																		echo '<li>'.renderLang($bill_list).'</li>';
																	}
																	echo '</ul>';
																echo '</div>';
															echo '</td>';
														echo '</tr>';
													}
													?>
												</tbody>
												
																
																
															
											</table>
										</div>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="#" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
		});  
		
		// Add row
		$('body').on('click', '.add-row', function(e){
			e.preventDefault();

			var field = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
			$(this).closest('table').find('tbody').append(field);

			$('.date').each(function(){
				$(this).daterangepicker({
					singleDatePicker: true,
					locale: {
						format: 'YYYY-MM-DD'
					}
				});
			});  

		}); 

    });
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