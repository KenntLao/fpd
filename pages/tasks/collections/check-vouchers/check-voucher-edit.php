<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('check-voucher-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';

		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT * FROM check_voucher WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
		} else {
			$_SESSION['sys_check_voucher_edit_err'] = renderLang($lang_no_data);
			header('location: /check-vouchers');
			exit();
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_check_voucher_edit); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_check_voucher_edit); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_check_voucher_edit_err');
                    ?>

					<form action="/submit-edit-check-voucher" method="post">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($collections_check_voucher_edit_form); ?></h3>
							</div>
							<div class="card-body">

								<input type="hidden" name="id" value="<?php echo $id; ?>">

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
													echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['property_name'].'</option>';
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
																echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['property_name'].'</option>';
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
																	echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['property_name'].'</option>';
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
											<input type="text" class="form-control date" name="date" id="date" value="<?php echo formatDate($_data['date']); ?>">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="reference_number"><?php echo renderLang($collections_check_voucher_reference_number); ?></label>
											<input type="text" class="form-control" name="reference_number" id="reference_number" value="<?php echo $_data['reference_number']; ?>">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="bank"><?php echo renderLang($collections_check_voucher_bank); ?></label>
											<select name="bank" id="bank" class="form-control">
												<?php 
												foreach($banks_arr as $key => $bank) {
													echo '<option '.($_data['bank'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($bank).'</option>';
												}
												?>
											</select>
										</div>
									</div>

									<div class="col-lg-3 col-md-4 <?php echo $_data['bank'] == 999 ? '' : 'd-none'; ?>" id="other-bank">
										<div class="form-group">
											<label for="other_bank"><?php echo renderLang($collections_check_vouchers_other_bank); ?></label>
											<input type="text" class="form-control" name="other_bank" id="other_bank" value="<?php echo $_data['other_bank']; ?>">
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="amount"><?php echo renderLang($collections_check_voucher_amount); ?></label>
											<input type="text" class="form-control" data-type="currency" name="amount" id="amount" value="<?php echo $_data['amount']; ?>">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="check_number"><?php echo renderLang($collections_check_voucher_check_number); ?></label>
											<input type="text" class="form-control" name="check_number" id="check_number" value="<?php echo $_data['check_number']; ?>">
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="particulars"><?php echo renderLang($collections_check_voucher_particulars); ?></label>
											<input type="text" class="form-control" name="particulars" id="particulars" value="<?php echo $_data['particulars']; ?>">
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="payee"><?php echo renderLang($collections_check_voucher_payee); ?></label>
											<input type="text" class="form-control" name="payee" id="payee" value="<?php echo $_data['payee']; ?>">
										</div>
									</div>
									
								</div>

							</div>
							<div class="card-footer text-right">
								<a href="/check-vouchers" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($collections_check_voucher_update); ?></button>
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