<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collection-add')) {

  $page = 'collections';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collections_add_daily_collection); ?> &middot; <?php echo $sitename; ?></title>
	
  	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($daily_collections_add_daily_collection); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

		        <div class="container-fluid">

		        	<?php 
                    renderError('sys_daily_collection_add_err');
		        	?>

		        	<form action="/submit-add-daily-collection" method="post" enctype="multipart/form-data">

			        	<div class="card">
			        		<div class="card-header">
			        			<h3 class="card-title"><?php echo renderLang($daily_collections_add_daily_collection_form); ?></h3>
			        		</div>
			        		<div class="card-body">

								<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 required">
											    <?php 
                                                if($_SESSION['sys_account_mode'] == 'user') {

                                                    $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                    }

                                                } else {

                                                    $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                                                    $sub_properties = "0";
                                                    if(!empty($sub_property_ids)) {
                                                        $sub_properties = implode(", ", $sub_property_ids);
                                                    }

                                                    $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id IN ($sub_properties) AND p.temp_del = 0");
                                                    $sql->execute();
                                                    if($sql->rowCount()) {
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }
                                                    }

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

			        				<div class="col-lg-3 col-md-4">
                                        <?php $err = isset($_SESSION['sys_daily_collection_add_date_err']) ? 1 : 0; ?>
			        					<div class="form-group">
                                            <label for="date1" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($daily_collections_daily_collection_date); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <input type="text" name="collection_date" id="date1" class="form-control date required<?php echo $err ? ' is-invalid' : ''; ?>" <?php echo isset($_SESSION['sys_daily_collection_add_date_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_date_val'].'"' : ''; ?>>
                                            <?php 
                                            echo $err ? '<p class="error_message text-danger mt-1">'.$_SESSION['sys_daily_collection_add_date_err'].'</p>' : '';
                                            unset($_SESSION['sys_daily_collection_add_date_err']);
                                            ?>
			        					</div>
			        				</div>

			        			</div>
			        				
			        			<div class="row">

			        				<div class="col-lg-3 col-md-4">
			        					<div class="form-group">
                                            <label for="voucher_type"><?php echo renderLang($daily_collections_daily_collection_voucher_type); ?></label>
                                            <select class="form-control voucher_type select2" id="voucher_type" name="voucher_type" <?php echo isset($_SESSION['sys_daily_collection_add_voucher_type_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_voucher_type_val'].'"' : ''; ?>>
			        						<?php 
			        						foreach ($reference_number_arr as $key => $value) {
			        							echo '<option value="'.$key.'">'.renderLang($value).'</option>';
			        						}
			        						?>
                                            </select>
			        					</div>
			        				</div>

                                    <div class="col-lg-3 col-md-4 d-none or_no">
										<div class="form-group">
											<label for="or_number"><?php echo renderLang($daily_collections_daily_collection_or); ?></label>
											<input type="text" class="form-control" name="or_number" id="or_number">
										</div>
									</div>

									<div class="col-lg-3 col-md-4 ar_no">
										<div class="form-group">
											<label for="ar_number"><?php echo renderLang($daily_collections_daily_collection_ar); ?></label>
											<input type="text" class="form-control" name="ar_number" id="ar_number">
										</div>
									</div>

									<div class="col-lg-3 col-md-4 d-none pr_no">
										<div class="form-group">
											<label for="pr_number"><?php echo renderLang($daily_collections_daily_collection_pr); ?></label>
											<input type="text" class="form-control" name="pr_number" id="pr_number">
										</div>
									</div>

			        			</div>
			        			
                                <div class="row">
                                
                                	<div class="col-lg-6 col-md-8">
	                                	<div class="table-responsive">
											<table class="table table-bordered">
												<thead>
													<tr>
                                                        <th class="w200"><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
                                                        <th><?php echo renderlang($tenants_tenants); ?></th>
                                                        <th class="w35"></th>
													</tr>
												</thead>
												<tbody>
													<tr class="default-row3 d-none">
														<td class="p-0">
                                                            <select name="unit_id[]" class="form-control border-0 unit_options">

                                                            </select>
                                                        </td>
                                                        <td class="p-0">
                                                            <select name="tenant_id[]" class="form-control border-0 tenant_options">
                                                                <option value=""></option>
                                                            </select>
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
													</tr>
                                                    <tr>
                                                        <!-- units -->
														<td class="p-0">
                                                            <select name="unit_id[]" class="form-control border-0 unit_options">

                                                            </select>
                                                        </td>
                                                        <!-- tenants -->
                                                        <td class="p-0">
                                                            <select name="tenant_id[]" class="form-control border-0 tenant_options">
                                                            </select>
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
													</tr>
												</tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="3">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
												<thead>
													<tr>
														<th><?php echo renderLang($lang_others); ?></th>
                                                        <th class="w35"></th>
													</tr>
												</thead>
                                                <tbody>
                                                    <tr class="default-row3 d-none">
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="others[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="others[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="2">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
										<div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2"><?php echo renderLang($daily_collection_report_particulars); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="default-row3 d-none">
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="particulars[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="particulars[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="2">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
										</div>
									</div>

								</div><!-- row -->

			        			<br>

                                <div class="row">
                                	<div class="col-sm-12">
	                                	<div class="table-responsive">
											<table class="table">
												<tbody class="table-data">

                                                    <tr>
                                                        <!-- PAYMENT TYPE -->
					                                    <td>
								        					<div class="form-group">
					                                        <?php $err = isset($_SESSION['sys_daily_collection_add_payment_type_err']) ? 1 : 0; ?>
					                                        <label><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></label>
								        						<select class="form-control payment_type" id="payment_type" name="payment_type[]" <?php echo isset($_SESSION['sys_daily_collection_add_payment_type_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_payment_type_val'].'"' : ''; ?>>
								        								<option value=""></option>	
								        						<?php 
								        						foreach ($payment_types_arr as $key => $value) {
								        							echo '<option value="'.$key.'">'.renderLang($value).'</option>';
								        						}
								        						?>
					                                            </select>
					                                            <?php 
					                                            echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_daily_collection_add_payment_type_err'].'</p>' : '';
					                                            unset($_SESSION['sys_daily_collection_add_payment_type_err']);
					                                            ?>
								        					</div>
														</td>

														<!-- CHECK NUMBER -->
														<td class="d-none check_number">
															<label><?php echo renderLang($collections_check_voucher_check_number); ?></label>
															<input type="text" class="form-control" name="check_number[]" id="check_number">
														</td>

														<!-- CHECK of date -->
														<td class="d-none date_of_check">
															<label><?php echo renderLang($daily_collections_daily_collection_date_of_check); ?></label>
															<input type="text" name="date_of_check[]" class="form-control date">
														</td>
														
														<!-- BANK -->
														<td class="d-none bank">
															<label><?php echo renderLang($collections_check_voucher_bank); ?></label>
															<select name="bank[]" id="bank" class="form-control bank_name">
																<option value=""></option>
																<?php 
																foreach($banks_arr as $key => $bank) {
																	echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
																}
																?>
															</select>
														</td>

														<!-- OTHER BANK -->
														<td class="d-none other_bank">
														    <label><?php echo renderLang($collections_check_vouchers_other_bank); ?></label>
															<input type="text" class="form-control" name="other_bank[]" id="other_bank">
														</td>

														<!-- TRANSACTION DETAILS -->
														<td class="d-none transaction">
															<label><?php echo renderLang($daily_collections_daily_collection_transaction_details); ?></label>
															<input type="text" class="form-control" name="transaction_details[]">
														</td>

														<!-- AMOUNT -->
														<td>
								        					<div class="form-group">
								        						<label><?php echo renderLang($daily_collections_daily_collection_amount); ?></label>
					                                            <input type="text" class="form-control" data-type="currency" name="amount[]" <?php echo isset($_SESSION['sys_daily_collection_add_amount_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_amount_val'].'"' : ''; ?>>
								        					</div>
														</td>

                                                    </tr>
                                                    
													<tr class="default-row d-none">

					                                    <!-- PAYMENT TYPE -->
					                                    <td>
								        					<div class="form-group">
					                                        <?php $err = isset($_SESSION['sys_daily_collection_add_payment_type_err']) ? 1 : 0; ?>
					                                        <label><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></label>
								        						<select class="form-control payment_type" id="payment_type" name="payment_type[]" <?php echo isset($_SESSION['sys_daily_collection_add_payment_type_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_payment_type_val'].'"' : ''; ?>>
								        								<option value=""></option>
								        						<?php 
								        						foreach ($payment_types_arr as $key => $value) {
								        							echo '<option value="'.$key.'">'.renderLang($value).'</option>';
								        						}
								        						?>
					                                            </select>
					                                            <?php 
					                                            echo $err ? '<p class="error-message text-danger mt-1">'.$_SESSION['sys_daily_collection_add_payment_type_err'].'</p>' : '';
					                                            unset($_SESSION['sys_daily_collection_add_payment_type_err']);
					                                            ?>
								        					</div>
														</td>

														<!-- CHECK NUMBER -->
														<td class="d-none check_number">
															<label><?php echo renderLang($collections_check_voucher_check_number); ?></label>
															<input type="text" class="form-control" name="check_number[]" id="check_number">
														</td>

														<!-- CHECK of date -->
														<td class="d-none date_of_check">
															<label><?php echo renderLang($daily_collections_daily_collection_date_of_check); ?></label>
															<input type="text" name="date_of_check[]" class="form-control date">
														</td>
														
														<!-- BANK -->
														<td class="d-none bank">
															<label><?php echo renderLang($collections_check_voucher_bank); ?></label>
															<select name="bank[]" id="bank" class="form-control bank_name">
																<option value=""></option>
																<?php 
																foreach($banks_arr as $key => $bank) {
																	echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
																}
																?>
																<option value="999"><?php echo renderLang($lang_others); ?></option>
															</select>
														</td>

														<!-- OTHER BANK -->
														<td class="d-none other_bank">
														    <label><?php echo renderLang($collections_check_vouchers_other_bank); ?></label>
															<input type="text" class="form-control" name="other_bank[]" id="other_bank">
														</td>

														<!-- TRANSACTION DETAILS -->
														<td class="d-none transaction">
															<label><?php echo renderLang($daily_collections_daily_collection_transaction_details); ?></label>
															<input type="text" class="form-control" name="transaction_details[]">
														</td>

														<!-- AMOUNT -->
														<td>
								        					<div class="form-group">
								        						<label><?php echo renderLang($daily_collections_daily_collection_amount); ?></label>
					                                            <input type="text" class="form-control" data-type="currency" name="amount[]" <?php echo isset($_SESSION['sys_daily_collection_add_amount_val']) ? 'value="'.$_SESSION['sys_daily_collection_add_amount_val'].'"' : ''; ?>>
								        					</div>
														</td>

													</tr>

												</tbody>
											</table>
											<div class="text-right mb-3">
		                                        <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
		                                    </div>
										</div>
									</div>

								</div><!-- row -->

			        			<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for=""><?php echo renderLang($daily_collections_daily_collection_or_ar_pr_attachment); ?></label>
											<input type="file" class="form-control" name="attachment[]" multiple>
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for=""><?php echo renderLang($daily_collections_daily_collection_deposit_payment_slip); ?></label>
											<input type="file" class="form-control" name="attachment2[]" multiple>
										</div>
									</div>

			        			</div><!-- row -->
			        			
			        		</div>
			        		<div class="card-footer text-right">
			        			<a href="/daily-collections/1" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
			        			<button class="btn btn-primary"><?php echo renderLang($daily_collections_add_daily_collection); ?></button>
			        		</div>
			        	</div>

		        	</form>

		        </div>

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

            // tenant options
            $('body').on('change', '.unit_options', function(){
                $this = $(this);
                var unit_id = $(this).val();

                $.post("/render-collection-tenants", {
                    unit_id:unit_id
                }, function(data) {
                    $this.closest('tr').find('.tenant_options').html('<option value=""></option>'+data);
                });

            });

            // add row other unit
            $('body').on('click', '.add-row3', function(e){
                e.preventDefault();

                var fields = $(this).closest('table').find('.default-row3').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');

            });

            var building_id = $('#sub_property_id').val();
            var unit_options;

            $.post('/daily-collection-unit-options', {
                id:building_id
            }, function(data){
               unit_options = '<option></option>'+data;

            }).done(function(){

                $('.unit_options').each(function(){
                    $(this).html(unit_options);
                });

            });

            // remove row
            $('body').on('click', '.remove-row', function(e){
                e.preventDefault();

                $(this).closest('tr').remove();

            });

            $('#sub_property_id').on('change', function(){

                building_id = $(this).val();

                $.post('/daily-collection-unit-options', {
                    id:building_id
                }, function(data){
                    unit_options = data;
                }).done(function(){

                    $('.unit_options').each(function(){
                        $(this).html(unit_options);
                    });

                });

            });

			$('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

			// show specify field if othes is selected
	        $('body').on('change', '.bank_name', function(){

	            var bank_name = $(this).val();

	            if(bank_name == '999') {
	                $(this).closest('tr').find('.other_bank').removeClass('d-none');
	            }
	            else {
	                $(this).closest('tr').find('.other_bank').addClass('d-none');
	            }

	        });

			// show specify field if othes is selected
	        $('body').on('change', '.payment_type', function(){

	            var payment_type = $(this).val();

	            if(payment_type == 2) {
	                $(this).closest('tr').find('.check_number').removeClass('d-none');
	                $(this).closest('tr').find('.date_of_check').removeClass('d-none');
	            }
	            else {
	                $(this).closest('tr').find('.check_number').addClass('d-none');
	                $(this).closest('tr').find('.date_of_check').addClass('d-none');
	            }
	            if(payment_type == 2 || payment_type == 1) {
	                $(this).closest('tr').find('.bank').removeClass('d-none');
	            }
	            else {
	                $(this).closest('tr').find('.bank').addClass('d-none');
	            }
	            if(payment_type == 1 || payment_type == 3 || payment_type == 4) {
	                $(this).closest('tr').find('.transaction').removeClass('d-none');
	            }
	            else {
	                $(this).closest('tr').find('.transaction').addClass('d-none');
	            }

	        });

	        // show specify field if othes is selected
	        $('.voucher_type').on('change', function(){

	            var voucher_type = $(this).val();

	            if(voucher_type == 1) {
	                $('.ar_no').removeClass('d-none');
	            }
	            else {
	                $('.ar_no').addClass('d-none');
	            }

	            if(voucher_type == 2) {
	                $('.or_no').removeClass('d-none');
	            }
	            else {
	                $('.or_no').addClass('d-none');
	            }

	            if(voucher_type == 3) {
	                $('.pr_no').removeClass('d-none');
	            }
	            else {
	                $('.pr_no').addClass('d-none');
	            }

	        });

	        $('.add-row').on('click', function(e){
                e.preventDefault();

                var fields2 = '<tr>'+$('.default-row').html()+'</tr>';
                $('.table-data').append(fields2);

                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
		                locale: {
		                    format: 'YYYY-MM-DD'
		                }
                    });
                });

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