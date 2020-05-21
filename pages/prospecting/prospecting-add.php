<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prospecting-add')) {

		// set page
        $page = 'prospecting';
        
        $curr_date = date('ymd');

		// suggested reference no
		$sql = $pdo->prepare("SELECT id, reference_number FROM prospecting WHERE temp_del = 0 ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($data['reference_number'] == '') {
			$reference_number_suggestion = $curr_date.'0001';
		} else {
			if(strpos($data['reference_number'], '-')) {
				$num = explode('-', $data['reference_number']);
				$num = $num[0];	
				$reference_number_suggestion = $curr_date.substr($num, -4) + 1;
			} else {
				$reference_number_suggestion = $curr_date.substr($data['reference_number'], -4) + 1;
			}
			
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prospecting_new_leads); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="fas fa-binoculars mr-3"></i><?php echo renderLang($prospecting_new_leads); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_prospecting_add_err');
					renderSuccess('sys_prospecting_add_suc');
					?>
					
					<form method="post" action="/submit-add-prospecting">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($prospecting_new_leads_form); ?></h3>
							</div>
							<div class="card-body">

                                <!-- BUILDING INFO -->
                                <h5 class="pl-3"><?php echo renderLang($prospecting_project_informations); ?></h5>
                                <p class="text-muted pl-3"><?php echo renderLang($prospecting_required_warning); ?></p>
                                <hr>
								<div class="row">
									
									<!-- REFERENCE NUMBER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_prospecting_add_reference_number_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="reference_number" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($prospecting_reference_number); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="reference_number" name="reference_number" placeholder="<?php echo renderLang($clients_client_id_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_add_reference_number_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_reference_number_val'].'"'; } else { echo ' value="'.$reference_number_suggestion.'"'; } ?> required readonly>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_prospecting_add_reference_number_err'].'</p>'; unset($_SESSION['sys_prospecting_add_reference_number_err']); } ?>
										</div>
									</div>

									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="project_name"><?php echo renderLang($prospecting_project_name); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="project_name" name="project_name" placeholder="<?php echo renderLang($clients_client_name_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_add_project_name_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_project_name_val'].'"'; } ?> required>
										</div>
									</div>

									<!-- OWNER/DEVELOPER -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="owner_developer"><?php echo renderLang($prospecting_owner_developer); ?></label>
											<input type="text" class="form-control" id="owner_developer" name="owner_developer"  placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_add_owner_developer_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_owner_developer_val'].'"'; } ?>>
										</div>
									</div>

									<!-- LOCATION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="location" ><?php echo renderLang($prospecting_location); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="location" name="location" placeholder=""<?php if(isset($_SESSION['sys_prospecting_add_location_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_location_val'].'"'; } ?> required>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

									
									<!-- PROPERTY CATEGORY -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_category"><?php echo renderLang($prospecting_property_category); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2 property_category" id="property_category" name="property_category" <?php if(isset($_SESSION['sys_prospecting_add_property_category_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_property_category_val'].'"'; } ?> required>
                    							<?php 
                                        			foreach($prospecting_property_category_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- PROPERTY CATEGORY OTHERS -->
									<div class="col-lg-3 col-md-4 mt-1 other">
										<div class="form-group">
											<label for="property_age" >Other remarks</label> <span></span>
											<input type="number" min="0" class="form-control" id="property_age" name="property_age" placeholder="" <?php if(isset($_SESSION['sys_prospecting_add_property_age_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_property_age_val'].'"'; } ?>>
										</div>
									</div>

									<!-- number of building -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="number_of_building"><?php echo renderLang($prospecting_number_of_building); ?></label>
											<select class="form-control select2" id="number_of_building" name="number_of_building" <?php if(isset($_SESSION['sys_prospecting_add_number_of_building_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_number_of_building_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($prospecting_number_of_building_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- PROPERTY AGE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_age" ><?php echo renderLang($prospecting_property_age); ?></label> <span></span>
											<input type="number" min="0" class="form-control" id="property_age" name="property_age" placeholder="" <?php if(isset($_SESSION['sys_prospecting_add_property_age_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_property_age_val'].'"'; } ?>>
										</div>
									</div>
									
									<!-- SERVICE REQUIRED -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="service_required"><?php echo renderLang($prospecting_service_required); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2" id="service_required" name="service_required" placeholder="" <?php if(isset($_SESSION['sys_prospecting_add_service_required_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_service_required_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($prospecting_service_required_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- OTHER SERVICES -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="other_services"><?php echo renderLang($prospecting_other_services); ?></label>
											<input type="text" class="form-control" id="other_services" name="other_services" placeholder=""<?php if(isset($_SESSION['sys_prospecting_add_other_services_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_other_services_val'].'"'; } ?>>
										</div>
									</div>

									<!-- CURRENT PROPERTY MANAGEMENT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="current_property_management"><?php echo renderLang($prospecting_current_property_management); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="current_property_management" name="current_property_management" <?php if(isset($_SESSION['sys_prospecting_add_current_property_management_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_current_property_management_val'].'"'; } ?>>
											
										</div>
									</div>

								</div><!-- row -->

								

                                <!-- CONTACT INFO -->
                                <h5 class="pl-3"><?php echo renderLang($prospecting_contact_informations); ?></h5>
                                <hr>
                                <div class="row">

                                    <!-- CONTACT PERSON -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="contact_person"><?php echo renderLang($prospecting_contact_person); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="contact_person" name="contact_person" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_add_contact_person_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_contact_person_val'].'"'; } ?> required>
										</div>
									</div>

									<!-- DESIGNATION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="designation"><?php echo renderLang($prospecting_designation); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="designation" name="designation" <?php if(isset($_SESSION['sys_prospecting_add_designation_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_designation_val'].'"'; } ?>>
										</div>
									</div>
									
									<!-- TELEPHONE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="telephone"><?php echo renderLang($prospecting_telephone); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="telephone" name="telephone" <?php if(isset($_SESSION['sys_prospecting_add_telephone_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_telephone_val'].'"'; } ?>>
										</div>
									</div>

									<!-- MOBILE NUMBER -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="mobile_number"><?php echo renderLang($prospecting_mobile_number); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="mobile_number" name="mobile_number" <?php if(isset($_SESSION['sys_prospecting_add_mobile_number_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_mobile_number_val'].'"'; } ?> required>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

                                    <!-- EMAIL ADDRESS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="email_address"><?php echo renderLang($prospecting_email_address); ?></label>
											<input type="email" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="email_address" name="email_address" <?php if(isset($_SESSION['sys_prospecting_add_email_address_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_email_address_val'].'"'; } ?> >
										</div>
									</div>
									
									<!-- REMARKS ON CONTACT PERSON -->
									<div class="col-lg-3 col-md-4">
                                        <div class="form-group">
											<label for="remarks_on_contact_person"><?php echo renderLang($prospecting_remarks_on_contact_person); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="remarks_on_contact_person" name="remarks_on_contact_person" <?php if(isset($_SESSION['sys_prospecting_add_remarks_on_contact_person_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_remarks_on_contact_person_val'].'"'; } ?> >
										</div>
									</div>


									<!-- SOURCE-->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="lead_received_through"><?php echo renderLang($prospecting_source); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="lead_received_through" name="lead_received_through" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_add_lead_received_through_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_lead_received_through_val'].'"'; } ?> required>
                    							<?php 
                                        			foreach($prospecting_lead_received_through_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- REFERRED BY -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="referred_by"><?php echo renderLang($prospecting_referred_by); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="referred_by" name="referred_by" <?php if(isset($_SESSION['sys_prospecting_add_referred_by_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_referred_by_val'].'"'; } ?>>
										</div>
									</div>
									
									

                                </div><!-- row -->

                                <div class="row">

                                    <!-- OTHER LEAD REMARKS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="other_lead_remarks"><?php echo renderLang($prospecting_other_lead_remarks); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="other_lead_remarks" name="other_lead_remarks" <?php if(isset($_SESSION['sys_prospecting_add_other_lead_remarks_val'])) { echo ' value="'.$_SESSION['sys_prospecting_add_other_lead_remarks_val'].'"'; } ?> >
										</div>
									</div>

                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prospecting-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($prospecting_save_leads); ?></button>
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
	<script>
		$(function() {

            // show specify field if othes is selected
	        $('.property_category').on('change', function(){

	            var val = $(this).val();

	            if(val == 8 ) {
	                $('.other').removeClass('d-none');
	            }
	            else {
	                $('.other').addClass('d-none');
	            }

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