<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collection-edit')) {

  	$page = 'collections';

  	$id = $_GET['id'];

  	// suggested client ID
        $sql = $pdo->prepare("SELECT dc.id, dc.sub_property_id, dc.particulars, deposit_payment_slip_attachment, dc.unit_id, dc.others, dc.tenant_ids, u.unit_name, sp.sub_property_name, p.property_name, dc.voucher_type, collection_date, payment_type, dcpt.amount, bank, check_number, other_bank, ar_number, or_number, pr_number, dc.attachment FROM daily_collections dc LEFT JOIN daily_collections_payment_types dcpt ON (dcpt.daily_collection_id = dc.id) LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE dc.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
		$sql->execute();
        if ($sql->rowCount()) {

            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }else{
            $_SESSION['sys_daily_collection_edit_err'] = renderLang($lang_no_data);
            header('location: /daily-collections/1');
            exit();
        }
        
        $err = 0;

        $_SESSION['sys_daily_collection_edit_date_val'] = $data['collection_date'];
        $_SESSION['sys_daily_collection_edit_payment_type_val'] = $data['payment_type'];

        $unit_ids = explode(',',$data['unit_id']);
        $tenant_ids = explode(',', $data['tenant_ids']);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collections_edit_daily_collection); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
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
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($daily_collections_edit_daily_collection); ?>
							<small><i class="fa fa-chevron-right ml-2 mr-2"></i></small>
                                <?php echo $data['sub_property_name'].' ['.$data['property_name'].']'; ?>
                            </h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

		        <div class="container-fluid">

		        	<?php 
                    renderError('sys_daily_collection_edit_err');
		        	?>

		        	<form action="/submit-edit-daily-collection" method="post" enctype="multipart/form-data">

		        		<input type="hidden" name="id" value="<?php echo $id; ?>">

			        	<div class="card">
			        		<div class="card-header">
			        			<h3 class="card-title"><?php echo renderLang($daily_collections_edit_daily_collection_form); ?></h3>
			        			<div class="card-tools">
                                    <?php if(checkPermission('daily-collection-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($daily_collections_delete_daily_collection); ?></a><?php } ?>
                                </div>
			        		</div>
			        		<div class="card-body">

								<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="building" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <input type="text" class="form-control" value="<?php echo $data['sub_property_name'].' ['.$data['property_name'].']'; ?>" readonly> 
                                            <input type="hidden" id="sub_property_id" name="sub_property_id" value="<?php echo $data['sub_property_id']; ?>">
                                       	</div>
                                    </div>


			        				<div class="col-lg-3 col-md-4">
                                        <?php $err = isset($_SESSION['sys_daily_collection_edit_date_err']) ? 1 : 0; ?>
			        					<div class="form-group">
                                            <label for="date1" class="mr-1 <?php echo $err ? 'text-danger' : ''; ?>"><?php echo $err ? '<i class="far fa-times-circle mr-1"></i>' : ''; echo renderLang($daily_collections_daily_collection_date); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <input type="text" name="collection_date" id="date1" class="form-control required<?php echo $err ? ' is-invalid' : ''; ?>" <?php echo isset($_SESSION['sys_daily_collection_edit_date_val']) ? 'value="'.$_SESSION['sys_daily_collection_edit_date_val'].'"' : ''; ?>>
                                            <?php 
                                            echo $err ? '<p class="error_message text-danger mt-1">'.$_SESSION['sys_daily_collection_edit_date_err'].'</p>' : '';
                                            unset($_SESSION['sys_daily_collection_edit_date_err']);
                                            ?>
			        					</div>
			        				</div>

			        			</div>
                                
			        			<div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="voucher_type"><?php echo renderLang($daily_collections_daily_collection_voucher_type); ?></label>
                                            <select class="form-control voucher_type select2" id="voucher_type" name="voucher_type">
                                            <?php 
                                            foreach ($reference_number_arr as $key => $value) {
                                                echo '<option '.($data['voucher_type'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 <?php if ($data['voucher_type'] != 2){ echo'd-none'; }?> or_no">
                                        <div class="form-group">
                                            <label for="or_number"><?php echo renderLang($daily_collections_daily_collection_or); ?></label>
                                            <input type="text" class="form-control" name="or_number" id="or_number" value="<?php echo $data['or_number'] ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 <?php if ($data['voucher_type'] != 1){ echo'd-none'; }?> ar_no">
                                        <div class="form-group">
                                            <label for="ar_number"><?php echo renderLang($daily_collections_daily_collection_ar); ?></label>
                                            <input type="text" class="form-control" name="ar_number" id="ar_number" value="<?php echo $data['ar_number'] ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-4 <?php if ($data['voucher_type'] != 3){ echo'd-none'; }?> pr_no">
                                        <div class="form-group">
                                            <label for="pr_number"><?php echo renderLang($daily_collections_daily_collection_pr); ?></label>
                                            <input type="text" class="form-control" name="pr_number" id="pr_number" value="<?php echo $data['pr_number'] ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6 col-md-8">
	                                	<div class="table-responsive">
											<table class="table table-bordered">
												<thead>
													<tr>
                                                        <th class="w200"><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
                                                        <th><?php echo renderlang($tenants_tenants); ?></th>
                                                        <th class="w35"></th>
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    foreach ($unit_ids as $key => $unit_id) {

                                                        echo '<tr>';

                                                            $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                            if(checkVar($unit_name)) {
                                                                echo '<td class="p-0">';
                                                                    echo '<select name="unit_id[]" class="form-control border-0 unit_options" data-val="'.$unit_id.'">';
                                                                    echo '</select>';
                                                                echo '</td>';
                                                            } else {
                                                                $unit = getField('id', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                                                if(checkVar($unit)) {
                                                                    echo '<td class="p-0">';
                                                                        echo '<select name="unit_id[]" class="form-control border-0 unit_options" data-val="'.$unit.'">';
                                                                        echo '</select>';
                                                                    echo '</td>';
                                                                } else {
                                                                    echo '<td class="p-0">';
                                                                        echo '<input type="text" name="unit_id[]" class="form-control border-0" value="'.$unit_id.'">';
                                                                    echo '</td>';
                                                                }
                                                            }

                                                            echo '<td class="p-0">';
                                                                echo '<select name="tenant_id[]" class="form-control border-0 tenant_options">';
                                                                    echo '<option></option>';
                                                                    $sql = $pdo->prepare("SELECT t.id, t.firstname, t.middlename, t.lastname FROM unit_tenants ut LEFT JOIN tenants t ON(ut.tenant_id = t.id) WHERE unit_id = :unit_id AND t.temp_del = 0");
                                                                    $sql->bindParam(":unit_id", $unit_id);
                                                                    $sql->execute();
                                                                    if($sql->rowCount()) {
                                                                        while($data1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo '<option '.($tenant_ids[$key] == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.getFullName($data1['id'], 'tenant').'</option>';
                                                                        }
                                                                    }
                                                                echo '</select>';
                                                            echo '</td>';

                                                            echo '<td class="p-0 text-center pt-1">';
                                                                echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>';
                                                            echo '</td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
													<tr class="default-row3 d-none">
														<td class="p-0">
                                                            <select name="unit_id[]" class="form-control border-0 unit_options">

                                                            </select>
                                                        </td>
                                                        <td class="p-0">
                                                            <select name="tenant_id[]" class="form-control border-0 tenant_options"></select>
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
													</tr>
												</tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="3">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
												<thead>
													<tr>
														<th><?php echo renderLang($lang_others); ?></th>
                                                        <th class="w35"></th>
													</tr>
												</thead>
                                                <tbody>
                                                    <?php 
                                                    $others = explode(',', $data['others']);
                                                    foreach($others as $key => $other) {
                                                        echo '<tr>';
                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" class="form-control border-0" name="others[]" value="'.$other.'">';
                                                            echo '</td>';
                                                            echo '<td class="p-0 text-center pt-1">';
                                                                echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                    <tr class="default-row3 d-none">
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="others[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="2">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
										<div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2"><?php echo renderLang($daily_collection_report_particulars); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $particulars_arr = explode(', ', $data['particulars']);
                                                    foreach($particulars_arr as $kek => $particulars) {
                                                        echo '<tr>';
                                                            echo '<td class="p-0">';
                                                                echo '<input type="text" class="form-control border-0" name="particulars[]" value="'.$particulars.'">';
                                                            echo '</td>';
                                                            echo '<td class="p-0 text-center pt-1">';
                                                                echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                    <tr class="default-row3 d-none">
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="particulars[]">
                                                        </td>
                                                        <td class="p-0 text-center pt-1">
                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="border-0 text-right" colspan="2">
                                                            <button href="" class="btn btn-sm btn-info add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
										</div>
									</div>

                                </div><!-- row -->

                                <br>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody class="table-data">
                                                    <?php 
                                                    $sql2 = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE daily_collection_id = :id");
                                                    $sql2->bindParam(":id",$id);
                                                    $sql2->execute();
                                                    if($sql2->rowCount()) {
                                                        while ($_data = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                            echo '<tr>';

                                                                //PAYMENT TYPE 
                                                                echo '<td>';
                                                                    echo '<div class="form-group">';
                                                                    echo '<label>'.renderLang($daily_collections_daily_collection_payment_type).'</label>';
                                                                    echo '<select class="form-control payment_type" name="payment_type[]">';
                                                                    echo '<option value=""></option>';

                                                                    foreach ($payment_types_arr as $key => $value) {
                                                                                echo '<option '.($_data['payment_type'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($value).'</option>';
                                                                            }
                                                                    echo '</select>';
                                                                    echo '</div>';
                                                                echo '</td>';

                                                                //CHECK NUMBER 
                                                                echo '<td class="'; if ($data['payment_type'] != 2){ echo'd-none'; } echo ' check_number">';
                                                                    echo '<label>'.renderLang($collections_check_voucher_check_number).'</label>';
                                                                    echo '<input type="text" class="form-control" name="check_number[]" value="'.$_data['check_number'].'">';
                                                                echo '</td>';

                                                                // DATE OF CHECK
                                                                echo '<td class="'; if ($data['payment_type'] != 2){ echo'd-none'; } echo ' date_of_check">';
                                                                    echo '<label>'.renderLang($daily_collections_daily_collection_date_of_check).'</label>';
                                                                    echo '<input type="text" class="form-control date" name="date_of_check[]" value="'.formatDate($_data['date_of_check']).'">';
                                                                echo '</td>';

                                                                // BANK  
                                                                echo '<td class="'; if ($data['payment_type'] == 0){ echo'd-none'; } echo ' bank">';
                                                                    echo '<label>'.renderLang($collections_check_voucher_bank).'</label>';
                                                                    echo '<select name="bank[]" class="form-control bank_name" required>';
                                                                    echo '<option value=""></option>';
                                                                        foreach($banks_arr as $key => $bank) {
                                                                                echo '<option '.($_data['bank'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($bank).'</option>';
                                                                        }
                                                                    echo '</select>';
                                                                echo '</td>';

                                                                // OTHER BANK  
                                                                echo '<td class="'; 
                                                                    if ($data['bank'] != '999'){ 
                                                                        echo'd-none'; 
                                                                    } 
                                                                echo ' other_bank">';
                                                                    echo '<label>'.renderLang($collections_check_vouchers_other_bank).'</label>';
                                                                    echo '<input type="text" class="form-control" name="other_bank[]" value="'.$_data['other_bank'].'">';
                                                                echo '</td>';

                                                                // TRANSACTION DETAILS  
                                                                echo '<td class="'; if ($data['payment_type'] == 0 || $data['payment_type'] == 2){ echo'd-none'; } echo ' transaction">';
                                                                    echo '<label>'.renderLang($daily_collections_daily_collection_transaction_details).'</label>';
                                                                    echo '<input type="text" class="form-control" name="transaction_details[]" value="'.$_data['transaction_details'].'">';
                                                                echo '</td>';

                                                                // AMOUNT  
                                                                echo '<td>';
                                                                    echo '<div>';
                                                                    echo '<label>'.renderLang($daily_collections_daily_collection_amount).'</label>';
                                                                    echo '<input type="text" class="form-control" data-type="currency" name="amount[]" value="'.$_data['amount'].'"';
                                                                    echo '</div>';
                                                                echo '</td>';

                                                                echo '<input type="hidden" name="dc_id[]" value="'.$_data['id'].'">';

                                                            echo '</tr>';

                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="default-row d-none">

                                                        <!-- PAYMENT TYPE -->
                                                        <td>
                                                            <div class="form-group">
                                                            <label><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></label>
                                                                <select class="form-control payment_type" id="payment_type" name="payment_type[]" >
                                                                        <option value=""></option>
                                                                <?php 
                                                                foreach ($payment_types_arr as $key => $value) {
                                                                    echo '<option value="'.$key.'">'.renderLang($value).'</option>';
                                                                }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <!-- CHECK NUMBER -->
                                                        <td class="d-none check_number">
                                                            <label><?php echo renderLang($collections_check_voucher_check_number); ?></label>
                                                            <input type="text" class="form-control" name="check_number[]" id="check_number">
                                                        </td>

                                                        <!-- DATE OF CHECK-->
                                                        <td class="d-none date_of_check">
                                                            <label><?php echo renderLang($daily_collections_daily_collection_date_of_check); ?></label>
                                                            <input type="text" name="date_of_check[]" class="form-control date">
                                                        </td>
                                                        
                                                        <!-- BANK -->
                                                        <td class="d-none bank">
                                                            <label><?php echo renderLang($collections_check_voucher_bank); ?></label>
                                                            <select name="bank[]" id="bank" class="form-control bank_name">
                                                                <option value=""></option>
                                                                <?php 
                                                                foreach($banks_arr as $key => $bank) {
                                                                    echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>

                                                        <!-- OTHER BANK -->
                                                        <td class="d-none other_bank">
                                                            <label><?php echo renderLang($collections_check_vouchers_other_bank); ?></label>
                                                            <input type="text" class="form-control" name="other_bank[]">
                                                        </td>

                                                        <!-- TRANSACTION DETAILS -->
                                                        <td class="d-none transaction">
                                                            <label><?php echo renderLang($daily_collections_daily_collection_transaction_details); ?></label>
                                                            <input type="text" class="form-control" name="transaction_details[]">
                                                        </td>

                                                        <!-- AMOUNT -->
                                                        <td>
                                                            <div class="form-group">
                                                                <label><?php echo renderLang($daily_collections_daily_collection_amount); ?></label>
                                                                <input type="text" class="form-control" data-type="currency" name="amount[]">
                                                            </div>
                                                        </td>
                                                        <input type="hidden" name="dc_id[]" value="0">

                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="text-right mb-3">
                                                <button href="" class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- row -->

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($daily_collections_daily_collection_or_ar_pr_attachment); ?></label><br>
                                            <?php 
                                            renderAttachments($data['attachment'], 'daily-collection');
                                            ?>
                                            <input type="file" class="form-control" name="attachment[]" multiple>
                                        </div>
                                    </div>
                                    
                                </div><div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($daily_collections_daily_collection_deposit_payment_slip); ?></label><br>
                                            <?php 
                                            renderAttachments($data['deposit_payment_slip_attachment'], 'deposit-payment-slip');
                                            ?>
                                            <input type="file" class="form-control" name="attachment2[]" multiple>
                                        </div>
                                    </div>
                                    
                                </div>
			        			
			        		</div>
			        		<div class="card-footer text-right">
			        			<a href="/daily-collections/1" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
			        			<button class="btn btn-success"><i class="fa fa-save mr-2"></i><?php echo renderLang($daily_collections_update); ?></button>
			        		</div>
			        	</div>

		        	</form>

		        </div>

	      	</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<!-- confirm delete -->
        <?php if(checkPermission('daily-collection-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-daily-collection" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($daily_collections_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($daily_collections_modal_delete_msg2); ?></p>
                            <hr>
                            <div class="form-group is-invalid">
                                <label for="modal_confirm_delete_upass"><?php echo renderLang($enter_password); ?></label>
                                <input type="password" class="form-control required" id="modal_confirm_delete_upass" name="upass" placeholder="<?php echo renderLang($enter_password_placeholder); ?>" required>
                            </div>
                            <div class="modal-error alert alert-danger"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                            <button class="btn btn-danger btn-delete"><i class="fa fa-check mr-2"></i><?php echo renderLang($modal_confirm_delete); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- modal -->
        <?php } ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
		$(function() {

            // tenant options
            $('body').on('change', '.unit_options', function(){
                $this = $(this);
                var unit_id = $(this).val();

                $.post("/render-collection-tenants", {
                    unit_id:unit_id
                }, function(data) {
                    $this.closest('tr').find('.tenant_options').html('<option value=""></option>'+data);
                });

            });

            var building_id = $('#sub_property_id').val();
            var unit_options;

            $.post('/daily-collection-unit-options', {
                id:building_id
            }, function(data){
               unit_options = data;

            }).done(function(){

                $('.unit_options').each(function(){
                    $(this).html(unit_options);
                    $(this).val($(this).data('val'));
                });
            });

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

			// open delete modal
            $('#delete').on('click', function(e){
                e.preventDefault();
                $('#modal-confirm-delete .modal-error').hide();
                $('#modal-confirm-delete').modal('show');
            });

            // submit delete modal
            $('form.ajax-form').on('submit', function(e){
                e.preventDefault();
                var post_url = $(this).attr('action');
                $.ajax({
                    url: post_url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response){
                        var response_arr = response.split(',');
                        if(response_arr[0] == 1) { // val is 1
                            window.location.href = '/daily-collections/1';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

			$('#date1').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            // show specify field if othes is selected
            $('body').on('change', '.bank_name', function(){

                var bank_name = $(this).val();

                if(bank_name == '999') {
                    $(this).closest('tr').find('.other_bank').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.other_bank').addClass('d-none');
                }

            });

            // show specify field if othes is selected
            $('body').on('change', '.payment_type', function(){

                var payment_type = $(this).val();

                if(payment_type == 2) {
                    $(this).closest('tr').find('.check_number').removeClass('d-none');
                    $(this).closest('tr').find('.date_of_check').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.check_number').addClass('d-none');
                    $(this).closest('tr').find('.date_of_check').addClass('d-none');
                }
                if(payment_type == 2 || payment_type == 1) {
                    $(this).closest('tr').find('.bank').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.bank').addClass('d-none');
                    $(this).closest('tr').find('.other_bank').addClass('d-none');
                }
                if(payment_type == 1 || payment_type == 3 || payment_type == 4) {
                    $(this).closest('tr').find('.transaction').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.transaction').addClass('d-none');
                }

            });

            // show specify field if othes is selected
            $('.voucher_type').on('change', function(){

                var voucher_type = $(this).val();

                if(voucher_type == 1) {
                    $('.ar_no').removeClass('d-none');
                }
                else {
                    $('.ar_no').addClass('d-none');
                }

                if(voucher_type == 2) {
                    $('.or_no').removeClass('d-none');
                }
                else {
                    $('.or_no').addClass('d-none');
                }

                if(voucher_type == 3) {
                    $('.pr_no').removeClass('d-none');
                }
                else {
                    $('.pr_no').addClass('d-none');
                }

            });

            $('.date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('.add-row').on('click', function(e){
                e.preventDefault();

                var fields2 = '<tr>'+$('.default-row').html()+'</tr>';
                $('.table-data').append(fields2);

                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                });

            });

            $('.payment_type').each(function(){

               var payment_type = $(this).val();

                if(payment_type == 2) {
                    $(this).closest('tr').find('.check_number').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.check_number').addClass('d-none');
                }
                if(payment_type == 2 || payment_type == 1) {
                    $(this).closest('tr').find('.bank').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.bank').addClass('d-none');
                    $(this).closest('tr').find('.other_bank').addClass('d-none');
                }
                if(payment_type == 1 || payment_type == 3 || payment_type == 4) {
                    $(this).closest('tr').find('.transaction').removeClass('d-none');
                }
                else {
                    $(this).closest('tr').find('.transaction').addClass('d-none');
                } 

            })

            $('.add-row2').on('click', function(e){
                e.preventDefault();

                var fields3 = '<tr>'+$('.default-row2').html()+'</tr>';
                $('.table-data2').append(fields3);

            });

            // add row other unit
            $('body').on('click', '.add-row3', function(e){
                e.preventDefault();

                var fields = $(this).closest('table').find('.default-row3').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');

            });

            // remove row
            $('body').on('click', '.remove-row', function(e){
                e.preventDefault();

                $(this).closest('tr').remove();

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