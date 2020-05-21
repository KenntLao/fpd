<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('check-voucher-add')) {
	
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
	<title><?php echo renderLang($collections_check_voucher_new); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_check_voucher_new); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<form action="/submit-add-check-voucher" method="post">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($collections_check_voucher_new_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_id"><?php echo renderLang($module_property); ?></label>
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
								
								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($lang_date); ?></label>
											<input type="text" class="form-control date" name="date" id="date">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="reference_number"><?php echo renderLang($collections_check_voucher_reference_number); ?></label>
											<input type="text" class="form-control" name="reference_number" id="reference_number">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="bank"><?php echo renderLang($collections_check_voucher_bank); ?></label>
											<select name="bank" id="bank" class="form-control">
												<?php 
												foreach($banks_arr as $key => $bank) {
													echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
												}
												?>
											</select>
										</div>
									</div>

									<div class="col-lg-3 col-md-4 d-none" id="other-bank">
										<div class="form-group">
											<label for="other_bank"><?php echo renderLang($collections_check_vouchers_other_bank); ?></label>
											<input type="text" class="form-control" name="other_bank" id="other_bank">
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="amount"><?php echo renderLang($collections_check_voucher_amount); ?></label>
											<input type="text" class="form-control" data-type="currency" name="amount" id="amount">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="check_number"><?php echo renderLang($collections_check_voucher_check_number); ?></label>
											<input type="text" class="form-control" name="check_number" id="check_number">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="particulars"><?php echo renderLang($collections_check_voucher_particulars); ?></label>
											<input type="text" class="form-control" name="particulars" id="particulars">
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="payee"><?php echo renderLang($collections_check_voucher_payee); ?></label>
											<input type="text" class="form-control" name="payee" id="payee">
										</div>
									</div>
									
								</div>

							</div>
							<div class="card-footer text-right">
								<a href="/check-vouchers" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($collections_check_voucher_add); ?></button>
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

		$('.date').each(function(e){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

		$('body').on('change', '#bank', function() {
			var bank = $(this).val();
			if(bank == '999') {
				$('#other-bank').removeClass('d-none');
			} else {
				if($('#other-bank').hasClass('d-none')) {

				} else {
					$('#other-bank').addClass('d-none');
				}
				
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