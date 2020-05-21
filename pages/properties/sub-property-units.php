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
		$page = '';
		
		// get ID
		$id = $_GET['id'];

		$query_mode = 'sub-property-units';

		$sql = $pdo->prepare("SELECT * FROM sub_properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
            $property_id = $data['property_id'];
            
            $sub_property_id = $data['id'];

			// get property data of sub property
			$_data = getData($property_id,'properties');

			// set fields from table to search on
			$fields_arr = array('unit_name');
			$search_placeholder = renderLang($units_unit_name);
			require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');

			$sql_query = 'SELECT * FROM units'.$where; // set sql statement
			require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $data['sub_property_name'].' &middot; '.renderLang($properties_sub_property); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/properties.css">
	
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
							<h1>
								<i class="far fa-building mr-3"></i><?php echo renderLang($properties_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $_data['property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $data['sub_property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $property_id; ?>"><?php echo $_data['property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo $data['sub_property_name']; ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					if($_data['status'] == 2 && $_data['temp_del'] != 0) {
						$_SESSION['sys_sub_properties_err'] = renderLang($properties_sub_property_deleted);
					}
					renderError('sys_units_add_err');
					renderSuccess('sys_units_add_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>

					<!-- PROPERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $property_id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $property_id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- BUILDING OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card sub-property-card">
								<div class="card-body p-2">
									<a href="/sub-property/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_details); ?></a>
									<a href="/sub-property-units/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_units_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<?php if(checkPermission('units')) { ?>
					
						<!-- UNITS LIST -->
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($units_units_list); ?></h3>
								<div class="card-tools">
                                    <button class="btn btn-success" type="button" id="import"><i class="fa fa-download mr-1"></i><?php echo renderLang($lang_import); ?></button>
									<?php if(checkPermission('unit-add')) { ?><a href="/add-unit/<?php echo $property_id.'/'.$id ?>" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($units_add_unit); ?></a><?php } ?>
								</div>
							</div>
							<div class="card-body">
								
								<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search-and-pagination.php'); ?>

								<!-- DATA TABLE -->
								<div class="table-responsive">
									<table id="table-data" class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th><?php echo renderLang($units_unit_name); ?></th>
												<th><?php echo renderLang($unit_owners_unit_owner); ?></th>
												<th><?php echo renderLang($units_unit_type); ?></th>
												<th class="text-center"><?php echo renderLang($units_capacity); ?></th>
												<th class="text-center"><?php echo renderLang($units_vacant); ?></th>
                                                <?php if(checkPermission('unit-edit')) { ?>
												    <th style="width:35px;"></th>
                                                <?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php
											$data_count = 0;
											$sql = $pdo->prepare("SELECT * FROM units".$where." ORDER BY unit_name ASC LIMIT ".$sql_start.",".$numrows);
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

												$data_count++;
												$id = $data['id'];

												echo '<tr>';

													// UNIT NAME
													echo '<td><a href="/unit/'.$id.'">'.$data['unit_name'].'</a></td>';

													// UNIT OWNER
													echo '<td>';
														if($data['unit_owner_id'] == 0) {
															echo '<small>TBD</small>';
														} else {
															$_data = getData($data['unit_owner_id'],'unit_owners');
															echo '<a href="/unit-owner/'.$data['unit_owner_id'].'">'.$_data['firstname'].' '.$_data['lastname'].'</a>';
														}
													echo '</td>';
												
													// UNIT TYPE
													echo '<td>';
														foreach($unit_type_arr as $unit_type) {
															if($unit_type[0] == $data['unit_type']) {
																echo renderLang($unit_type[1]);
															}
														}
													echo '</td>';

													// CAPACITY
													echo '<td class="text-center">';
														// if unit type is residential, show capacity
														if(!$data['unit_type']) {
															echo $data['unit_capacity'];
														} else {
															echo '-';
														}
													echo '</td>';
												
													// VACANCY STATUS
													echo '<td class="text-center">';
														foreach($yesno_arr as $yesno) {
															if($yesno[0] == $data['vacancy_status']) {
																echo renderLang($yesno[1]);
															}
														}
														if($data['vacancy_status']) {
															foreach($vacancy_type_arr as $vacancy_type) {
																if($vacancy_type[0] == $data['vacancy_type']) {
																	echo ' ('.renderLang($vacancy_type[1]).')';
																}
															}
														}
													echo '</td>';

													// STATUS
													//echo '<td>';
													//	foreach($status_arr as $status) {
													//		if($status[0] == $data['status']) {
													//			switch($data['status']) {
													//				case 0:
													//					echo '<span class="text-success">'.renderLang($status[1]).'</span>';
													//					break;
													//				case 1:
													//					echo '<span class="text-warning">'.renderLang($status[1]).'</span>';
													//					break;
													//			}
													//		}
													//	}
													//echo '</td>';
												
												// OPTIONS
												echo '<td>';

													// EDIT UNIT
													if(checkPermission('unit-edit')) {
														echo '<a href="/edit-unit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($units_edit_unit).'"><i class="fa fa-pencil-alt"></i></a>';
													}

												echo '</td>'; // end options

												echo '</tr>';
											}
											?>
										</tbody>
									</table>
								</div><!-- table-responsive -->

							</div>
						</div><!-- card -->
					
					<?php } ?>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <!-- import -->
	<div class="modal fade" id="modal-import">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($lang_import); ?></h4>
				</div>
				<form action="/import-units" method="post" id="form_import">
                    <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                    <input type="hidden" name="sub_property_id" value="<?php echo $sub_property_id; ?>">
					<div class="modal-body">

                        <div class="row">

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="units_file"><?php echo renderLang($lang_excel_file); ?></label>
                                    <input type="file" id="units_file" name="units_file" accept=".csv" class="form-control" required>
                                    <small class="text-muted">Please upload file with .csv format only.</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <small>The format of the csv file should be:</small>
                                <p>unit name | unit type | unit area | status | unit capacity | firstname | middlename | lastname | gender | civil status | birthdate | citizenship</p>
                            </div>

                        </div>
                        <div id="form-alert"></div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button class="btn btn-primary"><i class="fa fa-download mr-2"></i><?php echo renderLang($lang_import); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {
			
			$('.duallistbox').bootstrapDualListbox();
			
			$('.btn-confirm-employees').click(function() {
				var property_id = <?php echo $id; ?>;
				var employee_ids = $('.duallistbox').val().join(',');
				loader.load('/property-manage-employees/'+property_id+'/'+employee_ids);
				showLoading();
			});
			
			// confirm employe remove
			$('.btn-property-remove-employee').click(function() {
				var property_id = <?php echo $id; ?>;
				var employee_id = $(this).attr('data-id') * 1;
				$('#modal-confirm-remove-employee a').attr('href','/property-remove-employee/'+property_id+'/'+employee_id);
            });
            
            // import units
            $('#import').on('click', function(e){
                e.preventDefault();

                $('#modal-import').modal('show');

            });

            $('#form_import').on('submit', function(e){
                e.preventDefault();

                $('#form-alert').html('<i class="fa fa-spinner fa-spin"></i>');

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(response){
						if(response == 'success') {
                            window.location.reload();
                        }else if(response == 'error') {
                            $('#form-alert').html(response);
                            $('#form-alert').show();
                        } else if(response == 'no session') {
                            window.location.href = "/";
                        } else {
                            $('#form-alert').html(response);
                            $('#form-alert').show();
                        }
					}
				});

			});
			
		});
	</script>
	
</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_properties_err'] = renderLang($properties_sub_property_not_found);
			header('location: /properties');

		}
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>