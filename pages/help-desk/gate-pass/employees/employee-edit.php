<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('gate-pass-employee-edit')) {

		// set page
		$page = 'gate-pass-employees';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
		if ($sql->rowCount()) {

        $_data = $sql->fetch(PDO::FETCH_ASSOC);	
			
		} else {

			$_SESSION['sys_gate_pass_employees_edit_err'] = renderLang($lang_no_data);
            header('location: /gate-pass-employees');
            exit();

		}
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($gate_pass_employees_edit_employee); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($gate_pass_employees_edit_employee); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['employee_name']; ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_gate_pass_employees_add_suc');
					?>
					
					<form method="post" action="/submit-edit-gate-pass-employee">

						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($gate_pass_employees_edit_employee_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('gate-pass-employee-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($gate_pass_employees_delete_employee); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- Sub Property ID -->
									<div class="col-lg-3 col-md-4">
										<label for="property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
										<?php 
										if (empty($_data['property_id'])) {

											$project_code = getField('reference_number','prospecting','id ='.$_data['prospect_id']);
											
											echo '<input type="text" class="form-control name-readonly" name="property_id" value="'.(!empty($_data['prospect_id']) ? $_data['property_name'].' ['.$project_code.']' : '').'" readonly>';

										} else {

											$property_code = getField('property_id','properties','id ='.$_data['property_id']);
											
											echo '<input type="text" class="form-control name-readonly" name="property_id" value="'.(!empty($_data['property_id']) ? $_data['property_name'].' ['.$property_code.']' : '').'" readonly>';

										}
										?>
									</div>

									<!-- TIME OUT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_out"><?php echo renderLang($visitors_time_out); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right input-readonly" name="time_out" id="time_out" value="<?php echo date('H:i:s'); ?>" readonly>
											</div>
										</div>
									</div>
									
								</div><!-- row -->

								<div class="row">

									<!-- employee_name -->
									<div class="col-lg-3 col-md-4">
										<label for="employee_name"><?php echo renderLang($gate_pass_employees_employee_name); ?></label>
										<input type="text" class="form-control" name="employee_name" <?php if(isset($_SESSION['sys_gate_pass_employees_edit_employees_name_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employees_edit_employees_name_val'].'"'; } else { echo 'value="'.$_data['employee_name'].'"'; } ?> required>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($gate_pass_employees_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" <?php if(isset($_SESSION['sys_gate_pass_employees_edit_purpose_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employees_edit_purpose_val'].'"'; } else { echo 'value="'.$_data['purpose'].'"'; } ?> required>
									</div>

									<!-- PERSON / DEPARTMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="person_department"><?php echo renderLang($gate_pass_employees_person_department); ?></label>
										<input type="text" class="form-control" name="person_department" <?php if(isset($_SESSION['sys_gate_pass_employees_edit_department_val'])) { echo ' value="'.$_SESSION['sys_gate_pass_employees_edit_department_val'].'"'; } else { echo 'value="'.$_data['person_department'].'"'; } ?> required>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/gate-pass-employees" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($gate_pass_employees_update_employee); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('gate-pass-employee-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-gate-pass-employee" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($gate_pass_employees_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($gate_pass_employees_modal_delete_msg2); ?></p>
                            <hr>
                            <div class="form-group is-invalid">
                                <label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
                                <input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
                            </div>
                            <div class="modal-error alert alert-danger"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                            <button class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
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
	<script>
		$(function() {

			// open delete modal
            $('#delete').on('click', function(e){
                e.preventDefault();
                $('#modal-confirm-delete .modal-error').hide();
                $('#modal-confirm-delete').modal('show');
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
                        var response_arr = response.split(',');
                        if(response_arr[0] == 1) { // val is 1
                            window.location.href = '/gate-pass-employees';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
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