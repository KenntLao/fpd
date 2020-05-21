<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
    
    // check permission to access this page or function
    if(checkPermission('permits-licences-add')) {

    $page = 'permits-and-licences';
    
    $property_id = $_GET['id'];

    // get prospect id
    $property_property_name = getField('property_name', 'properties', 'id = '.$property_id);
    $prospect_id = getField('id', 'prospecting', 'project_name = "'.$property_property_name.'"');
    $prospect_id = checkVar($prospect_id) ? $prospect_id : 0;

    $id = 0;
    $sql = $pdo->prepare("SELECT * FROM operation_permits WHERE property_id = :id AND temp_del = 0 LIMIT 1");
    $sql->bindParam(":id", $property_id);
    $sql->execute();
    if($sql->rowCount()) {
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $id = $_data['id'];
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($permits_and_licences); ?> &middot; <?php echo $sitename; ?></title>
    
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
                            <h1><i class="far fa-building mr-3"></i><?php echo renderLang($permits_and_licences); ?></h1>
                        </div>
                    </div>
                    
                </div><!-- container-fluid -->
            </section><!-- content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">

                    <?php 
                    renderSuccess('sys_permit_licences_add_suc');
                    renderError('sys_permit_licences_add_err');
                    ?>

                    <form action="/submit-add-permits-and-licences" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($permits_and_licences_form); ?></h3>
                            </div>
                            <div class="card-body">

                                <!-- PROPERTY -->
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-2">
                                        <div class="form-group">
                                            <label for="property"><?php echo renderLang($properties_property); ?></label>
                                            <select name="property" id="property" class="form-control select2">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM properties WHERE temp_del = 0");
                                                $sql->execute();
                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                    if($_SESSION['sys_account_mode'] == 'user') {
                                                        echo '<option '.($property_id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                    }

                                                    if($_SESSION['sys_account_mode'] == 'employee') {

                                                        $property_ids = getField('property_ids', 'employees', 'id = '.$_SESSION['sys_id']);
                                                        $property_ids = explode(',', $property_ids);

                                                        if(in_array($data['id'], $property_ids)) {
                                                            echo '<option '.($property_id == $data['id'] ? 'selected' : '').' value="'.$data['id'].'">'.$data['property_name'].'</option>';
                                                        }

                                                    }
                                                        
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- PERMITS & LICENCES -->
                                <?php 
                                foreach ($permits_and_licences_arr as $key => $permits) {
                                ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-center">
                                                <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-<?php echo $key; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($permits); ?></button>
                                            </p>
                                            <div class="collapse" id="tab-<?php echo $key; ?>">

                                                <div class="card card-body">

                                                    <div class="row">
                                                        <div class="col-12 table-responsive mh500p">
                                                            <table class="table table-bordered table-hover table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo renderLang($permits_and_licences_permits); ?></th>
                                                                        <th><?php echo renderLang($permits_and_licences_permit_number); ?></th>
                                                                        <th><?php echo renderLang($permits_and_licences_date_issued); ?></th>
                                                                        <th><?php echo renderLang($permits_and_licences_status_remarks); ?></th>
                                                                        <th><?php echo renderLang($permits_and_licences_last_date_submitted); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM permits_and_licences WHERE module = 'task-permits-and-licences' AND category = :category");
                                                                    $sql->bindParam(":category", $permits[0]);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                        if($id != 0) {
                                                                            $sql1 = $pdo->prepare("SELECT * FROM operation_permits_licences WHERE permit_id = :id AND permit_licences_id = :licence_id");
                                                                            $sql1->bindParam(":id", $id);
                                                                            $sql1->bindParam(":licence_id", $data['id']);
                                                                            $sql1->execute();
                                                                            $data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                                                                            echo '<tr>';

                                                                                echo '<td>';
                                                                                    echo '<p>'.$data['name'].'</p>';
                                                                                    echo '<input type="hidden" name="permit_id[]" value="'.$data['id'].'">';
                                                                                echo '</td>';

                                                                                echo '<td><input type="text" name="permit_number[]" class="form-control border-0" value="'.$data1['permit_number'].'"></td>';

                                                                                echo '<td><input type="text" name="date_issued[]" class="form-control border-0 date" value="'.formatDate($data1['date_issued']).'"></td>';

                                                                                echo '<td><textarea name="remarks[]" class="form-control notes border-0" row="2">'.$data1['remarks'].'</textarea></td>';

                                                                                echo '<td><input type="text" name="date_submitted[]" class="form-control border-0 date" value="'.formatDate($data1['date_submitted']).'"></td>';

                                                                            echo '</tr>';

                                                                        } else {

                                                                            echo '<tr>';

                                                                                echo '<td>';
                                                                                    echo '<p>'.$data['name'].'</p>';
                                                                                    echo '<input type="hidden" name="permit_id[]" value="'.$data['id'].'">';
                                                                                echo '</td>';

                                                                                echo '<td><input type="text" name="permit_number[]" class="form-control border-0"></td>';

                                                                                echo '<td><input type="text" name="date_issued[]" class="form-control border-0 date"></td>';

                                                                                echo '<td><textarea name="remarks[]" class="form-control notes border-0" row="2"></textarea></td>';

                                                                                echo '<td><input type="text" name="date_submitted[]" class="form-control border-0 date"></td>';

                                                                            echo '</tr>';

                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- TSA PERMITS & LICENCES -->
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-center">
                                                <button class="btn w100pc pms-red text-white" type="button"  data-toggle="collapse" data-target="#tab-tsa" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($permits_and_licences_tsa); ?></button>
                                            </p>
                                            <div class="collapse" id="tab-tsa">

                                                <div class="card card-body">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo renderLang($permits_and_licences_permits); ?></th>
                                                                    <th><?php echo renderLang($lang_status); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $tsa_id = !empty($prospect_id) ? getField('id', 'pre_operation_audit_tsa', 'prospect_id = '.$prospect_id) : 0;
                                                                $sql = $pdo->prepare("SELECT * FROM permits_and_licences WHERE module = 'pre-operation-audit-tsa' AND temp_del = 0");
                                                                $sql->execute();
                                                                while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                    $sql1 = $pdo->prepare("SELECT * FROM pre_operation_audit_tsa_permit_licences WHERE tsa_id = :tsa_id AND particulars = :id LIMIT 1");
                                                                    $sql1->bindParam(":tsa_id", $tsa_id);
                                                                    $sql1->bindParam(":id", $data['id']);
                                                                    $sql1->execute();
                                                                    $data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                                                                    echo '<tr>';

                                                                        echo '<input type="hidden" name="tsa_licence_id[]" value="'.(isset($data1['id']) ? $data1['id'] : 0).'">';

                                                                        echo '<td>';
                                                                            echo '<p>'.$data['name'].'</p>';
                                                                            echo '<input type="hidden" name="permits_licences_id[]" value="'.$data['id'].'">';
                                                                        echo '</td>';

                                                                        echo '<td>';
                                                                            echo '<textarea class="form-control notes border-0" name="tsa_licence_status[]">'.$data1['status'].'</textarea>';
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
                                    </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="/permits-and-licences-list" class="btn btn-default"><i class="fa fa-arrow-left mr-1"></i><?php echo renderLang($btn_back); ?></a>
                                <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($permits_and_licences_save_permit_and_licences); ?></button>
                            </div>
                        </div>

                    </form>

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