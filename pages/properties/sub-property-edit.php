<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('property-edit')) {

		// set page
		$page = 'properties';

		// get id
		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT sub_property_inclusive_of, property_id, sub_property_name, sub_property_joining_fee, sub_property_association_dues FROM sub_properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			// get data of sub property
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			$property_id = $data['property_id'];
			
			// get property data of sub property
			$_data = getData($property_id,'properties');
			
			if(!isset($_SESSION['sys_sub_properties_edit_sub_property_name_val'])) {
				$_SESSION['sys_sub_properties_edit_sub_property_name_val'] = $data['sub_property_name'];
			}
			if(!isset($_SESSION['sys_sub_properties_edit_joining_fee_val'])) {
				$_SESSION['sys_sub_properties_edit_joining_fee_val'] = $data['sub_property_joining_fee'];
			}
			if(!isset($_SESSION['sys_sub_properties_edit_association_dues_val'])) {
				$_SESSION['sys_sub_properties_edit_association_dues_val'] = $data['sub_property_association_dues'];
			}

			$inclusive_of = explode(',',$data['sub_property_inclusive_of']);
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($properties_edit_sub_property); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
								<i class="far fa-building mr-3"></i><?php echo renderLang($properties_edit_sub_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php  echo $_data['property_name']; ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php  echo $data['sub_property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $property_id; ?>"><?php echo $_data['property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo renderLang($properties_edit_sub_property); ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_sub_properties_edit_err');
					renderSuccess('sys_sub_properties_edit_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>

					<!-- PROOERTY OPTIONS -->
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
					
					<form method="post" action="/submit-edit-sub-property">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($properties_edit_sub_property_form); ?></h3>
								<div class="card-tools">
									<button type="button" class="btn btn-danger btn-confirm-delete mr-1" data-toggle="modal" data-target="#modal-confirm-delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($properties_delete_sub_property); ?></button>
								</div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- PROPERTY NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_sub_properties_edit_sub_property_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="sub_property_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_sub_property_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="sub_property_name" name="sub_property_name" placeholder="<?php echo renderLang($properties_sub_property_name_placeholder); ?>"<?php if(isset($_SESSION['sys_sub_properties_edit_sub_property_name_val'])) { echo ' value="'.$_SESSION['sys_sub_properties_edit_sub_property_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_edit_sub_property_name_err'].'</p>'; unset($_SESSION['sys_sub_properties_edit_sub_property_name_err']); } ?>
										</div>
									</div>
									
								</div>

								<hr>
								
								<h4><?php echo renderLang($properties_sub_property_building_data); ?></h4>

								<div class="row">

									<!-- ASSOCIATION DUES -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_sub_properties_edit_association_dues_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="sub_association_dues" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_association_dues); ?> (P/sq.m.)</label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="sub_association_dues" name="sub_association_dues" placeholder="e.g. 25.5"<?php if(isset($_SESSION['sys_sub_properties_edit_association_dues_val'])) { echo ' value="'.$_SESSION['sys_sub_properties_edit_association_dues_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_edit_association_dues_err'].'</p>'; unset($_SESSION['sys_sub_properties_edit_association_dues_err']); } ?>
										</div>
									</div>

									<!-- Inclusive Checkbox -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label><?php echo renderLang($properties_sub_property_building_data_inclusive_of); ?></label>
											<div class="custom-control custom-checkbox">
												<input name="inclusive[]" class="custom-control-input" type="checkbox" id="customCheckbox1" value="<?php echo $properties_sub_property_building_data_Real_State_Tax[0]; ?>" <?php if (in_array($properties_sub_property_building_data_Real_State_Tax[0],$inclusive_of)) { echo 'checked'; } ?>>
												<label for="customCheckbox1" class="custom-control-label">
													<?php echo renderLang($properties_sub_property_building_data_Real_State_Tax); ?>
												</label>
											</div>

											<div class="custom-control custom-checkbox">
												<input name="inclusive[]" class="custom-control-input" type="checkbox" id="customCheckbox2" value="<?php echo $properties_sub_property_building_data_Building_Insurance[0]; ?>" <?php if (in_array($properties_sub_property_building_data_Building_Insurance[0],$inclusive_of)) { echo 'checked'; } ?>>
												<label for="customCheckbox2" class="custom-control-label">
													<?php echo renderLang($properties_sub_property_building_data_Building_Insurance);?>
												</label>
											</div>
										</div>
									</div>

									<!-- Joining Fee -->
									<div class="col-lg-3 col-md-4">
										<?php $joining_fee_err = isset($_SESSION['sys_sub_properties_edit_joining_fee_err']) ? 1:0; ?>
										<div class="form-group">
											<label class="mr-1 <?php echo $joining_fee_err ? 'text-danger' : ''; ?>"><?php echo $joining_fee_err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($properties_sub_property_building_data_Joining_Fee);?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" name="join_fee" class="form-control required" <?php echo isset($_SESSION['sys_sub_properties_edit_joining_fee_val']) ? 'value="'.$_SESSION['sys_sub_properties_edit_joining_fee_val'].'"': ''; ?>>
											<?php 
											echo $joining_fee_err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_edit_joining_fee_err'].'</p>' : '';
											unset($_SESSION['sys_sub_properties_edit_joining_fee_err']);
											?>
										</div>
									</div>
									

								</div>

								<div class="row">

									<!-- Floors/ Units -->
									<div class=" col-md-12">
										<h4><?php echo renderLang($properties_sub_property_equipment_list); ?></h4>
                                        <div class="table-responsive">
                                        	<table class="table table-bordered table-hover">
                                        		<thead>
                                                    <tr>
                                                        <th class="w170"><?php echo renderLang($properties_sub_property_equipment_name); ?></th>
                                                        <th class="w150"><?php echo renderLang($properties_sub_property_equipment_quantity); ?></th>
                                                        <th class="w100"><?php echo renderLang($properties_sub_property_equipment_type); ?></th>
                                                        <th class="w150"><?php echo renderLang($properties_sub_property_equipment_make_model); ?></th>
                                                        <th class="w100"><?php echo renderLang($properties_sub_property_equipment_capacity); ?></th>
                                                        <th class="w150"><?php echo renderLang($properties_sub_property_equipment_date_acquired); ?></th>
                                                        <th class="w150"><?php echo renderLang($properties_sub_property_equipment_supplier) ?></th>
                                                        <th class="w150"><?php echo renderLang($properties_sub_property_equipment_remarks); ?></th>
                                                    </tr>
                                                </thead>
                                        	</table>
                                            <?php foreach ($equipments_arr as $key => $equipment ) { ?>
                                            <table class="table table-bordered table-hover">
                                            	<tbody>

                                            		<?php 

                                            			$sql = $pdo->prepare("SELECT * FROM equipments WHERE sub_property_id = :sub_property_id AND equipment_key = :equipment_key");
                                                       	$sql->bindParam(":sub_property_id", $id);
                                                       	$sql->bindParam(":equipment_key", $key);
                                                       	$sql->execute();
                                                       	if($sql->rowCount()) {
	                                                       	while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

	                                                       		echo '<tr class="default-row">';

			                                                		echo '<td class="w170">';

			                                                        if (empty($equipment[1]['options'])) {

			                                                            echo '<input type="text" class="form-control border-0"  name="equipment[]" value="'.$data['equipment_name'].'">';

			                                                        } else {

			                                                            	echo '<select class="form-control border-0" name="equipment[]" value="'.$data['equipment_name'].'">';
			                                                            	foreach ($equipment[1]['options'] as $option_key => $option) {

			                                                            			echo '<option '.($data['equipment_name'] == $option[0] ? 'selected' : '').' value="'.$option[0].'">'.renderLang($option).'</option>';

			                                                            		}
			                                                            	echo '</select>';
			                                                        }

				                                                    echo '</td>';
			                                                        echo '<td class="w150"><input type="number" class="form-control border-0" name="quantity[]" value="'.$data['amount'].'"></td>';
			                                                        echo '<td class="w100"><input type="text" class="form-control border-0" name="type[]" value="'.$data['equipment_type'].'"></td>';
			                                                        echo '<td class="w150"><input type="text" class="form-control border-0" name="make_model[]" value="'.$data['serial_number'].'"></td>';
			                                                        echo '<td class="w100"><input type="text" class="form-control border-0" name="capacity[]" value="'.$data['equipment_capacity'].'"></td>';
			                                                        echo '<td class="w150"><input type="text" class="form-control date border-0"" name="date[]" value="'.formatDate($data['date_acquired']).'"></td>';
			                                                        echo '<td class="w150"><input type="text" class="form-control border-0" name="supplier[]" value="'.$data['supplier'].'"></td>';
			                                                        echo '<td class="w150"><input type="text" class="form-control border-0" name="remarks[]" value="'.$data['equipment_description'].'"></td>';
			                                                        echo '<input type="hidden" name="equipment_key[]" value="'.$data['equipment_key'].'">';
			                                                        echo '<input type="hidden" name="e_key_id[]" value="'.$data['id'].'">';
			                                                    echo '</tr>';

	                                                       	}

                                                     	} else {

                                                            echo '<tr class="default-row">';

                                                                echo '<td class="w170">';

                                                                if (empty($equipment[1]['options'])) {

                                                                    echo '<input type="text" class="form-control border-0"  name="equipment[]" value="'.renderLang($equipment[1]['title']).'">';

                                                                } else {

                                                                        echo '<select class="form-control border-0" name="equipment[]">';
                                                                        foreach ($equipment[1]['options'] as $option_key => $option) {

                                                                                echo '<option value="'.$option[0].'">'.renderLang($option).'</option>';

                                                                            }
                                                                        echo '</select>';
                                                                }

                                                                echo '</td>';
                                                                echo '<td class="w150"><input type="number" class="form-control border-0" name="quantity[]"></td>';
                                                                echo '<td class="w100"><input type="text" class="form-control border-0" name="type[]"></td>';
                                                                echo '<td class="w150"><input type="text" class="form-control border-0" name="make_model[]"></td>';
                                                                echo '<td class="w100"><input type="text" class="form-control border-0" name="capacity[]" ></td>';
                                                                echo '<td class="w150"><input type="text" class="form-control date border-0"" name="date[]" ></td>';
                                                                echo '<td class="w150"><input type="text" class="form-control border-0" name="supplier[]"></td>';
                                                                echo '<td class="w150"><input type="text" class="form-control border-0" name="remarks[]"></td>';
                                                                echo '<input type="hidden" name="equipment_key[]" value="'.$key.'">';
                                                                echo '<input type="hidden" name="e_key_id[]" value="0">';
                                                                
                                                            echo '</tr>';

                                                        }
                                                        ?>
                                                </tbody>
                                                <tfoot class="text-right" >
                                                	<tr>
                                                		<td colspan="7" class="border-0"></td>
                                                		<td class="border-0 w150">
	                                                    <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                		</td>
	                                                </tr>
                                                </tfoot>
                                            </table>
                                            
                                            <?php } ?>
                                        </div>
									</div>
									
								</div><!-- row -->

								<div class="row">


									<!-- amenities -->
									<div class="col-lg-8 col-md-12 p-4">
										<div class="form-group">
											<label><?php echo renderLang($properties_sub_property_amenities); ?></label>
											<table class="table table-header-center">
												<thead>
													<tr>
														<th><?php echo renderLang($properties_sub_property_amenities); ?></th>
														<th class="w300"><?php echo renderLang($properties_sub_property_amenities_description); ?></th>
														<th class="border-0 w100"></th>
													</tr>
												</thead>
												<tbody class="amenities-fields">

													<?php 
													foreach ($sub_property_amenities_arr as $key => $amenity) { 

													$sql = $pdo->prepare("SELECT * FROM sub_properties_amenities WHERE sub_property_id = :id AND amenity_name = :amenity");
													$sql->bindParam(":id", $id);
													$sql->bindParam(":amenity", $amenity[0]);
													$sql->execute();
													if(!$sql->rowCount()) {
													}
													$_data = $sql->fetch(PDO::FETCH_ASSOC);

															echo '<tr>';
																echo '<td>';
																echo '<div class="icheck-primary">';
																		echo '<input type="checkbox" id="'.renderLang($amenity).'" name="amenity_name[]" value="'.renderLang($amenity).'" '.(checkVar($_data['amenity_name']) && $amenity[0] == $_data['amenity_name'] ? 'checked' : '').' >';
																		echo '<label for="'.renderLang($amenity).'">'.renderLang($amenity).'</label>';
																	echo'</div>';
																echo '</td>';

															echo '<td><input type="text" class="form-control" name="amenity_description[]" value="'.$_data['amenity_description'].'"></td>';
															echo '<input type="hidden" name="amenities_id[]" value="'.$_data['id'].'">';
															echo '</tr>';
													} 
													?>
													<tr>
														<th><?php echo renderLang($properties_sub_property_amenities_other); ?></th>
														<th class="text-center"><a href="" id="add-row"><?php echo renderLang($properties_sub_property_add_row); ?></a></th>
													</tr>
													<tr>
														<td><input type="text" class="form-control" name="amenity_name[]"></td>
														<td><input type="text" class="form-control" name="amenity_description[]"></td>
														<td class="border-0"><a class="text-danger" href="" id="remove"><?php echo renderLang($lang_remove); ?></a></td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>

								</div>
								<!-- .row -->

							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/property-sub-properties/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($properties_update_sub_property); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->
	
	<!-- MODALS -->
	<!-- confirm delete -->
	<div class="modal fade" id="modal-confirm-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
				</div>
				<form action="/delete-sub-property" method="post" id="form_delete">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="test" value="test">
					<div class="modal-body">
						<p><?php echo renderLang($properties_modal_delete_msg3); ?></p>
						<p><?php echo renderLang($properties_modal_delete_msg4); ?></p>
						<hr>
						<div class="form-group is-invalid">
							<label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
							<input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
						</div>
						<div class="modal-error alert alert-danger"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button type="button" class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function(){
			$('#add-row').on('click', function(e){
				e.preventDefault();

				var other_fields = '<td><input type="text" class="form-control" name="amenity_name[]"></td><td><input type="text" class="form-control" name="amenity_description[]"></td><td class="border-0"><a class="text-danger" href="" id="remove"><?php echo renderLang($lang_remove); ?></a></td>' ;//$('#other-field').html();

				$('.amenities-fields').append('<tr>'+other_fields+'</tr>');

			});

			$('.amenities-fields').on('click', '#remove', function(e){
				e.preventDefault();

				$(this).closest('tr').remove();

            });
            
            $('.date').each(function(e){

                $(this).daterangepicker({
                    singleDatePicker: true,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
               	});

            });


            $('body').on('click', '.add-row', function(e){
	            e.preventDefault();

	            var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
	            $(this).closest('table').find('tbody').append(fields);

	            $('.date').each(function(e){
		            $(this).daterangepicker({
		                singleDatePicker: true,
		                locale: {
		                    format: 'YYYY-MM-DD'
		                }
		            });
		        });

	        });

            

		});
	</script>
	<script>
		$(function() {
			
			var form_data;
			
			// confirm delete
			$('.btn-delete').click(function() {
				form_data = $('#form_delete').serialize();
				$('#modal_confirm_delete_upass').val('');
				$('#form_delete').submit();
			});
			$('#form_delete').submit(function(e) {
				e.preventDefault();
				var post_url = $(this).attr("action");
				$.ajax({
					url: post_url,
					type: 'POST',
					data : form_data
				}).done(function(response){
					var response_arr = response.split(',');
					if(response_arr[0] == 1) { // val is 1
						window.location.href = '/property/<?php echo $property_id; ?>';
					} else {
						$('.modal-error')
							.html(response_arr[1]) // val is error message
							.show();
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
			$_SESSION['sys_sub_properties_err'] = renderLang($properties_sub_property_not_found);
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