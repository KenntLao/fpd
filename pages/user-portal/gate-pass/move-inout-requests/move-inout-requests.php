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
	<title><?php echo renderLang($move_inout_requests); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_requests); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_err');
					renderSuccess('sys_user_move_inout_requests_add_suc');
					renderSuccess('sys_move_inout_requests_edit_suc');
					renderSuccess('sys_move_inout_requests_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($move_inout_requests_list); ?></h3>
                            <div class="card-tools">
								<a href="/user-move-inout-request-add" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($move_inout_requests_new_move_inout_request); ?></a>
								</div>
                        </div>
                        <div class="card-body">
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($move_inout_requests_date); ?></th>
											<th><?php echo renderLang($move_inout_requests_request); ?></th>
											<th><?php echo renderLang($move_inout_requests_unit); ?></th>
											<th><?php echo renderLang($move_inout_requests_quantity); ?></th>
											<th><?php echo renderLang($move_inout_requests_remarks); ?></th>
											<th><?php echo renderLang($move_inout_requests_status); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT * FROM move_inout_requests WHERE temp_del = 0 ORDER BY date ASC");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											$id = $data['id'];

											echo '<tr>';

												// date
												echo '<td>'.$data['date'].'</td>';

												// request
												echo '<td>'.renderLang($move_inout_request_arr[$data['request']]).'</td>';

												// unit
                                                echo '<td>'.$data['unit'].'</td>';
                                                
												// quantity
												echo '<td>'.$data['quantity'].'</td>';

												// remarks
												echo '<td>'.$data['remarks'].'</td>';

												// STATUS
												echo '<td>'.renderLang($move_inout_request_status_arr[$data['status']]).'</td>';

											echo '</tr>';
										}
										?>
									</tbody>
							
								</table>
							</div><!-- table-responsive -->
						</div><!-- card body -->
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
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