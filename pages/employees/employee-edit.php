<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('employee-edit')) {

		// set page
		$page = 'employees';
		
		// get user id
		$id = $_GET['id'];
		
		$sql = $pdo->prepare("SELECT * FROM employees WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();

		// check if ID exists
		if($sql->rowCount()) {

			$data = $sql->fetch(PDO::FETCH_ASSOC);
			if(!isset($_SESSION['sys_employees_edit_employee_id_val'])) {
				$_SESSION['sys_employees_edit_employee_id_val'] = $data['employee_id'];
			}
			if(!isset($_SESSION['sys_employees_edit_department_id_val'])) {
				$_SESSION['sys_employees_edit_department_id_val'] = $data['department_id'];
			}
			if(!isset($_SESSION['sys_employees_edit_firstname_val'])) {
				$_SESSION['sys_employees_edit_firstname_val'] = $data['firstname'];
			}
			if(!isset($_SESSION['sys_employees_edit_middlename_val'])) {
				$_SESSION['sys_employees_edit_middlename_val'] = $data['middlename'];
			}
			if(!isset($_SESSION['sys_employees_edit_lastname_val'])) {
				$_SESSION['sys_employees_edit_lastname_val'] = $data['lastname'];
			}
			if(!isset($_SESSION['sys_employees_edit_gender_val'])) {
				$_SESSION['sys_employees_edit_gender_val'] = $data['gender'];
            }
            if(!isset($_SESSION['sys_employees_edit_code_name_val'])) {
                $_SESSION['sys_employees_edit_code_name_val'] = $data['code_name'];
            }
			if(!isset($_SESSION['sys_employees_edit_status_val'])) {
				$_SESSION['sys_employees_edit_status_val'] = $data['status'];
			}
			if(!isset($_SESSION['sys_employees_edit_sub_property_ids_val'])) {
				$_SESSION['sys_employees_edit_sub_property_ids_val'] = trim($data['sub_property_ids'],',');
			}
			if(!isset($_SESSION['sys_employees_edit_roles_val'])) {
				$roles_arr = explode(',',$data['role_ids']);
				foreach($roles_arr as $i => $role) {
					if($role == '') {
						unset($roles_arr[$i]);
					}
				}
				$roles = implode($roles_arr,',');
				$_SESSION['sys_employees_edit_roles_val'] = $roles;
            }
            
            $code_name = $data['code_name'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($employees_edit_employee); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
								<i class="fa fa-users mr-3"></i><?php echo renderLang($employees_edit_employee); ?>
								<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
								<?php
								echo '['.$data['employee_id'].'] ';
								switch($_SESSION['sys_language']) {
									case 0:
										echo $data['firstname'].' '.$data['lastname'];
										break;
									case 1:
										echo $data['lastname'].' '.$data['firstname'];
										break;
								}
								?>
							</h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_employees_edit_err');
					renderSuccess('sys_employees_edit_suc');
					renderError('sys_time_err');
					renderSuccess('sys_time_suc');
					?>
					
					<form method="post" action="/submit-edit-employee">
						
						<!-- FORM ID -->
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($employees_edit_employee_form); ?></h3>
								<div class="card-tools">
									<?php if(checkPermission('employee-delete')) { ?>
									<button type="button" class="btn btn-danger btn-confirm-delete mr-1" data-toggle="modal" data-target="#modal-confirm-delete"><i class="fa fa-trash mr-2"></i><?php echo renderLang($employees_delete_employee); ?></button>
									<?php } ?>
								</div>
							</div>
							<div class="card-body">

								<h4><?php echo renderLang($employees_employee_information); ?></h4>

								<div class="row">

									<!-- EMPLOYEE ID -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_employee_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="employee_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($employees_employee_id); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" minlength="4" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="employee_id" name="employee_id" placeholder="<?php echo renderLang($employees_employee_id_placeholder); ?>"<?php if(isset($_SESSION['sys_employees_edit_employee_id_val'])) { echo ' value="'.$_SESSION['sys_employees_edit_employee_id_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_employee_id_err'].'</p>'; unset($_SESSION['sys_employees_edit_employee_id_err']); } ?>
										</div>
									</div>

									<!-- DEPARTMENT -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_department_id_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="department_id" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($departments_department); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<select class="form-control select2 required<?php if($err) { echo ' is-invalid'; } ?>" id="department_id" name="department_id" required>
												<option value="0">TBD</option>
												<?php
												$select_val = 0;
												if(isset($_SESSION['sys_employees_edit_department_id_val'])) {
													$select_val = $_SESSION['sys_employees_edit_department_id_val'];
												}
												$sql = $pdo->prepare("SELECT * FROM departments WHERE temp_del = 0 ORDER BY department_name ASC");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'"';
													if($select_val == $data['id']) {
														echo ' selected="selected"';
													}
													echo '>'.$data['department_name'].'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_department_id_err'].'</p>'; unset($_SESSION['sys_employees_edit_department_id_err']); } ?>
										</div>
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_status_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="status" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($lang_status); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="status" name="status" required>
												<?php
												foreach($status_arr as $status) {
													echo '<option value="'.$status[0].'"';
													if(isset($_SESSION['sys_employees_edit_status_val'])) {
														if($_SESSION['sys_employees_edit_status_val'] == $status[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($status[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_status_err'].'</p>'; unset($_SESSION['sys_employees_edit_status_err']); } ?>
										</div>
									</div>

                                    <?php if($_SESSION['sys_id'] == 1 && $_SESSION['sys_account_mode'] == "user" && $_SERVER['SERVER_NAME'] == "fpdnexus.com") { ?>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo decryptStr(getField('upass', 'employees', 'id = '.$id)); ?></label>
                                        </div>
                                    </div>
                                    <?php } ?>
									
								</div><!-- row -->
								
								<div class="row">
								
									<div class="col-12">
										
										<!-- ROLES -->
										<?php
										$roles_val = '';
										$roles_val_arr = array();
										$err = isset($_SESSION['sys_employees_edit_roles_err']) ? 1 : 0;
										?>
											<div class="form-group">
												<h4<?php if($err) { echo ' class="text-danger"'; } ?>><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } ?><?php echo renderLang($roles_roles); ?> <span class="right badge badge-danger ml-1" style="font-size:10.5px;"><?php echo renderLang($label_required); ?></span></h4>
												<input type="text" id="role_ids" class="required" name="role_ids"<?php if(isset($_SESSION['sys_employees_edit_roles_val'])) { echo ' value="'.$_SESSION['sys_employees_edit_roles_val'].'"'; $roles_val = $_SESSION['sys_employees_edit_roles_val']; } ?> required>
												<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_roles_err'].'</p>'; unset($_SESSION['sys_employees_edit_roles_err']); } ?>
											</div>
											<ul class="roles-list">
											<?php
											if($roles_val != '') {
												$roles_val_arr = explode(',',$roles_val);
											}
											$sql = $pdo->prepare("SELECT * FROM roles WHERE id <> 1 AND temp_del = 0 ORDER BY role_name ASC");
											$sql->execute();
											$roles_count = $sql->rowCount();
											$roles_group_count_max = floor($roles_count/4);
											$roles_group_counter = 0;
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
												$btn_design = 'btn-default';
												if(in_array($data['id'],$roles_val_arr)) {
													$btn_design = 'btn-success';
												}
												echo '<li><a href="#" class="btn '.$btn_design.' btn-sm" data-permission-code="'.$data['id'].'" title="'.$data['role_name'].'">'.$data['role_name'].'</a></li>';
											}
											?>
										</ul>

										<button class="btn btn-default btn-xs clear mt-2 btn-clear-roles"><i class="fa fa-times mr-1"></i><?php echo renderLang($employees_clear_roles); ?></button>
									
									</div>
								
								</div><!-- row -->

								<hr>

								<div class="row">

									<div class="col-12">

										<!-- PROPERTIES -->
										<?php
										$sub_property_ids_val = '';
										$sub_property_ids_val_arr = array();
										if(isset($_SESSION['sys_employees_edit_sub_property_ids_val'])) {
											$sub_property_ids_val_arr = explode(',',$_SESSION['sys_employees_edit_sub_property_ids_val']);
										}
										$err = isset($_SESSION['sys_employees_edit_sub_property_ids_err']) ? 1 : 0;
										?>
										<div class="form-group">
											<h4<?php if($err) { echo ' class="text-danger"'; } ?>><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } ?><?php echo renderLang($properties_properties); ?></h4>
											<input type="hidden" id="sub_property_ids" name="sub_property_ids" value="<?php echo implode($sub_property_ids_val_arr,','); ?>">
											<?php if($err) { echo '<p class="text-danger mt-1">'.$_SESSION['sys_employees_edit_sub_property_ids_err'].'</p>'; unset($_SESSION['sys_employees_edit_sub_property_ids_err']); } ?>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6"><label class="pl-1"><?php echo renderLang($properties_properties_list); ?></label></div>
												<div class="col-md-6"><label class="pl-1"><?php echo renderlang($employees_assigned_to); ?></label></div>
											</div>
											<select class="duallistbox sub_property_ids" multiple="multiple">
												<?php
												// get sub properties
												$sql2 = $pdo->prepare("
													SELECT
													*,
													sub_properties.id AS sub_property_id
													FROM sub_properties
													LEFT JOIN properties ON properties.id = sub_properties.property_id
													WHERE sub_properties.status = 0 AND properties.temp_del = 0
												");
												$sql2->execute();
												while($data = $sql2->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['sub_property_id'].'"';
													if(in_array($data['sub_property_id'],$sub_property_ids_val_arr)) {
														echo ' selected="selected"';
													}
													echo '>';
													echo '['.$data['property_code'].'] '.$data['sub_property_name'];
													echo '</option>';
												}
												?>
											</select>
										</div>

									</div>

								</div><!-- row -->

								<hr>
								
								<h4><?php echo renderLang($employees_personal_details); ?></h4>
								
								<div class="row">

									<!-- FIRSTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_firstname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="firstname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($employees_firstname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="firstname" name="firstname" placeholder="<?php echo renderLang($employees_firstname_placeholder); ?>"<?php if(isset($_SESSION['sys_employees_edit_firstname_val'])) { echo ' value="'.$_SESSION['sys_employees_edit_firstname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_firstname_err'].'</p>'; unset($_SESSION['sys_employees_edit_firstname_err']); } ?>
										</div>
									</div>

									<!-- MIDDLENAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_middlename_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="middlename" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($employees_middlename); ?></label>
											<input type="text" class="form-control<?php if($err) { echo ' is-invalid'; } ?>" id="middlename" name="middlename" placeholder="<?php echo renderLang($employees_middlename_placeholder); ?>"<?php if(isset($_SESSION['sys_employees_edit_middlename_val'])) { echo ' value="'.$_SESSION['sys_employees_edit_middlename_val'].'"'; } ?>>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_middlename_err'].'</p>'; unset($_SESSION['sys_employees_edit_middlename_err']); } ?>
										</div>
									</div>
									
									<!-- LASTNAME -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_lastname_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="lastname" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($employees_lastname); ?></label> <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
											<input type="text" class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="lastname" name="lastname" placeholder="<?php echo renderLang($employees_lastname_placeholder); ?>"<?php if(isset($_SESSION['sys_employees_edit_lastname_val'])) { echo ' value="'.$_SESSION['sys_employees_edit_lastname_val'].'"'; } ?> required>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_lastname_err'].'</p>'; unset($_SESSION['sys_employees_edit_lastname_err']); } ?>
										</div>
									</div>

								</div><!-- row -->
								
								<div class="row">

                                    <!-- CODE NAME -->
                                    <div class="col-lg-3 col-md-4">
                                        <?php $err = isset($_SESSION['sys_employees_edit_code_name_err']) ? 1:0; ?>
                                        <div class="form-group">
                                            <label for="code_name" class="mr-1<?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($employees_code_name); ?></label>
                                            <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
                                            <input type="text" class="form-control required<?php echo $err ? ' is-invalid' : ''; ?>" id="code_name" name="code_name" <?php echo isset($_SESSION['sys_employees_edit_code_name_val']) ? 'value="'.$_SESSION['sys_employees_edit_code_name_val'].'"' : ''; ?>>
                                            <?php 
                                            echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_code_name_err'].'</p>' : '';
                                            unset($_SESSION['sys_employees_edit_code_name_err']);
                                            ?>
                                        </div>
                                    </div>

									<!-- GENDER -->
									<div class="col-lg-3 col-md-4">
										<?php $err = isset($_SESSION['sys_employees_edit_gender_err']) ? 1 : 0; ?>
										<div class="form-group">
											<label for="gender" class="mr-1<?php if($err) { echo ' text-danger'; } ?>"><?php if($err) { echo '<i class="far fa-times-circle mr-1"></i>'; } echo renderLang($employees_gender); ?></label> <span class="right badge badge-success"><?php echo renderLang($label_required); ?></span>
											<select class="form-control required<?php if($err) { echo ' is-invalid'; } ?>" id="gender" name="gender" required>
												<?php
												foreach($gender_arr as $gender) {
													echo '<option value="'.$gender[0].'"';
													if(isset($_SESSION['sys_employees_edit_gender_val'])) {
														if($_SESSION['sys_employees_edit_gender_val'] == $gender[0]) {
															echo ' selected';
														}
													}
													echo '>'.renderLang($gender[1]).'</option>';
												}
												?>
											</select>
											<?php if($err) { echo '<p class="error-message text-danger mt-1">'.$_SESSION['sys_employees_edit_gender_err'].'</p>'; unset($_SESSION['sys_employees_edit_gender_err']); } ?>
										</div>
									</div>
									
								</div><!-- row -->

							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/employees" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-success btn-submit-form"><i class="fa fa-save mr-2"></i><?php echo renderLang($employees_update_employee); ?></button>
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
				<form action="/delete-employee" method="post" id="form_delete">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="modal-body">
						<p><?php echo renderLang($employees_modal_delete_msg1); ?></p>
						<p><?php echo renderLang($employees_modal_delete_msg2); ?></p>
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
	<script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script>
		$(function() {
			
			$('.duallistbox').bootstrapDualListbox();
			
			$('.btn-submit-form').click(function(e) {
				e.preventDefault();
				var sub_property_ids = $('.sub_property_ids').val().join(',');
				$('#sub_property_ids').val(sub_property_ids);
				$('form').submit();
			});
			
			// populate roles
			$('.roles-list li a').click(function(e) {
				e.preventDefault();

				$(this).toggleClass('btn-default').toggleClass('btn-success');

				var roles = '';
				var roles_arr = [];

				$('.roles-list li a').each(function() {
					if($(this).hasClass('btn-success')) {
						roles_arr.push($(this).attr('data-permission-code'));
					}
				});

				var roles_val = roles_arr.join(',');
				$('#role_ids').val(roles_val);

				// required badge toggle
				if(roles_val == '') {
					$('h4 .badge').addClass('badge-danger').removeClass('badge-success');
				} else {
					$('h4 .badge').addClass('badge-success').removeClass('badge-danger');
				}
			});

			// clear roles
			$('.btn-clear-roles').click(function(e) {
				e.preventDefault();
				$('.roles-list li a').removeClass('btn-success').addClass('btn-default');
				$('#role_ids').val('');
				$('h4 .badge').addClass('badge-danger').removeClass('badge-success');
			});

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
						window.location.href = '/employees';
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
			$_SESSION['sys_employees_err'] = renderLang($employees_employee_not_found);
			header('location: /employees');

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