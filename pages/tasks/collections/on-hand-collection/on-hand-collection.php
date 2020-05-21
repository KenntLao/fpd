<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('collection-undeposited')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'collections';

		$id = $_GET['id'];

		$sql = $pdo->prepare("SELECT * FROM on_hand_collection WHERE temp_del = 0 AND id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);

		} else {
			$_SESSION['sys_on_hand_collection_edit_err'] = renderLang($lang_no_data);
			header('location: /on-hand-collections');
			exit();
		}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($collections_on_hand_collection); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($collections_on_hand_collection); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo renderLang($pre_operation_audit_iad_count_sheet); ?></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-<?php echo $on_hand_collection_status_color_arr[$_data['status']]; ?>"><?php echo renderLang($on_hand_collection_status_arr[$_data['status']]); ?></button>
							</div>
						</div>
						<div class="card-body">

							<!-- PROPERTY -->
							<div class="row">
								<!-- PROPERTY -->
								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label for="property_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
										<input type="text" class="form-control input-readonly" id="property_id" readonly value="<?php echo getField('property_name', 'properties', 'id = '.$_data['property_id']); ?>">
									</div>
								</div>

								<!-- cashier -->
								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label for="cashier"><?php echo renderLang($pre_operation_audit_iad_cashier); ?></label>
										<input type="text" class="form-control input-readonly" id="cashier" value="<?php echo $_data['cashier']; ?>" readonly>
									</div>
								</div>

								<!-- attachment -->
								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label for="attachment"><?php echo renderLang($proposals_attachment); ?></label><br>
										<?php 
										if(!empty($_data['attachment'])) {

											$img_ext = array('jpg', 'jpeg', 'png');
											if(strpos($_data['attachment'], ',')) {

												$attachments = explode(',', $_data['attachment']);
												foreach($attachments as $attachment) {

													$attachment_part = explode('.', $attachment);
													
													if(in_array($attachment_part[1], $img_ext)) {

														
															echo '<a href="/assets/uploads/on-hand-collection/'.$attachment.'" data-toggle="lightbox">'; 
																echo '<img class="has-bg-img mr-2" src="/assets/uploads/on-hand-collection/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																echo $attachment;
															echo '</a><br>';
														

													} else {

														echo '<a href="/assets/uploads/on-hand-collection/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

													}

												}

											} else {

												$attachment_part = explode('.', $_data['attachment']);
												if(in_array($attachment_part[1], $img_ext)) {

														
													echo '<a href="/assets/uploads/on-hand-collection/'.$_data['attachment'].'" data-toggle="lightbox">'; 
														echo '<img class="has-bg-img mr-2" src="/assets/uploads/on-hand-collection/'.$_data['attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
														echo $_data['attachment'];
													echo '</a><br>';
													

												} else {

													echo '<a href="/assets/uploads/on-hand-collection/'.$_data['attachment'].'" target="_blank">'.$_data['attachment'].'</a><br>';

												}
											
											}

										}
										?>
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
																</tr>
															</thead>
															<tbody>
																<?php 
																foreach($pcc_cash_on_hand_arr as $key => $bills) {
																	$sql = $pdo->prepare("SELECT * FROM on_hand_collection_bills WHERE collection_id = :id AND denomination = :denom LIMIT 1");
																	$sql->bindParam(":id", $id);
																	$sql->bindParam(":denom", $key);
																	$sql->execute();
																	$data = $sql->fetch(PDO::FETCH_ASSOC);

																	echo '<tr>';
																		echo '<td>'.renderLang($bills[0]).'</td>';
																		echo '<td><p>'.$bills[1].'</p></td>';
																		echo '<td><p>'.(!empty($data['quantity']) ? $data['quantity'] : '').'</p></td>';
																		echo '<td><p>'.$data['amount'].'</p></td>';

																	echo '</tr>';
																}
																?>
																
															</tbody>
															<tfoot>
																<?php 
																$sql = $pdo->prepare("SELECT * FROM on_hand_collection_totals WHERE collection_id = :id LIMIT 1");
																$sql->bindParam(":id", $id);
																$sql->execute();
																$total_data = $sql->fetch(PDO::FETCH_ASSOC);
																$total_per_count = explode(',', $total_data['total_per_count']);
																?>
																<tr>
																	<th colspan="3" class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_bills_and_coins); ?></th>
																	<td><input type="text" min="0" class="form-control border-0 input-readonly" id="total-bills" name="bills_total" readonly value="<?php echo $total_data['total_bills']; ?>"></td>
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
																<?php 
																$sql = $pdo->prepare("SELECT * FROM on_hand_collection_checks WHERE collection_id = :id");
																$sql->bindParam(":id", $id);
																$sql->execute();
																if($sql->rowCount()) {

																	while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																		echo '<tr>';
																			echo '<td><p>'.$data['or_number'].'</p></td>';
																			echo '<td><p>'.$data['bank'].'</p></td>';
																			echo '<td><p>'.$data['date'].'</p></td>';
																			echo '<td><p>'.$data['amount'].'</p></td>';
																		echo '</tr>';
																	}

																}
																?>
															</tbody>
															<tfoot>
																<tr>
																	<th colspan="3" class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_checks); ?></th>
																	<td><input type="text" min="0" class="form-control border-0 input-readonly" id="total-checks" name="checks_total" readonly value="<?php echo $total_data['total_checks']; ?>"></td>
																</tr>
															</tfoot>
														</table>
														<div class="text-right">
															<button class="btn btn-info add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
														</div>
													</div>
												</div>
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
												<td><input type="text" class="form-control input-readonly" name="total_bills" id="total-bills-coins"readonly value="<?php echo $total_data['total_bills']; ?>"></td>
												<td colspan="2"></td>
											</tr>
											<tr>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_checks); ?></th>
												<td><input type="text" min="0" class="form-control input-readonly" name="total_checks" id="checks-total" readonly value="<?php echo $total_data['total_checks']; ?>"></td>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
												<td><input type="number" min="0" class="form-control input-readonly" name="total_per_count1" value="<?php echo $total_per_count[0]; ?>" readonly></td>
											</tr>
											<tr>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_others); ?></th>
												<td><input type="text" min="0" class="form-control input-readonly" name="total_others" value="<?php echo $total_data['others']; ?>" readonly></td>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_iad_total_to_be_counted_for); ?></th>
												<td><input type="number" min="0" class="form-control input-readonly" name="total_to_be_counted_for" value="<?php echo $total_data['total_to_be_counted_for']; ?>" readonly></td>
											</tr>
											<tr>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_total_per_count); ?></th>
												<td><input type="number" min="0" class="form-control input-readonly" name="total_per_count2" value="<?php echo $total_per_count[1]; ?>" readonly></td>
												<th class="text-uppercase"><?php echo renderLang($pre_operation_audit_pcc_over_age); ?></th>
												<td><input type="number" min="0" class="form-control input-readonly" name="total_overage" value="<?php echo $total_data['overage_shortage']; ?>" readonly></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

						</div>
						<div class="card-footer text-right">
							<a href="/on-hand-collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
							<?php if(checkPermission('collection-undeposited-approve') && $_data['status'] == 1) { ?>
							<button class="btn btn-success" id="approve"><i class="fa fa-check mr-1"></i><?php echo renderLang($lang_approve); ?></button>
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
	<script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script>
	$(function(){

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

		$('#approve').on('click', function(e) {
			e.preventDefault();
			var id = <?php echo $id; ?>;
			$.post('/approve-on-han-collection',{
				id:id
			}, function(data){
				window.location.reload();
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