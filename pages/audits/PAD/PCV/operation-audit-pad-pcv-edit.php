<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-PAD-edit')) {

    $page = 'operation-audit';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM poa_pad_pcv WHERE id = :id AND temp_del = 0");
    $sql->bindParam(":id", $id);
    $sql->execute();
    if($sql->rowCount()) {

        $_data = $sql->fetch(PDO::FETCH_ASSOC);

    } else {

        $_SESSION['sys_pre_operation_audit_pad_err'] = renderLang($pre_operation_audit_pad_not_found);
        header('location: /operation-audit-pad-list');
        exit();

    }

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_pad_edit_pcv); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1>
                                <i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_pad_edit_pcv); ?>
                                <small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo getField('project_name', 'prospecting', 'id='.$_data['prospect_id']); ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderError('sys_pre_operation_audit_pad_pcv_add_err');
                    ?>

                    <form action="" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_pad_edit_pcv_form); ?></h3>
                            </div>
                            <div class="card-body">

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
                                                    echo '<option '.($_data['prospect_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2"><p class="w120"><?php echo renderLang($pre_operation_audit_pcc_date); ?></p></th>
                                                        <th rowspan="2"><p class="w200"><?php echo renderLang($pre_operation_audit_pcv_payee); ?></p></th>
                                                        <th rowspan="2"><p class="w200"><?php echo renderLang($pre_operation_audit_tsa_particulars); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pre_operation_audit_pcv_no); ?></p></th>
                                                        <th rowspan="2"><p class="w120"><?php echo renderLang($pre_operation_audit_pcc_amount); ?></p></th>
                                                        <th colspan="<?php echo count($pre_op_audit_pcv_legend_arr); ?>" class="text-center"><?php echo renderLang($pre_operation_audit_pvc_findings); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <?php 
                                                        foreach($pre_op_audit_pcv_legend_arr as $key => $value) {
                                                            echo '<th><p class="w35">'.$key.'</p></th>';
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM poa_pad_pcv_particulars WHERE pcv_id = :id");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        echo '<tr>';

                                                        echo '<td><input type="text" class="form-control border-0 date" name="pcv_date[]" value="'.$data['date'].'"></td>';
                                                        echo '<td><input type="text" class="form-control border-0" name="pcv_payee[]" value="'.$data['payee'].'"></td>';
                                                        echo '<td><input type="text" class="form-control border-0" name="pcv_particulars[]"  value="'.$data['particulars'].'"></td>';
                                                        echo '<td><input type="text" class="form-control border-0" name="pcv_no[]"  value="'.$data['pcv_no'].'"></td>';
                                                        echo '<td><input type="text" data-type="currency" class="form-control border-0" name="pcv_amount[]"  value="'.$data['amount'].'"></td>';

                                                        $sql1 = $pdo->prepare("SELECT * FROM poa_pad_pcv_findings WHERE particular_id = :id");
                                                        $sql1->bindParam(":id", $data['id']);
                                                        $sql1->execute();
                                                        while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<td><button class="btn '.($data1['status'] == 'a' ? 'btn-success' : 'btn-danger').' findings w30">'.$data1['status'].'</button><input type="hidden" name="findings_'.$data1['legend'].'[]" value="'.$data1['status'].'"></td>';
                                                        }

                                                        echo '</tr>';

                                                    }
                                                    ?>
                                                    <tr class="default-row d-none">
                                                        <td><input type="text" class="form-control border-0 date" name="pcv_date[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="pcv_payee[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="pcv_particulars[]"></td>
                                                        <td><input type="text" class="form-control border-0" name="pcv_no[]"></td>
                                                        <td><input type="text" data-type="currency" class="form-control border-0" name="pcv_amount[]"></td>
                                                        <?php 
                                                        foreach($pre_op_audit_pcv_legend_arr as $key => $value) {
                                                            echo '<td><button class="btn btn-danger findings w30">r</button><input type="hidden" name="findings_'.$key.'[]" value="r"></td>';
                                                        }
                                                        ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right mt-3">
                                            <button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                        </div>
                                    </div> 
                                </div>

                                <div class="row mt-3">

                                    <div class="col-lg-6 row">
                                        <div class="col-lg-6 col-md-12">
                                            <p><b><?php echo renderLang($pre_operation_audit_pcv_audited_by); ?></b></p>
                                            <div class="form-group">
                                                <label for="pcv_audited_by"><?php echo renderLang($pre_operation_audit_pad_accounting_supervisor); ?></label>
                                                <input type="text" class="form-control" name="pcv_audited_by" id="pcv_audited_by" value="<?php echo $_data['accounting_supervisor']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 row">
                                        <div class="col-lg-12 row">
                                            <p><b><?php echo renderLang($pre_operation_audit_pcv_recommendations_discussed); ?></b></p>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label for="pcv_custodian"><?php echo renderLang($pre_operation_audit_pcv_pcf_custodian); ?></label>
                                                    <input type="text" class="form-control" name="pcv_custodian" id="pcv_custodian" value="<?php echo $_data['pcf_custodian']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label for="pcv_building_manager"><?php echo renderLang($pre_operation_audit_pcv_building_manager); ?></label>
                                                    <input type="text" class="form-control" name="pcv_building_manager" id="pcv_building_manager" value="<?php echo $_data['building_manager']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="col-lg-6 col-md-12">
                                        <p class="ml-2 mb-2"><b><?php echo renderLang($pre_operation_audit_pcv_legend); ?></b></p>
                                        <?php 
                                        foreach($pre_op_audit_pcv_legend_arr as $key => $value) {
                                            echo '<p><span>'.$key.'</span><span class="mr-3 ml-3">-</span><span>'.renderLang($value).'</span></p>';
                                        }
                                        ?>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <p class="mb-5"></p>
                                        <?php 
                                        foreach($pre_op_audit_pcv_status_legend_arr as $key => $value) {
                                            echo '<p><span>'.$key.'</span><span class="mr-3 ml-3">-</span><span>'.renderLang($value).'</span></p>';
                                        }
                                        ?>
                                    </div>

                                </div>
                                
                            </div>
                            <div class="card-footer text-right">
                                <a href="/operation-audit-pad-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($pre_operation_audit_pad_update_pcv); ?></button>
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

        // add row
        $('body').on('click', '.add-row', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('.col-12').find('.default-row').html()+'</tr>';
            $(this).closest('.col-12').find('tbody').append(fields);

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
                });
            });

        });

        // toggle button
        $('body').on('click', '.findings', function(e){
            e.preventDefault();

            $(this).toggleClass('btn-success').toggleClass('btn-danger');

            var val = '';
            
            if($(this).hasClass('btn-success')) {
                $(this).html('a');
                $(this).closest('td').find('input').val('a');
            } else {
                $(this).html('r');
                $(this).closest('td').find('input').val('r');
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