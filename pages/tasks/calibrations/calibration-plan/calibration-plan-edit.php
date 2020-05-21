<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibration-plan-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'calibration-plans';

        $id = $_GET['id'];

        // suggested client ID
        $sql = $pdo->prepare("SELECT c.id, s.sub_property_name, c.status, s.property_id, sub_property_id, prepared_by, approved_by, date_created FROM calibrations c LEFT JOIN sub_properties s ON (c.sub_property_id = s.id) WHERE c.temp_del = 0 AND c.category = 'Plan' AND c.id = :id ORDER BY date_created ASC");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        
        $err = 0;
    
        // full name
        $current_user_full_name = getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']);
        $status = $_data['status'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calibration_new_calibration_plan); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($calibration_new_calibration_plan); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_calibration_plan_edit_err');
                    ?>

                    <form method="post" action="/submit-calibration-plan-edit">

                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($calibration_new_calibration_plan_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($inspection_building); ?></label>
                                            <?php  $property_name = getField('property_name','properties','id ='.$_data['property_id']);; ?>
                                            <input type="text" class="form-control input-readonly" name="sub_property_id" value="<?php echo $_data['sub_property_name'].' ['.$property_name.']'; ?>" readonly> 
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($calibration_instrument); ?></th>
                                                        <th><?php echo renderLang($calibration_brand); ?></th>
                                                        <th><?php echo renderLang($calibration_serial_no); ?></th>
                                                        <th><?php echo renderLang($calibration_date_calibrated); ?></th>
                                                        <th><?php echo renderLang($calibration_due_date_of_calibration); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $sql = $pdo->prepare("SELECT * FROM calibration_plan WHERE calibration_id = :id");
                                                        $sql->bindParam(":id", $id);
                                                        $sql->execute();
                                                        if ($sql->rowCount()) {
                                                            while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                echo '<tr>';

                                                                echo '<td>';
                                                                echo '<select name="instrument[]" id="" class="form-control border-0">';
                                                                echo '<option value=""></option>';
                                                                foreach($calibration_category_and_equipment_arr as $key => $equipment) {
                                                                    echo '<option '.($data['instrument'] == renderLang($equipment['equipment']) ? 'selected' : '').' value="'.renderLang($equipment['equipment']).'">'.renderLang($equipment['equipment']).'</option>';
                                                                }
                                                                echo '</select>';
                                                                echo '</td>';
                                                                echo '<td><input type="text" class="form-control border-0" name="brand[]" value="'.$data['brand'].'"></td>';
                                                                echo '<td><input type="text" class="form-control border-0" name="serial_number[]" value="'.$data['serial_number'].'"></td>';
                                                                echo '<td><input type="text" class="form-control border-0 date" name="date_calibrated[]" value="'.$data['date_calibrated'].'"></td>';
                                                                echo '<td><input type="text" class="form-control border-0 date" name="due_date_calibration[]" value="'.$data['due_date_calibration'].'"></td>';
                                                                echo '<input type="hidden" name="plan_id[]" value="'.$data['id'].'">';

                                                                echo '</tr>';

                                                            }
                                                         } 
                                                    ?>
                                                    <?php if ($status == 0) { ?>
                                                    <tr class="default-row">
                                                        <td>
                                                            <select name="instrument[]" id="" class="form-control border-0">
                                                                <option value=""></option>
                                                                <?php 
                                                                foreach($calibration_category_and_equipment_arr as $key => $equipment) {
                                                                    echo '<option value="'.renderLang($equipment['equipment']).'">'.renderLang($equipment['equipment']).'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control border-0" name="brand[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="serial_number[]"></td>
                                                        <td><input type="text" class="form-control border-0 date" name="date_calibrated[]"></td>
                                                        <td><input type="text" class="form-control border-0 date" name="due_date_calibration[]"></td>
                                                        <input type="hidden" name="plan_id[]" value="0">
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <?php if ($status == 0) { ?>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-right">
                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                        
                                </div>

                                <div class="row">
                                                            
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="prepared_by"><?php echo renderLang($calibration_prepared_by); ?></label>
                                            <input type="text" class="form-control input-readonly" name="prepared_by" id="prepared_by" value="<?php echo $current_user_full_name; ?>" readonly>
                                            <p class="mt-2"><?php echo renderLang($calibration_engineering_services_division); ?></p>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="approved_by"><?php //echo renderLang($calibration_approved_by); ?></label>
                                            <input type="text" class="form-control" name="approved_by">
                                            <p class="mt2"><?php //echo renderLang($calibration_engineering_services_division); ?></p>
                                        </div>
                                    </div>
                                    -->

                                </div>
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

                            </div>
                            <div class="card-footer text-right">
                                <a href="/calibration-plans" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <?php if ($status == 0) { ?>
                                <button class="btn btn-success" id="save-button"><i class="fa fa-save mr-2"></i><?php echo renderLang($lang_save_as_draft); ?></button>
                                <?php } ?>
                            </div>
                        </div>

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
    $(function(){

        $('.date').each(function(e){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        // Add row
        $('body').on('click', '.add-row', function(e){
            e.preventDefault();

            var fields = $(this).closest('table').find('.default-row').html();
            fields = '<tr>'+fields+'</tr>';
            $(this).closest('table').find('tbody').append(fields);
            
            $('.select').each(function(){
                if($(this).hasClass('select2-hidden-accessible')) {
                    console.log('yes');
                } else {
                    console.log('no');
                    $(this).select2();
                }
                
            });

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