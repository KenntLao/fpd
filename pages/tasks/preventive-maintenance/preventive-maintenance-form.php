<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('preventive-maintenance-add')) {

    $page = 'preventive-maintenance';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT pm.equipment_id, pm.frequency, e.equipment_name, e.serial_number, e.equipment_description, e.equipment_location, pm.before_picture, pm.after_picture, pm.month_of, pm.date FROM preventive_maintenance pm LEFT JOIN equipments e ON(pm.equipment_id = e.id) WHERE pm.id = :pm_id LIMIT 1");
    $sql->bindParam(":pm_id", $id);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    $frequency_id = $data['frequency'];
    $equipment_id = $data['equipment_id'];

    $frequency = $preventive_maintenance_frequency_arr[$frequency_id][1];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($frequency); ?> &middot; <?php echo $sitename; ?></title>
	
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
					renderSuccess('sys-preventive-maintenance-add-suc');
					renderError('sys-preventive-maintenance-add-err');
					?>

                    <form action="/submit-preventive-maintenance-checklist" method="post" enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($frequency); ?> <?php echo renderLang($preventive_maintenance_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="equipment_id" value="<?php echo $equipment_id; ?>">
								<input type="hidden" name="pm_id" value="<?php echo $id; ?>">

                                <!-- TITLE -->
                                <div class="row pb-5">
                                    <div class="col-12 text-center">
                                        <h4><?php echo strtoupper(renderLang($frequency).' '.renderLang($preventive_maintenance_checklist)); ?></h4>
                                    </div>
                                </div>

								<div class="row">

									<?php if($frequency_id == 0 || $frequency_id == 1) { ?> 
										<div class="col-lg-3 col-md-6">
											<div class="form-group">
												<label for="month"><?php echo renderLang($preventive_maintenance_equipment_month); ?></label>
												<select name="month" id="month" class="form-control" required>
												<?php 
												foreach($months_arr as $key => $month) {
													echo '<option '.($data['month_of'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($month).'</option>';
												}
												?>
												</select>
											</div>
										</div>
									<?php } ?>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="date"><?php echo renderLang($lang_date); ?></label>
											<input type="text" class="form-control date" id="date" name="date" value="<?php echo checkVar($data['date']) ? formatDate($data['date']) : ''; ?>">
										</div>
									</div>

								</div>

                                <div class="row">

                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for=""><?php echo renderLang($preventive_maintenance_equipment); ?></label>
                                            <input type="text" class="form-control" name="equipment_name" value="<?php echo $data['equipment_name']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="model"><?php echo renderLang($preventive_maintenance_equipment_model_brand); ?></label>
                                            <input type="text" id="model" name="serial_number" class="form-control" value="<?php echo $data['serial_number']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="equipment_code"><?php echo renderLang($preventive_maintenance_equipment_code); ?></label>
                                            <input type="text" id="equipment_code" name="equipment_code" class="form-control" value="<?php echo $data['equipment_description']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="equipment_location"><?php echo renderLang($preventive_maintenance_equipment_location); ?></label>
                                            <input type="text" id="equipment_location" name="equipment_location" class="form-control" value="<?php echo $data['equipment_location']; ?>">
                                        </div>
                                    </div>

                                </div>

								<div class="row">

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="before_pictures"><?php echo renderLang($preventive_maintenance_before_pm_picture); ?></label>
											<input type="file" class="form-control" name="before_pictures[]" id="before_pictures" multiple>
											<?php 
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
                                            ?>
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<label for="after_pictures"><?php echo renderLang($preventive_maintenance_after_pm_picture); ?></label>
											<input type="file" class="form-control" name="after_pictures[]" id="after_pictures" multiple>
											<?php 
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
                                            ?>
										</div>
									</div>

								</div>

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <button class="btn btn-danger float-right" id="add-item"><i class="fa fa-plus mr-1"></i><?php echo renderLang($preventive_maintenance_equipment_add_item); ?></button>
                                    </div>
                                </div>

                                <div class="row">
 
                                    <div class="col-12 table-responsive mh500p">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>NO.</th>
                                                    <th><?php echo renderLang($preventive_maintenance_equipment_time_to_check); ?></th>

                                                    <!-- DAILY -->
                                                    <?php 
                                                    if($frequency_id == 0) {
                                                        for($i = 1; $i <= 31; $i++){
                                                            echo '<th>'.$i.'</th>';
                                                        }
                                                    }
                                                    ?>

                                                    <!-- WEEKLY -->
                                                    <?php
                                                    if($frequency_id == 1) {
                                                        for($i = 1; $i <= 4; $i++) {
                                                            echo '<th>'.renderLang($preventive_maintenance_equipment_week).' '.$i.'</th>';
                                                        }
                                                    ?>
                                                    <th><?php echo renderLang($preventive_maintenance_equipment_findings); ?></th>
                                                    <th><?php echo renderLang($preventive_maintenance_remarks); ?></th>
                                                    <?php } ?>

                                                    <!-- MONTHLY -->
                                                    <?php 
                                                    if($frequency_id == 2) {
                                                        for($i = 1; $i <= 4; $i++) {
                                                            echo '<th>'.renderLang($preventive_maintenance_month).' '.$i.'</th>';
                                                        }
                                                    ?>
                                                    <th><?php echo renderLang($preventive_maintenance_remarks); ?></th>
                                                    <?php } ?>

                                                    <!-- QUARTERLY -->
                                                    <?php 
                                                    if($frequency_id == 3) {
                                                        for($i = 1; $i <= 4; $i++) {

                                                            $prefix = '';
                                                            switch($i) {
                                                                case 1:
                                                                    $prefix = 'first';
                                                                    break;
                                                                
                                                                case 2:
                                                                    $prefix = 'second';
                                                                    break;

                                                                case 3:
                                                                    $prefix = 'third';
                                                                    break;

                                                                case 4:
                                                                    $prefix = 'fourth';
                                                                    break;
                                                            }

                                                            echo '<th>'.$prefix.' '.renderLang($preventive_maintenance_quarter).'</th>';
                                                        }
                                                    ?>
                                                    <th><?php echo renderLang($preventive_maintenance_remarks); ?></th>
                                                    <?php } ?>

                                                    <!-- SEMI ANNUAL -->
                                                    <?php 
                                                    if($frequency_id == 4) {
                                                        for($i = 1; $i <= 2; $i++) {
                                                            echo '<th>';
                                                            echo renderLang($preventive_maintenance_semi_annual);
                                                            echo '<input type="text" class="form-control date-range">';
                                                            echo '</th>';
                                                        }
                                                    ?>
                                                    <th><?php echo renderLang($preventive_maintenance_remarks); ?></th>
                                                    <?php } ?>

                                                    <!-- ANNUAL -->
                                                    <?php if($frequency_id == 5) { ?>
                                                        <th><?php echo renderLang($preventive_maintenance_findings); ?></th>
                                                        <th><?php echo renderLang($preventive_maintenance_remarks); ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="table-data">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT item_to_check, frequency, id FROM preventive_maintenance_item_to_check WHERE temp_del = 0 AND preventive_maintenance_id = :id");
                                            $sql->bindParam(":id", $id);
                                            $sql->execute();
                                            $no = 1;
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $sql1 = $pdo->prepare("SELECT * FROM preventive_maintenance_activities WHERE item_to_check_id = :id");
                                                $sql1->bindParam(":id", $data['id']);
                                                $sql1->execute();
                                                $frequency_code = array();
                                                $is_checked = array();
                                                while($data2 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                    $frequency_code[] = $data2['frequency_code'];
                                                    $is_checked[$data2['frequency_code']] = $data2['is_checked'];
                                                }

                                                echo '<tr>';
                                                echo '<td><p class="w30">'.$no.'.</p></td>';
                                                echo '<td><p class="w200">'.$data['item_to_check'].'</p></td>';

                                                // daily
                                                if($frequency_id == 0) {

                                                    for($i = 1; $i <= 31; $i++){

                                                        $code = $id.'-'.$data['frequency'].'-'.$data['id'].'-'.$i;
                                                        $data_check = in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '0' : '1' : '1';

                                                        echo '<td>';
                                                        echo '<p class="w30 mb-0"><button class="btn btn-success btn-sm check '.(in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '' : 'd-none' : 'd-none').'"  data-code="'.$code.'" data-checked="'.$data_check.'" data-id="'.$data['id'].'"><i class="fa fa-check"></i></button></p>';
                                                        echo '</td>';

                                                    }

                                                }
                                                
                                                // weekly
                                                if($frequency_id == 1) {

                                                    for($i = 1; $i <= 4; $i++) {

                                                        $code = $id.'-'.$data['frequency'].'-'.$data['id'].'-'.$i;
                                                        $data_check = in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '0' : '1' : '1';

                                                        echo '<td>';
                                                        echo '<p class="w30 mb-0"><button class="btn btn-success btn-sm check '.(in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '' : 'd-none' : 'd-none').'"  data-code="'.$code.'" data-checked="'.$data_check.'" data-id="'.$data['id'].'"><i class="fa fa-check"></i></button></p>';
                                                        echo '</td>';

                                                    }

                                                    echo '<td><textarea name="findings" data-pmitc-id="' . $data['id'] . '" row="2" class="form-control notes"></textarea></td>';
                                                    echo '<td><textarea name="remarks" data-pmitc-id="' . $data['id'] . '" row="2" class="form-control notes"></textarea></td>';

                                                }

                                                // monthly
                                                if($frequency_id == 2) {

                                                    for($i = 1; $i <= 4; $i++) {

                                                        $code = $id.'-'.$data['frequency'].'-'.$data['id'].'-'.$i;
                                                        $data_check = in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '0' : '1' : '1';

                                                        echo '<td>';
                                                        echo '<p class="w30 mb-0"><button class="btn btn-success btn-sm check '.(in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '' : 'd-none' : 'd-none').'"  data-code="'.$code.'" data-checked="'.$data_check.'" data-id="'.$data['id'].'"><i class="fa fa-check"></i></button></p>';
                                                        echo '</td>';

                                                    }

                                                    echo '<td><textarea name="" row="2" class="form-control notes"></textarea></td>';

                                                }

                                                // QUARTERLY
                                                if($frequency_id == 3) {

                                                    for($i = 1; $i <= 4; $i++) {

                                                        $code = $id.'-'.$data['frequency'].'-'.$data['id'].'-'.$i;
                                                        $data_check = in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '0' : '1' : '1';

                                                        echo '<td>';
                                                        echo '<p class="w30 mb-0"><button class="btn btn-success btn-sm check '.(in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '' : 'd-none' : 'd-none').'"  data-code="'.$code.'" data-checked="'.$data_check.'" data-id="'.$data['id'].'"><i class="fa fa-check"></i></button></p>';
                                                        echo '</td>';

                                                    }

                                                    echo '<td><textarea name="" row="2" class="form-control notes"></textarea></td>';

                                                }

                                                // SEMI ANNUAL
                                                if($frequency_id == 4) {

                                                    for($i = 1; $i <= 2; $i++) {

                                                        $code = $id.'-'.$data['frequency'].'-'.$data['id'].'-'.$i;
                                                        $data_check = in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '0' : '1' : '1';

                                                        echo '<td>';
                                                        echo '<p class="w30 mb-0"><button class="btn btn-success btn-sm check '.(in_array($code, $frequency_code) ? $is_checked[$code] == 1 ? '' : 'd-none' : 'd-none').'"  data-code="'.$code.'" data-checked="'.$data_check.'" data-id="'.$data['id'].'"><i class="fa fa-check"></i></button></p>';
                                                        echo '</td>';

                                                    }

                                                    echo '<td><textarea name="" row="2" class="form-control notes"></textarea></td>';

                                                }

                                                // ANNUAL
                                                if($frequency_id == 5) {

                                                    echo '<td><textarea name="" row="2" class="form-control notes"></textarea></td>';
                                                    echo '<td><textarea name="" row="2" class="form-control notes"></textarea></td>';
                                                    
                                                }
                                                
                                                echo '</tr>';

                                                $no++;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/frequency-preventive-maintenance/6" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

    <div class="modal fade" id="modal-add-item">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h4 class="modal-title"><?php echo renderLang($preventive_maintenance_equipment_add_item); ?></h4>
				</div>
				<form action="/add-item-to-check" method="post" class="ajax-form">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="modal-body">

                        <div class="form-group">
                            <label for="item"><?php echo renderLang($preventive_maintenance_item_to_check); ?></label>
                            <input type="text" class="form-control" name="item" id="item">
                        </div>

                        <div class="modal-err bg-danger p-4"></div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
						<button class="btn btn-primary"><i class="fa fa-plus mr-2"></i><?php echo renderLang($preventive_maintenance_equipment_add_item); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- modal -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
		$(function(){

            $('.date-range').each(function(){
                $(this).daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
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

            // check
            $('#table-data').on('click', 'td', function(e){
                e.preventDefault();

                var $this = $(this);

                var code = $(this).find('.check').data('code');
                var is_checked = $(this).find('.check').data('checked');
                var item_id = $(this).find('.check').data('id');

                // save to database
                $.post('/check-item-preventive-maintenance', {
                    code:code, is_checked:is_checked, item_id:item_id
                }, function(data){
                    $this.find('.check').toggleClass('d-none');
                });
            });

            $('#add-item').on('click', function(e){
                e.preventDefault();

                $('#modal-add-item').modal('show');
                $('.modal-err').hide()

            });

            //add findings and remarks
            $("[name='remarks'], [name='findings']").on('change', function(e){
                e.preventDefault();

                var pmitc_id, findings, remarks, data = [];

                $("[name='remarks']").each(function(){

                    pmitc_id = $(this).data('pmitc-id');
                    findings = $(this).closest('tr').find('[name="findings"]').val();
                    remarks = $(this).val();

                    data.push([pmitc_id, findings, remarks]);

                    console.log(data);
                });

                if (data.length !== 0) {
                    $.ajax({
                        url: "/submit-preventive-maintenance-findings-and-remarks",
                        type: 'POST',
                        data: {data: data},
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            })

            // add item
            $('form.ajax-form').on('submit', function(e){
				e.preventDefault();
				
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(response){
                        var data = JSON.parse(response);
                        if(data['type'] == 'success') {
                            window.location.reload();
                        } else {
                            $('.modal-err').show().html(data['msg']);
                        }
					}
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