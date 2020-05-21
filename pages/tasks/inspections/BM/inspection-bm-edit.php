<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('inspection-BM-edit')) {

    $page = 'inspections';
    
    $curr_day = date('d');
    $curr_month = date('m');
    $curr_year = date('Y');

    $id = $_GET['id'];
    $sql = $pdo->prepare("SELECT * FROM task_inspection_bm_checklist WHERE id = :id AND temp_del = 0");
    $sql->bindParam(":id", $id);
    $sql->execute();
    $month = '';
    $day = '';
    if($sql->rowCount()) {

        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $month = date('m', strtotime($_data['date']));
        $day = date('d', strtotime($_data['date']));

    } else {

        $_SESSION['sys_inspection_bm_add_err'] = renderLang($lang_no_data);
        header('location: /bm-inspections');
        exit();

    }

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspection_building_manager_edit); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/pre-operation-audit.css">
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($inspection_building_manager_edit); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <form action="/submit-edit-bm-checklist" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($inspection_building_manager_update_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="checklist_id" value="<?php echo $id; ?>">

                                <div class="row ">
                                    <div class="col-12 text-center mb-3">
                                        <h4><?php echo strtoupper(renderLang($inspection_building_manager_inspection_checklist)); ?></h4>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($inspection_building); ?></label>
                                            <input type="text" class="form-control input-readonly" name="sub_property_id" value="<?php echo getField('sub_property_name', 'sub_properties', 'id = '.$_data['sub_property_id']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="month"><?php echo renderLang($inspection_month); ?></label>
                                            <input type="text" id="month" class="form-control input-readonly" readonly value="<?php echo renderLang($months_arr[$month]); ?>">
                                            <input type="hidden" name="month" value="<?php echo $month; ?>">
                                        </div>
                                    </div>

                                    <!-- legend -->
                                    <div class="col-lg-6 col-md-12">
                                        <ul style="list-style-type: none;">
                                            <?php 
                                            foreach($inspection_bm_checklist_legend_arr as $key => $legend) {
                                                echo '<li class="p-2">';
                                                    echo '<button class="btn btn-'.$legend['legend-color'].' btn-legend '.($key == 0 ? 'btn-selected' : '').'" data-color="'.$legend['legend-color'].'"></button>';
                                                    echo '<span class="ml-2">'.renderLang($legend['legend']).'</span>';
                                                echo '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>

                                <input type="hidden" name="day" value="<?php echo $day; ?>">

                                <?php foreach($inspection_checklist_arr as $tab_key => $tab) {  ?>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn pms-red text-white w100pc" type="button"  data-toggle="collapse" data-target="#tab-<?php echo strtolower($tab['name']); ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $tab['symbol'].' '.$tab['name']; ?></button>
                                        </p>
                                        <div class="collapse" id="tab-<?php echo strtolower($tab['name']); ?>">

                                            <div class="card card-body">

                                                <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM task_inspection_bm_checklist_tab WHERE bm_checklist_id = :id AND tab_category = :tab_key LIMIT 1");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->bindParam(":tab_key", $tab_key);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    $checklist_tab_id = $data['id'];
                                                    $tab_remarks = $data['remarks'];
                                                ?>

                                                <div class="row">
                                                    <div class="col-12 table-responsive mh500p">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo $tab['symbol']; ?></th>
                                                                    <th><?php echo $tab['name']; ?></th>
                                                                    <th colspan="2" class="text-center"><?php echo renderLang($inspection_day).' '.$day; ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                foreach($tab['list'] as $list_key => $list) {

                                                                    
                                                                    $sql = $pdo->prepare("SELECT * FROM task_inspection_bm_checklist_tab_categories WHERE checklist_tab_id = :checklist_tab_id AND category = :list_key LIMIT 1");
                                                                    $sql->bindParam(":checklist_tab_id", $checklist_tab_id);
                                                                    $sql->bindParam(":list_key", $list_key);
                                                                    $sql->execute();
                                                                    
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                                                                    echo '<tr>';

                                                                        echo '<input type="hidden" name="tab_key[]" value="'.$tab_key.'">';

                                                                        echo '<td>';
                                                                            $numbering = explode('.', $list[0]);
                                                                            if(!empty($numbering[1])) {
                                                                                echo '<p class="pl-2">'.$list[0].'</p>';
                                                                            } else {
                                                                                echo '<p><b>'.$list[0].'</b></p>';
                                                                            }
                                                                        echo '</td>';
                                                                        // item
                                                                        echo '<td>';
                                                                            echo '<p class="w300">'.renderLang($list[1]).'</p>';
                                                                            echo '<input type="hidden" name="inspection_category[]" value="'.$list_key.'">';
                                                                        echo '</td>';

                                                                        // check button
                                                                        echo '<td class="w55 check">';
                                                                            echo '<button type="button" class="btn btn-'.$inspection_bm_checklist_legend_arr[$data['check_color']]['legend-color'].' '.($data['check_value'] == 1 ? '' : 'd-none').'"><i class="fa fa-check"></i></button>';
                                                                        echo '</td>';
                                                                        // remarks
                                                                        echo '<td>';
                                                                            echo '<textarea name="notes[]" class="form-control notes border-0">'.$data['notes'].'</textarea>';
                                                                        echo '</td>';

                                                                        echo '<input type="hidden" name="check_value[]" value="'.$data['check_value'].'">';
                                                                        echo '<input type="hidden" name="check_color[]" value="'.$data['check_color'].'">';

                                                                    echo '</tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="tab_category[]" value="<?php echo $tab_key; ?>">
                                                
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo renderLang($inspection_remarks); ?></label>
                                                            <textarea name="tab_remarks[]" rows="3" class="form-control notes"><?php echo $tab_remarks; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/bm-inspections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-success"><i class="fa fa-save mr-1"></i><?php echo renderLang($inspection_BM_inspection_update); ?></button>
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

			$('#date').daterangepicker({
				singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
			});

            // select color
            var color = 'success';
            $('body').on('click', '.btn-legend', function(e){
                e.preventDefault();

                $('.btn-legend').each(function(){
                    $(this).removeClass('btn-selected');
                });

                $(this).addClass('btn-selected');

                color = $(this).data('color');

            });

            // check
            $('body').on('click', '.check', function(){
                // remove btn color
                $(this).find('button').removeClass('btn-warning').removeClass('btn-success').removeClass('btn-danger');

                // add the selected btn color
                $(this).find('button').addClass('btn-'+color);

                switch(color) {
                    case 'success':
                        $(this).closest('tr').find('input[name="check_color[]"]').val('0');
                    break;

                    case 'warning':
                        $(this).closest('tr').find('input[name="check_color[]"]').val('1');
                    break;

                    case 'danger':
                        $(this).closest('tr').find('input[name="check_color[]"]').val('2');
                    break;
                }

                if($(this).find('button').hasClass('d-none')) {
                    $(this).find('button').removeClass('d-none');
                    $(this).closest('tr').find('input[name="check_value[]"]').val('1');
                } else {
                    $(this).find('button').addClass('d-none');
                    $(this).closest('tr').find('input[name="check_value[]"]').val('0');
                    $(this).closest('tr').find('input[name="check_color[]"]').val('');
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