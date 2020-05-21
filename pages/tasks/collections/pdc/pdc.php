<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pdc')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';

        // full name
        $current_user_full_name = getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']);
    
	
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
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($pdc); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_daily_collection_report_add_err');
                    ?>

                    <form action="/submit-pdc-add" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pdc_add_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 required">
                                            <?php 
											if($_SESSION['sys_account_mode'] == 'user') {

												$sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
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

                                <div class="row">
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="collection_date"><?php echo renderLang($daily_collection_date); ?></label>
                                            <input type="text" class="form-control date" name="collection_date" id="collection_date">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-12">
                                        <label><?php echo renderLang($pdc_dated_checks_for_deposit); ?></label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed text-center">
                                                <thead>
                                                    <tr class="bg-gray">
                                                        <th><?php echo renderLang($lang_date); ?></th>
                                                        <th><?php echo renderLang($pdc_pr_number); ?></th>
                                                        <th><?php echo renderLang($pdc_unit_number); ?></th>
                                                        <th><?php echo renderLang($pdc_payor); ?></th>
                                                        <th><?php echo renderLang($daily_collection_report_particulars); ?></th>
                                                        <th><?php echo renderLang($pdc_amount); ?></th>
                                                        <th><?php echo renderLang($pdc_date_on_check); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-12">
                                        <label><?php echo renderLang($pdc_monitoring); ?></label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed text-center">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_date); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_pr_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_unit_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_payor); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_particulars); ?></p></th>
                                                        <th colspan="3" class="bg-gray"><?php echo renderLang($pdc_check_details); ?></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_date_deposited); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_receipt_type); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_receipt_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_status); ?></p></th>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($pdc_amount); ?></th>
                                                        <th><?php echo renderLang($pdc_bank_check_number); ?></th>
                                                        <th><?php echo renderLang($pdc_date_on_check); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-data">
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <!-- <tr>
                                                        <td class="text-right" colspan="12">
                                                            <button class="btn btn-info btn-sm"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr> -->
                                                    <!-- <tr>
                                                        <th colspan="5" class="text-uppercase"><?php echo renderLang($daily_collection_report_sub_total); ?></th>
                                                        <?php 
                                                        foreach($payment_types_arr as $key => $payment) {
                                                            echo '<td><p class="sub_total'.$key.'"></p></td>';
                                                        }
                                                        ?>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="5" class="text-uppercase"><?php echo renderLang($daily_collection_report_grand_total); ?></th>
                                                        <th><input type="text" class="form-control input-readonly border-0 grand-total text-center font-weight-bold" name="grand_total" readonly></th>
                                                        <th colspan="7"></th>
                                                    </tr> -->
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <br>

                                <div class="row mt-5">

                                    <div class="col-lg-3 col-md-4">
                                        <label for="prepared_by"><?php echo renderLang($pdc_updated_by); ?></label>
                                        <input type="text" class="form-control input-readonly" name="prepared_by" value="<?php echo $current_user_full_name; ?>" readonly>
                                        <p>Cashier</p>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <label for="date_time"><?php echo renderLang($pdc_date_time); ?></label>
                                        <input type="text" class="form-control" name="date_time">
                                    </div>
                                    
                                </div><!-- row -->

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
                                <a href="/pdc-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary" id="save-button"><i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?></button>
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

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        // change save status 
		$('#save-status').on('change', function(){

            if($(this).is(':checked')) {
                $(this).val('1');
                $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
                $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_for_submission); ?>');

            } else {
                $(this).val('0');
                $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                $('#save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
            }

        });

        // render daily collections base on building and date
        var sub_property_id = $('#sub_property_id').val();
        var date = $('#collection_date').val();

        $.post('/render-daily-collections', {
            id:sub_property_id, date:date
        }, function(data){

            $('#table-data').html(data);

            compute_sub_total();
            compute_grand_total()

        });

        // render daily collections on building and date changes
        $('#sub_property_id, #collection_date').on('change', function(){

            sub_property_id = $('#sub_property_id').val();
            date = $('#collection_date').val();

            $.post('/render-daily-collections', {
                id:sub_property_id, date:date
            }, function(data){

                $('#table-data').html(data);

                compute_sub_total();
                compute_grand_total();

            });

        });

    });

    function compute_sub_total() {
        // compute totals of each amount
        // cash
        var sub_total_cash = 0;
        $('.cash').each(function(){
            var cash = $(this).html();
            cash = convertCurrency(cash);
            sub_total_cash += cash;
        });
        $('.sub_total0').html(convert_to_currency(sub_total_cash, "blur"));

        // direct_deposit
        var sub_total_direct_deposit = 0;
        $('.direct_deposit').each(function(){
            var direct_deposit = $(this).html();
            direct_deposit = convertCurrency(direct_deposit);
            sub_total_direct_deposit += direct_deposit;
        });
        $('.sub_total1').html(convert_to_currency(sub_total_direct_deposit, "blur"));

        // check
        var sub_total_check = 0;
        $('.check').each(function(){
            var check = $(this).html();
            check = convertCurrency(check);
            sub_total_check += check;
        });
        $('.sub_total2').html(convert_to_currency(sub_total_check, "blur"));

        // credit card
        var sub_total_credit_card = 0;
        $('.credit_card').each(function(){
            var credit_card = $(this).html();
            credit_card = convertCurrency(credit_card);
            sub_total_credit_card += credit_card;
        });
        $('.sub_total3').html(convert_to_currency(sub_total_credit_card, "blur"));

        // bills_payment
        var sub_total_bills_payment = 0;
        $('.bills_payment').each(function(){
            var bills_payment = $(this).html();
            bills_payment = convertCurrency(bills_payment);
            sub_total_bills_payment += bills_payment;
        });
        $('.sub_total4').html(convert_to_currency(sub_total_bills_payment, "blur"));
    }

    function compute_grand_total() {

        var grand_total = 0;
        var sub_total_count = <?php echo count($payment_types_arr); ?>;
        for(var i = 0; i < sub_total_count; i++) {
            var sub_total = $('.sub_total'+i).html();
            sub_total = convertCurrency(sub_total);
            grand_total += sub_total;
        }

        $('.grand-total').val(convert_to_currency(grand_total, "blur"));

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