<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-TSA-add')) {

	$page = 'pre-operation-audit';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_tsa_add); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_tsa_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php
                    renderError('sys_pre_operation_audit_tsa_add_err');
                    ?>

                    <form action="/submit-add-tsa-pre-operation-audit" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_tsa); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="project"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <select name="prospect_id" id="project" class="form-control select2">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT id, reference_number, project_name FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_of_audit"><?php echo renderLang($pre_operation_audit_date_of_audit); ?></label>
                                            <input type="text" class="form-control" name="date_of_audit" id="date_of_audit">
                                        </div>
                                    </div>             

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_presented"><?php echo renderLang($pre_operation_audit_tsa_date_presented_to_board); ?></label>
                                            <input type="text" name="date_presented" id="date_presented" class="form-control date">
                                        </div>
                                    </div>            

                                </div>

                                <!-- SECTION 1 SUMMARY -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-summary" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_1).' - '.renderLang($pre_operation_audit_tsa_summary); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-summary">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_tsa_summary); ?></h3>
                                                </div>
                                                <div class="card-body pad">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea name="summary" rows="10" class="form-control notes"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 2 DESCRIPTION OF BUILDING -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-building" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_2).' - '.renderLang($pre_operation_audit_tas_desc_building); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-building">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_tas_desc_building); ?></h3>
                                                </div>
                                                <div class="card-body pad">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea name="building_description" rows="10" class="form-control notes"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_tsa_insert_building_picture); ?></label>
                                                                <input type="file" name="building_picture" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 3 BUILDING STATUS AND EVALUATION -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-building-status" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_3).' - '.renderLang($pre_operation_audit_tsa_building_status_and_evaluation); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-building-status">

                                            <!-- <div class="card">
												<div class="card-header text-center">
													<h3><?php echo renderLang($operation_audit_tsa_update_of_previous_years_technical_and_safety_audit); ?></h3>
												</div>
												<div class="card-body">
													
													<div class="row">

														<div class="col-12">
															<label for="">A. <?php echo renderLang($operation_audit_tsa_compliance_and_non_conformances_item); ?></label>
														</div>

														<div class="col-12">
															<div class="table-responsive">
																<table class="table table-bordered table-hover table-condensed">
																	<thead>
																		<tr>
																			<th><?php echo renderLang($operation_audit_tsa_non_conformance); ?></th>
																			<th><?php echo renderLang($operation_audit_tsa_status); ?></th>
																			<th><?php echo renderLang($operation_audit_tsa_remarks); ?></th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr class="default-row">
																			<td>
																				<textarea name="non_conformance[]" class="form-control notes border-0"></textarea>
																			</td>
																			<td>
																				<textarea name="conformance_status[]" class="form-control notes border-0"></textarea>
																			</td>
																			<td>
																				<textarea name="conformance_remarks[]" class="form-control notes border-0"></textarea>
																			</td>
																		</tr>
																	</tbody>
																	<tfoot>
																		<tr>
																			<td colspan="3" class="text-right">
																				<button class="btn btn-info btn-sm add-row-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
																			</td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>

													</div>

												</div>
											</div> -->

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_tsa_building_status_and_evaluation); ?></h3>
                                                </div>
                                                <div class="card-body pad">

                                                    <?php
                                                    $num = 1;
                                                    foreach($tsa_section_3_arr as $section_key => $system) { 

                                                    echo '<input type="hidden" name="location_category[]" value="'.$section_key.'">';
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">
                                                                <button class="btn pms-red text-white w300 text-left" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $num; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $num.'. '.renderLang($system[0]); ?></button>
                                                            </p>
                                                            <div class="collapse" id="tab-<?php echo $num; ?>">

                                                            <div class="row">


                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label><?php echo renderLang($pre_operation_audit_tsa_details); ?></label>
                                                                        <textarea name="location_details[]" rows="2" class="form-control notes"></textarea>
                                                                    </div>
                                                                </div>

                                                                </div>

                                                                <div class="location-row">
                                                                    <div class="location">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <div class="card-tools">
                                                                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_tsa_location); ?></label>
                                                                                    <input type="text" name="location[]" class="form-control">
                                                                                    <input type="hidden" name="location_code[]" value="<?php echo $section_key; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">

                                                                                    <div class="<?php echo ($section_key == 'aircon' || $section_key == 'electrical' || $section_key == 'mechanical' ? 'col-lg-6 col-md-12' : 'col-md-12'); ?>">

                                                                                        <div class="form-group">
                                                                                            <label for="location_unit"><?php echo renderLang($pre_operation_audit_tsa_unit); ?></label>
                                                                                            <input type="text" class="form-control" name="location_unit[]" id="location_unit">
                                                                                        </div>

                                                                                        <div class="row">

                                                                                            <!-- findings -->
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label><?php echo renderLang($pre_operation_audit_pvc_findings); ?></label>
                                                                                                    <select name="findings[]" class="form-control findings">
                                                                                                        <option></option>
                                                                                                        <?php 
                                                                                                        foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                            echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>

                                                                                            <!-- prioritization -->
                                                                                            <div class="col-md-6">
                                                                                                <label><?php echo renderLang($pre_operation_audit_prioritization); ?></label>
                                                                                                <select name="priority[]" class="form-control priority">
                                                                                                    <option></option>
                                                                                                    <?php 
                                                                                                    foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                        echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <div class="priority_specify d-none">
                                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                                    <input type="text" class="form-control" name="priority_specify[]">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        <!-- recommendation -->
                                                                                        <div class="form-group">
                                                                                            <label><?php echo renderLang($turnover_audit_tsa_recommendation); ?></label>
                                                                                            <textarea name="location_recommendation[]" class="form-control notes"></textarea>
                                                                                        </div>

                                                                                    </div>

                                                                                    <?php 
                                                                                    if ($section_key == 'aircon' || $section_key == 'electrical' || $section_key == 'mechanical') {
                                                                                    ?>

                                                                                    <div class="col-lg-6 col-md-12 table-responsive">
                                                                                        <table class="table table-bordered table-hover">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th colspan="2"><?php echo renderLang($pre_operation_audit_tsa_manufacturer_specipications); ?></th>
                                                                                                    <th><?php echo renderLang($pre_operation_audit_tsa_operational_data); ?></th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php 
                                                                                                foreach($system[1] as $key => $fields) {
                                                                                                    echo '<tr>';

                                                                                                    echo '<td><p>'.renderLang($fields).'</p><input type="hidden" name="'.$section_key.'_specification_category[]" value="'.$key.'"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" name="'.$section_key.'_specification[]"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" name="'.$section_key.'_data[]"></td>';

                                                                                                    echo '</tr>';
                                                                                                }
                                                                                                ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="text-right">
                                                                        <button href="" class="btn btn-info add-row-location"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                </div>

                                                                <!-- Pictures -->
                                                                <div class="row mt-4">
                                                                    <div class="col-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th><?php echo renderLang($pre_operation_audit_tsa_pictures); ?></th>
                                                                                        <th><?php echo renderLang($pre_operation_audit_pvc_findings); ?></th>
                                                                                        <th><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                                        <th><?php echo renderlang($pre_operation_audit_tsa_recommendations); ?></th>
                                                                                        <th class="w35"></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr class="default-row">
                                                                                        <td><input type="file" name="pictures[]" class="form-control border-0"></td>
                                                                                        <td>
                                                                                            <select name="picture_findings[]" class="form-control picture_findings">
                                                                                                <option></option>
                                                                                                <?php 
                                                                                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                    echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select name="picture_priority[]" class="form-control picture_priority">
                                                                                                <option></option>
                                                                                                <?php 
                                                                                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                    echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                            <div class="picture_priority_specify d-none">
                                                                                                <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                                <input type="text" class="form-control" name="picture_priority_specify[]">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td><textarea name="picture_recommendations[]" class="form-control notes border-0"></textarea></td>
                                                                                        <td>
                                                                                            <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                        </td>
                                                                                        <input type="hidden" name="picture_code[]" value="<?php echo $section_key; ?>">
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="text-right">
                                                                                <button class="btn btn-info add-row-pictures"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="notes"><?php echo renderLang($pre_operation_audit_tsa_notes); ?></label>
                                                                            <textarea name="notes[]" id="notes" rows="2" class="form-control notes"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($section_key == 'fire_safety_and_security') { ?>

                                                                    <?php 
                                                                    foreach ($tsa_operations_audit_fire_safety_and_security as $key => $fire_safety_and_security) { 
                                                                    ?>

                                                                    <!-- FIRE EXTINGUISHER -->
                                                                    <div class="row mt-4">
                                                                        <div class="col-12">
                                                                            <p class="text-center">
                                                                                <button class="btn bg-secondary text-white w100pc text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseExample"><?php echo renderLang($fire_safety_and_security); ?></button>
                                                                            </p>
                                                                            <div class="collapse show" id="tab_<?php echo $key; ?>">

                                                                                <input type="hidden" name="fire_safety_category[]" value="<?php echo $key; ?>">

                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div class="card-header text-center">
                                                                                            <h3><?php echo renderLang($fire_safety_and_security); ?></h3>
                                                                                        </div>
                                                                                        <div class="row my-4">
                                                                                            <div class="col-12">
                                                                                                <label><?php echo renderLang($pre_operation_audit_tsa_details); ?></label>
                                                                                                <textarea class="form-control notes" name="fire_safety_details[]"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="site-row">
                                                                                    <input type="hidden" class="site_category" name="fire_safety_site_category[]" value="1">
                                                                                        <div class="site card m-2">
                                                                                            <div class="card-body">

                                                                                                <div class="row mb-4">
                                                                                                    <div class="col-6">
                                                                                                        <label><?php echo renderLang($operation_audit_tsa_fire_extinguishers_site); ?></label>
                                                                                                        <input type="text" class="form-control" name="fire_safety_site[]">
                                                                                                        <input type="hidden" name="fire_safety_code[]" value="<?php echo $key; ?>">
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                                                                                                                                    
                                                                                                <div class="row">
                                                                                                    <div class="col-12">
                                                                                                        <div class="form-group">
                                                                                                            <div class="table-responsive">
                                                                                                                <table class="table table-bordered table-hover">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th><?php echo renderLang($operation_audit_tsa_fire_extinguishers_location); ?></th>
                                                                                                                            <th><?php echo renderLang($operation_audit_tsa_fire_extinguishers_type); ?></th>
                                                                                                                            <th><?php echo renderLang($operation_audit_tsa_fire_extinguishers_qty); ?></th>
                                                                                                                            <th><?php echo renderLang($operation_audit_tsa_fire_extinguishers_capacity); ?></th>
                                                                                                                            <th><?php echo renderLang($operation_audit_tsa_fire_extinguishers_date); ?></th>
                                                                                                                            <th rowspan="2" class="w35"></th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        <tr class="default-row-site-loc">
                                                                                                                            <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_location[]"></td>
                                                                                                                            <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_type[]"></td>
                                                                                                                            <td><input type="number" class="form-control border-0" name="<?php echo $key; ?>_quantity[]"></td>
                                                                                                                            <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_capacity[]"></td>
                                                                                                                            <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_date[]"></td>
                                                                                                                            <td class="d-none"><input type="text" class="site_loc_category" name="<?php echo $key; ?>_loc_category[]" value="1"></td>
                                                                                                                            <td>
                                                                                                                                <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                                <div class="text-right">
                                                                                                                    <button class="btn btn-info add-row-site-loc"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="text-right">
                                                                                            <button class="btn btn-info add-row-site"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                                        </div> 
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <?php } ?>

                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                        $num++;
                                                    } 
                                                    ?>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 4 AUDIT OF PERMITS AND LICENCES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-permits" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_4).' - '.renderLang($pre_operation_audit_of_permits); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-permits">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_of_permits); ?></h3>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo renderLang($pre_operation_audit_tsa_particulars); ?></th>
                                                                    <th><?php echo renderLang($pre_operation_audit_date_issuance); ?></th>
                                                                    <th><?php echo renderLang($pre_operation_audit_pvc_findings); ?></th>
                                                                    <th><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                    <th><?php echo renderlang($pre_operation_audit_tsa_recommendations); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $sql = $pdo->prepare("SELECT * FROM permits_and_licences WHERE module = 'pre-operation-audit-tsa' AND temp_del = 0");
                                                                $sql->execute();
                                                                while($_data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo '<tr>';

                                                                        echo '<td><p>'.$_data['name'].'</p><input type="hidden" name="particulars[]" value="'.$_data['id'].'"></td>';
                                                                        echo '<td><input type="text" name="permit_date_of_issuance[]" class="form-control border-0"></td>';

                                                                        echo '<td>';
                                                                            echo '<select name="permit_findings[]" class="form-control border-0 picture_findings">';
                                                                                echo '<option></option>';
                                                                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                    echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                        echo '</td>';
                                                                        echo '<td>';
                                                                            echo '<select name="permit_priority[]" class="form-control border-0 picture_priority">';
                                                                                echo '<option></option>';
                                                                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                    echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                            echo '<div class="picture_priority_specify '.($data['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                echo '<input type="text" class="form-control" name="permit_priority_specify[]">';
                                                                            echo '</div>';
                                                                        echo '</td>';
                                                                        echo '<td><textarea name="permit_recommendation[]" class="form-control notes border-0"></textarea></td>';

                                                                    echo '</tr>';
                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 5 INVENTORY OF AS-BUILT PLANS AND EQUIPMENT MANUALS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-inventory" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_5).' - '.renderLang($pre_operation_audit_tsa_inventory); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-inventory">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_tsa_inventory); ?></h3>
                                                </div>
                                                <div class="card-body">
                                                                
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">1. <?php echo renderLang($pre_operation_audit_tsa_as_built_plan); ?></label>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="w300"><?php echo renderLang($pre_operation_audit_pvc_findings); ?></th>
                                                                                <th class="w200"><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_recommendations); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_description); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_sheets_available); ?></th>
                                                                                <th rowspan="2" class="w35"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="default-row">
                                                                                <td>
                                                                                    <select name="as_built_findings[]" class="form-control picture_findings">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select name="as_built_priority[]" class="form-control picture_priority">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    <div class="picture_priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
                                                                                        <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                        <input type="text" class="form-control" name="as_built_priority_specify[]">
                                                                                    </div>
                                                                                </td>
                                                                                <td><textarea name="as_built_recommendation[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td>
                                                                                    <div class="row m-auto">
                                                                                        <button class="btn btn-danger btn-sm remove-row ">
                                                                                            <i class="fa fa-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row-sec4"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">2. <?php echo renderLang($pre_operation_audit_tsa_equipment_manuals); ?></label>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="w250"><?php echo renderLang($pre_operation_audit_pvc_findings); ?></th>
                                                                                <th class="w200"><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_recommendations); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_contractor); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_description); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_submitted_documents); ?></th>
                                                                                <th rowspan="2" class="w35"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="default-row">
                                                                                <td>
                                                                                    <select name="manual_findings[]" class="form-control picture_findings border-0">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select name="manual_priority[]" class="form-control picture_priority border-0">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    <div class="picture_priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
                                                                                        <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                        <input type="text" class="form-control" name="manual_priority_specify[]">
                                                                                    </div>
                                                                                </td>
                                                                                <td><textarea name="manual_recommendation[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="manual_contractor[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="manual_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="manual_documents[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row-sec4"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>         

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audit-tsa-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
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
    <script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
	<script>
		$(function(){

            // findings equivalent prioritization
            $('body').on('change', '.findings', function(){
                var finding_key = $(this).val();
                var priority_arr = <?php echo json_encode($tsa_audit_prioritization_arr); ?>;
                var findings_arr = <?php echo json_encode($tsa_audit_fingings_arr); ?>;
                var priority_key = findings_arr[finding_key]['proiritization'];
                
                $(this).closest('.row').find('.priority').val(priority_key);

                if(priority_key == 5) {
                    $(this).closest('.row').find('.priority_specify').removeClass("d-none");
                } else {
                    $(this).closest('.row').find('.priority_specify').addClass("d-none");
                }

            });

            // Others specify
            $('body').on('change', '.priority', function(){

                var priority_key = $(this).val();
                if(priority_key == 5) {
                    $(this).closest('div').find('.priority_specify').removeClass('d-none');
                } else {
                    $(this).closest('div').find('.priority_specify').addClass('d-none');
                }

            });

            // findings equivalent prioritization
            $('body').on('change', '.picture_findings', function(){
                var picture_finding_key = $(this).val();
                var picture_priority_arr = <?php echo json_encode($tsa_audit_prioritization_arr); ?>;
                var picture_findings_arr = <?php echo json_encode($tsa_audit_fingings_arr); ?>;
                var picture_priority_key = picture_findings_arr[picture_finding_key]['proiritization'];
                
                $(this).closest('tr').find('.picture_priority').val(picture_priority_key);

                if(picture_priority_key == 5) {
                    $(this).closest('tr').find('.picture_priority_specify').removeClass("d-none");
                } else {
                    $(this).closest('tr').find('.picture_priority_specify').addClass("d-none");
                }

            });

            // Others specify
            $('body').on('change', '.picture_priority', function(){

                var picture_priority_key = $(this).val();
                if(picture_priority_key == 5) {
                    $(this).closest('tr').find('.picture_priority_specify').removeClass('d-none');
                } else {
                    $(this).closest('tr').find('.picture_priority_specify').addClass('d-none');
                }

            });

			$('.duallistbox').bootstrapDualListbox();

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });

            $('#date_of_audit').daterangepicker({
                singleDatePicker: false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            
            // add row location
            var num = 1;
            $('body').on('click', '.add-row-location', function(e){
                e.preventDefault();

                num++;

                var location = $(this).closest('.location-row').find('.card').html();
                
                $(this).closest('.location-row').find('.location').append('<div class="card">'+location+'</div>');

            });

            // section 5 add row
            $('body').on('click', '.add-row-sec4', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('tbody').find('tr:nth-child(1)').html();

                $(this).closest('.table-responsive').find('tbody').append('<tr>'+fields+'</tr>');

            });
            
            // add row pictures
            $('body').on('click', '.add-row-pictures', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('.table-responsive').find('tbody').find('tr:nth-child(1)').html();
                $(this).closest('.table-responsive').find('tbody').append(fields);

            });

            // add row conformance
			$('body').on('click', '.add-row-conformance', function(e){
				e.preventDefault();

				var field = '<tr>'+$(this).closest('table').find('tbody').find('tr:nth-child(1)').html();
				$(this).closest('table').find('tbody').append(field);

			});

            // add row site
            $('body').on('click', '.add-row-site', function(e){
                e.preventDefault();

                var num2 = $(this).closest('div').prev().prev().val()*1;

                var site = $(this).closest('.site-row').find('.site').html();

                num2++;
                
                $(this).closest('div').before('<input type="hidden" class="site_category" name="fire_safety_site_category[]" value="'+num2+'"><div class="card">'+site+'</div>');

                $(this).closest('.site-row').find('.card:nth-last-child(2)').find('.site_loc_category').val(num2);


            });

            // section 5 add row
            $('body').on('click', '.add-row-site-loc', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('tbody').find('tr:nth-child(1)').html();

                $(this).closest('.table-responsive').find('tbody').append('<tr>'+fields+'</tr>');
                

                var num = $(this).closest('.card').prev().val();

                $(this).closest('.card').find('.site_loc_category').each(function(){

                    $(this).val(num);

                });

            });

            // remove row
            $('body').on('click', '.remove-row', function(e){
                var $this = $(this);
                e.preventDefault();
                if($(this).closest('tbody').children('tr').length != 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('last row cannot be deleted');
                }
               
            });
            // 

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
