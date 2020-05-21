<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('fcu-monthly-inspection-add')) {

	$page = 'inspections';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspection_fcu_add); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($inspection_fcu_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<?php 
			renderError('sys_fcu_inspection_checklist_add_err'); 
			?>

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <form action="submit-add-fcu-inspection" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($inspection_fcu_monthly_inspection_form); ?></h3>
                            </div>
                            <div class="card-body">

                            	<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($inspection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date"><?php echo renderLang($inspection_sheet_date); ?></label>
                                            <input type="text" class="form-control date" name="date">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="model_no"><?php echo renderLang($inspection_fcu_model_number); ?></label>
                                            <input type="text" class="form-control" name="model_no">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="location_unit_no"><?php echo renderLang($inspection_location_unit_no); ?></label>
                                            <input type="text" class="form-control" name="location_unit_no">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="serial_no"><?php echo renderLang($inspection_serial_no); ?></label>
                                            <input type="text" class="form-control" name="serial_no">
                                        </div>
                                    </div>

                             	</div>
                             		
                             	<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="time_started"><?php echo renderLang($inspection_time_started); ?></label>
                                            <input type="time" class="form-control" name="time_started">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="time_finished"><?php echo renderLang($inspection_time_finished); ?></label>
                                            <input type="time" class="form-control" name="time_finished">
                                        </div>
                                    </div>

                                </div>

                                <br>

                                <div class="row">
                                	<div class="col-12">

                                		<div class="table-responsive">
                                			<table class="table table-bordered table-hover">
                                				<thead>
                                					<tr>
                                						<th class="text-center"><?php echo renderLang($inspection_scope_of_works); ?></th>
                                						<th class="w50pc text-center"><?php echo renderLang($inspection_remarks); ?></th>
                                					</tr>
                                				</thead>
                                				<tbody class="table-data">
                                					<?php foreach ($fcu_monthly_inspection_arr as $fcu_key => $fcu_value) {

                                						echo '<tr>';

                                						echo '<td><p>'.renderLang($fcu_value).'</p><input type="hidden" name="scope_of_works[]" value="'.$fcu_key.'"></td>';

                                						echo '<td><textarea type="text" class="form-control border-0 notes" name="remarks[]"></textarea></td>';

                                						echo '</tr>';

                                					 }?>
                                                     <tr class="default-row">
                                                         <td><textarea type="text" class="form-control border-0" name="scope_of_works[]"></textarea></td>
                                                         <td><textarea type="text" class="form-control border-0 notes" name="remarks[]"></textarea></td>
                                                     </tr>
                                				</tbody>
                                			</table>
                                            <div class="text-right">
                                            <button id="add-row" class="btn btn-primary" id="add-row"><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                		</div>
                                		
                                	</div>
                                </div>

                                <br>

                                <div class="row">

                                	<div class="col-12">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($inspection_recommendations); ?></label>
                                            <textarea type="text" class="form-control border-0 notes" name="recommendations"></textarea>
                                        </div>
                                    </div>
                                	
                                </div>

                                <div class="row">

                                	<div class="col-md-6">
                                        <div class="form-group">
                                            <label for="conducted_by"><?php echo renderLang($inspection_conducted_by); ?></label>
                                            <input type="text" class="form-control border-0" name="conducted_by" id="conducted_by">
                                            <p><span class="border-top"><?php echo renderLang($inspection_name_signature_of_technician); ?></span></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="acknowledged_by"><?php echo renderLang($inspection_acknowledged_by); ?></label>
                                            <input type="text" class="form-control border-0" name="acknowledged_by" id="acknowledged_by">
                                            <p><span class="border-top"><?php echo renderLang($inspection_clients_signature_date); ?></span></p>
                                        </div>
                                    </div>
                                	
                                </div>

                                <br>

                                <div class="row">

                                	<div class="col-md-6">
                                        <div class="form-group">
                                            <label for="noted_by"><?php echo renderLang($inspection_noted_by); ?></label>
                                            <input type="text" class="form-control border-0" name="noted_by" id="noted_by">
                                            <p><span class="border-top"><?php echo renderLang($inspection_name_signature_date); ?></span></p>
                                        </div>
                                    </div>
                                	
                                </div>

                            </div>
                            <div class="card-footer text-right">
								<a href="/fcu-monthly-inspection-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($inspection_save_inspection); ?></button>
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
		$(function(){

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

            $('#add-row').on('click', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('.default-row').html();

                $(this).closest('.table-responsive').find('.table-data').append('<tr>'+fields+'</tr>');

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