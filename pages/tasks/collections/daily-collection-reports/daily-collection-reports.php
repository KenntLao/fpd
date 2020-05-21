<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('daily-collection-reports')) {
	
		// clear sessions from forms
		clearSessions();

		// set page
        $page = 'collections';

        $page_href = "daily-collection-reports";
        $fields_arr = array('sub_property_name','property_name'); // fields to search
        $date_fields_arr = array('report_date');
        $search_placeholder = renderLang($daily_collections_daily_collection_building); // search placeholder
        // set search
        include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-config.php");

        $total_row = 50;
        if($_SESSION['sys_account_mode'] == "user") {
            $total_row = getField('count(dcr.id)', 'daily_collection_reports dcr LEFT JOIN sub_properties sp ON(dcr.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id)', 'dcr.temp_del = 0 '.$where);
        } else {
            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];
            $sub_properties = "0";
            if(!empty($sub_property_ids)) {
                $sub_properties = implode(", ", $sub_property_ids);
            }
            $sql = $pdo->prepare("SELECT count(dcr.id) FROM daily_collection_reports dcr LEFT JOIN sub_properties sp ON(dcr.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dcr.temp_del = 0 AND dcr.sub_property_id IN ($sub_properties) $where");
            $sql->execute();
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $total_row = $data['count(dcr.id)'];
        }

        include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination-config.php");
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($daily_collection_reports); ?> &middot; <?php echo $sitename; ?></title>
	
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
							<h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($daily_collection_reports); ?></h1>
						</div>
					</div>

				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php 
					renderSuccess('sys_daily_collection_report_add_suc');
                    renderError('sys_daily_collection_report_edit_err');
                    renderSuccess('sys_daily_collection_report_edit_suc');
					?>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"></h3>
							<div class="card-tools">
								<a href="/daily-collection-report-add" class="btn btn-danger"><i class="fa fa-plus mr-1"></i><?php echo renderLang($daily_collection_report_add); ?></a>
							</div>
						</div>
						<div class="card-body">

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/search-filter.php"); ?>

							<div class="table-responsive">
								<table class="table table-bordered table-hover table-condensed" id="table-data">
									<thead>
										<tr>
											<th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
											<th><?php echo renderLang($daily_collection_report_date); ?></th>
											<th><?php echo renderLang($daily_collection_date); ?></th>
											<th><?php echo renderLang($daily_collection_report_grand_total); ?></th>
											<th><?php echo renderLang($daily_collection_report_prepared_by); ?></th>
											<th><?php echo renderLang($lang_status); ?></th>
                                            <?php if(checkPermission('daily-collection-report-edit')) { ?>
											    <th class="w35 no-sort p-0"></th>
                                            <?php } ?>
										</tr>
									</thead>
									<tbody>
                                        <?php 
                                        $data_count = 0;
										if($_SESSION['sys_account_mode'] == 'user') {

											$sql = $pdo->prepare("SELECT dcr.id, sub_property_name, property_name, report_date, collection_date, grand_total, prepared_by, prepared_by_account_mode, dcr.status FROM daily_collection_reports dcr LEFT JOIN sub_properties sp ON(dcr.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dcr.temp_del = 0 $where ORDER BY dcr.report_date DESC LIMIT ".$qry_start.", ".$qry_limit);
											$sql->execute();
											while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                $data_count++;

												echo '<tr>';
													// sub_property
													echo '<td><a href="/daily-collection-report/'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';
													// report date
													echo '<td>'.formatDate($data['report_date']).'</td>';
													// collection date
													echo '<td>'.formatDate($data['collection_date']).'</td>';
													// grand total
													echo '<td class="grand-totals">'.$data['grand_total'].'</td>';
													// prepared by
													echo '<td>';
														if($data['prepared_by_account_mode'] == 'user') {
															echo getFullName($data['prepared_by'], 'user');
														} else {
															$code_name  = getField('code_name', 'employees', 'id = '.$data['prepared_by']);
															if(checkVar($code_name)) {
																echo '['.$code_name.']'.getFullName($data['prepared_by'], 'employee');
															} else {
																echo getFullName($data['prepared_by'], 'employee');
															}
														}
													echo '</td>';
													// status
													echo '<td class="text-center">';
														echo '<span class="badge badge-'.$daily_collection_report_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_status_arr[$data['status']]).'</span>';
													echo '</td>';
													// edit
													if(checkPermission('daily-collection-report-edit')) {
                                                        echo '<td>';
                                                            if($data['status'] == 0) {
                                                                echo '<a href="/daily-collection-report-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collection_report_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                            }
														echo '</td>';
													}
												echo '</tr>';
											}

                                        } else { // employees
                                            
                                            $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];
                                            $sub_properties = "0";
                                            if(!empty($sub_property_ids)) {
                                                $sub_properties = implode(", ", $sub_property_ids);
                                            }

                                            $sql = $pdo->prepare("SELECT dcr.id, sub_property_name, property_name, report_date, collection_date, grand_total, prepared_by, prepared_by_account_mode, dcr.status FROM daily_collection_reports dcr LEFT JOIN sub_properties sp ON(dcr.sub_property_id = sp.id) LEFT JOIN properties p ON(sp.property_id = p.id) WHERE dcr.temp_del = 0 AND dcr.sub_property_id IN ($sub_properties) $where ORDER BY dcr.report_date DESC LIMIT ".$qry_start.", ".$qry_limit);
                                            $sql->execute();
                                            if($sql->rowCount()) {
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    $data_count++;

                                                    echo '<tr>';
                                                        // sub_property
                                                        echo '<td><a href="/daily-collection-report/'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</a></td>';
                                                        // report date
                                                        echo '<td>'.formatDate($data['report_date']).'</td>';
                                                        // collection date
                                                        echo '<td>'.formatDate($data['collection_date']).'</td>';
                                                        // grand total
                                                        echo '<td class="grand-totals">'.$data['grand_total'].'</td>';
                                                        // prepared by
                                                        echo '<td>';
                                                            if($data['prepared_by_account_mode'] == 'user') {
                                                                echo getFullName($data['prepared_by'], 'user');
                                                            } else {
                                                                $code_name  = getField('code_name', 'employees', 'id = '.$data['prepared_by']);
                                                                if(checkVar($code_name)) {
                                                                    echo '['.$code_name.']'.getFullName($data['prepared_by'], 'employee');
                                                                } else {
                                                                    echo getFullName($data['prepared_by'], 'employee');
                                                                }
                                                            }
                                                        echo '</td>';
                                                        // status
                                                        echo '<td class="text-center">';
                                                            echo '<span class="badge badge-'.$daily_collection_report_status_color_arr[$data['status']].'">'.renderLang($daily_collection_report_status_arr[$data['status']]).'</span>';
                                                        echo '</td>';
                                                        // edit
                                                        if(checkPermission('daily-collection-report-edit')) {
                                                            echo '<td>';
                                                                if($data['status'] == 0) {
                                                                    echo '<a href="/daily-collection-report-edit/'.$data['id'].'" class="btn btn-success btn-xs" title="'.renderLang($daily_collection_report_edit).'"><i class="fa fa-pencil-alt"></i></a>';
                                                                }
                                                            echo '</td>';
                                                        }
                                                    echo '</tr>';
                                                }
                                            }

										}
										?>
									</tbody>
								</table>
							</div>

                            <?php include($_SERVER['DOCUMENT_ROOT']."/includes/common/pagination.php"); ?>

                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <label for="total" class="text-uppercase"><?php echo renderLang($lang_total); ?></label>
                                    <input type="text" class="form-control input-readonly" id="total" readonly>
                                </div>
                            </div>

						</div>
						<div class="card-footer text-right">
							<a href="/collections" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
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
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){

        // compute total
        var total = 0;
        $('.grand-totals').each(function(){
            var grand_total = convertCurrency($(this).html());
            total += grand_total;
        });
        $('#total').val(convert_to_currency(total.toFixed(3), "blur"));

        // data tables
        $('#table-data').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
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