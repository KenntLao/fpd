<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
    
    // check permission to access this page or function
    if(checkPermission('pdc')) {
    
        // clear sessions from forms
        clearSessions();

        // set page
        $page = 'collections';

        $id = $_GET['id'];
        $date = $_GET['date'];

        // full name
        $current_user_full_name = getFullName($_SESSION['sys_id'], $_SESSION['sys_account_mode']);
    
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($pdc_add); ?> &middot; <?php echo $sitename; ?></title>
    
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
                            <h1><i class="fas fa-tasks mr-3"></i><?php echo renderLang($pdc_add); ?></h1>
                        </div>
                    </div>

                </div><!-- container-fluid -->
            </section><!-- content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?php 
                    renderError('sys_daily_collection_report_add_err');
                    ?>

                    <form action="/submit-pdc-add" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($pdc_add_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id" class="mr-1"><?php echo renderLang($daily_collections_daily_collection_building); ?></label>
                                            <span class="right badge badge-danger"><?php echo renderLang($label_required); ?></span>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2 required">
                                                <option value=""></option>
                                            <?php 
                                            if($_SESSION['sys_account_mode'] == 'user') {

                                                $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option '.($id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                }

                                            } else { // employees
                                                
                                                $cluster_ids = getClusterIDs($_SESSION['sys_id']);

                                                // no cluster
                                                if(empty($cluster_ids)) {

                                                    $sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                    $sub_properties = explode(',', $sub_property_ids);
                                                    foreach($sub_properties as $sub_property_id) {
                                                        $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0 AND sp.id = :id");
                                                        $sql->bindParam(":id", $sub_property_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                            }
                                                        }
                                                    }

                                                } else {

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

                                                    // get user assigned sub_properties
                                                    foreach($sub_property_ids as $sub_property_id) {

                                                        $sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0 AND sp.id = :id");
                                                        $sql->bindParam(":id", $sub_property_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<option value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
                                                            }
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
                                            <label for="report_date"><?php echo renderLang($daily_collection_report_date); ?></label>
                                            <input type="text" class="form-control input-readonly" name="report_date" id="report_date" value="<?php echo formatDate(time(), true); ?>" readonly>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="collection_date"><?php echo renderLang($daily_collection_date); ?></label>
                                            <input type="text" class="form-control date" id="date" name="collection_date" value="<?php echo $date; ?>">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-12">
                                        <label><?php echo renderLang($pdc_dated_checks_for_deposit); ?></label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed">
                                                <thead>
                                                    <tr class="bg-gray text-center">
                                                        <th><?php echo renderLang($lang_date); ?></th>
                                                        <th><?php echo renderLang($pdc_pr_number); ?></th>
                                                        <th><?php echo renderLang($pdc_unit_number); ?></th>
                                                        <th><?php echo renderLang($pdc_payor); ?></th>
                                                        <th><?php echo renderLang($daily_collection_report_particulars); ?></th>
                                                        <th><?php echo renderLang($pdc_amount); ?></th>
                                                        <th><?php echo renderLang($pdc_date_on_check); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT dcpt.amount, dcpt.date_of_check, dc.id, dc.pr_number, dc.unit_id, dc.particulars, dc.collection_date, dc.sub_property_id FROM daily_collections dc LEFT JOIN sub_properties sp ON (sp.id = dc.sub_property_id) LEFT JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.sub_property_id = :id AND dc.collection_date = :dates AND voucher_type = 3 AND dc.temp_del = 0");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->bindParam(":dates", $date);
                                                    $sql->execute();
                                                    while ($_data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        echo '<tr class="text-center">';

                                                        echo '<td>'.$_data['collection_date'].'</td>';
                                                        echo '<td>'.$_data['pr_number'].'</td>';
                                                        // unit
                                                        echo '<td>';
                                                            $unit_names = array();
                                                            $unit_ids = explode(',', $_data['unit_id']);
                                                            foreach($unit_ids as $unit_id) {
                                                                $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                if(checkVar($unit_name)) {
                                                                    $unit_names[] = $unit_name;
                                                                } else {
                                                                    $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$_data['sub_property_id']);
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
                                                        echo '<td></td>';
                                                        echo '<td>'.$_data['particulars'].'</td>';
                                                         // AMOUNT
                                                        echo '<td>'.$_data['amount'].'<input type="hidden" class="pr_amount" name="amount[]"  value="'.$_data['amount'].'"></td>';
                                                        echo '<td>'.$_data['date_of_check'].'</td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td>
                                                            <label for="report_date" class="text-left">Total :</label>
                                                            <input type="text" class="form-control text-center input-readonly border-0" id="amount" name="total" readonly>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 ml-auto">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="col-12">
                                        <label><?php echo renderLang($pdc_monitoring); ?></label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed text-center">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_date); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_pr_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_unit_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_payor); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($daily_collection_report_particulars); ?></p></th>
                                                        <th colspan="3" class="bg-gray"><?php echo renderLang($pdc_check_details); ?></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_date_deposited); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_receipt_type); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($pdc_receipt_number); ?></p></th>
                                                        <th rowspan="2"><p class="w100"><?php echo renderLang($lang_status); ?></p></th>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo renderLang($pdc_amount); ?></th>
                                                        <th><?php echo renderLang($pdc_bank_check_number); ?></th>
                                                        <th><?php echo renderLang($pdc_date_on_check); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT dcpt.amount, dcpt.date_of_check, dc.id, voucher_type, dcpt.status, bank, check_number, dc.pr_number, dc.unit_id, dc.particulars, dc.collection_date, sub_property_id FROM daily_collections dc LEFT JOIN sub_properties sp ON (sp.id = dc.sub_property_id) LEFT JOIN daily_collections_payment_types dcpt ON (dc.id = dcpt.daily_collection_id) WHERE dc.sub_property_id = :id AND dc.collection_date = :dates AND voucher_type = 3 AND dc.temp_del = 0");
                                                    $sql->bindParam(":id",$id);
                                                    $sql->bindParam(":dates", $date);
                                                    $sql->execute();
                                                    while ($_data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                        echo '<tr>';

                                                            echo '<td>'.$_data['collection_date'].'</td>';
                                                            echo '<td>'.$_data['pr_number'].'</td>';
                                                            // unit
                                                            echo '<td>';
                                                                $unit_names = array();
                                                                $unit_ids = explode(',', $_data['unit_id']);
                                                                foreach($unit_ids as $unit_id) {
                                                                    $unit_name = getField('unit_name', 'units', 'id = "'.$unit_id.'"');
                                                                    if(checkVar($unit_name)) {
                                                                        $unit_names[] = $unit_name;
                                                                    } else {
                                                                        $unit_name = getField('unit_name', 'units', 'unit_name = "'.$unit_id.'" AND sub_property_id = '.$_data['sub_property_id']);
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
                                                            
                                                            echo '<td></td>';
                                                            echo '<td>'.$_data['particulars'].'</td>';
                                                            // AMOUNT
                                                            echo '<td>'.$_data['amount'].'</td>';
                                                            echo '<td>'.(checkVar($_data['bank']) ? renderLang($banks_arr[$_data['bank']]) : '').'/';
                                                            echo (checkVar($_data['check_number']) ? $_data['check_number'] : '').'</td>';
                                                            echo '<td>'.formatDate($_data['date_of_check']).'</td>';
                                                            echo '<td></td>';
                                                            echo '<td>'.renderLang($reference_number_arr[$_data['voucher_type']]).'</td>';
                                                            echo '<td><input type="text" name="receipt_no[]" class="form-control border-0"></td>';
                                                            // STATUS
                                                            echo '<td>';
                                                                echo '<button data-status="'.$_data['status'].'" data-id="'.$_data['status'].'" class="btn btn-xs btn-'.$daily_collection_report_collection_status_color_arr[$_data['status']].' btn-status">'.renderLang($daily_collection_report_collection_status_arr[$_data['status']]).'</button><br>';
                                                            echo '</td>';

                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <br>

                                <div class="row mt-5">

                                    <div class="col-lg-3 col-md-4">
                                        <label for="prepared_by"><?php echo renderLang($pdc_updated_by); ?></label>
                                        <input type="text" class="form-control input-readonly" name="prepared_by" value="<?php echo $current_user_full_name; ?>" readonly>
                                        <p>Cashier</p>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <label for="date_time"><?php echo renderLang($pdc_date_time); ?></label>
                                        <input type="text" class="form-control direct-chat-timestamp input-readonly" name="date_time" value="<?php echo formatDate(time(), true, false, true); ?>" readonly>
                                    </div>
                                    
                                </div><!-- row -->

                                <!-- Status -->
                                <div class="row mt-2">
                                    <div class="col-12 text-right">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="save-status" name="status" value="0">
                                            <label for="save-status"><?php echo renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/pdc-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary" id="save-button"><i class="fa fa-upload mr-1"></i><?php echo renderLang($lang_save_as_draft); ?></button>
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

        $('.date').each(function(){
            $(this).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

         $('#date, #sub_property_id').on('change', function(){
            var id = $('#sub_property_id').val();
            var date = $('#date').val();
            window.location.href = '/add-pdc/'+date+'-'+id;
        });

         // compute total bill
            var total = 0;
            $('.pr_amount').each(function(){
                var amount = $(this).val();
                amount = convertCurrency(amount);
                
                total += amount;
                
                $('#amount').val(convert_to_currency(total, "blur"));

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