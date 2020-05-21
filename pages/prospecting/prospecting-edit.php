<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('prospecting-edit')) {

		// set page
        $page = 'prospecting';
        
        $id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
    
        $cat = $_data['prospecting_category'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($prospecting_edit); ?> &middot; <?php echo $sitename; ?></title>
	
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
                            <h1>
                                <i class="fas fa-binoculars mr-3"></i><?php echo renderLang($prospecting_edit); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <span class="text-uppercase"><?php echo renderLang($prospecting_category_arr[$cat]); ?></span>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['project_name']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_prospecting_edit_err');
					?>
					
					<form method="post" action="/submit-edit-prospecting">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

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

                                    <!-- STATUS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="status"><?php echo renderLang($prospecting_status); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                            <select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="status" name="status" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_edit_lead_received_through_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_lead_received_through_val'].'"'; } ?> required>
                                                <?php 
                                                    foreach($prospect_status_arr as $key => $value) {
                                                        echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-8 d-none" id="declined-remarks">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($prospecting_remarks); ?></label>
                                            <textarea name="declined_remarks" class="form-control notes" rows="2"><?php echo $_data['declined_remarks']; ?></textarea>
                                        </div>
                                    </div>

                                </div>

								<div class="row">

                                    <!-- REFERENCE NUMBER -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($prospecting_reference_number); ?></label>
                                            <input type="text" value="<?php echo $_data['reference_number']; ?>" class="form-control" readonly>
                                        </div>                                    
                                    </div>

									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="project_name"><?php echo renderLang($prospecting_project_name); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="project_name" name="project_name" placeholder="<?php echo renderLang($clients_client_name_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_edit_project_name_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_project_name_val'].'"'; } else { echo 'value="'.$_data['project_name'].'"'; } ?> required>
										</div>
									</div>

									<!-- OWNER/DEVELOPER -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="owner_developer"><?php echo renderLang($prospecting_owner_developer); ?></label> 
											<input type="text" class="form-control" id="owner_developer" name="owner_developer"  placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_edit_owner_developer_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_owner_developer_val'].'"'; } else { echo 'value="'.$_data['owner_developer'].'"'; } ?>>
										</div>
									</div>

									<!-- LOCATION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="location" ><?php echo renderLang($prospecting_location); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="location" name="location" placeholder=""<?php if(isset($_SESSION['sys_prospecting_edit_location_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_location_val'].'"'; } else { echo 'value="'.$_data['location'].'"'; } ?> required>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">

									
									<!-- PROPERTY CATEGORY -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_category"><?php echo renderLang($prospecting_property_category); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2 property_category" id="property_category" name="property_category" <?php if(isset($_SESSION['sys_prospecting_edit_property_category_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_property_category_val'].'"'; } ?> required>
                    							<?php 
                                        			foreach($prospecting_property_category_arr as $key => $value) {
                                            			echo '<option '.($_data['property_category'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- PROPERTY CATEGORY OTHERS -->
									<div class="col-lg-3 col-md-4 others <?php if($_data['property_category'] != 8 ){ echo 'd-none'; } ?>">
										<div class="form-group">
											<label for="property_category_others" >Specify Other</label> <span></span>
											<input type="text" min="0" class="form-control" id="property_category_others" name="property_category_others" placeholder="" <?php if(isset($_SESSION['sys_prospecting_edit_property_category_others_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_property_category_others_val'].'"'; } else { echo 'value="'.$_data['property_category_others'].'"'; } ?> >
										</div>
									</div>

									<!-- number of building -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="number_of_building"><?php echo renderLang($prospecting_number_of_building); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2" id="number_of_building" name="number_of_building" <?php if(isset($_SESSION['sys_prospecting_edit_number_of_building_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_number_of_building_val'].'"'; } ?> required>
                    							<?php 
                                        			foreach($prospecting_number_of_building_arr as $key => $value) {
                                            			echo '<option '.($_data['number_of_building'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- PROPERTY AGE -->
                                    <?php if($cat != 1 ) { ?>
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="property_age" ><?php echo renderLang($prospecting_property_age); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="number" min="0" class="form-control" id="property_age" name="property_age" placeholder="" <?php if(isset($_SESSION['sys_prospecting_edit_property_age_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_property_age_val'].'"'; } else { echo 'value="'.$_data['property_age'].'"'; } ?> required>
										</div>
									</div>
                                    <?php } ?>
									
									<!-- SERVICE REQUIRED -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="service_required"><?php echo renderLang($prospecting_service_required); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2" id="service_required" name="service_required" placeholder="" <?php if(isset($_SESSION['sys_prospecting_edit_service_required_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_service_required_val'].'"'; } ?> required>
                                                <?php 

                                                if($cat != 1) {

                                                    foreach($prospecting_service_required_arr as $key => $value) {
                                            			echo '<option '.($_data['service_required'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}

                                                } else if($cat == 1) {

                                                    foreach($prospecting_esd_service_required_arr as $key => $value) {
                                            			echo '<option '.($_data['service_required'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}

                                                }

                                        		?>
                  							</select>
										</div>
									</div>

                                    <!-- OTHER SERVICES -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="other_services"><?php echo renderLang($prospecting_other_services); ?></label>
											<input type="text" class="form-control" id="other_services" name="other_services" placeholder=""<?php if(isset($_SESSION['sys_prospecting_edit_other_services_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_other_services_val'].'"'; } else { echo 'value="'.$_data['other_services'].'"'; } ?>>
										</div>
									</div>

                                    <?php if($cat != 1) { ?>

                                    <!-- CURRENT PROPERTY MANAGEMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="current_property_management"><?php echo renderLang($prospecting_current_property_management); ?></label>
                                            <input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="current_property_management" name="current_property_management" <?php if(isset($_SESSION['sys_prospecting_edit_current_property_management_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_current_property_management_val'].'"'; } else { echo 'value="'.$_data['current_property_management'].'"'; } ?>>
                                            
                                        </div>
                                    </div>
                                    <?php } ?>

								</div><!-- row -->
                                
                                <!-- CONTACT INFO -->
                                <h5 class="pl-3"><?php echo renderLang($prospecting_contact_informations); ?></h5>
                                <div class="row">
                                
                                	<div class="col-sm-12">
	                                	<div class="table-responsive">
											<table class="table">
												<tbody class="table-data-contact">
                                                    <tr>
                                                        <!-- CONTACT PERSON -->
					                                    <td>
															<label><?php echo renderLang($prospecting_contact_person); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
															<input type="text" class="form-control" name="prospect_contact_person" required value="<?php echo $_data['contact_person']; ?>">
														</td>

														<!-- DESIGNATION -->
														<td>
															<label><?php echo renderLang($prospecting_designation); ?></label>
															<input type="text" class="form-control" name="prospect_contact_designation" value="<?php echo $_data['designation']; ?>">
														</td>
														
														<!-- CONTACT NUMBER -->
														<td>
															<label for="contact_number"><?php echo renderLang($prospecting_contact_number); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
															<input type="text" class="form-control" name="prospect_contact_number" required value="<?php echo $_data['mobile_number']; ?>">
														</td>

														<!-- EMAIL ADDRESS -->
														<td>
															<label><?php echo renderLang($prospecting_email_address); ?></label>
															<input type="email" class="form-control" name="prospect_email_address" value="<?php echo $_data['email_address']; ?>">
														</td>
                                                    </tr>
                                                    <?php 
													$sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE prospect_id = :id");
                                                	$sql->bindParam(":id", $id);
                                                	$sql->execute();
                                                	$last_code = '';

													while($data = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
													<tr>
                                                        <input type="hidden" name="prospect_contact_id[]" value="<?php echo $data['id']; ?>">
					                                    <!-- CONTACT PERSON -->
					                                    <td>
															<label ><?php echo renderLang($prospecting_contact_person); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
															<input type="text" class="form-control" name="contact_person[]" value="<?php echo $data['contact_person']; ?>" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>" >
														</td>

														<!-- DESIGNATION -->
														<td>
															<label><?php echo renderLang($prospecting_designation); ?></label>
															<input type="text" class="form-control" name="designation[]"  value="<?php echo $data['designation']; ?>" >
														</td>
														
														<!-- CONTACT NUMBER -->
														<td>
															<label><?php echo renderLang($prospecting_contact_number); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
															<input type="text" class="form-control" name="contact_number[]" value="<?php echo $data['contact_number']; ?>" >
														</td>

														<!-- EMAIL ADDRESS -->
														<td>
															<label ><?php echo renderLang($prospecting_email_address); ?></label>
															<input type="email" class="form-control" name="email_address[]" value="<?php echo $data['email_address']; ?>" >
														</td>
														
														<input type="hidden" name="code[]" value="<?php echo $data['code'] ?>">
														
													</tr>
                                                    <?php $last_code = $data['code']; ?>

													<?php } ?>
												</tbody>
                                                <tfoot>

                                                    <tr class="default-row-contact d-none" data-code="<?php echo $last_code; ?>">
                                                        
                                                        <input type="hidden" name="prospect_contact_id[]" value="0">

                                                        <!-- CONTACT PERSON -->
                                                        <td>
                                                            <label><?php echo renderLang($prospecting_contact_person); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                                            <input type="text" class="form-control" name="contact_person[]" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>" >
                                                        </td>

                                                        <!-- DESIGNATION -->
                                                        <td>
                                                            <label><?php echo renderLang($prospecting_designation); ?></label>
                                                            <input type="text" class="form-control" name="designation[]" >
                                                        </td>
                                                        
                                                        <!-- CONTACT NUMBER -->
                                                        <td>
                                                            <label><?php echo renderLang($prospecting_contact_number); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                                            <input type="text" class="form-control" name="contact_number[]" >
                                                        </td>

                                                        <!-- EMAIL ADDRESS -->
                                                        <td>
                                                            <label><?php echo renderLang($prospecting_email_address); ?></label>
                                                            <input type="email" class="form-control" name="email_address[]" >
                                                        </td>

                                                    </tr>
                                                
                                                </tfoot>
                                                
											</table>
                                            <?php if($cat != 1) { ?>
											<div class="text-right mb-3">
		                                        <button href="" class="btn btn-info add-row-contact"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
		                                    </div>
                                            <?php } ?>
										</div>
									</div>

								</div><!-- row -->

								<div class="row">
									
									<!-- REMARKS ON CONTACT PERSON -->
                                    <?php if($cat != 1) { ?>
									<div class="col-lg-3 col-md-4">										
										<div class="form-group">
											<label for="remarks_on_contact_person"><?php echo renderLang($prospecting_remarks_on_contact_person); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="remarks_on_contact_person" name="remarks_on_contact_person" <?php if(isset($_SESSION['sys_prospecting_edit_remarks_on_contact_person_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_remarks_on_contact_person_val'].'"'; } else { echo 'value="'.$_data['remarks_on_contact_person'].'"'; } ?> >
										</div>
									</div>
                                    <?php } ?>

									<!-- SOURCE-->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="lead_received_through"><?php echo renderLang($prospecting_source); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="lead_received_through" name="lead_received_through" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_edit_lead_received_through_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_lead_received_through_val'].'"'; } ?> required>
                    							<?php 
                                        			foreach($prospecting_lead_received_through_arr as $key => $value) {
                                            			echo '<option '.($_data['lead_received_through'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
										</div>
									</div>

									<!-- REFERRED BY -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="referred_by"><?php echo renderLang($prospecting_referred_by); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="referred_by" name="referred_by" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_prospecting_edit_referred_by_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_referred_by_val'].'"'; } else { echo 'value="'.$_data['referred_by'].'"'; } ?>>
										</div>
									</div>

                                    <!-- OTHER LEAD REMARKS -->
                                    <?php if($cat != 1) { ?>
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="other_lead_remarks"><?php echo renderLang($prospecting_other_lead_remarks); ?></label>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="other_lead_remarks" name="other_lead_remarks" <?php if(isset($_SESSION['sys_prospecting_edit_other_lead_remarks_val'])) { echo ' value="'.$_SESSION['sys_prospecting_edit_other_lead_remarks_val'].'"'; } else { echo 'value="'.$_data['other_lead_remarks'].'"'; } ?> >
										</div>
									</div>
                                    <?php } ?>
                                
                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prospecting-list/<?php echo $cat; ?>" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($prospecting_update_prospect); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <!-- PLANTILLA -->
    <div class="modal fade" id="modal-plantilla">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
            <form action="/send-to-hr" method="post" class="ajax-form">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($prospecting_for_hr_information); ?></h4>
				</div>
                <div class="modal-body">
                        <input type="hidden" name="prospect_id" value="<?php echo $id; ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2"><?php echo renderLang($nni_manpower_plantilla); ?></th>
                                        <th rowspan="2"><?php echo renderLang($nni_head_count); ?></th>
                                        <th colspan="2" class="text-center"><?php echo renderLang($nni_budget); ?></th>
                                        <th rowspan="2"><?php echo renderLang($nni_special_qualification); ?></th>
                                        <th rowspan="2"><?php echo renderLang($nni_remarks); ?></th>
                                    </tr>
                                    <tr>
                                        <th><?php echo renderLang($nni_base_pay); ?></th>
                                        <th><?php echo renderLang($nni_allowance); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="default-row">
                                        <td><input type="text" class="form-control border-0" name="plantilla[]"></td>
                                        <td><input type="text" class="form-control border-0" name="head_count[]"></td>
                                        <td><input type="text" class="form-control border-0" name="base_pay[]"></td>
                                        <td><input type="text" class="form-control border-0" name="allowance[]"></td>
                                        <td><input type="text" class="form-control border-0" name="qualification[]"></td>
                                        <td><input type="text" class="form-control border-0" name="remarks[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-info" id="add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                        </div>

                        <div class="alert alert-danger send-notif mt-2"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                    <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($prospecting_send_to_HR); ?></button>
                </div>
            </form>
			</div>
		</div>
	</div><!-- modal -->

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script>
        $(function(){

            var status = $('#status').val();

            if(status == 2 || status == 4) {
                $('#declined-remarks').removeClass('d-none');
            }

            $('#status').on('change', function(){

                status = $(this).val();

                if(status == 2 || status == 4) {
                    $('#declined-remarks').removeClass('d-none');
                } else {
                    $('#declined-remarks').addClass('d-none');
                }

            <?php if($cat == 0){ ?>
                // if(status == 3) {

                //     $('.send-notif').hide();
                //     $('#modal-plantilla').modal('show');

                // }
            <?php } ?>

            });

            $('.cancel').on('click', function(){
                $('#status').val(0);
            });

            $('#add-row').on('click', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('form').find('.default-row').html()+'</tr>';
                $(this).closest('form').find('tbody').append(fields);

            });

            var code = <?php echo $last_code > 0 ? $last_code : 0; ?>;
            $('body').on('click', '.add-row-contact', function(e){
                e.preventDefault();

                code++;

                var fields = '<tr>'+$(this).closest('.table-responsive').find('.default-row-contact').html()+'<input type="hidden" name="code[]" value="'+code+'"></tr>';
                $(this).closest('.table-responsive').find('tbody').append(fields);

            });

            // SEND to HR ajax
            $('form.ajax-form').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response){

                        if(response == 'error') {
                            $('.send-notif').html(response).show();
                            $('#status').val(3);
                        } else {
                            alert(response);
                            $('#modal-plantilla').modal('hide');
                        }
                        
                    }
                });

            });

            // show specify field if othes is selected
	        $('.property_category').on('change', function(){

	            var val = $(this).val();

	            if(val == 8 ) {
	                $('.others').removeClass('d-none');
	            }
	            else {
	                $('.others').addClass('d-none');
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