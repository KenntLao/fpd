<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('inspections')) {

	$page = 'inspections';

    $inpection_no = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($inspections); ?> &middot; <?php echo $sitename; ?></title>
	
	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/assets/css/preventive-maintenance.css">
	
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
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($inspections); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid" id="tabs">

                    

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                
                                <!-- ENGINEERING SERVICES  -->
                                <?php if ($inpection_no == 5) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/inspection-sheet">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3><?php echo renderLang($inspection_sheet_engineering_services_division); ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <!--Fire Extinguisher Inspection -->
                                <?php if ($inpection_no == 1) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/fire-extinguisher-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3><?php echo renderLang($fire_extinguisher_inspection_checklist); ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <!--Emergency Light Inspection --> 
                                <?php if ($inpection_no == 1) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/emergency-light-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3><?php echo renderLang($emergency_light_inspection_checklist); ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <!--BM Inspection -->    
                                <?php if ($inpection_no == 2 ) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/bm-inspections">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3><?php echo renderLang($inspection_building_manager_inspection); ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                              
                                <!-- FCU inspection -->
                                <?php if ($inpection_no == 1 ) { 
                                        if (checkPermission('fcu-monthly-inspections')) {?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/fcu-monthly-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3><?php echo renderLang($inspection_fcu_monthly_inspections); ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   } 
                                      }?>

                                <!-- Genaral Inspection & Function Check -->
                                <?php if ($inpection_no == 0 ) { 
                                        if (checkPermission('general-inspection-and-function-check')) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/general-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3>General Inspection & Function Check</h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   }
                                      } ?>
                                
                                <!-- Proper Installation, Genaral Inspection & Function Check  -->
                                <?php if ($inpection_no == 0 ) { 
                                        if (checkPermission('proper-installation-general-inspection-and-function-check')) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/proper-installation-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3>Proper Installation, General Inspection & Function Check</h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   } 
                                      } ?>
                                
                                <!-- Supply Voltage & Load Current Reading  -->
                                <?php if ($inpection_no == 0 ) { 
                                        if (checkPermission('supply-voltage-and-load-current-reading')) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/supply-voltage-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3>Supply Voltage & Load Current Reading</h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   } 
                                      } ?>
                                
                                <!-- Power & Grounding Wirings  -->
                                <?php if ($inpection_no == 0 ) { 
                                        if (checkPermission('power-and-grounding-wirings')) { ?>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <div class="bg-redd p-3 h-100 position-relative rounded" data-id="/power-inspection-list">
                                        <div class="row">
                                            <div class="col-8 position-relative">
                                                <div class="bottom-left">
                                                    <h3>Power & Grounding Wirings</h3>
                                                </div>
                                            </div>
                                            <div class="col-4 mx-auto">
                                                <img class="zoom" src="/assets/images/preventive-maintenance-icon/M.png" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php   } 
                                      } ?>

                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/inspection-categories" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

            $('.date').each(function(){
                $(this).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'MMMM d, Y'
                    }
                });
            });

            $('#tabs').on('click', '.bg-redd', function(){

                var href = $(this).data('id');

                window.location.href = href;

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