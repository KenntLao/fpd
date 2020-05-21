<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-TSA-edit')) {

    $page = 'pre-operation-audit';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa WHERE id = :id AND temp_del = 0 LIMIT 1");
    $sql->bindParam(":id", $id);
    $sql->execute();
    if($sql->rowCount()) {

        $_data = $sql->fetch(PDO::FETCH_ASSOC);

    } else {

        $_SESSION['sys_pre_operation_audit_tsa_err'] = renderLang($pre_operation_audit_tsa_not_found);
        header('location: /pre-operation-audit-tsa-list');
        exit();
    }
    

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($pre_operation_audit_tsa_edit); ?> &middot; <?php echo $sitename; ?></title>
	
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_tsa_edit); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php
                    renderError('sys_pre_operation_audit_tsa_edit_err');
                    renderSuccess('sys_pre_operation_audit_tsa_edit_suc');
                    ?>

                    <form action="/submit-edit-tsa-pre-operation-audit" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_tsa); ?></h3>
                                <div class="card-tools">
                                    <?php if(checkPermission('pre-operation-audit-TSA-delete')) { ?><a href="" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash mr-1"></i><?php echo renderLang($pre_operation_audit_tsa_delete); ?></a><?php } ?>
                                    <button type="button" class="btn btn-<?php echo $audit_status_color_arr[$_data['status']]; ?>"><?php echo renderLang($audit_status_arr[$_data['status']]); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- TSA DATA -->
                                <div class="row">

                                    <input type="hidden" name="tsa_id" value="<?php echo $id; ?>">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="project"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                            <select name="prospect_id" id="project" class="form-control select2">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT id, reference_number, project_name FROM prospecting WHERE temp_del = 0 AND status = 3 AND prospecting_category = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option '.($_data['prospect_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">['.$data['reference_number'].'] '.$data['project_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_of_audit"><?php echo renderLang($pre_operation_audit_date_of_audit); ?></label>
                                            <input type="text" class="form-control" name="date_of_audit" id="date_of_audit" value="<?php echo $_data['date_of_audit']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_presented"><?php echo renderLang($pre_operation_audit_tsa_date_presented_to_board); ?></label>
                                            <input type="text" name="date_presented" id="date_presented" class="form-control date" value="<?php echo formatDate($_data['date_presented']); ?>">
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
                                                                <textarea name="summary" id="" rows="10" class="form-control notes"><?php echo $_data['summary']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead class="text-center bg-dark">
                                                                            <tr>
                                                                                <th class="w100"><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_findings); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_recommendation); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php 

                                                                        $num = 1;
                                                                        foreach ($tsa_audit_prioritization_arr as $key => $prioritization){ 

                                                                            if (renderlang($prioritization) != 'Others') {

                                                                         ?>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="3" class="bg-gray" data-toggle="toggle">
                                                                                            <label><?php echo $num.'. '.renderlang($prioritization); ?></label>
                                                                                            <input type="hidden" name="summary_category[]" value="<?= $key ?>">
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                                <tbody class="hide">
                                                                                <?php
                                                                                // SYSTEM
                                                                                $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system WHERE tsa_id = :tsa_id");
                                                                                $sql->bindParam(":tsa_id", $id);;
                                                                                $sql->execute();
                                                                                while($data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                    //
                                                                                        $sql2 = $pdo->prepare("SELECT system_id, recommendation, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_system_locations  WHERE system_id = :system_id AND prioritization = :prioritization");
                                                                                        $sql2->bindParam(":system_id", $data2['id']);
                                                                                        $sql2->bindParam(":prioritization", $key);
                                                                                        $sql2->execute();

                                                                                        while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                            if (!empty($data3['findings'])) {

                                                                                                echo '<tr>';

                                                                                                    echo '<td>';
                                                                                                    echo '<p class="w250">'.(empty($data2['category']) ? '' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                                                                    echo '</td>';
                                                                                                    echo '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                                                                    echo '<td><p>'.$data3['recommendation'].'</p></td>';

                                                                                                echo '</tr>';

                                                                                            }
                                                                                        }

                                                                                    // SYS PICTURES
                                                                                        $sql2 = $pdo->prepare("SELECT system_id, recommendations, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_system_pictures  WHERE system_id = :system_id AND prioritization = :prioritization");
                                                                                        $sql2->bindParam(":system_id", $data2['id']);
                                                                                        $sql2->bindParam(":prioritization", $key);
                                                                                        $sql2->execute();

                                                                                        while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                            if (!empty($data3['findings'])) {

                                                                                                echo '<tr>';

                                                                                                    echo '<td>';
                                                                                                    echo '<p class="w250">'.(empty($data2['category']) ? '' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                                                                    echo '</td>';
                                                                                                    echo '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                                                                    echo '<td><p>'.$data3['recommendations'].'</p></td>';

                                                                                                echo '</tr>';

                                                                                            }
                                                                                        }
                                                                            }

                                                                            // PERMIT
                                                                                $sql2 = $pdo->prepare("SELECT recommendation, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_permit_licences WHERE prioritization = :prioritization AND tsa_id = :id");
                                                                                $sql2->bindParam(":prioritization", $key);
                                                                                $sql2->bindParam(":id", $id);
                                                                                $sql2->execute();

                                                                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                    if (!empty($data3['findings'])) {

                                                                                        echo '<tr>';

                                                                                            echo '<td>';
                                                                                            echo '<p class="w250">'.(empty($data2['category']) ? 'PERMIT AND LICENSES' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                                                            echo '</td>';
                                                                                            echo '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                                                            echo '<td><p>'.$data3['recommendation'].'</p></td>';

                                                                                        echo '</tr>';

                                                                                    }
                                                                                }

                                                                            // AS BUILT PLAN
                                                                                $sql2 = $pdo->prepare("SELECT recommendation,  findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_as_built_plans  WHERE prioritization = :prioritization AND tsa_id = :id");
                                                                                $sql2->bindParam(":prioritization", $key);
                                                                                $sql2->bindParam(":id", $id);
                                                                                $sql2->execute();

                                                                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                    if (!empty($data3['findings'])) {

                                                                                        echo '<tr>';

                                                                                            echo '<td>';
                                                                                            echo '<p class="w250">'.(empty($data2['category']) ? 'AS-BUILT PLANS' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                                                            echo '</td>';
                                                                                            echo '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                                                            echo '<td><p>'.$data3['recommendation'].'</p></td>';

                                                                                        echo '</tr>';

                                                                                    }
                                                                                }

                                                                            // EQUIPMENT MANUALS
                                                                                $sql2 = $pdo->prepare("SELECT recommendation, findings, prioritization_specify, prioritization FROM pre_operation_audit_tsa_equipment_manuals  WHERE prioritization = :prioritization AND tsa_id = :id");
                                                                                $sql2->bindParam(":prioritization", $key);
                                                                                $sql2->bindParam(":id", $id);
                                                                                $sql2->execute();

                                                                                while ($data3 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                    if (!empty($data3['findings'])) {

                                                                                        echo '<tr>';

                                                                                            echo '<td>';
                                                                                            echo '<p class="w250">'.(empty($data2['category']) ? 'EQUIPMENT MANUALS' : renderLang($tsa_section_3_arr[$data2['category']][0])).'</p>';
                                                                                            echo '</td>';
                                                                                            echo '<td><p>'.(checkVar($data3['findings']) ? renderLang($tsa_audit_fingings_arr[$data3['findings']]['findings']) : '').'</p></td>';
                                                                                            echo '<td><p>'.$data3['recommendation'].'</p></td>';

                                                                                        echo '</tr>';

                                                                                    }
                                                                                }


                                                                                    $num++;
                                                                                }
                                                                            ?>
                                                                            </tbody>
                                                                        <?php } ?>
                                                                    </table>
                                                                </div>
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
                                                                <textarea name="building_description" id="" rows="10" class="form-control notes"><?php echo $_data['building_description']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="text-center">
                                                                <img src="/assets/uploads/pre-operation-audit/<?php echo $_data['building_picture']; ?>" class="img-fluid mb-2 mr-2 img-thumbnail img-responsive" alt="white sample"/>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($pre_operation_audit_tsa_update_building_picture); ?></label>
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
																		<?php 
																		$sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_compliances WHERE tsa_id = :tsa_id");
																		$sql->bindParam(":tsa_id", $id);
																		$sql->execute();
																		if($sql->rowCount()) {
																			while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
																				echo '<tr>';
																					echo '<input type="hidden" name="compliance_id[]" value="'.$data['id'].'">';
																					echo '<td>';
																						echo '<textarea name="non_conformance[]" class="form-control notes border-0">'.$data['conformance'].'</textarea>';
																					echo '</td>';
																					echo '<td>';
																						echo '<textarea name="conformance_status[]" class="form-control notes border-0">'.$data['status'].'</textarea>';
																					echo '</td>';
																					echo '<td>';
																						echo '<textarea name="conformance_remarks[]" class="form-control notes border-0">'.$data['remarks'].'</textarea>';
																					echo '</td>';
																				echo '</tr>';
																			}
																		}
																		?>
																		<tr class="default-row">
																			<input type="hidden" name="compliance_id[]" value="0">
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

                                                        $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system WHERE tsa_id = :id AND category = :category LIMIT 1");
                                                        $sql->bindParam(":id", $id);
                                                        $sql->bindParam(":category", $section_key);
                                                        $sql->execute();
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                        $system_id = $data['id'];
                                                        $details = $data['details'];
                                                        $notes = $data['notes'];

                                                    echo '<input type="hidden" name="location_category[]" value="'.$section_key.'">';
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">
                                                                <button class="btn pms-red text-white w300 text-left" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $num; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $num.'. '.renderLang($system[0]); ?></button>
                                                            </p>
                                                            <div class="collapse" id="tab-<?php echo $num; ?>">

                                                                <input type="hidden" name="system_id[]" value="<?php echo $system_id; ?>">

                                                                <div class="row">

                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <textarea name="location_details[]" rows="2" class="form-control notes"><?php echo $details; ?></textarea>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <!-- locations -->
                                                                <div class="location-row">
                                                                    <div class="location">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_locations WHERE system_id = :system_id");
                                                                    $sql->bindParam(":system_id", $system_id);
                                                                    $sql->execute();
                                                                    if($sql->rowCount()) {

                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                    ?>
                                                                        <input type="hidden" name="location_id[]" value="<?php echo $data['id']; ?>">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <div class="card-tools">
                                                                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_tsa_location); ?></label>
                                                                                    <input type="text" name="location[]" class="form-control"  value="<?php echo $data['location']; ?>">
                                                                                    <input type="hidden" name="location_code[]" value="<?php echo $section_key; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">

                                                                                    <div class="<?php echo ($section_key == 'aircon' || $section_key == 'electrical' || $section_key == 'mechanical' ? 'col-lg-6 col-md-12' : 'col-md-12'); ?>">

                                                                                        <div class="form-group">
                                                                                            <label for="location_unit"><?php echo renderLang($pre_operation_audit_tsa_unit); ?></label>
                                                                                            <input type="text" class="form-control" name="location_unit[]" id="location_unit" value="<?php echo $data['unit']; ?>">
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
                                                                                                            echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
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
                                                                                                        echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <div class="priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
                                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                                    <input type="text" class="form-control" name="priority_specify[]" value="<?php echo $data['prioritization_specify']; ?>">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        <!-- recommendation -->
                                                                                        <div class="form-group">
                                                                                            <label><?php echo renderLang($turnover_audit_tsa_recommendation); ?></label>
                                                                                            <textarea name="location_recommendation[]" class="form-control notes"><?php echo $data['recommendation']; ?></textarea>
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
                                                                                                $sql1 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_units WHERE location_id = :location_id");
                                                                                                $sql1->bindParam(":location_id", $data['id']);
                                                                                                $sql1->execute();
                                                                                                $fetch = array();
                                                                                                while ($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                                                    $fetch[$data1['specification_category']] = array(
                                                                                                        'spec' => $data1['specification'],
                                                                                                        'data' => $data1['operational_data'],
                                                                                                        'id' => $data1['id']
                                                                                                    );
                                                                                                }
                                                                                                foreach($system[1] as $key => $fields) {
                                                                                                    echo '<tr>';
                                                                                                    echo '<input type="hidden" name="'.$section_key.'_location_unit_id_val[]" value="'.(isset($fetch[$key]['id']) ? $fetch[$key]['id'] : 0).'">';
                                                                                                    echo '<td><p>'.renderLang($fields).'</p><input type="hidden" name="'.$section_key.'_specification_category_val[]" value="'.$key.'"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" value="'.(isset($fetch[$key]['spec']) ? $fetch[$key]['spec'] : '').'" name="'.$section_key.'_specification_val[]"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" value="'.(isset($fetch[$key]['data']) ? $fetch[$key]['data'] : '').'" name="'.$section_key.'_data_val[]"></td>';

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

                                                                        <?php } ?>

                                                                    <?php } else { ?>
                                                                        <input type="hidden" name="location_id[]" value="<?php echo $data['id']; ?>">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <div class="card-tools">
                                                                                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_tsa_location); ?></label>
                                                                                    <input type="text" name="location[]" class="form-control"  value="<?php echo $data['location']; ?>">
                                                                                    <input type="hidden" name="location_code[]" value="<?php echo $section_key; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">

                                                                                    <div class="<?php echo ($section_key == 'aircon' || $section_key == 'electrical' || $section_key == 'mechanical' ? 'col-lg-6 col-md-12' : 'col-md-12'); ?>">

                                                                                        <div class="form-group">
                                                                                            <label for="location_unit"><?php echo renderLang($pre_operation_audit_tsa_unit); ?></label>
                                                                                            <input type="text" class="form-control" name="location_unit[]" id="location_unit" value="<?php echo $data['unit']; ?>">
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
                                                                                                            echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
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
                                                                                                        echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <div class="priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
                                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                                    <input type="text" class="form-control" name="priority_specify[]" value="<?php echo $data['prioritization_specify']; ?>">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        <!-- recommendation -->
                                                                                        <div class="form-group">
                                                                                            <label><?php echo renderLang($turnover_audit_tsa_recommendation); ?></label>
                                                                                            <textarea name="location_recommendation[]" class="form-control notes"><?php echo $data['recommendation']; ?></textarea>
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
                                                                                                $sql1 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_units WHERE location_id = :location_id");
                                                                                                $sql1->bindParam(":location_id", $data['id']);
                                                                                                $sql1->execute();
                                                                                                $fetch = array();
                                                                                                while ($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                                                    $fetch[$data1['specification_category']] = array(
                                                                                                        'spec' => $data1['specification'],
                                                                                                        'data' => $data1['operational_data'],
                                                                                                        'id' => $data1['id']
                                                                                                    );
                                                                                                }
                                                                                                foreach($system[1] as $key => $fields) {
                                                                                                    echo '<tr>';
                                                                                                    echo '<input type="hidden" name="'.$section_key.'_location_unit_id_val[]" value="'.(isset($fetch[$key]['id']) ? $fetch[$key]['id'] : 0).'">';
                                                                                                    echo '<td><p>'.renderLang($fields).'</p><input type="hidden" name="'.$section_key.'_specification_category_val[]" value="'.$key.'"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" value="'.(isset($fetch[$key]['spec']) ? $fetch[$key]['spec'] : '').'" name="'.$section_key.'_specification_val[]"></td>';
                                                                                                    echo '<td><input type="text" class="form-control border-0" value="'.(isset($fetch[$key]['data']) ? $fetch[$key]['data'] : '').'" name="'.$section_key.'_data_val[]"></td>';

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
                                                                    <?php } ?>
                                                                    </div>

                                                                    <div class="default-location d-none">
                                                                        <input type="hidden" name="location_id[]" value="0">
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
                                                                                                            echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
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
                                                                                                        echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <div class="priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
                                                                                                    <label for=""><?php echo renderLang($pre_operation_audit_specify); ?></label>
                                                                                                    <input type="text" class="form-control" name="priority_specify[]" value="<?php echo $data['prioritization_specify']; ?>">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        <!-- recommendation -->
                                                                                        <div class="form-group">
                                                                                            <label><?php echo renderLang($turnover_audit_tsa_recommendation); ?></label>
                                                                                            <textarea name="location_recommendation[]" class="form-control notes"><?php echo $data['recommendation']; ?></textarea>
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

                                                                                                    echo '<input type="hidden" name="location_unit_id[]" value="0">';

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
                                                                                    <?php 
                                                                                    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_pictures WHERE system_id = :id");
                                                                                    $sql->bindParam(":id", $system_id);
                                                                                    $sql->execute();
                                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                        echo '<tr>';

                                                                                            echo '<input type="hidden" name="picture_id[]" value="'.$data['id'].'">';
                                                                                            echo '<input type="hidden" name="delete_id[]" value="'.$data['id'].'">';
                                                                                            echo '<input type="hidden" name="delete_category[]" value="system-pictures">';

                                                                                            echo '<td>';
                                                                                                renderAttachments($data['picture'], 'pre-operation-audit', '100px', '100px');
                                                                                                echo '<input type="file" name="pictures[]" class="form-control border-0 d-inline">';
                                                                                            echo '</td>';

                                                                                            echo '<td>';
                                                                                                echo '<select name="picture_findings[]" class="form-control picture_findings">';
                                                                                                echo '<option></option>';
                                                                                                    foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                        echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                                    }
                                                                                                echo '</select>';
                                                                                            echo '</td>';

                                                                                            echo '<td>';
                                                                                                echo '<select name="picture_priority[]" class="form-control picture_priority">';
                                                                                                echo '<option></option>';
                                                                                                    foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                        echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                    }
                                                                                                echo '</select>';

                                                                                                echo '<div class="picture_priority_specify '.($data['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                                echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                                echo '<input type="text" class="form-control" name="picture_priority_specify[]" value="'.$data['prioritization_specify'].'">';

                                                                                            echo '</td>';

                                                                                            echo '<td><textarea name="picture_recommendations[]" class="form-control notes border-0">'.$data['recommendations'].'</textarea></td>';

                                                                                            echo '<td>';
                                                                                            echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                                                            echo '</td>';

                                                                                            echo '<input type="hidden" name="picture_code[]" value="'.$section_key.'">';

                                                                                        echo '</tr>';

                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr class="default-row d-none">
                                                                                        <input type="hidden" name="delete_id[]" value="0">
                                                                                        <input type="hidden" name="delete_category[]" value="system-pictures">
                                                                                        <input type="hidden" name="picture_id[]" value="0">
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
                                                                                            <div class="picture_priority_specify <?php echo $data['prioritization'] == 5 ? '' : 'd-none'; ?>">
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
                                                                                </tfoot>
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
                                                                            <textarea name="notes[]" id="notes" rows="2" class="form-control notes"><?php echo $notes; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($section_key == 'fire_safety_and_security') { ?>

                                                                    <?php foreach ($tsa_operations_audit_fire_safety_and_security as $key => $fire_safety_and_security) { 

                                                                    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_fire_safety_and_security WHERE tsa_id = :tsa_id AND category = :category");
                                                                    $sql->bindParam(":tsa_id",$id);
                                                                    $sql->bindParam(":category",$key);
                                                                    $sql->execute();
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    ?>

                                                                    <!-- FIRE EXTINGUISHER -->
                                                                    <div class="row mt-4">
                                                                        <div class="col-12">
                                                                            <p class="text-center">
                                                                                <button class="btn bg-secondary text-white w100pc text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseExample"><?php echo renderLang($fire_safety_and_security); ?></button>
                                                                            </p>
                                                                            <div class="collapse show" id="tab_<?php echo $key; ?>">

                                                                                <input type="hidden" name="fire_safety_category[]" value="<?php echo $key; ?>">
                                                                                <input type="hidden" name="fire_safety_id[]" value="<?php echo $data['id']; ?>">

                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div class="card-header text-center">
                                                                                            <h3><?php echo renderLang($fire_safety_and_security); ?></h3>
                                                                                        </div>
                                                                                        <div class="row my-4">
                                                                                            <div class="col-12">
                                                                                                <label><?php echo renderLang($pre_operation_audit_tsa_details); ?></label>
                                                                                                <textarea class="form-control notes" name="fire_safety_details[]"><?php echo $data['details']; ?></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="site-row">
                                                                                    <?php 
                                                                                    $last_num = 0;
                                                                                    $sql2 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_fire_safety_and_security_site WHERE fire_safety_id = :fire_safety_id");
                                                                                    $sql2->bindParam(":fire_safety_id",$data['id']);
                                                                                    $sql2->execute();
                                                                                    if ($sql->rowCount()) {
                                                                                        while ($data2 = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                                    ?>
                                                                                            <input type="hidden" class="site_category" name="fire_safety_site_category[]" value="<?php echo $data2['category']; ?>">
                                                                                            <div class=" card m-2">
                                                                                                <div class="card-body">

                                                                                                    <div class="row mb-4">
                                                                                                        <div class="col-6">
                                                                                                            <label><?php echo renderLang($operation_audit_tsa_fire_extinguishers_site); ?></label>
                                                                                                            <input type="text" class="form-control" name="fire_safety_site[]" value="<?php echo $data2['site']; ?>">
                                                                                                            <input type="hidden" name="fire_safety_code[]" value="<?php echo $key; ?>">
                                                                                                            <input type="hidden" name="fire_safety_site_id[]" value="<?php echo $data2['id']; ?>">
                                                                                                            
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
                                                                                                                                <th class="w35"></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                        <?php 
                                                                                                                        $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_fire_safety_and_security_site_location WHERE category = :site_loc_category AND site_id = :site_id");
                                                                                                                        $sql->bindParam(":site_loc_category",$data2['category']);
                                                                                                                        $sql->bindParam(":site_id",$data2['id']);
                                                                                                                        $sql->execute();
                                                                                                                        if ($sql->rowCount()) {
                                                                                                                            while ($data3 = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                                                                         ?>
                                                                                                                            <tr>
                                                                                                                                <input type="hidden" name="delete_id[]" value="<?php echo $data3['id']; ?>">
                                                                                                                                <input type="hidden" name="delete_category[]" value="site-location">
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_location[]" value="<?php echo $data3['location']; ?>"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_type[]" value="<?php echo $data3['type']; ?>"></td>
                                                                                                                                <td><input type="number" class="form-control border-0" name="<?php echo $key; ?>_quantity[]" value="<?php echo $data3['quantity']; ?>"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_capacity[]" value="<?php echo $data3['capacity']; ?>"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_date[]" value="<?php echo $data3['date_of_last_refill']; ?>"></td>
                                                                                                                                <td class="d-none"><input type="text" class="site_loc_category" name="<?php echo $key; ?>_loc_category[]" value="<?php echo $data3['category']; ?>"></td>
                                                                                                                                <td>
                                                                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                                                                </td>

                                                                                                                                <!-- Site Location ID -->
                                                                                                                                <td class="d-none"><input type="text" name="<?php echo $key; ?>_loc_id[]"  value="<?php echo $data3['id']; ?>"></td>
                                                                                                                            </tr>
                                                                                                                            <?php } ?>
                                                                                                                        <?php }?>
                                                                                                                        </tbody>
                                                                                                                        <tfoot>
                                                                                                                            <tr class="default-row-site-loc d-none">
                                                                                                                                <input type="hidden" name="delete_id[]" value="0">
                                                                                                                                <input type="hidden" name="delete_category[]" value="site-location">
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_location[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_type[]"></td>
                                                                                                                                <td><input type="number" class="form-control border-0" name="<?php echo $key; ?>_quantity[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_capacity[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_date[]" ></td>
                                                                                                                                <td class="d-none"><input type="text" class="site_loc_category" name="<?php echo $key; ?>_loc_category[]"  value="0"></td>
                                                                                                                                <td>
                                                                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                                                                </td>

                                                                                                                                <!-- Site Location ID -->
                                                                                                                                <td class="d-none"><input type="text" name="<?php echo $key; ?>_loc_id[]"  value="0"></td>
                                                                                                                            </tr>
                                                                                                                        </tfoot>
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

                                                                                            <?php $last_num = $data2['category'] ?>
                                                                                        <?php } ?>
                                                                                    <?php } ?>

                                                                                        <input type="hidden" class="site_category" name="fire_safety_site_category[]" value="<?php echo $last_num; ?>">
                                                                                            <div class="site card m-2 d-none">
                                                                                                <div class="card-body">

                                                                                                    <div class="row mb-4">
                                                                                                        <div class="col-6">
                                                                                                            <label><?php echo renderLang($operation_audit_tsa_fire_extinguishers_site); ?></label>
                                                                                                            <input type="text" class="form-control" name="fire_safety_site[]">
                                                                                                            <input type="hidden" name="fire_safety_code[]" value="<?php echo $key; ?>">
                                                                                                            <input type="hidden" name="fire_safety_site_id[]" value="0">
                                                                                                            
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
                                                                                                                                <th class="w35"></th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr class="default-row-site-loc">
                                                                                                                                <input type="hidden" name="delete_id[]" value="0">
                                                                                                                                <input type="hidden" name="delete_category[]" value="site-location">
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_location[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_type[]"></td>
                                                                                                                                <td><input type="number" class="form-control border-0" name="<?php echo $key; ?>_quantity[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_capacity[]"></td>
                                                                                                                                <td><input type="text" class="form-control border-0" name="<?php echo $key; ?>_date[]" ></td>
                                                                                                                                <td class="d-none"><input type="text" class="site_loc_category" name="<?php echo $key; ?>_loc_category[]"  value="0"></td>
                                                                                                                                <td>
                                                                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                                                                </td>

                                                                                                                                <!-- Site Location ID -->
                                                                                                                                <td class="d-none"><input type="text" name="<?php echo $key; ?>_loc_id[]"  value="0"></td>
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
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                    $sql2 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_permit_licences WHERE particulars = :particulars AND tsa_id = :tsa_id");
                                                                    $sql2->bindParam(":particulars",$data['id']);
                                                                    $sql2->bindParam(":tsa_id",$id);
                                                                    $sql2->execute();
                                                                    $data2 = $sql2->fetch(PDO::FETCH_ASSOC);

                                                                    echo '<tr>';

                                                                        echo '<input type="hidden" name="permit_id[]" value="'.$data['id'].'">';

                                                                        echo '<td><p>'.$data['name'].'</p><input type="hidden" name="particulars[]" value="'.$data['id'].'"></td>';
                                                                        echo '<td><input type="text" name="permit_date_of_issuance[]" class="form-control border-0" value="'.$data2['date_of_issuance'].'"></td>';

                                                                        echo '<td>';
                                                                            echo '<select name="permit_findings[]" class="form-control border-0 picture_findings">';
                                                                                echo '<option></option>';
                                                                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                    echo '<option  '.($data2['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                        echo '</td>';
                                                                        echo '<td>';
                                                                            echo '<select name="permit_priority[]" class="form-control border-0 picture_priority">';
                                                                                echo '<option ></option>';
                                                                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                    echo '<option '.(checkVar($data2['prioritization']) && $data2['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                            echo '<div class="picture_priority_specify '.($data2['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                echo '<input type="text" class="form-control" name="permit_priority_specify[]">';
                                                                            echo '</div>';
                                                                        echo '</td>';
                                                                        echo '<td><textarea name="permit_recommendation[]" class="form-control notes border-0">'.$data2['recommendation'].'</textarea></td>';
                                                                        echo '<input type="hidden" name="pre_ops_permit_id[]" value="'.$data2['id'].'">';

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
                                                                                <th class="w35"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                            $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_as_built_plans WHERE tsa_id = :tsa_id");
                                                                            $sql->bindParam(":tsa_id", $id);
                                                                            $sql->execute();
                                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                echo '<tr>';

                                                                                    echo '<input type="hidden" name="as_built_id[]" value="'.$data['id'].'">';
                                                                                    echo '<input type="hidden" name="delete_id[]" value="'.$data['id'].'">';
                                                                                    echo '<input type="hidden" name="delete_category[]" value="as-built-plans">';

                                                                                    echo '<td>';
                                                                                        echo '<select name="as_built_findings[]" class="form-control picture_findings">';
                                                                                        echo '<option></option>';
                                                                                            foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                            }
                                                                                        echo '</select>';
                                                                                    echo '</td>';

                                                                                    echo '<td>';
                                                                                        echo '<select name="as_built_priority[]" class="form-control picture_priority">';
                                                                                        echo '<option></option>';
                                                                                            foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                            }
                                                                                        echo '</select>';

                                                                                        echo '<div class="picture_priority_specify '.($data['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                        echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                        echo '<input type="text" class="form-control" name="as_built_priority_specify[]" value="'.$data['prioritization_specify'].'">';
                                                                                        echo '</>';

                                                                                    echo '</td>';

                                                                                    echo '<td><textarea name="as_built_recommendation[]" class="form-control notes border-0">'.$data['recommendation'].'</textarea></td>';

                                                                                    echo '<td><textarea name="as_built_description[]"  class="form-control notes border-0">'.$data['description'].'</textarea></td>';

                                                                                    echo '<td><textarea name="sheets[]" class="form-control notes border-0">'.$data['sheets_available'].'</textarea></td>';

                                                                                    echo '<td>';
                                                                                    echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                                                    echo '</td>';

                                                                                echo '</tr>';

                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr class="default-row d-none">
                                                                                <input type="hidden" name="as_built_id[]" value="0">
                                                                                <input type="hidden" name="delete_id[]" value="0">
                                                                                <input type="hidden" name="delete_category[]" value="as-built-plans">
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
                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info" id="add-row-sec4"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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
                                                                            <?php 
                                                                            $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_equipment_manuals WHERE tsa_id = :id");
                                                                            $sql->bindParam(":id", $id);
                                                                            $sql->execute();
                                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                                echo '<tr>';

                                                                                echo '<input type="hidden" name="manual_id[]" value="'.$data['id'].'">';
                                                                                echo '<input type="hidden" name="delete_id[]" value="'.$data['id'].'">';
                                                                                echo '<input type="hidden" name="delete_category[]" value="equipment-manuals">';

                                                                                echo '<td>';
                                                                                    echo '<select name="manual_findings[]" class="form-control picture_findings">';
                                                                                    echo '<option></option>';
                                                                                        foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                            echo '<option '.($data['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                        }
                                                                                    echo '</select>';
                                                                                echo '</td>';

                                                                                echo '<td>';
                                                                                    echo '<select name="manual_priority[]" class="form-control picture_priority">';
                                                                                    echo '<option></option>';
                                                                                        foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                            echo '<option '.(checkVar($data['prioritization']) && $data['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                        }
                                                                                    echo '</select>';

                                                                                    echo '<div class="picture_priority_specify '.($data['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                    echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                    echo '<input type="text" class="form-control" name="manual_priority_specify[]" value="'.$data['prioritization_specify'].'">';
                                                                                    echo '</div>';

                                                                                echo '</td>';

                                                                                echo '<td><textarea name="manual_recommendation[]" rows="2" class="form-control notes border-0">'.$data['recommendation'].'</textarea></td>';

                                                                                echo '<td><textarea name="manual_contractor[]" rows="2" class="form-control notes border-0">'.$data['contractor'].'</textarea></td>';

                                                                                echo '<td><textarea name="manual_description[]" rows="2" class="form-control notes border-0">'.$data['description'].'</textarea></td>';

                                                                                echo '<td><textarea name="manual_documents[]" rows="2" class="form-control notes border-0">'.$data['submitted_documents'].'</textarea></td>';

                                                                                echo '<td>';
                                                                                echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                                                echo '</td>';

                                                                                echo '</tr>';
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr class="default-row d-none">
                                                                                <input type="hidden" name="manual_id[]" value="0">
                                                                                <input type="hidden" name="delete_id[]" value="0">
                                                                                <input type="hidden" name="delete_category[]" value="equipment-manuals">
                                                                                <td>
                                                                                    <select name="manual_findings[]" class="form-control picture_findings">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select name="manual_priority[]" class="form-control picture_priority">
                                                                                        <option></option>
                                                                                        <?php 
                                                                                        foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                            echo '<option value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    <div class="picture_priority_specify d-none">
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
                                                                        </tfoot>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info" id="add-row-sec4"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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

                                <?php if(checkPermission('pre-operation-audit-TSA-comments')) { ?>
                                <!-- comment box -->
                                    <?php 
                                    $sql = $pdo->prepare("SELECT * FROM comments WHERE module = 'pre-operation-audit-TSA' AND module_type = 'approval' AND module_id = :id AND temp_del = 0 ORDER BY comment_date DESC");
                                    $sql->bindParam(":id", $id);
                                    $sql->execute();
                                    if($_data['status'] == 1 || $_data['status'] == 3) {
                                    ?>
                                    <div class="row mt-4">
                                        <div class="col-lg-6">

                                            <div class="card direct-chat direct-chat-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title"><?php echo renderLang($lang_comments); ?></h3>
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
                                                            echo 'No Comment Yet.';
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <?php if(checkPermission('pre-operation-audit-TSA-comment-add')) { ?>
                                                        <div class="input-group">
                                                            <input type="text" name="comment" placeholder="" class="form-control">
                                                            <span class="input-group-append">
                                                                <button type="button" id="add-comment" class="btn btn-primary">Send</button>
                                                            </span>
                                                        </div>
                                                        <p id="err_msg" class="error-message text-danger mt-1"></p>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php 
                                    }
                                } 
                                ?>

                                <?php if(checkPermission('pre-operation-audit-TSA-approve')) { ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                    <?php if($_data['status'] == 1) { ?>
                                        <button class="btn btn-success approve" data-val="3"><i class="fa fa-check mr-1"></i><?php echo renderLang($lang_approve); ?></button>
                                        <button class="btn btn-danger approve" data-val="2"><i class="fa fa-times mr-1"></i><?php echo renderLang($lang_return); ?></button>
                                    <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if(checkPermission('pre-operation-audit-TSA-edit') && $_data['status'] != 3 && $_data['status'] != 1) { ?>
                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <div class="icheck-success">
                                            <input type="checkbox" id="save-status" name="save_status" value="<?php echo $_data['status'] == 2 ? 1 : $_data['status']; ?>" <?php echo $_data['status'] == 2 ? 'checked' : ''; ?>>
                                            <label for="save-status"><?php echo $_data['status'] == 2 ? renderLang($lang_for_submission) : renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            
                            </div>
                            <div class="card-footer text-right">
                                <a href="/pre-operation-audit-tsa-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <?php if(checkPermission('pre-operation-audit-TSA-edit') && $_data['status'] != 3 && $_data['status'] != 1) { ?>
                                <button class="btn btn-success" id="submit-btn"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save_as_draft); ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    
                    </form>

                </div>

			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

        <!-- confirm delete -->
        <?php if(checkPermission('pre-operation-audit-TSA-delete')){ ?>
        <div class="modal fade" id="modal-confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title"><?php echo renderLang($modal_delete_confirmation); ?></h4>
                    </div>
                    <form action="/delete-tsa-pre-operation-audit" method="post" class="ajax-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modal-body">
                            <p><?php echo renderLang($pre_operation_audit_tsa_modal_delete_msg1); ?></p>
                            <p><?php echo renderLang($pre_operation_audit_tsa_modal_delete_msg2); ?></p>
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
    <script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script>
		$(function(){

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
                            window.location.href = '/pre-operation-audit-tsa-list';
                        } else {
                            $('.modal-error')
                                .html(response_arr[1]) // val is error message
                                .show();
                        }
                    }
                });
            });

            // toggle table rows
            $('body').on('click', '[data-toggle="toggle"]', function(){
                $(this).closest('tbody').next('.hide').toggle();
            });

            $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

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
            
            // add comment
            $('#add-comment').on('click', function(e){
                e.preventDefault();

                var comment = $('input[name="comment"]').val();
                var module = 'pre-operation-audit-TSA';
                var module_type = "approval";
                var module_id = <?php echo $id; ?>;

                if(comment.trim() !== '') {

                    $.post('/add-comment', {
                        comment:comment, module:module, 
                        module_type:module_type, module_id:module_id
                    }, function(data){
                        window.location.reload();
                    });

                }

            });

            // approve status
            $('body').on('click', '.approve', function(e){
                e.preventDefault();

                var status = $(this).data('val');
                var audit_id = <?php echo $id; ?>;
                var audit_type = 'TSA';

                $.post('/pre-operation-audit-approve', {
                    status:status, audit_id:audit_id, audit_type:audit_type
                }, function(data){
                    if(data == 'success') {

                        window.location.reload();

                    } else {
                        switch(data) {

                            case 'no-session':
                                window.location.href = "/";
                            break;

                            case 'error':
                                window.location.href= "/pre-operation-audit-checklist/"+audit_id;
                            break;
                        }
                    }
                });

            });

            // save status
            $('#save-status').on('change', function(e){
                
                var status = $(this).val();
                if(status == '1') {
                    $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
                    $(this).val('0');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                } else {
                    $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_for_submission); ?>');
                    $(this).val('1');
                    $(this).closest('div').find('label').html('<?php echo renderLang($lang_for_submission); ?>');
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

                var location = $(this).closest('.location-row').find('.default-location').find('.card').html();
                
                $(this).closest('.location-row').find('.location').append('<input type="hidden" name="location_id[]" value="0"><div class="card">'+location+'</div>');

            });

            // section 5 add row
            $('body').on('click', '#add-row-sec4', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('tfoot').find('tr:nth-child(1)').html();

                $(this).closest('.table-responsive').find('tbody').append('<tr>'+fields+'</tr>');

            });

            // add row pictures
            $('body').on('click', '.add-row-pictures', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('.table-responsive').find('tfoot').find('tr:nth-child(1)').html();
                $(this).closest('.table-responsive').find('tbody').append(fields);

			});
			
			// add row conformance
			$('body').on('click', '.add-row-conformance', function(e){
				e.preventDefault();

				var field = '<tr>'+$(this).closest('table').find('tfoot').find('tr:nth-child(1)').html();
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

                var fields = $(this).closest('.table-responsive').find('tfoot').find('tr:nth-child(1)').html();

                $(this).closest('.table-responsive').find('tfoot').append('<tr>'+fields+'</tr>');
                

                var num = $(this).closest('.card').prev().val();

                $(this).closest('.card').find('.site_loc_category').each(function(){

                    $(this).val(num);

                });

            });

            // remove row
                $('body').on('click', '.remove-row', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    if($(this).closest('tbody').children('tr').length != 1) {
                        if(confirm("Are you sure to permanently delete this row?")) {
                            var id = $(this).closest('tr').find('[name="delete_id[]"]').val();
                            var category = $(this).closest('tr').find('[name="delete_category[]"]').val();
                            
                            $.post("/delete-pre-operation-audit-tsa-row", {
                                id:id,
                                category:category
                            }, function(data) {
                                switch(data) {
                                    case "success":
                                        $this.closest('tr').remove();
                                        break;
                                    case "no-session":
                                        window.location.href = "/";
                                        break;
                                }
                            });
                        }

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