<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('unidentified-add')) {
	
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
	<title><?php echo renderLang($unidentified_add); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($unidentified_add); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <form action="/submit-add-unidentified" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($unidentified_add_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                                <?php 
                                                    if($_SESSION['sys_account_mode'] == 'user') {

                                                        $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                        $sql->execute();
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                        }

                                                    } else {

                                                        // get clusters of user
                                                        $cluster_ids = getClusterIDs($_SESSION['sys_id']);
                                                        
                                                        // no cluster
                                                        if(empty($cluster_ids)) {

                                                            $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                            $sub_properties = explode(',', $sub_property_ids);
                                                            foreach($sub_properties as $sub_property_id) {
                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                                }
                                                            }

                                                        } else { // has cluster

                                                            // get all properties under cluster
                                                            $property_ids = array();
                                                            $sub_property_ids = array();
                                                            foreach($cluster_ids as $cluster_id) {
                                                                // get properties under cluster
                                                                $property_ids = getClusterProperties($cluster_id);

                                                                // get all sub_properties under property
                                                                foreach($property_ids as $property_id) {
                                                                    $sql = $pdo->prepare("SELECT id FROM sub_properties WHERE property_id = :property_id AND temp_del = 0");
                                                                    $sql->bindParam(":property_id", $property_id);
                                                                    $sql->execute();
                                                                    if($sql->rowCount()) {
                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                            $sub_property_ids[] = $data['id'];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            foreach($sub_property_ids as $sub_property_id) {

                                                                $sql = $pdo->prepare("SELECT sp.id, p.temp_del, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND sp.id = :id AND p.temp_del = 0");
                                                                $sql->bindParam(":id", $sub_property_id);
                                                                $sql->execute();
                                                                if($sql->rowCount()) {
                                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                                }

                                                            }

                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="form_of_payment"><?php echo renderLang($unidentified_form_of_payment); ?></label>
                                            <input type="text" class="form-control" name="form_of_payment" id="form_of_payment">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="date_deposited"><?php echo renderLang($unidentified_date_deposited); ?></label>
                                            <input type="text" class="form-control date" name="date_deposited" id="date_deposited">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="amount"><?php echo renderLang($unidentified_amount); ?></label>
                                            <input type="text" class="form-control" data-type="currency" name="amount" id="amount">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="deposit_reference"><?php echo renderLang($unidentified_deposit_reference); ?></label>
                                            <input type="text" class="form-control" name="deposit_reference" id="deposit_reference">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="bank"><?php echo renderLang($unidentified_bank); ?></label>
                                            <select name="bank" id="bank" class="form-control">
                                                <?php 
                                                foreach($banks_arr as $key => $bank) {
                                                    echo '<option value="'.$key.'">'.renderLang($bank).'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 d-none specify">
                                        <div class="form-group">
                                            <label for="bank_specify"><?php echo renderLang($unidentified_other_banks_sepcify); ?></label>
                                            <input type="text" class="form-control" name="bank_specify" id="bank_specify">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/unidentified/<?php echo $id; ?>" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($unidentified_add); ?></button>
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

        // other bank
            $('body').on('change', '#bank', function(){
                var bank = $(this).val();

                if(bank == 999) {
                    $('.specify').removeClass('d-none');
                } else {
                    $('.specify').addClass('d-none');
                }

            });
        // 

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