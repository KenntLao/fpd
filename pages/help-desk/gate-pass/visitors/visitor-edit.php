<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('visitor-edit')) {

		// set page
		$page = 'visitors';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM visitors WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($service_providers_edit_service_provider); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($visitors_edit_visitor); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['name_of_visitor']; ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_service_providers_add_err');
					?>
					
					<form method="post" action="/submit-edit-visitor">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($visitors_edit_visitor_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('visitor-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($visitors_delete_visitor); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- Sub Property ID -->
									<div class="col-lg-3 col-md-4">
										<label for="sub_property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
										<?php 
										$sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON (sp.property_id = p.id) WHERE sp.id = :sub_property_id");
										$sql->bindParam(":sub_property_id",$_data['sub_property_id']);
										$sql->execute();
										$_data2 = $sql->fetch(PDO::FETCH_ASSOC);
										?>
										<input type="text" class="form-control name-readonly" name="sub_property_id" value="<?php echo $_data2['sub_property_name']; ?> [<?php echo $_data2['property_name']; ?>]" readonly>
									</div>
									
								</div>

								<div class="row">

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

									<!-- NAME OF VISITORS -->
									<div class="col-lg-3 col-md-4">
										<label for="name_of_visitor"><?php echo renderLang($visitors_name_of_visitor); ?></label>
										<input type="text" class="form-control" name="name_of_visitor" <?php if(isset($_SESSION['sys_visitors_edit_name_of_visitor_val'])) { echo ' value="'.$_SESSION['sys_visitors_edit_name_of_visitor_val'].'"'; } else { echo 'value="'.$_data['name_of_visitor'].'"'; } ?> >
									</div>

									<!-- COMPANY / ADDRESS -->
									<div class="col-lg-3 col-md-4">
										<label for="company_address"><?php echo renderLang($visitors_company_address); ?></label>
										<input type="text" class="form-control" name="company_address" <?php if(isset($_SESSION['sys_visitors_edit_company_address_val'])) { echo ' value="'.$_SESSION['sys_visitors_edit_company_address_val'].'"'; } else { echo 'value="'.$_data['company_address'].'"'; } ?>>
									</div>
									
								</div><!-- row -->

								<div class="row">

									<!-- PERSON TO VISIT -->
									<div class="col-lg-3 col-md-4">
										<label for="person_to_visit"><?php echo renderLang($visitors_person_to_visit); ?></label>
										<input type="text" class="form-control" name="person_to_visit" <?php if(isset($_SESSION['sys_visitors_edit_person_to_visit_val'])) { echo ' value="'.$_SESSION['sys_visitors_edit_person_to_visit_val'].'"'; } else { echo 'value="'.$_data['person_to_visit'].'"'; } ?>>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($visitors_purpose); ?></label>
										<select class="form-control select2 purpose" name="purpose" <?php if(isset($_SESSION['sys_visitors_edit_purpose_val'])) { echo ' value="'.$_SESSION['sys_visitors_edit_purpose_val'].'"'; } ?>>
                                            <?php 
                                                foreach($visitor_purpose_arr as $key => $value) {
                                                    echo '<option '.($_data['purpose'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div>

									<!-- PURPOSE OTHERS -->
									<div class="col-lg-3 col-md-4 others  <?php if($_data['purpose'] != 'Others' ){ echo 'd-none'; } ?>">
										<div class="form-group">
											<label for="purpose_others" >Specify Others</label> <span></span>
											<input type="text" min="0" class="form-control" id="purpose_others" name="purpose_others" value="<?php echo $_data['purpose_others'] ?>">
										</div>
									</div>

                                    <?php if(checkPermission('visitor-approve')) { ?>
									<!-- STATUS -->
									<!-- <div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($visitors_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_visitors_edit_status_val'])) { echo ' value="'.$_SESSION['sys_visitors_edit_status_val'].'"'; } ?>>
                                            <?php 
                                                foreach($visitors_status_arr as $key => $value) {
                                                    echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div> -->
                                    <?php } ?>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/visitors" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($visitors_update_visitor); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('visitor-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-visitor" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($visitors_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($visitors_modal_delete_msg2); ?></p>
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
                            window.location.href = '/visitors';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

             // show specify field if othes is selected
	        $('.purpose').on('change', function(){

	            var val = $(this).val();

	            if(val == 'Others' ) {
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