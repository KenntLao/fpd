<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('contract-edit')) {

		// set page
		$page = 'contract';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM contract WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;

        $mode_of_payment = explode(',', $_data['mode_of_payment']);

        $reference_number = getField('reference_number', 'prospecting', 'id = '.$_data['prospect_id']);
        $project_name = getField('project_name', 'prospecting', 'id = '.$_data['prospect_id']);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($contract_edit_contract); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($contract_edit_contract); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $project_name; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_clients_add_client_err');
					renderSuccess('sys_clients_add_client_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-edit-contract" enctype="multipart/form-data">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($contract_edit_contract_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('contract-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($contract_delete_contract); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id" ><?php echo renderLang($contract_project_name); ?></label>
                                            <input type="text" class="form-control input-readonly" value="<?php echo '['.$reference_number.'] '.$project_name; ?>" readonly>
                                        </div>
                                    </div>

									<!-- DATE ACQUISITION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="acquisition_date"><?php echo renderLang($contract_date_acquisition); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="acquisition_date" id="acquisition_date"<?php if(isset($_SESSION['sys_contract_edit_acquisition_date_val'])) { echo ' value="'.$_SESSION['sys_contract_edit_acquisition_date_val'].'"'; } else { echo 'value="'.formatDate($_data['acquisition_date']).'"'; } ?>>
											</div>
										</div>
									</div>

									<!-- RENEWAL DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="renewal_date"><?php echo renderLang($contract_renewal_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="renewal_date" id="renewal_date"<?php if(isset($_SESSION['sys_contract_edit_renewal_date_val'])) { echo ' value="'.$_SESSION['sys_contract_edit_renewal_date_val'].'"'; } else { echo 'value="'.formatDate($_data['renewal_date']).'"'; } ?>>
											</div>
										</div>
									</div>
									
								</div><!-- row -->

								<div class="row">

									<!-- TERMS OF PAYMENTS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="term"><?php echo renderLang($contract_terms_of_payment); ?></label>
                                            <select name="term" id="term" class="form-control">
                                            <?php 
                                            foreach($contract_terms_arr as $key => $terms) {
                                                echo '<option '.($_data['term_of_payment'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($terms).'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ADVANCE PAYMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="advance"><?php echo renderLang($contract_advance_payment); ?></label>
                                            <input type="text" data-type="currency" class="form-control" name="advance" id="advance" value="<?php echo $_data['advance_payment']; ?>">
                                        </div>
                                    </div>

                                    <!-- NUMBER OF MONTHS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="number_of_month"><?php echo renderLang($contract_number_of_month); ?></label>
                                            <input type="number" class="form-control" name="number_of_month" id="number_of_month" value="<?php echo $_data['number_of_month']; ?>">
                                        </div>
                                    </div>
									
								</div><!-- row -->

                                <div class="row">

                                    <!-- STATUS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="status"><?php echo renderLang($contract_status); ?></label>
                                            <select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_contract_edit_status_val'])) { echo ' value="'.$_SESSION['sys_contract_edit_status_val'].'"'; } ?>>
                                                <?php 
                                                    foreach($contract_status_arr as $key => $value) {
                                                        echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                    }
                                                ?>
                                            </select>   
                                        </div>
                                    </div>

                                    <!-- SECURITY DEPOSIT -->
                                    <div class="col-lg-3 col-md-4">
                                        <label for="amount"><?php echo renderLang($contract_security_deposit); ?></label>
                                        <input type="text" class="form-control" name="security_deposit" value="<?php echo $_data['security_deposit']; ?>" required>
                                    </div>


                                    <!-- AMOUNT -->
                                    <div class="col-lg-3 col-md-4">
                                        <label for="amount"><?php echo renderLang($contract_amount_php); ?></label>
                                        <input type="text" data-type="currency" class="form-control" name="amount" value="<?php echo $_data['amount']; ?>" placeholder="<?php echo renderLang($downpayment_amount_placeholder); ?>" required>
                                    </div>
                                    
                                </div>

								<div class="row">

                                    <!-- ATTACHMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="attachment"><?php echo renderLang($contract_attachment); ?></label><br>
                                            <?php 
                                            if(!empty($_data['attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($_data['attachment'], ',')) {

                                                    $attachments = explode(',', $_data['attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/contracts/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/contracts/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/contracts/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/contracts/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/contracts/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>

                                    <!-- MODE OF PAYMENT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label><?php echo renderLang($contract_mode_of_payment); ?> :</label>
                                            <div class="custom-control custom-checkbox">
                                                <input name="mode_of_payment[]" class="custom-control-input" type="checkbox" id="customCheckbox1" value="<?php echo $contract_cheque[0]; ?>" <?php echo in_array($contract_cheque[0], $mode_of_payment) ? 'checked' : '' ?>>
                                                <label for="customCheckbox1" class="custom-control-label">
                                                    <?php echo renderLang($contract_cheque); ?>
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input name="mode_of_payment[]" class="custom-control-input" type="checkbox" id="customCheckbox2" value="<?php echo $contract_cash[0]; ?>" <?php echo in_array($contract_cash[0], $mode_of_payment) ? 'checked' : '' ?>>
                                                <label for="customCheckbox2" class="custom-control-label">
                                                    <?php echo renderLang($contract_cash);?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/contract-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($contract_update_contract); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('contract-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-contract" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($contract_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($contract_modal_delete_msg2); ?></p>
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
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script>
		$(function() {

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

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
                            window.location.href = '/contract-list';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('#acquisition_date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});
			
		});
	</script>
	<script>
		$(function() {

			$('#renewal_date').daterangepicker({
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