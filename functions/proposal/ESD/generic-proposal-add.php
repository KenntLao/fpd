<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-esd-add')) {

        $err = 0;

        // generic esd proposal
            $prospect_id = '';
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                } else {
                    $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
                    $sql->bindParam(":id", $prospect_id);
                    $sql->execute();
                    if($sql->rowCount()) {
                        $_data = $sql->fetch(PDO::FETCH_ASSOC);
                    } else {
                        $err++;
                    }
                }
            }

            $status = 0;
            if(isset($_POST['status'])) {
                $status = trim($_POST['status']);
            }

            $reference_number = '';
            if(isset($_POST['reference_number'])){
                $reference_number = trim($_POST['reference_number']);
                if(strlen($reference_number) == 0) {
                    $err++;
                }
            }

            $date = '';
            if(isset($_POST['date'])) {
                $date = trim($_POST['date']);
            }

            $salutation = '';
            if(isset($_POST['salutation'])) {
                $salutation = trim($_POST['salutation']);
            }

            $client = '';
            if(isset($_POST['client'])) {
                $client = trim($_POST['client']);
            }

            $letter_subject = '';
            if(isset($_POST['letter_subject'])) {
                $letter_subject = trim($_POST['letter_subject']);
            }

            $works = '';
            if(isset($_POST['works'])) {
                $works = trim($_POST['works']);
            }

            $company = $_data['contact_person'];
            if(isset($_POST['company'])) {
                $company = trim($_POST['company']);
            }

            $address_line1 = '';
            if(isset($_POST['address_line1'])) {
                $address_line1 = trim($_POST['address_line1']);
            }

            $address_line2 = '';
            if(isset($_POST['address_line2'])) {
                $address_line2 = trim($_POST['address_line2']);
            }

            $address = implode(',', array($address_line1, $address_line2));

            $service_name = '';
            if(isset($_POST['service_name'])) {
                $service_name = trim($_POST['service_name']);
            }
            
            $other_service = '';
            if(isset($_POST['other_service'])) {
                $other_service = trim($_POST['other_service']);
            }

            $short_location = '';
            if(isset($_POST['short_location'])) {
                $short_location = trim($_POST['short_location']);
            }

            $payment_terms = '';
            if(isset($_POST['payment_terms'])) {
                $payment_terms = trim($_POST['payment_terms']);
            }

            $validity_period = '';
            if(isset($_POST['validity_period'])) {
                $validity_period = trim($_POST['validity_period']);
            }

            $waranty_period = '';
            if(isset($_POST['waranty_period'])) {
                $waranty_period = trim($_POST['waranty_period']);
            }

            // signatory
            $created_by_position = '';
            if(isset($_POST['signatoryPosition'])) {
                $created_by_position = trim($_POST['signatoryPosition']);
            }

            $noted_by = '';
            if(isset($_POST['noterSignatoryName'])) {
                $noted_by = trim($_POST['noterSignatoryName']);
            }

            $noted_by_position = '';
            if(isset($_POST['noterSignatoryPosition'])) {
                $noted_by_position = trim($_POST['noterSignatoryPosition']);
            }

            $noted_by_department = '';
            if(isset($_POST['noterSignatoryDepartment'])) {
                $noted_by_department = trim($_POST['noterSignatoryDepartment']);
            }

            $conforme = '';
            if(isset($_POST['conforme'])) {
                $conforme = trim($_POST['conforme']);
            }

            $conforme_contact = '';
            if(isset($_POST['conforme_contact'])) {
                $conforme_contact = trim($_POST['conforme_contact']);
            }
            // 
        // 

        // generic esd proposal items
            $item_code = array();
            if(isset($_POST['item_code'])) {
                $item_code = $_POST['item_code'];
            }    

            $item_name = array();
            if(isset($_POST['item_name'])) {
                $item_name = $_POST['item_name'];
            }

            $has_costing = array();
            if(isset($_POST['hasCosting'])) {
                $has_costing = $_POST['hasCosting'];
            }
        // 

        // generic esd proposal materials
            $material_code = array();
            if(isset($_POST['material_code'])) {
                $material_code = $_POST['material_code'];
            }

            $material_name = array();
            if(isset($_POST['material_name'])) {
                $material_name = $_POST['material_name'];
            }
        // 

        // generic esd proposal labor cost
            $labor_cost_code = array();
            if(isset($_POST['labor_cost_code'])) {
                $labor_cost_code = $_POST['labor_cost_code'];
            }
            
            $option_code = array();
            if(isset($_POST['option_code'])) {
                $option_code = $_POST['option_code'];
            }
        
            $labor_cost = array();
            if(isset($_POST['labor_cost'])) {
                $labor_cost = $_POST['labor_cost'];
            }

            $vat = array();
            if(isset($_POST['vat'])) {
                $vat = $_POST['vat'];
            }

            $lc_other = array();
            if(isset($_POST['lc_other'])) {
                $lc_other = $_POST['lc_other'];
            }

            $total = array();
            if(isset($_POST['total'])) {
                $total = $_POST['total'];
            }
        // 

        // generic esd proposal options
            $options_code = array();
            if(isset($_POST['options_code'])) {
                $options_code = $_POST['options_code'];
            }
            
            $description = array();
            if(isset($_POST['description'])) {
                $description = $_POST['description'];
            }

            $location = array();
            if(isset($_POST['location'])) {
                $location = $_POST['location'];
            }

            // Materials
            $quantity = array();
            if(isset($_POST['quantity'])) {
                $quantity = $_POST['quantity'];
            }

            $unit = array();
            if(isset($_POST['unit'])) {
                $unit = $_POST['unit'];
            }

            $unit_price = array();
            if(isset($_POST['unit_price'])) {
                $unit_price = $_POST['unit_price'];
            }

            $total_price = array();
            if(isset($_POST['total_price'])) {
                $total_price = $_POST['total_price'];
            }

            // LC
            $lc_quantity = array();
            if(isset($_POST['lc_quantity'])) {
                $lc_quantity = $_POST['lc_quantity'];
            }

            $lc_unit = array();
            if(isset($_POST['lc_unit'])) {
                $lc_unit = $_POST['lc_unit'];
            }

            $lc_unit_cost = array();
            if(isset($_POST['lc_unit_cost'])) {
                $lc_unit_cost = $_POST['lc_unit_cost'];
            }
            
            $lc_total_amount = array();
            if(isset($_POST['lc_total_amount'])) {
                $lc_total_amount = $_POST['lc_total_amount'];
            }

            $sub_total = array();
            if(isset($_POST['sub_total'])) {
                $sub_total = $_POST['sub_total'];
            }
        // 

        // user
        $user_id = $_SESSION['sys_id'];
        $account_mode = $_SESSION['sys_account_mode'];

        // check for errors
        if($err == 0) {

            // insert to proposal_esd_generic
                $sql = $pdo->prepare("INSERT INTO proposal_esd_generic (
                    prospect_id,
                    reference_number, 
                    salutation, 
                    client,
                    date, 
                    letter_subject, 
                    company, 
                    service_name,
                    other_service,
                    works,
                    payment_terms, 
                    warranty_period, 
                    address, 
                    short_location,
                    proposal_validity, 
                    created_by, 
                    account_mode,
                    position,
                    status
                ) VALUES (
                    :prospect_id,
                    :reference_number, 
                    :salutation, 
                    :client,
                    :date, 
                    :letter_subject, 
                    :company, 
                    :service_name,
                    :other_service,
                    :works,
                    :payment_terms, 
                    :warranty_period, 
                    :address, 
                    :short_location, 
                    :proposal_validity, 
                    :created_by, 
                    :account_mode,
                    :position,
                    :status
                )");
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->bindParam(":reference_number", $reference_number);
                $sql->bindParam(":salutation", $salutation);
                $sql->bindParam(":client", $client);
                $sql->bindParam(":date", $date);
                $sql->bindParam(":letter_subject", $letter_subject);
                $sql->bindParam(":company", $company);
                $sql->bindParam(":service_name", $service_name);
                $sql->bindParam(":other_service", $other_service);
                $sql->bindParam(":works", $works);
                $sql->bindParam(":payment_terms", $payment_terms);
                $sql->bindParam(":warranty_period", $waranty_period);
                $sql->bindParam(":address", $address);
                $sql->bindParam(":short_location", $short_location);
                $sql->bindParam(":proposal_validity", $validity_period);
                $sql->bindParam(":created_by", $user_id);
                $sql->bindParam(":account_mode", $account_mode);
                $sql->bindParam(":position", $created_by_position);
                $sql->bindParam(":status", $status);
                $sql->execute();
                
                $proposal_esd_generic_id = $pdo->lastInsertId();
            // 

            // insert into proposal_esd_generic_signatory
                $sql = $pdo->prepare("INSERT INTO proposal_esd_generic_signatory (
                    proposal_esd_generic_id, 
                    noted_by, 
                    position, 
                    department, 
                    conforme_name, 
                    conforme_contact
                ) VALUES (
                    :proposal_esd_generic_id, 
                    :noted_by, 
                    :position, 
                    :department, 
                    :conforme_name, 
                    :conforme_contact
                )");
                $sql->bindParam(":proposal_esd_generic_id", $proposal_esd_generic_id);
                $sql->bindParam(":noted_by", $noted_by);
                $sql->bindParam(":position", $noted_by_position);
                $sql->bindParam(":department", $noted_by_department);
                $sql->bindParam(":conforme_name", $conforme);
                $sql->bindParam(":conforme_contact", $conforme_contact);
                $sql->execute();
            // 

            // insert to proposal_esd_generic_items
                $sql = $pdo->prepare("INSERT INTO proposal_esd_generic_items (
                    proposal_esd_generic_id, 
                    item_name,
                    item_code,
                    has_costing
                ) VALUES (
                    :proposal_esd_generic_id, 
                    :item_name,
                    :item_code,
                    :has_costing
                )");
                $sql->bindParam(":proposal_esd_generic_id", $proposal_esd_generic_id);
                foreach($item_name as $key => $item) {
                    $sql->bindParam(":item_code", $item_code[$key]);
                    $sql->bindParam(":item_name", $item);
                    $sql->bindParam(":has_costing", $has_costing[$key]);
                    $sql->execute();

                    $esd_generic_item_id = $pdo->lastInsertId();

                    // insert into pproposal_esd_generic_scope_of_works
                        $sql1 = $pdo->prepare("INSERT INTO proposal_esd_generic_scope_of_works (
                            esd_generic_item_id, 
                            material_name, 
                            material_code
                        ) VALUES (
                            :esd_generic_item_id, 
                            :material_name, 
                            :material_code
                        )");
                        $sql1->bindParam(":esd_generic_item_id", $esd_generic_item_id);
                        foreach($material_name as $material_key => $material) {
                            if($item_code[$key] == $material_code[$material_key]) {
                                $sql1->bindParam(":material_name", $material_name[$material_key]);
                                $sql1->bindParam(":material_code", $material_code[$material_key]);
                                $sql1->execute();
                            }
                        }
                    // 

                    // insert into proposal_esd_generic_labor_cost
                    $sql1 = $pdo->prepare("INSERT INTO proposal_esd_generic_labor_cost (
                        esd_generic_item_id, 
                        labor_cost, 
                        vat,
                        other,
                        total,
                        labor_cost_code,
                        option_code
                    ) VALUES (
                        :esd_generic_item_id, 
                        :labor_cost, 
                        :vat,
                        :other,
                        :total,
                        :labor_cost_code,
                        :option_code
                    )");
                    $sql1->bindParam(":esd_generic_item_id", $esd_generic_item_id);
                    foreach($labor_cost_code as $lc_key => $lc_code) {
                        if($lc_code == $item_code[$key]) {
                            $sql1->bindParam(":labor_cost", $labor_cost[$lc_key]);
                            $sql1->bindParam(":vat", $vat[$lc_key]);
                            $sql1->bindParam(":other", $lc_other[$lc_key]);
                            $sql1->bindParam(":total", $total[$lc_key]);
                            $sql1->bindParam(":labor_cost_code", $lc_code);
                            $sql1->bindParam(":option_code", $option_code[$lc_key]);
                            $sql1->execute();

                            $esd_generic_labor_cost_id = $pdo->lastInsertId();

                            // insert into proposal_esd_generic_options
                            $sql2 = $pdo->prepare("INSERT INTO proposal_esd_generic_options (
                                esd_generic_labor_cost_id, 
                                quantity, 
                                unit,
                                description, 
                                location, 
                                unit_price, 
                                total_price,
                                options_code,
                                lc_quantity, 
                                lc_unit, 
                                lc_unit_cost, 
                                lc_total, 
                                sub_total
                            ) VALUES (
                                :esd_generic_labor_cost_id, 
                                :quantity, 
                                :unit, 
                                :description, 
                                :location, 
                                :unit_price, 
                                :total_price,
                                :options_code,
                                :lc_quantity,
                                :lc_unit,
                                :lc_unit_cost,
                                :lc_total,
                                :sub_total
                            )");
                            $sql2->bindParam(":esd_generic_labor_cost_id", $esd_generic_labor_cost_id);
                            foreach($options_code as $option_key => $opt_code) {
                                if($opt_code == $option_code[$lc_key]) {
                                    $qty = 0;
                                    if(checkVar($quantity[$option_key])) {
                                        $qty = $quantity[$option_key];
                                    }

                                    $lc_qty = 0;
                                    if(checkVar($lc_quantity[$option_key])) {
                                        $lc_qty = $lc_quantity[$option_key];
                                    }

                                    $sql2->bindParam(":quantity", $qty);
                                    $sql2->bindParam(":unit", $unit[$option_key]);
                                    $sql2->bindParam(":description", $description[$option_key]);
                                    $sql2->bindParam(":location", $location[$option_key]);
                                    $sql2->bindParam(":unit_price", $unit_price[$option_key]);
                                    $sql2->bindParam(":total_price", $total_price[$option_key]);
                                    $sql2->bindParam(":options_code", $opt_code);
                                    $sql2->bindParam(":lc_quantity", $lc_qty);
                                    $sql2->bindParam(":lc_unit", $lc_unit[$option_key]);
                                    $sql2->bindParam(":lc_unit_cost", $lc_unit_cost[$option_key]);
                                    $sql2->bindParam(":lc_total", $lc_total_amount[$option_key]);
                                    $sql2->bindParam(":sub_total", $sub_total[$option_key]);
                                    $sql2->execute();
                                }
                            }
                        }
                    }

                }
            // 

            $_SESSION['sys_generic_proposal_esd_add_suc'] = renderLang($generic_proposal_esd_added);
            header('location: /esd-generic-list');

        } else {

            $_SESSION['sys_generic_proposal_esd_add_err'] = renderLang($form_error);
            header('location: /esd-generic-add');

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