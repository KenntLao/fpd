<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibration-plans')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'calibration-plans';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calibration_plans); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($calibration_plans); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php
					renderSuccess('sys_calibration_plan_edit_suc');
					renderSuccess('calibration_plan_added');
					?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($calibration_plan_list); ?></h3>
                            <div class="card-tools">
                            	<?php if (checkPermission('calibration-plan-add')) { ?>
                                <a href="/calibration-plan-add" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($calibration_plan_add); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-resposive">
                                <table class="table table-bordered table-condensed table-hover" id="table-data">
                                    <thead>
										<tr>
                                            <th><?php echo renderLang($inspection_building); ?></th>
                                            <th><?php echo renderLang($calibration_prepared_by); ?></th>
											<th><?php echo renderLang($calibration_date_created); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<?php if(checkPermission('visitor-edit')) { ?>
											<th class="w35 no-sort p-0"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
									<?php
									if ($_SESSION['sys_account_mode'] == 'user') {

										$sql = $pdo->prepare("SELECT c.id, c.status, s.sub_property_name, s.property_id, sub_property_id, prepared_by, date_created FROM calibrations c LEFT JOIN sub_properties s ON (c.sub_property_id = s.id) WHERE c.temp_del = 0 AND c.category = 'Plan' ORDER BY date_created ASC");
										$sql->execute();
										while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
											
											echo '<tr>';

												$property_name = getField('property_name','properties','id ='.$data['property_id']);
												echo '<td>'.$data['sub_property_name'].' ['.$property_name.']</td>';
												echo '<td>'.$data['prepared_by'].'</td>';
												echo '<td>'.$data['date_created'].'</td>';

												// status
												echo '<td>';
													echo '<span class="badge badge-'.$daily_collection_report_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_status_arr[$data['status']]).'</span>';
												echo '</td>';

												echo '<td><a href="/calibration-plan-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($calibration_edit_calibration).'"><i class="fa fa-pencil-alt"></i></a></td>';

											echo '</tr>';
										}

									} else {

										//get cluster of users
										$clusters_ids = getClusterIDs($_SESSION['sys_id']);

										// if no cluster
										if (empty($clusters_ids)) {

											$property_ids = getField('property_ids','employees','id = '.$_SESSION['sys_id']);
											$properties = explode(',', $property_ids);
											foreach ($properties as $property_id) {

												$sql = $pdo->prepare("SELECT c.id, c.status, s.sub_property_name, s.property_id, sub_property_id, prepared_by, date_created FROM calibrations c LEFT JOIN sub_properties s ON (c.sub_property_id = s.id) WHERE c.temp_del = 0 AND c.category = 'Plan' AND s.property_id = :property_id ORDER BY date_created ASC");
												$sql->bindParam(":property_id",$property_id);
												$sql->execute();
												if ($sql->rowCount()) {
													while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
														
														echo '<tr>';

															$property_name = getField('property_name','properties','id ='.$data['property_id']);
															echo '<td>'.$data['sub_property_name'].' ['.$property_name.']</td>';
															echo '<td>'.$data['prepared_by'].'</td>';
															echo '<td>'.$data['date_created'].'</td>';

															// status
															echo '<td>';
																echo '<span class="badge badge-'.$daily_collection_report_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_status_arr[$data['status']]).'</span>';
															echo '</td>';

															echo '<td><a href="/calibration-plan-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($calibration_edit_calibration).'"><i class="fa fa-pencil-alt"></i></a></td>';

														echo '</tr>';
													}
												}

											}

										} else { // has cluster

											// get all properties under cluster
											foreach ($clusters_ids as $cluster_id) {
												$property_ids = array();

												// get properties under cluster
												$property_ids = getClusterProperties($cluster_id);

												foreach ($property_ids as $property_id) {

													$sql = $pdo->prepare("SELECT c.id, c.status, s.sub_property_name, s.property_id, sub_property_id, prepared_by, date_created FROM calibrations c LEFT JOIN sub_properties s ON (c.sub_property_id = s.id) WHERE c.temp_del = 0 AND c.category = 'Plan' AND s.property_id = :property_id ORDER BY date_created ASC");
													$sql->bindParam(":property_id",$property_id);
													$sql->execute();
													if ($sql->rowCount()) {
														while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
															
															echo '<tr>';

																$property_name = getField('property_name','properties','id ='.$data['property_id']);
																echo '<td>'.$data['sub_property_name'].' ['.$property_name.']</td>';
																echo '<td>'.$data['prepared_by'].'</td>';
																echo '<td>'.$data['date_created'].'</td>';

																// status
																echo '<td>';
																	echo '<span class="badge badge-'.$daily_collection_report_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_status_arr[$data['status']]).'</span>';
																echo '</td>';

																echo '<td><a href="/calibration-plan-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($calibration_edit_calibration).'"><i class="fa fa-pencil-alt"></i></a></td>';

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
                        <div class="card-footer text-right">
                            <a href="/calibration-category" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
            "order": [[ 2, "desc" ]]
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