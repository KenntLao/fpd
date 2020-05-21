<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-deposit-edit')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        $id = $_GET['id'];
        
        $sql = $pdo->prepare("SELECT * FROM daily_deposit WHERE temp_del = 0 AND id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            $sub_property_id = $_data['sub_property_id'];
            $date = $_data['recorded_date'];

        } else {
            $_SESSION['sys_daily_deposit_err'] = renderLang($lang_no_data);
            header('location: /daily-deposit-list');
            exit();
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_daily_deposit_edit); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_daily_deposit_edit); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_daily_deposit_edit_suc');
                    ?>

                    <form action="/submit-edit-daily-deposit" method="post" enctype="multipart/form-data">
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($collections_daily_deposit); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-<?php echo $daily_deposit_status_color_arr[$_data['status']]; ?>"><?php echo renderLang($daily_deposit_status_arr[$_data['status']]); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <?php 
                                                $sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.id = :id");
                                                $sql->bindParam(":id", $sub_property_id);
                                                $sql->execute();
                                                $data = $sql->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <input type="text" class="form-control input-readonly" value="<?php echo $data['sub_property_name'].' ['.$data['property_name'].']'; ?>" readonly>
                                            <input type="hidden" name="sub_property_id" value="<?php  echo $sub_property_id; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date"><?php echo renderLang($daily_collection_date); ?></label>
                                            <input type="text" class="form-control input-readonly" name="date" id="date" value="<?php echo checkVar($date) ? formatDate($date) : ''; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="deposit_date"><?php echo renderLang($collections_daily_deposit_deposit_date); ?></label>
                                            <input type="text" class="form-control date" name="deposit_date" id="deposit_date" value="<?php echo formatDate($_data['deposit_date']); ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
                                                <th><?php echo renderLang($collections_check_voucher_amount); ?></th>
                                                <th><?php echo renderLang($collections_or_number); ?></th>
                                                <th><?php echo renderLang($collections_daily_deposit_payment); ?></th>
                                                <th><?php echo renderLang($daily_collections_daily_collection_transaction_details); ?></th>
                                                <th><?php echo renderLang($collections_daily_deposit_slip_reference_number); ?></th>
                                                <th><?php echo renderLang($collections_check_voucher_bank); ?></th>
                                                <th><?php echo renderLang($daily_collection_date); ?></th>
                                                <th><?php echo renderLang($collections_daily_deposit_recorded_date); ?></th>
                                                <th><?php echo renderLang($collections_daily_deposit_reference_number); ?></th>
                                                <th><?php echo renderLang($lang_status); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql = $pdo->prepare("SELECT *,dcpt.id as dcpt_id FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.temp_del = 0 AND dc.sub_property_id = :id AND dc.collection_date = :date AND voucher_type <> 3");
                                            $sql->bindParam(":id", $sub_property_id);
                                            $sql->bindParam(":date", $date);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        // unit
                                                        echo '<td>';
                                                            $unit_names = array();
                                                            $unit_ids = explode(',', $data['unit_id']);
                                                            foreach($unit_ids as $unit_id) {
                                                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                if(checkVar($unit_name)) {
                                                                    $unit_names[] = $unit_name;
                                                                } else {
                                                                    $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
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
                                                        
                                                        echo '<td class="amount text-'.$payment_types_color_arr[$data['payment_type']].'" data-amount="'.$data['amount'].'">'.$data['amount'].'</td>';
                                                        echo '<td>';
                                                            if(checkVar($data['or_number'])) {
                                                                echo 'OR ['.$data['or_number'].']';
                                                            } else if(checkVar($data['ar_number'])) {
                                                                echo 'AR ['.$data['ar_number'].']';
                                                            }
                                                        echo '</td>';
                                                        echo '<td class="payment text-'.$payment_types_color_arr[$data['payment_type']].'" data-payment="'.$data['payment_type'].'">'.renderLang($payment_types_arr[$data['payment_type']]).'</td>';
                                                        echo '<td>';	
                                                            if($data['payment_type'] == 2) {
                                                                echo $data['check_number'];
                                                            } 
                                                            if($data['payment_type'] == 1 || $data['payment_type'] == 3 || $data['payment_type'] == 4) {
                                                                echo $data['transaction_details'];
                                                            }
                                                        echo '</td>';
                                                        // deposit slip
                                                        echo '<td>';
                                                            echo '<input type="text" class="form-control border-0" name="deposit_slip[]" value="'.$data['deposit_slip'].'">';
                                                        echo '</td>';
                                                        // bank
                                                        echo '<td>';
                                                            if(checkVar($data['bank'])) {
                                                                if($data['bank'] == 999) {
                                                                    echo $data['other_bank'];
                                                                } else {
                                                                    echo renderLang($banks_arr[$data['bank']]);
                                                                }
                                                            }
                                                        echo '</td>';
                                                        echo '<td>'.formatDate($data['collection_date']).'</td>';
                                                        // date deposited
                                                        echo '<td>';
                                                            echo formatDate($data['recorded_date']);
                                                        echo '</td>';
                                                        // Reference
                                                        echo '<td>';
                                                            echo '<input type="text" class="form-control border-0 reference-number '.($_data['status'] ? 'input-readonly' : '').'" name="reference_number[]" value="'.$data['reference_number'].'" '.($_data['status'] ? 'readonly' : '').'>';
                                                            echo '<input type="hidden" name="payment_type_id[]" value="'.$data['dcpt_id'].'">';
                                                        echo '</td>';
                                                        // Status
                                                        echo '<td>';
                                                            echo '<span class="badge status badge-'.$daily_collection_report_collection_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_collection_status_arr[$data['status']]).'</span>';
                                                        echo '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <th colspan=2><?php echo renderLang($collections_daily_deposit_total_breakdown); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach($payment_types_arr as $key => $payment_type) {
                                                        echo '<tr>';
                                                            echo '<th>'.renderLang($payment_type).'</th>';
                                                            echo '<td><input type="text" class="form-control border-0 input-readonly" id="payment_'.$key.'" readonly></td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><?php echo renderLang($collections_daily_deposit_total); ?></th>
                                                        <td><input type="text" class="form-control border-0 input-readonly" id="total_deposited" name="total_deposited" readonly></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <th><?php echo renderLang($collections_daily_deposit_reference); ?></th>
                                                        <th><?php echo renderLang($lang_attachments); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM daily_deposit_reference WHERE deposit_id  = :id");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                            echo '<input type="hidden" name="reference_id[]" value="'.$data['id'].'">';
                                                            echo '<td>';
                                                                echo '<input type="text" class="form-control border-0" name="deposit_reference[]" value="'.$data['deposit_reference'].'">';
                                                            echo '</td>';

                                                            echo '<td>';
                                                                renderAttachments($data['attachments'], 'daily-deposit');
                                                                echo '<input type="file" class="form-control border-0" name="attachment[]">';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                    <tr class="default-row <?php echo $sql->rowCount() ? 'd-none' : ''; ?>">
                                                        <input type="hidden" name="reference_id[]" value="0">
                                                        <td><input type="text" class="form-control border-0" name="deposit_reference[]"></td>
                                                        <td><input type="file" class="form-control border-0" name="attachment[]"></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <?php if($_data['status'] == 0 || $_data['status'] == 4) { ?>
                                                    <tr>
                                                        <td colspan="2" class="text-right border-0">
                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <?php if($_data['status'] == 0 || $_data['status'] == 4) { ?>
                                <!-- Status -->
								<div class="row mt-2">
									<div class="col-12 text-right">
										<div class="icheck-primary">
											<input type="checkbox" id="save-status" name="status" value="0">
											<label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
										</div>
									</div>
								</div>
								<?php } ?>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/daily-deposit-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <?php if(($_data['status'] == 0 || $_data['status'] == 4) && checkPermission('daily-deposit-edit')) { ?>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($collections_daily_deposit_update); ?></button>
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
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
	$(function(){

        // check status base on reference number
        $('body').on('change', '.reference-number', function() {

            var reference = $(this).val();
            reference = reference.trim();

            if(reference) {
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

        // change save status 
		$('#save-status').on('change', function(){

            if($(this).is(':checked')) {
                $(this).val('1');
                $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');

            } else {
                $(this).val('0');
                $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
            }

        });

        $(document).on('click', '[data-toggle="lightbox"]', function(e) {
            e.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

		$('body').on('click', '.add-row', function(e){
			e.preventDefault();

			var fields = '<tr>'+$(this).closest('table').find('.default-row').html()+'</tr>';
			$(this).closest();

        });

        // total breakdown
        total_breakdown();

        // add row
        $('.add-row').on('click', function(e) {
            e.preventDefault();

            var fields = $(this).closest('table').find('.default-row').html();
            $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');

        });

    });
    
    // total cash breakdown
    function total_breakdown() {

        var cash = 0;
        var direct = 0;
        var check = 0;
        var credit_card = 0;
        var bills = 0;
        var others = 0;
        var total_deposited = 0;
        
        var payment_types_arr = <?php echo json_encode($payment_types_arr); ?>;
        var payment_keys = [];

        $.each(payment_types_arr, function(key, data) {
            payment_keys.push(key);
        });

        $('.payment').each(function(){
            var payment_type = $(this).data('payment');
            var amount = $(this).closest('tr').find('.amount').data('amount');
            amount = convertCurrency(amount);

            total_deposited += amount;

            if(inArray(payment_type, payment_keys)) {
                switch(payment_type) {
                    case 0:
                        cash += amount;
                        break;
                    case 1:
                        direct += amount;
                        break;
                    case 2:
                        check += amount;
                        break;
                    case 3:
                        credit_card += amount;
                        break;
                    case 4:
                        bills += amount;
                        break;
                    default:
                        others += amount;
                }
            }

        });

        $.each(payment_types_arr, function(key, data) {
            var value = 0;
            switch(key) {
                case 0:
                    value = cash;
                    break;
                case 1:
                    value = direct;
                    break;
                case 2:
                    value = check;
                    break;
                case 3:
                    value = credit_card;
                    break;
                case 4:
                    value = bills;
                    break;
            }
            $('#payment_'+key).val(convert_to_currency(value, "blur"));
        });

        $('#total_deposited').val(convert_to_currency(total_deposited, "blur"));

    }
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