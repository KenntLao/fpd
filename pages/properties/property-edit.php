<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('property-edit')) {

		// set page
		$page = 'properties';

		// get id
		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT * FROM properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			if(!isset($_SESSION['sys_properties_edit_property_id_val'])) {
				$_SESSION['sys_properties_edit_property_id_val'] = $data['property_id'];
			}
			if(!isset($_SESSION['sys_properties_edit_property_code_val'])) {
				$_SESSION['sys_properties_edit_property_code_val'] = $data['property_code'];
			}
			if(!isset($_SESSION['sys_properties_edit_property_name_val'])) {
				$_SESSION['sys_properties_edit_property_name_val'] = $data['property_name'];
			}
			if(!isset($_SESSION['sys_properties_edit_client_id_val'])) {
				$_SESSION['sys_properties_edit_client_id_val'] = $data['client_id'];
			}
			if(!isset($_SESSION['sys_properties_edit_status_val'])) {
				$_SESSION['sys_properties_edit_status_val'] = $data['status'];
            }
            
            $cluster_id = $data['cluster_id'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($properties_edit_property); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/assets/css/users.css">
	
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
								<i class="far fa-building mr-3"></i>
								<?php echo renderLang($properties_edit_property); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php  echo $data['property_name']; ?>
							</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="/properties/"><?php echo renderLang($properties_properties); ?></a></li>
								<li class="breadcrumb-item"><a href="/property/<?php echo $id; ?>"><?php echo $data['property_name']; ?></a></li>
								<li class="breadcrumb-item active"><?php echo renderLang($properties_edit_property); ?></li>
							</ol>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_properties_edit_err');
					renderSuccess('sys_properties_edit_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-edit-property">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($properties_edit_property_form); ?></h3>
								<div class="card-tools">
									<a href="/property/<?php echo $id; ?>" class="btn btn-default mr-1"><i class="far fa-building mr-2"></i><?php echo renderlang($properties_view_property_profile); ?></a>
									<?php if(checkPermission('property-delete')) { ?>
									<button type="button" class="btn btn-danger btn-confirm-delete mr-1" data-toggle="modal" data-target="#modal-confirm-delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($properties_delete_property); ?></button>
									<?php } ?>
								</div>
							</div>
							<div class="card-body">

								<div class="row">

									<!-- PROPERTY ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_edit_property_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control input-readonly required<?php if($err) { echo ' is-invalid'; } ?>" id="property_id" name="property_id" placeholder="<?php echo renderLang($properties_property_id_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_edit_property_id_val'])) { echo ' value="'.$_SESSION['sys_properties_edit_property_id_val'].'"'; } ?> required readonly>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_edit_property_id_err'].'</p>'; unset($_SESSION['sys_properties_edit_property_id_err']); } ?>
										</div>
									</div>

									<!-- PROPERTY CODE -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_edit_property_code_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_code" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_code); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="property_code" name="property_code" placeholder="<?php echo renderLang($properties_property_code_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_edit_property_code_val'])) { echo ' value="'.$_SESSION['sys_properties_edit_property_code_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_edit_property_code_err'].'</p>'; unset($_SESSION['sys_properties_edit_property_code_err']); } ?>
										</div>
									</div>

									<!-- PROPERTY NAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_edit_property_name_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="property_name" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($properties_property_name); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="property_name" name="property_name" placeholder="<?php echo renderLang($properties_property_name_placeholder); ?>"<?php if(isset($_SESSION['sys_properties_edit_property_name_val'])) { echo ' value="'.$_SESSION['sys_properties_edit_property_name_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_edit_property_name_err'].'</p>'; unset($_SESSION['sys_properties_edit_property_name_err']); } ?>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="status" name="status" required>
												<?php
												foreach($status_arr as $status) {
													echo '<option value="'.$status[0].'"';
													if(isset($_SESSION['sys_properties_edit_status_val'])) {
														if($_SESSION['sys_properties_edit_status_val'] == $status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_edit_status_err'].'</p>'; unset($_SESSION['sys_properties_edit_status_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->
								
								<div class="row">

									<!-- CLIENT -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_properties_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="client_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($clients_client); ?></label>
											<select class="form-control<?php if($err) { echo ' is-invalid'; } ?>" id="client_id" name="client_id">
												<option value="0">TBD</option>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_properties_edit_client_id_val'])) {
													$select_val = $_SESSION['sys_properties_edit_client_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM clients WHERE temp_del = 0 ORDER BY client_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$data['client_name'].'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_properties_edit_client_id_err'].'</p>'; unset($_SESSION['sys_properties_edit_client_id_err']); } ?>
										</div>
									</div>

                                    <!-- CLUSTER -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="cluster"><?php echo renderLang($cluster).$data['cluster_id']; ?></label>
                                            <select name="cluster" id="cluster" class="form-control select2">
                                                <option <?php echo $cluster_id == 0 ? 'selected' : ''; ?> value="0">TBD</option>
                                                <?php 
                                                $sql1 = $pdo->prepare("SELECT * FROM clusters WHERE temp_del = 0");
                                                $sql1->execute();
                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option '.($cluster_id == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.$data1['cluster_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
								
								</div><!-- row -->

							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/properties" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($properties_update_property); ?></button>
							</div>
						</div><!-- card -->
					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->
	
	<!-- MODALS -->
	<!-- confirm delete -->
	<div class="modal fade" id="modal-confirm-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
				</div>
				<form action="/delete-property" method="post" id="form_delete">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="test" value="test">
					<div class="modal-body">
						<p><?php echo renderLang($properties_modal_delete_msg1); ?></p>
						<p><?php echo renderLang($properties_modal_delete_msg2); ?></p>
						<hr>
						<div class="form-group is-invalid">
							<label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
							<input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
						</div>
						<div class="modal-error alert alert-danger"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button type="button" class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script>
		$(function() {
			
			var form_data;
			
			// confirm delete
			$('.btn-delete').click(function() {
				form_data = $('#form_delete').serialize();
				$('#modal_confirm_delete_upass').val('');
				$('#form_delete').submit();
			});
			$('#form_delete').submit(function(e) {
				e.preventDefault();
				var post_url = $(this).attr("action");
				$.ajax({
					url: post_url,
					type: 'POST',
					data : form_data
				}).done(function(response){
					var response_arr = response.split(',');
					if(response_arr[0] == 1) { // val is 1
						window.location.href = '/properties';
					} else {
						$('.modal-error')
							.html(response_arr[1]) // val is error message
							.show();
					}
				});
			});
			
		});
	</script>
	
</body>

</html>
<?php
		} else { // ID not found

			// !NEED TRANSLATION
			$_SESSION['sys_properties_err'] = renderLang($properties_property_not_found);
			header('location: /properties');

		}
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>