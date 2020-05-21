<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('billing-advice-add')) {

		// set page
		$page = 'billing-advice';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($downpayment_new_downpayment); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-coins mr-3"></i><?php echo renderLang($downpayment_new_downpayment); ?></h1>
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
					
					<form method="post" action="/submit-add-downpayment" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($downpayment_new_downpayment_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="prospect_id" ><?php echo renderLang($downpayment_project); ?></label>
											<select class="form-control select2" id="prospect_id" name="prospect_id">
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    // check if already created
                                                    $exist = getField('id', 'downpayments', 'temp_del = 0 AND prospect_id = '.$data['id']);
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

									<!-- PROPERTY CODE -->
									<div class="col-lg-3 col-md-4">
										<label for="property_code"><?php echo renderLang($downpayment_property_code); ?></label>
										<input type="text" class="form-control" name="property_code" <?php if(isset($_SESSION['sys_downpayment_add_property_code_val'])) { echo ' value="'.$_SESSION['sys_downpayment_add_property_code_val'].'"'; } ?> required>
									</div>

									<!-- AMOUNT -->
									<div class="col-lg-3 col-md-4">
										<label for="amount"><?php echo renderLang($downpayment_amount_php); ?></label>
										<input type="text" data-type="currency" class="form-control" name="amount" placeholder="<?php echo renderLang($downpayment_amount_placeholder); ?>"<?php if(isset($_SESSION['sys_downpayment_add_amount_val'])) { echo ' value="'.$_SESSION['sys_downpayment_add_amount_val'].'"'; } ?> required>
									</div>


								</div><!-- row -->
								<div class="row">


                                    <!-- DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($downpayment_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date" id="date"<?php if(isset($_SESSION['sys_downpayment_add_date_val'])) { echo ' value="'.$_SESSION['sys_downpayment_add_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>

									<!-- OR -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="or_num"><?php echo renderLang($downpayment_or); ?></label>
											<input type="text" class="form-control" name="or_num" id="or_num">	
										</div>
									</div>
									
								</div><!-- row -->
								<div class="row">

                                    <!-- ATTACHMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($downpayment_attachment); ?></label>
										<input type="file" class="form-control" name="attachment[]" required multiple="">
									</div>									

								</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/downpayments" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($downpayment_save_downpayment); ?></button>
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

			$('#date').daterangepicker({
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