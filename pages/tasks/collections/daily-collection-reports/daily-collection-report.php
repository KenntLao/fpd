<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collection-reports')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';
		
		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT *,dcr.status FROM daily_collection_reports dcr LEFT JOIN sub_properties sp ON(dcr.sub_property_id = sp.id) WHERE dcr.id = :id AND dcr.temp_del = 0 LIMIT 1");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
		} else {
			$_SESSION['sys_daily_collection_report_edit_err'] = renderLang($lang_no_data);
			header('location: /daily-collection-reports');
			exit();
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collection_report); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($daily_collection_report); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderSuccess('sys_daily_collection_report_status_suc');
					?>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($daily_collection_report); ?></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-<?php echo $daily_collection_report_status_color_arr[$_data['status']]; ?>"><?php echo renderLang($daily_collection_report_status_arr[$_data['status']]); ?></button>
							</div>
						</div>
						<div class="card-body">

							<div class="row">

								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
										<input type="text" class="form-control input-readonly" value="<?php echo $_data['sub_property_name'].' ['.getField('property_name', 'properties', 'id = '.$_data['property_id']).']'; ?>" readonly>
									</div>
								</div>

								<div class="col-lg-3 col-md-4 d-none">
									<div class="form-group">
										<label for="report_date"><?php echo renderLang($daily_collection_report_date); ?></label>
										<input type="text" class="form-control input-readonly" name="report_date" id="report_date" value="<?php echo formatDate($_data['report_date']); ?>" readonly>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label for="collection_date"><?php echo renderLang($daily_collection_date); ?></label>
										<input type="text" class="form-control input-readonly" name="collection_date" id="collection_date" value="<?php echo formatDate($_data['collection_date']); ?>" readonly>
									</div>
								</div>

							</div>

							<div class="row">

								<div class="col-12">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-condensed text-center">
											<thead>
												<tr>
													<th rowspan="2"><p class="w100"><?php echo renderLang($lang_date); ?></p></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_receipt_type); ?></p></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_receipt_no); ?></p></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($daily_collections_daily_collection_unit); ?></p></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_particulars); ?></p></th>
													<th colspan="<?php echo count($payment_types_arr); ?>" class="bg-gray"><?php echo renderLang($daily_collections_daily_collection_amount); ?></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($daily_collections_daily_collection_bank_name); ?></p></th>
													<th rowspan="2"><p class="w100"><?php echo renderLang($lang_status); ?></p></th>
												</tr>
												<tr>
													<?php 
													foreach($payment_types_arr as $payment) {
														echo '<th><p class="w150">'.renderLang($payment).'</p></th>';
													}
													?>
												</tr>
											</thead>
											<tbody id="table-data">
												
											</tbody>
											<tfoot>
												<tr>
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
												</tr>
											</tfoot>
										</table>
									</div>
								</div>

							</div>

                            <!-- bills and coins -->
                            <div class="row mt-5">

                                <div class="col-lg-6 p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_cash_on_hand); ?></th>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_denomination); ?></th>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_quantity); ?></th>
                                                    <th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach($pcc_cash_on_hand_arr as $key => $bills) {

                                                    $sql = $pdo->prepare("SELECT * FROM daily_collection_report_cash_count WHERE collection_report_id = :id AND denomination = :key");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->bindParam(":key", $key);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    echo '<tr>';
                                                        echo '<input type="hidden" name="cash_count_id[]" value="'.$data['id'].'">';
                                                        echo '<td>'.renderLang($bills[0]).'</td>';
                                                        echo '<td><p class="m-0">'.$bills[1].'</p><input type="hidden" name="denomination[]" value="'.$key.'" class="denomination" data-val="'.$bills[1].'"></td>';
                                                        echo '<td class="p-0"><input type="number" min="0" class="form-control border-0 quantity input-readonly" name="quantity[]" value="'.$data['quantity'].'" readonly></td>';
                                                        echo '<td class="p-0"><input type="text" min="0" class="form-control border-0 amount input-readonly" name="amount[]" readonly value="'.$data['amount'].'"></td>';

                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3"><?php echo $_SESSION['sys_language'] ? renderLang($pre_operation_audit_iad_total_bills_and_coins) : strtoupper(renderLang($pre_operation_audit_iad_total_bills_and_coins)); ?></th>
                                                    <td class="p-0"><input type="text" min="0" class="form-control border-0 input-readonly" id="total-bills" name="bills_total" readonly></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                
                                <div class="col-lg-6 p-3">
                                
                                    <?php if(checkPermission('daily-collection-report-overage')) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <th><?php echo renderLang($undeposited_cash); ?></th>
                                                <td class="p-0"><input type="text" class="form-control border-0 cash-total input-readonly" readonly></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($daily_collection_report_total_deposited); ?></th>
                                                <td class="p-0"><input type="text" class="form-control border-0 total-deposited input-readonly" readonly></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
                                                <td class="p-0"><input type="text" class="form-control border-0 total-bills input-readonly" readonly></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
                                                <td class="p-0"><input type="text" class="form-control border-0 overage input-readonly" readonly></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php 
                                    if(checkPermission('daily-collection-report-comment')) {

                                        $sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'daily-collection-report' AND module_type = 'overage' AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
                                        $sql->bindParam(":id", $id);
                                        $sql->execute();
                                    ?>
                                        <div class="card direct-chat direct-chat-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo renderLang($lang_remarks); ?></h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="direct-chat-messages">

                                                    <?php 
                                                    if($sql->rowCount()) {
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            
                                                            if($_SESSION['sys_id'] == $data['user_id'] && $_SESSION['sys_account_mode'] == $data['user_account_mode']) {
                                                            echo '<div class="direct-chat-msg right">';
                                                                echo '<div class="direct-chat-info clearfix">';

                                                                    echo '<span class="direct-chat-name float-right">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                    echo '<span class="direct-chat-timestamp float-left">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                    echo '</div>';

                                                                    echo '<img class="direct-chat-img" src="'.$_SESSION['sys_photo'].'" alt="message user image">';

                                                                    echo '<div class="direct-chat-text">';
                                                                        echo $data['comment'];
                                                                    echo '</div>';

                                                            echo '</div>';

                                                            } else {

                                                            echo '<div class="direct-chat-msg">';
                                                                echo '<div class="direct-chat-info clearfix">';

                                                                    echo '<span class="direct-chat-name float-left">'.getFullName($data['user_id'], $data['user_account_mode']).'</span>';
                                                                    echo '<span class="direct-chat-timestamp float-right">'.formatDate($data['comment_date'], true, false, true).'</span>';

                                                                echo '</div>';

                                                                    if($data['user_account_mode'] == 'user') {
                                                                        $photo = '/assets/images/profile/default.png';
                                                                    } else {
                                                                        $gender = getField('gender', 'employees', 'id = '.$data['user_id']);
                                                                        $photo = getField('photo', 'employees', 'id = '.$data['user_id']);
                                                                        if(!checkVar($photo)) {
                                                                            switch($gender) {
                                                                                case 0:
                                                                                    $photo = '/dist/img/avatar2.png';
                                                                                    break;
                                                                                case 1:
                                                                                    $photo = '/dist/img/avatar5.png';
                                                                            }
                                                                        }
                                                                    }

                                                                    echo '<img class="direct-chat-img" src="'.(!empty($photo) ? $photo : '/dist/img/avatar2.png').'" alt="message user image">';

                                                                    echo '<div class="direct-chat-text">';
                                                                        echo $data['comment'];
                                                                    echo '</div>';
                                                            echo '</div>';

                                                            }

                                                                
                                                        }
                                                    } else {
                                                        echo renderLang($lang_no_remarks);
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <?php if(checkPermission('daily-collection-report-comment-add')) { ?>
                                                    <form action="" method="post" id="comment-form">
                                                    <div class="input-group">
                                                        <input type="text" name="comment" placeholder="" class="form-control">
                                                        <span class="input-group-append">
                                                            <button id="add-comment" class="btn btn-primary">Send</button>
                                                        </span>
                                                    </div>
                                                    <p id="err_msg" class="error-message text-danger mt-1"></p>
                                                    </form>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>

                            </div>

						</div>
						<div class="card-footer text-right">
							<a href="/daily-collection-reports" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
							<?php if($_data['status'] == 1 && checkPermission('daily-collection-report-verify')) { ?>
                                <!-- return -->
                                <button class="btn btn-danger update-status" data-status="4"><i class="fa fa-times mr-1"></i><?php echo renderLang($lang_return); ?></button>
								<!-- verify -->	
								<button class="btn btn-info update-status" data-status="2"><i class="fa fa-check mr-2"></i><?php echo renderLang($lang_verify); ?></button>
							<?php } ?>

							<?php if($_data['status'] == 2 && checkPermission('daily-collection-report-approve')) { ?>
								<!-- approve -->
								<button class="btn btn-success update-status" data-status="3"><i class="fa fa-thumbs-up mr-1"></i><?php echo renderLang($lang_approve); ?></button>
							<?php } ?>
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
    $(function(){

        // add comment
        $('#comment-form').on('submit', function(e){
            e.preventDefault();

            var comment = $('input[name="comment"]').val();
            var module = 'daily-collection-report';
            var module_type = "overage";
            var module_id = <?php echo $id; ?>;

            $.post('/add-comment', {
                comment:comment, module:module, 
                module_type:module_type, module_id:module_id
            }, function(data){
                window.location.reload();
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
        var sub_property_id = <?php echo $_data['sub_property_id']; ?>;
		var date = $('#collection_date').val();
		var type = 'view';

        $.post('/render-daily-collections', {
			id:sub_property_id, date:date,
			type:type
        }, function(data){

            $('#table-data').html(data);

            compute_sub_total();
            compute_grand_total();

		}).done(function(){

            var total_bill = $('.total-bills').val();
            total_bill = convertCurrency(total_bill);
            var cash = $('.cash-total').val();
            cash = convertCurrency(cash);
            var deposited = $('.total-deposited').val();
            deposited = convertCurrency(deposited);
            var total_cash = cash - deposited;
            var overage = total_cash - total_bill;
            var sign = Math.sign(overage);
            if(sign > 0) {
                $('.overage').val('+ '+convert_to_currency(overage, "blur"));
            } 
            if(sign < 0) {
                $('.overage').val('- '+convert_to_currency(overage, "blur"));
            }
            if(sign == 0) {
                $('.overage').val(convert_to_currency(overage, "blur"));
            }

        });

        var total = 0;
        $('.amount').each(function(){
            var amount = $(this).val();
            amount = convertCurrency(amount);
            
            total += amount;
            
            $('#total-bills').val(convert_to_currency(total, "blur"));
            $('.total-bills').val(convert_to_currency(total, "blur"));
            $('.total-bills').attr("value", convert_to_currency(total, "blur"));

        });
		
		// update status of daily collection report
		$('.update-status').on('click', function(e){
			e.preventDefault();

			var status = $(this).data('status');
			var id = <?php echo $id; ?>;

			$.post("/update-daily-collection-report-status", {
				id:id, status:status
			}, function(data){
				window.location.reload();
			});

		});

    });

    function compute_sub_total() {
        // compute totals of each amount
        // cash
        var sub_total_cash = 0;
        var total_deposited = 0;
        $('.cash').each(function(){
            var cash = $(this).html();
            cash = convertCurrency(cash);
            sub_total_cash += cash;

            var status = $(this).closest('tr').find('.stat').data("status");
            if(status == 1) {
                total_deposited += cash;
            }
        });
        $('.total-deposited').val(convert_to_currency(total_deposited, "blur"));
        $('.sub_total0').html(convert_to_currency(sub_total_cash, "blur"));
        $('.cash-total').val(convert_to_currency(sub_total_cash, "blur"));
        $('.cash-total').attr("value", convert_to_currency(sub_total_cash, "blur"));

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