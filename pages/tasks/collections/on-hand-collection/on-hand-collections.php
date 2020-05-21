<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('collection-undeposited')) {
	
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
	<title><?php echo renderLang($collections_on_hand); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_on_hand); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderSuccess('sys_undeposited_collection_add_suc');
					renderSuccess('sys_collection_undeposited_edit_suc');
					renderError('sys_collection_undeposited_edit_err');
					?>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($collections_on_hand_list); ?></h3>
							<div class="card-tools">
								<a href="/add-on-hand-collections" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($collections_on_hand_add); ?></a>
							</div>
						</div>
						<div class="card-body">
							
							<div class="row">
								<div class="col-12 table-responsive">
									<table class="table table-bordered table-hover table-condensed" id="table-data">
										<thead>
											<tr>
												<th><?php echo renderLang($audits_project); ?></th>
												<th><?php echo renderLang($pre_operation_audit_iad_cashier); ?></th>
												<th><?php echo renderLang($lang_status); ?></th>
												<?php if(checkPermission('collection-undeposited-edit')) { ?>
													<th class="w35 no-sort p-0"></th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php 
											if($_SESSION['sys_account_mode'] == 'user') { // users

												$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE temp_del = 0");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<tr>';
														echo '<td><a href="/on-hand-collection/'.$data['id'].'">'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</a></td>';
														echo '<td>'.$data['cashier'].'</td>';
														echo '<td><span class="badge badge-'.$on_hand_collection_status_color_arr[$data['status']].'">'.renderLang($on_hand_collection_status_arr[$data['status']]).'</span></td>';

														if(checkPermission('collection-undeposited-edit')) {
															echo '<td>';
																echo '<a href="/edit-on-hand-collection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
															echo '</td>';
														}

													echo '</tr>';
												}

											} else { // employees

												// get clusters of user
												$cluster_ids = getClusterIDs($_SESSION['sys_id']);

												// no cluster
												if(empty($cluster_ids)) {

													$property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
													$properties = explode(',', $property_ids);
													foreach($properties as $property_id) {
														$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE temp_del = 0 AND property_id = :property_id");
														$sql->bindParam(":property_id", $property_id);
														$sql->execute();
														if($sql->rowCount()) {
															while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																echo '<tr>';
																	echo '<td><a href="/on-hand-collection/'.$data['id'].'">'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</a></td>';
																	echo '<td>'.$data['cashier'].'</td>';
																	echo '<td><span class="badge badge-'.$on_hand_collection_status_color_arr[$data['status']].'">'.renderLang($on_hand_collection_status_arr[$data['status']]).'</span></td>';

																	if(checkPermission('collection-undeposited-edit')) {
																		echo '<td>';
																			echo '<a href="/edit-on-hand-collection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
																		echo '</td>';
																	}

																echo '</tr>';
															}
														}
															
													}

												} else { // has cluster

													// get all properties under cluster
													foreach($cluster_ids as $cluster_id) {
														$property_ids = array();
														// get properties under cluster
														$property_ids = getClusterProperties($cluster_id);

														foreach($property_ids as $property_id) {

															$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE temp_del = 0 AND property_id = :property_id");
															$sql->bindParam(":property_id", $property_id);
															$sql->execute();
															if($sql->rowCount()) {
																while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																	echo '<tr>';
																		echo '<td><a href="/on-hand-collection/'.$data['id'].'">'.getField('property_name', 'properties', 'id = '.$data['property_id']).'</a></td>';
																		echo '<td>'.$data['cashier'].'</td>';
																		echo '<td><span class="badge badge-'.$on_hand_collection_status_color_arr[$data['status']].'">'.renderLang($on_hand_collection_status_arr[$data['status']]).'</span></td>';

																		if(checkPermission('collection-undeposited-edit')) {
																			echo '<td>';
																				echo '<a href="/edit-on-hand-collection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
																			echo '</td>';
																		}

																	echo '</tr>';
																}
															}

														}
														
													}

												}

											}	
											?>
										</tbody>
									</table>
								</div>
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