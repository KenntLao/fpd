<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('collection-undeposited-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_on_hand_new); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_on_hand_new); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderError('sys_on_hand_collection_add_err');
					?>

					<form action="/submit-add-on-hand-collection" method="post" enctype="multipart/form-data">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($pre_operation_audit_iad_count_sheet); ?></h3>
							</div>
							<div class="card-body">

								<!-- PROPERTY -->
								<div class="row">
									<!-- PROPERTY -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
											<select name="property_id" id="property_id" class="form-control select2">
											<?php 
											if($_SESSION['sys_account_mode'] == 'user') { // users - superadmin

												$sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
												}

											} else { // employees

												$cluster_ids = getClusterIDs($_SESSION['sys_id']);

												// no cluster
												if(empty($cluster_ids)) {

													$property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
													$properties = explode(',', $property_ids);
													foreach($properties as $property_id) {
														$sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0 AND id = :id");
														$sql->bindParam(":id", $property_id);
														$sql->execute();
														if($sql->rowCount()) {
															while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
															}
														}
													}

												} else { // has cluster

													foreach($cluster_ids as $cluster_id) {
														$property_ids = array();
														// get properties under cluster
														$property_ids = getClusterProperties($cluster_id);

														foreach($property_ids as $property_id) {
															$sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0 AND id = :id");
															$sql->bindParam(":id", $property_id);
															$sql->execute();
															if($sql->rowCount()) {
																while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																	echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
																}
															}
														}
													}

												}

											}
											?>
											</select>
										</div>
									</div>

									<!-- cashier -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="cashier"><?php echo renderLang($pre_operation_audit_iad_cashier); ?></label>
											<input type="text" class="form-control" name="cashier" id="cashier">
										</div>
									</div>

									<!-- attachment -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="attachment"><?php echo renderLang($proposals_attachment); ?></label>
											<input type="file" name="attachment" id="attachment" class="form-control">
										</div>
									</div>

								</div>

								<!-- BILLS -->
								<div class="row">
									<div class="col-12">
										<p class="text-center">
											<button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-bills" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_iad_bills); ?></button>
										</p>
										<div class="collapse" id="tab-bills">

											<div class="card card-body">

												<div class="row">
													<div class="col-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover">
																<thead>
																	<tr>
																		<th><?php echo renderLang($pre_operation_audit_pcc_cash_on_hand); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_pcc_denomination); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_pcc_quantity); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
																	</tr>
																</thead>
																<tbody>
																	<?php 
																	foreach($pcc_cash_on_hand_arr as $key => $bills) {
                                                                        
																		echo '<tr>';

																			echo '<td>'.renderLang($bills[0]).'</td>';
																			echo '<td><p>'.$bills[1].'</p><input type="hidden" name="denomination[]" value="'.$key.'" class="denomination" data-val="'.$bills[1].'"></td>';
																			echo '<td><input type="number" min="0" class="form-control border-0 quantity" name="quantity[]"></td>';
																			echo '<td><input type="text" min="0" class="form-control border-0 amount input-readonly" name="amount[]" readonly></td>';

																		echo '</tr>';
																	}
																	?>
																</tbody>
																<tfoot>
																	<tr>
																		<th colspan="3"><?php echo $_SESSION['sys_language'] ? renderLang($pre_operation_audit_iad_total_bills_and_coins) : strtoupper(renderLang($pre_operation_audit_iad_total_bills_and_coins)); ?></th>
																		<td><input type="text" min="0" class="form-control border-0 input-readonly" id="total-bills" name="bills_total" readonly></td>
																	</tr>
																</tfoot>
															</table>
														</div>
													</div>
												</div>
												
											</div>

										</div>
									</div>
								</div>

								<!-- CHECKS -->
								<div class="row">
									<div class="col-12">
										<p class="text-center">
											<button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-checks" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_iad_checks); ?></button>
										</p>
										<div class="collapse" id="tab-checks">

											<div class="card card-body">

												<div class="row">
													<div class="col-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover">
																<thead>
																	<tr>
																		<th><?php echo renderLang($pre_operation_audit_iad_or_ar_no); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_iad_bank); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_pcc_date); ?></th>
																		<th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="default-row">
																		<td><input type="text" min="0" class="form-control border-0" name="check_or[]"></td>
																		<td><input type="text" min="0" class="form-control border-0" name="check_bank[]"></td>
																		<td><input type="text" min="0" class="form-control border-0 date" name="check_date[]"></td>
																		<td><input type="text" min="0" class="form-control border-0 check-amount" name="check_amount[]" data-type="currency"></td>
																	</tr>
																</tbody>
																<tfoot>
																	<tr>
																		<th colspan="3" class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_checks); ?></th>
																		<td><input type="text" min="0" class="form-control border-0 input-readonly" id="total-checks" name="checks_total" readonly></td>
																	</tr>
																</tfoot>
															</table>
															<div class="text-right">
																<button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
															</div>
														</div>
													</div>
												</div>
												
											</div>

										</div>
									</div>
								</div>

								<!-- OTHERS -->
								<div class="row">
									<div class="col-12">
										<p class="text-center">
											<button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-others" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_others); ?></button>
										</p>
										<div class="collapse" id="tab-others">

											<div class="card card-body">

												<!-- DIRECT DEPOSIT -->
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<thead>
															<tr>
																<th colspan="3" class="text-center"><?php echo renderLang($collections_direct_deposit); ?></th>
															</tr>
															<tr>
																<th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
																<th><?php echo renderLang($collections_check_voucher_bank); ?></th>
																<th><?php echo renderLang($collections_date_deposited); ?></th>
															</tr>
														</thead>
														<tbody>
															<tr class="default-row">
																<td><input type="text" data-type="currency" class="form-control border-0 direct-deposit-amount" name="direct_deposit_amount[]"></td>
																<td>
																	<select name="direct_deposit_bank[]" class="form-control border-0">
																		<?php 
																		foreach($banks_arr as $key => $bank) {
																			echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
																		}
																		?>
																	</select>
																</td>
																<td>
																	<input type="text" class="form-control date border-0" name="direct_deposit_date[]">
																</td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th>
																	<p class="text-uppercase"><?php echo renderlang($lang_total); ?>: <span id="direct-deposit-total" class="ml-3"></span></p>
																</th>
																<td colspan="2" class="text-right">
																	<button class="btn btn-info other-add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
																</td>
															</tr>
														</tfoot>
													</table>
												</div>

												<!-- CREDIT / DEBIT CARD -->
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<thead>
															<tr>
																<th colspan="3" class="text-center"><?php echo renderLang($collections_credit_debit_card); ?></th>
															</tr>
															<tr>
																<th><?php echo renderlang($pre_operation_audit_pcc_amount); ?></th>
																<th><?php echo renderLang($collections_card_type); ?></th>
																<th><?php echo renderLang($collections_date_of_payment); ?></th>
															</tr>
														</thead>
														<tbody>
															<tr class="default-row">
																<td><input type="text" data-type="currency" class="form-control border-0 credit-card-amount" name="credit_card_amount[]"></td>
																<td><input type="text" class="form-control border-0" name="credit_card_type[]"></td>
																<td><input type="text" class="form-control border-0 date" name="credit_card_date[]"></td>
															</tr>
														</tbody>
														<tfoot>
															<tr>
																<th>
																	<p class="text-uppercase"><?php echo renderlang($lang_total); ?>: <span id="credit-card-total" class="ml-3"></span></p>
																</th>
																<td colspan="2" class="text-right">
																	<button class="btn btn-info other-add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
																</td>
															</tr>
														</tfoot>
													</table>
												</div>

											</div>

										</div>
									</div>
								</div>

								<!-- TOTAL -->
								<div class="row mt-5">
									<div class="col-12">
										<div class="table-responsive">
											<table class="table">
												<tr>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
													<td><input type="text" class="form-control input-readonly" name="total_bills" id="total-bills-coins"readonly></td>
													<td colspan="2"></td>
												</tr>
												<tr>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_checks); ?></th>
													<td><input type="text" min="0" class="form-control input-readonly" name="total_checks" id="checks-total" readonly></td>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
													<td><input type="text" data-type="currency" min="0" class="form-control" name="total_per_count1" id="total-per-count"></td>
												</tr>
												<tr>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_others); ?></th>
													<td><input type="text" data-type="currency" min="0" class="form-control" name="total_others"></td>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_to_be_counted_for); ?></th>
													<td><input type="text" data-type="currency" min="0" class="form-control" name="total_to_be_counted_for" id="annex"></td>
												</tr>
												<tr>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
													<td><input type="text" data-type="currency" min="0" class="form-control" name="total_per_count2"></td>
													<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
													<td><input type="text" data-type="currency" min="0" class="form-control" name="total_overage" id="overage"></td>
												</tr>
											</table>
										</div>
									</div>
								</div>

								<div id="sample"></div>

								<!-- Status -->
								<div class="row">
									<div class="col-12 text-right">
										<div class="icheck-primary">
											<input type="checkbox" id="save-status" name="status" value="0">
											<label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
										</div>
									</div>
								</div>

							</div>
							<div class="card-footer text-right">
								<a href="/on-hand-collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary" id="save-button"><i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?></button>
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

        // CHECK ADD ROW
        $('.add-row').on('click', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('.table-responsive').find('.default-row').html()+'</tr>';
            $(this).closest('.table-responsive').find('tbody').append(fields);

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
                });
            });

		});

		// Bills auto compute
		$('body').on('change', '.quantity', function(){
			var quantity = $(this).val();
			var denom = $(this).closest('tr').find('.denomination').data('val');
			denom = convertCurrency(denom);
			
			var amount = denom * quantity;

			$(this).closest('tr').find('.amount').val(convert_to_currency(amount, "blur"));

			// compute total bill
			var total = 0;
			$('.amount').each(function(){
				var amount = $(this).val();
				amount = convertCurrency(amount);
				
				total += amount;
				
				$('#total-bills').val(convert_to_currency(total, "blur"));
				$('#total-bills-coins').val(convert_to_currency(total, "blur"));

			});

		});

		// checks total auto compute
		$('body').on('keyup', '.check-amount', function(){

			var total_check = 0;

			$('.check-amount').each(function(){
				var check_amount = $(this).val();
				check_amount = convertCurrency(check_amount);

				total_check += check_amount;
			});

			$('#total-checks').val(convert_to_currency(total_check, "blur"));
			$('#checks-total').val(convert_to_currency(total_check, "blur"));

		});

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

		// computation for overage total
		$('#total-per-count, #annex').on('keyup', function(){

			var per_count = $('#total-per-count').val();
			per_count = convertCurrency(per_count);

			var annex = $('#annex').val();
			annex = convertCurrency(annex);

			var overage = per_count - annex;

			$('#overage').val(convert_to_currency(overage, "blur"));

		});

		// other add row
		$('body').on('click', '.other-add-row', function(e){
			e.preventDefault();

			var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
			$(this).closest('table').find('tbody').append(fields);

			$('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
					locale: {
						format: 'YYYY-MM-DD'
					}
                });
            });

		});

		// DIRECT DEPOSIT TOTAL
		$('body').on('keyup', '.direct-deposit-amount', function(){

			var direct_deposit_total = 0;

			$('.direct-deposit-amount').each(function(){
				var amount = $(this).val();
				amount = convertCurrency(amount);
				direct_deposit_total += amount;
			});

			$('#direct-deposit-total').html(convert_to_currency(direct_deposit_total, "blur"));

		});

		// CREDIT CARD TOTAL
		$('body').on('keyup', '.credit-card-amount', function(){

			var credit_card_total = 0;
			
			$('.credit-card-amount').each(function(){
				var amount = $(this).val();
				amount = convertCurrency(amount);
				credit_card_total += amount;
			});

			$('#credit-card-total').html(convert_to_currency(credit_card_total, "blur"));

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