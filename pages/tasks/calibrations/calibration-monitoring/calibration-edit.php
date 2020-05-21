<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibration-monitoring-edit')) {

		// set page
		$page = 'calibration';

		$id = $_GET['id'];

		// suggested client ID
        $sql = $pdo->prepare("SELECT c.id, s.sub_property_name, c.status, s.property_id, sub_property_id, prepared_by, approved_by, date_created FROM calibrations c LEFT JOIN sub_properties s ON (c.sub_property_id = s.id) WHERE c.temp_del = 0 AND c.category = 'Monitoring' AND c.id = :id ORDER BY date_created ASC");
        $sql->bindParam(":id", $id);
		$sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;

        $status = $_data['status'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calibration_edit_calibration); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-tachometer-alt mr-3"></i><?php echo renderLang($calibration_edit_calibration); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderError('sys_calibration_monitoring_edit_err');
					?>
					
					<form method="post" action="/submit-edit-calibration-monitoring">

						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?php echo renderLang($calibration_edit_calibration_monitoring_form); ?></h3>
								<div class="card-tools">
                                    <?php if(checkPermission('mail-log-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($calibration_delete_calibration); ?></a><?php } ?>
                                </div>
							</div>
							<div class="card-body">

								<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($inspection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                            <?php
                                            if ($_SESSION['sys_account_mode'] == 'user') { // user - superadmin

	                                            $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0");
	                                            $sql->execute();
	                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
	                                                echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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
			                                                echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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
				                                                echo '<option '.($_data['property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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
                                                                        	<?php 

                                                                        		$sql = $pdo->prepare("SELECT * FROM calibration_monitoring WHERE calibration_id = :calibration_id");
						                                                       	$sql->bindParam(":calibration_id", $id);
			                                                       				$sql->execute();
			                                                       				if($sql->rowCount()) {
	                                                       							while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

	                                                                        		echo '<tr>';
	                                                                        		echo '<td><p>'.$data['category'].'</p><input type="hidden" name="category[]" value="'.$data['category'].'"></td>';
	                                                                        		echo '<td><p>'.$data['equipment'].'</p><input type="hidden" name="equipment[]" value="'.$data['equipment'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0" name="brand[]" value="'.$data['brand'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0" name="serial_number[]" value="'.$data['serial_number'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0 date" name="date_calibrated[]" value="'.$data['date_calibrated'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0" name="frequency[]" value="'.$data['frequency'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0" name="accepted_tolerance[]" value="'.$data['accepted_tolerance'].'"></td>';
	                                                                        		echo '<td><input type="text" class="form-control border-0 date" name="next_calibration_date[]" value="'.$data['next_calibration_date'].'"></td>';
	                                                                        		echo '</tr>';
	                                                                        		echo '<input type="hidden" name="monitoring_id[]" value="'.$data['id'].'">';
		                                                                        	}
		                                                                        }?>
		                                                                     <?php if ($status == 0) { ?>
                                                                        	<tr class="default-row">
                                                                        		<td><input type="text" class="form-control border-0" name="category[]" placeholder="<?php echo renderLang($calibration_category); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="equipment[]" placeholder="<?php echo renderLang($calibration_equipment); ?>"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="brand[]"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="serial_number[]"></td>
                                                                        		<td><input type="text" class="form-control border-0 date" name="date_calibrated[]"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="frequency[]" value="Every 2 Years"></td>
                                                                        		<td><input type="text" class="form-control border-0" name="accepted_tolerance[]" value="+/-5%"></td>
                                                                        		<td><input type="text" class="form-control border-0 date" name="next_calibration_date[]"></td>
                                                                        		<input type="hidden" name="monitoring_id[]" value="0">
                                                                        	</tr>
                                                                        	<?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                    <?php if ($status == 0) { ?>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                    <?php } ?>
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
										<input type="text" class="form-control certify-border border-bottom input-readonly" name="prepared_by" value="<?php echo $_data['prepared_by']; ?>" readonly>
										<p><?php echo renderLang($calibration_operations_manager); ?></p>
										<p><?php echo renderLang($calibration_engineering_services_division); ?></p>
									</div>
									
								</div><!-- row -->

								<br>

								<!--<div class="row">

									<div class="col-lg-3 col-md-4">
										<label for="approved_by"><?php //echo renderLang($calibration_approved_by); ?></label>
										<input type="text" class="form-control certify-border border-bottom" name="approved_by" value="<?php //echo $_data['approved_by']; ?>">
										<p><?php //echo renderLang($calibration_director); ?></p>
										<p><?php //echo renderLang($calibration_engineering_services_division); ?></p>
									</div>
									
								</div> -->

								<?php if ($status == 0) { ?>
                                <!-- Status -->
                                <div class="row mt-2">
                                    <div class="col-12 text-right">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="save-status" name="status" value="<?php echo $_data['status']; ?>">
                                            <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
								
							</div><!-- card-body -->
							<div class="card-footer text-right">
								<a href="/calibration-list" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
								<?php if ($status == 0) { ?>
								<button class="btn btn-success" id="save-button"><i class="fa fa-save mr-2"></i><?php echo renderLang($calibration_save_calibration); ?></button>
								<?php } ?>
							</div>
						</div><!-- card -->

					</form>
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<!-- confirm delete -->
        <?php if(checkPermission('mail-log-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-mail-log" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($mail_logs_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($mail_logs_modal_delete_msg2); ?></p>
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
                            window.location.href = '/mail-logs';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('.date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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
                $('#save-button').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_for_submission); ?>');

            } else {
                $(this).val('0');
                $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                $('#save-button').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
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