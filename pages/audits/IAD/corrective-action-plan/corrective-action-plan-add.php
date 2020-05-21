<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('operation-audit-IAD-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'operation-audit';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($audits_corrective_action_plan_add); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

    <style>
    .table-fixed-head thead th {
        position: sticky; 
        top: 0;
        background-color: #343a40;
    }
    .hide td {
        padding: 0;
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($audits_corrective_action_plan_add); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_corrective_action_plan_add_err');
                    ?>

                    <form action="/submit-add-corrective-action-plan" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($audits_corrective_action_plan_on_IAD_findings); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <!-- property -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_id"><?php echo renderLang($audits_project); ?></label>
                                            <select name="property_id" id="property_id" class="form-control select2">
                                                <?php 
                                                if($_SESSION['sys_account_mode'] == "user") { // users
                                                    $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
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
                                                    $sql = $pdo->prepare("SELECT * FROM properties WHERE id IN($properties) AND temp_del = 0");
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="reference_number"><?php echo renderLang($audits_iad_reference_no); ?></label>
                                            <input type="text" class="form-control" name="reference_number" id="reference_number">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-8">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center"><?php echo renderLang($audits_auditees); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($audits_name); ?></th>
                                                        <th><?php echo renderLang($audits_position); ?></th>
                                                        <th class="w35"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="auditee_name[]">
                                                        </td>
                                                        <td class="p-0">
                                                            <input type="text" class="form-control border-0" name="auditee_position[]">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-danger remove-auditee-row"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-right border-0">
                                                            <button class="btn btn-sm btn-info add-row-auditee"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo renderLang($audits_iad_summary_of_findings); ?></th>
                                                        <th><?php echo renderLang($audits_iad_counts); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th><?php echo renderLang($audits_iad_major); ?></th>
                                                        <td class="p-0"><input type="number" class="form-control border-0 major_count" name="major_count"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($audits_iad_minor); ?></th>
                                                        <td class="p-0"><input type="number" class="form-control border-0 minor_count" name="minor_count"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($audits_iad_note); ?></th>
                                                        <td class="p-0"><input type="number" class="form-control border-0 note_count" name="note_count"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                    <label for=""><?php echo renderLang($audits_iad_complied); ?></label>
                                        <ul class="list-unstyled">
                                            <?php 
                                            foreach($iad_corrective_plan_compliance_arr as $key => $compliance) {
                                                echo '<li class="mb-1 compliance-legend" data-key="'.$key.'" data-color="'.$iad_corrective_plan_compliance_color_arr[$key].'">';
                                                    echo '<button class="btn btn-'.$iad_corrective_plan_compliance_color_arr[$key].' btn-legend '.($key == 0 ? 'btn-selected' : '').'"></button>';
                                                    echo '<span class="ml-2 legend-label">'.renderLang($compliance).'</span>';
                                                echo '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- verification_od_previous_finding -->
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-verification" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($audits_corrective_action_plan_verification_on_previous_finding); ?></button>
                                        </p>
                                        <div class="collapse" id="tab-verification">

                                            <div class="card card-body">

                                                <div class="table-responsive" style="max-height: 500px;">
                                                    <table class="table table-bordered table-fixed-head">
                                                        <thead class="text-center bg-dark">
                                                            <tr>
                                                                <th><p class="w300"><?php echo renderLang($audits_iad_findings); ?></p></th>
                                                                <th><p class="w200"></p></th>
                                                                <th><p><?php echo renderLang($audits_iad_complied); ?></p></th>
                                                                <th><p class="w150"><?php echo renderLang($audits_iad_classification); ?></p></th>
                                                                <th><p class="w300"><?php echo renderLang($audits_iad_risks); ?></p></th>
                                                                <th><p class="w300"><?php echo renderLang($audits_iad_recommendations); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_root_cause); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_correction); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_corrective_action); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_timeline); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_responsible_party); ?></p></th>
                                                                <th><p class="w200"><?php echo renderLang($audits_iad_verification_date); ?></p></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <input type="hidden" name="category[]" value="verification">
                                                                <input type="hidden" name="sub_category[]" value="1">
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="findings_key[]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="findings[]"></textarea>
                                                                </td>
                                                                <!-- // complied -->
                                                                <td class="complied text-center">
                                                                    <button class="btn mt-3 d-none"></button>
                                                                    <input type="hidden" name="complied[]" value="">
                                                                </td>
                                                                <!-- // classifications -->
                                                                <td>
                                                                    <select class="form-control border-0 classification" name="classification[]">
                                                                    <option value=""></option>
                                                                        <?php 
                                                                        foreach($iad_corrective_plan_classifications_arr as $class_key => $classification) {
                                                                            echo '<option value="'.$class_key.'">'.renderLang($classification).'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <!-- // risks -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="risks[]"></textarea>
                                                                </td>
                                                                <!-- // recommendations -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="recommendations[]"></textarea>
                                                                </td>
                                                                <!-- // root cause -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="root_cause[]"></textarea>
                                                                </td>
                                                                <!-- // correction -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="correction[]"></textarea>
                                                                </td>
                                                                <!-- // corrective action -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="corrective_action[]"></textarea>
                                                                </td>
                                                                <!-- // timeline -->
                                                                <td>
                                                                    <input type="text" class="form-control date border-0 text-center" name="timeline[]">
                                                                </td>
                                                                <!-- // responsible party -->
                                                                <td>
                                                                    <textarea class="form-control notes border-0" name="responsible_party[]"></textarea>
                                                                </td>
                                                                <!-- // verification date -->
                                                                <td>
                                                                    <input type="text" class="form-control date border-0 text-center" name="verification_date[]">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="text-right mt-2">
                                                    <button class="btn btn-info btn-sm add-row-verification"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php foreach($audit_iad_findings_arr as $key => $findings) { ?>

                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-center">
                                                <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $key; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $key.'. '.renderLang($findings['title']); ?></button>
                                            </p>
                                            <div class="collapse" id="tab-<?php echo $key; ?>">

                                                <div class="card card-body">

                                                    <div class="table-responsive" style="max-height: 500px;">
                                                        <table class="table table-bordered table-fixed-head">
                                                            <thead class="text-center bg-dark">
                                                                <tr>
                                                                    <th><p class="w300"><?php echo renderLang($audits_iad_findings); ?></p></th>
                                                                    <th><p class="w200"></p></th>
                                                                    <th><p><?php echo renderLang($audits_iad_complied); ?></p></th>
                                                                    <th><p class="w150"><?php echo renderLang($audits_iad_classification); ?></p></th>
                                                                    <th><p class="w300"><?php echo renderLang($audits_iad_risks); ?></p></th>
                                                                    <th><p class="w300"><?php echo renderLang($audits_iad_recommendations); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_root_cause); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_correction); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_corrective_action); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_timeline); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_responsible_party); ?></p></th>
                                                                    <th><p class="w200"><?php echo renderLang($audits_iad_verification_date); ?></p></th>
                                                                </tr>
                                                            </thead>
                                                            <?php 
                                                            foreach($findings['content'] as $content_key => $content) {
                                                                echo '<tbody class="labels">';
                                                                    echo '<tr>';
                                                                        echo '<th class="bg-gray" colspan="12" data-toggle="toggle">'.$key.'.'.$content_key.' '.renderLang($content['title']).'</th>';
                                                                    echo '</tr>';
                                                                echo '</tbody>';
        
                                                                echo '<tbody class="hide">';
                                                                foreach($content['list'] as $list_key => $list) {
                                                                    echo '<tr>';
                                                                        
                                                                        echo '<input type="hidden" name="category[]" value="'.$key.'">';
                                                                        echo '<input type="hidden" name="sub_category[]" value="'.$content_key.'">';

                                                                        // findings
                                                                        echo '<td>';
                                                                            if($key == 'I') { // others
                                                                                echo '<textarea class="form-control notes border-0" name="findings_key[]"></textarea>';
                                                                            } else if($key == 'A' && ($content_key == '4' || $content_key == "3") && $list_key == 0) {
                                                                                echo '<p class="pl-3 m-0">'.renderLang($list).'</p>';
                                                                                echo '<input type="text" class="form-control border-0 date-range" name="covered_period[]">';
                                                                                echo '<input type="hidden" name="findings_key[]" value="'.$list_key.'">';
                                                                            } else {
                                                                                echo '<p class="p-3 m-0">'.renderLang($list).'</p>';
                                                                                echo '<input type="hidden" name="findings_key[]" value="'.$list_key.'">';
                                                                            }
                                                                        echo '</td>';
                                                                        // othe findings
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="findings[]"></textarea>';
                                                                        echo '</td>';
                                                                        // complied
                                                                        echo '<td class="complied text-center">';
                                                                            echo '<button class="btn mt-3 d-none"></button>';
                                                                            echo '<input type="hidden" name="complied[]" value="">';
                                                                        echo '</td>';
                                                                        // classifications
                                                                        echo '<td>';
                                                                            echo '<select class="form-control border-0 classification" name="classification[]">';
                                                                                echo '<option value=""></option>';
                                                                                foreach($iad_corrective_plan_classifications_arr as $class_key => $classification) {
                                                                                    echo '<option value="'.$class_key.'">'.renderLang($classification).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                        echo '</td>';
                                                                        // risks
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="risks[]"></textarea>';
                                                                        echo '</td>';
                                                                        // recommendations
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="recommendations[]"></textarea>';
                                                                        echo '</td>';
                                                                        // root cause
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="root_cause[]"></textarea>';
                                                                        echo '</td>';
                                                                        // correction
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="correction[]"></textarea>';
                                                                        echo '</td>';
                                                                        // corrective action
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="corrective_action[]"></textarea>';
                                                                        echo '</td>';
                                                                        // timeline
                                                                        echo '<td>';
                                                                            echo '<input type="text" class="form-control date border-0 text-center" name="timeline[]">';
                                                                        echo '</td>';
                                                                        // responsible party
                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="responsible_party[]"></textarea>';
                                                                        echo '</td>';
                                                                        // verification date
                                                                        echo '<td>';
                                                                            echo '<input type="text" class="form-control date border-0 text-center" name="verification_date[]">';
                                                                        echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                                echo '</tbody>';
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>

                                                    <?php if($key == "I") { ?>
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-right">
                                                            <button class="btn btn-info btn-sm add-row"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                <?php } ?>

                                <div class="row mt-3">
                                    <div class="col-lg-3 col-md-4">
                                        <label for="attachments"><?php echo renderLang($lang_attachments); ?></label>
                                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/corrective-action-plan-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($audits_corrective_action_plan_add); ?></button>
                            </div>
                        </div>

                    </form>

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

        // add row
        $('.add-row').on('click', function(e){
            e.preventDefault();
            var fields = $(this).closest('.card').find('table').find('.hide:nth-last-child(1)').find('tr:nth-child(1)').html();
            $(this).closest('.card').find('table').find('.hide:nth-last-child(1)').append('<tr>'+fields+'</tr>');
            $(this).closest('.card').find('table').find('.hide:nth-last-child(1)').find('tr:nth-last-child(1)').find('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });
        });

        // Findings count
        $('body').on('change', '.classification', function(){
            var major = 0;
            var minor = 0;
            var note = 0;
            $('.classification').each(function(){
                var key_val = $(this).val();
                if(key_val == '0' || key_val == 1) {
                    major++;
                }
                if(key_val == 2) {
                    minor++;
                }
                if(key_val == 3) {
                    note++;
                }
                console.log(key_val);
            });
            $('.major_count').val(major);
            $('.minor_count').val(minor);
            $('.note_count').val(note);
        });

        // compliance legend
            var compliance_arr = <?php echo json_encode($iad_corrective_plan_compliance_arr); ?>;
            var complied_val = $('.btn-selected').closest('li').data('key');
            var complied_color = $('.btn-selected').closest('li').data('color');
            $('body .compliance-legend').children().on('click', function(e){
                e.preventDefault();
                $('.compliance-legend').each(function(){
                    if($(this).find('button').hasClass('btn-selected')) {
                        $(this).find('button').removeClass('btn-selected');
                    }
                });
                $(this).parent().find('button').addClass('btn-selected');
                complied_val = $(this).closest('li').data('key');
                complied_color = $(this).closest('li').data('color');
            });
        // 

        // complied click
        $('body').on('click', '.complied', function(e){
            e.preventDefault();
            $(this).find('button').html(compliance_arr[complied_val][<?php echo $_SESSION['sys_language']; ?>]);
            if($(this).find('button').hasClass('d-none')) {
                $(this).find('button').removeClass('d-none');
                $(this).find('button').removeClass('btn-success').removeClass('btn-danger').removeClass('btn-secondary');
                $(this).find('button').addClass('btn-'+complied_color);
                $(this).find('input').val(complied_val);
            } else {
                if($(this).find('button').hasClass('btn-'+complied_color)) {
                    $(this).find('button').removeClass('btn-success').removeClass('btn-danger').removeClass('btn-secondary');
                    $(this).find('button').addClass('d-none');
                    $(this).find('input').val('');
                } else {
                    $(this).find('button').removeClass('btn-success').removeClass('btn-danger').removeClass('btn-secondary');
                    $(this).find('button').addClass('btn-'+complied_color);
                    $(this).find('input').val(complied_val);
                }
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

        // date range
        $('.date-range').each(function(){
            $(this).daterangepicker({
                singleDatePicker: false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        // toggle table rows
        $('body').on('click', '[data-toggle="toggle"]', function(){
            $(this).closest('tbody').next('.hide').toggle();
        });

        // auditees add row
        $('body').on('click', '.add-row-auditee', function(e){
            e.preventDefault();

            var fields = $(this).closest('table').find('tbody').find('tr:nth-child(1)').html();
            $(this).closest('table').find('tbody').append('<tr>'+fields+'</tr>');

        });

        // auditees delete row
        $('body').on('click', '.remove-auditee-row', function(e){
            e.preventDefault();
            if($(this).closest('tbody').find('tr').length != 1) {
                $(this).closest('tr').remove();
            } else {
                alert('last row cannot be deleted');
            }
        });

        // verification add row
        $('body').on('click', '.add-row-verification', function(e) {
            e.preventDefault();

            var fields = $(this).closest('.card').find('table').find('tbody').find('tr:nth-child(1)').html();
            $(this).closest('.card').find('table').find('tbody').append('<tr>'+fields+'</tr>');
            $(this).closest('.card').find('table').find('tbody').find('tr:nth-last-child(1)').find('textarea').each(function(){
                $(this).val("");
            });
            $(this).closest('.card').find('table').find('tbody').find('tr:nth-last-child(1)').find('.complied').find('button').addClass('d-none').removeClass('btn-success').removeClass('btn-danger').removeClass('btn-secondary');
            $(this).closest('.card').find('table').find('tbody').find('tr:nth-last-child(1)').find('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
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