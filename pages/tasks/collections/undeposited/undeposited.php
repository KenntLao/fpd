<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('undeposited')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        
        $id = $_GET['id'];
        $date = $_GET['date'];
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($undeposited); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-file-contract mr-3"></i><?php echo renderLang($undeposited); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($undeposited); ?></h3>
                        </div>
                        <div class="card-body">

                            <!-- SUB PROPERTY -->
                            <div class="row">
                                <!--  SUB PROPERTY -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="property_id"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                        <select name="sub_property_id" id="sub_property_id" class="form-control select2 input-readonly" disabled>
                                            <option value="0"></option>
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

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <?php 
                                    foreach($payment_types_arr as $key => $payment) {
                                        echo '<thead>';
                                            echo '<tr class="bg-dark">';
                                                echo '<th colspan="7">'.renderLang($payment).'</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<th>'.renderLang($daily_collections_daily_collection_unit).'</th>';
                                                echo '<th>'.renderLang($collections_check_voucher_amount).'</th>';
                                                echo '<th>'.renderLang($collections_or_number).'</th>';
                                                echo '<th>'.renderLang($collections_daily_deposit_payment).'</th>';
                                                echo '<th>'.renderLang($collections_daily_deposit_slip_reference_number).'</th>';
                                                echo '<th>'.renderLang($collections_check_voucher_bank).'</th>';
                                                echo '<th>'.renderLang($daily_collection_date).'</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            $sql = $pdo->prepare("SELECT * FROM daily_collections dc JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.temp_del = 0 AND dc.sub_property_id = :id AND dc.collection_date = :date AND dcpt.status = 0 AND dcpt.payment_type = :payment");
                                            $sql->bindParam(":id", $id);
                                            $sql->bindParam(":date", $date);
                                            $sql->bindParam(":payment", $key);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                        // unit
                                                        echo '<td>';
                                                            $unit_names = array();
                                                            $unit_ids = explode(',', $data['unit_id']);
                                                            foreach($unit_ids as $unit_id) {
                                                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                if(checkVar($unit_name)) {
                                                                    $unit_names[] = $unit_name;
                                                                } else {
                                                                    $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                                                    if(checkVar($unit_name)) {
                                                                        $unit_names[] = $unit_name;
                                                                    } else {
                                                                        $unit_names[] = $unit_id;
                                                                    }
                                                                }
                                                            }
                                                            $unit_name = implode(', ', $unit_names);
                                                            echo $unit_name;
                                                        echo '</td>';

                                                        echo '<td class="amount_'.$key.'" data-amount="'.$data['amount'].'">'.$data['amount'].'</td>';
                                                        echo '<td>';
                                                            if(checkVar($data['or_number'])) {
                                                                echo 'OR ['.$data['or_number'].']';
                                                            } else if(checkVar($data['ar_number'])) {
                                                                echo 'AR ['.$data['ar_number'].']';
                                                            }
                                                        echo '</td>';
                                                        echo '<td>'.renderLang($payment_types_arr[$data['payment_type']]).'</td>';
                                                        echo '<td class="payment" data-payment="'.$data['payment_type'].'">';	
                                                            if($data['payment_type'] == 2) {
                                                                echo $data['check_number'];
                                                            } 
                                                            if($data['payment_type'] == 1 || $data['payment_type'] == 3 || $data['payment_type'] == 4) {
                                                                echo $data['transaction_details'];
                                                            }
                                                        echo '</td>';
                                                        echo '<td>';
                                                            if(checkVar($data['bank'])) {
                                                                if($data['bank'] == 999) {
                                                                    echo $data['other_bank'];
                                                                } else {
                                                                    echo renderLang($banks_arr[$data['bank']]);
                                                                }
                                                            }
                                                        echo '</td>';
                                                        $curr_date = strtotime(formatDate(time(), true));
                                                        if(strtotime($data['collection_date']) < $curr_date) {
                                                            echo '<td class="text-red">'.formatDate($data['collection_date']).'</td>';
                                                        } else {
                                                            echo '<td>'.formatDate($data['collection_date']).'</td>';
                                                        }
                                                    echo '</tr>';
                                                }
                                            } else {
                                                    echo '<tr>';
                                                        echo '<td colspan="7">'.renderLang($lang_no_data).'</td>';
                                                    echo '</tr>';
                                            }
                                        echo '</tbody>';
                                    }
                                    ?>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <?php 
                                            foreach($payment_types_arr as $key => $payment) {
                                                echo '<tr>';
                                                    echo '<th class="text-uppercase">'.renderLang($payment).'</th>';
                                                    echo '<td><p class="total_'.$key.'"></p></td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                            <tr>
                                                <th class="text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                <td><input type="text" name="grand_total" class="form-control grand-total input-readonly border-0 font-weight-bold" readonly></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer text-right">
                            <a href="/undeposited-list" class="btn btn-default"><i class="fa fa-arrow-left"></i><?php echo renderLang($btn_back); ?></a>
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

        // load data on sub_property and date change
        $('#sub_property_id, #collection_date').on('change', function(){
            var id = $('#sub_property_id').val();
            var date = $('#collection_date').val();
            window.location.href = "/undeposited/"+date+"-"+id;
        });

        // total for each payment type
        var payment_types_arr = <?php echo json_encode($payment_types_arr); ?>;

        var grand_total = 0;
        
        $.each(payment_types_arr, function(key, data) {
            var total_amount = 0;
            $('.amount_'+key).each(function(){
                var amount = $(this).html();
                amount = convertCurrency(amount);
                total_amount += amount;
            });
            $('.total_'+key).html(convert_to_currency(total_amount, "blur"));
            grand_total += total_amount;
        });

        $('.grand-total').val(convert_to_currency(grand_total, "blur"));
		
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