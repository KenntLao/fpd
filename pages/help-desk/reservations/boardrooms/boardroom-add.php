<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('boardroom-add')) {

		// set page
		$page = 'boardrooms';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($boardrooms_new_reservation); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="far fa-calendar-minus mr-3"></i><?php echo renderLang($boardrooms_new_reservation); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					?>
					
					<form method="post" action="/submit-add-boardroom">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($boardrooms_new_reservation_form); ?></h3>
							</div>
							<div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 ">
                                                <?php 
                                                if($_SESSION['sys_account_mode'] == 'user') {

                                                    $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                    }

                                                } else {

                                                    $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                                    foreach($sub_property_ids as $sub_property_id) {

                                                        $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                        $sql->bindParam(":id", $sub_property_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                            echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }

                                                    }

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

								<div class="row">

									<!-- DATE ACQUISITION -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="acquisition_date"><?php echo renderLang($boardrooms_date); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right" name="date_reserve" id="date_reserve"<?php if(isset($_SESSION['sys_contract_add_acquisition_date_reserve_val'])) { echo ' value="'.$_SESSION['sys_contract_add_boardroom_date_reserve_val'].'"'; } ?> required>
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
												<input type="time" class="form-control float-right" name="time_from" id="time_from"<?php if(isset($_SESSION['sys_boardroom_add_time_from_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_time_from_val'].'"'; } ?>>
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
												<input type="time" class="form-control float-right" name="time_to" id="time_to"<?php if(isset($_SESSION['sys_boardroom_add_time_to_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_time_to_val'].'"'; } ?>>
											</div>
										</div>
									</div>
					

									
								</div><!-- row -->

								<div class="row">

									<!-- department -->
									<div class="col-lg-3 col-md-4">
										<label for="department"><?php echo renderLang($boardrooms_department); ?></label>
										<input type="text" class="form-control" name="department" <?php if(isset($_SESSION['sys_boardroom_add_department_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_department_val'].'"'; } ?>>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($boardrooms_purpose); ?></label>
										<input type="text" class="form-control" name="purpose" <?php if(isset($_SESSION['sys_boardroom_add_purpose_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_purpose_val'].'"'; } ?> >
									</div>

									<!-- RESERVED BY -->
									<div class="col-lg-3 col-md-4">
										<label for="reserved_by"><?php echo renderLang($boardrooms_reserved_by); ?></label>
										<input type="text" class="form-control" name="reserved_by" <?php if(isset($_SESSION['sys_boardroom_add_reserved_by_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_reserved_by_val'].'"'; } ?> >
									</div>

									
									
								</div><!-- row -->

								<div class="row">

									<!-- ROOM -->
									<div class="col-lg-3 col-md-4">
										<label for="room"><?php echo renderLang($boardrooms_room); ?></label>
										<select class="form-control select2" id="room" name="room" <?php if(isset($_SESSION['sys_boardroom_add_room_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_room_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($boardroom_number_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>
									
									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($visitors_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_boardroom_add_status_val'])) { echo ' value="'.$_SESSION['sys_boardroom_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($visitors_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>

								</div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/boardrooms" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-upload mr-2"></i><?php echo renderLang($boardrooms_save_reservation); ?></button>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function() {

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