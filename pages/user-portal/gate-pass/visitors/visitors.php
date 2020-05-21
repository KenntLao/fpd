<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if logged in
if(checkSession()) {

	$page = "user-visitors";

	// check if user is unit owner or tenant
	$account_mode = $_SESSION['sys_account_mode'];
	if($account_mode == 'tenant' || $account_mode == 'unit_owner') {

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($visitors); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($visitors); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_visitors_add_suc');
					renderSuccess('sys_visitors_edit_suc');
					renderSuccess('sys_visitors_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($visitors_list); ?></h3>
                            <div class="card-tools">
								<?php //if(checkPermission('')) { ?><a href="/user-visitor-add" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($visitors_new_visitor); ?></a><?php// } ?>
							</div>
                        </div>
                        <div class="card-body">
							
							<?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
										    <th><?php echo renderLang($lang_date); ?></th>
											<th><?php echo renderLang($visitors_time_in); ?></th>
											<th><?php echo renderLang($visitors_time_out); ?></th>
											<th><?php echo renderLang($visitors_name_of_visitor); ?></th>
											<th><?php echo renderLang($visitors_company_address); ?></th>
											<th><?php echo renderLang($visitors_person_to_visit); ?></th>
											<th><?php echo renderLang($visitors_purpose); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = $pdo->prepare("SELECT * FROM visitors WHERE temp_del = 0 AND account_type = :account_type AND created_by = :created_by ORDER BY time_in ASC");

										$sql->bindParam(":account_type", $_SESSION['sys_account_mode']);
                                        $sql->bindParam(":created_by", $_SESSION['sys_id']);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$id = $data['id'];

											echo '<tr>';
											
											    // date
											    echo '<td>'.formatDate($data['date']).'</td>';

												// time_in
												echo '<td>'.$data['time_in'].'</td>';

												// time_out
												echo '<td>'.$data['time_out'].'</td>';

												// name_of_visitor
												echo '<td><a href="/user-visitor/'.$data['id'].'">'.$data['name_of_visitor'].'</a></td>';

												// company_address
												echo '<td>'.$data['company_address'].'</td>';

												// person_to_visit
												echo '<td>'.$data['person_to_visit'].'</td>';

												// purpose
												echo '<td>'.$data['purpose'].'</td>';

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
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
        $(function(){
            
            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[ 0, "desc" ]]
            });

            // remove sorting in column
	        $('.no-sort').each(function(){
	            $(this).removeClass('sorting');
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