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
        $sql->bindParam(":id", $prospect_id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);

        $nni_id = getField('id', 'nni', 'prospect_id = '.$_data['id']);
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

                    <?php if($nni_data['status'] != 2) { ?>
                    <form method="post" action="/submit-add-notice-of-new-instruction" enctype="multipart/form-data">
                    <?php } ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo renderLang($new_notice_of_new_instruction_form); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-<?php echo isset($nni_data['status']) ? $nni_status_color_arr[$nni_data['status']]: 'secondary'; ?>"><?php echo isset($nni_data['status']) ? renderLang($nni_status_arr[$nni_data['status']]): renderLang($nni_status_arr[0]); ?></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id" value="<?php echo $prospect_id; ?>">

                                <div class="table-responsive">
                                    <table class="table table-bordered">

                                        <!-- PROJECT INFO -->
                                            <thead>
                                                <tr>
                                                    <th colspan="12" class="bg-gray" data-toggle="toggle"><?php echo renderLang($prospecting_project_informations); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="hide">
                                                <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :prospect_id LIMIT 1");
                                                    $sql->bindParam(":prospect_id", $prospect_id);
                                                    $sql->execute();

                                                    $contact_person = '';
                                                    $designation = '';
                                                    $contact_number = '';
                                                    $email_address = '';

                                                    $service_required = '';

                                                    if($sql->rowCount()) {
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                                                        $contact_person = $data['contact_person'];
                                                        $designation = $data['designation'];
                                                        $contact_number = $data['mobile_number'];
                                                        $email_address = $data['email_address'];

                                                        $service_required = $data['service_required'];

                                                ?>
                                                <tr>
                                                    <!-- project name -->
                                                    <th colspan="2"><?php echo renderLang($prospecting_project_name); ?></th>
                                                    <td colspan="4"><?php echo $data['project_name']; ?></td>
                                                    <!-- owner / developer -->
                                                    <th colspan="2"><?php echo renderLang($prospecting_owner_developer); ?></th>
                                                    <td colspan="4"><?php echo $data['owner_developer']; ?></td>
                                                </tr>
                                                <tr>
                                                    <!-- project address -->
                                                    <th colspan="2"><?php echo renderLang($nni_project_address); ?></th>
                                                    <td colspan="10"><?php echo $data['location']; ?></td>
                                                </tr>
                                                <tr>
                                                    <!-- type of development -->
                                                    <th colspan="2"><?php echo renderLang($prospecting_property_category); ?></th>
                                                    <td colspan="10"><?php echo renderLang($prospecting_property_category_arr[$data['property_category']]); ?></td>
                                                </tr>
                                                <?php } else { ?>
                                                <tr>
                                                    <td colspan="12"><?php echo renderLang($lang_no_data); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        <!-- ./project info -->

                                        <!-- clients contact details -->
                                            <thead>
                                                <tr>
                                                    <th colspan="12" class="bg-gray" data-toggle="toggle"><?php echo renderLang($nni_clients_contact_details); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="hide">
                                                <?php 
                                                $last_code = $prospect_id.'0';
                                                if(!empty($contact_person)) {
                                                ?>
                                                <tr>
                                                    <!-- contact person -->
                                                    <th colspan="2"><?php echo renderLang($nni_contact_person); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0 input-readonly" name="prospecting_contact_person" value="<?php echo $contact_person; ?>" readonly>
                                                    </td>
                                                    <!-- designation -->
                                                    <th colspan="2"><?php echo renderLang($nni_designation); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0 input-readonly" name="prospecting_designation" value="<?php echo $designation; ?>" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php $office_address = getField('office_address', 'prospecting_contacts', 'prospect_id = '.$prospect_id.' AND (office_address IS NOT NULL)'); ?>
                                                    <th colspan="2"><?php echo renderLang($nni_office_address); ?></th>
                                                    <td colspan="10" class="p-0">
                                                        <input type="text" class="form-control border-0" name="prospecting_office_address" value="<?php echo !empty($office_address) ? $office_address : $_data['location']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!-- contact number -->
                                                    <th colspan="2"><?php echo renderLang($nni_contact_number); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0 input-readonly" id="prospecting_contact_number" name="prospecting_contact_number" value="<?php echo $contact_number; ?>" readonly>
                                                    </td>
                                                    <!-- email address -->
                                                    <th colspan="2"><?php echo renderLang($nni_email_address); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="email" class="form-control border-0 input-readonly" id="prospecting_email_address" name="prospecting_email_address" value="<?php echo $email_address; ?>" readonly>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE prospect_id = :prospect_id");
                                                $sql->bindParam(":prospect_id", $prospect_id);
                                                $sql->execute();
                                                if($sql->rowCount()) {
                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)){
                                                ?>  
                                                    <tr>
                                                        <td colspan="12"><p></p></td>
                                                        <input type="hidden" name="contact_code[]" value="<?php echo $data['code']; ?>">
                                                    </tr>
                                                    <tr>
                                                        <!-- contact person -->
                                                        <th colspan="2"><?php echo renderLang($nni_contact_person); ?></th>
                                                        <td colspan="4" class="p-0">
                                                            <input type="text" class="form-control border-0 input-readonly" name="nni_contact_person[]" value="<?php echo $data['contact_person']; ?>">
                                                        </td>
                                                        <!-- designation -->
                                                        <th colspan="2"><?php echo renderLang($nni_designation); ?></th>
                                                        <td colspan="4" class="p-0">
                                                            <input type="text" class="form-control border-0 input-readonly" name="nni_designation[]" value="<?php echo $data['designation']; ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!-- contact number -->
                                                        <th colspan="2"><?php echo renderLang($nni_contact_number); ?></th>
                                                        <td colspan="4" class="p-0">
                                                            <input type="text" class="form-control border-0 input-readonly" name="nni_contact_number[]" value="<?php echo $data['contact_number']; ?>">
                                                        </td>
                                                        <!-- email address -->
                                                        <th colspan="2"><?php echo renderLang($nni_email_address); ?></th>
                                                        <td colspan="4" class="p-0">
                                                            <input type="email" class="form-control border-0 input-readonly" name="nni_email_address[]" value="<?php echo $data['email_address']; ?>">
                                                        </td>
                                                    </tr>
                                                <?php 
                                                        $last_code = $data['code'];
                                                    }
                                                }
                                                ?>

                                                <?php } else { ?>
                                                <tr>
                                                    <td colspan="12"><?php echo renderLang($lang_no_data); ?></td>
                                                </tr>
                                                <?php } ?>
                                                
                                                <!-- others -->
                                                <tr>
                                                    <th colspan="12"><?php echo renderLang($lang_others); ?></th>
                                                </tr>
                                                <input type="hidden" name="contact_code[]" value="0">
                                                <tr class="default1 d-none">
                                                    <!-- contact person -->
                                                    <th colspan="2"><?php echo renderLang($nni_contact_person); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0" name="nni_contact_person[]">
                                                    </td>
                                                    <!-- designation -->
                                                    <th colspan="2"><?php echo renderLang($nni_designation); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0" name="nni_designation[]">
                                                    </td>
                                                </tr>
                                                <tr class="default2 d-none">
                                                    <!-- contact number -->
                                                    <th colspan="2"><?php echo renderLang($nni_contact_number); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="text" class="form-control border-0" name="nni_contact_number[]">
                                                    </td>
                                                    <!-- email address -->
                                                    <th colspan="2"><?php echo renderLang($nni_email_address); ?></th>
                                                    <td colspan="4" class="p-0">
                                                        <input type="email" class="form-control border-0" name="nni_email_address[]">
                                                    </td>
                                                </tr>
                                                <?php if($nni_data['status'] == 0) { ?>
                                                    <tr>
                                                        <td colspan="12" class="text-right">
                                                            <button class="btn btn-sm btn-info add-row-client"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        <!-- ./clients contact -->

                                        <!-- scope of service -->
                                            <thead>
                                                <tr>
                                                    <th colspan="12" class="bg-gray" data-toggle="toggle"><?php echo renderLang($nni_scope_of_service); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="hide">
                                                <?php if(strlen($service_required) != 0) { ?>
                                                <tr>
                                                    <!-- scope of service -->
                                                    <th colspan="2"><?php echo renderLang($prospecting_service_required); ?></th>
                                                    <td colspan="10"><?php echo renderLang($prospecting_service_required_arr[$service_required]); ?></td>
                                                </tr>
                                                <?php } else { ?>
                                                <tr>
                                                    <td colspan="11"><?php echo renderLang($lang_no_data); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        <!--  -->

                                        <!-- service agreement -->
                                            <thead>
                                                <tr>
                                                    <th colspan="11" class="bg-gray" data-toggle="toggle"><?php echo renderLang($nni_service_agreement); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="hide">
                                                <?php 
                                                $sql = $pdo->prepare("SELECT * FROM contract WHERE prospect_id = :id ORDER BY id DESC LIMIT 1");
                                                $sql->bindParam(":id", $prospect_id);
                                                $sql->execute();
                                                $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <tr>
                                                    <th><?php echo renderLang($nni_contract_duration); ?></th>
                                                    <td class="p-0" colspan="2">
                                                        <select name="contract_duration" id="term" class="form-control border-0">
                                                            <?php 
                                                            foreach($nni_contract_duration_arr as $key => $terms) {
                                                                echo '<option '.($data['contract_duration'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($terms).'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>

                                                    <th colspan="2"><?php echo renderLang($nni_start_of_contract); ?></th>
                                                    <td class="p-0" colspan="2">
                                                        <input type="text" class="form-control border-0 date" name="start_contract" id="start_contract" value="<?php echo formatDate($data['acquisition_date']); ?>">
                                                    </td>

                                                    <th colspan="2"><?php echo renderLang($nni_end_of_contract); ?></th>
                                                    <td class="p-0" colspan="2">
                                                        <input type="text" class="form-control border-0 input-readonly" name="end_contract" id="end_contract" value="<?php echo formatDate($data['renewal_date']); ?>" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <!--  -->
                                    </table>
                                        
                                        <?php if(checkPermission('hr-informations')) { ?>
                                            <!-- HR information -->
                                            <?php 
                                            $nni_hr_status = isset($nni_id) ? getField('status', 'nni_hr_tab', 'nni_id = '.$nni_id) : NULL;
                                            $hr_assigned = isset($nni_id) ? getField('assigned', 'nni_hr_tab', 'nni_id = '.$nni_id) : NULL;
                                            ?>

                                            <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="12" class="bg-gray" data-toggle="toggle">
                                                            <?php echo renderLang($nni_for_hr_information); ?>
                                                            <?php if($nni_data['status'] == 2 && checkVar($nni_hr_status)) { ?>
                                                                <span class="float-right <?php echo ' badge-'.$nni_dep_status_color[$nni_hr_status]; ?> pl-2 pr-2"><?php echo renderlang($nni_departments_status_arr[$nni_hr_status]); ?></span>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hide">

                                                        <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                                        <input type="hidden" name="department" value="HR">

                                                        <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                            <!-- hr status -->
                                                            <tr>
                                                                <th><?php echo renderLang($lang_status); ?></th>
                                                                <td class="p-0" colspan="2">
                                                                    <select name="nni_hr_status" id="nni_hr_status" name="nni_hr_status" class="form-control border-0">
                                                                        <?php 
                                                                        foreach($nni_departments_status_arr as $key => $status) {
                                                                            if($key != 3) {
                                                                                echo '<option '.(isset($nni_hr_status) && $nni_hr_status == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>

                                                        <!-- header -->
                                                        <tr class="text-center">
                                                            <th rowspan="2"><?php echo renderLang($nni_manpower_plantilla); ?></th>
                                                            <th rowspan="2" <?php echo $nni_data['status'] == 0 ? 'colspan="2"' : ''; ?>><?php echo renderLang($prf_name); ?></th>
                                                            <th colspan="6"><?php echo renderLang($nni_budget); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_deployment_date); ?></th>
                                                            <th rowspan="2"><?php echo renderLang($nni_special_qualification); ?></th>
                                                            <?php if($nni_data['status'] != 0) { ?>
                                                            <th rowspan="2"><?php echo renderLang($nni_remarks); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th><?php echo renderLang($nni_base_pay); ?></th>
                                                            <th><?php echo renderLang($nni_allowance); ?></th>
                                                            <th><?php echo renderLang($labor_cost_total_compensation); ?></th>
                                                            <th><?php echo renderLang($labor_cost_total_gmb); ?></th>
                                                            <th><?php echo renderLang($labor_cost_total_cib); ?></th>
                                                            <th><?php echo renderLang($lang_total); ?></th>
                                                        </tr>

                                                        <?php 
                                                        $sql = $pdo->prepare("SELECT * FROM labor_cost WHERE prospect_id = :prospect_id AND temp_del = 0 AND status = 3 ORDER BY version DESC LIMIT 1");
                                                        $sql->bindParam(":prospect_id", $prospect_id);
                                                        $sql->execute();
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                        $proposal_lc_id = $data['id'];

                                                        $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE prospect_id = :prospect_id AND temp_del = 0 AND status = 3 ORDER BY version DESC LIMIT 1");
                                                        $sql->bindParam(":prospect_id", $prospect_id);
                                                        $sql->execute();
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                        $outsource_lc_id = $data['id'];

                                                        $sql1 = $pdo->prepare("SELECT * FROM nni_hr WHERE nni_id = :nni_id");
                                                        $sql1->bindParam(":nni_id", $nni_id);
                                                        $sql1->execute();
                                                        $nni_hr_id = 0;
                                                        if($sql1->rowCount()) {
                                                            $datas = array();
                                                            while($data1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                $datas[] = $data1;
                                                            }
                                                            $nni_hr_id = 1;
                                                            $position_index = 'manpower_plantilla';
                                                            $base_pay_index = 'budget_base_pay';
                                                            $allowance_index = 'budget_allowance';
                                                            $total_index = 'total_lc';
                                                        } else {
                                                            $sql2 = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE labor_cost_id = :lc_id");
                                                            $sql2->bindParam(":lc_id", $proposal_lc_id);
                                                            $sql2->execute();
                                                            $datas = array();
                                                            while($data1 = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                $data1['origin'] = 'direct';
                                                                $datas[] = $data1;
                                                            }

                                                            $sql2 = $pdo->prepare("SELECT * FROM labor_cost_outsource_positions WHERE labor_cost_id = :lc_id");
                                                            $sql2->bindParam(":lc_id", $outsource_lc_id);
                                                            $sql2->execute();
                                                            while($data1 = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                $data1['origin'] = 'outsource';
                                                                $datas[] = $data1;
                                                            }

                                                            $position_index = 'position_id';
                                                            $base_pay_index = 'basic_salary';
                                                            $allowance_index = 'allowance';
                                                            $total_index = 'rounded_up_total';
                                                        }

                                                        foreach($datas as $data1) {
                                                            echo '<tr>';

                                                                echo '<input type="hidden" name="nni_hr_id[]" value="'.($nni_hr_id ? $data1['id'] : '0').'">';
                                                                echo '<input type="hidden" name="hr_parent[]" value="'.$data1['origin'].'">';

                                                                // position 
                                                                echo '<td class="p-0">';
                                                                    echo '<select class="form-control border-0 plantilla '.(checkVar($data1['origin']) && $data1['origin'] == 'direct' ? 'text-danger' : 'text-primary').'" name="manpower_plantilla[]">';
                                                                        echo '<option value=""></option>';
                                                                        $sql1 = $pdo->prepare("SELECT * FROM positions_for_project");
                                                                        $sql1->execute();
                                                                        while($data2 = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo '<option '.($data1[$position_index] == $data2['id'] ? 'selected' : '').' value="'.$data2['id'].'">'.$data2['position'].'</option>';
                                                                        }
                                                                    echo '</select>';
                                                                echo '</td>';

                                                                // name
                                                                echo '<td class="p-0" '.($nni_data['status'] == 0 ? 'colspan="2"' : '').'>';
                                                                    echo '<input type="text" class="form-control border-0" name="prf_name[]" min="1" value="'.($nni_hr_id ? $data1['name'] : '').'">';
                                                                echo '</td>';

                                                                // base pay
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 base-pay" name="budget_base_pay[]" value="'.$data1[$base_pay_index].'" data-type="currency">';
                                                                echo '</td>';

                                                                // allowance
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 allowance" name="budget_allowance[]" value="'.$data1[$allowance_index].'" data-type="currency">';
                                                                echo '</td>';

                                                                // total compensation
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 total-compensation" name="compensation[]" value="'.$data1['total_compensation'].'">';
                                                                echo '</td>';

                                                                // total gmb
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 total-gmb" name="gmb[]" value="'.$data1['total_gmb'].'">';
                                                                echo '</td>';

                                                                // total cib
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 total-cib" name="cib[]" value="'.$data1['total_cib'].'">';
                                                                echo '</td>';

                                                                // total
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 lc-total '.$data1['origin'].'" name="lc_total[]" value="'.$data1[$total_index].'">';
                                                                echo '</td>';

                                                                // deployment date
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0 date" name="deployment_date[]" name="delpoyment_date" value="'.($nni_hr_id ? $data1['deployment_date'] : '').'">';
                                                                echo '</td>';

                                                                // special qualification
                                                                echo '<td class="p-0">';
                                                                    echo '<input type="text" class="form-control border-0" name="special_qualification[]" value="'.($nni_hr_id ? $data1['special_qualification'] : '').'">';
                                                                echo '</td>';

                                                                // remarks
                                                                echo '<td class="p-0 '.($nni_data['status'] == 0 ? 'd-none' : '').'">';
                                                                    echo '<select class="form-control border-0" name="hr_remarks[]">';
                                                                    foreach($prf_status_arr as $key => $prf_status) {
                                                                        echo '<option '.($nni_hr_id && $data1['remarks'] == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($prf_status).'</option>';
                                                                    }
                                                                    echo '</select>';
                                                                echo '</td>';

                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th class="text-uppercase"><?php echo renderLang($lang_total); ?></th>
                                                            <td <?php echo $nni_data['status'] == 0 ? 'colspan="2"' : ''; ?>></td>
                                                            <td class="sub_total_base_pay"></td>
                                                            <td class="sub_total_allowance"></td>
                                                            <td class="sub_total_compensation"></td>
                                                            <td class="sub_total_gmb"></td>
                                                            <td class="sub_total_cib"></td>
                                                            <td class="sub_total_total"></td>
                                                            <input type="hidden" name="HR_total" id="HR-total">
                                                            <td colspan="3"></td>
                                                        </tr>
                                                        <tr>
                                                            <!-- <td colspan="11" class="text-right">
                                                                <button class="btn btn-info btn-sm"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                            </td> -->
                                                        </tr>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>

                                                        <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $nni_hr_status == '') { ?>
                                                            <!-- HR assign -->
                                                            <tr>
                                                                <th><?php echo renderLang($nni_assign_to); ?></th>
                                                                <td colspan="2" class="p-0 border-0">
                                                                    <select name="hr_assigned" id="hr_assigned" class="form-control select2 border-0">
                                                                        <?php 
                                                                        $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :hr_dep_id");
                                                                        $sql->bindParam(":hr_dep_id", $hr_dep_id);
                                                                        $sql->execute();
                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td class="p-0" colspan="9">
                                                                    <button type="button" class="btn btn-success assign" data-val="5" data-cat="HR"><?php echo renderLang($nni_for_execution); ?></button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                            <tr>
                                                                <td class="border-0">
                                                                    <button class="btn btn-primary dep-save"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>


                                                </tbody>
                                            </table>
                                            <!--  -->
                                            <?php if(checkPermission('notice-of-new-instruction-HR') && ($nni_hr_status == 3 || $nni_hr_status == 0) && $hr_assigned == $_SESSION['sys_id']) { ?>
                                                </form>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if (checkPermission('it-informations')) { ?>
                                            <!-- IT information -->
                                            <?php 
                                                $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id LIMIT 1");
                                                $sql->bindParam(":nni_id", $nni_id);
                                                $sql->execute();
                                                $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                $nni_it_id = $data['id'];
                                                $it_status = $data['status'];
                                                $it_assigned = $data['assigned'];
                                            ?>

                                            <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="12" class="bg-gray" data-toggle="toggle">
                                                            <?php echo renderLang($nni_for_it_information); ?>
                                                            <?php if($nni_data['status'] == 2 && checkVar($it_status)) { ?>
                                                                <span class="float-right <?php echo ' badge-'.$nni_dep_status_color[$it_status]; ?> pl-2 pr-2"><?php echo renderlang($nni_departments_status_arr[$it_status]); ?></span>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hide">

                                                    <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                                    <input type="hidden" name="department" value="IT">

                                                    <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                        <!-- IT status -->
                                                        <tr>
                                                            <th><?php echo renderLang($lang_status); ?></th>
                                                            <td class="p-0 border-0" colspan="2">
                                                                <select class="form-control select2" id="status" name="status">
                                                                <?php 
                                                                    foreach($nni_departments_status_arr as $key => $value) {
                                                                        if($key != 3) {
                                                                            echo '<option'.($data['status'] == $key ? ' selected' : ' ').' value="'.$key.'">'.renderLang($value).'</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    <!-- line break -->
                                                    <tr>
                                                        <td colspan="12" class="border-0" ><p></p></td>
                                                    </tr>

                                                    <!-- header -->
                                                    <tr class="text-center text-uppercase">
                                                        <th colspan="2"><?php echo renderLang($nni_it_position); ?></th>
                                                        <th colspan="2"><?php echo renderLang($nni_it_name); ?></th>
                                                        <th <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>><?php echo renderLang($nni_email_address); ?></th>
                                                        <th colspan="4"><?php echo renderLang($nni_access); ?></th>
                                                    </tr>
                                                    <?php
                                                    $sql = $pdo->prepare("SELECT * FROM labor_cost WHERE prospect_id = :prospect_id AND temp_del = 0 AND status = 3 ORDER BY version DESC LIMIT 1");
                                                    $sql->bindParam(":prospect_id", $prospect_id);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    $proposal_lc_id = $data['id'];

                                                    $sql = $pdo->prepare("SELECT * FROM labor_cost_outsource WHERE prospect_id = :prospect_id AND temp_del = 0 AND status = 3 ORDER BY version DESC LIMIT 1");
                                                    $sql->bindParam(":prospect_id", $prospect_id);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    $outsource_lc_id = $data['id'];
                                                    
                                                    $sql = $pdo->prepare("SELECT * FROM nni_it_staffs WHERE nni_it_id = :nni_it_id");
                                                    $sql->bindParam(":nni_it_id", $nni_it_id);
                                                    $sql->execute();
                                                    $has_it = 0;
                                                    if($sql->rowCount()) {
                                                        $datas = array();
                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                            $datas[] = $data;
                                                        }
                                                        $has_it = 1;
                                                    } else {
                                                        $datas = array();
                                                        $sql = $pdo->prepare("SELECT * FROM nni_hr WHERE nni_id = :nni_id");
                                                        $sql->bindParam(":nni_id", $nni_id);
                                                        $sql->execute();
                                                        if($sql->rowCount()) {
                                                            $datas = array();
                                                            while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                $datas[] = $data;
                                                            }
                                                        } else {
                                                            $has_it = 2;
                                                            $sql2 = $pdo->prepare("SELECT * FROM labor_cost_positions WHERE labor_cost_id = :lc_id");
                                                            $sql2->bindParam(":lc_id", $proposal_lc_id);
                                                            $sql2->execute();
                                                            $datas = array();
                                                            while($data1 = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                $data1['origin'] = 'direct';
                                                                $datas[] = $data1;
                                                            }

                                                            $sql2 = $pdo->prepare("SELECT * FROM labor_cost_outsource_positions WHERE labor_cost_id = :lc_id");
                                                            $sql2->bindParam(":lc_id", $outsource_lc_id);
                                                            $sql2->execute();
                                                            while($data1 = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                                                $data1['origin'] = 'outsource';
                                                                $datas[] = $data1;
                                                            }

                                                        }
                                                    }
                                                    foreach($datas as $data) { 
                                                        if($has_it == 1) {
                                                            $position = $data['position'];
                                                            $it_email = $data['email_address'];
                                                            $server_access = checkVar($data['server_access']) ? explode(',', $data['server_access']) : explode(',', '0,0,0,0');
                                                            $staff_id = $data['id'];
                                                            $it_name = $data['name'];
                                                        } else if($has_it == 2){
                                                            $position = checkVar($data['position_id']) ? getField("position", "positions_for_project", "id = ".$data['position_id']) : '';;
                                                            $it_email = '';
                                                            $server_access = explode(',', '0,0,0,0');
                                                            $staff_id = '0';
                                                            $it_name = '';
                                                        } else {
                                                            $position = checkVar($data['manpower_plantilla']) ? getField("position", "positions_for_project", "id = ".$data['manpower_plantilla']) : '';
                                                            $it_email = '';
                                                            $server_access = explode(',', '0,0,0,0');
                                                            $staff_id = '0';
                                                            $it_name = $data['name'];
                                                        }
                                                        ?>
                                                        <tr>

                                                            <input type="hidden" name="it_staff_id[]" value="<?php echo $staff_id; ?>">
                                                            <!-- position -->
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0" name="it_position[]" value="<?php echo $position; ?>">
                                                            </td>

                                                            <!-- name -->
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0" name="it_name[]" value="<?php echo $it_name; ?>">
                                                            </td>

                                                            <!-- email -->
                                                            <td <?php echo $nni_data['status'] != 0 ? '' : 'class="d-none"'; ?>>
                                                                <input type="email" name="it_email[]" class="form-control border-0" value="<?php echo $it_email; ?>">
                                                            </td>

                                                            <!-- server access -->
                                                            <?php foreach ($website_arr as $key => $website) { ?>
                                                                <td class="p-0">
                                                                    <div class="icheck-success pl-2">
                                                                        <input type="checkbox" class="bcheck" id="<?php echo $key.'-'.$data['id']; ?>"  value="1" <?php echo $server_access[$key] == 1 ? 'checked' : ''; ?>>
                                                                        <input type="hidden" class="bvalue" name="access_<?php echo $key; ?>[]" value="<?php echo $server_access[$key]; ?>">
                                                                        <label for="<?php echo $key.'-'.$data['id']; ?>"><?php echo $website; ?></label>
                                                                    </div>
                                                                </td>
                                                            <?php } ?>

                                                        </tr>
                                                    <?php } ?>

                                                    <!-- line break -->
                                                    <tr>
                                                        <td colspan="12" class="border-0"><p></p></td>
                                                    </tr>

                                                    <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $it_status == '') { ?>
                                                        <!-- it assign -->
                                                        <tr>
                                                            <th><?php echo renderLang($nni_assign_to); ?></th>
                                                            <td colspan="2" class="p-0 border-0">
                                                                <select name="it_assigned" id="it_assigned" class="form-control select2 border-0">
                                                                    <?php 
                                                                    $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :it_dep_id");
                                                                    $sql->bindParam(":it_dep_id", $it_dep_id);
                                                                    $sql->execute();
                                                                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td class="p-0" colspan="9">
                                                                <button type="button" class="btn btn-success assign" data-val="5" data-cat="IT"><?php echo renderLang($nni_for_execution); ?></button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                        <tr>
                                                            <td colspan="12">
                                                                <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    <!-- line break -->
                                                    <tr>
                                                        <td colspan="12" class="border-0"><p></p></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <!--  -->

                                            <?php if(checkPermission("notice-of-new-instruction-IT") && ($it_status == 3 || $it_status == 0) && $it_assigned == $_SESSION['sys_id']) { ?>
                                                </form>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if (checkPermission('cad-informations')) { ?>
                                            <!-- CAD information -->
                                            <?php 
                                            $nni_cad_status = isset($nni_id) ? getField('status', 'nni_cad_tab', 'nni_id = '.$nni_id) : '';
                                            $cad_assigned = isset($nni_id) ? getField('assigned', 'nni_cad_tab', 'nni_id = '.$nni_id) : NULL;
                                            ?>

                                            <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                <form action="/update-departments-status" method="post" class="dep-form">
                                            <?php } ?>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="12" class="bg-gray" data-toggle="toggle">
                                                            <?php echo renderLang($nni_for_cad_information); ?>
                                                            <?php if($nni_data['status'] == 2 && checkVar($nni_cad_status)) { ?>
                                                                <span class="float-right <?php echo ' badge-'.$nni_dep_status_color[$nni_cad_status]; ?> pl-2 pr-2"><?php echo renderlang($nni_departments_status_arr[$nni_cad_status]); ?></span>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hide">

                                                        <input type="hidden" name="nni_id" value="<?php echo $nni_id; ?>">
                                                        <input type="hidden" name="department" value="CAD">

                                                        <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                            <!-- cad department status -->
                                                            <tr>
                                                                <th><?php echo renderLang($lang_status); ?></th>
                                                                <td class="p-0" colspan="2">
                                                                    <select name="nni_cad_status" id="nni_cad_status" class="form-control border-0">
                                                                        <?php 
                                                                        foreach($nni_departments_status_arr as $key => $status) {
                                                                            if($key != 3) {
                                                                                echo '<option '.(isset($nni_cad_status) && $nni_cad_status == $key ? 'selected' : '').' value="'.$key.'">'.renderLang($status).'</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td colspan="10"></td>
                                                            </tr>
                                                        <?php } ?>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>

                                                        <tr class="text-center">
                                                            <th colspan="3"><?php echo renderLang($nni_property_administration); ?></th>
                                                            <th colspan="4" class="text-center"><?php echo renderLang($nni_revenue_allocation); ?></th>
                                                            <th colspan="4"><?php echo renderLang($nni_terms).$nni_cad_status; ?></th>
                                                        </tr>
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
                                                            ?>
                                                            <tr>

                                                                <input type="hidden" name="cad_id[]" value="<?php echo isset($fetch[$key]) ? $fetch[$key]['id'] : '0'; ?>">

                                                                <!-- property admin -->
                                                                <td class="p-0" colspan="3">
                                                                    <input type="<?php echo $key == 0 ? 'text' : 'hidden'; ?>" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency" value="<?php echo $key == 0 && isset($fetch[$key]) ? $fetch[$key]['property_administration'] : ''; ?>">
                                                                </td>

                                                                <!-- revenue allocation -->
                                                                <td class="p-0" colspan="2">
                                                                    <input class="form-control border-0 input-readonly" type="text" value="<?Php echo renderLang($inclusions); ?>" readonly>
                                                                    <input type="hidden" name="revenue[]" value="<?php echo $key; ?>">
                                                                </td>
                                                                <td class="p-0" colspan="2">
                                                                    <input type="text" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]" value="<?php echo isset($fetch[$key]) ? $fetch[$key]['revenue_amount'] : ''; ?>">
                                                                </td>

                                                                <!-- terms -->
                                                                <td class="p-0" colspan="2">
                                                                    <input type="text" class="form-control border-0 input-readonly" value="<?php echo renderLang($nni_cad_term_arr[$key]); ?>" readonly>
                                                                    <input type="hidden" name="terms[]" value="<?php echo $key; ?>">
                                                                </td>
                                                                <td class="p-0" colspan="2">
                                                                    <?php 
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
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <input type="hidden" name="cad_id[]" value="<?php echo isset($fetch['escalation3']) ? $fetch['escalation3']['id'] : '0'; ?>">
                                                            <!-- property admin -->
                                                            <td class="p-0" colspan="3">
                                                                <input type="hidden" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency">
                                                            </td>

                                                            <!-- revenue allocation -->
                                                            <td class="p-0" colspan="2">
                                                                <input name="revenue[]" class="form-control border-0" type="hidden" value="escalation3">
                                                            </td>

                                                            <td class="p-0" colspan="2">
                                                                <input type="hidden" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]">
                                                            </td>
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0 input-readonly" name="terms[]" value="<?php echo renderLang($nni_escalation); ?>" readonly>
                                                            </td>
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0" name="term_option[]" value="<?php echo isset($fetch['escalation3']) ? $fetch['escalation3']['term_option'] : ''; ?>">
                                                            </td>
                                                        </tr>
                                                        <!-- others -->
                                                        <tr>
                                                            <th colspan="11">
                                                                <?php echo renderLang($lang_others); ?>
                                                            </th>
                                                        </tr>
                                                        <?php 
                                                        foreach($fetch as $key => $data) {

                                                            if(!in_array($data['revenue'], $inclusion) && $data['revenue'] != 'escalation3') { 
                                                            ?>
                                                                <tr>

                                                                   <input type="hidden" name="cad_id[]" value="<?php echo $data['id']; ?>">

                                                                   <!-- property admin -->
                                                                    <td class="p-0" colspan="3">
                                                                        <input type="text" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency" value="<?php echo $data['property_administration']; ?>">
                                                                    </td>

                                                                    <!-- revenue allocation -->
                                                                    <td class="p-0" colspan="2">
                                                                        <input name="revenue[]" class="form-control border-0" type="text" value="<?php echo $data['revenue']; ?>">
                                                                    </td>
                                                                    <td class="p-0" colspan="2">
                                                                        <input type="text" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]" value="<?php echo $data['revenue_amount']; ?>">
                                                                    </td>

                                                                    <!-- terms -->
                                                                    <td class="p-0" colspan="2">
                                                                        <input type="text" class="form-control border-0 input-readonly" value="<?php echo $data['terms']; ?>" readonly>
                                                                    </td>
                                                                    <td class="p-0" colspan="2">
                                                                    <input type="text" class="form-control border-0" name="term_option[]" value="<?php echo $data['term_option']; ?>">
                                                                    </td>

                                                                </tr>
                                                            <?php }
                                                        } ?>
                                                        <!-- default row -->
                                                        <tr class="default-row d-none">
                                                            <input type="hidden" name="cad_id[]" value="0">
                                                            <!-- property admin -->
                                                            <td class="p-0" colspan="3">
                                                                <input type="hidden" class="form-control border-0 cad-amount" name="property_administration[]" data-type="currency">
                                                            </td>

                                                            <!-- revenue allocation -->
                                                            <td class="p-0" colspan="2">
                                                                <input class="form-control border-0" type="text" name="revenue[]">
                                                            </td>
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" data-type="currency" class="form-control border-0 cad-amount" name="revenue_amount[]">
                                                            </td>

                                                            <!-- terms -->
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0" name="terms[]"">
                                                            </td>
                                                            <td class="p-0" colspan="2">
                                                                <input type="text" class="form-control border-0" name="term_option[]">
                                                            </td>
                                                        </tr>
                                                        <!-- add row -->
                                                        <tr>
                                                            <th colspan="11" class="text-right">
                                                                <button class="btn btn-info btn-sm add-row-cad"><i class="fa fa-plus mr-1"></i><?php echo renderLang($lang_add_row); ?></button>
                                                            </th>
                                                        </tr>
                                                        <!-- revenue total -->
                                                        <tr>
                                                            <th colspan="5"><?php echo renderLang($nni_revenue_allocation_total); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" class="form-control border-0" id="CAD-total" readonly>
                                                            </td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- labor cost direct -->
                                                        <tr>
                                                            <th colspan="5"><?php echo renderLang($nni_labor_cost_direct); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" name="labor-cost" data-type="currency" class="form-control border-0" id="labor-cost" value="<?php echo isset($nni_id) ? getField('labor_cost', 'nni_cad_tab', 'nni_id = '.$nni_id) : ''; ?>">
                                                            </td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- labor cost outsource -->
                                                        <tr>
                                                            <th colspan="5"><?php echo renderLang($nni_labor_cost_outsource); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" class="form-control border-0" id="labor-cost-outsource" data-type="currency" name="labor-cost-outsource" value="<?php echo isset($nni_id) ? getField('labor_cost_outsource', 'nni_cad_tab', 'nni_id = '.$nni_id) : ''; ?>">
                                                            </td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- total -->
                                                        <tr>
                                                            <th colspan="5"><?php echo renderLang($lang_total); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" class="form-control border-0" id="total-cost" readonly>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- vat -->
                                                        <?php 
                                                        $cad_vat = isset($nni_id) ? getField('vat', 'nni_cad_tab', 'nni_id = '.$nni_id) : NULL;
                                                        ?>
                                                        <tr>
                                                            <th colspan="5" class="p-0">
                                                                <div class="icheck-success pl-2">
                                                                    <input type="checkbox" id="vat" name="vat_status" value="1" <?php echo isset($cad_vat) && $cad_vat == 1 ? 'checked' : ''; ?>>
                                                                    <label for="vat"><?php echo renderLang($nni_vat); ?><span class="ml-2">(0.12)</span></label>
                                                                </div>
                                                            </th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" id="vat-total" class="form-control border-0" readonly>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- sub total -->
                                                        <tr>
                                                            <th colspan="5">Sub Total</th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" class="form-control border-0" id="sub_total_cost" readonly>
                                                            </td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <!-- total cost -->
                                                        <tr>
                                                            <th colspan="5"><?php echo renderLang($nni_total_cost); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" class="form-control border-0" id="total-cost-vat" readonly>
                                                            </td>
                                                            <td colspan="4"></td>
                                                        </tr>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="11" class="border-0"><p></p></td>
                                                        </tr>
            
                                                        <!-- SECURITY DEPOSIT -->
                                                        <tr>
                                                            <th class="text-uppercase" colspan="11"><?php echo renderLang($nni_security_deposit); ?></th>
                                                        </tr>
                                                        <tr>
                                                            <?php 
                                                            $sql = $pdo->prepare("SELECT * FROM downpayments WHERE prospect_id = :id AND temp_del = 0 LIMIT 1");
                                                            $sql->bindParam(":id", $prospect_id);
                                                            $sql->execute();
                                                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <!-- amount -->
                                                            <th colspan="2"><?php echo renderLang($downpayment_amount_php); ?></th>
                                                            <td colspan="2" class="p-0">
                                                                <input type="text" id="dp-amount" data-type="currency" class="form-control border-0" name="amount" value="<?php echo $data['amount']; ?>">
                                                            </td>
                                                            <!-- date of payment -->
                                                            <th colspan="2"><?php echo renderLang($downpayment_date); ?></th>
                                                            <td class="p-0" colspan="2">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right date border-0" name="dp_date" value="<?php echo formatDate($data['date']); ?>" required>
                                                                </div>
                                                            </td>

                                                            <!-- OR -->
                                                            <th class="<?php echo $nni_data['status'] != 0 ? '' : 'd-none'; ?>"><?php echo renderLang($downpayment_or); ?></th>
                                                            <td colspan="2" class="p-0 <?php echo $nni_data['status'] != 0 ? '' : 'd-none'; ?>">
                                                                <input type="text" class="form-control border-0" name="or_num" id="or_num" value="<?php echo $data['or_num']; ?>">
                                                            </td>
                                                        </tr>

                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>

                                                        <?php if(checkPermission('notice-of-new-instruction-OM') && $nni_data['status'] == 2 && (isset($nni_data) && $nni_data['assigned'] == $_SESSION['sys_id']) && $nni_cad_status == '') { ?>
                                                            <!-- cad assigned -->
                                                            <tr>
                                                                <th><?php echo renderLang($nni_assign_to); ?></th>
                                                                <td colspan="2" class="p-0 border-0">
                                                                    <select name="cad_assigned" id="cad_assigned" class="form-control select2 border-0">
                                                                        <?php 
                                                                        $sql = $pdo->prepare("SELECT * FROM employees WHERE department_id = :cad_dep_id");
                                                                        $sql->bindParam(":cad_dep_id", $cad_dep_id);
                                                                        $sql->execute();
                                                                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo '<option value="'.$data['id'].'">'.getFullName($data['id'], 'employee').'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td class="p-0" colspan="9">
                                                                    <button type="button" class="btn btn-success assign" data-val="5" data-cat="CAD"><?php echo renderLang($nni_for_execution); ?></button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                            <tr>
                                                                <td>
                                                                    <button class="btn btn-primary"><i class="fa fa-save mr-1"></i><?php echo renderLang($lang_save); ?></button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        
                                                        <!-- line break -->
                                                        <tr>
                                                            <td colspan="12" class="border-0"><p></p></td>
                                                        </tr>

                                                </tbody>
                                            </table>
                                            <!--  -->
                                            <?php if(checkPermission("notice-of-new-instruction-CAD") && ($nni_cad_status == 0 || $nni_cad_status == 3) && $cad_assigned == $_SESSION['sys_id']) { ?>
                                                </form>
                                            <?php } ?>
                                        <?php } ?>

                                    <table class="table table-bordered">
                                        <?php if(checkPermission('NNI-reference-documents')) { ?>
                                            <!-- reference document -->
                                                <thead>
                                                    <tr>
                                                        <th colspan="11" class="bg-gray" data-toggle="toggle"><?php echo renderLang($nni_reference_documents); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hide">
                                                    
                                                    <!-- header -->
                                                    <tr>
                                                        <?php if(checkPermission('NNI-labor-cost-attachment')) { ?>
                                                            <th colspan="3"><?php echo renderLang($nni_labor_cost_breakdown); ?></th>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NNI-scope-of-work-attachment')) { ?>
                                                            <th colspan="3"><?php echo renderLang($nni_detailed_scope_of_work); ?></th>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NNI-attachment')) { ?>
                                                            <th colspan="3">NNI</th>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NTP-attachment')) { ?>
                                                            <th colspan="3"><?php echo renderLang($notice_to_proceed); ?></th>
                                                        <?php } ?>
                                                    </tr>

                                                    <!-- input file -->
                                                    <tr>
                                                        <?php if(checkPermission('NNI-labor-cost-attachment')) { ?>
                                                            <!-- lc breakdown input -->
                                                            <td colspan="3">
                                                                <input type="file" class="form-control border-0" name="attachment[]" multiple>
                                                            </td>
                                                        <?php } ?>

                                                        <?php if(checkPermission('NNI-scope-of-work-attachment')) { ?>
                                                            <!-- scope of work input -->
                                                            <td colspan="3">
                                                                <input type="file" class="form-control border-0" name="attachment2[]" multiple>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NNI-attachment')) { ?>
                                                            <!-- nni input -->
                                                            <td colspan="3">
                                                                <input type="file" class="form-control border-0" name="attachment_nni[]" multiple>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NTP-attachment')) { ?>
                                                            <!-- ntp input -->
                                                            <td colspan="3">
                                                                <input type="file" class="form-control border-0" name="attachment_ntp[]" multiple>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>

                                                    <!-- attachment preview -->
                                                    <?php 
                                                        $sql = $pdo->prepare("SELECT * FROM nni WHERE id = :id LIMIT 1");
                                                        $sql->bindParam(":id", $nni_id);
                                                        $sql->execute();
                                                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <tr>
                                                        <!-- lc -->
                                                        <td colspan="3">
                                                            <?php renderAttachments($data['labor_cost_breakdown'], "nni"); ?>
                                                        </td>
                                                        <?php if(checkPermission('NNI-scope-of-work-attachment')) { ?>
                                                            <!-- scope of work -->
                                                            <td colspan="3">
                                                                <?php renderAttachments($data['detailed_scope_of_work'], "nni"); ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NNI-attachment')) { ?>
                                                            <!-- nni -->
                                                            <td colspan="3">
                                                                <?php renderAttachments($data['nni_attachment'], "nni"); ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if(checkPermission('NTP-attachment')) { ?>
                                                            <!-- ntp -->
                                                            <td colspan="3">
                                                                <?php renderAttachments($data['ntp_attachment'], "ntp"); ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>

                                                </tbody>
                                            <!--  -->
                                        <?php } ?>

                                        <!-- remarks -->
                                            <thead>
                                                <tr>
                                                    <th colspan="12" class="bg-gray" data-toggle="toggle"><?php echo renderLang($nni_remarks); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="hide">
                                                <?php 
                                                    $sql = $pdo->prepare("SELECT * FROM nni WHERE id = :id LIMIT 1");
                                                    $sql->bindParam(":id", $nni_id);
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <textarea class="form-control notes border-0" name="nni_remarks" rows="4"><?php echo $data['remarks']; ?></textarea>
                                                    </td>
                                                </tr>

                                                <!-- line break -->
                                                <tr>
                                                    <td colspan="12" class="border-0"><p></p></td>
                                                </tr>

                                            </tbody>
                                        <!--  -->

                                    </table>
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

                            </div>
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
                        </div>

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

            // assign notification
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                <?php
                // approval notification
                if(isset($_SESSION['sys_nni_add_suc'])) {
                    ?>
                    Toast.fire({
                        type: 'success',
                        title: '<?php echo $_SESSION['sys_nni_add_suc']; ?>'
                    });
                    <?php
                    unset($_SESSION['sys_nni_add_suc']);
                }
                ?>
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
                        dep_assigned = $(this).closest('tr').find('select').val();
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
                            // console.log(response);
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

            // ekko lightbox
                $(document).on('click', '[data-toggle="lightbox"]', function(e) {
                    e.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
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

            // add cad row
                $('body').on('click', '.add-row-cad', function(e){
                    e.preventDefault();
                    var fields = "<tr>"+$(this).closest('tbody').find('.default-row').html()+"</tr>";
                    $(this).closest('tr').before(fields);
                });
            // 

            // add client row
                var contact_code = <?php echo $last_code; ?>;
                $("body").on("click", ".add-row-client", function(e) {
                    e.preventDefault();

                    contact_code++;

                    var line_break = '<tr><td colspan="12" class="border-0"><p></p><input type="hidden" name="contact_code[]" value="'+contact_code+'"></td></tr>';

                    var client_fields = line_break+"<tr>"+$(this).closest('tbody').find('.default1').html()+"</tr>";
                    client_fields += "<tr>"+$(this).closest('tbody').find('.default2').html()+"</tr>";
                    $(this).closest('tr').before(client_fields);

                });
            // 

            // toggle table rows
                $('body').on('click', '[data-toggle="toggle"]', function(){
                    $(this).closest('thead').next('.hide').toggle();
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

            compute_hr_sub_total();

        });

        // sub total computation
        function compute_hr_sub_total() {

            // base pay
            var sub_total_base_pay = 0;
            $('.base-pay').each(function(){
                var base_pay = convertCurrency($(this).val());
                sub_total_base_pay += base_pay;
            });
            $('.sub_total_base_pay').html(convert_to_currency(sub_total_base_pay, "blur"));

            // allowance
            var sub_total_allowance = 0;
            $('.allowance').each(function() {
                var allowance = convertCurrency($(this).val());
                sub_total_allowance += allowance;
            });
            $('.sub_total_allowance').html(convert_to_currency(sub_total_allowance, "blur"));

            // total compensation
            var sub_total_compensation = 0;
            $('.total-compensation').each(function() {
                var compensation = convertCurrency($(this).val());
                sub_total_compensation += compensation;
            });
            $('.sub_total_compensation').html(convert_to_currency(sub_total_compensation, "blur"));

            // total gmb
            var sub_total_gmb = 0;
            $('.total-gmb').each(function() {
                var gmb = convertCurrency($(this).val());
                sub_total_gmb += gmb;
            });
            $('.sub_total_gmb').html(convert_to_currency(sub_total_gmb, "blur"));

            // total cib
            var sub_total_cib = 0;
            $('.total-cib').each(function(){
                var cib = convertCurrency($(this).val());
                sub_total_cib += cib;
            });
            $('.sub_total_cib').html(convert_to_currency(sub_total_cib, "blur"));

            // total
            var sub_total_total = 0;
            $('.lc-total').each(function() {
                var total = convertCurrency($(this).val());
                sub_total_total += total;
            });
            $('.sub_total_total').html(convert_to_currency(sub_total_total, "blur"));
            $('#HR-total').val(convert_to_currency(sub_total_total, "blur"));

            // direct total
            var direct_total = 0;
            $('.lc-total').each(function() {
                if($(this).hasClass('direct')) {
                    var total = convertCurrency($(this).val());
                    direct_total += total;
                }
            });
            $('#labor-cost').val(convert_to_currency(direct_total, "blur"));

            // outsource total
            var outsource_total = 0;
            $('.lc-total').each(function() {
                if($(this).hasClass('outsource')) {
                    var total = convertCurrency($(this).val());
                    outsource_total += total;
                }
            });
            $('#labor-cost-outsource').val(convert_to_currency(outsource_total, "blur"));

        }

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