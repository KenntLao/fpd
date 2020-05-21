<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('properties')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'properties';
		
		// set fields from table to search on
		$fields_arr = array('property_code','property_name');
		$search_placeholder = renderLang($properties_property_code).', '.renderLang($properties_property_name);
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		$properties_type = 'cluster';
        if($_SESSION['sys_account_mode'] == 'employee') {
			$user_cluster = getField('id', 'clusters', 'assigned = '.$_SESSION['sys_id']);
			if(checkVar($user_cluster)) {

				$sql_query = 'SELECT * FROM properties'.$where.' AND cluster_id = '.$user_cluster; // set sql statement

			} else {

				$properties_type = 'employee';

				$property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
				$properties = explode(',', $property_ids);
				$property_count = 0;
				foreach($properties as $property_id) {
					if(checkVar($property_id)) {
						$exist = getField('id', 'properties', 'id = '.$property_id);
						if(checkVar($exist)) {
							$property_count++;
						}
					}
				}

			}
        } else {
            $sql_query = 'SELECT * FROM properties'.$where; // set sql statement
        }
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($properties_properties); ?> &middot; <?php echo $sitename; ?></title>
	
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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($properties_properties); ?></h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item active"><?php echo renderLang($properties_properties_list); ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_properties_err');
					renderSuccess('sys_properties_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><i class="fa fa-list mr-2"></i><?php echo renderLang($properties_properties_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('property-add')) { ?>
                                <a href="/add-property" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($properties_add_property); ?></a>
                                <?php } ?>
							</div>
						</div>
						<div class="card-body">
							
							<?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>
							
							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo renderLang($properties_property_id); ?></th>
											<th><?php echo renderLang($properties_property_code); ?></th>
											<th><?php echo renderLang($properties_property_name); ?></th>
											<th><?php echo renderLang($clients_client); ?></th>
                                            <th><?php echo renderLang($cluster); ?></th>
											<th class="text-center"><?php echo renderLang($properties_sub_properties); ?></th>
											<th class="text-center"><?php echo renderLang($employees_employees); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th class="w35 no-sort p-0"></th>
										</tr>
									</thead>
									<tbody>
                                        <?php
                                        if($_SESSION['sys_account_mode'] == 'employee') {
											
											$cluster_sql = checkVar($user_cluster) ? "AND cluster_id = ".$user_cluster : "";
                                            $data_count = 0;
											$sql = $pdo->prepare("SELECT * FROM properties".$where." ".$cluster_sql." ORDER BY property_id ASC");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												if(empty($user_cluster)) {
													$property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                    $properties = explode(',', $property_ids);
                                                    
                                                    $properties = array_filter($properties);

													if(in_array($data['id'], $properties)) {

                                                        

														$data_count++;
														$id = $data['id'];

														echo '<tr>';

															// PROPERTY ID
															echo '<td><a href="/property/'.$data['id'].'">'.$data['property_id'].'</a></td>';

															// PROPERTY CODE
															echo '<td><a href="/property/'.$data['id'].'">'.$data['property_code'].'</a></td>';

															// PROPERTY NAME
															echo '<td><a href="/property/'.$data['id'].'">'.$data['property_name'].'</a></td>';

															// CLIENT
															echo '<td>';
																if($data['client_id'] != 0) {
																	$_data = getData($data['client_id'],'clients');
																	echo '<a href="/client/'.$_data['id'].'">'.$_data['client_name'].'</a>';
																} else {
																	echo '<small>TBD</small>';
																}
															echo '</td>';
															
															// CLUSTER
															echo '<td>';
																if($data['cluster_id'] != 0) {
																	echo '<a href="#">'.getFIeld('cluster_name', 'clusters', 'id = '.$data['cluster_id']).'</a>';
																} else {
																	echo '<small>TBD</small>';
																}
															echo '</td>';

															// BUILDINGS
															echo '<td class="text-center">';

																// get from EMPLOYEES table
																$sql2 = $pdo->prepare("SELECT property_id, temp_del FROM sub_properties WHERE property_id = ".$id." AND temp_del = 0");
																$sql2->execute();
																$buildings_ctr = $sql2->rowCount();
																echo '<a href="/property-sub-properties/'.$id.'">'.number_format($buildings_ctr,0,'.',',');

															echo '</td>';

															// NUMBER OF EMPLOYEES
															echo '<td class="text-center">';

																// get from EMPLOYEES table
																$sql2 = $pdo->prepare("SELECT id, property_ids, temp_del FROM employees WHERE property_ids LIKE '%,".$id.",%' AND temp_del = 0");
																$sql2->execute();
																$employees_ctr = $sql2->rowCount();
																echo number_format($employees_ctr,0,'.',',');

															echo '</td>';
														
															// STATUS
															echo '<td>';
																foreach($status_arr as $status) {
																	if($status[0] == $data['status']) {
																		switch($data['status']) {
																			case 0:
																				echo '<span class="text-success">'.renderLang($status[1]).'</span>';
																				break;
																			case 1:
																				echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
																				break;
																		}
																	}
																}
															echo '</td>';

															// OPTIONS
															echo '<td>';

																// EDIT property
																if(checkPermission('property-edit')) {
																	echo '<a href="/edit-property/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($properties_edit_property).'"><i class="fa fa-pencil-alt"></i></a>';
																}

															echo '</td>'; // end options

														echo '</tr>';

													}

												} else {

													$data_count++;
													$id = $data['id'];

													echo '<tr>';

														// PROPERTY ID
														echo '<td><a href="/property/'.$data['id'].'">'.$data['property_id'].'</a></td>';

														// PROPERTY CODE
														echo '<td><a href="/property/'.$data['id'].'">'.$data['property_code'].'</a></td>';

														// PROPERTY NAME
														echo '<td><a href="/property/'.$data['id'].'">'.$data['property_name'].'</a></td>';

														// CLIENT
														echo '<td>';
															if($data['client_id'] != 0) {
																$_data = getData($data['client_id'],'clients');
																echo '<a href="/client/'.$_data['id'].'">'.$_data['client_name'].'</a>';
															} else {
																echo '<small>TBD</small>';
															}
														echo '</td>';
														
														// CLUSTER
														echo '<td>';
															if($data['cluster_id'] != 0) {
																echo '<a href="#">'.getFIeld('cluster_name', 'clusters', 'id = '.$data['cluster_id']).'</a>';
															} else {
																echo '<small>TBD</small>';
															}
														echo '</td>';

														// BUILDINGS
														echo '<td class="text-center">';

															// get from EMPLOYEES table
															$sql2 = $pdo->prepare("SELECT property_id, temp_del FROM sub_properties WHERE property_id = ".$id." AND temp_del = 0");
															$sql2->execute();
															$buildings_ctr = $sql2->rowCount();
															echo '<a href="/property-sub-properties/'.$id.'">'.number_format($buildings_ctr,0,'.',',');

														echo '</td>';

														// NUMBER OF EMPLOYEES
														echo '<td class="text-center">';

															// get from EMPLOYEES table
															$sql2 = $pdo->prepare("SELECT id, property_ids, temp_del FROM employees WHERE property_ids LIKE '%,".$id.",%' AND temp_del = 0");
															$sql2->execute();
															$employees_ctr = $sql2->rowCount();
															echo number_format($employees_ctr,0,'.',',');

														echo '</td>';
													
														// STATUS
														echo '<td>';
															foreach($status_arr as $status) {
																if($status[0] == $data['status']) {
																	switch($data['status']) {
																		case 0:
																			echo '<span class="text-success">'.renderLang($status[1]).'</span>';
																			break;
																		case 1:
																			echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
																			break;
																	}
																}
															}
														echo '</td>';

														// OPTIONS
														echo '<td>';

															// EDIT property
															if(checkPermission('property-edit')) {
																echo '<a href="/edit-property/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($properties_edit_property).'"><i class="fa fa-pencil-alt"></i></a>';
															}

														echo '</td>'; // end options

													echo '</tr>';

												}

                                            }

                                        } else {
                                            
                                            $data_count = 0;
                                            $sql = $pdo->prepare("SELECT * FROM properties".$where." ORDER BY property_id ASC");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $data_count++;
                                                $id = $data['id'];

                                                echo '<tr>';

                                                    // PROPERTY ID
                                                    echo '<td><a href="/property/'.$data['id'].'">'.$data['property_id'].'</a></td>';

                                                    // PROPERTY CODE
                                                    echo '<td><a href="/property/'.$data['id'].'">'.$data['property_code'].'</a></td>';

                                                    // PROPERTY NAME
                                                    echo '<td><a href="/property/'.$data['id'].'">'.$data['property_name'].'</a></td>';

                                                    // CLIENT
                                                    echo '<td>';
                                                        if($data['client_id'] != 0) {
                                                            $_data = getData($data['client_id'],'clients');
                                                            echo '<a href="/client/'.$_data['id'].'">'.$_data['client_name'].'</a>';
                                                        } else {
                                                            echo '<small>TBD</small>';
                                                        }
                                                    echo '</td>';
                                                    
                                                    // CLUSTER
                                                    echo '<td>';
                                                        if($data['cluster_id'] != 0) {
                                                            echo '<a href="#">'.getFIeld('cluster_name', 'clusters', 'id = '.$data['cluster_id']).'</a>';
                                                        } else {
                                                            echo '<small>TBD</small>';
                                                        }
                                                    echo '</td>';

                                                    // BUILDINGS
                                                    echo '<td class="text-center">';

                                                        // get from EMPLOYEES table
                                                        $sql2 = $pdo->prepare("SELECT property_id, temp_del FROM sub_properties WHERE property_id = ".$id." AND temp_del = 0");
                                                        $sql2->execute();
                                                        $buildings_ctr = $sql2->rowCount();
                                                        echo '<a href="/property-sub-properties/'.$id.'">'.number_format($buildings_ctr,0,'.',',');

                                                    echo '</td>';

                                                    // NUMBER OF EMPLOYEES
                                                    echo '<td class="text-center">';

                                                        // get from EMPLOYEES table
                                                        $sql2 = $pdo->prepare("SELECT id, property_ids, temp_del FROM employees WHERE property_ids LIKE '%,".$id.",%' AND temp_del = 0");
                                                        $sql2->execute();
                                                        $employees_ctr = $sql2->rowCount();
                                                        echo number_format($employees_ctr,0,'.',',');

                                                    echo '</td>';
                                                
                                                    // STATUS
                                                    echo '<td>';
                                                        foreach($status_arr as $status) {
                                                            if($status[0] == $data['status']) {
                                                                switch($data['status']) {
                                                                    case 0:
                                                                        echo '<span class="text-success">'.renderLang($status[1]).'</span>';
                                                                        break;
                                                                    case 1:
                                                                        echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
                                                                        break;
                                                                }
                                                            }
                                                        }
                                                    echo '</td>';

                                                    // OPTIONS
                                                    echo '<td>';

                                                        // EDIT property
                                                        if(checkPermission('property-edit')) {
                                                            echo '<a href="/edit-property/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($properties_edit_property).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        }

                                                    echo '</td>'; // end options

                                                echo '</tr>';
                                            }

                                        }
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->
							
							<?php // require($_SERVER['DOCUMENT_ROOT'].'/includes/common/pagination-bottom.php'); ?>
							
						</div>
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
    $(function() {

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