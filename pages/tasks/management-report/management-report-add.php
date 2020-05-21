<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('management-report-add')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
		$page = 'management-report';
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($management_report_new); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($management_report_new); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($management_report_new_form); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <!-- PROPERTY -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="sub_property_id"><?php echo renderLang($properties_property); ?></label>
                                        <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                            <?php 
                                            $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
                                            $sql->execute();
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- NAME -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo renderLang($management_report_name_of_bm); ?></label>
                                        <input type="text" class="form-control" name="" id="">
                                    </div>
                                </div>
                                <!-- DESIGNATION -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo renderLang($management_report_designation); ?></label>
                                        <input type="text" class="form-control" name="" id="">
                                    </div>
                                </div>
                                <!-- DATE -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo renderLang($lang_date); ?></label>
                                        <input type="text" class="form-control date" name="" id="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <p class="text-center">
                                        <button class="btn pms-red text-white w100pc" type="button" data-toggle="collapse" data-target="#tab-1" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($management_report_executive_summary); ?></button>
                                    </p>
                                    <div class="collapse" id="tab-1">

                                        <div class="card card-body">

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th class="w50pc bg-gray"><?php echo renderLang($management_report_items); ?></th>
                                                            <th class="w50pc bg-gray"><?php echo renderlang($management_report_highlights); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    foreach($management_report_executive_summary_arr as $key => $executive_summary) {
                                                    ?>
                                                        <tr>
                                                            <th colspan="2"><span class="mr-2"><?php echo $key; ?>.</span><?php echo renderLang($executive_summary['title']); ?></th>
                                                        </tr>
                                                        <?php 
                                                        foreach($executive_summary['items'] as $item_key => $item) {
                                                            echo '<tr>';

                                                                echo '<td>';
                                                                    echo '<p class="ml-3">'.$item_key.'. '.renderLang($item['title']).'</p>';
                                                                echo '</td>';

                                                                echo '<td>';
                                                                    echo '<p>';
                                                                    foreach($item['highlights'] as $hignlight_key => $highlight) {
                                                                        echo renderLang($highlight).'<br>';
                                                                    }
                                                                    echo '</p>';
                                                                echo '</td>';

                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    <?php
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
                        <div class="card-footer text-right">
                            <a href="" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
    <script>
    $(function(){

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
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