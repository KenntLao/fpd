<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('amenities')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'amenities';
		
		// set fields from table to search on
		// $fields_arr = array('client_id','client_name','contact_person');
		// $search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
		// require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
		
		// $sql_query = 'SELECT * FROM clients'.$where; // set sql statement
		// require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($amenities); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($amenities); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					
					renderSuccess('sys_amenities_add_suc');
					renderSuccess('sys_amenities_edit_suc');
					renderSuccess('sys_amenities_suc');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($amenities_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('amenity-add')) { ?><a href="/add-amenity" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($amenities_make_a_reservation); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<!-- <?php //require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?> -->

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
								
									<thead>
										<tr>
											<th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
											<th><?php echo renderLang($amenities_date); ?></th>
											<th><?php echo renderLang($amenities_venue); ?></th>
											<th><?php echo renderLang($amenities_subject); ?></th>
											<th><?php echo renderLang($amenities_project_name); ?></th>
											<th><?php echo renderLang($amenities_time_started_end); ?></th>
											<th><?php echo renderLang($amenities_status); ?></th>
											<?php if(checkPermission('amenity-edit')) { ?>
											<th class="w35"></th>
											<?php } ?>
											
										</tr>
									</thead>
									<tbody>
										<?php
										if ($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT a.*, sub_property_name, property_name FROM amenities a LEFT JOIN sub_properties sp ON (a.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE a.temp_del = 0 ORDER BY a.date ASC");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												$id = $data['id'];

												echo '<tr>';

													// SUB PROPERTY
													echo '<td><a href="/amenity/'.$id.'">'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</a></td>';

													// DATE
													echo '<td>'.formatDate($data['date']).'</td>';

													// COMPLAINANT
													echo '<td>'.$data['venue'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['subject'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['project_name'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['time_started_end'].'</td>';


													// DESCRIPTION
													echo '<td>'.renderLang($amenities_arr[$data['status']]).'</td>';

													if(checkPermission('amenity-edit')) {

													echo '<td><a href="/edit-amenity/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($amenities_edit_amenity).'"><i class="fa fa-pencil-alt"></i></a></td>';
													}


												echo '</tr>';
											}

										} else {

											$sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

											$sub_properties = implode(',',$sub_property_ids);

											$sql = $pdo->prepare("SELECT a.*, sub_property_name, property_name FROM amenities a LEFT JOIN sub_properties sp ON (a.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE a.temp_del = 0 AND a.sub_property_id IN ($sub_properties) ORDER BY a.date ASC");
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												
												$id = $data['id'];

												echo '<tr>';

													// SUB PROPERTY
													echo '<td><a href="/amenity/'.$id.'">'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</a></td>';

													// DATE
													echo '<td>'.formatDate($data['date']).'</td>';

													// COMPLAINANT
													echo '<td>'.$data['venue'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['subject'].'</td>';

													// DESCRIPTION
													echo '<td><a href="/amenity/'.$id.'">'.$data['project_name'].'</td>';

													// DESCRIPTION
													echo '<td>'.$data['time_started_end'].'</td>';


													// DESCRIPTION
													echo '<td>'.renderLang($amenities_arr[$data['status']]).'</td>';

													if(checkPermission('amenity-edit')) {

													echo '<td><a href="/edit-amenity/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($amenities_edit_amenity).'"><i class="fa fa-pencil-alt"></i></a></td>';
													}


												echo '</tr>';
											}

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
                "order": [[ 1, "desc" ]]
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