<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unidentified')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT sub_property_name, property_name FROM sub_properties sp JOIN properties p ON(sp.property_id = p.id) WHERE sp.id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            $_SESSION['sys_unidentified_add_err'] = renderLang($lang_no_data);
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($unidentified); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($unidentified); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderSuccess('sys_unidentified_add_suc');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($unidentified_list); ?></h3>
                            <div class="card-tools">
                                <a href="/add-unidentified/<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($unidentified_add); ?></a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                        <input type="text" class="form-control" value="<?php echo $_data['sub_property_name'].' ['.$_data['property_name'].']'; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <!-- UNIDENTIFIED -->
                                <div class="col-12">
                                    <label><?php echo renderLang($unidentified_status_arr[0]); ?></label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed table-hover">
                                            <thead class="bg-dark text-center">
                                                <tr>
                                                    <th><?php echo renderLang($unidentified_form_of_payment); ?></th>
                                                    <th><?php echo renderLang($unidentified_date_deposited); ?></th>
                                                    <th><?php echo renderLang($unidentified_amount); ?></th>
                                                    <th><?php echo renderLang($unidentified_bank); ?></th>
                                                    <th><?php echo renderLang($unidentified_deposit_reference); ?></th>
                                                    <th class="w75"><?php echo renderLang($unidentified_status); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="unidentified">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM unidentified WHERE sub_property_id = :id AND status = 0");
                                                $sql->bindParam(":id", $id);
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        echo '<td>'.$data['form_of_payment'].'</td>';
                                                        echo '<td>'.formatDate($data['date_deposited']).'</td>';
                                                        echo '<td>'.$data['amount'].'</td>';
                                                        echo '<td>';
                                                        if(checkVar($data['bank'])) {
                                                            if($data['bank'] == 999) {
                                                                echo $data['other_bank'];
                                                            } else {
                                                                echo renderLang($banks_arr[$data['bank']]);
                                                            }
                                                        }
                                                        echo '</td>';
                                                        echo '<td>'.$data['deposit_reference'].'</td>';
                                                        echo '<td>';
                                                            echo '<button data-id="'.$data['id'].'" class="btn status btn-xs btn-'.$unidentified_status_color_arr[$data['status']].'">'.renderLang($unidentified_status_arr[$data['status']]).'</button>';
                                                        echo '</td>';

                                                        // echo '<td>';
                                                        //     echo '<a href="/edit-daily-deposit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        // echo '</td>';

                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- IDENTIFIED -->
                                <div class="col-12">
                                <label><?php echo renderLang($unidentified_status_arr[1]); ?></label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-condensed" id="table-data">
                                            <thead class="bg-dark text-center">
                                                <tr>
                                                    <th><?php echo renderLang($unidentified_form_of_payment); ?></th>
                                                    <th><?php echo renderLang($unidentified_date_deposited); ?></th>
                                                    <th><?php echo renderLang($unidentified_amount); ?></th>
                                                    <th><?php echo renderLang($unidentified_bank); ?></th>
                                                    <th><?php echo renderLang($unidentified_deposit_reference); ?></th>
                                                    <th class="w75"><?php echo renderLang($unidentified_status); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="identified">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM unidentified WHERE sub_property_id = :id AND status = 1");
                                                $sql->bindParam(":id", $id);
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        echo '<td>'.$data['form_of_payment'].'</td>';
                                                        echo '<td>'.formatDate($data['date_deposited']).'</td>';
                                                        echo '<td>'.$data['amount'].'</td>';
                                                        echo '<td>';
                                                        if(checkVar($data['bank'])) {
                                                            if($data['bank'] == 999) {
                                                                echo $data['other_bank'];
                                                            } else {
                                                                echo renderLang($banks_arr[$data['bank']]);
                                                            }
                                                        }
                                                        echo '</td>';
                                                        echo '<td>'.$data['deposit_reference'].'</td>';
                                                        echo '<td>';
                                                            echo '<button data-id="'.$data['id'].'" class="btn status btn-xs btn-'.$unidentified_status_color_arr[$data['status']].'">'.renderLang($unidentified_status_arr[$data['status']]).'</button>';
                                                        echo '</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/unidentified-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                        </div>
                    </div>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
  	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
    $(function(){

        // update status
        $('body').on('click', '.status', function(e){
            e.preventDefault();

            var $this = $(this);

            var id = $(this).data('id');
            var status;
            if($(this).hasClass('btn-success')) {
                status = 0;
            } else {
                status = 1;  
            }

            var after_status;

            $.post("/update-unidentified-status", {
                id:id, status:status
            }, function(data){
                if(data == '0') {
                    $this.removeClass('btn-success').addClass('btn-secondary').html('<?php echo renderLang($unidentified_status_arr[0]) ?>');
                } 
                if(data == '1') {
                    $this.removeClass('btn-secondary').addClass('btn-success').html('<?php echo renderLang($unidentified_status_arr[1]) ?>');
                }
                after_status = data;

                if(after_status == 0) {
                    var tr = '<tr>'+$this.closest('tr').html()+'</tr>';
                    $this.closest('tr').remove();
                    $('#unidentified').append(tr);
                }
                if(after_status == 1) {
                    var tr = '<tr>'+$this.closest('tr').html()+'</tr>';
                    $this.closest('tr').remove();
                    $('#identified').append(tr);
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