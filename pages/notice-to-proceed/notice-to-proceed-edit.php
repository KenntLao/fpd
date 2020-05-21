<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('notice-to-proceed-edit')) {

		// set page
        $page = 'notice-to-proceed';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT ntp.id, project_name, ntp.date, ntp.status, ntp.remarks, reference_number, ntp.attachment, prospect_id FROM notice_to_proceed ntp LEFT JOIN prospecting p ON(ntp.prospect_id = p.id) WHERE ntp.temp_del = 0 AND ntp.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($notice_to_proceed_edit_ntp); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1>
                                <i class="fas fa-file-signature mr-3"></i><?php echo renderLang($notice_to_proceed_edit_ntp); ?>
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
                    renderError('sys_notice_to_proceed_edit_err');
                    renderSuccess('sys_notice_to_proceed_edit_suc');
                    ?>

                    <form action="/submit-edit-notice-to-proceed" method="post" enctype="multipart/form-data">
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($notice_to_proceed_edit_ntp_form); ?></h3>
                                <div class="card-tools">
                                    <?php if ($_data['status'] == 1) { ?>
                                    <?php if(checkPermission('notice-to-proceed-add')) { ?><a href="/edit-nni/<?php echo $_data['prospect_id']; ?>" class="btn btn-primary btn-md"><i class="fa fa-plus mr-1"></i><?php echo renderLang($create_nni); ?></a><?php } ?>
                                    <?php } ?>
                                    <?php if(checkPermission('notice-to-proceed-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($notice_to_proceed_delete_ntp); ?></a><?php } ?>
                                </div>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="row">
                                    
                                    <!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id" ><?php echo renderLang($notice_to_proceed_project_name); ?></label>
                                            <input type="text" class="form-control input-readonly" value="<?php echo '['.$_data['reference_number'].'] '.$_data['project_name']; ?>" readonly>
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
                                                <input type="text" class="form-control float-right" name="date" id="date-notice-to-proceed" required value="<?php echo formatDate($_data['date']); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STATUS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="status"><?php echo renderLang($notice_to_proceed_status); ?></label>
                                            <select class="form-control" id="status" name="status" <?php if(isset($_SESSION['sys_notice_to_proceed_add_status_val'])) { echo ' value="'.$_SESSION['sys_notice_to_proceed_add_status_val'].'"'; } ?>>
                                                <?php 
                                                    foreach($notice_to_proceed_status_arr as $key => $value) {
                                                        echo '<option '.($_data['status'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                    }
                                                ?>
                                            </select>	
                                        </div>
                                    </div>

                                </div><!-- row -->

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

                                                            
                                                                echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/notice-to-proceeds/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/notice-to-proceeds/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>

                                </div><!-- row -->

                                <div class="row">

                                    <!-- REMARKS -->
                                    <div class="col-lg-6 col-md-12">
                                        <label for="remarks"><?php echo renderLang($notice_to_proceed_remarks); ?></label>
                                        <textarea name="remarks" id="remarks" rows="3" class="form-control notes"><?php echo $_data['remarks']; ?></textarea>
                                    </div>

                                    
                                </div><!-- row -->

                            </div>
                            <div class="card-footer text-right">
                                <a href="/notice-to-proceed-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($notice_to_proceed_update_ntp); ?></button>
                            </div>
                        </div> 

                    </form>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

        <!-- confirm delete -->
        <?php if(checkPermission('notice-to-proceed-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-notice-to-proceed" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($notice_to_proceed_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($notice_to_proceed_modal_delete_msg2); ?></p>
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
                            window.location.href = '/notice-to-proceed-list';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('#date-notice-to-proceed').daterangepicker({
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