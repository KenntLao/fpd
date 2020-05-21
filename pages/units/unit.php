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
		
		// get ID
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM units WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {
			
			$data = $sql->fetch(PDO::FETCH_ASSOC);

			// get property data of sub property
			$property_id = $data['property_id'];
			$pid_data = getData($property_id,'properties');
			
			$sub_property_id = $data['sub_property_id'];
			$spid_data = getData($sub_property_id,'sub_properties');
			
			$unit_owner_id = $data['unit_owner_id'];
			if($data['unit_owner_id'] != 0) {
				$uo_data = getData($unit_owner_id,'unit_owners');
				switch($_SESSION['sys_language']) {
					case 0: $unit_owner_name = $uo_data['firstname'].' '.$uo_data['lastname']; break;
					case 1: $unit_owner_name = $uo_data['lastname'].' '.$uo_data['firstname']; break;
				}
			} else {
				$unit_owner_name = '<small>TBD</small>';
			}
			
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $data['unit_name'].' '.$spid_data['sub_property_name'].' &middot; '.$pid_data['property_name'].' &middot; '.renderLang($units_unit); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
								<?php echo $pid_data['property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $spid_data['sub_property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $data['unit_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $property_id; ?>"><?php echo $pid_data['property_name']; ?></a></li>
								<li class="breadcrumb-item"><a href="/sub-property/<?php echo $sub_property_id; ?>"><?php echo $spid_data['sub_property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo $data['unit_name']; ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					if($data['status'] == 2 && $data['temp_del'] != 0) {
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
									<a href="/sub-property/<?php echo $sub_property_id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_details); ?></a>
									<a href="/sub-property-units/<?php echo $sub_property_id; ?>" class="btn btn-primary mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_units_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- UNITS LIST -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($units_unit_details); ?></h3>
							<div class="card-tools">
								<?php renderProfileStatus($data['status']); ?>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th class="w170"><?php echo renderLang($units_unit_name) ?></th>
										<td class="w30p"><?php echo $data['unit_name']; ?></td>
										<th class="w170"><?php echo renderLang($properties_sub_property) ?></th>
										<td class="w30p"><?php echo $spid_data['sub_property_name']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($unit_owners_unit_owner) ?></th>
										<td><?php echo $unit_owner_name; ?></td>
										<th><?php echo renderLang($properties_property) ?></th>
										<td><?php echo $pid_data['property_name']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($units_unit_type) ?></th>
										<td>
											<?php
											foreach($unit_type_arr as $unit_type) {
												if($unit_type[0] == $data['unit_type']) {
													echo renderLang($unit_type[1]);
												}
											}
											?>
										</td>
										<th><?php echo renderLang($units_capacity) ?></th>
										<td><?php echo $data['unit_capacity']; ?></td>
									</tr>
									<tr>
										<th><?php echo renderLang($units_vacant) ?></th>
										<td colspan="3">
											<?php
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
											?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!-- card -->
					
                    <!-- TENANT LIST -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($tenants_tenants_list); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('unit-tenant-assign')) { ?><a href="" id="add" class="btn btn-success btn-md mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_assign_tenant_to_unit); ?></a><?php } ?>
								<?php if(checkPermission('tenant-add')) { ?><a href="/add-tenant" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($tenants_add_tenant); ?></a><?php } ?>
							</div>
						</div>
						<div class="card-body">

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-bordered table-striped table-hover with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($tenants_tenant_name); ?></th>
											<th><?php echo renderLang($tenants_gender); ?></th>
											<th>Date From</th>
											<th>Date To</th>
											<th><?php echo renderLang($lang_status); ?></th>
											<th style="width:35px;"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$data_count = 0;
										$sql = $pdo->prepare("SELECT
											*
											FROM unit_tenants
											LEFT JOIN tenants ON unit_tenants.tenant_id = tenants.id
											WHERE unit_id = ".$id."
										");
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

											$data_count++;
											

											echo '<tr>';

												// LAST NAME
												echo '<td>';
													echo '<a href="/tenant/'.$data['id'].'">';
														echo '['.$data['tenant_id'].'] ';
														switch($_SESSION['sys_language']) {
															case 0: echo $data['firstname'].' '.$data['lastname']; break;
															case 1: echo $data['lastname'].' '.$data['firstname']; break;
														}
													echo '</a>';
												echo '</td>';

												// GENDER
												echo '<td>';
													foreach($gender_arr as $gender) {
														if($gender[0] == $data['gender']) {
															echo renderLang($gender[1]);
														}
													}
												echo '</td>';

												// DATE FROM
												echo '<td>';
													echo date('F j, Y', $data['date_from']);
												echo '</td>';

												// DATE TO
												echo '<td>';
													echo date('F j, Y', $data['date_to']);
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

													// EDIT TENANT
													if(checkPermission('unit-tenant-lease-update')) {
														echo '<a href="#" class="btn btn-success btn-xs" title="'.renderLang($tenants_edit_tenant).'"><i class="fa fa-upload"></i></a>';
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

                    <!-- OCCUPANTS -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($occupants_occupants_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('unit-occupant-assign')) { ?><a href="/add-occupant/<?php echo $id; ?>" class="btn btn-success btn-md mr-1"><i class="fa fa-door-open mr-2"></i><?php echo renderLang($units_assign_occupants_to_unit); ?></a><?php } ?>
								<?php if(checkPermission('occupant-add')) { ?><a href="/add-occupant" class="btn btn-danger btn-md"><i class="fa fa-plus mr-2"></i><?php echo renderLang($occupants_add_occupant); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th><?php echo renderLang($occupants_occupant_name); ?></th>
                                        <th><?php echo renderLang($occupants_gender); ?></th>
                                        <th><?php echo renderLang($occupants_birthdate); ?></th>
                                        <th><?php echo renderLang($occupants_age); ?></th>
                                        <th><?php echo renderLang($lang_citizenship_global); ?></th>
										<th><?php echo renderLang($lang_status); ?></th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql = $pdo->prepare("SELECT o.id, o.firstname, o.middlename, o.lastname, o.gender, o.birthdate, o.status, c.nationality FROM occupants o LEFT JOIN units u ON(o.unit_id=u.id) LEFT JOIN countries c ON o.citizenship_id = c.num_code WHERE o.unit_id = :id AND o.temp_del = 0");
                                    $sql->bindParam(":id", $id);
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                        echo '<tr>';

                                        // NAME
                                        echo '<td>';
                                            echo '<a href="/occupant/'.$data['id'].'">';
                                                switch($_SESSION['sys_language']) {
                                                    case 0: echo $data['firstname'].' '.$data['lastname']; break;
                                                    case 1: echo $data['lastname'].' '.$data['firstname']; break;
                                                }
                                            echo '</a>';
                                        echo '</td>';

                                        // GENDER
                                        echo '<td>';
                                            echo renderLang($gender_arr[$data['gender']][1]);
                                        echo '</td>';

                                        // BIRTHDATE
                                        echo '<td>'.date('F j, Y', strtotime($data['birthdate'])).'</td>';

                                        // AGE
                                        $age = 0;
                                        $curr_date = time();
                                        $birthdate = strtotime($data['birthdate']);
                                        $age = $curr_date - $birthdate;
                                        $age = floor($age / (365*60*60*24));
                                        echo '<td>'.$age.'</td>';

                                        // CITIZENSHIP
                                        echo '<td>'.$data['nationality'].'</td>';
                                        
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

                                        echo '</tr>';

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('properties')){ ?>
        <div class="modal fade" id="modal-confirm-add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($units_assign_tenant_to_unit); ?></h4>
                    </div>
                    <form action="/submit-unit-tenant-assign" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <div class="form-group is-invalid">
                                <label for="modal_confirm_delete_upass"><?php echo renderLang($units_assign_tenant_id); ?></label>
                                <select class="form-control select2 " name="tenant_id" id="tenant_id" class="form-control">
                                	<?php 
                                	$sql = $pdo->prepare("SELECT * FROM tenants WHERE temp_del = 0");
                                	$sql->execute();
	                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                    echo '<option value="'.$data['id'].'">['.$data['tenant_id'].']'.$data['lastname'].', '.$data['firstname'].'</option>';

	                                }
                                	?>
                                </select>
                            </div>
                            <div class="form-group">
								<label for="date_from"><?php echo renderLang($units_assign_date_from); ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
										<input type="text" class="form-control float-right" name="date_from" id="date_from" required>
									</div>
							</div>
							<div class="form-group">
								<label for="date_to"><?php echo renderLang($units_assign_date_to); ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
										<input type="text" class="form-control float-right" name="date_to" id="date_to" required>
									</div>
							</div>
                            <div class="modal-error alert alert-danger"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                            <button class="btn btn-primary btn-add"><i class="fa fa-upload mr-2"></i><?php echo renderLang($units_assign_save_assign_tenant); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- modal -->
        <?php } ?>
        

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>

	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
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

			// open add modal
            $('#add').on('click', function(e){
                e.preventDefault();
                $('#modal-confirm-add .modal-error').hide();
                $('#modal-confirm-add').modal('show');
            });

            // submit delete modal
            $('form.ajax-form').on('submit', function(e){
                e.preventDefault();
                var post_url = $(this).attr('action');
                $.ajax({
                    url: post_url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response){
                        window.location.reload();
                    }
                });
            });
			
		});
	</script>
	<script>
		$(function() {

			$('#date_from').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
			});
			
		});
	</script>
	<script>
		$(function() {

			$('#date_to').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
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