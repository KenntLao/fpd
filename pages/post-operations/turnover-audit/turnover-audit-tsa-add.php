<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('turnover-audits')) {

    $page = 'turnover-audit';
    
    
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
                    renderError('sys_pre_operation_audit_tsa_add_err');
                    ?>

                    <form action="/submit-add-tsa-operation-audit" method="post" enctype="multipart/form-data">

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
                                            <input type="text" class="form-control date" name="date_of_audit" id="date_of_audit">
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
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-inventory-sec7"" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_1); ?></button>
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
                                                                    <textarea name="summary" rows="2" class="form-control notes"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="w35"><?php echo renderLang($operation_audit_tsa_items); ?></th>
                                                                                <th><?php echo renderLang($operation_audit_tsa_description); ?></th>
                                                                                <th><?php echo renderLang($turnover_audit_tsa_recommendation); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php 
                                                                        foreach($operation_audit_section_1 as $key => $summary_item) {
                                                                            echo '<tbody>';
                                                                                echo '<tr>';
                                                                                    echo '<td colspan="3"><label>'.renderLang($summary_item).'</label></td>';
                                                                                echo '</tr>';
                                                                                
                                                                                    echo '<tr class="default-row">';
                                                                                        echo '<td><p class="numbering"></p></td>';
                                                                                        echo '<td>';
                                                                                            echo '<textarea name="description[]" rows="2" class="form-control notes border-0"></textarea>';
                                                                                        echo '</td>';
                                                                                        echo '<td>';
                                                                                            echo '<textarea name="recommendation[]" rows="2" class="form-control notes border-0"></textarea>';
                                                                                        echo '</td>';
                                                                                    echo '</tr>';

                                                                                echo '<tr>';
                                                                                    echo '<td colspan="3" class="text-right">';
                                                                                        echo '<button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i>'.renderLang($lang_add_row).'</button>';
                                                                                    echo '</td>';
                                                                                echo '</tr>';

                                                                            echo '</tbody>';
                                                                        }
                                                                        ?>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <input type="file" name="building_picture" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <input type="file" name="building_picture" class="form-control">
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
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-building" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_2); ?></button>
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
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-building-status" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_3); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-building-status">

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
                                                                            <tr>
                                                                                <th colspan="3">Non-conforming items during the year 2018</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="default-row">
                                                                                <td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="as_built_remarks[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right">
                                                                        <button class="btn btn-info add-row-sec3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

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
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-permits" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_4); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-permits">

                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h3><?php echo renderLang($operation_audit_tsa_safety_inspection_checklist); ?></h3>
                                                </div>
                                                <div class="card-body">

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

                                                                        echo '<tr>';
                                                                        echo '<td></td>';
                                                                        echo '<td>'.renderLang($list).'</td>';
                                                                        echo '<td></td>';
                                                                        echo '<td></td>';
                                                                        echo '<td><input type="text" class="form-control border-0" name=""></td>';
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

                                <!-- SECTION 5 INVENTORY OF AS-BUILT PLANS AND EQUIPMENT MANUALS -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-inventory" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($pre_operation_audit_tsa_section_5); ?></button>
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
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_description); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_sheets_available); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_remarks); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="default-row">
                                                                                <td><textarea name="as_built_description[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="sheets[]" rows="2" class="form-control notes border-0"></textarea></td>
                                                                                <td><textarea name="as_built_remarks[]" rows="2" class="form-control notes border-0"></textarea></td>
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
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_contractor); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_description); ?></th>
                                                                                <th><?php echo renderLang($pre_operation_audit_tsa_submitted_documents); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="default-row">
                                                                                <td><input type="text" name="manual_contractor[]" class="form-control border-0"></td>
                                                                                <td><input type="text" name="manual_description[]" class="form-control border-0"></td>
                                                                                <td><input type="text" name="manual_documents[]" class="form-control border-0"></td>
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
                $(this).closest('tbody').find('.default-row').after(field);

                // row numbers
                var numbers = 1;
                $('.numbering').each(function(){
                    $(this).html(numbers);
                    numbers++;
                });

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
