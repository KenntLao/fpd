<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('inspection-BM')) {

    $page = 'inspections';
    
    $curr_day = date('d');
    $curr_month = date('m');
    $curr_year = date('Y');

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspection_building_manager_isnpections); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/pre-operation-audit.css">
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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($inspection_building_manager_isnpections); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_inspection_bm_add_suc');
                    renderError('sys_inspection_bm_add_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo renderLang($inspection_list); ?></h4>
                            <div class="card-tools">
                                <?php if(checkPermission('inspection-BM-add')) { ?>
                                <a href="/add-bm-inspection" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($inspection_building_manager_add); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="table-data">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($lang_date); ?></th>
                                            <th><?php echo renderLang($inspection_building); ?></th>
                                            <th class="w35 no-sort p-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										if($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT bm.date, bm.id, sub_property_name, property_name FROM task_inspection_bm_checklist bm JOIN sub_properties sp ON(bm.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE bm.temp_del = 0");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												echo '<tr>';

													echo '<td><a href="#">'.formatDate($data['date']).'</a></td>';

													echo '<td><a href="#">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';

													// edit
													if(checkPermission('inspection-BM-edit')) {
														echo '<td>';
															echo '<a href="/edit-bm-inspection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($inspection_building_manager_edit).'"><i class="fa fa-pencil-alt"></i></a>';
														echo '</td>';
													}

												echo '</tr>';

											}

										} else { // employees

											// get clusters of user
											$cluster_ids = getClusterIDs($_SESSION['sys_id']);
											
											// no cluster
											if(empty($cluster_ids)) {

												$sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
												$sub_properties = explode(',', $sub_property_ids);
												foreach($sub_properties as $sub_property_id) {
													$sql = $pdo->prepare("SELECT bm.date, bm.id, sub_property_name, property_name FROM task_inspection_bm_checklist bm JOIN sub_properties sp ON(bm.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE bm.temp_del = 0 AND bm.sub_property_id = :sub_property_id");
													$sql->bindParam(":sub_property_id", $sub_property_id);
													$sql->execute();
													if($sql->rowCount()) {
														while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

															echo '<tr>';

																echo '<td><a href="#">'.formatDate($data['date']).'</a></td>';

																echo '<td><a href="#">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';

																// edit
																if(checkPermission('inspection-BM-edit')) {
																	echo '<td>';
																		echo '<a href="/edit-bm-inspection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($inspection_building_manager_edit).'"><i class="fa fa-pencil-alt"></i></a>';
																	echo '</td>';
																}

															echo '</tr>';
															
														}

													}
												}

											} else { // has cluster

												// get all properties under cluster
												$property_ids = array();
												$sub_property_ids = array();
												foreach($cluster_ids as $cluster_id) {
													// get properties under cluster
													$property_ids = getClusterProperties($cluster_id);

													// get all sub_properties under property
													foreach($property_ids as $property_id) {
														$sql = $pdo->prepare("SELECT id FROM sub_properties WHERE property_id = :property_id AND temp_del = 0");
														$sql->bindParam(":property_id", $property_id);
														$sql->execute();
														if($sql->rowCount()) {
															while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																$sub_property_ids[] = $data['id'];
															}
														}
													}
												}

												foreach($sub_property_ids as $sub_property_id) {
													$sql = $pdo->prepare("SELECT bm.date, bm.id, sub_property_name, property_name FROM task_inspection_bm_checklist bm JOIN sub_properties sp ON(bm.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE bm.temp_del = 0 AND bm.sub_property_id = :sub_property_id");
													$sql->bindParam(":sub_property_id", $sub_property_id);
													$sql->execute();
													if($sql->rowCount()) {
														while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

															echo '<tr>';

																echo '<td><a href="#">'.formatDate($data['date']).'</a></td>';

																echo '<td><a href="#">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';

																// edit
																if(checkPermission('inspection-BM-edit')) {
																	echo '<td>';
																		echo '<a href="/edit-bm-inspection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($inspection_building_manager_edit).'"><i class="fa fa-pencil-alt"></i></a>';
																	echo '</td>';
																}

															echo '</tr>';
															
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
							<a href="/inspection-categories" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
						</div>
                    </div>

                </div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
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

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            // remove sorting in column
            $('.no-sort').each(function(){
                $(this).removeClass('sorting');
            });
            // 

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