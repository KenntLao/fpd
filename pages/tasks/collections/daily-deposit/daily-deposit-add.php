<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-deposit-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        
        $date = $_GET['date'];
        $id = $_GET['id'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_daily_deposit_new); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_daily_deposit_new); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_daily_deposit_add_err');
                    ?>

                    <form action="/submit-add-daily-deposit" method="post" enctype="multipart/form-data">
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($collections_daily_deposit); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 required">
                                                <option value="0"></option>
                                                <?php 
                                                    if($_SESSION['sys_account_mode'] == 'user') {

                                                        $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                        $sql->execute();
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }

                                                    } else {

                                                        // get clusters of user
                                                        $cluster_ids = getClusterIDs($_SESSION['sys_id']);
                                                        
                                                        // no cluster
                                                        if(empty($cluster_ids)) {

                                                            $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                            $sub_properties = explode(',', $sub_property_ids);
                                                            foreach($sub_properties as $sub_property_id) {
                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                                }
                                                            }

                                                        } else { // has cluster

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

                                                            foreach($sub_property_ids as $sub_property_id) {

                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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
                                            <label for="date"><?php echo renderLang($daily_collection_date); ?></label>
                                            <input type="text" class="form-control date" name="date" id="date" value="<?php echo formatDate($date); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="deposit_date"><?php echo renderLang($collections_daily_deposit_deposit_date); ?></label>
                                            <input type="text" class="form-control date" name="deposit_date" id="deposit_date">
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
                                            $sql->bindParam(":id", $id);
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
                                                        echo '<td class="text-'.$payment_types_color_arr[$data['payment_type']].'" data-payment="'.$data['payment_type'].'">'.renderLang($payment_types_arr[$data['payment_type']]).'</td>';
                                                        echo '<td class="payment">';	
                                                            if($data['payment_type'] == 2) {
                                                                echo $data['check_number'];
                                                            } 
                                                            if($data['payment_type'] == 1 || $data['payment_type'] == 3 || $data['payment_type'] == 4) {
                                                                echo $data['transaction_details'];
                                                            }
                                                        echo '</td>';
                                                        // deposit_slip
                                                        echo '<td>';
                                                            echo '<input type="text" class="form-control border-0" name="deposit_slip[]">';
                                                        echo '</td>';
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
                                                            echo '<input type="text" class="form-control border-0 reference-number" name="reference_number[]" value="'.$data['reference_number'].'">';
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
                                                    <tr class="default-row">
                                                        <td><input type="text" class="form-control border-0" name="deposit_reference[]"></td>
                                                        <td><input type="file" class="form-control border-0" name="attachment[]"></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right border-0">
                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

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
                                <a href="/daily-deposit-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($collections_daily_deposit_add); ?></button>
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

        $('#date, #sub_property_id').on('change', function(){
            var id = $('#sub_property_id').val();
            var date = $('#date').val();
            window.location.href = '/add-daily-deposit/'+date+'-'+id;
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