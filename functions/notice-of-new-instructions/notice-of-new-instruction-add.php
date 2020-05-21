<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('notice-of-new-instruction-add')) {
    
        $err = 0;
        
        // PROCESS FORM

            // PROJECT ID
            $prospect_id = $_POST['id'];

            // status
            $save_status = 0;
            if(isset($_POST['save_status'])) {
                $save_status = $_POST['save_status'];
            }

            $sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE prospect_id = :id");
            $sql->bindParam(":id",$prospect_id);
            $sql->execute();
            $_data = $sql->fetch(PDO::FETCH_ASSOC);

            $contact_person = '';
            if(isset($_data['contact_person'])) {
                $contact_person = $_data['contact_person'];
            }

            $contact_number = '';
            if(isset($_data['contact_number'])) {
                $contact_number = $_data['contact_number'];
            }

        // NOTICE OF NEW INSTRUCTIONS

            // NNI REMARKS
            $nni_remarks = '';
            if(isset($_POST['nni_remarks'])) {
                $nni_remarks = $_POST['nni_remarks'];
            }

        // PROSPECTING
            // prospecting_contact_person
            $prospecting_contact_person = '';
            if(isset($_POST['prospecting_contact_person'])) {
                $prospecting_contact_person = $_POST['prospecting_contact_person'];
            }
            // prospecting_designation
            $prospecting_designation = '';
            if(isset($_POST['prospecting_designation'])) {
                $prospecting_designation = $_POST['prospecting_designation'];
                
            }
            // prospecting_contact_number
            $prospecting_mobile_number = '';
            if(isset($_POST['prospecting_mobile_number'])) {
                $prospecting_mobile_number = $_POST['prospecting_mobile_number'];
                
            }
            // prospecting_email_address
            $prospecting_email_address = '';
            if(isset($_POST['prospecting_email_address'])) {
                $prospecting_email_address = $_POST['prospecting_email_address'];
                
            }
            // prospecting_office_address
            $prospecting_office_address = '';
            if(isset($_POST['prospecting_office_address'])) {
                $prospecting_office_address = $_POST['prospecting_office_address'];
                
            }

        // CLIENTS CONTACTS
        
            // contact code
            $contact_code = array();
            if(isset($_POST['contact_code'])) {
                $contact_code = $_POST['contact_code'];
            }

            // nni_contact_person
            $nni_contact_person = array();
            if(isset($_POST['nni_contact_person'])) {
                $nni_contact_person = $_POST['nni_contact_person'];
                
            }
            // nni_designation
            $nni_designation = array();
            if(isset($_POST['nni_designation'])) {
                $nni_designation = $_POST['nni_designation'];
                
            }
            // nni_contact_number
            $nni_contact_number = array();
            if(isset($_POST['nni_contact_number'])) {
                $nni_contact_number = $_POST['nni_contact_number'];
                
            }
            // nni_email_address
            $nni_email_address = array();
            if(isset($_POST['nni_email_address'])) {
                $nni_email_address = $_POST['nni_email_address'];
                
            }

        // CONTRACT

            // START CONTRACT
            $start_contract = '';
            if(isset($_POST['start_contract'])) {
                $start_contract = trim($_POST['start_contract']);
            }
            // END CONTRACT
            $end_contract = '';
            if(isset($_POST['end_contract'])) {
                $end_contract = trim($_POST['end_contract']);
            }

            // CONTRACT DURATION
            $contract_duration = 0;
            if(isset($_POST['contract_duration'])) {
                $contract_duration = trim($_POST['contract_duration']);
            }

        // NNI HR INFORMATION
        if (checkPermission('hr-informations')) {

            // nni hr id
            $nni_hr_id = array();
            if(isset($_POST['nni_hr_id'])) {
                $nni_hr_id = $_POST['nni_hr_id'];
            }

            // nni hr origin
            $origin = array();
            if(isset($_POST['hr_parent'])) {
                $origin = $_POST['hr_parent'];
            }

            // MANPOWER PLANTILLA
            $manpower_plantilla = array();
            if(isset($_POST['manpower_plantilla'])) {
                $manpower_plantilla = $_POST['manpower_plantilla']; 
            }
            
            $prf_name = array();
            if(isset($_POST['prf_name'])) {
                $prf_name = $_POST['prf_name'];
            }

            // HEAD COUNT
            $head_count = array();
            if(isset($_POST['head_count'])) {
                $head_count = $_POST['head_count'];
            }

            // BUDGET BASE PAY
            $budget_base_pay = array();
            if(isset($_POST['budget_base_pay'])) {
                $budget_base_pay = $_POST['budget_base_pay'];
            }

            // BUDGET ALLOWANCE
            $budget_allowance = array();
            if(isset($_POST['budget_allowance'])) {
                $budget_allowance = $_POST['budget_allowance'];
            }

            // COMPENSATION
            $compensation = array();
            if(isset($_POST['compensation'])) {
                $compensation = $_POST['compensation'];
            }

            // GMB
            $gmb = array();
            if(isset($_POST['gmb'])) {
                $gmb = $_POST['gmb'];
            }

            // CIB
            $cib = array();
            if(isset($_POST['cib'])) {
                $cib = $_POST['cib'];
            }

            // LC TOTAL
            $lc_total = array();
            if(isset($_POST['lc_total'])) {
                $lc_total = $_POST['lc_total'];
            }

            // DEPLOYMENT DATE
            $deployment_date = array();
            if(isset($_POST['deployment_date'])) {
                $deployment_date = $_POST['deployment_date'];
            }

            // SPECIAL QUALIFICATION
            $special_qualification = array();
            if(isset($_POST['special_qualification'])) {
                $special_qualification = $_POST['special_qualification'];
            }

            // HR REMARKS
            $hr_remarks = array();
            if(isset($_POST['hr_remarks'])) {
                $hr_remarks = $_POST['hr_remarks'];
            }
            
            // HR_total
            $hr_total = 0;
            if(isset($_POST['HR_total'])) {
                $hr_total = trim($_POST['HR_total']);
            }

        }

        // NNI CAD INFO
        if (checkPermission('cad-informations')) {

            // nni cad id
            $nni_cad_id = array();
            if(isset($_POST['cad_id'])) {
                $nni_cad_id = $_POST['cad_id'];
            }
        
            // CAD property_administration
            $property_administration = array();
            if(isset($_POST['property_administration'])) {
                $property_administration = $_POST['property_administration'];
            }

            // CAD inclusions
            $revenue = array();
            if(isset($_POST['revenue'])) {
                $revenue = $_POST['revenue'];
            }

            // CAD terms
            $terms = array();
            if(isset($_POST['terms'])) {
                $terms = $_POST['terms'];
            }

            // CAD cad_remarks
            $revenue_amount = array();
            if(isset($_POST['revenue_amount'])) {
                $revenue_amount = $_POST['revenue_amount'];
            }

            // LABOR COST
            $labor_cost = '';
            if(isset($_POST['labor-cost'])) {
                $labor_cost = trim($_POST['labor-cost']);
            }

            // LABOR COST OUTSOURCE
            $labor_cost_outsource = '';
            if(isset($_POST['labor-cost-outsource'])) {
                $labor_cost_outsource = trim($_POST['labor-cost-outsource']);
            }

            // VAT STATUS
            $vat_status = 0;
            if(isset($_POST['vat_status'])) {
                $vat_status = trim($_POST['vat_status']);
            }
          
            // TERM OPTION
            $term_option = array();
            if(isset($_POST['term_option'])) {
                $term_option = $_POST['term_option'];
            }

        }

        // NNI IT INFO
        if (checkPermission('it-informations')) {
        
            // server_access
            $server_access = '';
            if(isset($_POST['server_access'])) {
                $server_access = $_POST['server_access'];
            }

            // webpage_access
            $webpage_access = array();
            if(isset($_POST['access_0'])) {
                $webpage_access = $_POST['access_0'];
            }

            // my_fpd
            $my_fpd = array();
            if(isset($_POST['access_1'])) {
                $my_fpd = $_POST['access_1'];
            }

            // fpd_nexus
            $fpd_nexus = array();
            if(isset($_POST['access_2'])) {
                $fpd_nexus = $_POST['access_2'];
            }

            // acumatica
            $acumatica = array();
            if(isset($_POST['access_3'])) {
                $acumatica = $_POST['access_3'];
            }

            // it_position
            $it_position = array();
            if(isset($_POST['it_position'])) {
                $it_position = $_POST['it_position'];
            }
            
            // it staff id
            $it_staff_id = array();
            if(isset($_POST['it_staff_id'])) {
                $it_staff_id = $_POST['it_staff_id'];
            }

            // it_name
            $it_name = array();
            if(isset($_POST['it_name'])) {
                $it_name = $_POST['it_name'];
            }


            // it_email
            $it_email = array();
            if(isset($_POST['it_email'])) {
                $it_email = $_POST['it_email'];
            }

        }

        // AMOUNT
            $amount = '';
            if(isset($_POST['amount'])) {
                $amount = $_POST['amount'];
                $_SESSION['sys_downpayment_add_amount_val'] = $amount;
                
            }

        // DATE
            $dp_date = '';
            if(isset($_POST['dp_date'])) {
                $dp_date = trim($_POST['dp_date']);
                
            }

        // OR
            $or_num = '';
            if(isset($_POST['or_num'])) {
                $or_num = trim($_POST['or_num']);
                
            }

        // signed_notice_to_proceed
            $signed_notice_to_proceed = 1;
            if(isset($_POST['signed_notice_to_proceed'])) {
                $signed_notice_to_proceed = trim($_POST['signed_notice_to_proceed']);
            }
        // 
    
        
        // VALIDATE FOR ERRORS
        if($err == 0) { // there are no errors

            $change_logs = array();

            // check nni if already existed
            $sql = $pdo->prepare("SELECT * FROM nni WHERE prospect_id = :id LIMIT 1");
            $sql->bindParam(":id", $prospect_id);
            $sql->execute();
            $nni_action = '';
            if($sql->rowCount()) { // existed update
                
                $data = $sql->fetch(PDO::FETCH_ASSOC);

                if ($save_status != $data['status']) {
                    $tmp = 'nni_status::'.$data['status'].'=='.$save_status;
                    array_push($change_logs, $tmp);
                }
                if ($nni_remarks != $data['remarks']) {
                    $tmp = 'nni_remarks::'.$data['remarks'].'=='.$nni_remarks;
                    array_push($change_logs, $tmp);
                }
                if ($signed_notice_to_proceed != $data['signed_notice_to_proceed']) {
                    $tmp = 'nni_signed_ntp::'.$data['signed_notice_to_proceed'].'=='.$signed_notice_to_proceed;
                    array_push($change_logs, $tmp);
                }

                $nni_action = 'update';

                $nni_id = $data['id'];

                $sql1 = $pdo->prepare("UPDATE nni SET 
                    labor_cost_breakdown = :labor_cost_attachment, 
                    detailed_scope_of_work = :detailed_scope_attachment, 
                    signed_notice_to_proceed = :signed_notice_to_proceed, 
                    remarks = :nni_remarks, 
                    nni_attachment = :nni_attachment,
                    ntp_attachment = :ntp_attachment,
                    status = :status
                WHERE id = :nni_id");
                $sql1->bindParam(":status", $save_status);
                $sql1->bindParam(":nni_id", $nni_id);
                $sql1->bindParam(":nni_remarks", $nni_remarks);
                $sql1->bindParam(":signed_notice_to_proceed", $signed_notice_to_proceed);

                // labor cost attachment
                    $attachments_arr = array();
                    if(isset($_FILES['attachment'])) {
                        $attachment_count = count($_FILES['attachment']);

                        // make directory if not existed
                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        // loop all attachment
                        for($i = 0; $i < $attachment_count; $i++) {

                            if(!empty($_FILES['attachment']['name'][$i])) {
                
                                $file = explode('.', $_FILES['attachment']['name'][$i]);
                                $file_name = $file[0];
                                $file_ext = $file[1];
                
                                $time = time();
                
                                $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
                
                                $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                                $file_size = $_FILES['attachment']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_tmp, $sys_upload_dir.'nni/'.$attachment_name);

                                $attachments_arr[] = $attachment_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_arr)) {
                        $attachment_name = implode(',', $attachments_arr);
                    } else {
                        $attachment_name = isset($data['labor_cost_breakdown']) ? $data['labor_cost_breakdown'] : '';
                    }

                    $sql1->bindParam(":labor_cost_attachment", $attachment_name);

                    if ($attachment_name != $data['labor_cost_breakdown']) {
                        $tmp = 'nni_labor_cost_breakdown::'.$data['labor_cost_breakdown'].'=='.$attachment_name;
                        array_push($change_logs, $tmp);
                    }

                // detailed scope attachment
                    $attachments2_arr = array();
                    if(isset($_FILES['attachment2'])) {
                        $attachment2_count = count($_FILES['attachment2']);

                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        for($i = 0; $i < $attachment2_count; $i++) {

                            if(!empty($_FILES['attachment2']['name'][$i])) {
                
                                $file2 = explode('.', $_FILES['attachment2']['name'][$i]);
                                $file2_name = $file2[0];
                                $file2_ext = $file2[1];
                
                                $time = time();
                
                                $attachment2_name = $file2_name.'-'.$time.'.'.$file2_ext;
                
                                $file2_tmp = $_FILES['attachment2']['tmp_name'][$i];
                                $file2_size = $_FILES['attachment2']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file2_tmp, $sys_upload_dir.'nni/'.$attachment2_name);

                                $attachments2_arr[] = $attachment2_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments2_arr)) {
                        $attachment2_name = implode(',', $attachments2_arr);
                    } else {
                        $attachment2_name = empty($data['detailed_scope_of_work']) ? '' : $data['detailed_scope_of_work'];
                    }

                    $sql1->bindParam(":detailed_scope_attachment", $attachment2_name);
                    
                    if ($attachment2_name != $data['detailed_scope_of_work']) {
                        $tmp = 'nni_detailed_scope_of_work::'.$data['detailed_scope_of_work'].'=='.$attachment2_name;
                        array_push($change_logs, $tmp);
                    }

                // NNI attachment
                    $attachments_nni_arr = array();
                    if(isset($_FILES['attachment_nni'])) {
                        $attachment_nni_count = count($_FILES['attachment_nni']);

                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        for($i = 0; $i < $attachment_nni_count; $i++) {

                            if(!empty($_FILES['attachment_nni']['name'][$i])) {
                
                                $file_nni = explode('.', $_FILES['attachment_nni']['name'][$i]);
                                $file_nni_name = $file_nni[0];
                                $file_nni_ext = $file_nni[1];
                
                                $time = time();
                
                                $attachment_nni_name = $file_nni_name.'-'.$time.'.'.$file_nni_ext;
                
                                $file_nni_tmp = $_FILES['attachment_nni']['tmp_name'][$i];
                                $file_nni_size = $_FILES['attachment_nni']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_nni_tmp, $sys_upload_dir.'nni/'.$attachment_nni_name);

                                $attachments_nni_arr[] = $attachment_nni_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_nni_arr)) {
                        $attachment_nni_name = implode(',', $attachments_nni_arr);
                    } else {
                        $attachment_nni_name = empty($data['nni_attachment']) ? '' : $data['nni_attachment'];
                    }

                    $sql1->bindParam(":nni_attachment", $attachment_nni_name);

                    if ($attachment_nni_name != $data['nni_attachment']) {
                        $tmp = 'nni_attachment::'.$data['nni_attachment'].'=='.$attachment_nni_name;
                        array_push($change_logs, $tmp);
                    }
                // 

                // NTP attachment
                    $attachments_ntp_arr = array();
                    if(isset($_FILES['attachment_ntp'])) {
                        $attachment_ntp_count = count($_FILES['attachment_ntp']);

                        if(!is_dir($sys_upload_dir.'ntp')) {
                            mkdir($sys_upload_dir.'ntp', 0755, true);
                        }

                        for($i = 0; $i < $attachment_ntp_count; $i++) {

                            if(!empty($_FILES['attachment_ntp']['name'][$i])) {
                
                                $file_ntp = explode('.', $_FILES['attachment_ntp']['name'][$i]);
                                $file_ntp_name = $file_ntp[0];
                                $file_ntp_ext = $file_ntp[1];
                
                                $time = time();
                
                                $attachment_ntp_name = $file_ntp_name.'-'.$time.'.'.$file_ntp_ext;
                
                                $file_ntp_tmp = $_FILES['attachment_ntp']['tmp_name'][$i];
                                $file_ntp_size = $_FILES['attachment_ntp']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_ntp_tmp, $sys_upload_dir.'ntp/'.$attachment_ntp_name);

                                $attachments_ntp_arr[] = $attachment_ntp_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_ntp_arr)) {
                        $attachment_ntp_name = implode(',', $attachments_ntp_arr);
                    } else {
                        $attachment_ntp_name = empty($data['ntp_attachment']) ? '' : $data['ntp_attachment'];
                    }

                    $sql1->bindParam(":ntp_attachment", $attachment_ntp_name);

                    if ($attachment_ntp_name != $data['ntp_attachment']) {
                        $tmp = 'notice_to_proceed::'.$data['ntp_attachment'].'=='.$attachment_ntp_name;
                        array_push($change_logs, $tmp);
                    }
                // 

                $sql1->execute();

            } else { // not existed insert

                $nni_action = 'add';

                $sql1 = $pdo->prepare("INSERT INTO nni (
                    prospect_id,
                    remarks,
                    labor_cost_breakdown,
                    detailed_scope_of_work,
                    nni_attachment,
                    ntp_attachment,
                    signed_notice_to_proceed,
                    status
                ) VALUES (
                    :nni_prospect_id,
                    :nni_remarks,
                    :labor_cost_attachment,
                    :detailed_scope_attachment,
                    :nni_attachment,
                    :ntp_attachment,
                    :signed_notice_to_proceed,
                    :status
                )");
                $sql1->bindParam(":status", $save_status);
                $sql1->bindParam(":nni_prospect_id", $prospect_id);
                $sql1->bindParam(":nni_remarks", $nni_remarks);
                $sql1->bindParam(":signed_notice_to_proceed", $signed_notice_to_proceed);
                
                // labor cost attachment
                    $attachments_arr = array();

                    if(isset($_FILES['attachment'])) {

                        $attachment_count = count($_FILES['attachment']);

                        // make directory if not existed
                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        // loop all attachment
                        for($i = 0; $i < $attachment_count; $i++) {

                            if(!empty($_FILES['attachment']['name'][$i])) {
                
                                $file = explode('.', $_FILES['attachment']['name'][$i]);
                                $file_name = $file[0];
                                $file_ext = $file[1];
                
                                $time = time();
                
                                $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
                
                                $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                                $file_size = $_FILES['attachment']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_tmp, $sys_upload_dir.'nni/'.$attachment_name);

                                $attachments_arr[] = $attachment_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_arr)) {
                        $attachment_name = implode(',', $attachments_arr);
                    } else {
                        $attachment_name = '';
                    }

                    $sql1->bindParam(":labor_cost_attachment", $attachment_name);

                // detailed scope attachment
                    $attachments2_arr = array();

                    if(isset($_FILES['attachment2'])) {
                        $attachment2_count = count($_FILES['attachment2']);

                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        for($i = 0; $i < $attachment2_count; $i++) {

                            if(!empty($_FILES['attachment2']['name'][$i])) {
                
                                $file2 = explode('.', $_FILES['attachment2']['name'][$i]);
                                $file2_name = $file2[0];
                                $file2_ext = $file2[1];
                
                                $time = time();
                
                                $attachment2_name = $file2_name.'-'.$time.'.'.$file2_ext;
                
                                $file2_tmp = $_FILES['attachment2']['tmp_name'][$i];
                                $file2_size = $_FILES['attachment2']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file2_tmp, $sys_upload_dir.'nni/'.$attachment2_name);

                                $attachments2_arr[] = $attachment2_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments2_arr)) {
                        $attachment2_name = implode(',', $attachments2_arr);
                    } else {
                        $attachment2_name = '';
                    }

                    $sql1->bindParam(":detailed_scope_attachment", $attachment2_name);

                // NNI attachment
                    $attachments_nni_arr = array();

                    if(isset($_FILES['attachment_nni'])) {
                        $attachment_nni_count = count($_FILES['attachment_nni']);

                        if(!is_dir($sys_upload_dir.'nni')) {
                            mkdir($sys_upload_dir.'nni', 0755, true);
                        }

                        for($i = 0; $i < $attachment_nni_count; $i++) {

                            if(!empty($_FILES['attachment_nni']['name'][$i])) {
                
                                $file_nni = explode('.', $_FILES['attachment_nni']['name'][$i]);
                                $file_nni_name = $file_nni[0];
                                $file_nni_ext = $file_nni[1];
                
                                $time = time();
                
                                $attachment_nni_name = $file_nni_name.'-'.$time.'.'.$file_nni_ext;
                
                                $file_nni_tmp = $_FILES['attachment_nni']['tmp_name'][$i];
                                $file_nni_size = $_FILES['attachment_nni']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_nni_tmp, $sys_upload_dir.'nni/'.$attachment_nni_name);

                                $attachments_nni_arr[] = $attachment_nni_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_nni_arr)) {
                        $attachment_nni_name = implode(',', $attachments_nni_arr);
                    } else {
                        $attachment_nni_name = '';
                    }

                    $sql1->bindParam(":nni_attachment", $attachment_nni_name);
                // 
                
                // ntp attachment
                    $attachments_ntp_arr = array();

                    if(isset($_FILES['attachment_ntp'])) {
                        $attachment_ntp_count = count($_FILES['attachment_ntp']);

                        if(!is_dir($sys_upload_dir.'ntp')) {
                            mkdir($sys_upload_dir.'ntp', 0755, true);
                        }

                        for($i = 0; $i < $attachment_ntp_count; $i++) {

                            if(!empty($_FILES['attachment_ntp']['name'][$i])) {
                
                                $file_ntp = explode('.', $_FILES['attachment_ntp']['name'][$i]);
                                $file_ntp_name = $file_ntp[0];
                                $file_ntp_ext = $file_ntp[1];
                
                                $time = time();
                
                                $attachment_ntp_name = $file_ntp_name.'-'.$time.'.'.$file_ntp_ext;
                
                                $file_ntp_tmp = $_FILES['attachment_ntp']['tmp_name'][$i];
                                $file_ntp_size = $_FILES['attachment_ntp']['size'][$i];
                                
                                // save file
                                move_uploaded_file($file_ntp_tmp, $sys_upload_dir.'ntp/'.$attachment_ntp_name);

                                $attachments_ntp_arr[] = $attachment_ntp_name;
                                
                            }

                        }
                    }

                    if(!empty($attachments_ntp_arr)) {
                        $attachment_ntp_name = implode(',', $attachments_ntp_arr);
                    } else {
                        $attachment_ntp_name = '';
                    }

                    $sql1->bindParam(":ntp_attachment", $attachment_ntp_name);
                // 

                $sql1->execute();

                $nni_id = $pdo->lastInsertId();

            }

            //EDIT PROSPECTING CONTACT
                // $sql = $pdo->prepare("UPDATE prospecting SET 
                //     contact_person = :prospecting_contact_person,
                //     mobile_number = :prospecting_mobile_number,
                //     designation = :prospecting_designation,
                //     email_address = :prospecting_email_address
                // WHERE id = :prospecting_id");
                // $sql->bindParam(':prospecting_id', $prospect_id);
                // $sql->bindParam(':prospecting_contact_person', $prospecting_contact_person);
                // $sql->bindParam(':prospecting_mobile_number', $prospecting_mobile_number);
                // $sql->bindParam(':prospecting_designation', $prospecting_designation);
                // $sql->bindParam(':prospecting_email_address', $prospecting_email_address);
                // $sql->execute();
            // 

            //INSERT PROSPECTING CONTACTS
                foreach($contact_code as $key => $code) {

                    // check if exist
                    $sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE code = :code");
                    $sql->bindParam(":code", $code);
                    $sql->execute();
                    if($sql->rowCount()) { // existed update

                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                        if ($nni_contact_person[$key] != $data['contact_person']) {
                            $tmp = 'nni_contact_person::'.$data['contact_person'].'=='.$nni_contact_person[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($nni_contact_number[$key] != $data['contact_number']) {
                            $tmp = 'nni_contact_number::'.$data['contact_number'].'=='.$nni_contact_number[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($nni_designation[$key] != $data['designation']) {
                            $tmp = 'nni_designation::'.$data['designation'].'=='.$nni_designation[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($nni_email_address[$key] != $data['email_address']) {
                            $tmp = 'nni_email_address::'.$data['email_address'].'=='.$nni_email_address[$key];
                            array_push($change_logs, $tmp);
                        }
                        if ($prospecting_office_address[$key] != $data['office_address']) {
                            $tmp = 'nni_office_address::'.$data['office_address'].'=='.$prospecting_office_address[$key];
                            array_push($change_logs, $tmp);
                        }

                        $sql1 = $pdo->prepare("UPDATE prospecting_contacts SET 
                            contact_person = :contact_person, 
                            contact_number = :designation, 
                            designation = :contact_number,
                            office_address = :office_address, 
                            email_address = :email_address
                        WHERE code = :code");

                        $sql1->bindParam(":code", $code);
                        $sql1->bindParam(":contact_person", $nni_contact_person[$key]);
                        $sql1->bindParam(":contact_number", $nni_contact_number[$key]);
                        $sql1->bindParam(":designation", $nni_designation[$key]);
                        $sql1->bindParam(":email_address", $nni_email_address[$key]);
                        $sql1->bindParam(":office_address",$prospecting_office_address);
                        $sql1->execute();

                    } else { // not existed insert

                        if (!empty($nni_contact_person[$key])) {

                            $sql1 = $pdo->prepare("INSERT INTO prospecting_contacts (
                                prospect_id,
                                contact_person,
                                designation,
                                contact_number,
                                email_address,
                                code,
                                office_address
                            ) VALUES (
                                :prospect_id,
                                :contact_person,
                                :designation,
                                :contact_number,
                                :email_address,
                                :code,
                                :office_address
                            )");
                            
                            $sql1->bindParam(":prospect_id",$prospect_id);
                            $sql1->bindParam(":office_address",$prospecting_office_address);
                            $sql1->bindParam(":contact_person", $nni_contact_person[$key]);
                            $sql1->bindParam(":contact_number", $nni_contact_number[$key]);
                            $sql1->bindParam(":designation", $nni_designation[$key]);
                            $sql1->bindParam(":email_address", $nni_email_address[$key]);
                            $sql1->bindParam(":code", $code);
                            $sql1->execute();
                        }

                    }

                }
            // 
      
            //  CONTRACT

                // check if contract already exist
                $sql = $pdo->prepare("SELECT * FROM contract WHERE prospect_id = :id ORDER BY id DESC LIMIT 1");
                $sql->bindParam(":id", $prospect_id);
                $sql->execute();
                if($sql->rowCount()) { // existed update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    if ($contact_person != $data['contract_contact_person']) {
                        $tmp = 'contracts_contact_person::'.$data['contract_contact_person'].'=='.$contact_person;
                        array_push($change_logs, $tmp);
                    }
                    if ($contact_number != $data['contact_number']) {
                        $tmp = 'contracts_contact_number::'.$data['contact_number'].'=='.$contact_number;
                        array_push($change_logs, $tmp);
                    }
                    if ($start_contract != $data['acquisition_date']) {
                        $tmp = 'nni_start_of_contract::'.$data['acquisition_date'].'=='.$start_contract;
                        array_push($change_logs, $tmp);
                    }
                    if ($end_contract != $data['renewal_date']) {
                        $tmp = 'nni_end_of_contract::'.$data['renewal_date'].'=='.$end_contract;
                        array_push($change_logs, $tmp);
                    }
                    if ($contract_duration != $data['contract_duration']) {
                        $tmp = 'nni_contract_duration::'.$data['contract_duration'].'=='.$contract_duration;
                        array_push($change_logs, $tmp);
                    }

                    $contract_id = $data['id'];

                    $sql1 = $pdo->prepare("UPDATE contract SET 
                        acquisition_date = :acquisition_date, 
                        renewal_date = :renewal_date, 
                        contract_contact_person = :contract_contact_person, 
                        contact_number = :contact_number,
                        contract_duration = :contract_duration
                    WHERE id = :id");
                    $sql1->bindParam(":id", $contract_id);
                    $sql1->bindParam(":contract_contact_person", $contact_person);
                    $sql1->bindParam(":contact_number", $contact_number);
                    $sql1->bindParam(":acquisition_date", $start_contract);
                    $sql1->bindParam(":renewal_date", $end_contract);
                    $sql1->bindParam(":contract_duration", $contract_duration);
                    $sql1->execute();

                } else { // not existed insert

                    $sql1 = $pdo->prepare("INSERT INTO contract (
                        prospect_id,
                        contract_contact_person,
                        contact_number,
                        acquisition_date,
                        renewal_date,
                        contract_duration
                    ) VALUES (
                        :c_prospect_id,
                        :contract_contact_person,
                        :contact_number,
                        :acquisition_date,
                        :renewal_date,
                        :contract_duration
                    )");
                    $sql1->bindParam(":c_prospect_id", $prospect_id);
                    $sql1->bindParam(":contract_contact_person", $contact_person);
                    $sql1->bindParam(":contact_number", $contact_number);
                    $sql1->bindParam(":acquisition_date", $start_contract);
                    $sql1->bindParam(":renewal_date", $end_contract);
                    $sql1->bindParam(":contract_duration", $contract_duration);
                    $sql1->execute();
    
                    $contract_id = $pdo->lastInsertId();
                }
            // 

            // HR permission
                if (checkPermission('hr-informations')) {

                    foreach($nni_hr_id as $key => $hr_id) {

                        // check if existed
                        $sql = $pdo->prepare("SELECT * FROM nni_hr WHERE id = :hr_id");
                        $sql->bindParam(":hr_id", $hr_id);
                        $sql->execute();
                        if($sql->rowCount()) { // existed update

                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                            
                            if ($manpower_plantilla[$key] != $data['manpower_plantilla']) {
                                $tmp = 'nni_manpower_plantilla::'.$data['manpower_plantilla'].'=='.$manpower_plantilla[$key];
                                array_push($change_logs, $tmp);
                            }
                            if ($budget_base_pay[$key] != $data['budget_base_pay']) {
                                $tmp = 'nni_base_pay::'.$data['budget_base_pay'].'=='.$budget_base_pay[$key];
                                array_push($change_logs, $tmp);
                            }
                            if ($budget_allowance[$key] != $data['budget_allowance']) {
                                $tmp = 'nni_allowance::'.$data['budget_allowance'].'=='.$budget_allowance[$key];
                                array_push($change_logs, $tmp);
                            }

                            $sql1 = $pdo->prepare("UPDATE nni_hr SET 
                                manpower_plantilla = :manpower_plantilla,
                                budget_base_pay = :budget_base_pay, 
                                budget_allowance = :budget_allowance,
                                total_compensation = :compensation,
                                total_gmb = :gmb,
                                total_cib = :cib,
                                total_lc = :lc_total,
                                deployment_date = :deployment_date, 
                                special_qualification = :special_qualification,
                                name = :name,
                                remarks = :hr_remarks,
                                origin = :origin
                            WHERE id = :hr_id");
                            $sql1->bindParam(":hr_id",$hr_id);
                            $sql1->bindParam(":manpower_plantilla", $manpower_plantilla[$key]);
                            $sql1->bindParam(":budget_base_pay", $budget_base_pay[$key]);
                            $sql1->bindParam(":budget_allowance", $budget_allowance[$key]);
                            $sql1->bindParam(":compensation", $compensation[$key]);
                            $sql1->bindParam(":gmb", $gmb[$key]);
                            $sql1->bindParam(":cib", $cib[$key]);
                            $sql1->bindParam(":lc_total", $lc_total[$key]);
                            $sql1->bindParam(":deployment_date", $deployment_date[$key]);
                            $sql1->bindParam(":special_qualification", $special_qualification[$key]);
                            $sql1->bindParam(":name", $prf_name[$key]);
                            $sql1->bindParam(":hr_remarks", $hr_remarks[$key]);
                            $sql1->bindParam(":origin", $origin[$key]);
                            $sql1->execute();

                        } else { // not existed insert

                            //INSERT NNI HR INFORMATION
                            $sql1 = $pdo->prepare("INSERT INTO nni_hr (
                                nni_id,
                                manpower_plantilla,
                                budget_base_pay,
                                budget_allowance,
                                total_compensation,
                                total_gmb,
                                total_cib,
                                total_lc,
                                deployment_date,
                                special_qualification,
                                name,
                                remarks,
                                origin
                            ) VALUES (
                                :nni_id,
                                :manpower_plantilla,
                                :budget_base_pay,
                                :budget_allowance,
                                :compensation,
                                :gmb,
                                :cib,
                                :lc_total,
                                :deployment_date,
                                :special_qualification,
                                :name,
                                :hr_remarks,
                                :origin
                            )");

                            $sql1->bindParam(":nni_id",$nni_id);
                            if(!empty($manpower_plantilla[$key])) {

                                $sql1->bindParam(":manpower_plantilla", $manpower_plantilla[$key]);
                                $sql1->bindParam(":budget_base_pay", $budget_base_pay[$key]);
                                $sql1->bindParam(":budget_allowance", $budget_allowance[$key]);
                                $sql1->bindParam(":compensation", $compensation[$key]);
                                $sql1->bindParam(":gmb", $gmb[$key]);
                                $sql1->bindParam(":cib", $cib[$key]);
                                $sql1->bindParam(":lc_total", $lc_total[$key]);
                                $sql1->bindParam(":deployment_date", $deployment_date[$key]);
                                $sql1->bindParam(":special_qualification", $special_qualification[$key]);
                                $sql1->bindParam(":name", $prf_name[$key]);
                                $sql1->bindParam(":hr_remarks", $hr_remarks[$key]);
                                $sql1->bindParam(":origin", $origin[$key]);
                                $sql1->execute();
                            }

                            $hr_id = $pdo->lastInsertId();

                        }

                    }

                    // check if existed
                    $sql = $pdo->prepare("SELECT * FROM prf WHERE prospect_id = :prospect_id AND temp_del = 0 LIMIT 1");
                    $sql->bindParam(":prospect_id", $prospect_id);
                    $sql->execute();
                    $prf_id = 0;
                    if($sql->rowCount()) { // update

                        $data = $sql->fetch(PDO::FETCH_ASSOC);
                        $prf_id = $data['id'];

                        $sql1 = $pdo->prepare("UPDATE prf SET prospect_id = :prospect_id WHERE id = :id");
                        $sql1->bindParam(":id", $prf_id);
                        $sql1->bindParam(":prospect_id", $prospect_id);
                        $sql1->execute();

                        foreach($nni_hr_id as $key => $hr_id) {
                            $code = $prospect_id.$prf_id.$key;

                            $sql1 = $pdo->prepare("SELECT * FROM prf_departments WHERE code = :code LIMIT 1");
                            $sql1->bindParam(":code", $code);
                            $sql1->execute();
                            if($sql1->rowCount()) { // update

                                $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                              
                                $sql2 = $pdo->prepare("UPDATE prf_departments SET 
                                    job_title = :job_title, 
                                    number_of_staff = :number_of_staff,
                                    status = :status,
                                    name = :name
                                WHERE id = :id");
                                if(!empty($manpower_plantilla[$key]) && !empty($head_count[$key])) {

                                    $sql2->bindParam(":id", $data1['id']);
                                    $sql2->bindParam(":job_title", $manpower_plantilla[$key]);
                                    $sql2->bindParam(":number_of_staff", $head_count[$key]);
                                    $sql2->bindParam(":status", $hr_remarks[$key]);
                                    $sql2->bindParam(":name", $prf_name[$key]);
                                    $sql2->execute();
                                }

                            } else { // insert

                                $sql2 = $pdo->prepare("INSERT INTO prf_departments (
                                    prf_id,
                                    job_title,
                                    number_of_staff,
                                    code,
                                    status,
                                    name
                                ) VALUES (
                                    :prf_id,
                                    :job_title,
                                    :number_of_staff,
                                    :code,
                                    :status,
                                    :name
                                )");
                                if(!empty($manpower_plantilla[$key]) && !empty($head_count[$key])) {
                                    $sql2->bindParam(":prf_id", $prf_id);
                                    $sql2->bindParam(":job_title", $manpower_plantilla[$key]);
                                    $sql2->bindParam(":number_of_staff", $head_count[$key]);
                                    $sql2->bindParam(":code", $code);
                                    $sql2->bindParam(":status", $hr_remarks[$key]);
                                    $sql2->bindParam(":name", $prf_name[$key]);
                                    $sql2->execute();
                                }

                            }

                        }

                    } else { // insert

                        // INSERT PRF
                        $sql1 = $pdo->prepare("INSERT INTO prf (
                            prospect_id
                        ) VALUES (
                            :prf_prospect_id
                        )");

                        $sql1->bindParam(":prf_prospect_id", $prospect_id);
                        $sql1->execute();

                        $prf_id = $pdo->lastInsertId();

                        $sql1 = $pdo->prepare("INSERT INTO prf_departments (
                            prf_id,
                            job_title,
                            number_of_staff,
                            code
                        ) VALUES (
                            :prf_id,
                            :job_title,
                            :number_of_staff,
                            :code
                        )");
                        $sql1->bindParam(":prf_id", $prf_id);
                        foreach($nni_hr_id as $key => $hr_id) {
                            if(!empty($manpower_plantilla[$key]) || !empty($head_count[$key])) {
                                $code = $prospect_id.$prf_id.$key;
                                $sql1->bindParam(":job_title", $manpower_plantilla[$key]);
                                $sql1->bindParam(":number_of_staff", $head_count[$key]);
                                $sql1->bindParam(":code", $code);
                                $sql1->execute();
                            }
                        }
                    }
                    
                }// HR permission
            // 

            // CAD permission
                if (checkPermission('cad-informations')) {

                    foreach($nni_cad_id as $key => $cad_id) {

                        // check if existed
                        $sql = $pdo->prepare("SELECT * FROM nni_cad WHERE id = :nni_id LIMIT 1");
                        $sql->bindParam(":nni_id", $cad_id);
                        $sql->execute();
                        if($sql->rowCount()) { // existed update
                            
                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                            $sql1 = $pdo->prepare("UPDATE nni_cad SET 
                                property_administration = :property_administration,
                                revenue_allocation = :revenue,
                                terms = :terms,
                                revenue_amount = :revenue_amount,
                                term_option = :term_option
                            WHERE id = :cad_id");
                            $sql1->bindParam(":cad_id", $cad_id);
                            $sql1->bindParam(":property_administration", $property_administration[$key]);
                            $sql1->bindParam(":terms", $terms[$key]);
                            $sql1->bindParam(":revenue", $revenue[$key]);
                            $sql1->bindParam(":revenue_amount", $revenue_amount[$key]);
                            $sql1->bindParam(":term_option", $term_option[$key]);
                            $sql1->execute();


                        } else { // not existed insert

                            //INSERT NNI CAD INFORMATION
                            $sql1 = $pdo->prepare("INSERT INTO nni_cad (
                                nni_id,
                                property_administration,
                                revenue_allocation,
                                terms,
                                revenue_amount,
                                term_option
                            ) VALUES (
                                :nni_cad_id,
                                :property_administration,
                                :revenue,
                                :terms,
                                :revenue_amount,
                                :term_option
                            )");

                            if(!in_array($revenue[$key], $inclusions_arr)) {

                                $sql1->bindParam(":nni_cad_id",$nni_id);
                                if(!strlen($revenue[$key]) == 0) {
                            
                                    $sql1->bindParam(":property_administration", $property_administration[$key]);
                                    $sql1->bindParam(":terms", $terms[$key]);
                                    $sql1->bindParam(":revenue", $revenue[$key]);
                                    $sql1->bindParam(":revenue_amount", $revenue_amount[$key]);
                                    $sql1->bindParam(":term_option", $term_option[$key]);
                                    $sql1->execute();
                                }
                                $cad_id = $pdo->lastInsertId();

                            }
                        }
                    }
                    
                    // check if existed
                    $sql = $pdo->prepare("SELECT * FROM nni_cad_tab WHERE nni_id = :nni_id");
                    $sql->bindParam(":nni_id", $nni_id);
                    $sql->execute();
                    if($sql->rowCount()) {

                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE nni_cad_tab SET 
                            labor_cost = :labor_cost,
                            vat = :vat,
                            labor_cost_outsource = :labor_cost_outsource
                        WHERE id = :id");
                        $sql1->bindParam(":labor_cost", $labor_cost);
                        $sql1->bindParam(":vat", $vat_status);
                        $sql1->bindParam(":labor_cost_outsource", $labor_cost_outsource);
                        $sql1->bindParam(':id', $data['id']);
                        $sql1->execute();

                    } else {

                        $sql1 = $pdo->prepare("INSERT INTO nni_cad_tab (
                            nni_id, 
                            labor_cost,
                            vat,
                            labor_cost_outsource
                        ) VALUES (
                            :nni_id, 
                            :labor_cost,
                            :vat,
                            :labor_cost_outsource
                        )");
                        $sql1->bindParam(":nni_id", $nni_id);
                        $sql1->bindParam(":labor_cost", $labor_cost);
                        $sql1->bindParam(":vat", $vat_status);
                        $sql1->bindParam(":labor_cost_outsource", $labor_cost_outsource);
                        $sql1->execute();

                    }

                }// CAD permission
            // 

            // IT permission
                if (checkPermission('it-informations')) {

                    // IT
                        // check if already exist
                        $nni_it_id = 0;
                        $sql = $pdo->prepare("SELECT * FROM nni_it WHERE nni_id = :nni_id");
                        $sql->bindParam(":nni_id", $nni_id);
                        $sql->execute();
                        if($sql->rowCount()) { // exist update

                            $data = $sql->fetch(PDO::FETCH_ASSOC);

                            $nni_it_id = $data['id'];

                            $sql1 = $pdo->prepare("UPDATE nni_it SET 
                                server_access = :server_access
                            WHERE id = :id");
                            $sql1->bindParam(":id", $nni_it_id);
                            $sql1->bindParam(":server_access", $server_access);
                            $sql1->execute();

                        } else { // do not exist insert

                            //INSERT NNI IT INFORMATION
                            $sql1 = $pdo->prepare("INSERT INTO nni_it (
                                nni_id,
                                server_access
                            ) VALUES (
                                :nni_id,
                                :server_access
                            )");
                            $sql1->bindParam(":nni_id", $nni_id);
                            $sql1->bindParam(":server_access", $server_access);
                            $sql1->execute();

                            $nni_it_id = $pdo->lastInsertId();
                        }
                    // 

                    // IT STAFFS
                        foreach($it_staff_id as $key => $staff_id) {

                            // check if exist
                            $sql = $pdo->prepare("SELECT * FROM nni_it_staffs WHERE id = :id");
                            $sql->bindParam(":id", $staff_id);
                            $sql->execute();
                            if($sql->rowCount()) { // existed update
                                
                                $data = $sql->fetch(PDO::FETCH_ASSOC);

                                $sql1 = $pdo->prepare("UPDATE nni_it_staffs SET 
                                    position = :it_position, 
                                    name = :it_name,
                                    email_address = :it_email,
                                    server_access = :server_access
                                WHERE id = :id");

                                $server_access = implode(',',array($webpage_access[$key],$my_fpd[$key],$fpd_nexus[$key],$acumatica[$key]));

                                $sql1->bindParam(":id", $staff_id);
                                $sql1->bindParam(":it_name", $it_name[$key]);
                                $sql1->bindParam(":it_position", $it_position[$key]);
                                $sql1->bindParam(":it_email", $it_email[$key]);
                                $sql1->bindParam(":server_access", $server_access);
                                $sql1->execute();

                            } else { // did not exist insert

                                //INSERT NNI IT STAFFS
                                $sql1 = $pdo->prepare("INSERT INTO nni_it_staffs (
                                    nni_it_id,
                                    name,
                                    position,
                                    email_address,
                                    server_access
                                ) VALUES (
                                    :nni_it_id,
                                    :it_name,
                                    :it_position,
                                    :it_email,
                                    :server_access
                                )");


                                if(!empty($it_position[$key]) && !empty($it_name[$key])) {

                                $server_access = implode(',',array($webpage_access[$key],$my_fpd[$key],$fpd_nexus[$key],$acumatica[$key]));
                                    $sql1->bindParam(":nni_it_id", $nni_it_id);
                                    $sql1->bindParam(":it_name", $it_name[$key]);
                                    $sql1->bindParam(":it_position", $it_position[$key]);
                                    $sql1->bindParam(":it_email", $it_email[$key]);
                                    $sql1->bindParam(":server_access", $server_access);
                                    $sql1->execute();
                                }
                               
                            }

                        }
                        
                    // 

                }// IT permission
            // 
          
            // INSERT TO DOWNPAYMENTS

                // check if existing
                $sql = $pdo->prepare("SELECT * FROM downpayments WHERE prospect_id = :prospect_id AND temp_del = 0");
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->execute();
                if($sql->rowCount()) {  // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    $dp_id = $data['id'];

                    $sql1 = $pdo->prepare("UPDATE downpayments SET 
                        amount = :amount,
                        date = :dp_date,
                        or_num = :or_num
                    WHERE id = :id");
                    $sql1->bindParam(":id", $dp_id);
                    $sql1->bindParam(":amount", $amount);
                    $sql1->bindParam(":dp_date", $dp_date);
                    $sql1->bindParam(":or_num", $or_num);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO downpayments (
                        prospect_id,
                        amount,
                        date,
                        or_num
                    ) VALUES (
                        :prospect_id,
                        :amount,
                        :dp_date,
                        :or_num
                    )");
                    $sql1->bindParam(":prospect_id", $prospect_id);
                    $sql1->bindParam(":amount", $amount);
                    $sql1->bindParam(":dp_date", $dp_date);
                    $sql1->bindParam(":or_num", $or_num);
                    $sql1->execute();

                    $downpayment_id = $pdo->lastInsertId();

                }

            // 

            // record to system log
            $change_log = implode(';;', $change_logs);
            systemLog('nni',$nni_id,$nni_action,$change_log);

            // notifications NNI
            $employees = getTable('employees');
            $users = getTable('users');
            foreach ($employees as $employee) {
                push_notification('nni', $nni_id, $employee['id'], 'employee', 'nni');          
            }
            foreach ($users as $user) {
                push_notification('nni', $nni_id, $user['id'], 'user', 'nni');          
            }

            $_SESSION['sys_nni_add_suc'] = renderLang($nni_created);
            header('location: /notice-of-new-instructions');
            
        } else { // error found
            
            $_SESSION['sys_notice_to_proceed_add_err'] = renderLang($form_error);
            header('location: /edit-nni/'.$prospect_id);
            
        }
        
    } else { // permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');

    }
} else { // no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>