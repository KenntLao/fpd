<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('preventive-maintenance-add')) {

    $page = 'preventive-maintenance';
    
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($preventive_add_maintenance); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($preventive_add_maintenance); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderError('sys_preventive_maintenance_add_err');
                    renderSuccess('sys_preventive_maintenance_add_suc');
                    ?>

                    <form action="/submit-add-preventive-maintenance" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($preventive_add_maintenance_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="building"><?php echo renderLang($preventive_maintenance_building); ?></label>
                                            <select name="building_id" id="building" class="form-control">
                                            <?php
                                            $sql = $pdo->prepare("SELECT sub_property_name, property_name, sp.id FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="equipment"><?php echo renderLang($preventive_maintenance_equipment); ?></label>
                                            <select name="equipment_id" id="equipment" class="form-control" required>

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="frequency"><?php echo renderLang($preventive_maintenance_frequency); ?></label>
                                            <select name="frequency" id="frequency" class="form-control">
                                            <?php 
                                            foreach($preventive_maintenance_frequency_arr as $key => $frequency) {
                                                echo '<option '.($id == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($frequency[1]).'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="employee"><?php echo renderLang($preventive_maintenance_assigned_to); ?></label>
                                            <select name="employee_id" id="employee" class="form-control select2" required>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="description"><?php echo renderLang($preventive_maintenance_description); ?></label>
                                            <textarea name="description" id="description" rows="3" class="form-control notes"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/frequency-preventive-maintenance/6" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($preventive_add_maintenance); ?></button>
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

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            var building_id = $('#building').val();

            var equipment_field = 'equipment';
            var employee_field = 'employee';

            $.post('/preventive-maintenance-equipment-options', {
                id:building_id, field:equipment_field
            }, function(data){
                $('#equipment').html(data);
            });

            $.post('/preventive-maintenance-equipment-options', {
                id:building_id, field:employee_field
            }, function(data){
                $('#employee').html(data);
            });

            $('#building').on('change', function(){
                
                building_id = $(this).val();

                $.post('/preventive-maintenance-equipment-options', {
                    id:building_id, field:equipment_field
                }, function(data){
                    $('#equipment').html(data);
                });

                $.post('/preventive-maintenance-equipment-options', {
                    id:building_id, field:employee_field
                }, function(data){
                    $('#employee').html(data);
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