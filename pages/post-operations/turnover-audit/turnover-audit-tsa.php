<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('turnover-audits')) {

    $page = 'turnover-audit';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa WHERE id = :id LIMIT 1");
    $sql->bindParam(":id", $id);
    $sql->execute();
    if($sql->rowCount()) {

        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $tsa_id = $_data['id'];
        $prospect_id = $_data['prospect_id'];
        $property_id = $_data['property_id'];

    } else {

      $_SESSION['sys_post_operations_audit_tsa_err'] = renderLang($pre_operation_audit_tsa_not_found);
        header('location: /turnover-audit-tsa-list');
        exit();  

    }

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($turnover_audit); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($turnover_audit_add); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <?php
                    renderError('sys_post_operation_audit_tsa_add_err');
                    ?>

                    <form action="/submit-add-tsa-turnover-audit" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pre_operation_audit_tsa).formatDate(''); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id"><?php echo renderLang($pre_operation_audit_project); ?></label>
                                                <?php 
                                                if ($_data['prospect_id'] == 0) {

                                                    $sql = $pdo->prepare("SELECT * FROM properties WHERE property_id = :property_id AND temp_del = 0");
                                                    $sql->bindParam(":property_id",$_data['prospect_id']);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                        echo '<input type="text" class="form-control name-readonly" value="['.$data['property_id'].'] '.$data['property_name'].'" readonly>';

                                                } else {

                                                    $sql = $pdo->prepare("SELECT id, reference_number, project_name FROM prospecting WHERE id = :prospect_id AND temp_del = 0 AND status = 3 AND prospecting_category = 0");
                                                    $sql->bindParam(":prospect_id",$_data['prospect_id']);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                        echo '<input type="text" class="form-control name-readonly" value="['.$data['reference_number'].'] '.$data['project_name'].'" readonly>';

                                                }
                                                ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_of_audit"><?php echo renderLang($pre_operation_audit_date_of_audit); ?></label>
                                            <input type="text" class="form-control date" name="date_of_audit" id="date_of_audit" value="<?php echo checkVar($_data['date_of_audit']) ? $_data['date_of_audit'] : ''; ?>">
                                        </div>
                                    </div>             

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_presented"><?php echo renderLang($pre_operation_audit_tsa_date_presented_to_board); ?></label>
                                            <input type="text" name="date_presented" id="date_presented" class="form-control date" value="<?php echo $_data['date_presented'] ?>">
                                        </div>
                                    </div>

                                </div>

                                <!-- SECTION 1 SUMMARY -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-inventory-sec7"" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_1).' - '.renderLang($pre_operation_audit_tsa_summary); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-inventory-sec7">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-header text-center">
                                                        <h3><?php echo renderLang($pre_operation_audit_tsa_summary); ?></h3>
                                                    </div>
                                                    <div class="card-body pad">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea name="summary" rows="2" class="form-control notes"><?php echo $_data['summary']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover" id="prioritization">
                                                                        <thead class="text-center bg-dark">
                                                                            <tr>
                                                                                <th class="w35"><?php echo renderLang($operation_audit_tsa_prioritization); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_findings); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_recommendation); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php 
                                                                        $num = 1;
                                                                        foreach ($tsa_audit_prioritization_arr as $key => $prioritization) {

                                                                            if (renderlang($prioritization) != 'Others') {

                                                                                echo '<tbody>';
                                                                                    echo '<tr>';
                                                                                        echo '<td colspan="3" class="bg-gray" data-toggle="toggle">';
                                                                                            echo '<label>'.$num.'. '.renderlang($prioritization).'</label>';
                                                                                            echo '<input type="hidden" name="summary_category[]" value="'.$key.'">';
                                                                                        echo '</td>';
                                                                                    echo '</tr>';
                                                                                echo '</tbody>';

                                                                                echo '<tbody class="hide">';

                                                                                    $pre_ops_id = getField('id','pre_operation_audit_tsa','prospect_id = "'.$prospect_id.'"');
                                                                                    $sql = $pdo->prepare(" SELECT * FROM pre_operation_audit_tsa_system WHERE tsa_id = :tsa_id");
                                                                                    $sql->bindParam(":tsa_id", $pre_ops_id);
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

                                                                                    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_system WHERE tsa_id = :tsa_id");
                                                                                    $sql->bindParam(":tsa_id", $tsa_id);
                                                                                    $sql->execute();
                                                                                    while($data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                        //
                                                                                            $sql2 = $pdo->prepare("SELECT system_id, recommendation, findings, prioritization_specify, prioritization FROM operations_audit_tsa_system_locations  WHERE system_id = :system_id AND prioritization = :prioritization");
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
                                                                                            $sql2 = $pdo->prepare("SELECT system_id, recommendations, findings, prioritization_specify, prioritization FROM operations_audit_tsa_system_pictures  WHERE system_id = :system_id AND prioritization = :prioritization");
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
                                                                                        $sql2 = $pdo->prepare("SELECT recommendation, findings, prioritization_specify, prioritization FROM operations_audit_tsa_permit_licences WHERE prioritization = :prioritization AND tsa_id = :ops_tsa_id");
                                                                                        $sql2->bindParam(":ops_tsa_id", $ops_tsa_id);
                                                                                        $sql2->bindParam(":prioritization", $key);
                                                                                        $sql2->execute();

                                                                                        while ($data2 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                            if (!empty($data2['findings'])) {

                                                                                                echo '<tr>';

                                                                                                    echo '<td>';
                                                                                                    echo '<p class="w250">PERMIT AND LICENSES</p>';
                                                                                                    echo '</td>';
                                                                                                    echo '<td><p>'.(checkVar($data2['findings']) ? renderLang($tsa_audit_fingings_arr[$data2['findings']]['findings']) : '').'</p></td>';
                                                                                                    echo '<td><p>'.$data2['recommendation'].'</p></td>';

                                                                                                echo '</tr>';

                                                                                            }
                                                                                        }

                                                                                    // AS BUILT PLAN
                                                                                        $sql2 = $pdo->prepare("SELECT recommendation, findings, prioritization_specify, prioritization FROM operations_audit_tsa_as_built_plans WHERE prioritization = :prioritization AND tsa_id = :tsa_id");
                                                                                        $sql2->bindParam(":tsa_id", $tsa_id);
                                                                                        $sql2->bindParam(":prioritization", $key);
                                                                                        $sql2->execute();

                                                                                        while ($data2 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                            if (!empty($data2['findings'])) {

                                                                                                echo '<tr>';

                                                                                                    echo '<td>';
                                                                                                    echo '<p class="w250">AS-BUILT PLANS</p>';
                                                                                                    echo '</td>';
                                                                                                    echo '<td><p>'.(checkVar($data2['findings']) ? renderLang($tsa_audit_fingings_arr[$data2['findings']]['findings']) : '').'</p></td>';
                                                                                                    echo '<td><p>'.$data2['recommendation'].'</p></td>';

                                                                                                echo '</tr>';

                                                                                            }
                                                                                        }

                                                                                    // EQUIPMENT MANUALS
                                                                                        $sql2 = $pdo->prepare("SELECT recommendation, findings, prioritization_specify, prioritization FROM operations_audit_tsa_equipment_manuals WHERE prioritization = :prioritization AND tsa_id = :tsa_id");
                                                                                        $sql2->bindParam(":tsa_id", $tsa_id);
                                                                                        $sql2->bindParam(":prioritization", $key);
                                                                                        $sql2->execute();

                                                                                        while ($data2 = $sql2->fetch(PDO::FETCH_ASSOC)) {

                                                                                            if (!empty($data2['findings'])) {

                                                                                                echo '<tr>';

                                                                                                    echo '<td>';
                                                                                                    echo '<p class="w250">EQUIPMENT MANUALS</p>';
                                                                                                    echo '</td>';
                                                                                                    echo '<td><p>'.(checkVar($data2['findings']) ? renderLang($tsa_audit_fingings_arr[$data2['findings']]['findings']) : '').'</p></td>';
                                                                                                    echo '<td><p>'.$data2['recommendation'].'</p></td>';

                                                                                                echo '</tr>';

                                                                                            }
                                                                                        }

                                                                                    $num++;
                                                                                echo '</tbody>';
                                                                            }
                                                                        } 
                                                                        ?>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($turnover_audit_tsa_pre_audit_meeting); ?></label>
                                                                <input type="file" name="pre_audit_meeting[]" class="form-control" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for=""><?php echo renderLang($turnover_audit_tsa_post_audit_meeting); ?></label>
                                                                <input type="file" name="post_audit_meeting[]" class="form-control" multiple>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 2 STAFFING -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-staffing" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_2).' - '.renderLang($turnover_audit_tsa_staffing); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-staffing">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($turnover_audit_tsa_staffing); ?></h3>
                                                </div>
                                                <div class="card-body pad">
                                                    
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <p>
                                                            <?php
                                                            switch($_SESSION['sys_language']) {
                                                                case 0: // english
                                                                    echo 'The present manpower deployed in the building totaled';
                                                                    echo '<input type="text" class="text-center border-top-0 border-right-0 border-left-0 mr-1 ml-1 staff-total" name="">';
                                                                    echo 'personnel, to wit:';
                                                                    break;
                                                                case 1: // japanese
                                                                    echo '建物に配置されている現在の労働力は、合計';
                                                                    echo '<input type="text" class="text-center border-top-0 border-right-0 border-left-0 mr-1 ml-1 staff-total" name="">';
                                                                    echo '人';
                                                                    break;
                                                            }
                                                            ?>
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-condensed">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_total_present_manpower); ?></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="default-row">
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0 staff-position" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="number" class="form-control border-0 staff-number" name="">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="2" class="text-right border-0">
                                                                                <button class="btn btn-info btn-sm add-row-table"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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
                                </div>

                                <!-- SECTION 3 DESCRIPTION OF BUILDING -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-building" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_3).' - '.renderLang($pre_operation_audit_tas_desc_building); ?></button>
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
                                                                <textarea name="building_description" rows="10" class="form-control notes"><?php echo $_data['building_description']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="text-center" id="building_picture"><br>
                                                            <?php if (checkVar($_data['building_picture'])) {?>
                                                            <img src="/assets/uploads/operations-audit/<?php echo $_data['building_picture']; ?>" class="img-fluid mb-2 mr-2 img-thumbnail img-responsive" alt="white sample"/>
                                                            <?php } else {  ?>
                                                            <img src="/assets/uploads/pre-operation-audit/<?php echo getField('building_picture','pre_operation_audit_tsa','prospect_id = "'.$_data['prospect_id'].'"'); ?>" class="img-fluid mb-2 mr-2 img-thumbnail img-responsive" alt="white sample"/>
                                                            <?php } ?>
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

                                <!-- SECTION 4 UPDATE OF PREVIOUS YEARS TECHNICAL AND SAFETY AUDIT -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-years-updates" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_4).' - '.renderLang($operation_audit_tsa_update_of_previous_years_technical_and_safety_audit); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-years-updates">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($operation_audit_tsa_update_of_previous_years_technical_and_safety_audit); ?></h3>
                                                </div>
                                                <div class="card-body pad">

                                                    <div class="row">

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">A. <?php echo renderLang($operation_audit_tsa_compliance_and_non_conformances_item); ?></label>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo renderLang($operation_audit_tsa_non_conformance); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_status); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_remarks); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="default-tbody d-none">
                                                                            <tr>
                                                                                <th colspan="3">
                                                                                    <?php 
                                                                                    switch($_SESSION['sys_language']) {
                                                                                        case 0: // english
                                                                                            echo 'Non-Conformances Status as per Year';
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo 'Audit Report';
                                                                                            break;
                                                                                        case 1: // japanese
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo '年の監査による不適合ステータス';
                                                                                            break;
                                                                                    }
                                                                                    ?>
                                                                                </th>
                                                                            </tr>
                                                                            <tr class="default-row">
                                                                                <td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="as_built_remarks[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3" class="text-right p-1 border-0">
                                                                                    <button class="btn btn-info btn-sm add-row-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody>
                                                                            <tr>
                                                                                <th colspan="3">
                                                                                    <?php 
                                                                                    switch($_SESSION['sys_language']) {
                                                                                        case 0: // english
                                                                                            echo 'Non-Conformances Status as per Y';
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo 'Audit';
                                                                                            break;
                                                                                        case 1: // japanese
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo '年の監査による不適合ステータス';
                                                                                            break;
                                                                                    }
                                                                                    ?>
                                                                                </th>
                                                                            </tr>
                                                                            <tr class="default-row">
                                                                                <td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="as_built_remarks[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3" class="text-right p-1 border-0">
                                                                                    <button class="btn btn-info btn-sm add-row-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td class="border-0">
                                                                                    <button class="btn btn-info btn-sm  add-non-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($turnover_audit_tsa_add_non_conformance); ?></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">B. <?php echo renderLang($turnover_audit_tsa_no_further_action_required); ?></label>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo renderLang($operation_audit_tsa_non_conformance); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_remarks); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="default-tbody">
                                                                            <tr>
                                                                                <th colspan="2">
                                                                                    <?php 
                                                                                    switch($_SESSION['sys_language']) {
                                                                                        case 0: // english
                                                                                            echo 'Non-Conformances Status as per Year';
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo 'Audit';
                                                                                            break;
                                                                                        case 1: // japanese
                                                                                            echo '<input type="text" class="ml-1 mr-1 text-center border-top-0 border-left-0 border-right-0">';
                                                                                            echo '年監査報告書による不適合';
                                                                                            break;
                                                                                    }
                                                                                    ?>
                                                                                </th>
                                                                            </tr>
                                                                            <tr class="default-row">
                                                                                <td>
                                                                                    <textarea name="" class="form-control border-0 notes"></textarea>
                                                                                </td>
                                                                                <td>
                                                                                    <textarea name="" class="form-control border-0 notes"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" class="text-right p-1 border-0">
                                                                                    <button class="btn btn-info btn-sm add-row-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td class="border-0">
                                                                                    <button class="btn btn-info btn-sm  add-non-conformance"><i class="fa fa-plus mr-1"></i><?php echo renderLang($turnover_audit_tsa_add_non_conformance); ?></button>
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
                                    </div>
                                </div>

                                <!-- SECTION 5 BUILDING STATUS AND EVALUATION -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-building-status" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_5).' - '.renderLang($pre_operation_audit_tsa_building_status_and_evaluation); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-building-status">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($pre_operation_audit_tsa_building_status_and_evaluation); ?></h3>
                                                </div>
                                                <div class="card-body pad">

                                                    <?php
                                                    $num = 1;
                                                    foreach($tsa_section_3_arr as $section_key => $system) { 
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">
                                                                <button class="btn pms-red text-white w300 text-left" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $num; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $num.'. '.renderLang($system[0]); ?></button>
                                                            </p>
                                                            <div class="collapse" id="tab-<?php echo $num; ?>">

                                                            <div class="row">

                                                                <input type="hidden" name="location_category[]" value="<?php echo $section_key; ?>">

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

                                                                                    <div class="col-lg-6 col-md-12">

                                                                                        <div class="form-group">
                                                                                            <label for="location_unit"><?php echo renderLang($pre_operation_audit_tsa_unit); ?></label>
                                                                                            <input type="text" class="form-control" name="location_unit[]" id="location_unit">
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label><?php echo renderLang($pre_operation_audit_remarks); ?></label>
                                                                                            <textarea name="location_remarks[]" rows="2" class="form-control notes"></textarea>
                                                                                        </div>

                                                                                    </div>

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
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="text-right">
                                                                        <button href="" class="btn btn-info btn-sm add-row-location"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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
                                                                                        <th><?php echo renderLang($pre_operation_audit_remarks); ?></th>
                                                                                        <th><?php echo renderlang($pre_operation_audit_tsa_recommendations); ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr class="default-row">
                                                                                        <td><input type="file" name="pictures[]" class="form-control border-0"></td>
                                                                                        <td><textarea name="picture_remarks[]" class="form-control notes border-0"></textarea></td>
                                                                                        <td><textarea name="picture_recommendations[]" class="form-control notes border-0"></textarea></td>
                                                                                        <input type="hidden" name="picture_code[]" value="<?php echo $section_key; ?>">
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="text-right">
                                                                                <button class="btn btn-info btn-sm add-row-pictures"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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

                                <!-- SECTION 6 SAFETY INSPECTION CHECKLIST -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-safety" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_6).' - '.renderLang($operation_audit_tsa_safety_inspection_checklist); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-safety">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($operation_audit_tsa_safety_inspection_checklist); ?></h3>
                                                </div>
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for=""><?php echo renderLang($turnover_audit_tsa_legend); ?></label>
                                                            <ul>
                                                                <li>S - <?php echo renderLang($turnover_audit_tsa_satisfactory); ?></li>
                                                                <li>NS - <?php echo renderLang($turnover_audit_tsa_not_satisfactory); ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>


                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2"><?php echo renderLang($pre_operation_audit_tsa_particulars); ?></th>
                                                                    <th rowspan="2"><?php echo renderLang($operation_audit_tsa_standards); ?></th>
                                                                    <th colspan="2"><?php echo renderLang($pre_operation_audit_tsa_status); ?></th>
                                                                    <th rowspan="2"><?php echo renderLang($operation_audit_tsa_remarks); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w50">S</th>
                                                                    <th class="w50">NS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($operation_safety_inspection_checklist_arr as $key => $value) { 

                                                                    echo '<tr>';
                                                                    echo '<th class="w35" colspan="5">'.$key.' '.renderLang($value['title']).'</th>';
                                                                    echo '</tr>';

                                                                         foreach ($value['list'] as $list_key => $list) { 

                                                                            $safety_key = $key.$list_key;

                                                                            $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_safety_inspection_checklist WHERE tsa_id = :tsa_id AND standards = :safety_key");
                                                                            $sql->bindParam(":tsa_id",$id);
                                                                            $sql->bindParam(":safety_key",$safety_key);
                                                                            $sql->execute();
                                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                                                                            echo '<tr>';
                                                                                echo '<td><input type="hidden" name="sic_particulars[]" value="'.$key.'"></td>';
                                                                                echo '<td>'.renderLang($list).'<input type="hidden" name="sic_standards[]" value="'.$key.$list_key.'"></td>';
                                                                                echo '<td class="check" data-val="s">';
                                                                                    echo '<button class="btn btn-success '.($data['status'] == 's' ? '' : 'd-none').'"><i class="fa fa-check"></i></button>';
                                                                                echo '</td>';
                                                                                echo '<td class="check" data-val="ns">';
                                                                                    echo '<button class="btn btn-danger  '.($data['status'] == 'ns' ? '' : 'd-none').'"><i class="fa fa-check"></i></button>';
                                                                                echo '</td>';
                                                                                echo '<td class="d-none"><input type="hidden" name="sic_check_status[]" class="check_value" value="'.$data['status'].'"></td>';
                                                                                echo '<td><input type="text" class="form-control border-0" name="sic_remarks[]" value="'.$data['remarks'].'"></td>';
                                                                                echo '<td class="d-none"><input type="text" name="sic_id[]" value="'.$data['id'].'"></td>';
                                                                            echo '</tr>';

                                                                        } 
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 7 AUDIT OF PERMITS AND LICENSES -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-permits" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_7).' - '.renderLang($pre_operation_audit_of_permits); ?></button>
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

                                                                    $sql2 = $pdo->prepare("SELECT * FROM operations_audit_tsa_permit_licences WHERE particulars = :particulars AND tsa_id = :tsa_id");
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

                                <!-- SECTION 8 INVENTORY OF AS-BUILT PLANS AND EQUIPMENT MANUALS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-inventory" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_8).' - '.renderLang($pre_operation_audit_tsa_inventory); ?></button>
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
                                                                            <?php
                                                                            $sql = $pdo->prepare("SELECT abp.*, tsa.property_id FROM operations_audit_tsa_as_built_plans abp LEFT JOIN operations_audit_tsa tsa ON (abp.tsa_id = tsa.id) WHERE tsa.property_id = :property_id AND abp.tsa_id = :tsa_id");
                                                                            $sql->bindParam(":property_id",$property_id);
                                                                            $sql->bindParam(":tsa_id",$id);
                                                                            $sql->execute();
                                                                            if ($sql->rowCount()) {
                                                                                while($_data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                    echo '<tr>';

                                                                                        echo '<input type="hidden" name="delete_id[]" value="'.$_data2['id'].'">';
                                                                                        echo '<input type="hidden" name="delete_category[]" value="as-built-plans">';

                                                                                        echo '<td>';
                                                                                            echo '<select name="as_built_findings[]" class="form-control picture_findings">';
                                                                                            echo '<option></option>';
                                                                                                foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                    echo '<option '.($_data2['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                                }
                                                                                            echo '</select>';
                                                                                        echo '</td>';

                                                                                        echo '<td>';
                                                                                            echo '<select name="as_built_priority[]" class="form-control picture_priority">';
                                                                                            echo '<option></option>';
                                                                                                foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                    echo '<option '.(checkVar($_data2['prioritization']) && $_data2['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                                }
                                                                                            echo '</select>';

                                                                                            echo '<div class="picture_priority_specify '.($_data2['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                            echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                            echo '<input type="text" class="form-control" name="as_built_priority_specify[]" value="'.$_data2['prioritization_specify'].'">';
                                                                                            echo '</div>';

                                                                                        echo '</td>';

                                                                                        echo '<td><textarea name="as_built_recommendation[]" class="form-control notes border-0">'.$_data2['recommendation'].'</textarea></td>';

                                                                                        echo '<td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0">'.$_data2['description'].'</textarea></td>';
                                                                                        echo '<td><textarea name="sheets[]" rows="2" class="form-control notes border-0">'.$_data2['sheets'].'</textarea></td>';
                                                                                        echo '<td class="d-none"><input type="text" name="as_built_id[]" value="'.$_data2['id'].'"></td>';

                                                                                        echo '<td>';
                                                                                        echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                                                        echo '</td>';

                                                                                    echo '</tr>';
                                                                                } 
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr class="default-row d-none">
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
                                                                                <td class="d-none"><input type="text" name="as_built_id[]" value="0"></td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row-section-8"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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
                                                                            $sql = $pdo->prepare("SELECT em.*, tsa.property_id FROM operations_audit_tsa_equipment_manuals em LEFT JOIN operations_audit_tsa tsa ON (em.tsa_id = tsa.id) WHERE tsa.property_id = :property_id AND em.tsa_id = :tsa_id");
                                                                            $sql->bindParam(":property_id",$property_id);
                                                                            $sql->bindParam(":tsa_id",$id);
                                                                            $sql->execute();
                                                                            while($_data2 = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                                echo '<tr>';

                                                                                    echo '<input type="hidden" name="delete_id[]" value="'.$_data2['id'].'">';
                                                                                    echo '<input type="hidden" name="delete_category[]" value="equipment-manuals">';
                                                                                    echo '<td class="d-none"><input type="text" name="manual_equip_id[]" value="'.$_data2['id'].'"></td>';

                                                                                    echo '<td>';
                                                                                        echo '<select name="manual_findings[]" class="form-control picture_findings">';
                                                                                        echo '<option></option>';
                                                                                            foreach($tsa_audit_fingings_arr as $key => $findings) {
                                                                                                echo '<option '.($_data2['findings'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($findings['findings']).'</option>';
                                                                                            }
                                                                                        echo '</select>';
                                                                                    echo '</td>';

                                                                                    echo '<td>';
                                                                                        echo '<select name="manual_priority[]" class="form-control picture_priority">';
                                                                                        echo '<option></option>';
                                                                                            foreach($tsa_audit_prioritization_arr as $key => $priority) {
                                                                                                echo '<option '.(checkVar($_data2['prioritization']) && $_data2['prioritization'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($priority).'</option>';
                                                                                            }
                                                                                        echo '</select>';

                                                                                        echo '<div class="picture_priority_specify '.($_data2['prioritization'] == 5 ? '' : 'd-none').'">';
                                                                                        echo '<label for="">'.renderLang($pre_operation_audit_specify).'</label>';
                                                                                        echo '<input type="text" class="form-control" name="manual_priority_specify[]" value="'.$_data2['prioritization_specify'].'">';
                                                                                        echo '</div>';

                                                                                    echo '</td>';

                                                                                    echo '<td><textarea name="manual_recommendation[]" rows="2" class="form-control notes border-0">'.$_data2['recommendation'].'</textarea></td>';

                                                                                    echo '<td><textarea name="manual_contractor[]" rows="2" class="form-control notes border-0">'.$_data2['contractor'].'</textarea></td>';

                                                                                    echo '<td><textarea name="manual_description[]" rows="2" class="form-control notes border-0">'.$_data2['description'].'</textarea></td>';

                                                                                    echo '<td><textarea name="manual_documents[]" rows="2" class="form-control notes border-0">'.$_data2['submitted_documents'].'</textarea></td>';

                                                                                    echo '<td>';
                                                                                    echo '<button class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button>';
                                                                                    echo '</td>';

                                                                                echo '</tr>';

                                                                            } 
                                                                             ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr class="default-row d-none">
                                                                                <input type="hidden" name="delete_id[]" value="0">
                                                                                <input type="hidden" name="delete_category[]" value="equipment-manuals">
                                                                                <td class="d-none"><input type="text" name="manual_equip_id[]" value="0"></td>
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
                                                                        <button class="btn btn-info add-row-section-8"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
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

                                <!-- SECTION 9 COMPARISON TEST OF DIFFERENT METERING INSTRUMENT -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <button class="btn w100pc pms-red text-white text-left text-uppercase" type="button"  data-toggle="collapse" data-target="#tab-comparison" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_9).' - '.renderLang($turnover_audit_tsa_comparison_test); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-comparison">

                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="text-center"><?php echo renderLang($turnover_audit_tsa_comparison_test); ?></h3>
                                                </div>
                                                <div class="card-body">
                                                    
                                                    <div class="row">
                                                    
                                                        <div class="col-12">
                                                            <label for="">A. <?php echo renderLang($turnover_audit_tsa_voltmeter); ?></label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead class="text-center">
                                                                        <tr>
                                                                            <th rowspan="2"><p><?php echo renderLang($turnover_audit_tsa_transfer_pump); ?></p></th>
                                                                            <th colspan="2"><?php echo renderLang($turnover_audit_tsa_pryce_center); ?></th>
                                                                            <th colspan="2"><?php echo renderLang($turnover_audit_tsa_fpd_asia_calibrated); ?></th>
                                                                            <th colspan="2"><?php echo renderLang($turnover_audit_tsa_evaluation); ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_range_volts); ?></th>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_reading_volts); ?></th>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_range_volts); ?></th>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_reading_volts); ?></th>
                                                                            <th>&#37; <?php echo renderLang($turnover_audit_tsa_error); ?></th>
                                                                            <th><?php echo renderLang($turnover_audit_tsa_remarks); ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="default-row">
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                            <td class="p-0">
                                                                                <input type="text" class="form-control border-0" name="">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td class="text-right border-0" colspan="7">
                                                                                <button class="btn btn-sm btn-info add-row-table"><i class="fa fa-plus mr-1"></i><?php echo renderlang($lang_add_row); ?></button>
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
                                </div>
                            
                            </div>
                            <div class="card-footer text-right">
                                <a href="/turnover-audit-tsa-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

			$('.duallistbox').bootstrapDualListbox();

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });
            
            // add row location
            var num = 1;
            $('body').on('click', '.add-row-location', function(e){
                e.preventDefault();

                num++;

                var location = $(this).closest('.location-row').find('.card').html();
                
                $(this).closest('.location-row').find('.location').append('<div class="card">'+location+'</div>');

            });

            // section 1 summary add row
            $('body').on('click', '.add-row', function(e){
                e.preventDefault();

                var field = '<tr>'+$(this).closest('tbody').find('.default-row').html()+'</tr>';
                $(this).closest('tbody').find('tr:nth-last-child(2)').after(field);

                // row numbers
                var numbers = 1;
                $('.numbering').each(function(){
                    $(this).html(numbers);
                    numbers++;
                });

            });

            // add row conformances
            $('body').on('click', '.add-row-conformance', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('tbody').find('.default-row').html()+'</tr>';
                $(this).closest('tbody').find('tr:nth-last-child(2)').after(fields);

            });

            // add non conformance
            $('body').on('click', '.add-non-conformance', function(e){
                e.preventDefault();

                var non_conformance = $(this).closest('table').find('.default-tbody').html();
                $(this).closest('table').find('tfoot').before('<tbody>'+non_conformance+'</tbody>');

            });

            // row numbers
            var numbers = 1;
            $('.numbering').each(function(){
                $(this).html(numbers);
                numbers++;
            });
            
            // add row pictures
            $('body').on('click', '.add-row-pictures', function(e){
                e.preventDefault();

                var fields = '<tr>'+$(this).closest('.table-responsive').find('.default-row').html()+'</tr>';
                $(this).closest('.table-responsive').find('tbody').append(fields);

            });

            // status change
            $('body').on('click', '.status', function(){
                if($(this).find('button').hasClass('S')) {
                    $(this).closest('tr').find('.NS').addClass('d-none');
                    // $(this).closest('tr').find('.S').removeClass('d-none');
                } else {
                    $(this).closest('tr').find('.S').addClass('d-none');
                    // $(this).closest('tr').find('.NS').removeClass('d-none');
                }

                $(this).find('button').toggleClass('d-none');
                
            });

            // add row licences
            $('body').on('click', '.add-row-licences', function(e){
                e.preventDefault();

                var fields = $(this).closest('table').find('.default-row').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');

            });

            // add row
            $('body').on('click', '.add-row-table', function(e){
                e.preventDefault();

                var fields = $(this).closest('table').find('.default-row').html();
                $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');
            });

            // toggle table rows
            $('body').on('click', '[data-toggle="toggle"]', function(){
                $(this).closest('tbody').next('.hide').toggle();
            });

            // STAFFING auto compute
            // $('body').on('change', '.staff-number', function(){
            //     var total_staff = 0;
            //     $('.staff-number').each(function(){
            //         var 
            //     });

            // });

            // section 5 add row
            $('body').on('click', '.add-row-section-8', function(e){
                e.preventDefault();

                var fields = $(this).closest('.table-responsive').find('tfoot').find('tr:nth-child(1)').html();

                $(this).closest('.table-responsive').find('tfoot').append('<tr>'+fields+'</tr>');

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
