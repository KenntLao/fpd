<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-move-inout-requests";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($move_inout_requests_new_move_inout_request); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/user-portal.css">
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/user-portal-sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_requests_new_move_inout_request); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_user_move_inout_requests_add_err');
					?>
					
					<form method="post" action="/submit-user-move-inout-request-add">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($move_inout_requests_add_move_inout_request_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- REQUEST -->
									<div class="col-lg-3 col-md-4">
										<label for="request"><?php echo renderLang($move_inout_requests_request); ?></label>
										<select class="form-control select2" id="request" name="request" <?php if(isset($_SESSION['sys_user_move_inout_requests_add_request_val'])) { echo ' value="'.$_SESSION['sys_user_move_inout_requests_add_request_val'].'"'; } ?>>
                                            <?php 
                                                foreach($move_inout_request_arr as $key => $value) {
                                                    echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div>
									
									<!-- DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($move_inout_requests_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date" id="date"<?php if(isset($_SESSION['sys_user_move_inout_requests_add_date_val'])) { echo ' value="'.$_SESSION['sys_user_move_inout_requests_add_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>

									<!-- QUANTITY -->
									<div class="col-lg-3 col-md-4">
										<label for="quantity"><?php echo renderLang($move_inout_requests_quantity); ?></label>
										<input type="number" class="form-control" min="0" name="quantity" <?php if(isset($_SESSION['sys_user_move_inout_requests_add_quantity_val'])) { echo ' value="'.$_SESSION['sys_user_move_inout_requests_add_quantity_val'].'"'; } ?> required>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($move_inout_requests_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_user_move_inout_requests_add_status_val'])) { echo ' value="'.$_SESSION['sys_user_move_inout_requests_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($visitors_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>

								</div><!-- row -->

								<div class="row mt-3">

                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($move_inout_requests_item_no); ?></th>
                                                    <th><?php echo renderLang($move_inout_requests_description); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-data">
                                                <tr class="default-row">
                                                    <td><input type="text" class="form-control border-0" name="item_no[]"></td>
                                                    <td><textarea name="description[]" rows="1" class="form-control notes border-0"></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <a href="" id="add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></a>
                                        </div>
                                    </div>
									
								</div><!-- row -->

								<div class="row">

									<!-- REMARKS -->
									<div class="col-lg-6 col-md-12">
										<label for="remarks"><?php echo renderLang($move_inout_requests_remarks); ?></label>
										<textarea name="remarks" id="remarks" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_user_move_inout_requests_add_remarks_val'])) { echo ''.$_SESSION['sys_user_move_inout_requests_add_remarks_val'].''; } ?></textarea>
									</div>


									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/move-inout-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($move_inout_requests_save_move_inout_request); ?></button>
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
                    format: 'MMMM D, Y'
                }
			});

            $('#add-row').on('click', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('.default-row').html();

                $(this).closest('.table-responsive').find('.table-data').append('<tr>'+fields+'</tr>');

            });
			
		});
	</script>
	
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