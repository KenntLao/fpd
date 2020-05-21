<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('contract-add')) {

		// set page
		$page = 'contract';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contract_new_contract); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contract_new_contract); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_add_client_err');
					renderSuccess('sys_clients_add_client_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-add-contract" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($contract_add_contract_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="prospect_id" ><?php echo renderLang($notice_to_proceed_project_name); ?></label>
											<select class="form-control select2" id="prospect_id" name="prospect_id" required>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    // check if already created
                                                    $exist = getField('id', 'contract', 'temp_del = 0 AND prospect_id = '.$data['id']);
                                                    if(!$exist) {

                                                        echo '<option value="'.$data['id'].'"';
                                                        if($select_val == $data['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                    }
												}
												?>
											</select>
										</div>
									</div>

									<!-- DATE ACQUISITION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="acquisition_date"><?php echo renderLang($contract_date_acquisition); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="acquisition_date" id="acquisition_date"<?php if(isset($_SESSION['sys_contract_add_acquisition_date_val'])) { echo ' value="'.$_SESSION['sys_contract_add_acquisition_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>

									<!-- RENEWAL DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="renewal_date"><?php echo renderLang($contract_renewal_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="renewal_date" id="renewal_date"<?php if(isset($_SESSION['sys_contract_add_renewal_date_val'])) { echo ' value="'.$_SESSION['sys_contract_add_renewal_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>
									
								</div><!-- row -->

                                <div class="row">

                                    <!-- TERMS OF PAYMENTS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="term"><?php echo renderLang($contract_terms_of_payment); ?></label>
                                            <select name="term" id="term" class="form-control">
                                            <?php 
                                            foreach($contract_terms_arr as $key => $terms) {
                                                echo '<option value="'.$key.'">'.renderLang($terms).'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ADVANCE PAYMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="advance"><?php echo renderLang($contract_advance_payment); ?></label>
                                            <input type="text" data-type="currency" class="form-control" name="advance" id="advance">
                                        </div>
                                    </div>

                                    <!-- NUMBER OF MONTHS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="number_of_month"><?php echo renderLang($contract_number_of_month); ?></label>
                                            <input type="number" class="form-control" name="number_of_month" id="number_of_month">
                                        </div>
                                    </div>
                                                
                                </div>

								<div class="row">

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="status"><?php echo renderLang($contract_status); ?></label>
											<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_contract_add_status_val'])) { echo ' value="'.$_SESSION['sys_contract_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($contract_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>	
										</div>
									</div>

									<!-- SECURITY DEPOSIT -->
									<div class="col-lg-3 col-md-4">
										<label for="amount"><?php echo renderLang($contract_security_deposit); ?></label>
										<input type="text" class="form-control" name="security_deposit" required>
									</div>


									<!-- AMOUNT -->
									<div class="col-lg-3 col-md-4">
										<label for="amount"><?php echo renderLang($contract_amount_php); ?></label>
										<input type="text" data-type="currency" class="form-control" name="amount" placeholder="<?php echo renderLang($downpayment_amount_placeholder); ?>" required>
									</div>
									
								</div><!-- row -->
								<div class="row">
									
									<!-- ATTACHMENT -->

									<!-- ATTACHMENT FOR ADVICE-->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($contract_attachments_soa); ?></label>
										<input type="file" class="form-control" name="attachment[]" required multiple>
									</div>

									<!-- ATTACHMENT FOR SOA -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($contract_attachments_billing_advice); ?></label>
										<input type="file" class="form-control" name="attachment[]" required multiple>
									</div>

									<!-- MODE OF PAYMENT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label><?php echo renderLang($contract_mode_of_payment); ?> :</label>
											<div class="custom-control custom-checkbox">
												<input name="mode_of_payment[]" class="custom-control-input" type="checkbox" id="customCheckbox1" value="<?php echo renderLang($contract_cheque); ?>">
												<label for="customCheckbox1" class="custom-control-label">
													<?php echo $contract_cheque[0]; ?>
												</label>
											</div>

											<div class="custom-control custom-checkbox">
												<input name="mode_of_payment[]" class="custom-control-input" type="checkbox" id="customCheckbox2" value="<?php echo renderLang($contract_cash); ?>">
												<label for="customCheckbox2" class="custom-control-label">
													<?php echo $contract_cash[0];?>
												</label>
											</div>
										</div>
									</div>
									
								</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/contract-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($contract_save_contract); ?></button>
							</div>
						</div><!-- card -->
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
		$(function() {

			$('#acquisition_date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});
			
		});
	</script>
	<script>
		$(function() {

			$('#renewal_date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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