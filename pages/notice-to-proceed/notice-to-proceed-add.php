<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-add')) {

		// set page
		$page = 'notice-to-proceed';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($notice_to_proceed_new_ntp); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-signature mr-3"></i><?php echo renderLang($notice_to_proceed_new_ntp); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_notice_to_proceed_add_err');
					?>
					
					<form method="post" action="/submit-add-notice-to-proceed" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($notice_to_proceed_new_ntp_form); ?></h3>
                                <div class="card-tools">
                                    <!-- <button type="button" class="btn btn-info" id="print"><i class="fa fa-envelope mr-1"></i><?php echo renderLang($notice_to_proceed_send); ?></button> -->
                                </div>
							</div>
							<div class="card-body">

								<div class="row">
									
									<!-- PROJECT NAME -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="prospect_id" ><?php echo renderLang($notice_to_proceed_project_name); ?></label>
											<select class="form-control select2" id="prospect_id" name="prospect_id" required>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_add_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_add_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0 ORDER BY project_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    // check if already created
                                                    $exist = getField('id', 'notice_to_proceed', 'temp_del = 0 AND prospect_id = '.$data['id']);
                                                    if(!$exist) {

                                                        echo '<option value="'.$data['id'].'"';
                                                        if($select_val == $data['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>['.$data['reference_number'].'] '.$data['project_name'].'</option>';

                                                    }
												}
												?>
											</select>
										</div>
									</div>

									<!-- DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date-notice-to-proceed"><?php echo renderLang($notice_to_proceed_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date" id="date-notice-to-proceed">
											</div>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="status"><?php echo renderLang($notice_to_proceed_status); ?></label>
											<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_notice_to_proceed_add_status_val'])) { echo ' value="'.$_SESSION['sys_notice_to_proceed_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($notice_to_proceed_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>	
										</div>
									</div>

								</div><!-- row -->

								<div class="row">
									
									<!-- ATTACHMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($notice_to_proceed_attachment); ?></label>
										<input type="file" class="form-control" name="attachment[]" required multiple>
									</div>

								</div>

								<div class="row">

									<!-- REMARKS -->
									<div class="col-lg-6 col-md-12">
										<label for="remarks"><?php echo renderLang($notice_to_proceed_remarks); ?></label>
										<textarea name="remarks" id="remarks" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_notice_to_proceed_add_remarks_val'])) { echo ''.$_SESSION['sys_notice_to_proceed_add_remarks_val'].''; } ?></textarea>
									</div>

									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/notice-to-proceed-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($notice_to_proceed_save_ntp); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <div class="modal fade" id="modal-print">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><?php echo renderLang($notice_to_proceed_print_form); ?></h4>
                </div>
                <form action="" method="post" class="ajax-form">
                    <input type="hidden" name="prospect_id" id="modal-prospect">
                    <input type="hidden" name="date" id="modal-date">
                    <input type="hidden" name="sender" id="modal-sender">
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="modal-address"><?php echo renderLang($notice_to_proceed_address); ?></label>
                                    <input type="text" class="form-control" name="address" id="modal-address">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message_body"><?php echo renderLang($notice_to_proceed_message_body); ?></label>
                                    <textarea name="message_body" id="message_body" rows="5" class="form-control notes"></textarea>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                        <button class="btn btn-primary btn-delete"><i class="fa fa-envelope mr-2"></i><?php echo renderLang($notice_to_proceed_send); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

			$('#date-notice-to-proceed').daterangepicker({
				singleDatePicker: true,
				locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            $('#print').on('click', function(e){
                e.preventDefault();

                var prospect_id = $('#prospect_id').val();
                var date = $('#date-notice-to-proceed').val();
                var sender = '<?php echo $_SESSION['sys_account_mode']; ?>-<?php echo $_SESSION['sys_id']; ?>';

                $('#modal-prospect').val(prospect_id);
                $('#modal-date').val(date);
                $('#modal-sender').val(sender);

                $('#modal-print').modal('show');

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