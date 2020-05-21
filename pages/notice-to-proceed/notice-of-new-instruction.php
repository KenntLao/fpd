<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-of-new-instructions')) {

		// set page
        $page = 'notice-to-proceed';
        
        $curr_date = date('ymd');

        $prospect_id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM prospecting  WHERE id = :id LIMIT 1");

        $sql->bindParam(":id",$prospect_id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $_SESSION['sys_nni_add_owner_developer_val'] = $_data['owner_developer'];
        $_SESSION['sys_nni_add_location_val'] = $_data['location'];
        $_SESSION['sys_nni_add_property_category_val'] = $_data['property_category'];
        $_SESSION['sys_nni_add_contact_person_val'] = $_data['contact_person'];
        $_SESSION['sys_nni_add_designation_val'] = $_data['designation'];
        $_SESSION['sys_nni_add_telephone_val'] = $_data['telephone'];
        $_SESSION['sys_nni_add_mobile_number_val'] = $_data['mobile_number'];
        $_SESSION['sys_nni_add_email_address_val'] = $_data['email_address'];

        $id = $_data['id'];

	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($new_notice_of_new_instruction); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="fas fa-file-signature mr-3"></i><?php echo renderLang($new_notice_of_new_instruction); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_prospecting_add_err');
					renderSuccess('sys_notice_to_proceed_add_suc');
					?>
					
					<form method="post" action="/submit-notice-of-new-instruction-add">

                        <input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($new_notice_of_new_instruction_form); ?></h3>
							</div>
							<div class="card-body">

                                <!-- BUILDING INFO -->
                                <h5 class="pl-3 text-uppercase"><?php echo renderLang($prospecting_project_informations); ?></h5>
                                <p class="text-muted pl-3"><?php echo renderLang($prospecting_required_warning); ?></p>
                                <hr>
								<div class="row">
									
									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="project_name" ><?php echo renderLang($prospecting_project_name); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo '['.$_data['reference_number'].'] '.$_data['project_name']; ?>" readonly>
										</div>
									</div>

									<!-- OWNER/DEVELOPER -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="owner_developer"><?php echo renderLang($prospecting_owner_developer); ?></label>
											<input type="text" class="form-control" id="owner_developer" name="owner_developer"  placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_nni_add_owner_developer_val'])) { echo ' value="'.$_SESSION['sys_nni_add_owner_developer_val'].'"'; } ?> readonly>
										</div>
									</div>

									<!-- PROJECT ADDRESS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="location" ><?php echo renderLang($nni_project_address); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
											<input type="text" class="form-control" id="location" name="location" placeholder=""<?php if(isset($_SESSION['sys_nni_add_location_val'])) { echo ' value="'.$_SESSION['sys_nni_add_location_val'].'"'; } ?> readonly>
										</div>
									</div>

                                    <!-- PROPERTY CATEGORY -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_category"><?php echo renderLang($prospecting_property_category); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                            <input type="text" class="form-control" id="property_category" name="property_category" value="<?php echo renderLang($prospecting_property_category_arr[$_data['property_category']]); ?>" readonly>
                                        </div>
                                    </div>

								</div><!-- row -->

								<br>
								<!-- CLIENT CONTACT DETAILS -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_clients_contact_details); ?></h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <tbody class="table-data">
                                                <tr>
                                                    <!-- CONTACT PERSON -->
                                                    <th><?php echo renderLang($nni_contact_person); ?></th>
                                                    <td colspan="3"><input type="text" class="form-control border-0" id="contact_person" name="contact_person" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_nni_add_contact_person_val'])) { echo ' value="'.$_SESSION['sys_nni_add_contact_person_val'].'"'; } ?> readonly></td>

                                                    <!-- DESIGNATION -->
                                                    <th><?php echo renderLang($nni_designation); ?></th>
                                                    <td><input type="text" class="form-control border-0" id="designation" name="designation" <?php if(isset($_SESSION['sys_nni_add_designation_val'])) { echo ' value="'.$_SESSION['sys_nni_add_designation_val'].'"'; } ?> readonly></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($nni_office_address); ?></th>
                                                    <td colspan="5"><textarea class="form-control w100p border-0" name="office_address" ></textarea></td>
                                                </tr>
                                                <tr>
                                                    <!-- TELEPHONE -->
                                                    <th><?php echo renderLang($nni_telephone); ?></th>
                                                    <td><input type="text" class="form-control border-0" id="designation" name="designation" <?php if(isset($_SESSION['sys_nni_add_telephone_val'])) { echo ' value="'.$_SESSION['sys_nni_add_telephone_val'].'"'; } ?> readonly></td>

                                                    <!-- MOBILE NUMBER-->
                                                    <th><?php echo renderLang($nni_mobile); ?></th>
                                                    <td><input type="text" class="form-control border-0" id="mobile_number" name="mobile_number" <?php if(isset($_SESSION['sys_nni_add_mobile_number_val'])) { echo ' value="'.$_SESSION['sys_nni_add_mobile_number_val'].'"'; } ?> readonly></td>

                                                    <!-- EMAIL ADDRESS -->
                                                    <th><?php echo renderLang($nni_email_address); ?></th>
                                                    <td colspan="2"><input type="email" class="form-control border-0" id="email_address" name="email_address" <?php if(isset($_SESSION['sys_nni_add_email_address_val'])) { echo ' value="'.$_SESSION['sys_nni_add_email_address_val'].'"'; } ?> readonly></td>
                                                </tr>
                                                <tr class="default-row1">

                                                    <!-- CONTACT PERSON -->
                                                    <th><?php echo renderLang($nni_contact_person); ?></th>
                                                    <td colspan="3"><input type="text" class="form-control border-0" name="nni_contact_person[]" id=""></td>

                                                    <!-- DESIGNATION -->
                                                    <th><?php echo renderLang($nni_designation); ?></th>
                                                    <td><input type="text" class="form-control border-0" name="nni_designation[]" id=""></td>
                                                </tr>
                                                <tr class="default-row2">

                                                    <!-- TELEPHONE -->
                                                    <th><?php echo renderLang($nni_telephone); ?></th>
                                                    <td><input type="text" class="form-control border-0" name="nni_telephone[]" id=""></td>

                                                    <!-- MOBILE NUMBER-->
                                                    <th><?php echo renderLang($nni_mobile); ?></th>
                                                    <td><input type="text" class="form-control border-0" name="nni_mobile[]" id=""></td>
                                                    
                                                    <!-- EMAIL ADDRESS -->
                                                    <th><?php echo renderLang($nni_email_address); ?></th>
                                                    <td colspan="2"><input type="email" class="form-control border-0" name="nni_email_address[]" id=""></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right mb-3">
                                            <button href="" class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- SCOPE OF SERVICE -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_scope_of_service); ?></h5>
                                <hr>
                                    <!-- SERVICE REQUIRED -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="service_required"><?php echo renderLang($prospecting_service_required); ?></label>
                                            <input type="text" class="form-control" id="service_required" name="service_required" value="<?php echo renderLang($prospecting_service_required_arr[$_data['service_required']]); ?>" readonly>
                                        </div>
                                    </div> 
                                
                                <br>
                                <!-- SERVICE AGREEMENT -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_service_agreement); ?></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th><?php echo renderLang($nni_contract_duration); ?></th>
                                                        <td colspan="3"><input type="text" class="form-control border-0" name="" id=""></td>
                                                        <th><?php echo renderLang($nni_start_of_contract); ?></th>
                                                        <td><input type="text" class="form-control border-0" name="start_contract" id="start_contract"></td>
                                                        <th><?php echo renderLang($nni_end_of_contract); ?></th>
                                                        <td><input type="text" class="form-control border-0" name="end_contract" id="end_contract" ></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <br>
                                <!-- FOR HR's INFORMATION -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_for_hr_information); ?></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2"><?php echo renderLang($nni_manpower_plantilla); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_head_count); ?></th>
                                                            <th colspan="2" class="text-center"><?php echo renderLang($nni_budget); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_deployment_date); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_special_qualifition); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_remarks); ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo renderLang($nni_base_pay); ?></th>
                                                            <th><?php echo renderLang($nni_allowance); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-data">
                                                        <?php 
                                                        foreach($hr_information_arr as $key => $hr_info) {

                                                            echo '<tr>';

                                                            // manpower_plantilla
                                                            echo '<td><p>'.renderLang($hr_info).'</p><input type="hidden" name="manpower_plantilla[]" class="form-control  border-0" value="'.$hr_info[0].'"></td>';

                                                            // head_count
                                                            echo '<td><input type="text" class="form-control border-0" name="head_count[]" id=""></td>';
                                                            // budget_base_pay
                                                            echo '<td><input type="number" class="form-control border-0" name="budget_base_pay[]" id=""></td>';

                                                            // budget_allowance
                                                            echo '<td><input type="number" class="form-control border-0" name="budget_allowance[]" id=""></td>';

                                                            //deployment_date
                                                            echo '<td><input type="text" class="form-control border-0 date" name="deployment_date[]" id="deployment_date"></td>';

                                                            //special_qualification
                                                            echo '<td><input type="text" class="form-control border-0" name="special_qualification[]" id=""></td>';

                                                            // hr_remarks
                                                            echo '<td><input type="text" class="form-control border-0" name="hr_remarks[]" id=""></td>';

                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                            <tr class="default-row3">

                                                                <!-- manpower_plantilla -->
                                                                <td><input type="text" class="form-control border-0" name="manpower_plantilla[]"></td>

                                                                <!-- head_count -->
                                                                <td><input type="text" class="form-control border-0" name="head_count[]" id=""></td>

                                                                <!-- budget_base_pay -->
                                                                <td><input type="number" class="form-control border-0" name="budget_base_pay[]" id=""></td>

                                                                <!-- budget_allowance -->
                                                                <td><input type="number" class="form-control border-0" name="budget_allowance[]" id=""></td>

                                                                <!-- deployment_date -->
                                                                <td><input type="text" class="form-control border-0 date" name="deployment_date[]" id="deployment_date"></td>

                                                                <!-- special_qualification -->
                                                                <td><input type="text" class="form-control border-0" name="special_qualification[]" id=""></td>

                                                                <!-- hr_remarks -->
                                                                <td><input type="text" class="form-control border-0" name="hr_remarks[]" id=""></td>
                                                                
                                                                
                                                            </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-right mb-3">
                                                    <button href="" class="btn btn-info add-row2"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <br>
                                <!-- FOR CAD's INFORMATION -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_for_cad_information); ?></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo renderLang($nni_property_administration); ?></th>
                                                            <th><?php echo renderLang($nni_inclusions); ?></th>
                                                            <th><?php echo renderLang($nni_terms); ?></th>
                                                            <th><?php echo renderLang($nni_remarks); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><textarea class="form-control border-0" name="property_administration"></textarea></td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php foreach ($inclusions_arr as $key => $inclusions) { ?>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input name="inclusions[]" class="custom-control-input" type="checkbox" id="occustomCheckbox<?php echo $key; ?>" value="<?php echo $key; ?>">
                                                                            <label for="occustomCheckbox<?php echo $key; ?>" class="custom-control-label">
                                                                                <?php echo renderLang($inclusions); ?>
                                                                            </label>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </td>
                                                            <td><textarea class="form-control border-0" name="terms"></textarea></td>
                                                            <td><textarea class="form-control border-0" name="cad_remarks"></textarea></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <br>
                                <!-- REFERENCE DOCUMENTS -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_reference_documents); ?></h5>
                                <hr>
                                    <!-- TYPE OF DEVELOPMENT -->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <?php foreach ($reference_documents_arr as $key => $value) { ?>

                                                <div class="col-md-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="reference_document[]" class="custom-control-input" type="checkbox" id="rdcustomCheckbox<?php echo $key;?>" value="<?php echo $key; ?>">
                                                        <label for="rdcustomCheckbox<?php echo $key;?>" class="custom-control-label">
                                                            <?php echo renderLang($value); ?>
                                                        </label>
                                                    </div>
                                                </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                <br>
                                <!-- REMARKS -->
                                <h5 class=" text-uppercase"><?php echo renderLang($nni_remarks); ?></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td><textarea class="form-control border-0" name="nni_remarks"></textarea></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/prospecting-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($nni_save_nni); ?></button>
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
        $(function() {

            $('.add-row').on('click', function(e){
                e.preventDefault();

                var fields1 = '<tr>'+$('.default-row1').html()+'</tr>';
                var fields2 = '<tr>'+$('.default-row2').html()+'</tr>';
                $('.table-data').append(fields1 + fields2);

            });

            $('.add-row2').on('click', function(e){
                e.preventDefault();

                var fields3 = '<tr>'+$('.default-row3').html()+'</tr>';
                $('.table-data').append(fields3);

                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
                    });
                });

            });

            $('#start_contract').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
            });

            $('#end_contract').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
                }
            });

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                locale: {
                    format: 'MMMM D, Y'
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