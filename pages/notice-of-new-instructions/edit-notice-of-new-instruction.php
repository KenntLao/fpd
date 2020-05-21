<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
    
    // check permission to access this page or function
    if(checkPermission('notice-of-new-instruction-edit')) {

        // set page
        $page = 'notice-of-new-instructions';
        
        $curr_date = date('ymd');

        $prospect_id = $_GET['id'];

        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");

        $sql->bindParam(":id",$prospect_id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        $_SESSION['sys_nni_add_owner_developer_val'] = $_data['owner_developer'];
        $_SESSION['sys_nni_add_location_val'] = $_data['location'];
        $_SESSION['sys_nni_add_property_category_val'] = $_data['property_category'];
        $_SESSION['sys_nni_add_contact_person_val'] = $_data['contact_person'];
        $_SESSION['sys_nni_add_contact_number_val'] = $_data['mobile_number'];
        $_SESSION['sys_nni_add_designation_val'] = $_data['designation'];
        $_SESSION['sys_nni_add_email_address_val'] = $_data['email_address'];
        $_SESSION['sys_nni_add_service_required_val'] = renderLang($prospecting_service_required_arr[$_data['service_required']]);

        $id = $_data['id'];

        $nni_id = getField('id', 'nni', 'prospect_id = '.$id);

        $nni_data = isset($nni_id) ? getData($nni_id, 'nni') : array('status'=> 0);

        $hr_total_budget = isset($nni_id) ? getField('budget_total', 'nni_hr_tab', 'nni_id = '.$nni_id) : NULL;
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo renderLang($new_notice_of_new_instruction); ?> &middot; <?php echo $sitename; ?></title>
    
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
    <link rel="stylesheet" href="/plugins/ekko-lightbox/ekko-lightbox.css">
    
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
                            <h1><i class="fas fa-file-signature mr-3"></i><?php echo renderLang($new_notice_of_new_instruction); ?></h1>
                        </div>
                    </div>
                    
                </div><!-- container-fluid -->
            </section><!-- content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    
                    <?php
                    renderError('sys_notice_to_proceed_add_err');
                    renderSuccess('sys_nni_add_suc');
                    ?>
                    <?php if($nni_data['status'] != 2) { ?>
                    <form method="post" action="/submit-add-notice-of-new-instruction" enctype="multipart/form-data">
                    <?php } ?>

                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($new_notice_of_new_instruction_form); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-<?php echo isset($nni_data['status']) ? $nni_status_color_arr[$nni_data['status']]: 'secondary'; ?>"><?php echo isset($nni_data['status']) ? renderLang($nni_status_arr[$nni_data['status']]): renderLang($nni_status_arr[0]); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- BUILDING INFO -->
                                <h5 class="pl-3 text-uppercase"><?php echo renderLang($prospecting_project_informations); ?></h5>
                                <p class="text-muted pl-3"><?php echo renderLang($prospecting_required_warning); ?></p>
                                <hr>
                                <div class="row">
                                    
                                    <!-- PROJECT NAME -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="project_name" ><?php echo renderLang($prospecting_project_name); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                            <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo '['.$_data['reference_number'].'] '.$_data['project_name']; ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- OWNER/DEVELOPER -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="owner_developer"><?php echo renderLang($prospecting_owner_developer); ?></label>
                                            <input type="text" class="form-control" id="owner_developer" name="owner_developer"  placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_nni_add_owner_developer_val'])) { echo ' value="'.$_SESSION['sys_nni_add_owner_developer_val'].'"'; } ?> readonly>
                                        </div>
                                    </div>

                                    <!-- PROJECT ADDRESS -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="location" ><?php echo renderLang($nni_project_address); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                            <input type="text" class="form-control" id="location" name="location" placeholder=""<?php if(isset($_SESSION['sys_nni_add_location_val'])) { echo ' value="'.$_SESSION['sys_nni_add_location_val'].'"'; } ?> readonly>
                                        </div>
                                    </div>

                                    <!-- PROPERTY CATEGORY -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="property_category"><?php echo renderLang($prospecting_property_category); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                            <input type="text" class="form-control" id="property_category" name="property_category" value="<?php echo renderLang($prospecting_property_category_arr[$_data['property_category']]); ?>" readonly>
                                        </div>
                                    </div>

                                </div><!-- row -->

                                <br>
                                <!-- CLIENT CONTACT DETAILS -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_clients_contact_details); ?></h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <tbody class="table-data-contacts">
                                                <tr>
                                                    <!-- CONTACT PERSON -->
                                                    <th><?php echo renderLang($nni_contact_person); ?></th>
                                                    <td colspan="2"><input type="text" class="form-control border-0 input-readonly" id="prospecting_contact_person" name="prospecting_contact_person" placeholder="<?php echo renderLang($clients_contact_person_placeholder); ?>"<?php if(isset($_SESSION['sys_nni_add_contact_person_val'])) { echo ' value="'.$_SESSION['sys_nni_add_contact_person_val'].'"'; } ?> readonly></td>

                                                    <!-- DESIGNATION -->
                                                    <th><?php echo renderLang($nni_designation); ?></th>
                                                    <td><input type="text" class="form-control border-0 input-readonly" id="prospecting_designation" name="prospecting_designation" <?php if(isset($_SESSION['sys_nni_add_designation_val'])) { echo ' value="'.$_SESSION['sys_nni_add_designation_val'].'"'; } ?> readonly></td>
                                                </tr>
                                                <tr>
                                                    <?php $office_address = getField('office_address', 'prospecting_contacts', 'prospect_id = '.$prospect_id.' AND (office_address IS NOT NULL)'); ?>
                                                    <th><?php echo renderLang($nni_office_address); ?></th>
                                                    <td colspan="5"><textarea class="form-control w100p border-0" name="prospecting_office_address"><?php echo !empty($office_address) ? $office_address : $_data['location']; ?></textarea></td>
                                                </tr>
                                                <tr>

                                                    <!-- CONTACT NUMBER-->
                                                    <th><?php echo renderLang($nni_contact_number); ?></th>
                                                    <td colspan="2"><input type="text" class="form-control border-0 input-readonly" id="prospecting_contact_number" name="prospecting_contact_number" <?php if(isset($_SESSION['sys_nni_add_contact_number_val'])) { echo ' value="'.$_SESSION['sys_nni_add_contact_number_val'].'"'; } ?> readonly></td>

                                                    <!-- EMAIL ADDRESS -->
                                                    <th><?php echo renderLang($nni_email_address); ?></th>
                                                    <td colspan="2"><input type="email" class="form-control border-0 input-readonly" id="prospecting_email_address" name="prospecting_email_address" <?php if(isset($_SESSION['sys_nni_add_email_address_val'])) { echo ' value="'.$_SESSION['sys_nni_add_email_address_val'].'"'; } ?> readonly ></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="5"><?php echo renderLang($lang_others); ?></th>
                                                </tr>
                                                <?php 
                                                    $sql2 = $pdo->prepare("SELECT * FROM prospecting_contacts  WHERE prospect_id = :prospect_id ORDER by id ASC");
                                                    $sql2->bindParam(":prospect_id",$prospect_id);
                                                    $sql2->execute();
                                                    $last_code = $id.'0';
                                                    while($_data2 = $sql2->fetch(PDO::FETCH_ASSOC)) {?>

                                                        <tr>
                                                            <input type="hidden" name="contact_code[]" value="<?php echo $_data2['code']; ?>">
                                                            <!-- CONTACT PERSON -->
                                                            <th><?php echo renderLang($nni_contact_person); ?></th>
                                                            <td colspan="2"><input type="text" class="form-control border-0 input-readonly" name="nni_contact_person[]" value="<?php echo $_data2['contact_person']; ?>" readonly></td>

                                                            <!-- DESIGNATION -->
                                                            <th><?php echo renderLang($nni_designation); ?></th>
                                                            <td><input type="text" class="form-control border-0 input-readonly" name="nni_designation[]" value="<?php echo $_data2['designation']; ?>" readonly></td>
                                                        </tr>
                                                        <tr>

                                                            <!-- CONTACT NUMBER-->
                                                            <th><?php echo renderLang($nni_contact_number); ?></th>
                                                            <td colspan="2"><input type="text" class="form-control border-0 input-readonly" name="nni_contact_number[]" value="<?php echo $_data2['contact_number']; ?>" readonly></td>
                                                            
                                                            <!-- EMAIL ADDRESS -->
                                                            <th><?php echo renderLang($nni_email_address); ?></th>
                                                            <td colspan="2"><input type="email" class="form-control border-0 input-readonly" name="nni_email_address[]" value="<?php echo $_data2['email_address']; ?>" readonly></td>
                                                        </tr>

                                                    <?php 
                                                        $last_code = $_data2['code'];
                                                    ?>
                                                <?php } ?>

                                                    <tr class="default-row-contacts d-none">

                                                        <!-- CONTACT PERSON -->
                                                        <th><?php echo renderLang($nni_contact_person); ?></th>
                                                        <td colspan="2"><input type="text" class="form-control border-0" name="nni_contact_person[]" value="<?php echo $_data2['contact_person']; ?>"></td>

                                                        <!-- DESIGNATION -->
                                                        <th><?php echo renderLang($nni_designation); ?></th>
                                                        <td><input type="text" class="form-control border-0" name="nni_designation[]" value="<?php echo $_data2['designation']; ?>" ></td>

                                                    </tr>
                                                    <tr class="default-row-contacts2 d-none">

                                                        <!-- CONTACT NUMBER-->
                                                        <th><?php echo renderLang($nni_contact_number); ?></th>
                                                        <td colspan="2"><input type="text" class="form-control border-0" name="nni_contact_number[]" value="<?php echo $_data2['contact_number']; ?>" ></td>
                                                                    
                                                        <!-- EMAIL ADDRESS -->
                                                        <th><?php echo renderLang($nni_email_address); ?></th>
                                                        <td colspan="2"><input type="email" class="form-control border-0" name="nni_email_address[]" value="<?php echo $_data2['email_address']; ?>" ></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right mb-3">
                                            <?php if($nni_data['status'] == 0) { ?>
                                            <button href="" class="btn btn-info btn-sm add-row-contacts"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- SCOPE OF SERVICE -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_scope_of_service); ?></h5>
                                <hr>
                                <div class="row">
                                    <!-- SERVICE REQUIRED -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <label for="service_required"><?php echo renderLang($prospecting_service_required); ?></label>
                                            <input type="text" class="form-control" id="service_required" name="service_required" value="<?php echo renderLang($prospecting_service_required_arr[$_data['service_required']]); ?>" readonly>
                                        </div>
                                    </div> 
                                </div>
                                
                                <br>
                                <!-- SERVICE AGREEMENT -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_service_agreement); ?></h5>
                                    <?php 
                                    $sql = $pdo->prepare("SELECT * FROM contract WHERE prospect_id = :id ORDER BY id DESC LIMIT 1");
                                    $sql->bindParam(":id", $prospect_id);
                                    $sql->execute();
                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th><?php echo renderLang($nni_contract_duration); ?></th>
                                                        <td colspan="3">
                                                            <select name="contract_duration" id="term" class="form-control border-0">
                                                            <?php 
                                                            foreach($nni_contract_duration_arr as $key => $terms) {
                                                                echo '<option '.($data['contract_duration'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($terms).'</option>';
                                                                }
                                                            ?>
                                                            </select>
                                                        </td>
                                                        <th><?php echo renderLang($nni_start_of_contract); ?></th>

                                                        <td><input type="text" class="form-control border-0 date" name="start_contract" id="start_contract" value="<?php echo !empty($data['acquisition_date']) ? formatDate($data['acquisition_date']) : date('Y-m-d'); ?>"></td>

                                                        <th><?php echo renderLang($nni_end_of_contract); ?></th>
                                                        <td><input type="text" class="form-control border-0 date" name="end_contract" id="end_contract" value="<?php echo !empty($data['renewal_date']) ? formatDate($data['renewal_date']) : date('Y-m-d'); ?>"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <br>

                                <!-- FOR HR's INFORMATION -->
                                <?php if (checkPermission('hr-informations')) { ?>
                                <div class="row">
                                    <?php 
                                    $nni_hr_status = isset($nni_id) ? getField('status', 'nni_hr_tab', 'nni_id = '.$nni_id) : NULL;
                                    $hr_assigned = isset($nni_id) ? getField('assigned', 'nni_hr_tab', 'nni_id = '.$nni_id) : NULL;
                                     ?>
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-hr" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($nni_for_hr_information); ?><?php if(checkPermission('notice-of-new-instruction-HR') && $nni_hr_status != '') { ?><span class="badge<?php echo isset($nni_hr_status) ? ' badge-'.$nni_dep_status_color[$nni_hr_status]: ''; ?> float-right"><?php echo isset($nni_hr_status) ? renderlang($nni_departments_status_arr[$nni_hr_status]) : renderlang($nni_departments_status_arr[0]); ?></span><?php } ?></button>
                                        </p>
                                        <div class="collapse" id="tab-hr">

                                            <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                            <input type="hidden" name="department" value="HR">

                                            <div class="card card-body">

                                                <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                <div class="row">

                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for="nni_hr_status"><?php echo renderLang($lang_status); ?></label>
                                                            <select name="nni_hr_status" id="nni_hr_status" name="nni_hr_status" class="form-control">
                                                                <?php 
                                                                foreach($nni_departments_status_arr as $key => $status) {
                                                                    if($key != 3) {
                                                                        echo '<option '.(isset($nni_hr_status) && $nni_hr_status == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th rowspan="2"><?php echo renderLang($nni_manpower_plantilla); ?></th>
                                                                        <th rowspan="2"><?php echo renderLang($nni_head_count); ?></th>
                                                                        <th colspan="2" class="text-center"><?php echo renderLang($nni_budget); ?></th>
                                                                        <th rowspan="2"><?php echo renderLang($nni_deployment_date); ?></th>
                                                                        <th rowspan="2"><?php echo renderLang($nni_special_qualification); ?></th>
                                                                        <th rowspan="2"><?php echo renderLang($prf_name); ?></th>
                                                                        <th rowspan="2" <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>><?php echo renderLang($nni_remarks); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><?php echo renderLang($nni_base_pay); ?></th>
                                                                        <th><?php echo renderLang($nni_allowance); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-data">

                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM nni_hr WHERE nni_id = :nni_id");
                                                                    $sql->bindParam(":nni_id", $nni_id);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                        echo '<tr>';

                                                                        echo '<input type="hidden" name="nni_hr_id[]" value="'.$data['id'].'">';

                                                                        echo '<td class="p-0">';
                                                                            echo '<select class="form-control border-0 plantilla" name="manpower_plantilla[]">';
                                                                            echo '<option value=""></option>';
                                                                            $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                                            $sql1->execute();
                                                                            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                                echo '<option '.($data['manpower_plantilla'] == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.$data1['position'].'</option>';
                                                                            }

                                                                            echo '</select>';
                                                                        echo '</td>';

                                                                        echo '<td class="p-0"><input type="number" class="form-control border-0" name="head_count[]" min="1" value="'.$data['head_count'].'"></td>';

                                                                        echo '<td class="p-0"><input type="text" class="form-control border-0" name="budget_base_pay[]" value="'.$data['budget_base_pay'].'" data-type="currency"></td>';

                                                                        echo '<td class="p-0"><input type="text" class="form-control border-0" name="budget_allowance[]" value="'.$data['budget_allowance'].'" data-type="currency"></td>';

                                                                        echo '<td class="p-0"><input type="text" class="form-control border-0 date" name="deployment_date[]" name="delpoyment_date" value="'.formatDate($data['deployment_date']).'"></td>';

                                                                        echo '<td class="p-0"><input type="text" class="form-control border-0" name="special_qualification[]" value="'.$data['special_qualification'].'"></td>';
                                                                        
                                                                        echo '<td class="p-0">';
                                                                            echo '<input type="text" class="form-control border-0" name="prf_name[]" value="'.$data['name'].'">';
                                                                        echo '</td>';

                                                                        echo '<td '.($nni_data['status'] != 0 ? 'class="p-0"' : 'class="d-none p-0"').'>';
                                                                            echo '<select class="form-control border-0" name="hr_remarks[]">';
                                                                                foreach($prf_status_arr as $key => $prf_status) {
                                                                                    echo '<option '.($data['remarks'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($prf_status).'</option>';
                                                                                }
                                                                            echo '</select>';
                                                                        echo '</td>';

                                                                        echo '</tr>';

                                                                    }
                                                                    ?>
                                                                    
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class="default-row3 d-none">
                                                                            
                                                                        <input type="hidden" name="nni_hr_id[]" value="0">

                                                                        <td>
                                                                            <select class="form-control border-0 plantilla" name="manpower_plantilla[]">
                                                                                <option value=""></option>
                                                                                <?php 
                                                                                $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                                                $sql1->execute();
                                                                                while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                                    echo '<option '.($data['manpower_plantilla'] == $data1['id'] ? 'selected' : '').' value="'.$data1['id'].'">'.$data1['position'].'</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>

                                                                        <!-- head_count -->
                                                                        <td><input type="number" class="form-control border-0" name="head_count[]" min="1" value="1"></td>

                                                                        <!-- budget_base_pay -->
                                                                        <td><input type="text" class="form-control border-0" name="budget_base_pay[]" data-type="currency"></td>

                                                                        <!-- budget_allowance -->
                                                                        <td><input type="text" class="form-control border-0" name="budget_allowance[]" data-type="currency"></td>

                                                                        <!-- deployment_date -->
                                                                        <td><input type="text" class="form-control border-0 date" name="deployment_date[]" id="deployment_date"></td>

                                                                        <!-- special_qualification -->
                                                                        <td><input type="text" class="form-control border-0" name="special_qualification[]"></td>

                                                                        <td class="p-0">
                                                                            <input type="text" class="form-control border-0" name="prf_name[]">
                                                                        </td>
                                                                        
                                                                        <td <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>>
                                                                            <select name="hr_remarks[]" class="form-control border-0">
                                                                                <?php 
                                                                                foreach($prf_status_arr as $key => $prf_status) {
                                                                                    echo '<option '.($data['remarks'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($prf_status).'</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="2"><?php echo renderLang($lang_total); ?></th>
                                                                        <td colspan="2"><input type="text" name="HR_total" id="hr_total" class="form-control input-readonly border-0 text-right" value="<?php echo isset($hr_total_budget) ? $hr_total_budget : ""; ?>" readonly></td>
                                                                        <td colspan="4"></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <div class="text-right mb-3">
                                                            <?php if($nni_data['status'] == 0) { ?>
                                                                <button href="" class="btn btn-info btn-sm add-row2"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $nni_hr_status == '') { ?>

                                                    <div class="row">
                                                        <!-- HR -->
                                                        <div class="col-lg-3 col-md-4">
                                                            <div class="form-group">
                                                                <label for="hr_assigned"><?php echo renderLang($nni_assign_to); ?></label>
                                                                <select name="hr_assigned" id="hr_assigned" class="form-control select2">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :hr_dep_id");
                                                                    $sql->bindParam(":hr_dep_id", $hr_dep_id);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="mt-2 text-right">
                                                                    <button type="button" class="btn btn-success assign" data-val="5" data-cat="HR"><?php echo renderLang($nni_for_execution); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                <?php } ?>

                                                <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary dep-save"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            
                                            </div>

                                            <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                </form>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <!-- FOR IT DETAILS -->
                                <?php if (checkPermission('it-informations')) { ?>
                                <div class="row">
                                    <?php 
                                        $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id LIMIT 1");
                                        $sql->bindParam(":nni_id", $nni_id);
                                        $sql->execute();
                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                        $nni_it_id = $data['id'];
                                        $it_status = $data['status'];
                                        $it_assigned = $data['assigned'];
                                    ?>
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-it" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($nni_for_it_information); ?><?php if(checkPermission("notice-of-new-instruction-IT") && $it_status != '') { ?><span class="badge<?php echo isset($it_status) ? ' badge-'.$nni_dep_status_color[$it_status]: ''; ?> float-right"><?php echo renderLang($nni_departments_status_arr[$it_status]); ?></span><?php } ?></button>
                                        </p>
                                        <div class="collapse" id="tab-it">

                                            <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                            <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                            <input type="hidden" name="department" value="IT">

                                            <div class="card card-body">
                                                <!--  -->
                                                <div class="row">

                                                    <!-- SERVER ACCESS-->
                                                    <div class="col-lg-3 col-md-4 <?php echo $nni_data['status'] != 0 ? '' : 'd-none'; ?>">
                                                        <div class="form-group">
                                                            <label for="server_access"><?php echo renderLang($nni_server_access); ?></label>
                                                            <input type="text" class="form-control" id="server_access" name="server_access" value="<?php echo $data['server_access']; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- SERVICE TYPE -->
                                                    <div class="col-lg-3 col-md-4 d-none">
                                                        <div class="form-group">
                                                            <label for="service_type" ><?php echo renderLang($nni_service_type); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                                            <input type="text" class="form-control" id="service_type" name="it_service_type"  <?php if(isset($_SESSION['sys_nni_add_service_required_val'])) { echo ' value="'.$_SESSION['sys_nni_add_service_required_val'].'"'; } ?> readonly>
                                                        </div>
                                                    </div>

                                                    <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                    <!-- STATUS-->
                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for="location" ><?php echo renderLang($nni_status); ?></label> <span><?php echo renderLang($prospecting_required); ?></span>
                                                            <select class="form-control select2" id="status" name="status" <?php if(isset($_SESSION['sys_contract_add_status_val'])) { echo ' value="'.$_SESSION['sys_contract_add_status_val'].'"'; } ?>>
                                                            <?php 
                                                                foreach($nni_departments_status_arr as $key => $value) {
                                                                    if($key != 3) {
                                                                        echo '<option'.($data['status'] == $key ? ' selected' : ' ').' value="'.$key.'">'.renderLang($value).'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo renderLang($nni_it_position); ?></th>
                                                                        <th><?php echo renderLang($nni_it_name); ?></th>
                                                                        <th><?php echo renderLang($nni_access); ?></th>
                                                                        <th <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>><?php echo renderLang($nni_email_address); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-data-it">
                                                                    <?php 

                                                                    $server_access = array();

                                                                    $sql = $pdo->prepare("SELECT * FROM nni_it_staffs WHERE nni_it_id = :id AND temp_del = 0");
                                                                    $sql->bindParam(":id", $nni_it_id);
                                                                    $sql->execute();
                                                                    if($sql->rowCount()) {

                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

                                                                            $server_access = explode(',',$data['server_access']);

                                                                            echo '<tr>';

                                                                            echo '<input type="hidden" name="it_staff_id[]" value="'.$data['id'].'">';

                                                                            echo '<td><input type="text" class="form-control border-0" name="it_position[]" value="'.$data['position'].'"></td>';

                                                                            echo '<td><input type="text" class="form-control border-0" name="it_name[]" value="'.$data['name'].'"></td>';

                                                                            echo '<td>';
                                                                            foreach ($website_arr as $key => $website) {
                                                                                echo '<div class="icheck-success">';
                                                                                echo '<input type="checkbox" class="bcheck" id="'.$data['id'].$key.'" value="1" '.($server_access[$key] == 1 ? 'checked' : '').'>';
                                                                                echo '<input type="hidden" class="bvalue" name="access_'.$key.'[]" value="'.($server_access[$key] == 1 ? '1' : '0').'">';
                                                                                echo '<label for="'.$data['id'].$key.'">'.$website.'</label>';
                                                                                echo '</div>';
                                                                            }
                                                                            echo '</td>';
                                                                            
                                                                            echo '<td '.($nni_data['status'] != 0 ? '' : 'class="d-none"').'><input type="email" name="it_email[]" value="'.$data['email_address'].'" class="form-control border-0"></td>';

                                                                            echo '</tr>';

                                                                        }

                                                                    } else {

                                                                        echo '<tr>';

                                                                        echo '<input type="hidden" name="it_staff_id[]" value="0">';

                                                                        echo '<td><input type="text" class="form-control border-0" name="it_position[]"></td>';

                                                                        echo '<td><input type="text" class="form-control border-0" name="it_name[]"></td>';

                                                                        echo '<td>';
                                                                            foreach ($website_arr as $key => $website) {
                                                                                echo '<div class="icheck-success">';
                                                                                echo '<input type="checkbox" class="bcheck" id="'.$key.$data['id'].'" value="1">';
                                                                                echo '<input type="hidden" class="bvalue" name="access_'.$key.'[]" value="0" >';
                                                                                echo '<label for="'.$key.$data['id'].'">'.$website.'</label>';
                                                                                echo '</div>';
                                                                            }
                                                                        echo '</td>';
                                                                        
                                                                        echo '<td '.($nni_data['status'] != 0 ? '' : 'class="d-none"').'><input type="email" name="it_email[]" class="form-control border-0"></td></td>';

                                                                        echo '</tr>';

                                                                    }
                                                                        
                                                                    ?>
                                                                    <tr class="default-row-it d-none">

                                                                        <input type="hidden" name="it_staff_id[]" value="0">

                                                                        <td><input type="text" class="form-control border-0" name="it_position[]"></td>

                                                                        <td><input type="text" class="form-control border-0" name="it_name[]"></td>

                                                                        <td>
                                                                         <?php foreach ($website_arr as $key => $website) { ?>
                                                                            <div class="icheck-success">
                                                                            <input type="checkbox" class="bcheck" id="<?php echo $key; ?>"  value="1" <?php echo isset($data[$key]) && $data[$key] == 1 ? 'checked' : ''; ?>>
                                                                            <input type="hidden" class="bvalue" name="access_<?php echo $key; ?>[]" value="0">
                                                                            <label for="<?php echo $key; ?>"><?php echo $website; ?></label>
                                                                            </div>
                                                                        <?php } ?>
                                                                        </td>

                                                                        <td <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>><input type="email" class="form-control border-0" name="it_email[]"></td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                            <div class="text-right mb-3">
                                                            <?php if($nni_data['status'] == 0) { ?>
                                                                <button href="" class="btn btn-info btn-sm add-row-it"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $it_status == '') { ?>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4">
                                                            <div class="form-group">
                                                                <label for="it_assigned"><?php echo renderLang($nni_assign_to); ?></label>
                                                                <select name="it_assigned" id="it_assigned" class="form-control select2">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :it_dep_id");
                                                                    $sql->bindParam(":it_dep_id", $it_dep_id);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="mt-2 text-right">
                                                                    <button type="button" class="btn btn-success assign" data-val="5" data-cat="IT"><?php echo renderLang($nni_for_execution); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                            </div>

                                            <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                            </form>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <!-- FOR CAD's INFORMATION -->
                                <?php if (checkPermission('cad-informations')) { ?>
                                <div class="row">
                                    <?php 
                                    $nni_cad_status = isset($nni_id) ? getField('status', 'nni_cad_tab', 'nni_id = '.$nni_id) : '';
                                    $cad_assigned = isset($nni_id) ? getField('assigned', 'nni_cad_tab', 'nni_id = '.$nni_id) : NULL;
                                    ?>
                                    <div class="col-12">
                                        <p class="text-center">
                                            <button class="btn w100pc pms-red text-white text-left" type="button"  data-toggle="collapse" data-target="#tab-cad" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($nni_for_cad_information); ?><?php if(checkPermission("notice-of-new-instruction-CAD") && $nni_cad_status != '') { ?><span class="badge<?php echo isset($nni_cad_status) ? ' badge-'.$nni_dep_status_color[$nni_cad_status]: ''; ?> float-right"><?php echo isset($nni_cad_status) ? renderLang($nni_departments_status_arr[$nni_cad_status]) : renderLang($nni_departments_status_arr[0]); ?></span><?php } ?></button>
                                        </p>
                                        <div class="collapse" id="tab-cad">

                                            <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                            <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                            <input type="hidden" name="department" value="CAD">

                                            <div class="card card-body">

                                            <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for="nni_cad_status"><?php echo renderLang($lang_status); ?></label>
                                                            <select name="nni_cad_status" id="nni_cad_status" class="form-control">
                                                            <?php 
                                                            foreach($nni_departments_status_arr as $key => $status) {
                                                                if($key != 3) {
                                                                    echo '<option '.(isset($nni_cad_status) && $nni_cad_status == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                                                }
                                                            }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo renderLang($nni_property_administration); ?></th>
                                                                        <th colspan="2" class="text-center"><?php echo renderLang($nni_revenue_allocation); ?></th>
                                                                        <th colspan="2" class="text-center"><?php echo renderLang($nni_terms); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-data-2">

                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM nni_cad WHERE nni_id = :nni_id");
                                                                    $sql->bindParam(":nni_id", $nni_id);
                                                                    $sql->execute();
                                                                    $fetch = array();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        $fetch[$data['revenue_allocation']] = array(
                                                                            'property_administration' => $data['property_administration'],
                                                                            'revenue' => $data['revenue_allocation'],
                                                                            'terms' => $data['terms'],
                                                                            'revenue_amount' => $data['revenue_amount'],
                                                                            'id' => $data['id'],
                                                                            'term_option' => $data['term_option']
                                                                        );
                                                                    }
                                                                    $inclusion = array();
                                                                    foreach ($inclusions_arr as $key => $inclusions) {

                                                                        $inclusion[] = ''.$key.'';

                                                                        echo '<tr>';
                                                                        
                                                                            echo '<input type="hidden" name="cad_id[]" value="'.(isset($fetch[$key]) ? $fetch[$key]['id'] : '0').'">';

                                                                            if($key == 0) {
                                                                                echo '<td><input type="text" data-type="currency" class="form-control border-0 cad-amount" name="property_administration[]" value="'.(isset($fetch[$key]) ? $fetch[$key]['property_administration'] : '').'"></td>';
                                                                            } else {
                                                                                echo '<td><input type="hidden" data-type="currency" class="form-control border-0 cad-amount" name="property_administration[]"></td>';
                                                                            }

                                                                            echo '<td><p>'.renderLang($inclusions).'</p><input name="revenue[]" class="form-control" type="hidden" value="'.$key.'"></td>';

                                                                            echo '<td><input type="text" data-type="currency" name="revenue_amount[]" class="form-control border-0 cad-amount" value="'.(isset($fetch[$key]) ? $fetch[$key]['revenue_amount'] : '').'"></td>';

                                                                            // terms
                                                                            echo '<td>';
                                                                                echo '<p>'.renderLang($nni_cad_term_arr[$key]).'</p>';
                                                                                echo '<input type="hidden" class="form-control border-0" name="terms[]" value="'.$key.'">';
                                                                            echo '</td>';

                                                                            echo '<td class="cad-term-option">';
                                                                                if($key == 0) {
                                                                                    echo '<select class="form-control border-0 downpayment-term" name="term_option[]">';
                                                                                        foreach($nni_cad_term_downpayment_arr as $month_key => $months) {
                                                                                            echo '<option '.(isset($fetch[$key]) && $fetch[$key]['term_option'] == $month_key ? 'selected' : '').' value="'.$month_key.'">'.renderLang($months).'</option>';
                                                                                        }
                                                                                    echo '</select>';
                                                                                } else if($key == 1) {

                                                                                    echo '<select class="form-control border-0" name="term_option[]">';
                                                                                        foreach($nni_cad_term_due_date_arr as $due_key => $due_date) {
                                                                                            echo '<option '.(isset($fetch[$key]) && $fetch[$key]['term_option'] == $due_key ? 'selected' : '').' value="'.$due_key.'">'.renderLang($due_date).'</option>';
                                                                                        }
                                                                                    echo '</select>';

                                                                                } else if($key == 2) {

                                                                                    echo '<input type="text" class="form-control border-0" data-type="currency" name="term_option[]" value="'.(isset($fetch[$key]) ? $fetch[$key]['term_option'] : '').'">';
                                                                                    
                                                                                }
                                                                            echo '</td>';

                                                                        echo '</tr>';

                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <input type="hidden" name="cad_id[]" value="0">
                                                                        <td><input type="hidden" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency"></td>

                                                                        <td><input name="revenue[]" class="form-control border-0" type="hidden" value="escalation3"></td>

                                                                        <td><input type="hidden" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]"></td>
                                                                        <td>
                                                                            <p><?php echo renderLang($nni_escalation); ?></p>
                                                                            <input type="hidden" name="terms[]">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control border-0" name="term_option[]" value="<?php echo isset($fetch['escalation3']) ? $fetch['escalation3']['term_option'] : ''; ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="5"><?php echo renderLang($lang_others); ?></th>
                                                                    </tr>
                                                                    <?php 
                                                                    foreach($fetch as $key => $data) {

                                                                        if(!in_array($data['revenue'], $inclusion) && $data['revenue'] != 'escalation3') {

                                                                            echo '<tr>';
                                                                        
                                                                            echo '<input type="hidden" name="cad_id[]" value="'.$data['id'].'">';

                                                                            echo '<td><input type="hidden" class="form-control border-0 cad-amount" name="property_administration[]" value="'.$data['property_administration'].'" data-type="currency"></td>';

                                                                            echo '<td><input name="revenue[]" class="form-control border-0" type="text" value="'.$data['revenue'].'"></td>';

                                                                            echo '<td><input type="text" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]" value="'.$data['revenue_amount'].'"></td>';

                                                                            echo '<td><input type="text" class="form-control border-0" name="terms[]" value="'.$data['terms'].'"></td>';

                                                                            echo '<td>';
                                                                                echo '<input type="text" class="form-control border-0" name="term_option[]" value="'.$data['term_option'].'">';
                                                                            echo '</td>';

                                                                            echo '</tr>';

                                                                        }

                                                                    }
                                                                    ?>
                                                                    <tr class="default-row4 d-none">
                                                                        <input type="hidden" name="cad_id[]" value="0">
                                                                        <td><input type="hidden" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency"></td>

                                                                        <td><input name="revenue[]" class="form-control border-0" type="text"></td>

                                                                        <td><input type="text" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]"></td>

                                                                        <td>
                                                                            <input type="text" class="form-control border-0" name="terms[]">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" class="form-control border-0" name="term_option[]">
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5" class="text-right">
                                                                        <?php if($nni_data['status'] == 0) { ?>
                                                                            <button href="" class="btn btn-info btn-sm add-row3"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                                        <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- REVENUE TOTAL -->
                                                                    <tr>
                                                                        <th colspan="2"><?php echo renderLang($nni_revenue_allocation_total); ?></th>
                                                                        <td><input type="text" class="form-control border-0" id="CAD-total" readonly></td>
                                                                        <td  colspan="2"></td>
                                                                    </tr>
                                                                    <!-- LABOR COST -->
                                                                    <tr>
                                                                        <th colspan="2"><?php echo renderLang($nni_labor_cost); ?></th>
                                                                        <td><input type="text" name="labor-cost" data-type="currency" class="form-control border-0" id="labor-cost" value="<?php echo isset($nni_id) ? getField('labor_cost', 'nni_cad_tab', 'nni_id = '.$nni_id) : ''; ?>"></td>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                    <!-- TOTAL -->
                                                                    <tr>
                                                                        <th colspan="2"><?php echo renderLang($lang_total); ?></th>
                                                                        <td><input type="text" class="form-control border-0" id="total-cost" readonly></td>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                    <!-- VAT -->
                                                                    <tr>
                                                                        <th colspan="2">
                                                                            <?php 
                                                                            $cad_vat = isset($nni_id) ? getField('vat', 'nni_cad_tab', 'nni_id = '.$nni_id) : NULL;
                                                                            ?>
                                                                            <div class="icheck-success">
                                                                                <input type="checkbox" id="vat" name="vat_status" value="1" <?php echo isset($cad_vat) && $cad_vat == 1 ? 'checked' : ''; ?>>
                                                                                <label for="vat"><?php echo renderLang($nni_vat); ?><span class="ml-2">(0.12)</span></label>
                                                                            </div>
                                                                        </th>
                                                                        <td><input type="text" id="vat-total" class="form-control border-0" readonly></td>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                    <!-- TOTAL COST WHITH VAT -->
                                                                    <tr>
                                                                        <th colspan="2"><?php echo renderLang($nni_total_cost); ?></th>
                                                                        <td>
                                                                            <input type="text" class="form-control border-0" id="total-cost-vat" readonly>
                                                                        </td>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                                    
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- For Downpayment Information -->
                                                <h5 class="text-uppercase"><?php echo renderLang($nni_security_deposit); ?></h5>
                                                <div class="row">

                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM downpayments WHERE prospect_id = :id AND temp_del = 0 LIMIT 1");
                                                    $sql->bindParam(":id", $id);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <!-- AMOUNT -->
                                                    <div class="col-lg-3 col-md-4">
                                                        <label for="amount"><?php echo renderLang($downpayment_amount_php); ?></label>
                                                        <input type="text" id="dp-amount" data-type="currency" class="form-control" name="amount" value="<?php echo $data['amount']; ?>">
                                                    </div>

                                                    <!-- DATE -->
                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="form-group">
                                                            <label for="downpayment_date"><?php echo renderLang($downpayment_date); ?></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control float-right date" name="dp_date" value="<?php echo !empty($data['date']) ? formatDate($data['date']) : date('Y-m-d'); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- OR -->
                                                    <div class="col-lg-3 col-md-4 <?php echo $nni_data['status'] != 0 ? '' : 'd-none'; ?>">
                                                        <div class="form-group">
                                                            <label for="or_num"><?php echo renderLang($downpayment_or); ?></label>
                                                            <input type="text" class="form-control" name="or_num" id="or_num" value="<?php echo $data['or_num']; ?>">  
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $nni_cad_status == '') { ?>

                                                    <div class="row mt-2">
                                                        <div class="col-lg-3 col-md-4">
                                                            <div class="form-group">
                                                                <label for="cad_assigned"><?php echo renderLang($nni_assign_to); ?></label>
                                                                <select name="cad_assigned" id="cad_assigned" class="form-control select2">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :cad_dep_id");
                                                                    $sql->bindParam(":cad_dep_id", $cad_dep_id);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="mt-2 text-right">
                                                                    <button type="button" class="btn btn-success assign" data-val="5" data-cat="CAD"><?php echo renderLang($nni_for_execution); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                            </div>

                                            <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                            </form>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <br>
                                <?php 
                                    $sql = $pdo->prepare("SELECT * FROM nni WHERE id = :id LIMIT 1");
                                    $sql->bindParam(":id", $nni_id);
                                    $sql->execute();
                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if(checkPermission('NNI-reference-documents')) { ?>
                                <!-- REFERENCE DOCUMENTS -->
                                <h5 class="text-uppercase"><?php echo renderLang($nni_reference_documents); ?></h5>
                                <hr>
                                <div class="row mb-3">

                                    <?php if(checkPermission('NNI-labor-cost-attachment')) { ?>
                                    <!-- Labor Cost Breakdown -->
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <label><?php echo renderLang($nni_labor_cost_breakdown); ?></label><br>
                                            <?php
                                            if(!empty($data['labor_cost_breakdown'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['labor_cost_breakdown'], ',')) {

                                                    $attachments = explode(',', $data['labor_cost_breakdown']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['labor_cost_breakdown']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['labor_cost_breakdown'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['labor_cost_breakdown'].'" target="_blank">'.$data['labor_cost_breakdown'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control" name="attachment[]" multiple>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if(checkPermission('NNI-scope-of-work-attachment')) { ?>
                                    <!-- Detailed Scope of Work -->
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <label><?php echo renderLang($nni_detailed_scope_of_work); ?></label><br>
                                            <?php
                                            if(!empty($data['detailed_scope_of_work'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['detailed_scope_of_work'], ',')) {

                                                    $attachments = explode(',', $data['detailed_scope_of_work']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['detailed_scope_of_work']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['detailed_scope_of_work'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['detailed_scope_of_work'].'" target="_blank">'.$data['detailed_scope_of_work'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control" name="attachment2[]" multiple>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if(checkPermission('NNI-attachment')) { ?>
                                    <!-- NNI -->
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <label>NNI</label><br>
                                            <?php
                                            if(!empty($data['nni_attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['nni_attachment'], ',')) {

                                                    $attachments = explode(',', $data['nni_attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/nni/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/nni/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['nni_attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/nni/'.$data['nni_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['nni_attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/nni/'.$data['nni_attachment'].'" target="_blank">'.$data['nni_attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control" name="attachment_nni[]" multiple>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php if(checkPermission('NTP-attachment')) { ?>
                                    <!-- NOTICE TO PROCEED -->
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <label><?php echo renderLang($notice_to_proceed); ?></label><br>
                                            <?php
                                            if(!empty($data['ntp_attachment'])) {

                                                $img_ext = array('jpg', 'jpeg', 'png');
                                                if(strpos($data['ntp_attachment'], ',')) {

                                                    $attachments = explode(',', $data['ntp_attachment']);
                                                    foreach($attachments as $attachment) {

                                                        $attachment_part = explode('.', $attachment);
                                                        
                                                        if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                                echo '<a href="/assets/uploads/ntp/'.$attachment.'" data-toggle="lightbox">'; 
                                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/ntp/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                                    echo $attachment;
                                                                echo '</a><br>';
                                                            

                                                        } else {

                                                            echo '<a href="/assets/uploads/ntp/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                        }

                                                    }

                                                } else {

                                                    $attachment_part = explode('.', $data['ntp_attachment']);
                                                    if(in_array($attachment_part[1], $img_ext)) {

                                                            
                                                        echo '<a href="/assets/uploads/ntp/'.$data['ntp_attachment'].'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/ntp/'.$data['ntp_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $data['ntp_attachment'];
                                                        echo '</a><br>';
                                                        

                                                    } else {

                                                        echo '<a href="/assets/uploads/ntp/'.$data['ntp_attachment'].'" target="_blank">'.$data['ntp_attachment'].'</a><br>';

                                                    }
                                                
                                                }

                                            }
                                            ?>
                                            <input type="file" class="form-control" name="attachment_ntp[]" multiple>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                                <?php } ?>

                                <!-- REMARKS -->
                                <h5 class=" text-uppercase"><?php echo renderLang($nni_remarks); ?></h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td><textarea class="form-control notes border-0" name="nni_remarks"><?php echo $data['remarks']; ?></textarea></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- POD -->
                                <?php if(checkPermission('notice-of-new-instruction-POD') && $nni_data['status'] == 1) { ?>
                                <!-- Assign -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4">
                                            <div class="form-group">
                                                <label for="assigned"><?php echo renderLang($nni_assign_to); ?></label>
                                                <select name="assigned" id="assigned" class="form-control select2">
                                                    <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :department_id");
                                                    $sql->bindParam(":department_id", $pod_dep_id);
                                                    $sql->execute();
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <p class="mt-2 text-right">
                                                    <button class="btn btn-success assign" data-val="2"><?php echo renderLang($nni_assign); ?></button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- BDD -->
                                <?php if(checkPermission('notice-of-new-instruction-BDD') && checkPermission('notice-of-new-instruction-edit')) { ?>
                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <?php  
                                        if($nni_data['status'] == 0) {
                                        ?>
                                        <div class="icheck-success">
                                            <input type="checkbox" id="save-status" name="save_status" value="<?php echo !empty($nni_data['status']) ? $nni_data['status'] : '0'; ?>" <?php echo !empty($nni_data['status']) && $nni_data['status'] ? 'checked' : ''; ?>>
                                            <label for="save-status"><?php echo !empty($nni_data['status']) && $nni_data['status'] ? renderLang($nni_endorsed) : renderLang($lang_save_as_draft); ?></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>

                                
                                
                            </div><!-- card-body -->
                            <div class="card-footer text-right">

                                <a href="/notice-of-new-instructions" class="btn btn-default mr-1"><i class="fa fa-arrow-left mr-2"></i><?php echo renderLang($btn_back); ?></a>
                                
                                <?php if(checkPermission('notice-of-new-instruction-BDD') && checkPermission('notice-of-new-instruction-edit') && $nni_data['status'] == 0) { ?>
                                    <button class="btn btn-success" id="submit-btn"><i class="fa fa-save mr-1"></i><?php echo $nni_data['status'] == 0 ? renderLang($lang_save_as_draft) : renderLang($nni_endorsed); ?></button>
                                <?php } ?>

                                <!-- OM -->
                                <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id'])) { ?>
                                    <!-- <button class="btn btn-success assign" data-val="5"><?php echo renderLang($nni_for_execution); ?></button> -->
                                <?php } ?>

                            </div>
                        </div><!-- card -->

                    <?php if($nni_data['status'] != 2) { ?>
                    </form>
                    <?php } ?>
                    
                </div><!-- container-fluid -->
            </section><!-- content -->
            
        </div>
        <!-- /.content-wrapper -->

        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
        
    </div><!-- wrapper -->

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/ekko-lightbox/ekko-lightbox.min.js"></script> 
    <script>
        $(function() {

            // Auto compute Service agreement end date
                var term = $('#term').val();
                var start_date = $('#start_contract').val();
                var end_date = compute_date(term, start_date);
                $('#end_contract').val(end_date);
                $('#term, #start_contract').on('change', function() {
                    var term = $('#term').val();
                    var start_date = $('#start_contract').val();
                    var end_date = compute_date(term, start_date);
                    $('#end_contract').val(end_date);
                });
            // 

            // set min and max of base pay base on position
                $('body').on('change', '.plantilla, input[name="budget_base_pay[]"]', function(){

                    var $this = $(this).closest('tr');
                    var position_id = $this.find('.plantilla').val();
                    
                    $.post('/check-position', {
                        id:position_id, 
                    }, function(data){

                        var result = JSON.parse(data);
                        var min = result[0];
                        var max = result[1];

                        var base_pay = $this.find('input[name="budget_base_pay[]"]').val();
                        base_pay = base_pay.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
                        min = min.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
                        max = max.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");

                        base_pay = base_pay * 1;
                        min = min * 1;
                        max = max * 1;

                        if(base_pay > max) {
                            alert('Base pay exeeded the maximum basic pay.');
                            $this.find('input[name="budget_base_pay[]"]').val(max);
                            formatCurrency($this.find('input[name="budget_base_pay[]"]'), "blur");
                        } else if(base_pay < min) {
                            alert('Base pay is below the minimum basic pay.');
                            $this.find('input[name="budget_base_pay[]"]').val(min);
                            formatCurrency($this.find('input[name="budget_base_pay[]"]'), "blur");
                        }

                        // 
                        var base_pay_total = 0;
                        var allowance_total = 0;
                        var head_count = 1;

                        // base pay total
                        $('input[name="budget_base_pay[]"]').each(function(){
                            var val = $(this).val();

                            head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
                            if(head_count == '' || head_count == 0) {
                                head_count = 1;
                            }

                            val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
                            base_pay_total += val * head_count;
                        });

                        // allowance total
                        $('input[name="budget_allowance[]"]').each(function(){
                            var val = $(this).val();

                            head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
                            if(head_count == '' || head_count == 0) {
                            head_count = 1;
                            }

                            val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
                            allowance_total += val * head_count;
                        });

                        var total = base_pay_total + allowance_total;

                        $('#hr_total').val(total);
                        formatCurrency($('#hr_total'), "blur");

                        // $('#labor-cost').val(total);
                        // formatCurrency($('#labor-cost'), "blur");

                    });

                });
            // 

            // Update status
                $('body').on('click', '.assign', function(e){
                    e.preventDefault();

                    var status = $(this).data('val');
                    var nni_id = <?php echo isset($nni_id) ? $nni_id : 0; ?>;
                    var assigned;
                    if(status == 2) {
                        assigned = $('#assigned').val();
                    }

                    var category;
                    var dep_assigned;
                    var HR_total;
                    var vat_status;
                    if(status == 5) {
                        category = $(this).data('cat');
                        dep_assigned = $(this).closest('.form-group').find('select').val();
                        HR_total = $('input[name="HR_total"]').val();
                        vat_status = $('input[name="vat_status"]').val();
                    }
                    

                    $.post('/update-status-nni', {
                        status:status, nni_id:nni_id, assigned:assigned,
                        dep_assigned:dep_assigned, category:category, HR_total:HR_total,
                        vat_status:vat_status
                    }, function(data){
                        if(data == 'success') {
                            window.location.reload();
                        } else {
                            // alert(data);
                        }
                    });

                });
            // 

            // Save Departments information
                $('.dep-form').on('submit', function(e){
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response){
                            window.location.reload();
                            // alert(response);
                        }
                    });

                });
            // 

            // save checkbox option
                $('#save-status').on('change', function(e){
                
                    // change text and value of checkbox 
                    var status = $(this).val();
                    if(status == '1') {
                        $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save_as_draft); ?>');
                        $(this).val('0');
                        $(this).closest('div').find('label').html('<?php echo renderLang($lang_save_as_draft); ?>');
                    } else {
                        $('#submit-btn').html('<i class="fa fa-save mr-1"></i><?php echo renderLang($nni_endorsed); ?>');
                        $(this).val('1');
                        $(this).closest('div').find('label').html('<?php echo renderLang($nni_endorsed); ?>');
                    }

                });
            // 

            // ekko light box
                $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                    e.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
                });
            // 

            // Add row Contacts
                var contact_code = <?php echo $last_code; ?>;
                $('.add-row-contacts').on('click', function(e){
                    e.preventDefault();

                    contact_code++;

                    var fields1 = '<tr><input type="hidden" name="contact_code[]" value="'+contact_code+'">'+$('.default-row-contacts').html()+'</tr>';
                    var fields2 = '<tr>'+$('.default-row-contacts2').html()+'</tr>';
                    $('.table-data-contacts').append(fields1 + fields2);

                });
            // 

            // Add row
                $('.add-row2').on('click', function(e){
                    e.preventDefault();

                    var fields3 = '<tr>'+$('.default-row3').html()+'</tr>';
                    $('.table-data').append(fields3);

                    $('.date').each(function(){
                        $(this).daterangepicker({
                            singleDatePicker: true,
                            locale: {
                                format : 'YYYY-MM-DD'
                            }
                        });
                    });

                });

                $('.add-row3').on('click', function(e){
                    e.preventDefault();

                    var fields4 = '<tr>'+$('.default-row4').html()+'</tr>';
                    $('.table-data-2').append(fields4);

                });

                var checkbox_num = 10;

                $('.add-row-it').on('click', function(e){
                    e.preventDefault();

                    var fields5 = '<tr>'+$('.default-row-it').html()+'</tr>';
                    $('.table-data-it').append(fields5);

                    var checkbox = $('.table-data-it').find('tr:nth-last-child(2)').find('checkbox').attr('id')*1+1;

                    $('.table-data-it').find('tr:nth-last-child(1)').find('[type="checkbox"]').each(function(){

                        var checkbox_id = $(this).attr('id')*1+1+checkbox_num.toString();

                        $(this).attr('id',checkbox_id);
                        $(this).closest('div').find('label').attr('for',checkbox_id);



                    });

                    checkbox_num++;

                });                
                    
                // change save status 
                $('body').on('change', '.bcheck', function(){

                    if($(this).is(':checked')) {
                        $(this).closest('div').find('.bvalue').val('1');


                    } else {
                        $(this).closest('div').find('.bvalue').val('0');
                    }

                });
            // 

            // Date picker
                $('.date').each(function(){
                    $(this).daterangepicker({
                        singleDatePicker: true,
                        locale: {
                            format : 'YYYY-MM-DD'
                        }
                    });
                });
            // 
            
        });

        function compute_date(term, start_date) {
            switch(term) {
                case '0': 
                    term = 1 * 1;
                    break;
                case '1':
                    term = 2 * 1;
                    break;
                case '2':
                    term = 3 * 1;
                    break;
            }

            // add year based on term
            var end_date = new Date(new Date(start_date).setFullYear(new Date(start_date).getFullYear() + term));
            // subtract 1 day
            end_date.setDate(end_date.getDate() - 1);
            var year = end_date.getFullYear();
            var month = end_date.getMonth();
            month += 1;
            if(month < 10) {
                month = '0'+month;
            }
            var date = end_date.getDate();
            if(date < 10) {
                date = '0'+date;
            }
            end_date  = year+'-'+month+'-'+date;

            return end_date;
        }
    </script>
    <script src="/assets/js/nni.js"></script>
    
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