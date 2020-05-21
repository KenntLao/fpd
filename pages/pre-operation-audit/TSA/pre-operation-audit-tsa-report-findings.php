<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('pre-operation-audit-TSA-add')) {

    $page = 'pre-operation-audit';
    
    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa WHERE id = :id LIMIT 1");
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
	<title><?php echo renderLang($pre_operation_audit_tsa_audit_report); ?> &middot; <?php echo $sitename; ?></title>

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
							<h1><i class="fas fa-clipboard-check mr-3"></i><?php echo renderLang($pre_operation_audit_tsa_audit_report); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($pre_operation_audit_pvc_findings); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                <?php 
                                $sql = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system WHERE tsa_id = :id");
                                $sql->bindParam(":id", $id);
                                $sql->execute();
                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<div class="table-responsive">';
                                        echo '<table class="table table-bordered table-condensed">';
                                            echo '<thead>';
                                                echo '<tr>';
                                                    echo '<th colspan="'.(count($tsa_section_3_arr[$data['category']][1]) + 4).'" class="text-white pms-red">'.renderLang($tsa_section_3_arr[$data['category']][0]).'</th>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                    echo '<th><p class="w200">'.renderLang($pre_operation_audit_pvc_findings).'</p></th>';
                                                    echo '<th><p class="w200">'.renderLang($pre_operation_audit_prioritization).'</p></th>';
                                                    echo '<th><p class="w200">'.renderLang($pre_operation_audit_tsa_location).'</p></th>';
                                                    echo '<th><p class="w200">'.renderLang($pre_operation_audit_tsa_unit).'</p></th>';
                                                    foreach($tsa_section_3_arr[$data['category']][1] as $key => $value) {
                                                        echo '<th><p class="w100">'.renderLang($value).'</p></th>';
                                                    }
                                                echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                                $sql1 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_locations WHERE system_id = :system_id");
                                                $sql1->bindParam(":system_id", $data['id']);
                                                $sql1->execute();
                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';

                                                        // findinds
                                                        echo '<td>'.(isset($data1['findings']) ? renderLang($tsa_audit_fingings_arr[$data1['findings']]['findings']) : '').'</td>';
                                                        // prioritization
                                                        echo '<td>';
                                                            if(isset($data1['prioritization'])) {
                                                                if($data1['prioritization'] == 5) {
                                                                    echo $data1['prioritization_specify'];
                                                                } else {
                                                                    echo renderLang($tsa_audit_prioritization_arr[$data1['prioritization']]);
                                                                }
                                                            }
                                                        echo '</td>';
                                                        // location
                                                        echo '<td>'.$data1['location'].'</td>';
                                                        // unit
                                                        echo '<td>'.$data1['unit'].'</td>';

                                                        foreach($tsa_section_3_arr[$data['category']][1] as $key => $value) {

                                                            $sql2 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_system_units WHERE location_id = :location_id AND specification_category = :category LIMIT 1");
                                                            $sql2->bindParam(":location_id", $data1['id']);
                                                            $sql2->bindParam(":category", $key);
                                                            $sql2->execute();
                                                            if($sql2->rowCount()) {
                                                                $data2 = $sql2->fetch(PDO::FETCH_ASSOC);
                                                                echo '<td>'.$data2['specification'].' : '.$data2['operational_data'].'</td>';
                                                            } else {
                                                                echo '<td></td>';
                                                            }

                                                        }
                                                        
                                                    echo '</tr>';
                                                }
                                            echo '</tbody>';
                                        echo '</table>';
                                    echo '</div>';
                                }
                                ?>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/pre-operation-audit-tsa-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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

			$('.duallistbox').bootstrapDualListbox();

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