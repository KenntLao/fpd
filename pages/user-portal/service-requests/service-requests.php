<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-service-requests";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_requests); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/user-portal.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-exclamation-circle mr-3"></i><?php echo renderLang($service_requests); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->


	<!-- Main content -->
	<section>
		<div class="container-fluid">

			<?php
			renderError('sys_units_add_err');
			renderSuccess('sys_units_add_suc');
			?>
			
			<!-- RESERVATION REQUESTS TABLE -->
			<div class="row">
				
				<div class="col-12">
					<div class="card property-card">
						<div class="card-header">
							<div class="card-title">
                            <h3 class="card-title"><?php echo renderLang($service_requests_list); ?></h3>		
							</div>
							<div class="card-tools">
							<a href="user-service-request-add" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($service_requests_new_service_request); ?></a>
						</div>
						</div>
						<div class="card-body ">
							<div class="table-responsive">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th class="text-center"><?php echo renderLang($service_requests_date); ?></th>
											<th class="text-center"><?php echo renderLang($service_requests_unit_no); ?></th>
											<th class="text-center"><?php echo renderLang($service_requests_property); ?></th>
											<th class="text-center"><?php echo renderLang($service_requests_description); ?></th>
											<th class="text-center"><?php echo renderLang($service_requests_assessment); ?></th>
											<th class="text-center"><?php echo renderLang($service_requests_status); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
                                        
                                        $sql = $pdo->prepare("SELECT sr.id, sr.date, property_id, unit_name, description, assessment FROM service_requests sr LEFT JOIN units u ON(sr.unit_id = u.id) WHERE sr.temp_del = 0 AND account_type = :account_type AND complainant = :complainant");

                                        $sql->bindParam(":account_type", $_SESSION['sys_account_mode']);
                                        $sql->bindParam(":complainant", $_SESSION['sys_id']);
										$sql->execute();

										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											echo '<tr>';

												// DATE
												echo '<td>'.formatDate($data['date'], true, false, false).'</td>';

												// DESCRIPTION
												echo '<td>'.$data['unit_name'].'</td>';

												// DESCRIPTION
												echo '<td>'.(isset($data['property_id']) ? getField('property_name', 'properties', 'id = '.$data['property_id']) : '').'</td>';

												// DESCRIPTION
												echo '<td>'.$data['description'].'</td>';

												// DESCRIPTION
												echo '<td>'.$data['assessment'].'</td>';
												
												// STATUS
												$status = getField('status','task_job_order','target_id ='.$data['id'].' AND target_category = 0');

												if (!isset($status)) {
													$status = getField('status','task_work_order','target_id ='.$data['id'].' AND target_category = 0');
													}
												
													echo '<td>'.(isset($status) ? renderLang($service_request_status_arr[$status]) : '' ).'</td>';

											echo '</tr>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div><!-- row -->

		</div><!-- container-fluid -->
	</section><!-- content -->

			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>


	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

			// open add modal
			$('#add_complaint').on('click', function(e) {
				e.preventDefault();

				$('#modal-add_complaint .modal-error').hide();
				$('#modal-add_complaint').modal('show');

			});

			$('#addcomplaint').daterangepicker({
				singleDatePicker: true
			});

		});
	</script>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>

</body>

</html>
<?php 
	} else { // invalid account mode

		// logout to current session
		session_destroy();
		session_start();
		
		$_SESSION['sys_user_login_err'] = renderLang($permission_message_1); // "You are not authorized to access this page. Please login first."
		header('location: /user-login');
	
	}

} else { // no session found, redirect to login page
	
	$_SESSION['sys_user_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /user-login');
	
}
?>