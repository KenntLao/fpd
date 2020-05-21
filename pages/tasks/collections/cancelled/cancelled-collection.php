<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('cancelled-collections')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        
        $id = $_GET['id'];

        $sql = $pdo->prepare("SELECT cc.*, dc.*, sp.sub_property_name, p.property_name FROM cancelled_collection cc JOIN daily_collections dc ON(cc.collection_id = dc.id) JOIN sub_properties sp ON(dc.sub_property_id = sp.id) JOIN properties p ON(sp.property_id = p.id) WHERE cc.id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        if($sql->rowCount()) {
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            $_SESSION['sys_cancelled_collection_err'] = renderLang($lang_no_data);
            header('location: /cancelled-collections');
            exit();
        }
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($cancelled_collection); ?> &middot; <?php echo $sitename; ?></title>
	
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

					<div class="row">
						<div class="col-sm-9">
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($cancelled_collection); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <?php 
                    renderError('sys_cancelled_collection_err');
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($cancelled_collection); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-<?php echo $cancelled_collection_status_color_arr[$_data['status']] ?>"><?php echo renderLang($cancelled_collection_status_arr[$_data['status']]); ?></button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="sub_property"><?php echo renderLang($cancelled_collections_project); ?></label>
                                        <input type="text" class="form-control input-readonly" id="sub_property" value="<?php echo $_data['sub_property_name'].' ['.$_data['property_name'].']'; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="collection_date"><?php echo renderLang($cancelled_collections_date); ?></label>
                                        <input type="text" class="form-control" id="collection_date" value="<?php echo formatDate($_data['collection_date']); ?>">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4">
                                    <?php
                                    $reference = renderLang($reference_number_arr[$_data['voucher_type']]);
                                    if ($_data['voucher_type'] == 1) {
                                        $reference .= ' ['.$_data['ar_number'].']';
                                    }
                                    if ($_data['voucher_type'] == 2) {
                                        $reference .= ' ['.$_data['or_number'].']';
                                    }
                                    if ($_data['voucher_type'] == 3) {
                                        $reference .= ' ['.$_data['pr_number'].']';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="reference"><?php echo renderLang($cancelled_collections_reference); ?></label>
                                        <input type="text" class="form-control" id="reference" value="<?php echo $reference; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></th>
                                            <th><?php echo renderLang($daily_collections_daily_collection_amount); ?></th>
                                            <th><?php echo renderLang($daily_collections_daily_collection_transaction_details); ?></th>
                                            <th><?php echo renderLang($collections_check_voucher_check_number); ?></th>
                                            <th><?php echo renderLang($cancelled_collections_bank); ?></th>
                                            <th><?php echo renderLang($daily_collections_daily_collection_date_of_check); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE daily_collection_id = :collection_id");
                                        $sql->bindParam(":collection_id", $_data['collection_id']);
                                        $sql->execute();
                                        if($sql->rowCount()) {
                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
                                                    echo '<td>';
                                                        echo renderLang($payment_types_arr[$data['payment_type']]);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo $data['amount'];
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo $data['transaction_details'];
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo $data['check_number'];
                                                    echo '</td>';
                                                    echo '<td>';
                                                    if(checkVar($data['bank'])) {
                                                        if ($data['bank'] == '999') {
                                                            echo $data['other_bank'];
                                                        }else{
                                                            echo renderLang($banks_arr[$data['bank']]);
                                                        }
                                                    }
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo $data['date_of_check'];
                                                    echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/cancelled-collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                            <?php if(checkPermission('cancelled-collection-approve') && $_data['status'] == 0) { ?>
                                <button class="btn btn-success approval" data-status="1"><i class="fa fa-check mr-1"></i><?php echo renderLang($lang_approve); ?></button>
                            <?php } ?>
                        </div>
                    </div>

                </div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script>
    $(function(){

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        <?php
        // approval notification
        if(isset($_SESSION['sys_cancelled_collection_suc'])) {
            ?>
            Toast.fire({
                type: 'success',
                title: '<?php echo $_SESSION['sys_cancelled_collection_suc']; ?>'
            });
            <?php
            unset($_SESSION['sys_cancelled_collection_suc']);
        }
        ?>

        $('body').on('click', '.approval', function(e){
            e.preventDefault();
            var status = $(this).data('status');
            var id = <?php echo $id; ?>;
            $.post("/update-cancelled-collection-status", {
                status:status, id:id
            }, function(data){
                window.location.reload();
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