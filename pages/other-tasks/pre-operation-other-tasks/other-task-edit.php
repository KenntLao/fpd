<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-other-task-edit')) {

		// set page
		$page = 'pre-operation-other-tasks';

		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT ot.attachment, ot.incharges, ot.id, ot.title, ot.status, d.department_name, d.department_code FROM other_tasks ot LEFT JOIN departments d ON ot.department_id = d.id WHERE ot.temp_del = 0 AND ot.id = :id LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {

        	$_data = $sql->fetch(PDO::FETCH_ASSOC);

    	} else {

	        $_SESSION['sys_ot_other_task_err'] = 'no id';
	        header('location: /pre-operation-other-tasks');
	        exit();

    	}

	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($op_other_task_edit_other_task); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
							<h1><i class="fas fa-th mr-3"></i><?php echo renderLang($op_other_task_edit_other_task); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_amenities_add_suc');
					?>
					
					<form method="post" action="/submit-edit-pre-operation-other-task" enctype="multipart/form-data">

						<input type="hidden" name="id" value="<?php echo $_data['id']; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($op_other_task_edit_other_task_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('pre-operation-other-task-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($op_other_task_delete_other_task); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- SERVICE REQUIRED -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="department_id" ><?php echo renderLang($downpayment_project); ?></label>
											<input type="text" class="form-control input-readonly" id="department_id" name="department_id" value="[<?php echo $_data['department_code'].'] '.$_data['department_name']; ?>" readonly>
										</div>
									</div>

									<!-- TITLE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="title"><?php echo renderLang($po_other_task_title); ?></label>
											<input type="text" class="form-control" id="title" name="title" value="<?php echo $_data['title']; ?>">
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="status"><?php echo renderLang($po_other_task_status); ?></label>
											<select name="status" id="status" class="form-control">
                                               <?php 
                                                    foreach($other_task_status_arr as $key => $status) {
                                                        echo '<option '.($_data['status'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                                    }
                                                ?>
                                            </select>
										</div>
									</div>
									
								</div><!-- row -->

								<div class="row">
                                    
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="row">
												<div class="col-md-6"><label class="pl-1"><?php echo renderLang($po_other_task_employee_list); ?></label></div>
												<div class="col-md-6"><label class="pl-1"><?php echo renderlang($po_other_task_incharge); ?></label></div>
											</div>
                                            <select name="incharges[]" id="incharges[]" class="duallistbox" multiple>
                                                <?php 
                                                $employee_ids = explode(',', $_data['incharges']);

                                                $sql = $pdo->prepare("SELECT * FROM employees WHERE temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    $full_name = $data['firstname'].' '.$_data['lastname'];
                                                    echo '<option '.(in_array($data['id'], $employee_ids) ? 'selected' : '').' value="'.$data['id'].'">'.$full_name.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
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

                                                            
                                                                echo '<a href="/assets/uploads/other-task/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/other-task/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/other-task/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/other-task/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/other-task/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/other-task/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>

                                </div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/pre-operation-other-tasks" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($po_other_task_update); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('pre-operation-other-task-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-pre-operation-other-task" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($op_other_task_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($op_other_task_modal_delete_msg2); ?></p>
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
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {

			$('#timeline').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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
                            window.location.href = '/pre-operation-other-tasks';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

            $('.duallistbox').bootstrapDualListbox();
			
			$('.btn-submit-form').click(function(e) {
				e.preventDefault();
				var employee_ids = $('.employee_ids').val().join(',');
				$('#employee_ids').val(employee_ids);
				$('form').submit();
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