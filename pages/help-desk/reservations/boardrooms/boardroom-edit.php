<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('boardroom-edit')) {

		// set page
		$page = 'boardrooms';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT * FROM boardrooms WHERE id = :id LIMIT 1");
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
	<title><?php echo renderLang($boardrooms_edit_boardroom); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($boardrooms_edit_boardroom); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $_data['department']; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					?>
					
					<form method="post" action="/submit-edit-boardroom">

						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($boardrooms_edit_boardroom_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('boardroom-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($boardrooms_delete_boardroom); ?></a><?php } ?>
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

									<!-- DATE ACQUISITION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date_reserve"><?php echo renderLang($boardrooms_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date_reserve" id="date_reserve"<?php if(isset($_SESSION['sys_boardroom_edit_date_reserve_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_date_reserve_val'].'"'; } else { echo 'value="'.$_data['date_reserve'].'"'; } ?> required>
											</div>
										</div>
									</div>

									<!-- TIME FROM -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_from"><?php echo renderLang($boardrooms_time_from); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right datetimepicker-input"  name="time_from" id="time_from"<?php if(isset($_SESSION['sys_boardroom_edit_time_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_time_from_val'].'"'; } else { echo 'value="'.$_data['time_from'].'"'; } ?>>
											</div>
										</div>
									</div>

									<!-- TIME TO -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_to"><?php echo renderLang($boardrooms_time_to); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right datetimepicker-input"  name="time_to" id="time_to"<?php if(isset($_SESSION['sys_boardroom_edit_time_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_time_to_val'].'"'; } else { echo 'value="'.$_data['time_to'].'"'; } ?>>
											</div>
										</div>
									</div>

									
								</div><!-- row -->

								<div class="row">


									<!-- ROOM -->
									<div class="col-lg-3 col-md-4">
										<label for="room"><?php echo renderLang($boardrooms_room); ?></label>
										<select class="form-control select2" id="room" name="room" <?php if(isset($_SESSION['sys_boardroom_add_room_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_room_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($boardroom_number_arr as $key => $value) {
                                            			echo '<option '.($_data['room'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>
					
									<!-- department -->
									<div class="col-lg-3 col-md-4">
										<label for="department"><?php echo renderLang($boardrooms_department); ?></label>
										<input type="text" class="form-control" name="department" <?php if(isset($_SESSION['sys_boardroom_edit_department_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_department_val'].'"'; } else { echo 'value="'.$_data['department'].'"'; } ?>>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($boardrooms_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" <?php if(isset($_SESSION['sys_boardroom_edit_purpose_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_purpose_val'].'"'; } else { echo 'value="'.$_data['purpose'].'"'; } ?> >
									</div>

								</div>
									
								<div class="row">

									<!-- RESERVED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="reserved_by"><?php echo renderLang($boardrooms_reserved_by); ?></label>
										<input type="text" class="form-control" name="reserved_by" <?php if(isset($_SESSION['sys_boardroom_edit_reserved_by_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_reserved_by_val'].'"'; } else { echo 'value="'.$_data['reserved_by'].'"'; } ?> >
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($visitors_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_boardroom_edit_status_val'])) { echo ' value="'.$_SESSION['sys_boardroom_edit_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($visitors_status_arr as $key => $value) {
                                            			echo '<option '.($_data['status'] == $key? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/boardrooms" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($boardrooms_update_boardroom); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('boardroom-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-boardroom" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($boardrooms_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($boardrooms_modal_delete_msg2); ?></p>
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
                            window.location.href = '/boardrooms';
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

			$('#date_reserve').daterangepicker({
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