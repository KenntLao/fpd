<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('move-inout-request-edit')) {

		// set page
		$page = 'move-inout-requests';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM move_inout_requests WHERE id = :id LIMIT 1");
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
	<title><?php echo renderLang($move_inout_requests_edit_move_inout_request); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_requests_edit_move_inout_request); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['unit']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_move_inout_requests_edit_err');
					?>
					
					<form method="post" action="/submit-edit-move-inout-request" enctype="multipart/form-data">

						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($move_inout_requests_edit_move_inout_request_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('move-inout-request-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($move_inout_requests_delete_move_inout_request); ?></a><?php } ?>
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

									<!-- REQUEST -->
									<div class="col-lg-3 col-md-4">
										<label for="request"><?php echo renderLang($move_inout_requests_request); ?></label>
										<select class="form-control select2 request" name="request" <?php if(isset($_SESSION['sys_move_inout_requests_edit_request_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_request_val'].'"'; } else { echo 'value="'.$_data['request'].'"'; } ?>>
                                            <?php 
                                                foreach($move_inout_request_arr as $key => $value) {
                                                    echo '<option '.($_data['request'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div>

									<!-- QUANTITY -->
									<div class="col-lg-3 col-md-4 mt-1 <?php if($_data['request'] == 2 || $_data['request'] == 3 ){ echo 'd-none'; } ?> move">
										<label for="quantity"><?php echo renderLang($move_inout_requests_quantity); ?></label>
										<input type="number" class="form-control" min="0" name="quantity" <?php if(isset($_SESSION['sys_move_inout_requests_edit_quantity_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_quantity_val'].'"'; } else { echo 'value="'.$_data['quantity'].'"'; } ?>>
									</div>

									<!-- PERSON / MATERIAL -->
									<div class="col-lg-3 col-md-4 mt-1 <?php if($_data['request'] == 1 || $_data['request'] == 0 ){ echo 'd-none'; } ?> gate_pass">
										<label for="quantity"><?php echo renderLang($move_inout_requests_person_material); ?></label>
										<input type="text" class="form-control" name="person_material" <?php if(isset($_SESSION['sys_move_inout_requests_edit_person_material_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_person_material_val'].'"'; } else { echo 'value="'.$_data['person_material'].'"'; } ?>>
									</div>
									
									<!-- DATE -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($move_inout_requests_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date" id="date"<?php if(isset($_SESSION['sys_move_inout_requests_edit_date_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_date_val'].'"'; } else { echo 'value="'.$_data['date'].'"'; } ?>>
											</div>
										</div>
									</div>

									<!-- unit -->
									<div class="col-lg-3 col-md-4">
										<label for="unit"><?php echo renderLang($move_inout_requests_unit); ?></label>
										<input type="text" class="form-control" name="unit" <?php if(isset($_SESSION['sys_move_inout_requests_edit_unit_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_unit_val'].'"'; } else { echo 'value="'.$_data['unit'].'"'; } ?>>
									</div>
									
								</div><!-- row -->

								<div class="row">

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

                                                            
                                                                echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/move-inout-requests/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $_data['attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $_data['attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/move-inout-requests/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control mt-1" name="attachment[]" multiple>
                                        </div>
                                    </div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($move_inout_requests_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_move_inout_requests_edit_status_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_edit_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($move_inout_request_status_arr as $key => $value) {
                                            			echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- REMARKS -->
									<div class="col-lg-6 col-md-12">
										<label for="remarks"><?php echo renderLang($move_inout_requests_remarks); ?></label>
										<textarea name="remarks" id="remarks" rows="3" class="form-control notes"><?php if(isset($_SESSION['sys_move_inout_requests_edit_remarks_val'])) { echo ''.$_SESSION['sys_move_inout_requests_edit_remarks_val'].''; } else { echo ''.$_data['remarks'].''; } ?></textarea>
									</div>


									
								</div><!-- row -->

								<div class="row mt-3">

                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($move_inout_requests_item_no); ?></th>
                                                    <th><?php echo renderLang($move_inout_requests_description); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-data">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM move_inout_request_item WHERE move_inout_id = :id");
                                                $sql->bindParam(":id", $id);
                                                $sql->execute();
                                                $last_code = '';
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';

                                                    echo '<td><input type="text" class="form-control border-0" name="item_no[]" value="'.$data['item_no'].'"></td>';

                                                    echo '<td><textarea name="description[]" rows="1" class="form-control notes border-0">'.$data['item_description'].'</textarea></td>';
                                                    echo '<input type="hidden" name="code[]" value="'.$data['code'].'">';

                                                    echo '</tr>';
                                                    $last_code = $data['code'];
                                                }
                                                ?>
                                            </tbody>
                                                <tr class="default-row d-none" data-code="<?php echo $last_code; ?>">
                                                    <td><input type="text" class="form-control border-0" name="item_no[]"></td>
                                                    <td><textarea name="description[]" rows="1" class="form-control notes border-0"></textarea></td>
                                                </tr>
                                        </table>
                                        <div class="text-right">
                                            <button class="btn btn-primary add-row"><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/move-inout-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($move_inout_requests_update_move_inout_request); ?></button>
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
                    <form action="/delete-move-inout-request" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($move_inout_requests_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($move_inout_requests_modal_delete_msg2); ?></p>
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
                            window.location.href = '/move-inout-requests';
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

            var code = $('.default-row').data('code');
            $('.add-row').on('click', function(e){
                e.preventDefault();

                code++;

                var fields = '<tr>'+$('.default-row').html()+'<input type="hidden" name="code[]" value="'+code+'"></tr>';
                $('.table-data').append(fields);

            });

             // show specify field if othes is selected
	        $('.request').on('change', function(){

	            var val = $(this).val();

	            if(val == 0 || val == 1) {
	                $('.move').removeClass('d-none');
	            }
	            else {
	                $('.move').addClass('d-none');
	            }


	            if(val == 2 || val == 3) {
	                $('.gate_pass').removeClass('d-none');
	            }
	            else {
	                $('.gate_pass').addClass('d-none');
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