<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unit-add')) {

		// set page
		$page = 'unit-add-eu';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?php echo renderLang($properties_add_property); ?> &middot;
			<?php echo $sitename; ?>
	</title>

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/users.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">

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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($units_add_unit); ?></h1>
						</div>
					</div>

				</div>
				<!-- container-fluid -->
			</section>
			<!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_units_add_suc');
                    ?>

					<!-- general form elements -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($units_add_unit); ?></h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						
						<form action="/submit-unit-eu-add" method="post">
							<div class="card-body">
								
								<h4><?php echo renderLang($units_unit_information); ?></h4>

									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="unit_name"><?php echo renderLang($units_unit_name); ?></label>
												<input type="text" class="form-control" name="unit_name" id="unit_name">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label><?php echo renderLang($properties_sub_property); ?></label>
												<select class="form-control select2" id="sub_property_id" name="sub_property_id" required>
                                                    <?php 
                                                    if($_SESSION['sys_account_mode'] == 'user') {

                                                        $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                        $sql->execute();
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }

                                                    } else {

                                                        // get clusters of user
                                                        $cluster_ids = getClusterIDs($_SESSION['sys_id']);
                                                        
                                                        // no cluster
                                                        if(empty($cluster_ids)) {

                                                            $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                            $sub_properties = explode(',', $sub_property_ids);
                                                            foreach($sub_properties as $sub_property_id) {
                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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

                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                                }

                                                            }

                                                        }
                                                    }
                                                    ?>
													<option value="0" class="property-tbd">TBD</option>
												</select>
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label><?php echo renderLang($properties_property); ?></label>
												<select class="form-control select2" id="property_id" name="property_id" required>
                                                    <?php 
                                                    if($_SESSION['sys_account_mode'] == 'user') { // users - superadmin

                                                        $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
                                                        $sql->execute();
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                        }

                                                    } else { // employees

                                                        $cluster_ids = getClusterIDs($_SESSION['sys_id']);

                                                        // no cluster
                                                        if(empty($cluster_ids)) {

                                                            $property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                            $properties = explode(',', $property_ids);
                                                            foreach($properties as $property_id) {
                                                                $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0 AND id = :id");
                                                                $sql->bindParam(":id", $property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                                    }
                                                                }
                                                            }

                                                        } else { // has cluster

                                                            foreach($cluster_ids as $cluster_id) {
                                                                $property_ids = array();
                                                                // get properties under cluster
                                                                $property_ids = getClusterProperties($cluster_id);

                                                                foreach($property_ids as $property_id) {
                                                                    $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0 AND id = :id");
                                                                    $sql->bindParam(":id", $property_id);
                                                                    $sql->execute();
                                                                    if($sql->rowCount()) {
                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        }

                                                    }        
                                                    ?>
												</select>
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-md-4">
											<div class="form-group">
												<label for="unit_capacity"><?php echo renderLang($units_capacity); ?></label>
												<input type="number" class="form-control" min="0" name="unit_capacity">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label><?php echo renderLang($units_unit_type); ?></label>
												<select class="form-control select" id="unit_type" name="unit_type" required>
                                        		<?php 
                                        			foreach($unit_type_arr as $key => $value) {
                                            			echo '<option '.($data['unit_type'] == $key? 'selected' : '').' value="'.$value[0].'">'.renderLang($value[1]).'</option>';
                                        			}
                                        		?>
											</select>
											</div><!-- /.form-group -->
										</div><!-- /.col -->

										<!-- UNIT AREA -->
										<div class="col-md-4">
											<div class="form-group">
												<label for="unit_area"><?php echo renderLang($units_unit_area); ?></label>
												<input type="text" class="form-control" id="unit_area" name="unit_area" required>
											</div>
										</div>

									</div>
									<!-- /.row -->
									<hr>

									<h4><?php echo renderLang($unit_owners_unit_owner_details); ?></h4>								

									<div class="row">

										<div class="col-md-4">
											<div class="form-group">
												<label for="firstname_uo"><?php echo renderLang($unit_owners_firstname); ?></label>
												<input type="text" class="form-control" name="firstname_uo" id="firstname_uo" placeholder="<?php echo renderLang($unit_owners_firstname_placeholder); ?>">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label for="middlename_uo"><?php echo renderLang($unit_owners_middlename); ?></label>
												<input type="text" class="form-control" name="middlename_uo" id="middlename_uo" placeholder="<?php echo renderLang($unit_owners_middlename_placeholder); ?>">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label for="lastname_uo"><?php echo renderLang($unit_owners_lastname); ?></label>
												<input type="text" class="form-control" name="lastname_uo" id="lastname_uo" placeholder="<?php echo renderLang($unit_owners_lastname_placeholder); ?>">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<div class="col-sm-4">
											<div class="form-group">
												<label><?php echo renderLang($unit_owners_gender); ?></label>
												<select class="form-control" name="gender_uo">
													<?php 
													foreach($gender_arr as $gender) {
														echo '<option value="'.$gender[0].'">'.renderLang($gender[1]).'</option>';
													}
													?>
												</select>
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->
										<div class="col-sm-4">
											<div class="form-group">
												<label for="birthdate_uo"><?php echo renderLang($unit_owners_birthdate); ?></label>
												<input type="text" class="form-control date" name="birthdate_uo" id="birthdate_uo">
											</div>
											<!-- /.form-group -->
										</div>
										<!-- /.col -->

										<!-- CITIZENSHIP -->
										<div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="citizenship_id" class="mr-1"><?php echo renderLang($lang_citizenship_global); ?></label>
                                                <select class="form-control select" id="citizenship_id" name="citizenship_id_uo" required>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option '.($data['num_code'] == 608 ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                
                                            </div>
										</div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="unit_owner_parking"><?php echo renderLang($unit_owners_parking); ?></label>
                                                <input type="text" class="form-control" name="unit_owner_parking" id="unit_owner_parking">
                                            </div>
                                        </div>

									</div>
									<!-- /.row -->
									<hr>

									<h4><?php echo renderLang($tenants_tenant_details); ?></h4>
								
									<div id="tenants_fields">
										<div class="row">

											<div class="col-md-4">

												<div class="form-group">
													<label for="exampleInputFirstname"><?php echo renderLang($tenants_firstname); ?></label>
													<input type="text" name="tenants_firstname[]" class="form-control" id="exampleInputFirstname" placeholder="<?php echo renderLang($tenants_firstname_placeholder); ?>" >
												</div><!-- /.form-group -->

											</div><!-- /.col -->

											<div class="col-sm-4">

												<div class="form-group">
													<label for="exampleInputMiddlename"><?php echo renderLang($tenants_middlename); ?></label>
													<input type="text" name="tenants_middlename[]" class="form-control" id="exampleInputMiddlename" placeholder="<?php echo renderLang($tenants_middlename_placeholder); ?>">
												</div><!-- /.form-group -->

											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="exampleInputLastname"><?php echo renderLang($tenants_lastname); ?></label>
													<input type="text" name="tenants_lastname[]" class="form-control" id="exampleInputLastname" placeholder="<?php echo renderLang($tenants_lastname_placeholder); ?>" >
												</div><!-- /.form-group -->

											</div><!-- /.col -->

											<div class="col-sm-4">

												<div class="form-group">
													<label><?php echo renderLang($tenants_gender); ?></label>
													<select class="form-control" name="tenants_gender[]">
													<?php 
													foreach($gender_arr as $gender) {
														echo '<option value="'.$gender[0].'">'.renderLang($gender[1]).'</option>';
													}
													?>
													</select>
												</div><!-- /.form-group -->

											</div><!-- /.col -->

											<div class="col-sm-4">

												<div class="form-group">
													<label for="tenants_birthdate"><?php echo renderLang($tenants_birthdate); ?></label>
													<input type="text" name="tenants_birthdate[]" class="form-control date">
												</div><!-- /.form-group -->

											</div><!-- /.col -->

											<!-- CITIZENSHIP -->
											<div class="col-sm-4">
										
												<div class="form-group citizenship-options">
													<label for="tenants_citizenship_id" class="mr-1"><?php echo renderLang($lang_citizenship_global); ?></label>
													<select class="form-control select2" name="tenants_citizenship_id[]">
														<?php 
				                                            $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
				                                            $sql->execute();
				                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
				                                                echo '<option '.($data['num_code'] == 608 ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
				                                            }
				                                        ?>
													</select>
													
												</div>
											</div>

											<!-- RELATIONSHIP TO OWNER -->
											<div class="col-sm-4">
										
												<div class="form-group">
													<label for="tenants_relationship_to_owner" class="mr-1"><?php echo renderLang($tenants_relationship_to_owner); ?></label>
													<select class="form-control select" name="tenants_relationship_to_owner[]" >
														<?php 
		                                        			foreach($relationship_to_owner_arr as $key => $value) {
		                                            			echo '<option '.($data['tenants_relationship_to_owner'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
		                                        			}
		                                        		?>
													</select>
													
												</div>
											</div>

											<!-- SOCIAL STATUS -->
											<div class="col-sm-4">
										
												<div class="form-group">
													<label for="tenants_social_status" class="mr-1"><?php echo renderLang($occupants_social_status); ?></label>
													<select class="form-control select" name="tenants_social_status[]" >
                                                        <option value=""></option>
														<?php 
		                                        			foreach($social_status_arr as $key => $value) {
		                                            			echo '<option '.($data['tenants_social_status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
		                                        			}
		                                        		?>
													</select>
												</div>

											</div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tenant_parking"><?php echo renderLang($tenants_parking); ?></label>
                                                    <input type="text" class="form-control" name="tenant_parking[]">
                                                </div>
                                            </div>

										</div>
										<!-- /.row -->
									</div><!-- /.fields -->

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<button class="btn btn-info" id="add-row-tenants"><i class="fas fa-plus mr-1"></i><?php echo renderLang($tenants_add_tenant); ?></button>
											</div><!-- /.form-group -->
										</div><!-- /.col -->
									</div><!-- /.row -->

									<hr>

									<h4><?php echo renderLang($occupants_occupant_details); ?></h4>

									<div id="occupants_fields">
										<div class="row">

											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputFirstname"><?php echo renderLang($occupants_firstname); ?></label>
													<input type="text" name="occupants_firstname[]" class="form-control" id="exampleInputFirstname" >
												</div><!-- /.form-group -->
											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="exampleInputMiddlename"><?php echo renderLang($occupants_middlename); ?></label>
													<input type="text" name="occupants_middlename[]" class="form-control" id="exampleInputMiddlename">
												</div><!-- /.form-group -->
											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="exampleInputLastname"><?php echo renderLang($occupants_lastname); ?></label>
													<input type="text" name="occupants_lastname[]" class="form-control" id="exampleInputLastname" >
												</div><!-- /.form-group -->
											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label><?php echo renderLang($occupants_gender); ?></label>
													<select class="form-control" name="occupants_gender[]">
													<?php 
													foreach($gender_arr as $gender) {
														echo '<option value="'.$gender[0].'">'.renderLang($gender[1]).'</option>';
													}
													?>
													</select>
												</div><!-- /.form-group -->
											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="exampleInputBirthdate"><?php echo renderLang($occupants_birthdate); ?></label>
													<input type="date" name="occupants_birthdate[]" class="form-control" id="exampleInputBirthdate">
												</div><!-- /.form-group -->
											</div><!-- /.col -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="occupants_citizenship_id" class="mr-1"><?php echo renderLang($lang_citizenship_global); ?></label>
													<select class="form-control select" id="occupants_citizenship_id" name="occupants_citizenship_id[]" >
														<?php 
				                                            $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
				                                            $sql->execute();
				                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
				                                                echo '<option '.($data['num_code'] == 608 ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
				                                            }
				                                        ?>
													</select>
													
												</div>
											</div>

											<!-- RELATIONSHIP TO TENANT-->
											<div class="col-sm-4">
										
												<div class="form-group">
													<label for="occupants_relationship_to_owner" class="mr-1"><?php echo renderLang($occupants_relationship_to_tenant); ?></label>
													<select class="form-control select" id="occupants_relationship_to_owner" name="occupants_relationship_to_owner[]" >
														<?php 
		                                        			foreach($relationship_to_tenant_arr as $key => $value) {
		                                            			echo '<option '.($data['occupants_relationship_to_owner'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
		                                        			}
		                                        		?>
													</select>
													
												</div>
											</div>

											<!-- SOCIAL STATUS -->
											<div class="col-sm-4">
										
												<div class="form-group">
													<label for="occupants_social_status" class="mr-1"><?php echo renderLang($occupants_social_status); ?></label>
													<select class="form-control select" id="occupants_social_status" name="occupants_social_status[]" >
                                                        <option value=""></option>
														<?php 
		                                        			foreach($social_status_arr as $key => $value) {
		                                            			echo '<option '.($data['occupants_social_status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
		                                        			}
		                                        		?>
													</select>
												</div>

											</div>

										</div>
										<!-- /.row -->
									</div>
									<!-- /.fields -->

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<button class="btn btn-info" id="add-row-occupants"><i class="fas fa-plus mr-1"></i><?php echo renderLang($occupants_add_occupant); ?></button>
											</div><!-- /.form-group -->
										</div><!-- /.col -->

									</div><!-- /.row -->

							</div>
							<!-- /.card-body -->
							<div class="card-footer text-right">
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($lang_save); ?></button>
							</div>
						</form>
					</div>

				</div>
				<!-- container-fluid -->
			</section>
			<!-- content -->

		</div>
			<!-- /.content-wrapper -->

			<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>

	</div>
	<!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){
        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format : 'YYYY-MM-DD'
                }
            });
        });
    });

		filterBuildings();
		
		// check if property value is changed
		$('#property_id').change(function() {
			filterBuildings();
		});
		
		// function to view only buildings under selected property
		function filterBuildings() {
			$('#sub_property_id option').hide();
			$('#sub_property_id .property-'+$('#property_id').val()).show();
			$('#sub_property_id .tbd').show();
			$('#sub_property_id option').each(function() {
				if($(this).attr('style') == 'display: none;') {} else {
					$('#sub_property_id').val($(this).attr('value'));
					return false;
				}
			});
		}
		
		//function for tenants
		$(function () {
			$('#add-row-tenants').on('click', function (e) {
				e.preventDefault();

				var other_fields = $('#tenants_fields').find('div:first-child').html();
                $('#tenants_fields').append('<div class="row">'+other_fields+'</div>');
                $('#tenants_fields').find('.row:nth-last-child(1)').find('.select2').remove();
                $('#tenants_fields').find('.row:nth-last-child(1)').find('.citizenship-options').html('<label for="tenants_citizenship_id" class="mr-1"><?php echo renderLang($lang_citizenship_global); ?></label><select class="form-control select2" id="tenants_citizenship_id" name="tenants_citizenship_id[]"><?php 
                    $sql = $pdo->prepare("SELECT num_code, nationality FROM countries");
                    $sql->execute();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option '.($data['num_code'] == 608 ? 'selected' : '').' value="'.$data['num_code'].'">'.$data['nationality'].'</option>';
                    }
                ?></select>');
                $('.select2').each(function(){
                    $(this).select2({
                        width: "100%"
                    });
                });
                $('#tenants_fields').find('.row:nth-last-child(1)').find('.date').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format : 'YYYY-MM-DD'
                    }
                });
			});

			$('#tenants_fields').on('click', '#remove', function (e) {
				e.preventDefault();

				$(this).closest('div').remove();

			});
		});

		//function for occupants
		$(function () {
			$('#add-row-occupants').on('click', function (e) {
				e.preventDefault();

				var other_fields = $('#occupants_fields').find('div:first-child').html();

				$('#occupants_fields').append('<div class="row">'+other_fields+'</div>');                

			});

			$('#occupants_fields').on('click', '#remove', function (e) {
				e.preventDefault();

				$(this).closest('div').remove();

			});
		});

		// submit function
		$(function(){

			$('[name="submit"]').on('click', function(e){
				e.preventDefault();

				// submit all form
				$('#unit-info').submit();
				$('#unit-owner').submit();
				$('#unit-tenant').submit();
				$('#unit-occupant').submit();

			});

			// unit info ajax
			$('#unit-info').on('submit', function(e){
				e.preventDefault();

        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(response){

          }
				});

			});

			// unit owner ajax
			$('#unit-owner').on('submit', function(e){
				e.preventDefault();

				$.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(response){

          }
				});

			});

			// unit tenant ajax
			$('#unit-tenant').on('submit', function(e){
				e.preventDefault();

				$.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(response){

          }
				});

			});

			// unit occupant ajax
			$('#unit-occupant').on('submit', function(e){
				e.preventDefault();

				$.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(response){

          }
				});

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