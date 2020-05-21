<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('30-60-90-days')) {
	
		// clear sessions from forms
		// clearSessions();

		// set page
        $page = 'day-plans';
        
        // set fields from table to search on
        $fields_arr = array('client_id','client_name','contact_person');
        $search_placeholder = renderLang($clients_client_id).', '.renderLang($clients_client_name).', '.renderLang($clients_contact_person);
        require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-search.php');
        
        $sql_query = 'SELECT * FROM clients'.$where; // set sql statement
        require($_SERVER['DOCUMENT_ROOT'].'/includes/common/set-pagination.php');
		
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($day_plans_30_60_90_day_plans); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="far fa-calendar-alt mr-3"></i><?php echo renderLang($day_plans_30_60_90_day_plans); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_day_plan_add_suc');
                    renderSuccess('sys_day_plan_edit_suc');
                    renderError('sys_day_plan_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($day_plans_30_60_90_day_plan_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('30-60-90-day-add')) { ?>
                                    <a href="/add-30-60-90-day-plan" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($day_plans_add); ?></a>
                                <?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                            <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/search.php'); ?>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($day_plans_project); ?></th>
                                            <th><?php echo renderLang($day_plans_date_of_deployment); ?></th>
                                            <th><?php echo renderLang($lang_status); ?></th>
                                            <th class="w35"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql = $pdo->prepare("SELECT day_plan_status ,reference_number, project_name, deployment_date, dp.id FROM day_plan dp LEFT JOIN prospecting p ON(dp.prospect_id = p.id) WHERE dp.temp_del = 0");
                                    $sql->execute();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';

                                        echo '<td><a href="/30-60-90-day-plan/'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</a></td>';
                                        echo '<td>'.formatDate($data['deployment_date']).'</td>';
                                        echo '<td>';
                                            echo '<span class="badge '.(checkVar($data['day_plan_status']) ? 'badge-'.$day_plan_status_arr[$data['day_plan_status']]['color'] : 'badge-secondary').'">';
                                                echo checkVar($data['day_plan_status']) ? renderLang($day_plan_status_arr[$data['day_plan_status']]['label']) : renderLang($day_plan_status_arr[0]);
                                            echo '</span>';
                                        echo '</td>';
                                        echo '<td><a href="/edit-30-60-90-day-plan/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($day_plans_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';

                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

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
                    singleDatePicker: true
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