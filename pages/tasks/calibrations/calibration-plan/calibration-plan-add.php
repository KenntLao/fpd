<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calibration-plan-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'calibration-plans';
    
        // full name
        $current_user_full_name = getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']);
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

                    <form method="post" action="/submit-calibration-plan-add">

                        <input type="hidden" name="calibration_category" value="Plan">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($calibration_new_calibration_plan_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($inspection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                                <?php 
                                                if($_SESSION['sys_account_mode'] == 'user') {

                                                    $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                    }

                                                } else { // employees
                                                    
                                                    $cluster_ids = getClusterIDs($_SESSION['sys_id']);

                                                    // no cluster
                                                    if(empty($cluster_ids)) {

                                                        $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                        $sub_properties = explode(',', $sub_property_ids);
                                                        foreach($sub_properties as $sub_property_id) {
                                                            $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0 AND sp.id = :id");
                                                            $sql->bindParam(":id", $sub_property_id);
                                                            $sql->execute();
                                                            if($sql->rowCount()) {
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                                }
                                                            }
                                                        }

                                                    } else {

                                                        // get all properties under cluster
                                                        $property_ids = array();
                                                        $sub_property_ids = array();
                                                        foreach($cluster_ids as $cluster_id) {
                                                            // get properties under cluster
                                                            $property_ids = getClusterProperties($cluster_id);
        
                                                            // get all sub_properties under property
                                                            foreach($property_ids as $property_id) {
                                                                $sql = $pdo->prepare("SELECT id FROM sub_properties WHERE property_id = :property_id AND temp_del = 0");
                                                                $sql->bindParam(":property_id", $property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        $sub_property_ids[] = $data['id'];
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        // get user assigned sub_properties
                                                        foreach($sub_property_ids as $sub_property_id) {

                                                            $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0 AND sp.id = :id");
                                                            $sql->bindParam(":id", $sub_property_id);
                                                            $sql->execute();
                                                            if($sql->rowCount()) {
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
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-right">
                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
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
                                
                                <!-- Status -->
                                <div class="row mt-2">
                                    <div class="col-12 text-right">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="save-status" name="status" value="0">
                                            <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/calibration-plans" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary" id="save-button"><i class="fa fa-plus mr-2"></i><?php echo renderLang($calibration_save_calibration); ?></button>
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