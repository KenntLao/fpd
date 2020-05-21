<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-PAD-add')) {

	$page = 'pre-operation-audit';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_pad_pcc); ?> &middot; <?php echo $sitename; ?></title>

    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <style>
    .certify-border {
        border-top: 0;
        border-left: 0;
        border-right: 0;
    }
    </style>
	
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_pad_pcc); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderError('sys_pre_operation_audit_pad_pcc_add_err');
                    ?>

                    <form action="/submit-add-pad-pcc-pre-operation-audit" method="post">

                        <input type="hidden" name="pcc_category" value="pre operations">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_pcc_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <!-- prospect -->
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

                                    <!-- pcc date -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="pcc_date"><?php echo renderLang($pre_operation_audit_pcc_date); ?></label>
                                            <input type="text" class="form-control date" name="pcc_date" id="pcc_date">
                                        </div>
                                    </div>

                                    <!-- pcc custodian -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="pcc_custodian"><?php echo renderLang($pre_operation_audit_pcc_custodian); ?></label>
                                            <input type="text" class="form-control" name="pcc_custodian" id="pcc_custodian">
                                        </div>
                                    </div>

                                    <!-- pcc amount of fund -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="pcc_amount"><?php echo renderLang($pre_operation_audit_pcc_amount_of_fund); ?></label>
                                            <input type="text" data-type="currency" class="form-control" name="pcc_amount" id="pcc_amount">
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_cash_on_hand); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_denomination); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_quantity); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_total); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach($pcc_cash_on_hand_arr as $key => $bills) {
                                                        echo '<tr>';

                                                        echo '<td>'.renderLang($bills[0]).'</td>';
                                                        echo '<td><p>'.$bills[1].'</p><input type="hidden" name="denomination[]" value="'.$key.'"></td>';
                                                        echo '<td><input type="number" min="0" class="form-control border-0" name="quantity[]"></td>';
                                                        echo '<td><input type="text" data-type="currency" min="0" class="form-control border-0" name="amount[]"></td>';
                                                        echo '<td><input type="text" data-type="currency" min="0" class="form-control border-0" name="total[]"></td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_total_cash_on_hand); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_total_cash"></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_unreplenished); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_unreplenished"></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_unliquidated); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_unliquidated"></td>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_total_per_count2"></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_replenishment); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_replenished"></td>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_total_per_books); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_total_per_books"></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_total_per_count1"></td>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="pcc_overage"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50%;"><?php echo renderLang($pre_operation_audit_items_to_check); ?></th>
                                                        <th><?php echo renderLang($pre_operation_audit_pcc_status_compliance); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $num = 1;
                                                    foreach($pcc_items_to_be_checked_arr as $key => $item) { 
                                                        echo '<tr>';

                                                        echo '<td><p>'.$num.'. '.renderLang($item).'</p><input type="hidden" name="item[]" value="'.$key.'"></td>';
                                                        echo '<td><textarea class="form-control notes border-0" name="status_compliance[]"></textarea></td>';

                                                        echo '</tr>';

                                                        $num++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">

                                    <div class="col-12 text-center">
                                        <p><b><?php echo renderLang($pre_operation_audit_pcc_certification); ?></b></p>
                                    </div>

                                    <div class="col-lg-6 col-md-12 text-left">
                                        <p><?php echo renderLang($pre_operation_audit_pcc_hereby); ?></p>
                                    </div>

                                    <!-- 1. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>1. <?php echo renderLang($pre_operation_audit_pcc_certify1_part1); ?><input type="text" data-type="currency" class="ml-1 mr-1 p-2 certify-border border-bottom" name="certify_amount"><?php echo renderLang($pre_operation_audit_pcc_certify1_part2); ?><input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom" name="certify_counted_by"><?php echo renderLang($pre_operation_audit_pcc_certify1_part3); ?><input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom date" name="certify_date"><?php echo renderLang($pre_operation_audit_pcc_certify1_part4); ?><input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom" name="certify_location"></p>
                                    </div>

                                    <!-- 2. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>2. <?php echo renderLang($pre_operation_audit_pcc_certify2); ?></p>
                                    </div>

                                    <!-- 3. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>3. <?php echo renderLang($pre_operation_audit_pcc_certify3); ?></p>
                                    </div>

                                    <!-- 4. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>4. <?php echo renderLang($pre_operation_audit_pcc_certify4); ?></p>
                                    </div>

                                </div>

                                <div class="row mt-5">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="counted_by"><?php echo renderLang($pre_operation_audit_pcc_counted_by); ?></label>
                                            <input type="text" class="form-control border-0" name="counted_by" id="counted_by">
                                            <p><span class="border-top"><?php echo renderLang($pre_operation_audit_pcc_signature_over_printed_name); ?></span></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="acknowledge_by"><?php echo renderLang($pre_operation_audit_pcc_acknowledge_by); ?></label>
                                            <input type="text" class="form-control border-0" name="acknowledge_by" id="acknowledge_by">
                                            <p><span class="border-top"><?php echo renderLang($pre_operation_audit_pcc_signature_over_printed_name); ?></span></p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pad-pcc-pre-operation-audit-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($pre_operation_audit_pcc_save); ?></button>
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