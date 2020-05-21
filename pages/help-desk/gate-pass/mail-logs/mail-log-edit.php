<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('mail-log-edit')) {

		// set page
		$page = 'mail-logs';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM mail_logs WHERE id = :id LIMIT 1");
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
	<title><?php echo renderLang($mail_logs_edit_mail_log); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($mail_logs_edit_mail_log); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_mail_logs_edit_err');
					?>
					
					<form method="post" action="/submit-edit-mail-log">

						<input type="hidden" name="id" value="<?php echo $_data['id']; ?>">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($mail_logs_edit_mail_log_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('mail-log-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($mail_logs_delete_mail_log); ?></a><?php } ?>
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

									<!-- REFERENCE NUMBER-->
									<div class="col-lg-3 col-md-4">
										<label for="reference_number"><?php echo renderLang($mail_logs_reference_number); ?></label>
										<input type="text" class="form-control" name="reference_number" <?php if(isset($_SESSION['sys_mail_logs_edit_reference_number_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_edit_reference_number_val'].'"'; } else { echo 'value="'.$_data['reference_number'].'"'; } ?> required>
									</div>

                                    <!-- DATE RECEIVED -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_received"><?php echo renderLang($mail_logs_date_received); ?></label>
											<input type="text" class="form-control date" name="date_received" value="<?php echo formatDate($_data['date_received']); ?>">
										</div>
									</div>

									<!-- ADDRESSEE -->
									<div class="col-lg-3 col-md-4">
										<label for="addressee"><?php echo renderLang($mail_logs_addressee); ?></label>
										<input type="text" class="form-control" name="addressee" <?php if(isset($_SESSION['sys_mail_logs_edit_addressee_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_edit_addressee_val'].'"'; }  else { echo 'value="'.$_data['addressee'].'"'; } ?> required>
									</div>

								</div>

								<div class="row">

									<!-- SENDER -->
									<div class="col-lg-3 col-md-4">
										<label for="sender"><?php echo renderLang($mail_logs_sender); ?></label>
										<input type="text" class="form-control" name="sender" <?php if(isset($_SESSION['sys_mail_logs_edit_sender_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_edit_sender_val'].'"'; }  else { echo 'value="'.$_data['sender'].'"'; } ?> required>
									</div>

									<!-- DATE SENT -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_sent"><?php echo renderLang($mail_logs_date_sent); ?></label>
											<input type="text" class="form-control date" name="date_sent" value="<?php echo formatDate($_data['date_sent']); ?>">
										</div>
									</div>

									<!-- REMARKS -->
									<div class="col-lg-3 col-md-4">
										<label for="remarks"><?php echo renderLang($mail_logs_remarks); ?></label>
										<input type="text" class="form-control" name="remarks" <?php if(isset($_SESSION['sys_mail_logs_edit_remarks_val'])) { echo ' value="'.$_SESSION['sys_mail_logs_edit_remarks_val'].'"'; }  else { echo 'value="'.$_data['remarks'].'"'; } ?> >
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/mail-logs" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($mail_logs_update_mail_log); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<!-- confirm delete -->
        <?php if(checkPermission('mail-log-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-mail-log" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($mail_logs_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($mail_logs_modal_delete_msg2); ?></p>
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
                            window.location.href = '/mail-logs';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('.date').daterangepicker({
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