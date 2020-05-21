<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('properties')) {

		// set page
		$page = 'properties';
		
		// get ID
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$_data = $sql->fetch(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($properties_add_sub_property); ?> &middot; <?php echo $sitename; ?></title>

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
								<i class="far fa-building mr-3"></i><?php echo renderLang($properties_add_sub_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php echo $_data['property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $id; ?>"><?php echo $_data['property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo renderLang($properties_add_sub_property); ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_sub_properties_add_err');
					renderError('sys_time_err');
					?>

					<!-- PROPERTY OPTIONS -->
					<div class="row">
						<div class="col-12">
							<div class="card property-card">
								<div class="card-body p-2">
									<a href="/property/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_property_details); ?></a>
									<a href="/property-sub-properties/<?php echo $id; ?>" class="btn btn-primary mr-1"><i class="far fa-building mr-2"></i><?php echo renderLang($properties_sub_property_list); ?></a>
									<a href="/property-employees/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="fa fa-users mr-2"></i><?php echo renderLang($employees_employees_list); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<form method="post" action="/submit-add-sub-property" autocomplete="off">
						
						<input type="hidden" name="property_id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($properties_add_sub_property_form); ?></h3>
							</div>
							<div class="card-body">
								
								<div class="row">

									<!-- SUB PROPERTY NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_sub_properties_add_property_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="sub_property_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_sub_property_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="sub_property_name" name="sub_property_name" placeholder="<?php echo renderLang($properties_sub_property_name_placeholder); ?>"<?php if(isset($_SESSION['sys_sub_properties_add_property_name_val'])) { echo ' value="'.$_SESSION['sys_sub_properties_add_property_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_add_property_name_err'].'</p>'; unset($_SESSION['sys_sub_properties_add_property_name_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<hr>
								
								<h4><?php echo renderLang($properties_sub_property_building_data); ?></h4>

								<div class="row">

									<!-- ASSOCIATION DUES -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_sub_properties_add_association_dues_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="sub_association_dues" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_association_dues); ?> (P/sq.m.)</label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="sub_association_dues" name="sub_association_dues" placeholder="e.g. 25.5"<?php if(isset($_SESSION['sys_sub_properties_add_association_dues_val'])) { echo ' value="'.$_SESSION['sys_sub_properties_add_association_dues_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_add_association_dues_err'].'</p>'; unset($_SESSION['sys_sub_properties_add_association_dues_err']); } ?>
										</div>
									</div>

									<!-- Inclusive Checkbox -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label><?php echo renderLang($properties_sub_property_building_data_inclusive_of); ?></label>
											<div class="custom-control custom-checkbox">
												<input name="inclusive[]" class="custom-control-input" type="checkbox" id="customCheckbox1" value="<?php echo renderLang($properties_sub_property_building_data_Real_State_Tax); ?>" checked>
												<label for="customCheckbox1" class="custom-control-label">
													<?php echo renderLang($properties_sub_property_building_data_Real_State_Tax); ?>
												</label>
											</div>

											<div class="custom-control custom-checkbox">
												<input name="inclusive[]" class="custom-control-input" type="checkbox" id="customCheckbox2" value="<?php echo renderLang($properties_sub_property_building_data_Building_Insurance); ?>">
												<label for="customCheckbox2" class="custom-control-label">
													<?php echo renderLang($properties_sub_property_building_data_Building_Insurance);?>
												</label>
											</div>
										</div>
									</div>

									<!-- Joining Fee -->
									<div class="col-lg-3 col-md-4">
										<?php $joining_fee_err = isset($_SESSION['sys_sub_properties_add_joining_fee_err']) ? 1:0; ?>
										<div class="form-group">
											<label class="mr-1 <?php echo $joining_fee_err ? 'text-danger' : ''; ?>"><?php echo $joining_fee_err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($properties_sub_property_building_data_Joining_Fee);?></label>
											<span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" name="join_fee" class="form-control required" <?php echo isset($_SESSION['sys_sub_properties_add_joining_fee_val']) ? 'value="'.$_SESSION['sys_sub_properties_add_joining_fee_val'].'"': ''; ?>>
											<?php 
											echo $joining_fee_err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_sub_properties_add_joining_fee_err'].'</p>' : '';
											unset($_SESSION['sys_sub_properties_add_joining_fee_err']);
											?>
										</div>
									</div>
									
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
                                            <?php foreach ($equipments_arr as $key => $equipment) { ?>
                                            <table class="table table-bordered table-hover">
                                            	<tbody>
                                                    <tr class="default-row">
                                                       	<?php 
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
	                                                    ?> 	
                                                        <td class="w150"><input type="number" class="form-control border-0" name="quantity[]"></td>
                                                        <td class="w100"><input type="text" class="form-control border-0" name="type[]"></td>
                                                        <td class="w150"><input type="text" class="form-control border-0" name="make_model[]"></td>
                                                        <td class="w100"><input type="text" class="form-control border-0" name="capacity[]" ></td>
                                                        <td class="w150"><input type="text" class="form-control date border-0"" name="date[]" ></td>
                                                        <td class="w150"><input type="text" class="form-control border-0" name="supplier[]"></td>
                                                        <td class="w150"><input type="text" class="form-control border-0" name="remarks[]"></td>
                                                        <input type="hidden" name="equipment_key[]" value="<?php echo $key; ?>">
                                                    </tr>
                                                   
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

								</div>
								<!-- .row -->

								</div>
								<!-- .row -->
								
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

													<?php foreach ($sub_property_amenities_arr as $key => $amenity) { ?>

													<tr>
														<td>
															<div class="icheck-primary">
																<input type="checkbox" id="<?php echo renderLang($amenity); ?>" name="amenity_name[]" value="<?php echo $amenity[0]; ?>"/>
																<label for="<?php echo renderLang($amenity); ?>"><?php echo renderLang($amenity); ?></label>
															</div>
														</td>
														<td><input type="text" class="form-control" name="amenity_description[]"></td>
														<td class="border-0"></td>
													</tr>

													<?php } ?>

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
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($properties_save_sub_property); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

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
	
</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_sub_properties_err'] = renderLang($properties_property_not_found);
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