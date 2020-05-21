<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('30-60-90-day-add')) {
	
		// clear sessions from forms
		// clearSessions();

		// set page
		$page = 'day-plans';
		
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($day_plans); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-calendar-alt mr-3"></i><?php echo renderLang($day_plans); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_day_plan_add_err');
                    ?>

                    <form action="/submit-add-30-60-90-day-plan" method="post">
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($day_plans_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row mb-5">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect"><?php echo renderLang($day_plans_project); ?></label>
                                            <select name="prospect_id" id="prospect" class="form-control select2">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM prospecting WHERE status = 3 AND prospecting_category = 0 AND temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="deployment"><?php echo renderLang($day_plans_date_of_deployment); ?></label>
                                            <input type="text" name="deployment" id="deployment" class="form-control date">
                                        </div>
                                    </div>

                                </div>

                                <?php 
                                foreach($day_plans_arr as $days) { 
                                
                                    $symbol = explode('.', $days[0]);    
                                ?>
                                <p class="text-center">
                                    <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $symbol[0]; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $symbol[0].'. '; echo renderLang($days[1]); ?></button>
                                </p>
                                <div class="collapse" id="tab-<?php echo $symbol[0]; ?>">
                                
                                    <div class="card card-body">

                                        <div class="row">
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-group">
                                                    <label for=""><?php echo renderLang($day_plans_to_be_accomplished_by); ?></label>
                                                    <input type="text" name="accomplished_date_<?php echo $symbol[1]; ?>" class="form-control date">
                                                </div>
                                                
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo renderLang($day_plans_date_from); ?></th>
                                                                <th><?php echo renderLang($day_plans_date_to); ?></th>
                                                                <th><?php echo renderLang($day_plans_action); ?></th>
                                                                <th><?php echo renderLang($day_plans_department_responsible); ?></th>
                                                                <th><?php echo renderLang($day_plans_remarks); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-data">
                                                            <?php
                                                            foreach($day_plan_actions_arr[$symbol[1]] as $key => $action) {
                                                                echo '<tr>';

                                                                echo '<td><input type="text" name="plan_date[]" class="form-control date  border-0"></td>';

                                                                echo '<td><input type="text" name="date_to[]" class="form-control date border-0"></td>';

                                                                echo '<td><p>'.renderLang($action).'</p><input type="hidden" name="plan_action[]" class="form-control  border-0" value="'.$action[0].'"></td>';

                                                                echo '<td>';
                                                                echo '<select name="department_id[]" class="form-control border-0">';
                                                                    $sql = $pdo->prepare("SELECT * FROM departments WHERE temp_del = 0");
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.$data['department_code'].' ['.$data['department_name'].']</option>';
                                                                    }
                                                                echo '</select>';
                                                                echo '</td>';

                                                                echo '<td><input type="text" name="plan_remarks[]" class="form-control  border-0"></td>';
                                                                
                                                                echo '<input type="hidden" name="plan_category[]" value="'.$symbol[1].'">';

                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                            <tr id="default-row" class="d-none">
                                                                <td><input type="text" name="plan_date[]" class="form-control date  border-0"></td>
                                                                <td><input type="text" name="date_to[]" class="form-control date border-0"></td>
                                                                <td><input type="text" name="plan_action[]" class="form-control  border-0"></td>
                                                                <td>
                                                                    <select name="department_id[]" class="form-control border-0">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM departments WHERE temp_del = 0");
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.$data['department_code'].' ['.$data['department_name'].']</option>';
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="plan_remarks[]" class="form-control  border-0"></td>
                                                                <input type="hidden" name="plan_category[]" value="<?php echo $symbol[1]; ?>">
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-right">
                                                        <button href="" id="add-row" class="btn btn-info"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>    
                                    
                                </div>
                                
                                <?php } ?>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/30-60-90-day-plans" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($day_plans_save_day_plan); ?></button>
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
		$(function() {

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

            $('body').on('click', '#add-row', function(e){
                e.preventDefault();

                var row_fields = $(this).closest('.table-responsive').find('#default-row').html();

                $(this).closest('.table-responsive').find('#table-data').append('<tr>'+row_fields+'</tr>');

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