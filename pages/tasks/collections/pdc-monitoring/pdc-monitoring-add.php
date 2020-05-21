<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pdc-monitoring')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        
        $id = $_GET['id'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pdc); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($pdc); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_pdc_monitoring_add_suc');
                    renderError('sys_pdc_monitoring_add_err');
                    ?>

                    <form action="/update-pdc-monitoring" method="post" autocomplete="off">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pdc_add_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 required">
                                                <option value=""></option>
                                            <?php 
                                            if($_SESSION['sys_account_mode'] == 'user') {

                                                $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="report_date"><?php echo renderLang($daily_collection_report_date); ?></label>
                                            <input type="text" class="form-control date" name="report_date" id="report_date">
                                        </div>
                                    </div>

                                </div>

                                <!-- for deposit -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <label><?php echo renderLang($pdc_dated_checks_for_deposit); ?></label>
                                        <table class="table table-bordered table-hover table-condensed">
                                            <thead class="bg-dark text-center">
                                                <tr>
                                                    <th><?php echo renderLang($pdc_date_on_check); ?></th>
                                                    <th><?php echo renderLang($pdc_pr_number); ?></th>
                                                    <th><?php echo renderLang($pdc_unit_number); ?></th>
                                                    <th><?php echo renderLang($pdc_payor); ?></th>
                                                    <th><?php echo renderLang($daily_collection_report_particulars); ?></th>
                                                    <th><?php echo renderLang($pdc_amount); ?></th>
                                                    <th><?php echo renderLang($collections_check_voucher_check_number); ?></th>
                                                    <th><?php echo renderLang($collections_check_voucher_bank); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $curr_date = formatDate(time(), true);
                                                $sql = $pdo->prepare("SELECT dcpt.*, dc.id, dc.pr_number, dc.unit_id, dc.particulars, dc.collection_date, dc.sub_property_id FROM daily_collections dc LEFT JOIN sub_properties sp ON (sp.id = dc.sub_property_id) LEFT JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.sub_property_id = :id AND voucher_type = 3 AND payment_type = 2 AND dc.temp_del = 0 AND dcpt.status = 0");
                                                $sql->bindParam(":id", $id);
                                                $sql->execute();
                                                while ($_data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    if(strtotime($_data['date_of_check']) <= strtotime($curr_date)) {
                                                        
                                                        echo '<tr class="text-center">';
        
                                                            echo '<td>'.formatDate($_data['date_of_check']).'</td>';
                                                            echo '<td>'.$_data['pr_number'].'</td>';
                                                            // unit
                                                            echo '<td>';
                                                                $unit_names = array();
                                                                $unit_ids = explode(',', $_data['unit_id']);
                                                                foreach($unit_ids as $unit_id) {
                                                                    $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                    if(checkVar($unit_name)) {
                                                                        $unit_names[] = $unit_name;
                                                                    } else {
                                                                        $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$_data['sub_property_id']);
                                                                        if(checkVar($unit_name)) {
                                                                            $unit_names[] = $unit_name;
                                                                        } else {
                                                                            $unit_names[] = $unit_id;
                                                                        }
                                                                    }
                                                                }
                                                                $unit_name = implode(', ', $unit_names);
                                                                echo $unit_name;
                                                            echo '</td>';
        
                                                            echo '<td></td>';
                                                            echo '<td>'.$_data['particulars'].'</td>';
                                                                // AMOUNT
                                                            echo '<td>'.$_data['amount'].'<input type="hidden" class="pr_amount" name="amount[]"  value="'.$_data['amount'].'"></td>';
                                                            echo '<td>'.$_data['check_number'].'</td>';
        
                                                            echo '<td>';
                                                                if(checkVar($_data['bank'])) {

                                                                    if($_data['bank'] == 999) {
                                                                        echo $_data['other_bank'];
                                                                    } else {
                                                                        echo renderLang($banks_arr[$_data['bank']]);
                                                                    }
                                                                }
                                                            echo '</td>';
        
                                                        echo '</tr>';

                                                    }

                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-center">
                                                    <td colspan="4" class="border-0"></td>
                                                    <th class="p-0 border-0 text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                    <td class="total-for-deposit border-left-0 border-right-0"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- monitoring -->
                                <div class="row">
                                    <div class="col-12">
                                        <label><?php echo renderLang($pdc_monitoring); ?></label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_date); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_pr_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_unit_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_payor); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_particulars); ?></p></th>
                                                        <th colspan="3" class="bg-dark"><?php echo renderLang($pdc_check_details); ?></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_date_deposited); ?></p></th>
                                                        <th rowspan="2"><p class="w55"><?php echo renderLang($pdc_receipt_type); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_receipt_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_status); ?></p></th>
                                                    </tr>
                                                    <tr>
                                                        <th><p class="w100"><?php echo renderLang($pdc_amount); ?></p></th>
                                                        <th><p class="w100"><?php echo renderLang($pdc_bank_check_number); ?></p></th>
                                                        <th><p class="w100"><?php echo renderLang($pdc_date_on_check); ?></p></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT dcpt.*, dcpt.id as dcpt_id, dc.id, voucher_type, bank, check_number, dc.pr_number, dc.unit_id, dc.particulars, dc.collection_date, dc.sub_property_id FROM daily_collections dc LEFT JOIN sub_properties sp ON (sp.id = dc.sub_property_id) LEFT JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.sub_property_id = :id AND voucher_type = 3 AND payment_type = 2 AND dc.temp_del = 0");
                                                    $sql->bindParam(":id",$id);
                                                    $sql->execute();
                                                    while ($_data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        echo '<tr class="text-center">';

                                                            echo '<input type="hidden" name="dcpt_id[]" value="'.$_data['dcpt_id'].'">';

                                                            echo '<td>'.$_data['collection_date'].'</td>';
                                                            echo '<td>'.$_data['pr_number'].'</td>';
                                                            // unit
                                                            echo '<td>';
                                                                $unit_names = array();
                                                                $unit_ids = explode(',', $_data['unit_id']);
                                                                foreach($unit_ids as $unit_id) {
                                                                    $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                    if(checkVar($unit_name)) {
                                                                        $unit_names[] = $unit_name;
                                                                    } else {
                                                                        $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$_data['sub_property_id']);
                                                                        if(checkVar($unit_name)) {
                                                                            $unit_names[] = $unit_name;
                                                                        } else {
                                                                            $unit_names[] = $unit_id;
                                                                        }
                                                                    }
                                                                }
                                                                $unit_name = implode(', ', $unit_names);
                                                                echo $unit_name;
                                                            echo '</td>';
                                                            
                                                            echo '<td></td>';
                                                            echo '<td>'.$_data['particulars'].'</td>';
                                                            // AMOUNT
                                                            echo '<td>'.$_data['amount'].'</td>';
                                                            echo '<td>'.(checkVar($_data['bank']) ? renderLang($banks_arr[$_data['bank']]) : '').'/';
                                                            echo (checkVar($_data['check_number']) ? $_data['check_number'] : '').'</td>';
                                                            echo '<td>'.formatDate($_data['date_of_check']).'</td>';
                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" class="form-control border-0 deposit-date" name="deposit_date[]" value="'.$_data['recorded_date'].'">';
                                                            echo '</td>';
                                                            echo '<td class="p-0">';
                                                                echo '<select name="receipt_type[]" class="form-control border-0 receipt-type">';
                                                                    echo '<option value=""></option>';
                                                                foreach($reference_number_arr as $key => $receipt_type) {
                                                                    if($key != 3) {
                                                                        echo '<option '.($_data['receipt_type'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($receipt_type).'</option>';
                                                                    }
                                                                }
                                                                echo '</select>';
                                                            echo '</td>';
                                                            
                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" class="form-control border-0 text-center or-number" name="receipt_number[]" value="'.$_data['reference_number'].'">';
                                                            echo '</td>';

                                                            echo '<td>';
                                                                echo '<span class="badge status badge-'.$daily_collection_report_collection_status_color_arr[$_data['status']].'">'.renderLang($daily_collection_report_collection_status_arr[$_data['status']]).'</span>';
                                                            echo '</td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pdc-monitoring-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
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

        // change status on OR NUMBER change
            $('body').on('change', '.or-number', function(){

                var or_number = $(this).val();
                or_number = or_number.trim();

                if(or_number) {
                    // deposited
                    $(this).closest('tr').find('.status').removeClass('badge-secondary').removeClass('badge-success');
                    $(this).closest('tr').find('.status').addClass('badge-success');
                    $(this).closest('tr').find('.status').html("<?php echo renderLang($daily_collection_report_collection_status_arr[1]); ?>");
                } else {
                    // undeposited
                    $(this).closest('tr').find('.status').removeClass('badge-secondary').removeClass('badge-success');
                    $(this).closest('tr').find('.status').addClass('badge-secondary');
                    $(this).closest('tr').find('.status').html("<?php echo renderLang($daily_collection_report_collection_status_arr[0]); ?>");
                }

            });

        // 

        // set receipt type and number required if date deppsited is not empty
            $('body').on('blur', '.deposit-date', function(){

                $('.deposit-date').each(function(){
                    var deposit_date = $(this).val();
                    deposit_date = deposit_date.trim();
                    if(deposit_date) {
                        $(this).closest('tr').find('.receipt-type').attr("required", true);
                        $(this).closest('tr').find('.or-number').attr("required", true);
                    } else {
                        $(this).closest('tr').find('.receipt-type').attr("required", false);
                        $(this).closest('tr').find('.or-number').attr("required", false);
                    }
                });

            });
        // 

        // total amount
            var total_for_deposit = 0;
            $('.pr_amount').each(function(){
                var amount = $(this).val();
                amount = convertCurrency(amount);
                total_for_deposit += amount;
            });
            $('.total-for-deposit').html(convert_to_currency(total_for_deposit, "blur"));
        // 

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