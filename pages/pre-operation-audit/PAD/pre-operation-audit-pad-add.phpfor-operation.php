<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-add')) {

	$page = 'pre-operation-audit';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_pad_checklist_page); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_pad_checklist_page); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pre_operation_audit_pad_add_suc');
                    renderError('sys_pre_operation_audit_pad_add_err');
                    ?>

                    <form action="/submit-add-pad-pre-operation-audit" method="post">
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_pad_checklist_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <!-- MONTH -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="for_month"><?php echo renderLang($pre_operation_audit_month); ?></label>
                                            <select name="month" id="for_month" class="form-control">
                                                <?php 
                                                foreach($months_arr as $key => $month) {
                                                    echo '<option value="'.$key.'">'.renderLang($month).'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <!-- PROSPECT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="prospect_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <select name="prospect_id" id="prospect_id" class="form-control select2">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT reference_number, project_name, id FROM prospecting WHERE status = 3 AND prospecting_category = 0 AND temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ACCOUNTINF ASSISTANT -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="accounting_assistant"><?php echo renderLang($pre_operation_audit_pad_accounting_assistant); ?></label>
                                            <input type="text" class="form-control" name="accounting_assistant" id="accounting_assistant">
                                        </div>
                                    </div>

                                    <!-- ACCOUNTING SUPERVISOR -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="accounting_supervisor"><?php echo renderLang($pre_operation_audit_pad_accounting_supervisor); ?></label>
                                            <input type="text" class="form-control" name="accounting_supervisor" id="accounting_supervisor">
                                        </div>
                                    </div>

                                    <!-- BUILDING MANAGER -->
                                    <div  class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="building_manager"><?php echo renderLang($pre_operation_audit_pad_building_manager); ?></label>
                                            <input type="text" class="form-control" name="building_manager" id="building_manager">
                                        </div>
                                    </div>

                                </div>

                                <div class="card card-danger card-tabs mt-4">
                                    <?php 
                                    $sql = $pdo->prepare("SELECT * FROM pre_operation_checklist WHERE category = 'pad'");
                                    $sql->execute();
                                    $fetch = array();
                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                        $fetch[$data['id']] = array(
                                            'iso_clause' => $data['iso_clause'],
                                            'item' => $data['item']
                                        );

                                    }
                                    ?>
                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                            <?php 
                                            for($i = 1; $i <= 10; $i++) {
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link<?php echo $i == 1? ' active' : '' ?>" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-<?php echo $i; ?>" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true"><?php echo $i; ?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-two-tabContent">
                                            <?php 
                                            for($i = 1; $i <= 10; $i++) {
                                            ?>
                                            <div class="tab-pane fade show <?php echo $i == 1? ' active' : '' ?>" id="custom-tabs-<?php echo $i; ?>" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo renderLang($pre_operation_audit_reference_document); ?></th>
                                                                <th><?php echo renderLang($pre_operation_audit_items_to_check); ?></th>
                                                                <th><?php echo renderLang($lang_status); ?></th>
                                                                <th><?php echo renderLang($pre_operation_audit_remarks); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                        foreach($fetch as $key => $data) {

                                                            $num = array();
                                                                $num = explode('.', $data['iso_clause']);

                                                            if($num[0] == $i) {

                                                                echo '<tr>';

                                                                    echo '<td><input type="text" class="form-control border-0" name="reference_document[]"></td>';

                                                                    $number = strpos($data['iso_clause'], '.');
                                                                    echo '<td><p class="w300">'.($number ? $data['iso_clause'].' '.$data['item'] : '<b>'.$data['iso_clause'].'. '.$data['item'].'</b>').'</p><input type="hidden" name="checklist_id[]" value="'.$key.'"></td>';

                                                                
                                                                    echo '<td>';
                                                                    echo '<textarea class="form-control notes border-0" name="status[]"></textarea>';
                                                                    echo '</td>';
                                                                    echo '<td><textarea class="form-control notes border-0" name="remarks[]"></textarea></td>';

                                                                echo '</tr>';
                                                            }

                                                        } 
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>

                                <div class="row mt-4">
                                    <!-- CHECKED BY -->
                                    <div class="col-lg-6 row">
                                        <div class="col-lg-8 col-md-12">
                                            <p><b><?php echo renderLang($pre_operation_audit_checked_by); ?></b></p>
                                            <div class="form-group">
                                                <label for="checked_by"><?php echo renderLang($pre_operation_audit_accounting_supervisor_signature_date); ?></label>
                                                <input type="text" class="form-control" name="checked_by" id="checked_by">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- NOTED BY -->
                                    <div class="col-lg-6 row">
                                        <div class="col-lg-8 col-md-12">
                                            <p><b><?php echo renderLang($pre_operation_audit_noted_by); ?></b></p>
                                            <div class="form-group">
                                                <label for="noted_by"><?php echo renderLang($pre_operation_audit_building_manager_signature_date); ?></label>
                                                <input type="text" class="form-control" name="noted_by" id="noted_by">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audit-pad-categories" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($pre_operation_audit_pad_save_checklist); ?></button>
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
