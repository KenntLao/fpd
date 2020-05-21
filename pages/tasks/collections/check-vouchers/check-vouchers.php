<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('check-vouchers')) {
	
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
	<title><?php echo renderLang($collections_check_vouchers); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_check_vouchers); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderSuccess('sys_check_voucher_add_suc');
					renderSuccess('sys_check_voucher_edit_suc');
					renderError('sys_check_voucher_edit_err');
					?>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($collections_check_voucher_list); ?></h3>
							<div class="card-tools">
                            <?php if(checkPermission('check-voucher-add')) { ?>
								<a href="/add-check-voucher" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($collections_add_check_voucher); ?></a>
                            <?php } ?>
							</div>
						</div>
						<div class="card-body">

							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-hover table-condensed">
									<thead>
										<tr>
											<th><?php echo renderLang($module_property); ?></th>
											<th><?php echo renderLang($lang_date); ?></th>
											<th><?php echo renderLang($collections_check_voucher_bank); ?></th>
											<th><?php echo renderlang($collections_check_voucher_amount); ?></th>
											<th><?php echo renderlang($collections_check_voucher_reference_number); ?></th>
											<th><?php echo renderlang($collections_check_voucher_check_number); ?></th>
                                            <?php if(checkPermission('check-voucher-edit')) { ?>
											    <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT * FROM check_voucher WHERE temp_del = 0");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												echo '<tr>';

													// property
													echo '<td>';
														echo '<a href="/check-voucher/'.$data['id'].'">'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</a>';
													echo '</td>';
													// date
													echo '<td>'.formatDate($data['date']).'</td>';
													// bank
													echo '<td>';
													if($data['bank'] == 999) {
														echo $data['other_bank'];
													} else {
														echo renderLang($banks_arr[$data['bank']]);
													}
													echo '</td>';
													// amount
                                                    echo '<td>'.$data['amount'].'</td>';

                                                    echo '<td>'.$data['reference_number'].'</td>';

                                                    echo '<td>'.$data['check_number'].'</td>';

                                                    if(checkPermission('check-voucher-edit')) {
                                                        // edit
                                                        echo '<td>';
                                                            echo '<a href="/edit-check-voucher/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($collections_check_voucher_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        echo '</td>';
                                                    }

												echo '</tr>';
											}

										} else {

                                            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];

                                            foreach($sub_property_ids as $property_id) {
                                                $sql = $pdo->prepare("SELECT * FROM check_voucher WHERE temp_del = 0 AND property_id = :property_id");
                                                $sql->bindParam(":property_id", $property_id);
                                                $sql->execute();
                                                if($sql->rowCount()) {
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';

                                                            // property
                                                            echo '<td>';
                                                                echo '<a href="/check-voucher/'.$data['id'].'">'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</a>';
                                                            echo '</td>';
                                                            // date
                                                            echo '<td>'.formatDate($data['date']).'</td>';
                                                            // bank
                                                            echo '<td>';
                                                            if($data['bank'] == 999) {
                                                                echo $data['other_bank'];
                                                            } else {
                                                                echo renderLang($banks_arr[$data['bank']]);
                                                            }
                                                            echo '</td>';
                                                            // amount
                                                            echo '<td>'.$data['amount'].'</td>';

                                                            echo '<td>'.$data['reference_number'].'</td>';

                                                            echo '<td>'.$data['check_number'].'</td>';

                                                            if(checkPermission('check-voucher-edit')) {
                                                                // edit
                                                                echo '<td>';
                                                                    echo '<a href="/edit-check-voucher/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($collections_check_voucher_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                                echo '</td>';
                                                            }

                                                        echo '</tr>';
                                                    }
                                                }
                                            }

										}
										?>
									</tbody>
								</table>
							</div>

						</div>
						<div class="card-footer text-right">
							<a href="/collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
						</div>
					</div>

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
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>