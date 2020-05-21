<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibration-monitoring-add')) {

		// set page
		$page = 'calibration';

		// full name
        $current_user_full_name = getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']);
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calibration_new_calibration); ?> &middot; <?php echo $sitename; ?></title>

	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

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
							<h1><i class="fas fa-tachometer-alt mr-3"></i><?php echo renderLang($calibration_new_calibration); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<form method="post" action="/submit-add-calibration">

						<input type="hidden" name="calibration_category" value="Monitoring">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($calibration_form); ?></h3>
							</div>
							<div class="card-body">

								<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($inspection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                            <?php
                                            if ($_SESSION['sys_account_mode'] == 'user') { // user - superadmin

	                                            $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0");
	                                            $sql->execute();
	                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
	                                            }

                                            } else { // employees

                                            	$cluster_ids = getClusterIDs($_SESSION['sys_id']);

                                            	// no cluster
                                            	if(empty($cluster_ids)) {

                                            		$property_ids = getField('property_ids','employees','id = '.$_SESSION['sys_id']);
                                            		$properties = explode(',',$property_ids);
                                            		foreach ($properties as $property_id) {

                                            			$sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name, sp.property_id FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.property_id = :property_id");
                                            			$sql->bindParam(':property_id',$property_id);
			                                            $sql->execute();
			                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
			                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
			                                            }

                                            		}
                                            	} else { // has cluster

                                            		foreach ($cluster_ids as $cluster_id) {
                                            			$property_ids =  array();

                                            			//get properties under cluster
                                            			$property_ids = getClusterProperties($cluster_id);

                                            			foreach ($property_ids as $property_id) {

                                            				$sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name, sp.property_id FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.property_id = :property_id");
	                                            			$sql->bindParam(':property_id',$property_id);
				                                            $sql->execute();
				                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
				                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
				                                            }

                                            			}
                                            		}

                                            	}

                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

								<div class="row">

                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white collapsed" type="button"  data-toggle="collapse" data-target="#tab-inventory" aria-expanded="true" aria-controls="collapseExample"><?php echo renderLang($calibration_equipment_calibration_monitoring); ?></button>
                                        </p>
                                        <div class="collapse show" id="tab-inventory">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($calibration_equipment_calibration_monitoring); ?></h3>
                                                </div>
                                                <div class="card-body">
                                                                
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th><?php echo renderLang($calibration_category); ?></th>
                                                                                <th><?php echo renderLang($calibration_equipment); ?></th>
                                                                                <th><?php echo renderLang($calibration_brand); ?></th>
                                                                                <th><?php echo renderLang($calibration_serial_no); ?></th>
                                                                                <th><?php echo renderLang($calibration_date_calibrated); ?></th>
                                                                                <th><?php echo renderLang($calibration_frequency); ?></th>
                                                                                <th><?php echo renderLang($calibration_accepted_tolerance); ?></th>
                                                                                <th><?php echo renderLang($calibration_next_calibration_date); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        	<?php foreach ($calibration_category_and_equipment_arr as $category_and_equipment_key => $category_and_equipment) { 

                                                                        		echo '<tr>';
                                                                        		echo '<td><p>'.renderLang($category_and_equipment['category']).'</p><input type="hidden" name="category[]" value="'.renderLang($category_and_equipment['category']).'"></td>';
                                                                        		echo '<td><p>'.renderLang($category_and_equipment['equipment']).'</p><input type="hidden" name="equipment[]" value="'.renderLang($category_and_equipment['equipment']).'"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0" name="brand[]" placeholder="'.renderLang($calibration_brand).'"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0" name="serial_number[]" placeholder="'.renderLang($calibration_serial_no).'"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0 date" name="date_calibrated[]"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0" name="frequency[]" value="Every 2 Years"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0" name="accepted_tolerance[]" value="+/-5%"></td>';
                                                                        		echo '<td><input type="text" class="form-control border-0 date" name="next_calibration_date[]"></td>';
                                                                        		echo '</tr>';

                                                                        	}?>
                                                                        	<tr class="default-row">
                                                                        		<td><input type="text" class="form-control border-0" name="category[]" placeholder="<?php echo renderLang($calibration_category); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="equipment[]" placeholder="<?php echo renderLang($calibration_equipment); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="brand[]" placeholder="<?php echo renderLang($calibration_brand); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="serial_number[]" placeholder="<?php echo renderLang($calibration_serial_no); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0 date" name="date_calibrated[]"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="frequency[]" value="Every 2 Years"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="accepted_tolerance[]" value="+/-5%"></td>
                                                                        		<td><input type="text" class="form-control border-0 date" name="next_calibration_date[]"></td>
                                                                        	</tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>       

                                                </div>
                                            </div>

                                        </div>
                                    </div>
									
								</div><!-- row -->

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<label for="prepared_by"><?php echo renderLang($calibration_prepared_by); ?></label>
										<input type="text" class="form-control certify-border border-bottom" name="prepared_by" value="<?php echo $current_user_full_name; ?>">
										<p><?php echo renderLang($calibration_operations_manager); ?></p>
										<p><?php echo renderLang($calibration_engineering_services_division); ?></p>
									</div>
									
								</div><!-- row -->

								<br>

								<!-- <div class="row">

									<div class="col-lg-3 col-md-4">
										<label for="approved_by"><?php //echo renderLang($calibration_approved_by); ?></label>
										<input type="text" class="form-control certify-border border-bottom" name="approved_by">
										<p><?php //echo renderLang($calibration_director); ?></p>
										<p><?php //echo renderLang($calibration_engineering_services_division); ?></p>
									</div>
									
								</div> -->

								<!-- Status -->
                                <div class="row mt-2">
                                    <div class="col-12 text-right">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="save-status" name="status" value="0">
                                            <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/calibration-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<button class="btn btn-primary" id="save-button"><i class="fa fa-plus mr-2"></i><?php echo renderLang($calibration_save_calibration); ?></button>
							</div>
						</div><!-- card -->

					</form>


				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function(){
            
            $('.date').each(function(e){

                $(this).daterangepicker({
                    singleDatePicker: true,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
               	});

            });

	        // add row pictures
            $('body').on('click', '.add-row', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('.table-responsive').find('.default-row').html()+'</tr>';
                $(this).closest('.table-responsive').find('tbody').append(fields);

                $('.date').each(function(e){
		            $(this).daterangepicker({
		                singleDatePicker: true,
		                locale: {
		                    format: 'YYYY-MM-DD'
		                }
		            });
		        });

            });

            // change save status 
	        $('#save-status').on('change', function(){

	            if($(this).is(':checked')) {
	                $(this).val('1');
	                $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
	                $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_for_submission); ?>');

	            } else {
	                $(this).val('0');
	                $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
	                $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
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