<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
    
    // check permission to access this page or function
    if(checkPermission('power-and-grounding-wiring-add')) {

    $page = 'inspections';

    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM task_inspection_engineering_checklist WHERE id = :id");
    $sql->bindParam(":id",$id);
    $sql->execute();
    if($sql->rowCount()) {
            
        $_data = $sql->fetch(PDO::FETCH_ASSOC);

    } else {
        $_SESSION['sys_proper_installation_inspection_err'] = renderLang($lang_no_data);
        header('location: /proper-installation-inspection-list');
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($inspection_add_proper_installation_inspection); ?> &middot; <?php echo $sitename; ?></title>
    
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
                            <h1><i class="far fa-building mr-3"></i><?php echo renderLang($inspection_add_proper_installation_inspection); ?></h1>
                        </div>
                    </div>
                    
                </div><!-- container-fluid -->
            </section><!-- content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">

                    <!-- <form action="submit-add-engineering-inspection" method="post"> -->

                        <input type="hidden" name="category" value="1">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($inspection_add_proper_installation_inspection_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="sub_property_id"><?php echo renderLang($inspection_building); ?></label>
                                            <select name="sub_property_id" id="sub_property_id" class="form-control select2">
                                            <?php 
											if($_SESSION['sys_account_mode'] == 'user') {

												$sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0");
												$sql->execute();
												while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
													echo '<option '.($_data['sub_property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
												}

											} else {

												$sub_property_ids = getField('sub_property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
												$sub_properties = explode(',', $sub_property_ids);
												foreach($sub_properties as $sub_property_id) {
													$sql = $pdo->prepare("SELECT sp.id, sub_property_name, property_name FROM sub_properties sp LEFT JOIN properties p ON(sp.property_id = p.id) WHERE sp.temp_del = 0 AND p.temp_del = 0 AND sp.id = :id");
													$sql->bindParam(":id", $sub_property_id);
													$sql->execute();
													if($sql->rowCount()) {
														while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
															echo '<option '.($_data['sub_property_id'] == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['sub_property_name'].' ['.$data['property_name'].']</option>';
														}
													}
												}
												
											}
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-4">
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="work_reference_no"><?php echo renderLang($inspection_sheet_work_ref_no); ?></label>
                                            <input type="text" class="form-control" name="work_reference_no" value="<?php echo $_data['work_reference_no']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="rated_v_and_i"><?php echo renderLang($inspection_sheet_rated_v_i); ?></label>
                                            <input type="text" class="form-control" name="rated_v_and_i" value="<?php echo $_data['rated_v_and_i']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="customer"><?php echo renderLang($inspection_sheet_customer); ?></label>
                                            <input type="text" class="form-control" name="customer" value="<?php echo $_data['customer']; ?>">
                                        </div>
                                    </div>

                                </div>

                                <?php foreach($proper_installation_sheet_arr as $key => $inspections) { ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <label><?php echo renderLang($inspections[1]); ?></label>

                                            <?php if($key == 0) { ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="w75"><?php echo renderLang($inspection_sheet_item_no); ?></th>
                                                                <th><?php echo renderLang($inspection_sheet_criteria); ?></th>
                                                                <th><?php echo renderLang($lang_status); ?></th>
                                                                <th><?php echo renderLang($inspection_sheet_remarks); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($inspections[2] as $key2 => $value2) {?>
                                                            <?php 
                                                                $sql1 = $pdo->prepare("SELECT * FROM task_inspection_engineer_general_and_function_check WHERE engineering_id = :id AND item_no = :key");
                                                                $sql1->bindParam(":id",$id);
                                                                $sql1->bindParam(":key",$key2);
                                                                $sql1->execute();
                                                                $_data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                                             ?>
                                                            <tr>
                                                                <td><input type="hidden" name="item_no[]" value="<?php echo $key2; ?>"></td>
                                                                <td><p><?php echo renderLang($value2); ?></p><input type="hidden" name="criteria[]" value="<?php echo renderLang($value2); ?>"></td>
                                                                <td><input type="text" class="form-control border-0" name="status[]" value="<?php echo $_data1['status']; ?>"></td>
                                                                <td><input type="text" class="form-control border-0" name="remarks[]" value="<?php echo $_data1['remarks']; ?>"></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row mt-5">
                                    <div class="form-group col-lg-9 col-md-12">
                                        <label for="test_equipment_used"><?php echo renderLang($inspection_sheet_test_equipment_used); ?></label>
                                        <input type="text" class="form-control" name="test_equipment_used" value="<?php echo $_data['test_equipment_used']; ?>">
                                    </div>
                                </div>
                                                    
                                <div class="row">
                                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="inspected_by"><?php echo renderLang($inspection_sheet_inspected_by); ?></label>
                                            <input type="text" class="form-control" name="inspected_by" value="<?php echo $_data['inspected_by']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="inspected_date"><?php echo renderLang($inspection_sheet_date); ?></label>
                                            <input type="text" class="form-control date" name="inspected_date" value="<?php echo $_data['inspected_date']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="inspected_time"><?php echo renderlang($inspection_sheet_time); ?></label>
                                            <input type="time" class="form-control" name="inspected_time" value="<?php echo $_data['inspected_time']; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                                    
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="checked_by"><?php echo renderLang($inspection_sheet_checked_by); ?></label>
                                            <input type="text" class="form-control" name="checked_by" value="<?php echo $_data['checked_by']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="checked_date"><?php echo renderLang($inspection_sheet_date); ?></label>
                                            <input type="text" class="form-control date" name="checked_date" value="<?php echo $_data['checked_date']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="checked_time"><?php echo renderlang($inspection_sheet_time); ?></label>
                                            <input type="time" class="form-control" name="checked_time" value="<?php echo $_data['checked_time']; ?>">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/proper-installation-inspection-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <!-- <button class="btn btn-primary"><i class="fa fa-upload mr-1"></i><?php echo renderLang($inspection_add_inspection); ?></button> -->
                            </div>
                        </div>

                    <!-- </form> -->

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