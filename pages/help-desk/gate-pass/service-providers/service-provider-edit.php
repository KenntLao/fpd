<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('service-provider-edit')) {

		// set page
		$page = 'service-providers';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM service_providers WHERE id = :id LIMIT 1");
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($service_providers_edit_service_provider); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['name_of_the_company']; ?></h1>
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
					
					<form method="post" action="/submit-edit-service-provider">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($service_providers_edit_service_provider_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('service-provider-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($service_providers_delete_service_provider); ?></a><?php } ?>
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

									<!-- Name of the Company -->
									<div class="col-lg-3 col-md-4">
										<label for="name_of_the_company"><?php echo renderLang($service_providers_name_of_the_company); ?></label>
										<input type="text" class="form-control" name="name_of_the_company" <?php if(isset($_SESSION['sys_service_providers_edit_name_of_the_company_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_name_of_the_company_val'].'"'; } else { echo 'value="'.$_data['name_of_the_company'].'"'; } ?> >
									</div>

									<!-- Services -->
									<div class="col-lg-3 col-md-4">
										<label for="services"><?php echo renderLang($service_providers_services); ?></label>
										<input type="text" class="form-control" name="services" <?php if(isset($_SESSION['sys_service_providers_edit_services_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_services_val'].'"'; } else { echo 'value="'.$_data['services'].'"'; } ?> >
									</div>

									<!-- Contact Person-->
									<div class="col-lg-3 col-md-4">
										<label for="contact_person"><?php echo renderLang($service_providers_contact_person); ?></label>
										<input type="text" class="form-control" name="contact_person" <?php if(isset($_SESSION['sys_service_providers_edit_contact_person_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_contact_person_val'].'"'; } else { echo 'value="'.$_data['contact_person'].'"'; } ?> >
									</div>
									

								</div><!-- row -->

								<div class="row">
									
									<!-- Mobile Number -->
									<div class="col-lg-3 col-md-4">
										<label for="mobile_number"><?php echo renderLang($service_providers_mobile_number); ?></label>
										<input type="text" class="form-control" name="mobile_number" <?php if(isset($_SESSION['sys_service_providers_edit_mobile_number_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_mobile_number_val'].'"'; } else { echo 'value="'.$_data['mobile_number'].'"'; } ?> >
									</div>

									<!-- Landline Number -->
									<div class="col-lg-3 col-md-4">
										<label for="landline_number"><?php echo renderLang($service_providers_landline_number); ?></label>
										<input type="text" class="form-control" name="landline_number" <?php if(isset($_SESSION['sys_service_providers_edit_landline_number_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_landline_number_val'].'"'; } else { echo 'value="'.$_data['landline_number'].'"'; } ?> >
									</div>

									<!-- Email Address -->
									<div class="col-lg-3 col-md-4">
										<label for="email_address"><?php echo renderLang($service_providers_email_address); ?></label>
										<input type="text" class="form-control" name="email_address" <?php if(isset($_SESSION['sys_service_providers_edit_email_address_val'])) { echo ' value="'.$_SESSION['sys_service_providers_edit_email_address_val'].'"'; } else { echo 'value="'.$_data['email_address'].'"'; } ?> >
									</div>


								</div><!-- row -->


								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/service-providers" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($service_providers_update_service_provider); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('service-provider-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-service-provider" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($service_providers_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($service_providers_modal_delete_msg2); ?></p>
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
                            window.location.href = '/service-providers';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
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