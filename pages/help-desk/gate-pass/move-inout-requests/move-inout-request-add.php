<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('move-inout-request-add')) {

		// set page
		$page = 'move-inout-requests';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($move_inout_requests_new_move_inout_request); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-ticket-alt mr-3"></i><?php echo renderLang($move_inout_requests_new_move_inout_request); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_move_inout_requests_add_err');
					?>
					
					<form method="post" action="/submit-add-move-inout-request" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($move_inout_requests_add_move_inout_request_form); ?></h3>
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

									<!-- REQUEST -->
									<div class="col-lg-3 col-md-4">
										<label for="request"><?php echo renderLang($move_inout_requests_request); ?></label>
										<select class="form-control select2 request" name="request" <?php if(isset($_SESSION['sys_move_inout_requests_add_request_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_request_val'].'"'; } ?>>
                                            <?php 
                                                foreach($move_inout_request_arr as $key => $value) {
                                                    echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                }
                                            ?>
                                        </select>
									</div>

									<!-- QUANTITY -->
									<div class="col-lg-3 col-md-4 mt-1 move">
										<label for="quantity"><?php echo renderLang($move_inout_requests_quantity); ?></label>
										<input type="number" class="form-control" min="0" name="quantity" <?php if(isset($_SESSION['sys_move_inout_requests_add_quantity_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_quantity_val'].'"'; } ?> >
									</div>
									
									<!-- PERSON / MATERIAL -->
									<div class="col-lg-3 col-md-4 mt-1 d-none gate_pass">
										<label for="person_material"><?php echo renderLang($move_inout_requests_person_material); ?></label>
										<input type="text" class="form-control" name="person_material" <?php if(isset($_SESSION['sys_move_inout_requests_add_person_material_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_person_material_val'].'"'; } ?> >
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
												<input type="text" class="form-control float-right" name="date" id="date"<?php if(isset($_SESSION['sys_move_inout_requests_add_date_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_date_val'].'"'; } ?> required>
											</div>
										</div>
									</div>

									<!-- unit -->
									<div class="col-lg-3 col-md-4">
										<label for="unit"><?php echo renderLang($move_inout_requests_unit); ?></label>
										<input type="text" class="form-control" name="unit" <?php if(isset($_SESSION['sys_move_inout_requests_add_unit_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_unit_val'].'"'; } ?> required>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- CERTIFICATE OF MANAGEMENT -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($move_inout_requests_certificate_of_management); ?></label>
										<input type="file" class="form-control" name="attachment[]" multiple>
										
									</div>

									<!-- REQUEST LETTER -->
									<div class="col-lg-3 col-md-4">
										<label for="attachment"><?php echo renderLang($move_inout_requests_request_letter); ?></label>
										<input type="file" class="form-control" name="attachment[]" multiple>
										
									</div>

									<!-- STATUS -->
									<div class="col-lg-3 col-md-4">
										<label for="status"><?php echo renderLang($move_inout_requests_status); ?></label>
										<select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_move_inout_requests_add_status_val'])) { echo ' value="'.$_SESSION['sys_move_inout_requests_add_status_val'].'"'; } ?>>
                    							<?php 
                                        			foreach($visitors_status_arr as $key => $value) {
                                            			echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                        			}
                                        		?>
                  							</select>
									</div>

								</div><!-- row -->

								<div class="row">

									<!-- REMARKS -->
									<div class="col-lg-6 col-md-12">
										<label for="remarks"><?php echo renderLang($move_inout_requests_remarks); ?></label>
										<textarea name="remarks" id="remarks" rows="3" class="form-control notes"></textarea>
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
                                                <tr class="default-row">
                                                    <td><input type="text" class="form-control border-0" name="item_no[]"></td>
                                                    <td><textarea name="description[]" rows="1" class="form-control notes border-0"></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button id="add-row" class="btn btn-primary" id="add-row"><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div>
									
								</div><!-- row -->
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/move-inout-requests" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($move_inout_requests_save_move_inout_request); ?></button>
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

			$('#date').daterangepicker({
				singleDatePicker: true,
				locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            $('#add-row').on('click', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('.default-row').html();

                $(this).closest('.table-responsive').find('.table-data').append('<tr>'+fields+'</tr>');

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