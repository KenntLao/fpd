<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('preventive-maintenance-add')) {

	$page = 'preventive-maintenance';
	
	$id = $_GET['id'];

	$frequency_id = $id;

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($preventive_maintenance); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($preventive_maintenance); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_preventive_maintenance_add_suc');
                    renderError('sys_preventive_maintenance_edit_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($preventive_maintenance); ?></h3>
							<div class="card-tools">
								<?php if(checkPermission('client-add')) { ?><a href="/add-preventive-maintenance/<?php echo $frequency_id == 6 ? '0' : $frequency_id; ?>" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($preventive_add_maintenance); ?></a><?php } ?>
							</div>
                        </div>
                        <div class="card-body">

							<!-- FILTER -->
							<div class="row">

								<div class="col-lg-3 col-md-4">
									<div class="form-group">
										<label for="frequency-filter"><?php echo renderlang($preventive_maintenance_frequency); ?></label>
										<select name="frequency-filter" id="frequency-filter" class="form-control">
											<option value="6">All</option>
											<?php 
											foreach($preventive_maintenance_frequency_arr as $key => $frequency) {
												echo '<option '.($frequency_id == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($frequency[1]).'</option>';
											}
											?>
										</select>
									</div>
								</div>

							</div>

                            <!-- EQUIPMENT LIST -->
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($preventive_maintenance_equipment); ?></th>
											<th><?php echo renderLang($preventive_maintenance_frequency); ?></th>
                                            <th><?php echo renderLang($equipments_serial_number); ?></th>
                                            <th><?php echo renderLang($preventive_maintenance_equipment_location); ?></th>
											<th><?php echo renderLang($lang_date); ?></th>
											<th><?php echo renderLang($preventive_maintenance_before); ?></th>
											<th><?php echo renderLang($preventive_maintenance_after); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
                                            <th class="w35"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-data">
									<?php 
									if($frequency_id == 6) {
										$frequency_condition = 'AND pm.frequency <> 6';
									} else {
										$frequency_condition= 'AND pm.frequency = '.$frequency_id;
									}

									if($_SESSION['sys_account_mode'] == 'user') {

										$sql = $pdo->prepare("SELECT pm.id, equipment_name, e.sub_property_id, sub_property_name, e.serial_number, pm.frequency, pm.date, pm.before_picture, pm.after_picture, preventive_maintenance_status  FROM preventive_maintenance pm LEFT JOIN equipments e ON(pm.equipment_id = e.id) LEFT JOIN sub_properties sp ON(sp.id = e.sub_property_id) WHERE pm.temp_del = 0 ".$frequency_condition);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
											echo '<tr>';

											// equipment name
											echo '<td><a href="/preventive-maintenance-form/'.$data['id'].'">'.$data['equipment_name'].'</a></td>';
											
											// frequency
											echo '<td>';
												echo renderLang($preventive_maintenance_frequency_arr[$data['frequency']][1]);
											echo '</td>';

											// serial number
											echo '<td>'.$data['serial_number'].'</td>';
											
											// location
											echo '<td><a href="/sub-property/'.$data['sub_property_id'].'">'.$data['sub_property_name'].'</a></td>';
											
											// date
											echo '<td>'.(checkVar($data['date']) ? formatDate($data['date']) : '').'</td>';

											// before
											echo '<td>';
											if(!empty($data['before_picture'])) {

												$img_ext = array('jpg', 'jpeg', 'png');
												if(strpos($data['before_picture'], ',')) {

													$attachments = explode(',', $data['before_picture']);
													foreach($attachments as $attachment) {

														$attachment_part = explode('.', $attachment);
														
														if(in_array($attachment_part[1], $img_ext)) {

															
																echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" data-toggle="lightbox">'; 
																	echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$attachment.'" style="height: 29px; width: 29px;"></img>';
																	echo $attachment;
																echo '</a><br>';
															

														} else {

															echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

														}

													}

												} else {

													$attachment_part = explode('.', $data['before_picture']);
													if(in_array($attachment_part[1], $img_ext)) {

															
														echo '<a href="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" data-toggle="lightbox">'; 
															echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
															echo $data['before_picture'];
														echo '</a><br>';
														

													} else {

														echo '<a href="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" target="_blank">'.$data['before_picture'].'</a><br>';

													}
												
												}

											}
											echo '</td>';

											// after
											echo '<td>';
											if(!empty($data['after_picture'])) {

												$img_ext = array('jpg', 'jpeg', 'png');
												if(strpos($data['after_picture'], ',')) {

													$attachments = explode(',', $data['after_picture']);
													foreach($attachments as $attachment) {

														$attachment_part = explode('.', $attachment);
														
														if(in_array($attachment_part[1], $img_ext)) {

															
																echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" data-toggle="lightbox">'; 
																	echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$attachment.'" style="height: 29px; width: 29px;"></img>';
																	echo $attachment;
																echo '</a><br>';
															

														} else {

															echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

														}

													}

												} else {

													$attachment_part = explode('.', $data['after_picture']);
													if(in_array($attachment_part[1], $img_ext)) {

															
														echo '<a href="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" data-toggle="lightbox">'; 
															echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
															echo $data['after_picture'];
														echo '</a><br>';
														

													} else {

														echo '<a href="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" target="_blank">'.$data['after_picture'].'</a><br>';

													}
												
												}

											}
											echo '</td>';

											// status
											echo '<td>'.renderLang($preventive_maintenance_status_arr[$data['preventive_maintenance_status']]).'</td>';

											// edit
											echo '<td><a href="/edit-preventive-maintenance/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($preventive_maintenance_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';

											echo '</tr>';
										}

									} else {

										$sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
										$sub_properties = explode(',', $sub_property_ids);
										foreach($sub_properties as $sub_property_id) {

											$sql = $pdo->prepare("SELECT pm.id, equipment_name, e.sub_property_id, sub_property_name, e.serial_number, pm.frequency, pm.date, pm.before_picture, pm.after_picture, preventive_maintenance_status  FROM preventive_maintenance pm LEFT JOIN equipments e ON(pm.equipment_id = e.id) LEFT JOIN sub_properties sp ON(sp.id = e.sub_property_id) WHERE pm.temp_del = 0 AND sp.id = :sub_property_id ".$frequency_condition);
											$sql->bindParam(":sub_property_id", $sub_property_id);
											$sql->execute();
											if($sql->rowCount()) {
												$data = $sql->fetch(PDO::FETCH_ASSOC);

												echo '<tr>';

													// equipment name
													echo '<td><a href="/preventive-maintenance-form/'.$data['id'].'">'.$data['equipment_name'].'</a></td>';
													
													// frequency
													echo '<td>';
														echo renderLang($preventive_maintenance_frequency_arr[$data['frequency']][1]);
													echo '</td>';

													// serial number
													echo '<td>'.$data['serial_number'].'</td>';
													
													// location
													echo '<td><a href="/sub-property/'.$data['sub_property_id'].'">'.$data['sub_property_name'].'</a></td>';
													
													// date
													echo '<td>'.(checkVar($data['date']) ? formatDate($data['date']) : '').'</td>';

													// before
													echo '<td>';
													if(!empty($data['before_picture'])) {

														$img_ext = array('jpg', 'jpeg', 'png');
														if(strpos($data['before_picture'], ',')) {

															$attachments = explode(',', $data['before_picture']);
															foreach($attachments as $attachment) {

																$attachment_part = explode('.', $attachment);
																
																if(in_array($attachment_part[1], $img_ext)) {

																	
																		echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" data-toggle="lightbox">'; 
																			echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$attachment.'" style="height: 29px; width: 29px;"></img>';
																			echo $attachment;
																		echo '</a><br>';
																	

																} else {

																	echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

																}

															}

														} else {

															$attachment_part = explode('.', $data['before_picture']);
															if(in_array($attachment_part[1], $img_ext)) {

																	
																echo '<a href="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" data-toggle="lightbox">'; 
																	echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																	echo $data['before_picture'];
																echo '</a><br>';
																

															} else {

																echo '<a href="/assets/uploads/preventive-maintenance/'.$data['before_picture'].'" target="_blank">'.$data['before_picture'].'</a><br>';

															}
														
														}

													}
													echo '</td>';

													// after
													echo '<td>';
													if(!empty($data['after_picture'])) {

														$img_ext = array('jpg', 'jpeg', 'png');
														if(strpos($data['after_picture'], ',')) {

															$attachments = explode(',', $data['after_picture']);
															foreach($attachments as $attachment) {

																$attachment_part = explode('.', $attachment);
																
																if(in_array($attachment_part[1], $img_ext)) {

																	
																		echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" data-toggle="lightbox">'; 
																			echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$attachment.'" style="height: 29px; width: 29px;"></img>';
																			echo $attachment;
																		echo '</a><br>';
																	

																} else {

																	echo '<a href="/assets/uploads/preventive-maintenance/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

																}

															}

														} else {

															$attachment_part = explode('.', $data['after_picture']);
															if(in_array($attachment_part[1], $img_ext)) {

																	
																echo '<a href="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" data-toggle="lightbox">'; 
																	echo '<img class="has-bg-img mr-2 mt-1" src="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
																	echo $data['after_picture'];
																echo '</a><br>';
																

															} else {

																echo '<a href="/assets/uploads/preventive-maintenance/'.$data['after_picture'].'" target="_blank">'.$data['after_picture'].'</a><br>';

															}
														
														}

													}
													echo '</td>';

													// status
													echo '<td>'.renderLang($preventive_maintenance_status_arr[$data['preventive_maintenance_status']]).'</td>';

													// edit
													echo '<td><a href="/edit-preventive-maintenance/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($preventive_maintenance_edit).'"><i class="fa fa-pencil-alt"></i></a></td>';

												echo '</tr>';

											}

										}

									}
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

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

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

			$('#frequency-filter').on('change', function(){

				var frequency_id = $(this).val();

				window.location.href = "/frequency-preventive-maintenance/"+frequency_id;

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