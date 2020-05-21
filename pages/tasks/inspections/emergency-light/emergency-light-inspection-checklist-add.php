<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('inspection-emergency-light-checklist-add')) {

	$page = 'inspections';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($add_emergency_light_inspection_checklist); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($add_emergency_light_inspection_checklist); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">   

                    <?php renderError('sys_emergency_light_inspection_checklist_add_err'); ?>

                    <form action="/submit-add-emergency-light-inspection-checklist" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($emergency_light_inspection_checklist_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <h3 class="text-center"><?php echo renderLang($emergency_light_inspection_checklist); ?></h3>

                                <div class="row">

                                    <!-- MONTH -->
                                    <div class="col-lg-3 col-md-4 text-center mx-auto">
                                        <div class="form-group">
                                            <label for="month"><?php echo renderLang($emergency_light_month); ?></label>
                                            <select name="month" id="month" class="form-control">
                                            <?php 
                                            foreach($months_arr as $key => $month) {
                                                echo '<option value="'.$key.'">'.renderLang($month).'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                </div><!-- row -->

                                <br>

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($properties_sub_property); ?></label>
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

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="room_department"><?php echo renderLang($emergency_light_room_department); ?></label>
                                                <input type="text" class="form-control" name="room_department">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="location_area"><?php echo renderLang($emergency_light_location_area); ?></label>
                                                <input type="text" class="form-control" name="location_area">
                                        </div>
                                    </div>
                                    
                                </div><!-- row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th class="w55"><?php echo renderLang($emergency_light_item); ?></th>
                                                            <th><?php echo renderLang($emergency_light_standard); ?></th>
                                                            <th class="w55"><?php echo renderLang($emergency_light_ok); ?></th>
                                                            <th class="w55"><?php echo renderLang($emergency_light_not_ok); ?></th>
                                                            <th class="w55"><?php echo renderLang($emergency_light_na); ?></th>
                                                            <th class="w200"><?php echo renderLang($emergency_light_remarks); ?></th>
                                                            <th class="w200"><?php echo renderLang($emergency_light_action_taken); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $last_num = 1;
                                                        foreach ($emergency_light_inspection_checklist_arr as $emergency_light_key => $emergency_light) {
                                                            
                                                            echo '<tr>';

                                                            echo '<td>';
                                                                echo '<p>'.$emergency_light_key.'</p>';
                                                                echo '<input type="hidden" name="item_no[]" value="'.$emergency_light_key.'">';
                                                            echo '</td>';

                                                            echo '<td>';
                                                                echo '<p>'.renderLang($emergency_light).'</p>';
                                                                echo '<input type="hidden" name="standard[]" value="'.renderLang($emergency_light).'">';
                                                            echo '</td>';
                                                            // OK
                                                            echo '<td class="check" data-val="ok">';
                                                                echo '<button class="btn btn-success d-none"><i class="fa fa-check"></i></button>';
                                                            echo '</td>';
                                                            // NOT OK
                                                            echo '<td class="check" data-val="not-ok">';
                                                                echo '<button class="btn btn-danger d-none"><i class="fa fa-times"></i></button>';
                                                            echo '</td>';
                                                            // N/A
                                                            echo '<td class="check" data-val="n/a">';
                                                                echo '<button class="btn btn-secondary d-none"><small>N/A</small></button>';
                                                            echo '</td>';
                                                            // remarks
                                                            echo '<td>';
                                                                echo '<textarea class="form-control notes border-0" name="remarks[]"></textarea>';
                                                            echo '</td>';
                                                            // action
                                                            echo '<td>';
                                                                echo '<textarea class="form-control notes border-0" name="action[]"></textarea>';
                                                            echo '</td>';

                                                            echo '<input type="hidden" name="check_status[]" class="check_value" value="">';
                                                            
                                                            echo '</tr>';
                                                            $last_num = $emergency_light_key;
                                                        } 
                                                        ?>
                                                        <tr class="default-row d-none">
                                                            <!-- STANDARD -->
                                                            <td>
                                                                <textarea name="standard[]" class="form-control notes border-0"></textarea>
                                                            </td>
                                                            <!-- OK -->
                                                            <td class="check"  data-val="ok">
                                                                <button class="btn btn-success d-none"><i class="fa fa-check"></i></button>
                                                            </td>
                                                            <!-- NOT OK -->
                                                            <td class="check" data-val="not-ok">
                                                                <button class="btn btn-danger d-none"><i class="fa fa-times"></i></button>
                                                            </td>
                                                            <!-- N/A -->
                                                            <td class="check" data-val="n/a">
                                                                <button class="btn btn-secondary d-none"><small>N/A</small></button>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control notes border-0" name="remarks[]"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control notes border-0" name="action[]"></textarea>
                                                            </td>
                                                            <input type="hidden" name="check_status[]" class="check_value" value="">
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-right">
                                                    <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- row -->

                                 <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="room_department"><?php echo renderLang($emergency_light_inspection_conducted_by); ?></label>
                                                <input type="text" class="form-control input-readonly" name="" value="<?php echo getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_inspect"><?php echo renderLang($emergency_light_date_conducted); ?></label>
                                                <input type="text" class="form-control input-readonly" value="<?php echo formatDate(time(), true, false, false); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="room_department"><?php echo renderLang($emergency_light_reviewed_by); ?></label>
                                                <input type="text" class="form-control" name="reviewed_by">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_inspect"><?php echo renderLang($emergency_light_date_reviewed); ?></label>
                                                <input type="text" class="form-control input-readonly date" name="reviewed_date" readonly>
                                        </div>
                                    </div>

                                    
                                </div><!-- row -->

                            </div><!-- card body -->
                            <div class="card-footer text-right">
                                <a href="/fire-extinguisher-inspection-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($add_emergency_light_inspection_checklist); ?></button>
                            </div>
                        </div><!-- card -->

                    </form><!-- form -->

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

            // add row
            var last_num = <?php echo $last_num > 1 ? $last_num : '0' ?>;
            $('body').on('click', '.add-row', function(e){
                e.preventDefault();

                last_num++;

                var fields = '<tr><td><p>'+last_num+'</p><input type="hidden" name="item_no[]" value="'+last_num+'"></td>'+$(this).closest('.table-responsive').find('.default-row').html()+'</tr>';
                $(this).closest('.table-responsive').find('tbody').append(fields);

            });


            // check
            $('body').on('click', '.check', function(e){
                e.preventDefault();

                var $this = $(this);

                $this.closest('tr').find('button').each(function(){

                    if($(this).hasClass('d-none')) {

                    } else {
                        $(this).addClass('d-none');
                    }

                });

                $this.find('button').removeClass('d-none');
                var check_val = $this.data('val');
                $this.closest('tr').find('.check_value').val(check_val);

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