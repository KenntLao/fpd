<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-add')) {

    $page = 'operation-audit';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($audits_iad_on_hand_collections_add); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($audits_iad_on_hand_collections_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderError('sys_count_sheet_add_err');
                    ?>

                    <form action="/submit-add-count-sheet" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_iad_count_sheet); ?></h3>
                            </div>
                            <div class="card-body">

                                <!-- category -->
                                <input type="hidden" name="category" value="on-hand-collection">

                                <!-- PROSPECT -->
                                <div class="row">
                                    <!--property -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id"><?php echo renderLang($audits_project); ?></label>
                                            <select name="property_id" id="property_id" class="form-control select2">
                                                <?php
                                                if($_SESSION['sys_account_mode'] == "user") { // users
                                                    $sql = $pdo->prepare("SELECT id, property_name FROM properties WHERE temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                    }
                                                } else { // employees
                                                    $property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];
                                                    $properties = "0";
                                                    if(!empty($property_ids)) {
                                                        $properties = implode(", ", $property_ids);
                                                    }
                                                    $sql = $pdo->prepare("SELECT id, property_name FROM properties WHERE temp_del = 0 AND id IN ($properties)");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- cashier -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="cashier"><?php echo renderLang($pre_operation_audit_iad_cashier); ?></label>
                                            <input type="text" class="form-control" name="cashier" id="cashier">
                                        </div>
                                    </div>

                                </div>

                                <!-- BILLS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-bills" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_iad_bills); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-bills">

                                            <div class="card card-body">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_cash_on_hand); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_denomination); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_quantity); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
                                                                        <th class="d-none"><?php echo renderLang($pre_operation_audit_pcc_total); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    foreach($pcc_cash_on_hand_arr as $key => $bills) {
                                                                        echo '<tr>';

                                                                        echo '<td class="p-0">';
                                                                            echo '<input type="text" class="form-control border-0 input-readonly" value="'.renderLang($bills[0]).'" readonly>';
                                                                        echo '</td>';
                                                                        echo '<td class="p-0">';
                                                                            echo '<input type="text" class="form-control border-0 input-readonly denomination" value="'.$bills[1].'" readonly>';
                                                                            echo '<input type="hidden" name="denomination[]" value="'.$key.'">';
                                                                        echo '</td>';
                                                                        echo '<td class="p-0"><input type="number" min="0" class="form-control border-0 quantity" name="quantity[]"></td>';
                                                                        echo '<td class="p-0"><input type="text" min="0" class="form-control border-0 amount" name="amount[]"></td>';
                                                                        echo '<td class="p-0 d-none"><input type="number" min="0" class="form-control border-0" name="total[]"></td>';

                                                                        echo '</tr>';
                                                                    }
                                                                    ?>
                                                                    
                                                                </tbody>
                                                                <tbody>
                                                                    <tr>
                                                                        <th colspan="3" class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
                                                                        <td class="p-0"><input type="text" min="0" class="form-control border-0 input-readonly" id="bills_total" name="bills_total" readonly></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- CHECKS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-checks" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_iad_checks); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-checks">

                                            <div class="card card-body">

                                               <div class="row">
                                                   <div class="col-12">
                                                       <div class="table-responsive">
                                                           <table class="table table-bordered table-hover">
                                                               <thead>
                                                                    <tr>
                                                                        <th><?php echo renderLang($pre_operation_audit_iad_or_ar_no); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_iad_bank); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_date); ?></th>
                                                                        <th><?php echo renderLang($pre_operation_audit_pcc_amount); ?></th>
                                                                    </tr>
                                                               </thead>
                                                               <tbody>
                                                                    <tr class="default-row">
                                                                        <td class="p-0">
                                                                            <input type="text" min="0" class="form-control border-0" name="check_or[]">
                                                                        </td>
                                                                        <td class="p-0">
                                                                            <input type="text" min="0" class="form-control border-0" name="check_bank[]">
                                                                        </td>
                                                                        <td class="p-0">
                                                                            <input type="text" min="0" class="form-control border-0 date" name="check_date[]">
                                                                        </td>
                                                                        <td class="p-0">
                                                                            <input type="text" min="0" data-type="currency" class="form-control border-0 check_amount" name="check_amount[]">
                                                                        </td>
                                                                    </tr>
                                                               </tbody>
                                                               <tfoot>
                                                                    <tr>
                                                                        <th colspan="3"><?php echo $_SESSION['sys_language'] ? renderLang($pre_operation_audit_iad_total_checks) : strtoupper(renderLang($pre_operation_audit_iad_total_checks)); ?></th>
                                                                        <td class="p-0">
                                                                            <input type="text" min="0" class="form-control border-0 input-readonly" name="checks_total" id="checks_total" readonly>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" class="text-right border-0">
                                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                        </td>
                                                                    </tr>
                                                               </tfoot>
                                                           </table>
                                                       </div>
                                                   </div>
                                               </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- UNDEPOSITED COLLECTIONS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-undeposited" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($on_hand_collections_undeposited_collection); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-undeposited">

                                            <div class="card card-body">
                                            
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed text-center">
                                                        <thead>
                                                            <th class="w35"></th>
                                                            <th><?php echo renderLang($on_hand_collections_or_ar_number); ?></th>
                                                            <th><?php echo renderLang($lang_date); ?></th>
                                                            <th><?php echo renderLang($on_hand_collections_payee); ?></th>
                                                            <th><?php echo renderLang($on_hand_collections_particulars); ?></th>
                                                            <th><?php echo renderLang($on_hand_collections_check_number); ?></th>
                                                            <th><?php echo renderLang($on_hand_collections_amount); ?></th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <button class="btn btn-sm btn-danger remove-row"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0" name="or_number[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 date" name="date[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0" name="payee[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0" name="particulars[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0" name="check_number[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 undeposited_amount" data-type="currency" name="undeposited_amount[]">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="5" class="border-0"></td>
                                                                <th class="border-0 text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 input-readonly" id="total" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7" class="text-right border-0">
                                                                    <button class="btn btn-info btn-sm add-row-undeposited"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- TOTAL -->
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="total_bills" id="total_bills"></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_checks); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="total_checks" id="total_checks"></td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="total_per_count1" id="total_per_count1"></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-white border-0 pl-0"><b><?php echo renderLang($pre_operation_audit_others); ?></b></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="total_others_specify">
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <input type="text" data-type="currency" class="form-control" name="total_others" id="total_others">
                                                    </td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_to_be_counted_for); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="total_to_be_counted_for" id="total_to_be_counted_for"></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td><input type="text" data-type="currency" class="form-control" name="total_per_count2" id="total_per_count2"></td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
                                                    <td><input type="text" class="form-control" name="total_overage" id="overage"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- INITIAL FINDINGS -->
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="width: 50%;"><?php echo renderLang($pre_operation_audit_iad_initial_findings_and_observation); ?></th>
                                                        <th  rowspan="2" ><?php echo renderLang($pre_operation_audit_remarks); ?></th>
                                                        <th colspan="2" class="text-center"><?php echo renderLang($pre_operation_audit_iad_compliance); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="w55"><?php echo renderLang($lang_yes); ?></th>
                                                        <th class="w55"><?php echo renderLang($lang_no); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $num = 1;
                                                    foreach($iad_audit_initial_findings_arr as $key => $item) { 
                                                        echo '<tr>';

                                                        echo '<td><p>'.$num.'. '.renderLang($item).'</p><input type="hidden" name="item[]" value="'.$key.'"></td>';
                                                        echo '<td><input type="text" name="initial_remarks[]" class="form-control border-0"></td>';
                                                        
                                                        echo '<td class="chk text-center"><button class="btn btn-success d-none YES" data-val="YES"><i class="fa fa-check"></i></button></td>';

                                                        echo '<td class="chk text-center"><button class="btn btn-success d-none NO" data-val="NO"><i class="fa fa-check"></i></button></td>';

                                                        echo '<input type="hidden" name="compliance[]" value="">';

                                                        echo '</tr>';

                                                        $num++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- CERTIFICATION -->
                                <div class="row mt-5">

                                    <div class="col-12 text-center">
                                        <p><b><?php echo renderLang($pre_operation_audit_pcc_certification); ?></b></p>
                                    </div>

                                    <div class="col-lg-6 col-md-12 text-left">
                                        <p><?php echo renderLang($pre_operation_audit_pcc_hereby); ?></p>
                                    </div>

                                    <!-- 1. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>1. <?php echo renderLang($pre_operation_audit_iad_certify_part_1); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom w200 text-center" name="certify_type">
                                            <?php echo renderLang($pre_operation_audit_iad_certify_part_2); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom w300 text-center" name="certify_amount">
                                            (Php<input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom text-center" name="certify_amount_value" data-type="currency">)
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part2); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom w200 text-center" name="certify_counted_by">
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part3); ?>
                                            <input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom date text-center" name="certify_date">
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part4); ?>
                                            <input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom w200 text-center" name="certify_location">
                                        </p>
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

                                <!-- ACKNOWLEDGEMENT -->
                                <div class="row mt-5">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="counted_by"><?php echo renderLang($pre_operation_audit_pcc_counted_by); ?></label>
                                            <input type="text" class="form-control certify-border border-bottom" value="<?php echo $_SESSION['sys_fullname']; ?>">
                                            <input type="hidden" class="form-control certify-border border-bottom" name="counted_by" id="counted_by" value="<?php echo $_SESSION['sys_id']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="acknowledge_by"><?php echo renderLang($pre_operation_audit_pcc_acknowledge_by); ?></label>
                                            <input type="text" class="form-control certify-border border-bottom"rder name="acknowledge_by" id="acknowledge_by">
                                        </div>
                                    </div>

                                </div>

                                <!-- CHANGE STATUS -->
                                <div class="row mt-5">
									<div class="col-12 text-right">
										<div class="icheck-primary">
											<input type="checkbox" id="save-status" name="status" value="0">
											<label for="save-status"><?php echo renderLang($lang_for_submission); ?></label>
										</div>
									</div>
								</div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/count-sheet-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary save-button"><i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?></button>
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

        // change status
        $('#save-status').on('change', function(){
            if($(this).is(":checked")) {
                $(this).val('1');
                $('.save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_for_submission); ?>');
            } else {
                $(this).val('0');
                $('.save-button').html('<i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
            }
        });

        // UNDEPOSITED ADD ROW
        $('.add-row-undeposited').on('click', function(e){
            e.preventDefault();
            var fields = $(this).closest('table').find('tbody').find('tr:nth-child(1)').html();
            $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');
            $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        // remove row
        $('body').on('click', '.remove-row', function(e){
            e.preventDefault();
            if($(this).closest('tbody').find('tr').length != 1) {
                $(this).closest('tr').remove();
                compute_total();
            } else {
                alert('last row cannot be deleted.');
            }
        });

        // get total
        $('body').on('keyup', '.undeposited_amount', function(){
            compute_total();
        });

        // CHECK ADD ROW
        $('.add-row').on('click', function(e){
            e.preventDefault();

            var fields = '<tr>'+$(this).closest('table').find('tbody').find('tr:nth-child(1)').html()+'</tr>';
            $(this).closest('table').find('tbody').append(fields);
            $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
        
        // select button
        $('tbody').on('click', '.chk', function(e){
            e.preventDefault();

            var $this = $(this);
        
            var type = $(this).find('button').data('val');

            if(type == 'YES') {
                $this.closest('tr').find('.YES').toggleClass('d-none');
                $this.closest('tr').find('.NO').addClass('d-none');
            }
            if(type == 'NO') {
                $this.closest('tr').find('.NO').toggleClass('d-none');
                $this.closest('tr').find('.YES').addClass('d-none');
            }

            $(this).closest('tr').find('input[name="compliance[]"]').val(type);

        });

        // auto compute bill amount
        $('.quantity').change(function() {
            $(this).closest('tr').find('.amount').val(compute_bill_amount($(this)));
            compute_bill_total();
            compute_total_per_count();
        }).keyup(function(){
            $(this).closest('tr').find('.amount').val(compute_bill_amount($(this)));
            compute_bill_total();
            compute_total_per_count();
        });

        // compute check total
        $('body').on('keyup', '.check_amount', function(){
            compute_check_total();
            compute_total_per_count();
        });
        
        // compute total per count
        $('body #total_bills, #total_checks, #total_others').keyup(function() {
            compute_total_per_count();
        }).blur(function(){
            compute_total_per_count();
        });

        // compute overage
        $('body #total_to_be_counted_for').keyup(function(){
            compute_total_per_count();
        }).blur(function(){
            compute_total_per_count();
        });

    });
    function compute_bill_amount(field) {
        var amount = 0;
        var quantity = parseInt(field.val());
        var denomination = convertCurrency(field.closest('tr').find('.denomination').val());
        amount = quantity * denomination;
        return convert_to_currency(amount.toFixed(3), "blur");
    }
    function compute_bill_total() {
        var bill_total = 0;
        $('.amount').each(function() {
            var amount = convertCurrency($(this).val());
            bill_total += amount;
        });
        var total =  convert_to_currency(bill_total.toFixed(3), "blur");
        $('#bills_total').val(total);
        $('#total_bills').val(total);
    }
    function compute_check_total() {
        var check_total = 0;
        $('.check_amount').each(function(){
            var check_amount = convertCurrency($(this).val());
            check_total += check_amount;
        });
        var total = convert_to_currency(check_total.toFixed(3), "blur");
        $('#checks_total').val(total);
        $('#total_checks').val(total);
    }
    function compute_total_per_count() {
        var total_bills = convertCurrency($('#total_bills').val());
        var total_checks = convertCurrency($('#total_checks').val());
        var total_others = convertCurrency($('#total_others').val());
        var total_per_count = total_bills + total_checks + total_others;
        total_per_count = convert_to_currency(total_per_count.toFixed(3), "blur");
        $('#total_per_count1').val(total_per_count);
        $('#total_per_count2').val(total_per_count);
        compute_overage_shortage();
    }
    function compute_overage_shortage() {
        var total_per_count = convertCurrency($('#total_per_count1').val());
        var total_to_be_counted_for = convertCurrency($('#total_to_be_counted_for').val());
        var overage = total_per_count - total_to_be_counted_for;
        var sign = Math.sign(overage);
        if(sign > 0) {
            $('#overage').val('+ '+convert_to_currency(overage, "blur"));
        } 
        if(sign < 0) {
            $('#overage').val('- '+convert_to_currency(overage, "blur"));
        }
        if(sign == 0) {
            $('#overage').val(convert_to_currency(overage, "blur"));
        }
    }
    function compute_total() {
        var undeposited_total = 0;
        $('.undeposited_amount').each(function(){
            var amount = convertCurrency($(this).val());
            undeposited_total += amount;
        });
        var total = convert_to_currency(undeposited_total.toFixed(3), "blur");
        $('#total').val(total);
        $('#total_to_be_counted_for').val(total);
        compute_overage_shortage();
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