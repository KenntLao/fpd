<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('visitor-add')) {

		// set page
		$page = 'visitors';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($visitors_new_visitor); ?> &middot; <?php echo $sitename; ?></title>
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($visitors_new_visitor); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_visitors_add_err');
					?>
					
					<form method="post" action="/submit-add-visitor">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($visitors_add_visitor_form); ?></h3>
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

                                    <!-- DATE -->
                                    <div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($lang_date); ?></label>
											<input type="text" class="form-control input-readonly" readonly value="<?php echo formatDate(time(), true, false); ?>">
										</div>
									</div>
									
									<!-- TIME IN -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_in"><?php echo renderLang($visitors_time_in); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="text" class="form-control float-right input-readonly" name="time_in" id="time_in" value="<?php echo $curr_time; ?>" required readonly>
											</div>
										</div>
									</div>

									<!-- TIME OUT -->
									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="time_out"><?php echo renderLang($visitors_time_out); ?></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-clock"></i>
													</span>
												</div>
												<input type="time" class="form-control float-right" name="time_out" id="time_out"<?php if(isset($_SESSION['sys_visitors_add_time_out_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_time_out_val'].'"'; } ?>>
											</div>
										</div>
									</div>

									<!-- NAME OF VISITORS -->
									<div class="col-lg-3 col-md-4">
										<label for="name_of_visitor"><?php echo renderLang($visitors_name_of_visitor); ?></label>
										<input type="text" class="form-control" name="name_of_visitor" <?php if(isset($_SESSION['sys_visitors_add_name_of_visitor_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_name_of_visitor_val'].'"'; } ?> required>
									</div>

									<!-- COMPANY / ADDRESS -->
									<div class="col-lg-3 col-md-4">
										<label for="company_address"><?php echo renderLang($visitors_company_address); ?></label>
										<input type="text" class="form-control" name="company_address" <?php if(isset($_SESSION['sys_visitors_add_company_address_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_company_address_val'].'"'; } ?> required>
									</div>

									<!-- PERSON TO VISIT -->
									<div class="col-lg-3 col-md-4">
										<label for="person_to_visit"><?php echo renderLang($visitors_person_to_visit); ?></label>
										<input type="text" class="form-control" name="person_to_visit" <?php if(isset($_SESSION['sys_visitors_add_person_to_visit_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_person_to_visit_val'].'"'; } ?> required>
									</div>

									<!-- PURPOSE -->
									<div class="col-lg-3 col-md-4">
										<label for="purpose"><?php echo renderLang($visitors_purpose); ?></label>
										<select class="form-control select2 purpose" name="purpose" <?php if(isset($_SESSION['sys_visitors_add_purpose_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_purpose_val'].'"'; } ?>>
                                            <?php 
                                                foreach($visitor_purpose_arr as $key => $value) {
                                                    echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div>

									<!-- PURPOSE OTHERS -->
									<div class="col-lg-3 col-md-4 others d-none">
										<div class="form-group">
											<label for="purpose_others" >Specify Others</label> <span></span>
											<input type="text" min="0" class="form-control" id="purpose_others" name="purpose_others" placeholder="" >
										</div>
									</div>

                                    <?php if(checkPermission('visitor-approve')) { ?>
									<!-- STATUS -->
									<!-- <div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($visitors_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_visitors_add_status_val'])) { echo ' value="'.$_SESSION['sys_visitors_add_status_val'].'"'; } ?>>
                                            <?php 
                                                foreach($visitors_status_arr as $key => $value) {
                                                    echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div> -->
                                    <?php } ?>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/visitors" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($visitors_save_visitor); ?></button>
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
	<script>
		$(function() {

			 // show specify field if othes is selected
	        $('.purpose').on('change', function(){

	            var val = $(this).val();

	            if(val == 'Others' ) {
	                $('.others').removeClass('d-none');
	            }
	            else {
	                $('.others').addClass('d-none');
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