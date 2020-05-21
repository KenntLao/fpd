<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collections')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';
        // page url
        $page_href = "daily-collections";
        
        $current_date = formatDate(time(), true);

        $fields_arr = array('sub_property_name','property_name','unit_name'); // fields to search
        $date_fields_arr = array('collection_date');
        $search_placeholder = renderLang($daily_collections_daily_collection_building).', '.renderLang($daily_collections_daily_collection_unit); // search placeholder
        // set search
        include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-config.php");

        // get total row
        $total_row = 0;
        if($_SESSION['sys_account_mode'] == 'user') {
            $total_row = getField('count(dc.id)', 'daily_collections dc LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id)', 'dc.temp_del = 0 '.$where);
        } else {
            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];
            $sub_properties = "0";
            if(!empty($sub_property_ids)) {
                $sub_properties = implode(", ", $sub_property_ids);
            }
            foreach($sub_property_ids as $sub_property_id) {
                $sql = $pdo->prepare("SELECT count(dc.id) FROM daily_collections dc LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE dc.sub_property_id IN($sub_properties) AND dc.temp_del = 0 $where ORDER BY dc.id DESC");
                $sql->execute();
                if($sql->rowCount()) {
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $total_row = $data['count(dc.id)'];
                }
            }
        }

        include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination-config.php");
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collections_daily_collection); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($daily_collections_daily_collection); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					<?php
					renderSuccess('sys_daily_collection_edit_suc');
					renderError('sys_daily_collection_edit_err');
                    renderSuccess('sys_daily_collection_add_suc');
                    renderSuccess('sys_daily_collection_suc');
                    renderSuccess('sys_cancelled_collection_add_suc');
                    renderError('sys_cancelled_collection_add_err');
					?>
					
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($daily_collections_list); ?></h3>
                            <div class="card-tools">
								<?php if(checkPermission('daily-collection-add')) { ?><a href="/add-daily-collection" class="btn btn-danger btn-md"><i class="fa fa-plus pr-2"></i><?php echo renderLang($daily_collections_add_daily_collection); ?></a>
								<?php } ?>
							</div>
                        </div>
                        <div class="card-body">

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-filter.php"); ?>

							<!-- DATA TABLE -->
							<div class="table-responsive">
								<table id="table-data" class="table table-hover table-bordered with-options">
									<thead>
										<tr>
											<th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_unit); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_voucher_type); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_payment_type); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_amount); ?></th>
											<th><?php echo renderLang($collections_check_voucher_check_number); ?></th>
											<th><?php echo renderLang($collections_check_voucher_bank); ?></th>
											<th><?php echo renderLang($daily_collections_daily_collection_date); ?></th>
                                            <?php if(checkPermission('daily-collection-update-status')) { ?>
                                            <!-- <th><?php echo renderLAng($lang_status); ?></th> -->
                                            <?php } ?>
											<?php if(checkPermission('daily-collection-edit')) { ?>
											    <th class="no-sort p-0" style="width: <?php echo checkPermission('daily-collection-edit') ? '60px' : '35px'; ?>;"></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $data_count = 0;
                                        $count = 0;
										if($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT dc.id, dc.voucher_type, dc.ar_number, dc.or_number, dc.pr_number, dc.unit_id, collection_date, sp.sub_property_name, p.property_name, dc.sub_property_id FROM daily_collections dc LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE dc.temp_del = 0 $where ORDER BY dc.id DESC LIMIT ".$qry_start.", ".$qry_limit);
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $data_count++;

												$id = $data['id'];

												if ($data['voucher_type'] == 1) {
													 $number = $data['ar_number'];
												}
												if ($data['voucher_type'] == 2) {
													 $number = $data['or_number'];
												}
												if ($data['voucher_type'] == 3) {
													 $number = $data['pr_number'];
												}

												$sql1 = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE daily_collection_id = :id");
	                                                $sql1->bindParam(":id", $id);
	                                                $sql1->execute();
	                                                $payment_types = array();
	                                                $amounts = array();
	                                                $banks = array();
	                                                $other_banks = array();
                                                    $check_numbers = array();
                                                    $status = array();
                                                    $payment_id = array();
	                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
	                                                    $payment_types[] = $data1['payment_type'];
	                                                    $amounts[] = $data1['amount'];
	                                                    $banks[] = $data1['bank'];
	                                                    $other_banks[] = $data1['other_bank'];
                                                        $check_numbers[] = $data1['check_number'];
                                                        $status[] = $data1['status'];
                                                        $payment_id[] = $data1['id'];
	                                                }

	                                                $unit_ids = explode(',',$data['unit_id']);

                                                echo '<tr class="list-unstyled">';

                                                        // BUILDING
                                                    echo '<td><a href="/daily-collection/'.$id.'">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';


                                                    // UNIT ID
                                                    echo '<td>';
                                                    foreach ($unit_ids as $key => $unit_id) {
                                                        $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                        if(checkVar($unit_name)) {
                                                            echo $unit_name.'<br>';
                                                        } else {
                                                            $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                                            if(checkVar($unit_name)) {
                                                                echo $unit_name.'<br>';
                                                            } else {
                                                                echo $unit_id.'<br>';
                                                            }
                                                        }
                                                    }
                                                    echo '</td>';

                                                    // REFERENCE NUMBER
                                                    echo '<td>'.renderLang($reference_number_arr[$data['voucher_type']]).' ['.$number.']</td>';

                                                   // PAYMENT TYPE
                                                    echo '<td>';
                                                        foreach($payment_types as $payment_type) {
                                                            echo '<li>'.renderLang($payment_types_arr[$payment_type]).'</li>';
                                                        }
                                                    echo '</td>';

                                                    // AMOUNT
                                                    echo '<td>';
                                                        foreach($amounts as $amount) {
                                                            echo '<li>'.$amount.'</li>';
                                                        }
                                                    echo '</td>';

                                                    // CHECK NO
                                                    echo '<td>';
                                                        foreach($check_numbers as $check_number) {
                                                            echo '<li>'.$check_number.'</li>';
                                                        }
                                                    echo '</td>';


                                                    // BANK
                                                    echo '<td>';
                                                        foreach($banks as $key => $bank) {

                                                            if ($bank == '999') {
                                                                echo '<li>'.$other_banks[$key].'</li>';
                                                            }else{

                                                                echo '<li>'.(checkVar($bank) ? renderLang($banks_arr[$bank]) : '').'</li>';

                                                            }
                                                            
                                                        }
                                                    echo '</td>';

                                                    // DATE
                                                    echo '<td>'.formatDate($data['collection_date']).'</td>';

                                                    if(checkPermission('daily-collection-update-status')) {
                                                        // STATUS
                                                        // echo '<td>';
                                                        // foreach($status as $key => $stat) {
                                                        //     echo '<button data-status="'.$stat.'" data-id="'.$payment_id[$key].'" class="btn btn-xs btn-'.$daily_collection_report_collection_status_color_arr[$stat].' btn-status">'.renderLang($daily_collection_report_collection_status_arr[$stat]).'</button><br>';
                                                        // }
                                                        // echo '</td>';
                                                    }

                                                    echo '<td>';
                                                        if(checkPermission('daily-collection-edit')) {

                                                            echo '<a href="/edit-daily-collection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a>';
                                                        }
                                                        $cancelled = getField('status', 'cancelled_collection', 'collection_id = '.$data['id']);
                                                        if(!checkVar($cancelled)) {
                                                            echo '<a href="" title="Cancel Collection" class="btn btn-danger btn-xs btn-cancel" data-id="'.$data['id'].'"><i class="fa fa-ban"></i></a>';
                                                        }
                                                    echo '</td>';

                                                echo '</tr>';
                                            }
                                            
										} else { // employees

                                            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];
                                            $sub_properties = "0";
                                            if(!empty($sub_property_ids)) {
                                                $sub_properties = implode(", ", $sub_property_ids);
                                            }
                                            
                                            $sql = $pdo->prepare("SELECT dc.id, dc.voucher_type, dc.ar_number, dc.or_number, dc.pr_number, dc.unit_id, collection_date, sp.sub_property_name, p.property_name, dc.sub_property_id FROM daily_collections dc LEFT JOIN units u ON (dc.unit_id = u.id) LEFT JOIN sub_properties sp ON (dc.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE dc.temp_del = 0 AND dc.sub_property_id IN ($sub_properties) $where ORDER BY dc.id DESC LIMIT ".$qry_start.", ".$qry_limit);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        
                                                    $data_count++;
                                                    $id = $data['id'];

                                                    if ($data['voucher_type'] == 1) {
                                                        $number = $data['ar_number'];
                                                    }
                                                    if ($data['voucher_type'] == 2) {
                                                            $number = $data['or_number'];
                                                    }
                                                    if ($data['voucher_type'] == 3) {
                                                            $number = $data['pr_number'];
                                                    }
                                                    
                                                    $sql1 = $pdo->prepare("SELECT * FROM daily_collections_payment_types WHERE daily_collection_id = :id");
                                                    $sql1->bindParam(":id", $id);
                                                    $sql1->execute();
                                                    $payment_types = array();
                                                    $amounts = array();
                                                    $banks = array();
                                                    $other_banks = array();
                                                    $check_numbers = array();
                                                    $status = array();
                                                    $payment_id = array();
                                                    while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                        $payment_types[] = $data1['payment_type'];
                                                        $amounts[] = $data1['amount'];
                                                        $banks[] = $data1['bank'];
                                                        $other_banks[] = $data1['other_bank'];
                                                        $check_numbers[] = $data1['check_number'];
                                                        $status[] = $data1['status'];
                                                        $payment_id[] = $data1['id'];
                                                    }

                                                    $unit_ids = explode(',',$data['unit_id']);

                                                    echo '<tr>';

                                                        // BUILDING
                                                        echo '<td><a href="/daily-collection/'.$id.'">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';


                                                        // UNIT ID
                                                        echo '<td>';
                                                        foreach ($unit_ids as $key => $unit_id) {
                                                            $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                            if(checkVar($unit_name)) {
                                                                echo $unit_name.'<br>';
                                                            } else {
                                                                $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$data['sub_property_id']);
                                                                if(checkVar($unit_name)) {
                                                                    echo $unit_name.'<br>';
                                                                } else {
                                                                    echo $unit_id.'<br>';
                                                                }
                                                            }
                                                        }
                                                        echo '</td>';

                                                        // REFERENCE NUMBER
                                                        echo '<td>'.renderLang($reference_number_arr[$data['voucher_type']]).' ['.$number.']</td>';

                                                        // PAYMENT TYPE
                                                        echo '<td>';
                                                            foreach($payment_types as $payment_type) {
                                                                echo '<li>'.renderLang($payment_types_arr[$payment_type]).'</li>';
                                                            }
                                                        echo '</td>';

                                                        // AMOUNT
                                                        echo '<td>';
                                                            foreach($amounts as $amount) {
                                                                echo '<li>'.$amount.'</li>';
                                                            }
                                                        echo '</td>';

                                                        // CHECK NO
                                                        echo '<td>';
                                                            foreach($check_numbers as $check_number) {
                                                                echo '<li>'.$check_number.'</li>';
                                                            }
                                                        echo '</td>';


                                                        // BANK
                                                        echo '<td>';
                                                            foreach($banks as $key => $bank) {

                                                                if ($bank == '999') {
                                                                    echo '<li>'.$other_banks[$key].'</li>';
                                                                }else{

                                                                    echo '<li>'.(checkVar($bank) ? renderLang($banks_arr[$bank]) : '').'</li>';

                                                                }
                                                                
                                                            }
                                                        echo '</td>';

                                                        // DATE
                                                        echo '<td>'.formatDate($data['collection_date']).'</td>';

                                                        if(checkPermission('daily-collection-update-status')) {
                                                            // // STATUS
                                                            // echo '<td>';
                                                            // foreach($status as $key => $stat) {
                                                            //     echo '<button data-status="'.$stat.'" data-id="'.$payment_id[$key].'" class="btn btn-xs btn-'.$daily_collection_report_collection_status_color_arr[$stat].' btn-status">'.renderLang($daily_collection_report_collection_status_arr[$stat]).'</button><br>';
                                                            // }
                                                            // echo '</td>';
                                                        }

                                                        if(checkPermission('daily-collection-edit')) {

                                                            // if(strtotime($current_date) <= strtotime($data['collection_date'])) {
    
                                                                echo '<td><a href="/edit-daily-collection/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collections_edit_daily_collection).'"><i class="fa fa-pencil-alt"></i></a></td>';
    
                                                            // } else {
                                                            //     echo '<td></td>';
                                                            // }
                                                        }

                                                    echo '</tr>';
                                                    
                                                }
                                            }
										}
										?>
									</tbody>
								</table>
							</div><!-- table-responsive -->

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination.php"); ?>

						</div><!-- card body -->
						<div class="card-footer text-right">
							<a href="/collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
						</div>
					</div><!-- card -->
					
				</div><!-- container-fluid -->
			</section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title"><?php echo renderLang($cancelled_collections_cancel); ?></h4>
                </div>
                <form action="/cancel-collection" method="post" id="cancelled_form" enctype="multipart/form-data">
                    <input type="hidden" name="collection_id" id="collection_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cancelled_attachment"><?php echo renderLang($lang_attachment); ?></label>
                                    <input type="file" class="form-control" name="cancelled_attachment" id="cancelled_attachment">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times mr-2"></i><?php echo renderLang($modal_cancel); ?></button>
                        <button class="btn btn-primary"><i class="fa fa-ban mr-1"></i><?php echo renderLang($cancelled_collections_cancel); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal -->

	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
  	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script>
	$(function(){

        // cancel collection
        $('body').on('click', '.btn-cancel', function(e) {
            e.preventDefault();
            var collection_id = $(this).data('id');
            $('#collection_id').val(collection_id);
            $('#cancelled_attachment').val("");
            $('#modal-cancel').modal("show");
        });

        $('#cancelled_form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response){
                    switch(response) {
                        case 'success':
                            window.location.reload();
                            break;
                        case 'error':
                            alert(response);
                            break;
                        case 'invalid-permission':
                            window.location.href = '/dashboard';
                            break;
                        case 'no-session':
                            window.location.href = '/';
                            break;
                    }
                }
            });
        });

        // date range
        $('.date-range').each(function(){
            $(this).daterangepicker({
                singleDatePicker: false,
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
        });

        // date range filter
        $('#date-range-filter').on('change', function(){
            var dt = $(this).val().replace(' ', "").replace(' ', "");
            var currUrl = $(location).attr("href");
            var currUrl_arr = currUrl.split('?');
            var newUrl = currUrl_arr[0];
            if (typeof (getUrlParameter('page')) != 'undefined') {
                newUrl += '?page=' + getUrlParameter('page');
                if(typeof (getUrlParameter('k')) != 'undefined') {
                    newUrl += '&k=' + getUrlParameter('k');
                }
            } else {
                if(typeof (getUrlParameter('k')) != 'undefined') {
                    newUrl += '?page=1&k=' + getUrlParameter('k');
                }
            }
            if(newUrl.includes("?")) {
                if(dt != '') {
                    newUrl += '&dt=' + encodeURIComponent(dt);
                }
            } else {
                if(dt != '') {
                    newUrl += '?dt=' + encodeURIComponent(dt);
                }
            }
            window.location.href = newUrl;
        });

		$('#table-data').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
        });

		// remove sorting in column
        $('.no-sort').each(function(){
            $(this).removeClass('sorting');
        });

        // change status
        $('body').on('click', '.btn-status', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var status = $(this).data('status');
            var payment_status = <?php echo json_encode($daily_collection_report_collection_status_arr); ?>;

            var stat = 0;
            if($(this).hasClass('btn-secondary')) {
                $(this).attr("data-status", 1);
                stat = 1;
            } else {
                $(this).attr("data-status", 0);
                stat = 0;
            }

            showLoading();

            $.post('/update-daily-collection-status', {
                id:id, status:stat
            }, function(data){
                if(data == 'no-session') {
                    window.location.href = '/';
                }
                if(data == 'invalid-permission') {
                    window.location.href = '/dashboard';
                }
                
                hideLoading();
            });   

            $(this).toggleClass('btn-success').toggleClass('btn-secondary');
            $(this).html(payment_status[stat][<?php echo $_SESSION['sys_language']; ?>]); 

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