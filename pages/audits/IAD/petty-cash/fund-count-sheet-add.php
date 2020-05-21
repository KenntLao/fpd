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
	<title><?php echo renderLang($petty_cash_fund_count_sheet_add); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($petty_cash_fund_count_sheet_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderError('sys_fund_count_sheet_add_err');
                    ?>

                    <form action="/submit-add-fund-count-sheet" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($petty_cash_fund_count_sheet_add_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <!-- PROPERTIES -->
                                <div class="row">

                                    <!-- property -->
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

                                    <!-- custodian -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="custodian"><?php echo renderLang($pre_operation_audit_pcc_custodian); ?></label>
                                            <input type="text" class="form-control" name="custodian" id="custodian">
                                        </div>
                                    </div>

                                    <!-- amount of fund -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="amount_of_fund"><?php echo renderLang($pre_operation_audit_pcc_amount_of_fund); ?></label>
                                            <input type="text" class="form-control" name="amount_of_fund" data-type="currency" id="amount_of_fund">
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

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
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
                                                                echo '<tr>';

                                                                    echo '<td class="p-0">';
                                                                        echo '<input type="text" class="form-control border-0 input-readonly" readonly value="'.renderLang($bills[0]).'">';
                                                                    echo '</td>';
                                                                    echo '<td class="p-0">';
                                                                        echo '<input type="text" class="form-control border-0 input-readonly denomination" readonly value="'.$bills[1].'">';
                                                                        echo '<input type="hidden" name="denomination[]" value="'.$key.'">';
                                                                    echo '</td>';
                                                                    echo '<td class="p-0"><input type="number" min="0" class="form-control border-0 quantity" name="quantity[]"></td>';
                                                                    echo '<td class="p-0"><input type="text" class="form-control border-0 amount input-readonly" name="amount[]" readonly></td>';

                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3" class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
                                                                <td class="p-0"><input type="text" min="0" class="form-control border-0 input-readonly" id="bills_total" readonly></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- UNREPLENISHED VOUCHERS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-unreplenished" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($petty_cash_unreplenished_vouchers); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-unreplenished">

                                            <div class="card card-body">
                                            
                                                <div class="row ml-2">
                                                    <div class="col--lg-6">
                                                        <label><?php echo renderLang($petty_cash_legend); ?></label>
                                                        <ul class="list-unstyled">
                                                            <?php 
                                                            foreach($petty_cash_findings_status_arr as $key => $legends) {
                                                                echo '<li class="ml-2 mb-2 vouchers-findings-legend" data-key="'.$key.'" data-color="'.$petty_cash_findings_status_color_arr[$key].'">';
                                                                    echo '<button class="btn btn-legend btn-'.$petty_cash_findings_status_color_arr[$key].' '.($key == 0 ? 'btn-selected' : '').'"></button>';
                                                                    echo '<span class="ml-2 legend-label">'.renderLang($legends).'</span>';
                                                                echo '</li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th rowspan="2" class="w35"></th>
                                                                <th rowspan="2"><?php echo renderLang($lang_date); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_payee); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_particulars); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_pcv_number); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_amount); ?></th>
                                                                <th colspan="<?php echo count($petty_cash_unreplenished_legend_arr); ?>"><?php echo renderLang($petty_cash_findings); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <?php 
                                                                    foreach($petty_cash_unreplenished_legend_arr as $key => $legend) { 
                                                                        echo '<th class="w35">'.$key.'</th>';
                                                                    }
                                                                ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="p-0 text-center">
                                                                    <button class="btn btn-danger btn-sm mt-1 remove-row"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control date border-0 text-center" name="voucher_date[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="voucher_payee[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="voucher_particulars[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="voucher_pcv_no[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center unreplenished_amount" name="voucher_amount[]" data-type="currency">
                                                                </td>
                                                                <?php 
                                                                foreach($petty_cash_unreplenished_legend_arr as $key => $legend) { 
                                                                    echo '<td class="p-0 text-center vouchers-findings">';
                                                                        echo '<input type="hidden" name="voucher_findings_'.$key.'[]" value="">';
                                                                    echo '</td>';
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="4"></th>
                                                                <th class="text-center text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                                <th class="p-0">
                                                                    <input type="text" class="form-control border-0 unreplenished_total text-center">
                                                                </th>
                                                                <td class="text-right p-0" colspan="<?php echo count($petty_cash_unreplenished_legend_arr) + 6; ?>">
                                                                    <button class="btn btn-info btn-sm add-row-unreplenished mt-2"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="row">

                                                    <!-- legends -->
                                                    <div class="col-lg-6">
                                                        <ul class="list-unstyled">
                                                            <?php 
                                                            foreach($petty_cash_unreplenished_legend_arr as $key => $legend) {
                                                                echo '<li><span class="font-weight-bold">'.$key.'</span><span class="ml-4">'.renderLang($legend).'</span></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>

                                                    <!-- findings and recommendations -->
                                                    <div class="col-lg-6">
                                                        <label for="findings_recommendation"><?php echo renderLang($petty_cash_findings_and_recommendations); ?></label>
                                                        <textarea name="findings_recommendations" id="findings_recommendation" rows="3" class="form-control notes"></textarea>
                                                    </div>

                                                </div>

                                                <div class="row mt-3">

                                                    <!-- PCF custodian -->
                                                    <div class="col-lg-3 col-md-4">
                                                        <label for="voucher_custodian"><?php echo renderLang($petty_cash_pcf_custodian); ?></label>
                                                        <input type="text" class="form-control" name="voucher_custodian" id="voucher_custodian">
                                                    </div>

                                                    <!-- building manager -->
                                                    <div class="col-lg-3 col-md-4">
                                                        <label for="voucher_building_manager"><?php echo renderLang($petty_cash_building_manager); ?></label>
                                                        <input type="text" class="form-control" name="voucher_building_manager" id="voucher_building_manager">
                                                    </div>

                                                </div>
                                            
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>

                                <!-- UNLIQUIDATED ADVANCES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-unliquidated" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($petty_cash_advances); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-unliquidated">

                                            <div class="card card-body">

                                                <div class="row ml-2">
                                                    <div class="col--lg-6">
                                                        <label><?php echo renderLang($petty_cash_legend); ?></label>
                                                        <ul class="list-unstyled">
                                                            <?php 
                                                            foreach($petty_cash_findings_status_arr as $key => $legends) {
                                                                echo '<li class="ml-2 mb-2 advances-findings-legend" data-key="'.$key.'" data-symbol="'.$petty_cash_findings_status_symbol_arr[$key].'">';
                                                                    echo '<button class="btn text-center'.($key == 0 ? ' btn-selected text-success' : ' text-danger').'"><i class="fa fa-'.($petty_cash_findings_status_symbol_arr[$key]).' "></i></button>';
                                                                    echo '<span class="ml-2 legend-label">'.renderLang($legends).'</span>';
                                                                echo '</li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th rowspan="2" class="w35"></th>
                                                                <th rowspan="2"><?php echo renderLang($lang_date); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_payee); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_particulars); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_pcv_number); ?></th>
                                                                <th rowspan="2"><?php echo renderLang($petty_cash_amount); ?></th>
                                                                <th colspan="<?php echo count($petty_cash_advances_lengend_arr); ?>"><?php echo renderLang($petty_cash_findings); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <?php 
                                                                    foreach($petty_cash_advances_lengend_arr as $key => $legend) { 
                                                                        echo '<th class="w35">'.$key.'</th>';
                                                                    }
                                                                ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="p-0 text-center">
                                                                    <button class="btn btn-danger btn-sm mt-1 remove-row"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control date border-0 text-center" name="advances_date[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="advances_payee[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="advances_particulars[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center" name="advances_pcv_no[]">
                                                                </td>
                                                                <td class="p-0">
                                                                    <input type="text" class="form-control border-0 text-center unliquidated-amount" name="advances_amount[]" data-type="currency">
                                                                </td>
                                                                <?php 
                                                                foreach($petty_cash_advances_lengend_arr as $key => $legend) { 
                                                                    echo '<td class="p-0 text-center advances-findings">';
                                                                        echo '<input type="hidden" name="advances_findings_'.$key.'[]" value="">';
                                                                        echo '<i class="fa mt-2"></i>';
                                                                    echo '</td>';
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="4"></th>
                                                                <th class="text-center text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                                <th class="p-0">
                                                                    <input type="text" class="form-control border-0 advances-total text-center">
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-right p-0 border-0" colspan="<?php echo count($petty_cash_unreplenished_legend_arr) + 6; ?>">
                                                                    <button class="btn btn-info btn-sm add-row-unliquidated mt-2"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="row">
                                                            
                                                    <!-- legends -->
                                                    <div class="col-lg-6">
                                                        <ul class="list-unstyled">
                                                            <?php 
                                                            foreach($petty_cash_advances_lengend_arr as $key => $legend) {
                                                                echo '<li><span class="font-weight-bold">'.$key.'</span><span class="ml-4">'.renderLang($legend).'</span></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>

                                                    <!-- PCF custodian -->
                                                    <div class="col-lg-3 col-md-6">
                                                        <label for="advances_custodian"><?php echo renderLang($petty_cash_pcf_custodian); ?></label>
                                                        <input type="text" class="form-control" name="advances_custodian" id="advances_custodian">
                                                    </div>

                                                    <!-- building manager -->
                                                    <div class="col-lg-3 col-md-6">
                                                        <label for="advances_building_manager"><?php echo renderLang($petty_cash_building_manager); ?></label>
                                                        <input type="text" class="form-control" name="advances_building_manager" id="advances_building_manager">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOTALS -->
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" class="form-control" name="bills_total" id="total">
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_unreplenished_pcv); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" class="form-control" name="unreplenished_pcv" id="unreplenished-total">
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_unliquidated_advances); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control" name="unliquidated_advances" id="unliquidated-total">
                                                    </td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control total_per_count" name="total_per_count1">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_others); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control" name="total_others" id="total_others">
                                                    </td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_books); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control" name="total_per_books" id="total_per_book">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control total_per_count" name="total_per_count2">
                                                    </td>
                                                    <th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
                                                    <td>
                                                        <input type="text" data-type="currency" min="0" class="form-control" name="overage" id="overage">
                                                    </td>
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
                                                        <th  rowspan="2" ></th>
                                                        <th colspan="2" class="text-center"><?php echo renderLang($pre_operation_audit_iad_compliance); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="w35"><?php echo renderLang($lang_yes); ?></th>
                                                        <th class="w35"><?php echo renderLang($lang_no); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $num = 1;
                                                    foreach($iad_audit_petty_cash_findings_arr as $key => $item) { 
                                                        echo '<tr>';

                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" class="form-control border-0 input-readonly" value="'.$num.'. '.renderLang($item).'" readonly>';
                                                                echo '<input type="hidden" name="item[]" value="'.$key.'">';
                                                            echo '</td>';
                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" name="remarks[]" class="form-control border-0">';
                                                            echo '</td>';
                                                            
                                                            echo '<td class="p-0 chk text-center">';
                                                                echo '<button class="btn btn-sm btn-success mt-1 d-none YES" data-val="YES"><i class="fa fa-check"></i></button>';
                                                            echo '</td>';

                                                            echo '<td class="p-0 chk text-center">';
                                                                echo '<button class="btn btn-sm btn-success mt-1 d-none NO" data-val="NO"><i class="fa fa-check"></i></button>';
                                                            echo '</td>';

                                                            echo '<input type="hidden" name="findings[]" value="">';

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
                                        <p><b class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_certification); ?></b></p>
                                    </div>

                                    <div class="col-lg-6 col-md-12 text-left">
                                        <p><?php echo renderLang($pre_operation_audit_pcc_hereby); ?></p>
                                    </div>

                                    <!-- 1. -->
                                    <div class="col-lg-10 col-md-12 text-left">
                                        <p>1. <?php echo renderLang($pre_operation_audit_iad_certify_part_1); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom text-center w200" name="certify_type">
                                            <?php echo renderLang($pre_operation_audit_iad_certify_part_2); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom text-center w350" name="certify_amount">
                                            (Php<input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom text-center" name="certify_amount_value" data-type="currency">)
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part2); ?>
                                            <input type="text" class="ml-1 mr-1 p-2 certify-border border-bottom text-center w200" name="certify_counted_by">
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part3); ?>
                                            <input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom text-center date" name="certify_date">
                                            <?php echo renderLang($pre_operation_audit_pcc_certify1_part4); ?>
                                            <input type="text" class="ml-1 mr-1 mt-1 p-2 certify-border border-bottom text-center w300" name="certify_location">
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
                                            <input type="text" class="form-control border-0" name="counted_by" id="counted_by" value="<?php echo getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']); ?>">
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
                                <a href="/fund-count-sheet-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

        $('.date').each(function(){
            $(this).daterangepicker({
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

            switch(type) {
                case "YES":
                    $this.closest('tr').find('.YES').toggleClass('d-none');
                    $this.closest('tr').find('.NO').addClass('d-none');
                    break;
                case "NO":
                    $this.closest('tr').find('.NO').toggleClass('d-none');
                    $this.closest('tr').find('.YES').addClass('d-none');
                    break;
            }
            
            if($this.find('button').hasClass('d-none')) {
                $this.closest('tr').find('input[name="findings[]"]').val("");
            } else {
                $this.closest('tr').find('input[name="findings[]"]').val(type);
            }

        });

        // auto compute cash amount
        $('body .quantity').change(function(){
            $(this).closest('tr').find('.amount').val(compute_cash_amount($(this)));
            compute_cash_total();
        }).keyup(function(){
            $(this).closest('tr').find('.amount').val(compute_cash_amount($(this)));
            compute_cash_total();
        });

        // UNREPLENISHED VOUCHERS
            // add row
            $('.add-row-unreplenished').on('click', function(e){
                e.preventDefault();
                var fields = $(this).closest('table').find('tbody').find('tr:nth-child(1)').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');
                $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.date').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
                $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.vouchers-findings').each(function() {
                    $(this).removeClass('bg-success').removeClass('bg-danger');
                    $(this).find('input').val("");
                });
            });

            // remove row
            $('body').on('click', '.remove-row', function(e){
                e.preventDefault();
                if($(this).closest('tbody').find('tr').length != 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('last row cannot be deleted');
                }
            });

            // select findings legend
            var vouchers_findings_arr = <?php echo json_encode($petty_cash_findings_status_arr); ?>;
            var vouchers_finding_key = $('#tab-unreplenished').find('.btn-selected').closest('li').data('key');
            var vouchers_finding_color = $('#tab-unreplenished').find('.btn-selected').closest('li').data('color');
            $('.vouchers-findings-legend').children().on('click', function(e){
                e.preventDefault();
                $('.vouchers-findings-legend').each(function(){
                    if($(this).find('button').hasClass('btn-selected')) {
                        $(this).find('button').removeClass('btn-selected');
                    }
                });
                $(this).parent().find('button').addClass('btn-selected');
                vouchers_finding_key = $(this).closest('li').data('key');
                vouchers_finding_color = $(this).closest('li').data('color');
            });

            // check findings
            $('body').on('click', '.vouchers-findings', function(e){
                e.preventDefault();
                if($(this).hasClass('bg-'+vouchers_finding_color)) {
                    $(this).removeClass('bg-'+vouchers_finding_color);
                    $(this).find('input').val("");
                } else {
                    $(this).removeClass('bg-success').removeClass('bg-danger');
                    $(this).addClass('bg-'+vouchers_finding_color);
                    $(this).find('input').val(vouchers_finding_key);
                }
            });

            // auto compute total amount
            $('body').on('keyup', '.unreplenished_amount', function(){
                compute_unreplenished_total();
            });
        // 

        // UNLIQUIDATED ADVANCES
            // add row
            $('.add-row-unliquidated').on('click', function(e){
                e.preventDefault();
                var fields = $(this).closest('table').find('tbody').find('tr:nth-child(1)').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');
                $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.date').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
                $(this).closest('table').find('tbody').find('tr:nth-last-child(1)').find('.advances-findings').each(function() {
                    $(this).find('i').removeClass('fa-times').removeClass('fa-check');
                    $(this).find('input').val("");
                });
            });

            // remove row
            $('body').on('click', '.remove-row', function(e){
                e.preventDefault();
                if($(this).closest('tbody').find('tr').length != 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('last row cannot be deleted');
                }
            });

            // select findings legend
            var advances_findings_arr = <?php echo json_encode($petty_cash_findings_status_arr); ?>;
            var advances_finding_key = $('#tab-unliquidated').find('.btn-selected').closest('li').data('key');
            var advances_finding_symbol = $('#tab-unliquidated').find('.btn-selected').closest('li').data('symbol');
            $('.advances-findings-legend').children().on('click', function(e){
                e.preventDefault();
                $('.advances-findings-legend').each(function(){
                    if($(this).find('button').hasClass('btn-selected')) {
                        $(this).find('button').removeClass('btn-selected');
                    }
                });
                $(this).parent().find('button').addClass('btn-selected');
                advances_finding_key = $(this).closest('li').data('key');
                advances_finding_symbol = $(this).closest('li').data('symbol');
            });

            // check findings
            $('body').on('click', '.advances-findings', function(e){
                e.preventDefault();
                if($(this).find('i').hasClass('fa-'+advances_finding_symbol)) {
                    $(this).find('i').removeClass('fa-'+advances_finding_symbol);
                    $(this).find('input').val("");
                } else {
                    $(this).find('i').removeClass('fa-times').removeClass('fa-check');
                    $(this).find('i').addClass('fa-'+advances_finding_symbol);
                    if(advances_finding_key == 0) {
                        $(this).find('i').removeClass('text-danger');
                        $(this).find('i').addClass('text-success');
                    } else {
                        $(this).find('i').removeClass('text-success');
                        $(this).find('i').addClass('text-danger');
                    }
                    $(this).find('input').val(advances_finding_key);
                }
            });

            // compute total
            $('body').on('keyup', '.unliquidated-amount', function(){
                compute_unliquidated_total();
            });
        // 

        $('#total_others').on('keyup', function(){
            compute_total_per_count();
        });

        $('#total_per_book').on('keyup', function(){
            compute_overage_shortage()
        });

    });
    function compute_cash_amount(field) {
        var amount = 0;
        var quantity = parseInt(field.val());
        var denomination = convertCurrency(field.closest('tr').find('.denomination').val());
        amount = quantity * denomination;
        return convert_to_currency(amount.toFixed(3), "blur");
    }
    function compute_cash_total() {
        var total = 0;
        $('.amount').each(function(){
            var amount = convertCurrency($(this).val());
            total += amount;
        });
        var total_cash = convert_to_currency(total.toFixed(3), "blur");
        $('#total').val(total_cash);
        $('#bills_total').val(total_cash);
        compute_total_per_count();
    }
    function compute_unreplenished_total() {
        var total = 0;
        $('.unreplenished_amount').each(function() {
            var amount = convertCurrency($(this).val());
            total += amount;
        });
        var total_currency = convert_to_currency(total.toFixed(3), "blur");
        $('.unreplenished_total').val(total_currency);
        $('#unreplenished-total').val(total_currency);
        compute_total_per_count();
    }
    function compute_unliquidated_total() {
        var total = 0;
        $('.unliquidated-amount').each(function(){
            var amount = convertCurrency($(this).val());
            total += amount;
        });
        var advances_total = convert_to_currency(total.toFixed(3), "blur");
        $('.advances-total').val(advances_total);
        $('#unliquidated-total').val(advances_total);
        compute_total_per_count();
    }
    function compute_total_per_count() {
        var total_bills = convertCurrency($('#total').val());
        var total_vouchers = convertCurrency($('#unreplenished-total').val());
        var total_advances = convertCurrency($('#unliquidated-total').val());
        var total_others = convertCurrency($('#total_others').val());
        var total_per_count = total_bills + total_vouchers + total_advances + total_others;
        var total = convert_to_currency(total_per_count.toFixed(3), "blur");
        $('.total_per_count').each(function(){
            $(this).val(total);
        });
        compute_overage_shortage();
    }
    function compute_overage_shortage() {
        var total_per_count = convertCurrency($('.total_per_count').val());
        var total_to_be_counted_for = convertCurrency($('#total_per_book').val());
        var overage = total_per_count - total_to_be_counted_for;
        var sign = Math.sign(overage);
        if(sign > 0) {
            $('#overage').val('+ '+convert_to_currency(overage.toFixed(3), "blur"));
        } 
        if(sign < 0) {
            $('#overage').val('- '+convert_to_currency(overage.toFixed(3), "blur"));
        }
        if(sign == 0) {
            $('#overage').val(convert_to_currency(overage.toFixed(3), "blur"));
        }
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